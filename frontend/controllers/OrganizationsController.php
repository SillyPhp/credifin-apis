<?php

namespace frontend\controllers;

use common\models\BusinessActivities;
use frontend\models\referral\ReferralReviewsTracking;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Designations;
use common\models\NewOrganizationReviews;
use common\models\OrganizationReviewFeedback;
use common\models\OrganizationReviewLikeDislike;
use common\models\UnclaimedFollowedOrganizations;
use common\models\UnclaimedOrganizations;
use frontend\models\OrganizationProductsForm;
use frontend\models\organizations\OrgAutoGenrateBlog;
use frontend\models\OrgAutoBlogForm;
use frontend\models\reviews\EditUnclaimedCollegeOrg;
use frontend\models\reviews\EditUnclaimedInstituteOrg;
use frontend\models\reviews\EditUnclaimedSchoolOrg;
use frontend\models\reviews\RegistrationForm;
use frontend\models\reviews\ReviewCards;
use Yii;
use yii\web\HttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Utilities;
use common\models\Organizations;
use frontend\models\CompanyLogoForm;
use frontend\models\reviews\EditReview;
use frontend\models\CompanyCoverImageForm;
use account\models\applications\ApplicationForm;
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
use common\models\OrganizationReviews;

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

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $referral = Yii::$app->referral->getReferralCode();
            $keyword = Yii::$app->request->post('keyword');
            $organization = Organizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.name', 'CONCAT(a.slug, "' . $referral . '") as slug', '(CASE WHEN a.is_featured = "1" THEN "1" ELSE NULL END) as is_featured', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'b.business_activity'])
                ->joinWith(['businessActivityEnc b'], false)
                ->where(['a.status' => 'Active', 'a.is_deleted' => 0]);
            if (!empty($keyword)) {
                $organization->andWhere([
                    'or',
                    ['like', 'a.name', $keyword],
                    ['like', 'a.slug', $keyword],
                ]);
            }
            $with_logo = $organization->orderBy(['a.logo' => SORT_DESC])->asArray()->all();

            if ($with_logo) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'organization' => $with_logo,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
        return $this->render('index');
    }

    public function actionCompanies($q = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!is_null($q)) {
            $referral = Yii::$app->referral->getReferralCode();
            $organizations = Organizations::find()
                ->alias('a')
                ->select(['a.name as text', 'CONCAT(a.slug, "' . $referral . '") as slug'])
                ->joinWith(['businessActivityEnc b'], false)
                ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
                ->andWhere([
                    'or',
                    ['like', 'a.name', $q],
                    ['like', 'a.slug', $q],
                ])
                ->asArray()
                ->all();

            return $organizations;
        }

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
            $org_products = \common\models\OrganizationProducts::find()
                ->alias('a')
                ->select(['a.product_enc_id', 'a.description'])
                ->joinWith(['organizationProductImages b' => function ($b) {
                    $b->select(['b.product_enc_id', 'b.image_enc_id', 'b.image', 'b.image_location', 'b.title']);
                    $b->where(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organization['organization_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->asArray()
                ->one();
            $our_team = \common\models\OrganizationEmployees::find()
                ->select(['first_name', 'last_name', 'image', 'image_location', 'designation', 'facebook', 'twitter', 'linkedin', 'employee_enc_id'])
                ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                ->asArray()
                ->all();
            $count_opportunities = \common\models\EmployerApplications::find()
                ->where(['organization_enc_id' => $organization['organization_enc_id'], 'for_careers' => 0, 'is_deleted' => 0])
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
                    'org_products' => $org_products,
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
                    'org_products' => $org_products,
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

    public function actionAddProductDescription()
    {
        if (Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $productdetail = Yii::$app->request->post();
            $checkProduct = \common\models\OrganizationProducts::findOne([
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'is_deleted' => 0,
            ]);

            if (!empty($checkProduct)) {
                $field = $productdetail['name'];
                $checkProduct->$field = $productdetail['value'];
                if (!$checkProduct->validate() || !$checkProduct->save()) {
                    return false;
                }
                return true;
            } else {
                $utilitiesModel = new Utilities();
                $organizationProducts = new \common\models\OrganizationProducts();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organizationProducts->product_enc_id = $utilitiesModel->encrypt();
                $organizationProducts->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                $organizationProducts->description = $productdetail['value'];
                $organizationProducts->created_on = date('Y-m-d H:i:s');
                $organizationProducts->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$organizationProducts->validate() || !$organizationProducts->save()) {
                    return false;
                }
                return true;
            }
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

    public function actionAddProducts()
    {
        if (Yii::$app->request->isAjax) {
            $organizationProductsForm = new OrganizationProductsForm();
            if (Yii::$app->request->post()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $organizationProductsForm->image = UploadedFile::getInstance($organizationProductsForm, 'image');
                if ($organizationProductsForm->save()) {
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
            return $this->renderAjax('add-products-form', [
                'organizationProductsForm' => $organizationProductsForm,
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

    public function actionRemoveProduct()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $p_id = Yii::$app->request->post('p_id');
        $update = Yii::$app->db->createCommand()
            ->update(\common\models\OrganizationProductImages::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['image_enc_id' => $id, 'product_enc_id' => $p_id])
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

    public function actionFollowUnclaimedOrganization()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $org_id = Yii::$app->request->post("org_id");
            $chkuser = UnclaimedFollowedOrganizations::find()
                ->select('followed')
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                ->asArray()
                ->one();
            $status = $chkuser['followed'];
            if (empty($chkuser)) {
                $followed = new UnclaimedFollowedOrganizations();
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
                    ->update(UnclaimedFollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
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
                    ->update(UnclaimedFollowedOrganizations::tableName(), ['followed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
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
            $options['limit'] = 6;
            $options['page'] = 1;
            $options['slug'] = $org;
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
            $referral = Yii::$app->referral->getReferralCode();
            $organizations = \common\models\Organizations::find()
                ->select(['initials_color color', 'CONCAT("/", slug, "' . $referral . '") link', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END logo'])
                ->where(['is_sponsored' => 1])
                ->limit(6)
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

    public function actionEditReview($request_type = null)
    {
        $editReviewForm = new EditReview;
        if ($editReviewForm->load(Yii::$app->request->post())) {
            if ($editReviewForm->save($request_type)) {
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionEditReviewUnclaimed($request_type = null, $type = null)
    {

        if ($type == 'org') {
            $editReviewForm = new EditReview();
            if ($editReviewForm->load(Yii::$app->request->post())) {
                if ($editReviewForm->save($request_type)) {
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        } elseif ($type == 'college') {
            $editReviewForm = new EditUnclaimedCollegeOrg();
            if ($editReviewForm->load(Yii::$app->request->post())) {
                if ($editReviewForm->save($request_type)) {
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        } elseif ($type == 'school') {
            $editReviewForm = new EditUnclaimedSchoolOrg();
            if ($editReviewForm->load(Yii::$app->request->post())) {
                if ($editReviewForm->save($request_type)) {
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        } elseif ($type == 'institute') {
            $editReviewForm = new EditUnclaimedInstituteOrg();
            if ($editReviewForm->load(Yii::$app->request->post())) {
                if ($editReviewForm->save($request_type)) {
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }

    }

    public function actionLoadReviews()
    {
        if (Yii::$app->request->isPost) {
            return true;
        }
    }

    public function actionReviews($slug)
    {
        $referral = Yii::$app->referral->getReferralCode();
        $editReviewForm = new EditReview;
        $model = new ApplicationForm();
        $primary_cat = $model->getPrimaryFields();
        $org = Organizations::find()
            ->select(['organization_enc_id', 'CONCAT(slug, "' . $referral . '") as slug', 'initials_color', 'name', 'website', 'email', 'logo', 'logo_location'])
            ->where([
                'slug' => $slug,
                'is_deleted' => 0
            ])
            ->asArray()
            ->one();
        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['organization_enc_id', 'b.business_activity', 'CONCAT(slug, "/reviews", "' . $referral . '") as slug', 'initials_color', 'name', 'website', 'email', 'logo', 'logo_location'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'slug' => $slug,
                'status' => 1
            ])
            ->asArray()
            ->one();

        if (!empty($org)) {
            $review_type = 'claimed';
            $reviews = OrganizationReviews::find()
                ->alias('a')
                ->select(['show_user_details', 'a.review_enc_id', 'a.status', 'ROUND(average_rating) average', 'c.name profile', 'a.created_on', 'a.is_current_employee', 'a.overall_experience', 'a.skill_development', 'a.work_life', 'a.compensation', 'a.organization_culture', 'a.job_security', 'a.growth', 'a.work', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'b.first_name', 'b.last_name', 'b.image user_logo', 'b.image_location user_logo_location', 'b.initials_color'])
                ->where(['a.organization_enc_id' => $org['organization_enc_id'], 'a.status' => 1])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
                ->asArray()
                ->all();
            $follow = FollowedOrganizations::find()
                ->select('followed')
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org['organization_enc_id']])
                ->asArray()
                ->one();

            $edit_review = $editReviewForm->getEditClaimedReview($org);
            if (!empty($edit_review)) {
                $editReviewForm->setValues($edit_review, $slug);
            }
            $stats = OrganizationReviews::find()
                ->select(['ROUND(AVG(job_security)) job_avg', 'ROUND(AVG(growth)) growth_avg', 'ROUND(AVG(organization_culture)) avg_cult', 'ROUND(AVG(compensation)) avg_compensation', 'ROUND(AVG(work)) avg_work', 'ROUND(AVG(work_life)) avg_work_life', 'ROUND(AVG(skill_development)) avg_skill'])
                ->where(['organization_enc_id' => $org['organization_enc_id'], 'status' => 1])
                ->asArray()
                ->one();
        }
        if (!empty($unclaimed_org)) {
            $obj = new ReviewCards();
            $review_type = 'unclaimed';
            $reviews = $obj->getReviewsCount($unclaimed_org);
            if ($unclaimed_org['business_activity'] == 'College') {
                $stats_students = $obj->getCollegeReviewStats($unclaimed_org);
                $reviews_students = $obj->getCollegeReviewsCount($unclaimed_org);
            } elseif ($unclaimed_org['business_activity'] == 'School') {
                $stats_students = $obj->getSchoolReviewStats($unclaimed_org);
                $reviews_students = $obj->getSchoolReviewsCount($unclaimed_org);
            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute') {
                $stats_students = $obj->getInstituteReviewStats($unclaimed_org);
                $reviews_students = $obj->getInstituteReviewsCount($unclaimed_org);
            }
            $stats = $obj->getReviewStats($unclaimed_org);
            $follow = UnclaimedFollowedOrganizations::find()
                ->select('followed')
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $unclaimed_org['organization_enc_id']])
                ->asArray()
                ->one();
            $edit_review = $editReviewForm->getEditReview($unclaimed_org);
            if (!empty($edit_review)) {
                if ($edit_review->reviewer_type == 0 || $edit_review->reviewer_type == 1) {
                    $editReviewForm->setValues($edit_review);
                } elseif ($edit_review->reviewer_type == 2 || $edit_review->reviewer_type == 3) {
                    $editReviewForm = new EditUnclaimedCollegeOrg();
                    $editReviewForm->setValues_college($edit_review);
                } elseif ($edit_review->reviewer_type == 4 || $edit_review->reviewer_type == 5) {
                    $editReviewForm = new EditUnclaimedSchoolOrg();
                    $editReviewForm->setValues_school($edit_review);
                } elseif ($edit_review->reviewer_type == 6 || $edit_review->reviewer_type == 7) {
                    $editReviewForm = new EditUnclaimedInstituteOrg();
                    $editReviewForm->setValues_institute($edit_review);
                }
            }
            $org = $unclaimed_org;
            if ($org['business_activity'] == 'College' || $org['business_activity'] == 'School' || $org['business_activity'] == 'Educational Institute') {
                return $this->render('review-college-company', ['review_type' => $review_type, 'follow' => $follow, 'reviews_students' => $reviews_students, 'primary_cat' => $primary_cat, 'editReviewForm' => $editReviewForm, 'edit' => $edit_review, 'slug' => $slug, 'stats_students' => $stats_students, 'stats' => $stats, 'org_details' => $org, 'reviews' => $reviews, 'stats' => $stats]);
            }
        }
        return $this->render('review-company', ['review_type' => $review_type, 'follow' => $follow, 'primary_cat' => $primary_cat, 'editReviewForm' => $editReviewForm, 'edit' => $edit_review, 'slug' => $slug, 'stats' => $stats, 'org_details' => $org, 'reviews' => $reviews, 'stats' => $stats]);
    }

    public function actionPostReviews($slug = null, $request_type = null)
    {
        if (Yii::$app->request->isPost) {
            $arr = Yii::$app->request->post('data');
            if ($request_type == 1) {
                $org_id = Organizations::find()
                    ->where(['slug' => $slug])
                    ->asArray()
                    ->one();
                $companyReview = new OrganizationReviews();
            } else {
                $org_id = UnclaimedOrganizations::find()
                    ->where(['slug' => $slug])
                    ->asArray()
                    ->one();
                $companyReview = new NewOrganizationReviews();
            }
            $f_time = strtotime($arr['from']);
            $from_time = date('Y-m-d', $f_time);
            $t_time = strtotime($arr['to']);
            $to_time = date('Y-m-d', $t_time);
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $companyReview->review_enc_id = $utilitiesModel->encrypt();
            $companyReview->show_user_details = (($arr['user'] == 'anonymous') ? 0 : 1);
            $category_execute = Categories::find()
                ->alias('a')
                ->where(['name' => $arr['department']]);
            $chk_cat = $category_execute->asArray()->one();
            if (empty($chk_cat)) {
                $categoriesModel = new Categories();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
                $categoriesModel->name = $arr['department'];
                $utilitiesModel->variables['name'] = $arr['department'];
                $utilitiesModel->variables['table_name'] = Categories::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $categoriesModel->slug = $utilitiesModel->create_slug();
                $categoriesModel->created_on = date('Y-m-d H:i:s');
                $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
                if ($categoriesModel->save()) {
                    $this->addNewAssignedCategory($categoriesModel->category_enc_id, $companyReview, $type = 'Reviews');
                } else {
                    return false;
                }
            } else {
                $cat_id = $chk_cat['category_enc_id'];
                $chk_assigned = $category_execute
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                    ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                    ->andWhere(['b.parent_enc_id' => null])
                    ->andWhere(['b.assigned_to' => 'Reviews'])
                    ->asArray()
                    ->one();
                if (empty($chk_assigned)) {
                    $this->addNewAssignedCategory($chk_cat['category_enc_id'], $companyReview, $type = 'Reviews');
                } else {
                    $companyReview->category_enc_id = $chk_cat['category_enc_id'];
                }
            }
            $data = Designations::find()
                ->where(['designation' => $arr['designation']])
                ->asArray()
                ->one();
            if (!empty($data)) {
                $companyReview->designation_enc_id = $data['designation_enc_id'];
            } else {
                $desigModel = new Designations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $desigModel->designation_enc_id = $utilitiesModel->encrypt();
                $utilitiesModel->variables['name'] = $arr['designation'];
                $utilitiesModel->variables['table_name'] = Designations::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $desigModel->slug = $utilitiesModel->create_slug();
                $desigModel->designation = $arr['designation'];
                $desigModel->created_on = date('Y-m-d H:i:s');
                $desigModel->created_by = Yii::$app->user->identity->user_enc_id;
                if ($desigModel->save()) {
                    $companyReview->designation_enc_id = $desigModel->designation_enc_id;
                } else {
                    return false;
                }
            }
            $companyReview->organization_enc_id = $org_id['organization_enc_id'];
            $companyReview->average_rating = $arr['average_rating'];
            if ($request_type == 1) {
                $companyReview->is_current_employee = (($arr['current_employee'] == 'current') ? 1 : 0);
            } else {
                $companyReview->reviewer_type = (($arr['current_employee'] == 'current') ? 1 : 0);
            }
            $companyReview->from_date = $from_time;
            $companyReview->to_date = $to_time;
            $companyReview->skill_development = $arr['skill_development'];
            $companyReview->work_life = $arr['work_life'];
            $companyReview->compensation = $arr['compensation'];
            $companyReview->organization_culture = $arr['organization_culture'];
            $companyReview->job_security = $arr['job_security'];
            $companyReview->growth = $arr['growth'];
            $companyReview->work = $arr['work'];
            $companyReview->city_enc_id = $arr['location'];
            $companyReview->likes = $arr['likes'];
            $companyReview->dislikes = $arr['dislikes'];
            $companyReview->created_by = Yii::$app->user->identity->user_enc_id;
            $companyReview->last_updated_by = Yii::$app->user->identity->user_enc_id;
            $companyReview->status = 1;
            $companyReview->created_on = date('Y-m-d H:i:s');
            if (!$companyReview->save()) {
                return true;
            } else {
                if ($request_type == 1) {
                    ReferralReviewsTracking::widget(['claim_review_id' => $companyReview->review_enc_id]);
                } else {
                    ReferralReviewsTracking::widget(['unclaim_review_id' => $companyReview->review_enc_id]);
                }
                return true;
            }
        }
    }

    private function addNewAssignedCategory($category_id, $companyReview, $type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = NULL;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $companyReview->category_enc_id = $category_id;
        } else {
            return false;
        }
    }

    public function actionPostCollegeCompanyReviews()
    {
        $model = new RegistrationForm();
        if (Yii::$app->request->isPost) {
            $arr = Yii::$app->request->post('data');
            $type = Yii::$app->request->post('type');
            $slug = Yii::$app->request->post('slug');
            $org_id = UnclaimedOrganizations::find()
                ->where(['slug' => $slug])
                ->asArray()
                ->one();
            if ($type == 'company') {
                if ($model->postReviews($org_id['organization_enc_id'])) {
                    return true;
                }
            } else if ($type == 'college') {
                if ($model->postCollegeReviews($org_id['organization_enc_id'])) {
                    return true;
                }
            } else if ($type == 'school') {
                if ($model->postSchoolReviews($org_id['organization_enc_id'])) {
                    return true;
                }
            } else if ($type == 'institute') {
                if ($model->postInstituteReviews($org_id['organization_enc_id'])) {
                    return true;
                }
            }
        }
    }

    public function actionGetReviews($slug, $limit = null, $offset = null)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $reviews = $this->getReviews($slug, $limit, $offset);
            if ($reviews['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'reviews' => $reviews['reviews'],
                    'total' => $reviews['total']
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionGetUnclaimedReviews($slug, $limit = null, $offset = null)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $reviews = $this->getUnclaimedReviews($slug, $limit, $offset);
            if ($reviews['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $reviews['total'],
                    'reviews' => $reviews['reviews']
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionGetUnclaimedStudentReviews($slug, $limit = null, $offset = null)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $reviews = $this->getUnclaimedStudentReviews($slug, $limit, $offset);
            if ($reviews['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $reviews['total'],
                    'reviews' => $reviews['reviews']
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionGetUnclaimedInstituteReviews($slug, $limit = null, $offset = null)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $reviews = $this->getUnclaimedInstituteReviews($slug, $limit, $offset);
            if ($reviews['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $reviews['total'],
                    'reviews' => $reviews['reviews']
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionGetUnclaimedSchoolReviews($slug, $limit = null, $offset = null)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $reviews = $this->getUnclaimedSchoolReviews($slug, $limit, $offset);
            if ($reviews['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $reviews['total'],
                    'reviews' => $reviews['reviews']
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    private function getReviews($slug, $limit, $offset)
    {
        $reviews = OrganizationReviews::find()
            ->alias('a')
            ->select(['a.review_enc_id','(CASE WHEN f.feedback_type = "1" THEN "1" ELSE NULL END) as feedback_type','(CASE WHEN f.feedback_type = "0" THEN "1" ELSE NULL END) as feedback_type_not','(CASE WHEN a.show_user_details = "1" THEN "1" ELSE NULL END) as show_user_details', 'a.review_enc_id', 'a.status', 'overall_experience', 'ROUND(a.average_rating) average', 'd.name profile', 'DATE_FORMAT(a.created_on, "%d-%m-%Y" ) as created_on', 'a.is_current_employee', 'a.overall_experience', 'a.skill_development', 'designation', 'a.work_life', 'a.compensation', 'a.organization_culture', 'a.job_security', 'a.growth', 'a.work', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'c.first_name', 'c.last_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", c.image_location, "/", c.image) ELSE NULL END image', 'c.initials_color'])
            ->where(['a.is_deleted' => 0])
            ->joinWith(['organizationEnc b' => function ($b) use ($slug) {
                $b->andWhere(['b.slug' => $slug]);
            }], false)
            ->joinWith(['createdBy c'], false)
            ->joinWith(['categoryEnc d'], false)
            ->joinWith(['designationEnc e'], false)
            ->joinWith(['organizationReviewLikeDislikes f' => function ($b) {
                $b->onCondition(['f.created_by' => Yii::$app->user->identity->user_enc_id]);
            }], false);

        return [
            'total' => $reviews->count(),
            'reviews' => $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
                ->limit($limit)
                ->offset($offset)
                ->asArray()
                ->all()
        ];
    }

    private function getUnclaimedReviews($slug, $limit, $offset)
    {
        $reviews = NewOrganizationReviews::find()
            ->alias('a')
            ->select(['(CASE WHEN a.show_user_details = "1" THEN "1" ELSE NULL END) as show_user_details', 'designation', 'a.review_enc_id', 'a.status', 'overall_experience', 'ROUND(a.average_rating) average', 'd.name profile', 'DATE_FORMAT(a.created_on, "%d-%m-%Y" ) as created_on', 'a.reviewer_type', 'a.overall_experience', 'a.skill_development', 'a.work_life', 'a.compensation', 'a.organization_culture', 'a.job_security', 'a.growth', 'a.work', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'c.first_name', 'c.last_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", c.image_location, "/", c.image) ELSE NULL END image', 'c.initials_color'])
            ->where(['a.status' => 1])
            ->joinWith(['organizationEnc b' => function ($b) use ($slug) {
                $b->andWhere(['b.slug' => $slug]);
            }], false)
            ->andWhere(['in', 'a.reviewer_type', [0, 1]])
            ->joinWith(['createdBy c'], false)
            ->joinWith(['categoryEnc d'], false)
            ->joinWith(['designationEnc e'], false);
        return [
            'total' => $reviews->count(),
            'reviews' => $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
                ->limit($limit)
                ->offset($offset)
                ->asArray()
                ->all()
        ];
    }

    private function getUnclaimedStudentReviews($slug, $limit, $offset)
    {
        $reviews = NewOrganizationReviews::find()
            ->alias('a')
            ->select(['(CASE WHEN a.show_user_details = "1" THEN "1" ELSE NULL END) as show_user_details',
                '(CASE
                WHEN a.reviewer_type = "2" THEN "Former"
                WHEN a.reviewer_type = "3" THEN "Current"
                ELSE "0"
                END) as reviewer_type'
                , 'e.name stream', 'educational_stream_enc_id', 'ROUND(a.average_rating) average', 'a.review_enc_id', 'a.status', 'd.name profile', 'DATE_FORMAT(a.created_on, "%d-%m-%Y" ) as created_on', 'a.academics', 'a.faculty_teaching_quality', 'a.infrastructure', 'a.accomodation_food', 'a.placements_internships', 'a.social_life_extracurriculars', 'a.culture_diversity', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'c.first_name', 'c.last_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", c.image_location, "/", c.image) ELSE NULL END image', 'c.initials_color'])
            ->where(['a.status' => 1])
            ->joinWith(['organizationEnc b' => function ($b) use ($slug) {
                $b->andWhere(['b.slug' => $slug]);
            }], false)
            ->andWhere(['in', 'a.reviewer_type', [2, 3]])
            ->joinWith(['createdBy c'], false)
            ->joinWith(['categoryEnc d'], false)
            ->joinWith(['educationalStreamEnc e'], false);
        return [
            'total' => $reviews->count(),
            'reviews' => $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
                ->limit($limit)
                ->offset($offset)
                ->asArray()
                ->all()
        ];
    }

    private function getUnclaimedInstituteReviews($slug, $limit, $offset)
    {
        $reviews = NewOrganizationReviews::find()
            ->alias('a')
            ->select(['(CASE WHEN a.show_user_details = "1" THEN "1" ELSE NULL END) as show_user_details',
                '(CASE
                WHEN a.reviewer_type = "6" THEN "Former"
                WHEN a.reviewer_type = "7" THEN "Current"
                ELSE "0"
                END) as reviewer_type'
                , 'e.name stream', 'educational_stream_enc_id', 'ROUND(a.average_rating) average', 'a.review_enc_id', 'a.status', 'd.name profile', 'DATE_FORMAT(a.created_on, "%d-%m-%Y" ) as created_on', 'a.student_engagement', 'a.school_infrastructure', 'a.faculty', 'a.value_for_money', 'a.teaching_style', 'a.coverage_of_subject_matter', 'a.accessibility_of_faculty', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'c.first_name', 'c.last_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", c.image_location, "/", c.image) ELSE NULL END image', 'c.initials_color'])
            ->where(['a.status' => 1])
            ->joinWith(['organizationEnc b' => function ($b) use ($slug) {
                $b->andWhere(['b.slug' => $slug]);
            }], false)
            ->andWhere(['in', 'a.reviewer_type', [6, 7]])
            ->joinWith(['createdBy c'], false)
            ->joinWith(['categoryEnc d'], false)
            ->joinWith(['educationalStreamEnc e'], false);
        return [
            'total' => $reviews->count(),
            'reviews' => $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
                ->limit($limit)
                ->offset($offset)
                ->asArray()
                ->all()
        ];
    }

    private function getUnclaimedSchoolReviews($slug, $limit, $offset)
    {
        $reviews = NewOrganizationReviews::find()
            ->alias('a')
            ->select(['(CASE WHEN a.show_user_details = "1" THEN "1" ELSE NULL END) as show_user_details',
                '(CASE
                WHEN a.reviewer_type = "4" THEN "Former"
                WHEN a.reviewer_type = "5" THEN "Current"
                ELSE "0"
                END) as reviewer_type'
                , 'e.name stream', 'educational_stream_enc_id', 'ROUND(a.average_rating) average', 'a.review_enc_id', 'a.status', 'd.name profile', 'DATE_FORMAT(a.created_on, "%d-%m-%Y" ) as created_on', 'a.student_engagement', 'a.school_infrastructure', 'a.faculty', 'a.accessibility_of_faculty', 'a.co_curricular_activities', 'a.leadership_development', 'a.sports', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'c.first_name', 'c.last_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", c.image_location, "/", c.image) ELSE NULL END image', 'c.initials_color'])
            ->where(['a.status' => 1])
            ->joinWith(['organizationEnc b' => function ($b) use ($slug) {
                $b->andWhere(['b.slug' => $slug]);
            }], false)
            ->andWhere(['in', 'a.reviewer_type', [4, 5]])
            ->joinWith(['createdBy c'], false)
            ->joinWith(['categoryEnc d'], false)
            ->joinWith(['educationalStreamEnc e'], false);
        return [
            'total' => $reviews->count(),
            'reviews' => $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
                ->limit($limit)
                ->offset($offset)
                ->asArray()
                ->all()
        ];
    }

    public function actionReviewLikeDislike()
    {
        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                $this->redirect('/login');
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            $r_id = Yii::$app->request->post('r_id');
            $id = Yii::$app->request->post('id');
            $chkuser = OrganizationReviewLikeDislike::find()
                ->select(['feedback_type'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'review_enc_id' => $r_id])
                ->asArray()
                ->one();
            if (empty($chkuser)) {
                $model = new OrganizationReviewLikeDislike();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->feedback_enc_id = $utilitiesModel->encrypt();
                $model->feedback_type = $id;
                $model->review_enc_id = $r_id;
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                $model->created_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                    ];
                }
            } else {
                $update = Yii::$app->db->createCommand()
                    ->update(OrganizationReviewLikeDislike::tableName(), ['feedback_type' => $id, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'review_enc_id' => $r_id])
                    ->execute();
                if ($update == 1) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                    ];
                }
            }

        }
    }

    public function actionReviewFeedback()
    {
        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                $this->redirect('/login');
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            $r_id = Yii::$app->request->post('r_id');
            $id = Yii::$app->request->post('id');
            $chkuser = OrganizationReviewFeedback::find()
                ->select(['feedback_type'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'review_enc_id' => $r_id])
                ->asArray()
                ->one();
            if (empty($chkuser)) {
                $model = new OrganizationReviewFeedback();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->feedback_enc_id = $utilitiesModel->encrypt();
                $model->user_enc_id = Yii::$app->user->identity->user_enc_id;
                $model->feedback_type = 1;
                $model->review_enc_id = $r_id;
                $model->feedback = $id;
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                if ($model->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Reported',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Error',
                    ];
                }
            } else {
                $update = Yii::$app->db->createCommand()
                    ->update(OrganizationReviewFeedback::tableName(), ['feedback' => $id, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'review_enc_id' => $r_id])
                    ->execute();
                if ($update == 1) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Reported',
                    ];
                }
            }

        }
    }

    public function actionFetchReviewCards()
    {
        $get = new ReviewCards();
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post('params');
            $cards = $get->getReviewCards($options);
            if ($cards['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $cards['total'],
                    'cards' => $cards['cards'],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionFetchReviewCardsCompany()
    {
        $get = new ReviewCards();
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post('params');
            $cards = $get->getCompaniesCard($options);
            if ($cards['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $cards['total'],
                    'cards' => $cards['cards'],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionFetchUnclaimedReviewCards()
    {
        $get = new ReviewCards();
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post('params');
            $cards = $get->getReviewUncliamedCards($options);
            if ($cards['total'] > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'total' => $cards['total'],
                    'cards' => $cards['cards'],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionGenrateBlog()
    {
        return $this->generateblog();
    }

    public function actionTopTenBlogs()
    {
        return $this->generateblog();
    }

    public function actionExplore(){
        return $this->render('explore');
    }

    private function generateblog()
    {
        $this->layout = 'main-secondary';
        $model = new OrgAutoGenrateBlog();
        if (Yii::$app->user->identity->organization):
            $data = $model->getJobs();
            $model->title = Yii::$app->user->identity->organization->name;
            $model->description = Yii::$app->user->identity->organization->description;
        endif;
        if ($model->load(Yii::$app->request->post())) {
            $model->images = UploadedFile::getInstances($model, 'images');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your Information Has Been Successfully Submitted..');
            } else {
                Yii::$app->session->setFlash('error', 'Something Went Wrong..');
            }
            return $this->refresh();
        }
        return $this->render('genrate-blog', ['model' => $model, 'data' => $data]);
    }

    public function actionSearchOrg($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $params1 = (new \yii\db\Query())
            ->select(['organization_enc_id as id','name', 'slug', 'initials_color color','CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",logo_location, "/", logo) END logo', '(CASE
                WHEN business_activity IS NULL THEN ""
                ELSE business_activity
                END) as business_activity'])
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->where("replace(name, '.', '') LIKE '%$q%'")
            ->andWhere(['is_deleted' => 0]);
        return $params1->limit(20)->all();


    }

}