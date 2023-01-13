<?php

namespace api\modules\v4\controllers;

use common\models\AssignedDeals;
use common\models\ClaimedDeals;
use common\models\UnclaimedOrganizations;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use common\models\Utilities;
use yii\db\Expression;

class DealsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'detail' => ['POST', 'OPTIONS'],
                'claim' => ['POST', 'OPTIONS'],
                'get-claimed' => ['POST', 'OPTIONS']
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionDetail()
    {
        $params = Yii::$app->request->post();

        if (empty($params)) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        $org_deals = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'a.facebook_username', 'a.twitter_username', 'a.linkedin_username', 'a.instagram_username', 'a.description',
                'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',])
            ->joinWith(['unclaimOrganizationImages b' => function ($b) {
                $b->select(['b.image_enc_id', 'b.unclaim_organization_enc_id', 'b.title', 'b.alt',
                    'CASE WHEN b.image IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->image) . '",b.image_location, "/", b.image) ELSE NULL END image'
                ]);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->joinWith(['assignedDeals c' => function ($c) {
                $c->select(['c.deal_enc_id', 'c.organization_enc_id', 'c.deal_type', 'c.coupon_type', 'c.coupon_code', 'c.slug', 'c.name', 'c.title',
                    'c.type', 'c.discount_type', 'c.expiry_date', 'c.is_popular', 'c.how_to_apply', 'c.terms_and_conditions', 'c.value', new Expression('NULL as is_claimed')
                ]);
                $c->joinWith(['assignedDealsLocations c1' => function ($c1) {
                    $c1->select(['c1.assign_deal_enc_id', 'c1.deal_enc_id', 'c1.location_enc_id', 'c2.latitude', 'c2.longitude',
                        'c2.city_enc_id', 'c2.postal_code', 'c2.address', 'c3.name city', 'c4.name state']);
                    $c1->joinWith(['locationEnc c2' => function ($c) {
                        $c->joinWith(['cityEnc c3' => function ($d) {
                            $d->joinWith(['stateEnc c4']);
                        }], false);
                    }], false);
                    $c1->onCondition(['c1.is_deleted' => 0]);
                }]);
                $c->onCondition(['c.is_deleted' => 0, 'c.status' => 'Active']);
                $c->groupBy(['c.deal_enc_id']);
            }])
            ->joinWith(['unclaimOrganizationLocations d' => function ($d) {
                $d->select(['d.location_enc_id', 'd.unclaim_organization_enc_id', 'd.location_name',
                    'd.address', 'd.postal_code', 'd.latitude', 'd.longitude', 'd1.name city', 'd2.name state']);
                $d->joinWith(['cityEnc d1' => function ($d1) {
                    $d1->joinWith(['stateEnc d2']);
                }], false);
                $d->onCondition(['d.status' => 'Active', 'd.is_deleted' => 0]);
            }])
            ->where(['a.slug' => $params['slug'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($org_deals) {

            if ($user = $this->isAuthorized()) {
                foreach ($org_deals['assignedDeals'] as $key => $val) {
                    $org_deals['assignedDeals'][$key]['is_claimed'] = $this->_isClaimed($val['deal_enc_id'], $user->user_enc_id);
                }
            }

            return $this->response(200, ['status' => 200, 'org_deals' => $org_deals]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function _isClaimed($deal_id, $user_id)
    {
        return ClaimedDeals::find()
            ->where(['deal_enc_id' => $deal_id, 'user_enc_id' => $user_id, 'is_deleted' => 0])
            ->exists();
    }

    public function actionClaim()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['deal_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "deal_id"']);
            }

            $claim = new ClaimedDeals();
            $claim->claimed_deal_enc_id = \Yii::$app->security->generateRandomString();
            $claim->deal_enc_id = $params['deal_id'];
            $claim->user_enc_id = $user->user_enc_id;
            if ($code = $this->_getCouponCode($params['deal_id'], $user->user_enc_id)) {
                $claim->claimed_coupon_code = $code;
            }
            $claim->expiry_date = AssignedDeals::findOne(['deal_enc_id' => $params['deal_id']])->expiry_date;
            $claim->created_by = $user->user_enc_id;
            $claim->created_on = date('Y-m-d H:i:s');
            if (!$claim->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $claim->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'coupon_code' => $claim->claimed_coupon_code]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function _getCouponCode($deal_id, $user_id)
    {
        $deal = AssignedDeals::findOne(['deal_enc_id' => $deal_id]);

        if ($deal->coupon_code) {
            return $deal->coupon_code;
        } else {
            $deal->coupon_code = $this->_genCode(8);
            $deal->last_updated_by = $user_id;
            $deal->last_updated_on = date('Y-m-d H:i:s');
            if ($deal->update()) {
                return $deal->coupon_code;
            }

            return false;
        }
    }

    private function _genCode($n = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public function actionGetClaimed()
    {
        if ($user = $this->isAuthorized()) {
            $claimed = ClaimedDeals::find()
                ->alias('a')
                ->select(['a.claimed_deal_enc_id', 'a.deal_enc_id', 'a.claimed_coupon_code', 'a.expiry_date', 'b.deal_type', 'b.name', 'b.title', 'b.value', 'b.type', 'b.discount_type',
                    'CASE WHEN b1.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",b1.logo_location, "/", b1.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b1.name, "&size=200&rounded=true&background=", REPLACE(b1.initials_color, "#", ""), "&color=ffffff") END logo'])
                ->joinWith(['dealEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc b1'], false);
                }], false)
                ->where(['a.user_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0])
                ->andWhere(['!=', 'b.slug', 'diwali-dhamaka'])
                ->asArray()
                ->all();

            if ($claimed) {
                return $this->response(200, ['status' => 200, 'claimed_deals' => $claimed]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}