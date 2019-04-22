<?php

namespace account\controllers\templates;

use account\models\templates\HiringProcessModel;
use common\models\HiringProcessTemplateFields;
use common\models\HiringProcessTemplates;
use Yii;
use yii\web\Controller;
use yii\web\Response;
class HiringProcessController extends Controller
{
    public function actionIndex()
    {
        $options = [
            'orderBy' => [
                'a.created_on' => SORT_DESC,
            ],
        ];

        $processes = new \account\models\templates\TemplateHiringProcess();

        return $this->render('index', [
            'processes' => $processes->getProcesses($options),
        ]);
    }
    public function actionView($id)
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

    public function actionAssignHiringProcessTemplate()
    {
        if (Yii::$app->request->isPost)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $q = new HiringProcessModel();
            if ($q->assignToOrg($id))
            {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Added To Your List'
                ];
            }
            else
            {
                return [
                    'status' => 201,
                    'title' => 'error',
                    'message' => 'Something went wrong'
                ];
            }


        }
    }

    public function actionBookmarkHiringProcessTemplate()
    {
        if (Yii::$app->request->isPost)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $q = new HiringProcessModel();
            $execute = $q->assignToBookMark($id);
            if ($execute=='mark')
            {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Added To BookMark List'
                ];
            }
            elseif ($execute =='unmark')
            {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Removed From BookMark List'
                ];
            }
            else
            {
                return [
                    'status' => 201,
                    'title' => 'error',
                    'message' => 'Something went wrong'
                ];
            }


        }
    }

}