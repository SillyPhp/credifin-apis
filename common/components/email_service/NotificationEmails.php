<?php

namespace common\components\email_service;

use common\models\ApplicationUnclaimOptions;
use common\models\EmployerApplications;
use common\models\Organizations;
use yii\base\Component;
use yii\base\InvalidParamException;
use common\models\Utilities;
use Yii;

class NotificationEmails extends Component{

    public function userAppliedNotify($application_id=null,$company_id=null,$unclaim_company_id=null,$type=null)
    {
       $object = new \account\models\applications\ApplicationForm();
        $application_details = EmployerApplications::find()
            ->where([
                'application_enc_id' => $application_id,
                'is_deleted' => 0
            ])
            ->one();
      if (!empty($unclaim_company_id))
      {
          $data = $object->getCloneUnclaimed($application_id, $type);
          $email = ApplicationUnclaimOptions::findOne(['application_enc_id'=>$application_id])->email;
      }
      if (!empty($company_id))
      {
          $data = $object->getCloneData($application_id, $type);
          $email = Organizations::findOne(['organization_enc_id'=>$company_id])->email;
      }
        if ($type=='Job') {
            if ($data2['wage_type'] == 'Fixed') {
                if ($data2['wage_duration'] == 'Monthly') {
                    $data2['fixed_wage'] = $data2['fixed_wage'] * 12;
                } elseif ($data2['wage_duration'] == 'Hourly') {
                    $data2['fixed_wage'] = $data2['fixed_wage'] * 40 * 52;
                } elseif ($data2['wage_duration'] == 'Weekly') {
                    $data2['fixed_wage'] = $data2['fixed_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['fixed_wage'])) . 'p.a.';
            } else if ($data2['wage_type'] == 'Negotiable') {
                if ($data2['wage_duration'] == 'Monthly') {
                    $data2['min_wage'] = $data2['min_wage'] * 12;
                    $data2['max_wage'] = $data2['max_wage'] * 12;
                } elseif ($data2['wage_duration'] == 'Hourly') {
                    $data2['min_wage'] = $data2['min_wage'] * 40 * 52;
                    $data2['max_wage'] = $data2['max_wage'] * 40 * 52;
                } elseif ($data2['wage_duration'] == 'Weekly') {
                    $data2['min_wage'] = $data2['min_wage'] * 52;
                    $data2['max_wage'] = $data2['max_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                if (!empty($data2['min_wage']) && !empty($data2['max_wage'])) {
                    $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data2['max_wage'])) . 'p.a.';
                } elseif (!empty($data2['min_wage'])) {
                    $amount = 'From ₹' . utf8_encode(money_format('%!.0n', $data2['min_wage'])) . 'p.a.';
                } elseif (!empty($data2['max_wage'])) {
                    $amount = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data2['max_wage'])) . 'p.a.';
                } elseif (empty($data2['min_wage']) && empty($data2['max_wage'])) {
                    $amount = 'Negotiable';
                }
            }
        }
        if ($type=='Internship') {
            if ($data2['wage_type'] == 'Fixed') {
                if ($data2['wage_duration'] == 'Weekly') {
                    $data2['fixed_wage'] = $data2['fixed_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['fixed_wage'])) . 'p.m.';
            } elseif ($data2['wage_type'] == 'Negotiable' || $data2['wage_type'] == 'Performance Based') {
                if ($data2['wage_duration'] == 'Weekly') {
                    $data2['min_wage'] = $data2['min_wage'] / 7 * 30;
                    $data2['max_wage'] = $data2['max_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data2['max_wage'])) . 'p.m.';
            }
        }
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'user-applied'], ['data' => $data]
            )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$email => 'Sneh'])
            ->setSubject(Yii::t('frontend', 'Someone Has Applied On Your Job Via Empower Youth'));

        if($mail->send()){
            return true;
        }
        else
        {
            return false;
        }
    }
}