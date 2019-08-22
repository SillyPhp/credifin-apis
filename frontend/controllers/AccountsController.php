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
use frontend\models\ChangePasswordForm;
use common\models\Utilities;

class AccountsController extends Controller
{

    public $layout = 'main-secondary';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginFormModel = new LoginForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($loginFormModel->load(Yii::$app->request->post()) && $loginFormModel->login()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Successfully Login',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'Incorrect username or password.',
                ];
            }
        }
        if (!Yii::$app->session->has("backURL")) {
            Yii::$app->session->set("backURL", Yii::$app->request->referrer);
        }
        if ($loginFormModel->load(Yii::$app->request->post()) && $loginFormModel->login()) {
            if ($loginFormModel->isMaster) {
                Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params->session->timeout);
            }
            return $this->redirect(Yii::$app->session->get("backURL"));
        }

        return $this->render('login', [
            'loginFormModel' => $loginFormModel,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/login');
    }

    public function actionSignup($type)
    {

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
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    private function login($data = [])
    {
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

    public function actionResendVerificationEmail()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->user->identity->organization->organization_enc_id;
            $response = false;
            if (!$id) {
                $response = Yii::$app->individualSignup->registrationEmail(Yii::$app->user->identity->user_enc_id);
            } else {
                $response = Yii::$app->organizationSignup->registrationEmail($id);
            }

            if ($response) {
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

    public function actionVerify($token)
    {
        try {
            $verifyEmailModel = Yii::$app->verifyEmail->registerVerification($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($verifyEmailModel) {
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

    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->forgotPassword()) {
                return $this->render('/site/message', [
                    'message' => 'An email with instructions has been sent to your email address (please also check your spam folder).'
                ]);
            } else {
                return $this->render('/site/message', [
                    'message' => 'An error has occurred. Please try again.'
                ]);
            }
        }
        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        try {
            $user_id = Yii::$app->forgotPassword->verify($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $model = new ResetPasswordForm();
        if (Yii::$app->request->isPost) {
            if (Yii::$app->forgotPassword->change($user_id, Yii::$app->request->post('new_password'))) {
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

    public function actionChangePassword()
    {
        if (Yii::$app->request->isAjax) {
            $changePasswordForm = new ChangePasswordForm();
            if ($changePasswordForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($changePasswordForm->changePassword()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Password has been changed.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            }
            return $this->renderAjax('change-password', [
                'changePasswordForm' => $changePasswordForm
            ]);
        }
    }

}