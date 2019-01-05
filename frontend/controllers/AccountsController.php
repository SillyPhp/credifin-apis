<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use frontend\models\accounts\LoginForm;
use frontend\models\accounts\ForgotPasswordForm;
use frontend\models\accounts\ResetPasswordForm;
use frontend\models\accounts\IndividualSignUpForm;
use frontend\models\accounts\OrganizationSignUpForm;
use frontend\models\accounts\UserEmails;

class AccountsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public $layout = 'main-secondary';

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginFormModel = new LoginForm();
        if ($loginFormModel->load(Yii::$app->request->post()) && $loginFormModel->login()) {
            return $this->redirect((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : '/account/dashboard'));
        }

        return $this->render('login', [
                    'loginFormModel' => $loginFormModel,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect('/login');
    }

    public function actionSignup($type) {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!isset($type) || empty($type)) {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }

        if ($type == 'individual') {
            $model = new IndividualSignUpForm();
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->load(Yii::$app->request->post());
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post())) {
                $model->user_type = 'Individual';
                if ($model->add()) {
                    $data['username'] = $model->username;
                    $data['password'] = $model->new_password;
                    $model = new IndividualSignUpForm();
                    if ($this->login($data)) {
                        return $this->redirect('/account/dashboard');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
                }
            }
            return $this->render('signup/individual', [
                        'model' => $model,
            ]);
        } elseif ($type == 'organization') {
            $model = new OrganizationSignUpForm();
            $organization_types = \common\models\extended\OrganizationTypes::find()
                    ->select(['organization_type_enc_id', 'organization_type'])
                    ->orderBy(['organization_type' => SORT_ASC])
                    ->asArray()
                    ->all();
            $business_activities = \common\models\extended\BusinessActivities::find()
                    ->select(['business_activity_enc_id', 'business_activity'])
                    ->orderBy(['business_activity' => SORT_ASC])
                    ->asArray()
                    ->all();
            $industries = \common\models\extended\Industries::find()
                    ->select(['industry_enc_id', 'industry'])
                    ->where(['NOT IN', 'industry', ['Same Industry', 'No Preference']])
                    ->orderBy(['industry' => SORT_ASC])
                    ->asArray()
                    ->all();

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->load(Yii::$app->request->post());
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post())) {
                $model->user_type = 'Organization Admin';
                if ($model->add()) {
                    $data['username'] = $model->username;
                    $data['password'] = $model->new_password;
                    $model = new OrganizationSignUpForm();
                    if ($this->login($data)) {
                        return $this->redirect('/account/dashboard');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
                }
            }
            return $this->render('signup/organization', [
                        'model' => $model,
                        'organization_types' => $organization_types,
                        'business_activities' => $business_activities,
                        'industries' => $industries,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionResendVerificationEmail() {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $is_organization = true;
            $id = Yii::$app->user->identity->organization->organization_enc_id;
            if (!$id) {
                $id = Yii::$app->user->identity->user_enc_id;
                $is_organization = false;
            }

            $userEmailsModel = new UserEmails();
            if ($userEmailsModel->verificationEmail($id, $is_organization)) {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'An email with instructions has been sent to your email address (please also check your spam folder).',
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionVerify($token) {
        try {
            $verifyEmailModel = new \frontend\models\accounts\VerifyEmail($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($verifyEmailModel->emailVerification()) {
            return $this->render('/site/message', [
                        'status' => 'success',
                        'title' => 'Congratulations',
                        'message' => 'Your email has been verified.'
            ]);
        } else {
            return $this->render('/site/message', [
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Your account verification failed.'
            ]);
        }
    }

    public function actionForgotPassword() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->forgotPassword()) {
                $model = new ForgotPasswordForm();
                return $this->render('/site/message', [
                            'status' => 'success',
                            'title' => 'Congratulations',
                            'message' => 'An email with instructions has been sent to your email address (please also check your spam folder).'
                ]);
            } else {
                return $this->render('/site/message', [
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'An error has occurred. Please try again.'
                ]);
            }
        }
        return $this->render('forgot-password', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->resetPassword()) {
                return $this->render('/site/message', [
                            'status' => 'success',
                            'title' => 'Congratulations',
                            'message' => 'Your password has been changed. You can login into your account now.'
                ]);
            } else {
                return $this->render('/site/message', [
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'An error has occurred. Please try again.'
                ]);
            }
        }

        return $this->render('reset-password', [
                    'model' => $model,
        ]);
    }

    private function login($data = []) {
        $loginFormModel = new LoginForm();
        $loginFormModel->username = $data['username'];
        $loginFormModel->password = $data['password'];
        $loginFormModel->rememberMe = true;
        if ($loginFormModel->login()) {
            return true;
        } else {
            return false;
        }
    }

}
