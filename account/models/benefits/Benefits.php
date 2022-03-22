<?php

namespace account\models\benefits;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
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
            $already_saved_benefit = OrganizationEmployeeBenefits::find()
                ->select('benefit_enc_id')
                ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'is_deleted'=>0])
                ->asArray()
                ->all();
            $already_saved_benefits = [];
            foreach ($already_saved_benefit as $bf){
                array_push($already_saved_benefits,$bf['benefit_enc_id']);
            }
            $to_be_added_location = array_diff($this->predefind_benefit, $already_saved_benefits);
            $to_be_deleted_location = array_diff($already_saved_benefits, $this->predefind_benefit);
            foreach ($to_be_added_location as $id) {
                $this->checkBenefitInArray($id);
            }
            foreach ($to_be_deleted_location as $id) {
                $this->removeBenefitInArray($id);
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
        } else {
            return false;
        }

    }

    private function checkBenefitInArray($id)
    {
        $chek_benefit = OrganizationEmployeeBenefits::find()
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'benefit_enc_id' => $id])
//            ->andWhere(['!=','is_deleted',1])
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
            if (!$orgBenefitsModal->save()) {
                return false;
            }
        } else{
            $update = Yii::$app->db->createCommand()
                ->update(OrganizationEmployeeBenefits::tableName(), ['is_deleted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['benefit_enc_id' => $id])
                ->execute();
        }

    }

    private function removeBenefitInArray($id)
    {
//        $chek_benefit = OrganizationEmployeeBenefits::find()
//            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'benefit_enc_id' => $id])
//            ->andWhere(['!=','is_deleted',1])
//            ->asArray()
//            ->one();
        $update = Yii::$app->db->createCommand()
            ->update(OrganizationEmployeeBenefits::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['benefit_enc_id' => $id])
            ->execute();
    }

    public function getAllBenefits()
    {
        $benefits = EmployeeBenefits::find()
            ->select(['benefit_enc_id', 'benefit', 'CASE WHEN icon IS NULL OR icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon) . '",icon_location, "/", icon) END icon'])
            ->where(['is_deleted' => 0])
            ->andWhere(['or',
                ['status' => 'Publish'],
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
        } else {
            return false;
        }
    }
}
