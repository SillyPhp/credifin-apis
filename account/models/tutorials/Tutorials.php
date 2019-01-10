<?php

namespace account\models\tutorials;

use common\models\WidgetTutorials;

class Tutorials extends WidgetTutorials
{
    private $_limit;
    private $_pageNumber;
    private $_where = [];
    private $_orderBy = [];

    private function __setOptions($options = [])
    {
        if ($options) {
            $this->_limit = ((int)$options['limit']) ? $options['limit'] : NULL;
            $this->_where = ($options['where']) ? $options['where'] : [];
            $this->_orderBy = ($options['orderBy']) ? $options['orderBy'] : [];
        }
    }

    public function getTutorialsByUser($options = [])
    {
        $this->__setOptions($options);
        $tutorials = self::find()
            ->alias('a')
            ->distinct()
            ->select(['a.tutorial_enc_id id', 'a.name', 'b.is_viewed']);

        if ($this->_where) {
            $tutorials->andWhere($this->_where);
        }

        $total = $tutorials->count();

        if ($this->_limit) {
            $offset = ($this->_pageNumber - 1) * $this->_limit;
            $tutorials->limit($this->_limit)
                ->offset($offset);
        }

        if ($this->_orderBy) {
            $tutorials->orderBy($this->_orderBy);
        }

        return [
            'total' => $total,
            'data' => $tutorials->asArray()->all(),
        ];
    }

}
