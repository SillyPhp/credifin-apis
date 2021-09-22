<?php

namespace frontend\models\webinars;

use common\models\WebinarRequest;
use common\models\WebinarRequestSpeakers;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class WebinarRequestForm extends Model
{
    public $topic;
    public $date;
    public $seats;
    public $speakers;
    public $objective;
    public $_flag;

    public function rules()
    {
        return [
            [['topic'], 'required'],
            [['date', 'seats', 'speakers', 'objective'], 'safe'],
            ['seats', 'integer', 'min' => 1, 'max' => 1000000],
            [['topic', 'seats', 'objective'], 'trim'],
        ];
    }

    public function save($speaker_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new WebinarRequest();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->request_enc_id = $utilitiesModel->encrypt();
            $model->title = $this->topic;
            $model->date = $this->date;
            $model->seats = $this->seats;
            $model->objectives = $this->objective;
            $model->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$model->save()) {
                $transaction->rollback();
                $this->_flag = false;
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => $model->getErrors(),
                ];
            } else {
                $this->_flag = true;
            }
            if ($this->_flag && !empty($speaker_id)) {
                $speaker_id = explode(',', $speaker_id);
                foreach ($speaker_id as $sid) {
                    $speakerModel = new WebinarRequestSpeakers();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $speakerModel->request_speaker_enc_id = $utilitiesModel->encrypt();
                    $speakerModel->speaker_enc_id = $sid;
                    $speakerModel->webinar_request_enc_id = $model->request_enc_id;
                    $speakerModel->created_by = $model->created_by;
                    if (!$speakerModel->save()) {
                        $transaction->rollback();
                        $this->_flag = false;
                        return [
                            'status' => 201,
                            'title' => 'Error',
                            'message' => 'Something Went Wrong speakerModel',
                        ];
                    } else {
                        $this->_flag = true;
                    }
                }
            }
            if ($this->_flag) {
                $transaction->commit();
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Request Submitted Successfully',
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'Something Went Wrong flag',
                ];
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            print_r($e->getMessage());
            exit();
        }
    }
}