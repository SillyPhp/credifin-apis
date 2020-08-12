<?php
namespace api\modules\v3\models;
use common\models\AppliedApplications;

class ProcessModel
{
    public static function process($options = [])
    {
        return self::_getProcess($options);
    }

    private static function _getProcess($options)
    {
        $applied_user = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->where(['a.application_enc_id' => $options['application_id'], 'a.created_by' => $options['user_id']])
            ->select(['a.applied_application_enc_id', 'a.status', 'i.icon', 'h.name org_name', 'h.slug org_slug', 'g.name title', 'b.slug', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(c.is_completed) total'])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->joinWith(['organizationEnc h'], false);
                $b->joinWith(['title f' => function ($b) {
                    $b->joinWith(['parentEnc i'], false);
                    $b->joinWith(['categoryEnc g'], false);
                }], false);

            }], false)
            ->joinWith(['appliedApplicationProcesses c' => function ($b) {
                $b->joinWith(['fieldEnc d'], false);
                $b->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
            }])
            ->groupBy(['a.applied_application_enc_id'])
            ->asArray()
            ->one();
        return $applied_user;
    }
}