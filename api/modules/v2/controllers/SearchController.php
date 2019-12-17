<?php

namespace api\modules\v2\controllers;

use common\models\ApplicationTypes;
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

class SearchController extends ApiBaseController{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'companies' => ['POST', 'OPTIONS'],
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

    public function actionJobs(){
        $req = Yii::$app->request->post();
        $options = [];

        if($req['page'] && (int)$req['page'] >= 1){
            $options['page'] = $req['page'];
        }else{
            $options['page'] = 1;
        }

        $options['limit'] = 9;

        if($req['keyword']){
            $options['keyword'] = $req['keyword'];
            return $this->response(200, $this->findJobs($options));
        }elseif($req['slug']){
            $options['slug'] = $req['slug'];
            return $this->response(200, $this->findJobs($options));
        }else{
            return $this->response(200, $this->findJobs($options));
        }
    }

    public function actionCompanies($name = null, $page = null){

        if($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;
            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->one();

            $org = ErexxCollaborators::find()
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
                ->where(['aa.college_enc_id' => $college_id, 'aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0]);

            if (isset($name) && !empty($name)) {
                $org->andWhere([
                    'or',
                    ['like', 'b.name', $name],
                    ['like', 'b.slug', $name],
                ]);
            }

            if (isset($page) && !empty($page)) {
                $org->limit = 1;
                $org->offset = ($page - 1) * 1;
            }

            $result = $org->asArray()->all();
            return $this->response(200, $result);
        }

    }

    public function actionInternships(){
        $req = Yii::$app->request->post();
        $options = [];

        if($req['page'] && (int)$req['page'] >= 1){
            $options['page'] = $req['page'];
        }else{
            $options['page'] = 1;
        }

        $options['limit'] = 9;

        if($req['keyword']){
            $options['keyword'] = $req['keyword'];
            return $this->response(200, $this->findInternships($options));
        }else{
            return $this->response(200, $this->findInternships($options));
        }
    }

    private function findInternships($options = []){
        $cards = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.last_date',
                'i.name category',
//                'CONCAT("'. Url::to('/internship/', true). '", a.slug) link',
                'a.slug',
                'd.initials_color color',
                'CONCAT("' . Url::to('/', true) .'", d.slug) organization_link',
                "g.name as city",
                'a.type',
                'c.name as title',
                'i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo'])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->joinWith(['organizationEnc d' => function ($a) {
                $a->where(['d.is_deleted' => 0]);
            }], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g'], false);
                }], false);
            }], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        $cards->andWhere([
            'a.application_for' => 2
        ]);

        $cards->orWhere([
            'a.application_for' => 0
        ]);

        if (isset($options['keyword'])) {
            $cards->andWhere([
                'or',
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
                ['like', 'd.name', $options['keyword']]
            ]);
        }

        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        $result = null;
        $result = $cards->groupBy(['a.application_enc_id'])->orderBy(['a.id' => SORT_DESC])->asArray()->all();

        return $result;
    }

    private function findJobs($options = []){
        $cards = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.last_date',
                'a.type',
//                'CONCAT("'. Url::to('/internship/', true). '", a.slug) link',
                'a.slug',
                'i.name category',
                'l.designation',
                'd.initials_color color',
                'CONCAT("'. Url::to('/', true) .'", d.slug) organization_link',
                "g.name as city",
                'c.name as title',
                'i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
                '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                WHEN a.experience = "2" THEN "1 Year Experience"
                WHEN a.experience = "3" THEN "2-3 Years Experience"
                WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                ELSE "No Experience"
                END) as experience',
            ])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->joinWith(['organizationEnc d' => function ($a) {
                $a->where(['d.is_deleted' => 0]);
            }], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g' => function ($x) {
                        $x->joinWith(['stateEnc s'], false);
                    }], false);
                }], false);
            }], false)
            ->joinWith(['preferredIndustry h'], false)
            ->joinWith(['designationEnc l'], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0]);


        $cards->andWhere([
            'a.application_for' => 2
        ]);

        $cards->orWhere([
            'a.application_for' => 0
        ]);

        if(isset($options['slug'])){
            $cards->andWhere([
               'd.slug'=>$options['slug']
            ]);
        }

        if (isset($options['keyword'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['keyword']],
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'h.industry', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
            ]);
        }

        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        return $cards->groupBy(['a.application_enc_id'])->orderBy(['a.id' => SORT_DESC])->asArray()->all();
    }
}