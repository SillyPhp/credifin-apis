<?php

namespace frontend\controllers;

use common\models\Organizations;
use frontend\models\EducationalLoans;
use Yii;
use yii\web\Controller;


class EducationLoansController extends Controller
{

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        return $this->render("education-loan-index");
    }
    public function actionApply(){
        $model = new EducationalLoans();
        return $this->render('apply',[
            'EducationalLoan' => $model,
        ]);
    }
    public function actionApplyLoan($id)
    {
        $this->layout = 'blank-layout';
        $wid = Organizations::find()
            ->select(['organization_enc_id'])
            ->where(['organization_enc_id'=>$id])
            ->asArray()->one();
        if ($wid){
            return $this->render('/framed-widgets/education-loan',['wid'=>$wid['organization_enc_id']]);
        }
        else {
            return 'Unauthorized';
        }
    }
    public function actionEducationLoanView(){
        return $this->render('education-loan-view');
    }
    public function actionLoanViewCollege()
    {
        return $this->render('loan-view-college');
    }

    public function actionLoanCollegeIndex(){
        return $this->render('loan-college-index');
    }
}