<?php

namespace api\modules\v1\controllers;


use Yii;
use yii\helpers\Url;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Organizations;

class ExploreController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'active-profiles' => ['POST'],
                'featured-employers' => ['POST'],
                'top-cities' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionActiveProfiles()
    {
        $req = Yii::$app->request->post();
        if (!empty($req['type'])) {
            $options['type'] = $req['type'];
            $activeProfiles = AssignedCategories::find()
                ->select(['b.name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", b.icon) icon', 'COUNT(d.id) as total'])
                ->alias('a')
                ->distinct()
                ->innerJoinWith(['parentEnc b' => function ($b) {
                    $b->onCondition([
                        'or',
                        ['!=', 'b.icon', NULL],
                        ['!=', 'b.icon', ''],
                    ])
                        ->groupBy(['b.category_enc_id']);
                }], false)
                ->joinWith(['employerApplications d' => function ($d) use ($options) {
                    $d->andOnCondition([
                        'd.status' => 'Active',
                        'd.is_deleted' => 0,
                    ])
                        ->joinWith(['applicationTypeEnc e' => function ($e) use ($options) {
                            $e->andOnCondition(['e.name' => ucfirst($options['type'])]);
                        }], false);
                }], false)
                ->where(['a.assigned_to' => ucfirst($options['type'])])
                ->orderBy([
                    'total' => SORT_DESC,
                    'b.name' => SORT_ASC,
                ])
                ->asArray()
                ->all();

            return $this->response(200, $activeProfiles);
        } else {
            return $this->response(422);
        }
    }

    public function actionFeaturedEmployers()
    {
        $organizations = Organizations::find()
            ->select(['initials_color color', 'name', 'organization_enc_id', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['is_sponsored' => 1])
            ->asArray()
            ->all();

        return $this->response(200, $organizations);
    }

    public function actionTopCities()
    {

        $cities = EmployerApplications::find()
            ->alias('a')
            ->select(['d.name', 'COUNT(c.city_enc_id) as total', 'c.city_enc_id'])
            ->innerJoinWith(['applicationPlacementLocations b' => function ($x) {
                $x->joinWith(['locationEnc c' => function ($x) {
                    $x->joinWith(['cityEnc d'], false);
                }], false);
            }], false)
            ->where(['status' => 'Active', 'a.is_deleted' => 0])
            ->orderBy(['total' => SORT_DESC])
            ->groupBy(['c.city_enc_id'])
            ->asArray()
            ->all();

        return $this->response(200, $cities);
    }

}