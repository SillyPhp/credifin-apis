<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Utilities;
use common\models\Organizations;
use frontend\models\CompanyLogoForm;
use frontend\models\CompanyCoverImageForm;
use common\models\FollowedOrganizations;
use common\models\OrganizationEmployeeBenefits;
use frontend\models\CompanyImagesForm;
use frontend\models\OrganizationEmployeesForm;
use common\models\OrganizationLocations;
use common\models\States;
use common\models\Cities;
use common\models\Countries;
use common\models\EmployeeBenefits;
use frontend\models\applications\ApplicationCards;

class OrganizationsController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'featured' => ['post'],
                ],
            ],
        ];
    }

    public function actionProfile($slug)
    {
        $organization = Organizations::find()
            ->where(['slug' => $slug, 'status' => 'Active', 'is_deleted' => 0])
            ->asArray()
            ->one();

        if ($organization) {
            $benefit = OrganizationEmployeeBenefits::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.organization_benefit_enc_id', 'b.benefit', 'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon) . '", b.icon_location, "/", b.icon) END icon'])
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
                    'benefit' => $benefit,
                    'gallery' => $gallery,
                    'our_team' => $our_team,
                    'industries' => $industries,
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

                return $this->render('view', [
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
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
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
                    return true;
                } else {
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

    public function actionLocationDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
            ->update(OrganizationLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['location_enc_id' => $id])
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
        $type = Yii::$app->request->post('type');
        if ($type == 'logo') {
            $update = Yii::$app->db->createCommand()
                ->update(Organizations::tableName(), ['logo' => null, 'logo_location' => null, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->execute();
        } elseif ($type == 'cover') {
            $update = Yii::$app->db->createCommand()
                ->update(Organizations::tableName(), ['cover_image' => null, 'cover_image_location' => null, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
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

    public function actionRemoveBenefit()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('type');
            $update = Yii::$app->db->createCommand()
                ->update(OrganizationEmployeeBenefits::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['organization_benefit_enc_id' => $id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
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
            return $this->renderAjax('image-gallery-form', [
                'companyImagesForm' => $companyImagesForm,
            ]);
        }
    }

    public function actionDeleteImages()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
            ->update(\common\models\OrganizationImages::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['image_enc_id' => $id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
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
            return $this->renderAjax('our-team-form', [
                'organizationEmployeesForm' => $organizationEmployeesForm,
            ]);
        }
    }

    public function actionDeleteEmployee()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $update = Yii::$app->db->createCommand()
            ->update(\common\models\OrganizationEmployees::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['employee_enc_id' => $id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
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
            Yii::$app->response->format = Response::FORMAT_JSON;
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
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Following',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Error',
                    ];
                }
            } else if ($status == 1) {
                $update = Yii::$app->db->createCommand()
                    ->update(FollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                    ->execute();
                if ($update == 1) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Unfollow',
                    ];
                }
            } else if ($status == 0) {
                $update = Yii::$app->db->createCommand()
                    ->update(FollowedOrganizations::tableName(), ['followed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                    ->execute();
                if ($update == 1) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Following',
                    ];
                }
            }
        }
    }

    public function actionOrganizationOpportunities($org)
    {
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

    public function actionFeatured()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $organizations = \common\models\Organizations::find()
                ->select(['initials_color color', 'CONCAT("/", slug) link', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END logo'])
                ->where(['is_sponsored' => 1])
                ->limit(10)
                ->asArray()
                ->all();
            if ($organizations) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'organizations' => $organizations
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

}