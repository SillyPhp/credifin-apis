<?php

namespace common\models\extended;

use common\models\AssignedCollegeCourses;
use common\models\AssignedLenderServices;
use common\models\Countries;
use common\models\extended\LoanAuditTrail;
use common\models\LoanStatus;
use Yii;
use common\models\Users;

class LoanLoggableBehavior extends \sammaye\audittrail\LoggableBehavior
{
    public $enc_id;
    public $className = '';
    public $type;

    public function leaveTrail($action, $name = null, $value = null, $old_value = null)
    {
        if ($this->active) {
            $log = new LoanAuditTrail();
            if (isset($this->owner->loan_app_enc_id)) {
                $this->enc_id = $this->owner->loan_app_enc_id;
            } elseif (isset($this->owner->loan_id)) {
                $this->enc_id = $this->owner->loan_id;
            } elseif (isset($this->owner->loan_application_enc_id)) {
                $this->enc_id = $this->owner->loan_application_enc_id;
            } elseif (isset($this->owner->emi_collection_enc_id)) {
                $this->enc_id = $this->owner->emi_collection_enc_id;
            } elseif (isset($this->owner->loan_account_enc_id)) {
                $this->enc_id = $this->owner->loan_account_enc_id;
            } elseif (isset($this->owner->cash_report_enc_id)) {
                $this->enc_id = $this->owner->cash_report_enc_id;
            }
            $log->model = $this->className;
            $log->old_value = $old_value;
            $log->new_value = $value;
            $log->action = $action;
            $log->model_id = (string)$this->getNormalizedPk();
            $log->field = $name;
            $log->foreign_id = $this->enc_id;
            $log->stamp = $this->storeTimestamp ? time() : date($this->dateFormat); // If we are storing a timestamp lets get one else lets get the date
            if ($this->getUserId()) {
                $log->user_id = (string)$this->getUserId(); // Lets get the user id
            } else {
                $log->user_id = isset(Yii::$app->user->identity->id) ? (string)Yii::$app->user->identity->id : null; // Lets get the user id
            }
            return $log->save();
        } else {
            return true;
        }
    }

    public function audit($insert)
    {

        $allowedFields = $this->allowed;
        $ignoredFields = $this->ignored;
        $ignoredClasses = $this->ignoredClasses;

        $newattributes = $this->owner->getAttributes();
        $oldattributes = $this->getOldAttributes();

        // Lets check if the whole class should be ignored
        if (sizeof($ignoredClasses) > 0) {
            if (array_search(get_class($this->owner), $ignoredClasses) !== false)
                return;
        }

        // Lets unset fields which are not allowed
        if (sizeof($allowedFields) > 0) {
            foreach ($newattributes as $f => $v) {
                if (array_search($f, $allowedFields) === false)
                    unset($newattributes[$f]);
            }

            foreach ($oldattributes as $f => $v) {
                if (array_search($f, $allowedFields) === false)
                    unset($oldattributes[$f]);
            }
        }

        // Lets unset fields which are ignored
        if (sizeof($ignoredFields) > 0) {
            foreach ($newattributes as $f => $v) {
                if (array_search($f, $ignoredFields) !== false)
                    unset($newattributes[$f]);
            }

            foreach ($oldattributes as $f => $v) {
                if (array_search($f, $ignoredFields) !== false)
                    unset($oldattributes[$f]);
            }
        }

        // If no difference then WHY?
        // There is some kind of problem here that means "0" and 1 do not diff for array_diff so beware: stackoverflow.com/questions/12004231/php-array-diff-weirdness :S
        if (count(array_diff_assoc($newattributes, $oldattributes)) <= 0)
            return;

        // If this is a new record lets add a CREATE notification
        if ($insert) {
            $this->leaveTrail(self::ACTION_CREATE);
        }

        if (isset($newattributes)) {
            foreach ($newattributes as $n => $m) {
                $newattributes[$n] = $this->getAttriValues($n, $m, $this->className);
            }
        }

        if (isset($oldattributes)) {
            foreach ($oldattributes as $n => $m) {
                $oldattributes[$n] = $this->getAttriValues($n, $m, $this->className);
            }
        }

        // Now lets actually write the attributes
        $this->auditAttributes($insert, $newattributes, $oldattributes);

        // Reset old attributes to handle the case with the same model instance updated multiple times
        $this->setOldAttributes($this->owner->getAttributes());
    }

    private function getAttriValues($key, $value, $type = NULL)
    {
        switch ($key) {
            case 'created_by':
            case 'updated_by':
            case 'last_updated_by':
            case 'managed_by':
            case 'lead_by':
            case 'shared_by':
            case 'shared_to':
            case 'cpa':
                if ($value) {
                    $model = Users::findOne(['user_enc_id' => $value]);
                    $newValue = $model->first_name . ' ' . $model->last_name;
                } else {
                    $newValue = $value;
                }
                break;
            case 'created_on':
            case 'updated_on':
            case 'candidate_status_date':
                $date = new \DateTime($value);
                $date->setTimezone(new \DateTimeZone('Asia/Kolkata'));
                $newValue = $date->format('j M Y g:i A');
                break;
            case 'loan_type':
                switch ($value) {
                    case 'Education Loan':
                        $newValue = 'College Education Loan';
                        break;
                    case 'School Fee Loan':
                        $newValue = 'School Education Loan';
                        break;
                    default:
                        $newValue = $value;
                }
                break;
            case 'applied_date':
                $newValue = date('j M Y', strtotime($value));
                break;
            case 'status':
                if ($type === 'AssignedLoanProvider') {
                    $status_val = LoanStatus::findOne(['value' => $value]);
                    if ($status_val) {
                        $newValue = $status_val->loan_status;
                    } else {
                        $newValue = $value;
                    }
                } else if ($type === "EmployeesCashReport") {
                    switch ($value) {
                        case 0:
                            $newValue = 'Pending';
                            break;
                        case 1:
                            $newValue = 'Approved';
                            break;
                        case 2:
                            $newValue = 'Waiting for approval';
                            break;
                        case 3:
                            $newValue = 'Rejected';
                            break;
                    }
                } else {
                    switch ($value) {
                        case 0:
                            $newValue = 'Pending';
                            break;
                        case 1:
                            $newValue = 'Approved';
                            break;
                        case 2:
                            $newValue = 'Rejected';
                            break;
                        case 3:
                            $newValue = 'Verified';
                            break;
                    }
                }
                break;
            case 'candidate_status':
                switch ($value) {
                    case 'New Lead':
                    case 'On Going':
                    case 'Accepted':
                        $newValue = $value;
                        break;
                    case 'Document Uploaded':
                        $newValue = 'Documention';
                        break;
                    case 'Follow Up':
                        $newValue = 'Follow Up';
                        break;
                    case 'Done':
                        $newValue = 'Done';
                        break;
                    case 'defferds':
                    case 'On Hold':
                        $newValue = $value;
                        break;
                    case 'withDrawn':
                    case 'Non Responsive':
                    case 'Rejected':
                        $newValue = $value;
                        break;
                    default:
                        $newValue = 'Empty';
                }
                break;
            case 'amount':
            case 'yearly_income':
                $amount = $value;
                $fmt = numfmt_create('en_IN', \NumberFormatter::CURRENCY);
                $amount = numfmt_format($fmt, $amount) . "\n";
                $amount = explode(".", $amount);
                $amount = $amount[0];
//                $newValue = '<span class="amountLoan">' . $amount . '</span>';
                $newValue = $amount;
                break;
            case 'provider_enc_id':
            case 'assigned_lender_service_enc_id':
                if ($key == 'provider_enc_id') {
                    $model = \common\models\Organizations::find()
                        ->where(['organization_enc_id' => $value, 'is_deleted' => 0])->asArray()->one();
                } else {
                    $model = AssignedLenderServices::find()
                        ->alias('z')
                        ->select(['z.assigned_lender_service_enc_id', 'z.provider_enc_id', 'a.name'])
                        ->joinWith(['providerEnc a'], false)
                        ->where(['z.assigned_lender_service_enc_id' => $value, 'z.is_deleted' => 0])->asArray()->one();
                }
                if ($model) {
                    $newValue = $model['name'];
                } else {
                    $newValue = $value;
                }
                break;
            case 'assigned_course_enc_id':
            case 'course_name':
                if ($type == 'PathToClaimOrgLoanApplication' || $type == 'PathToUnclaimOrgLoanApplication') {
                    $model = AssignedCollegeCourses::find()
                        ->alias('z')
                        ->select(['z.assigned_college_enc_id', 'z.course_enc_id', 'a.course_name'])
                        ->joinWith(['courseEnc a'], false)
                        ->andWhere(['z.assigned_college_enc_id' => $value])
                        ->asArray()
                        ->one();
                    $newValue = $model['course_name'];
                } else {
                    $newValue = $value;
                }
                break;
            case 'country_enc_id':
                $model = Countries::find()
                    ->andWhere(['country_enc_id' => $value])
                    ->one();
                $newValue = $model->name;
                break;
            default:
                $newValue = $value;
        }

        return $newValue;
    }
}