<?php

namespace account\controllers;

use common\models\ResumeTemplates;
use frontend\models\profiles\ResumeData;
use yii\web\HttpException;
use account\models\resumeBuilder\AddExperienceForm;
use account\models\resumeBuilder\AddQualificationForm;
use account\models\resumeBuilder\ResumeAchievments;
use account\models\resumeBuilder\ResumeHobbies;
use account\models\resumeBuilder\ResumeInterests;
use common\models\Organizations;
use common\models\Skills;
use common\models\UnclaimedOrganizations;
use common\models\UserAchievements;
use common\models\UserEducation;
use common\models\UserHobbies;
use common\models\UserInterests;
use common\models\UserSkills;
use common\models\UserWorkExperience;
use common\models\Utilities;
use frontend\models\account\Applications;
use frontend\models\account\OrganizationsExtends;
use frontend\models\NotesForm;
use frontend\models\OrganizationSignUpForm;
use frontend\models\PersonalProfile;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use kartik\mpdf\Pdf;

class ResumeBuilderController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->user_enc_id;
        $addQualificationForm = new AddQualificationForm();
        $addExperienceForm = new AddExperienceForm();
        $obj = new ResumeData();
        $user = $obj->getUser();
        $resume_data = $obj->getResumeData($user_id);
        return $this->render('resume', [
            'user' => $user,
            'addQualificationForm' => $addQualificationForm,
            'addExperienceForm' => $addExperienceForm,
            'resume_data' => $resume_data,
        ]);
    }

    public function actionExperience()
    {
        if (Yii::$app->request->isAjax) {
            $title = Yii::$app->request->post('title');
            $company = Yii::$app->request->post('company');
            $city = Yii::$app->request->post('city');
            $from = Yii::$app->request->post('from');
            $to = Yii::$app->request->post('to');
            $checkbox = Yii::$app->request->post('checkbox');
            $description = Yii::$app->request->post('description');
            $from = Yii::$app->formatter->asDate($from, 'yyyy-MM-dd');
            $to = Yii::$app->formatter->asDate($to, 'yyyy-MM-dd');
            $salary = Yii::$app->request->post('salary');
            $ctc = Yii::$app->request->post('ctc');


            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj = new UserWorkExperience();
            $obj->experience_enc_id = $utilitiesModel->encrypt();
            $obj->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $obj->title = $title;
            $obj->company = $company;
            $obj->city_enc_id = $city;
            $obj->from_date = $from;
            $obj->to_date = $to;
            $obj->ctc = $ctc;
            $obj->salary = $salary;
            $obj->is_current = $checkbox;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;
            $obj->description = $description;

            if (!$obj->save()) {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'error',
                    'message' => 'something went wrong.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Experience added.',
                ]);
            }

        }
    }

    public function actionAchievementRemove()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $achievement_rmv = UserAchievements::findOne([
                'user_achievement_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $achievement_rmv->is_deleted = 1;
            if ($achievement_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Achievement has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionHobbyRemove()
    {

        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $hobby_rmv = UserHobbies::findOne([
                'user_hobby_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $hobby_rmv->is_deleted = 1;
            if ($hobby_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Hobby has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionSkillRemove()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $skill_rmv = UserSkills::findOne([
                'user_skill_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $skill_rmv->is_deleted = 1;
            if ($skill_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'skill has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionInterestRemove()
    {

        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $interest_rmv = UserInterests::findOne([
                'user_interest_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $interest_rmv->is_deleted = 1;
            if ($interest_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'interest has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionAchievements()
    {

        if (Yii::$app->request->isAjax) {
            $achievement_name = Yii::$app->request->post('achievement_name');
            $model = new ResumeAchievments();
            $already_exits = UserAchievements::findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'achievement' => $achievement_name,
                'is_deleted' => 0
            ]);

            if ($already_exits) {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'Achievement already exists.',
                ]);
            } else {

                $model->achievments = $achievement_name;

                if (!$model->add()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'Achievement successfully added.',
                    ]);
                }
            }
        }

    }

    public function actionHobbies()
    {

        if (Yii::$app->request->isAjax) {

            $hobby_name = Yii::$app->request->post('hobby_name');
            $model = new ResumeHobbies();
            $already_exits = UserHobbies::findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'hobby' => $hobby_name,
                'is_deleted' => 0
            ]);

            if ($already_exits) {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'Hobby already exists.',
                ]);
            } else {
                $model->hobbies = $hobby_name;

                if (!$model->hobby_add()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'Hobby successfully added.',
                    ]);
                }
            }
        }

    }

    public function actionInterests()
    {
        if (Yii::$app->request->isAjax) {
            $interest_name = Yii::$app->request->post('interest_name');
            $model = new ResumeInterests();
            $already_exits = UserInterests::findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'interest' => $interest_name,
                'is_deleted' => 0
            ]);

            if ($already_exits) {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'interest already exists.',
                ]);
            } else {
                $model->interests = $interest_name;

                if (!$model->interest_add()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'interest successfully added.',
                    ]);
                }
            }
        }

    }

    public function actionEducation(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new AddQualificationForm();
        if ($model->load(Yii::$app->request->post())) {
            return $model->save();
            if (!$model->save()) {
                return false;
            } else {
                return true;
            }

        }

    }

    public function actionEditEducation()
    {
        $id = Yii::$app->request->post('id');
        $editedu = UserEducation::find()
            ->where(['education_enc_id' => $id])
            ->asArray()
            ->one();
        $from_date = date_create($editedu['from_date']);
        $to_date = date_create($editedu['to_date']);
        $editedu['from_date'] = date_format($from_date, 'Y/m/d');
        $editedu['to_date'] = date_format($to_date, 'Y/m/d');

        return json_encode($editedu);
    }

    public function actionEditExperience()
    {
        $id = Yii::$app->request->post('id');
        $editexp = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.title', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current', 'a.experience_enc_id', 'a.description', 'b.name', 'b.city_enc_id', 'a.salary', 'a.ctc'])
            ->joinWith(['cityEnc b'])
            ->where(['a.experience_enc_id' => $id])
            ->asArray()
            ->one();

        $from_date = date_create($editexp['from_date']);
        $to_date = date_create($editexp['to_date']);
        $editexp['from_date'] = date_format($from_date, 'Y/m/d');
        $editexp['to_date'] = date_format($to_date, 'Y/m/d');

        return json_encode($editexp);
    }

    public function actionDeleteExperience()
    {
        $id = Yii::$app->request->post('id');
        $deleteexp = UserWorkExperience::findOne(
            [
                'experience_enc_id' => $id,
            ]
        );

        if ($deleteexp->delete()) {
            return json_encode($response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'experience has been deleted.',
            ]);
        } else {
            return json_encode($response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ]);
        }

    }

    public function actionDeleteEducation()
    {
        $id = Yii::$app->request->post('id');
        $deleteedu = UserEducation::findOne(
            [
                'education_enc_id' => $id,
            ]
        );

        if ($deleteedu->delete()) {
            return json_encode($response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'experience has been deleted.',
            ]);
        } else {
            return json_encode($response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ]);
        }

    }

    public function actionUpdateEducation()
    {
        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');

            $model = new AddQualificationForm();

            $model->school = Yii::$app->request->post('school');
            $model->degree = Yii::$app->request->post('degree');
            $model->field = Yii::$app->request->post('field');
            $model->qualification_from = Yii::$app->request->post('from');
            $model->qualification_to = Yii::$app->request->post('to');

            if ($model->update($id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionUpdateExperience()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $title = Yii::$app->request->post('title');
            $company = Yii::$app->request->post('company');
            $city = Yii::$app->request->post('city');
            $from = Yii::$app->request->post('from');
            $to = Yii::$app->request->post('to');
            $check = Yii::$app->request->post('check');
            $description = Yii::$app->request->post('description');
            $from = Yii::$app->formatter->asDate($from, 'yyyy-MM-dd');
            $to = Yii::$app->formatter->asDate($to, 'yyyy-MM-dd');
            $ctc = Yii::$app->request->post('ctc');
            $salary = Yii::$app->request->post('salary');


            $model = UserWorkExperience::find()
                ->where(['experience_enc_id' => $id])
                ->one();

            $model->title = $title;
            $model->company = $company;
            $model->city_enc_id = $city;
            $model->from_date = $from;
            $model->to_date = $to;
            $model->is_current = $check;
            $model->salary = $salary;
            $model->ctc = $ctc;
            $model->description = $description;

            if ($model->update()) {
                return true;
            } else {
                return false;
            }

        }

    }

    public function actionSkills()
    {
        if (Yii::$app->request->isAjax) {

            $skillsinput = Yii::$app->request->post('skill_name');

            $obj = new Skills();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $chk = Skills::find()
                ->where(['skill' => $skillsinput])
                ->asArray()
                ->one();


        }

        if (empty($chk)) {
            $obj->skill_enc_id = $utilitiesModel->encrypt();
            $obj->skill = $skillsinput;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$obj->save()) {
                return false;
            } else {

                $user_obj = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->user_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $obj->skill_enc_id;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$user_obj->save()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'skill successfully added.',
                    ]);
                }

            }
        } else {
            $chkk = UserSkills::find()
                ->where(['skill_enc_id' => $chk['skill_enc_id'], 'is_deleted' => 0])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();

            if (!$chkk) {
                $user_obj = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->user_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $chk['skill_enc_id'];
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;

                if (!$user_obj->save()) {
                    
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'skill successfully added.',
                    ]);
                }
            } else {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'skill already exists.',
                ]);
            }

        }
    }

    public function actionOrganizations($q = null)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($q)) {
            $org = Organizations::find()
                ->alias('a')
                ->select(['a.name AS text'])
                ->where(['like', 'a.name', $q, 'is_deleted' => 0]);

            $unclaimed_org = UnclaimedOrganizations::find()
                ->alias('a')
                ->select(['a.name AS text'])
                ->where(['like', 'a.name', $q, 'is_deleted' => 0]);

            return $unclaimed_org->union($org)->asArray()->all();
        }
    }

    public function actionSchools($q = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($q)) {
            $school = Organizations::find()
                ->alias('a')
                ->select(['a.name AS text'])
                ->joinWith(['businessActivityEnc b'], false)
                ->where(['like', 'a.name', $q, 'a.is_deleted' => 0])
                ->andWhere([
                    'or',
                    ['b.business_activity' => 'School'],
                    ['b.business_activity' => 'College'],
                    ['b.business_activity' => 'Educational Institute']
                ])
                ->asArray()
                ->all();

            return $school;
        }
    }

    public function actionDownloadResume()
    {
        //if (Yii::$app->request->isAjax) {
            // get your HTML raw content without any layouts or scripts
            $content = Yii::$app->request->post('html');
            $temp = Yii::$app->request->post('css');
            // setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // your html content input
                'content' => $content,
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting
                //'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                'cssFile' => Url::to('@rootDirectory/assets/common/cv_templates/'.$temp.'.css'),
                // any css to be embedded if required
                //'cssInline' => '',
                // set mPDF properties on the fly
                'options' => ['title' => 'Title'],
                // call mPDF methods on the fly
                'methods' => [
                    //'SetHeader'=>['Header'],
                    //'SetFooter'=>['{PAGENO}'],
                ]
            ]);

            // return the pdf output as per the destination setting
            return $pdf->render();
        //}
    }

    public function actionGetData()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $obj = new ResumeData();
            return [
                'status'=>200,
                'data'=>$obj->getResumeData(Yii::$app->user->identity->user_enc_id)
            ];
        }
    }
    public function actionPreview()
    {
        $templates = ResumeTemplates::find()
            ->select(['template_enc_id','name','unique_id','template_path','thumb_image','thumb_image_location'])
            ->where(['is_deleted'=>0])
            ->asArray()
            ->all();
        $this->layout = 'templates-layout';
        return $this->render('template-preview',['templates'=>$templates]);
    }

}