<?php

namespace api\modules\v4\models;

use common\models\UserRoles;
use common\models\Users;
use common\models\UserTypes;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class Employee extends Model
{
    public $first_name;
    public $last_name;
    public $userId;
    public $email;
    public $phone;
    public $userType;
    public $organization_enc_id;


    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['first_name','userId','last_name', 'email'],'string', 'max' => 100],
            [['email'],'email'],
            [['phone'], 'string','min'=>10, 'max' => 10],
            [['phone'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Phone can only contain numbers'],
            [['userType','first_name','last_name','phone','email'], 'safe'],
            [['organization_enc_id'], 'required', 'when' => function () {
                return $this->userType == 'Employee';
            }],
        ];
    }

    public function formName()
    {
         return '';
    }

    public function update($user_enc_id){
      $model = Users::findOne(['user_enc_id' => $this->userId]);
      try{
          if (!$this->validate()){
              throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($this->errors, 0, false)));
          }
          if ($model){
              if($this->first_name){
                  $model->first_name = $this->first_name;
              }
              if($this->last_name){
                  $model->last_name = $this->last_name;
              }
              if($this->email){
                  $model->email = $this->email;
              }
              if($this->phone){
                  $model->phone = $this->phone;
              }
              $model->last_updated_on = date('Y-m-d H:i:s');
              if (isset($this->userType)&&!empty($this->userType)){
                  $typeId = UserTypes::findOne(['user_type' => $this->userType]);
                  if ($typeId){
                      $model->user_type_enc_id = $typeId['user_type_enc_id'];
                      if ($this->userType == 'Employee') {
                          $role_check = UserRoles::findOne(['user_enc_id' => $this->userId]);
                          if (!$role_check) {
                              $user_roles = new UserRoles();
                              $user_roles->role_enc_id = Yii::$app->security->generateRandomString(20);
                              $user_roles->user_type_enc_id = $typeId['user_type_enc_id'];
                              $user_roles->user_enc_id = $this->userId;
                              $user_roles->organization_enc_id = $this->organization_enc_id;
                              $user_roles->created_on = date('Y-m-d H:i:s');
                              $user_roles->created_by = $user_enc_id;
                              $user_roles->updated_on = date('Y-m-d H:i:s');
                              $user_roles->updated_by = $user_enc_id;
                              if (!$user_roles->save()) {
                                  throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($user_roles->errors, 0, false)));
                              }
                          } else {
                              $role_check->organization_enc_id = $this->organization_enc_id;
                              $role_check->updated_by = $user_enc_id;
                              $role_check->updated_on = date('Y-m-d H:i:s');
                              if (!$role_check->save()) {
                                  throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($role_check->errors, 0, false)));
                              }
                          }
                      }
                  }else{
                      throw new \Exception("User Type Not Found Or Invalid UserID");
                  }
              }
              if (!$model->save()) {
                  throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
              }else{
                  return [
                      'status'=>true,
                      'message'=>'Success'
                  ];
              }
          }else {
              throw new \Exception("User Not Found Or Invalid UserID");
          }
      }catch (\Exception $e){
          return [
              'status'=>false,
              'error'=>$e->getMessage()
          ];
      }
  }
}