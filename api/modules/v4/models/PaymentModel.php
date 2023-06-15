<?php
namespace api\modules\v4\models;
use common\models\LoanApplications;
use yii\base\Model;

class PaymentModel extends Model {

    public $loan_app_id;
    public $amount;
    public $desc;
    public $name;
    public $brand;
    public $method;
    public $phone;
    public $purpose;

    public function rules()
    {
        return [
            [['name', 'loan_app_id','amount'], 'required'],
            ['amount', 'integer', 'min' => 100],
            [['phone'], 'safe'],
            [['phone'], 'string', 'length' => [10, 10]],
            [['name'], 'string', 'length' => [3, 200]],
            ['brand', 'required', 'when' => function ($model) {
                return $model->method == 0;
            }],
            ['desc', 'required', 'when' => function ($model) {
                return $model->method == 0;
            }],
            ['purpose', 'required', 'when' => function ($model) {
                return $model->method == 1;
            }],
            ['method', 'boolean'],
            [['loan_app_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_id' => 'loan_app_enc_id']],
        ];
    }

    public function formName(){
        return '';
    }
}