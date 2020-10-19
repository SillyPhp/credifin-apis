<?php

namespace frontend\controllers;

use frontend\models\onlineClassEnquiries\ClassEnquiryForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\BusinessActivities;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use frontend\models\reviews\RegistrationForm;

class ReviewsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

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

    public function actionSearchOrg($type = null, $query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = explode(",", $type);
        $params1 = (new \yii\db\Query())
            ->select(['name', 'CONCAT(slug, "/reviews") as profile_link', 'CONCAT(slug, "/reviews") as review_link', 'initials_color color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->unclaimedOrganizations->logo) . '",logo_location, "/", logo) END logo', '(CASE
                WHEN business_activity IS NULL THEN ""
                ELSE business_activity
                END) as business_activity'])
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->where("replace(name, '.', '') LIKE '%$query%'");
        if ($type[0] != null) {
            $query1 = $params1->andWhere([
                'or',
                ['in', 'business_activity', $type]
            ])
                ->andWhere(['is_deleted' => 0]);
        } else {
            $query1 = $params1->andWhere(['is_deleted' => 0]);
        }

        $params2 = (new \yii\db\Query())
            ->select(['name', 'slug as profile_link', 'CONCAT(slug, "/reviews") as review_link', 'initials_color color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->organizations->logo) . '",logo_location, "/", logo) END logo', 'business_activity'])
            ->from(Organizations::tableName() . 'as a')
            ->innerJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->where("replace(name, '.', '') LIKE '%$query%'");
        if ($type[0] != null) {
            $query2 = $params2->andWhere([
                'or',
                ['in', 'business_activity', $type]
            ])
                ->andWhere(['is_deleted' => 0]);
        } else {
            $query2 = $params2->andWhere(['is_deleted' => 0]);
        }

        return $query1->union($query2)->all();

    }

    public function actionPostUnclaimedReviews($tempname = null)
    {
        $model = new RegistrationForm();
        $org_type = $model->types();
        if (!empty(Yii::$app->user->identity->organization) || Yii::$app->user->isGuest) {
            $this->layout = 'main-secondary';
            return $this->render('without-login');
        }
        if (Yii::$app->request->isPost) {
            $org_name = Yii::$app->request->post('org_name');
            $website = Yii::$app->request->post('website');
            $org_category = Yii::$app->request->post('org_category');
            $type = Yii::$app->request->post('type');
            $response = $model->saveVal($org_name, $website, $org_category);
            if ($response['status'] == 200) {
                if ($type == 'company') {
                    if ($model->postReviews($response['org_id'])) {
                        return $this->redirect('/' . $response['slug'] . '/reviews');
                    }
                } else if ($type == 'college') {
                    if ($model->postCollegeReviews($response['org_id'])) {
                        return $this->redirect('/' . $response['slug'] . '/reviews');
                    }
                } else if ($type == 'school') {
                    if ($model->postSchoolReviews($response['org_id'])) {
                        return $this->redirect('/' . $response['slug'] . '/reviews');
                    }
                } else if ($type == 'institute') {
                    if ($model->postInstituteReviews($response['org_id'])) {
                        return $this->redirect('/' . $response['slug'] . '/reviews');
                    }
                }
            } else {
                return false;
            }

        }
        return $this->render('unclaimed-reviews', ['name' => $tempname, 'model' => $model, 'type' => $org_type]);
    }

    public function actionSchools()
    {
        $model = new ClassEnquiryForm();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->save();
        }
        return $this->render('schools',[
            'model' => $model,
        ]);
    }

    public function actionCompanies()
    {
        return $this->render('companies');
    }

    public function actionColleges()
    {
        $model = new ClassEnquiryForm();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->save();
        }
        return $this->render('colleges',[
            'model' => $model,
        ]);
    }

    public function actionInstitutes()
    {
        return $this->render('educational-institutes');
    }
}