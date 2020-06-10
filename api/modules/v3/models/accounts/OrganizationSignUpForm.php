<?php

namespace api\modules\v3\models\accounts;
use Yii;
use yii\base\Model;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\Usernames;
use common\models\Organizations;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

class OrganizationSignUpForm extends Model
{

    public $username;
    public $created_by;
    public $phone;
    public $countryCode;
    public $organization_name;
    public $organization_email;
    public $organization_website;
    public $organization_phone;
    private $_flag = false;

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
            [['username','created_by','organization_name', 'organization_email', 'organization_phone'], 'required'],
            [['username','created_by','organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'trim'],
            [['username','organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['organization_name'], 'string', 'max' => 100],
            [['username'], 'string', 'length' => [3, 20]],
            [['organization_email'], 'string', 'max' => 50],
            [['organization_phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['organization_email'], 'email'],
            [['organization_website'], 'url', 'defaultScheme' => 'http'],
            [['organization_phone'], PhoneInputValidator::className()],
            ['organization_email', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_email' => 'email'], 'message' => 'This email address has already been used.'],
            ['organization_phone', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
        ];
    }


    public function add()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $usernamesModel = new Usernames();
            $usernamesModel->username = strtolower($this->username);
            $usernamesModel->assigned_to = 2;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $this->_flag = false;
                $transaction->rollback();
                return false;
            } else {
                $this->_flag = true;
            }

            $utilitiesModel = new Utilities();

//            if($this->_flag) {
//                $referralModel = new \common\models\crud\Referral();
//                $referralModel->user_enc_id = $referralModel->created_by = $this->created_by;
//
//                if (!$referralModel->create()) {
//                    $this->_flag = false;
//                    $transaction->rollback();
//                    return false;
//                } else {
//                    $this->_flag = true;
//                }
//            }

            if ($this->_flag) {
                $organizationsModel = new Organizations();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organizationsModel->organization_enc_id = $utilitiesModel->encrypt();
                $organizationsModel->name = $this->organization_name;
                $organizationsModel->email = strtolower($this->organization_email);
                $organizationsModel->initials_color = RandomColors::one();
                $organizationsModel->phone = $this->organization_phone;
                $organizationsModel->website = $this->organization_website;
                $organizationsModel->created_on = date('Y-m-d H:i:s');
                $organizationsModel->created_by = $this->created_by;
                $utilitiesModel->variables['name'] = $usernamesModel->username;
                $utilitiesModel->variables['table_name'] = Organizations::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $organizationsModel->slug = $utilitiesModel->create_slug();
                $organizationsModel->status = 'Active';
                if (!$organizationsModel->validate() || !$organizationsModel->save()) {
                    $this->_flag = false;
                    $transaction->rollback();
                    return false;
                }
            }

            if($this->_flag) {
                $referralModel = new \common\models\crud\Referral();
                $referralModel->created_by = $this->created_by;
                $referralModel->is_organization = true;
                $referralModel->organization_enc_id = $organizationsModel->organization_enc_id;

                if (!$referralModel->create()) {
                    $this->_flag = false;
                    $transaction->rollback();
                    return false;
                } else {
                    $this->_flag = true;
                }
            }

            if ($this->_flag) {
//                Yii::$app->organizationSignup->registrationEmail($organizationsModel->organization_enc_id);
//                $mail = Yii::$app->mail;
//                $mail->receivers = [];
//                $mail->receivers[] = [
//                    "name" => $this->organization_name,
//                    "email" => $this->organization_email,
//                ];
//                $mail->subject = 'Welcome to Empower Youth';
//                $mail->template = 'thank-you';
//                $mail->send();
               // \api\modules\v3\models\widgets\Referral::widget(['user_org_id' => $organizationsModel->organization_enc_id]);
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

}