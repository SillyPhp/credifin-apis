<?php

namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\AssignedWebinarTo;
use common\models\ClassNotes;
use common\models\ErexxCollaborators;
use common\models\FollowedOrganizations;
use common\models\OnlineClasses;
use common\models\Organizations;
use common\models\ShortlistedApplications;
use common\models\UserAccessTokens;
use common\models\UserOtherDetails;
use common\models\Users;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\Utilities;
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
                ->where(['a.created_by' => $id, 'a.is_deleted' => 0, 'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1])
                ->count();

            $companies_cnt = ErexxCollaborators::find()
                ->alias('a')
                ->select(['COUNT(a.college_enc_id) companies_count'])
                ->joinWith(['organizationEnc bb'])
                ->where(['a.college_enc_id' => $college_id['organization_enc_id'], 'a.is_deleted' => 0, 'a.organization_approvel' => 1, 'a.college_approvel' => 1, 'bb.is_erexx_approved' => 1, 'bb.has_placement_rights' => 1])
                ->asArray()
                ->all();

            $shortlisted_cnt = ShortlistedApplications::find()
                ->alias('a')
                ->distinct()
                ->joinWith(['applicationEnc c' => function ($c) {
                    $c->joinWith(['organizationEnc bb']);
                    $c->innerJoinWith(['erexxEmployerApplications cc']);
                }], false)
                ->where(['a.created_by' => $id, 'a.shortlisted' => 1,
                    'cc.status' => 'Active', 'cc.is_deleted' => 0, 'bb.is_erexx_approved' => 1, 'bb.has_placement_rights' => 1])
                ->count();

            $companies = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($college_id) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $college_id
                        ]);
                        $y->andWhere(['in', 'c.application_for', [0, 2]]);
                    }], false);
                }])
                ->where(['aa.college_enc_id' => $college_id,
                    'aa.organization_approvel' => 1,
                    'aa.college_approvel' => 1,
                    'aa.is_deleted' => 0,
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1])
                ->limit(6)
                ->asArray()
                ->all();

            $applied_applications = AppliedApplications::find()
                ->alias('a')
                ->select(['DISTINCT(a.application_enc_id) application_enc_id', 'a.current_round'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->innerJoinWith(['erexxEmployerApplications c']);
                    $b->joinWith(['organizationEnc d']);
                    $b->joinWith(['title e' => function ($e) {
                        $e->joinWith(['parentEnc e1']);
                        $e->joinWith(['categoryEnc e2']);
                    }], false);
                    $b->joinWith(['applicationPlacementLocations f' => function ($f) use ($b) {
                        $b->select(['b.application_enc_id',
                            'b.title',
                            'b.slug',
                            'd.slug comp_slug',
                            'e1.category_enc_id',
                            'g.name city',
                            'e2.name profile',
                            'e1.name parent_name',
                            'b.organization_enc_id',
                            'd.name organization_name',
                            'CONCAT("' . Url::to('/', 'https') . '", d.slug) profile_link',
                            'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
                            'f.placement_location_enc_id',
                            'COUNT(f.placement_location_enc_id) cnt']);
                        $f->joinWith(['locationEnc f1' => function ($f1) {
                            $f1->joinWith(['cityEnc g']);
                        }], false);
                        $b->groupBy('f.placement_location_enc_id');
                    }]);
                }])
                ->where(['a.created_by' => $id, 'a.is_deleted' => 0, 'd.is_erexx_approved' => 1, 'd.has_placement_rights' => 1])
                ->limit(6)
                ->asArray()
                ->all();

            $followed_org = ErexxCollaborators::find()
                ->alias('a')
                ->distinct()
                ->select(['a.collaboration_enc_id', 'a.organization_enc_id'])
                ->joinWith(['organizationEnc b' => function ($b) use ($id, $college_id) {
                    $b->groupBy('organization_enc_id');
                    $b->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN cc.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN cc.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $b->joinWith(['businessActivityEnc e'], false);
                    $b->joinWith(['employerApplications cc' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'cc.status' => 'Active',
                            'cc.is_deleted' => 0,
                            'f.college_enc_id' => $college_id
                        ]);
                        $y->andWhere(['in', 'cc.application_for', [0, 2]]);
                    }], false);
                    $b->joinWith(['followedOrganizations c'], false);
                    $b->andWhere(['c.followed' => 1, 'c.user_enc_id' => $id]);
                    $b->joinWith(['businessActivityEnc e'], false);
                }])
                ->where(['a.college_enc_id' => $college_id, 'a.organization_approvel' => 1, 'a.college_approvel' => 1, 'a.is_deleted' => 0, 'b.is_erexx_approved' => 1, 'b.has_placement_rights' => 1])
                ->limit(6)
                ->asArray()
                ->all();

            $counts = [
                'applied_cnt' => [0 => ['applied_count' => $applied_count]],
                'companies_cnt' => $companies_cnt,
                'shortlisted_cnt' => [0 => ['shortlisted_cnt' => $shortlisted_cnt]],
                'organization' => $companies,
                'applied_application' => $applied_applications,
                'followed' => $followed_org,
            ];
            return $this->response(200, $counts);
        }
    }

    public function actionAppliedApplications()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $applied_applications = AppliedApplications::find()
                ->alias('a')
                ->select(['DISTINCT(a.application_enc_id) application_enc_id', 'a.current_round'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->innerJoinWith(['erexxEmployerApplications c']);
                    $b->joinWith(['organizationEnc d']);
                    $b->joinWith(['title e' => function ($e) {
                        $e->joinWith(['parentEnc e1']);
                        $e->joinWith(['categoryEnc e2']);
                    }], false);
                    $b->joinWith(['applicationPlacementLocations f' => function ($f) use ($b) {
                        $b->select(['b.application_enc_id',
                            'b.title',
                            'b.slug',
                            'd.slug comp_slug',
                            'e1.category_enc_id',
                            'g.name city',
                            'e2.name profile',
                            'e1.name parent_name',
                            'b.organization_enc_id',
                            'd.name organization_name',
                            'CONCAT("' . Url::to('/', 'https') . '", d.slug) profile_link',
                            'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
                            'f.placement_location_enc_id',
                            'COUNT(f.placement_location_enc_id) cnt']);
                        $f->joinWith(['locationEnc f1' => function ($f1) {
                            $f1->joinWith(['cityEnc g']);
                        }], false);
                        $b->groupBy('f.placement_location_enc_id');
                    }]);
                }])
                ->where(['a.created_by' => $id, 'a.is_deleted' => 0, 'd.is_erexx_approved' => 1, 'd.has_placement_rights' => 1])
                ->limit(6)
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $applied_applications]);
        } else {
            return false;
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
                ->select(['a.user_enc_id', 'a.username', 'b.starting_year', 'b.course_enc_id', 'b.section_enc_id', 'b.semester', 'b.organization_enc_id college_id'])
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
                        'd.course_name',
                        'a.semester',
                        'a.subject_name',
                        'a.class_type'
                    ])
                ->joinWith(['teacherEnc b' => function ($b) {
                    $b->joinWith(['userEnc b1'], false);
                    $b->joinWith(['collegeEnc c'], false);
                }], false)
                ->joinWith(['courseEnc d'], false)
                ->where(['a.status' => 'Active', 'a.is_deleted' => 0, 'c.organization_enc_id' => $user['college_id']])
                ->andWhere(
                    [
                        'a.semester' => $user['semester'],
                        'a.course_enc_id' => $user['course_enc_id'],
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
                ->select(['a.user_enc_id', 'a.username', 'b.starting_year', 'b.course_enc_id', 'b.section_enc_id', 'b.semester', 'b.organization_enc_id college_id'])
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
                        'd.course_name',
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
                    $b->joinWith(['courseEnc d'], false);
                }], false)
                ->where(['a.is_deleted' => 0, 'b.is_deleted' => 0, 'b3.organization_enc_id' => $user['college_id']])
                ->andWhere(
                    [
                        'b.semester' => $user['semester'],
                        'b.course_enc_id' => $user['course_enc_id'],
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
                ->select(['a.user_enc_id', 'a.username', 'b.starting_year', 'b.course_enc_id', 'b.section_enc_id', 'b.semester', 'b.organization_enc_id college_id'])
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
                        'd.course_name',
                        'a.semester',
                        'a.subject_name'
                    ])
                ->joinWith(['teacherEnc b' => function ($b) {
                    $b->joinWith(['userEnc b1'], false);
                    $b->joinWith(['collegeEnc c'], false);
                }], false)
                ->joinWith(['courseEnc d'], false)
                ->where(['a.status' => 'Active', 'a.is_deleted' => 0, 'c.organization_enc_id' => $user['college_id']])
                ->andWhere(
                    [
                        'a.semester' => $user['semester'],
                        'a.course_enc_id' => $user['course_enc_id'],
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

            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('Y-m-d H:i:s');

            $user_id = $user->user_enc_id;

            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $user_id])
                ->asArray()
                ->one();

            $webinar = Webinars::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.webinar_enc_id',
                    'a.title',
                    'a.start_datetime',
                    'a.end_datetime',
                    'a.availability',
                    'a.image',
                    'a.image_location',
                    'a.description',
                ])
                ->joinWith(['assignedWebinarTos b'], false)
                ->joinWith(['webinarRegistrations d' => function ($d) {
                    $d->select(['d.webinar_enc_id',
                        'd.register_enc_id',
                        'd.register_enc_id',
                        'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                    ]);
                    $d->joinWith(['createdBy d1'], false);
                    $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
                }])
                ->joinWith(['assignedWebinarTopics c' => function ($c) {
                    $c->select(['c.webinar_enc_id', 'c1.name']);
                    $c->joinWith(['topicEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['b.organization_enc_id' => $college_id['organization_enc_id'], 'a.is_deleted' => 0])
                ->andWhere(['>=', 'a.end_datetime', $date_now])
                ->asArray()
                ->all();

            if (!empty($webinar)) {
                $i = 0;
                foreach ($webinar as $w) {
                    $user_registered = $this->userRegistered($w['webinar_enc_id'], $user_id);
                    $webinar[$i]['is_registered'] = $user_registered;
                    $i++;
                }
            }

            if ($webinar) {
                return $this->response(200, ['status' => 200, 'data' => $webinar]);
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
                return $this->response(409, ['status' => 409, 'message' => 'already registered']);
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
                return $this->response(200, ['status' => 200, 'message' => 'Joined Successfully']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionWebinarDetail()
    {
        if ($user = $this->isAuthorized()) {

            $user_id = $user->user_enc_id;

            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $user_id])
                ->asArray()
                ->one();

            $param = Yii::$app->request->post();

            if (isset($param['webinar_id']) && !empty($param['webinar_id'])) {
                $webinar_id = $param['webinar_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $webinar = Webinars::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.webinar_enc_id',
                    'a.title',
                    'a.start_datetime',
                    'a.end_datetime',
                    'a.availability',
                    'a.image',
                    'a.image_location',
                    'a.description',
                ])
                ->joinWith(['assignedWebinarTos b'], false)
                ->joinWith(['webinarSpeakers bb' => function ($bb) {
                    $bb->select(['bb.webinar_enc_id',
                        'bb.user_enc_id', 'bb1.first_name',
                        'bb1.last_name', 'bb1.username',
                        'bb1.description',
                        'CASE WHEN bb1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", bb1.image_location, "/", bb1.image) END image'
                    ]);
                    $bb->joinWith(['userEnc bb1'], false);
                    $bb->onCondition(['bb.is_deleted' => 0]);
                }])
                ->joinWith(['webinarRegistrations d' => function ($d) {
                    $d->select(['d.webinar_enc_id',
                        'd.register_enc_id',
                        'd.register_enc_id',
                        'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                    ]);
                    $d->joinWith(['createdBy d1'], false);
                    $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
                }])
                ->joinWith(['assignedWebinarTopics c' => function ($c) {
                    $c->select(['c.webinar_enc_id', 'c1.name']);
                    $c->joinWith(['topicEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['b.organization_enc_id' => $college_id['organization_enc_id'], 'a.is_deleted' => 0, 'a.webinar_enc_id' => $webinar_id])
                ->asArray()
                ->one();

            if (!empty($webinar)) {

                $user_registered = $this->userRegistered($webinar['webinar_enc_id'], $user_id);
                $webinar['is_registered'] = $user_registered;
            }


            if ($webinar) {
                return $this->response(200, ['status' => 200, 'data' => $webinar]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function userRegistered($webinar_id, $user_id)
    {
        return WebinarRegistrations::find()
            ->where(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id])
            ->exists();
    }

//    public function actionGetCompanies()
//    {
//        $q = Organizations::find()
//            ->alias('a')
//            ->select(['a.organization_enc_id', 'a.name', 'CONCAT("' . Url::to('/', true) . '", a.slug) profile_link', 'd.business_activity', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
//            ->distinct()
//            ->joinWith(['employerApplications b' => function ($x) {
//                $x
//                    ->select(['b.organization_enc_id', 'COUNT(b.application_enc_id) application_type', 'c.name'])
//                    ->joinWith(['applicationTypeEnc c'], false)
//                    ->onCondition([
//                        'b.status' => 'Active',
//                        'b.is_deleted' => 0,
//                        'b.application_for' => 0
//                    ])
//                    ->orOnCondition([
//                        'b.status' => 'Active',
//                        'b.is_deleted' => 0,
//                        'b.application_for' => 2
//                    ])
//                    ->groupBy(['b.application_type_enc_id']);
//            }])
//            ->joinWith(['businessActivityEnc d'], false)
//            ->groupBy(['a.organization_enc_id'])
//            ->where([
//                'a.is_deleted' => 0,
//                'a.is_erexx_registered' => 1
//            ])
//            ->asArray()
//            ->all();
//
//        return $this->response(200, $q);
//    }
//
//    public function actionAppliedApplications()
//    {
//
//        $id = Yii::$app->request->post('id');
//
//        $q = AppliedApplications::find()
//            ->alias('a')
//            ->select(['a.application_enc_id', 'a.current_round'])
//            ->joinWith(['applicationEnc b' => function ($x) {
//                $x->joinWith(['organizationEnc d'], false);
//                $x->joinWith(['title h' => function ($y) {
//                    $y->joinWith(['parentEnc i']);
//                    $y->joinWith(['categoryEnc j']);
//                }], false);
//                $x->joinWith(['applicationPlacementLocations e' => function ($y) use ($x) {
//                    $x->select(['b.application_enc_id', 'b.title', 'i.category_enc_id', 'g.name city', 'j.name profile', 'i.name parent_name', 'b.organization_enc_id', 'd.name organization_name', 'CONCAT("' . Url::to('/', true) . '", d.slug) profile_link', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo', 'e.placement_location_enc_id', 'COUNT(e.placement_location_enc_id) cnt']);
//                    $y->joinWith(['locationEnc f' => function ($z) {
//                        $z->joinWith(['cityEnc g']);
//                    }], false);
//                    $x->groupBy(['e.placement_location_enc_id']);
//                }], false);
//            }])
//            ->joinWith(['resumeEnc c'], false)
//            ->where([
//                'c.user_enc_id' => $id,
//                'a.is_deleted' => 0,
//                'd.is_erexx_registered' => 1,
//                'd.is_deleted' => 0,
//                'b.application_for' => 2,
//            ])
//            ->andWhere(['or',
//                ['a.status' => 'Pending'],
//                ['a.status' => 'Accepted']
//            ])
//            ->limit(6)
//            ->asArray()
//            ->all();
////        return $q;
//        return $this->response(200, $q);
//    }
//
//    public function actionFollowedCompanies()
//    {
//        $id = Yii::$app->request->post('id');
//
//        $f = FollowedOrganizations::find()
//            ->alias('a')
//            ->distinct()
//            ->select(['a.followed_enc_id', 'a.organization_enc_id'])
//            ->innerJoinWith(['organizationEnc b' => function ($x) {
//                $x->joinWith(['businessActivityEnc e'], false);
//                $x->joinWith(['employerApplications c' => function ($y) use ($x) {
//                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'CONCAT("' . Url::to('/', true) . '", b.slug) profile_link', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo', 'c.application_enc_id', 'COUNT(c.application_enc_id) application_type', 'd.name']);
//                    $y
//                        ->joinWith(['applicationTypeEnc d'], false)
//                        ->onCondition([
//                            'c.status' => 'Active',
//                            'c.is_deleted' => 0,
//                            'c.application_for' => 0
//                        ])
//                        ->orOnCondition([
//                            'c.status' => 'Active',
//                            'c.is_deleted' => 0,
//                            'c.application_for' => 2
//                        ])
//                        ->groupBy(['c.application_type_enc_id']);
//                }], false);
//            }])
//            ->where([
//                'a.user_enc_id' => $id,
//                'a.followed' => 1,
//                'b.is_erexx_registered' => 1,
//                'b.is_deleted' => 0,
//            ])
//            ->asArray()
//            ->all();
//
//        return $this->response(200, $f);
//    }
}