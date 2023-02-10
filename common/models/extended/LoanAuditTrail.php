<?php

namespace common\models\extended;

use Yii;
use yii\db\ActiveRecord;

/**
 * The followings are the available columns in table 'tbl_loan_audit_trail':
 * @var integer $id
 * @var string $new_value
 * @var string $old_value
 * @var string $action
 * @var string $model
 * @var string $field
 * @var string $stamp
 * @var integer $user_id
 * @var string $model_id
 * @var string $loan_id
 */
class LoanAuditTrail extends ActiveRecord
{
    private $_message_category = 'loanaudittrail';

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
//        if(isset(Yii::$app->params['audittrail.table'])){
//            return Yii::$app->params['audittrail.table'];
//        }else{
        return '{{%loan_audit_trail}}';
        //}
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
//        if (isset(Yii::$app->params['audittrail.db'])) {
//            return Yii::$app->get(Yii::$app->params['audittrail.db']);
//        } else  {
        return parent::getDb();
        //}
        // return Yii::$app->get('dbUser');
    }

    public function init()
    {
        parent::init();

        \Yii::$app->i18n->translations[$this->_message_category] = [
            'class' => 'yii\i18n\PhpMessageSource',
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('loanaudittrail','ID'),
            'old_value' => Yii::t('loanaudittrail','Old Value'),
            'new_value' => Yii::t('loanaudittrail','New Value'),
            'action' => Yii::t('loanaudittrail','Action'),
            'model' => Yii::t('loanaudittrail','Type'),
            'field' => Yii::t('loanaudittrail','Field'),
            'stamp' => Yii::t('loanaudittrail','Stamp'),
            'user_id' => Yii::t('loanaudittrail','User'),
            'model_id' => Yii::t('loanaudittrail','ID'),
            'loan_id' => Yii::t('loanaudittrail', 'Loan ID'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['action', 'model', 'stamp', 'model_id'], 'required'],
            ['action', 'string', 'max' => 255],
            ['model', 'string', 'max' => 255],
            ['field', 'string', 'max' => 255],
            ['model_id', 'string', 'max' => 255],
            ['user_id', 'string', 'max' => 255],
            ['loan_id', 'string', 'max' => 255],
            [['old_value', 'new_value'], 'safe']
        ];
    }

    public static function recently($query)
    {
        $query->orderBy(['[[stamp]]' => SORT_DESC]);
    }

    public function getUser()
    {
        if(isset(Yii::$app->params['loanaudittrail.model']) && isset(Yii::$app->params['loanaudittrail.model'])){
            return $this->hasOne(Yii::$app->params['loanaudittrail.model'], ['id' => 'user_id']);
        } else {
            return $this->hasOne('common\models\Users', ['id' => 'user_id']);
        }
    }

    public function getLoan()
    {
        if(isset(Yii::$app->params['audittrail.model']) && isset(Yii::$app->params['audittrail.model'])){
            return $this->hasOne(Yii::$app->params['audittrail.model'], ['loan_app_enc_id' => 'loan_id']);
        }else{
            return $this->hasOne('common\models\LoanApplications', ['loan_app_enc_id' => 'loan_id']);
        }
    }

    public function getParent(){
        $model_name =
            (
            isset(Yii::$app->params['audittrail.FQNPrefix']) &&
            rtrim(Yii::$app->params['audittrail.FQNPrefix'], '\\') ?
                rtrim(Yii::$app->params['audittrail.FQNPrefix'], '\\') . '\\' :
                ''
            ) . $this->model;
        return new $model_name;
    }
}

?>