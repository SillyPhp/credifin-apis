<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\models\VehicleRepoForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\AssignedLoanAccounts;
use common\models\EmiCollection;
use common\models\extended\AssignedLoanAccountsExtended;
use common\models\extended\LoanAccountsExtended;
use common\models\LoanAccountComments;
use common\models\LoanAccountPtps;
use common\models\LoanAccounts;
use common\models\LoanActionComments;
use common\models\LoanActionRequests;
use common\models\LoanApplications;
use common\models\spaces\Spaces;
use common\models\UserRoles;
use common\models\Users;
use common\models\Utilities;
use common\models\VehicleRepoComments;
use common\models\VehicleRepossession;
use common\models\VehicleRepossessionImages;
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
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id"']);
        }
        $loan_ids = $params['loan_account_enc_id'];
        if (!empty($loan_ids)) {
            $data = (new \yii\db\Query())
                ->select([
                    "(CASE WHEN a.loan_account_number IS NOT NULL THEN a.loan_account_number ELSE a1.loan_account_number END) AS loan_account_number",
                    "COUNT(a1.loan_account_number) as total_emis", 'a.loan_account_enc_id', 'a.sales_target_date', 'a.telecaller_target_date', 'a.collection_target_date',
                    '(CASE WHEN a.name IS NOT NULL THEN a.name ELSE a1.customer_name END) as name',
                    '(CASE WHEN a.phone IS NOT NULL THEN a.phone ELSE a1.phone END) as phone',
                    '(CASE WHEN a.emi_amount IS NOT NULL THEN a.emi_amount ELSE a1.amount END) as emi_amount',
                    'a.overdue_amount', 'a.ledger_amount', 'a.sales_priority', 'telecaller_priority', 'a.collection_priority', 'a.bucket',
                    '(CASE WHEN a.loan_type IS NOT NULL THEN a.loan_type ELSE a1.loan_type END) AS loan_type',
                    'a.emi_date', 'a.created_on', 'a.last_emi_received_amount', 'a.last_emi_received_date',
                    'COALESCE(SUM(a.ledger_amount), 0) + COALESCE(SUM(a.overdue_amount), 0) AS total_pending_amount',
                ])
                ->from(['a' => LoanAccounts::tableName()],)
                ->join('LEFT JOIN', ['a1' => EmiCollection::tableName()], 'a1.loan_account_enc_id = a.loan_account_enc_id')
                ->where(['a.loan_account_enc_id' => $loan_ids])
                ->groupBy(['a1.loan_type', 'a1.customer_name', 'a1.phone', 'a1.amount', 'a1.loan_account_number'])
                ->one();
        } else {
            $data = (new \yii\db\Query())
                ->select([
                    "a1.loan_account_number",
                    "COUNT(a1.loan_account_number) as total_emis", 'a1.customer_name as name',
                    'a1.phone',
                    'a1.amount as emi_amount',
                    'a1.loan_type',
                ])
                ->from(['a1' => EmiCollection::tableName()],)
                ->where(['a1.loan_account_number' => $loan_ids])
                ->groupBy(['a1.loan_type', 'a1.customer_name', 'a1.phone', 'a1.amount', 'a1.loan_account_number'])
                ->one();
        };

        if ($loan_ids) {
            $lac = LoanAccounts::findOne(['loan_account_enc_id' => $loan_ids]);
        } else {
            $lac = EmiCollection::findOne(['loan_account_number' => $params['loan_account_number']]);
        };
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
            ->andWhere(['a.is_deleted' => 0, 'loan_account_number' => $lac['loan_account_number']]);
        $count = $model->count();
        $model = $model
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->orderBy(['created_on' => SORT_DESC])
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
            $utilitiesModel = new \common\models\Utilities();
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
        $utilitiesModel = new \common\models\Utilities();
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
        $where = ['a.is_deleted' => 0];
        if (!empty($params['bucketVal'])) {
            $where['bucket'] = $params['bucketVal'];
        }
        if (!empty($params['fields_search'])) {
            $fields_search = $params['fields_search'];
            foreach ($fields_search as $key => $value) {
                if (!empty($value)) {

                    switch ($key) {
                        case 'branch':
                            $where['a.branch_enc_id'] = $value;
                            break;
                        case 'loan_type':
                            $where['a.loan_type'] = $value;
                            break;
                    }
                }
            }
        }
        $bucket = LoanAccountsExtended::find()
            ->alias('a')
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
            ->where($where);
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
        $bucket = $bucket->asArray()->one();
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
                "a.ptp_enc_id", "a.emi_collection_enc_id", "a.proposed_payment_method", "a.proposed_date",
                "a.proposed_amount", "a.status", "a.collection_manager as collection_manager_enc_id", "b.loan_account_enc_id",
                "b.loan_account_number", "c.total_installments", "c.financed_amount", "c.stock", "c.last_emi_received_date",
                "c.last_emi_date", "(CASE WHEN c.name IS NOT NULL THEN c.name ELSE b.customer_name END) AS name",
                "c.emi_amount", "c.overdue_amount", "c.ledger_amount",
                "(CASE WHEN c.loan_type IS NOT NULL THEN c.loan_type ELSE b.loan_type END) AS loan_type",
                "c.emi_date", "c.last_emi_received_amount", "c.advance_interest", "c.bucket",
                "(CASE WHEN c.branch_enc_id IS NOT NULL THEN c.branch_enc_id ELSE b.branch_enc_id END) AS branch_enc_id",
                "c.bucket_status_date", "c.pos", "bb.location_enc_id as branch", "bb.location_name as branch_name",
                "CONCAT(cm.first_name, ' ', COALESCE(cm.last_name, '')) as collection_manager",
                "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, '')) as assigned_caller",
                "COALESCE(SUM(c.ledger_amount), 0) + COALESCE(SUM(c.overdue_amount), 0) AS total_pending_amount",
                "a.created_by"
            ])
            ->innerJoinWith(['emiCollectionEnc b' => function ($b) {
                $b->innerJoinWith(['loanAccountEnc c' => function ($cc) {
                    $cc->joinWith(['assignedLoanAccounts ala' => function ($ala) {
                        $ala->joinWith(['sharedTo d1']);
                        $ala->andOnCondition(['ala.is_deleted' => 0]);
                    }]);
                    $cc->joinWith(['branchEnc d'], false);
                    $cc->joinWith(["assignedCaller ac"], false);
                }]);
                $b->joinWith(['branchEnc bb'], false);
            }])
            ->joinWith(['collectionManager cm'], false);
        if (isset($params['type']) && $params['type'] == 'dashboad') {
            $ptpcases->andWhere(['between', 'a.proposed_date', date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime('+3 days'))]);
        } else {
            $ptpcases->where(['>=', 'a.proposed_date', date('Y-m-d H:i:s')]);
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
                    if ($key == 'assigned_caller') {
                        $ptpcases->andWhere(["like", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, ''))", "%$value%", false]);
                    } elseif ($key == 'loan_account_number') {
                        $ptpcases->andWhere(['b.' . $key => $value]);
                    } elseif ($key == 'bucket') {
                        $ptpcases->andWhere(['IN', 'c.bucket', $value]);
                    } elseif ($key == 'loan_type') {
                        $ptpcases->andWhere(['IN', 'c.loan_type', $value]);
                    } elseif ($key == 'branch') {
                        $ptpcases->andWhere(['IN', 'bb.location_enc_id', $value]);
                    } elseif ($key == 'total_pending_amount') {
                        $ptpcases->having(['=', "COALESCE(SUM(c.ledger_amount), 0) + COALESCE(SUM(c.overdue_amount), 0)", $value]);
                    } elseif ($key == 'collection_manager') {
                        $ptpcases->andWhere(["LIKE", "CONCAT(cm.first_name, ' ', COALESCE(cm.last_name, ''))", "$value%", false]);
                    } elseif ($key == 'proposed_amount') {
                        $ptpcases->andWhere(["LIKE", 'a.' . $key, "$value%", false]);
                    } elseif ($key == 'pos') {
                        $ptpcases->andWhere(["LIKE", 'c.' . $key, $value]);
                    } elseif ($key == 'sharedTo') {
                        $ptpcases->andWhere(['like', "CONCAT(d1.first_name, ' ', COALESCE(d1.last_name, ''))", $value]);
                    } elseif ($key == 'proposed_date') {
                        $ptpcases->andWhere(["LIKE", 'a.' . $key, $value]);
                    } elseif ($key == 'proposed_payment_method') {
                        $ptpcases->andWhere(['a.' . $key => $value]);
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
            return $this->response(200, ['status' => 200, 'count' => $count, 'ptpcases' => $ptpcases]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
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
                    'a.loan_account_enc_id', 'a.loan_account_number', 'a.name', 'a.phone',
                    'a.emi_amount', 'a.overdue_amount', 'a.ledger_amount', 'a.loan_type', 'a.emi_date'
                ])
                ->where(['a.is_deleted' => 0])
                ->andWhere(['a.loan_account_number' => $loan_number['loan_account_number']])
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

            $priority_types = ['telecaller_priority', 'collection_priority', 'sales_priority',
                'sales_target_date', 'telecaller_target_date', 'collection_target_date'];

            foreach ($priority_types as $type) {
                if (isset($params[$type])) {
                    $priority->$type = $params[$type];
                }
            }

            $priority->updated_by = $user->user_enc_id;
            $priority->updated_on = date('Y-m-d H:i:s');

            if (!$priority->save()) {
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
                    $loan = LoanAccounts::find()->where($where);
                    $raw = $loan->createCommand()->getRawSql();
                    $loan = $loan->one();
                    if (!$loan) {
                        $new = true;
                        $loan = new LoanAccounts();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000000);
                        $loan->loan_account_enc_id = $utilitiesModel->encrypt();
                        $loan->lms_loan_account_number = $lms_loan_account_number;
                        $loan->case_no = $case_no;
                        $loan->loan_account_number = $loan_account_number;
                        $loan->created_on = date('Y-m-d h:i:s');
                        $loan->created_by = $user->user_enc_id;
                        $new_cases++;
                    } else {
                        $old_cases++;
                    }
                    $loan->updated_on = date('Y-m-d h:i:s');
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

            if (!$branch->save()) {
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

            if (!$branch->save()) {
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

            if (!$target_date->save()) {
                throw new Exception(implode(" ", array_column($target_date->getErrors(), '0')));
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Added Successfully']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

}