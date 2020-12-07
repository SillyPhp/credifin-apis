<?php


namespace api\modules\v1\controllers;


use api\modules\v1\models\Candidates;
use api\modules\v2\models\LoanApplicationsForm;
use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\CertificateTypes;
use common\models\CollegeCoursesPool;
use common\models\Countries;
use common\models\EducationLoanPayments;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplications;
use common\models\LoanCandidateEducation;
use common\models\LoanCertificates;
use common\models\LoanCoApplicants;
use common\models\LoanQualificationType;
use common\models\LoanTypes;
use common\models\OrganizationFeeComponents;
use common\models\Organizations;
use common\models\PathToClaimOrgLoanApplication;
use common\models\PathToUnclaimOrgLoanApplication;
use common\models\UserAccessTokens;
use yii\helpers\Url;
use Yii;
use yii\filters\auth\HttpBearerAuth;

class LoansController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'college-list',
                'college-courses',
                'loan-purpose',
                'save-application',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'college-list' => ['POST'],
                'college-courses' => ['POST'],
                'loan-purpose' => ['POST'],
                'save-application' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user->user_enc_id;
    }

    public function actionCollegeList()
    {
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'b.business_activity',
                'REPLACE(name, "&amp;", "&") as name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->joinWith(['businessActivityEnc b'], false)
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0,
                'b.business_activity' => ['College', 'School'],
                'has_loan_featured' => 1
            ])
            ->asArray()
            ->all();

        if ($organizations) {
            return $this->response(200, $organizations);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionCollegeCourses()
    {
        $courses = CollegeCoursesPool::find()
            ->select(['course_name'])
            ->where(['status' => 'Approved', 'is_deleted' => 0])
            ->asArray()
            ->all();

        if ($courses) {
            return $this->response(200, $courses);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionLoanPurpose()
    {

        $params = Yii::$app->request->post();

        if (isset($params['college_id']) && !empty($params['college_id'])) {
            $college_id = $params['college_id'];
        } else {
            return $this->response(422, 'missing information');
        }

        $fee_components = OrganizationFeeComponents::find()
            ->distinct()
            ->alias('a')
            ->select(['a.fee_component_enc_id', 'a.name'])
            ->joinWith(['assignedOrganizationFeeComponents b'], false)
            ->where(['b.organization_enc_id' => $college_id, 'b.status' => 1, 'b.is_deleted' => 0])
            ->asArray()
            ->all();

        $loan_types = LoanTypes::find()
            ->select(['loan_type_enc_id', 'loan_name'])
            ->asArray()
            ->all();

        if ($fee_components) {
            return $this->response(200, ['fee_components' => $fee_components, 'loan_types' => $loan_types]);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionSaveApplication()
    {
        $params = Yii::$app->request->post();
        $c = $params['college_course_info'];
        unset($params['college_course_info']);
        $params['college_course_info'][0] = $c;
        $params['userID'] = $this->userId();

        if ($params) {
            $organizationObject = new OrganizationList();
            $model = new LoanApplicationsForm();
            if ($params['is_addmission_taken'] == 1) {
                $parser = $organizationObject->conditionParser($params);
                if (!$parser['college_id']) {
                    return $this->response(500, ['status' => 500, 'message' => 'Unable to Get College Information']);
                }
                $parser2 = $organizationObject->conditionCourseParser($parser, $params);
                if (!$parser2['assigned_course_id']) {
                    return $this->response(500, ['status' => 500, 'message' => 'Unable to Get Course Information']);
                }
                $model->college_course_enc_id = $parser2['assigned_course_id'];
            } else {
                $course_name = $course_name = trim($params['college_course_info'][0]['course_text']);
                $model->college_course_enc_id = null;
                $parser['college_id'] = null;
                $parser['is_claim'] = 3;
                $pref = explode(',', $params['clg_pref']);
            }
//            if (!$parser['college_id']) {
//                return $this->response(500, ['status' => 500, 'message' => 'Unable to Get College Information']);
//            }
//            $parser2 = $organizationObject->conditionCourseParser($parser, $params);
//            if (!$parser2['assigned_course_id']) {
//                return $this->response(500, ['status' => 500, 'message' => 'Unable to Get Course Information']);
//            }
            $orgDate = $params['applicant_dob'];
            $userId = $this->userId();
            if (!$params['is_india']) {
                $model->country_enc_id = $params['country_enc_id'];
            }

            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                $model->college_course_enc_id = $parser2['assigned_course_id'];
                if ($params['loan_purpose']) {
                    $model->purpose = explode(',', $params['loan_purpose']);
                }
                if ($model->validate()) {
                    if ($data = $model->add($params['is_addmission_taken'], $userId, $parser['college_id'], 'Android', $parser['is_claim'], $course_name, $pref)) {
                        $data["name"] = "Empower Youth";
                        $data["description"] = "Application Processing Fee";
                        $data["image"] = Url::to("/assets/common/logos/eylogo2.png", 'https');
                        $data['theme_color'] = "#ff7803";
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        }
    }

    public function actionApplicationStatus()
    {

        $userId = $this->userId();
        $status = LoanApplications::find()
            ->where(['created_by' => $userId, 'status' => 0])
            ->one();

        if ($status) {
            return $this->response(409, ['status' => 409, 'data' => $status->status]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function actionStudentLoans()
    {
        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id',
                'a.applicant_name',
                'a.amount loan_amount',
                'a.status',
                'a.email',
                'a.phone',
                'd.payment_token',
//                'd.payment_id',
//                'd.payment_status',
                '(CASE
                WHEN d.payment_status IS NULL THEN "failed"
                WHEN d.payment_status = "captured" THEN "received"
                ELSE d.payment_status
                END) as payment_status',
                '(CASE
                WHEN d.payment_id IS NULL THEN ""
                ELSE d.payment_id
                END) as payment_id',
                'd.payment_amount application_fees',
                'd.payment_gst application_fees_gst',
                'd.education_loan_payment_enc_id'
            ])
//            ->innerJoinWith(['pathToClaimOrgLoanApplications cc'], false)
            ->joinWith(['educationLoanPayments d'], false)
            ->where(['a.created_by' => $this->userId()])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($loans) {
            $d["name"] = "Empower Youth";
            $d["description"] = "Application Processing Fee";
            $d["image"] = Url::to("/assets/common/logos/eylogo2.png", 'https');
            $d['theme_color'] = "#ff7803";
            $d['username'] = Yii::$app->getSecurity()->generateRandomString(3);
            return $this->response(200, ['status' => 200, 'data' => $loans, 'payment_detail' => $d]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionUpdateLoanApplication()
    {
        $params = Yii::$app->request->post();
        if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
            $loan_app_id = $params['loan_app_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if (isset($params['education_loan_payment_enc_id']) && !empty($params['education_loan_payment_enc_id'])) {
            $loan_payment_id = $params['education_loan_payment_enc_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if ($params['status'] == 'captured') {
            $loan_application = LoanApplications::find()
                ->where(['loan_app_enc_id' => $loan_app_id])
                ->one();
            if ($loan_application) {
                $loan_application->status = 0;
                $loan_application->updated_by = $this->userId();
                $loan_application->updated_on = date('Y-m-d H:i:s');
                $loan_application->update();
            }
        }

        $loan_payments = EducationLoanPayments::find()
            ->where(['education_loan_payment_enc_id' => $loan_payment_id])
            ->one();
        if ($loan_payments) {
            $loan_payments->payment_id = $params['payment_id'];
            $loan_payments->payment_status = $params['status'];
            $loan_payments->payment_signature = $params['signature'];
            $loan_payments->updated_by = $this->userId();
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            $loan_payments->update();
        }

        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionGetLoan()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id']) && empty($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $application = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.loan_app_enc_id',
                'a.applicant_name',
                'DATE_FORMAT(a.applicant_dob, \'%d-%b-%Y\') applicant_dob',
                'a.degree',
                'a.phone',
                'a.image',
                'a.image_location',
                'a.email',
//                'c1.course_name',
            ])
//            ->joinWith(['pathToClaimOrgLoanApplications c' => function ($c) {
//                $c->joinWith(['createdBy b' => function ($b) {
//                    $b->joinWith(['userOtherInfo b1']);
//                }], false);
//                $c->joinWith(['assignedCourseEnc cc' => function ($cc) {
//                    $cc->joinWith(['courseEnc c1']);
//                }]);
//            }], false)
            ->joinWith(['loanCoApplicants d' => function ($d) {
                $d->select([
                    'd.loan_co_app_enc_id',
                    'd.loan_app_enc_id',
                    'd.name',
                    'd.relation',
                    'd.email',
                    'd.phone',
                    'd.image',
                    'd.image_location',
                    'DATE_FORMAT(d.co_applicant_dob, \'%d-%b-%Y\') co_applicant_dob',
                    'd.employment_type',
                    'd.annual_income',
                    'd.address',
                    'd.years_in_current_house',
                    'd.occupation'
                ]);
                $d->joinWith(['loanCertificates de' => function ($e) {
                    $e->select(['de.certificate_enc_id', 'de.loan_co_app_enc_id', 'de.certificate_type_enc_id', 'de1.name', 'de.number', 'de.proof_image image', 'de.proof_image_location image_location']);
                    $e->joinWith(['certificateTypeEnc de1'], false);
                    $e->onCondition(['de.is_deleted' => 0]);
                }]);
                $d->joinWith(['loanApplicantResidentialInfos dg' => function ($g) {
                    $g->select(['dg.loan_app_res_info_enc_id', 'dg.loan_app_enc_id', 'dg.loan_co_app_enc_id', 'dg.residential_type', 'dg.type', 'dg.address', 'dg.city_enc_id', 'dg2.name city_name', 'dg.state_enc_id', 'dg1.name state_name']);
                    $g->joinWith(['stateEnc dg1'], false);
                    $g->joinWith(['cityEnc dg2'], false);
                    $g->onCondition(['dg.is_deleted' => 0]);
                }]);
            }])
            ->joinWith(['loanCertificates e' => function ($e) {
                $e->select(['e.certificate_enc_id', 'e.loan_app_enc_id', 'e.certificate_type_enc_id', 'e1.name', 'e.number', 'e.proof_image image', 'e.proof_image_location image_location']);
                $e->joinWith(['certificateTypeEnc e1'], false);
                $e->onCondition(['e.is_deleted' => 0]);
                $e->orderBy(['e.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanCandidateEducations f' => function ($f) {
                $f->select(['f.loan_candidate_edu_enc_id', 'f.loan_app_enc_id', 'f.qualification_enc_id', 'f.institution', 'f.obtained_marks', 'f1.name']);
                $f->joinWith(['qualificationEnc f1'], false);
                $f->onCondition(['f.is_deleted' => 0]);
                $f->orderBy(['f.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanApplicantResidentialInfos g' => function ($g) {
                $g->select(['g.loan_app_res_info_enc_id', 'g.loan_app_enc_id', 'g.loan_co_app_enc_id', 'g.residential_type', 'g.type', 'g.address', 'g.city_enc_id', 'g.state_enc_id', 'g1.name state_name', 'g2.name city_name']);
                $g->joinWith(['stateEnc g1'], false);
                $g->joinWith(['cityEnc g2'], false);
                $g->onCondition(['g.is_deleted' => 0]);
                $g->orderBy(['g.created_on' => SORT_ASC]);
            }])
            ->where(['a.loan_app_enc_id' => $params['loan_app_enc_id'], 'a.created_by' => $this->userId(), 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($application) {
            if ($application['image']) {
                $image = $this->getFile($application['image_location'], $application['image']);
                $application['image'] = $image;
            }

            $course_name = '';
            $path_claim = PathToClaimOrgLoanApplication::find()
                ->alias('a')
                ->select(['a.bridge_enc_id', 'a.loan_app_enc_id', 'assigned_course_enc_id', 'c1.course_name', 'b.name country_name'])
                ->joinWith(['assignedCourseEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                }], false)
                ->joinWith(['countryEnc b'], false)
                ->where(['a.loan_app_enc_id' => $application['loan_app_enc_id']])
                ->asArray()
                ->one();

            $path_uclaim = PathToUnclaimOrgLoanApplication::find()
                ->alias('a')
                ->select(['a.bridge_enc_id', 'a.loan_app_enc_id', 'assigned_course_enc_id', 'c1.course_name', 'b.name country_name'])
                ->joinWith(['assignedCourseEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                }], false)
                ->joinWith(['countryEnc b'], false)
                ->where(['a.loan_app_enc_id' => $application['loan_app_enc_id']])
                ->asArray()
                ->one();

            if ($path_claim) {
                $course_name = $path_claim['course_name'];
            } elseif ($path_uclaim) {
                $course_name = $path_uclaim['course_name'];
            }

            $application['course_name'] = $course_name;

            if ($application['loanCoApplicants']) {
                foreach ($application['loanCoApplicants'] as $i => $c) {
                    if ($c['image']) {
                        $image = $this->getFile($c['image_location'], $c['image']);
                        $application['loanCoApplicants'][$i]['image'] = $image;
                    }
                    if (!empty($c['loanCertificates'])) {
                        foreach ($c['loanCertificates'] as $jj => $cc) {
                            if ($cc['image']) {
                                $image = $this->getFile($cc['image_location'], $cc['image']);
                                $application['loanCoApplicants'][$i]['loanCertificates'][$jj]['image'] = $image;
                            }
                        }
                    }
                }
            }

            if ($application['loanCertificates']) {
                foreach ($application['loanCertificates'] as $j => $c) {
                    if ($c['image']) {
                        $image = $this->getFile($c['image_location'], $c['image']);
                        $application['loanCertificates'][$j]['image'] = $image;
                    }
                }
            }
        }

        if ($application) {
            return $this->response(200, [$application]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function actionLoanSecondForm()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
        if (!isset($params['type']) && empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $type = $params['type'];
        $id = $params['id'];

        if ($type == 'id_proof') {
            $id = $this->saveIdProof($params, $id);
            if ($id) {
                return $this->response(200, ['id' => $id]);
            }
        } elseif ($type == 'address') {
            $id = $this->saveAddress($params, $id);
            if ($id) {
                return $this->response(200, ['id' => $id]);
            }
        } elseif ($type == 'qualification') {
            $id = $this->saveQualification($params, $id);
            if ($id) {
                return $this->response(200, ['id' => $id]);
            }
        } elseif ($type == 'co_applicant') {
            $id = $this->saveCoApplicant($params, $id);
            if ($id) {
                return $this->response(200, ['id' => $id]);
            }
        }

    }

    private function saveIdProof($params, $id = null)
    {
        if ($id != null) {

            $certificate = CertificateTypes::find()
                ->where(['name' => $params['proof_name']])
                ->one();

            if (!$certificate) {
                $certificate = new CertificateTypes();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $certificate->certificate_type_enc_id = $utilitiesModel->encrypt();
                $certificate->name = $params['proof_name'];
                if (!$certificate->save()) {
                    print_r($certificate->getErrors());
                    return false;
                }
            }

            $loan_certificates = LoanCertificates::find()
                ->where(['certificate_enc_id' => $id])
                ->one();

            if ($loan_certificates) {
                $loan_certificates->certificate_type_enc_id = $certificate->certificate_type_enc_id;
                $loan_certificates->number = $params['number'];
                $loan_certificates->updated_by = $this->userId();
                $loan_certificates->updated_on = date('Y-m-d H:i:s');
                if ($loan_certificates->update()) {
                    return $loan_certificates->certificate_enc_id;
                } else {
                    $loan_certificates->getErrors();
                    return false;
                }
            }

        } else {

            $certificate = CertificateTypes::find()
                ->where(['name' => $params['proof_name']])
                ->one();

            if (!$certificate) {
                $certificate = new CertificateTypes();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $certificate->certificate_type_enc_id = $utilitiesModel->encrypt();
                $certificate->name = $params['proof_name'];
                if (!$certificate->save()) {
                    print_r($certificate->getErrors());
                    return false;
                }
            }

            $loan_certificates = new LoanCertificates();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_certificates->certificate_enc_id = $utilitiesModel->encrypt();
            if (isset($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
                $loan_certificates->loan_co_app_enc_id = $params['loan_co_app_id'];
            } else {
                $loan_certificates->loan_app_enc_id = $params['loan_app_id'];
            }
            $loan_certificates->certificate_type_enc_id = $certificate->certificate_type_enc_id;
            $loan_certificates->number = $params['number'];
            $loan_certificates->created_by = $this->userId();
            $loan_certificates->created_on = date('Y-m-d H:i:s');
            if ($loan_certificates->save()) {
                return $loan_certificates->certificate_enc_id;
            } else {
                print_r($loan_certificates->getErrors());
                return false;
            }
        }
    }

    private function saveAddress($params, $id = null)
    {
        if ($id == null) {
            $res_info = new LoanApplicantResidentialInfo();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $res_info->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
            if (isset($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
                $res_info->loan_co_app_enc_id = $params['loan_co_app_id'];
            } else {
                $res_info->loan_app_enc_id = $params['loan_app_id'];
            }
            $res_info->residential_type = $params['address_type'];
            $res_info->type = $params['res_type'];
            $res_info->address = $params['address'];
            $res_info->city_enc_id = $params['city_id'];
            $res_info->state_enc_id = $params['state_id'];
            $res_info->created_by = $this->userId();
            $res_info->created_on = date('Y-m-d H:i:s');
            if ($res_info->save()) {
                return $res_info->loan_app_res_info_enc_id;
            } else {
                print_r($res_info->getErrors());
                return false;
            }
        } else {
            $update_res_info = LoanApplicantResidentialInfo::find()
                ->where(['loan_app_res_info_enc_id' => $id])
                ->one();

            if ($update_res_info) {
                $update_res_info->residential_type = $params['address_type'] ? $params['address_type'] : $update_res_info->residential_type;
                $update_res_info->type = $params['res_type'] ? $params['res_type'] : $update_res_info->type;
                $update_res_info->address = $params['address'] ? $params['address'] : $update_res_info->address;
                $update_res_info->city_enc_id = $params['city_id'] ? $params['city_id'] : $update_res_info->city_enc_id;
                $update_res_info->state_enc_id = $params['state_id'] ? $params['state_id'] : $update_res_info->state_enc_id;
                $update_res_info->created_by = $this->userId();
                $update_res_info->created_on = date('Y-m-d H:i:s');
                if ($update_res_info->update()) {
                    return $update_res_info->loan_app_res_info_enc_id;
                } else {
                    print_r($update_res_info->getErrors());
                    return false;
                }
            }
        }
    }

    private function saveQualification($params, $id = null)
    {

        if ($id == null) {

            if (isset($params['name']) && !empty($params['name'])) {
                $qualification_type = LoanQualificationType::find()
                    ->where(['name' => $params['name']])
                    ->one();

                if (!$qualification_type) {
                    $qualification_type = new LoanQualificationType();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $qualification_type->qualification_enc_id = $utilitiesModel->encrypt();
                    $qualification_type->name = $params['name'];
                    if (!$qualification_type->save()) {
                        print_r($qualification_type->getErrors());
                        return false;
                    }
                }
            }

            $education = new LoanCandidateEducation();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $education->loan_candidate_edu_enc_id = $utilitiesModel->encrypt();
            $education->loan_app_enc_id = $params['loan_app_id'];
            if (isset($params['name']) && !empty($params['name'])) {
                $education->qualification_enc_id = $qualification_type->qualification_enc_id;
            }
            $education->institution = $params['institution'];
            $education->obtained_marks = $params['obtained_marks'];
            $education->created_by = $this->userId();
            $education->created_on = date('Y-m-d H:i:s');
            if ($education->save()) {
                return $education->loan_candidate_edu_enc_id;
            } else {
                print_r($education->getErrors());
                return false;
            }

        } else {
            if (isset($params['name']) && !empty($params['name'])) {
                $qualification_type = LoanQualificationType::find()
                    ->where(['name' => $params['name']])
                    ->one();

                if (!$qualification_type) {
                    $qualification_type = new LoanQualificationType();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $qualification_type->qualification_enc_id = $utilitiesModel->encrypt();
                    $qualification_type->name = $params['name'];
                    if (!$qualification_type->save()) {
                        print_r($qualification_type->getErrors());
                        return false;
                    }
                }
            }

            $education = LoanCandidateEducation::find()
                ->where(['loan_candidate_edu_enc_id' => $id])
                ->one();

            if (isset($params['name']) && !empty($params['name'])) {
                $education->qualification_enc_id = $qualification_type->qualification_enc_id;
            }
            if (isset($params['institution']) && !empty($params['institution'])) {
                $education->institution = $params['institution'];
            }
            if (isset($params['obtained_marks']) && !empty($params['obtained_marks'])) {
                $education->obtained_marks = $params['obtained_marks'];
            }
            $education->created_by = $this->userId();
            $education->created_on = date('Y-m-d H:i:s');
            if ($education->update()) {
                return $education->loan_candidate_edu_enc_id;
            } else {
                print_r($education->getErrors());
                return false;
            }

        }
    }

    private function saveCoApplicant($params, $id = null)
    {
        if ($id == null) {
            $loan_co_applicants = new LoanCoApplicants();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_co_applicants->loan_co_app_enc_id = $utilitiesModel->encrypt();
            $loan_co_applicants->loan_app_enc_id = $params['loan_app_id'];
            $loan_co_applicants->name = $params['name'];
            $loan_co_applicants->email = $params['email'];
            $loan_co_applicants->phone = $params['phone'];
            $loan_co_applicants->relation = $params['relation'];
            $loan_co_applicants->annual_income = $params['annual_income'];
            $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['applicant_dob']));
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'];
            $loan_co_applicants->occupation = $params['occupation'];
            $loan_co_applicants->address = $params['address'];
            $loan_co_applicants->created_by = $this->userId();
            $loan_co_applicants->created_on = date('Y-m-d H:i:s');
            if ($loan_co_applicants->save()) {
                return $loan_co_applicants->loan_co_app_enc_id;
            } else {
                print_r($loan_co_applicants->getErrors());
                die();
            }
        } else {
            $loan_co_applicants = LoanCoApplicants::find()
                ->Where(['loan_co_app_enc_id' => $id])
                ->one();

            $loan_co_applicants->name = $params['name'] ? $params['name'] : $loan_co_applicants->name;
            $loan_co_applicants->email = $params['email'] ? $params['email'] : $loan_co_applicants->email;
            $loan_co_applicants->phone = $params['phone'] ? $params['phone'] : $loan_co_applicants->phone;
            $loan_co_applicants->employment_type = $params['employment_type'] ? $params['employment_type'] : $loan_co_applicants->employment_type;
            $loan_co_applicants->annual_income = $params['annual_income'] ? $params['annual_income'] : $loan_co_applicants->annual_income;
            $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['applicant_dob'])) ? date('Y-m-d', strtotime($params['applicant_dob'])) : $loan_co_applicants->co_applicant_dob;
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'] ? $params['years_in_current_house'] : $loan_co_applicants->years_in_current_house;
            $loan_co_applicants->occupation = $params['occupation'] ? $params['occupation'] : $loan_co_applicants->occupation;
            $loan_co_applicants->address = $params['address'] ? $params['address'] : $loan_co_applicants->address;
            $loan_co_applicants->updated_by = $this->userId();
            $loan_co_applicants->updated_on = date('Y-m-d H:i:s');
            if ($loan_co_applicants->update()) {
                return $loan_co_applicants->loan_co_app_enc_id;
            } else {
                print_r($loan_co_applicants->getErrors());
                die();
            }
        }
    }

    public function actionUploadImage()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
            if (!isset($params['type']) && empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $image = UploadedFile::getInstanceByName('image');

            if ($id = $this->upload($params, $image)) {
                return $this->response(200, ['status' => 200, 'id' => $id]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function upload($user_id, $params, $image)
    {

        if ($params['type'] == 'co_applicant') {

            if (isset($params['loan_co_app_id']) && !empty($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
                $co_applicant = LoanCoApplicants::find()
                    ->where(['loan_co_app_enc_id' => $params['loan_co_app_id']])
                    ->one();

                if ($co_applicant) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }
                    $co_applicant->image = $encrypted_string . '.' . $image->extension;
                    $co_applicant->image_location = 'loan-proofs-and-profile-images';
                    $co_applicant->updated_by = $user_id;
                    $co_applicant->updated_on = date('Y-m-d H:i:s');
                    if ($co_applicant->update()) {
                        if ($this->uploadFile($co_applicant->image, $image->tempName)) {
                            return $co_applicant->loan_co_app_enc_id;
                        }
                    } else {
                        print_r($co_applicant->getErrors());
                        die();
                    }
                } else {
                    $co_applicant = new LoanCoApplicants();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $co_applicant->loan_co_app_enc_id = $utilitiesModel->encrypt();
                    $co_applicant->loan_app_enc_id = $params['loan_app_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }
                    $co_applicant->image = $encrypted_string . '.' . $image->extension;
                    $co_applicant->image_location = 'loan-proofs-and-profile-images';
                    $co_applicant->created_by = $user_id;
                    $co_applicant->created_on = date('Y-m-d H:i:s');
                    if ($co_applicant->save()) {
                        if ($this->uploadFile($co_applicant->image, $image->tempName)) {
                            return $co_applicant->loan_co_app_enc_id;
                        }
                    } else {
                        print_r($co_applicant->getErrors());
                    }
                }

            }
        } else if ($params['type'] == 'id_proof') {
            if (isset($params['id']) && !empty($params['id'])) {
                $proof = LoanCertificates::find()
                    ->where(['certificate_enc_id' => $params['id']])
                    ->one();

                if ($proof) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }

                    $proof->proof_image = $encrypted_string . '.' . $image->extension;
                    $proof->proof_image_location = 'loan-proofs-and-profile-images';
                    $proof->updated_by = $user_id;
                    $proof->updated_on = date('Y-m-d H:i:s');
                    if ($proof->update()) {
                        if ($this->uploadFile($proof->proof_image, $image->tempName)) {
                            return $proof->certificate_enc_idl;
                        }
                    } else {
                        print_r($proof->getErrors());
                        die();
                    }
                }
            }
        } else if ($params['type'] == 'applicant') {
            $loan_applicant = LoanApplications::find()
                ->where(['loan_app_enc_id' => $params['loan_app_id']])
                ->one();

            if ($loan_applicant) {
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == '.') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }
                $loan_applicant->image = $encrypted_string . '.' . $image->extension;
                $loan_applicant->image_location = 'loan-proofs-and-profile-images';
                $loan_applicant->updated_by = $user_id;
                $loan_applicant->updated_on = date('Y-m-d H:i:s');
                if ($loan_applicant->update()) {
                    if ($this->uploadFile($loan_applicant->image, $image->tempName)) {
                        return $loan_applicant->loan_app_enc_id;
                    }
                } else {
                    print_r($loan_applicant->getErrors());
                    die();
                }
            }
        }

    }

    private function uploadFile($file_name, $file)
    {
        $bucketName = 'loan-uploads';
        $access_key = 'AKIATDLKTDI76APKFGXO';
        $secret_key = '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';
        $s3 = new S3Client([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => $access_key,
                'secret' => $secret_key,
            ]
        ]);

        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key' => 'loan-proofs-and-profile-images/' . $file_name,
            'SourceFile' => $file
        ]);

        if ($result) {
            $s3->putObjectAcl([
                'Bucket' => $bucketName,
                'Key' => 'loan-proofs-and-profile-images/' . $file_name,
                'ACL' => 'public-read'
            ]);
            return true;
        } else {
            return false;
        }
    }

}