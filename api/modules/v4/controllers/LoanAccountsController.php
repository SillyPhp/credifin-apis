<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\EmiPaymentIssues;
use common\models\extended\EmiPaymentIssuesExtended;
use common\models\LoanAccounts;
use common\models\Utilities;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;


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
                'emi-account-details' => ['POST', 'OPTIONS']
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

    public function actionLoanAccountsUpload()
    {

        $user = $this->isAuthorized();
        if (!$user && !UserUtilities::getUserType($user->user_enc_id) != 'Financer') {
            return $this->response(500, 'Not Authorized');
        }
        $branches = [
            "JUC1" => "TrqLBkI5SotCQop7U0woMQEutVX4u_js",
            "LDH" => "gYtsOG242BbiWWN7lKNbz7IWJgWoCCn9",
            "MOGA" => "T4g9Wj8XLoXVwQclQXyGKTg2aj1ivH2u",
            "JGN" => "Y8NKO0tAPYiV3AyXOZegqJZXRS349OnX",
            "HSX" => "K8Q1w8QJx9n2dohUt9yaxcXxDNmOXTly",
            "NAWA" => "JQV0LHItiRIzWEwmLSnoMWKrF9-bN-zd",
            "MEX" => "ir5WbWoWWoFyusc_4PQlwOu5DQUgyKxQ",
            "BAT" => "_vqfd91_Zeuzyx6YO86LRdN8WsppmYjb",
            "TTO" => "YMvA0ceagxF8VnOM9iZGiLcA1U5ntfYN",
            "KXH" => "7SeaDyQLa9EAJa-VBwU487QWcZtILbKy",
            "NRO" => "S7jiMDMKxeMyBi7lIiRYkloixUS23CJu",
            "MKS" => "k92XHDDvjSLHRb1Z9Mgqzrjsivbd9yPY",
            "SGNR" => "64DQhoey0k_yld7EgVkBPRaMzTRHM27g",
            "ABS" => "_52J89O4vEyuMd1iOiLeXXpF1YNJQacZ",
            "MOT" => "bGWAE6eeiBCMscTJP4_LOWZNrYnfB9ZI",
            "NDLS" => "gJD3Q3rBN4zd1Y54TzlL3-6H8DdqMonV",
            "JUC99" => "_3mF57Fx4OjP-k9fI8N8YQcaEunorkX9",
            "KNN" => "Qrbb-ZDFjnfJxPdqaa2p-glNy2M8vR0a",
            "MET" => "F1mtP7o8JY0dzHQ63pwAuT71mM9kPMES",
            "ASR" => "Q53aKrsYXU_dk9BXKlNyBVNHe1dBCzyE",
            "KARR" => "aCQ-LQO7lG3w1PsnDKnpBJrGWKOgOHhl",
            "ZKP" => "umIKTkufpaej91B1ZFN7ccRlm2izgBDr",
            "MOH" => "can4hKTe3yPwYCOlrgntY3U7y9L9j3tv",
            "HSR" => "62AfH3SduPPkLs7xpaSutKcmlFdBDBhr",
            "JIND" => "33FmX0h2wsAzZIK2sOGr_L9tvTDrTn-I",
            "FZP" => "jKbDalL5YRxwe3XvqxGrQGqgwrkA06",
            "JUCHO" => "3wVg50vYNo8kpYnZb1yZRBGKXJmWpO",
            "UBC" => "BnE3860mWdnjvDg1eKqLdjw9A2K5DJ",
            "ROK" => "k4x1rvbEZd3N0KJ34y0JoaY7p5gXMV",
            "SNP" => "abvgrG4VyQNLv5yKEVaMopW30A9nXK",
            "PNP" => "VagLPkqymR5362byxxGgdb8K4GeY29",
            "RK" => "Yljygz3xWRVLz5Y37anzd6BD7w1LP5",
            "HW" => "nM70aLyBGo9Ar9yVO531oKl2Wp1EVz",
            "RKSH" => "7B0P3kNEldvA6yaEMk0vom14wrJXbj",
            "DDN" => "VA1npK2MJdJ24kbq0ayPdrlbjPkBXZ",
            "GZB" => "x8JweG370Q7alG887W65o2z5PrBLyl",
            "MDNR" => "yeD1AaYgZoGWDqLmBB2DoGkOlw9MK5",
            "NODA" => "yeD1AaYgZoGWDqLmJ4wNoGkOlw9MK5",
            "KLEnull" => "L7B0P3kNEldvwA2zpjxvQm14wrJXbj",
            "GGNnull" => "zpBn4vYx2RmB75pZDX8loJg3Aq9Vyl",
            "JUC10" => "yVgawN7rxoLL9A10jpnYoYOM5kelbv",
            "CDG" => "E9n1pJ74KRzANyYglp9qQgxm0e5ND6",
            "JP" => "6mMpL8zN9QqAqwEGpLLmQAxKOrBbnw",
            "PTA" => "qOLw3GDM1RZj2w4E2VwxRgjYBra6Ak",
            "PAN" => "zpBn4vYx2RmBjkEnnBq1oJg3Aq9Vyl"
        ];
        $file = $_FILES['file'];
        if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
            $count = true;
            $transaction = Yii::$app->db->beginTransaction();
            $utilitiesModel = new Utilities();
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                $data = array_map(function($item) {
                    return str_replace([' ', "\t", "\n", "\r", "\0", "\x0B"], '', trim($item));
                }, $data);
                if ($count) {
                    $header = $data;
                    $count = false;
                    continue;
                }
                $loan = LoanAccounts::findOne(['loan_account_number' => trim($data[array_search('LoanNo', $header)])]);
                if (!$loan) {
                    $loan = new LoanAccounts();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000000);
                    $loan->loan_account_enc_id = $utilitiesModel->encrypt();
                    $loan->lms_loan_account_number = $data[array_search('LmsNumber', $header)];
                    $loan->loan_account_number = trim($data[array_search('LoanNo', $header)]);
                    $loan->name = trim($data[array_search('CustomerName', $header)]);
                    $loan->loan_type = $data[array_search('LoanType', $header)];
                    $loan->emi_date = date('Y-m-d', strtotime($data[array_search('FirstInstallmentDate', $header)]));
                    $loan->last_emi_date = date('Y-m-d', strtotime($data[array_search('LastInstallmentDate', $header)]));
                    $loan->emi_amount = $data[array_search('EmiAmount', $header)];
                    $loan->total_installments = $data[array_search('TotalInstallments', $header)];
                    $loan->financed_amount = $data[array_search('AmountFinanced', $header)];
                    $loan->branch_enc_id = $branches[$data[array_search('Branch', $header)]];
                    $loan->created_on = date('Y-m-d h:i:s');
                    $loan->created_by = $user->user_enc_id;
                }
                $loan->bucket_status_date = date('Y-m-d', strtotime($data[array_search('SMASTATUSDATE', $header)]));
                $loan->bucket = $data[array_search('SMASTATUS', $header)];
                $loan->last_emi_received_amount = $data[array_search('LastRecAmount', $header)];
                $loan->last_emi_received_date = date('Y-m-d', strtotime($data[array_search('LastRecDate', $header)]));
                $loan->ledger_amount = $data[array_search('LedgerAmount', $header)] ?? 0;
                $loan->overdue_amount = $data[array_search('OverDueAmount', $header)] ?? 0;
                $loan->pos = $data[array_search('Pos', $header)];
                $loan->advance_interest = $data[array_search('AdvanceInterest', $header)];
                $loan->stock = $data[array_search('Stock', $header)];
                $loan->collection_manager = $data[array_search('CollectionManager', $header)];
                !empty($data[array_search('Phone', $header)]) ? $loan->phone = $data[array_search('Phone', $header)] : '';
                $loan->updated_on = date('Y-m-d h:i:s');
                $loan->updated_by = $user->user_enc_id;
                if (!$loan->save()) {
                    print_r($loan->getErrors());
                    print_r($data);
                    exit();
                    $transaction->rollBack();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan->getErrors()]);
                }
            }
            fclose($handle);
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        }
    }

    public function actionLoanAccountsUpload2()
    {
        $user = $this->isAuthorized();
        if (!$user && !UserUtilities::getUserType($user->user_enc_id) != 'Financer') {
            return $this->response(500, 'Not Authorized');
        }
        $file = $_FILES['file'];
        if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
            $count = 1;
            $transaction = Yii::$app->db->beginTransaction();
            $utilitiesModel = new Utilities();
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                if ($count == 1) {
                    $count++;
                    continue;
                }
                $save = 'update';
                $loan = LoanAccounts::findOne(['loan_account_number' => trim($data[1])]);
                if (!$loan) {
                    $loan = new LoanAccounts();
                    $utilitiesModel->variables['string'] = time() . rand(100, 10000000);
                    $loan->loan_account_enc_id = $utilitiesModel->encrypt();
                    $loan->lms_loan_account_number = $data[0];
                    $loan->loan_account_number = trim($data[1]);
                    $loan->name = $data[2];
                    if (!empty($data[3])) {
                        $loan->phone = $data[3];
                    }
                    $loan->loan_type = $data[6];
                    $loan->created_on = date('Y-m-d h:i:s');
                    $loan->created_by = $user->user_enc_id;
                    $save = 'save';
                }
                $loan->emi_date = date('Y-m-d', strtotime($data[5]));
                $loan->emi_amount = $data[4];
                if (!empty($data[7])) {
                    $loan->overdue_amount = $data[7];
                }
                if (!empty($data[8])) {
                    $loan->ledger_amount = $data[8];
                }
                if (!empty($data[9])) {
                    $loan->last_emi_received_amount = $data[9];
                }
                if (!empty($data[10])) {
                    $loan->last_emi_received_date = date('Y-m-d', strtotime($data[10]));
                }
                $loan->updated_on = date('Y-m-d h:i:s');
                $loan->updated_by = $user->user_enc_id;
                if (!$loan->$save()) {
                    $transaction->rollBack();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan->getErrors()]);
                }
            }
            fclose($handle);
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        }
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
            $Payment_issues = new EmiPaymentIssuesExtended();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $Payment_issues->emi_payment_issues_enc_id = $utilitiesModel->encrypt();
            $Payment_issues->loan_account_enc_id = $params['loan_account_enc_id'];
            $Payment_issues->loan_app_enc_id = !empty($params['loan_app_enc_id']) ? $params['loan_app_enc_id'] : null;
            $Payment_issues->reasons = $params['reasons'];
            $Payment_issues->remarks = $params['remarks'];
            $Payment_issues->created_by = $Payment_issues->updated_by = $user->user_enc_id;
            $Payment_issues->created_on = $Payment_issues->updated_on = date('Y-m-d H:i:s');

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
        $data = EmiPaymentIssues::find()
            ->alias('a')
            ->joinWith(['createdBy b'])
            ->andWhere(['a.is_deleted' => 0, 'a.loan_account_enc_id' => $params['loan_account_enc_id']])
            ->asArray()
            ->all();

        $res = [];
        $issues = [
            '1' => 'legal', '2' => 'Repo', '3' => 'accidental', '4' => 'health'
        ];

        foreach ($data as $datam) {
            $reason = $datam['reasons'];
            $pay_issues = !empty($issues[$reason]) ? $issues[$reason] : null;
            $createdByName = $datam['createdBy']['first_name'] . ' ' . $datam['createdBy']['last_name'];

            $res[] = [
                'emi_payment_issues_enc_id' => $datam['emi_payment_issues_enc_id'],
                'loan_account_enc_id' => $datam['loan_account_enc_id'],
                'created_by' => $createdByName,
                'created_on' => $datam['created_on'],
                'remarks' => $datam['remarks'],
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
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id"']);
        }

        $data = LoanAccounts::find()
            ->select(['loan_account_enc_id', 'loan_account_number',
                'COUNT(CASE WHEN is_deleted = 0 THEN loan_account_number END) as total_emis',
                'name', 'phone', 'emi_amount', 'overdue_amount', 'ledger_amount', 'loan_type', 'emi_date', 'created_on', 'last_emi_received_amount', 'last_emi_received_date'])
            ->andWhere(['is_deleted' => 0, 'loan_account_enc_id' => $params['loan_account_enc_id']])
            ->asArray()
            ->one();

        $lac = LoanAccounts::findOne(['loan_account_enc_id' => $params['loan_account_enc_id']]);
        $model = $this->_emiAccData($lac)['data'];

        if ($data || $model) {
            return $this->response(200, ['status' => 200, 'data' => $data, 'display_data' => $model]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
    }


    private function _emiAccData($lac)
    {
        $model = EmiCollection::find()
            ->alias('a')
            ->select([
                'a.customer_name', 'a.collection_date', 'a.amount', 'a.emi_payment_method', 'CONCAT(b.first_name , " ", b.last_name) as collected_by',
                'CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ",",a.other_delay_reason) ELSE a.delay_reason END AS delay_reason',
                'CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . '",a.pr_receipt_image_location, "/", a.pr_receipt_image) ELSE NULL END as pr_receipt_image',
                'CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . '",a.other_doc_image_location, "/", a.other_doc_image) ELSE NULL END as other_doc_image',
                'a.created_on', 'a.emi_payment_status', 'a.reference_number'
            ])
            ->joinWith(['createdBy b'], false)
            ->andWhere(['a.is_deleted' => 0, 'created_by' => $lac['created_by'], 'loan_account_number' => $lac['loan_account_number']]);

        $model = $model
            ->asArray()
            ->all();
        return ['data' => $model];
    }
}
