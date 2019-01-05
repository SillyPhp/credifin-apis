<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\Controller;
use common\models\Users;

class UserController extends Controller {

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
                    'update-profile' => ['POST'],
                    'change-profile-image' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionUpdateProfile() {
        $attributes = Yii::$app->request->post();

        if (!empty($attributes)) {
            $user = Users::findOne([
                        'user_enc_id' => $attributes['user_id'],
            ]);

            if ($user) {
                $user->address = $attributes['address'];
                $user->city_enc_id = $attributes['city_id'];
                $user->facebook = $attributes['facebook'];
                $user->twitter = $attributes['twitter'];
                $user->linkedin = $attributes['linkedin'];
                $user->google = $attributes['google_plus'];
                $user->youtube = $attributes['youtube'];
                $user->skype = $attributes['skype'];
                $user->instagram = $attributes['instagram'];
//                $user->website = $attributes['website'];
                $user->description = $attributes['description'];
                if ($user->validate() && $user->save()) {
                    $response = [
                        'status' => 200,
                        'message' => 'Profile successfully updated.',
                    ];
                } else {
                    $response = [
                        'status' => 201,
                        'message' => $user->getErrors(),
                    ];
                }
            } else {
                $response = [
                    'status' => 202,
                    'message' => 'Invalid user details.',
                ];
            }
        } else {
            $response = [
                'status' => 202,
                'message' => 'Provide user details.',
            ];
        }

        return $response;
    }

    public function actionChangeProfilePicture() {
        $attributes = Yii::$app->request->post();
//        return [
//            'image' => $attributes['image'],
//        ];
        $base = $attributes['image'];
        $filename = $attributes['filename'];
        if ($this->saveImage($base, $filename)) {
            return [
                'status' => 200,
                'message' => 'Image uploaded successfully.',
            ];
        } else {
            return [
                'status' => 201,
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    private function saveImage($base, $filename) {
        $binary = base64_decode($base);
        $headers = Yii::$app->request->headers;
        $base_path = Yii::$app->params->upload_directories->images->image_path;
        $headers->set('Content-Type', 'bitmap; charset=utf-8');
        if (!is_dir($base_path)) {
            if (!mkdir($base_path, 0755, true)) {
                return false;
            }
        }

        if (!$file = fopen($base_path . DIRECTORY_SEPARATOR . $filename, 'wb')) {
            return false;
        }
        if (!fwrite($file, $binary)) {
            return false;
        }

        if (!fclose($file)) {
            return false;
        }

        return true;
    }

}
