<?php

namespace api\modules\v4\models;

use Yii;
use common\models\extended\UserTasks;

class Tasks extends \common\models\UserTasks
{
    private $_fail = false;

    public function addTasks($options)
    {
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $this->task_enc_id = $utilitiesModel->encrypt();
        $this->created_on = date('Y-m-d H:i:s');
        $this->name = $options['name'];
        $this->created_by = $options['created_by'];
        if (!$this->validate()) {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->save()) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
                $this->_fail = true;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        if ($this->_fail) {
            return [
                'id' => $this->task_enc_id,
                'name' => $this->name,
                'is_completed' => $this->is_completed,
            ];
        } else {
            return false;
        }

    }

    public function getTasks($identity)
    {
        $tasks = self::find()
            ->select(['name', 'task_enc_id', 'is_completed'])
            ->where(['created_by' => $identity, 'is_deleted' => 0]);
        $total = $tasks->count();
        $tasks = $tasks
            ->asArray()
            ->all();
        return [
            'total' => $total,
            'data' => $tasks
        ];
    }

    public function updateTasks($data)
    {
        $name = $data['name'];
        $task_id = $data['task_id'];
        $identity = $data ['identity'];
        $query = Yii::$app->db->createCommand()
            ->update(self::tableName(), ['name' => $name, 'last_updated_by' => $identity, 'last_updated_on' => date('Y-m-d H:i:s')], ['task_enc_id' => $task_id, 'created_by' => $identity])
            ->execute();
        if ($query) {
            return true;
        } else {
            return false;
        }

    }

    public function deleteTasks($data)
    {
        $task_id = $data['task_id'];
        $identity = $data['identity'];
        $query = Yii::$app->db->createCommand()
            ->update(self::tableName(), ['is_deleted' => 1], ['task_enc_id' => $task_id, 'is_deleted' => 0, 'created_by' => $identity])
            ->execute();
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function is_completed_tasks($data)
    {
        $task_id = $data['task_id'];
        $identity = $data['identity'];
        $is_completed = $data['is_completed'];
        $complete_status = self::findOne([
            'task_enc_id' => $task_id,
            'is_deleted' => 0,
            'created_by' => $identity,
        ]);
        if ($is_completed) {
            $complete_status->is_completed = 1;
        } else {
            $complete_status->is_completed = 0;
        }
        if ($complete_status->update()) {
            return true;
        } else {
            return false;
        }

    }

}
