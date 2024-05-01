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
    public $department;
    public $designation_id;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['designation', 'department'], 'required'],
            [['designation'], 'trim'],
            [['designation', 'department', 'designation_id'], 'string', 'max' => 150],
        ];
    }

    public function addDesignation($user)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (empty($this->designation_id)) {
                $checkDesignation = FinancerAssignedDesignations::findOne(['organization_enc_id' => $user['organization_enc_id'], 'designation' => $this->designation, 'department' => $this->department]);
            } else {
                $checkDesignation = FinancerAssignedDesignations::findOne(['organization_enc_id' => $user['organization_enc_id'], 'assigned_designation_enc_id' => $this->designation_id]);
            }
            if (!empty($checkDesignation)) {
                if ($checkDesignation['is_deleted'] == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(FinancerAssignedDesignations::tableName(), ['is_deleted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['assigned_designation_enc_id' => $checkDesignation['assigned_designation_enc_id']])
                        ->execute();
                    if (!$update) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred while updating.', 'error' => $checkDesignation->getErrors()];
                    }
                    $transaction->commit();
                    return ['status' => 200, 'message' => 'Successfully Added'];
                }
                if (!empty($this->designation_id)) {
                    if (!empty(FinancerAssignedDesignations::findOne(['organization_enc_id' => $user['organization_enc_id'], 'designation' => $this->designation, 'department' => $this->department]))) {
                        return ['status' => 201, 'message' => 'Designation already exists in the same department.'];
                    }
                    $update = Yii::$app->db->createCommand()
                        ->update(FinancerAssignedDesignations::tableName(), ['designation' => $this->designation, 'department' => $this->department, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['assigned_designation_enc_id' => $this->designation_id])
                        ->execute();
                    if (!$update) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred while updating.'];
                    }
                    $transaction->commit();
                    return ['status' => 200, 'message' => 'Successfully updated'];
                }
                return ['status' => 201, 'message' => 'Already Added'];
            } else {
                $designation = new FinancerAssignedDesignations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $designation->assigned_designation_enc_id = $utilitiesModel->encrypt();
                $designation->organization_enc_id = $user['organization_enc_id'];
                $designation->designation = $this->designation;
                $designation->department = $this->department;
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
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'Some Internal Server Error', 'error' => json_decode($exception->getMessage(), true)];
        }
    }
}
