<?php

namespace account\models\benefits;

use Yii;
use yii\base\Model;
use common\models\EmployeeBenefits;
use common\models\Utilities;
use common\models\OrganizationEmployeeBenefits;

class Benefits extends Model
{

    public $benefit;
    public $predefind_benefit;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['predefind_benefit', 'benefit'], 'safe'],
        ];
    }

    public function Add()
    {
        if (!empty($this->benefit)) {
            $chek = EmployeeBenefits::find()
                ->where(['benefit' => $this->benefit])
                ->asArray()
                ->one();
            if (empty($chek)) {
                $beneiftModal = new EmployeeBenefits();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $beneiftModal->benefit_enc_id = $utilitiesModel->encrypt();
                $beneiftModal->benefit = $this->benefit;
                $beneiftModal->icon = null;
                $beneiftModal->icon_location = null;
                $beneiftModal->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                $beneiftModal->created_on = date('Y-m-d H:i:s');
                $beneiftModal->created_by = Yii::$app->user->identity->user_enc_id;
                if ($beneiftModal->save()) {
                    return $this->assignToOrg($beneiftModal->benefit_enc_id);
                }
            } else {
               return $this->checkBenefit($chek['benefit_enc_id']);
            }
        } else if (!empty($this->predefind_benefit)) {
            foreach ($this->predefind_benefit as $id) {
               $this->checkBenefitInArray($id);
            }
            return true;
        } else {
            return false;
        }

    }

    private function checkBenefit($id)
    {
        $chek_benefit = OrganizationEmployeeBenefits::find()
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'benefit_enc_id' => $id])
            ->asArray()
            ->one();
        if (empty($chek_benefit)) {
            return $this->assignToOrg($id);
        }
        else
        {
            return false;
        }

    }

    private function checkBenefitInArray($id)
    {
        $chek_benefit = OrganizationEmployeeBenefits::find()
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'benefit_enc_id' => $id])
            ->andWhere(['!=','is_deleted',1])
            ->asArray()
            ->one();
        if (empty($chek_benefit)) {
            $orgBenefitsModal = new OrganizationEmployeeBenefits;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $orgBenefitsModal->organization_benefit_enc_id = $utilitiesModel->encrypt();
            $orgBenefitsModal->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $orgBenefitsModal->benefit_enc_id = $id;
            $orgBenefitsModal->created_on = date('Y-m-d H:i:s');
            $orgBenefitsModal->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$orgBenefitsModal->save())
            {
                return false;
            }
        }

    }

    public function getAllBenefits()
    {
        $benefits = EmployeeBenefits::find()
            ->select(['benefit_enc_id', 'benefit', 'icon', 'icon_location'])
            ->andWhere(['or',
                ['organization_enc_id'=>null],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        return $benefits;
    }

    private function assignToOrg($id)
    {
        $orgBenefitsModal = new OrganizationEmployeeBenefits;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $orgBenefitsModal->organization_benefit_enc_id = $utilitiesModel->encrypt();
        $orgBenefitsModal->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $orgBenefitsModal->benefit_enc_id = $id;
        $orgBenefitsModal->created_on = date('Y-m-d H:i:s');
        $orgBenefitsModal->created_by = Yii::$app->user->identity->user_enc_id;
        if ($orgBenefitsModal->save()) {
            return true;
        }
        else
        {
            return false;
        }
    }
}
