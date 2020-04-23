<?php

namespace account\models\campus_placement;

use common\models\ErexxCollaborators;
use Yii;
use yii\base\Model;
use common\models\Utilities;

//use common\models\OrganizationInterviewProcess;
//use common\models\InterviewProcessFields;

class CollegePlacementForm extends Model
{

    public $college_id;

    public function rules()
    {
        return [
            [['college_id'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $already_saved_college = ErexxCollaborators::find()
            ->select(['college_enc_id'])
            ->where(['organization_enc_id'=>Yii::$app->user->identity->organization->organization_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->all();

        if(!empty($already_saved_college)){
            $saved_c = [];
            foreach ($already_saved_college as $a){
                array_push($saved_c,$a['college_enc_id']);
            }

            $to_be_added = array_diff($this->college_id,$saved_c);
            $to_be_deleted = array_diff($saved_c,$this->college_id);

           if(!empty($to_be_added)){
               foreach ($to_be_added as $t){
                   $this->addCollege($t);
               }
           }

           if(!empty($to_be_deleted)){
               foreach ($to_be_deleted as $d){
                   $this->deleteCollege($d);
               }
           }
           return true;
        }else {

            foreach ($this->college_id as $array) {
                $utilitiesModel = new Utilities();
                $erexxCollaboratorsModel = new ErexxCollaborators();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $erexxCollaboratorsModel->collaboration_enc_id = $utilitiesModel->encrypt();
                $erexxCollaboratorsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                $erexxCollaboratorsModel->college_enc_id = $array;
                $erexxCollaboratorsModel->created_on = date('Y-m-d H:i:s');
                $erexxCollaboratorsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$erexxCollaboratorsModel->save()) {
                    return false;
                }
            }
            return true;
        }
    }

    private function addCollege($id){
        $college = ErexxCollaborators::find()
            ->where(['college_enc_id'=>$id])
            ->one();
        if(!empty($college) && $college->is_deleted == 1){
            $college->is_deleted = 0;
            $college->last_updated_by = Yii::$app->user->identity->user_enc_id;
            if(!$college->update()){
                return false;
            }
        } else {
            $utilitiesModel = new Utilities();
            $erexxCollaboratorsModel = new ErexxCollaborators();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $erexxCollaboratorsModel->collaboration_enc_id = $utilitiesModel->encrypt();
            $erexxCollaboratorsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $erexxCollaboratorsModel->college_enc_id = $id;
            $erexxCollaboratorsModel->created_on = date('Y-m-d H:i:s');
            $erexxCollaboratorsModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$erexxCollaboratorsModel->save()) {
                return false;
            }
        }
    }

    private function deleteCollege($id){
        $college = ErexxCollaborators::find()
            ->where(['college_enc_id'=>$id])
            ->one();
        if($college->is_deleted == 0) {
            $college->is_deleted = 1;
        } else{
            $college->is_deleted = 0;
        }
        $college->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if(!$college->update()){
            return false;
        }
    }

}