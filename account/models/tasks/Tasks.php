<?php

namespace account\models\tasks;

use Yii;
use common\models\extended\UserTasks;

class Tasks extends UserTasks {

    private $_limit;
    private $_pageNumber;
    private $_where = [];
    private $_orderBy = [];
    private $_data = [];
    private $_flag = false;

    private function __setOptions($options = []) {
        if ($options) {
            $this->_limit = ((int) $options['limit']) ? $options['limit'] : NULL;
            $this->_pageNumber = ((int) $options['pageNumber']) ? $options['pageNumber'] : 1;
            $this->_where = ($options['where']) ? $options['where'] : [];
            $this->_orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
            $this->_data = ($options['data']) ? $options['data'] : [];
        }
    }

    public function getTasks($options = []) {
        $this->__setOptions($options);

        $tasks = self::find()
                ->select(['name', 'task_enc_id task_id', 'is_completed'])
                ->where(['is_deleted' => 0]);

        if ($this->_where) {
            $tasks->andWhere($this->_where);
        }

        $total = $tasks->count();

        if ($this->_limit) {
            $offset = ($this->_pageNumber - 1) * $this->_limit;
            $tasks->limit($this->_limit)
                    ->offset($offset);
        }

        if ($this->_orderBy) {
            $tasks->orderBy($this->_orderBy);
        }

        return [
            'total' => $total,
            'data' => $tasks->asArray()->all(),
        ];
    }

    public function addTask($options = []) {
        $this->__setOptions($options);

        foreach ($options['data'] as $key => $value) {
            $field = $key;
            $this->$field = $value;
        }

        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->save()) {
                $transaction->rollBack();
                $this->_flag = false;
            } else {
                $this->_flag = true;
            }

            if ($this->_flag) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

        if ($this->_flag) {
            return [
                'id' => $this->task_enc_id,
                'name' => $this->name,
                'is_completed' => $this->is_completed,
            ];
        } else {
            return false;
        }
    }

    public function editTask($options = []) {
        $this->__setOptions($options);
    }

    public function deleteTask($options = []) {
        $this->__setOptions($options);
    }

}
