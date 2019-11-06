<?php


namespace api\modules\v2\controllers;

use common\models\ErexxCollaborators;
use common\models\UserOtherDetails;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class CollegeIndexController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'counts' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionCounts(){
        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();
            $company_count = ErexxCollaborators::find()
                ->select(['count(college_enc_id) company_count'])
                ->where(['college_enc_id'=>$req['college_id'],'organization_approvel'=>1,'college_approvel'=>1,'is_deleted'=>0])
                ->asArray()
                ->all();

            $candidate_count = UserOtherDetails::find()
                ->select(['count(organization_enc_id) candidate_count'])
                ->where(['organization_enc_id'=>$req['college_id']])
                ->asArray()
                ->all();

            $companies = ErexxCollaborators::find()
                ->alias('a')
                ->select([])
                ->joinWith(['organizationEnc b'=>function($b){

                }])
                ->where(['a.college_enc_id'=>$req['college_id'],'a.organization_approvel'=>1,'a.college_approvel'=>1,'a.is_deleted'=>0])
                ->asArray()
                ->all();


        }
    }
}