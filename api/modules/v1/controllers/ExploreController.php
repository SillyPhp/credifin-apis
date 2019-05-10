<?php

namespace api\modules\v1\controllers;

use common\models\EmployerApplications;
use Yii;
use common\models\AssignedCategories;
use common\models\Organizations;
use yii\helpers\Url;

class ExploreController extends ApiBaseController
{
    public function behaviors(){
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
                ->select(['b.name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', true) . '", b.icon) icon', 'COUNT(d.id) as total'])
                ->alias('a')
                ->distinct()
                ->joinWith(['parentEnc b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['employerApplications d' => function ($b) use ($options) {
                    $b->joinWith(['applicationTypeEnc e']);
                    $b->andWhere(['e.name' => ucfirst($options['type'])]);
                }], false)
                ->groupBy(['a.parent_enc_id'])
                ->orderBy(['total' => SORT_DESC])
                ->limit(8)
                ->asArray()
                ->all();

            return $this->response(200, $activeProfiles);
        }else{
            return $this->response(422);
        }
    }

    public function actionFeaturedEmployers(){
        $organizations = Organizations::find()
            ->select(['initials_color color','name','organization_enc_id', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo,true) . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['is_sponsored' => 1])
            ->asArray()
            ->all();

        return $this->response(200,$organizations);
    }

    public function actionTopCities(){

        $cities = EmployerApplications::find()
            ->alias('a')
            ->select(['d.name','COUNT(c.city_enc_id) as total','c.city_enc_id'])
            ->innerJoinWith(['applicationPlacementLocations b' => function ($x) {
                $x->joinWith(['locationEnc c' => function ($x) {
                    $x->joinWith(['cityEnc d'], false);
                }], false);
            }], false)
            ->where(['a.is_deleted'=>0])
            ->orderBy(['total' => SORT_DESC])
            ->groupBy(['c.city_enc_id'])
            ->asArray()
            ->all();

        return $this->response(200,$cities);
    }

}