<?php

namespace account\models\bankDetails;

use common\models\Utilities;
use Yii;
use yii\base\Model;

class BankDetailForm extends Model
{
    public $bank_name;
    public $branch_name;
    public $branch_number;
    public $branch_address;
    public $city;
    public $region;
    public $account_no;
    public $account_holder;
    public $ifsc_code;


    public function rules()
    {
        return [
            [['bank_name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'bank_name' => Yii::t('account', 'Bank Name'),
            'branch_name' => Yii::t('account', 'Branch Name'),
            'branch_number' => Yii::t('account', 'Branch Number'),
            'branch_address' => Yii::t('account', 'Branch Address'),
            'city' => Yii::t('account', 'City'),
            'rigion' => Yii::t('account', 'Region'),
            'account_no' => Yii::t('account', 'Account Number'),
            'account_holder' => Yii::t('account', 'Account Holder'),
            'ifsc_code' => Yii::t('account', 'IFSC Code'),
        ];
    }


}