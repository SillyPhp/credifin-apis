<?php

namespace account\controllers;

use account\models\preferences\CandidatePreferenceForm;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Industries;
use common\models\UserPreferences;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class PreferencesController extends Controller
{
    public function actionCandidate()
    {
        $applicationpreferenceformModel = new CandidatePreferenceForm();

        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
            ->asArray()
            ->all();

        if (Yii::$app->request->isPost) {

            if ($applicationpreferenceformModel->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $assigned_to = $applicationpreferenceformModel['assigned_too'];

                $userdata = UserPreferences::find()
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                    ->andWhere(['assigned_to'=>$assigned_to])
                    ->one();

                if ($userdata) {
                    if($applicationpreferenceformModel->updateData()){
                        return json_encode([
                            'status' => 200,
                            'message' => 'Saved',
                        ]);
                    }else{
                        return json_encode([
                            'status' => 201,
                            'message' => 'Something went wrong',
                        ]);
                    }
                } else {
                    if($applicationpreferenceformModel->saveData()){

                        return json_encode([
                            'status' => 200,
                            'message' => 'Saved',
                        ]);
                    }else{
                        return json_encode([
                            'status' => 201,
                            'message' => 'Something went wrong',
                        ]);
                    }
                }
            } else {
                return json_encode([
                    'status' => 201,
                    'message' => 'Something went wrong',
                ]);
            }
        }

        return $this->render('candidate', [
            'applicationpreferenceformModel' => $applicationpreferenceformModel,
            'primaryfields' => $primaryfields,
        ]);
    }

    public function actionGetIndustry($q = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($q)) {
            $industryModel = new Industries();
            $industry = $industryModel->find()
                ->select(['industry_enc_id AS id', 'industry AS text'])
                ->where(['like', 'industry', $q])
                ->orderBy(['industry' => SORT_ASC])
                ->asArray()
                ->all();

            return $industry;
        }
    }

    public function actionGetJobData(){

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost){

            $data = UserPreferences::find()
                ->alias('a')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id,'assigned_to'=>'Jobs'])
                ->joinWith(['userPreferredLocations c'=>function($x){
                    $x->where(['c.is_deleted'=>0]);
                    $x->joinWith(['cityEnc']);
                }])
                ->joinWith(['userPreferredIndustries d'=>function($y){
                    $y->where(['d.is_deleted'=>0]);
                    $y->joinWith(['industryEnc']);
                }])
                ->joinWith(['userPreferredSkills e'=>function($z){
                    $z->where(['e.is_deleted'=>0]);
                    $z->joinWith(['skillEnc']);
                }])
                ->asArray()
                ->all();

            if(empty($data)){
                return json_encode(['status'=>201]);
            }else{
                return json_encode($data);
            }

        }
    }

    public function actionGetInternData(){

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost){

            $data = UserPreferences::find()
                ->alias('a')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id,'assigned_to'=>'Internships'])
                ->joinWith(['userPreferredLocations c'=>function($x){
                    $x->where(['c.is_deleted'=>0]);
                    $x->joinWith(['cityEnc']);
                }])
                ->joinWith(['userPreferredIndustries d'=>function($y){
                    $y->where(['d.is_deleted'=>0]);
                    $y->joinWith(['industryEnc']);
                }])
                ->joinWith(['userPreferredSkills e'=>function($z){
                    $z->where(['e.is_deleted'=>0]);
                    $z->joinWith(['skillEnc']);
                }])
                ->asArray()
                ->all();

            if(empty($data)){
                return json_encode(['status'=>201]);
            }else{
                return json_encode($data);
            }

        }
    }
}