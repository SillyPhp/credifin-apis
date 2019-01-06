<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\Organizations;
use frontend\models\CompanyLogoForm;
use frontend\models\CompanyCoverImageForm;
use frontend\models\AddEmployeeBenefitForm;
use frontend\models\OrganizationVideoForm;
use common\models\OrganizationVideos;
use common\models\OrganizationLocations;
use common\models\States;
use common\models\Cities;
use common\models\Countries;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\ApplicationOptions;
use common\models\ShortlistedOrganizations;

class CompaniesController extends Controller {

    public function actionDetail($cpidk) {
        $organization = Organizations::find()
                ->where(['slug' => $cpidk, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();

        if ($organization) {
            $organizationLocations = OrganizationLocations::find()
                    ->alias('a')
                    ->select(['a.*', 'b.name as city', 'c.name as state', 'd.name as country'])
                    ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
                    ->innerJoin(States::tableName() . 'as c', 'c.state_enc_id = b.state_enc_id')
                    ->innerJoin(Countries::tableName() . 'as d', 'd.country_enc_id = c.country_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.status' => 'Active', 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();

            $organizationVideos = OrganizationVideos::find()
                    ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                    ->asArray()
                    ->all();
            $jobcards = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', 'f.location_enc_id', 'h.name as city', 'd.organization_enc_id', 'a.created_on', 'a.slug', 'a.experience', 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location', 'e.option_name', 'e.value as salary'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                    ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as f', 'f.application_enc_id = a.application_enc_id')
                    ->innerJoin(OrganizationLocations::tablename() . 'as g', 'f.location_enc_id = g.location_enc_id')
                    ->leftJoin(ApplicationOptions::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id')
                    ->leftJoin(Cities::tableName() . 'as h', 'h.city_enc_id = g.city_enc_id')
                    ->where(['e.option_name' => 'salary'])
                    ->andWhere(['a.organization_enc_id' => $organization['organization_enc_id']])
                    ->orderBy(['a.id' => SORT_DESC])
                    ->limit(3)
                    ->asArray()
                    ->all();

            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->organization_enc_id == $organization['organization_enc_id']) {
                $industries = \common\models\Industries::find()
                        ->select(['industry_enc_id value', 'industry text'])
                        ->orderBy(['industry' => SORT_ASC])
                        ->asArray()
                        ->all();

                $companyLogoFormModel = new CompanyLogoForm();
                $companyCoverImageForm = new CompanyCoverImageForm();
                $addEmployeeBenefitForm = new AddEmployeeBenefitForm();
                return $this->render('editable', [
                            'organization' => $organization,
                            'locations' => $organizationLocations,
                            'videos' => $organizationVideos,
                            'companyLogoFormModel' => $companyLogoFormModel,
                            'companyCoverImageForm' => $companyCoverImageForm,
                            'addEmployeeBenefitForm' => $addEmployeeBenefitForm,
                            'jobcards' => $jobcards,
                            'industries' => $industries,
                ]);
            } else {
                $chkuser = ShortlistedOrganizations::find()
                        ->select('shortlisted')
                        ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $organization['organization_enc_id']])
                        ->asArray()
                        ->one();
                return $this->render('detail', [
                            'organization' => $organization,
                            'locations' => $organizationLocations,
                            'videos' => $organizationVideos,
                            'jobcards' => $jobcards,
                            'shortlist' => $chkuser,
                ]);
            }
        } else {
            
        }
    }

    public function actionUpdateLogo() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $companyLogoFormModel = new CompanyLogoForm();
        if (Yii::$app->request->post()) {
            $companyLogoFormModel->logo = UploadedFile::getInstance($companyLogoFormModel, 'logo');

            if ($companyLogoFormModel->save()) {

                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Logo has been changed.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionUpdateCoverImage() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $companyCoverImageForm = new CompanyCoverImageForm();
        if (Yii::$app->request->post()) {
            $companyCoverImageForm->image = UploadedFile::getInstance($companyCoverImageForm, 'image');
            if ($companyCoverImageForm->save()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Cover image has been changed.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionUpdateEditedCompanyProfile() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->post()) {
            $organisationData = Yii::$app->request->post();
//            return $organisationData['name'];
            $organisationModel = new Organizations();
            $organisation = $organisationModel->findOne([
                'organization_enc_id' => Yii::$app->organisation->identity->organization_enc_id,
                'status' => 'Active',
                'is_deleted' => 0,
            ]);
            $field = $organisationData['name'];
            $organisation->$field = $organisationData['value'];
            if ($organisationModel->validate()) {
                if ($organisationModel->save()) {
                    $response = [
                        'status' => 200,
                        'message' => Yii::t('frontend', 'You are successfully subscribed.'),
                    ];
                } else {
                    $response = [
                        'status' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.'),
                    ];
                }
            } else {
                $response = [
                    'status' => 0,
                    'message' => Yii::t('frontend', 'Please enter all the information correctly'),
                ];
            }
            return $response;
        }
    }

    public function actionUpdateProfile() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->post()) {
            $organizationData = Yii::$app->request->post();
            $organization = Organizations::findOne([
                        'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                        'status' => 'Active',
                        'is_deleted' => 0,
            ]);
            $field = $organizationData['name'];
            $organization->$field = $organizationData['value'];
            if ($organization->validate()) {
                if ($organization->save()) {
                    $response = [
                        'status' => 200,
                        'message' => Yii::t('frontend', 'You are successfully subscribed.'),
                    ];
                    return true;
                } else {
                    $response = [
                        'status' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.'),
                    ];
                    return false;
                }
            } else {
                $response = [
                    'status' => 0,
                    'message' => Yii::t('frontend', 'Please enter all the information correctly'),
                ];
            }
            return $response;
        }
    }

    public function actionVideoDelete() {
        Yii::$app->response->format = Response::FORMAT_JSON;

//        $organizationVideos = OrganizationVideos::find()
//        ->where([video_enc_id => 'eU5GY2ZqNTQrbW5RcDV3VWV0UitmQT09' , 'is_deleted' => 0])
//                ->asArray()
//                ->all();
//        print_r($organizationVideos);
//        exit();
        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
                ->update(OrganizationVideos::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['video_enc_id' => $id])
                ->execute();
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Video has been Deleted.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionLocationDelete() {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $organizationLocations = OrganizationLocations::find()
//        ->where([location_enc_id => 'eU5GY2ZqNTQrbW5RcDV3VWV0UitmQT09' , 'is_deleted' => 0])
//                ->asArray()
//                ->all();
//        print_r($organizationLocations);
//        exit();
        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
                ->update(OrganizationLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['location_enc_id' => $id])
                ->execute();
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Location has been Removed.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionRemoveImage() {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $organization = Organizations::find()
//                ->where(['slug' => $cpidk, 'status' => 'Active', 'is_deleted' => 0])
//                ->asArray()
//                ->all();
//        print_r($organization);
//        exit();
        $type = Yii::$app->request->post('type');
        if($type == 'logo'){
            $update = Yii::$app->db->createCommand()
                ->update(Organizations::tableName(), ['logo' => null, 'logo_location' => null, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->execute();
        }
        elseif($type == 'cover'){
            $update = Yii::$app->db->createCommand()
                ->update(Organizations::tableName(), ['cover_image' => null, 'cover_image_location' => null, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->execute();
        }
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Image has been Removed.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionCompanyAlert() {
        $companyAlertForm = new \frontend\models\CompanyAlertForm();
        return $this->renderAjax('companyalert', ['companyAlertForm' => $companyAlertForm]);
    }
    
    public function actionJobsAjax() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $companycards = Organizations::find()
                    ->select(['name', 'CONCAT("' . Url::to('/company/') . '", slug) link', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END logo'])
                    ->where(['is_sponsored' => 1])
                    ->limit(10)
                    ->asArray()
                    ->all();

            if ($companycards) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'companycards' => $companycards
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionAddVideo() {
        $organizationVideoForm = new OrganizationVideoForm();
        if ($organizationVideoForm->load(Yii::$app->request->post())) {
            $organizationVideoForm->link = $this->getYouTubeID($organizationVideoForm->link);
            if ($organizationVideoForm->add()) {
                return true;
            } else {
                return false;
            }
        }
        return $this->renderAjax('add-video', [
            'organizationVideoForm' => $organizationVideoForm,
        ]);
    }

    private function getYouTubeID($URL) {
        $YouTubeCheck = preg_match('![?&]{1}v=([^&]+)!', $URL . '&', $Data);
        If ($YouTubeCheck) {
            $VideoID = $Data[1];
        }
        return $VideoID;
    }

}
