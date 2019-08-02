<?php

namespace api\modules\v2\controllers;

use common\models\Organizations;
use Yii;
use yii\helpers\Url;

class UtilitiesController extends ApiBaseController{

    public function actionGetCompany(){
        $organization = Organizations::find()
            ->select([
                'organization_enc_id',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0
            ])
            ->asArray()
            ->one();
        return $organization;
    }

    public function actionGetCompanies($search=null){
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0
            ])
            ->andWhere([
                'or',
                ['like', 'name', $search],
                ['like', 'slug', $search]
            ])
            ->asArray()
            ->all();
        return $organizations;
    }

}