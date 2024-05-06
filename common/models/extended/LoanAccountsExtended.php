<?php

namespace common\models\extended;

use common\models\AssignedLoanAccounts;
use common\models\EmiCollection;
use common\models\LoanAccounts;
use phpDocumentor\Reflection\Types\This;

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
            'subBucket'=>['1','2']
        ],
        'SMA1' => [
            'name' => 'SMA-1',
            'value' => 1.5,
            'subBucket'=>['3','4']
        ],
        'SMA2' => [
            'name' => 'SMA-2',
            'value' => 1.5,
            'subBucket'=>['5','6']
        ],
        'NPA' => [
            'name' => 'NPA',
            'value' => 2,
            'subBucket'=>['7','8']
        ],
        'OnTime' => [
            'name' => 'OnTime',
            'value' => null,
            'subBucket'=>['X']
        ],
    ];

    public static function selectComponentBuckets($params){
        $valuesSma = self::$buckets;
        $startDate = $params['start_date'];
        $endDate = $params['end_date'];
        $select = [
            "COALESCE(COUNT(CASE WHEN ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}'  THEN ec.id), 0) total_cases_count", //till date start data end date total emi
            "COALESCE(SUM(CASE WHEN ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.amount END), 0) total_collected_cases_sum",
            "COALESCE(SUM(CASE WHEN ec.emi_payment_status = 'paid' AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.amount END), 0) total_collected_verified_amount",
            "COALESCE(SUM(CASE WHEN ec.emi_payment_status NOT IN ('rejected', 'failed','pending', 'paid') AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.amount END), 0) total_collected_unverified_amount",
            "COALESCE(COUNT(CASE WHEN lap.id IS NOT NULL AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.id END), 0) total_interaction_count",
            "COALESCE(SUM(CASE WHEN lap.id IS NOT NULL AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN (ec.amount + lap.proposed_amount) END), 0) total_interaction_sum",
        ];
        foreach ($valuesSma as $key => $value) {
            $inClause = "('" . implode("', '", $value['subBucket']) . "')";
            $select[] = "COALESCE(COUNT(CASE WHEN lac.sub_bucket IN $inClause AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.id END), 0) {$key}_total_cases_count"; //till date start data end date total emi
            $select[] = "COALESCE(SUM(CASE WHEN lac.sub_bucket IN $inClause AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.amount END), 0) {$key}_collected_cases_sum";
            $select[] = "COALESCE(SUM(CASE WHEN lac.sub_bucket IN $inClause AND ec.emi_payment_status = 'paid' AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.amount END), 0) {$key}_collected_verified_amount";
            $select[] = "COALESCE(SUM(CASE WHEN lac.sub_bucket IN $inClause AND ec.emi_payment_status NOT IN ('rejected', 'failed','pending', 'paid') AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN ec.amount END), 0) {$key}_collected_unverified_amount";
            $select[] = "COALESCE(COUNT(CASE WHEN lac.sub_bucket IN $inClause AND lap.id IS NOT NULL AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN lap.id END), 0) {$key}_total_interaction_count";
            $select[] = "COALESCE(SUM(CASE WHEN lac.sub_bucket IN $inClause AND lap.id IS NOT NULL AND ec.amount > 0 AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' THEN (ec.amount + lap.proposed_amount) END), 0) {$key}_total_interaction_sum";
        }
      return  $select = implode(',', $select);
    }

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
