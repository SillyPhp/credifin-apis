<?php

namespace api\modules\v4\models;

use common\models\LoanPayments;
use common\models\Utilities;
use common\models\spaces\Spaces;
use yii\base\Model;

use Yii;


class LoanPaymentsForm extends Model
{
    public $payment_mode;
    public $amount;
    public $payment_date;

    public $payment_type;
    public $reference_number;
    public $receipt;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['payment_mode', 'amount', 'reference_number'], 'required'],
            [['amount', 'payment_mode'], 'number'],
            [['receipt'], 'safe'],
            [['payment_mode', 'payment_type', 'reference_number'], 'trim'],
            [['reference_number'], 'string', 'max' => 50]
        ];
    }

    public function save($loan_id, $user_id)
    {
        if (!$this->validate()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $this->getErrors()];
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new LoanPayments();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->loan_payments_enc_id = $utilitiesModel->encrypt();
            $model->loan_app_enc_id = $loan_id;
            $model->payment_amount = $this->amount;
            $model->payment_status = 'captured';
            if ($this->payment_type) {
                switch ($this->payment_type) {
                    case 1:
                        $p_type = 'Capital Small Finance Bank';
                        break;
                    case 2:
                        $p_type = 'ICICI';
                        break;
                    case 3:
                        $p_type = 'Axis Bank';
                        break;
                    case 4:
                        $p_type = 'Agile Finance';
                        break;
                    default:
                        $p_type = null;
                        break;
                }
            } else {
                $p_type = null;
            }
            $model->payment_mode = $this->payment_mode;
            $model->payment_source = $p_type;
            $model->reference_number = $this->reference_number;
            if ($this->receipt) {
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->image = $utilitiesModel->encrypt() . '.' . $this->receipt->extension;
                $model->image_location = Yii::$app->getSecurity()->generateRandomString();
                $contentType = $this->receipt->type;
                $base_path = Yii::$app->params->upload_directories->images->image_path . $model->image_location;
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($this->receipt->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $model->image, 'private', ['params' => ['ContentType' => $contentType]]);
                if (!$result) {
                    $transaction->rollBack();
                    return ['status' => 500, 'message' => 'an error occurred', 'error' => $result->getErrors()];
                }
            }
            $model->created_on = date('Y-m-d', strtotime($this->payment_date)) . ' ' . date('H:i:s');
            $model->updated_on = date('Y-m-d', strtotime($this->payment_date)) . ' ' . date('H:i:s');
            $model->created_by = $user_id;
            $model->updated_by = $user_id;
            if (!$model->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()];
            }
            $transaction->commit();
            return ['status' => 200, 'message' => 'Saved Successfully'];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => $e->getMessage()];
        }
    }

}
