<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\OrganizationEmployeeBenefits;
use common\models\EmployeeBenefits;

class AddEmployeeBenefitForm extends Model
{

    public $add_benefit;
    public $emp_benefit;

    public function rules()
    {
        return [
            [['emp_benefit', 'add_benefit'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'add_benefit' => Yii::t('frontend', 'Add New Benefit'),
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }
        if (!empty($this->emp_benefit)) {
            foreach ($this->emp_benefit as $bid) {
                $utilitiesModel = new Utilities();
                $organizationEmployeeBenefitModel = new OrganizationEmployeeBenefits();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organizationEmployeeBenefitModel->organization_benefit_enc_id = $utilitiesModel->encrypt();
                $organizationEmployeeBenefitModel->benefit_enc_id = $bid;
                $organizationEmployeeBenefitModel->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                $organizationEmployeeBenefitModel->created_on = date('Y-m-d H:i:s');
                $organizationEmployeeBenefitModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$organizationEmployeeBenefitModel->validate() || !$organizationEmployeeBenefitModel->save()) {
                    return $organizationEmployeeBenefitModel->getErrors();
                }
            }
        }
        if (!empty($this->add_benefit)) {
            $utilitiesModel = new Utilities();
            $employeeBenefitModel = new EmployeeBenefits();
            $organizationEmployeeBenefitModel = new OrganizationEmployeeBenefits();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $employeeBenefitModel->benefit_enc_id = $utilitiesModel->encrypt();
            $employeeBenefitModel->benefit = $this->add_benefit;
            $employeeBenefitModel->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
            $employeeBenefitModel->created_on = date('Y-m-d H:i:s');
            $employeeBenefitModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$employeeBenefitModel->validate() || !$employeeBenefitModel->save()) {
                return $employeeBenefitModel->getErrors();
            }
            $organizationEmployeeBenefitModel->organization_benefit_enc_id = $utilitiesModel->encrypt();
            $organizationEmployeeBenefitModel->benefit_enc_id = $employeeBenefitModel->benefit_enc_id;
            $organizationEmployeeBenefitModel->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
            $organizationEmployeeBenefitModel->created_on = date('Y-m-d H:i:s');
            $organizationEmployeeBenefitModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$organizationEmployeeBenefitModel->validate() || !$organizationEmployeeBenefitModel->save()) {
                return $organizationEmployeeBenefitModel->getErrors();
            }
        }

        return true;
    }


}
