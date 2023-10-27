<?php
namespace api\modules\v4\models;
use common\models\LoanApplications;
use yii\base\Model;

class PaymentModel extends Model {

    public $loan_app_id;
    public $amount;
    public $name;
    public $phone;

    public function rules()
    {
        return [
            [['name', 'loan_app_id', 'amount', 'phone'], 'required'],
            ['amount', function () {
                if (!is_array($this->amount) || empty($this->amount)) {
                    $this->addError('amount', 'Please choose amount!');
                }
            }],
            [['phone'], 'string', 'length' => [10, 10]],
            [['name'], 'string', 'length' => [3, 200]],
            [['loan_app_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_id' => 'loan_app_enc_id']],
        ];
    }

    public function formName(){
        return '';
    }
}