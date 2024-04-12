<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\models\VehicleRepoForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\AssignedLoanAccounts;
use common\models\AssignedLoanPayments;
use common\models\Cities;
use common\models\EmiCollection;
use common\models\extended\AssignedLoanAccountsExtended;
use common\models\extended\LoanAccountsExtended;
use common\models\LoanAccountComments;
use common\models\LoanAccountOtherDetails;
use common\models\LoanAccountPtps;
use common\models\LoanAccounts;
use common\models\LoanActionComments;
use common\models\LoanActionRequests;
use common\models\LoanApplications;
use common\models\OrganizationLocations;
use common\models\spaces\Spaces;
use common\models\States;
use common\models\UserRoles;
use common\models\Users;
use common\models\Utilities;
use common\models\VehicleRepossessionImages;
use Razorpay\Api\Api;
use Yii;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;


class LoanAccountsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'loan-accounts-upload' => ['POST', 'OPTIONS'],
                'emi-payment-issues' => ['POST', 'OPTIONS'],
                'emi-account-details' => ['POST', 'OPTIONS'],
                'vehicle-repossession' => ['POST', 'OPTIONS'],
                'get-repo-list' => ['POST', 'OPTIONS'],
                'repo-details' => ['POST', 'OPTIONS'],
                'save-repo-comments' => ['POST', 'OPTIONS'],
                'get-legal-list' => ['POST', 'OPTIONS'],
                'get-acc-list' => ['POST', 'OPTIONS'],
                'get-health-list' => ['POST', 'OPTIONS'],
                'get-telecaller-list' => ['POST', 'OPTIONS'],
                'assign-telecaller' => ['POST', 'OPTIONS'],
                'get-ptp-cases' => ['POST', 'OPTIONS'],
                'stats' => ['POST', 'OPTIONS'],
                'loan-accounts-type' => ['POST', 'OPTIONS'],
                'update-loan-acc-access' => ['POST', 'OPTIONS'],
                'upload-sheet' => ['POST', 'OPTIONS'],
                'update-branch' => ['POST', 'OPTIONS'],
                'update-target-dates' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionEmiPaymentIssues()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id']);
        }
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $Payment_issues = new LoanActionRequests();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $Payment_issues->request_enc_id = $utilitiesModel->encrypt();
            $Payment_issues->loan_account_enc_id = $params['loan_account_enc_id'];
            $Payment_issues->reasons = $params['reasons'];
            $Payment_issues->remarks = $params['remarks'];
            $Payment_issues->created_by = $Payment_issues->updated_by = $user->user_enc_id;
            $Payment_issues->created_on = $Payment_issues->updated_on = date('Y-m-d H:i:s');

            $document = UploadedFile::getInstanceByName('document');
            if ($document) {
                $documents = Yii::$app->getSecurity()->generateRandomString() . '.' . $document->extension;
                $documents_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->payment_issues->image . $documents_location;

                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($document->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $documents, "public", ['params' => ['ContentType' => $document->type]]);

                $Payment_issues->request_image = $documents;
                $Payment_issues->request_image_location = $documents_location;
            }

            if (!$Payment_issues->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving the data.', 'error' => $Payment_issues->getErrors()]);
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'issues' => $Payment_issues]);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    public function actionGetPaymentIssues()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id']);
        }

        $data = LoanActionRequests::find()
            ->alias('a')
            ->select([
                'a.loan_account_enc_id', 'a.request_enc_id', 'a.reasons', 'a.remarks', 'a.created_by',
                'a.request_image', 'a.request_image_location', 'a.created_on',
                "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) as created_by_name", 'b.image_location', 'b.image',
                "CASE WHEN b.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', b.image_location, '/', b.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')), '&size=200&rounded=false&background=', REPLACE(b.initials_color, '#', ''), '&color=ffffff') END createdby_image",
                "CASE WHEN a.request_image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->payment_issues->image, 'https') . "', a.request_image_location, '/', a.request_image) END request_image"
            ])
            ->joinWith(['createdBy b'], false)
            ->where(['a.is_deleted' => 0, 'a.loan_account_enc_id' => $params['loan_account_enc_id']])
            ->andWhere(['<>', 'a.reasons', 4])
            ->asArray()
            ->all();


        $res = [];
        $issues = [
            '1' => 'Legal', '2' => 'Accident', '3' => 'Health'
        ];

        foreach ($data as $datam) {
            $reason = $datam['reasons'];
            $pay_issues = !empty($issues[$reason]) ? $issues[$reason] : null;
            $res[] = [
                'request_enc_id' => $datam['request_enc_id'],
                'loan_account_enc_id' => $datam['loan_account_enc_id'],
                'created_by' => $datam['created_by_name'],
                'created_on' => $datam['created_on'],
                'remarks' => $datam['remarks'],
                'user_image' => $datam['createdby_image'],
                'image' => $datam['request_image'],
                'reasons' => $pay_issues,
            ];
        }
        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $res]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionEmiAccountDetails()
    {
        $this->isAuth();
        $params = $this->post;
        if (empty($params['loan_account_enc_id']) && empty($params['loan_account_number'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id" or "loan_account_number"']);
        }
        $loan_id = $params['loan_account_enc_id'];
        if (!empty($loan_id)) {
            $data = LoanAccounts::find()
                ->alias('a')
                ->select([
                    'a.loan_account_enc_id',
                    'a.sales_target_date',
                    'a.telecaller_target_date',
                    'a.collection_target_date',
                    'a.overdue_amount',
                    'a.ledger_amount',
                    'a.sales_priority',
                    'a.telecaller_priority',
                    'a.collection_priority',
                    'a.bucket',
                    "(CASE WHEN a.nach_approved = 0 THEN 'Inactive' WHEN a.nach_approved = 1 THEN 'Active' ELSE '' END) AS nach_approved",
                    'a.emi_date',
                    'a.created_on',
                    'a.last_emi_received_amount',
                    'a.last_emi_received_date',
                    "COUNT(a1.id) AS total_emis",
                    'a.phone',
                    "a.name",
                    "a.loan_type",
                    "a.emi_amount",
                    "a.loan_account_number",
                    "(CASE WHEN a.bucket = 'onTime' THEN a.emi_amount ELSE
                    (CASE WHEN COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0) < a.emi_amount * (CASE 
                        WHEN a.bucket = 'sma-0' THEN 1.25
                        WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                        WHEN a.bucket = 'npa' THEN 2
                        ELSE 1
                    END)  
                    THEN COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0)  
                        ELSE emi_amount * 
                            (CASE 
                                WHEN a.bucket = 'sma-0' THEN 1.25
                                WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                                WHEN a.bucket = 'npa' THEN 2
                                ELSE 1
                        END) 
                    END) 
                END) target_collection_amount",

                    "(CASE WHEN (COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0)) < 0 THEN 
                (CASE WHEN a.bucket = 'onTime' THEN a.emi_amount ELSE
                    (CASE WHEN COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0) < a.emi_amount * (CASE 
                        WHEN a.bucket = 'sma-0' THEN 1.25
                        WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                        WHEN a.bucket = 'npa' THEN 2
                        ELSE 1
                    END)  
                    THEN COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0)  
                        ELSE emi_amount * 
                            (CASE 
                                WHEN a.bucket = 'sma-0' THEN 1.25
                                WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                                WHEN a.bucket = 'npa' THEN 2
                                ELSE 1
                        END) 
                    END) 
                END) ELSE COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0)
                END) AS total_pending_amount",
                    "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, '')) as assigned_caller"
                ])
                ->joinWith(['emiCollections AS a1' => function ($b) {
                    $b->select(['a1.id', 'a1.loan_account_enc_id', 'a1.phone', 'a1.address', 'a1.latitude', 'a1.longitude', 'a1.created_on', "CONCAT(cr.first_name , ' ', COALESCE(cr.last_name, '')) AS created_by"]);
                    $b->joinWith(['createdBy cr'], false);
                    $b->andOnCondition(['a1.is_deleted' => 0]);
                }])
                ->joinWith(["assignedCaller ac"], false)
                ->joinWith(['assignedLoanAccounts d' => function ($d) {
                    $d->andOnCondition(["d.is_deleted" => 0, "d.status" => "Active"]);
                    $d->select([
                        'd.loan_account_enc_id', "d.assigned_enc_id", "(CASE WHEN d.user_type = 1 THEN 'bdo' WHEN user_type = 2 THEN 'collection_manager' WHEN user_type = 3 THEN 'telecaller' END) as user_type",
                        "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, '')) name",
                        "(CASE WHEN d1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', d1.image_location, '/', d1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', concat(d1.first_name,' ',d1.last_name), '&size=200&rounded=false&background=', REPLACE(d1.initials_color, '#', ''), '&color=ffffff') END) image"
                    ]);
                    $d->joinWith(['sharedTo d1'], false);
                }])
                ->joinWith(['loanAccountOtherDetails ld' => function ($ld) {
                    $ld->andOnCondition(['ld.type' => 'phone']);
                }])
                ->joinWith(['emiPaymentRecords AS epr' => function ($epr) {
                    $epr->select(['epr.emi_payment_records_enc_id', 'epr.loan_account_enc_id', 'epr.payment_id', "(CASE WHEN epr.type = 1 THEN 'nach' WHEN epr.type = 2 THEN 'enach' END) AS type", 'epr.amount', 'epr.nach_date']);
                    $epr->andOnCondition("epr.status REGEXP 'fail|failed' AND epr.charges_paid = 0");
                }])
                ->where(['a.loan_account_enc_id' => $loan_id])
                ->groupBy(['a.loan_account_enc_id'])
                ->asArray()
                ->one();
            if ($data) {
                $ph = $data['phone'];
                $phones = $data['emiCollections'];
                $phones1 = $data['loanAccountOtherDetails'];
                $p1 = array_map(function ($phone) {
                    return ['phone' => $phone['phone'], 'created_on' => strtotime($phone['created_on'])];
                }, $phones);
                $p2 = array_map(function ($phone) {
                    return ['phone' => $phone['value'], 'created_on' => strtotime($phone['created_on'])];
                }, $phones1);
                $merge = array_merge($p1, $p2);
                usort($merge, function ($a, $b) {
                    return $b['created_on'] - $a['created_on'];
                });
                $data['phone'] = array_values(array_unique(array_column($merge, 'phone')));
                if (!empty($ph)) {
                    $data['phone'][] = $ph;
                }
                foreach ($phones as $loc) {
                    $data['location'][] = [
                        'address' => $loc['address'],
                        'latitude' => $loc['latitude'],
                        'longitude' => $loc['longitude'],
                        'created_on' => $loc['created_on'],
                        'created_by' => $loc['created_by']
                    ];
                }
                unset($data['emiCollections']);
                unset($data['loanAccountOtherDetails']);
            }
        } else {
            $query = EmiCollection::find()
                ->alias('a')
                ->select([
                    'a.loan_account_number',
                    'a.customer_name as name',
                    'a.phone',
                    'a.amount as emi_amount',
                    'a.loan_type',
                    "COUNT(*) OVER(PARTITION BY a.loan_account_number) AS total_emis", 'a.address', 'a.longitude', 'a.latitude', "CONCAT(cr.first_name , ' ', COALESCE(cr.last_name, '')) AS created_by", 'a.created_on',
                ])
                ->where(['a.loan_account_number' => $params['loan_account_number'], 'a.is_deleted' => 0])
                ->joinWith(['createdBy cr'], false)
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();
            if ($query) {
                $phones = array_unique(array_column($query, 'phone'));
                $data = reset($query);
                $data['phone'] = $phones;
                foreach ($query as $loc) {
                    $data['location'][] = [
                        'address' => $loc['address'],
                        'latitude' => $loc['latitude'],
                        'longitude' => $loc['longitude'],
                        'created_on' => $loc['created_on'],
                        'created_by' => $loc['created_by']
                    ];
                }
                unset($data['emiCollections']);
            }
        }
        if (!empty($data)) {
            $lac = $data['loan_account_number'];
            $model = $this->_emiAccData($lac)['data'];
            return $this->response(200, ['status' => 200, 'data' => $data, 'display_data' => $model]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
    }


    private function _emiAccData($lac)
    {
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $payment_methods = EmiCollectionForm::$payment_methods;
        $payment_modes = EmiCollectionForm::$payment_modes;
        $model = EmiCollection::find()
            ->alias('a')
            ->select([
                'a.customer_visit', 'a.customer_interaction',
                'a.emi_collection_enc_id',
                'a.customer_name', 'a.collection_date', 'a.amount', 'a.emi_payment_method', 'a.emi_payment_mode',
                "CONCAT(b.first_name , ' ', COALESCE(b.last_name, '')) as collected_by",
                "CASE 
                    WHEN a.other_delay_reason IS NOT NULL 
                        THEN CONCAT(a.delay_reason , ',', a.other_delay_reason) 
                    ELSE a.delay_reason 
                END AS delay_reason",
                "CASE 
                    WHEN b.image IS NOT NULL 
                        THEN 
                        CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . "',b.image_location, '/', b.image) 
                    ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')), '&size=200&rounded=true&background=', REPLACE(b.initials_color, '#', ''), '&color=ffffff')
                END image",
                "CASE 
                    WHEN a.pr_receipt_image IS NOT NULL 
                        THEN CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . "',a.pr_receipt_image_location, '/', a.pr_receipt_image) 
                    ELSE NULL 
                END as pr_receipt_image",
                "CASE 
                    WHEN a.other_doc_image IS NOT NULL 
                        THEN CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . "', a.other_doc_image_location, '/', a.other_doc_image) 
                    ELSE NULL 
                END as other_doc_image",
                "CASE 
                    WHEN a.borrower_image IS NOT NULL 
                        THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . "',a.borrower_image_location, '/', a.borrower_image) 
                    ELSE NULL 
                END as borrower_image",
                'a.created_on', 'a.emi_payment_status', 'a.reference_number', 'a.ptp_amount', 'a.ptp_date',
                "(CASE WHEN a.ptp_payment_method = '1' THEN 'cash' 
                WHEN a.ptp_payment_method = '0' THEN 'online' ELSE 'null' END) AS ptp_payment_method",
                "d1.payment_short_url"
            ])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['assignedLoanPayments d' => function ($d) {
                $d->joinWith(['loanPaymentsEnc d1'], false);
            }], false)
            ->andWhere(['a.is_deleted' => 0, 'loan_account_number' => $lac]);
        $count = $model->count();
        $model = $model
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($model as &$value) {
            $value['emi_payment_method'] = $payment_methods[$value['emi_payment_method']];
            $value['emi_payment_mode'] = $payment_modes[$value['emi_payment_mode']];
            if ($value['other_doc_image']) {
                $proof = $my_space->signedURL($value['other_doc_image']);
                $value['other_doc_image'] = $proof;
            }
            if ($value['borrower_image']) {
                $proof = $my_space->signedURL($value['borrower_image']);
                $value['borrower_image'] = $proof;
            }
            if ($value['pr_receipt_image']) {
                $proof = $my_space->signedURL($value['pr_receipt_image']);
                $value['pr_receipt_image'] = $proof;
            }
        }
        return ['data' => $model, 'count' => $count];
    }

    public function actionUpdateNach()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id"']);
        }
        if (empty($params['status'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
        }
        $update = LoanAccounts::findOne(['loan_account_enc_id' => $params['loan_id']]);
        if (empty($update)) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        if ($params['status'] == 'Active') {
            $update->nach_approved = 1;
        }
        if ($params['status'] == 'Inactive') {
            $update->nach_approved = 0;
        }
        $update->updated_by = $user->user_enc_id;
        $update->updated_on = date('Y-m-d H:i:s');
        if (!$update->update()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $update->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
    }

    public function actionGetBasicDetail()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id"']);
        }
        $subquery = (new Query())
            ->select([
                'z.loan_account_enc_id',
                "SUM(CASE WHEN z.emi_payment_status = 'paid' THEN z.amount END) AS collected_amount",
                "SUM(CASE WHEN z.emi_payment_status = 'pending' THEN z.amount END) AS pending_amount",
            ])
            ->from(["z" => EmiCollection::tableName()])
            ->groupBy(["z.loan_account_enc_id"]);

        $detail = LoanAccounts::find()
            ->alias('a')
            ->select([
                'a.loan_account_enc_id',
                'la.amount as loan_amount', 'a.loan_app_enc_id',
                'a.emi_date as collection_date',
                'COALESCE(ANY_VALUE(subquery.collected_amount), 0) collected_amount',
                'COALESCE(ANY_VALUE(subquery.pending_amount), 0) pending_amount',
                'br.location_name as branch',
                'a.branch_enc_id',
                'a.total_installments as number_of_emis',
            ])
            ->joinWith(['branchEnc br'], false)
            ->joinWith(["emiCollections c" => function ($c) use ($subquery) {
                $c->from(["subquery" => $subquery]);
            }], false)
            ->joinWith(['loanAppEnc0 d' => function ($d) {
                $d->select([
                    'd.loan_co_app_enc_id', 'd.father_name', 'd.loan_app_enc_id', 'd.name', 'd.email', 'd.phone', 'd.borrower_type',
                    'd.relation', 'd.employment_type', 'd.annual_income', 'd.co_applicant_dob', 'd.occupation',
                    'ANY_VALUE(d1.address) address', 'ANY_VALUE(d2.name) city', 'ANY_VALUE(d3.name) state', 'ANY_VALUE(d3.abbreviation) state_abbreviation', 'ANY_VALUE(d1.postal_code) postal_code', 'ANY_VALUE(d3.state_code) state_code',
                    'd.voter_card_number', 'd.aadhaar_number', 'd.pan_number', 'd.gender', 'd.marital_status', 'd.driving_license_number', 'd.cibil_score', 'd.passport_number',
                    "CASE WHEN d.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . "',d.image_location, d.image) ELSE NULL END image",
                ]);
                $d->joinWith(['loanApplicantResidentialInfos d1' => function ($d1) {
                    $d1->joinWith(['cityEnc d2'], false);
                    $d1->joinWith(['stateEnc d3'], false);
                }], false);
            }])
            ->joinWith(['loanAppEnc la'], false)
            ->where(['a.loan_account_enc_id' => $params['loan_account_enc_id']])
            ->groupBy(['a.loan_account_enc_id'])
            ->asArray()
            ->one();

        return $this->response(200, ['status' => 200, 'data' => $detail]);
    }

    public function actionVehicleRepossession()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }


        $model = new VehicleRepoForm();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->front = UploadedFile::getInstancesByName('front');
            $model->back = UploadedFile::getInstancesByName('back');
            $model->left = UploadedFile::getInstancesByName('left');
            $model->right = UploadedFile::getInstancesByName('right');
            if ($model->validate()) {
                $rep = $model->vehicleRepo($user);

                if ($rep['status'] == 201) {
                    return $this->response(201, $rep);
                } else {
                    return $this->response(500, $rep);
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
            }
        } else {
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        }
    }

    public function actionGetRepoList()
    {
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $data = LoanActionRequests::find()
            ->alias('a')
            ->select([
                'a.request_enc_id', 'a.loan_account_enc_id', 'a.vehicle_model', 'a.km_driven',
                "(CASE WHEN a.insurance = '1' THEN 'yes' ELSE 'no' END) AS insurance",
                "(CASE WHEN a.rc = '1' THEN 'yes' ELSE 'no' END) AS rc", 'a.registration_number', 'a.current_market_value',
                'a.repossession_date', 'b.loan_account_number', "CONCAT(c.first_name,' ',c.last_name) created_by", 'd.brand_name'
            ])
            ->joinWith(['loanAccountEnc b'], false)
            ->joinWith(['createdBy c'], false)
            ->joinWith(['financerVehicleBrandEnc d'], false)
            ->andWhere(['a.is_deleted' => 0, 'a.reasons' => 4]);

        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'registration_number' || $key == 'repossession_date') {
                        $data->andWhere(['a.' . $key => $value]);
                    } elseif ($key == 'loan_account_number') {
                        $data->andWhere(['b.' . $key => $value]);
                    } elseif ($key == 'min_current_market_value') {
                        $data->andWhere(['>=', 'current_market_value', $value]);
                    } elseif ($key == 'max_current_market_value') {
                        $data->andWhere(['<=', 'current_market_value', $value]);
                    } elseif ($key == 'min_km_driven') {
                        $data->andWhere(['>=', 'km_driven', $value]);
                    } elseif ($key == 'max_km_driven') {
                        $data->andWhere(['<=', 'km_driven', $value]);
                    } elseif ($key == 'brand_name') {
                        $data->andWhere(['like', 'd.' . $key, $value]);
                    } elseif ($key == 'insurance' || $key == 'rc') {
                        if ($value == 'yes') {
                            $data->andWhere([$key => 1]);
                        } elseif ($value == 0) {
                            $data->andWhere([$key => 0]);
                        }
                    } else {
                        $data->andWhere(['like', $key, $value]);
                    }
                }
            }
        }

        $count = $data->count();
        $data = $data
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data, 'count' => $count]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionRepoDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['request_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "request_enc_id']);
        }

        $data = VehicleRepossessionImages::find()
            ->alias('a')
            ->andWhere(['a.is_deleted' => 0, 'a.vehicle_repossession_enc_id' => $params['request_enc_id']])
            ->joinWith(['vehicleRepossessionEnc b' => function ($b) {
                $b->joinWith(['loanAccountEnc b1']);
                $b->joinWith(['financerVehicleBrandEnc b5']);
            }])
            ->asArray()
            ->all();

        $images = ['front' => [], 'back' => [], 'left' => [], 'right' => []];

        $issues = [
            '1' => 'front', '2' => 'back', '3' => 'left', '4' => 'right'
        ];

        foreach ($data as $datam) {
            $img_type = $datam['image_type'];
            $image_type = $issues[$img_type];

            if (!empty($datam['image'])) {
                $user_image = Yii::$app->params->digitalOcean->baseUrl .
                    Yii::$app->params->digitalOcean->rootDirectory .
                    Yii::$app->params->upload_directories->repo_images->image .
                    $datam['image_location'] . '' . $datam['image'];
            } else {
                $user_image = '';
            }

            $images[$image_type][] = [
                'image' => $user_image,
            ];
        }

        $result = [
            'status' => 200,
            'data' => [
                'request_enc_id' => $params['request_enc_id'],
                'vehicle_model' => $datam['vehicleRepossessionEnc']['vehicle_model'],
                'loan_account_number' => $datam['vehicleRepossessionEnc']['loanAccountEnc']['loan_account_number'],
                'loan_acc_enc_id' => $datam['vehicleRepossessionEnc']['loanAccountEnc']['loan_account_enc_id'],
                'km_driven' => $datam['vehicleRepossessionEnc']['km_driven'],
                'registration_number' => $datam['vehicleRepossessionEnc']['registration_number'],
                'current_market_value' => $datam['vehicleRepossessionEnc']['current_market_value'],
                'repossession_date' => $datam['vehicleRepossessionEnc']['repossession_date'],
                'insurance' => ($datam['vehicleRepossessionEnc']['insurance'] == 1) ? 'yes' : 'no',
                'rc' => ($datam['vehicleRepossessionEnc']['rc'] == 1) ? 'yes' : 'no',
                'rc_image' => $datam['vehicleRepossessionEnc']['rc_image'] ? Yii::$app->params->digitalOcean->baseUrl .
                    Yii::$app->params->digitalOcean->rootDirectory .
                    Yii::$app->params->upload_directories->repo_images->image .
                    $datam['vehicleRepossessionEnc']['rc_image_location'] . '' . $datam['vehicleRepossessionEnc']['rc_image'] : "",
                'brand_name' => $datam['vehicleRepossessionEnc']['financerVehicleBrandEnc']['brand_name'],
                'images' => $images,
                'comments' => [],
            ],
        ];

        if (!empty($images['front']) || !empty($images['back']) || !empty($images['left']) || !empty($images['right'])) {
            return $this->response(200, $result);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionSaveRepoComments()
    {

        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['request_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "request_enc_id"']);
        }

        if (empty($params['comment'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "comment"']);
        }

        if (empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "type"']);
        }

        $type = 'error';

        if (!empty($params['type'])) {
            if ($params['type'] == 'legal') {
                $type = 1;
            } elseif ($params['type'] == 'accident') {
                $type = 2;
            } elseif ($params['type'] == 'health') {
                $type = 3;
            } elseif ($params['type'] == 'repossession') {
                $type = 4;
            }
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $comment = new LoanActionComments();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $comment->comment_enc_id = $utilitiesModel->encrypt();
            $comment->request_enc_id = $params['request_enc_id'];
            $comment->comment = $params['comment'];
            $comment->type = $type;
            $comment->created_by = $user->user_enc_id;
            $comment->created_on = date('Y-m-d H:i:s');
            if (!$comment->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $comment->getErrors()]);
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'data' => $comment]);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => $exception->getMessage()];
        }
    }

    public function actionGetRepoComments()
    {
        $user = $this->isAuthorized();
        if (!$user) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['request_enc_id']) || empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "request_enc_id or type"']);
        }

        $type = $params['type'];
        $query = $this->repoCommentsDetails($params['request_enc_id'], $type);

        if (!$query) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }

        return $this->response(200, ['status' => 200, 'data' => $query]);
    }

    private function repoCommentsDetails($request_enc_id, $type)
    {
        $query = LoanActionComments::find()
            ->alias('a')
            ->select([
                'a.request_enc_id', 'a.comment', 'a.type', 'a.created_on',
                "CONCAT(f1.first_name,' ',f1.last_name) created_by",
                "CASE WHEN f1.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . "',f1.image_location, '/', f1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(f1.first_name,' ',f1.last_name), '&size=200&rounded=true&background=', REPLACE(f1.initials_color, '#', ''), '&color=ffffff') END user_image",
                "CASE WHEN f2.logo IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . "', f2.logo_location, '/', f2.logo) ELSE CONCAT('https://ui-avatars.com/api/?name=', f2.name, '&size=200&rounded=false&background=', REPLACE(f2.initials_color, '#', ''), '&color=ffffff') END logo",
            ])
            ->joinWith(['createdBy f1' => function ($b3) {
                $b3->joinWith(['organizations f2']);
            }])
            ->onCondition(['a.is_deleted' => 0]);

        switch ($type) {
            case "legal":
                $query->andWhere(['a.type' => '1']);
                break;

            case "accident":
                $query->andWhere(['a.type' => '2']);
                break;

            case "health":
                $query->andWhere(['a.type' => '3']);
                break;

            case "repossession":
                $query->andWhere(['a.type' => '4']);
                break;

            default:
                return false;
        }
        $result = $query
            ->andWhere(['a.request_enc_id' => $request_enc_id])
            ->asArray()
            ->all();

        if ($type == 'type' && $result) {
            $result = self::repoIssue($result);
        }
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    public static function repoIssue($data)
    {
        $names = ["1" => 'Legal', "2" => 'Accident', "3" => 'Health', "4" => 'Repossession'];
        $res = [];
        foreach ($data as $datum) {
            $res[$names[$datum['type']]][] = $datum;
        }
        return $res;
    }


    public function actionGetLegalList()
    {
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $data = LoanActionRequests::find()
            ->alias('a')
            ->select([
                'a.remarks', 'a.loan_account_enc_id', 'a.request_enc_id',
                "CASE WHEN a.request_image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->payment_issues->image, "https") . "', a.request_image_location, '/', a.request_image) END image", 'a.created_on', 'b.loan_account_number', "CONCAT(c.first_name , ' ', c.last_name) as created_by", 'b.emi_amount', 'b.last_emi_received_amount'
            ])
            ->joinWith(['loanAccountEnc b'], false)
            ->joinWith(['createdBy c'], false)
            ->andWhere(['a.reasons' => 1, 'a.is_deleted' => 0]);

        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'loan_account_number') {
                        $data->andWhere(['b.' . $key => $value]);
                    } elseif ($key == 'created_by') {
                        $data->andWhere(['like', 'c.' . $key, $value]);
                    } else {
                        $data->andWhere(['like', $key, $value]);
                    }
                }
            }
        }

        $count = $data->count();
        $data = $data
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data, 'count' => $count]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionGetAccList()
    {
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $data = LoanActionRequests::find()
            ->alias('a')
            ->select([
                'a.remarks', 'a.loan_account_enc_id', 'a.request_enc_id',
                "CASE WHEN a.request_image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->payment_issues->image, "https") . "', a.request_image_location, '/', a.request_image) END image",
                'a.created_on', 'b.loan_account_number', "CONCAT(c.first_name , ' ', c.last_name) as created_by"
            ])
            ->joinWith(['loanAccountEnc b'], false)
            ->joinWith(['createdBy c'], false)
            ->andWhere(['a.reasons' => 2, 'a.is_deleted' => 0]);

        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'loan_account_number') {
                        $data->andWhere(['b.' . $key => $value]);
                    } elseif ($key == 'created_by') {
                        $data->andWhere(['like', 'c.' . $key, $value]);
                    } else {
                        $data->andWhere(['like', $key, $value]);
                    }
                }
            }
        }

        $count = $data->count();
        $data = $data
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data, 'count' => $count]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionGetHealthList()
    {
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $data = LoanActionRequests::find()
            ->alias('a')
            ->select([
                'a.remarks', 'a.loan_account_enc_id', 'a.request_enc_id',
                "CASE WHEN a.request_image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->payment_issues->image, "https") . "', a.request_image_location, '/', a.request_image) END image",
                'a.created_on', 'b.loan_account_number', "CONCAT(c.first_name , ' ', c.last_name) as created_by"
            ])
            ->joinWith(['loanAccountEnc b'], false)
            ->joinWith(['createdBy c'], false)
            ->andWhere(['a.reasons' => 3, 'a.is_deleted' => 0]);

        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'loan_account_number') {
                        $data->andWhere(['b.' . $key => $value]);
                    } elseif ($key == 'created_by') {
                        $data->andWhere(['like', 'c.' . $key, $value]);
                    } else {
                        $data->andWhere(['like', $key, $value]);
                    }
                }
            }
        }
        $count = $data->count();
        $data = $data
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data, 'count' => $count]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionGetTelecallerList()
    {
        $user = $this->isAuthorized();
        $org_id = $user->organization_enc_id;
        if (!$org_id) {
            $user_roles = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $user_roles->organization_enc_id;
        }

        $data = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id', "CONCAT(a.first_name , ' ', COALESCE(a.last_name, '')) as name"])
            ->joinWith(['userRoles0 b' => function ($b) {
                $b->joinWith('designation d');
            }], false)
            ->where(['d.designation' => 'Tele Caller Collection', 'd.organization_enc_id' => $org_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionAssignTelecaller()
    {
        $user = $this->isAuthorized();
        if (!$user) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['caller_ids']) || empty($params['bucket'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "caller_ids" or "bucket"']);
        }
        $loanAccounts = (new Query())
            ->from([LoanAccounts::tableName()])
            ->select(['loan_account_enc_id', 'bucket'])
            ->where(['bucket' => $params['bucket'], 'is_deleted' => 0]);
        foreach ($loanAccounts->batch(100) as $rows) {
            $assignment = $this->assignCasesToTelecallers($params['caller_ids'], $rows);
            foreach ($assignment as $caseName => $telecaller) {
                $update = Yii::$app->db->createCommand()
                    ->update(LoanAccounts::tableName(), ['assigned_caller' => $telecaller['user_enc_id'], 'updated_by' => $user->user_enc_id, 'updated_on' => date('Y-m-d H:i:s')], ['loan_account_enc_id' => $caseName])
                    ->execute();
                if (!$update) {
                    return false;
                }
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'Successfully Updated']);
    }

    function assignCasesToTelecallers($telecallers, $cases)
    {
        if (count($telecallers) <= 0 || count($cases) <= 0) {
            return "Both telecallers and cases must not be empty.";
        }
        $telecallerCount = count($telecallers);
        $caseCount = count($cases);
        if ($telecallerCount >= $caseCount) {
            return "There are more telecallers than cases, so every case can have a unique telecaller.";
        }

        $assignment = array();
        for ($i = 0; $i < $caseCount; $i++) {
            $telecaller = $telecallers[$i % $telecallerCount];
            $assignment[$cases[$i]['loan_account_enc_id']] = $telecaller;
        }
        return $assignment;
    }

    public function actionSaveLoanAccountComments()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();

        if (empty($params["loan_account_enc_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing information 'loan_account_enc_id'"]);
        }

        if (empty($params["comment"])) {
            return $this->response(422, ["status" => 422, "message" => "missing information 'comment'"]);
        }

        $comment = new LoanAccountComments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables["string"] = time() . rand(100, 100000);
        $comment->comment_enc_id = $utilitiesModel->encrypt();
        $comment->loan_account_enc_id = $params['loan_account_enc_id'];
        $comment->comment = $params['comment'];
        if (!empty($params['is_important']) && (int)$params['is_important'] == 1) {
            $comment->is_important = 1;
        }
        $comment->source = 'EL';
        $comment->created_by = $user->user_enc_id;
        $comment->created_on = date('Y-m-d H:i:s');
        if (!$comment->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $comment->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
    }

    public function actionGetComments()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (empty($params["loan_account_enc_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing information 'loan_account_enc_id'"]);
        }

        $comments = LoanAccountComments::find()
            ->alias('a')
            ->select([
                'a.comment', 'a.is_important', 'a.reply_to', 'a.loan_account_enc_id',
                'a.status', 'a.source', 'a.created_on',
                "CONCAT(b.first_name,' ',COALESCE(b.last_name, '')) as created_by",
                "CASE WHEN b.image IS NOT NULL THEN CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . "',b.image_location, '/', b.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(b.first_name,' ',b.last_name), '&size=200&rounded=true&background=', REPLACE(b.initials_color, '#', ''), '&color=ffffff') END user_image",
                "CASE WHEN b1.logo IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . "', b1.logo_location, '/', b1.logo) ELSE CONCAT('https://ui-avatars.com/api/?name=', b1.name, '&size=200&rounded=false&background=', REPLACE(b1.initials_color, '#', ''), '&color=ffffff') END logo",
            ])
            ->joinWith(['createdBy b' => function ($b) {
                $b->joinWith(['organizations b1']);
            }], false)
            ->andWhere(['a.loan_account_enc_id' => $params['loan_account_enc_id'], 'a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($comments) {
            return $this->response(200, ['status' => 200, 'data' => $comments]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionStats()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        $where = ['a.is_deleted' => 0, 'a.hard_recovery' => 0];
        if (!empty($params['fields_search'])) {
            $fields_search = $params['fields_search'];
            foreach ($fields_search as $key => $value) {
                if (!empty($value)) {
                    switch ($key) {
                        case 'branch':
                            if ($value == 'unassigned') {
                                $where['a.branch_enc_id'] = null;
                            } else {
                                $where['a.branch_enc_id'] = $value;
                            }
                            break;
                        case 'loan_type':
                            $where['a.loan_type'] = $value;
                            break;
                    }
                }
            }
        }
        $buckets = LoanAccountsExtended::$buckets;
        $loan = (new Query())
            ->select(['*', "(CASE
                                WHEN (ledger_amount + overdue_amount) < 0 THEN
                                    (CASE
                                        WHEN bucket = 'onTime' THEN emi_amount
                                        ELSE
                                            (CASE
                                                WHEN (ledger_amount + overdue_amount) <
                                                    emi_amount * (CASE
                                                                        WHEN bucket = 'sma-0' THEN 1.25
                                                                        WHEN bucket IN ('sma-1', 'sma-2') THEN 1.50
                                                                        WHEN bucket = 'npa' THEN 2
                                                                        ELSE 1
                                                        END)
                                                    THEN (ledger_amount + overdue_amount)
                                                ELSE emi_amount *
                                                    (CASE
                                                            WHEN bucket = 'sma-0' THEN 1.25
                                                            WHEN bucket IN ('sma-1', 'sma-2') THEN 1.50
                                                            WHEN bucket = 'npa' THEN 2
                                                            ELSE 1
                                                        END)
                                                END)
                                        END)
                                ELSE (ledger_amount + overdue_amount)
                            END) AS total_pending_amount"])
            ->from(LoanAccounts::tableName());

        $b_select = [];
        foreach ($buckets as $key => $value) {
            $b_select[] = "SUM(CASE WHEN bucket = '" . $value['name'] . "' THEN a.total_pending_amount END) AS total_sum_$key";
            $b_select[] = "COUNT(CASE WHEN bucket = '" . $value['name'] . "' THEN a.total_pending_amount END) AS total_count_$key";
        }


        $bucket = (new Query())
            ->select([
                "COUNT(a.loan_account_enc_id) AS loan_accounts_count",
                "COUNT(NULLIF(a.overdue_amount, 0)) AS overdue_count",
                "SUM(a.overdue_amount) AS overdue_sum",
                "COUNT(NULLIF(a.ledger_amount, 0)) AS ledger_count",
                "SUM(a.ledger_amount) AS ledger_sum",
                "COUNT(NULLIF(a.last_emi_received_amount, 0)) AS emi_received_count",
                "SUM(a.last_emi_received_amount) AS emi_received_sum",
                "(COALESCE(COUNT(a.ledger_amount), 0) + COALESCE(COUNT(a.overdue_amount), 0)) AS total_pending_count",
                "(COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0)) AS total_pending_sum"
            ])
            ->addSelect($b_select)
            ->from(['a' => $loan])
            ->where($where);
        $bucketVal = '';
        if (!empty($params['sub_bucket'])&&isset($params['sub_bucket'])){
            $bucketVal = $params['sub_bucket'];
        }
        if (!empty($bucketVal)) {
            switch ($bucketVal) {
                case 1:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 0,
                        ':max' => 15
                    ]);
                    break;
                case 2:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 15,
                        ':max' => 30
                    ]);
                    break;
                case 3:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 30,
                        ':max' => 45
                    ]);
                    break;
                case 4:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 45,
                        ':max' => 60
                    ]);
                    break;
                case 5:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 60,
                        ':max' => 75
                    ]);
                    break;
                case 6:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 75,
                        ':max' => 90
                    ]);
                    break;
                case 7:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min AND ((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':min' => 90,
                        ':max' => 120
                    ]);
                    break;
                case 8:
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) >= :min', [
                        ':min' => 120
                    ]);
                    break;
                case 'X':
                    $bucket->andWhere('((a.overdue_amount / a.emi_amount) * 30) <= :max', [
                        ':max' => 0
                    ]);
                    break;
                default:
                    //skip
                    break;
            }
        }



        if (!$this->isSpecial(1)) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);

            $assigned_lc = (new Query())
                ->select(['z.loan_account_enc_id'])
                ->from(['z' => AssignedLoanAccounts::tableName()])
                ->where(['IN', 'z.shared_to', $juniors])
                ->andWhere(['z.is_deleted' => 0, 'z.status' => 'Active']);
            $bucket
                ->andWhere([
                    "OR",
                    ["IN", "a.assigned_caller", $juniors],
                    ["IN", "a.collection_manager", $juniors],
                    ["IN", "a.created_by", $juniors],
                    ["IN", "a.loan_account_enc_id", $assigned_lc],
                ]);
        }
        $bucket = $bucket->one();
        $bucket = array_merge($bucket, $this->ptpCasesStats($where));
        return $this->response(200, ["status" => 200, "data" => $bucket]);
    }

    private function ptpCasesStats($conditions)
    {
        $where = [];
        foreach ($conditions as $key => $value) {
            if (in_array($key, ['loan_type', 'branch_enc_id', 'bucket', 'id_deleted'])) {
                $where["la.$key"] = $value;
            }
        }
        $subQuery = (new Query())
            ->select(["DISTINCT REGEXP_REPLACE(z.loan_account_number, '[^a-zA-Z0-9]', '') AS loan_account_number"])
            ->from(['z' => EmiCollection::tableName()])
            ->innerJoin(['z1' => LoanAccountPtps::tableName()], 'z1.emi_collection_enc_id = z.emi_collection_enc_id')
            ->where(['z.is_deleted' => 0]);

        return (new Query())
            ->select(['COUNT(*) AS ptp_count', 'SUM(a.amount) AS ptp_sum'])
            ->from([
                'a' => (new Query())
                    ->select([
                        'x.amount',
                        "RANK() OVER (PARTITION BY REGEXP_REPLACE(x.loan_account_number, '[^a-zA-Z0-9]', '') ORDER BY x.id DESC) AS rnk",
                        'x.created_on',
                        'x.ptp_date'
                    ])
                    ->from(['x' => EmiCollection::tableName()])
                    ->innerJoin(['y' => $subQuery], "REGEXP_REPLACE(y.loan_account_number, '[^a-zA-Z0-9]', '') = REGEXP_REPLACE(x.loan_account_number, '[^a-zA-Z0-9]', '')")
                    ->innerJoin(['la' => LoanAccounts::tableName()], "la.loan_account_enc_id = x.loan_account_enc_id")
                    ->where(['x.is_deleted' => 0])
                    ->andWhere($where)
            ])
            ->where([
                'AND',
                ['a.rnk' => 1],
                ['IS NOT', 'a.ptp_date', null]
            ])
            ->one();
    }

    public function actionLoanAccountsType()
    {
        $loan_accounts = LoanAccountsExtended::find()
            ->distinct()
            ->select(['loan_type'])
            ->asArray()
            ->all();
        return $this->response(200, ["status" => 200, "data" => $loan_accounts]);
    }

    public function actionUpdateLoanAccAccess()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;

        if (empty($params['assigned_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "assigned_enc_id"']);
        }

        $update = AssignedLoanAccountsExtended::findOne(['assigned_enc_id' => $params['assigned_enc_id'], 'is_deleted' => 0]);

        if (!$update) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

        (!empty($params['access'])) ? $update->access = $params['access'] : "";
        (!empty($params['status'])) ? $update->status = $params['status'] : "";
        (!empty($params['delete'])) ? $update->is_deleted = 1 : "";
        $update->updated_by = $user->user_enc_id;
        $update->updated_on = date('Y-m-d H:i:s');

        if (!$update->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $update->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
    }

    public function actionGetPtpCases()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;

        $sub_query = (new \yii\db\Query())
            ->select(['z.loan_account_enc_id', 'z.collection_date', 'z.amount', 'z.emi_collection_enc_id'])
            ->from(['z' => EmiCollection::tableName()])
            ->where([
                'z.id' => (new \yii\db\Query())
                    ->select(['MAX(zz.id)'])
                    ->from(['zz' => EmiCollection::tableName()])
                    ->where("z.loan_account_enc_id = zz.loan_account_enc_id AND zz.emi_payment_status NOT IN ('pending', 'failed', 'rejected')")
                    ->orderBy(['id' => SORT_DESC])
            ]);

        $ptpcases = LoanAccountPtps::find()
            ->alias('a')
            ->select([
                  "CASE
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) <= 0 THEN 'X'
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) >= 0 AND ((c.overdue_amount / c.emi_amount) * 30) <= 15 THEN 1
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) > 15 AND ((c.overdue_amount / c.emi_amount) * 30) <= 30 THEN 2
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) > 30 AND ((c.overdue_amount / c.emi_amount) * 30) <= 45 THEN 3
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) > 45 AND ((c.overdue_amount / c.emi_amount) * 30) <= 60 THEN 4
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) > 60 AND ((c.overdue_amount / c.emi_amount) * 30) <= 75 THEN 5
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) > 75 AND ((c.overdue_amount / c.emi_amount) * 30) <= 90 THEN 6
                    WHEN ((c.overdue_amount / c.emi_amount) * 30) > 90 AND ((c.overdue_amount / c.emi_amount) * 30) <= 120 THEN 7
                    WHEN (c.overdue_amount / c.emi_amount) * 30 >= 120 THEN 8
                END AS sub_bucket",
                "a.ptp_enc_id", "a.emi_collection_enc_id", "a.proposed_payment_method", "a.proposed_date",
                "a.proposed_amount", "a.status", "a.collection_manager as collection_manager_enc_id", "b.loan_account_enc_id",
                "b.loan_account_number", "c.total_installments", "c.financed_amount", "c.stock", "c.last_emi_received_date",
                "c.last_emi_date", "COALESCE(c.name, b.customer_name) AS name",
                "c.emi_amount", "c.overdue_amount", "c.ledger_amount",
                "(CASE WHEN c.loan_type IS NOT NULL THEN c.loan_type ELSE b.loan_type END) AS loan_type",
                "c.emi_date", "c.last_emi_received_amount", "c.advance_interest", "c.bucket",
                "(CASE WHEN c.branch_enc_id IS NOT NULL THEN c.branch_enc_id ELSE b.branch_enc_id END) AS branch_enc_id",
                "c.bucket_status_date", "c.pos", "bb.location_enc_id as branch", "bb.location_name as branch_name",
                "CONCAT(cm.first_name, ' ', COALESCE(cm.last_name, '')) as collection_manager",
                "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, '')) as assigned_caller",
                "COALESCE(SUM(c.ledger_amount), 0) + COALESCE(SUM(c.overdue_amount), 0) AS total_pending_amount",
                "a.created_by", 'c2.name as state_name', 'c2.state_enc_id',
            ])
            ->innerJoinWith(['emiCollectionEnc b' => function ($b) {
                $b->joinWith(['loanAccountEnc c' => function ($cc) {
                    $cc->joinWith(['assignedLoanAccounts ala' => function ($ala) {
                        $ala->joinWith(['sharedTo d1']);
                        $ala->andOnCondition(['ala.is_deleted' => 0]);
                    }]);
                    $cc->joinWith(['branchEnc d' => function ($d) {
                        $d->joinWith(['cityEnc c1' => function ($c1) {
                            $c1->joinWith(['stateEnc c2'], false);
                        }], false);
                    }], false);
                    $cc->joinWith(["assignedCaller ac"], false);
                }]);
                $b->joinWith(['branchEnc bb'], false);
            }])
            ->joinWith(['collectionManager cm'], false);

        if (isset($params['type']) && $params['type'] == 'dashboard') {
            $ptpcases->andWhere(['BETWEEN', 'a.proposed_date', date('Y-m-d'), date('Y-m-d', strtotime('+3 days'))]);
        } else {
            $ptpcases->andwhere(['>=', 'a.proposed_date', date('Y-m-d')]);
        }

        $ptpcases = $ptpcases
            ->groupBy(['a.ptp_enc_id'])
            ->orderBy(['a.proposed_date' => SORT_ASC]);
        if (empty($user->organization_enc_id) && !in_array($user->username, ['nisha123', 'rajniphf', 'KKB', 'phf604', 'wishey'])) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $ptpcases = $ptpcases->andWhere(['IN', 'a.created_by', $juniors]);
        }

        if (!empty($params["fields_search"])) {
            foreach ($params["fields_search"] as $key => $value) {
                if (!empty($value) || $value == "0") {
                    if ($key=='sub_bucket'){
                        $ptpcases->having(['in','sub_bucket',$value]);
                    }
                    elseif ($key == 'assigned_caller') {
                        if ($value == 'unassigned') {
                            $ptpcases->andWhere(['CONCAT(ac.first_name, \' \', COALESCE(ac.last_name, \'\'))' => null]);
                        } else {
                            $ptpcases->andWhere(["like", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, ''))", "%$value%", false]);
                        }
                    } elseif ($key == 'loan_account_number') {
                        $ptpcases->andWhere(['b.' . $key => $value]);
                    } elseif ($key == 'state_enc_id') {
                        if (in_array("unassigned", $value)) {
                            $ptpcases->andWhere(['c2.state_enc_id' => null]);
                        } else {
                            $ptpcases->andWhere(['IN', 'c2.state_enc_id', $value]);
                        }                    
                    } elseif ($key == 'bucket') {
                        if (in_array("unassigned", $value)) {
                            $ptpcases->andWhere(['c.bucket' => null]);
                        } else {
                            $ptpcases->andWhere(['IN', 'c.bucket', $value]);
                        }
                    } elseif ($key == 'loan_type') {
                        $ptpcases->andWhere(['IN', 'c.loan_type', $value]);
                    } elseif ($key == 'branch') {
                        if (in_array("unassigned", $value)) {
                            $ptpcases->andWhere(['bb.location_enc_id' => null]);
                        } else {
                            $ptpcases->andWhere(['IN', 'bb.location_enc_id', $value]);
                        }
                    } elseif ($key == 'total_pending_amount') {
                        $ptpcases->having(['=', "COALESCE(SUM(c.ledger_amount), 0) + COALESCE(SUM(c.overdue_amount), 0)", $value]);
                    } elseif ($key == 'min_proposed_amount') {
                        $ptpcases->andWhere([">=", 'a.proposed_amount', $value]);
                    } elseif ($key == 'max_proposed_amount') {
                        $ptpcases->andWhere(["<=", 'a.proposed_amount', $value]);
                    } elseif ($key == 'min_overdue_amount') {
                        $ptpcases->andWhere([">=", 'overdue_amount', $value]);
                    } elseif ($key == 'max_overdue_amount') {
                        $ptpcases->andWhere(["<=", 'overdue_amount', $value]);
                    } elseif ($key == 'min_pos') {
                        $ptpcases->andWhere([">=", 'pos', $value]);
                    } elseif ($key == 'max_pos') {
                        $ptpcases->andWhere(["<=", 'pos', $value]);
                    } elseif ($key == 'min_emi_amount') {
                        $ptpcases->andWhere([">=", 'emi_amount', $value]);
                    } elseif ($key == 'max_emi_amount') {
                        $ptpcases->andWhere(["<=", 'emi_amount', $value]);
                    } elseif ($key == 'min_last_emi_received_amount') {
                        $ptpcases->andWhere([">=", 'last_emi_received_amount', $value]);
                    } elseif ($key == 'max_last_emi_received_amount') {
                        $ptpcases->andWhere(["<=", 'last_emi_received_amount', $value]);
                    } elseif ($key == 'emi_date') {
                        $ptpcases->andWhere(['DAY(c.emi_date)' => $value]);
                    } elseif ($key == 'collection_manager') {
                        $ptpcases->andWhere(['ala.user_type' => 2])
                            ->andWhere(['LIKE', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", "$value%", false]);
                    } elseif ($key == 'assigned_bdo') {
                        if ($value == 'unassigned') {
                            $ptpcases->andWhere(['ala.user_type' => 1])
                                ->andWhere(['CONCAT(d1.first_name, \' \', COALESCE(d1.last_name, \'\'))' => null]);
                        } else {
                            $ptpcases->andWhere(['ala.user_type' => 1])
                                ->andWhere(['LIKE', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", "$value%", false]);
                        }
                    } elseif ($key == 'proposed_start_date') {
                        if ($value == 'unassigned') {
                            $ptpcases->andWhere(['a.proposed_date' => null]);
                        } else {
                            $ptpcases->andWhere(['>=', 'a.proposed_date', $value]);
                        }
                    } elseif ($key == 'proposed_end_date') {
                        if ($value == 'unassigned') {
                            $ptpcases->andWhere(['a.proposed_date' => null]);
                        } else {
                            $ptpcases->andWhere(['<=', 'a.proposed_date', $value]);
                        }
                    } elseif ($key == 'proposed_payment_method') {
                        $ptpcases->andWhere(['a.' . $key => $value]);
                    } elseif ($key == 'name') {
                        $ptpcases->andWhere([
                            'OR',
                            [
                                'AND',
                                ['IS NOT', 'c.name', null],
                                ['LIKE', 'c.name', "%$value%", false]
                            ],
                            [
                                'AND',
                                ['IS', 'c.name', null],
                                ['LIKE', 'b.customer_name', "%$value%", false]
                            ]
                        ]);
                    } else {
                        $ptpcases->andWhere(['like', $key, $value]);
                    }
                }
            }
        }
        $count = $ptpcases->count();
        $ptpcases = $ptpcases
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        foreach ($ptpcases as &$item) {
            $tm = $item['emiCollectionEnc']['loanAccountEnc'];
            $item['assignedLoanAccounts'] = array_map(function ($assignedLoan) {
                $user_type = ($assignedLoan['user_type'] == 1) ? 'bdo' : (($assignedLoan['user_type'] == 2) ? 'collection_manager' : (($assignedLoan['user_type'] == 3) ? 'telecaller' : null));
                $shared_name = $assignedLoan['sharedTo']['first_name'] . ' ' . ($assignedLoan['sharedTo']['last_name'] ?? null);
                if (!empty($assignedLoan['sharedTo']['image'])) {
                    $shared_img = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $assignedLoan['sharedTo']['image_location'] . '/' . $assignedLoan['sharedTo']['image'];
                } else {
                    $shared_img = 'https://ui-avatars.com/api/?name=' . urlencode($shared_name) . '&size=200&rounded=false&background=' . str_replace('#', '', $assignedLoan['sharedTo']['initials_color']) . '&color=ffffff';
                }
                return [
                    'id' => $assignedLoan['id'],
                    'assigned_enc_id' => $assignedLoan['assigned_enc_id'],
                    'loan_account_enc_id' => $assignedLoan['loan_account_enc_id'],
                    'access' => $assignedLoan['access'],
                    'name' => $shared_name,
                    'image' => $shared_img,
                    'user_type' => $user_type,
                ];
            }, $tm['assignedLoanAccounts']);
            unset($item['emiCollectionEnc'], $item['loanAccountEnc']);
        }

        if ($ptpcases) {
            return $this->response(200, ['status' => 200, 'count' => $count, 'data' => $ptpcases]);
        }

        return $this->response(200, ['status' => 200, 'data' => [], 'message' => 'Not Found']);
    }

    public function actionGetLoanAccount()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        $loan_number = $params['loan_number'];
        if (!empty($loan_number['loan_account_enc_id']) && $loan_number['loan_account_enc_id'] !== "null") {
            $query = LoanAccountsExtended::find()
                ->alias('a')
                ->select([
                    'a.loan_account_enc_id', "(CASE WHEN a.nach_approved = 0 THEN 'Inactive' WHEN a.nach_approved = 1 THEN 'Active' ELSE '' END) AS nach_approved", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, '')) as assigned_caller",
                    'a.loan_account_number', 'a.name', 'a.phone', 'a.loan_account_enc_id AS id',
                    "CASE WHEN a.bucket = 'onTime' THEN a.emi_amount ELSE
                    (CASE WHEN COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0) < a.emi_amount * (CASE 
                        WHEN a.bucket = 'sma-0' THEN 1.25
                        WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                        WHEN a.bucket = 'npa' THEN 2
                        ELSE 1
                    END)  
                    THEN COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0)  
                        ELSE emi_amount * 
                            (CASE 
                                WHEN a.bucket = 'sma-0' THEN 1.25
                                WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                                WHEN a.bucket = 'npa' THEN 2
                                ELSE 1
                        END) 
                    END) 
                END target_collection_amount", "COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0) AS total_pending_amount",
                    'a.emi_amount', 'a.overdue_amount', 'a.ledger_amount', 'a.loan_type', 'a.emi_date', 'a.bucket',
                ])
                ->joinWith(["assignedCaller ac"], false)
                ->joinWith(["assignedLoanAccounts d" => function ($d) {
                    $d->andOnCondition(["d.is_deleted" => 0, "d.status" => "Active"]);
                    $d->select([
                        'd.loan_account_enc_id', "d.assigned_enc_id", "(CASE WHEN d.user_type = 1 THEN 'bdo' WHEN user_type = 2 THEN 'collection_manager' WHEN user_type = 3 THEN 'telecaller' END) as user_type",
                        "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, '')) name",
                        "(CASE WHEN d1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', d1.image_location, '/', d1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', concat(d1.first_name,' ',d1.last_name), '&size=200&rounded=false&background=', REPLACE(d1.initials_color, '#', ''), '&color=ffffff') END) image"
                    ]);
                    $d->joinWith(['sharedTo d1'], false);
                }])
                ->where(['a.is_deleted' => 0])
                ->andWhere(['a.loan_account_number' => $loan_number['loan_account_number']])
                ->groupBy(['a.loan_account_enc_id'])
                ->asArray()
                ->all();
            if ($query) {
                return $this->response(200, ['status' => 200, 'data' => $query]);
            }
        } else {
            $query = EmiCollection::find()
                ->select(['loan_account_number', 'customer_name as name', 'phone', 'loan_type'])
                ->where(['loan_account_number' => $loan_number['loan_account_number']])
                ->asArray()
                ->all();

            if ($query) {
                return $this->response(200, ['status' => 200, 'data' => $query]);
            }
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionShiftPtpCases($limit = 50, $page = 1, $auth = '')
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($auth !== 'EXhS3PIQq9iYHoCvpT2f1a62GUCfzRvn') {
            return ['status' => 401, 'msg' => 'authentication failed'];
        }

        $data = EmiCollection::find()
            ->alias('a')
            ->select([
                'a.emi_collection_enc_id', 'a.ptp_payment_method', 'a.ptp_amount', 'a.ptp_date', 'a.created_on',
                'a.created_by', 'a.updated_by', 'a.updated_on'
            ])
            ->where([
                'and',
                ['not', ['a.ptp_amount' => NULL]],
                ['not', ['a.ptp_date' => NULL]]
            ])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->asArray()
            ->all();

        $inserted = 0;
        $utilitiesModel = new Utilities();
        foreach ($data as $d) {
            $utilitiesModel->variables["string"] = time() . rand(100, 10000000);

            $insert = Yii::$app->db->createCommand()
                ->insert(LoanAccountPtps::tableName(), [
                    'ptp_enc_id' => $utilitiesModel->encrypt(),
                    'emi_collection_enc_id' => $d['emi_collection_enc_id'],
                    'proposed_payment_method' => $d['ptp_payment_method'],
                    'proposed_date' => $d['ptp_date'],
                    'proposed_amount' => $d['ptp_amount'],
                    'status' => 1,
                    'created_by' => $d['created_by'],
                    'created_on' => $d['created_on'],
                    'updated_by' => $d['updated_by'] ? $d['updated_by'] : $d['created_by'],
                    'updated_on' => $d['updated_on'] ? $d['updated_on'] : $d['created_on'],
                ])
                ->execute();
            if ($insert) {
                $inserted += 1;
            }
        }


        return ['status' => 200, 'found' => count($data), 'inserted' => $inserted];
    }

    public function actionShiftAssignedLoanAccounts($limit = 50, $page = 1, $auth = '')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($auth !== 'EXhS3PIQq9iYHoCvpT2f1a62GUCfzRvn') {
            return ['status' => 401, 'msg' => 'authentication failed'];
        }

        $data = LoanAccounts::find()
            ->alias('a')
            ->select(["a.loan_account_enc_id", "a.updated_by", "a.collection_manager", "a.updated_on", "a.created_by"])
            ->where(['not', ["a.collection_manager" => NULL]])
            ->andwhere(['a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->asArray()
            ->all();

        $inserted = 0;
        $utilitiesModel = new Utilities();
        foreach ($data as $val) {
            $utilitiesModel->variables["string"] = time() . rand(100, 10000000);

            $insert = Yii::$app->db->createCommand()
                ->insert(AssignedLoanAccounts::tableName(), [
                    'assigned_enc_id' => $utilitiesModel->encrypt(),
                    'loan_account_enc_id' => $val['loan_account_enc_id'],
                    'shared_by' => $val['updated_by'],
                    'shared_to' => $val['collection_manager'],
                    'user_type' => 2,
                    'status' => 'Active',
                    'created_by' => $val['updated_by'],
                    'created_on' => $val['updated_on'],
                    'updated_by' => $val['updated_by'],
                    'updated_on' => $val['updated_on'],
                ])->execute();
            if ($insert) {
                $inserted += 1;
            }
        }

        return ['status' => 200, 'found' => count($data), 'inserted' => $inserted];
    }

    public function actionUpdatePriority()
    {
        $user = $this->isAuthorized();
        if (!$user) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        $loan_account_enc_id = $params['loan_account_enc_id'];

        if (empty($loan_account_enc_id)) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information "loan_account_enc_id"']);
        }

        foreach ($loan_account_enc_id as $loan_account_enc_ids) {
            $priority = LoanAccountsExtended::findOne(['loan_account_enc_id' => $loan_account_enc_ids]);
            if (!$priority) {
                throw new Exception('Loan account not found');
            }
            $priority->sales_priority = !empty($params['sales_priority']) ? $params['sales_priority'] : $priority->sales_priority;
            $priority->collection_priority = !empty($params['collection_priority']) ? $params['collection_priority'] : $priority->collection_priority;
            $priority->telecaller_priority = !empty($params['telecaller_priority']) ? $params['telecaller_priority'] : $priority->telecaller_priority;
            $priority->sales_target_date = !empty($params['sales_target_date']) ? $params['sales_target_date'] : $priority->sales_target_date;
            $priority->collection_target_date = !empty($params['collection_target_date']) ? $params['collection_target_date'] : $priority->collection_target_date;
            $priority->telecaller_target_date = !empty($params['telecaller_target_date']) ? $params['telecaller_target_date'] : $priority->telecaller_target_date;

            $priority->updated_by = $user->user_enc_id;
            $priority->updated_on = date('Y-m-d H:i:s');
            if (!$priority->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $priority->getErrors()]);
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
    }

    public function actionHardRecovery()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        $loanAccountEncIds = isset($params['loan_accounts']) ? $params['loan_accounts'] : [];

        if (empty($loanAccountEncIds)) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "loan_accounts"']);
        }

        foreach ($loanAccountEncIds as $loanAccountEncId) {
            $hard_recovery = LoanAccountsExtended::findOne(['loan_account_enc_id' => $loanAccountEncId]);

            if ($hard_recovery) {
                if ($hard_recovery->hard_recovery == 1) {
                    $hard_recovery->hard_recovery = 0;
                } else {
                    $hard_recovery->hard_recovery = 1;
                }

                $hard_recovery->updated_by = $user->user_enc_id;
                $hard_recovery->updated_on = date('Y-m-d H:i:s');

                if (!$hard_recovery->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $hard_recovery->getErrors()]);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Loan Account with ID ' . $loanAccountEncId . ' not found']);
            }
        }
        return $this->response(200, ['status' => 200, 'message' => 'Marked Hard Recovery']);
    }

    public function actionUploadSheet()
    {
        $this->isAuth(2);
        $user = $this->user;
        $params = $this->post;
        if (empty($params['branch_loc'])) {
            return 'send branch loc';
        }
        $branch_loc = $params['branch_loc'];
        if (!in_array($branch_loc, ['ZoneName', 'CompanyName'])) {
            return 'send correct loc';
        }
        $branches = [
            "JALANDHAR" => "TrqLBkI5SotCQop7U0woMQEutVX4u_js",
            "PATHANKOT" => "BnE3860mWdn2Ek4ganakdjw9A2K5DJ",
            "FAZILKA" => "DKLb29kg0o0Ax5zrDVpydPBlampN8J",
            "LUDHIANA" => "gYtsOG242BbiWWN7lKNbz7IWJgWoCCn9",
            "MOGA" => "T4g9Wj8XLoXVwQclQXyGKTg2aj1ivH2u",
            "JAGRAON" => "Y8NKO0tAPYiV3AyXOZegqJZXRS349OnX",
            "HOSHIARPUR" => "K8Q1w8QJx9n2dohUt9yaxcXxDNmOXTly",
            "NAWANSHEHAR" => "JQV0LHItiRIzWEwmLSnoMWKrF9-bN-zd",
            "MUKERIAN" => "ir5WbWoWWoFyusc_4PQlwOu5DQUgyKxQ",
            "BATALA" => "_vqfd91_Zeuzyx6YO86LRdN8WsppmYjb",
            "TARN TARAN" => "YMvA0ceagxF8VnOM9iZGiLcA1U5ntfYN",
            "TARNTARAN" => "YMvA0ceagxF8VnOM9iZGiLcA1U5ntfYN",
            "KAPURTHALA" => "7SeaDyQLa9EAJa-VBwU487QWcZtILbKy",
            "NAKODAR" => "S7jiMDMKxeMyBi7lIiRYkloixUS23CJu",
            "MUKTSAR" => "k92XHDDvjSLHRb1Z9Mgqzrjsivbd9yPY",
            "GANGA NAGAR" => "64DQhoey0k_yld7EgVkBPRaMzTRHM27g",
            "ABOHAR" => "_52J89O4vEyuMd1iOiLeXXpF1YNJQacZ",
            "MALOUT" => "bGWAE6eeiBCMscTJP4_LOWZNrYnfB9ZI",
            "DELHI" => "gJD3Q3rBN4zd1Y54TzlL3-6H8DdqMonV",
            "JUC99" => "_3mF57Fx4OjP-k9fI8N8YQcaEunorkX9",
            "KHANNA" => "Qrbb-ZDFjnfJxPdqaa2p-glNy2M8vR0a",
            "MALERKOTLA" => "F1mtP7o8JY0dzHQ63pwAuT71mM9kPMES",
            "AMRITSAR" => "Q53aKrsYXU_dk9BXKlNyBVNHe1dBCzyE",
            "KHARAR" => "aCQ-LQO7lG3w1PsnDKnpBJrGWKOgOHhl",
            "ZIRKPUR" => "umIKTkufpaej91B1ZFN7ccRlm2izgBDr",
            "MOH" => "can4hKTe3yPwYCOlrgntY3U7y9L9j3tv",
            "HSR" => "62AfH3SduPPkLs7xpaSutKcmlFdBDBhr",
            "JIND" => "33FmX0h2wsAzZIK2sOGr_L9tvTDrTn-I",
            "FEROZPUR" => "jKbDalL5YRxwe3XvqxGrQGqgwrkA06",
            "JUCHO" => "3wVg50vYNo8kpYnZb1yZRBGKXJmWpO",
            "UBC" => "BnE3860mWdnjvDg1eKqLdjw9A2K5DJ",
            "ROHTAK" => "k4x1rvbEZd3N0KJ34y0JoaY7p5gXMV",
            "SNP" => "abvgrG4VyQNLv5yKEVaMopW30A9nXK",
            "PNP" => "VagLPkqymR5362byxxGgdb8K4GeY29",
            "ROORKEE" => "Yljygz3xWRVLz5Y37anzd6BD7w1LP5",
            "HARIDWAR" => "nM70aLyBGo9Ar9yVO531oKl2Wp1EVz",
            "RKSH" => "7B0P3kNEldvA6yaEMk0vom14wrJXbj",
            "DDN" => "VA1npK2MJdJ24kbq0ayPdrlbjPkBXZ",
            "GAZIABAD" => "x8JweG370Q7alG887W65o2z5PrBLyl",
            "MDNR" => "yeD1AaYgZoGWDqLmBB2DoGkOlw9MK5",
            "NODA" => "yeD1AaYgZoGWDqLmJ4wNoGkOlw9MK5",
            "KLE" => "L7B0P3kNEldvwA2zpjxvQm14wrJXbj",
            "GGN" => "zpBn4vYx2RmB75pZDX8loJg3Aq9Vyl",
            "JUC10" => "yVgawN7rxoLL9A10jpnYoYOM5kelbv",
            "CDG" => "E9n1pJ74KRzANyYglp9qQgxm0e5ND6",
            "JP" => "6mMpL8zN9QqAqwEGpLLmQAxKOrBbnw",
            "PTA" => "qOLw3GDM1RZj2w4E2VwxRgjYBra6Ak",
            "PAN" => "zpBn4vYx2RmBjkEnnBq1oJg3Aq9Vyl"
        ];
        $defined = [
            'FileNumberNew' => 'loan_account_number',
            'CaseNo' => 'case_no',
            'CompanyID' => 'company_id',
            'CompanyName' => 'company_name',
            'DealerName' => 'dealer_name',
            'NachApproved' => 'nach_approved',
            'CoBorrower' => 'coborrower_name',
            'CoBorrowerMobile' => 'coborrower_phone',
            'LastInstallmentDate' => 'last_emi_date',
            'TotalInstallments' => 'total_installments',
            'AmountFinanced' => 'financed_amount',
            'Stock' => 'stock',
            'Adv.HP' => 'advance_interest',
            'OverDue' => 'overdue_amount',
            'SMA_STATUS' => 'bucket',
            'Name' => 'name',
            'SMA_STATUS_DATE' => 'bucket_status_date',
            'MobileNumber' => 'phone',
            'Installment1' => 'emi_amount',
            'Ledger A/c' => 'ledger_amount',
            'LoanType' => 'loan_type',
            'FirstInstallmentDate' => 'emi_date',
            'LastRecAmount' => 'last_emi_received_amount',
            'LastRecDate' => 'last_emi_received_date',
            'VehicleMain' => 'vehicle_type',
            'VehicleModel' => 'vehicle_make',
            'VehicleMake' => 'vehicle_model',
            'VehicleEngineNo' => 'vehicle_engine_no',
            'VehicleChassisNo' => 'vehicle_chassis_no',
            'VehicleNo' => 'rc_number',
        ];
        $no_need = [
            'PHF LEASING LTD.',
            'PHF LEASING LIMITED',
            'PHF ECO GREEN',
            'LAP-',
            'LAP -',
        ];
        $always_required = [
            'CompanyID',
            'LmsNumber',
            'FileNumberNew',
            'CompanyName',
            'CaseNo',
            'Stock',
            'Adv.HP',
            'SMA_STATUS',
            'SMA_STATUS_DATE',
            'ZoneName',
            'Ledger A/c',
            'MobileNumber',
            'Name',

        ];
        $new_cases = 0;
        $old_cases = 0;
        $file = $_FILES['file'];
        try {
            if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
                $count = true;
                $transaction = Yii::$app->db->beginTransaction();
                $utilitiesModel = new Utilities();
                while (($data = fgetcsv($handle, 100000)) !== FALSE) {
                    if ($count) {
                        $headers = $data;
                        $missing = [];
                        foreach ($always_required as $item) {
                            if (!in_array($item, $headers)) {
                                $missing[] = $item;
                            }
                        }
                        if (!empty($missing)) {
                            throw new \Exception("These fields are required" . json_encode($missing));
                        }
                        $count = false;
                        continue;
                    }
                    if (empty($headers)) {
                        throw new \Exception("Headers error.");
                    }

                    $data = array_map(function ($key, $item) use ($headers) {
                        $item = trim($item);
                        return in_array($key, [array_search('FileNumberNew', $headers), array_search('CaseNo', $headers)]) ? str_replace(' ', '', $item) : $item;
                    }, array_keys($data), $data);
                    unset($loan_account_number);
                    if (array_search('FileNumberNew', $headers) !== false) {
                        $loan_account_number = $data[array_search('FileNumberNew', $headers)];
                    }
                    $lms_loan_account_number = $data[array_search('LmsNumber', $headers)];
                    $case_no = $data[array_search('CaseNo', $headers)];
                    $where = ["AND"];
                    if (!empty($loan_account_number)) {
                        $where[] = ["loan_account_number" => $loan_account_number];
                    } else {
                        $company_id = $data[array_search('CompanyID', $headers)];
                        $where[] = ["case_no" => $case_no];
                        $where[] = ["company_id" => $company_id];
                        $loan_account_number = $lms_loan_account_number;
                    }
                    if (array_search('Name', $headers) !== false) {
                        $name = $data[array_search('Name', $headers)];
                        $name = explode(' ', $name)[0];
                        $where[] = ['LIKE', 'name', "$name%", false];
                    }
                    $model = LoanAccounts::find();
                    $loan = $model->where($where)->one();

                    if (!$loan && !empty($loan_account_number)) {
                        $where = [
                            'AND',
                            [
                                'OR',
                                ['loan_account_number' => $loan_account_number],
                                ['lms_loan_account_number' => $loan_account_number]
                            ],
                            ['IS', 'loan_app_enc_id', null]
                        ];
                        $loan = $model->where($where)->one();
                    }
                    if (!$loan) {
                        $new = true;
                        $loan = new LoanAccounts();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000000);
                        $loan->loan_account_enc_id = $utilitiesModel->encrypt();
                        if (!empty($lms_loan_account_number)) {
                            $loan->lms_loan_account_number = $lms_loan_account_number;
                        }
                        $loan->case_no = $case_no;
                        $loan->loan_account_number = !empty($loan_account_number) ? $loan_account_number : $case_no;
                        $loan->created_on = date('Y-m-d H:i:s');
                        $loan->created_by = $user->user_enc_id;
                        $new_cases++;
                    } else {
                        $old_cases++;
                    }
                    $loan->updated_on = date('Y-m-d H:i:s');
                    $loan->updated_by = $user->user_enc_id;

                    if (in_array('LoanType', $headers)) {
                        $loan_type = $data[array_search('LoanType', $headers)];
                    } else {
                        $loan_type = $params['loan_type'];
                    }
                    $loan->loan_type = $loan_type;
                    $loan->updated_by = $user->user_enc_id;
                    foreach ($headers as $header) {
                        if (in_array($header, [
                            'CompanyID',
                            'CompanyName',
                            'DealerName',
                            'NachApproved',
                            'CoBorrower',
                            'CoBorrowerMobile',
                            'LastInstallmentDate',
                            'TotalInstallments',
                            'AmountFinanced',
                            'Stock',
                            'AmountFinanced',
                            'SMA_STATUS',
                            'SMA_STATUS_DATE',
                            'Name',
                            'MobileNumber',
                            'VehicleMain',
                            'VehicleMake',
                            'VehicleModel',
                            'VehicleEngineNo',
                            'VehicleChassisNo',
                            'VehicleNo',
                            'Adv.HP',
                            'Installment1',
                            'Ledger A/c',
                            'LoanType',
                            'LastRecDate',
                            'FirstInstallmentDate',
                            'VehicleMain',
                            'LastInstallmentDate',
                            'ZoneName',
                            'OverDue'
                        ])) {
                            $value = $data[array_search($header, $headers)];

                            if (in_array($header, ['NachApproved'])) {
                                $value = $value == 'Yes' ? 1 : 0;
                            } else if ($header == $branch_loc) {
                                $branch = trim(str_replace($no_need, '', $value));
                                $branch = $branches[$branch];
                                if (empty($branch)) {
                                    throw new \Exception('branch not found');
                                }
                                $loan->branch_enc_id = $branch;
                            } else if ($header == 'VehicleModel') {
                                if (!is_numeric($value) || strlen((string)$value) != 4) {
                                    continue;
                                }
                            } else if ($header == 'Stock') {
                                $amount = $data[array_search('Adv.HP', $headers)];
                                if ($amount === false) {
                                    throw new \Exception('Adv.HP field not found');
                                }
                                $loan->pos = $value + $amount;
                            } else if (in_array($header, ['LastRecDate', 'FirstInstallmentDate', 'LastInstallmentDate', 'SMA_STATUS_DATE'])) {
                                if (empty($value) && $value !== 0) {
                                    continue;
                                }
                                $date = date('Y-m-d', strtotime($value));
                                if ($header == 'LastRecDate') {
                                    if (empty($loan->last_emi_received_date) || ($loan->last_emi_received_date < $date && !empty($value))) {
                                        $loan->last_emi_received_date = $date;
                                        $amount = $data[array_search('LastRecAmount', $headers)];
                                        if ($amount === false) {
                                            throw new \Exception('LastRecAmount field not found');
                                        }
                                        if (!empty($amount))
                                            $loan->last_emi_received_amount = $amount;
                                    }
                                    continue;
                                }
                                $value = $date;
                            }
                            if ($header == 'ZoneName') {
                                continue;
                            }

                            if (empty($defined[$header])) {
                                throw new \Exception("db field not found for $header");
                            }

                            if (!empty($value) || $value === 0) {
                                $def = $defined[$header];
                                if (in_array($header, [
                                    'Stock',
                                    'Adv.HP',
                                    'SMA_STATUS',
                                    'SMA_STATUS_DATE',
                                    'MobileNumber',
                                    'Ledger A/c',
                                    'OverDue'
                                ])) {
                                    if ($header == 'Ledger A/c' && in_array($loan_type, ['Loan Against Property', 'MSME']) && $value < 0) {
                                        $value = 0;
                                    }
                                    $loan->$def = $value;
                                } else {
                                    if (empty($loan->$def)) {
                                        $loan->$def = $value;
                                    }
                                }
                            }
                        }
                    }
                    if (!$loan->save()) {
                        throw new \Exception(implode(' ', array_column($loan->getErrors(), '0')));
                    }
                    unset($new);
                }
                fclose($handle);
                $transaction->commit();
                return $this->response(200, ['message' => 'successfully saved', 'new_cases' => $new_cases, 'old_cases' => $old_cases]);
            }
        } catch (\Exception $exception) {
            print_r(['exception' => $exception]);
            exit();
            $this->response(500, ['message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionUpdateBranch()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['id']) || empty($params['value'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_account_enc_id" and "value" are required']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $branch = LoanAccountsExtended::findOne(['loan_account_enc_id' => $params['id']]);
            if (!$branch) {
                return $this->response(404, ['status' => 404, 'message' => 'Loan Account not found']);
            }

            $branch->branch_enc_id = $params['value'];
            $branch->updated_by = $user->user_enc_id;
            $branch->updated_on = date('Y-m-d H:i:s');

            if (!$branch->update()) {
                throw new Exception(implode(" ", array_column($branch->getErrors(), '0')));
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionFinancerAssigned()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['loan_id']) || empty($params['partner_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_id" or "partner_id"']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $branch = LoanAccountsExtended::findOne(['loan_account_enc_id' => $params['loan_id']]);
            if (!$branch) {
                return $this->response(404, ['status' => 404, 'message' => 'Loan Account not found']);
            }

            $branch->assigned_financer_enc_id = $params['partner_id'];
            $branch->updated_by = $user->user_enc_id;
            $branch->updated_on = date('Y-m-d H:i:s');

            if (!$branch->update()) {
                throw new Exception(implode(" ", array_column($branch->getErrors(), '0')));
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Successfully Assigned']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionAssignFinancer($limit = 50, $page = 1, $auth = '')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($auth !== Yii::$app->params->apiAccessKey) {
            return ['status' => 401, 'message' => 'authentication failed'];
        }

        $num = LoanApplications::find()
            ->alias('a')
            ->select(['a.application_number', 'a.loan_app_enc_id', 'b.provider_enc_id'])
            ->innerJoinWith(['loanApplicationPartners b'], false)
            ->andWhere(['not', ['a.application_number' => null]])
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->asArray()
            ->all();

        foreach ($num as $application) {
            $loan_account = LoanAccounts::findOne(['loan_account_number' => $application['application_number']]);
            if ($loan_account) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $loan_account->assigned_financer_enc_id = $application['provider_enc_id'];

                    if (!$loan_account->save()) {
                        throw new Exception(implode(" ", array_column($loan_account->getErrors(), '0')));
                    }
                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
                }
            }
        }
        $transaction->commit();
        return ['status' => 200, 'found and updated' => count($num)];
    }

    public function actionUpdateTargetDates()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_account_enc_id"']);
        }

        if (!isset($params['sales_target_date']) && !isset($params['collection_target_date']) && !isset($params['telecaller_target_date'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "sales_target_date" or "collection_target_date" or "telecaller_target_date"']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $target_date = LoanAccountsExtended::findOne(['loan_account_enc_id' => $params['loan_account_enc_id']]);
            if (!$target_date) {
                return $this->response(404, ['status' => 404, 'message' => 'Loan Account not found']);
            }

            $target_date->sales_target_date = isset($params['sales_target_date']) ? $params['sales_target_date'] : $target_date->sales_target_date;
            $target_date->collection_target_date = isset($params['collection_target_date']) ? $params['collection_target_date'] : $target_date->collection_target_date;
            $target_date->telecaller_target_date = isset($params['telecaller_target_date']) ? $params['telecaller_target_date'] : $target_date->telecaller_target_date;
            $target_date->updated_by = $user->user_enc_id;
            $target_date->updated_on = date('Y-m-d H:i:s');

            if (!$target_date->update()) {
                throw new Exception(implode(" ", array_column($target_date->getErrors(), '0')));
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Added Successfully']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionUpdatePtpStatus()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        $ptp_enc_id = $params['ptp_enc_id'];

        if (empty($ptp_enc_id)) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information "ptp_enc_id"']);
        }
        if (!isset($params['status'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "status"']);
        }

        foreach ($ptp_enc_id as $ptp_enc_ids) {
            $status = LoanAccountPtps::findOne(['ptp_enc_id' => $ptp_enc_ids]);
            if (!$status) {
                throw new Exception('ptp_enc_id not found');
            }
            $status->status = !empty($params['status']) ? $params['status'] : $status->status;
            $status->updated_by = $user->user_enc_id;
            $status->updated_on = date('Y-m-d H:i:s');
            if (!$status->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $status->getErrors()]);
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
    }

    public function actionUpcomingPtpStats()
    {
        $user = $this->isAuth();
        $params = Yii::$app->request->post();

        $sub_query = (new Query())
            ->from(['a' => LoanAccountPtps::tableName()])
            ->select(['a.proposed_date', 'COUNT(a.id) count', 'SUM(a.proposed_amount) AS sum', 'ANY_VALUE(c.loan_type)'])
            ->leftJoin(['b' => EmiCollection::tableName()], 'b.emi_collection_enc_id = a.emi_collection_enc_id')
            ->leftJoin(['c' => LoanAccounts::tableName()], 'c.loan_account_enc_id = b.loan_account_enc_id')
            ->leftJoin(['ac' => Users::tableName()], 'ac.user_enc_id = c.assigned_caller')
            ->leftJoin(['d' => OrganizationLocations::tableName()], 'd.location_enc_id = c.branch_enc_id')
            ->leftJoin(['c1' => Cities::tableName()], 'c1.city_enc_id = d.city_enc_id')
            ->leftJoin(['c2' => States::tableName()], 'c2.state_enc_id = c1.state_enc_id')
            ->leftJoin(['bb' => OrganizationLocations::tableName()], 'bb.location_enc_id = b.branch_enc_id')
            ->leftJoin(['cm' => Users::tableName()], 'cm.user_enc_id = a.collection_manager')
            ->leftJoin(['ala' => AssignedLoanAccounts::tableName()], 'ala.loan_account_enc_id = c.loan_account_enc_id')
            ->leftJoin(['d1' => Users::tableName()], 'd1.user_enc_id = ala.created_by')
            ->groupBy(['proposed_date']);

        if (empty($user->organization_enc_id) && !in_array($user->username, ['nisha123', 'rajniphf', 'KKB', 'phf604', 'wishey'])) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $sub_query->andWhere(['IN', 'a.created_by', $juniors]);
        }

        $from = "(SELECT CURDATE() AS proposed_date
                UNION ALL
                SELECT  DATE_ADD( CURDATE(), INTERVAL 1 DAY)
                UNION ALL
                SELECT  DATE_ADD( CURDATE(), INTERVAL 2 DAY)
                UNION ALL
                SELECT  DATE_ADD( CURDATE(), INTERVAL 3 DAY)
        )";
        $data = (new Query())
            ->select([
                'a.proposed_date',
                'COALESCE(b.sum, 0) sum',
                'COALESCE(b.count,0) AS count',
            ])
            ->from(['a' => $from])
            ->leftJoin(['b' => $sub_query], 'a.proposed_date = b.proposed_date');

        $query = LoanAccountPtps::find()
            ->alias('a')
            ->select([
                'la.loan_type',
                "SUM(a.proposed_amount) amount",
                "COUNT(a.proposed_date) AS count",
            ])
            ->joinWith(['emiCollectionEnc ec' => function ($ec) {
                $ec->joinWith(['loanAccountEnc la' => function ($la) {
                    $la->joinWith(["assignedLoanAccounts ala" => function ($ala) {
                        $ala->andOnCondition(['ala.is_deleted' => 0]);
                        $ala->joinWith(['sharedTo d1']);
                    }]);
                    $la->joinWith(["assignedCaller ac"], false);
                    $la->joinWith(['branchEnc d' => function ($d) {
                        $d->joinWith(['cityEnc c1' => function ($c1) {
                            $c1->joinWith(['stateEnc c2'], false);
                        }], false);
                    }], false);
                }]);
                $ec->joinWith(['branchEnc bb'], false);
            }], false)
            ->joinWith(['collectionManager cm'], false)
            ->where(['IS NOT', 'la.loan_type', null])
            ->andwhere(['>=', 'a.proposed_date', date('Y-m-d')])
            ->groupBy(['la.loan_type']);

        if (!empty($params["fields_search"])) {
            foreach ($params["fields_search"] as $key => $value) {
                if (!empty($value) || $value == "0") {
                    if ($key == 'assigned_caller') {
                        if ($value == 'unassigned') {
                            $sub_query->andWhere(['CONCAT(ac.first_name, \' \', COALESCE(ac.last_name, \'\'))' => null]);
                            $query->andWhere(['CONCAT(ac.first_name, \' \', COALESCE(ac.last_name, \'\'))' => null]);
                        } else {
                            $sub_query->andWhere(["like", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, ''))", "%$value%", false]);
                            $query->andWhere(["like", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, ''))", "%$value%", false]);
                        }
                    } elseif ($key == 'loan_account_number') {
                        $sub_query->andWhere(['b.' . $key => $value]);
                        $query->andWhere(['ec.' . $key => $value]);
                    } elseif ($key == 'state_enc_id') {
                        if (in_array("unassigned", $value)) {
                        $sub_query->andWhere(['c2.state_enc_id' => null]);
                        $query->andWhere(['c2.state_enc_id' => null]);
                    } else {
                        $sub_query->andWhere(['IN', 'c2.state_enc_id', $value]);
                        $query->andWhere(['IN', 'c2.state_enc_id', $value]);
                    }
                    } elseif ($key == 'bucket') {
                        if (in_array("unassigned", $value)) {
                            $sub_query->andWhere(['c.bucket' => null]);
                            $query->andWhere(['la.bucket' => null]);
                        } else {
                            $sub_query->andWhere(['IN', 'c.bucket', $value]);
                            $query->andWhere(['IN', 'la.bucket', $value]);
                        }
                    } elseif ($key == 'loan_type') {
                        $sub_query->andWhere(['IN', 'c.loan_type', $value]);
                        $query->andWhere(['IN', 'la.loan_type', $value]);
                    } elseif ($key == 'branch') {
                        if (in_array("unassigned", $value)) {
                            $sub_query->andWhere(['bb.location_enc_id' => null]);
                            $query->andWhere(['bb.location_enc_id' => null]);
                        } else {
                            $sub_query->andWhere(['IN', 'bb.location_enc_id', $value]);
                            $query->andWhere(['IN', 'bb.location_enc_id', $value]);
                        }
                    } elseif ($key == 'assigned_bdo') {
                        $sub_query->andWhere(['ala.user_type' => 1])
                            ->andWhere(['LIKE', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", "$value%", false]);
                        $query->andWhere(['ala.user_type' => 1])
                            ->andWhere(['LIKE', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", "$value%", false]);
                    } elseif ($key == 'collection_manager') {
                        $sub_query->andWhere(['ala.user_type' => 2])
                            ->andWhere(['LIKE', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", "$value%", false]);
                        $query->andWhere(['ala.user_type' => 2])
                            ->andWhere(['LIKE', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", "$value%", false]);
                    } elseif ($key == 'min_proposed_amount') {
                        $sub_query->andWhere([">=", 'a.proposed_amount', $value]);
                        $query->andWhere([">=", 'a.proposed_amount', $value]);
                    } elseif ($key == 'max_proposed_amount') {
                        $sub_query->andWhere(["<=", 'a.' . $key, "$value", false]);
                        $query->andWhere(["<=", 'a.' . $key, "$value%", false]);
                    } elseif ($key == 'min_pos') {
                        $sub_query->andWhere([">=", 'c.pos', $value]);
                        $query->andWhere([">=", 'la.pos', $value]);
                    } elseif ($key == 'max_pos') {
                        $sub_query->andWhere(["<=", 'c.pos', $value]);
                        $query->andWhere(["<=", 'la.pos', $value]);
                    } elseif ($key == 'min_emi_amount') {
                        $sub_query->andWhere([">=", 'c.emi_amount', $value]);
                        $query->andWhere([">=", 'la.emi_amount', $value]);
                    } elseif ($key == 'max_emi_amount') {
                        $sub_query->andWhere(["<=", 'c.emi_amount', $value]);
                        $query->andWhere(["<=", 'la.emi_amount', $value]);
                    } elseif ($key == 'min_overdue_amount') {
                        $sub_query->andWhere([">=", 'c.overdue_amount', $value]);
                        $query->andWhere([">=", 'la.overdue_amount', $value]);
                    } elseif ($key == 'max_overdue_amount') {
                        $sub_query->andWhere(["<=", 'c.overdue_amount', $value]);
                        $query->andWhere(["<=", 'la.overdue_amount', $value]);
                    } elseif ($key == 'emi_date') {
                        $sub_query->andWhere(['DAY(c.emi_date)' => $value]);
                        $query->andWhere(['DAY(la.emi_date)' => $value]);
                    } elseif ($key == 'proposed_start_date') {
                        if ($value == 'unassigned') {
                            $sub_query->andWhere(['a.proposed_date' => null]);
                            $query->andWhere(['a.proposed_date' => null]);
                        } else {
                            $sub_query->andWhere(['>=', 'a.proposed_date', $value]);
                            $query->andWhere(['>=', 'a.proposed_date', $value]);
                        }
                    } elseif ($key == 'proposed_end_date') {
                        if ($value == 'unassigned') {
                            $sub_query->andWhere(['a.proposed_date' => null]);
                            $query->andWhere(['a.proposed_date' => null]);
                        } else {
                            $sub_query->andWhere(['<=', 'a.proposed_date', $value]);
                            $query->andWhere(['<=', 'a.proposed_date', $value]);
                        }
                    } elseif ($key == 'proposed_payment_method') {
                        $sub_query->andWhere(['a.' . $key => $value]);
                        $query->andWhere(['a.' . $key => $value]);
                    } elseif ($key == 'name') {
                        $sub_query->andWhere([
                            'OR',
                            [
                                'AND',
                                ['IS NOT', 'c.name', null],
                                ['LIKE', 'c.name', "%$value%", false]
                            ],
                            [
                                'AND',
                                ['IS', 'c.name', null],
                                ['LIKE', 'b.customer_name', "%$value%", false]
                            ]
                        ]);
                        $query->andWhere([
                            'OR',
                            [
                                'AND',
                                ['IS NOT', 'la.name', null],
                                ['LIKE', 'la.name', "%$value%", false]
                            ],
                            [
                                'AND',
                                ['IS', 'la.name', null],
                                ['LIKE', 'ec.customer_name', "%$value%", false]
                            ]
                        ]);
                    } else {
                        $sub_query->andWhere(['like', $key, $value]);
                        $query->andWhere(['like', $key, $value]);
                    }
                }
            }
        }
        $data = $data->all();
        $query = $query->asArray()->all();
        return $this->response(200, ["status" => 200, "date_stats" => $data, "product_stats" => $query]);
    }

    public function actionPtpProductStats()
    {
        $user = $this->isAuth();
        $query = LoanAccountPtps::find()
            ->alias('a')
            ->select([
                'la.loan_type',
                "SUM(a.proposed_amount) amount",
                "COUNT(a.proposed_date) AS count",
            ])
            ->joinWith(['emiCollectionEnc ec' => function ($ec) {
                $ec->joinWith(['loanAccountEnc la']);
            }], false)
            ->where(['IS NOT', 'la.loan_type', null])
            ->andwhere(['>=', 'a.proposed_date', date('Y-m-d')])
            ->groupBy(['la.loan_type'])
            ->asArray()
            ->all();
        return $this->response(200, ["status" => 200, "data" => $query]);
    }

    public function actionSendPaymentLinks()
    {
        $user = $this->isAuth();
        $params = $this->post;
        if (empty($params['loan_account_enc_ids'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_account_enc_ids"']);
        }
        $loan_account_enc_ids = $params['loan_account_enc_ids'];
        $loan_accounts = LoanAccounts::find()
            ->alias('a')
            ->select([
                'a.loan_account_enc_id', 'a.name', 'a.phone', 'a.loan_type',
                "(CASE WHEN a.bucket = 'onTime' THEN a.emi_amount ELSE
                    (CASE WHEN COALESCE(a.ledger_amount, 0) + COALESCE(a.overdue_amount, 0) < a.emi_amount * (CASE 
                        WHEN a.bucket = 'sma-0' THEN 1.25
                        WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                        WHEN a.bucket = 'npa' THEN 2
                        ELSE 1
                    END)  
                    THEN COALESCE(a.ledger_amount, 0) + COALESCE(a.overdue_amount, 0)  
                        ELSE emi_amount * 
                            (CASE 
                                WHEN a.bucket = 'sma-0' THEN 1.25
                                WHEN a.bucket IN ('sma-1', 'sma-2') THEN 1.50
                                WHEN a.bucket = 'npa' THEN 2
                                ELSE 1
                        END) 
                    END) 
                END) AS emi_amount"
            ])
            ->where(["AND", ['IN', 'a.loan_account_enc_id', $loan_account_enc_ids], ['a.is_deleted' => 0]])
            ->indexBy(['loan_account_enc_id'])
            ->asArray()
            ->all();
        if (!$loan_accounts) {
            return $this->response(404, ['message' => 'An error occurred.', 'error' => 'Loan accounts not found']);
        }
        $enc_amount = array_column($loan_accounts, 'emi_amount', 'loan_account_enc_id');
        $where = ['OR'];
        foreach ($enc_amount as $key => $value) {
            $where[] = ['a.loan_account_enc_id' => $key, 'b.payment_amount' => $value];
        }
        $check_existing = AssignedLoanPayments::find()
            ->alias('a')
            ->select(['a.loan_account_enc_id', 'a.loan_payments_enc_id'])
            ->innerJoinWith(['loanPaymentsEnc AS b' => function ($b) {
                $b->andOnCondition(
                    [
                        'AND',
                        ['b.payment_link_type' => '0'],
                        ['>=', 'b.close_by', date('Y-m-d H:i:s')],
                        ['b.payment_mode_status' => 'active'],
                        ['b.payment_status' => 'pending']
                    ]
                );
            }], false)
            ->where(
                $where
            )
            ->asArray()->all();

        $data = array_diff($loan_account_enc_ids, array_column($check_existing, 'loan_account_enc_id'));
        try {
            if (!$org = $user->organization_enc_id) {
                $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
                if (!$org = $findOrg['organization_enc_id']) {
                    return $this->response(500, ['status' => 500, 'message' => 'Organization not found']);
                }
            }
            $options['org_id'] = $org;
            $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
            if (!$keys) {
                throw new \Exception('an error occurred while fetching razorpay credentials');
            }
            $api_key = $keys['api_key'];
            $api_secret = $keys['api_secret'];
            $api = new Api($api_key, $api_secret);
            foreach ($data as $value) {
                $loan_account = $loan_accounts[$value];
                if ($loan_account['emi_amount'] < 0 || empty($loan_account['phone']) || strlen($loan_account['phone']) != 10) {
                    continue;
                }
                $options = [];
                $options['loan_account_enc_id'] = $loan_account['loan_account_enc_id'];
                $options['user_id'] = $user->user_enc_id;
                $options['amount'] = $loan_account['emi_amount'];
                $options['description'] = 'Emi collection for ' . $loan_account['loan_type'];
                $options['name'] = $loan_account['name'];
                $options['contact'] = $loan_account['phone'];
                $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack . "/payment/transaction";
                $options['brand'] = 'Testing';
                $options['purpose'] = $loan_account['loan_type'];
                $options['close_by'] = time() + 24 * 60 * 60 * 30;
                $options['ref_id'] = 'EMPL-' . Yii::$app->security->generateRandomString(8);
                $create = \common\models\payments\Payments::createLink($api, $options);
                if (!$create) {
                    throw new Exception('An error occurred.');
                }
            }
            return $this->response(200, ['message' => 'Success']);
        } catch (\Exception $exception) {
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionLoanAssign()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_type"']);
        }
        if (empty($params['user_id']) || empty($params['user_type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "user_id" and "user_type"']);
        }

        $query = LoanAccounts::find()
            ->alias('a')
            ->select(['a.loan_account_enc_id'])
            ->where(['a.loan_type' => $params['loan_type']])
            ->andWhere([
                'not exists', (new Query())
                    ->select('*')
                    ->from(['b' => AssignedLoanAccounts::tableName()])
                    ->where('b.loan_account_enc_id = a.loan_account_enc_id')
                    ->andWhere(['b.shared_to' => $params['user_id']])
                    ->andWhere(['b.user_type' => $params['user_type']])
            ])
            ->groupBy(['a.loan_account_enc_id'])
            ->asArray()
            ->all();

        if (empty($query)) {
            return $this->response(404, ['status' => 404, 'message' => 'Loan account not found']);
        }
        foreach ($query as $data) {
            $update = new AssignedLoanAccounts();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $update->assigned_enc_id = $utilitiesModel->encrypt();
            $update->loan_account_enc_id = $data['loan_account_enc_id'];
            $update->shared_by = $user->user_enc_id;
            $update->shared_to = $params['user_id'];
            $update->access = 'Full Access';
            $update->user_type = $params['user_type'];
            $update->status = 'Active';
            $update->created_by = $user->user_enc_id;
            $update->created_on = date('Y-m-d H:i:s');
            $update->updated_by = $user->user_enc_id;
            $update->updated_on = date('Y-m-d H:i:s');
            if (!$update->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving the data.', 'error' => $update->getErrors()]);
            }
        }
        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
    }

    public function actionUpdateLoanAccount()
    {
        $user = $this->isAuthorized();
        if (!$user) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        if ($user->username != 'KKB') {
            return $this->response(404, ['status' => 404, 'message' => 'Page Not Found']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_account_enc_id"']);
        }

        if (!isset($params['company_id']) && !isset($params['case_no'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "company_id" or "case_no"']);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $case = LoanAccounts::findOne(['loan_account_enc_id' => $params['loan_account_enc_id']]);

            if (empty($case)) {
                throw new Exception("Loan Account not found.");
            }
            $case->company_id = $params['company_id'];
            $case->case_no = $params['case_no'];
            if (!$case->save()) {
                throw new \yii\db\Exception(implode(" ", array_column($case->getErrors(), '0')));
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Added Successfully']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionLinksPaymentList()
    {
        $this->isAuth();
        $params = $this->post;
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $data = AssignedLoanPayments::find()
            ->alias('a')
            ->select([
                'a.loan_account_enc_id',
                'a.emi_collection_enc_id',
                'a.loan_payments_enc_id',
                'b.name',
                'b.loan_account_number',
                'b.bucket',
                'b.bucket_status_date',
                'c.payment_amount',
                'c.payment_status',
                'a.created_on AS transaction_initiated_date',
                'd.collection_date',
                'b.phone',
                'b1.location_name',
                'b.loan_type',
            ])
            ->innerJoinWith(['loanAccountEnc AS b' => function ($b) {
                $b->joinWith(['branchEnc AS b1'], false);
            }], false)
            ->innerJoinWith(['loanPaymentsEnc AS c'], false)
            ->joinWith(['emiCollectionEnc AS d'], false);
        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $data->andWhere(['BETWEEN', 'a.created_on', $params['start_date'], $params['end_date']]);
        }
        $search = [
            'loan_account_number',
            'customer_name',
            'bucket',
            'phone',
            'loan_type',
            'collection_start_date',
            'collection_end_date',
            'emi_payment_statuses',
            'transaction_start_date',
            'transaction_end_date'
        ];
        foreach ($params['fields_search'] as $key => $val) {
            if ((!empty($val) || $val == '0') && in_array($key, $search)) {
                switch ($key) {
                    case 'collection_start_date':
                        $data->andWhere(['>=', 'd.collection_date', $val]);
                        break;
                    case 'collection_end_date':
                        $data->andWhere(['<=', 'd.collection_date', $val]);
                        break;
                    case 'emi_payment_statuses':
                        $data->andWhere(['c.payment_status' => $val]);
                        break;
                    case 'transaction_start_date':
                        $data->andWhere(['>=', 'a.created_on', $val]);
                        break;
                    case 'transaction_end_date':
                        $data->andWhere(['<=', 'a.created_on', $val]);
                        break;
                    case 'loan_account_number':
                        $data->andWhere(['LIKE', 'b.loan_account_number', "$val%", false]);
                        break;
                    case 'customer_name':
                        $data->andWhere(['LIKE', 'b.name', $val]);
                        break;
                    case 'phone':
                        $data->andWhere(['LIKE', 'b.phone', "$val%", false]);
                        break;
                    default:
                        // default is only for b alias name so set accordingly
                        $data->andWhere(["b.$key" => $val]);
                        break;
                }
            }
        }
        $count = $data->count();
        $data = $data->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        if (!empty($data)) {
            return $this->response(200, ['message' => 'Success', 'data' => $data, 'count' => $count]);
        }
        return $this->response(404, ['message' => 'data not found']);
    }

    public function actionUpdateBasicDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['loan_account_enc_id']) || empty($params['value']) || empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "loan_account_enc_id", "type", and "value" are required']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $other_details = LoanAccounts::findOne(['loan_account_enc_id' => $params['loan_account_enc_id']]);
            if (!$other_details) {
                return $this->response(404, ['status' => 404, 'message' => 'Loan Account not found']);
            }
            $update = new LoanAccountOtherDetails();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $update->detail_enc_id = $utilitiesModel->encrypt();
            $update->loan_account_enc_id = $params['loan_account_enc_id'];
            $update->type = $params['type'];
            $update->value = $params['value'];
            $update->created_by = $update->updated_by = $user->user_enc_id;
            $update->created_on = $update->updated_on = date('Y-m-d H:i:s');

            if (!$update->save()) {
                throw new Exception(implode(" ", array_column($update->getErrors(), '0')));
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }
}
