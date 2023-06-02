<?php

namespace api\modules\v4\models;

use yii\base\Model;
use common\models\FinancerAssignedDesignations;
use common\models\spaces\Spaces;
use mysql_xdevapi\Exception;
use common\models\Utilities;
use Yii;


class FinancerDesignationForm extends Model
{
    public $designation;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['designation'], 'required'],
            [['designation'], 'trim'],
            [['designation'], 'string', 'max' => 150],
        ];
    }

    public function addDesignation($user)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $checkDesignation = FinancerAssignedDesignations::findOne(['organization_enc_id' => $user['organization_enc_id'], 'designation' => $this->designation]);
            if (!empty($checkDesignation)) {
                if ($checkDesignation['is_deleted'] == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(FinancerAssignedDesignations::tableName(), ['is_deleted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['assigned_designation_enc_id' => $checkDesignation['assigned_designation_enc_id']])
                        ->execute();
                    if (!$update) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred while updating.', 'error' => $checkDesignation->getErrors()]);
                    }
                    $transaction->commit();
                    return ['status' => 200, 'message' => 'Successfully Added'];
                } else {
                    return ['status' => 201, 'message' => 'Already Added'];
                }
            }
            $designation = new FinancerAssignedDesignations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $designation->assigned_designation_enc_id = $utilitiesModel->encrypt();
            $designation->organization_enc_id = $user['organization_enc_id'];
            $designation->designation = $this->designation;
            $designation->created_by = $user->user_enc_id;
            $designation->created_on = date('Y-m-d H:i:s');
            $designation->last_updated_by = $user->user_enc_id;
            $designation->last_updated_on = date('Y-m-d H:i:s');
            if (!$designation->save()) {
                $transaction->rollBack();
                throw new \Exception(json_encode($designation->getErrors()));
            }
            $transaction->commit();
            return ['status' => 200, 'message' => 'Successfully Added'];
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'Some Internal Server Error', 'error' => json_decode($exception->getMessage(), true)];
        }
    }
}