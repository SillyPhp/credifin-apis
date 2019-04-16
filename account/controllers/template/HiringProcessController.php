<?php

namespace account\controllers\template;

use Yii;
use yii\web\Controller;

class HiringProcessController extends Controller
{
    public function actionHiringProcess($id)
    {
        $process_name = HiringProcessTemplates::find()
            ->select(['process_name'])
            ->where(['hiring_process_enc_id' => $id])
            ->asArray()
            ->one();
        $process_fields = HiringProcessTemplateFields::find()
            ->select(['field_name', 'icon'])
            ->where(['hiring_process_enc_id' => $id])
            ->asArray()
            ->all();
        if (empty($process_name)|| empty($process_fields)) {
            return 'not found';
        }

        return $this->render('/hiring-processes/display', [
            'process_name' => $process_name,
            'process_fields' => $process_fields
        ]);
    }
}