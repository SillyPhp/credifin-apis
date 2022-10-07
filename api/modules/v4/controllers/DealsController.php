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
            return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
        }

        $detail = AssignedDeals::find()
            ->alias('a')
            ->select(['a.deal_enc_id', 'a.organization_enc_id', 'a.deal_type', 'a.coupon_type', 'a.coupon_code', 'a.slug', 'a.name', 'a.title',
                'a.type', 'a.discount_type', 'a.expiry_date', 'a.is_popular', 'a.how_to_apply', 'a.terms_and_conditions',
            ])
            ->joinWith(['assignedDealsLocations b' => function ($b) {
                $b->select(['b.assign_deal_enc_id', 'b.deal_enc_id', 'b.location_enc_id', 'c.latitude', 'c.longitude',
                    'c.city_enc_id', 'c.postal_code', 'c.address', 'd.name city', 'e.name state']);
                $b->joinWith(['locationEnc c' => function ($c) {
                    $c->joinWith(['cityEnc d' => function ($d) {
                        $d->joinWith(['stateEnc e']);
                    }], false);
                }], false);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->where(['a.slug' => $params['slug'], 'a.is_deleted' => 0, 'a.status' => 'Active'])
            ->asArray()
            ->one();

        if ($detail) {

            $detail['organization'] = UnclaimedOrganizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.name', 'a.slug',
                    'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',])
                ->joinWith(['unclaimOrganizationImages b' => function ($b) {
                    $b->select(['b.image_enc_id', 'b.unclaim_organization_enc_id', 'b.title', 'b.alt',
                        'CASE WHEN b.image IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->image) . '",b.image_location, "/", b.image) ELSE NULL END image'
                    ]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['organization_enc_id' => $detail['organization_enc_id']])
                ->asArray()
                ->one();


            return $this->response(200, ['status' => 200, 'deal' => $detail]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }
}