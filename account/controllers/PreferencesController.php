<?php

namespace account\controllers;

use account\models\preferences\CandidatePreferenceForm;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Industries;
use Yii;
use yii\web\Controller;

class PreferencesController extends Controller
{
    public function actionCandidate()
    {
        $applicationpreferenceformModel = new CandidatePreferenceForm();
        $industries = Industries::find()
            ->select(['industry_enc_id id', 'industry text'])
            ->asArray()
            ->all();
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
            ->asArray()
            ->all();
        if (Yii::$app->request->isPost) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($applicationpreferenceformModel->load(Yii::$app->request->post())) {
                $userdata = UserPreferences::find()
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                    ->one();
                if ($userdata) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UserPreferences::tableName(), ['created_by' => Yii::$app->user->identity->user_enc_id])
                        ->execute();
                } else {
//                    return $applicationpreferenceformModel->location;
                    return json_encode($applicationpreferenceformModel->saveData());
                    if ($applicationpreferenceformModel->saveData()) {
                        return [
                            'status' => 200,
                            'message' => 'hi',
                        ];
                    } else {
                        return [
                            'status' => 201,
                            'message' => 'data not saved',
                        ];
                    }
                }
            } else {
                return [
                    'status' => 201,
                    'message' => 'Something went wrong',
                ];
            }
        }

        return $this->render('candidate', [
            'applicationpreferenceformModel' => $applicationpreferenceformModel,
            'industries' => $industries,
            'primaryfields' => $primaryfields,
        ]);
    }
}