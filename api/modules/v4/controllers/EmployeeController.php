<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Employee;
use common\models\UserAccessTokens;
use common\models\Users;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class EmployeeController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'update-profile' => ['POST', 'OPTIONS'],
                'list-users' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionUpdateProfile(){
        if ($user = $this->isAuthorized()){
            $model = new Employee();
            $model->load(Yii::$app->getRequest()->getBodyParams());
            $res = $model->update($user['user_enc_id']);
            if ($res['status']){
                return $this->response(200, ['status' => 200, 'message' => 'Successfully Updated']);
            }else{
                return $this->response(201, ['status' => 201, 'message' => $res['error']]);
            }
        }else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionListUsers(){
        if ($user = $this->isAuthorized()){
        }else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionResetPassword()
    {
        $params = Yii::$app->request->post();

        if (empty($params['user_enc_id']) || empty($params['new_password'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing user_enc_id or new_password']);
        }

        $user_enc_id = $params['user_enc_id'];
        $new_password = $params['new_password'];

        $user = Users::findOne(['user_enc_id' => $user_enc_id, 'is_deleted' => 0]);

        if ($user != null) {
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($new_password);
            $user->is_email_verified = 1;
            $user->update();

            UserAccessTokens::updateAll(
                [
                    'is_deleted' => 1,
                    'last_updated_on' => date('Y-m-d H:i:s')
                ],
                ['and',
                    ['user_enc_id' => $user_enc_id],
                    ['is_deleted' => 0]
                ]
            );

            return $this->response(200, ['status' => 200, 'message' => 'Password changed successfully']);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'User not found']);
        }
    }

}