<?php

namespace common\components;

use common\models\EmployeeBenefits;
use common\models\OrganizationEmployees;
use common\models\OrganizationImages;
use common\models\OrganizationProducts;
use common\models\Organizations;
use common\models\UserEducation;
use common\models\UserSkills;
use common\models\UserSpokenLanguages;
use common\models\UserTypes;
use Yii;
use yii\db\Query;
use yii\base\Component;
use common\models\EmailLogs;
use common\models\Users;
use common\models\Utilities;

class NotificationEmailsComponent extends Component
{

    public function getData()
    {
        $data = (new Query())
            ->from(['a' => Users::tableName()])
            ->select(['a.user_enc_id', 'a.email', 'CONCAT(a.first_name, " ", a.last_name) name', 'a.username', 'a.gender', 'a.description', 'a.image','a.city_enc_id', 'a.dob', 'a.experience', 'a.job_function','e.user_language_enc_id', 'd.user_skill_enc_id', 'c.education_enc_id'])
            ->leftJoin(UserTypes::tableName() . 'as b', 'b.user_type_enc_id = a.user_type_enc_id')
            ->leftJoin(UserEducation::tableName() . 'as c', 'c.user_enc_id = a.user_enc_id')
            ->leftJoin(UserSkills::tableName() . 'as d', 'd.created_by = a.user_enc_id')
            ->leftJoin(UserSpokenLanguages::tableName() . 'as e', 'e.created_by = a.user_enc_id')
            ->where(['not', ['a.user_of' => 'MIS']])
            ->andWhere(['a.organization_enc_id' => null, 'b.user_type' => 'Individual', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere([
                'or',
                ['a.gender' => null],
                ['a.description' => null],
                ['a.image' => null],
                ['a.city_enc_id' => null],
                ['a.dob' => null],
                ['a.experience' => null],
                ['a.job_function' => null],
                ['c.education_enc_id' => null],
                ['d.user_skill_enc_id' => null],
                ['e.user_language_enc_id' => null],
            ])
            ->groupBy('a.user_enc_id');
        $userData = [];
        foreach ($data->batch(100) as $rows) {
            foreach ($rows as $d) {
                $per = 0;
                $total = 10;
                $t = 100 / $total;
                if ($d['user_language_enc_id']) {
                    $per += $t;
                }
                if ($d['user_skill_enc_id']) {
                    $per += $t;
                }
                if ($d['education_enc_id']) {
                    $per += $t;
                }
                if ($d['experience']) {
                    $per += $t;
                }
                if ($d['image']) {
                    $per += $t;
                }
                if ($d['job_function']) {
                    $per += $t;
                }
                if ($d['description']) {
                    $per += $t;
                }
                if ($d['gender']) {
                    $per += $t;
                }
                if ($d['city_enc_id']) {
                    $per += $t;
                }
                if ($d['dob']) {
                    $per += $t;
                }
                $u = ['user' => ["id" => $d['user_enc_id'], 'name'=> $d['name'], 'email' => $d['email'], 'username' => $d['username'], 'profileCompleted' => $per]];
                array_push($userData,$u);
            }
        }
        foreach ($userData as $email) {
            if($email['profile'] < 80) {
                $email_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $email_logs->email_log_enc_id = $utilitesModel->encrypt();
                $email_logs->email_type = 4;
                $email_logs->user_enc_id = $email['user']['id'];
                $email_logs->receiver_email = $email['user']['email'];
                $email_logs->subject = 'Empower Youth Updates User Profile';
                $email_logs->template = 'complete-profile';
                $email_logs->data = json_encode($email);
                $email_logs->is_sent = 0;
                $email_logs->created_on = date('Y-m-d H:i:s');
                if (!$email_logs->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    public function SendMail()
    {
        $user_email = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'a.email',])
            ->joinWith(['userSkills b'])
            ->joinWith(['userEducations c'])
            ->joinWith(['userResumes d' =>  function ($c){
//                $c->groupBy(['c.education_enc_id']);
            }])
            ->where(['not', ['a.user_of' => 'MIS']])
            ->andWhere([
                'or',
                ['a.gender' => null],
                ['a.description' => null],
                ['a.image' => null],
                ['a.city_enc_id' => null],
                ['a.dob' => null],
                ['a.experience' => null],
//                ['b.salary' => null],
            ])
            ->andWhere(['a.organization_enc_id' => null])
            ->groupBy(['b.created_by','b.skill_enc_id'])
            ->asArray()
            ->all();
        print_r($user_email);
        exit();
        $emailLogs = EmailLogs::find()
            ->where([
                'type' => 4,
                'template' => 1,
                'is_send' => 0,
                'is_deleted' => 0,
            ])
            ->asArray()
            ->all();

        if (count($emailLogs) > 0) {

        }
    }

    public function orgSendMail($id){
        $data = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'a.organization_enc_id', 'a.email','CASE WHEN c.benefit_enc_id IS NOT NULL THEN COUNT(distinct c.benefit_enc_id) ELSE 0 END benefit', 'CASE WHEN d.employee_enc_id IS NOT NULL THEN COUNT(distinct d.employee_enc_id) ELSE 0 END team' ,'CASE WHEN e.image_enc_id IS NOT NULL THEN COUNT(distinct e.image_enc_id) ELSE 0 END gallery', 'CASE WHEN f.product_enc_id IS NOT NULL THEN COUNT(distinct f.product_enc_id) ELSE 0 END product'])
            ->innerJoinWith(['organizationEnc b' => function($b){
                $b->joinWith(['employeeBenefits c'], false);
                $b->joinWith(['organizationEmployees d'], false);
                $b->joinWith(['organizationImages e'], false);
                $b->joinWith(['organizationProducts f'], false);
            }])
            ->where(['not', ['a.user_of' => 'MIS']])
            ->andWhere([
                'or',
                ['b.logo' => null],
                ['b.tag_line' => null],
                ['b.description' => null],
                ['b.mission' => null],
                ['b.vision' => null],
                ['b.website' => null],
                ['b.cover_image' => null],
                ['b.phone' => null],
            ])
            ->andWhere(['b.organization_enc_id' => $id])
            ->asArray()
            ->one();

        $per = 0;
        $total = 10;
        $t = 100/$total;
        if($data['benefit'] != 0){
            $per += $t;
//            $per += 10;
        }
        if($data['team'] != 0){
            $per += $t;
        }
        if($data['gallery'] != 0){
            $per += $t;
        }
        if($data['product'] != 0){
            $per += $t;
        }
        if($data['organizationEnc']['logo']){
            $per += $t;
        }
        if($data['organizationEnc']['tag_line']){
            $per += $t;
        }
        if($data['organizationEnc']['description']){
            $per += $t;
        }
        if($data['organizationEnc']['mission']){
            $per += $t;
        }
        if($data['organizationEnc']['vision']){
            $per += $t;
        }
        if($data['organizationEnc']['website']){
            $per += $t;
        }
        return $per;
    }

    public function orgProfileMail(){
        $data = (new Query())
            ->from(['a' => Users::tableName()])
            ->select(['a.user_enc_id', 'a.organization_enc_id', 'a.email', 'b.logo', 'b.slug', 'b.tag_line', 'b.mission', 'b.vision', 'b.website' , 'b.description', 'b.email as organization_email', 'b.name as organization_name', 'CASE WHEN c.benefit_enc_id IS NOT NULL THEN COUNT(distinct c.benefit_enc_id) ELSE 0 END benefit', 'CASE WHEN d.employee_enc_id IS NOT NULL THEN COUNT(distinct d.employee_enc_id) ELSE 0 END team' ,'CASE WHEN e.image_enc_id IS NOT NULL THEN COUNT(distinct e.image_enc_id) ELSE 0 END gallery', 'CASE WHEN f.product_enc_id IS NOT NULL THEN COUNT(distinct f.product_enc_id) ELSE 0 END product'])
            ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
            ->leftJoin(EmployeeBenefits::tableName() . 'as c', 'c.organization_enc_id = b.organization_enc_id')
            ->leftJoin(OrganizationEmployees::tableName() . 'as d', 'd.organization_enc_id = b.organization_enc_id')
            ->leftJoin(OrganizationImages::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->leftJoin(OrganizationProducts::tableName() . 'as f', 'f.organization_enc_id = b.organization_enc_id')
            ->where(['not', ['a.user_of' => 'MIS']])
            ->andWhere(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere([
                'or',
                ['b.logo' => null],
                ['b.tag_line' => null],
                ['b.description' => null],
                ['b.mission' => null],
                ['b.vision' => null],
                ['b.website' => null],
                ['b.cover_image' => null],
                ['b.phone' => null],
            ])
            ->groupBy('a.user_enc_id');
        $orgData = [];
        foreach ($data->batch(50) as $rows) {
            foreach ($rows as $d) {
                $per = 0;
                $total = 10;
                $t = 100 / $total;
                if ($d['benefit'] != 0) {
                    $per += $t;
                }
                if ($d['team'] != 0) {
                    $per += $t;
                }
                if ($d['gallery'] != 0) {
                    $per += $t;
                }
                if ($d['product'] != 0) {
                    $per += $t;
                }
                if ($d['logo']) {
                    $per += $t;
                }
                if ($d['tag_line']) {
                    $per += $t;
                }
                if ($d['description']) {
                    $per += $t;
                }
                if ($d['mission']) {
                    $per += $t;
                }
                if ($d['vision']) {
                    $per += $t;
                }
                if ($d['website']) {
                    $per += $t;
                }
                $org = ['organization' => ["id" => $d['organization_enc_id'], "name" => $d['organization_name'], "email" => $d['organization_email'], 'username' => $d['slug'],'profileCompleted' => $per], 'user' => ["id" => $d['user_enc_id']]];
                array_push($orgData,$org);
            }
        }
        foreach ($orgData as $email) {
            if($email['profile'] < 80) {
                $email_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $email_logs->email_log_enc_id = $utilitesModel->encrypt();
                $email_logs->email_type = 4;
                $email_logs->user_enc_id = $email['user']['id'];
                $email_logs->organization_enc_id = $email['organization']['id'];
                $email_logs->receiver_email = $email['organization']['email'];
                $email_logs->subject = 'Empower Youth Updates User Profile';
                $email_logs->template = 'complete-profile';
                $email_logs->data = json_encode($email);
                $email_logs->is_sent = 0;
                $email_logs->created_on = date('Y-m-d H:i:s');
                if (!$email_logs->save()) {
                    return false;
               }
            }
        }
        return true;
    }

}