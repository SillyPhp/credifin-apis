<?php

namespace account\controllers;
use account\models\applications\ApplicationForm;
use account\models\training_program\InviteCandidatesForm;
use account\models\training_program\TrainingProgram;
use account\models\training_program\UserAppliedTraining;
use common\models\AppliedTrainingApplications;
use common\models\TrainingProgramApplication;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class TrainingProgramController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->identity->businessActivity->business_activity == "Educational Institute") {
            return parent::beforeAction($action);
        } else{
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->user->identity->organization):
        $model = new TrainingProgram();
        $object = new ApplicationForm();
        $primary_cat = $object->getPrimaryFields();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your Application Has Been Submitted Successfully..');
            } else {
                Yii::$app->session->setFlash('error', 'Error Please Contact Supportive Team ');
            }
            return $this->refresh();
        }
        return $this->render('index',['model'=>$model,'primary_cat'=>$primary_cat]);
        endif;
    }

    public function actionDashboard()
    {
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationDashboard();
        }
    }

    private function __organizationDashboard()
    {
        $userApplied = new UserAppliedTraining();
        return $this->render('dashboard/organization', [
            'applications'=>$this->__trainings(8),
            'total_applied' => $userApplied->total_applied(),
            'applied_applications'=>$userApplied->getUserDetails('Trainings',10)
        ]);
    }

    private function __trainings($limit = NULL)
    {
        $options = [
            'applicationType' => 'Trainings',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.is_deleted' => 0,
            ],
            'orderBy' => [
                'a.created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $applications = new \account\models\applications\TrainingApplications();
        return $applications->getApplications($options);
    }

    public function actionIndex()
    {
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationTrainings();
        }
    }
    private function __organizationTrainings()
    {
        return $this->render('list/organization', [
            'applications' => $this->__trainings(),
        ]);
    }
    public function actionDeleteApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(TrainingProgramApplication::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $id])
                ->execute();
            if ($update) {
                Yii::$app->sitemap->generate();
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionCandidates($app_id)
    {
        if (Yii::$app->user->identity->organization) {
            $user_data = AppliedTrainingApplications::find()
                ->alias('a')
                ->where(['a.application_enc_id' => $app_id])
                ->select(['applied_application_enc_id','a.application_enc_id','a.created_by'])
                ->joinwith(['createdBy b'=>function($b)
                {
                    $b->select(['b.user_enc_id','b.username','b.experience','b.job_function','b.first_name', 'b.last_name', 'b.image', 'b.image_location','g.name city_name',]);
                    $b->joinWith(['jobFunction f'], false);
                    $b->joinWith(['cityEnc g'], false);
                    $b->joinWith(['userSkills c'=>function($b)
                    {
                        $b->select(['c.created_by','d.skill']);
                        $b->joinWith(['skillEnc d'],false);
                        $b->onCondition(['c.is_deleted' => 0]);
                    }]);
                }])
                ->groupBy(['application_enc_id'])
                ->asArray()
                ->all();
            return $this->render('dashboard/candidate-list', ['user_data' => $user_data]);
        }
    }

    public function actionClone($aidk)
    {
        if (Yii::$app->user->identity->organization):
            $object = new TrainingProgram();
            $model = $object->setData($aidk);
            $type = 'Clone';
            $object = new ApplicationForm();
            $primary_cat = $object->getPrimaryFields();
            if ($object->load(Yii::$app->request->post())) {
                if ($object->save()) {
                    Yii::$app->session->setFlash('success', 'Your Application Has Been Submitted Successfully..');
                } else {
                    Yii::$app->session->setFlash('error', 'Error Please Contact Supportive Team ');
                }
                return $this->refresh();
            }
            return $this->render('index',['model'=>$model['model'],'batch_data'=>$model['batch_data'],'skill'=>$model['skill_list'],'primary_cat'=>$primary_cat]);
            endif;

    }

    public function actionInviteCandidates(){
        if (Yii::$app->request->isAjax) {
            $inviteForm = new InviteCandidatesForm();

            return $this->renderAjax('invitation_form',[
                'inviteForm' => $inviteForm,
            ]);
        }
    }

    public function actionSubmitInvitations(){
        if (Yii::$app->request->isAjax) {
            $inviteForm = new InviteCandidatesForm();
            if ($inviteForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($inviteForm->send()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Invitations has been Send.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            }
        }
    }
}