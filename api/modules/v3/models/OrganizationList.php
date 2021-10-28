<?php

namespace api\modules\v3\models;

use common\models\AssignedCollegeCourses;
use common\models\AssignedUnclaimCollegeCourses;
use common\models\BusinessActivities;
use common\models\CollegeCoursesPool;
use common\models\EmployerApplications;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use common\models\RandomColors;
use common\models\Users;
use common\models\Utilities;
use Yii;
use common\models\Organizations;
use yii\helpers\Url;
use yii\db\Expression;

class OrganizationList
{
    public $flag;

    public static function get($options)
    {
        return self::getCompanies($options);
    }

    public function getList($l = 6, $o = 0, $id)
    {
        $data = (new \yii\db\Query())
            ->from(Organizations::tableName() . 'as a')
            ->select(['a.organization_enc_id', 'COUNT(distinct c.application_enc_id) total_applications', 'b.business_activity', 'a.initials_color', 'a.name', 'a.slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->leftJoin(EmployerApplications::tableName() . 'as c', 'c.organization_enc_id = a.organization_enc_id')
            ->groupBy(['a.organization_enc_id'])
            ->limit($l)
            ->offset($o)
            ->where(['a.created_by' => $id])
            ->all();
        return $data;
    }

    private static function getCompanies($options = [])
    {
        $params1 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as text', 'a.organization_enc_id id', new Expression('"claim" as pulled_from')])
            ->from(Organizations::tableName() . 'as a')
            ->innerJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.business_activity_enc_id')
            ->andWhere(['is_deleted' => 0]);

        $params2 = (new \yii\db\Query())
            ->select(['REPLACE(name, "&amp;", "&") as text', 'a.organization_enc_id id', new Expression('"unclaim" as pulled_from')])
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(BusinessActivities::tableName() . 'as b', 'b.business_activity_enc_id = a.organization_type_enc_id')
            ->andWhere(['is_deleted' => 0]);

        if (isset($options['source']) && !empty($options['source'])) {
            $params2->andWhere(['in', 'source', $options['source']]);
        }
        if (isset($options['type']) && !empty($options['type'])) {
            $params1->andWhere(['in', 'business_activity', $options['type']]);
            $params2->andWhere(['in', 'business_activity', $options['type']]);
        }

        if ($options['datatype'] == 0) {
            return $params1->union($params2)->all();
        } elseif ($options['datatype'] == 1) {
            return $params1->all();
        } elseif ($options['datatype'] == 2) {
            return $params2->all();
        }
    }

    public function getOrgId($options = [])
    {

        $c2 = UnclaimedOrganizations::find()
            ->select(['organization_enc_id'])
            ->where(['name' => trim($options['name'])])
            ->asArray()
            ->one();

        if ($c2['organization_enc_id']) {
            return [
                'is_claim' => false,
                'id' => $c2['organization_enc_id']
            ];
        } else {
            return $this->saveUnclaimOrganization($options);
        }
    }

    private function saveUnclaimOrganization($options = [])
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model = new UnclaimedOrganizations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->organization_enc_id = $utilitiesModel->encrypt();
            $model->organization_type_enc_id = null;
            $utilitiesModel->variables['name'] = $options['name'];
            $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $slug = $utilitiesModel->create_slug();
            $slug_replace_str = str_replace("-", "", $slug);
            $model->slug = $slug_replace_str;
            $model->source = $options['source'];
            $model->name = $options['name'];
            $model->created_by = (($options['userId']) ? $options['userId'] : null);
            $model->initials_color = RandomColors::one();
            $model->status = 1;
            if ($model->save()) {
                $usernames = Usernames::findone(['username' => $slug_replace_str]);
                $username = new Usernames();
                if ($usernames) {
                    $username->username = $slug_replace_str . Yii::$app->getSecurity()->generateRandomString(3);
                } else {
                    $username->username = $slug_replace_str;
                }
                $username->assigned_to = 3;
                if (!$username->save()) {
                    $transaction->rollBack();
                    return false;
                }
                $this->flag = true;
            } else {
                $transaction->rollBack();
                return false;
            }

            if ($this->flag) {
                $transaction->commit();
                return [
                    'is_claim' => false,
                    'id' => $model->organization_enc_id
                ];
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }

    public function conditionParser($params)
    {
        if ($params['college_course_info'][0]['pulled_from'] == 'claim') {
            return [
                'college_id' => $params['college_course_info'][0]['colg_id'],
                'is_claim' => 1,
            ];
        } else if ($params['college_course_info'][0]['pulled_from'] == 'unclaim' && $params['college_course_info'][0]['colg_id'] == 'self') {
            $options['name'] = trim($params['college_course_info'][0]['colg_text']);
            $options['source'] = 3;
            $options['userId'] = $params['userID'];
            $org = $this->getOrgId($options);
            return [
                'college_id' => $org['id'],
                'is_claim' => 2,
            ];
        } else if ($params['college_course_info'][0]['pulled_from'] == 'unclaim' && $params['college_course_info'][0]['colg_id'] != 'self') {
            return [
                'college_id' => $params['college_course_info'][0]['colg_id'],
                'is_claim' => 2,
            ];
        }
    }

    public function conditionCourseParser($parser, $params)
    {
        if ($params['college_course_info'][0]['pulled_from'] == 'claim') {
            $course_name = trim($params['college_course_info'][0]['course_text']);
            return [
                'assigned_course_id' => $this->getAssignCourse($course_name, $parser['college_id'])
            ];
        } else if ($params['college_course_info'][0]['pulled_from'] == 'unclaim' && $params['college_course_info'][0]['colg_id'] == 'self') {
            $course_name = trim($params['college_course_info'][0]['course_text']);
            return [
                'assigned_course_id' => $this->getAssignUnclaimCourse($course_name, $parser['college_id'])
            ];
        } else if ($params['college_course_info'][0]['pulled_from'] == 'unclaim' && $params['college_course_info'][0]['colg_id'] != 'self') {
            $course_name = trim($params['college_course_info'][0]['course_text']);
            return [
                'assigned_course_id' => $this->getAssignUnclaimCourse($course_name, $parser['college_id'])
            ];
        }
    }

    public function getAssigneWidgetCourse($course_name, $colleg_id)
    {
        return $this->getAssignCourse($course_name, $colleg_id);
    }

    private function getAssignCourse($course_name, $colleg_id)
    {
        $pool = CollegeCoursesPool::find()
            ->select(['course_enc_id'])
            ->where(['course_name' => $course_name])
            ->asArray()->one();

        if (!empty($pool)) {
            $assignClaim = AssignedCollegeCourses::find()
                ->select(['assigned_college_enc_id'])
                ->where(['organization_enc_id' => $colleg_id, 'course_enc_id' => $pool['course_enc_id']])
                ->asArray()
                ->one();
            if (!empty($assignClaim)) {
                return $assignClaim['assigned_college_enc_id'];
            } else {
                return $this->saveClaimCourse($colleg_id, $pool['course_enc_id']);
            }
        } else {
            $cousrse_enc_id = $this->saveCourseInPool($course_name);
            return $this->saveClaimCourse($colleg_id, $cousrse_enc_id);
        }
    }

    private function getAssignUnclaimCourse($course_name, $colleg_id)
    {
        $pool = CollegeCoursesPool::find()
            ->select(['course_enc_id'])
            ->where(['course_name' => $course_name])
            ->asArray()->one();

        if (!empty($pool)) {
            $assignUnclaim = AssignedUnclaimCollegeCourses::find()
                ->select(['assigned_college_enc_id'])
                ->where(['organization_enc_id' => $colleg_id, 'course_enc_id' => $pool['course_enc_id']])
                ->asArray()
                ->one();
            if (!empty($assignUnclaim)) {
                return $assignUnclaim['assigned_college_enc_id'];
            } else {
                return $this->saveUnclaimCourse($colleg_id, $pool['course_enc_id']);
            }
        } else {
            $cousrse_enc_id = $this->saveCourseInPool($course_name);
            return $this->saveUnclaimCourse($colleg_id, $cousrse_enc_id);
        }
    }

    private function saveUnclaimCourse($colleg_id, $course_id)
    {
        $user = Users::findOne(['username' => 'admin'])->user_enc_id;
        $model = new AssignedUnclaimCollegeCourses();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->assigned_college_enc_id = $utilitiesModel->encrypt();
        $model->course_enc_id = $course_id;
        $model->organization_enc_id = $colleg_id;
        $model->created_on = date('Y-m-d H:i:s');
        $model->created_by = $user;
        if ($model->save()) {
            return $model->assigned_college_enc_id;
        } else {
            return false;
        }
    }

    private function saveClaimCourse($colleg_id, $course_id)
    {
        $user = Users::findOne(['username' => 'admin'])->user_enc_id;
        $model = new AssignedCollegeCourses();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->assigned_college_enc_id = $utilitiesModel->encrypt();
        $model->course_enc_id = $course_id;
        $model->organization_enc_id = $colleg_id;
        $model->created_on = date('Y-m-d H:i:s');
        $model->created_by = $user;
        if ($model->save()) {
            return $model->assigned_college_enc_id;
        } else {
            return false;
        }
    }

    private function saveCourseInPool($course_name)
    {
        $user = Users::findOne(['username' => 'admin'])->user_enc_id;
        $model = new CollegeCoursesPool();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->course_enc_id = $utilitiesModel->encrypt();
        $model->course_name = $course_name;
        $model->status = 'Pending';
        $model->created_on = date('Y-m-d H:i:s');
        $model->created_by = $user;
        if ($model->save()) {
            return $model->course_enc_id;
        } else {
            return false;
        }
    }
}
