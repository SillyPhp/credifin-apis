<?php

namespace account\models\emails;

use common\models\AppInviteEmailLogs;
use common\models\EmailLogs;
use common\models\EmailTemplates;
use common\models\EmployerApplications;
use common\models\MisEmailLogs;
use common\models\Utilities;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SendEmailModel extends Model
{
    public $email;
    public $name;
    public $subject;
    public $template;
    public $application_id;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['application_id','template', 'subject', 'name'], 'safe'],
            [['email', 'subject', 'name'], 'trim'],
        ];
    }

    public function sendEmails()
    {
        if (!$this->validate()) {
            return [
                'status' => 201,
                'title' => 'Validation Error',
                'message' => "Email format invalid",
            ];
        }

        $application_details = EmployerApplications::findOne(['application_enc_id' => $this->application_id,'is_deleted' => 0]);
        if (!empty($application_details->unclaimed_organization_enc_id)) {
            $org_details = $application_details->getUnclaimedOrganizationEnc()->select([
                'organization_enc_id',
                'REPLACE(name, "&amp;", "&") as org_name',
                'slug', 'email', 'website',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '", logo_location, "/", logo) END
                ) organization_logo',
            ])->asArray()->one();
        } else {
            $org_details = $application_details->getOrganizationEnc()->select([
                'organization_enc_id',
                'REPLACE(name, "&amp;", "&") as org_name',
                'slug', 'email', 'website',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory .  Yii::$app->params->upload_directories->organizations->logo . '", logo_location, "/", logo) END
                ) organization_logo',
            ])->asArray()->one();
        }
        $data = $object = EmployerApplications::find()
            ->alias('a')
            ->where(['a.application_enc_id' => $this->application_id])
            ->select([
                'a.application_enc_id',
                'a.organization_enc_id',
                'a.unclaimed_organization_enc_id',
                'CONCAT("") as organization_logo',
                'CONCAT("") as org_name',
                'a.minimum_exp',
                'a.slug',
                'a.maximum_exp',
                'b.internship_duration',
                'b.internship_duration_type',
                'b.saturday_frequency',
                'b.sunday_frequency',
                'b.interview_start_date',
                'b.pre_placement_offer',
                'b.has_placement_offer',
                'b.interview_end_date',
                'a.interview_process_enc_id',
                'b.pre_placement_offer',
                'b.has_placement_offer',
                'b.has_online_interview',
                'b.has_questionnaire',
                'b.has_benefits',
                'b.wage_duration',
                'b.wage_type',
                'b.min_wage',
                'b.max_wage',
                'b.fixed_wage',
                'b.wage_type',
                'a.experience',
                'a.preferred_industry',
                'pi.industry',
                'a.preferred_gender',
                'a.description',
                'a.type',
                'a.timings_from',
                'a.timings_to',
                'a.joining_date',
                'a.last_date',
                'l.category_enc_id primaryfield',
                'm.name',
                'l.icon_png profile_icon',
                'n.designation_enc_id',
                'n.designation',
                'CONCAT("") as amount',
                'appType.name application_type',
                '(CASE
                WHEN b.wage_type = "Unpaid" THEN 0
                WHEN b.wage_type = "Fixed" THEN 1
                WHEN b.wage_type = "Negotiable" THEN 2
                WHEN b.wage_type = "Performance Based" THEN 3
                END) as wage_type', 'b.working_days','b.positions'])
            ->joinwith(['applicationTypeEnc appType'], 'INNER JOIN', false)
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], 'INNER JOIN', false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationOptions b'], false, 'INNER JOIN')
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->andWhere(['i.is_deleted' => 0]);
                $b->joinWith(['jobDescriptionEnc j'], false, 'INNER JOIN');
                $b->select(['i.application_enc_id', 'j.job_description']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->andWhere(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false, 'INNER JOIN');
                $b->select(['g.application_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->onCondition(['e.is_deleted' => 0]);
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationEmployeeBenefits c' => function ($b) {
                $b->onCondition(['c.is_deleted' => 0]);
                $b->joinWith(['benefitEnc d'], false);
                $b->select(['c.application_enc_id', 'c.benefit_enc_id', 'd.benefit', 'd.icon', 'd.icon_location']);
            }])
            ->joinWith(['applicationInterviewQuestionnaires q' => function ($b) {
                $b->onCondition(['q.is_deleted' => 0]);
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->joinWith(['applicationInterviewLocations r' => function ($b) {
                $b->onCondition(['r.is_deleted' => 0]);
                $b->joinWith(['locationEnc u' => function ($b) {
                    $b->joinWith(['cityEnc v'], false);
                }], false);
                $b->select(['r.location_enc_id', 'r.application_enc_id', 'v.city_enc_id', 'v.name', 'u.latitude as interview_lat', 'u.longitude as interview_long']);
            }])
            ->joinWith(['preferredIndustry pi'])
            ->asArray()
            ->one();
        $data['org_name'] = $org_details['org_name'];
        $data['organization_logo'] = $org_details['organization_logo'];

        $this->subject = "Recommended Application";
        $this->template = "job-invite-email";

        $utilitiesModel = new Utilities();
        $emailModel = new AppInviteEmailLogs();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $emailModel->email_log_enc_id = $utilitiesModel->encrypt();
        $emailModel->application_enc_id = $this->application_id;
        $emailModel->is_sent = 0;
        $emailModel->created_on = date('Y-m-d H:i:s');
        if (!$emailModel->validate() || !$emailModel->save()) {
            return [
                'status' => 201,
                'title' => 'emailModel',
                'message' => 'Email logs not save'
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            $email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            // Validate e-mail
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Yii::$app->mailer->htmlLayout = 'layouts/email';
                $mail = Yii::$app->mailer->compose(
                    ['html' => $this->template],['data'=>$data]
                )
                    ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                    ->setTo([$this->email])
                    ->setSubject( $data['org_name'] . " has shortlisted you for " . $data['name']);
                if (!$mail->send()) {
                    return [
                        'status' => 201,
                        'title' => 'Saving Error',
                        'message' => "Model not saved in database",
                    ];
                }
                $mail_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
                $mail_logs->email_type = 6;
                $mail_logs->user_enc_id = Yii::$app->user->identity->user_enc_id;
                $mail_logs->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                $mail_logs->receiver_email = $email;
                $mail_logs->subject = $this->subject;
                $mail_logs->template = 'verification-email';
                $mail_logs->is_sent = 1;
                if (!$mail_logs->save()) {
                    $transaction->rollBack();
                    return [
                        'status' => 201,
                        'title' => 'Saving Error',
                        'message' => "Model not saved in database",
                    ];
                }
                $emailModel->is_sent = 1;
                if(!$emailModel->save()){
                    $transaction->rollBack();
                    return [
                        'status' => 201,
                        'title' => 'Updating Error',
                        'message' => "Something went wrong..",
                    ];
                }
            } else {
                return [
                    'status' => 201,
                    'title' => 'Email',
                    'message' => "Email not validated",
                ];
            }

            $transaction->commit();
            return [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Email Sent Successfully..'
            ];
        } catch (yii\db\Exception $exception) {
            $transaction->rollBack();
            return [
                'status' => 201,
                'title' => 'DB Exceptions',
                'message' => $exception
            ];
        }

    }

}