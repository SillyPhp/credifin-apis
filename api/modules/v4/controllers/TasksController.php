<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\TasksForm;
use common\models\UserTasks;
use Yii;
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

    // this action is used to get tasks list
    public function actionList()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // creating tasks form object
            $taskModel = new TasksForm();

            // getting tasks
            $response = $taskModel->getTasks($user->user_enc_id);

            if ($response['total']) {
                return $this->response(200, ['status' => 200, 'total' => $response['total'], 'tasks' => $response['data']]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Tasks not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to creating tasks
    public function actionCreate()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking name
            if (empty($params['name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
            }

            // adding options
            $options = ['name' => $params['name'], 'created_by' => $user->user_enc_id];

            // creating tasks object
            $taskModel = new TasksForm();

            // adding task
            $response = $taskModel->addTasks($options);

            if ($response['status'] == 200) {
                return $this->response(200, $response);
            } else {
                return $this->response(500, $response);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

    }

    // this action is used to update task
    public function actionUpdate()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking name
            if (empty($params['name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
            }

            // checking task_enc_id
            if (empty($params['task_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "task_enc_id"']);
            }

            // creating tasks form object
            $taskModel = new TasksForm();

            // updating task
            $response = $taskModel->updateTasks(['name' => $params['name'], 'task_id' => $params['task_enc_id'], 'identity' => $user->user_enc_id]);

            if ($response) {
                return $this->response(200, ['status' => 200, 'title' => 'Success', 'message' => 'Task title has been changed.']);
            } else {
                return $this->response(500, ['status' => 500, 'title' => 'Error', 'message' => 'An error has occurred. Please try again.']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to delete task
    public function actionDelete()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting request params
            $params = Yii::$app->request->post();

            // checking task_enc_id
            if (empty($params['task_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "task_enc_id"']);
            }

            // updating data query
            $query = Yii::$app->db->createCommand()
                ->update(UserTasks::tableName(), ['is_deleted' => 1], ['task_enc_id' => $params['task_enc_id'], 'is_deleted' => 0, 'created_by' => $user->user_enc_id])
                ->execute();

            if ($query) {
                return $this->response(200, ['status' => 200, 'title' => 'Success', 'message' => 'Task has been deleted.']);
            } else {
                return $this->response(500, ['status' => 500, 'title' => 'Error', 'message' => 'An error has occurred. Please try again.']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this is used to complete task
    public function actionIsComplete()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking task_enc_id
            if (empty($params['task_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "task_enc_id"']);
            }

            // checking is_completed
            if (!isset($params['is_completed'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "is_completed"']);
            }

            // creating form object
            $taskModel = new TasksForm();

            // completing task
            $response = $taskModel->is_completed_tasks(['task_id' => $params['task_enc_id'], 'is_completed' => $params['is_completed'], 'identity' => $user->user_enc_id]);

            if ($response) {
                return $this->response(200, ['status' => 200, 'title' => 'Success', 'message' => 'Task has been updated.']);
            } else {
                return $this->response(500, ['status' => 500, 'title' => 'Error', 'message' => 'An error has occurred. Please try again.']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}