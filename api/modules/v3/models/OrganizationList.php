<?php
namespace api\modules\v3\models;
use common\models\BusinessActivities;
use common\models\EmployerApplications;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use common\models\RandomColors;
use common\models\Utilities;
use Yii;
use common\models\Organizations;
use yii\helpers\Url;
class OrganizationList
{
    public  $flag;
    public static $DefaultType = ['College', 'School', 'Educational Institute'];
    public static function get($options)
    {
        if (!isset($options['type']))
        {
            $options['type'] = self::$DefaultType;
        }
        return self::getCompanies($options);
    }

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

    private static function getCompanies($options=[])
    {
        $params1 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as value', 'a.organization_enc_id id'])
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['in', 'business_activity', $options['type']]);

        $params2 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as value', 'a.organization_enc_id id'])
            ->from(Organizations::tableName() . 'as a')
            ->innerJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['in', 'business_activity', $options['type']]);

        return $params1->union($params2)->all();
    }

    public function getOrgId($name)
    {
        $c1 = Organizations::find()
            ->select(['organization_enc_id'])
            ->where(['name' => trim($name)])
            ->asArray()
            ->one();

        $c2 = UnclaimedOrganizations::find()
            ->select(['organization_enc_id'])
            ->where(['name' => trim($name)])
            ->asArray()
            ->one();

        if ($c1['organization_enc_id']) {
            return [
                'is_claim' => true,
                'id' => $c1['organization_enc_id']
            ];
        } elseif ($c2['organization_enc_id']) {
            return [
                'is_claim' => false,
                'id' => $c2['organization_enc_id']
            ];
        } else {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model = new UnclaimedOrganizations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->organization_enc_id = $utilitiesModel->encrypt();
                $model->organization_type_enc_id = null;
                $utilitiesModel->variables['name'] = $name;
                $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $slug = $utilitiesModel->create_slug();
                $slug_replace_str = str_replace("-", "", $slug);
                $model->slug = $slug_replace_str;
                $model->name = $name;
                $model->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : null);
                $model->initials_color = RandomColors::one();
                $model->status = 1;
                if ($model->save()) {
                    $username = new Usernames();
                    $username->username = $slug_replace_str;
                    $username->assigned_to = 3;
                    if (!$username->save()) {
                        $transaction->rollBack();
                        return false;
                    }
                    $this->flag = true;
                }
                else
                {
                    $transaction->rollBack();
                    return false;
                }
             }
            catch (\Exception $exception) {
                $transaction->rollBack();
                return false;
            }

            if ($this->flag) {
                $transaction->commit();
                return [
                    'is_claim' => false,
                    'id' => $model->organization_enc_id
                ];
            }
         }
    }
  }
