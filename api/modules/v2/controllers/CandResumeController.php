<?php

namespace api\modules\v2\controllers;

use common\models\Cities;
use common\models\Skills;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\UserEducation;
use common\models\Users;
use common\models\UserSkills;
use common\models\UserWorkExperience;
use Yii;
use common\models\Utilities;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;


class CandResumeController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'fetch-details' => ['POST', 'OPTIONS'],
                'save-about' => ['POST', 'OPTIONS'],
                'save-qualification' => ['POST', 'OPTIONS'],
                'save-experience' => ['POST', 'OPTIONS'],
                'save-skills' => ['POST', 'OPTIONS'],
                'remove-edu' => ['POST', 'OPTIONS'],
                'remove-exp' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionSaveAbout()
    {

        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $about = Yii::$app->request->post('description');

            $users = Users::find()
                ->where(['user_enc_id' => $id])
                ->one();

            $users->description = $about;
            $users->last_updated_on = date('Y-m-d H:i:s');
            if ($users->update()) {
                return $this->response(200, ['status' => 200]);
            } else {
                print_r($users->getErrors());
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionFetchDetails()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $about = Users::find()
                ->select(['description'])
                ->where([
                    'user_enc_id' => $id
                ])
                ->asArray()
                ->one();

            $experience = $this->getWorkExp($id);

            $education = $this->getEducation($id);

            $skills = UserSkills::find()
                ->alias('a')
                ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted'])
                ->joinWith(['skillEnc c'], false)
                ->where(['a.created_by' => $id, 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            $data = [];
            $data['about'] = $about;
            $data['experience'] = $experience;
            $data['education'] = $education;
            $data['skills'] = $skills;

            return $this->response(200, $data);
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveExperience()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $req = Yii::$app->request->post();
            $work_id = Yii::$app->request->post('id');

            if (Yii::$app->request->post('id')) {
                $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
                $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');
                $data = UserWorkExperience::find()
                    ->where(['experience_enc_id' => $work_id])
                    ->one();
                $data->title = $req['title'];
                $data->company = $req['company'];
                $data->from_date = $from;
                $data->to_date = $to;
                $data->description = $req['description'];
                $data->last_updated_by = $id;
                $data->last_updated_on = date('Y-m-d H:i:s');
                if ($data->update()) {
                    $experience = UserWorkExperience::find()
                        ->alias('a')
                        ->select(['a.experience_enc_id id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current'])
//                ->innerJoin(Cities::tableName() . "b", "b.city_enc_id=a.city_enc_id")
                        ->where(['a.created_by' => $id])
                        ->orderBy(['a.id' => SORT_DESC])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'data' => $experience]);
                } else {
                    print_r($data->getErrors());
                }
            } else {
                $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
                $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');

                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $obj = new UserWorkExperience();
                $obj->experience_enc_id = $utilitiesModel->encrypt();
                $obj->user_enc_id = $id;
                $obj->title = $req['title'];
                $obj->company = $req['company'];
                $obj->from_date = $from;
                $obj->to_date = $to;
                $obj->created_on = date('Y-m-d H:i:s');
                $obj->created_by = $id;
                $obj->description = $req['description'];

                if ($obj->save()) {
                    $experience = UserWorkExperience::find()
                        ->alias('a')
                        ->select(['a.experience_enc_id id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current'])
//                ->innerJoin(Cities::tableName() . "b", "b.city_enc_id=a.city_enc_id")
                        ->where(['a.created_by' => $id])
                        ->orderBy(['a.id' => SORT_DESC])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'data' => $experience]);
                }
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveQualification()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;
            $req = Yii::$app->request->post();
            $edu_id = Yii::$app->request->post('id');

            if (Yii::$app->request->post('id')) {
                $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
                $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');
                $data = UserEducation::find()
                    ->where(['education_enc_id' => $edu_id])
                    ->one();
                $data->institute = $req['college'];
                $data->degree = $req['degree'];
                $data->cgpa = $req['cgpa'];
                $data->from_date = $from;
                $data->to_date = $to;
                $data->last_updated_by = $id;
                $data->last_updated_on = date('Y-m-d H:i:s');
                if ($data->update()) {
                    $education = UserEducation::find()
                        ->where(['created_by' => $id])
                        ->orderBy(['id' => SORT_DESC])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'data' => $education]);
                } else {
                    print_r($data->getErrors());
                }
            } else {

                $utilities = new Utilities();
                $user_education_model = new UserEducation();
                $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
                $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');

                $user_education_model->institute = $req['college'];
                $user_education_model->degree = $req['degree'];
                $user_education_model->cgpa = $req['cgpa'];
                $user_education_model->from_date = $from;
                $user_education_model->to_date = $to;
                $user_education_model->created_by = $id;
                $user_education_model->user_enc_id = $id;
                $user_education_model->created_on = date('Y-m-d H:i:s');
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_education_model->education_enc_id = $utilities->encrypt();
                if (!$user_education_model->save()) {
                    print_r($user_education_model->getErrors());
                }

                $education = UserEducation::find()
                    ->where(['created_by' => $id])
                    ->orderBy(['id' => SORT_DESC])
                    ->asArray()
                    ->all();

                return $this->response(200, ['status' => 200, 'data' => $education]);
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveSkills()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $skills = Yii::$app->request->post('skills');

            //finding already saved skills
            $saved_skills = UserSkills::find()
                ->select(['skill_enc_id'])
                ->where(['created_by' => $id, 'is_deleted' => 0])
                ->asArray()
                ->all();

            $s_skill = [];
            foreach ($saved_skills as $s) {
                array_push($s_skill, $s['skill_enc_id']);
            }

            //get skill_enc_id of new added skills
            $new_skill_keys = [];
            foreach ($skills as $s) {
                if (empty($s['key'])) {
                    $model = new Skills();
                    $utilities = new Utilities();
                    $utilities->variables['string'] = time() . rand(100, 100000);
                    $model->skill_enc_id = $utilities->encrypt();
                    $model->skill = $s['value'];
                    $model->created_by = $id;
                    $model->created_on = date('Y-m-d H:i:s');
                    if ($model->save()) {
                        array_push($new_skill_keys, $model->skill_enc_id);
                    } else {
                        print_r($model->getErrors());
                        print_r('while saving new skill');
                    }
                } else {
                    array_push($new_skill_keys, $s['key']);
                }
            }


            //check difference between skills
            $to_be_added_skills = array_diff($new_skill_keys, $s_skill);
            $to_be_deleted_skills = array_diff($s_skill, $new_skill_keys);

            //add skills to user skills table
            if (!empty($to_be_added_skills)) {
                foreach ($to_be_added_skills as $skill) {
                    $model = new UserSkills();
                    $utilities = new Utilities();
                    $utilities->variables['string'] = time() . rand(100, 100000);
                    $model->user_skill_enc_id = $utilities->encrypt();
                    $model->skill_enc_id = $skill;
                    $model->created_on = date('Y-m-d H:i:s');
                    $model->created_by = $id;
                    if (!$model->save()) {
                        print_r($model->getErrors());
                        print_r('while adding new skill');
                        print_r($skill);
                    }
                }
            }

            //remove skills from user skills table
            if (!empty($to_be_deleted_skills)) {
                foreach ($to_be_deleted_skills as $d) {
                    $skill = UserSkills::find()
                        ->where(['skill_enc_id' => $d, 'created_by' => $id])
                        ->one();

                    $skill->is_deleted = 1;
                    $skill->last_updated_by = $id;
                    $skill->last_updated_on = date('Y-m-d H:i:s');

                    if (!$skill->update()) {
                        print_r($skill->getErrors());
                        print_r('while delete new skill');
                    }

                }
            }

            $skills = UserSkills::find()
                ->alias('a')
                ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted'])
                ->joinWith(['skillEnc c'], false)
                ->where(['a.created_by' => $id, 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'skills' => $skills]);

        } else {
            return $this->response(401);
        }

    }

    public function actionRemoveEdu()
    {
        if ($user = $this->isAuthorized()) {
            $user_id = $user->user_enc_id;
            $edu_enc_id = Yii::$app->request->post('id');

            $user_edu = UserEducation::find()
                ->where(['education_enc_id' => $edu_enc_id])
                ->one();

            if (!empty($user_edu)) {
                if ($user_edu->delete()) {
                    $education = UserEducation::find()
                        ->where(['created_by' => $user_id])
                        ->orderBy(['id' => SORT_DESC])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'edu' => $education]);
                } else {
                    print_r($user_edu->getErrors());
                }
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionRemoveExp()
    {
        if ($user = $this->isAuthorized()) {
            $user_id = $user->user_enc_id;
            $exp_enc_id = Yii::$app->request->post('id');

            $user_exp = UserWorkExperience::find()
                ->where(['experience_enc_id' => $exp_enc_id])
                ->one();

            if (!empty($user_exp)) {
                if ($user_exp->delete()) {
                    $experience = UserWorkExperience::find()
                        ->alias('a')
                        ->select(['a.experience_enc_id id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current'])
                        ->where(['a.created_by' => $user_id])
                        ->orderBy(['a.id' => SORT_DESC])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'work' => $experience]);
                }
            }
        } else {
            return $this->response(401);
        }
    }

    private function getEducation($id)
    {

        $education = UserEducation::find()
            ->where(['created_by' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        return $education;
    }

    private function getWorkExp($id)
    {

        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.experience_enc_id id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current'])
//            ->innerJoin(Cities::tableName() . "b", "b.city_enc_id=a.city_enc_id")
            ->where(['a.created_by' => $id])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        return $experience;
    }

}