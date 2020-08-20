<?php

namespace frontend\controllers;

use common\models\BusinessActivities;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use frontend\models\EducationalLoans;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;


class EducationLoansController extends Controller
{
    public function actionIndex(){
        return $this->render("education-loan-index");
    }
    public function actionApply(){
        $type = ['College','School','Educational Institute'];
        $params1 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as name','a.organization_enc_id','b.business_activity'])
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['in', 'business_activity', $type]);

        $params2 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as name','a.organization_enc_id','b.business_activity'])
            ->from(Organizations::tableName() . 'as a')
            ->innerJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['in', 'business_activity', $type]);

        $data_collection = $params1->union($params2)->all();
        return $this->render('apply-general-loan-form',['data_collection'=>$data_collection]);
    }
    public function actionApplyLoan($id)
    { 
        $this->layout = 'widget-layout';
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