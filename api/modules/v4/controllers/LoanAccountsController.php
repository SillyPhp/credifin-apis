<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\models\VehicleRepoForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\EmiPaymentIssues;
use common\models\extended\EmiPaymentIssuesExtended;
use common\models\LoanAccounts;
use common\models\UserRoles;
use common\models\Utilities;
use common\models\spaces\Spaces;
use common\models\VehicleRepossession;
use common\models\VehicleRepossessionImages;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use function GuzzleHttp\Promise\all;


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
            "KLE" => "L7B0P3kNEldvwA2zpjxvQm14wrJXbj",
            "GGN" => "zpBn4vYx2RmB75pZDX8loJg3Aq9Vyl",
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
            while (($data = fgetcsv($handle,)) !== FALSE) {
                if ($count) {
                    $header = $data;
                    $count = false;
                    continue;
                }

                $data = array_map(function ($key, $item) use ($header) {
                    $item = trim($item);
                    return in_array($key, [array_search('LmsNumber', $header), array_search('LoanNo', $header)]) ? str_replace(' ', '', $item) : $item;
                }, array_keys($data), $data);

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
                    $loan->group_name = $data[array_search('GroupName', $header)];
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
                $collection_manager = UserRoles::findOne(['employee_code' => $data[array_search('CollectionManager', $header)]]);
                if ($collection_manager && !empty($collection_manager['user_enc_id'])) {
                    $loan->collection_manager = $collection_manager['user_enc_id'];
                }
                !empty($data[array_search('Phone', $header)]) ? $loan->phone = $data[array_search('Phone', $header)] : '';
                $loan->updated_on = date('Y-m-d h:i:s');
                $loan->updated_by = $user->user_enc_id;
                if (!$loan->save()) {
                    $transaction->rollBack();
                    print_r($loan->getErrors());
                    print_r($data);
                    exit();
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

            $document = UploadedFile::getInstanceByName('document');
            if ($document) {
                $documents = Yii::$app->getSecurity()->generateRandomString() . '.' . $document->extension;
                $documents_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->payment_issues->image . $documents_location;

                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($document->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $documents, "public", ['params' => ['contentType' => $document->type]]);

                $Payment_issues->image = $documents;
                $Payment_issues->image_location = $documents_location;
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
        $data = EmiPaymentIssues::find()
            ->alias('a')
            ->joinWith(['createdBy b'])
            ->andWhere(['a.is_deleted' => 0, 'a.loan_account_enc_id' => $params['loan_account_enc_id']])
            ->asArray()
            ->all();

        $res = [];
        $issues = [
            '1' => 'Legal', '2' => 'Accident', '3' => 'Health'
        ];

        foreach ($data as $datam) {
            $reason = $datam['reasons'];
            $pay_issues = !empty($issues[$reason]) ? $issues[$reason] : null;
            $createdByName = $datam['createdBy']['first_name'] . ' ' . $datam['createdBy']['last_name'];
            $createdByImage = $datam['createdBy'];
            if ($createdByImage['image']) {
                $createdByImage = Yii::$app->params->digitalOcean->baseUrl .
                    Yii::$app->params->digitalOcean->rootDirectory .
                    Yii::$app->params->upload_directories->users->image .
                    $createdByImage['image_location'] . '/' . $createdByImage['image'];
            } else {
                $createdByImage = 'https://ui-avatars.com/api/?name=' .
                    urlencode($createdByImage['first_name'] . ' ' . $createdByImage['last_name']) .
                    '&size=200&rounded=true&background=' .
                    str_replace('#', '', $createdByImage['initials_color']) .
                    '&color=ffffff';
            }
            if (!empty($datam['image'])) {
                $user_image = Yii::$app->params->digitalOcean->baseUrl .
                    Yii::$app->params->digitalOcean->rootDirectory .
                    Yii::$app->params->upload_directories->payment_issues->image .
                    $datam['image_location'] . '/' . $datam['image'];
            } else {
                $user_image = '';
            }

            $res[] = [
                'emi_payment_issues_enc_id' => $datam['emi_payment_issues_enc_id'],
                'loan_account_enc_id' => $datam['loan_account_enc_id'],
                'created_by' => $createdByName,
                'created_on' => $datam['created_on'],
                'remarks' => $datam['remarks'],
                'user_image' => $createdByImage,
                'image' => $user_image,
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
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $payment_methods = EmiCollectionForm::$payment_methods;
        $payment_modes = EmiCollectionForm::$payment_modes;
        $model = EmiCollection::find()
            ->alias('a')
            ->select([
                'a.customer_name', 'a.collection_date', 'a.amount', 'a.emi_payment_method', 'a.emi_payment_mode', 'CONCAT(b.first_name , " ", b.last_name) as collected_by',
                'CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ",",a.other_delay_reason) ELSE a.delay_reason END AS delay_reason',
                'CASE WHEN b.image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . '",b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(b.first_name," ",b.last_name), "&size=200&rounded=true&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image',
                'CASE WHEN a.pr_receipt_image IS NOT NULL THEN CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . '",a.pr_receipt_image_location, "/", a.pr_receipt_image) ELSE NULL END as pr_receipt_image',
                'CASE WHEN a.other_doc_image IS NOT NULL THEN CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . '",a.other_doc_image_location, "/", a.other_doc_image) ELSE NULL END as other_doc_image',
                'CASE WHEN a.borrower_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . '",a.borrower_image_location, "/", a.borrower_image) ELSE NULL END as borrower_image',
                'a.created_on', 'a.emi_payment_status', 'a.reference_number', 'a.ptp_amount', 'a.ptp_date'
            ])
            ->joinWith(['createdBy b'], false)
            ->andWhere(['a.is_deleted' => 0, 'created_by' => $lac['created_by'], 'loan_account_number' => $lac['loan_account_number']]);

        $count = $model->count();
        $model = $model
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($model as $key => $value) {
            $model[$key]['emi_payment_method'] = $payment_methods[$value['emi_payment_method']];
            $model[$key]['emi_payment_mode'] = $payment_modes[$value['emi_payment_mode']];
            if ($value['other_doc_image']) {
                $proof = $my_space->signedURL($value['other_doc_image'], "15 minutes");
                $model[$key]['other_doc_image'] = $proof;
            }
            if ($value['borrower_image']) {
                $proof = $my_space->signedURL($value['borrower_image'], "15 minutes");
                $model[$key]['borrower_image'] = $proof;
            }
            if ($value['pr_receipt_image']) {
                $proof = $my_space->signedURL($value['pr_receipt_image'], "15 minutes");
                $model[$key]['pr_receipt_image'] = $proof;
            }
        }
        return ['data' => $model, 'count' => $count];
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
        $data = VehicleRepossession::find()
            ->alias('a')
            ->select(['a.vehicle_repossession_enc_id', 'a.loan_account_enc_id', 'a.vehicle_model', 'a.km_driven',
                '(CASE WHEN a.insurance = "1" THEN "yes" ELSE "no" END) AS insurance',
                '(CASE WHEN a.rc = "1" THEN "yes" ELSE "no" END) AS rc', 'a.registration_number', 'a.current_market_value',
                'a.repossession_date', 'b.loan_account_number'])
            ->joinWith(['loanAccountEnc b'], false)
            ->andWhere(['a.is_deleted' => 0]);


        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'registration_number' || $key == 'repossession_date') {
                        $data->andWhere(['a.' . $key => $value]);
                    } elseif ($key == 'loan_account_number') {
                        $data->andWhere(['b.' . $key => $value]);
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

        if (empty($params['vehicle_repossession_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "vehicle_repossession_enc_id']);
        }

        $data = VehicleRepossessionImages::find()
            ->alias('a')
            ->andWhere(['a.is_deleted' => 0, 'a.vehicle_repossession_enc_id' => $params['vehicle_repossession_enc_id']])
            ->joinWith(['vehicleRepossessionEnc b' => function ($b) {
                $b->joinWith(['loanAccountEnc b1']);
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
                'vehicle_repossession_enc_id' => $params['vehicle_repossession_enc_id'],
                'vehicle_model' => $datam['vehicleRepossessionEnc']['vehicle_model'],
                'loan_account_number' => $datam['vehicleRepossessionEnc']['loanAccountEnc']['loan_account_number'],
                'km_driven' => $datam['vehicleRepossessionEnc']['km_driven'],
                'registration_number' => $datam['vehicleRepossessionEnc']['registration_number'],
                'current_market_value' => $datam['vehicleRepossessionEnc']['current_market_value'],
                'repossession_date' => $datam['vehicleRepossessionEnc']['repossession_date'],
                'insurance' => ($datam['vehicleRepossessionEnc']['repossession_date'] == 1) ? 'yes' : 'no',
                'rc' => ($datam['vehicleRepossessionEnc']['repossession_date'] == 1) ? 'yes' : 'no',
                'images' => $images,
            ],
        ];

        if (!empty($images['front']) || !empty($images['back']) || !empty($images['left']) || !empty($images['right'])) {
            return $this->response(200, $result);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }
}