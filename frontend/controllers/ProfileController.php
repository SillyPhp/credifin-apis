<?php

namespace frontend\controllers;

use common\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use common\models\Usernames;

class ProfileController extends Controller
{

    public function actionIndex($username, $type = null, $slug = null)
    {
        $user = Usernames::find()
            ->where(['username' => $username])
            ->andWhere(['!=', 'assigned_to', 0])
            ->one();

        if (!$user) {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }

        if ($user->assigned_to === 1) {
            if (empty($type)) {
                return Yii::$app->runAction('users/profile', [
                    'username' => $user->username
                ]);
            }

            if (isset($type) && !empty($type) && $type === 'edit') {
                return Yii::$app->runAction('users/edit');
            } else {
                throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
            }
        }

        if ($user->assigned_to === 2 || $user->assigned_to === 3) {
            if (isset($type) && !empty($type)) {
                if ($type === 'careers' || $type === "jobs" || $type === "internships") {
                    return Yii::$app->runAction('organizations/careers/index', [
                        'slug' => $user->username,
                    ]);
                }

                if ($type === 'job' || $type === 'internship' && isset($slug) && !empty($slug)) {
                    return Yii::$app->runAction('organizations/careers/detail', [
                        'username' => $user->username,
                        'type' => $type,
                        'slug' => $slug,
                    ]);
                }

                if ($type === 'reviews' || $type === 'loans') {
                    return Yii::$app->runAction('organizations/detail', [
                        'slug' => $user->username,
                        'type' => $type
                    ]);
                }
            } else {
                return Yii::$app->runAction('organizations/detail', [
                    'slug' => $user->username
                ]);
            }

            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
    }

    public function actionUpdateProfile(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $param = Yii::$app->request->post();
            if(!Yii::$app->user->isGuest){
                $users = Users::findOne(['user_enc_id' => !Yii::$app->user->identity->user_enc_id]);
                if($users){
                    if($param['field_name'] == 'skills'){

                    }else if($param['field_name'] == 'languages'){

                    }
                    if($param['field_name'] == 'dob'){
                        $users->$param['field_name'] = date('Y-m-d', strtotime($param['value']));
                    }else{
                        $users->$param['field_name'] = $param['value'];
                    }
                    $users->last_updated_on = date('Y-m-d H:i:s');
                    if(!$users->update()){
                        print_r($users->getErrors);
                        die();
                    }
                }
            }

        }
    }
}