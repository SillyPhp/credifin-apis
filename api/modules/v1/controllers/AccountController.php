<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\Controller;
use common\models\Utilities;
use common\models\UserTypes;
use common\models\Users;
use common\models\States;
use common\models\Cities;

class AccountController extends Controller {

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['POST'],
                    'signup' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionLogin() {
        $attributes = Yii::$app->request->post();

        if (!empty($attributes)) {
//            $user_type = UserTypes::findOne([
//                        'user_type' => $attributes['user_type'],
//            ]);

            $user = Users::find()
                    ->alias('a')
                    ->select(['a.*', 'b.city_enc_id AS city_id', 'b.name AS city_name', 'c.state_enc_id AS state_id', 'c.name AS state_name'])
                    ->leftJoin(Cities::tableName() . ' as b', 'b.city_enc_id = a.city_enc_id')
                    ->leftJoin(States::tableName() . ' as c', 'c.state_enc_id = b.state_enc_id')
                    ->where(['username' => $attributes['username']])
//                    ->andWhere(['user_type_enc_id' => $user_type->user_type_enc_id])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->one();

            if ($user) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['password'] = $attributes['password'];
                    $utilitiesModel->variables['hash'] = $user['password'];
                    if ($utilitiesModel->verify_pass()) {
                        $response = [
                            'status' => 200,
                            'message' => 'Login successful',
                            'data' => [
                                'user_id' => $user['user_enc_id'],
                                'username' => $user['username'],
                                'email' => $user['email'],
                                'first_name' => $user['first_name'],
                                'last_name' => $user['last_name'],
                                'phone' => $user['phone'],
                                'address' => $user['address'],
                                'state' => [
                                    'id' => $user['state_id'],
                                    'name' => $user['state_name'],
                                ],
                                'city' => [
                                    'id' => $user['city_id'],
                                    'name' => $user['city_name'],
                                ],
//                                'options' => [
//                                    'menu' => [
//                                        'items' => [
//                                            [
//                                                'id' => 2,
//                                                'name' => 'Jobs',
//                                                'visible' => true,
//                                            ],
//                                            [
//                                                'id' => 3,
//                                                'name' => 'Internships',
//                                                'visible' => true,
//                                            ],
//                                            [
//                                                'id' => 4,
//                                                'name' => 'Trainings',
//                                                'visible' => true,
//                                            ],
//                                            [
//                                                'id' => 5,
//                                                'name' => 'Quiz',
//                                                'visible' => false,
//                                            ],
//                                            [
//                                                'id' => 6,
//                                                'name' => 'Question Papers',
//                                                'visible' => false,
//                                            ],
//                                            [
//                                                'id' => 7,
//                                                'name' => 'Notes',
//                                                'visible' => false,
//                                            ],
//                                            [
//                                                'id' => 8,
//                                                'name' => 'Learning Corner',
//                                                'visible' => true,
//                                            ],
//                                        ],
//                                    ],
//                                ],
                            ],
                        ];
                    } else {
                        $response = [
                            'status' => 201,
                            'message' => 'Incorrent username or password',
                        ];
                    }
            } else {
                $response = [
                    'status' => 201,
                    'message' => 'Incorrent username or password',
                ];
            }
        } else {
            $response = [
                'status' => 201,
                'message' => 'Enter username or password',
            ];
        }
        return $response;
    }

    public function actionSignup() {
        $attributes = Yii::$app->request->post();

        $user_type = UserTypes::findOne([
                    'user_type' => 'Individual',
        ]);

        $usersModel = new Users();
        $utilitiesModel = new Utilities();
        $usersModel->username = $attributes['username'];
        $usersModel->email = $attributes['email'];
        $usersModel->first_name = $attributes['first_name'];
        $usersModel->last_name = $attributes['last_name'];
        $usersModel->phone = $attributes['phone'];
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $usersModel->user_enc_id = $utilitiesModel->encrypt();
        $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
        $usersModel->auth_key = Yii::$app->security->generateRandomString();
        $utilitiesModel->variables['password'] = $attributes['password'];
        $usersModel->password = $utilitiesModel->encrypt_pass();
        $usersModel->created_on = date('Y-m-d H:i:s');
        if ($usersModel->validate()) {
            if ($usersModel->save()) {
                $response = [
                    'status' => 200,
                    'message' => 'Signup successful',
                ];
            } else {
                $response = [
                    'status' => 201,
                    'message' => $usersModel->getErrors(),
                ];
            }
        } else {
            $response = [
                'status' => 201,
                'message' => $usersModel->getErrors(),
            ];
        }
        return $response;
    }
    
    public function actionTest() {
        return Yii::$app->request->headers;
    }

}
