<?php

namespace frontend\models\profiles;

use Yii;
use yii\helpers\Url;
use common\models\AssignedCategories;

class ProfileCards
{

    public static function activeProfiles($options = [])
    {
        return self::_getActiveProfiles($options);
    }

    private static function _getActiveProfiles($options)
    {
        return AssignedCategories::find()
            ->select(['b.name', 'CONCAT("' . Url::to('/' . strtolower($options['type']) . '/list?keyword=') . '", b.name) link', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", b.icon) icon', 'COUNT(d.id) as total'])
            ->alias('a')
            ->joinWith(['parentEnc b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->joinWith(['employerApplications d' => function ($b) {
                $b->joinWith(['applicationTypeEnc e']);
            }], false)
            ->where(['e.name' => ucfirst($options['type'])])
            ->groupBy(['a.parent_enc_id'])
            ->orderBy(['total' => SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();
    }

}