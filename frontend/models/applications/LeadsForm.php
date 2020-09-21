<?php
namespace frontend\models\applications;
use common\models\LeadsParentInformation;
use common\models\LoanApplicationLeads;
use Yii;
use yii\base\Model;
use common\models\Utilities;
class LeadsForm extends Model
{
   public $_flag;
   public $student_name;
   public $student_mobile_number;
   public $university_name;
   public $course_name;
   public $course_fee_annual;
   public $parent_name = [];
   public $parent_relation = [];
   public $parent_mobile_number = [];
   public $parent_annual_income = [];

   public function formName()
   {
       return '';
   }

   public function rules()
   {
       return [
           [['student_name','student_mobile_number'],'required'],
           [['university_name','course_name','course_fee_annual','parent_name','parent_relation','parent_mobile_number','parent_annual_income'],'safe'],
           [['student_name', 'university_name','course_name'], 'string', 'max' => 255],
           [['student_mobile_number'], 'string','length'=>[10,15]],
           [['course_fee_annual'], 'integer'],
       ];
   }

   public function save()
   {
       $transaction = Yii::$app->db->beginTransaction();
       try {
           $model = new LoanApplicationLeads();
           $utilitiesModel = new Utilities();
           $utilitiesModel->variables['string'] = time() . rand(100, 100000);
           $model->lead_enc_id = $utilitiesModel->encrypt();
           $model->application_number = rand(1000, 10000) . time();
           $model->student_name = $this->student_name;
           $model->student_mobile_number = $this->student_mobile_number;
           $model->university_name = $this->university_name;
           $model->course_name = $this->course_name;
           $model->course_fee_annual = $this->course_fee_annual;
           $model->created_on = date('Y-m-d H:i:s');
           $model->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
           if(!$model->save()){
               $transaction->rollback();
               $this->_flag = false;
               return false;
           }else{
               $this->_flag = true;
           }
           if (count($this->parent_name)>0){
               for ($i=0;$i<count($this->parent_name);$i++){
                   $parent = new LeadsParentInformation();
                   $utilitiesModel = new Utilities();
                   $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                   $parent->lead_parent_enc_id = $utilitiesModel->encrypt();
                   $parent->lead_enc_id = $model->lead_enc_id;
                   $parent->name = $this->parent_name[$i];
                   $parent->relation_with_student = (($this->parent_relation[$i])?$this->parent_relation[$i]:null);
                   $parent->mobile_number = (($this->parent_mobile_number[$i])?$this->parent_mobile_number[$i]:null);
                   $parent->annual_income = (($this->parent_annual_income[$i])?$this->parent_annual_income[$i]:null);
                   $parent->created_on = date('Y-m-d H:i:s');
                   $parent->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
                   if (!$parent->save()){
                       $transaction->rollback();
                       $this->_flag = false;
                       return false;
                   }else{
                       $this->_flag = true;
                   }
               }
           }
           if ($this->_flag)
           {
               $session = Yii::$app->session;
               $session->set('app_number', $model->application_number);
               $transaction->commit();
             return true;
           }else{
               return false;
           }

       } catch (\Exception $exception) {
           $transaction->rollBack();
           return false;
       }
   }
}