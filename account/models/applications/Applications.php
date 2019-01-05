<?php

namespace account\models\applications;

use common\models\extended\EmployerApplications;

class Applications extends EmployerApplications
{

    private $_applicationType;
    private $_limit;
    private $_pageNumber;
    private $_where = [];
    private $_orderBy = [];

    private function __setOptions($options = [])
    {
        if ($options) {
            $this->_limit = ((int)$options['limit']) ? $options['limit'] : NULL;
            $this->_pageNumber = ((int)$options['pageNumber']) ? $options['pageNumber'] : 1;
            $this->_where = ($options['where']) ? $options['where'] : [];
            $this->_orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
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
            ->select(['a.application_enc_id', 'a.title', 'CONCAT("/", "' . $slug . '", "/", a.slug) link', 'c.name', 'd.icon'])
            ->joinWith(['title b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
                $b->joinWith(['parentEnc d'], false);
            }], false)
            ->joinWith(['appliedApplications e' => function ($c) {
                $c->select(['e.application_enc_id']);
            }], true)
            ->joinWith(['placementLocations'])
            ->where(['a.is_deleted' => 0])
            ->groupBy(['a.application_enc_id']);

        if ($this->_applicationType) {
            $applications->joinWith(['applicationTypeEnc f' => function ($d) {
                $d->andWhere(['f.name' => $this->_applicationType]);
            }], false);
        }

        if ($this->_where) {
            $applications->andWhere($this->_where);
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
