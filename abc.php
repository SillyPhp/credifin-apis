<?php

use common\models\CreditLoanApplicationReports;
use common\models\CreditRequestedData;
use common\models\CreditResponseData;
use common\models\LoanApplications;
use yii\helpers\Url;

$subquery = (new \yii\db\Query())
    ->select([
        'ANY_VALUE(report_enc_id) report_enc_id','ANY_VALUE(d4.loan_app_enc_id) loan_app_enc_id','d4.loan_co_app_enc_id',
        'ANY_VALUE(d5.file_url) file_url', 'ANY_VALUE(d5.filename) filename',
        'ANY_VALUE(d4.created_on) created_on', "DATEDIFF('" . $date . "', ANY_VALUE(d4.created_on)) as days_till_now",
        'ANY_VALUE(d6.request_source) request_source'
    ])
    ->from(['d4' => CreditLoanApplicationReports::tableName()])
    ->join('INNER JOIN', ['d5' => CreditResponseData::tableName()], 'd5.response_enc_id = d4.response_enc_id')
    ->join('INNER JOIN', ['d6' => CreditRequestedData::tableName()], 'd6.request_enc_id = d5.request_enc_id')
    ->orderBy(['created_on' => SORT_DESC])
    ->andWhere(['d4.is_deleted' => 0]);


// getting loan detail
$loan = LoanApplications::find()
    ->alias('a')
    ->select([
        'a.loan_app_enc_id', 'a.amount', 'a.created_on apply_date', 'a.application_number', 'a.capital_roi', 'a.capital_roi_updated_on', "CONCAT(ub.first_name, ' ', ub.last_name) AS capital_roi_updated_by", 'a.registry_status', 'a.registry_status_updated_on', "CONCAT(rs.first_name, ' ', rs.last_name) AS registry_status_updated_by",
        'lpe.name as loan_product', 'a.chassis_number', 'a.rc_number', 'a.invoice_number', 'a.pf', 'a.roi', 'a.number_of_emis', 'a.emi_collection_date', 'a.battery_number',
        "CASE WHEN ub.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', ub.image_location, '/', ub.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(ub.first_name,' ',ub.last_name), '&size=200&rounded=false&background=', REPLACE(ub.initials_color, '#', ''), '&color=ffffff') END update_image",
        "CASE WHEN rs.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', rs.image_location, '/', rs.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(rs.first_name,' ',rs.last_name), '&size=200&rounded=false&background=', REPLACE(rs.initials_color, '#', ''), '&color=ffffff') END rs_image",
        'ANY_VALUE(b.status) as loan_status', 'a.loan_type', 'ANY_VALUE(i1.name) city','ANY_VALUE(i2.name) state',
        'ANY_VALUE(i2.abbreviation) state_abbreviation','ANY_VALUE(i2.state_code) state_code','ANY_VALUE(i.postal_code) postal_code',
        'ANY_VALUE(i.address) address','ANY_VALUE(k.access) access','lp.name as loan_product', "(CASE WHEN a.loan_app_enc_id IS NOT NULL THEN FALSE ELSE TRUE END) as login_fee", 'a.loan_products_enc_id'
    ])
    ->joinWith(['loanProductsEnc lpe'], false)
    ->joinWith(['capitalRoiUpdatedBy ub'], false)
    ->joinWith(['registryStatusUpdatedBy rs'], false)
    ->joinWith(['assignedLoanProviders b'], false)
    ->joinWith(['loanCoApplicants d' => function ($d) use ($date,$subquery) {
        $d->select([
            'd.loan_co_app_enc_id', 'd.loan_app_enc_id', 'd.name', 'd.email', 'd.phone', 'd.borrower_type',
            'd.relation', 'd.employment_type', 'd.annual_income', 'd.co_applicant_dob', 'd.occupation',
            'ANY_VALUE(d1.address) address','ANY_VALUE(d2.name) city','ANY_VALUE(d3.name) state','ANY_VALUE(d3.abbreviation) state_abbreviation','ANY_VALUE(d1.postal_code) postal_code','ANY_VALUE(d3.state_code) state_code',
            'd.voter_card_number', 'd.aadhaar_number', 'd.pan_number', 'd.gender', 'd.marital_status', 'd.driving_license_number', 'd.cibil_score',
            "CASE WHEN d.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . "',d.image_location, d.image) ELSE NULL END image",
        ]);
        $d->joinWith(['loanApplicantResidentialInfos d1' => function ($d1) {
            $d1->joinWith(['cityEnc d2'], false);
            $d1->joinWith(['stateEnc d3'], false);
        }], false);
        $d->joinWith([
            'creditLoanApplicationReports d4' => function ($k) use ($subquery) {
                $k->from(['subquery' => $subquery]);
            }
        ]);
    }])
    ->joinWith(['loanApplicationNotifications e' => function ($e) {
        $e->select(['e.notification_enc_id', 'e.message', 'e.loan_application_enc_id', 'e.created_on', "CONCAT(e1.first_name,' ',e1.last_name) created_by"]);
        $e->joinWith(['createdBy e1'], false);
        $e->onCondition(['e.is_deleted' => 0, 'e.source' => 'EL']);
    }])
    ->joinWith(['loanApplicationComments f' => function ($f) {
        $f->select([
            'f.comment_enc_id', 'f.comment', 'f.loan_application_enc_id', 'f.created_on', "CONCAT(f1.first_name,' ',f1.last_name) created_by",
            "CASE WHEN f1.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . "',f1.image_location, '/', f1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(f1.first_name,' ',f1.last_name), '&size=200&rounded=true&background=', REPLACE(f1.initials_color, '#', ''), '&color=ffffff') END user_image",
            "CASE WHEN f2.logo IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . "', f2.logo_location, '/', f2.logo) ELSE CONCAT('https://ui-avatars.com/api/?name=', f2.name, '&size=200&rounded=false&background=', REPLACE(f2.initials_color, '#', ''), '&color=ffffff') END logo",
        ]);
        $f->joinWith(['createdBy f1' => function ($f1) {
            $f1->joinWith(['organizations f2']);
        }], false);
        $f->onCondition(['f.is_deleted' => 0, 'f.source' => 'EL']);
    }])
    ->joinWith(['loanPurposes g' => function ($g) {
        $g->select(['g.financer_loan_purpose_enc_id', 'g.financer_loan_purpose_enc_id', 'g.loan_app_enc_id', 'g1.purpose']);
        $g->joinWith(['financerLoanPurposeEnc g1'], false);
        $g->onCondition(['g.is_deleted' => 0]);
    }])
    ->joinWith(['loanVerificationLocations h' => function ($h) {
        $h->select([
            'h.loan_verification_enc_id', 'h.loan_app_enc_id', 'h.location_name',
            'h.local_address', 'h.latitude', 'h.longitude', "CONCAT(h1.first_name,' ',h1.last_name) created_by", 'h.created_on',
            "CASE WHEN h1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', h1.image_location, '/', h1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(h1.first_name,' ',h1.last_name), '&size=200&rounded=false&background=', REPLACE(h1.initials_color, '#', ''), '&color=ffffff') END image"
        ]);
        $h->joinWith(['createdBy h1'], false);
        $h->onCondition(['h.is_deleted' => 0]);
    }])
    ->joinWith(['loanApplicantResidentialInfos i' => function ($i) {
        $i->joinWith(['cityEnc i1'], false);
        $i->joinWith(['stateEnc i2'], false);
    }], false)
    ->joinWith(['sharedLoanApplications k' => function ($k) {
        $k->select([
            'k.shared_loan_app_enc_id', 'k.loan_app_enc_id', 'k.access', 'k.status', "CONCAT(k1.first_name,' ',k1.last_name) name", 'k1.phone',
            "CASE WHEN k1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', k1.image_location, '/', k1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(k1.first_name,' ',k1.last_name), '&size=200&rounded=false&background=', REPLACE(k1.initials_color, '#', ''), '&color=ffffff') END image"
        ])->joinWith(['sharedTo k1'], false)
            ->onCondition(['k.is_deleted' => 0]);
    }])
    ->joinWith(['assignedLoanPayments p' => function ($p) {
        $p->select(['p.loan_app_enc_id', 'p1.payment_mode', 'p1.payment_status', 'p1.payment_amount']);
        $p->orderBy(['p1.created_on' => SORT_DESC]);
        $p->joinWith(['loanPaymentsEnc p1'], false);
    }])
    ->joinWith(['loanProductsEnc lp'], false)
    ->joinWith(['loanApplicationTvrs l' => function ($m) {
        $m->select(['l.loan_application_tvr_enc_id', 'l.loan_app_enc_id', 'l.status', 'l.assigned_to']);
    }])
    ->joinWith(['loanApplicationPds m' => function ($m) {
        $m->select(['m.loan_application_pd_enc_id', 'm.preferred_date', 'm.loan_app_enc_id', 'm.status', 'm.assigned_to', 'm.preferred_date']);
    }])
    ->joinWith(['loanApplicationReleasePayments n' => function ($m) {
        $m->select(['n.loan_application_release_payment_enc_id', 'n.loan_app_enc_id', 'n.status', 'n.assigned_to']);
    }])
    ->joinWith(['loanApplicationsReferences o' => function ($o) {
        $o->select(['o.references_enc_id', 'o.loan_app_enc_id', 'o.type', 'o.value', 'o.name', 'o.reference']);
        $o->onCondition(['o.is_deleted' => 0]);
    }])
    ->joinWith(['loanApplicationFis q' => function ($m) {
        $m->select(['q.loan_application_fi_enc_id', 'q.loan_app_enc_id', 'q.status', 'q.assigned_to']);
    }])
    ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
    ->limit(1)
    ->asArray()
    ->one();