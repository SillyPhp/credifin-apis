<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\ApiBaseController;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Countries;
use common\models\States;
use yii\helpers\ArrayHelper;
use Yii;

class ApiUtilitiesController extends ApiBaseController{

    public function actionStates(){
        $statesModel = new States();
        $states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name'=>SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');
        return $this->response(200, $states);
    }

    public function actionCities($n = null, $id = null){
        $cities = Cities::find()
                  ->alias('a')
                  ->select(['a.city_enc_id AS id', 'a.name AS name'])
                  ->innerJoin(States::tableName(). ' as b', 'b.state_enc_id = a.state_enc_id')
                  ->innerJoin(Countries::tableName(). ' as c', 'c.country_enc_id = b.country_enc_id')
                  ->where(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
                  ->andFilterWhere(['like', 'a.name', $n])
                  ->andFilterWhere(['like', 'a.city_enc_id', $id])
                  ->asArray()
                  ->all();
        return $this->response(200, $cities);
    }

    public function actionGetCitiesByState(){
        if($id = \Yii::$app->request->post('id')){
            $cities = Cities::find()
                      ->select(['city_enc_id AS id', 'name'])
                      ->where(['state_enc_id' => $id])
                      ->orderBy(['name' => SORT_ASC])
                      ->asArray()
                      ->all();
            if(count($cities) > 0){
                return $this->response(200, $cities);
            }
            return $this->response(201);
        }
        return $this->response(202);
    }

    public function actionJobProfiles($n){
        return AssignedCategories::find()
                ->alias('a')
                ->select(['a.category_enc_id category_id', 'b.name values'])
                ->joinWith(['categoryEnc b'], false, 'INNER JOIN')
                ->where(['a.status' => 'Approved'])
                ->andWhere('b.name LIKE "%' . $n . '%"')
                ->andWhere(['not' , ['a.parent_enc_id' => null]])
                ->asArray()
                ->all();
    }
}
