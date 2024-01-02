<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Employee;
use common\models\EmployeeIncentivePoints;
use common\models\UserRoles;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use common\models\Utilities;

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
}