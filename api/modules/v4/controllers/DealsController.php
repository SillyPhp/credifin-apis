<?php

namespace api\modules\v4\controllers;

use common\models\AssignedDeals;
use common\models\UnclaimedOrganizations;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

class DealsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'detail' => ['POST', 'OPTIONS']
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
                    'c.type', 'c.discount_type', 'c.expiry_date', 'c.is_popular', 'c.how_to_apply', 'c.terms_and_conditions', 'c.value'
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
            return $this->response(200, ['status' => 200, 'org_deals' => $org_deals]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }
}