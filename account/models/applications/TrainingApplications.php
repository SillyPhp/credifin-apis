<?php

namespace account\models\applications;

use common\models\TrainingProgramApplication;

class TrainingApplications extends TrainingProgramApplication
{

    private $_applicationType;
    private $_limit;
    private $_pageNumber;
    private $_where = [];
    private $_orderBy = [];
    private $_having = [];

    private function __setOptions($options = [])
    {
        if ($options) {
            $this->_limit = ((int)$options['limit']) ? $options['limit'] : NULL;
            $this->_pageNumber = ((int)$options['pageNumber']) ? $options['pageNumber'] : 1;
            $this->_where = ($options['where']) ? $options['where'] : [];
            $this->_orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
            $this->_having = ($options['having']) ? $options['having'] : [];
            $this->_applicationType = ($options['applicationType']) ? $options['applicationType'] : NULL;
        }
    }

    public function getApplications($options = [])
    {
        $this->__setOptions($options);
        $slug = substr_replace(strtolower($this->_applicationType), "", -1);
        $applications = self::find()
            ->alias('a')
            ->distinct()
            ->where(['a.is_deleted' => 0])
            ->groupBy(['a.application_enc_id','d.id'])
            ->select(['a.application_enc_id','SUM(d.seats) total_seats','a.description','a.training_duration','CONCAT("/", "' . $slug . '", "/", a.slug) link','a.training_duration_type','l.name cat_name','c.name as title', 'l.icon_png','l.icon'])
            ->joinWith(['title0 b'=>function($b)
            {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc c'],false);
            }],false)
            ->joinWith(['trainingProgramBatches d'=>function($b)
            {
                $b->onCondition(['d.is_deleted'=>0]);
                $b->select(['d.application_enc_id','i.name','d.fees','d.fees_methods','d.seats','d.days','start_time','d.end_time']);
                $b->joinWith(['cityEnc i'],false);
            }])
            ->joinWith(['trainingProgramSkills g' => function ($b) {
                $b->onCondition(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
            }]);

        if ($this->_applicationType) {
            $applications->joinWith(['applicationTypeEnc f' => function ($d) {
                $d->andWhere(['f.name' => $this->_applicationType]);
            }], false);
        }

        if ($this->_where) {
            $applications->andWhere($this->_where);
        }
        if ($this->_having) {
            $applications->having($this->_having);
        }

        $total = $applications->count();

        if ($this->_limit) {
            $offset = ($this->_pageNumber - 1) * $this->_limit;
            $applications->limit($this->_limit)
                ->offset($offset);
        }

        if ($this->_orderBy) {
            $applications->orderBy($this->_orderBy);
        }

        return [
            'total' => $total,
            'data' => $applications->asArray()->all(),
        ];
    }

}
