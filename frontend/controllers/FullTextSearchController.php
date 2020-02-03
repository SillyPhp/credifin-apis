<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class FullTextSearchController extends Controller
{
    public function actionTest($query=null)
    {
        $result = Yii::$app->db->createCommand("SELECT name FROM {{%unclaimed_organizations}} WHERE MATCH (name) AGAINST ('{$query}' IN NATURAL LANGUAGE MODE);");

        print_r($result->queryAll());
    }
}