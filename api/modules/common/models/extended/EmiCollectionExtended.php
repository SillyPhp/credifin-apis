<?php

namespace common\models\extended;

use common\models\EmiCollection;

class EmiCollectionExtended extends EmiCollection
{
    public function behaviors()
    {
        $model = explode("\\", EmiCollection::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}