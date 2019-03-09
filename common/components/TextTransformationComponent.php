<?php

namespace common\components;

use Yii;
use yii\base\Component;

class TextTransformationComponent extends Component
{

    public function firstUpper($string)
    {
        return ucfirst(strtolower($string));
    }

    public function firstLower($string)
    {
        return lcfirst(strtoupper($string));
    }

    public function toLower($string)
    {
        return strtolower(strtoupper($string));
    }

    public function toUpper($string)
    {
        return strtoupper(strtolower($string));
    }

    public function capitalize($string)
    {
        return ucwords(strtolower($string));
    }

}