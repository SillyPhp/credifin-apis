<?php

namespace api\modules\v2\controllers;

use common\models\ApplicationTypes;
use common\models\EmployerApplications;
use Yii;
use yii\helpers\Url;

class SearchController extends ApiBaseController{

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
        }else{
            return $this->response(200, $this->findJobs($options));
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
                'CONCAT("'. Url::to('/internship/', true). '", a.slug) link',
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
                'CONCAT("'. Url::to('/internship/', true). '", a.slug) link',
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