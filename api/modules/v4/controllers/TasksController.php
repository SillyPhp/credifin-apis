<?php

namespace api\modules\v4\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\UserTasks;
use yii\filters\VerbFilter;
use yii\filters\Cors;


class TasksController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list' => ['POST', 'OPTIONS'],
                'create' => ['POST', 'OPTIONS'],
                'delete' => ['POST', 'OPTIONS'],
                'update' => ['POST', 'OPTIONS'],
                'is-complete' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionList()
    {
        if ($user = $this->isAuthorized()) {
            $identity = $user->user_enc_id;
            $taskModel = new \api\modules\v4\models\Tasks();
            $response = $taskModel->getTasks($identity);
            if ($response['total'] > 0) {
                return $this->response(200, [
                    'status' => 200,
                    'total' => $response['total'],
                    'tasks' => $response['data'],
                ]);
            } else {
                return $this->response(404, [
                    'status' => 404,
                    'message' => 'Tasks not found',
                ]);
            }
        }
    }

    public function actionCreate()
    {
        $params = Yii::$app->request->post();
        if ($user = $this->isAuthorized()) {
            if (empty($params['name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
            }
            $options = [
                'name' => $params['name'],
                'created_by' => $user->user_enc_id,
            ];
            $taskModel = new \api\modules\v4\models\Tasks();
            $response = $taskModel->addTasks($options);
            if ($response) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Task added successfully',
                    'data' => $response,
                ]);
            } else {
                return $this->response(500, [
                    'status' => 500,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }
        } else {
            return false;
        }

    }

    public function actionUpdate()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!empty($params['name'])) {
                $data['name'] = $params['name'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
            }
            if (!empty($params['task_enc_id'])) {
                $data['task_id'] = $params['task_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "task_enc_id"']);
            }
            $data['identity'] = $user->user_enc_id;


            $taskModel = new \api\modules\v4\models\Tasks();
            $response = $taskModel->updateTasks($data);
            if ($response) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Task title has been changed.',
                ]);
            } else {
                return $this->response(500, [
                    'status' => 500,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }
        }
    }

    public function actionDelete()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!empty($params['task_enc_id'])) {
                $task_id = $params['task_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "task_enc_id"']);
            }
            $data = [
                'task_id' => $task_id,
                'identity' => $user->user_enc_id,
            ];
            $taskModel = new \api\modules\v4\models\Tasks();
            $response = $taskModel->deleteTasks($data);

            if ($response) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Task has been deleted.',
                ]);
            } else {
                return $this->response(500, [
                    'status' => 500,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }
        }
    }

    public function actionIsComplete()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!empty($params['task_enc_id'])) {
                $data['task_id'] = $params['task_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "task_enc_id"']);
            }

            if (isset($params['is_completed'])) {
                $data['is_completed'] = $params['is_completed'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "is_completed"']);
            }
            $data['identity'] = $user->user_enc_id;
            $taskModel = new \api\modules\v4\models\Tasks();
            $response = $taskModel->is_completed_tasks($data);
            if ($response) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Task has been updated.',
                ]);
            } else {
                return $this->response(500, [
                    'status' => 500,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }
        }
    }
}