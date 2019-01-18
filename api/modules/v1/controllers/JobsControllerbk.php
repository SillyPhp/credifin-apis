<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
//use yii\web\Controller;
use yii\rest\ActiveController;
//use common\models\EmployerApplications;
//use common\models\ApplicationTypes;
//use common\models\ApplicationOptions;
//use common\models\ApplicationPlacementLocations;
//use common\models\Organizations;
//use common\models\OrganizationLocations;
//use common\models\Categories;
//use common\models\AssignedCategories;
//use common\models\Cities;

class JobsControllerbk extends ActiveController {
    

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
                    'index' => ['GET'],
                ],
            ],
        ];
    }
    
    public $modelClass = 'api\modules\v1\models\Jobs';

//    public function actions() {
//        $actions = parent::actions();
//        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
//        return $actions;
//    }
    
//    public function actionIndex(){
//        $jobs = new \api\modules\v1\models\Jobs();
//        return $jobs->getJobs();
//    }

    public function actionJobCard() {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $application_id = Yii::$app->request->get('application');
        $details = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name category', 'CONCAT("'.Url::to('@commonAssets/categories/').'", d.icon) icon', 'e.name', 'CASE WHEN e.logo IS NOT NULL THEN CONCAT("http://www.eygb.co/", "'.Url::to(Yii::$app->params->upload_directories->organizations->logo, false) .'", e.logo_location, "/", e.logo) ELSE CONCAT("https://ui-avatars.com/api/?", "size=200&rounded=false&color=000000&name=", e.name) END logo'])
                ->innerJoin(AssignedCategories::tableName() . ' b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . ' c', 'b.category_enc_id = c.category_enc_id')
                ->innerJoin(Categories::tableName() . ' d', 'd.category_enc_id = b.parent_enc_id')
                ->innerJoin(Organizations::tableName() . ' e', 'e.organization_enc_id = a.organization_enc_id')
                ->where(['a.application_enc_id' => $application_id, 'e.is_deleted' => 0])
                ->asArray()
                ->one();
        
        if($details && !empty(Yii::$app->request->post('image'))) {
            $data = $_POST['photo'];
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/photos");
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/photos/".time().'.png', $data);
    die;  
        }
        if ($details) {
            return $this->renderPartial('og-image', [
                    'details' => $details,
            ]);
        }
    }

}
