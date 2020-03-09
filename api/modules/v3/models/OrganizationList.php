<?php
namespace api\modules\v3\models;
use common\models\BusinessActivities;
use common\models\EmployerApplications;
use Yii;
use common\models\Organizations;
use yii\helpers\Url;
class OrganizationList
{
    public function getList($l=6,$o=0,$id)
    {
        $data = (new \yii\db\Query())
            ->from(Organizations::tableName() . 'as a')
            ->select(['a.organization_enc_id','COUNT(distinct c.application_enc_id) total_applications','b.business_activity','a.initials_color','a.name','a.slug','CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->leftJoin(EmployerApplications::tableName() . 'as c', 'c.organization_enc_id = a.organization_enc_id')
            ->groupBy(['a.organization_enc_id'])
            ->limit($l)
            ->offset($o)
            ->where(['a.created_by'=>$id])
            ->all();
        return $data;
    }
}
