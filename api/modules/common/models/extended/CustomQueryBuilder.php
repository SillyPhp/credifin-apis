<?php
namespace common\models\extended;

use yii\db\Query;
use yii\db\Expression;

class CustomQueryBuilder extends Query
{
    public function safeConcat($table, $column1, $column2, $alias)
    {
        $expression = new Expression("CONCAT($table.$column1, ' ', $table.$column2) AS $alias");
        $this->select($expression);
        return $this;
    }
}