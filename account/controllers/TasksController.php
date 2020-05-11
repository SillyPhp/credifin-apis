<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\UserTasks;

class TasksController extends Controller
{

    private $_condition;

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (Yii::$app->user->identity->organization_enc_id) {
                $this->_condition = ['organization_enc_id' => Yii::$app->user->identity->organization_enc_id];
            } else {
                $this->_condition = ['created_by' => Yii::$app->user->identity->user_enc_id];
            }

            $page = Yii::$app->request->post('page');

            if (!(int)$page > 0) {
                $page = 1;
            }

            $options = [
                'where' => $this->_condition,
                'pageNumber' => $page,
                'orderBy' => [
                    'created_on' => SORT_DESC,
                ],
            ];

            $tasksModel = new \account\models\tasks\Tasks();
            $tasks = $tasksModel->getTasks($options);

            if ($tasks['total'] > 0) {
                return [
                    'status' => 200,
                    'tasks' => $tasks['data'],
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $data['task_enc_id'] = $utilitiesModel->encrypt();
            $data['name'] = Yii::$app->request->post('task');
            if (Yii::$app->user->identity->organization->organization_enc_id) {
                $data['organization_enc_id'] = Yii::$app->user->identity->organization->organization_enc_id;
            }
            $data['created_on'] = date('Y-m-d H:i:s');
            $data['created_by'] = Yii::$app->user->identity->user_enc_id;
            $options = [
                'data' => $data,
            ];

            $tasksModel = new \account\models\tasks\Tasks();
            $response = $tasksModel->addTask($options);
            if ($response) {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Task added successfully',
                    'data' => $response,
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        $task = UserTasks::findOne([
            'task_enc_id' => $id,
            'is_deleted' => 0,
        ]);

        $task->is_deleted = 1;
        if ($task->update()) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Task has been deleted.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }


    public function actionTaskComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        $task = UserTasks::findOne([
            'task_enc_id' => $id,
            'is_completed' => 0,
            'is_deleted' => 0,
        ]);

        $task->is_completed = 1;
        if ($task->update()) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Task has been Completed.',
                $task = [
                    'name' => $task->name,
                    'id' => $task->id,
                ]
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionTaskIncomplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        $task = UserTasks::findOne([
            'task_enc_id' => $id,
            'is_completed' => 1,
            'is_deleted' => 0,
        ]);

        $task->is_completed = 0;
        if ($task->update()) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Task has been Updated or add to incomplete.',
                $task = [
                    'name' => $task->name,
                    'id' => $task->id,
                ]
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $name = Yii::$app->request->post('name');
            $task_id = Yii::$app->request->post('task_id');

            $update = Yii::$app->db->createCommand()
                ->update(UserTasks::tableName(), ['name' => $name, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['task_enc_id' => $task_id])
                ->execute();
            if ($update) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Task title has been changed.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }

        }
    }

}
