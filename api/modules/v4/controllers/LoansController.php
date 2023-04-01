<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\BusinessLoanApplication;
use api\modules\v4\models\CoApplicantFrom;
use common\models\AssignedLoanProvider;
use common\models\BillDetails;
use common\models\CertificateTypes;
use common\models\EsignAgreementDetails;
use common\models\EsignDocumentsTemplates;
use common\models\EsignRequestedAgreements;
use common\models\EsignVehicleLoanDetails;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\EducationLoanPaymentsExtends;
use common\models\extended\LoanApplicantResidentialInfoExtended;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\LoanCertificatesExtended;
use common\models\extended\LoanCoApplicantsExtended;
use common\models\extended\LoanVerificationLocationsExtended;
use common\models\FinancerLoanNegativeLocation;
use common\models\LeadsApplications;
use common\models\LoanAuditTrail;
use common\models\LoanCertificates;
use common\models\LoanCoApplicants;
use common\models\LoanVerificationLocations;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\spaces\Spaces;
use common\models\Users;
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
                'update-loan-amounts' => ['POST', 'OPTIONS'],
                'remove-loan-application' => ['POST', 'OPTIONS'],
                'add-verification-location' => ['POST', 'OPTIONS'],
                'add-co-applicant' => ['POST', 'OPTIONS'],
                'audit-trail-list' => ['POST', 'OPTIONS'],
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
                $user_id = $this->isAuthorized();
                if (!empty($user_id)) {
                    $user_id = $user_id->user_enc_id;
                } else {
                    $user_id = NULL;
                }


                if ($user = $this->isAuthorized()) {
                    $lender = $this->getFinancerId($user);
                    if ($lender != null) {
                        $model->loan_lender = $lender;
                    }
                }

                if (!empty($model->ref_id)) {
                    $referralData = Referral::findOne(['code' => $model->ref_id]);
                    if ($referralData) {

                        $user_obj = null;
                        if ($referralData['user_enc_id'] != null) {
                            $user_obj = Users::findOne(['user_enc_id' => $referralData['user_enc_id']]);
                        } elseif ($referralData['organization_enc_id'] != null) {
                            $user_obj = Users::findOne(['organization_enc_id' => $referralData['organization_enc_id']]);
                        }

                        if ($user_obj != null) {
                            $lender = $this->getFinancerId($user_obj);
                            if ($lender != null) {
                                $model->loan_lender = $lender;
                            }
                        }

                    }
                }

                $resposne = $model->save($user_id);
                if (isset($resposne['status']) && $resposne['status'] == true) {
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
            $loan_application = LoanApplicationsExtended::find()
                ->where(['loan_app_enc_id' => $loan_app_id])
                ->one();
            if ($loan_application) {
                $loan_application->status = 0;
                $loan_application->updated_by = null;
                $loan_application->updated_on = date('Y-m-d H:i:s');
                $loan_application->update();
            }
        }

        $loan_payments = EducationLoanPaymentsExtends::find()
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
        $loan_payment = EducationLoanPaymentsExtends::findOne(['payment_token' => $plink_id]);
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
        $docs = EsignDocumentsTemplates::find()
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

            if (empty($params['assigned_to'])) {
                $params['assigned_to'] = 1;
            }

            $file = UploadedFile::getInstanceByName('file');

            if (!$type_id = $this->getCertificateTypeId($params['document_type'], $params['assigned_to'])) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
            }
            $utilitiesModel = new Utilities();
            $certificate = new LoanCertificatesExtended();
            $certificate->certificate_enc_id = \Yii::$app->getSecurity()->generateRandomString();
            $certificate->loan_app_enc_id = $params['loan_id'];
            $certificate->certificate_type_enc_id = $type_id;
            if (!empty($params['proof_of'])) {
                $certificate->proof_of = $params['proof_of'];
            }
            if (!empty($params['financer_loan_document_enc_id'])) {
                $certificate->financer_loan_document_enc_id = $params['financer_loan_document_enc_id'];
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

            $application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['id']]);

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

            $provider = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $params['id'], 'provider_enc_id' => $params['parent_id']]);

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

    public function actionUpdateLoanAmounts()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            $provider_id = $this->getFinancerId($user);
            if ($provider_id == null) {
                return $this->response(409, ['status' => 409, 'message' => 'provider id not found']);
            }
            // provider_id
            // id = field name
            // value = field value
            // parent_id = loan_id
            if (empty($params['parent_id']) || empty($params['id']) || empty($params['value'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "parent_id, org_id, id, value"']);
            }

            $provider = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $params['parent_id'], 'provider_enc_id' => $provider_id]);

            if (!$provider) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $field = $params['id'];
            $provider->$field = $params['value'];
            $provider->updated_by = $user->user_enc_id;
            $provider->updated_on = date('Y-m-d H:i:s');
            if (!$provider->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $provider->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveLoanApplication()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            $loan_app = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['loan_id']]);

            $loan_app->is_deleted = 1;
            $loan_app->updated_by = $user->user_enc_id;
            $loan_app->updated_on = date('Y-m-d H:i:s');
            if (!$loan_app->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddVerificationLocation()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            $verification_location = new LoanVerificationLocationsExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $verification_location->loan_verification_enc_id = $utilitiesModel->encrypt();
            $verification_location->loan_app_enc_id = $params['loan_id'];
            (!empty($params['location_name'])) ? $verification_location->location_name = $params['location_name'] : null;
            (!empty($params['local_address'])) ? $verification_location->local_address = $params['local_address'] : null;
            (!empty($params['latitude'])) ? $verification_location->latitude = $params['latitude'] : null;
            (!empty($params['longitude'])) ? $verification_location->longitude = $params['longitude'] : null;
            $verification_location->created_by = $user->user_enc_id;
            $verification_location->created_on = date('Y-m-d H:i:s');
            if (!$verification_location->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $verification_location->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddCoApplicant()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            $model = new CoApplicantFrom();

            if ($model->load(Yii::$app->request->post(), '')) {

                if ($model->validate()) {
                    if (!empty($params['loan_co_app_enc_id'])) {
                        $co_applicant = $model->update($params['loan_co_app_enc_id'], $user->user_enc_id);
                    } else {
                        $co_applicant = $model->save($params['loan_id'], $user->user_enc_id);
                    }
                    if ($co_applicant['status'] == 500) {
                        return $this->response(500, $co_applicant);
                    }
                    return $this->response(200, $co_applicant);
                } else {
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAuditTrailList()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            $limit = 10;
            $page = 1;

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (!empty($params['limit'])) {
                $limit = $params['limit'];
            }

            if (!empty($params['page'])) {
                $page = $params['page'];
            }

            $audit = LoanAuditTrail::find()
                ->alias('a')
                ->select(['a.old_value', 'a.new_value', 'a.action', 'a.field', 'a.stamp', 'CONCAT(b.first_name," ",b.last_name) created_by'])
                ->joinWith(['user b'], false)
                ->where(['a.loan_id' => $params['loan_id']])
                ->andWhere(['not', ['a.field' => ['', 'created_by', 'created_on', 'id', 'proof_image', 'proof_image_location', null]]])
                ->andWhere(['not like', 'a.field', '%_enc_id%', false])
                ->andWhere(['not like', 'a.field', '%updated_on%', false])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->orderBy(['a.stamp' => SORT_DESC])
                ->asArray()
                ->all();

            if ($audit) {
                return $this->response(200, ['status' => 200, 'audit_list' => $audit]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCreateFinancerLoanNegativeLocation()
    {

        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $lender = $this->getFinancerId($user);
            if ($lender == null) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "financer id not found"']);
            }
            if (empty($params['local_address'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "local_address"']);
            }
            if (empty($params['radius'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "radius"']);
            }
            if (empty($params['latitude'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "latitude"']);
            }
            if (empty($params['longitude'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "longitude"']);
            }

            $model = new FinancerLoanNegativeLocation();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->negative_location_enc_id = $utilitiesModel->encrypt();
            $model->financer_enc_id = $lender;
            $model->user_enc_id = $user->user_enc_id;
            $model->address = $params['local_address'];
            $model->radius = $params['radius'];
            $model->latitude = $params['latitude'];
            $model->longitude = $params['longitude'];
            if (!empty($params['status'])) {
                $model->status = $params['status'];
            }
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $user->user_enc_id;

            if (!$model->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'saved successfully']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionGetFinancerLoanNegativeLocation()
    {
        if ($user = $this->isAuthorized()) {
            $query = FinancerLoanNegativeLocation::find()
                ->alias('a')
                ->select(['a.negative_location_enc_id', 'CONCAT(b.first_name, " ", b.last_name) AS name', 'a.address', 'a.radius', 'a.latitude', 'a.longitude', 'a.status', 'a.created_by', 'a.created_on'])
                ->joinWith(['userEnc b'], false)
                ->andWhere(['a.is_deleted' => 0, 'a.created_by' => $user->user_enc_id])
                ->asArray()
                ->all();
            if ($query) {
                return $this->response(200, ['status' => 200, 'data' => $query]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionUpdateFinancerLoanNegativeLocation()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['negative_location_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "negative_location_enc_id"']);
            }

            $query = FinancerLoanNegativeLocation::findOne(['negative_location_enc_id' => $params['negative_location_enc_id']]);

            if (!empty($params['is_deleted'])) {
                $query->is_deleted = $params['is_deleted'];
            } else if (!empty($params['status'])) {
                $query->status = $params['status'];
            }

            $query->updated_by = $user->user_enc_id;
            $query->updated_on = date('Y-m-d H:i:s');

            if ($query->update()) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Updated successfully.',
                ]);
            } else {
                return $this->response(500, [
                    'status' => 500,
                    'title' => 'Error',
                    'message' => 'An error has occurred while updating. Please try again.',
                ]);
            }

        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

}