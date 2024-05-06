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
            'value' => 1.25,
            'subBucket'=>'1,2'
        ],
        'SMA1' => [
            'name' => 'SMA-1',
            'value' => 1.5,
            'subBucket'=>'3,4'
        ],
        'SMA2' => [
            'name' => 'SMA-2',
            'value' => 1.5,
            'subBucket'=>'5,6'
        ],
        'NPA' => [
            'name' => 'NPA',
            'value' => 2,
            'subBucket'=>'7,8'
        ],
        'OnTime' => [
            'name' => 'OnTime',
            'value' => null,
            'subBucket'=>'X'
        ],
    ];

    public static $user_types = [
        'Area Collection Manager' => 'Collection',
        'Area Sales Manager' => 'Sales',
        'Branch Operations Executive' => 'Sales',
        'Business Development Officer' => 'Sales',
        'Business Manager' => 'Sales',
        'Collection Head' => 'Collection',
        'Collection Manager' => 'Collection',
        'Collection Officer' => 'Collection',
        'Customer Relationship Manager' => 'Sales',
        'Deputy Area Collection Manager' => 'Collection',
        'Deputy Area Sales Manager' => 'Sales',
        'Marketing Executive' => 'Sales',
        'MIS Manager' => 'Sales',
        'Operations Executive' => 'Sales',
        'Operations Manager' => 'Sales',
        'Regional  Operations Executive' => 'Sales',
        'Regional Collection Manager' => 'Collection',
        'Regional Operation Executive' => 'Sales',
        'Regional Operations Manager' => 'Sales',
        'Senior Business Development Officer' => 'Sales',
        'Senior Business Manager' => 'Sales',
        'Team Leader' => 'Sales',
        'Team Leader Collection' => 'Collection',
        'Team Leader Sales' => 'Sales'
    ];

    public function getEmiCollectionsCustom()
    {
        return $this->hasOne(EmiCollection::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}
