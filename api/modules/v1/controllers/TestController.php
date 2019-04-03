<?php

namespace api\modules\v1\controllers;

use yii\web\Response;
use api\modules\v1\models\Candidates;
use api\modules\v1\models\Clients;
use api\modules\v1\models\JobApply;
use common\models\UserAccessTokens;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\ApplicationOptions;
use common\models\Cities;
use common\models\Designations;
use common\models\Industries;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\JobApplied;

class TestController extends ApiBaseController {

    public function behaviors(){
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBearerAuth::className()
//        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index' => ['POST'],
                'job-card' => ['GET'],
            ]
        ];
        return $behaviors;

    }

    public function actionIndex(){
        return 1;
    }
}
