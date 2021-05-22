<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v1\models\Cards;
use api\modules\v1\models\OrganizationsList;
use common\models\Cities;
use common\models\UnclaimedFollowedOrganizations;
use common\models\UnclaimedOrganizations;
use common\models\Utilities;
use common\models\Countries;
use common\models\EmployeeBenefits;
use common\models\EmployerApplications;
use common\models\FollowedOrganizations;
use common\models\Industries;
use common\models\OrganizationEmployeeBenefits;
use common\models\OrganizationEmployees;
use common\models\OrganizationImages;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\States;
use common\models\UserAccessTokens;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;

class OrganizationsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => ['detail', 'opportunities', 'locations'],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'detail' => ['POST'],
                'opportunities' => ['POST'],
                'locations' => ['POST'],
                'follow' => ['POST'],
                'index' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user;
    }

    public function actionIndex()
    {
        $get = new OrganizationsList();
        $options = [];
        $param = Yii::$app->request->post();
        if (isset($param['keyword']) && !empty($param['keyword'])) {
            $options['keyword'] = trim($param['keyword']);
        }
        if (isset($param['sortBy']) && !empty($param['sortBy'])) {
            $options['sortBy'] = trim($param['sortBy']);
        }

        if (isset($param['limit']) && !empty($param['limit'])) {
            $options['limit'] = $param['limit'];
        } else {
            $options['limit'] = 10;
        }

        if (isset($param['page']) && !empty($param['page'])) {
            $options['page'] = $param['page'];
        } else {
            $options['page'] = 1;
        }

        $options['user_id'] = $this->userId();

        $options['business_activity'] = ['Recruiter', 'Business', 'Scholarship Fund', 'Banking & Finance Company', 'Others'];
        $cards = $get->getAllCompanies($options);
        if ($cards) {
            return $this->response(200, $cards);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionOpportunities()
    {
        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $result = [];

            $organization = Organizations::find()
                ->select(['organization_enc_id', 'name', 'email', 'tag_line', 'initials_color', 'establishment_year', 'description', 'mission', 'vision', 'value', 'website', 'phone', 'fax', 'facebook', 'google', 'twitter', 'linkedin', 'instagram', 'number_of_employees', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo', 'CASE WHEN cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '", cover_image_location, "/", cover_image) ELSE NULL END cover_image'])
                ->where(['organization_enc_id' => $req['id']])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->one();

            if ($organization) {

                $options = [];
                $options['organization_id'] = $organization['organization_enc_id'];
                if ($req['type'] == 'Jobs') {
                    $result['jobs'] = Cards::jobs($options);
                } elseif ($req['type'] == 'Internships') {
                    $result['internships'] = Cards::internships($options);
                } else {
                    $result['jobs'] = Cards::jobs($options);
                    $result['internships'] = Cards::internships($options);
                }

                return $this->response(200, $result);
            } else {
                return $this->response(404, 'Not Found');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }
    }

    public function actionLocations()
    {
        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $result = [];

            $organization = Organizations::find()
                ->select(['organization_enc_id', 'name', 'email', 'tag_line', 'initials_color', 'establishment_year', 'description', 'mission', 'vision', 'value', 'website', 'phone', 'fax', 'facebook', 'google', 'twitter', 'linkedin', 'instagram', 'number_of_employees', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo', 'CASE WHEN cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '", cover_image_location, "/", cover_image) ELSE NULL END cover_image'])
                ->where(['organization_enc_id' => $req['id']])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->one();

            if ($organization) {

                $organizationLocations = OrganizationLocations::find()
                    ->alias('a')
                    ->select(['a.location_enc_id', 'a.location_name', 'a.address', 'a.postal_code', 'a.latitude', 'a.longitude', 'b.name as city', 'c.name as state', 'd.name as country'])
                    ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
                    ->innerJoin(States::tableName() . 'as c', 'c.state_enc_id = b.state_enc_id')
                    ->innerJoin(Countries::tableName() . 'as d', 'd.country_enc_id = c.country_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.status' => 'Active', 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['organization_locations'] = $organizationLocations;

                return $this->response(200, $result);
            } else {
                return $this->response(404, 'Not Found');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }
    }

    public function actionDetail()
    {
        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $result = [];

            $organization = Organizations::find()
                ->select(['organization_enc_id', 'name', 'slug username', 'email', 'tag_line', 'initials_color', 'establishment_year', 'description', 'mission', 'vision', 'value', 'website', 'phone', 'fax', 'facebook', 'google', 'twitter', 'linkedin', 'instagram', 'number_of_employees', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo', 'CASE WHEN cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '", cover_image_location, "/", cover_image) ELSE NULL END cover_image'])
                ->where(['organization_enc_id' => $req['id']])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->one();

            if ($organization) {
                $result['organization'] = $organization;

                $benefit = OrganizationEmployeeBenefits::find()
                    ->alias('a')
                    ->select(['a.organization_benefit_enc_id', 'b.benefit', 'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon, true) . '", b.icon_location, "/", b.icon) END icon'])
                    ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id']])
                    ->andWhere(['a.is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['benefit'] = $benefit;

                $gallery = OrganizationImages::find()
                    ->select(['image_enc_id', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->image, 'https') . '", image_location, "/",  image) image'])
                    ->where(['organization_enc_id' => $organization['organization_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['gallery'] = $gallery;

                $team = OrganizationEmployees::find()
                    ->select(['first_name', 'last_name', 'designation', 'facebook', 'twitter', 'linkedin', 'employee_enc_id', 'CASE WHEN image IS NOT NULL OR image = "" THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->employees->image, 'https') . '", image_location, "/", image) ELSE NULL END image'])
                    ->where(['organization_enc_id' => $organization['organization_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['team'] = $team;

                $opportunities_count = EmployerApplications::find()
                    ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                    ->count();
                $result['opportunties_count'] = $opportunities_count;

                $industry = Industries::find()
                    ->select(['industry'])
                    ->where(['industry_enc_id' => $organization['industry_enc_id']])
                    ->asArray()
                    ->one();
                $result['industry'] = $industry;

                if (Yii::$app->request->headers->get('Authorization') && Yii::$app->request->headers->get('source')) {

                    $token_holder_id = UserAccessTokens::find()
                        ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                        ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                        ->one();

                    $user = Candidates::findOne([
                        'user_enc_id' => $token_holder_id->user_enc_id
                    ]);

                    if ($user) {
                        $follow = FollowedOrganizations::find()
                            ->select('followed')
                            ->where(['created_by' => $user->user_enc_id, 'organization_enc_id' => $organization['organization_enc_id']])
                            ->asArray()
                            ->one();
                        $result['follow'] = $follow;
                    } else {
                        return $this->response(401, 'unauthorized');
                    }
                }

                return $this->response(200, $result);
            } else {
                return $this->response(404, 'Not Found');
            }
        } else {
            return $this->response(422, 'Missing information');
        }
    }

    public function actionFollow()
    {

        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $token_holder_id = UserAccessTokens::find()
                ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                ->one();

            $user = Candidates::findOne([
                'user_enc_id' => $token_holder_id->user_enc_id
            ]);


            $org = Organizations::find()
                ->select(['organization_enc_id'])
                ->where(['organization_enc_id' => $req['id']])
                ->asArray()
                ->all();

            $unclaimed_org = UnclaimedOrganizations::find()
                ->select([])
                ->where(['organization_enc_id' => $req['id']])
                ->asArray()
                ->all();

            if (!empty($org)) {

                $chkuser = FollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                    ->asArray()
                    ->one();

                $status = $chkuser['followed'];

                if (empty($chkuser)) {
                    $followed = new FollowedOrganizations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $followed->followed_enc_id = $utilitiesModel->encrypt();
                    $followed->organization_enc_id = $req['id'];
                    $followed->user_enc_id = $user->user_enc_id;
                    $followed->followed = 1;
                    $followed->created_on = date('Y-m-d H:i:s');
                    $followed->created_by = $user->user_enc_id;
                    $followed->last_updated_on = date('Y-m-d H:i:s');
                    $followed->last_updated_by = $user->user_enc_id;
                    if ($followed->save()) {
                        return $this->response(200, 'saved');
                    } else {
                        return $this->response(500, "don't saved");
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(FollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                        ->execute();
                    if ($update == 1) {
                        return $this->response(200, 'saved');
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(FollowedOrganizations::tableName(), ['followed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                        ->execute();
                    if ($update == 1) {
                        return $this->response(200, 'saved');
                    }
                }
            } elseif ($unclaimed_org) {
                $unchkuser = UnclaimedFollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                    ->asArray()
                    ->one();

                $status = $unchkuser['followed'];

                if (empty($unchkuser)) {
                    $followed = new UnclaimedFollowedOrganizations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $followed->followed_enc_id = $utilitiesModel->encrypt();
                    $followed->organization_enc_id = $req['id'];
                    $followed->user_enc_id = $user->user_enc_id;
                    $followed->followed = 1;
                    $followed->created_on = date('Y-m-d H:i:s');
                    $followed->created_by = $user->user_enc_id;
                    if ($followed->save()) {
                        return $this->response(200, 'saved');
                    } else {
                        return $this->response(500, "don't saved");
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UnclaimedFollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                        ->execute();
                    if ($update == 1) {
                        return $this->response(200, 'saved');
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UnclaimedFollowedOrganizations::tableName(), ['followed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                        ->execute();
                    if ($update == 1) {
                        return $this->response(200, 'saved');
                    }
                }
            } else {
                return $this->response(500, 'an error occurred');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }

    }

}
