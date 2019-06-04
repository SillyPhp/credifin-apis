<?php

namespace account\controllers;

use account\models\preferences\CandidatePreferenceForm;
use account\models\preferences\CandidateInternshipPreferenceForm;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Industries;
use yii\web\HttpException;
use common\models\UserPreferences;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class PreferencesController extends Controller
{
    public function actionIndex()
    {
        if (!Yii::$app->user->identity->organization) {

            $applicationpreferenceformModel = new CandidatePreferenceForm();
            $internapplicationpreferenceformModel = new CandidateInternshipPreferenceForm();

            $jobprimaryfields = Categories::find()
                ->alias('a')
                ->select(['a.name', 'a.category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['b.assigned_to' => 'Jobs', 'b.status' => 'Approved'])
                ->asArray()
                ->all();

            $internprimaryfields = Categories::find()
                ->alias('a')
                ->select(['a.name', 'a.category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['b.assigned_to' => 'Internships', 'b.status' => 'Approved'])
                ->asArray()
                ->all();

            $juser_skills = UserPreferences::find()
                ->alias('a')
                ->select(['b.skill'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Jobs'])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc b'], false);
                }], false)
                ->asArray()
                ->all();

            $job_data = UserPreferences::find()
                ->alias('a')
                ->select(['c.job_profile_enc_id', 'a.min_expected_salary'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Jobs'])
                ->joinWith(['userPreferredJobProfiles c' => function ($x) {
                    $x->where(['c.is_deleted' => 0]);
                }])
                ->asArray()
                ->all();


            $job_profile_id = [];

            foreach ($job_data as $jd) {
                array_push($job_profile_id, $jd['job_profile_enc_id']);
            }

            if ($job_profile_id) {
                $applicationpreferenceformModel->job_category = $job_profile_id;
            }

            $intern_data = UserPreferences::find()
                ->alias('a')
                ->select(['c.job_profile_enc_id'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Internships'])
                ->joinWith(['userPreferredJobProfiles c' => function ($x) {
                    $x->where(['c.is_deleted' => 0]);
                }])
                ->asArray()
                ->all();

            $iuser_skills = UserPreferences::find()
                ->alias('a')
                ->select(['b.skill'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Internships'])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc b'], false);
                }], false)
                ->asArray()
                ->all();

            $intern_profile_id = [];

            foreach ($intern_data as $jd) {
                array_push($intern_profile_id, $jd['job_profile_enc_id']);
            }

            if ($intern_profile_id) {
                $internapplicationpreferenceformModel->job_category = $intern_profile_id;
            }

            if (Yii::$app->request->isPost) {

                if ($applicationpreferenceformModel->load(Yii::$app->request->post())) {

                    $skill = Yii::$app->request->post('skills');

                    if (empty($skill)) {
                        return json_encode([
                            'status' => 201,
                            'message' => 'Please Enter Skills',
                        ]);
                    }

                    $applicationpreferenceformModel->key_skills = Yii::$app->request->post('skills');


                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $userdata = UserPreferences::find()
                        ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                        ->andWhere(['assigned_to' => "Jobs"])
                        ->one();

                    if ($userdata) {

                        if ($applicationpreferenceformModel->updateData()) {
                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    } else {
                        if ($applicationpreferenceformModel->saveData()) {

                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    }
                } elseif ($internapplicationpreferenceformModel->load(Yii::$app->request->post())) {

                    $skill = Yii::$app->request->post('intern_skills');

                    if (empty($skill)) {
                        return json_encode([
                            'status' => 201,
                            'message' => 'Please Enter Skills',
                        ]);
                    }
                    $internapplicationpreferenceformModel->key_skills = Yii::$app->request->post('intern_skills');
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $userdata = UserPreferences::find()
                        ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                        ->andWhere(['assigned_to' => 'Internships'])
                        ->one();

                    if ($userdata) {
                        if ($internapplicationpreferenceformModel->updateData()) {
                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    } else {
                        if ($internapplicationpreferenceformModel->saveData()) {

                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
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
                'internapplicationpreferenceformModel' => $internapplicationpreferenceformModel,
                'jobprimaryfields' => $jobprimaryfields,
                'internprimaryfields' => $internprimaryfields,
                'juser_skills' => $juser_skills,
                'iuser_skills' => $iuser_skills
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionGetIndustry($q = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($q)) {
            $industryModel = new Industries();
            $industry = $industryModel->find()
                ->select(['industry_enc_id AS id', 'industry AS text'])
                ->where('industry LIKE "%' . $q . '%"')
                ->orderBy(['industry' => SORT_ASC])
                ->asArray()
                ->all();

            return $industry;
        }
    }

    public function actionGetJobData()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $data = UserPreferences::find()
                ->alias('a')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Jobs'])
                ->joinWith(['userPreferredLocations c' => function ($x) {
                    $x->onCondition(['c.is_deleted' => 0]);
                    $x->joinWith(['cityEnc']);
                }])
                ->joinWith(['userPreferredIndustries d' => function ($y) {
                    $y->onCondition(['d.is_deleted' => 0]);
                    $y->joinWith(['industryEnc']);
                }])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc']);
                }])
                ->asArray()
                ->all();


            if (empty($data)) {
                return json_encode(['status' => 201]);
            } else {
                return json_encode($data);
            }

        }
    }

    public function actionGetInternData()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $data = UserPreferences::find()
                ->alias('a')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Internships'])
                ->joinWith(['userPreferredLocations c' => function ($x) {
                    $x->onCondition(['c.is_deleted' => 0]);
                    $x->joinWith(['cityEnc']);
                }])
                ->joinWith(['userPreferredIndustries d' => function ($y) {
                    $y->onCondition(['d.is_deleted' => 0]);
                    $y->joinWith(['industryEnc']);
                }])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc']);
                }])
                ->asArray()
                ->all();

            if (empty($data)) {
                return json_encode(['status' => 201]);
            } else {
                return json_encode($data);
            }

        }
    }
}