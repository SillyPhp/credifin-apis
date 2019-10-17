<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use common\models\Usernames;

class ProfileController extends Controller
{

    public function actionIndex($username, $type = '')
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
                    'username' => $user->username,
                ]);
            }

            if (isset($type) && !empty($type) && $type === 'edit') {
                return Yii::$app->runAction('users/edit');
            } else {
                throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
            }
        }

        if ($user->assigned_to === 2 || $user->assigned_to === 3) {
            if (empty($type) && $user->assigned_to === 2) {
                return Yii::$app->runAction('organizations/profile', [
                    'slug' => $user->username,
                ]);
            }

            if (isset($type) && !empty($type) && $type === 'reviews') {
                return Yii::$app->runAction('organizations/reviews', [
                    'slug' => $user->username,
                ]);
            }

            if (isset($type) && !empty($type) && $type === 'careers') {
                return Yii::$app->runAction('organizations/careers/index', [
                    'slug' => $user->username,
                ]);
            }

            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
    }

}