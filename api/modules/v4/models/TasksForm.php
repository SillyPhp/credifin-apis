<?php

namespace api\modules\v4\models;

use Yii;
use common\models\extended\UserTasks;

class TasksForm extends \common\models\UserTasks
{
    // adding tasks
    public function addTasks($options)
    {
        // adding data
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $this->task_enc_id = $utilitiesModel->encrypt();
        $this->created_on = date('Y-m-d H:i:s');
        $this->name = $options['name'];
        $this->created_by = $options['created_by'];
        if (!$this->validate()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $this->getErrors()];
        }

        return ['status' => 200, 'title' => 'Success', 'message' => 'Task added successfully', 'data' => ['id' => $this->task_enc_id, 'name' => $this->name, 'is_completed' => $this->is_completed]];

    }

    // getting tasks list
    public function getTasks($identity)
    {
        // query data
        $tasks = self::find()
            ->select(['name', 'task_enc_id', 'is_completed'])
            ->where(['created_by' => $identity, 'is_deleted' => 0]);

        // getting count
        $total = $tasks->count();

        // getting data array
        $tasks = $tasks->asArray()->all();

        // returing data
        return ['total' => $total, 'data' => $tasks];
    }

    // updating task
    public function updateTasks($data)
    {
        $query = Yii::$app->db->createCommand()
            ->update(self::tableName(), ['name' => $data['name'], 'last_updated_by' => $data ['identity'], 'last_updated_on' => date('Y-m-d H:i:s')], ['task_enc_id' => $data['task_id'], 'created_by' => $data ['identity']])
            ->execute();

        if ($query) {
            return true;
        } else {
            return false;
        }

    }

    // completing task
    public function is_completed_tasks($data)
    {
        // getting task object with task id
        $complete_status = self::findOne(['task_enc_id' => $data['task_id'], 'is_deleted' => 0, 'created_by' => $data['identity']]);

        // checking is completed
        if ($data['is_completed']) {
            $complete_status->is_completed = 1;
        } else {
            $complete_status->is_completed = 0;
        }

        // updating data
        if ($complete_status->update()) {
            return true;
        } else {
            return false;
        }

    }
}
