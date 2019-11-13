<?php

namespace api\modules\v2\controllers;

use common\models\AssignedCategories;
use common\models\EmployerApplications;
use common\models\Organizations;
use Yii;
use yii\helpers\Url;

class ListController extends ApiBaseController
{

    public function actionHomeList()
    {
        $result = [];

        $result['companies'] = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'd.business_activity', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
            ->distinct()
            ->innerJoinWith(['employerApplications b' => function ($x) {
                $x
                    ->select(['b.organization_enc_id', 'COUNT(b.application_enc_id) application_type', 'c.name'])
                    ->joinWith(['applicationTypeEnc c'], false)
                    ->onCondition([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                        'b.application_for' => 0
                    ])
                    ->orOnCondition([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                        'b.application_for' => 2
                    ])
                    ->groupBy(['b.application_type_enc_id']);
            }])
            ->joinWith(['businessActivityEnc d'])
            ->groupBy(['a.organization_enc_id'])
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 'Active',
                'a.is_erexx_registered' => 1
            ])
            ->limit(6)
            ->asArray()
            ->all();

        $result['profiles'] = AssignedCategories::find()
            ->alias('a')
            ->select(['d.category_enc_id', 'd.name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', true) . '", d.icon) icon'])
            ->joinWith(['parentEnc d' => function ($z) {
                $z->groupBy(['d.category_enc_id']);
            }], false)
            ->innerJoinWith(['employerApplications b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0,
                    'b.status' => 'Active',
                    'b.application_for' => 0
                ]);
                $x->orOnCondition([
                    'b.is_deleted' => 0,
                    'b.status' => 'Active',
                    'b.application_for' => 2
                ]);
            }], false)
            ->where([
                'a.is_deleted' => 0,
            ])
            ->limit(6)
            ->asArray()
            ->all();

        return $this->response(200, $result);
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