<?php

namespace common\models\extended;

use common\models\Utilities;

class Subscribers extends \common\models\Subscribers
{
    public $name;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['name', 'email'], 'trim'],
            [['subscriber_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['email'], 'email'],
        ];
    }

    public function subscribe()
    {
        if (!$this->validate()) {
            $errors = $this->getErrors();
            foreach ($errors as $key => $value) {
                $error .= implode('<br>', $value) . '<br>';
            }
            return [
                'status' => 201,
                'title' => 'Validation Error',
                'message' => $error
            ];
        };

        $model = new \common\models\Subscribers();
        $name = explode(' ', $this->name);
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->subscriber_enc_id = $utilitiesModel->encrypt();
        $model->first_name = $name[0];
        if (isset($name[1])) {
            $model->last_name = $name[1];
        }
        $model->email = $this->email;
        $model->subscription_for = 1;
        if (!$model->validate() || !$model->save()) {
            return [
                'status' => 201,
                'title' => 'Error',
                'message' => 'Something went wrong.. Try again later'
            ];
        } else {
            return [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Subscribed Successfully..!'
            ];
        }
    }
}
