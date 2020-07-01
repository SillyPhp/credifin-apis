<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use common\models\AssignedCategories;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\Organizations;
use common\models\UserOtherDetails;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class LoansController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        $behaviors['authenticator'] = [
//            'except' => [
//                'home-list'
//            ],
//            'class' => HttpBearerAuth::className()
//        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'home-list' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionSaveApplicants()
    {
        if ($user = $this->isAuthorized()) {
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
//                return $model->add($user->user_enc_id);
                if ($model->add($user->user_enc_id) == true) {
                    return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully..']);
                }
                return $this->response(201, ['status' => 201, 'message' => 'Something went wrong...']);
            }
            return $this->response(201, ['status' => 201, 'message' => 'Modal values not loaded..']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

}