<?php

namespace frontend\models;

use common\models\LeadsApplications;
use common\models\LeadsCollegePreference;
use common\models\Usernames;
use common\models\Users;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use frontend\models\events\UserModel;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class AdmissionForm extends Model
{
    public $email;
    public $first_name;
    public $last_name;
    public $phone;
    public $countryCode;
    public $course;
    public $source;
    public $college;
    public $preference_college1;
    public $preference_college2;
    public $preference_college3;
    public $appliedCollege;
    public $amount;
    public $fee;
    public $_flag;

    public function behaviors()
    {
        return [
            [
                'class' => PhoneInputBehavior::className(),
                'countryCodeAttribute' => 'countryCode',
            ],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['email', 'first_name', 'last_name', 'phone'], 'required'],
            [['email'], 'email'],
            [['amount', 'college', 'preference_college1', 'source', 'course'], 'safe'],
            [['amount'], 'integer'],
            [['email', 'first_name', 'last_name', 'phone'], 'trim'],
            [['email', 'first_name', 'last_name', 'phone'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['phone'], PhoneInputValidator::className()],
        ];
    }

    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new LeadsApplications();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->application_enc_id = $utilitiesModel->encrypt();
            $model->application_number = date('ymd') . time();
            $model->first_name = $this->first_name;
            $model->last_name = $this->last_name;
            $model->student_mobile_number = $this->phone;
            $model->source = $this->source;
            $model->student_email = $this->email;
            if ($this->college) {
                $model->college_name = $this->college;
            }
            $model->has_taken_addmission = 0;
            if ($this->appliedCollege == 'yes') {
                $model->has_taken_addmission = 1;
                $model->college_name = $this->college;
            }
            if ($this->amount) {
                $model->loan_amount = $this->amount;
            }
            $model->course_name = $this->course;
            if (!Yii::$app->user->isGuest) {
                $model->created_by = Yii::$app->user->identity->user_enc_id;
            }
            if (!$model->save()) {
                $transaction->rollback();
                return [
                    'status' => 201,
                    'title' => 'errors',
                    'message' => 'something went wrong',
                ];
            }
            $p_college = array_filter($this->preference_college1);
            if ($p_college) {
                foreach ($p_college as $k => $pr) {
                    $prCollege = new LeadsCollegePreference();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $prCollege->preference_enc_id = $utilitiesModel->encrypt();
                    $prCollege->application_enc_id = $model->application_enc_id;
                    $prCollege->college_name = $pr;
                    if (!Yii::$app->user->isGuest) {
                        $prCollege->created_by = Yii::$app->user->identity->user_enc_id;
                    }
                    if (!$prCollege->save()) {
                        $transaction->rollback();
                        return [
                            'status' => 201,
                            'title' => 'errors',
                            'message' => 'something went wrong',
                        ];
                    }
                }
            }
            $transaction->commit();
            return [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Form Submitted Successfully',
            ];
        } catch (\Exception $e) {
            $transaction->rollback();
            print_r($e->getMessage());
            exit();
        }

    }

    public function updateData($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            if ($id) {
                $model = LeadsApplications::findOne(['application_enc_id' => $id]);
            } else {
                $model = new LeadsApplications();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->application_enc_id = $utilitiesModel->encrypt();
                $model->application_number = date('ymd') . time();
            }
            $model->first_name = $this->first_name;
            $model->last_name = $this->last_name;
            $model->student_mobile_number = $this->phone;
            $model->source = $this->source;
            $model->student_email = $this->email;
            if ($this->college) {
                $model->college_institute_name = $this->college;
            }
            $model->has_taken_addmission = 0;
            if ($this->appliedCollege == 'yes') {
                $model->has_taken_addmission = 1;
                $model->college_institute_name = $this->college;
            }
            if ($this->amount) {
                $model->loan_amount = $this->amount;
            }
            $model->course_name = $this->course;
            if (!Yii::$app->user->isGuest) {
                $model->created_by = Yii::$app->user->identity->user_enc_id;
            }
            if (!$model->save()) {
                $transaction->rollback();
                return [
                    'status' => 201,
                    'title' => 'errors',
                    'message' => 'something went wrong',
                ];
            }
            $p_college = array_filter($this->preference_college1);
            if ($p_college) {
                foreach ($p_college as $k => $pr) {
                    $prCollege = LeadsCollegePreference::findOne(['application_enc_id' => $id, 'college_name' => $pr]);
                    if (!$prCollege) {
                        $prCollege = new LeadsCollegePreference();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $prCollege->preference_enc_id = $utilitiesModel->encrypt();
                        $prCollege->application_enc_id = $model->application_enc_id;
                        $prCollege->college_name = $pr;
                        if (!Yii::$app->user->isGuest) {
                            $prCollege->created_by = Yii::$app->user->identity->user_enc_id;
                        }
                        if (!$prCollege->save()) {
                            $transaction->rollback();
                            return [
                                'status' => 201,
                                'title' => 'errors',
                                'message' => 'something went wrong',
                            ];
                        }
                    }
                }
            }
            $transaction->commit();
            return [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Form Submitted Successfully',
            ];
        } catch (\Exception $e) {
            $transaction->rollback();
            print_r($e->getMessage());
            exit();
        }

    }
}