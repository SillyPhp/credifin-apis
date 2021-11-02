<?php

namespace common\models\extended;

use common\models\ApplicationEducationalRequirements;
use common\models\ApplicationEmployeeBenefits;
use common\models\ApplicationInterviewLocations;
use common\models\ApplicationOptions;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationSkills;
use common\models\EducationalRequirements;
use Yii;
use common\models\ApplicationJobDescription;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Designations;
use common\models\Utilities;

class EmployerApplications extends \common\models\EmployerApplications
{

    public function getPlacementLocations()
    {
        return $this->getApplicationPlacementLocations()->alias('ap')->select(['application_enc_id', 'total' => 'sum(positions)'])->onCondition(['ap.is_deleted' => 0])->groupBy(['application_enc_id'])->asArray();
    }

    public function getLocations()
    {
        return $this->getApplicationPlacementLocations()->alias('aa')->select(['aa.application_enc_id', 'aa.location_enc_id', 'bb.city_enc_id', 'cc.name'])->joinWith(["locationEnc bb" => function ($b) {
            $b->joinWith(['cityEnc cc'], false);
        }], false)->asArray();
    }

    //$for 0 as both , 1 as Empower youth only and 2 as Erexx or Ecampus only
    public function _cloneApplication($id, $for = 1)
    {
        $row1 = \common\models\EmployerApplications::findOne(['application_enc_id' => $id]);
        $title = $this->_findTitle($row1->title);
        $designation = $this->_findDesignation($row1->designation_enc_id);
        $row2 = new \common\models\EmployerApplications();
        $row2->attributes = $row1->attributes;
        $row2->id = NULL;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $row2->application_enc_id = Yii::$app->security->generateRandomString(12);
        $row2->application_number = rand(1000, 10000) . time();
        $row2->application_for = $for;
        $row2->created_on = date('Y-m-d H:i:s');
        $row2->published_on = date('Y-m-d H:i:s');
        $utilitiesModel->variables['name'] = $title . '-' . $designation . '-' . $row2->application_number;
        $utilitiesModel->variables['table_name'] = \common\models\EmployerApplications::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $row2->slug = $utilitiesModel->create_slug();
        $row2->isNewRecord = true;
        if ($row2->save()) {

            $rowApplicationOptions1 = ApplicationOptions::findOne(['application_enc_id' => $id]);
            $rowApplicationOptions2 = new ApplicationOptions();
            $rowApplicationOptions2->attributes = $rowApplicationOptions1->attributes;
            $rowApplicationOptions2->option_enc_id = Yii::$app->security->generateRandomString(12);
            $rowApplicationOptions2->id = NULL;
            $rowApplicationOptions2->application_enc_id = $row2->application_enc_id;
            $rowApplicationOptions2->isNewRecord = true;
            if (!$rowApplicationOptions2->save()) {
                return false;
            }

            $rowJobDescription1 = ApplicationJobDescription::findAll(['application_enc_id' => $id]);
            if (!empty($rowJobDescription1) && count($rowJobDescription1) > 0) {
                foreach ($rowJobDescription1 as $description) {
                    $rowJobDescription2 = new ApplicationJobDescription();
                    $rowJobDescription2->attributes = $description->attributes;
                    $rowJobDescription2->id = Null;
                    $rowJobDescription2->application_job_description_enc_id = Yii::$app->security->generateRandomString(12);
                    $rowJobDescription2->application_enc_id = $row2->application_enc_id;
                    $rowJobDescription2->isNewRecord = true;
                    if (!$rowJobDescription2->save()) {
                        return false;
                    }
                }
            }

            $rowSkills1 = ApplicationSkills::findAll(['application_enc_id' => $id]);
            if (!empty($rowSkills1) && count($rowSkills1) > 0) {
                foreach ($rowSkills1 as $skills) {
                    $rowSkills2 = new ApplicationSkills();
                    $rowSkills2->attributes = $skills->attributes;
                    $rowSkills2->id = Null;
                    $rowSkills2->application_skill_enc_id = Yii::$app->security->generateRandomString(12);
                    $rowSkills2->application_enc_id = $row2->application_enc_id;
                    $rowSkills2->isNewRecord = true;
                    if (!$rowSkills2->save()) {
                        return false;
                    }
                }
                $rowEducationReq1 = ApplicationEducationalRequirements::findAll(['application_enc_id' => $id]);
                if (!empty($rowEducationReq1) && count($rowEducationReq1) > 0) {
                    foreach ($rowEducationReq1 as $educationalRequirements) {
                        $rowEducationReq2 = new ApplicationEducationalRequirements();
                        $rowEducationReq2->attributes = $educationalRequirements->attributes;
                        $rowEducationReq2->id = Null;
                        $rowEducationReq2->application_educational_requirement_enc_id = Yii::$app->security->generateRandomString(12);;
                        $rowEducationReq2->application_enc_id = $row2->application_enc_id;
                        $rowEducationReq2->isNewRecord = true;
                        if (!$rowEducationReq2->save()) {
                            return false;
                        }
                    }
                }
                $rowInterviewLocation1 = ApplicationInterviewLocations::findAll(['application_enc_id' => $id]);
                if (!empty($rowInterviewLocation1) && count($rowInterviewLocation1) > 0) {
                    foreach ($rowInterviewLocation1 as $interviewLocations) {
                        $rowInterviewLocation2 = new ApplicationInterviewLocations();
                        $rowInterviewLocation2->attributes = $interviewLocations->attributes;
                        $rowInterviewLocation2->id = Null;
                        $rowInterviewLocation2->interview_location_enc_id = Yii::$app->security->generateRandomString(12);
                        $rowInterviewLocation2->application_enc_id = $row2->application_enc_id;
                        $rowInterviewLocation2->isNewRecord = true;
                        if (!$rowInterviewLocation2) {
                            return false;
                        }
                    }
                }

                $rowPlacementLocation1 = ApplicationPlacementLocations::findAll(['application_enc_id' => $id]);
                if (!empty($rowPlacementLocation1) && count($rowPlacementLocation1) > 0) {
                    foreach ($rowPlacementLocation1 as $placementLocations) {
                        $rowPlacementLocation2 = new ApplicationPlacementLocations();
                        $rowPlacementLocation2->attributes = $placementLocations->attributes;
                        $rowPlacementLocation2->id = Null;
                        $rowPlacementLocation2->placement_location_enc_id = Yii::$app->security->generateRandomString(12);
                        $rowPlacementLocation2->application_enc_id = $row2->application_enc_id;
                        $rowPlacementLocation2->isNewRecord = true;
                        if (!$rowPlacementLocation2->save()) {
                            return false;
                        }
                    }
                }

                $rowEmployeBenifits1 = ApplicationEmployeeBenefits::findAll([['application_enc_id' => $id]]);
                if (!empty($rowEmployeBenifits1) && count($rowEmployeBenifits1) > 0) {
                    foreach ($rowEmployeBenifits1 as $employeBenifits) {
                        $rowEmployeBenifits2 = new ApplicationEmployeeBenefits();
                        $rowEmployeBenifits2->attributes = $employeBenifits->attributes;
                        $rowEmployeBenifits2->id = Null;
                        $rowEmployeBenifits2->application_benefit_enc_id = Yii::$app->security->generateRandomString(12);
                        $rowEmployeBenifits2->application_enc_id = $row2->application_enc_id;
                        $rowEmployeBenifits2->isNewRecord = true;
                        if (!$rowEmployeBenifits2->save()) {
                            return false;
                        }
                    }
                }

                return $row2->application_enc_id;
            }
        } else {
            return false;
        }
    }

    private function _findTitle($id)
    {
        $title = AssignedCategories::find()
            ->alias('a')
            ->where(['assigned_category_enc_id' => $id])
            ->select(['b.name'])
            ->joinWith(['categoryEnc b'], false)
            ->asArray()->one();

        return $title['name'];
    }

    private function _findDesignation($id)
    {
        $designation = Designations::find()
            ->select(['designation'])
            ->where(['designation_enc_id' => $id])
            ->asArray()->one();

        return $designation['designation'];
    }
}
