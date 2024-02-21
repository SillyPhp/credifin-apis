<?php
namespace common\models\extended;
use common\models\Brands;
class BrandsExtend extends \common\models\Brands{

    public function behaviors()
    {
        return [
            'common\models\extended\LoggableBehavior'
        ];
    }
}