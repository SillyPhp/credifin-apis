<?php


namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\CollegeCourses;
use common\models\CollegeSettings;
use common\models\Companies;
use common\models\EmployeeBenefits;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\ErexxSettings;
use common\models\ErexxWhatsappInvitation;
use common\models\OrganizationEmployeeBenefits;
use common\models\OrganizationReviews;
use common\models\Organizations;
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

            $approved_candidates = UserOtherDetails::find()
                ->select(['count(user_enc_id) candidate_count'])
                ->where(['organization_enc_id' => $req['college_id'], 'college_actions' => 0])
                ->asArray()
                ->one();

            $pending_candidates = UserOtherDetails::find()
                ->select(['count(user_enc_id) candidate_count'])
                ->where(['organization_enc_id' => $req['college_id'], 'college_actions' => null])
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

            $pending_jobs = $this->pendingJobsCount('Jobs', $req['college_id']);
            $pending_internships = $this->pendingJobsCount('Internships', $req['college_id']);
            $approved_jobs = $this->approvedJobsCount('Jobs', $req['college_id']);
            $approved_internships = $this->approvedJobsCount('Internships', $req['college_id']);

            $result = [];
            $result['company_count'] = $company_count['company_count'];
            $result['approved_candidate_count'] = $approved_candidates['candidate_count'];
            $result['pending_candidate_count'] = $pending_candidates['candidate_count'];
            $result['companies'] = $companies;
            $result['pending_jobs'] = $pending_jobs;
            $result['pending_internships'] = $pending_internships;
            $result['approved_jobs'] = $approved_jobs;
            $result['approved_internships'] = $approved_internships;
            $result['candidates'] = $candidates;
            $result['placements_count'] = $placements_count;

            return $this->response(200, ['status' => 200, 'data' => $result]);

        }
    }

    private function approvedJobsCount($type, $college_id)
    {
        return ErexxEmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->joinWith(['employerApplicationEnc b' => function ($b) {
                $b->joinWith(['applicationTypeEnc c']);
            }], false)
            ->where([
                'a.college_enc_id' => $college_id,
                'a.is_college_approved' => 1,
                'a.status' => 'Active',
                'a.is_deleted' => 0,
                'b.status' => 'Active',
                'b.is_deleted' => 0,
                'b.application_for' => [0, 2]
            ])
            ->andWhere(['c.name' => $type])
            ->count();
    }

    public function pendingJobsCount($type, $college_id)
    {
        return EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                $b->onCondition([
                    'b.college_enc_id' => $college_id,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                ]);
                $b->andWhere([
                    'or',
                    ['b.is_college_approved' => null],
                    ['b.is_college_approved' => 0]
                ]);
            }], false)
            ->joinWith(['applicationTypeEnc z'])
            ->joinWith(['organizationEnc bb'], false)
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 'Active',
                'a.application_for' => [0, 2],
                'a.for_all_colleges' => 1,
                'z.name' => $type,
                'bb.is_erexx_approved' => 1,
                'bb.has_placement_rights' => 1,
            ])
            ->count();
    }

    public function actionCompanySelection()
    {

        if ($user = $this->isAuthorized()) {

            $college_id = $this->getOrgId();

            $companies = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->innerJoinWith(['organizationEnc b' => function ($x) {
                    $x->select(['b.organization_enc_id',
                        'b.name organization_name', 'b.slug org_slug',
                        'e.business_activity',
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) {
                        $y->select(['c.organization_enc_id', 'COUNT(c.application_enc_id) application_type', 'd.name'])
                            ->joinWith(['applicationTypeEnc d'], false)
                            ->onCondition([
                                'c.status' => 'Active',
                                'c.is_deleted' => 0,
                                'c.application_for' => [0, 2]
                            ])
                            ->groupBy(['c.application_type_enc_id']);
                    }]);
                }])
                ->where([
                    'aa.college_enc_id' => $college_id,
                    'aa.organization_approvel' => 1,
                    'aa.college_approvel' => 0,
                    'aa.is_deleted' => 0,
                    'aa.status' => 'Active',
                    'b.status' => 'Active',
                    'b.is_deleted' => 0
                ])
                ->asArray()
                ->all();

//            $companies = Organizations::find()
//                ->alias('a')
//                ->distinct()
//                ->select([
//                    'a.organization_enc_id',
//                    'a.slug',
//                    'g.college_approvel',
//                    'g.organization_approvel',
//                    'g.collaboration_enc_id'
//                ])
//                ->joinWith(['employerApplications c' => function ($y) use ($college_id) {
//                    $y->select(['c.organization_enc_id', 'c.application_enc_id', 'd.name']);
//                    $y->joinWith(['applicationTypeEnc d'], false);
//                    $y->andWhere([
//                        'c.status' => 'Active',
//                        'c.is_deleted' => 0,
//                        'c.for_all_colleges' => 1,
//                        'c.application_for' => [0, 2]
//                    ]);
//                }])
//                ->joinWith(['industryEnc h'], false)
//                ->joinWith(['businessActivityEnc b'], false)
//                ->joinWith(['erexxCollaborators0 g' => function ($g) use ($college_id) {
//                    $g->onCondition(['g.college_enc_id' => $college_id]);
//                }], false)
//                ->where([
//                    'a.is_deleted' => 0,
//                    'a.status' => 'Active',
//                    'a.has_placement_rights' => 1,
//                    'a.is_erexx_approved' => 1
//                ])
//                ->andWhere([
//                    'or',
//                    ['g.college_approvel' => null],
//                    ['g.college_approvel' => 0]
//                ])
//                ->limit(6)
//                ->asArray()
//                ->all();


            if (!empty($companies)) {
                return $this->response(200, ['status' => 200, 'data' => $companies]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCompanyApprove()
    {
        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();

            if (isset($req['collaborator_enc_id']) && !empty($req['collaborator_enc_id'])) {
                $collaborator_enc_id = $req['collaborator_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($req['action']) && !empty($req['action'])) {
                $action = $req['action'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $approve = ErexxCollaborators::find()
                ->where(['collaboration_enc_id' => $collaborator_enc_id, 'college_approvel' => 0])
                ->one();

            if (!empty($approve)) {
                if ($action == 'Accept') {
                    $approve->college_approvel = 1;
                } elseif ($action == 'Reject') {
                    $approve->is_deleted = 1;
                }
                $approve->last_updated_by = $user->user_enc_id;
                $approve->last_updated_on = date('Y-m-d H:i:s');

                if ($approve->update()) {
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

    public function actionJobsSelection()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $req = Yii::$app->request->post();

            if (isset($req['type']) && !empty($req['type'])) {
                $type = $req['type'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $limit = $req['limit'];


//            $jobs = ErexxEmployerApplications::find()
//                ->alias('a')
//                ->distinct()
//                ->select([
//                    'a.application_enc_id',
//                    'a.college_enc_id',
//                    'bb.name',
//                    'bb.slug org_slug',
//                    'bb.organization_enc_id',
//                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
//                    'e.name title',
//                    'a.employer_application_enc_id',
//                    'b.slug',
//                    'z.name job_type',
//                ])
//                ->joinWith(['employerApplicationEnc b' => function ($b) {
//                    $b->joinWith(['organizationEnc bb'], false);
//                    $b->select(['b.application_enc_id', 'b.slug']);
//                    $b->joinWith(['title d' => function ($d) {
//                        $d->joinWith(['categoryEnc e']);
//                    }], false);
//                    $b->joinWith(['applicationPlacementLocations f' => function ($f) {
//                        $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
//                        $f->joinWith(['locationEnc ff' => function ($z) {
//                            $z->joinWith(['cityEnc g']);
//                        }], false);
//                        $f->onCondition(['f.is_deleted' => 0]);
//                        $f->groupBy(['f.placement_location_enc_id']);
//                    }], true);
//                    $b->joinWith(['applicationTypeEnc z']);
//                }], true)
//                ->where(['a.college_enc_id' => $college_id,
//                    'a.is_deleted' => 0,
//                    'b.is_deleted' => 0,
//                    'bb.is_deleted' => 0,
//                    'a.status' => 'Active',
//                    'a.is_college_approved' => 0,
//                    'z.name' => $type,
//                    'bb.is_erexx_approved' => 1,
//                    'bb.has_placement_rights' => 1]);
//            if ($limit) {
//                $jobs->limit($limit);
//            }
//            $jobs = $jobs->asArray()
//                ->all();

            $jobs = EmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.application_enc_id',
                    'a.slug',
                    'a.last_date',
                    'a.joining_date',
                    'b.employer_application_enc_id',
                    'b.is_college_approved',
                    'b.college_enc_id',
                    'y.interview_process_enc_id',
                    'bb.organization_enc_id',
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'dd.designation',
                    'z.name job_type'
                ])
                ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                    $b->onCondition([
                        'b.college_enc_id' => $college_id,
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                    ]);
                    $b->andWhere([
                        'or',
                        ['b.is_college_approved' => null],
                        ['b.is_college_approved' => 0]
                    ]);
                }], false)
                ->joinWith(['organizationEnc bb'], false)
                ->joinWith(['interviewProcessEnc y' => function ($y) {
                    $y->select(['y.interview_process_enc_id']);
                    $y->joinWith(['interviewProcessFields yy' => function ($yy) {
                        $yy->select(['yy.interview_process_enc_id', 'yy.sequence', 'yy.field_name']);
                    }]);
                }])
                ->joinWith(['applicationEducationalRequirements bc' => function ($bc) {
                    $bc->select(['bc.application_enc_id', 'cb.educational_requirement']);
                    $bc->joinWith(['educationalRequirementEnc cb'], false);
                }])
                ->joinWith(['applicationSkills bbc' => function ($bbc) {
                    $bbc->select(['bbc.application_enc_id', 'skill']);
                    $bbc->joinWith(['skillEnc cbb'], false);
                }])
                ->joinWith(['designationEnc dd'], false)
                ->joinWith(['title d' => function ($d) {
                    $d->joinWith(['parentEnc e']);
                    $d->joinWith(['categoryEnc ee']);
                }], false)
                ->joinWith(['applicationOptions m'], false)
                ->joinWith(['applicationPlacementLocations f' => function ($f) {
                    $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                    $f->joinWith(['locationEnc ff' => function ($z) {
                        $z->joinWith(['cityEnc g']);
                        $z->groupBy(['ff.city_enc_id']);
                    }], false);
                    $f->onCondition(['f.is_deleted' => 0]);
                    $f->groupBy(['f.placement_location_enc_id']);
                }], true)
                ->joinWith(['applicationTypeEnc z'])
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.application_for' => [0, 2],
                    'a.for_all_colleges' => 1,
                    'z.name' => $type,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                ]);
            if ($limit) {
                $jobs->limit($limit);
            }
            $jobs = $jobs->asArray()
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
                $data['is_college_approved'] = $j['is_college_approved'];
                foreach ($j['applicationPlacementLocations'] as $l) {
                    if (!in_array($l['name'], $locations)) {
                        array_push($locations, $l['name']);
                        $positions += $l['positions'];
                    }
                }
                $data['location'] = implode(',', $locations);
                $data['positions'] = $positions;
                array_push($result, $data);
            }

            return $this->response(200, ['status' => 200, 'jobs' => $result]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionJobApprove()
    {
        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();
            $college_id = $this->getOrgId();

            $data = ErexxEmployerApplications::find()
                ->where(['employer_application_enc_id' => $req['application_enc_id'],
                    'college_enc_id' => $college_id])
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
                $model = new ErexxEmployerApplications();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->application_enc_id = $utilitiesModel->encrypt();
                $model->employer_application_enc_id = $req['application_enc_id'];
                $model->college_enc_id = $college_id;
                if ($req['action'] == 'Accept') {
                    $this->__addCompany($req['org_enc_id'], $this->getOrgId());
                    $model->is_college_approved = 1;
                } elseif ($req['action'] == 'Reject') {
                    $model->is_college_approved = 0;
                    $data->is_deleted = 1;
                }
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by = $user->user_enc_id;
                if ($model->save()) {
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'An error occured']);
                }

            }
        } else {
            return $this->response(401, ['status' => 401]);
        }
    }

    private function __addCompany($org_id, $college_enc_id)
    {

        if ($user = $this->isAuthorized()) {
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
                $save_collab->created_by = $user->user_enc_id;
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
                    $erexx_comp->last_updated_by = $user->user_enc_id;
                    if ($erexx_comp->update()) {
                        return true;
                    }
                }
            }
        }
    }

    public function actionRequestCompany()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $params = Yii::$app->request->post();
            if (isset($params['org_id']) && !empty($params['org_id'])) {
                $org_id = $params['org_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $save_collab = new ErexxCollaborators();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $save_collab->collaboration_enc_id = $utilitiesModel->encrypt();
            $save_collab->organization_enc_id = $org_id;
            $save_collab->college_enc_id = $college_id;
            $save_collab->organization_approvel = 0;
            $save_collab->college_approvel = 1;
            $save_collab->status = 'Requested';
            $save_collab->created_on = date('Y-m-d H:i:s');
            $save_collab->created_by = $user->user_enc_id;
            if ($save_collab->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'Requested']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
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
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
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

//    public function actionCompanies()
//    {
//        if ($user = $this->isAuthorized()) {
//
//            $req = [];
//            $req['college_id'] = $this->getOrgId();
//
//            $companies = ErexxCollaborators::find()
//                ->alias('aa')
//                ->distinct()
//                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id', 'aa.college_approvel'])
//                ->joinWith(['organizationEnc b' => function ($x) use ($req) {
//                    $x->groupBy('organization_enc_id');
//                    $x->select(['b.organization_enc_id', 'b.name', 'b.website', 'b.description',
//                        'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 0 END) as internships_count',
//                        'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 0 END) as jobs_count', 'b.slug org_slug',
//                        'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo',
//                        'b.facebook',
//                        'b.google',
//                        'b.twitter',
//                        'b.instagram',
//                        'b.fax',
//                        'b.linkedin',
//                        'b.phone'
//                    ]);
//                    $x->joinWith(['businessActivityEnc e'], false);
//                    $x->joinWith(['employerApplications c' => function ($y) use ($req) {
//                        $y->innerJoinWith(['erexxEmployerApplications f']);
//                        $y->joinWith(['applicationTypeEnc d'], true);
//                        $y->andWhere([
//                            'c.status' => 'Active',
//                            'c.is_deleted' => 0,
//                            'f.college_enc_id' => $req['college_id']
//                        ]);
//                    }], false)
//                        ->joinWith(['organizationLocations ee' => function ($e) {
//                            $e->select(['ee.organization_enc_id', 'ff.city_enc_id', 'ff.name']);
//                            $e->joinWith(['cityEnc ff' => function ($ff) {
//                                $ff->groupBy(['ff.city_enc_id']);
//                            }], false)
//                                ->orOnCondition([
//                                    'ee.is_deleted' => 0,
//                                ]);
//                            $e->groupBy(['ee.organization_enc_id']);
//                        }]);
//                }])
//                ->where([
//                    'aa.college_enc_id' => $req['college_id'],
//                    'aa.organization_approvel' => 1,
////                    'aa.college_approvel' => 1,
//                    'aa.is_deleted' => 0,
////                    'f.is_deleted' => 0,
////                    'f.is_college_approved' => 1,
//                    'f.status' => 'Active',
//                    'b.is_erexx_approved' => 1,
//                    'b.has_placement_rights' => 1
//                ])
//                ->asArray()
//                ->all();
//
//            $i = 0;
//            foreach ($companies as $c) {
//                $reviews = OrganizationReviews::find()
//                    ->select(['organization_enc_id', 'ROUND(average_rating) average_rating', 'COUNT(review_enc_id) reviews_cnt'])
//                    ->where(['organization_enc_id' => $c['organization_enc_id']])
//                    ->asArray()
//                    ->one();
//
//                $benefit = OrganizationEmployeeBenefits::find()
//                    ->alias('a')
//                    ->select(['a.organization_benefit_enc_id',
//                        'b.benefit',
//                        'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon, 'https') . '", b.icon_location, "/", b.icon) END icon'])
//                    ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
//                    ->where(['a.organization_enc_id' => $c['organization_enc_id']])
//                    ->andWhere(['a.is_deleted' => 0])
//                    ->asArray()
//                    ->all();
//
//                $companies[$i]['organizationEnc']['benefits'] = $benefit;
//                $companies[$i]['organizationEnc']['organizationReviews'][0] = $reviews;
//                $i++;
//            }
//
//            return $this->response(200, ['status' => 200, 'companies' => $companies]);
//        }
//    }

    public function actionCompanies()
    {
        if ($this->isAuthorized()) {

            $param = Yii::$app->request->post();
            if (isset($param['limit']) && !empty($param['limit'])) {
                $limit = $param['limit'];
            } else {
                $limit = 10;
            }

            if (isset($param['page']) && !empty($param['page'])) {
                $page = $param['page'];
            } else {
                $page = 1;
            }

            $sort_by = $param['sort_by'];

            $college_id = $this->getOrgId();

            $companies = Organizations::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.organization_enc_id',
                    'a.business_activity_enc_id',
                    'a.name',
                    'a.website',
                    'a.description',
//                    'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 0 END) as internships_count',
//                    'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 0 END) as jobs_count',
                    'a.slug org_slug',
                    'b.business_activity',
                    'h.industry',
                    'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
                    'a.facebook',
                    'a.google',
                    'a.twitter',
                    'a.instagram',
                    'a.fax',
                    'a.linkedin',
                    'a.phone',
                    'g.college_approvel',
                    'g.organization_approvel',
                    'g.status',
                    'g.is_deleted'
                ])
                ->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                    $y->select(['c.organization_enc_id', 'c.application_type_enc_id', 'd.name type']);
                    $y->joinWith(['applicationTypeEnc d'], false);
                    $y->onCondition([
                        'c.status' => 'Active',
                        'c.is_deleted' => 0,
                        'c.for_all_colleges' => 1,
                        'c.application_for' => [0, 2]
                    ]);
                }])
                ->joinWith(['industryEnc h'], false)
                ->joinWith(['businessActivityEnc b'], false)
                ->joinWith(['organizationLocations ee' => function ($e) {
                    $e->select(['ee.organization_enc_id', 'ff.city_enc_id', 'ff.name']);
                    $e->joinWith(['cityEnc ff' => function ($ff) {
                        $ff->groupBy(['ff.city_enc_id']);
                    }], false)
                        ->orOnCondition([
                            'ee.is_deleted' => 0,
                        ]);
                    $e->groupBy(['ee.organization_enc_id']);
                }])
                ->joinWith(['erexxCollaborators0 g' => function ($g) use ($college_id) {
                    $g->onCondition(['g.college_enc_id' => $college_id]);
                }], false)
                ->where([
                    'a.is_erexx_approved' => 1,
                    'a.has_placement_rights' => 1,
                    'a.status' => 'Active',
                    'a.is_deleted' => 0
                ])
                ->andWhere(['not', ['in', 'b.business_activity', ['College', 'Educational Institute', 'School']]]);
            if (!empty($sort_by)) {
                if ($sort_by == 'approved') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)ASC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    ]);
                } elseif ($sort_by == 'rejected') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    ]);
                } elseif ($sort_by == 'pending') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)ASC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)ASC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    ]);
                } elseif ($sort_by == 'invite') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)ASC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)ASC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)ASC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)ASC'),
                    ]);
                }
            } else {
                $companies->orderBy([
                    new \yii\db\Expression('FIELD (g.is_deleted, 1)ASC'),
                    new \yii\db\Expression('FIELD (g.college_approvel, 1)DESC'),
                    new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                ]);
            }

            $companies = $companies->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            $jobs_cnt = 0;
            $intern_cnt = 0;
            $i = 0;
            if ($companies) {
                foreach ($companies as $c) {
                    $reviews = OrganizationReviews::find()
                        ->select(['organization_enc_id', 'ROUND(average_rating) average_rating', 'COUNT(review_enc_id) reviews_cnt'])
                        ->where(['organization_enc_id' => $c['organization_enc_id']])
                        ->asArray()
                        ->one();

                    $benefit = OrganizationEmployeeBenefits::find()
                        ->alias('a')
                        ->select(['a.organization_benefit_enc_id',
                            'b.benefit',
                            'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon, 'https') . '", b.icon_location, "/", b.icon) END icon'])
                        ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
                        ->where(['a.organization_enc_id' => $c['organization_enc_id']])
                        ->andWhere(['a.is_deleted' => 0])
                        ->asArray()
                        ->all();

                    if ($c['status'] == null && !empty($c['employerApplications'])) {
                        $companies[$i]['status'] = 'Active';
                        $companies[$i]['organization_approvel'] = '1';
                        $companies[$i]['college_approvel'] = '0';
                    }

                    if ($c['employerApplications']) {
                        foreach ($c['employerApplications'] as $cc) {
                            if ($cc['type'] == 'Jobs') {
                                $jobs_cnt++;
                            } elseif ($cc['type'] == 'Internships') {
                                $intern_cnt++;
                            }
                        }
                    }
                    $companies[$i]['jobs_count'] = $jobs_cnt;
                    $companies[$i]['internships_count'] = $intern_cnt;

                    $jobs_cnt = 0;
                    $intern_cnt = 0;

                    $companies[$i]['benefits'] = $benefit;
                    $companies[$i]['organizationReviews'] = $reviews;
                    $i++;
                }
            }

            if ($companies) {
                return $this->response(200, ['status' => 200, 'data' => $companies]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
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

            $college_setings = $this->getPrefrences();

            if ($college_setings) {
                return $this->response(200, ['status' => 200, 'data' => $college_setings]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getPrefrences()
    {
        $collge_id = $this->getOrgId();

        $college_setings = ErexxSettings::find()
            ->alias('a')
            ->select(['a.setting', 'a.title', 'b.college_settings_enc_id', 'b.value'])
            ->joinWith(['collegeSettings b' => function ($b) use ($collge_id) {
                $b->onCondition(['b.college_enc_id' => $collge_id]);
            }], false)
            ->where(['a.status' => 'Active'])
            ->asArray()
            ->all();

        $i = 0;
        foreach ($college_setings as $c) {
            if ($c['setting'] == 'show_jobs' || $c['setting'] == 'show_internships') {
                if ($c['value'] == null) {
                    $college_setings[$i]['value'] = 2;
                }
            } else {
                if ($c['value'] == null) {
                    $college_setings[$i]['value'] = 1;
                }
            }
            $i++;
        }

        return $college_setings;
    }

    public function actionUpdateCollegePreferences()
    {
        if ($user = $this->isAuthorized()) {
            $collge_id = $this->getOrgId();

            $params = Yii::$app->request->post();
            $setting_enc_id = $params['college_settings_enc_id'];
            $value = $params['value'];
            $name = $params['name'];

            $setting = CollegeSettings::find()
                ->where(['college_settings_enc_id' => $setting_enc_id])
                ->one();

            if ($setting) {
                $setting->value = $value;
                $setting->updated_by = $user->user_enc_id;
                $setting->updated_on = date('Y-m-d H:i:s');
                if ($setting->update()) {
                    if ($name == 'students_approve') {
                        $this->setCandidateApprove($collge_id);
                    } elseif ($name == 'jobs_approve') {
                        $this->setJobsApprove($collge_id, $user->user_enc_id, 'Jobs', $name);
                    } elseif ($name == 'internships_approve') {
                        $this->setJobsApprove($collge_id, $user->user_enc_id, 'Internships', $name);
                    } elseif ($name == 'auto_approve_companies_for_job_placement') {
                        //for auto approve companies for jobs
                    } elseif ($name == 'auto_approve_companies_for_internship_placement') {
                        //for auto approve companies for internships
                    }
                    return $this->response(200, ['status' => 200, 'data' => $this->getPrefrences()]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {

                $setting_id = ErexxSettings::find()
                    ->where(['setting' => $name])
                    ->asArray()
                    ->one();

                $college_settings = new CollegeSettings();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $college_settings->college_settings_enc_id = $utilitiesModel->encrypt();
                $college_settings->college_enc_id = $collge_id;
                $college_settings->setting_enc_id = $setting_id['setting_enc_id'];
                $college_settings->value = $value;
                $college_settings->created_by = $user->user_enc_id;
                $college_settings->created_on = date('Y-m-d H:i:s');
                if ($college_settings->save()) {
                    return $this->response(200, ['status' => 200, 'data' => $this->getPrefrences()]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function setJobsApprove($college_id, $user_id, $type, $name)
    {
        $job_approve = CollegeSettings::find()
            ->alias('a')
            ->select(['a.value'])
            ->innerJoinWith(['settingEnc b'], false)
            ->where([
                'a.college_enc_id' => $college_id,
                'b.status' => 'Active',
                'b.setting' => $name
            ])
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
                ->where([
                    'a.college_enc_id' => $college_id,
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.is_college_approved' => 0,
                    'z.name' => $type
                ])
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

    private function setCompaniesApprove($college_id, $type, $name)
    {
        $company_approve = CollegeSettings::find()
            ->alias('a')
            ->select(['a.value'])
            ->innerJoinWith(['settingEnc b'], false)
            ->where([
                'a.college_enc_id' => $college_id,
                'b.status' => 'Active',
                'b.setting' => $name
            ])
            ->asArray()
            ->one();

        if ($company_approve && $company_approve['value'] == 2) {
            $comapanies = ErexxCollaborators::find()
                ->alias('a')
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['employerApplications c']);
                }])
                ->where(['a.college_enc_id' => $college_id, 'a.college_approvel' => 1])
                ->asArray()
                ->all();
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
                ->joinWith(['userEnc b' => function ($b) {
                    $b->joinWith(['cityEnc d'], false);
                }], false)
                ->joinWith(['collegeEnc c'], false)
                ->joinWith(['role0 e'], false)
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