<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\BusinessLoanApplication;
use common\models\AssignedLoanProvider;
use common\models\BillDetails;
use common\models\CertificateTypes;
use common\models\EsignAgreementDetails;
use common\models\EsignDocuments;
use common\models\EsignRequestedAgreements;
use common\models\EsignVehicleLoanDetails;
use common\models\LeadsApplications;
use common\models\LoanCertificates;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\spaces\Spaces;
use common\models\Utilities;
use yii\web\UploadedFile;
use api\modules\v4\models\LoanApplication;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use yii\filters\VerbFilter;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

class LoansController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'loan-application' => ['POST', 'OPTIONS'],
                'update-payment-status' => ['POST', 'OPTIONS'],
                'update-payment-link-status' => ['POST', 'OPTIONS'],
                'contact-us' => ['POST', 'OPTIONS'],
                'detail' => ['POST', 'OPTIONS'],
                'authorize-esign' => ['POST', 'OPTIONS'],
                'get-esign-applications' => ['POST', 'OPTIONS'],
                'get-documents' => ['POST', 'OPTIONS'],
                'get-document-url' => ['POST', 'OPTIONS'],
                'upload-document' => ['POST', 'OPTIONS'],
                'update-application-number' => ['POST', 'OPTIONS'],
                'add-loan-branch' => ['POST', 'OPTIONS'],
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

    public function actionLoanApplication()
    {
        $model = new LoanApplication();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstanceByName('bill');
            if ($model->validate()) {
                $user_id = $this->isAuthorized()->user_enc_id;
                if (!$user_id) {
                    $user_id = NULL;
                }
                $resposne = $model->save($user_id);
                if ($resposne['status']) {
                    return $this->response(200, ['status' => 200, 'data' => $resposne['data']]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
            }
        } else {
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        }
    }

    public function actionUpdatePaymentStatus()
    {
        $params = Yii::$app->request->post();

        if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
            $loan_app_id = $params['loan_app_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_id"']);
        }

        if (isset($params['loan_payment_id']) && !empty($params['loan_payment_id'])) {
            $loan_payment_id = $params['loan_payment_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_payment_id"']);
        }

        if ($params['status'] == 'captured') {
            $loan_application = LoanApplications::find()
                ->where(['loan_app_enc_id' => $loan_app_id])
                ->one();
            if ($loan_application) {
                $loan_application->status = 0;
                $loan_application->updated_by = null;
                $loan_application->updated_on = date('Y-m-d H:i:s');
                $loan_application->update();
            }
        }

        $loan_payments = EducationLoanPayments::find()
            ->where(['education_loan_payment_enc_id' => $loan_payment_id])
            ->one();
        if ($loan_payments) {
            $loan_payments->payment_id = (($params['payment_id']) ? $params['payment_id'] : null);
            $loan_payments->payment_status = $params['status'];
            $loan_payments->payment_signature = $params['signature'];
            $loan_payments->updated_by = null;
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            $loan_payments->update();
        }
        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionContactUs()
    {
        $params = Yii::$app->request->post();

        $model = new LeadsApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->application_enc_id = $utilitiesModel->encrypt();
        $model->application_number = date('ymd') . time();
        $model->source = 'Empower Loans';
        $model->first_name = $params['first_name'];
        $model->last_name = $params['last_name'];
        $model->student_mobile_number = $params['phone'];
        $model->student_email = $params['email'];
        $model->message = $params['message'];
        if (!$model->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
        }


        return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'id' => $model->application_enc_id]);

    }

    public function actionUpdatePaymentLinkStatus()
    {
        $params = Yii::$app->request->post();

        $razorpay_payment_id = $params['razorpay_payment_id'];
        $razorpay_payment_link_id = $params['razorpay_payment_link_id'];
        $razorpay_signature = $params['razorpay_signature'];

        $api_key = Yii::$app->params->razorPay->prod->apiKey;
        $api_secret = Yii::$app->params->razorPay->prod->apiSecret;

        $api = new Api($api_key, $api_secret);

        if ($razorpay_payment_id) {
            try {
                $payment = $api->payment->fetch($razorpay_payment_id);
            } catch (Exception $e) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred, Please Contact The Support Team..']);
            }

            if ($payment) {
                if ($payment->captured == 1) {
                    if ($this->savePaymentStatus($razorpay_payment_id, $payment->status, $razorpay_payment_link_id, $razorpay_signature)) {
                        return $this->response(200, ['status' => 200, 'message' => 'payment successfully captured']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred, Please Contact The Support Team..']);
                    }
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'Payment Status Not Found, Please Contact The Support Team..']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Payment Status Not Found, Please Contact The Support Team..']);
            }
        }

        return $this->response(400, ['status' => 400, 'message' => 'bad request']);

    }

    private function savePaymentStatus($payment_id, $status, $plink_id, $signature)
    {
        $loan_payment = EducationLoanPayments::findOne(['payment_token' => $plink_id]);
        $loan_payment->payment_status = $status;
        $loan_payment->payment_id = $payment_id;
        $loan_payment->payment_signature = $signature;
        if ($loan_payment->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function actionDetail()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            $detail = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'a.applicant_name', 'a.loan_type', 'a.status', 'a.phone', 'a.email', 'a.amount',
                    'a.yearly_income', 'b.desired_tenure', 'b.name_of_company', 'b.type_of_company',
                    'b.nature_of_business', 'b.annual_turnover', 'b1.designation', 'b.business_premises',
                    'b.occupation', 'b.vehicle_type', 'b.vehicle_option'
                ])
                ->joinWith(['loanApplicationOptions b' => function ($b) {
                    $b->joinWith(['designation0 b1']);
                }], false)
                ->where(['a.id' => $params['loan_id'], 'a.is_deleted' => 0, 'a.source' => 'EmpowerFintech', 'a.created_by' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($detail) {
                return $this->response(200, ['status' => 200, 'detail' => $detail]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdate()
    {
        $params = Yii::$app->request->post();

        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
        }

        $loan_app = LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id'], 'is_deleted' => 0]);

        if ($loan_app) {

            $model = new LoanApplication();

            $model->applicant_name = $loan_app->applicant_name;
            $model->phone_no = $loan_app->phone;
            $model->loan_type = $loan_app->loan_type;

            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

                if ($model->validate()) {

                    $user_id = $this->isAuthorized()->user_enc_id;
                    if (!$user_id) {
                        $user_id = NULL;
                    }
                    $resposne = $model->update($params['loan_id'], $user_id);
                    if ($resposne['status']) {
                        return $this->response(200, ['status' => 200, 'data' => $resposne['data']]);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
                    }
                } else {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
                }
            } else {
                return $this->response(400, ['status' => 400, 'message' => 'bad request']);
            }

        }

        return $this->response(404, ['status' => 404, 'message' => 'loan application not found']);
    }

    private function authorizeEsign()
    {
        if ($user = $this->isAuthorized()) {

            if ($user->organization_enc_id) {
                return ['status' => 200, 'org_id' => $user->organization_enc_id];
            }

            $ref_enc_id = ReferralSignUpTracking::findOne(['sign_up_user_enc_id' => $user->user_enc_id])->referral_enc_id;

            if ($ref_enc_id) {

                $org_id = Referral::findOne(['referral_enc_id' => $ref_enc_id])->organization_enc_id;

                if ($org_id) {
                    return ['status' => 200, 'org_id' => $org_id];
                }
            }

            return ['status' => 404];
        }

        return ['status' => 401];
    }

    public function actionGetEsignApplications()
    {
        $data = $this->authorizeEsign();

        if ($data['status'] == 200) {

            $params = Yii::$app->request->post();

            $page = 1;
            $limit = 10;

            if (!empty($params['limit'])) {
                $limit = $params['limit'];
            }

            if (!empty($params['page'])) {
                $page = $params['page'];
            }

            $model = EsignAgreementDetails::find()
                ->alias('z')
                ->select(['z.*'])
                ->joinWith(['esignVehicleLoanDetails a'])
                ->joinWith(['esignBorrowerDetails b']);

            if (!empty($params['search_keyword'])) {
                $model->andWhere([
                    'or',
                    ['like', 'z.agreement_id', $params['search_keyword']],
                    ['like', 'z.loan_type', $params['search_keyword']],
                    ['like', 'z.phone', $params['search_keyword']],
                    ['like', 'z.aadhaar_number', $params['search_keyword']],
                    ['like', 'z.case_no', $params['search_keyword']],
                    ['like', 'z.employee_enc_id', $params['search_keyword']],
                    ['like', 'z.data_mode', $params['search_keyword']],
                    ['like', 'z.date_created', $params['search_keyword']]
                ]);
            }

            $model = $model->andWhere(['z.organization_id' => $data['org_id']])
                ->orderBy(['z.date_created' => SORT_DESC])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($model) {

                foreach ($model as $key => $val) {
                    $model[$key]['doc_files'] = $this->getDocuments();
                    $model[$key]['agreements'] = $this->getRequestAgreement($val['agreement_id']);
                }

                return $this->response(200, ['status' => 200, 'data' => $model]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getDocuments()
    {
        $docs = EsignDocuments::find()
            ->select(['doc_id', 'name', 'file_url'])
            ->asArray()
            ->all();

        return $docs;
    }

    private function getRequestAgreement($agreement_id)
    {
        $agreements = EsignRequestedAgreements::find()
            ->alias('a')
            ->select(['a.request_id', 'a.agreement_id'])
            ->joinWith(['esignRequestedAgreementsDetails b' => function ($b) {
                $b->select(['b.signer_id', 'b.request_id', 'b.name', 'b.phone', 'b.active', 'b.private_url', 'b.auth_type', 'b.auth_method', 'b.is_signed', 'b.expiryDate']);
            }])
            ->where(['a.agreement_id' => $agreement_id])
            ->groupBy(['a.agreement_id'])
            ->asArray()
            ->all();

        return $agreements;
    }

    public function actionGetDocumentUrl()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['vehicle_loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "vehicle_loan_id"']);
            }

            if (empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "type"']);
            }

            $doc = EsignVehicleLoanDetails::findOne(['vehicle_loan_id' => $params['vehicle_loan_id']]);

            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);

            $url = '';
            if ($params['type'] == 'license' && $doc->driving_image_url) {
                $url = $my_space->signedURL($doc->driving_image_url, "15 minutes");
            } elseif ($params['type'] == 'chassi' && $doc->chassis_image_url) {
                $url = $my_space->signedURL($doc->chassis_image_url, "15 minutes");
            }

            if ($url) {
                return $this->response(200, ['status' => 200, 'url' => $url]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'file not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUploadDocument()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();


            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "loan_id"']);
            }
            if (empty($params['document_type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "document_type"']);
            }

            $file = UploadedFile::getInstanceByName('file');

            if (!$type_id = $this->getCertificateTypeId($params['document_type'], $params['assigned_to'])) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
            }
            $utilitiesModel = new Utilities();
            $certificate = new LoanCertificates();
            $certificate->certificate_enc_id = \Yii::$app->getSecurity()->generateRandomString();
            $certificate->loan_app_enc_id = $params['loan_id'];
            $certificate->certificate_type_enc_id = $type_id;
            if (!empty($params['proof_of'])) {
                $certificate->proof_of = $params['proof_of'];
            }
            $certificate->created_by = $user->user_enc_id;
            if (!empty($params['short_description'])) {
                $certificate->short_description = $params['short_description'];
            }
            $certificate->related_to = (int)$params['assigned_to'];
            $certificate->proof_image_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->loans->image . $certificate->proof_image_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            if ($file->extension == null || $file->extension == '') {
                $certificate->proof_image = $utilitiesModel->encrypt() . '.' . 'pdf';
            } else {
                $certificate->proof_image = $utilitiesModel->encrypt() . '.' . $file->extension;
            }
            $type = $file->type;
            if ($certificate->save()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $certificate->proof_image, "private", ['params' => ['ContentType' => $type]]);
                if ($result) {
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully Saved']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'Some Error Occurred']);
                }
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Some Error Occurred', 'error' => $certificate->getErrors()]);
            }
        }

    }

    private function getCertificateTypeId($type, $assigned_to)
    {
        $exists = CertificateTypes::findOne(['name' => $type]);
        if (!$exists) {
            $model = new CertificateTypes();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $model->certificate_type_enc_id = $utilitiesModel->encrypt();
            $model->name = $type;
            $model->assigned_to = (int)$assigned_to;
            if ($model->save()) {
                return $model->certificate_type_enc_id;
            }
            return false;
        }
        return $exists->certificate_type_enc_id;
    }

    public function actionUpdateApplicationNumber()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['value'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "value"']);
            }

            if (empty($params['id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "id"']);
            }

            $application = LoanApplications::findOne(['loan_app_enc_id' => $params['id']]);

            if ($application) {
                $application->application_number = $params['value'];
                $application->updated_by = $user->user_enc_id;
                $application->updated_on = date('Y-m-d H:i:s');
                if (!$application->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddLoanBranch()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            // id = loan_app_enc_id
            // value = branch_id
            // parent_id = provider_id
            if (empty($params['id']) || empty($params['value']) || empty($params['parent_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id, branch_id, provider_id"']);
            }

            $provider = AssignedLoanProvider::findOne(['loan_application_enc_id' => $params['id'], 'provider_enc_id' => $params['parent_id']]);

            $provider->branch_enc_id = $params['value'];
            $provider->updated_by = $user->user_enc_id;
            $provider->updated_on = date('Y-m-d H:i:d');
            if (!$provider->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $provider->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully added']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}