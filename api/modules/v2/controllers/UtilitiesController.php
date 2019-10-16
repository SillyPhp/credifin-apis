<?php

namespace api\modules\v2\controllers;

use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Countries;
use common\models\Organizations;
use common\models\States;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class UtilitiesController extends ApiBaseController{

    public function actionGetCompany(){
        $organization = Organizations::find()
            ->select([
                'organization_enc_id',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0
            ])
            ->asArray()
            ->one();
        return $organization;
    }

    public function actionGetCompanies($search=null){
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0
            ])
            ->andWhere([
                'or',
                ['like', 'name', $search],
                ['like', 'slug', $search]
            ])
            ->asArray()
            ->all();
        return $organizations;
    }

    public function actionProfiles($type){
        $q = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => $type, 'b.status' => 'Approved'])
            ->asArray()
            ->all();

        return $this->response(200, $q);
    }

    public function actionStates()
    {
        $statesModel = new States();
        $states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'name', 'state_enc_id');
        $states = ['select' => 'default'] + $states;
        return $this->response(200, $states);
    }

    public function actionCities($n = null, $id = null)
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['a.city_enc_id AS id', 'a.name AS name'])
            ->innerJoin(States::tableName() . ' as b', 'b.state_enc_id = a.state_enc_id')
            ->innerJoin(Countries::tableName() . ' as c', 'c.country_enc_id = b.country_enc_id')
            ->where(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->andFilterWhere(['like', 'a.name', $n])
            ->andFilterWhere(['like', 'a.city_enc_id', $id])
            ->asArray()
            ->all();
        return $this->response(200, $cities);
    }

}