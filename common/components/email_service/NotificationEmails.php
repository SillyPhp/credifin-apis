<?php

namespace common\components\email_service;

use common\models\ApplicationUnclaimOptions;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\Utilities;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use common\models\Users;
use common\models\AppliedEmailLogs;
use common\models\Webinar;
use common\models\WebinarRegistrations;
use yii\helpers\Url;
use yii\base\Component;
use yii\base\InvalidParamException;
use Yii;

class NotificationEmails extends Component
{

    public function userAppliedNotify($user_id = null, $application_id = null, $company_id = null, $unclaim_company_id = null, $type = null, $applied_id = null)
    {
        $object = new \account\models\applications\ApplicationForm();
        $user_info = Users::find()
            ->where(['user_enc_id' => $user_id])
            ->joinWith(['cityEnc b'], false)
            ->select(['username', 'CONCAT(first_name," ",last_name) full_name', 'experience', 'CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . '",image_location,"/",image) logo', 'b.name city'])
            ->asArray()
            ->one();
        $user_skills = \common\models\UserSkills::find()
            ->alias('a')
            ->select(['b.skill skills'])
            ->innerJoin(\common\models\Skills::tableName() . 'b', 'b.skill_enc_id = a.skill_enc_id')
            ->where(['a.created_by' => $user_id])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $userCv = \common\models\UserResume::find()
            ->select(['resume_enc_id'])
            ->where(['user_enc_id' => $user_id])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->one();

        $interview_process = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.interview_process_enc_id', 'b.process_name'])
            ->joinWith(['interviewProcessEnc b'], false)
            ->where([
                'application_enc_id' => $application_id
            ])
            ->asArray()
            ->one();

        $process_rounds = InterviewProcessFields::find()
            ->select(['field_enc_id', 'field_name', 'field_label', 'sequence', 'icon'])
            ->where([
                'interview_process_enc_id' => $interview_process['interview_process_enc_id']
            ])
            ->asArray()
            ->all();

        if (!empty($unclaim_company_id)) {
            $data = $object->getCloneUnclaimed($application_id, $type);
            $org_d = UnclaimedOrganizations::find()
                ->select(['initials_color', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
                ->where(['organization_enc_id' => $unclaim_company_id])
                ->asArray()->one();
            $email = ApplicationUnclaimOptions::findOne(['application_enc_id' => $application_id])->email;
            $data['is_claimed'] = false;
        }
        if (!empty($company_id)) {
            $data = $object->getCloneData($application_id, $type);
            $org_d = Organizations::find()
                ->where(['organization_enc_id' => $company_id])
                ->select(['email', 'initials_color', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
                ->asArray()
                ->one();
            $email = $org_d['email'];
            $data['is_claimed'] = true;
        }
        if ($type == 'Jobs') {
            if ($data['wage_type'] == 'Fixed') {
                if ($data['wage_duration'] == 'Monthly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 12;
                } elseif ($data['wage_duration'] == 'Hourly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 40 * 52;
                } elseif ($data['wage_duration'] == 'Weekly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.a.';
            } else if ($data['wage_type'] == 'Negotiable') {
                if ($data['wage_duration'] == 'Monthly') {
                    $data['min_wage'] = $data['min_wage'] * 12;
                    $data['max_wage'] = $data['max_wage'] * 12;
                } elseif ($data['wage_duration'] == 'Hourly') {
                    $data['min_wage'] = $data['min_wage'] * 40 * 52;
                    $data['max_wage'] = $data['max_wage'] * 40 * 52;
                } elseif ($data['wage_duration'] == 'Weekly') {
                    $data['min_wage'] = $data['min_wage'] * 52;
                    $data['max_wage'] = $data['max_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                if (!empty($data['min_wage']) && !empty($data['max_wage'])) {
                    $amount = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
                } elseif (!empty($data['min_wage'])) {
                    $amount = 'From ₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . 'p.a.';
                } elseif (!empty($data['max_wage'])) {
                    $amount = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
                } elseif (empty($data['min_wage']) && empty($data['max_wage'])) {
                    $amount = 'Negotiable';
                }
            }
        }
        if ($type == 'Internships') {
            if ($data['wage_type'] == 'Fixed') {
                if ($data['wage_duration'] == 'Weekly') {
                    $data['fixed_wage'] = $data['fixed_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.m.';
            } elseif ($data['wage_type'] == 'Negotiable' || $data['wage_type'] == 'Performance Based') {
                if ($data['wage_duration'] == 'Weekly') {
                    $data['min_wage'] = $data['min_wage'] / 7 * 30;
                    $data['max_wage'] = $data['max_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.m.';
            }
        }
        $data['amount'] = $amount;
        $data['user_skills'] = $user_skills;
        $data['user_details'] = $user_info;
        $data['resume'] = $userCv['resume_enc_id'];
        $data['org_info'] = $org_d;
        $data['rounds'] = $process_rounds;
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'user-applied'], ['data' => $data]
        )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$email => $org_d['name']])
            ->setSubject(Yii::t('app', 'Someone Has Applied On Your Job Via Empower Youth'));

        $appliedMail = new AppliedEmailLogs();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $appliedMail->email_log_enc_id = $utilitiesModel->encrypt();
        $appliedMail->applied_enc_id = $applied_id;
        $appliedMail->save();
        if ($mail->send()) {
            $update = Yii::$app->db->createCommand()
                ->update(AppliedEmailLogs::tableName(), ['is_sent' => 1], ['applied_enc_id' => $applied_id])
                ->execute();
            return true;
        } else {
            return false;
        }
    }

    public function educationLoanThankYou($params){
        Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
            ['html' => 'education-loan-thanks'],['data'=>$params]
            )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$params['email'] => $params['name']])
            ->setSubject('Congratulations! Your Application Has Been Received');
        if ($mail->send()) {
            return true;
        }
    }

    public function webinarRegistrationEmail($params){
        $data = Webinar::find()
            ->alias('a')
            ->select(['a.webinar_enc_id',
                'CASE WHEN a.email_sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->webinars->banner->image, 'https') . '", a.email_sharing_image_location, "/", a.email_sharing_image) END image',
                'slug','a.title','other_platforms','GROUP_CONCAT(DISTINCT CONCAT(e.first_name," ",e.last_name)) speakers','GROUP_CONCAT(DISTINCT DATE_FORMAT(b.start_datetime, "%d-%M-%y")) date','GROUP_CONCAT(DISTINCT DATE_FORMAT(b.start_datetime, "%H:%i %p")) time'])
            ->joinWith(['webinarEvents b'=>function($b){
                $b->joinWith(['webinarSpeakers c'=>function($b){
                    $b->joinWith(['speakerEnc d'=>function($b){
                        $b->joinWith(['userEnc e'],false);
                    }],false);
                }]);
            }],false)
            ->where(['a.webinar_enc_id'=>$params['webinar_id']])
            ->asArray()
            ->one();
        $params['title'] = $data['title'];
        $params['speakers'] = $data['speakers'];
        $params['date'] = $data['date'];
        $params['time'] = $data['time'];
        $params['image'] = $data['image'];
        if ($params['is_my_campus']){
            $params['from'] = 'no-reply@myecampus.in';
            $params['site_name'] = 'My E-Campus';
            $params['link'] = 'https://www.myecampus.in/webinar-detail?id='.$params['webinar_id'];
        }else{
            $params['link'] = 'https://www.empoweryouth.com/webinar/'.$data['slug'];
        }
        if (!empty($params['subject'])){
            $subject = $params['subject'];
        }else{
            $subject = 'Thank you for Registering for This Webinar';
        }
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'webinar-registration-mail.php'],['data'=>$params]
        )
            ->setFrom([$params['from'] => $params['site_name']])
            ->setTo([$params['email'] => $params['name']])
            ->setSubject($subject);
        if ($mail->send()) {
            return true;
        }
    }

    public function candidateProcessNotification($param){
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'job-process-status'],['data'=>$param]
        )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$param['email'] => $param['name']])
            ->setSubject($param['subject']);
        if ($mail->send()) {
            return true;
        }
    }

    public function zoomRegisterAccess($params){
        $requestBody = '{  
                "email": "'.$params["email"].'",
                "first_name": "'.$params["first_name"].'",
                "last_name": "'.$params["last_name"].'"
                }';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/webinars/".$params["webinar_zoom_id"]."/registrants",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImtWdk05VXp3UWNtZFVXS3hudFZiekEiLCJleHAiOjE2MzQ5MzAxNDMsImlhdCI6MTYzNDMyNTM0NH0.zJI1ZjK5mDeAsHAlGH3WgDhxjdUxQAKBT8iip-iM0Jo",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
         $data =  json_decode($response,true);
         $join_url = $data['join_url'];
         $get = WebinarRegistrations::findOne(['webinar_enc_id'=>$params['webinar_id'],'created_by'=>$params['user_id']]);
         $get->unique_access_link = $join_url;
         $get->save();
        }
    }

    public function zoomRegisterBatchAccess($params){
        $requestBody = '{
              "auto_approve": false,
              "registrants": '.$params['data'].'
            }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/webinars/".$params["webinar_zoom_id"]."/batch_registrants",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImtWdk05VXp3UWNtZFVXS3hudFZiekEiLCJleHAiOjE2MzQxNTk0MjQsImlhdCI6MTYzMzU1NDYyNX0._mnivTgCBZOo88NW_KGgqVyR8bwPr4xvrxnA1zEiZOE",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data =  json_decode($response,true);
            foreach ($data['registrants'] as $registrant){
                $join_url = $registrant['join_url'];
                $get = WebinarRegistrations::findOne(['webinar_enc_id'=>$params['webinar_id'],'created_by'=>$params['user_id']]);
                $get->unique_access_link = $join_url;
                $get->save();
            }
        }
    }
}