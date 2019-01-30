<?php

namespace frontend\organizations\OrganizationCards;

use Yii;
use commom\models\Organizations;

class OrganizationCards
{

    public static function organizations()
    {
        return self::_getOrganizations();
    }

    private static function _getOrganizations()
    {
        return Organizations::find()
            ->select(['initials_color color', 'CONCAT("/company/", slug) link', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['is_sponsored' => 1])
            ->limit(10)
            ->asArray()
            ->all();
    }

}