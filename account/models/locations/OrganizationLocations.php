<?php

namespace account\models\locations;

class OrganizationLocations extends \common\models\extended\OrganizationLocations {

    private $locationType;
    private $limit;
    private $pageNumber;
    private $where = [];
    private $orderBy = [];

    private function __setOptions($options = []) {
        if ($options) {
            $this->limit = ((int) $options['limit']) ? $options['limit'] : NULL;
            $this->pageNumber = ((int) $options['pageNumber']) ? $options['pageNumber'] : 1;
            $this->where = ($options['where']) ? $options['where'] : [];
            $this->orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
            $this->locationType = ($options['locationType']) ? $options['locationType'] : NULL;
        }
    }

    public function getLocations($options = []) {
        $this->__setOptions($options);
        $locations = self::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.title', 'a.slug', 'c.name', 'd.icon'])
                ->joinWith(['title b' => function($b) {
                        $b->joinWith(['categoryEnc c'], false);
                        $b->joinWith(['parentEnc d'], false);
                    }], false)
                ->joinWith(['appliedApplications e' => function($c) {
                        $c->select(['e.application_enc_id']);
                    }], true)
                ->joinWith(['placementLocations'])
                ->where(['a.is_deleted' => 0])
                ->groupBy(['a.application_enc_id']);

        if ($this->locationType) {
            $locations->joinWith(['locationTypeEnc f' => function($d) {
                    $d->andWhere(['f.name' => $this->locationType]);
                }], false);
        }

        if ($this->where) {
            $locations->andWhere($this->where);
        }

        $total = $locations->count();

        if ($this->limit) {
            $offset = ($this->pageNumber - 1) * $this->limit;
            $locations->limit($this->limit)
                    ->offset($offset);
        }

        if ($this->orderBy) {
            $locations->orderBy($this->orderBy);
        }

        return [
            'total' => $total,
            'data' => $locations->asArray()->all(),
        ];
    }

}
