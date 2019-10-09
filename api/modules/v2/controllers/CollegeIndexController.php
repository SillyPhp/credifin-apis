<?php


namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\ErexxCollaborators;
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
                ->select(['aa.collaboration_enc_id','aa.organization_enc_id'])
                ->distinct()
                ->innerJoinWith(['organizationEnc b' => function ($x) {
                    $x->select(['b.organization_enc_id', 'b.name organization_name','b.slug org_slug','e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) {
                        $y->select(['c.organization_enc_id', 'COUNT(c.application_enc_id) application_type', 'd.name'])
                            ->joinWith(['applicationTypeEnc d'], false)
                            ->onCondition([
                                'c.status' => 'Active',
                                'c.is_deleted' => 0,
                                'c.application_for' => 0
                            ])
                            ->orOnCondition([
                                'c.status' => 'Active',
                                'c.is_deleted' => 0,
                                'c.application_for' => 2
                            ])
                            ->groupBy(['c.application_type_enc_id']);
                    }]);
                }])
                ->where(['aa.college_enc_id' => $req['college_id'], 'aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0])
                ->asArray()
                ->all();

            $candidates = UserOtherDetails::find()
                ->alias('a')
                ->select(['b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", image_location, "/", image) ELSE NULL END image'])
                ->joinWith(['userEnc b'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.organization_enc_id' => $req['college_id']])
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

    public function actionCompnaySelection(){

    }
}