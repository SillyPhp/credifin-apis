<?php


namespace api\modules\v2\controllers;


use api\modules\v1\models\Candidates;
use api\modules\v2\models\ProfilePicture;
use common\models\Cities;
use common\models\CollegeCourses;
use common\models\ErexxEmployerApplications;
use common\models\OrganizationOtherDetails;
use common\models\Organizations;
use common\models\User;
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

class CollegeProfileController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-image' => ['POST', 'OPTIONS'],
                'upload-logo' => ['POST', 'OPTIONS'],
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

    public function actionOrgData()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $organizations]);
        }
    }

    public function actionFetchDetails()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id', 'b.name', 'b.phone', 'b.email', 'b.website', 'b.description',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',
                    'c.affiliated_to', 'd.name city'])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['organizationOtherDetails c' => function ($c) {
                        $c->joinWith(['locationEnc d']);
                    }]);
                }], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $courses = CollegeCourses::find()
                ->select(['college_course_enc_id', 'course_name', 'course_duration'])
                ->where(['organization_enc_id' => $organizations['organization_enc_id']])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $organizations, 'courses' => $courses]);
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveDetail()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();
            $update_detail = Organizations::find()
                ->where(['organization_enc_id' => $data['org_enc_id']])
                ->one();

            if (!empty($update_detail)) {
                $update_detail->description = $data['description'];
                $update_detail->website = $data['website'];
                $update_detail->last_updated_on = date('Y-m-d H:i:s');
                $update_detail->last_updated_by = $user->user_enc_id;
                if ($update_detail->update()) {
                    if ($this->saveOtherDetails($data)) {
                        return $this->response(200, ['status' => 200]);
                    } else {
                        return false;
                    }
                }
            } else {
                return $this->response(404);
            }

        } else {
            return $this->response(401);
        }
    }

    private function saveOtherDetails($data)
    {
        $other_details = OrganizationOtherDetails::find()
            ->where(['organization_enc_id' => $data['org_enc_id']])
            ->one();

        if (!empty($other_details)) {
            $city_id = Cities::findone([
                'name' => $data['location']
            ]);

            $city_enc_id = $city_id->city_enc_id;

            $other_details->location_enc_id = $city_enc_id;
            $other_details->affiliated_to = $data['university'];
            if ($other_details->update()) {
                return true;
            }
        } else {
            $model = new OrganizationOtherDetails();
            $utilities = new Utilities();
            $utilities->variables['string'] = time() . rand(100, 100000);
            $model->organization_other_details_enc_id = $utilities->encrypt();
            $model->organization_enc_id = $data['org_enc_id'];
            $model->affiliated_to = $data['university'];
            $city_id = Cities::findone([
                'name' => $data['location']
            ]);

            $city_enc_id = $city_id->city_enc_id;
            $model->location_enc_id = $city_enc_id;
            if ($model->save()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionUploadLogo()
    {
        if ($user = $this->isAuthorized()) {
            $pictureModel = new ProfilePicture();
            $pictureModel->profile_image = UploadedFile::getInstanceByName('profile_image');
            if ($pictureModel->profile_image && $pictureModel->validate()) {
                if ($org_id = $pictureModel->updateLogo()) {
                    $logo = Organizations::find()
                        ->select(['CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
                        ->where(['organization_enc_id' => $org_id])
                        ->asArray()
                        ->one();
                    return $this->response(200, ['status' => 200, 'logo' => $logo['logo']]);
                }
                return $this->response(500);
            } else {
                return $this->response(409);
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveCourse()
    {
        if ($user = $this->isAuthorized()) {

            $req = Yii::$app->request->post();
            $college_id = $this->getOrgId();

            $course = new CollegeCourses();
            $utilities = new Utilities();
            $utilities->variables['string'] = time() . rand(100, 100000);
            $course->college_course_enc_id = $utilities->encrypt();
            $course->organization_enc_id = $college_id;
            $course->course_name = $req['course_name'];
            $course->course_duration = (int)$req['course_duration'];
            $course->created_by = $user->user_enc_id;
            $course->created_on = date('Y-m-d H:i:s');
            if ($course->save()) {
                $courses = CollegeCourses::find()
                    ->select(['college_course_enc_id', 'course_name', 'course_duration'])
                    ->where(['organization_enc_id' => $college_id])
                    ->asArray()
                    ->all();

                return $this->response(200, ['status' => 200, 'courses' => $courses]);
            } else {
                return $course->getErrors();
                return $this->response(409, ['status' => 409, 'message' => 'There is an error']);
            }

        } else {
            return $this->response(401);
        }
    }

    public function actionUpdateCourse()
    {
        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();
            $college_id = $this->getOrgId();

            $course = CollegeCourses::find()
                ->where(['college_course_enc_id' => $req['course_id']])
                ->one();

            if (!empty($course)) {
                $course->course_name = $req['course_name'];
                $course->course_duration = $req['course_duration'];
                $course->updated_by = $user->user_enc_id;
                $course->updated_on = date('Y-m-d H:i:s');
                if ($course->update()) {
                    $courses = CollegeCourses::find()
                        ->select(['college_course_enc_id', 'course_name', 'course_duration'])
                        ->where(['organization_enc_id' => $college_id])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'courses' => $courses]);
                } else {
                    return $this->response(409, ['status' => 409, 'message' => 'There is an error']);
                }
            } else {
                return $this->response(404);
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionLatestJobs()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $jobs = ErexxEmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name title',
                    'a.employer_application_enc_id',
                    'b.slug',
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
                }], true)
                ->where(['a.college_enc_id' => $college_id, 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.is_college_approved' => 1])
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
                $data['org_slug'] = $j['org_slug'];
                $data['title'] = $j['title'];
                $data['slug'] = $j['slug'];
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


}