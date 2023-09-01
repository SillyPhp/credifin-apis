<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\BusinessLoanApplication;
use api\modules\v4\models\CoApplicantForm;
use api\modules\v4\models\LoanApplication;
use api\modules\v4\models\LoanPaymentsForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\CertificateTypes;
use common\models\CreditLoanApplicationReports;
use common\models\EsignAgreementDetails;
use common\models\EsignDocumentsTemplates;
use common\models\EsignRequestedAgreements;
use common\models\EsignVehicleLoanDetails;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\EducationLoanPaymentsExtends;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\LoanCertificatesExtended;
use common\models\extended\LoanPaymentsExtends;
use common\models\extended\LoanVerificationLocationsExtended;
use common\models\FinancerLoanNegativeLocation;
use common\models\LeadsApplications;
use common\models\LoanApplications;
use common\models\LoanAuditTrail;
use common\models\LoanPayments;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\spaces\Spaces;
use common\models\States;
use common\models\Users;
use common\models\Utilities;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

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
                'credit-reports' => ['POST', 'OPTIONS'],
                'update-loan' => ['POST', 'OPTIONS'],
                'credit-report' => ['POST', 'OPTIONS'],
                'check-number' => ['POST', 'OPTIONS'],
                'loan-update' => ['POST', 'OPTIONS']
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

    // saving loan application
    public function actionLoanApplication()
    {
        // creating Loan application object
        $model = new LoanApplication();

        // loading data into model object
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

            // validating request
            if ($model->validate()) {

                // checking user authorization
                $user = $this->isAuthorized();

                // if user logged-in then assigning user_enc_id else null
                $user_id = !empty($user) ? $user->user_enc_id : null;

                // if user logged-in
                if ($user) {

                    // getting financer/employer id from logged in user
                    $lender = $this->getFinancerId($user);

                    // if financer/lender not null then assigning to loan_lender
                    if ($lender != null) {
                        $model->loan_lender = $lender;
                    }
                }

                // if ref-id not empty getting financer/employer id from the referral code
                if (!empty($model->ref_id)) {

                    // getting user id from referral code
                    $referralData = Referral::findOne(['code' => $model->ref_id]);

                    if ($referralData) {

                        // getting user object from referral data user_enc_id or organization_enc_id
                        $user_obj = Users::findOne(['user_enc_id' => $referralData->user_enc_id, 'organization_enc_id' => $referralData->organization_enc_id]);

                        // if user exists
                        if (!empty($user_obj)) {

                            // getting financer/employer id
                            $lender = $this->getFinancerId($user_obj);

                            // if financer/lender not null then assigning to loan_lender
                            if ($lender != null) {
                                $model->loan_lender = $lender;
                            }
                        }
                    }
                }

                // saving loan application
                $response = $model->save($user_id);

                if ($response['status'] == 200) {
                    return $this->response(200, $response);
                } else {
                    return $this->response(500, $response);
                }

            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
            }
        } else {
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        }
    }

    public function actionUpdateLoan()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (!isset($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }

        $type = $params['type'] ?? 'capital';

        $loan_update = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['loan_app_enc_id']]);

        if ($type == 'capital') {

            // Validate capital_roi to be greater than 20
            if (!isset($params['capital_roi']) || floatval($params['capital_roi']) < 20) {
                return $this->response(422, ['status' => 422, 'message' => 'capital_roi should be greater than 20']);
            }

            if (is_null($loan_update->capital_roi)) {
                $loan_update->capital_roi = $params['capital_roi'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'cannot update']);
            }

            $loan_update->capital_roi_updated_on = date('Y-m-d H:i:s');
            $loan_update->capital_roi_updated_by = $user->user_enc_id;
        }
        if ($type == 'registry') {
            $loan_update->registry_status = 1;
            $loan_update->registry_status_updated_on = date('Y-m-d H:i:s');
            $loan_update->registry_status_updated_by = $user->user_enc_id;
        }

        if (!$loan_update->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_update->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully']);
    }


// updating payment status
    public function actionUpdatePaymentStatus()
    {
        $params = Yii::$app->request->post();

        if (empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_id"']);
        }

        if (empty($params['loan_payment_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_payment_id"']);
        }

        // status captured
        if ($params['status'] == 'captured') {

            // getting loan_application object form loan_app_id
            $loan_application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['loan_app_id']]);

            // updating data
            if ($loan_application) {
                $loan_application->status = 0;
                $loan_application->updated_by = null;
                $loan_application->updated_on = date('Y-m-d H:i:s');
                if (!$loan_application->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_application->getErrors()]);
                }
            }
        }

        // getting loan payments object
        $loan_payments = EducationLoanPaymentsExtends::findOne(['education_loan_payment_enc_id' => $params['loan_payment_id']]);

        // updating loan payments data
        if ($loan_payments) {
            $loan_payments->payment_id = (!empty($params['payment_id']) ? $params['payment_id'] : null);
            $loan_payments->payment_status = $params['status'];
            $loan_payments->payment_signature = $params['signature'];
            $loan_payments->updated_by = null;
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            if (!$loan_payments->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_payments->getErrors()]);
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
    }

    // contact us leads
    public function actionContactUs()
    {
        // getting params
        $params = Yii::$app->request->post();

        // saving leads
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
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'id' => $model->application_enc_id]);
    }

    // updating payment link status
    public function actionUpdatePaymentLinkStatus()
    {
        // getting request params
        $params = Yii::$app->request->post();
        $razorpay_payment_id = $params['razorpay_payment_id'];
        $razorpay_payment_link_id = $params['razorpay_payment_link_id'];
        $razorpay_signature = $params['razorpay_signature'];
        $model = LoanPayments::find()
            ->alias('a')
            ->select(['d.organization_enc_id org_id', 'e.organization_enc_id user_org_id'])
            ->where(['payment_token' => $razorpay_payment_link_id])
            ->joinWith(['assignedLoanPayments b' => function ($b) {
                $b->joinWith(['loanAppEnc c' => function ($c) {
                    $c->joinWith(['leadBy d' => function ($d) {
                        $d->joinWith(['userRoles0 e'], false);
                    }]);
                }], false);
            }], false)
            ->asArray()->one();
        if ($model) {
            if (isset($model['user_org_id']) || !empty($model['user_org_id'])) {
                $options['org_id'] = $model['user_org_id'];
            } else {
                $options['org_id'] = $model['org_id'];
            }
            $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
            if (!$keys) {
                return ['status' => 500, 'message' => 'an error occurred while fetching razorpay credentials'];
            }
            $api_key = $keys['api_key'];
            $api_secret = $keys['api_secret'];
            $api = new Api($api_key, $api_secret);
        } else {
            return ['status' => 500, 'message' => 'an error occurred while fetching razorpay credentials'];
        }
        // if not empty razorpay_payment_id
        if (!empty($params['razorpay_payment_id'])) {

            // trying to fetch payment data
            try {
                $payment = $api->payment->fetch($razorpay_payment_id);
            } catch (Exception $e) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred, Please Contact The Support Team..']);
            }

            // if data fetched successfully
            if ($payment) {

                // if payment status captured == 1 then saving payment status
                if ($payment->captured == 1) {

                    // saving payment status if data saved successfully
                    if ($this->savePaymentStatus($razorpay_payment_id, $payment->status, $razorpay_payment_link_id, $razorpay_signature)) {
                        return $this->response(200, ['status' => 200, 'message' => 'payment successfully captured']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred, Please Contact The Support Team...']);
                    }

                } else {
                    // if payment not captured
                    return $this->response(404, ['status' => 404, 'message' => 'Payment Status Not Found, Please Contact The Support Team..']);
                }
            } else {
                // if payment data not found
                return $this->response(404, ['status' => 404, 'message' => 'Payment Status Not Found, Please Contact The Support Team..']);
            }
        }

        return $this->response(400, ['status' => 400, 'message' => 'bad request']);

    }

    // saving payment status to loan payments
    private function savePaymentStatus($payment_id, $status, $plink_id, $signature)
    {
        $loan_payment = LoanPaymentsExtends::findOne(['payment_token' => $plink_id]);
        $loan_payment->payment_status = $status;
        $loan_payment->payment_id = $payment_id;
        $loan_payment->payment_signature = $signature;
        if ($loan_payment->save()) {
            return true;
        } else {
            return false;
        }
    }

    // getting detail of application
    public function actionDetail()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking loan_id if empty then sending missing information
            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            // getting detail
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

            // if not found
            return $this->response(404, ['status' => 404, 'message' => 'application not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // updating loan application
    public function actionUpdate()
    {
        $params = Yii::$app->request->post();

        // checking loan_id
        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
        }

        // getting loan application object
        $loan_app = LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id'], 'is_deleted' => 0]);


        if ($loan_app) {

            // creating loan application object
            $model = new LoanApplication();

            $model->applicant_name = $loan_app->applicant_name;
            $model->phone_no = $loan_app->phone;
            $model->loan_type = $loan_app->loan_type;

            // loading data to model
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

                // validating model
                if ($model->validate()) {

                    // checking if user authorized or not
                    $user = $this->isAuthorized();
                    $user_id = !empty($user) ? $user->user_enc_id : null;

                    $response = $model->update($params['loan_id'], $user_id);

                    if ($response['status'] == 200) {
                        return $this->response(200, $response);
                    } else {
                        return $this->response(500, $response);
                    }

                } else {
                    // if model not validated
                    return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
                }
            } else {

                // if there is no data in request
                return $this->response(400, ['status' => 400, 'message' => 'bad request']);
            }

        }

        return $this->response(404, ['status' => 404, 'message' => 'loan application not found']);
    }

    private function authorizeEsign()
    {
        // checking user authorization
        if ($user = $this->isAuthorized()) {

            // if it's organization then returning 200 with organization_enc_id
            if ($user->organization_enc_id) {
                return ['status' => 200, 'org_id' => $user->organization_enc_id];
            }

            // if it's user then getting referral_enc_id via referral signup tracking of this user
            $ref_enc_id = ReferralSignUpTracking::findOne(['sign_up_user_enc_id' => $user->user_enc_id]);

            // checking if referral_enc_id not empty
            if (!empty($ref_enc_id->referral_enc_id)) {

                // getting referral data from referral_enc_id
                $org_id = Referral::findOne(['referral_enc_id' => $ref_enc_id]);

                // if organization_enc_id not empty then returning 200 with org_id
                if (!empty($org_id->organization_enc_id)) {
                    return ['status' => 200, 'org_id' => $org_id];
                }
            }

            // if not found
            return ['status' => 404];
        }

        // if not authorized
        return ['status' => 401];
    }

    // getting e-sign applications
    public function actionGetEsignApplications()
    {
        // checking e-sign authorization
        $data = $this->authorizeEsign();

        // status 200
        if ($data['status'] == 200) {

            $params = Yii::$app->request->post();

            $page = !empty($params['page']) ? $params['page'] : 1;
            $limit = !empty($params['limit']) ? $params['limit'] : 10;

            // getting agreement details
            $model = EsignAgreementDetails::find()
                ->alias('z')
                ->select(['z.*'])
                ->joinWith(['esignVehicleLoanDetails a'])
                ->joinWith(['esignBorrowerDetails b']);

            // filtering with search_keyword
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

                // getting  documents and request agreement
                foreach ($model as $key => $val) {
                    $model[$key]['doc_files'] = $this->getDocuments();
                    $model[$key]['agreements'] = $this->getRequestAgreement($val['agreement_id']);
                }

                return $this->response(200, ['status' => 200, 'data' => $model]);
            } else {

                // if not found
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting e-sign document templates
    private function getDocuments()
    {
        return EsignDocumentsTemplates::find()
            ->select(['doc_id', 'name', 'file_url'])
            ->asArray()
            ->all();
    }

    // getting e-sign requested agreements
    private function getRequestAgreement($agreement_id)
    {
        return EsignRequestedAgreements::find()
            ->alias('a')
            ->select(['a.request_id', 'a.agreement_id'])
            ->joinWith(['esignRequestedAgreementsDetails b' => function ($b) {
                $b->select(['b.signer_id', 'b.request_id', 'b.name', 'b.phone', 'b.active', 'b.private_url', 'b.auth_type', 'b.auth_method', 'b.is_signed', 'b.expiryDate']);
            }])
            ->where(['a.agreement_id' => $agreement_id])
            ->groupBy(['a.agreement_id'])
            ->asArray()
            ->all();
    }

    // getting document private url
    public function actionGetDocumentUrl()
    {
        // checking authorization
        if ($this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking vehicle_laon_id
            if (empty($params['vehicle_loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "vehicle_loan_id"']);
            }

            // checking type
            if (empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "type"']);
            }

            // getting data
            $doc = EsignVehicleLoanDetails::findOne(['vehicle_loan_id' => $params['vehicle_loan_id']]);

            // creating new spaces object
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);

            $url = '';
            // if type license then getting license image signed url
            if ($params['type'] == 'license' && $doc->driving_image_url) {
                $url = $my_space->signedURL($doc->driving_image_url, "15 minutes");
            } elseif ($params['type'] == 'chassi' && $doc->chassis_image_url) {
                // if type chassi then getting chassi image signed url
                $url = $my_space->signedURL($doc->chassis_image_url, "15 minutes");
            }

            // if not empty url
            if (!empty($url)) {
                return $this->response(200, ['status' => 200, 'url' => $url]);
            }

            // if not found
            return $this->response(404, ['status' => 404, 'message' => 'file not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to upload document
    public function actionUploadDocument()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {


            $params = Yii::$app->request->post();

            // checking loan_id
            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "loan_id"']);
            }

            // checking document_type
            if (empty($params['document_type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "document_type"']);
            }

            // checking assigned_to
            if (empty($params['assigned_to'])) {
                $params['assigned_to'] = 1;
            }

            // getting file instance by name
            $file = UploadedFile::getInstanceByName('file');

            // getting certificate type id if an error occurred then send 500
            if (!$type_id = $this->getCertificateTypeId($params['document_type'], $params['assigned_to'])) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
            }

            // saving data in loan certificates
            $utilitiesModel = new Utilities();
            $certificate = new LoanCertificatesExtended();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $certificate->certificate_enc_id = $utilitiesModel->encrypt();
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

            // if extension null or empty then it will be added as .pdf
            if ($file->extension == null || $file->extension == '') {
                $certificate->proof_image = $utilitiesModel->encrypt() . '.' . 'pdf';
            } else {
                // else file extension
                $certificate->proof_image = $utilitiesModel->encrypt() . '.' . $file->extension;
            }
            $type = $file->type;
            // saving certificate data
            if ($certificate->save()) {

                // creating spaces object
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $certificate->proof_image, "private", ['params' => ['ContentType' => $type]]);
                if ($result) {
                    // if uploaded successfully
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully Saved']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'some error occurred while uploading image']);
                }

            } else {
                // if not saved
                return $this->response(500, ['status' => 500, 'message' => 'Some Error Occurred', 'error' => $certificate->getErrors()]);
            }
        }
    }

    // getting certificate type id if not exists then save it
    private function getCertificateTypeId($type, $assigned_to)
    {
        // getting certificate type
        $exists = CertificateTypes::findOne(['name' => $type]);

        // if not exists then saving it
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

        // returning certificate type id
        return $exists->certificate_type_enc_id;
    }

    // updating application number
    public function actionUpdateApplicationNumber()
    {
        // checking authorization
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        // checking value
        if (empty($params['value'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "value"']);
        }

        // checking id
        if (empty($params['id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "id"']);
        }

        // getting loan application object from loan id
        $application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['id']]);

        // updating data
        if ($application) {
            $application->application_number = $params['value'];
            $application->updated_by = $user->user_enc_id;
            $application->updated_on = date('Y-m-d H:i:s');
            if (!$application->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $application->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

        } else {

            // if application not found
            return $this->response(404, ['status' => 404, 'message' => 'application not found']);
        }

    }

    // this action is used to add loan branch
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

            // getting assigned loan provider object from loan_application_enc_id and provider_enc_id
            $provider = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $params['id'], 'provider_enc_id' => $params['parent_id']]);

            // updating data
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

    // updating loan amounts
    public function actionUpdateLoanAmounts()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // getting financer/provider_id from logged-in user
            $provider_id = $this->getFinancerId($user);
            if ($provider_id == null) {
                // if provider not found
                return $this->response(409, ['status' => 409, 'message' => 'provider not found']);
            }

            // provider_id
            // id = field name
            // value = field value
            // parent_id = loan_id
            if (empty($params['parent_id']) || empty($params['id']) || empty($params['value'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "parent_id, org_id, id, value"']);
            }

            // getting assigned loan provider object from loan_application_enc_id and provider_enc_id
            $provider = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $params['parent_id'], 'provider_enc_id' => $provider_id]);

            // if provider not found
            if (!$provider) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            // updating data
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

    // this action is used to delete loan application
    public function actionRemoveLoanApplication()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // check loan_id
            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            // loan application object from loan_id
            $loan_app = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['loan_id']]);

            // deleting loan application
            $loan_app->is_deleted = 1;
            $loan_app->updated_by = $user->user_enc_id;
            $loan_app->updated_on = date('Y-m-d H:i:s');
            if (!$loan_app->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_app->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to loan verification location
    public function actionAddVerificationLocation()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking loan_id
            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            // adding loan verification locations
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

    // this action is used to add co-applicant
    public function actionAddCoApplicant()
    {
        // checking authorization
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();

        // creating co applicant form object
        $model = new CoApplicantForm();
        $model->user_id = $user->user_enc_id;

        // loading data to model
        if ($model->load(Yii::$app->request->post())) {

            // validating model
            if ($model->validate()) {

                // if not empty loan_co_app_enc_id updating co-applicant
                if (!empty($params['loan_co_app_enc_id'])) {
                    $co_applicant = $model->update();
                } else {
                    // saving co-applicant
                    $co_applicant = $model->save();
                }

                // if status 500 returning 500
                if ($co_applicant['status'] == 500) {
                    return $this->response(500, $co_applicant);
                }

                return $this->response(200, $co_applicant);
            } else {
                // validation errors
                return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
            }
        }

        // bad request if no data in request
        return $this->response(400, ['status' => 400, 'message' => 'bad request']);
    }

    // this action is used to create financer loan negative location
    public function actionCreateFinancerLoanNegativeLocation()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // getting lender/financer id of this user
            $lender = $this->getFinancerId($user);
            if ($lender == null) {
                return $this->response(422, ['status' => 422, 'message' => 'financer not found']);
            }

            // checking request variables
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

            // saving data
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

    // getting financer loan negative locations
    public function actionGetFinancerLoanNegativeLocation()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting lender/financer of this user
            $lender = $this->getFinancerId($user);

            // getting negative locations
            $query = FinancerLoanNegativeLocation::find()
                ->alias('a')
                ->select(['a.negative_location_enc_id', 'CONCAT(b.first_name, " ", b.last_name) AS name', 'a.address', 'a.radius', 'a.latitude', 'a.longitude', 'a.status', 'a.created_by', 'a.created_on'])
                ->joinWith(['userEnc b'], false);

            if (!empty($user->organization_enc_id)) {
                $query->andWhere(['a.is_deleted' => 0, 'a.financer_enc_id' => $user->organization_enc_id]);
            } else {
                $query->andWhere(['a.is_deleted' => 0]);
                $query->andWhere(['or', ['a.user_enc_id' => $user->user_enc_id], ['and', ['a.financer_enc_id' => $lender], ['a.status' => 'Active']]]);
            }

            $query = $query->asArray()
                ->all();

            if ($query) {
                return $this->response(200, ['status' => 200, 'data' => $query]);
            }

            // if not found
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // update financer loan negative location
    public function actionUpdateFinancerLoanNegativeLocation()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking negative_location_enc_id
            if (empty($params['negative_location_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "negative_location_enc_id"']);
            }

            // getting object
            $query = FinancerLoanNegativeLocation::findOne(['negative_location_enc_id' => $params['negative_location_enc_id']]);

            // if not empty is_deleted then delete this data
            if (!empty($params['is_deleted'])) {
                $query->is_deleted = $params['is_deleted'];
            } else if (!empty($params['status'])) {
                // else update status
                $query->status = $params['status'];
            }

            $query->updated_by = $user->user_enc_id;
            $query->updated_on = date('Y-m-d H:i:s');

            if ($query->update()) {
                return $this->response(200, ['status' => 200, 'message' => 'Updated successfully.']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'An error has occurred while updating. Please try again.', 'error' => $query->getErrors()]);
            }

        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }


    public function actionCreditReports()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_id"']);
        }
        $credit_report = CreditLoanApplicationReports::find()
            ->alias('a')
            ->select(['a.response_enc_id', 'b1.request_source', 'c.borrower_type', 'c.name',
                'a.created_on'
            ])
            ->joinWith(['responseEnc b' => function ($b) {
                $b->select(['b.response_enc_id', 'b1.request_source', 'b.response_body']);
                $b->joinWith(['requestEnc b1'], false);
            }])
            ->joinWith(['loanCoAppEnc c'], false)
            ->andWhere(['a.loan_app_enc_id' => $params['loan_app_id']])
            ->asArray()
            ->all();
        $check = [
            "CIBIL" => "BureauResponseXml",
            "EQUIFAX" => "CCRResponse",
            'CRIF' => 'response_body'
        ];
        foreach ($credit_report as $key => $value) {
            $value['responseEnc']['response_body'] = json_decode($value['responseEnc']['response_body'], true);
            if (array_key_exists($value['responseEnc']['request_source'], $check)) {
                $search = $check[$value['responseEnc']['request_source']];
            }
            if (!empty($search)) {
                $response_body = UserUtilities::array_search_key($search, $value);
                switch ($value['responseEnc']['request_source']) {
                    case 'CIBIL':
                        $array = json_decode(json_encode((array)simplexml_load_string($response_body)), true);
//                        $name = $array['NameSegment']['ConsumerName1'] . ' ' . $array['NameSegment']['ConsumerName2'];
                        if (!empty($array['ScoreSegment'])) {
                            if (array_key_exists(0, $array['ScoreSegment'])) {
                                foreach ($array['ScoreSegment'] as $val) {
                                    if (is_array($val)) {
                                        $score = ltrim($val['Score'], 0);
                                        if ($score != '-1') {
                                            $credit_report[$key]['CIBIL']['score'] = $score;
                                        }
                                    }
                                }
                            } else {
                                $credit_report[$key]['CIBIL']['score'] = ltrim($array['ScoreSegment']['Score'], 0);
                            }
                        }
                        if (!empty($array['Header'])) {
                            $rawDate = $array['Header']['DateProcessed'];
                            $formattedDate = substr($rawDate, 4) . '-' . substr($rawDate, 2, 2) . '-' . substr($rawDate, 0, 2);

                            $credit_report[$key]['report_date'] = $formattedDate;
                        }
                        if (!empty($array['TelephoneSegment'])) {
                            if (array_key_exists(0, $array['TelephoneSegment'])) {
                                foreach ($array['TelephoneSegment'] as $telephones) {
                                    $credit_report[$key]['CIBIL']['phones'][] = $telephones['TelephoneNumber'];
                                }
                            } else {
                                $credit_report[$key]['CIBIL']['phones'][] = $array['TelephoneSegment']['TelephoneNumber'];
                            }
                        }

                        if (!empty($array['EmailContactSegment'])) {
                            if (array_key_exists(0, $array['EmailContactSegment'])) {
                                foreach ($array['EmailContactSegment'] as $email) {
                                    $credit_report[$key]['CIBIL']['emails'][] = $email['EmailID'];
                                }
                            } else {
                                $credit_report[$key]['CIBIL']['emails'][] = $array['EmailContactSegment']['EmailID'];
                            }
                        }
                        if (!empty($array['Address'])) {
                            if (array_key_exists(0, $array['Address'])) {
                                foreach ($array['Address'] as $addresses) {
                                    $tmp = [];
                                    for ($x = 1; $x <= 4; $x++) {
                                        $line = 'AddressLine' . $x;
                                        if (array_key_exists($line, $addresses)) {
                                            $tmp[] = $addresses[$line];
                                        }
                                    }
                                    if (array_key_exists('StateCode', $addresses)) {
                                        $state = States::findOne(['state_code' => $addresses['StateCode']])['name'];
                                        if (!empty($state)) {
                                            $tmp[] = $state;
                                        }
                                    }
                                    if (array_key_exists('PinCode', $addresses)) {
                                        $tmp[] = $addresses['PinCode'];
                                    }
                                    $credit_report[$key]['CIBIL']['address'][] = implode(', ', $tmp);
                                }
                            } else {
                                for ($x = 1; $x <= 4; $x++) {
                                    $line = 'AddressLine' . $x;
                                    if (array_key_exists($line, $array['Address'])) {
                                        $tmp[] = $array['Address'][$line];
                                    }
                                }
                                if (array_key_exists('StateCode', $array['Address'])) {
                                    $state = States::findOne(['state_code' => $array['Address']['StateCode']])['name'];
                                    if (!empty($state)) {
                                        $tmp[] = $state;
                                    }
                                }
                                if (array_key_exists('PinCode', $array['Address'])) {
                                    $tmp[] = $array['Address']['PinCode'];
                                }
                                $credit_report[$key]['CIBIL']['address'][] = implode(', ', $tmp);
                            }
                        }
                        break;
                    case 'EQUIFAX':
                        $score = UserUtilities::array_search_key('ScoreDetails', $response_body)[0]['Value'];
                        $response_body = UserUtilities::array_search_key('CIRReportData', $response_body)['IDAndContactInfo'];
//                        $name = $response_body['PersonalInfo']['Name']['FullName'];
                        $credit_report[$key]['EQUIFAX']['score'] = $score;
                        foreach ($response_body['AddressInfo'] as $val) {
                            $credit_report[$key]['EQUIFAX']['address'][] = $val['Address'] . ', ' . $val['State'] . ', ' . $val['Postal'];
                        }
                        foreach ($response_body['PhoneInfo'] as $val) {
                            $credit_report[$key]['EQUIFAX']['phones'][] = $val['Number'];
                        }
                        foreach ($response_body['EmailAddressInfo'] as $val) {
                            $credit_report[$key]['EQUIFAX']['emails'][] = $val['EmailAddress'];
                        }
                        break;
                    case 'CRIF':
                        $doc = new \DOMDocument();
                        $doc->loadXML($response_body);
                        $xpath = new \DOMXPath($doc);
                        $dataPath = '/INDV-REPORT-FILE/INDV-REPORTS/INDV-REPORT';
//                        $name = $xpath->query($dataPath . '/REQUEST/NAME')->item(0)->nodeValue;
                        try {

                            $credit_report[$key]['CRIF']['score'] = $xpath->query($dataPath . '/SCORES/SCORE/SCORE-VALUE')->item(0)->nodeValue;
                        } catch (\Exception $e) {

                        }
                        $endPath = '-VARIATIONS/VARIATION/VALUE';
                        $emailPath = $dataPath . '/PERSONAL-INFO-VARIATION/EMAIL' . $endPath;
                        $addressPath = $dataPath . '/PERSONAL-INFO-VARIATION/ADDRESS' . $endPath;
                        $phonePath = $dataPath . '/PERSONAL-INFO-VARIATION/PHONE-NUMBER' . $endPath;
                        $addresses = $xpath->query($addressPath);
                        $phones = $xpath->query($phonePath);
                        $emails = $xpath->query($emailPath);
                        try {
                            for ($i = 0; $i < $emails->length; $i++) {
                                $credit_report[$key]['CRIF']['emails'][] = $emails->item($i)->nodeValue;
                            }
                        } catch (\Exception $e) {
                        }
                        try {
                            for ($i = 0; $i < $phones->length; $i++) {
                                $credit_report[$key]['CRIF']['phones'][] = $phones->item($i)->nodeValue;
                            }
                        } catch (\Exception $e) {
                        }
                        try {
                            for ($i = 0; $i < $addresses->length; $i++) {
                                $credit_report[$key]['CRIF']['address'][] = $addresses->item($i)->nodeValue;
                            }
                        } catch (\Exception $e) {
                        }
                        break;
                }
            }
            unset($credit_report[$key]['responseEnc']);
        }
        foreach ($credit_report as $key => $val) {
            if (isset($val[$val['request_source']])) {
                foreach ($val[$val['request_source']] as $res => $report) {
                    if (is_array($report)) {
                        $credit_report[$key][$val['request_source']][$res] = array_unique($report);
                    }
                }
            } else {
                unset($credit_report[$key]);
            }
        }
        if ($credit_report) {
            return $this->response(200, ['status' => 200, 'data' => $credit_report]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'data not found']);
    }

    public function actionCheckNumber()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        $date = date('Y-m-d H:i:s', strtotime('-30 days'));

        if (isset($params['phone'])) {
            $phoneNumber = $params['phone'];

            $phoneExists = LoanApplications::find()
                ->alias('a')
                ->joinWith(['loanCoApplicants b'])
                ->where(['or',
                    ['a.phone' => $phoneNumber],
                    ['b.phone' => $phoneNumber],
                    ['a.phone' => '+91' . $phoneNumber],
                    ['b.phone' => '+91' . $phoneNumber],
                    ['a.phone' => '+' . $phoneNumber],
                    ['b.phone' => '+' . $phoneNumber],
                    ['a.phone' => preg_replace('/^\+?91/', '', $phoneNumber)],
                    ['b.phone' => preg_replace('/^\+?91/', '', $phoneNumber)],
                    ['a.phone' => preg_replace('/^\+?+/', '', $phoneNumber)],
                    ['b.phone' => preg_replace('/^\+?+/', '', $phoneNumber)],

                    ['a.phone' => '+91' . preg_replace('/^\+?+/', '', $phoneNumber)],
                    ['b.phone' => '+91' . preg_replace('/^\+?+/', '', $phoneNumber)],
                    ['a.phone' => '+' . $phoneNumber],
                    ['b.phone' => '+' . $phoneNumber],
                ]);
            if (isset($params['loan_id'])) {
                $phoneExists = $phoneExists->andWhere(['a.loan_app_enc_id' => $params['loan_id']]);
            } else {
                $phoneExists = $phoneExists->andWhere(['>=', "a.loan_status_updated_on", $date]);
            }
            $phoneExists = $phoneExists->exists();


            if ($phoneExists) {
                return $this->response(200, ['status' => 200, 'message' => 'Phone number already exists']);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Phone number does not exist']);
            }
        }


        if (isset($params['aadhaar_number'])) {
            $aadhaarNumber = $params['aadhaar_number'];

            $aadhaarExists = LoanApplications::find()
                ->alias('a')
                ->joinWith(['loanCoApplicants b'])
                ->where(['or',
                    ['a.aadhaar_number' => $aadhaarNumber],
                    ['b.aadhaar_number' => $aadhaarNumber]
                ])
                ->andWhere(['>=', "a.loan_status_updated_on", $date])
                ->exists();

            if ($aadhaarExists) {
                return $this->response(200, ['status' => 200, 'message' => 'Aadhaar number already exists']);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Aadhaar number does not exist']);
            }
        }

        if (isset($params['pan_number'])) {
            $panNumber = $params['pan_number'];

            $panExists = LoanApplications::find()
                ->alias('a')
                ->joinWith(['loanCoApplicants b'])
                ->where(['or',
                    ['a.pan_number' => $panNumber],
                    ['b.pan_number' => $panNumber]
                ])
                ->andWhere(['>=', "a.loan_status_updated_on", $date])
                ->exists();

            if ($panExists) {
                return $this->response(200, ['status' => 200, 'message' => 'PAN number already exists']);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'PAN number does not exist']);
            }
        }

        if (isset($params['voter_card_number'])) {
            $voter_card_number = $params['voter_card_number'];
            $voter_card_number = LoanApplications::find()
                ->alias('a')
                ->joinWith(['loanCoApplicants b'])
                ->where(['or',
                    ['a.voter_card_number' => $voter_card_number],
                    ['b.voter_card_number' => $voter_card_number]
                ])
                ->andWhere(['>=', "a.loan_status_updated_on", $date])
                ->exists();

            if ($voter_card_number) {
                return $this->response(200, ['status' => 200, 'message' => 'Voter number already exists']);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Voter number does not exist']);
            }
        }
        return $this->response(422, ['status' => 422, 'message' => 'Phone or Aadhaar_number or PAN_number or Voter_number is missing']);
    }

    public function actionAuditTrailList()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
        }

        $audit = LoanAuditTrail::find()
            ->alias('a')
            ->select(['a.old_value', 'a.new_value',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", concat(b.first_name," ",b.last_name), "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
                , 'a.model', 'a.action', 'a.field', 'a.stamp', 'CONCAT(b.first_name," ",b.last_name) created_by'])
            ->joinWith(['user b'], false)
            ->where(['a.loan_id' => $params['loan_id']])
            ->andWhere(['not', ['a.field' => ['', 'created_by', 'created_on', 'id', 'proof_image', 'proof_image_location', null]]])
            ->andWhere(['not like', 'a.field', '%_enc_id%', false])
            ->andWhere(['not like', 'a.field', '%updated_on%', false])
            ->andWhere(['not like', 'a.field', '%EducationLoanPaymentsExtends%', false])
            ->orderBy(['a.stamp' => SORT_DESC])
            ->asArray()
            ->all();

        $groupedAudit = [];

        if ($audit) {
            foreach ($audit as $item) {
                $item['model'] = explode("\\", $item['model']);
                if (is_array($item['model'])) {
                    $item['model'] = end($item['model']);
                }
                if ($item['model'] !== 'EducationLoanPayments') {
                    $item['model'] = substr_count($item['model'], 'Extended') ? str_replace('Extended', '', $item['model']) : $item['model'];
                    $item['stamp'] = strtotime($item['stamp']);

                    if ($item['field'] === 'gender') {
                        if ($item['new_value'] == 1) {
                            $item['new_value'] = 'Male';
                        } elseif ($item['new_value'] == 2) {
                            $item['new_value'] = 'Female';
                        } else {
                            $item['new_value'] = 'Others';
                        }
                    }

                    $groupedAudit[$item['model']][] = $item;
                }
            }

            foreach ($groupedAudit as $g => $item) {
                array_multisort(array_column($item, 'stamp'), SORT_DESC, $item);
                foreach ($item as $key => $i) {
                    $i['stamp'] = date('Y-m-d H:i:s', $i['stamp']);
                    $groupedAudit[$g][$key] = $i;
                }
            }

            return $this->response(200, ['status' => 200, 'audit_list' => $groupedAudit]);

        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function actionLoanUpdate()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['type']) || empty($params['id']) || empty($params['value'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information " or id or value"']);
        }
        if (in_array($params['type'], ['invoice_number', 'rc_number', 'chassis_number'])) {
            $type = $params['type'];
            $model = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $params['id']]);
            if (!$model) {
                return $this->response(404, ['status' => 404, 'message' => 'loan not found']);
            }
            $model->$type = $params['value'];
            $model->updated_by = $user->user_enc_id;
            $model->updated_on = date('Y-m-d H:i:s');
            if (!$model->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        }
        return $this->response(500, ['status' => 500, 'message' => 'invalid field']);
    }

    public function actionAssignApplicationNumber()
    {
        $loan_applications = LoanApplications::find()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'b.financer_loan_product_enc_id', 'b.product_code', 'c1.organization_code', 'c1.location_enc_id', 'c2.city_code'])
            ->joinWith(['loanProductsEnc b'], false)
            ->joinWith(['assignedLoanProviders c' => function ($c) {
                $c->joinWith(['branchEnc c1' => function ($c1) {
                    $c1->joinWith(['cityEnc c2'], false);
                }], false);
            }], false)
            ->joinWith(['loanPurposes d' => function ($d) {
                $d->select(['d.loan_purpose_enc_id', 'd.loan_app_enc_id', 'd1.purpose_code']);
                $d->joinWith(['financerLoanPurposeEnc d1'], false);
            }])
            ->andWhere(['between', 'a.created_on', "2023-09-01 00:00:00", "2023-09-01 23:59:59"])
            ->groupBy(['a.loan_app_enc_id'])
            ->orderBy(['a.created_on' => SORT_ASC])
            ->asArray()
            ->all();

        foreach ($loan_applications as $la) {
            $purposeCode = '';
            $purposeCodeArray = [];
            $finalPurposeCode = '';
            if ($la['loanPurposes']) {
                foreach ($la['loanPurposes'] as $purpose) {
                    if (!empty($purpose['purpose_code'])) {
                        $purposeCodeArray[] = $purpose['purpose_code'];
                    }
                }
                $purposeCodeArray = array_unique($purposeCodeArray);
                $purposeCode = implode($purposeCodeArray);
                $finalPurposeCode = $purposeCode ? '-' . $purposeCode : '';
            }

            if ($la['product_code'] && ($la['city_code'] || $la['organization_code'])) {
                $this->assignNumber($la, $finalPurposeCode);
            }
        }
        if ($loan_applications) {
            return $this->response(200, ['status' => 200, 'data' => $loan_applications]);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
        }

    }

    private function assignNumber($la, $purposeCode)
    {
        $currentYear = date('y');
        $currentMonth = date('m');
        $applicationNumber = null;
        $loanAccountNumber = "{$la['product_code']}{$purposeCode}-{$la['city_code']}{$la['organization_code']}-{$currentMonth}{$currentYear}";

        $incremental = LoanApplications::find()
            ->select(['application_number'])
            ->where(['like', 'application_number', $loanAccountNumber . '%', false])
            ->orderBy(['created_on' => SORT_DESC])
            ->one();

        if ($incremental) {
            $prev_num = '';
            $my_string = $incremental['application_number'];
            $my_array = explode('-', $my_string);
            $prev_num = ((int)$my_array[count($my_array) - 1] + 1);
            $new_num = $prev_num < 9 ? '00' . $prev_num : ($prev_num < 99 ? '0' . $prev_num : $prev_num);
            $final_num = "$loanAccountNumber-{$new_num}";
            $applicationNumber = $final_num;
        } else {
            $applicationNumber = "$loanAccountNumber-001";
        }

        $resp = Yii::$app->db->createCommand()
            ->update(LoanApplications::tableName(), ['application_number' => $applicationNumber], ['loan_app_enc_id' => $la['loan_app_enc_id']])
            ->execute();

    }

}