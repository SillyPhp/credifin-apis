<?php

namespace frontend\controllers;

use common\models\AssignedCategories;
use common\models\Categories;
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
                ->orderBy([new \yii\db\Expression('FIELD (b.industry, "Others") ASC, b.industry ASC')])
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

    public function actionProfiles()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $param1 = (new \yii\db\Query())
            ->select(['industry value'])
            ->from(Industries::tableName().'as a');

        $param2 = (new \yii\db\Query())
            ->select(['business_activity value'])
            ->from(BusinessActivities::tableName().'as a');

        return $param1->union($param2)->all();
    }

}
