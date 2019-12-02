<?php


namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\CollegeCourses;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\Organizations;
use common\models\Referral;
use common\models\ReviewsType;
use common\models\User;
use common\models\UserOtherDetails;
use common\models\Users;
use Yii;
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
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
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

            $company_count = ErexxCollaborators::find()
                ->select(['count(college_enc_id) company_count'])
                ->where(['college_enc_id' => $req['college_id'], 'organization_approvel' => 1, 'college_approvel' => 1, 'is_deleted' => 0])
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
                ->where(['a.status' => 'Hired'])
                ->asArray()
                ->count();

            $companies = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($req) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
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
                ->where(['aa.college_enc_id' => $req['college_id'], 'aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0])
                ->limit(6)
                ->asArray()
                ->all();


            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->distinct()
                ->select(['a.user_other_details_enc_id', 'a.user_enc_id', 'b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
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
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.college_actions' => 0])
                ->limit(6)
                ->asArray()
                ->all();

            $result = [];
            $result['company_count'] = $company_count['company_count'];
            $result['candidate_count'] = $candidate_count['candidate_count'];
            $result['companies'] = $companies;
            $result['candidates'] = $candidates;
            $result['placements_count'] = $placements_count;

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
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
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
                ->where(['a.college_enc_id' => $college_id, 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.is_college_approved' => 0, 'z.name' => $type])
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
                ->select(['b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.user_enc_id' => $data['user_id']])
                ->asArray()
                ->one();

            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->select(['a.user_other_details_enc_id', 'a.user_enc_id', 'b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b'], false)
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
                ->select(['college_course_enc_id', 'course_name', 'course_duration'])
                ->where(['organization_enc_id' => $college_id])
                ->groupBy(['course_name'])
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
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($req) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name', 'b.website', 'b.description', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
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
                    }], false)
                        ->joinWith(['organizationReviews k' => function ($k) {
                            $k->select(['k.organization_enc_id', 'ROUND(k.average_rating) average_rating', 'COUNT(k.review_enc_id) reviews_cnt']);
                        }])
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
                ->where(['aa.college_enc_id' => $req['college_id'], 'aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0])
                ->asArray()
                ->all();

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
                    'a.starting_year',
                    'a.ending_year',
                    'a.semester',
                    'c.name',
                    'cc.educational_requirement course_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->select(['b.user_enc_id']);
//                    $b->joinWith(['appliedApplications ccc' => function ($c) {
////                        $c->select(['ccc.created_by','ccc.application_enc_id','e.organization_enc_id','e.name company_name','f.name','ccc.applied_application_enc_id','COUNT(CASE WHEN g.is_completed = 1 THEN 1 END) as active', 'COUNT(g.is_completed) total']);
//                        $c->joinWith(['appliedApplicationProcesses g' => function ($g) {
//                            $g->select(['g.applied_application_enc_id', 'h.field_enc_id']);
//                            $g->joinWith(['fieldEnc h' => function ($h) {
//                                $h->select(['h.field_enc_id', 'h.field_name', 'h.sequence']);
//                            }]);
//                        }]);
//                        $c->joinWith(['applicationEnc d' => function ($d) {
//                            $d->joinWith(['title ee' => function ($ee) {
//                                $ee->joinWith(['categoryEnc f']);
//                            }]);
//                            $d->joinWith(['organizationEnc e']);
//                            $d->onCondition([
//                                'd.status' => 'Active',
//                                'd.is_deleted' => 0,
//                            ])
//                            ->andOnCondition(["or",
//                                ['d.application_for' => 0],
//                                ['d.application_for' => 2],
//                            ]);
//                        }], false);
//                        $c->onCondition(['ccc.is_deleted' => 0]);
//                        $c->orderBy(['ccc.id' => SORT_DESC]);
//                    }]);
                }], true)
                ->joinWith(['educationalRequirementEnc cc'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.college_actions' => null]);
            if (isset($data['course_name'])) {
                $candidates->andWhere(['cc.educational_requirement' => $data['course_name']]);
            }
            if (isset($data['semester'])) {
                $candidates->andWhere(['a.semester' => $data['semester']]);
            }

            $candidates = $candidates->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'candidates' => $candidates]);
        }
    }

    public function actionCandidateInvitation()
    {
        if ($user = $this->isAuthorized()) {

            $data = Yii::$app->request->post();
            $mail = Yii::$app->mailLogs;
            $mail->organization_enc_id = $this->getOrgId();
            $mail->user_enc_id = $user->user_enc_id;
            $mail->referral_code = $this->getReferralCode();
            $mail->email_type = 6;
            $mail->email_receivers = [
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone']
                ]
            ];
            $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
            $mail->email_template = 'invitation-email';
            if (!$mail->setEmailLog()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
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

            $user = UserOtherDetails::find()
                ->where(['user_other_details_enc_id' => $data['user_id']])
                ->one();

            if ($user) {
                if ($data['type'] == "approve") {
                    $user->college_actions = 0;
                } elseif ($data['type'] == "block") {
                    $user->college_actions = 1;
                } elseif ($data['type'] == "reject") {
                    $user->college_actions = 2;
                }

                if ($user->update()) {
                    return $this->response(200, ['status' => 200]);
                } else {
                    return $this->response(500, ['status' => 500]);
                }
            } else {
                return $this->response(500, ['status' => 500]);
            }
        }
    }

}