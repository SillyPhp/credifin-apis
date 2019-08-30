<?php

namespace frontend\controllers;

use Yii;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use yii\web\Controller;
use yii\web\Response;

/**
 * CitiesController implements the CRUD actions for Cities model.
 */
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
                'status' => 0
            ];
        }
    }

    public function actionCityList($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $out = ['results' => ['id' => '', 'text' => '']];
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
//            $out['results'] = array_values($cities);
//        } elseif ($id > 0) {
//            $out['results'] = ['id' => $id, 'text' => Cities::find($id)->name];
//        }
//        return $out;

            return $cities;
        }
    }

    public function actionCareerCityList($q = null,$cid='b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09')
    {
        if (!is_null($q)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Cities::find()
                ->alias('a')
                ->select(['a.name text','a.city_enc_id id'])
                ->where('a.name LIKE "' . $q . '%"')
                ->joinWith(['stateEnc b'=>function($b) use ($cid)
                {
                    $b->joinWith(['countryEnc c']);
                    $b->andWhere(['c.country_enc_id' => $cid]);
                }],false)
                ->limit(20)
                ->asArray()
                ->all();
            $out['results'] = array_values($data);
            return $out;
        }
    }

}
