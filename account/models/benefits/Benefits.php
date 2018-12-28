<?php

namespace account\models\benefits;

use Yii;
use yii\base\Model;
use common\models\EmployeeBenefits;
use common\models\Utilities;

class Benefits extends Model {

    public $benefit;

    public function formName() {
        return '';
    }

    public function rules() {
        return [
            [['benefit'], 'required'],
        ];
    }

    public function Add() {
        $beneiftModal = new EmployeeBenefits();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $beneiftModal->benefit_enc_id = $utilitiesModel->encrypt();
        $beneiftModal->benefit = $this->benefit;
        $beneiftModal->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $beneiftModal->created_on = date('Y-m-d H:i:s');
        $beneiftModal->created_by = Yii::$app->user->identity->user_enc_id;
        if ($beneiftModal->save()) {
            return true;
        } else {
            return false;
        }
    }

}
