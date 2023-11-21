<?php

namespace frontend\controllers;
use common\models\Categories;
use common\models\CreditLoanApplicationReports;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanCoApplicants;
use common\models\OpenTitles;
use common\models\User;
use common\models\Usernames;
use common\models\UserTypes;
use frontend\models\applications\Careerjet_API;
use common\models\AppliedApplications;
use common\models\Auth;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\Posts;
use common\models\SkillsUpPostAssignedBlogs;
use common\models\Users;
use common\models\EmiCollection;
use common\models\RandomColors;
use common\models\Utilities;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionSql(){
        $sql = "CALL GetUserHierarchy('3wVg50vYNo82LkxexgW6QBGKXJmWpO')";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        print_r($data);exit();
    }
}
