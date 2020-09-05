<?php
namespace api\modules\v3\controllers;
use common\models\Countries;
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
}