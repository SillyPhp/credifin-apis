<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\BusinessActivities;
use common\models\Industries;
use common\models\AssignedIndustries;

class IndustriesController extends Controller
{

    /**
     * @inheritdoc
     */

    public function actionGetIndustriesByBusinessActivity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if (!empty($id)) {
            $industries = AssignedIndustries::find()
                ->alias('a')
                ->select(['b.industry_enc_id id', 'b.industry name'])
                ->innerJoin(Industries::tableName() . 'as b', 'b.industry_enc_id = a.industry_enc_id')
                ->innerJoin(BusinessActivities::tableName() . 'as c', 'c.business_activity_enc_id = a.business_activity_enc_id')
                ->where(['c.business_activity_enc_id' => $id])
                ->orderBy(['b.industry' => SORT_ASC])
                ->asArray()
                ->all();
            if ($industries) {
                $response = [
                    'status' => 200,
                    'industries' => $industries,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }

            return $response;
        }
    }

//    public function actionList()
//    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//        return Industries::find()
//            ->orderBy([new \yii\db\Expression('FIELD (industry, "Same Industry", "No Preference") DESC, industry ASC')])
//            ->asArray()
//            ->all();
//    }

}
