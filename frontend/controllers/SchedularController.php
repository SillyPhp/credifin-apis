<?php

namespace frontend\controllers;


use common\models\InterviewerDetail;
use yii\web\Controller;

class SchedularController extends Controller
{
    public function actionInerviewerStatus($id, $type)
    {
        $this->layout = 'main-secondary';
        $interviewer_details = InterviewerDetail::find()
            ->where(['interviewer_detail_enc_id' => $id])
            ->one();

        if ($interviewer_details->status == 1) {
            return $this->render('/site/message',['message'=>'You are already accepted.']);
        } elseif ($interviewer_details->status == 2) {
            return $this->render('/site/message',['message'=>'You are already rejected.']);
        } else {

            if (!empty($interviewer_details)) {
                if ($type == 'accept') {
                    $interviewer_details->status = 1;
                } elseif ($type == 'reject') {
                    $interviewer_details->status = 2;
                }

                if ($interviewer_details->update()) {
                    return $this->render('/site/message',['message'=>'successfully '.$type.'ed']);
                }
            }
        }
    }
}