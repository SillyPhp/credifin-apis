<?php

namespace account\models\processes;

class OrganizationInterviewProcesses extends \common\models\extended\OrganizationInterviewProcess {

    private $_limit;
    private $_pageNumber;
    private $_where = [];
    private $_orderBy = [];

    private function __setOptions($options = []) {
        if ($options) {
            $this->_limit = ((int) $options['limit']) ? $options['limit'] : NULL;
            $this->_pageNumber = ((int) $options['pageNumber']) ? $options['pageNumber'] : 1;
            $this->_where = ($options['where']) ? $options['where'] : [];
            $this->_orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
        }
    }

    public function getProcesses($options = []) {
        $this->__setOptions($options);
        $processes = self::find()
                ->select(['interview_process_enc_id id', 'process_name'])
                ->where(['is_deleted' => 0]);

        if ($this->_where) {
            $processes->andWhere($this->_where);
        }

        $total = $processes->count();

        if ($this->_limit) {
            $offset = ($this->_pageNumber - 1) * $this->_limit;
            $processes->limit($this->_limit)
                    ->offset($offset);
        }

        if ($this->_orderBy) {
            $processes->orderBy($this->_orderBy);
        }

        return [
            'total' => $total,
            'data' => $processes->asArray()->all(),
        ];
    }

}
