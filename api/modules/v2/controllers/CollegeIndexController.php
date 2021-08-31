<?php


namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\AssignedCollegeCourses;
use common\models\CollegeSettings;
use common\models\EmployeeBenefits;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxCollegeRejectionReasons;
use common\models\ErexxCollegeRejections;
use common\models\ErexxEmployerApplications;
use common\models\ErexxSettings;
use common\models\ErexxWhatsappInvitation;
use common\models\LoanApplications;
use common\models\OrganizationEmployeeBenefits;
use common\models\OrganizationLabels;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\Referral;
use common\models\RejectionReasons;
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

            $college_id = $this->getOrgId();
            $this->setCandidateApprove($college_id);
            $this->autoCompaniesApprove($college_id, 'Jobs', 'auto_approve_companies_for_job_placement');
            $this->autoCompaniesApprove($college_id, 'Internships', 'auto_approve_companies_for_internship_placement');
            $this->autoJobsApprove($college_id, $user->user_enc_id, 'Jobs', 'jobs_approve');
            $this->autoJobsApprove($college_id, $user->user_enc_id, 'Internships', 'internships_approve');

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
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($req) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $req['college_id']
                        ]);
                        $y->andWhere(['in', 'c.application_for', 2]);
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
                ->select(['a.user_other_details_enc_id', 'a.user_enc_id', 'b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'cc.course_name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->select(['b.user_enc_id']);
                    $b->joinWith(['appliedApplications f' => function ($f) {
                        $f->select(['f.created_by', 'e.name', 'e.slug']);
                        $f->joinWith(['applicationEnc d' => function ($d) {
                            $d->joinWith(['organizationEnc e' => function ($e) {
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

            if ($candidates) {
                foreach ($candidates as $key => $val) {
                    $candidates[$key]['loan_applied'] = $this->loanApplied($val['user_enc_id']);
                    $candidates[$key]['applied_companies'] = $this->appliedCompanies($val['user_enc_id']);
                }
            }

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
                $b->joinWith(['organizationEnc bb'], false);
                $b->joinWith(['applicationTypeEnc c']);
            }], false)
            ->where([
                'a.college_enc_id' => $college_id,
                'a.is_college_approved' => 1,
                'a.status' => 'Active',
                'a.is_deleted' => 0,
                'b.status' => 'Active',
                'b.is_deleted' => 0,
                'b.application_for' => 2,
                'b.for_all_colleges' => 1,
                'bb.is_erexx_approved' => 1,
                'bb.has_placement_rights' => 1,
                'bb.is_deleted' => 0,
                'bb.status' => 'Active',
            ])
            ->andWhere(['c.name' => $type])
            ->count();
    }

    public function pendingJobsCount($type, $college_id)
    {

        $rejected_companies = ErexxCollaborators::find()
            ->select(['organization_enc_id'])
            ->where(['college_enc_id' => $college_id, 'is_deleted' => 1])
            ->asArray()
            ->all();

        $ids = [];
        foreach ($rejected_companies as $r) {
            array_push($ids, $r['organization_enc_id']);
        }

        $count = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.application_enc_id',
                'b.is_college_approved',
                'b.is_deleted'
            ])
            ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                $b->onCondition(['b.college_enc_id' => $college_id]);
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
                }], false);
                $f->onCondition(['f.is_deleted' => 0]);
            }], true)
            ->joinWith(['applicationTypeEnc z'])
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 'Active',
                'z.name' => $type,
                'bb.is_erexx_approved' => 1,
                'bb.has_placement_rights' => 1,
                'bb.is_deleted' => 0,
                'bb.status' => 'Active',
                'a.application_for' => 2,
                'a.for_all_colleges' => 1,
            ])
            ->andWhere(['NOT', ['bb.organization_enc_id' => $ids]])
            ->asArray()
            ->all();

        $i = 0;
        $counts = [];
        foreach ($count as $c) {
            if ($c['is_deleted'] != 1) {
                if ($c['is_college_approved'] != 1) {
                    array_push($counts, $count[$i]);
                }
            }
            $i++;
        }

        return count($counts);
    }

    public function actionCompanySelection()
    {

        if ($user = $this->isAuthorized()) {

            $college_id = $this->getOrgId();

            $companies = Organizations::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.organization_enc_id',
                    'a.name organization_name',
                    'a.slug org_slug',
                    'e.business_activity',
                    'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
                    'g.college_approvel',
                    'g.organization_approvel',
                    'g.collaboration_enc_id',
                    'g.is_deleted'
                ])
                ->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                    $y->select(['c.organization_enc_id', 'c.application_enc_id', 'd.name']);
                    $y->joinWith(['applicationTypeEnc d'], false);
                    $y->andWhere([
                        'c.status' => 'Active',
                        'c.is_deleted' => 0,
                        'c.for_all_colleges' => 1,
                        'c.application_for' => 2
                    ]);
                }])
                ->joinWith(['industryEnc h'], false)
                ->joinWith(['businessActivityEnc e'], false)
                ->joinWith(['erexxCollaborators0 g' => function ($g) use ($college_id) {
                    $g->onCondition(['g.college_enc_id' => $college_id]);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.has_placement_rights' => 1,
                    'a.is_erexx_approved' => 1
                ])
                ->andWhere([
                    'or',
                    ['g.college_approvel' => null],
                    ['g.college_approvel' => 0],
                ])
                ->limit(6)
                ->asArray()
                ->all();


            $j = 0;
            $jobs_cnt = 0;
            $intern_cnt = 0;
            foreach ($companies as $c) {
                if ($c['employerApplications']) {
                    foreach ($c['employerApplications'] as $cc) {
                        if ($cc['name'] == 'Jobs') {
                            $jobs_cnt++;
                        } elseif ($cc['name'] == 'Internships') {
                            $intern_cnt++;
                        }
                    }
                }
                $companies[$j]['jobs_count'] = $jobs_cnt;
                $companies[$j]['internships_count'] = $intern_cnt;

                $jobs_cnt = 0;
                $intern_cnt = 0;
                $j++;
            }


            $data = [];
            $i = 0;
            foreach ($companies as $c) {
                if ($c['is_deleted'] != 1) {
                    array_push($data, $companies[$i]);
                }
                $i++;
            }

            $companies = $data;


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

            $college_id = $this->getOrgId();

            if (isset($req['organization_enc_id']) && !empty($req['organization_enc_id'])) {
                $organization_enc_id = $req['organization_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($req['action']) && !empty($req['action'])) {
                $action = $req['action'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $approve = ErexxCollaborators::find()
                ->where(['organization_enc_id' => $organization_enc_id, 'college_enc_id' => $college_id, 'college_approvel' => 0])
                ->one();

            if (!empty($approve)) {
                if ($action == 'Accept') {
                    $approve->college_approvel = 1;
                } elseif ($action == 'Reject') {
                    $approve->is_deleted = 1;
                    $d['collab_enc_id'] = $approve->collaboration_enc_id;
                    $d['reasons'] = $req['reasons'];
                    $d['user_id'] = $user->user_enc_id;
                    if ($d['reasons']) {
                        $this->__rejectReasons($d, 1);
                    }
                }
                $approve->last_updated_by = $user->user_enc_id;
                $approve->last_updated_on = date('Y-m-d H:i:s');

                if ($approve->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'An error occurred']);
                }

            } else {
                $model = new ErexxCollaborators();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->collaboration_enc_id = $utilitiesModel->encrypt();
                $model->organization_enc_id = $organization_enc_id;
                $model->college_enc_id = $college_id;
                $model->organization_approvel = 1;
                if ($action == 'Accept') {
                    $model->college_approvel = 1;
                } elseif ($action == 'Reject') {
                    $model->college_approvel = 0;
                    $model->is_deleted = 1;
                    $d['collab_enc_id'] = $model->collaboration_enc_id;
                    $d['reasons'] = $req['reasons'];
                    $d['user_id'] = $user->user_enc_id;
                    if ($d['reasons']) {
                        $this->__rejectReasons($d, 1);
                    }
                }
                $model->created_by = $user->user_enc_id;
                $model->created_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'An error occurred']);
                }
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

            $rejected_companies = ErexxCollaborators::find()
                ->select(['organization_enc_id'])
                ->where(['college_enc_id' => $college_id, 'is_deleted' => 1])
                ->asArray()
                ->all();

            $ids = [];
            foreach ($rejected_companies as $r) {
                array_push($ids, $r['organization_enc_id']);
            }

            $jobs = EmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.application_enc_id',
                    'a.slug',
                    'a.status',
                    'a.last_date',
                    'a.joining_date',
                    'b.employer_application_enc_id',
                    'b.is_college_approved',
                    'b.college_enc_id',
                    'y.interview_process_enc_id',
                    'bb.organization_enc_id',
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'dd.designation',
                    'z.name job_type',
                    'b.is_deleted',
                    'm.positions',
                    'a.created_on'
                ])
                ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                    $b->onCondition([
                        'b.college_enc_id' => $college_id,
                        'b.status' => 'Active',
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
                    $bbc->onCondition(['bbc.is_deleted' => 0]);
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
                    }], false);
                    $f->onCondition(['f.is_deleted' => 0]);
                }], true)
                ->joinWith(['applicationTypeEnc z'])
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.application_for' => 2,
                    'a.for_all_colleges' => 1,
                    'z.name' => $type,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                ])
//                ->andWhere(['or', 'a.for_all_colleges', 1])
                ->andWhere(['NOT', ['bb.organization_enc_id' => $ids]])
//                ->groupBy(['bb.organization_enc_id'])
//                ->orderBy([new \yii\db\Expression('a.status = "Active" desc')])
                ->orderBy(new Expression('rand()'))
                ->asArray()
                ->all();

            $result = [];
            foreach ($jobs as $j) {
                $data = [];
                $locations = [];
                $positions = 0;
                $datetime1 = new \DateTime(date('Y-m-d', strtotime($j['created_on'])));
                $datetime2 = new \DateTime(date('Y-m-d'));

                $diff = $datetime1->diff($datetime2);
                $data['filling_soon'] = ($diff->days > 10) ? true : false;
                $data['name'] = $j['name'];
                $data['logo'] = $j['logo'];
                $data['is_deleted'] = $j['is_deleted'];
                $data['job_type'] = $j['job_type'];
                $data['org_slug'] = $j['org_slug'];
                $data['title'] = $j['title'];
                $data['slug'] = $j['slug'];
                $data['org_enc_id'] = $j['organization_enc_id'];
                $data['employer_application_enc_id'] = $j['employer_application_enc_id'];
                $data['application_enc_id'] = $j['application_enc_id'];
                $data['college_enc_id'] = $j['college_enc_id'];
                $data['is_college_approved'] = $j['is_college_approved'];
                $data['last_date'] = $j['last_date'];
                if ($j['status'] != 'Active') {
                    $data['is_closed'] = true;
                } else {
                    $data['is_closed'] = false;
                }
                foreach ($j['applicationPlacementLocations'] as $l) {
                    if (!in_array($l['name'], $locations)) {
                        array_push($locations, $l['name']);
                        $positions += $l['positions'];
                    }
                }
                $data['is_exclusive'] = $this->__exclusiveJob($j['application_enc_id']);
                $data['location'] = $locations ? implode(',', $locations) : 'Work From Home';
                if ($positions) {
                    $data['positions'] = $positions;
                } else {
                    $data['positions'] = $j['positions'];
                }
                array_push($result, $data);
            }

            $data = [];
            $j = 0;
            $i = 0;
            foreach ($result as $r) {
                if ($r['is_deleted'] != 1) {
                    if ($r['is_college_approved'] != 1) {
                        array_push($data, $result[$j]);
                        $i++;
                    }
                }
                if ($limit) {
                    if ($i == 6) {
                        break;
                    }
                }
                $j++;
            }

            return $this->response(200, ['status' => 200, 'jobs' => $data]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __exclusiveJob($app_id)
    {
        $exclusive_job = ErexxEmployerApplications::find()
            ->alias('a')
            ->joinWith(['employerApplicationEnc b'])
            ->where(['a.employer_application_enc_id' => $app_id, 'b.for_all_colleges' => 0])
            ->count();

        if ($exclusive_job == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function actionGetReasons()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['reason_for']) && empty($params['reason_for'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $reasons = RejectionReasons::find()
                ->select(['rejection_reason_enc_id', 'reason'])
                ->where(['is_deleted' => 0, 'reason_by' => 0, 'reason_for' => $params['reason_for']])
                ->andWhere(['or', ['created_by' => $user->user_enc_id], ['status' => 'Approved']])
                ->all();

            if ($reasons) {
                return $this->response(200, ['status' => 200, 'data' => $reasons]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
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
                    $d['erexx_app_id'] = $data->application_enc_id;
                    $d['reasons'] = $req['reasons'];
                    $d['user_id'] = $user->user_enc_id;
                    if ($d['reasons']) {
                        $this->__rejectReasons($d, 1);
                    }
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
                    $model->is_deleted = 1;
                    $d['erexx_app_id'] = $model->application_enc_id;
                    $d['reasons'] = $req['reasons'];
                    $d['user_id'] = $user->user_enc_id;
                    if ($d['reasons']) {
                        $this->__rejectReasons($d, 1);
                    }
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

    private function __rejectReasons($data, $reason_for)
    {
        $rejection = new ErexxCollegeRejections();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $rejection->erexx_college_rejection_enc_id = $utilitiesModel->encrypt();
        if ($reason_for == 0) {
            $rejection->erexx_employer_app_enc_id = $data['erexx_app_id'];
        } elseif ($reason_for == 1) {
            $rejection->erexx_collab_enc_id = $data['collab_enc_id'];
        }
        $rejection->created_by = $data['user_id'];
        $rejection->created_on = date('Y-m-d H:i:s');
        if ($rejection->save()) {
            foreach ($data['reasons'] as $reason_id) {
                $reason = new ErexxCollegeRejectionReasons();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $reason->erexx_college_rejection_reasons_enc_id = $utilitiesModel->encrypt();
                $reason->erexx_college_rejection_enc_id = $rejection->erexx_college_rejection_enc_id;
                $reason->reason_enc_id = $reason_id;
                $reason->created_by = $data['user_id'];
                $reason->created_on = date('Y-m-d H:i:s');
                if (!$reason->save()) {
                    print_r($reason->getErrors());
                    die();
                }
            }
        } else {
            print_r($rejection->getErrors());
            die();
        }
    }

    public function actionSaveReason()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();

            if (!isset($data['reason']) && empty($data['reason'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (!isset($data['reason_for']) && empty($data['reason_for'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $reason = new RejectionReasons();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $reason->rejection_reason_enc_id = $utilitiesModel->encrypt();
            $reason->reason = $data['reason'];
            $reason->reason_by = 0;
            $reason->reason_for = (int)$data['reason_for'];
            $reason->created_by = $user->user_enc_id;
            $reason->created_on = date('Y-m-d H:i:s');
            if ($reason->save()) {
                return $this->response(200, ['status' => 200, 'data' => ['rejection_reason_enc_id' => $reason->rejection_reason_enc_id, 'reason' => $reason->reason]]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
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

            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->select(['a.user_other_details_enc_id', 'a.user_enc_id',
                    'a.cgpa', 'a.university_roll_number', 'b.first_name', 'b.last_name',
                    'CONCAT(b.first_name, " " ,b.last_name) user_full_name',
                    'b.email', 'b.phone',
                    'a.starting_year', 'a.ending_year', 'a.semester', 'c.name',
                    'c1.course_name', 'b1.name city_name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->joinWith(['cityEnc b1']);
                }], false)
                ->joinWith(['assignedCollegeEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                }], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id'], 'a.college_actions' => 0]);
            if (isset($data['name']) && !empty($data['name'])) {
                $candidates->having(['like', 'user_full_name', $data['name']]);
            }
            if (isset($data['courses']) && !empty($data['courses'])) {
                $candidates->andWhere(['c1.course_name' => $data['courses']]);
            }
            if (isset($data['semesters']) && !empty($data['semesters'])) {
                $candidates->andWhere(['a.semester' => $data['semesters']]);
            }
            if (isset($data['roll_no']) && !empty($data['roll_no'])) {
                $candidates->andWhere(['like', 'a.university_roll_number', $data['roll_no']]);
            }
            $candidates = $candidates->asArray()
                ->all();

            if ($candidates) {
                foreach ($candidates as $key => $val) {
                    $candidates[$key]['loan_applied'] = $this->loanApplied($val['user_enc_id']);
                    $candidates[$key]['applied_companies'] = $this->appliedCompanies($val['user_enc_id']);
                    $candidates[$key]['applied_jobs'] = $this->appliedJobs($val['user_enc_id'], 'Jobs');
                    $candidates[$key]['applied_internships'] = $this->appliedJobs($val['user_enc_id'], 'Internships');
                }
            }

            return $this->response(200, ['status' => 200, 'all_candidates' => $candidates]);
        }
    }

    private function appliedJobs($user_id, $type)
    {
        $applied = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.applied_application_enc_id',
                'a.application_enc_id',
                'a.current_round',
                'g.name application_type',
                'b.slug',
                'b.status',
                'd.slug comp_slug',
                'd.name organization_name',
                'e2.name title',
                'e1.name profile',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
                'a.current_round',
//                'COUNT(CASE WHEN cc.is_completed = 1 THEN 1 END) as active',
//                'COUNT(cc.is_completed) total',
            ])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->innerJoinWith(['erexxEmployerApplications c']);
                $b->joinWith(['organizationEnc d']);
                $b->joinWith(['title e' => function ($e) {
                    $e->joinWith(['parentEnc e1']);
                    $e->joinWith(['categoryEnc e2']);
                }], false);
                $b->joinWith(['applicationTypeEnc g']);
            }], false)
            ->joinWith(['appliedApplicationLocations f' => function ($f) {
                $f->select(['f.application_location_enc_id', 'f.applied_application_enc_id', 'f.city_enc_id', 'f1.name city_name']);
                $f->joinWith(['cityEnc f1'], false);
            }])
            ->joinWith(['appliedApplicationProcesses cc' => function ($cc) {
                $cc->joinWith(['fieldEnc dd'], false);
                $cc->select(['cc.applied_application_enc_id', 'cc.process_enc_id', 'cc.field_enc_id', 'dd.field_name', 'dd.icon', 'dd.sequence']);
                $cc->orderBy('dd.sequence');
            }])
            ->where([
                'a.created_by' => $user_id,
                'a.is_deleted' => 0,
//                    'b.status' => 'Active',
                'b.is_deleted' => 0,
                'b.application_for' => 2,
                'd.is_erexx_approved' => 1,
                'd.has_placement_rights' => 1,
                'd.status' => 'Active',
                'd.is_deleted' => 0,
                'c.status' => 'Active',
                'c.is_deleted' => 0,
                'c.is_college_approved' => 1
            ])
            ->andWhere(['g.name' => $type])
            ->asArray()
            ->all();

        $i = 0;
        if ($applied) {
            foreach ($applied as $a) {
                $cities = [];
                foreach ($a['appliedApplicationLocations'] as $c) {
                    array_push($cities, $c['city_name']);
                }
                $applied[$i]['cities'] = implode(',', $cities);
                if ($a['status'] != 'Active') {
                    $applied[$i]['is_closed'] = true;
                } else {
                    $applied[$i]['is_closed'] = false;
                }
                $i++;
            }
        }

        return $applied;
    }

    private function loanApplied($user_id)
    {
        return LoanApplications::find()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.amount', 'a.status'])
            ->joinWith(['createdBy b' => function ($b) {
                $b->innerJoinWith(['userOtherDetails b1']);
            }], false)
            ->joinWith(['educationLoanPayments c'], false)
            ->where(['a.is_deleted' => 0, 'b1.user_enc_id' => $user_id, 'c.payment_status' => ['captured', 'created']])
            ->asArray()
            ->all();
    }

    private function appliedCompanies($user_id)
    {
        return AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.applied_application_enc_id',
                'a.application_enc_id', 'b2.name', 'b2.slug',
                'CASE WHEN b2.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b2.logo_location, "/", b2.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b2.name, "&size=200&rounded=false&background=", REPLACE(b2.initials_color, "#", ""), "&color=ffffff") END logo'
            ])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->innerJoinWith(['erexxEmployerApplications b1' => function ($b1) {
                    $b1->onCondition(['b1.is_deleted' => 0, 'b1.status' => 'Active']);
                }]);
                $b->joinWith(['organizationEnc b2']);
                $b->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                $b->groupBy(['b.organization_enc_id']);
            }], false)
            ->where(['a.is_deleted' => 0, 'a.created_by' => $user_id])
            ->asArray()
            ->all();
    }

    public function actionCourses()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'courses' => $courses]);
        }
    }

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
            $company_name = $param['company_name'];
            $company_location = $param['company_location'];

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
                    'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
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
                        'c.application_for' => 2
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
                ->joinWith(['organizationLabels h1' => function ($h) {
                    $h->select(['h1.organization_enc_id', 'h2.name']);
                    $h->joinWith(['labelEnc h2' => function ($h2) {
                        $h2->onCondition(['h2.is_deleted' => 0]);
                    }], false);
                    $h->onCondition(['h1.is_deleted' => 0, 'h1.label_for' => 1]);
                }])
                ->where([
                    'a.is_erexx_approved' => 1,
                    'a.has_placement_rights' => 1,
                    'a.status' => 'Active',
                    'a.is_deleted' => 0
                ])
                ->andWhere(['not', ['in', 'b.business_activity', ['College', 'Educational Institute', 'School']]]);
            if (!empty($sort_by)) {
                if ($sort_by == 'Approved') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)ASC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    ]);
                } elseif ($sort_by == 'Rejected') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    ]);
                } elseif ($sort_by == 'Pending') {
                    $companies->orderBy([
                        new \yii\db\Expression('FIELD (g.is_deleted, 1)ASC'),
                        new \yii\db\Expression('FIELD (g.organization_approvel, 1)DESC'),
                        new \yii\db\Expression('FIELD (g.college_approvel, 1)ASC'),
                        new \yii\db\Expression('FIELD (c.for_all_colleges, 1)DESC'),
                    ]);
                } elseif ($sort_by == 'Invite') {
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

            if (isset($param['filter']) && !empty($param['filter'])) {
                if ($param['filter'] == 'Verified') {
                    $companies->andWhere(['h2.name' => 'Verified']);
                } elseif ($param['filter'] == 'Hot') {
                    $companies->andWhere(['h2.name' => 'Hot']);
                } elseif ($param['filter'] == 'Featured') {
                    $companies->andWhere(['h2.name' => 'Featured']);
                } elseif ($param['filter'] == 'New') {
                    $companies->andWhere(['h2.name' => 'New']);
                } elseif ($param['filter'] == 'Promoted') {
                    $companies->andWhere(['h2.name' => 'Promoted']);
                } elseif ($param['filter'] == 'Trending') {
                    $companies->andWhere(['h2.name' => 'Trending']);
                }
            }

            if (!empty($company_name)) {
                $companies->andWhere(['like', 'a.name', $company_name]);
            }
            if (!empty($company_location)) {
                $companies->andWhere(['like', 'ff.name', $company_location]);
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

                    $org_labels = OrganizationLabels::find()
                        ->alias('a')
                        ->select([
                            'a.org_label_enc_id',
                            'a.label_enc_id',
                            'b.name'
                        ])
                        ->joinWith(['labelEnc b'])
                        ->where(['a.label_for' => 1, 'a.organization_enc_id' => $c['organization_enc_id'], 'a.is_deleted' => 0])
                        ->asArray()
                        ->all();

                    $labels = [];
                    if ($org_labels) {
                        foreach ($org_labels as $l) {
                            switch ($l['name']) {
                                case "Trending":
                                    $labels['Trending'] = true;
                                    break;
                                case "Promoted":
                                    $labels['Promoted'] = true;
                                    break;
                                case "New":
                                    $labels['New'] = true;
                                    break;
                                case "Hot":
                                    $labels['Hot'] = true;
                                    break;
                                case "Featured":
                                    $labels['Featured'] = true;
                                    break;
                                case "trendd":
                                    $labels['trendd'] = true;
                                    break;
                                case "Verified":
                                    $labels['Verified'] = true;
                                    break;
                            }
                        }
                    }

                    $companies[$i]['labels'] = $labels;

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
                    'c1.course_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
                ->joinWith(['userEnc b' => function ($b) {
                    $b->select(['b.user_enc_id']);
                }], true)
                ->joinWith(['assignedCollegeEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                }], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id']]);
            if (isset($data['course_name']) && !empty($data['course_name'])) {
                $candidates->andWhere(['c1.course_name' => $data['course_name']]);
            }
            if (isset($data['semester']) && !empty($data['semester']) && count($data['semester']) < 10) {
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

            if (isset($data['order']) && isset($data['order_type']) && !empty($data['order'])) {
                if ($data['order_type'] == 'asc') {
                    $candidates->orderBy([$data['order'] => SORT_ASC]);
                } else {
                    $candidates->orderBy([$data['order'] => SORT_DESC]);
                }
            } else {

                $candidates = $candidates->orderBy(
                    [
                        new \yii\db\Expression('college_actions IS NULL DESC,college_actions ASC')
                    ]
                );
            }
            $candidates = $candidates->asArray()
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

    public function actionTeachersInvitation()
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
            $mail->type = 2;
            $mail->email_receivers = $mails;
            $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
            $mail->email_template = 'teacher-invitation-email';
            if (!$mail->setEmailLog()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
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
            ->orderBy(['a.id' => SORT_ASC])
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

            $setting_id = ErexxSettings::find()
                ->where(['setting' => $name])
                ->asArray()
                ->one();

            $setting = CollegeSettings::find()
                ->where(['college_enc_id' => $collge_id, 'setting_enc_id' => $setting_id['setting_enc_id']])
                ->one();


            if ($setting) {
                $setting->value = $value;
                $setting->updated_by = $user->user_enc_id;
                $setting->updated_on = date('Y-m-d H:i:s');
                if ($setting->update()) {
                    if ($name == 'students_approve') {
                        $this->setCandidateApprove($collge_id);
                    } elseif ($name == 'jobs_approve') {
                        $this->autoJobsApprove($collge_id, $user->user_enc_id, 'Jobs', $name);
                    } elseif ($name == 'internships_approve') {
                        $this->autoJobsApprove($collge_id, $user->user_enc_id, 'Internships', $name);
                    } elseif ($name == 'auto_approve_companies_for_job_placement') {
                        $this->autoCompaniesApprove($collge_id, 'Jobs', 'auto_approve_companies_for_job_placement');
                    } elseif ($name == 'auto_approve_companies_for_internship_placement') {
                        $this->autoCompaniesApprove($collge_id, 'Internships', 'auto_approve_companies_for_internship_placement');
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
                    if ($name == 'students_approve') {
                        $this->setCandidateApprove($collge_id);
                    } elseif ($name == 'jobs_approve') {
                        $this->autoJobsApprove($collge_id, $user->user_enc_id, 'Jobs', $name);
                    } elseif ($name == 'internships_approve') {
                        $this->autoJobsApprove($collge_id, $user->user_enc_id, 'Internships', $name);
                    } elseif ($name == 'auto_approve_companies_for_job_placement') {
                        $this->autoCompaniesApprove($collge_id, 'Jobs', 'auto_approve_companies_for_job_placement');
                    } elseif ($name == 'auto_approve_companies_for_internship_placement') {
                        $this->autoCompaniesApprove($collge_id, 'Internships', 'auto_approve_companies_for_internship_placement');
                    }
                    return $this->response(200, ['status' => 200, 'data' => $this->getPrefrences()]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function autoJobsApprove($college_id, $user_id, $type, $name)
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
                    'y.interview_process_enc_id',
                    'bb.organization_enc_id',
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'dd.designation',
                    'z.name job_type',
                    'b.is_deleted'
                ])
                ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                    $b->onCondition(['b.college_enc_id' => $college_id]);
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
                    'z.name' => $type,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.is_deleted' => 0,
                    'bb.status' => 'Active',
                    'a.application_for' => 2,
                    'a.for_all_colleges' => 1,
                ])
                ->asArray()
                ->all();

            $data = [];
            $j = 0;
            $i = 0;
            foreach ($jobs as $r) {
                if ($r['is_deleted'] != 1) {
                    if ($r['is_college_approved'] != 1) {
                        array_push($data, $jobs[$j]);
                        $i++;
                    }
                }
                $j++;
            }

            foreach ($data as $j) {

                $erexx_collab = ErexxCollaborators::find()
                    ->where(['organization_enc_id' => $j['organization_enc_id'], 'college_enc_id' => $college_id, 'is_deleted' => 0])
                    ->asArray()
                    ->one();

                if ($erexx_collab && $erexx_collab['college_approvel'] == 1) {
                    $data = ErexxEmployerApplications::find()
                        ->where(['employer_application_enc_id' => $j['application_enc_id'], 'college_enc_id' => $college_id])
                        ->one();

                    if (!empty($data)) {
                        $data->is_college_approved = 1;
                        $data->last_updated_by = $user_id;
                        $data->last_updated_on = date('Y-m-d H:i:s');
                        $data->update();
                    } else {
                        $model = new ErexxEmployerApplications();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $model->application_enc_id = $utilitiesModel->encrypt();
                        $model->employer_application_enc_id = $j['application_enc_id'];
                        $model->college_enc_id = $college_id;
                        $model->is_college_approved = 1;
                        $model->created_by = $user_id;
                        $model->created_on = date('Y-m-d H:i:s');
                        $model->save();
                    }
                }
            }

        }
    }

    private function autoCompaniesApprove($college_id, $type, $name)
    {
        if ($user = $this->isAuthorized()) {

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
                $companies = Organizations::find()
                    ->alias('a')
                    ->distinct()
                    ->select([
                        'a.organization_enc_id',
                        'a.name organization_name',
                        'a.slug org_slug',
                        'e.business_activity',
                        'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
                        'g.college_approvel',
                        'g.organization_approvel',
                        'g.collaboration_enc_id',
                        'g.is_deleted'
                    ])
                    ->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                        $y->select(['c.organization_enc_id', 'c.application_enc_id', 'd.name']);
                        $y->joinWith(['applicationTypeEnc d'], false);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'c.for_all_colleges' => 1,
                            'c.application_for' => 2
                        ]);
                    }])
                    ->joinWith(['industryEnc h'], false)
                    ->joinWith(['businessActivityEnc e'], false)
                    ->joinWith(['erexxCollaborators0 g' => function ($g) use ($college_id) {
                        $g->onCondition(['g.college_enc_id' => $college_id]);
                    }], false)
                    ->where([
                        'a.is_deleted' => 0,
                        'a.status' => 'Active',
                        'a.has_placement_rights' => 1,
                        'a.is_erexx_approved' => 1,
                        'd.name' => $type,
                    ])
                    ->andWhere([
                        'or',
                        ['g.college_approvel' => null],
                        ['g.college_approvel' => 0],
                    ])
                    ->asArray()
                    ->all();

                if ($companies) {
                    foreach ($companies as $c) {
                        if ($c['is_deleted'] != 1) {

                            $approve = ErexxCollaborators::find()
                                ->where(['organization_enc_id' => $c['organization_enc_id'], 'college_enc_id' => $college_id, 'college_approvel' => 0])
                                ->one();

                            if (!empty($approve)) {

                                $approve->college_approvel = 1;
                                $approve->last_updated_by = $user->user_enc_id;
                                $approve->last_updated_on = date('Y-m-d H:i:s');
                                $approve->update();
                            } else {
                                $model = new ErexxCollaborators();
                                $utilitiesModel = new Utilities();
                                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                $model->collaboration_enc_id = $utilitiesModel->encrypt();
                                $model->organization_enc_id = $c['organization_enc_id'];
                                $model->college_enc_id = $college_id;
                                $model->organization_approvel = 1;
                                $model->college_approvel = 1;
                                $model->created_by = $user->user_enc_id;
                                $model->created_on = date('Y-m-d H:i:s');
                                $model->save();
                            }
                        }
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
            ->where(['a.college_enc_id' => $college_id, 'b.status' => 'Active', 'b.setting' => 'students_approve'])
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
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) END image',
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

    public function actionUserAppliedCompanies()
    {
        if ($user = $this->isAuthorized()) {
            $companies = Organizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.name'])
                ->joinWith(['employerApplications b' => function ($b) {
                    $b->innerJoinWith(['appliedApplications c' => function ($c) {
                        $c->innerJoinWith(['createdBy d' => function ($d) {
                            $d->innerJoinWith(['userOtherInfo e']);
                        }]);
                    }]);
                }], false)
                ->groupBy(['a.organization_enc_id'])
                ->where(['e.organization_enc_id' => $this->getOrgId()])
                ->asArray()
                ->all();
            if ($companies) {
                return $this->response(200, ['status' => 200, 'data' => $companies]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionEmptyJobs()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $param = Yii::$app->request->post();

            if (isset($param['limit']) && !empty($param['limit'])) {
                $limit = Yii::$app->request->post('limit');
            } else {
                $limit = 10;
            }

            if (!isset($param['type']) && empty($param['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $type = $param['type'];

            $jobs = ErexxEmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'a.employer_application_enc_id',
                    'a.is_college_approved',
                    'b.slug',
                    'b.status',
                    'b.last_date',
                    'b.joining_date',
                    'm.fixed_wage as fixed_salary',
                    'm.wage_type salary_type',
                    'm.max_wage as max_salary',
                    'm.min_wage as min_salary',
                    'm.wage_duration as salary_duration',
                    'dd.designation',
                    'z.name job_type',
                    'm.positions'
                ])
                ->joinWith(['employerApplicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc bb'], false);
                    $b->select(['b.application_enc_id', 'b.slug', 'y.interview_process_enc_id']);
                    $b->joinWith(['interviewProcessEnc y' => function ($y) {
                        $y->select(['y.interview_process_enc_id']);
                        $y->joinWith(['interviewProcessFields yy' => function ($yy) {
                            $yy->select(['yy.interview_process_enc_id', 'yy.sequence', 'yy.field_name']);
                        }]);
                    }]);
                    $b->joinWith(['applicationEducationalRequirements bc' => function ($bc) {
                        $bc->select(['bc.application_enc_id', 'cb.educational_requirement']);
                        $bc->joinWith(['educationalRequirementEnc cb'], false);
                    }]);
                    $b->joinWith(['applicationSkills bbc' => function ($bbc) {
                        $bbc->select(['bbc.application_enc_id', 'skill']);
                        $bbc->joinWith(['skillEnc cbb'], false);
                    }]);
                    $b->joinWith(['designationEnc dd'], false);
                    $b->joinWith(['title d' => function ($d) {
                        $d->joinWith(['parentEnc e']);
                        $d->joinWith(['categoryEnc ee']);
                    }], false);
                    $b->joinWith(['applicationOptions m'], false);
                    $b->joinWith(['applicationPlacementLocations f' => function ($f) {
                        $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                        $f->joinWith(['locationEnc ff' => function ($z) {
                            $z->joinWith(['cityEnc g']);
                        }], false);
                    }], true);
                    $b->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where([
                    'a.college_enc_id' => $college_id,
                    'a.is_deleted' => 0,
                    'b.is_deleted' => 0,
                    'bb.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.is_college_approved' => 1,
                    'b.application_for' => 2,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1
                ]);
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if ($limit) {
                $jobs->limit($limit);
            }
            $result = $jobs
                ->orderBy([new \yii\db\Expression('b.status = "Active" desc')])
                ->asArray()
                ->all();


            $i = 0;
            foreach ($result as $val) {
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 40 * 52 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 52 . ' p.a.';
                    } else {
                        $result[$i]['salary'] = $val['fixed_salary'] . ' p.a.';
                    }
                } elseif ($val['salary_type'] == "Negotiable") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . ' p.a.';
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . ' p.a.';
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 52) . ' p.a.';
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . ' p.a.';
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['max_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 52) . ' p.a.';
                        } else {
                            $result[$i]['salary'] = (string)($val['max_salary']) . ' p.a.';
                        }
                    }
                }
                $i++;
            }

            $resultt = [];
            foreach ($result as $j) {

                $count = AppliedApplications::find()
                    ->alias('a')
                    ->select(['COUNT(a.applied_application_enc_id) count'])
                    ->innerJoinWith(['createdBy f' => function ($f) {
                        $f->innerJoinWith(['userOtherInfo g']);
                        $f->onCondition(['f.is_deleted' => 0]);
                    }], false)
                    ->where(['a.application_enc_id' => $j['employerApplicationEnc']['application_enc_id'],
                        'a.is_deleted' => 0, 'g.organization_enc_id' => $college_id,
                        'g.is_deleted' => 0
                    ])
                    ->asArray()
                    ->one();

                $data = [];
                $locations = [];
                $educational_requirement = [];
                $skills = [];
                $positions = 0;
                $datetime1 = new \DateTime(date('Y-m-d', strtotime($j['created_on'])));
                $datetime2 = new \DateTime(date('Y-m-d'));

                $diff = $datetime1->diff($datetime2);
                $data['filling_soon'] = ($diff->days > 10) ? true : false;
                $data['name'] = $j['name'];
                $data['job_type'] = $j['job_type'];
                $data['logo'] = $j['logo'];
                $data['org_slug'] = $j['org_slug'];
                $data['title'] = $j['title'];
                $data['is_college_approved'] = $j['is_college_approved'];
                $data['slug'] = $j['slug'];
                $data['last_date'] = $j['last_date'];
                $data['joining_date'] = $j['joining_date'];
                $data['designation'] = $j['designation'];
                $data['salary'] = $j['salary'];
                if ($j['status'] != 'Active') {
                    $data['is_closed'] = true;
                } else {
                    $data['is_closed'] = false;
                }
                foreach ($j['employerApplicationEnc']['applicationPlacementLocations'] as $l) {
                    if (!in_array($l['name'], $locations)) {
                        array_push($locations, $l['name']);
                        $positions += $l['positions'];
                    }
                }

                foreach ($j['employerApplicationEnc']['applicationEducationalRequirements'] as $a) {
                    array_push($educational_requirement, $a['educational_requirement']);
                }

                foreach ($j['employerApplicationEnc']['applicationSkills'] as $s) {
                    array_push($skills, $s['skill']);
                }

                $data['is_exclusive'] = $this->__exclusiveJob($j['employer_application_enc_id']);
                $data['process'] = $j['employerApplicationEnc']['interviewProcessEnc']['interviewProcessFields'];
                $data['location'] = $locations ? implode(',', $locations) : 'Work From Home';
                $data['positions'] = $positions ? $positions : $j['positions'];
                $data['education'] = implode(',', $educational_requirement);
                $data['skills'] = implode(',', $skills);
                $data['applied_count'] = $count['count'];

                if ($count['count'] == 0) {
                    array_push($resultt, $data);
                }

            }

            return $this->response(200, ['status' => 200, 'data' => $resultt]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}