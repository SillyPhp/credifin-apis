<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\Applied;
use common\models\AnsweredQuestionnaire;
use common\models\AnsweredQuestionnaireFields;
use common\models\AppliedApplications;
use common\models\AssignedCollegeCourses;
use common\models\ClassNotes;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\OnlineClasses;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFields;
use common\models\ShortlistedApplications;
use common\models\UserCoachingTutorials;
use common\models\UserOtherDetails;
use common\models\Users;
use common\models\UserWebinarInterest;
use common\models\Webinar;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\Utilities;
use common\models\WebinarSessions;
use common\models\WidgetTutorials;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class CandhomeController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-data' => ['POST', 'OPTIONS'],
                'applied-applications' => ['POST', 'OPTIONS'],
                'all-notes' => ['POST', 'OPTIONS'],
                'get-course-list' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionGetData()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->one();

            $applied_count = AppliedApplications::find()
                ->alias('a')
                ->distinct()
                ->innerJoinWith(['applicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc bb']);
                    $b->innerJoinWith(['erexxEmployerApplications c']);
                }], false)
                ->where([
                    'a.created_by' => $id,
                    'a.is_deleted' => 0,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.status' => 'Active',
                    'bb.is_deleted' => 0,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'b.application_for' => [0, 2],
                    'c.is_deleted' => 0,
                    'c.status' => 'Active',
                    'c.is_college_approved' => 1
                ])
                ->count();

            $companies_cnt = ErexxCollaborators::find()
                ->alias('a')
                ->select(['COUNT(a.college_enc_id) companies_count'])
                ->joinWith(['organizationEnc bb'], false)
                ->where([
                    'a.college_enc_id' => $college_id['organization_enc_id'],
                    'a.is_deleted' => 0,
                    'a.organization_approvel' => 1,
                    'a.college_approvel' => 1,
                    'a.status' => 'Active',
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.status' => 'Active',
                    'bb.is_deleted' => 0
                ])
                ->asArray()
                ->all();


            $shortlisted_cnt = ShortlistedApplications::find()
                ->alias('a')
                ->distinct()
                ->joinWith(['applicationEnc c' => function ($c) {
                    $c->joinWith(['organizationEnc bb']);
                    $c->innerJoinWith(['erexxEmployerApplications cc']);
                }], false)
                ->where([
                    'a.created_by' => $id,
                    'a.shortlisted' => 1,
                    'cc.status' => 'Active',
                    'cc.is_deleted' => 0,
                    'cc.is_college_approved' => 1,
                    'c.status' => 'Active',
                    'c.is_deleted' => 0,
                    'c.application_for' => 2,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.status' => 'Active',
                    'bb.is_deleted' => 0,
                ])
                ->count();

            $companies = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($college_id) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name',
                        'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count',
                        'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count',
                        'b.slug org_slug',
                        'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $college_id,
                            'f.is_college_approved' => 1,
                            'f.status' => 'Active',
                            'f.is_deleted' => 0
                        ]);
                        $y->andWhere(['in', 'c.application_for', [0, 2]]);
                    }], false);
                    $x->joinWith(['organizationLabels g' => function ($g) {
                        $g->joinWith(['labelEnc gg']);
                    }], false);
                }])
                ->where([
                    'aa.college_enc_id' => $college_id,
                    'aa.organization_approvel' => 1,
                    'aa.college_approvel' => 1,
                    'aa.is_deleted' => 0,
                    'aa.status' => 'Active',
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0
                ])
                ->andWhere(['gg.name' => 'Featured', 'g.label_for' => 1, 'g.is_deleted' => 0])
                ->limit(6)
                ->asArray()
                ->all();

            $applied_jobs = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.applied_application_enc_id',
                    'a.application_enc_id',
                    'a.current_round',
                    'g.name application_type',
                    'b.slug',
                    'b.last_date',
                    'd.slug comp_slug',
                    'd.name organization_name',
                    'e2.name title',
                    'e1.name profile',
                    'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
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
                ->where([
                    'a.created_by' => $id,
                    'a.is_deleted' => 0,
                    'd.is_erexx_approved' => 1,
                    'd.has_placement_rights' => 1,
                    'd.is_deleted' => 0,
                    'd.status' => 'Active',
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'b.application_for' => [0, 2],
                    'c.status' => 'Active',
                    'c.is_deleted' => 0,
                    'c.is_college_approved' => 1
                ])
                ->andWhere(['g.name' => 'Jobs'])
                ->limit(6)
                ->asArray()
                ->all();

            $i = 0;
            foreach ($applied_jobs as $a) {
                $cities = [];
                foreach ($a['appliedApplicationLocations'] as $c) {
                    array_push($cities, $c['city_name']);
                }
                if ($a['last_date'] < date('Y-m-d')) {
                    $applied_jobs[$i]['is_closed'] = true;
                } else {
                    $applied_jobs[$i]['is_closed'] = false;
                }
                $applied_jobs[$i]['cities'] = implode(',', $cities);
                $i++;
            }

            $applied_internships = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.applied_application_enc_id',
                    'a.application_enc_id',
                    'a.current_round',
                    'g.name application_type',
                    'b.slug',
                    'b.last_date',
                    'd.slug comp_slug',
                    'd.name organization_name',
                    'e2.name title',
                    'e1.name profile',
                    'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
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
                ->where([
                    'a.created_by' => $id,
                    'a.is_deleted' => 0,
                    'd.is_erexx_approved' => 1,
                    'd.has_placement_rights' => 1,
                    'd.is_deleted' => 0,
                    'd.status' => 'Active',
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'b.application_for' => [0, 2],
                    'c.status' => 'Active',
                    'c.is_deleted' => 0,
                    'c.is_college_approved' => 1
                ])
                ->andWhere(['g.name' => 'Internships'])
                ->limit(6)
                ->asArray()
                ->all();

            $i = 0;
            foreach ($applied_internships as $a) {
                $cities = [];
                foreach ($a['appliedApplicationLocations'] as $c) {
                    array_push($cities, $c['city_name']);
                }
                if ($a['last_date'] < date('Y-m-d')) {
                    $applied_internships[$i]['is_closed'] = true;
                } else {
                    $applied_internships[$i]['is_closed'] = false;
                }
                $applied_internships[$i]['cities'] = $cities ? implode(',', $cities) : 'Work From Home';
                $i++;
            }

            $followed_org = ErexxCollaborators::find()
                ->alias('a')
                ->distinct()
                ->select(['a.collaboration_enc_id', 'a.organization_enc_id'])
                ->joinWith(['organizationEnc b' => function ($b) use ($id, $college_id) {
                    $b->groupBy('organization_enc_id');
                    $b->select(['b.organization_enc_id', 'b.name organization_name',
                        'count(CASE WHEN cc.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count',
                        'count(CASE WHEN cc.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $b->joinWith(['businessActivityEnc e'], false);
                    $b->joinWith(['employerApplications cc' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'cc.status' => 'Active',
                            'cc.is_deleted' => 0,
                            'f.college_enc_id' => $college_id,
                            'f.status' => 'Active',
                            'f.is_deleted' => 0,
                            'f.is_college_approved' => 1
                        ]);
                        $y->andWhere(['in', 'cc.application_for', [0, 2]]);
                    }], false);
                    $b->joinWith(['followedOrganizations c'], false);
                    $b->andWhere(['c.followed' => 1, 'c.user_enc_id' => $id]);
                    $b->joinWith(['businessActivityEnc e'], false);
                }])
                ->where([
                    'a.college_enc_id' => $college_id,
                    'a.organization_approvel' => 1,
                    'a.college_approvel' => 1,
                    'a.status' => 'Active',
                    'a.is_deleted' => 0,
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0
                ])
                ->limit(6)
                ->asArray()
                ->all();


            $counts = [
                'applied_cnt' => [0 => ['applied_count' => $applied_count]],
                'companies_cnt' => $companies_cnt,
                'shortlisted_cnt' => [0 => ['shortlisted_cnt' => $shortlisted_cnt]],
                'organization' => $companies,
                'applied_jobs' => $applied_jobs,
                'applied_internships' => $applied_internships,
                'followed' => $followed_org,
            ];
            return $this->response(200, $counts);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionShortlistedApplications()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            $limit = 0;
            if (isset($params['limit']) && !empty($params['limit'])) {
                $limit = (int)$params['limit'];
            }

            $shortlisted_applications = ShortlistedApplications::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.shortlisted_enc_id', 'a.application_enc_id',
                    'bb.name',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'dd.designation',
                    'z.name job_type',
                    'm.positions',
                    'c.application_enc_id',
                    'c.slug',
                    'c.status',
                    'c.last_date',
                    'c.joining_date',
                    'c.created_on',
                    'bb.organization_enc_id org_enc_id',
                    'bb.name',
                    'bb.slug org_slug',
                    'cc.employer_application_enc_id',
                    'cc.is_college_approved',
                ])
                ->joinWith(['applicationEnc c' => function ($c) {
                    $c->joinWith(['organizationEnc bb'], false);
                    $c->innerJoinWith(['erexxEmployerApplications cc'], false);
                    $c->joinWith(['designationEnc dd'], false)
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
                        ->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where([
                    'a.created_by' => $user->user_enc_id,
                    'a.shortlisted' => 1,
                    'cc.status' => 'Active',
                    'cc.is_deleted' => 0,
                    'cc.is_college_approved' => 1,
                    'c.status' => 'Active',
                    'c.is_deleted' => 0,
                    'c.application_for' => 2,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.status' => 'Active',
                    'bb.is_deleted' => 0,
                ]);
            if ($limit) {
                $shortlisted_applications->limit($limit);
            }
            $shortlisted_applications = $shortlisted_applications->asArray()
                ->all();


            if ($shortlisted_applications) {
                foreach ($shortlisted_applications as $k => $j) {
                    $locations = [];
                    $positions = 0;
                    $datetime1 = new \DateTime(date('Y-m-d', strtotime($j['created_on'])));
                    $datetime2 = new \DateTime(date('Y-m-d'));

                    $diff = $datetime1->diff($datetime2);
                    $shortlisted_applications[$k]['filling_soon'] = ($diff->days > 10) ? true : false;
                    if ($j['status'] != 'Active') {
                        $shortlisted_applications[$k]['is_closed'] = true;
                    } else {
                        $shortlisted_applications[$k]['is_closed'] = false;
                    }
                    foreach ($j['applicationEnc']['applicationPlacementLocations'] as $l) {
                        if (!in_array($l['name'], $locations)) {
                            array_push($locations, $l['name']);
                            $positions += $l['positions'];
                        }
                    }
                    $shortlisted_applications[$k]['is_exclusive'] = $this->__exclusiveJob($j['application_enc_id']);
                    $shortlisted_applications[$k]['location'] = $locations ? implode(',', $locations) : 'Work From Home';
                    if ($positions) {
                        $shortlisted_applications[$k]['positions'] = $positions;
                    } else {
                        $shortlisted_applications[$k]['positions'] = $j['positions'];
                    }
                }
                return $this->response(200, ['status' => 200, 'shortlisted' => $shortlisted_applications]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
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

    public function actionAppliedApplications()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $param = Yii::$app->request->post();

            if (isset($param['type']) && !empty($param['type'])) {
                $type = $param['type'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

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
                ->where([
                    'a.created_by' => $id,
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

            if ($applied) {
                return $this->response(200, ['status' => 200, 'data' => $applied]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionOnlineClasses()
    {
        if ($user = $this->isAuthorized()) {

            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('y-m-d');
            $time_now = $dt->format('H:i:s');

            $user = Users::find()
                ->alias('a')
                ->select(['a.user_enc_id', 'a.username', 'b.starting_year', 'b.assigned_college_enc_id', 'b.section_enc_id', 'b.semester', 'b.organization_enc_id college_id'])
                ->innerJoinWith(['userOtherInfo b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $classes = OnlineClasses::find()
                ->alias('a')
                ->select(
                    [
                        'a.class_enc_id',
                        'a.class_date',
                        'a.start_time',
                        'a.end_time',
                        'CONCAT(b1.first_name," ",b1.last_name) teacher_name',
                        'dd.course_name',
                        'a.semester',
                        'a.subject_name',
                        'a.class_type'
                    ])
                ->joinWith(['teacherEnc b' => function ($b) {
                    $b->joinWith(['userEnc b1'], false);
                    $b->joinWith(['collegeEnc c'], false);
                }], false)
                ->joinWith(['assignedCollegeEnc d' => function ($d) {
                    $d->joinWith(['courseEnc dd']);
                }], false)
                ->where([
                    'a.status' => 'Active',
                    'a.is_deleted' => 0,
                    'c.organization_enc_id' => $user['college_id']
                ])
                ->andWhere(
                    [
                        'a.semester' => $user['semester'],
                        'a.assigned_college_enc_id' => $user['course_enc_id'],
                        'a.section_enc_id' => $user['section_enc_id']
                    ])
                ->andWhere(['a.class_date' => $date_now])
                ->andWhere(['>=', 'a.end_time', $time_now])
                ->orderBy(['a.class_date' => SORT_ASC, 'a.start_time' => SORT_ASC])
                ->orderBy([new \yii\db\Expression('a.class_type = "Live" desc')])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($classes as $c) {
                $seconds = $this->timeDifference($c['start_time'], $c['class_date']);
                $classes[$i]['is_live'] = ($c['class_type'] == "Live" ? true : false);
                $classes[$i]['seconds'] = $seconds;
                $classes[$i]['is_started'] = ($seconds < 0 ? true : false);
                $i++;
            }

            if ($classes) {
                return $this->response(200, ['status' => 200, 'data' => $classes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAllNotes()
    {
        if ($user = $this->isAuthorized()) {

            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('y-m-d');
            $time_now = $dt->format('H:i:s');

            $user = Users::find()
                ->alias('a')
                ->select(['a.user_enc_id', 'a.username', 'b.starting_year', 'b.assigned_college_enc_id', 'b.section_enc_id', 'b.semester', 'b.organization_enc_id college_id'])
                ->innerJoinWith(['userOtherInfo b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $notes = ClassNotes::find()
                ->distinct()
                ->alias('a')
                ->select(
                    [
                        'a.class_enc_id',
                        'b.class_date',
                        'b.start_time',
                        'b.end_time',
                        'CONCAT(b2.first_name," ",b2.last_name) teacher_name',
                        'dd.course_name',
                        'b.subject_name',
                        'a.note',
                        'a.title',
                        'b.class_type'
                    ]
                )
                ->joinWith(['classEnc b' => function ($b) {
                    $b->joinWith(['teacherEnc b1' => function ($b) {
                        $b->joinWith(['userEnc b2'], false);
                        $b->joinWith(['collegeEnc b3'], false);
                    }], false);
                    $b->joinWith(['assignedCollegeEnc d' => function ($d) {
                        $d->joinWith(['courseEnc dd']);
                    }], false);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'b.is_deleted' => 0,
                    'b3.organization_enc_id' => $user['college_id']])
                ->andWhere(
                    [
                        'b.semester' => $user['semester'],
                        'b.assigned_college_enc_id' => $user['course_enc_id'],
                        'b.section_enc_id' => $user['section_enc_id']
                    ])
                ->andWhere(['<=', 'b.class_date', $date_now])
                ->orderBy(['b.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($notes as $n) {
                $link = $this->getFile($n['note']);
                $notes[$i]['link'] = $link;
                $i++;
            }

            if ($notes) {
                return $this->response(200, ['status' => 200, 'data' => $notes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function getFile($file_name)
    {
        $bucketName = 'mec-uploads';
        $access_key = 'AKIATDLKTDI76APKFGXO';
        $secret_key = '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';
        $s3 = new S3Client([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => $access_key,
                'secret' => $secret_key,
            ]
        ]);

        $url = $s3->getObjectUrl($bucketName, 'online_class_notes/' . $file_name);
        return $url;

    }

    public function actionGetUpcomingClasses()
    {
        if ($user = $this->isAuthorized()) {

            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('y-m-d');

            $user = Users::find()
                ->alias('a')
                ->select(['a.user_enc_id', 'a.username', 'b.starting_year', 'b.assigned_college_enc_id', 'b.section_enc_id', 'b.semester', 'b.organization_enc_id college_id'])
                ->innerJoinWith(['userOtherInfo b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $classes = OnlineClasses::find()
                ->alias('a')
                ->select(
                    [
                        'a.class_enc_id',
                        'a.class_date',
                        'a.start_time',
                        'a.end_time',
                        'CONCAT(b1.first_name," ",b1.last_name) teacher_name',
                        'dd.course_name',
                        'a.semester',
                        'a.subject_name'
                    ])
                ->joinWith(['teacherEnc b' => function ($b) {
                    $b->joinWith(['userEnc b1'], false);
                    $b->joinWith(['collegeEnc c'], false);
                }], false)
                ->joinWith(['assignedCollegeEnc d' => function ($d) {
                    $d->joinWith(['courseEnc dd']);
                }], false)
                ->where([
                    'a.status' => 'Active',
                    'a.is_deleted' => 0,
                    'c.organization_enc_id' => $user['college_id']])
                ->andWhere(
                    [
                        'a.semester' => $user['semester'],
                        'a.assigned_college_enc_id' => $user['course_enc_id'],
                        'a.section_enc_id' => $user['section_enc_id']
                    ])
                ->andWhere(['>', 'a.class_date', $date_now])
                ->orderBy(['a.class_date' => SORT_ASC, 'a.start_time' => SORT_ASC])
                ->asArray()
                ->all();

            if ($classes) {
                return $this->response(200, ['status' => 200, 'data' => $classes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function timeDifference($start_time, $date)
    {
        $datetime = new \DateTime();
        $timezone = new \DateTimeZone('Asia/Kolkata');
        $datetime->setTimezone($timezone);
        $time1 = $datetime->format('y-m-d H:i:s');

        $seconds = strtotime($date . $start_time) - strtotime($time1);

        return $seconds;
    }

    public function actionGetWebinar()
    {
        if ($user = $this->isAuthorized()) {

            $user_id = $user->user_enc_id;

            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $user_id])
                ->asArray()
                ->one();

            $webinar = new \common\models\extended\Webinar();
            $webinar = $webinar->webinarsList($college_id['organization_enc_id']);

            $webinars = [];
            if (!empty($webinar)) {
                $i = 0;
                foreach ($webinar as $w) {
                    $registered_count = WebinarRegistrations::find()
                        ->where(['is_deleted' => 0, 'status' => 1, 'webinar_enc_id' => $w['webinar_enc_id']])
                        ->count();
                    $webinar[$i]['count'] = $registered_count;
                    $user_registered = $this->userRegistered($w['webinar_enc_id'], $user_id);
                    $webinar[$i]['is_registered'] = $user_registered;
                    $webinar[$i]['is_paid'] = $w['price'] ? true : false;
                    if ($w['webinarEvents']) {
                        array_push($webinars, $webinar[$i]);
                    }
                    $i++;
                }
            }

            if ($webinars) {
                return $this->response(200, ['status' => 200, 'data' => $webinars]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionJoinWebinar()
    {
        if ($user = $this->isAuthorized()) {

            $param = Yii::$app->request->post();

            if (isset($param['webinar_id']) && !empty($param['webinar_id'])) {
                $webinar_id = $param['webinar_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $register_user = WebinarRegistrations::find()
                ->where(['webinar_enc_id' => $webinar_id, 'created_by' => $user->user_enc_id])
                ->one();

            if ($register_user) {
                $register_user->status = 1;
                $register_user->last_updated_on = date('Y-m-d H:i:s');
                $register_user->last_updated_by = $user->user_enc_id;
                if ($register_user->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'Joined Successfully']);
                }
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
//                return $this->response(409, ['status' => 409, 'message' => 'already registered']);
            }

            $webinar = Webinars::findOne(['webinar_enc_id' => $webinar_id]);
            $webinarSession = WebinarSessions::findOne(['session_enc_id' => $webinar->session_enc_id]);
            if (!$webinarSession) {
                return $this->response(409, ['status' => 409, 'message' => 'Session not created..']);
            }

            $model = new WebinarRegistrations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->register_enc_id = $utilitiesModel->encrypt();
            $model->webinar_enc_id = $webinar_id;
            $model->status = 1;
            $model->created_by = $user->user_enc_id;
            $model->created_on = date('Y-m-d h:i:s');
            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'sessionEnc' => $webinarSession, 'message' => 'Joined Successfully']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionWebinarDetail()
    {
        $param = Yii::$app->request->post();

        if (isset($param['webinar_id']) && !empty($param['webinar_id'])) {
            $webinar_id = $param['webinar_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if ($user = $this->isAuthorized()) {

            $user_id = $user->user_enc_id;

            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $user_id])
                ->asArray()
                ->one();

            $webinar = new \common\models\extended\Webinar();
            $webinar = $webinar->webinarDetail($college_id['organization_enc_id'], $webinar_id);
        } else {
            $webinar = new \common\models\extended\Webinar();
            $webinar = $webinar->webinarDetail(null, $webinar_id);
        }

        if (!empty($webinar)) {
            if ($user = $this->isAuthorized()) {
                $user_id = $user->user_enc_id;
                $user_registered = $this->userRegistered($webinar['webinar_enc_id'], $user_id);
                $webinar['interest_status'] = $this->interested($webinar['webinar_enc_id'], $user_id);
            }else{
                $user_registered = 0;
                $webinar['interest_status'] = null;
            }
            $registered_count = WebinarRegistrations::find()
                ->where(['is_deleted' => 0, 'status' => 1, 'webinar_enc_id' => $webinar['webinar_enc_id']])
                ->count();
            $webinar['registered_count'] = $registered_count;

            $webinar['is_registered'] = $user_registered;

            $date = new \DateTime($webinar['event']['start_datetime']);
            $seconds = $this->timeDifference($date->format('H:i:s'), $date->format('Y-m-d'));
            $webinar['seconds'] = $seconds;
            $webinar['is_started'] = ($seconds < 0 ? true : false);
            foreach ($webinar['events'] as $k => $a) {
                $j = 0;
                foreach ($a as $t) {
                    $date = new \DateTime($t['start_datetime']);
                    $seconds = $this->timeDifference($date->format('H:i:s'), $date->format('Y-m-d'));
                    $is_started = ($seconds < 0 ? true : false);
                    $webinar['events'][$k][$j]['seconds'] = $seconds;
                    $webinar['events'][$k][$j]['is_started'] = $is_started;
                    $j++;
                }
            }
        }

        if ($webinar) {
            return $this->response(200, ['status' => 200, 'data' => $webinar]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    private function userRegistered($webinar_id, $user_id)
    {
        return WebinarRegistrations::find()
            ->where(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id, 'status' => 1, 'is_deleted' => 0])
            ->exists();
    }

    private function interested($webinar_id, $user_id)
    {
        $interest = UserWebinarInterest::find()
            ->select(['interest_status'])
            ->where(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id])
            ->asArray()
            ->one();

        return $interest['interest_status'];
    }

    public function actionChangeStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['webinar_enc_id']) && empty($params['webinar_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
            if (!isset($params['status']) && empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
            $already_exists = UserWebinarInterest::find()
                ->where(['created_by' => $user->user_enc_id, 'webinar_enc_id' => $params['webinar_enc_id']])
                ->one();

            if ($already_exists) {
                $already_exists->interest_status = $params['status'];
                $already_exists->last_updated_on = date('Y-m-d H:i:s');
                $already_exists->last_updated_by = $user->user_enc_id;
                if ($already_exists->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'updated']);
                }
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            } else {
                $reg = new UserWebinarInterest();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $reg->webinar_interest_enc_id = $utilitiesModel->encrypt();
                $reg->webinar_enc_id = $params['webinar_enc_id'];
                $reg->created_by = $user->user_enc_id;
                $reg->interest_status = $params['status'];
                $reg->created_on = date('Y-m-d H:i:s');
                if ($reg->save()) {
                    return $this->response(200, ['status' => 200, 'message' => 'updated']);
                }
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCollegeCourses()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($college_id) {
                $courses = AssignedCollegeCourses::find()
                    ->distinct()
                    ->alias('a')
                    ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                    ->joinWith(['courseEnc c'], false)
                    ->joinWith(['collegeSections b' => function ($b) {
                        $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                        $b->onCondition(['b.is_deleted' => 0]);
                    }], false)
                    ->where(['a.organization_enc_id' => $college_id['organization_enc_id'], 'a.is_deleted' => 0])
//                    ->groupBy(['a.course_name'])
                    ->asArray()
                    ->all();
                if ($courses) {
                    return $this->response(200, ['status' => 200, 'courses' => $courses]);
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetCourseList()
    {
        $params = Yii::$app->request->post();
        if ($params['id']) {
            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }], false)
                ->where(['a.organization_enc_id' => $params['id'], 'a.is_deleted' => 0])
//                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();
            if ($courses) {
                return $this->response(200, ['status' => 200, 'courses' => $courses]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionQuestionnaire()
    {
        if ($user = $this->isAuthorized()) {

            $college_id = UserOtherDetails::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->one();

            $applications = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.applied_application_enc_id', 'a.current_round', 'b.slug'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->innerJoinWith(['erexxEmployerApplications c']);
                }], false)
                ->where(['a.created_by' => $user->user_enc_id, 'a.is_deleted' => 0, 'c.college_enc_id' => $college_id->organization_enc_id, 'c.is_college_approved' => 1])
                ->andWhere(['a.status' => ['Accepted', 'Incomplete']])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();

            $object = new Applied();
            $question = [];
            foreach ($applications as $v) {
                $array = $object->getCurrentQuestions($v['applied_application_enc_id'], $v['current_round'], $user->user_enc_id);
                if (!empty($array)) {
                    $question[] = $array;
                }
            }

            if ($question) {
                return $this->response(200, ['status' => 200, 'data' => $question]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionQuestionnaireFields()
    {

        if ($user = $this->isAuthorized()) {
            $parameters = \Yii::$app->request->post();

            if (isset($parameters['questionnaire_enc_id']) && !empty($parameters['questionnaire_enc_id'])) {
                $q_enc_id = $parameters['questionnaire_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }

            if (isset($parameters['applied_application_enc_id']) && !empty($parameters['applied_application_enc_id'])) {
                $applied_application_enc_id = $parameters['applied_application_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }

            $chk = AnsweredQuestionnaire::find()
                ->where([
                    'applied_application_enc_id' => $applied_application_enc_id,
                    'questionnaire_enc_id' => $q_enc_id,
                    'created_by' => $user->user_enc_id,
                ])
                ->asArray()
                ->one();

            if ($chk) {
                return $this->response(409, ['status' => 409, 'message' => 'already filled']);
            }

            $fields = QuestionnaireFields::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
                ->joinWith(['questionnaireFieldOptions b' => function ($a) {
                    $a->select(['b.field_option_enc_id', 'b.field_enc_id', 'b.field_option']);
                }], true)
                ->where(['a.questionnaire_enc_id' => $q_enc_id])
                ->groupBy(['a.field_enc_id'])
                ->orderBy('a.sequence')
                ->asArray()
                ->all();

            if (!empty($fields)) {
                return $this->response(200, ['status' => 200, 'data' => $fields]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionFillQuestionnaire()
    {
        if ($user = $this->isAuthorized()) {
            $parameters = \Yii::$app->request->post();

            if (isset($parameters['questionnaire_enc_id']) && !empty($parameters['questionnaire_enc_id'])) {
                $questionnaire_id = $parameters['questionnaire_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }

            if (isset($parameters['applied_application_enc_id']) && !empty($parameters['applied_application_enc_id'])) {
                $applied_application_id = $parameters['applied_application_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }

            $data = $parameters['data'];

            $answered_model = new AnsweredQuestionnaire();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $answered_model->answered_questionnaire_enc_id = $utilitiesModel->encrypt();
            $answered_model->applied_application_enc_id = $applied_application_id;
            $answered_model->questionnaire_enc_id = $questionnaire_id;
            $answered_model->created_by = $user->user_enc_id;
            $answered_model->created_on = date('Y-m-d H:i:s');
            if ($answered_model->save()) {
                foreach ($data as $d) {

                    if ($d['field_type'] == 'text' || $d['field_type'] == 'textarea' || $d['field_type'] == 'number' || $d['field_type'] == 'date' || $d['field_type'] == 'time') {
                        $field_model = new AnsweredQuestionnaireFields();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $field_model->answer_enc_id = $utilitiesModel->encrypt();
                        $field_model->answered_questionnaire_enc_id = $answered_model->answered_questionnaire_enc_id;
                        $field_model->field_enc_id = $d['field_enc_id'];
                        $field_model->answer = $d['answer'];
                        $field_model->created_on = date('Y-m-d H:i:s');
                        $field_model->created_by = $user->user_enc_id;
                        if (!$field_model->save()) {
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                        }
                    }

                    if ($d['field_type'] == 'select' || $d['field_type'] == 'radio') {
                        $field_model = new AnsweredQuestionnaireFields();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $field_model->answer_enc_id = $utilitiesModel->encrypt();
                        $field_model->answered_questionnaire_enc_id = $answered_model->answered_questionnaire_enc_id;
                        $field_model->field_enc_id = $d['field_enc_id'];
                        $field_model->field_option_enc_id = $d['option_enc_id'];
                        $field_model->created_on = date('Y-m-d H:i:s');
                        $field_model->created_by = $user->user_enc_id;
                        if (!$field_model->save()) {
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                        }
                    }

                    if ($d['field_type'] == 'checkbox') {
                        foreach ($d['options'] as $option) {
                            $utilitiesModel = new Utilities();
                            $fieldsModel = new AnsweredQuestionnaireFields;
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                            $fieldsModel->answered_questionnaire_enc_id = $answered_model->answered_questionnaire_enc_id;
                            $fieldsModel->field_enc_id = $d['field_enc_id'];
                            $fieldsModel->field_option_enc_id = $option;
                            $fieldsModel->created_on = date('Y-m-d H:i:s');
                            $fieldsModel->created_by = $user->user_enc_id;
                            if (!$fieldsModel->save()) {
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                            }
                        }
                    }
                }
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'problem in saving questionnaire']);
            }

            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['status' => 'Pending', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['applied_application_enc_id' => $applied_application_id])
                ->execute();
            if ($update) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        }
    }

    public function actionNotInterested()
    {
        if ($user = $this->isAuthorized()) {

            $id = WidgetTutorials::findone(['name' => 'not_interested_for_loans']);
            if ($id) {
                $tutorial = new UserCoachingTutorials();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $tutorial->user_coaching_tutorial_enc_id = $utilitiesModel->encrypt();
                $tutorial->tutorial_enc_id = $id->tutorial_enc_id;
                $tutorial->created_by = $user->user_enc_id;
                $tutorial->created_on = date('Y-m-d H:i:s');
                $tutorial->is_viewed = 1;
                if ($tutorial->save()) {
                    return $this->response(200, ['status' => 200, 'message' => 'saved']);
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

}