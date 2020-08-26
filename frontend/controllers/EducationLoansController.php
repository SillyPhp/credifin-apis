<?php

namespace frontend\controllers;

use common\models\AssignedCollegeCourses;
use common\models\BusinessActivities;
use common\models\Countries;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use frontend\models\EducationalLoans;
use Yii;
use yii\helpers\Url;
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

    public function actionIndex()
    {
        $loan_org = Organizations::find()
            ->select(['organization_enc_id', 'name', 'logo', 'logo_location', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END org_logo', 'initials_color'])
            ->where(['is_deleted' => 0, 'has_loan_featured' => 1, 'status' => 'Active'])
            ->asArray()
            ->all();
        return $this->render("education-loan-index", [
            'loan_org' => $loan_org,
        ]);
    }

    public function actionApply()
    {
        $type = ['College', 'School', 'Educational Institute'];
        $india = Countries::findOne(['name' => 'India'])->country_enc_id;
        $params1 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as name', 'a.organization_enc_id', 'b.business_activity'])
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['in', 'business_activity', $type]);

        $params2 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as name', 'a.organization_enc_id', 'b.business_activity'])
            ->from(Organizations::tableName() . 'as a')
            ->innerJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['in', 'business_activity', $type]);

        $data_collection = $params1->union($params2)->all();
        return $this->render('apply-general-loan-form', [
            'data_collection' => $data_collection,
            'india' => $india
        ]);
    }

    public function actionApplyLoan($id)
    {
        $this->layout = 'widget-layout';
        $wid = Organizations::find()
            ->select(['organization_enc_id', 'name'])
            ->where(['organization_enc_id' => $id])
            ->asArray()->one();
        if ($wid) {
            return $this->render('/framed-widgets/education-loan', ['wid' => $wid['organization_enc_id'], 'title' => $wid['name']]);
        } else {
            return 'Unauthorized';
        }
    }

    public function actionEducationLoanView()
    {
        return $this->render('education-loan-view');
    }

    public function actionLoanViewCollege()
    {
        return $this->render('loan-view-college');
    }

    public function actionLoanCollegeIndex()
    {
        return $this->render('loan-college-index');
    }
}