<?php

namespace api\modules\v4\controllers;

use common\models\Cities;
use common\models\Designations;
use common\models\OrganizationTypes;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use common\models\Utilities;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['GET', 'POST','OPTIONS'],
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

 public function actionIndex(){
    if($this->isAuthorized()){
        $params = Yii::$app->request->post();
        print_r($params['name']);
        die();
    return $this->response(200,['status'=>200,'message'=>'success']);
    }
    else
    return $this->response(401,['status'=>401,'message'=>'unauthorised']);
 }

}