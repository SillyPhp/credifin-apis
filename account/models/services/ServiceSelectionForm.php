<?php

namespace account\models\services;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\SelectedServices;

class ServiceSelectionForm extends Model {

    public $services;
    private $_condition = [];
    private $_flag = false;

    public function formName() {
        return '';
    }

    public function rules() {
        return [
            [['services'], 'required'],
        ];
    }

    public function add() {
        if (!$this->validate()) {
            return false;
        }

        if (Yii::$app->user->identity->organization->organization_enc_id) {
            $this->_condition = ['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id];
        } else {
            $this->_condition = ['b.created_by' => Yii::$app->user->identity->user_enc_id];
        }

        $services = \common\models\Services::find()
                ->alias('a')
                ->select(['a.service_enc_id', 'a.name', 'b.selected_service_enc_id', 'b.is_selected'])
                ->joinWith(['selectedServices b' => function($b) {
                        $b->onCondition($this->_condition);
                    }], false)
                ->where(['a.is_always_visible' => 0])
                ->orderBy(['a.sequence' => SORT_ASC])
                ->asArray()
                ->all();
                    
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($services as $service) {
                if ($service['selected_service_enc_id']) {
                    $condition['selected_service_enc_id'] = $service['selected_service_enc_id'];
                    if (in_array($service['service_enc_id'], $this->services)) {
                        if ($service['is_selected'] !== 1) {
                            $data = [
                                'is_selected' => 1,
                                'last_updated_on' => date('Y-m-d H:i:s'),
                                'last_updated_by' => Yii::$app->user->identity->user_enc_id,
                            ];
                            if ($this->_update($data, $condition)) {
                                $this->_flag = true;
                            } else {
                                $transaction->rollBack();
                                $this->_flag = false;
                                break;
                            }
                        }
                    } else {
                        $data = [
                            'is_selected' => 0,
                            'last_updated_on' => date('Y-m-d H:i:s'),
                            'last_updated_by' => Yii::$app->user->identity->user_enc_id,
                        ];
                        if ($this->_update($data, $condition)) {
                            $this->_flag = true;
                        } else {
                            $transaction->rollBack();
                            $this->_flag = false;
                            break;
                        }
                    }
                } else {
                    if (in_array($service['service_enc_id'], $this->services)) {
                        if ($this->_add($service['service_enc_id'])) {
                            $this->_flag = true;
                        } else {
                            $transaction->rollBack();
                            $this->_flag = false;
                            break;
                        }
                    }
                }
            }

            if ($this->_flag) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        if ($this->_flag) {
            return true;
        } else {
            return false;
        }
    }

    private function _add($service) {
        $model = new SelectedServices;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->selected_service_enc_id = $utilitiesModel->encrypt();
        $model->service_enc_id = $service;
        if (Yii::$app->user->identity->organization->organization_enc_id) {
            $model->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        }
        $model->created_by = Yii::$app->user->identity->user_enc_id;
        $model->created_on = date('Y-m-d H:i:s');
        if ($model->validate() && $model->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function _update($data = [], $condition = []) {
        if ($data && $condition) {
            $service = \common\models\SelectedServices::findOne($condition);
            if ($service) {
                foreach ($data as $key => $value) {
                    $field = $key;
                    $service->$field = $value;
                }

                if ($service->validate() && $service->update()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

}
