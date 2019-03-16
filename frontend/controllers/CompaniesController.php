<?php

namespace frontend\controllers;

use common\models\FollowedOrganizations;
use common\models\OrganizationEmployeeBenefits;
use frontend\models\CompanyImagesForm;
use frontend\models\OrganizationEmployeesForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\Utilities;
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
use common\models\EmployeeBenefits;
use frontend\models\applications\ApplicationCards;

class CompaniesController extends Controller
{

    public function actionDetail($cpidk)
    {
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
//            $jobcards = EmployerApplications::find()
//                    ->alias('a')
//                    ->select(['a.application_enc_id', 'f.location_enc_id', 'h.name as city', 'd.organization_enc_id', 'a.created_on', 'a.slug', 'a.experience', 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location', 'e.option_name', 'e.value as salary'])
//                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
//                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
//                    ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
//                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as f', 'f.application_enc_id = a.application_enc_id')
//                    ->innerJoin(OrganizationLocations::tablename() . 'as g', 'f.location_enc_id = g.location_enc_id')
//                    ->leftJoin(ApplicationOptions::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id')
//                    ->leftJoin(Cities::tableName() . 'as h', 'h.city_enc_id = g.city_enc_id')
//                    ->where(['e.option_name' => 'salary'])
//                    ->andWhere(['a.organization_enc_id' => $organization['organization_enc_id']])
//                    ->orderBy(['a.id' => SORT_DESC])
//                    ->limit(3)
//                    ->asArray()
//                    ->all();
            $benefit = OrganizationEmployeeBenefits::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.organization_benefit_enc_id', 'b.benefit', 'b.icon'])
                ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
                ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();
            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $type = Yii::$app->request->post('type');
                $options = [];
                $options['limit'] = 3;
                $options['page'] = 1;
                $options['company'] = $organization['name'];
                if ($type == 'Jobs') {
                    $cards = ApplicationCards::jobs($options);
                } else {
                    $cards = ApplicationCards::internships($options);
                }
                if ($cards) {
                    $response = [
                        'status' => 200,
                        'message' => 'Success',
                        'cards' => $cards,
                    ];
                } else {
                    $response = [
                        'status' => 201,
                    ];
                }
                return $response;
            }

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
//                            'jobcards' => $jobcards,
                    'industries' => $industries,
                    'benefit' => $benefit,
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
//                            'jobcards' => $jobcards,
                    'shortlist' => $chkuser,
                    'benefit' => $benefit,
                ]);
            }
        } else {

        }
    }

    public function actionProfile()
    {
        $organization = Organizations::find()
            ->where(['slug' => 'ajayjuneja', 'status' => 'Active', 'is_deleted' => 0])
            ->asArray()
            ->one();
        if ($organization) {
            $benefit = OrganizationEmployeeBenefits::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.organization_benefit_enc_id', 'b.benefit', 'b.icon', 'b.icon_location'])
                ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
                ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();
            $gallery = \common\models\OrganizationImages::find()
                ->select(['image', 'image_location', 'image_enc_id'])
                ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                ->asArray()
                ->all();
            $our_team = \common\models\OrganizationEmployees::find()
                ->select(['first_name', 'last_name', 'image', 'image_location', 'designation', 'facebook', 'twitter', 'linkedin', 'employee_enc_id'])
                ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                ->asArray()
                ->all();
            $count_opportunities = \common\models\EmployerApplications::find()
                ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                ->count();

            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $organizationLocations = OrganizationLocations::find()
                    ->alias('a')
                    ->select(['location_enc_id', 'a.location_name', 'a.address', 'a.postal_code', 'a.latitude', 'a.longitude', 'b.name as city', 'c.name as state', 'd.name as country'])
                    ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
                    ->innerJoin(States::tableName() . 'as c', 'c.state_enc_id = b.state_enc_id')
                    ->innerJoin(Countries::tableName() . 'as d', 'd.country_enc_id = c.country_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.status' => 'Active', 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();

                if ($organizationLocations) {
                    $response = [
                        'status' => 200,
                        'message' => 'Success',
                        'locations' => $organizationLocations,
                        'org' => $organization,
                    ];
                } else {
                    $response = [
                        'status' => 201,
                    ];
                }
                return $response;
            }
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->organization_enc_id == $organization['organization_enc_id']) {
                $industries = \common\models\Industries::find()
                    ->select(['industry_enc_id value', 'industry text'])
                    ->orderBy(['industry' => SORT_ASC])
                    ->asArray()
                    ->all();

                $companyLogoFormModel = new CompanyLogoForm();
                $companyCoverImageForm = new CompanyCoverImageForm();
                return $this->render('edit', [
                    'organization' => $organization,
                    'companyLogoFormModel' => $companyLogoFormModel,
                    'companyCoverImageForm' => $companyCoverImageForm,
                    'industries' => $industries,
                    'benefit' => $benefit,
                    'gallery' => $gallery,
                    'our_team' => $our_team,
                    'count_opportunities' => $count_opportunities,
                ]);
            } else {

                $follow = FollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $organization['organization_enc_id']])
                    ->asArray()
                    ->one();
                $industry = \common\models\Industries::find()
                    ->select(['industry'])
                    ->where(['industry_enc_id' => $organization['industry_enc_id']])
                    ->asArray()
                    ->one();

                return $this->render('profile', [
                    'organization' => $organization,
                    'follow' => $follow,
                    'benefit' => $benefit,
                    'gallery' => $gallery,
                    'our_team' => $our_team,
                    'industry' => $industry,
                    'count_opportunities' => $count_opportunities,
                ]);
            }
        } else {

        }
    }

    public function actionEdit()
    {
        $organization = Organizations::find()
            ->where(['slug' => 'ajayjuneja', 'status' => 'Active', 'is_deleted' => 0])
            ->asArray()
            ->one();
        if ($organization) {

            $benefit = OrganizationEmployeeBenefits::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.organization_benefit_enc_id', 'b.benefit', 'b.icon', 'b.icon_location'])
                ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
                ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();
            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $organizationLocations = OrganizationLocations::find()
                    ->alias('a')
                    ->select(['a.location_name', 'a.address', 'a.postal_code', 'a.latitude', 'a.longitude', 'b.name as city', 'c.name as state', 'd.name as country'])
                    ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
                    ->innerJoin(States::tableName() . 'as c', 'c.state_enc_id = b.state_enc_id')
                    ->innerJoin(Countries::tableName() . 'as d', 'd.country_enc_id = c.country_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.status' => 'Active', 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();

                if ($organizationLocations) {
                    $response = [
                        'status' => 200,
                        'message' => 'Success',
                        'locations' => $organizationLocations,
                    ];
                } else {
                    $response = [
                        'status' => 201,
                    ];
                }
                return $response;
            }

            return $this->render('edit', [
                'organization' => $organization,
                'benefit' => $benefit,
            ]);
        } else {

        }
    }

    public function actionUpdateLogo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $companyLogoFormModel = new CompanyLogoForm();
        if (Yii::$app->request->post()) {
            $image = Yii::$app->request->post('data');

            if ($companyLogoFormModel->save($image)) {

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

    public function actionUpdateCoverImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $companyCoverImageForm = new CompanyCoverImageForm();
        if (Yii::$app->request->post()) {
            $c_image = Yii::$app->request->post('data');
//            $companyCoverImageForm->image = UploadedFile::getInstance($companyCoverImageForm, 'image');

            if ($companyCoverImageForm->save($c_image)) {
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

    public function actionUpdateEditedCompanyProfile()
    {
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

    public function actionUpdateProfile()
    {
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

    public function actionVideoDelete()
    {
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

    public function actionLocationDelete()
    {
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

    public function actionRemoveImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $organization = Organizations::find()
//                ->where(['slug' => $cpidk, 'status' => 'Active', 'is_deleted' => 0])
//                ->asArray()
//                ->all();
//        print_r($organization);
//        exit();
        $type = Yii::$app->request->post('type');
        if ($type == 'logo') {
            $update = Yii::$app->db->createCommand()
                ->update(Organizations::tableName(), ['logo' => null, 'logo_location' => null, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->execute();
        } elseif ($type == 'cover') {
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

    public function actionCompanyAlert()
    {
        $companyAlertForm = new \frontend\models\CompanyAlertForm();
        return $this->renderAjax('companyalert', ['companyAlertForm' => $companyAlertForm]);
    }

    public function actionJobsAjax()
    {
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

    public function actionAddVideo()
    {
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

    public function actionAddBenefit()
    {
        $benefits = \common\models\EmployeeBenefits::find()
            ->asArray()
            ->all();
        $addEmployeeBenefitForm = new AddEmployeeBenefitForm();
        return $this->renderAjax('add-benefit', [
            'addEmployeeBenefitForm' => $addEmployeeBenefitForm,
            'benefits' => $benefits,
        ]);
    }

    public function actionSubmitBenefit()
    {
        $addEmployeeBenefitForm = new AddEmployeeBenefitForm();
        if ($addEmployeeBenefitForm->load(Yii::$app->request->post())) {
//            return json_encode($addEmployeeBenefitForm->save());
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($addEmployeeBenefitForm->save()) {
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
    }

    public function actionRemoveBenefit()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('type');
            $update = Yii::$app->db->createCommand()
                ->update(OrganizationEmployeeBenefits::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_benefit_enc_id' => $id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
                ->execute();
            if ($update) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Employee Benefit has been Removed.',
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

    public function actionAddGalleryImages()
    {
        if (Yii::$app->request->isAjax) {
            $companyImagesForm = new CompanyImagesForm();
            if (Yii::$app->request->post()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $companyImagesForm->image = UploadedFile::getInstance($companyImagesForm, 'image');
//                return $companyImagesForm->save();
                if ($companyImagesForm->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Image has been Uploaded.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            }
            return $this->renderAjax('image_gallery', [
                'companyImagesForm' => $companyImagesForm,
            ]);
        }
    }

    public function actionDeleteImages()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
            ->update(\common\models\OrganizationImages::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['image_enc_id' => $id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->execute();
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Image has been Deleted.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionAddEmployee()
    {
        if (Yii::$app->request->isAjax) {
            $organizationEmployeesForm = new OrganizationEmployeesForm();
            if ($organizationEmployeesForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $organizationEmployeesForm->image = UploadedFile::getInstance($organizationEmployeesForm, 'image');
                if ($organizationEmployeesForm->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Image has been Uploaded.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            }
            return $this->renderAjax('our_team_form', [
                'organizationEmployeesForm' => $organizationEmployeesForm,
            ]);
        }
    }

    public function actionDeleteEmployee()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
            ->update(\common\models\OrganizationEmployees::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['employee_enc_id' => $id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->execute();
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Image has been Deleted.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionFollow()
    {
        if (Yii::$app->request->isPost) {
            $org_id = Yii::$app->request->post("org_id");
            $chkuser = FollowedOrganizations::find()
                ->select('followed')
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                ->asArray()
                ->one();

            $status = $chkuser['followed'];

            if (empty($chkuser)) {
                $followed = new FollowedOrganizations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $followed->followed_enc_id = $utilitiesModel->encrypt();
                $followed->organization_enc_id = $org_id;
                $followed->user_enc_id = Yii::$app->user->identity->user_enc_id;
                $followed->followed = 1;
                $followed->created_on = date('Y-m-d H:i:s');
                $followed->created_by = Yii::$app->user->identity->user_enc_id;
                $followed->last_updated_on = date('Y-m-d H:i:s');
                $followed->last_updated_by = Yii::$app->user->identity->user_enc_id;
                if ($followed->save()) {
                    return 'following';
                } else {
                    return false;
                }
            } else if ($status == 1) {
                $update = Yii::$app->db->createCommand()
                    ->update(FollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                    ->execute();
                if ($update == 1) {
                    return 'unfollow';
                }
            } else if ($status == 0) {
                $update = Yii::$app->db->createCommand()
                    ->update(FollowedOrganizations::tableName(), ['followed' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                    ->execute();
                if ($update == 1) {
                    return 'following';
                }
            }
        }
    }

    public function actionOrganizationOpportunities($org){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            $options = [];
            $options['limit'] = 3;
            $options['page'] = 1;
            $options['company'] = $org;
            if ($type == 'Jobs') {
                $cards = ApplicationCards::jobs($options);
            } else {
                $cards = ApplicationCards::internships($options);
            }
            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    private function getYouTubeID($URL)
    {
        $YouTubeCheck = preg_match('![?&]{1}v=([^&]+)!', $URL . '&', $Data);
        If ($YouTubeCheck) {
            $VideoID = $Data[1];
        }
        return $VideoID;
    }

}
