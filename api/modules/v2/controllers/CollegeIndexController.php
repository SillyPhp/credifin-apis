<?php


namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\CollegeCourses;
use common\models\CollegeSettings;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\ErexxSettings;
use common\models\ErexxWhatsappInvitation;
use common\models\OrganizationReviews;
use common\models\Referral;
use common\models\Teachers;
use common\models\UserOtherDetails;
use common\models\Users;
use Yii;
use \yii\db\Expression;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class CollegeIndexController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'counts' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    private function getOrgId()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $organizations['college_id'];
        } else {
            return $this->response(401);
        }
    }

    public function actionCounts()
    {
        if ($user = $this->isAuthorized()) {

            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $req = [];
            $req['college_id'] = $organizations['college_id'];

            $this->setCandidateApprove($req['college_id']);

            $company_count = ErexxCollaborators::find()
                ->alias('a')
                ->select(['count(a.college_enc_id) company_count'])
                ->innerJoinWith(['organizationEnc b'])
                ->where(['a.college_enc_id' => $req['college_id'], 'a.organization_approvel' => 1, 'a.college_approvel' => 1,
                    'a.is_deleted' => 0,
                    'b.is_deleted' => 0,
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1
                ])
                ->asArray()
                ->one();

            $candidate_count = UserOtherDetails::find()
                ->select(['count(user_enc_id) candidate_count'])
                ->where(['organization_enc_id' => $req['college_id']])
                ->asArray()
                ->one();

            $placements_count = AppliedApplications::find()
                ->alias('a')
                ->select(['COUNT(b.user_enc_id) candidates'])
                ->innerJoinWith(['createdBy b' => function ($b) use ($req) {
                    $b->innerJoinWith(['userOtherInfo c' => function ($c) use ($req) {
                        $c->innerJoinWith(['organizationEnc d' => function ($d) use ($req) {
                            $d->andOnCondition([
                                'd.organization_enc_id' => $req['college_id']
                            ]);
                        }]);
                    }]);
                }])
                ->innerJoinWith(['applicationEnc ee' => function ($ee) {
                    $ee->joinWith(['organizationEnc e2']);
                }])
                ->where(['a.status' => 'Hired',
                    'e2.is_erexx_approved' => 1,
                    'e2.has_placement_rights' => 1])
                ->asArray()
                ->count();

            $companies = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($req) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($req) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $req['college_id']
                        ]);
                        $y->andWhere(['in', 'c.application_for', [0, 2]]);
                    }], false);
                }])
                ->where(['aa.college_enc_id' => $req['college_id'],
                    'aa.organization_approvel' => 1, 'aa.college_approvel' => 1,
                    'aa.is_deleted' => 0,
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1])
                ->limit(6)
                ->asArray()
                ->all();


            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->distinct()
                ->select(['a.user_other_details_enc_id', 'a.user_enc_id', 'b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'cc.course_name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->select(['b.user_enc_id']);
                    $b->joinWith(['appliedApplications f' => function ($f) {
                        $f->select(['f.created_by', 'e.name', 'e.slug']);
                        $f->joinWith(['applicationEnc d' => function ($d) {
                            $d->joinWith(['organizationEnc e' => function ($e) {
//                                $e->groupBy('e.organization_enc_id');
                            }], false);
                        }], false);
                    }], true);
                }], true)
                ->joinWith(['courseEnc cc'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.college_actions' => 0])
                ->limit(6)
                ->asArray()
                ->all();

            $college_settings = CollegeSettings::find()
                ->alias('a')
                ->select(['a.value'])
                ->innerJoinWith(['settingEnc b'], false)
                ->where(['a.college_enc_id' => $req['college_id'], 'b.status' => 'Active', 'b.setting' => 'jobs_approve'])
                ->asArray()
                ->one();

            $result = [];
            $result['company_count'] = $company_count['company_count'];
            $result['candidate_count'] = $candidate_count['candidate_count'];
            $result['companies'] = $companies;
            $result['candidates'] = $candidates;
            $result['placements_count'] = $placements_count;
            $result['jobs_auto_approve'] = ($college_settings['value'] == 2 ? true : false);

            return $this->response(200, ['status' => 200, 'data' => $result]);

        }
    }

//    public function actionCompanySelection()
//    {
//
//        if ($user = $this->isAuthorized()) {
//
//            $organizations = Users::find()
//                ->alias('a')
//                ->select(['b.organization_enc_id college_id'])
//                ->joinWith(['organizationEnc b'], false)
//                ->where(['a.user_enc_id' => $user->user_enc_id])
//                ->asArray()
//                ->one();
//
//            $req = [];
//            $req['college_id'] = $organizations['college_id'];
//
//            $companies = ErexxCollaborators::find()
//                ->alias('aa')
//                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
//                ->distinct()
//                ->innerJoinWith(['organizationEnc b' => function ($x) {
//                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
//                    $x->joinWith(['businessActivityEnc e'], false);
//                    $x->joinWith(['employerApplications c' => function ($y) {
//                        $y->select(['c.organization_enc_id', 'COUNT(c.application_enc_id) application_type', 'd.name'])
//                            ->joinWith(['applicationTypeEnc d'], false)
//                            ->onCondition([
//                                'c.status' => 'Active',
//                                'c.is_deleted' => 0,
//                                'c.application_for' => 0
//                            ])
//                            ->orOnCondition([
//                                'c.status' => 'Active',
//                                'c.is_deleted' => 0,
//                                'c.application_for' => 2
//                            ])
//                            ->groupBy(['c.application_type_enc_id']);
//                    }]);
//                }])
//                ->where(['aa.college_enc_id' => $req['college_id'], 'aa.organization_approvel' => 1, 'aa.college_approvel' => 0, 'aa.is_deleted' => 0, 'aa.status' => 'Active'])
//                ->asArray()
//                ->all();
//
//            if (!empty($companies)) {
//                return $this->response(200, ['status' => 200, 'companies' => $companies]);
//            } else {
//                return $this->response(404, ['status' => 404]);
//            }
//        } else {
//            return $this->response(401, ['status' => 401]);
//        }
//    }
//
//    public function actionCompanyApprove()
//    {
//        if ($user = $this->isAuthorized()) {
//            $req = Yii::$app->request->post();
//
//            $approve = ErexxCollaborators::find()
//                ->where(['collaboration_enc_id' => $req['collaborator_enc_id'], 'college_approvel' => 0])
//                ->one();
//
//            if (!empty($approve)) {
//                if ($req['action'] == 'Accept') {
//                    $approve->college_approvel = 1;
//                } elseif ($req['action'] == 'Reject') {
//                    $approve->is_deleted = 1;
//                }
//                $approve->last_updated_by = $user->user_enc_id;
//                $approve->last_updated_on = date('Y-m-d H:i:s');
//
//                if ($approve->update()) {
//                    return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
//                } else {
//                    return $this->response(500, ['status' => 500, 'message' => 'An error occured']);
//                }
//
//
//            } else {
//                return $this->response(404, ['status' => 404, 'message' => 'not found']);
//            }
//
//        } else {
//            return $this->response(401, ['status' => 401]);
//        }
//    }

    public function actionJobsSelection()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $type = Yii::$app->request->post('type');


            $jobs = ErexxEmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.application_enc_id',
                    'a.college_enc_id',
                    'bb.name',
                    'bb.slug org_slug',
                    'bb.organization_enc_id',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name title',
                    'a.employer_application_enc_id',
                    'b.slug',
                    'z.name job_type',
                ])
                ->joinWith(['employerApplicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc bb'], false);
                    $b->select(['b.application_enc_id', 'b.slug']);
                    $b->joinWith(['title d' => function ($d) {
                        $d->joinWith(['parentEnc e']);
                    }], false);
                    $b->joinWith(['applicationPlacementLocations f' => function ($f) {
                        $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                        $f->joinWith(['locationEnc ff' => function ($z) {
                            $z->joinWith(['cityEnc g']);
                        }], false);
                        $f->groupBy(['f.placement_location_enc_id']);
                    }], true);
                    $b->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where(['a.college_enc_id' => $college_id,
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.is_college_approved' => 0,
                    'z.name' => $type,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1])
                ->limit(6)
                ->asArray()
                ->all();


            $result = [];
            foreach ($jobs as $j) {
                $data = [];
                $locations = [];
                $positions = 0;
                $data['name'] = $j['name'];
                $data['logo'] = $j['logo'];
                $data['job_type'] = $j['job_type'];
                $data['org_slug'] = $j['org_slug'];
                $data['title'] = $j['title'];
                $data['slug'] = $j['slug'];
                $data['org_enc_id'] = $j['organization_enc_id'];
                $data['employer_application_enc_id'] = $j['employer_application_enc_id'];
                $data['application_enc_id'] = $j['application_enc_id'];
                $data['college_enc_id'] = $j['college_enc_id'];
                foreach ($j['employerApplicationEnc']['applicationPlacementLocations'] as $l) {
                    array_push($locations, $l['name']);
                    $positions += $l['positions'];
                }
                $data['location'] = implode(',', $locations);
                $data['positions'] = $positions;
                array_push($result, $data);
            }

            return $this->response(200, ['status' => 200, 'jobs' => $result]);
        } else {
            return $this->response(401);
        }
    }

    public function actionJobApprove()
    {
        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();

            $data = ErexxEmployerApplications::find()
                ->where(['application_enc_id' => $req['application_enc_id']])
                ->one();

            if (!empty($data)) {
                if ($req['action'] == 'Accept') {
                    $this->__addCompany($req['org_enc_id'], $this->getOrgId());
                    $data->is_college_approved = 1;
                } elseif ($req['action'] == 'Reject') {
                    $data->is_deleted = 1;
                }
                $data->last_updated_by = $user->user_enc_id;
                $data->last_updated_on = date('Y-m-d H:i:s');
                if ($data->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'An error occured']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401]);
        }
    }

    private function __addCompany($org_id, $college_enc_id)
    {

        $erexx_collab = ErexxCollaborators::find()
            ->where(['organization_enc_id' => $org_id, 'college_enc_id' => $college_enc_id])
            ->exists();

        if (!$erexx_collab) {
            $save_collab = new ErexxCollaborators();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $save_collab->collaboration_enc_id = $utilitiesModel->encrypt();
            $save_collab->organization_enc_id = $org_id;
            $save_collab->college_enc_id = $college_enc_id;
            $save_collab->organization_approvel = 1;
            $save_collab->college_approvel = 1;
            $save_collab->created_on = date('Y-m-d H:i:s');
            $save_collab->created_by = $college_enc_id;
            if ($save_collab->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            $erexx_comp = ErexxCollaborators::find()
                ->where(['organization_enc_id' => $org_id, 'college_enc_id' => $college_enc_id])
                ->one();

            if ($erexx_comp->college_approvel == 0) {
                $erexx_comp->college_approvel = 1;
                $erexx_comp->last_updated_by = $this->getOrgId();
                if ($erexx_comp->update()) {
                    return true;
                }
            }
        }
    }

    public function actionViewAllCandidates()
    {

        if ($user = $this->isAuthorized()) {

            $data = Yii::$app->request->post();
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $req = [];
            $req['college_id'] = $organizations['college_id'];

            $candidate = UserOtherDetails::find()
                ->alias('a')
                ->select(['b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.cgpa', 'a.semester', 'c.name', 'cc.course_name', 'b1.name city_name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->joinWith(['cityEnc b1']);
                }], false)
                ->joinWith(['courseEnc cc'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.user_enc_id' => $data['user_id']])
                ->asArray()
                ->one();

            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->select(['a.user_other_details_enc_id', 'a.user_enc_id', 'a.cgpa', 'b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'cc.course_name', 'b1.name city_name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->joinWith(['cityEnc b1']);
                }], false)
                ->joinWith(['courseEnc cc'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.college_actions' => 0])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $candidate, 'all_candidates' => $candidates]);
        }
    }

    public function actionCourses()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $college_id])
                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'courses' => $courses]);
        }
    }

    public function actionCompanies()
    {
        if ($user = $this->isAuthorized()) {

            $req = [];
            $req['college_id'] = $this->getOrgId();

            $companies = ErexxCollaborators::find()
                ->alias('aa')
                ->distinct()
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->joinWith(['organizationEnc b' => function ($x) use ($req) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name', 'b.website', 'b.description', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 0 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 0 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($req) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $req['college_id']
                        ]);
                    }], false)
                        ->joinWith(['organizationLocations ee' => function ($e) {
                            $e->select(['ee.organization_enc_id', 'ff.city_enc_id', 'ff.name']);
                            $e->joinWith(['cityEnc ff' => function ($ff) {
                                $ff->groupBy(['ff.city_enc_id']);
                            }], false)
                                ->orOnCondition([
                                    'ee.is_deleted' => 0,
                                ]);
                            $e->groupBy(['ee.organization_enc_id']);
                        }]);
                }])
                ->where(['aa.college_enc_id' => $req['college_id'],
                    'aa.organization_approvel' => 1,
                    'aa.college_approvel' => 1,
                    'aa.is_deleted' => 0,
                    'f.is_deleted' => 0,
                    'f.is_college_approved' => 1,
                    'f.status' => 'Active',
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1
                ])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($companies as $c) {
                $reviews = OrganizationReviews::find()
                    ->select(['organization_enc_id', 'ROUND(average_rating) average_rating', 'COUNT(review_enc_id) reviews_cnt'])
                    ->where(['organization_enc_id' => $c['organization_enc_id']])
                    ->asArray()
                    ->one();

                $companies[$i]['organizationEnc']['organizationReviews'][0] = $reviews;
                $i++;
            }

            return $this->response(200, ['status' => 200, 'companies' => $companies]);
        }
    }

    public function actionCandidates()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();
            $req['college_id'] = $this->getOrgId();
            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.user_other_details_enc_id',
                    'a.user_enc_id',
                    'b.email',
                    'b.phone',
                    'a.university_roll_number',
                    'c.name department',
                    'b.first_name',
                    'b.last_name',
                    'CONCAT(b.first_name, " " ,b.last_name) user_full_name',
                    'a.starting_year',
                    'a.ending_year',
                    'a.semester',
                    'a.college_actions',
                    'c.name',
                    'a.cgpa',
                    'cc.course_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->select(['b.user_enc_id']);
                }], true)
                ->joinWith(['courseEnc cc'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id']]);
            if (isset($data['course_name']) && !empty($data['course_name'])) {
                $candidates->andWhere(['cc.course_name' => $data['course_name']]);
            }
            if (isset($data['semester']) && !empty($data['semester'])) {
                $candidates->andWhere(['a.semester' => $data['semester']]);
            }
            if (isset($data['roll_no']) && !empty($data['roll_no'])) {
                $candidates->andWhere(['a.university_roll_number' => $data['roll_no']]);
            }
            if (isset($data['name']) && !empty($data['name'])) {
                $candidates->having(['like', 'user_full_name', $data['name']]);
            }
            if (isset($data['college_actions']) && $data['college_actions'] != 'empty') {
                if ($data['college_actions'] == '') {
                    $candidates->andWhere(['a.college_actions' => null]);
                } else {
                    $candidates->andWhere(['a.college_actions' => $data['college_actions']]);
                }
            }

            $candidates = $candidates->orderBy(
                [
                    new \yii\db\Expression('college_actions IS NULL DESC,college_actions ASC')
                ]
            )->asArray()
                ->all();

            $i = 0;
            foreach ($candidates as $c) {
                $applied = $this->getAppliedData($c['user_enc_id']);
                $candidates[$i]['applied'] = $applied;
                $i++;
            }

            return $this->response(200, ['status' => 200, 'candidates' => $candidates]);
        }
    }

    private function getAppliedData($user_id)
    {
        $applied = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'b2.name org_name', 'b2.slug org_slug', 'a.current_round', 'b.slug',
                'COUNT(CASE WHEN cc.is_completed = 1 THEN 1 END) as active',
                'COUNT(cc.is_completed) total',
                'b4.name category_name',
                'b5.name parent_category_name',
                'a.status job_status'])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->innerJoinWith(['erexxEmployerApplications b1'], false);
                $b->joinWith(['organizationEnc b2'], false);
                $b->joinWith(['title b3' => function ($b3) {
                    $b3->joinWith(['categoryEnc b4']);
                    $b3->joinWith(['parentEnc b5']);
                }]);
            }], false)
            ->joinWith(['appliedApplicationProcesses cc' => function ($cc) {
                $cc->joinWith(['fieldEnc dd'], false);
                $cc->select(['cc.applied_application_enc_id', 'cc.process_enc_id', 'cc.field_enc_id', 'dd.field_name', 'dd.icon', 'dd.sequence']);
                $cc->orderBy('dd.sequence');
            }])
            ->where(['a.created_by' => $user_id, 'b2.is_erexx_approved' => 1,
                'b2.has_placement_rights' => 1])
            ->groupBy(['a.applied_application_enc_id'])
            ->orderBy(['a.id' => SORT_DESC])
            ->limit(3)
            ->asArray()
            ->all();

        return $applied;
    }

    public function actionTeacherInvitation()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post('data');
            foreach ($data as $d) {
                $mail = Yii::$app->mailLogs;
                $mail->organization_enc_id = $this->getOrgId();
                $mail->user_enc_id = $user->user_enc_id;
                $mail->referral_code = $this->getReferralCode();
                $mail->email_type = 6;
                $mail->type = 2;
                $mail->email_receivers = [
                    [
                        'name' => $d['name'],
                        'email' => $d['email'],
                        'phone' => $d['phone']
                    ]
                ];
                $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
                $mail->email_template = 'teacher-invitation-email';
                if (!$mail->setEmailLog()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }
            return $this->response(200, ['status' => 200, 'message' => 'Email sent']);
        }
    }

    public function actionCandidateInvitation()
    {
        if ($user = $this->isAuthorized()) {

            $data = Yii::$app->request->post('data');
            foreach ($data as $d) {
                $mail = Yii::$app->mailLogs;
                $mail->organization_enc_id = $this->getOrgId();
                $mail->user_enc_id = $user->user_enc_id;
                $mail->referral_code = $this->getReferralCode();
                $mail->email_type = 6;
                $mail->type = 1;
                $mail->email_receivers = [
                    [
                        'name' => $d['name'],
                        'email' => $d['email'],
                        'phone' => $d['phone']
                    ]
                ];
                $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
                $mail->email_template = 'invitation-email';
                if (!$mail->setEmailLog()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }
            return $this->response(200, ['status' => 200, 'message' => 'Email sent']);
        }
    }

    public function actionCandidatesInvitation()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post('emails');
            $mail = [];
            $mails = [];
            foreach ($data as $m) {
                $mail['email'] = $m;
                array_push($mails, $mail);
            }
            $mail = Yii::$app->mailLogs;
            $mail->organization_enc_id = $this->getOrgId();
            $mail->user_enc_id = $user->user_enc_id;
            $mail->referral_code = $this->getReferralCode();
            $mail->email_type = 6;
            $mail->type = 1;
            $mail->email_receivers = $mails;
            $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
            $mail->email_template = 'invitation-email';
            if (!$mail->setEmailLog()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Email sent']);
        }
    }

    public function actionCandidatesFileInvitation()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post('emails');
            $emails = [];
            for ($i = 0; $i < count($data); $i++) {
                if (filter_var($data[$i]['email'], FILTER_VALIDATE_EMAIL)) {
                    array_push($emails, $data[$i]);
                }
            }

            $mail = Yii::$app->mailLogs;
            $mail->organization_enc_id = $this->getOrgId();
            $mail->user_enc_id = $user->user_enc_id;
            $mail->referral_code = $this->getReferralCode();
            $mail->email_type = 6;
            $mail->type = 1;
            $mail->email_receivers = $emails;
            $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
            $mail->email_template = 'invitation-email';
            if (!$mail->setEmailLog()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Email sent']);
        }
    }

    private function getReferralCode()
    {
        $referral_code = Referral::find()
            ->alias('a')
            ->select(['a.referral_enc_id', 'b.organization_enc_id', 'a.code'])
            ->joinWith(['organizationEnc b'])
            ->where(['b.organization_enc_id' => $this->getOrgId()])
            ->asArray()
            ->one();

        return $referral_code['code'];
    }

    public function actionCollegeActions()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();
            $_flag = 0;
            foreach ($data['user_id'] as $id) {
                $user = UserOtherDetails::find()
                    ->where(['user_other_details_enc_id' => $id])
                    ->one();

                if ($user) {
                    if ($data['type'] == "approve") {
                        $user->college_actions = 0;
                        $user->updated_on = date('Y-m-d H:i:s');
                    } elseif ($data['type'] == "block") {
                        $user->college_actions = 1;
                        $user->updated_on = date('Y-m-d H:i:s');
                    } elseif ($data['type'] == "reject") {
                        $user->college_actions = 2;
                        $user->updated_on = date('Y-m-d H:i:s');
                    }
                    if ($user->update()) {
                        $_flag++;
                    }
                }
            }
            if ($_flag == 0) {
                return $this->response(500, ['status' => 500, 'Message' => 'An Error occurred']);
            } else {
                return $this->response(200, ['status' => 200, 'Message' => 'saved']);
            }
        }
    }

    public function actionWhatsappInvitation()
    {

        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();
            if (!empty($req['phone'])) {
                $phone = $req['phone'];
            }

            $model = new ErexxWhatsappInvitation();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->invitation_enc_id = $utilitiesModel->encrypt();
            $model->invitation_type = 1;
            $model->phone = $phone;
            $model->user_enc_id = $user->user_enc_id;
            $model->organization_enc_id = $this->getOrgId();
            if ($model->save()) {
                $link = 'https://www.myecampus.in/signup?ref=' . $this->getReferralCode() . '%26invitation=' . $model->invitation_enc_id;
                return $this->response(200, ['status' => 200, 'link' => $link]);
            } else {
                return $this->response(500, ['status' => 500, 'Message' => 'An Error Occurred']);
            }
        }

    }

    public function actionGetCollegePreferences()
    {
        if ($user = $this->isAuthorized()) {

            $collge_id = $this->getOrgId();

            $pref_exists = CollegeSettings::find()
                ->where(['college_enc_id' => $collge_id])
                ->exists();

            if (!$pref_exists) {

                $settings = ErexxSettings::find()
                    ->where(['status' => 'Active'])
                    ->asArray()
                    ->all();

                foreach ($settings as $s) {

                    $model = new CollegeSettings();
                    $utilities = new Utilities();
                    $utilities->variables['string'] = time() . rand(100, 100000);
                    $model->college_settings_enc_id = $utilities->encrypt();
                    $model->college_enc_id = $collge_id;
                    $model->setting_enc_id = $s['setting_enc_id'];
                    $model->created_by = $user->user_enc_id;
                    $model->created_on = date('Y-m-d H:i:s');
                    if (!$model->save()) {
                        return $this->response(500, ['status' => 500, 'message' => 'en error occurred']);
                    }
                }
            }

            $college_setings = CollegeSettings::find()
                ->alias('a')
                ->select(['a.college_settings_enc_id', 'a.value', 'b.setting', 'b.title'])
                ->innerJoinWith(['settingEnc b'], false)
                ->where(['college_enc_id' => $collge_id, 'b.status' => 'Active'])
                ->asArray()
                ->all();

            if ($college_setings) {
                return $this->response(200, ['status' => 200, 'data' => $college_setings]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateCollegePreferences()
    {
        if ($user = $this->isAuthorized()) {
            $collge_id = $this->getOrgId();

            $params = Yii::$app->request->post();
            $setting_enc_id = $params['college_settings_enc_id'];
            $value = $params['value'];

            $setting = CollegeSettings::find()
                ->where(['college_settings_enc_id' => $setting_enc_id])
                ->one();

            if ($setting) {
                $setting->value = $value;
                $setting->updated_by = $user->user_enc_id;
                $setting->updated_on = date('Y-m-d H:i:s');
                if ($setting->update()) {
                    $this->setCandidateApprove($collge_id);
                    $this->setJobsApprove($collge_id, $user->user_enc_id);
                    return $this->response(200, ['status' => 200, 'message' => 'updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function setJobsApprove($college_id, $user_id)
    {
        $job_approve = CollegeSettings::find()
            ->alias('a')
            ->select(['a.value'])
            ->innerJoinWith(['settingEnc b'], false)
            ->where(['a.college_enc_id' => $college_id, 'b.status' => 'Active', 'b.setting' => 'jobs_approve'])
            ->asArray()
            ->one();

        if ($job_approve && $job_approve['value'] == 2) {
            $jobs = ErexxEmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select(['a.application_enc_id', 'bb.organization_enc_id'])
                ->joinWith(['employerApplicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc bb'], false);
                    $b->joinWith(['applicationTypeEnc z']);
                }], false)
                ->where(['a.college_enc_id' => $college_id, 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.is_college_approved' => 0])
                ->asArray()
                ->all();

            foreach ($jobs as $j) {

                $erexx_collab = ErexxCollaborators::find()
                    ->where(['organization_enc_id' => $j['organization_enc_id'], 'college_enc_id' => $college_id])
                    ->asArray()
                    ->one();

                if ($erexx_collab && $erexx_collab['college_approvel'] == 1) {
                    $data = ErexxEmployerApplications::find()
                        ->where(['application_enc_id' => $j['application_enc_id']])
                        ->one();

                    if (!empty($data)) {
                        $data->is_college_approved = 1;
                        $data->last_updated_by = $user_id;
                        $data->last_updated_on = date('Y-m-d H:i:s');
                        $data->update();
                    }
                }
            }

        }
    }

    private function setCandidateApprove($college_id)
    {
        $candidate_approve = CollegeSettings::find()
            ->alias('a')
            ->select(['a.value'])
            ->innerJoinWith(['settingEnc b'], false)
            ->where(['a.college_enc_id' => $college_id, 'b.status' => 'Active', 'b.setting' => 'candidate_approve'])
            ->asArray()
            ->one();

        if ($candidate_approve && $candidate_approve['value'] == 2) {
            $candidates = UserOtherDetails::find()
                ->select(['user_other_details_enc_id'])
                ->where(['organization_enc_id' => $college_id, 'college_actions' => null])
                ->asArray()
                ->all();

            if (!empty($candidates)) {
                foreach ($candidates as $c) {
                    $model = UserOtherDetails::find()
                        ->where(['user_other_details_enc_id' => $c['user_other_details_enc_id']])
                        ->one();

                    if ($model && $model->college_actions == null) {
                        $model->college_actions = 0;
                        $model->update();
                    }
                }
            }
        }
    }

    public function actionCollegeTeachers()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $teachers = Teachers::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.teacher_enc_id',
                    'b.username',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) END image',
                    'b.first_name',
                    'b.last_name',
                    'b.email',
                    'b.phone',
                    'b.description',
                    'c.name college_name',
                    'd.name city_name',
                    'e.user_type role'
                ])
                ->joinWith(['userEnc b'=>function($b){
                    $b->joinWith(['cityEnc d'],false);
                }], false)
                ->joinWith(['collegeEnc c'],false)
                ->joinWith(['role0 e'],false)
                ->where(['a.college_enc_id' => $college_id])
                ->asArray()
                ->all();

            if ($teachers) {
                return $this->response(200, ['status' => 200, 'data' => $teachers]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}