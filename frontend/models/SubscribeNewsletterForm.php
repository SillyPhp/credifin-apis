<?php

namespace frontend\models;

use common\models\Subscribers;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class SubscribeNewsletterForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['first_name', 'last_name'], 'safe'],
            [['first_name', 'last_name', 'email'], 'trim'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $subscribers = Subscribers::find()
            ->where(['email' => $this->email])
            ->one();
        if($subscribers){
            $subscribers->first_name = $this->first_name;
            $subscribers->last_name = $this->last_name;
            if($subscribers->update()) {
                return true;
            } else{
                return 'exists';
            }
        }
        $subscribersModel = new \common\models\Subscribers();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $subscribersModel->subscriber_enc_id = $utilitiesModel->encrypt();
        $subscribersModel->first_name = $this->first_name;
        $subscribersModel->last_name = $this->last_name;
        $subscribersModel->email = $this->email;
        if ($subscribersModel->validate() && $subscribersModel->save()) {
            return true;
        } else {
            return false;
        }
    }
}