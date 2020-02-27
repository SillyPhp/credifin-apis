<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\EmailLogs;
use common\models\Users;
use common\models\Utilities;

class NotificationEmailsComponent extends Component
{

    public function getData()
    {
        $user_email = Users::find()
            ->select(['user_enc_id', 'email'])
            ->where(['not', ['user_of' => 'MIS']])
            ->andWhere([
                'or',
                ['gender' => null],
                ['description' => null],
                ['image' => null],
                ['city_enc_id' => null],
                ['dob' => null],
                ['experience' => null],
            ])
            ->asArray()
            ->all();

//        foreach ($user_email as $email) {
//            $email_logs = new EmailLogs();
//            $utilitesModel = new Utilities();
//            $utilitesModel->variables['string'] = time() . rand(100, 100000);
//            $email_logs->email_log_enc_id = $utilitesModel->encrypt();
//            $email_logs->email_type = 4;
//            $email_logs->user_enc_id = $email['user_enc_id'];
//            $email_logs->subject = 'Empower Youth Updates User Profile';
//            $email_logs->template = 'applications-list';
//            $email_logs->is_sent = 0;
//            $email_logs->created_on = date('Y-m-d H:i:s');
//            if (!$email_logs->save()) {
//                echo 'failed';
//            }
//        }
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

    public function orgProfileMail( ){
        $data = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'a.organization_enc_id', 'a.email', 'b.email as organization_email', 'b.name as organization_name', 'CASE WHEN c.benefit_enc_id IS NOT NULL THEN COUNT(distinct c.benefit_enc_id) ELSE 0 END benefit', 'CASE WHEN d.employee_enc_id IS NOT NULL THEN COUNT(distinct d.employee_enc_id) ELSE 0 END team' ,'CASE WHEN e.image_enc_id IS NOT NULL THEN COUNT(distinct e.image_enc_id) ELSE 0 END gallery', 'CASE WHEN f.product_enc_id IS NOT NULL THEN COUNT(distinct f.product_enc_id) ELSE 0 END product'])
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
            ->groupBy('a.user_enc_id')
            ->limit(10)
            ->asArray()
            ->all();

        $orgData = [];
        foreach ($data as $d) {
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
            if ($d['organizationEnc']['logo']) {
                $per += $t;
            }
            if ($d['organizationEnc']['tag_line']) {
                $per += $t;
            }
            if ($d['organizationEnc']['description']) {
                $per += $t;
            }
            if ($d['organizationEnc']['mission']) {
                $per += $t;
            }
            if ($d['organizationEnc']['vision']) {
                $per += $t;
            }
            if ($d['organizationEnc']['website']) {
                $per += $t;
            }
            $org = ["org" => $d['organization_enc_id'], "name" => $d['organization_name'], "email" => $d['organization_email'], "profile" => $per];
            array_push($orgData,$org);
        }
        print_r($orgData);
        exit();
    }

}