<?php

namespace common\models\extended;

use common\models\AssignedLoanAccounts;
use common\models\EmiCollection;
use common\models\LoanAccounts;

class LoanAccountsExtended extends LoanAccounts
{
    public function behaviors()
    {
        $model = explode("\\", LoanAccounts::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }

    public static $buckets = [
        'SMA0' => [
            'name' => 'SMA-0',
            'value' => 1.25
        ],
        'SMA1' => [
            'name' => 'SMA-1',
            'value' => 1.5
        ],
        'SMA2' => [
            'name' => 'SMA-2',
            'value' => 1.5
        ],
        'NPA' => [
            'name' => 'NPA',
            'value' => 2
        ],
        'OnTime' => [
            'name' => 'OnTime',
            'value' => null
        ],
    ];

    public function getEmiCollectionsCustom()
    {
        return $this->hasOne(EmiCollection::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}