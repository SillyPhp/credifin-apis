<?php

namespace api\modules\v2\controllers;

use common\models\AssignedCategories;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\Organizations;
use common\models\UserOtherDetails;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class ListController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'except' => [
                'home-list'
            ],
            'class' => HttpBearerAuth::className()
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'home-list' => ['POST', 'OPTIONS'],
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

    public function actionHomeList()
    {

        if ($user = $this->isAuthorized()) {
            $result = [];

            $id = $user->user_enc_id;

            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->one();

            $result['companies'] = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($college_id) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $college_id['organization_enc_id']
                        ]);
                        $y->andWhere(['in', 'c.application_for', [0, 2]]);
                    }], false);
                }])
                ->where(['aa.college_enc_id' => $college_id, 'aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0])
                ->limit(6)
                ->asArray()
                ->all();

            $result['profiles'] = AssignedCategories::find()
                ->alias('a')
                ->select(['d.category_enc_id', 'd.name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', true) . '", d.icon) icon'])
                ->joinWith(['parentEnc d' => function ($z) use ($college_id) {
                    $z->groupBy(['d.category_enc_id']);
                }], false)
                ->innerJoinWith(['employerApplications b' => function ($x) use ($college_id) {
                    $x->innerJoinWith(['erexxEmployerApplications f']);
                    $x->andWhere([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                        'f.college_enc_id' => $college_id
                    ]);
                    $x->andWhere(['in', 'b.application_for', [0, 2]]);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                ])
                ->limit(6)
                ->asArray()
                ->all();

            return $this->response(200, $result);
        }else{
            $result['companies'] = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y){
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                        ]);
                        $y->andWhere(['in', 'c.application_for', [0, 2]]);
                    }], false);
                }])
                ->where(['aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0])
                ->limit(6)
                ->asArray()
                ->all();

            $result['profiles'] = AssignedCategories::find()
                ->alias('a')
                ->select(['d.category_enc_id', 'd.name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', true) . '", d.icon) icon'])
                ->joinWith(['parentEnc d' => function ($z){
                    $z->groupBy(['d.category_enc_id']);
                }], false)
                ->innerJoinWith(['employerApplications b' => function ($x) {
                    $x->innerJoinWith(['erexxEmployerApplications f']);
                    $x->andWhere([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                    ]);
                    $x->andWhere(['in', 'b.application_for', [0, 2]]);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                ])
                ->limit(6)
                ->asArray()
                ->all();

            return $this->response(200, $result);
        }
    }

    public function actionListProfiles()
    {

    }

    public function actionListJobs()
    {

    }

    public function actionListInternships()
    {

    }

}