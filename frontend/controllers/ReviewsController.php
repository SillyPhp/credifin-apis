<?php

namespace frontend\controllers;

use common\models\BusinessActivities;
use common\models\Organizations;
use common\models\OrganizationTypes;
use common\models\UnclaimedOrganizations;
use frontend\models\reviews\RegistrationForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class ReviewsController extends Controller
{
    public function actionIndex()
    {
        $model = new RegistrationForm();
        $org_type = $model->types();
        if ($model->load(Yii::$app->request->post())) {
            $response = $model->saveVal();
            if ($response['status'] == 200) {
                return $this->redirect($response['slug'] . '/reviews');
            } else {
                return false;
            }
        }
        return $this->render('index', ['model' => $model, 'type' => $org_type]);
    }

    public function actionSearch($keywords)
    {
        $business_activity = BusinessActivities::find()
            ->select(['business_activity_enc_id', 'business_activity'])
            ->asArray()
            ->all();

        return $this->render('filter-companies', ['keywords' => $keywords, 'business_activity' => $business_activity]);
    }

    public function actionSearchOrg($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query1 = (new \yii\db\Query())
            ->select(['name','slug','initials_color color','logo','(CASE
                WHEN business_activity IS NULL THEN ""
                ELSE business_activity
                END) as business_activity'])
            ->from(UnclaimedOrganizations::tableName().'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->where('name LIKE "%' . $query . '%"')
            ->andWhere(['status'=>1]);

        $query2 = (new \yii\db\Query())
            ->select(['name','slug','initials_color color','CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",logo_location, "/", logo) END logo','business_activity'])
            ->from(Organizations::tableName().'as a')
            ->innerJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->where('name LIKE "%' . $query . '%"')
            ->andWhere(['is_deleted'=>0]);

        return $query1->union($query2)->all();

    }
    public function actionPostUnclaimedReviews($tempname=null)
    {
        $model = new RegistrationForm();
        $org_type = $model->types();
        if (!empty(Yii::$app->user->identity->organization)||Yii::$app->user->isGuest)
        {
            return 'You are not authorized to access this page as Your are not login as User';
        }
        if (Yii::$app->request->isPost)
        {
            $org_name = Yii::$app->request->post('org_name');
            $website = Yii::$app->request->post('website');
            $org_category = Yii::$app->request->post('org_category');
            $type = Yii::$app->request->post('type');
            $response = $model->saveVal($org_name, $website, $org_category);
            if ($response['status'] == 200) {
                if ($type=='company') {
                    if ($model->postReviews($response['org_id'])) {
                        return $this->redirect('/' . $response['slug'] . '/reviews');
                    }
                }
                else if($type=='college'){
                    if ($model->postCollegeReviews($response['org_id'])) {
                        return $this->redirect('/' . $response['slug'] . '/reviews');
                    }
                }
              else if ($type=='school')
              {
                  if ($model->postSchoolReviews($response['org_id'])) {
                      return $this->redirect('/' . $response['slug'] . '/reviews');
                  }
              }
              else if ($type=='institute')
              {
                  if ($model->postInstituteReviews($response['org_id'])) {
                      return $this->redirect('/' . $response['slug'] . '/reviews');
                  }
              }
            }
            else
            {
                return false;
            }

        }
        return $this->render('unclaimed-reviews',['name'=>$tempname,'model'=>$model,'type'=>$org_type]);
    }

}

