<?php

namespace common\components\email_service;

use common\models\ApplicationUnclaimOptions;
use common\models\EmailLogs;
use common\models\Quizzes;
use common\models\RandomColors;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\Usernames;
use common\models\UserTypes;
use common\models\Utilities;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use common\models\Users;
use common\models\AppliedEmailLogs;
use common\models\Webinar;
use common\models\WebinarRegistrations;
use frontend\models\referral\EducationLoan;
use frontend\models\referral\Referral;
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

    public function educationLoanThankYou($params)
    {
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'education-loan-thanks'], ['data' => $params]
        )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$params['email'] => $params['name']])
            ->setSubject('Congratulations! Your Application Has Been Received');
        if ($mail->send()) {
            return true;
        }
    }

    public function webinarRegistrationEmail($params)
    {
        $data = Webinar::find()
            ->alias('a')
            ->select(['a.webinar_enc_id',
                'CASE WHEN a.email_sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->webinars->banner->image, 'https') . '", a.email_sharing_image_location, "/", a.email_sharing_image) END image',
                'slug', 'a.title', 'other_platforms', 'GROUP_CONCAT(DISTINCT CONCAT(e.first_name," ",e.last_name)) speakers', 'GROUP_CONCAT(DISTINCT DATE_FORMAT(b.start_datetime, "%d-%M-%y")) date', 'GROUP_CONCAT(DISTINCT DATE_FORMAT(b.start_datetime, "%H:%i %p")) time'])
            ->joinWith(['webinarEvents b' => function ($b) {
                $b->joinWith(['webinarSpeakers c' => function ($b) {
                    $b->joinWith(['speakerEnc d' => function ($b) {
                        $b->joinWith(['userEnc e'], false);
                    }], false);
                }]);
            }], false)
            ->where(['a.webinar_enc_id' => $params['webinar_id']])
            ->asArray()
            ->one();
        $params['title'] = $data['title'];
        $params['speakers'] = $data['speakers'];
        $params['date'] = $data['date'];
        $params['time'] = $data['time'];
        $params['image'] = $data['image'];
        if ($params['is_my_campus']) {
            $params['from'] = 'no-reply@myecampus.in';
            $params['site_name'] = 'My E-Campus';
            $params['link'] = 'https://www.myecampus.in/webinar-detail?id=' . $params['webinar_id'];
        } else {
            $params['link'] = 'https://www.empoweryouth.com/webinar/' . $data['slug'];
        }
        if (!empty($params['subject'])) {
            $subject = $params['subject'];
        } else {
            $subject = 'Thank you for Registering for This Webinar';
        }
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'webinar-registration-mail.php'], ['data' => $params]
        )
            ->setFrom([$params['from'] => $params['site_name']])
            ->setTo([$params['email'] => $params['name']])
            ->setSubject($subject);
        if ($mail->send()) {
            return true;
        }
    }

    public function quizRegistrationEmail($params)
    {
        $data = Quizzes::find()
            ->alias('a')
            ->select(['a.quiz_enc_id', 'a.name', 'DATE_FORMAT(a.quiz_start_datetime, "%d %M,%Y from %h:%i %p") quiz_start_datetime', 'c1.name category', 'c2.name parent_category',
                'CASE WHEN a.sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->quiz->sharing->image, 'https') . '", a.sharing_image_location, "/", a.sharing_image) ELSE NULL END sharing_image',])
            ->joinWith(['assignedCategoryEnc c' => function ($c) {
                $c->joinWith(['categoryEnc c1']);
                $c->joinWith(['parentEnc c2']);
            }], false)
            ->where(['a.quiz_enc_id' => $params['quiz_id']])
            ->asArray()
            ->one();

        $similar_quizzes = Quizzes::find()
            ->alias('a')
            ->select(['a.quiz_enc_id', 'a.name',
                'CASE WHEN a.sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->quiz->sharing->image, 'https') . '", a.sharing_image_location, "/", a.sharing_image) ELSE NULL END sharing_image',])
            ->joinWith(['assignedCategoryEnc c' => function ($c) {
                $c->joinWith(['categoryEnc c1']);
                $c->joinWith(['parentEnc c2']);
            }], false)
            ->andWhere(['not', ['c1.name' => $data['category']]])
            ->andFilterWhere(['c1.name' => $data['category']])
            ->limit(3)
            ->asArray()
            ->all();

        $params['similar_quizzes'] = $similar_quizzes;
        $params['quiz_name'] = $data['name'];
        $params['quiz_start_datetime'] = $data['quiz_start_datetime'];
        if (!empty($params['subject'])) {
            $subject = $params['subject'];
        } else {
            $subject = 'Thank you for Registering for This Quiz';
        }
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'quiz-registration-mail.php'], ['data' => $params]
        )
            ->setFrom([$params['from'] => $params['site_name']])
            ->setTo([$params['email'] => $params['name']])
            ->setSubject($subject);
        if ($mail->send()) {
            return true;
        }
    }

    public function candidateProcessNotification($param)
    {
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'job-process-status'], ['data' => $param]
        )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$param['email'] => $param['name']])
            ->setSubject($param['subject']);
        if ($mail->send()) {
            return true;
        }
    }

    public function zoomRegisterAccess($params)
    {
        $requestBody = '{  
                "email": "' . $params["email"] . '",
                "first_name": "' . $params["first_name"] . '",
                "last_name": "' . $params["last_name"] . '"
                }';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/webinars/" . $params["webinar_zoom_id"] . "/registrants",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImM1TEd2bWJTUmJPTldOSjVYdzU3bnciLCJleHAiOjE2NTIyMDkwODAsImlhdCI6MTY0NjMzMzk0NX0.rvsc8xHgvUSWkOYOSdwhca0EJ93DCGEldatAo4HABZg",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            $join_url = $data['join_url'];
            $get = WebinarRegistrations::findOne(['webinar_enc_id' => $params['webinar_id'], 'created_by' => $params['user_id']]);
            $get->unique_access_link = $join_url;
            $get->save();
        }
    }

    public function zoomRegisterBatchAccess($params)
    {
        $requestBody = '{
              "auto_approve": false,
              "registrants": ' . $params['data'] . '
            }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/webinars/" . $params["webinar_zoom_id"] . "/batch_registrants",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImM1TEd2bWJTUmJPTldOSjVYdzU3bnciLCJleHAiOjE2NTIyMDkwODAsImlhdCI6MTY0NjMzMzk0NX0.rvsc8xHgvUSWkOYOSdwhca0EJ93DCGEldatAo4HABZg",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            foreach ($data['registrants'] as $registrant) {
                $join_url = $registrant['join_url'];
                $get = WebinarRegistrations::findOne(['webinar_enc_id' => $params['webinar_id'], 'created_by' => $params['user_id']]);
                $get->unique_access_link = $join_url;
                $get->save();
            }
        }
    }

    public function accessRegisterForLoansEmails($params)
    {


    }

    private function generate_username($string_name = null, $rand_no = 200)
    {
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //cut second name to 5 letters
        $part3 = ($rand_no) ? rand(0, $rand_no) : "";

        $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }

    public function createuserSignUp($params)
    {
        $flag = false;
        $user_type = UserTypes::findOne([
            'user_type' => 'Individual',
        ]);

        if (!$user_type) {
            return false;
        }

        $username = $this->generate_username($params['name']);
        $password = $params['phone'];
        $arr = explode(' ', $params['name']);
        $first_name = $arr[0];
        $last_name = $arr[1] . ' ' . (($arr[2]) ? $arr[2] : '');
        if (empty($last_name)):
            $last_name = null;
        endif;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $usernamesModel = new Usernames();
            $usernamesModel->username = strtolower($username);
            $usernamesModel->assigned_to = 1;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $flag = false;
                $transaction->rollBack();
                return false;
            } else {
                $flag = true;
            }

            if ($flag) {
                $utilitiesModel = new Utilities();
                $usersModel = new Users();
                $usersModel->username = strtolower($username);
                $usersModel->first_name = ucfirst(strtolower($first_name));
                $usersModel->last_name = ucfirst(strtolower($last_name));
                $usersModel->email = strtolower($params['email']);
                $usersModel->phone = $params['phone'];
                $usersModel->initials_color = RandomColors::one();
                $utilitiesModel->variables['password'] = $password;
                $usersModel->password = $utilitiesModel->encrypt_pass();
                $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $usersModel->user_enc_id = Yii::$app->security->generateRandomString(15);
                $usersModel->auth_key = Yii::$app->security->generateRandomString();
                $usersModel->status = 'Active';
                if (!$usersModel->validate() || !$usersModel->save()) {
                    $flag = false;
                    $transaction->rollBack();
                    return false;
                    //throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($usersModel->errors, 0, false)));
                }
            }

            if ($flag) {
                $referralModel = new \common\models\crud\Referral();
                $referralModel->user_enc_id = $referralModel->created_by = $usersModel->user_enc_id;

                if (!$referralModel->create()) {
                    $flag = false;
                    $transaction->rollBack();
                    return false;
                    //throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($referralModel->errors, 0, false)));
                } else {
                    $flag = true;
                }
            }

            if ($flag) {
                $params['username'] = $username;
                $params['password'] = $password;
                Yii::$app->mailer->htmlLayout = 'layouts/email';
                $mail = Yii::$app->mailer->compose(
                    ['html' => 'default-user-password'], ['data' => $params]
                )
                    ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                    ->setTo([$params['email'] => $params['name']])
                    ->setSubject('Your Empower Youth\'s Default Username Password Is Here');
                if ($mail->send()) {
                    $mail_logs = new EmailLogs();
                    $mail_logs->email_log_enc_id = Yii::$app->security->generateRandomString(15);
                    $mail_logs->email_type = 5;
                    $mail_logs->user_enc_id = $usersModel->user_enc_id;
                    $mail_logs->receiver_name = $usersModel->first_name . " " . $usersModel->last_name;
                    $mail_logs->receiver_email = $usersModel->email;
                    $mail_logs->receiver_phone = $usersModel->phone;
                    $mail_logs->subject = "Your Empower Youth's Default Username Password Is Here";
                    $mail_logs->template = 'dafault-user-password';
                    $mail_logs->is_sent = 1;
                    $mail_logs->save();
                }
                Referral::widget(['user_id' => $usersModel->user_enc_id]);
                $transaction->commit();
                return [
                    'status' => true,
                    'id' => $usersModel->user_enc_id,
                ];
            } else {
                $transaction->rollBack();
                return [
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return [
                'status' => false,
                'message' => $e,
            ];
        }
    }

    public function newJobEmail($param)
    {
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'job-create-email'], ['data' => $param]
        )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$param['email'] => $param['name']])
            ->setSubject($param['subject']);
        if ($mail->send()) {
            return true;
        }
    }
}