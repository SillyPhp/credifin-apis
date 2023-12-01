<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * UserLogin model
 *
 * @property integer $id
 * @property string $user_enc_id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $first_name
 * @property string $last_name
 * @property string $user_type_enc_id
 * @property string $phone
 * @property string $address
 * @property string $city_enc_id
 * @property string $organization_enc_id
 * @property string $status
 * @property string $is_deleted
 * @property string $password write-only password
 */
class UserLogin extends ActiveRecord implements IdentityInterface {

    public static function tableName() {
        return '{{%users}}';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username, $type = NULL) {
        return static::find()
    		->alias('a')
    		->joinWith(['organizationEnc b' => function ($b) {
        		$b->onCondition(['b.is_deleted' => 'false', 'b.status' => 'Active']);
    		}], false)
    		->where(['a.is_deleted' => 'false'])
    		->andWhere(['or', ['a.username' => $username], ['a.email' => $username], ['b.email' => $username]])
	    	->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password, $hash) {
        $model = new Utilities();
        $model->variables['password'] = $password;
        $model->variables['hash'] = $hash;
        return $model->verify_pass();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrganizationEnc() {
       return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    public function getOrganization() {
        return Organizations::findOne(['organization_enc_id' => $this->organization_enc_id, 'status' => 'Active', 'is_deleted' => 'false']);
    }

    public function getBusinessActivity() {
        return BusinessActivities::findOne(['business_activity_enc_id' => $this->getOrganization()->business_activity_enc_id]);
    }

    public function getType() {
        return UserTypes::findOne(['user_type_enc_id' => $this->user_type_enc_id]);
    }

    public function getReferral() {
        $organization = $this->getOrganization();
        $referralModel = Referral::find();
        if ($organization) {
            $referralModel->where([
                    'organization_enc_id' => $organization->organization_enc_id,
                ]);
        } else {
            $referralModel->where([
                    'user_enc_id' => $this->user_enc_id,
                ]);
        }
        
        $referralModel->andWhere(['is_deleted' => 0]);
        
        return $referralModel->one();
    }

    public function getServices() {
        $services = SelectedServices::find()
                ->alias('a')
                ->select(['b.name', 'b.link', 'b.icon'])
                ->rightJoin(Services::tableName() . ' b', 'b.service_enc_id = a.service_enc_id');

        if ($this->organization_enc_id) {
            $condition = ['a.organization_enc_id' => $this->organization_enc_id];
        } else {
            $condition = ['a.created_by' => $this->user_enc_id];
        }

        $services->where(['and',
                    ['a.is_selected' => 1],
                    $condition,
                ])
                ->orWhere(['b.is_always_visible' => 1])
                ->orderBy(['b.sequence' => SORT_ASC]);

        $selectedServices = SelectedServices::find()
                ->alias('a')
                ->where(['and',
                    ['a.is_selected' => 1],
                    $condition,
                ])
                ->count();
        return [
            'selected_services' => $selectedServices,
            'menu_items' => $services->asArray()->all(),
        ];
    }

}

