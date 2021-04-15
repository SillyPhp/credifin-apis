<?php
namespace api\modules\v3\controllers;
use common\models\Cities;
use common\models\Countries;
use common\models\States;
use yii\filters\VerbFilter;
use Yii;

class CountriesListController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-countries-list' => ['POST', 'OPTIONS'],
                'get-cities' => ['POST', 'OPTIONS','GET'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetCountriesList()
    {
        if (Yii::$app->request->isPost)
        {
            $cList = Countries::find()->select(['country_enc_id', 'name'])->orderBy(['name' => SORT_ASC])->asArray()->all();
            if ($cList) {
                return $this->response(200, ['status' => 200, 'countries' => $cList]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Countries not found']);
            }
        }
    }

    public function actionGetCities(){
        if (Yii::$app->request->isGET)
        {
            $params = Yii::$app->request->get();
            $query = Cities::find()
                ->alias('a')
                ->distinct()
                ->select(['a.city_enc_id id', 'CONCAT(a.name,", ",b.name) value'])
                ->innerJoin(States::tableName().'as b','b.state_enc_id = a.state_enc_id')
                ->innerJoin(Countries::tableName().'as c','c.country_enc_id = b.country_enc_id');
            if (isset($params['country'])){
                $query->andWhere(['c.name'=>'India']);
            }
            $data = $query->orderBy(['a.name' => SORT_ASC])
                ->asArray()->all();
            if ($data) {
                return $this->response(200, ['status' => 200, 'cities' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Cities not found']);
            }
        }
    }
}