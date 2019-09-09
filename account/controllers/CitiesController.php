<?php

namespace account\controllers;

use Yii;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use yii\web\Controller;
use yii\web\Response;

class CitiesController extends Controller
{

    public function actionGetCitiesByState()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($id = Yii::$app->request->post('id')) {
            $cities = Cities::find()->select(['city_enc_id AS id', 'name'])->where(['state_enc_id' => $id])->orderBy(['name' => SORT_ASC])->asArray()->all();
        }

        if (count($cities) > 0) {
            return [
                'status' => 200,
                'cities' => $cities
            ];
        } else {
            return [
                'status' => 201
            ];
        }
    }

    public function actionCityList($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($q)) {
            $cities = Cities::find()
                ->alias('a')
                ->select(['a.city_enc_id AS id', 'a.name AS text'])
                ->innerJoin(States::tableName() . ' as b', 'b.state_enc_id = a.state_enc_id')
                ->innerJoin(Countries::tablename() . ' as c', 'c.country_enc_id = b.country_enc_id')
                ->where(['like', 'a.name', $q])
                ->andWhere(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
                ->limit(20)
                ->asArray()
                ->all();

            return $cities;
        }
    }

    public function actionCities($q=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Cities::find()
                ->alias('a')
                ->select(['a.name','a.city_enc_id'])
                ->where('a.name LIKE "' . $q . '%"')
                ->joinWith(['stateEnc b'=>function($b)
                {
                    $b->joinWith(['countryEnc c']);
                    $b->andWhere(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09']);
                }],false)
                ->asArray()
                ->all();
        return $data;
    }

    public function actionCountryList($q = null)
    {
        if (!is_null($q)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Countries::find()
                ->alias('a')
                ->select(['a.name text','a.country_enc_id id'])
                ->where('a.name LIKE "' . $q . '%"')
                ->limit(20)
                ->asArray()
                ->all();
            $out['results'] = array_values($data);
            return $out;
        }
    }

    public function actionFetchAll()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Cities::find()
            ->alias('a')
            ->select(['a.name value','a.city_enc_id id'])
            ->joinWith(['stateEnc b'=>function($b)
            {
                $b->joinWith(['countryEnc c']);
                $b->andWhere(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09']);
            }],false)
            ->asArray()
            ->all();
        return $data;
    }


}
