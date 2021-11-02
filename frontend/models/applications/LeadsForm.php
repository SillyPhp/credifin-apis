<?php
namespace frontend\models\applications;
use common\models\LeadsApplications;
use common\models\LeadsParentInformation;
use common\models\LoanApplicationLeads;
use common\models\Users;
use Yii;
use yii\base\Model;
use common\models\Utilities;
class LeadsForm extends Model
{
   public $_flag;
   public $first_name;
   public $last_name;
   public $student_mobile_number;
   public $student_email;
   public $university_name;
   public $course_name;
   public $course_fee_annual;
   public $parentElem;
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
           [['first_name','last_name','student_mobile_number','parentElem'],'required'],
           [['first_name', 'last_name', 'student_email','student_mobile_number','university_name','course_name'], 'trim'],
           [['university_name','student_email','course_name','course_fee_annual','parent_name','parent_relation','parent_mobile_number','parent_annual_income'],'safe'],
           [['first_name','last_name', 'university_name','course_name','student_email'], 'string', 'max' => 255],
           [['first_name', 'last_name'], 'match','pattern' => '/^([A-Z a-z])+$/', 'message' => 'Name can only contain alphabets'],
           [['student_mobile_number'], 'string','length'=>[10,10]],
           [['course_fee_annual'], 'integer','min'=>5000,'max'=>5000000],
           ['student_email','email'],
       ];
   }

   public function save()
   {
       $transaction = Yii::$app->db->beginTransaction();
       try {
           $model = new LeadsApplications();
           $utilitiesModel = new Utilities();
           $utilitiesModel->variables['string'] = time() . rand(100, 100000);
           $model->application_enc_id = $utilitiesModel->encrypt();
           $model->application_number = rand(1000, 10000) . time();
           $model->first_name = $this->first_name;
           $model->last_name = $this->last_name;
           $model->student_mobile_number = $this->student_mobile_number;
           $model->student_email = $this->student_email;
           $model->college_institute_name = $this->university_name;
           $model->course_name = $this->course_name;
           $model->course_fee_annual = $this->course_fee_annual;
           $model->filled_by = 1;
           $userID = Yii::$app->user->identity->user_enc_id;
           if($userID){
               $user = Users::find()
                   ->alias('z')->distinct()
                   ->where(['z.user_enc_id' => $userID])
                   ->joinWith(['userTypeEnc a' => function($a){
                       $a->andWhere(['a.user_type' => 'Executive']);
                   }],false)
                   ->asArray()
                   ->one();
               if(!empty($user)){
                   $model->managed_by = $userID;
                   $model->assign_date = date('Y-m-d H:i:s');
               }
           }
           $model->created_on = date('Y-m-d H:i:s');
           $model->created_by = (($userID)?$userID:null);
           if($model->save()){
               $this->_flag = true;
           }else{
               $transaction->rollback();
               $this->_flag = false;
               return false;
           }
           if (!empty($this->parentElem) && $this->parentElem > 0){
               for ($i=0;$i<$this->parentElem;$i++){
                   if (!empty($this->parent_name[$i])||!empty($this->parent_relation[$i])||!empty($this->parent_mobile_number[$i])||!empty($this->parent_annual_income[$i])){
                       $parent = new LeadsParentInformation();
                       $utilitiesModel = new Utilities();
                       $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                       $parent->lead_parent_enc_id = $utilitiesModel->encrypt();
                       $parent->application_enc_id = $model->application_enc_id;
                       $parent->name =(($this->parent_name[$i])?$this->parent_name[$i]:null);
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
           }
           if ($this->_flag)
           {
               $transaction->commit();
             return [
                 'app_num'=>$model->application_number,
                 'status'=>true,
             ];
           }else{
               return [
                   'status'=>false,
               ];
           }

       } catch (\Exception $exception) {
           $transaction->rollBack();
           return false;
       }
   }
}
