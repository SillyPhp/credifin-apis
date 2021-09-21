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
use common\models\LeadsApplications;
use common\models\LeadsCollegePreference;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplications;
use common\models\LoanApplicationsCollegePreference;
use common\models\LoanCandidateEducation;
use common\models\LoanCertificates;
use common\models\PathToOpenLeads;
use common\models\PressReleasePubliser;
use common\models\ReferralReviewTracking;
use common\models\Utilities;
use common\models\LoanCoApplicants;
use common\models\LoanQualificationType;
use common\models\LoanTypes;
use common\models\OrganizationFeeComponents;
use common\models\Organizations;
use common\models\PathToClaimOrgLoanApplication;
use common\models\PathToUnclaimOrgLoanApplication;
use common\models\spaces\Spaces;
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
                'home',
                'interest-free',
                'refinance',
                'school-fee-finance',
                'enquiry-form',
                'study-in-india',
                'faqs',
                'press-release-publisher',
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
                'home' => ['POST'],
                'enquiry-form' => ['POST'],
                'study-in-india' => ['POST'],
                'press-release-publisher' => ['POST'],
                'save-teachers-loan' => ['POST'],
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

        return $user ? $user->user_enc_id : null;
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
        $params = Yii::$app->request->post();

        $courses = CollegeCoursesPool::find()
            ->alias('a')
            ->select(['a.course_name'])
            ->where(['a.status' => 'Approved', 'a.is_deleted' => 0]);
        if (isset($params['college_id']) && !empty($params['college_id'])) {
            $courses->joinWith(['assignedCollegeCourses b'], false)
                ->andWhere(['b.organization_enc_id' => $params['college_id']]);
        }
        $courses = $courses->asArray()
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
            ->where(['created_by' => $userId, 'status' => 0, 'is_deleted' => 0])
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
                'd.education_loan_payment_enc_id',
                "DATE_FORMAT(a.created_on, '%d-%b-%Y') applied_date"
            ])
            ->joinWith(['educationLoanPayments d'], false)
            ->where(['a.created_by' => $this->userId(), 'a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($loans) {

            foreach ($loans as $k => $v) {
                $loans[$k]['payment_status'] = ucwords($v['payment_status']);
            }

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

    public function actionLoanDetail()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id']) && empty($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $loan = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id',
                'a.applicant_name',
                'a.amount loan_amount',
                'a.status',
                'a.email',
                'a.phone',
                'a.had_taken_addmission',
                'd.payment_token',
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
                'd.education_loan_payment_enc_id',
                "DATE_FORMAT(a.created_on, '%d-%b-%Y') applied_date"
            ])
            ->joinWith(['educationLoanPayments d'], false)
            ->joinWith(['loanCoApplicants dd' => function ($d) {
                $d->select([
                    'dd.loan_co_app_enc_id',
                    'dd.loan_app_enc_id',
                    'dd.name',
                    'dd.relation',
                    'dd.employment_type',
                    'dd.annual_income'
                ]);
            }])
            ->joinWith(['loanPurposes e' => function ($e) {
                $e->select(['e.loan_purpose_enc_id', 'e.loan_app_enc_id', 'e.fee_component_enc_id', 'e1.name']);
                $e->joinWith(['feeComponentEnc e1'], false);
            }])
            ->where(['a.created_by' => $this->userId(), 'a.is_deleted' => 0, 'a.loan_app_enc_id' => $params['loan_app_enc_id']])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->one();

        if ($loan) {

            $course_name = '';
            $college_name = '';
            $path_claim = PathToClaimOrgLoanApplication::find()
                ->alias('a')
                ->select(['a.bridge_enc_id', 'a.loan_app_enc_id', 'assigned_course_enc_id', 'c1.course_name', 'b.name country_name', 'c2.name college_name'])
                ->joinWith(['assignedCourseEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                    $cc->joinWith(['organizationEnc c2']);
                }], false)
                ->joinWith(['countryEnc b'], false)
                ->where(['a.loan_app_enc_id' => $loan['loan_app_enc_id']])
                ->asArray()
                ->one();

            $path_uclaim = PathToUnclaimOrgLoanApplication::find()
                ->alias('a')
                ->select(['a.bridge_enc_id', 'a.loan_app_enc_id', 'assigned_course_enc_id', 'c1.course_name', 'b.name country_name', 'c2.name college_name'])
                ->joinWith(['assignedCourseEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                    $cc->joinWith(['organizationEnc c2']);
                }], false)
                ->joinWith(['countryEnc b'], false)
                ->where(['a.loan_app_enc_id' => $loan['loan_app_enc_id']])
                ->asArray()
                ->one();

            $path_lead = PathToOpenLeads::find()
                ->select(['course_name'])
                ->where(['loan_app_enc_id' => $loan['loan_app_enc_id']])
                ->asArray()
                ->one();

            $loan['prefs'] = [];
            if ($loan['had_taken_addmission'] == 0) {
                $prefs = LoanApplicationsCollegePreference::find()
                    ->select(['preference_enc_id', 'college_name'])
                    ->where(['loan_app_enc_id' => $loan['loan_app_enc_id']])
                    ->asArray()
                    ->all();

                $loan['prefs'] = $prefs;
            }

            if ($path_claim) {
                $course_name = $path_claim['course_name'];
                $college_name = $path_claim['college_name'];
            } elseif ($path_uclaim) {
                $course_name = $path_uclaim['course_name'];
                $college_name = $path_uclaim['college_name'];
            } elseif ($path_lead) {
                $course_name = $path_lead['course_name'];
            }

            $loan['course_name'] = $course_name;
            $loan['college_name'] = $college_name;
            $loan['payment_status'] = ucwords($loan['payment_status']);
            $d["name"] = "Empower Youth";
            $d["description"] = "Application Processing Fee";
            $d["image"] = Url::to("/assets/common/logos/eylogo2.png", 'https');
            $d['theme_color'] = "#ff7803";
            $d['username'] = Yii::$app->getSecurity()->generateRandomString(3);
            return $this->response(200, ['status' => 200, 'data' => $loan, 'payment_detail' => $d]);
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
            $loan_app_ids = explode(',', $loan_app_id);
            foreach ($loan_app_ids as $loan_id) {
                $loan_application = LoanApplications::find()
                    ->where(['loan_app_enc_id' => $loan_id])
                    ->one();
                if ($loan_application) {
                    $loan_application->status = 0;
                    $loan_application->updated_by = $this->userId();
                    $loan_application->updated_on = date('Y-m-d H:i:s');
                    $loan_application->update();
                }
            }
        }

        $loan_payment_ids = explode(',', $loan_payment_id);
        foreach ($loan_payment_ids as $payment_id) {
            $loan_payments = EducationLoanPayments::find()
                ->where(['education_loan_payment_enc_id' => $payment_id])
                ->one();
            if ($loan_payments) {
                $loan_payments->payment_id = $params['payment_id'];
                $loan_payments->payment_status = $params['status'];
                $loan_payments->payment_signature = $params['signature'];
                $loan_payments->updated_by = $this->userId();
                $loan_payments->updated_on = date('Y-m-d H:i:s');
                $loan_payments->update();
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionGetLoan()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id']) && empty($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $application = $this->getLoanData($params);

        if ($application && $application['ask_guarantor_info'] == 1) {
            $data['loan_app_enc_id'] = $params['loan_app_enc_id'];
            $data['relations'] = 'Guarantor';
            $application['guarantor'] = $this->getLoanData($data)['loanCoApplicants'];
        }

        if ($application) {
            return $this->response(200, $application);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    private function getLoanData($params)
    {
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
                'a.gender',
                'a.ask_guarantor_info'
            ])
            ->joinWith(['loanCoApplicants d' => function ($d) use ($params) {
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
                    $e->select(['de.certificate_enc_id', 'de.loan_co_app_enc_id', 'de.certificate_type_enc_id', 'de1.name', 'de.number', 'de.proof_image_name', 'de.proof_image image', 'de.proof_image_location image_location']);
                    $e->joinWith(['certificateTypeEnc de1'], false);
                    $e->onCondition(['de.is_deleted' => 0]);
                }]);
                $d->joinWith(['loanApplicantResidentialInfos dg' => function ($g) {
                    $g->select(['dg.loan_app_res_info_enc_id', 'dg.loan_app_enc_id', 'dg.loan_co_app_enc_id', 'dg.residential_type', 'dg.type', 'dg.address', 'dg.city_enc_id', 'dg2.name city_name', 'dg.state_enc_id', 'dg1.name state_name']);
                    $g->joinWith(['stateEnc dg1'], false);
                    $g->joinWith(['cityEnc dg2'], false);
                    $g->onCondition(['dg.is_deleted' => 0]);
                }]);
                if (isset($params['relations']) && !empty($params['relations'])) {
                    $d->onCondition(['d.relation' => $params['relations']]);
                } else {
                    $d->onCondition(['<>', 'd.relation', 'Guarantor']);
                }
                $d->groupBy(['d.loan_co_app_enc_id']);
            }])
            ->joinWith(['loanCertificates e' => function ($e) {
                $e->select(['e.certificate_enc_id', 'e.loan_app_enc_id', 'e.certificate_type_enc_id', 'e1.name', 'e.number', 'e.proof_image_name', 'e.proof_image image', 'e.proof_image_location image_location']);
                $e->joinWith(['certificateTypeEnc e1'], false);
                $e->onCondition(['e.is_deleted' => 0]);
                $e->orderBy(['e.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanCandidateEducations f' => function ($f) {
                $f->select(['f.loan_candidate_edu_enc_id', 'f.loan_app_enc_id', 'f.qualification_enc_id', 'f.institution', 'f.obtained_marks', 'f1.name', 'f.proof_image image', 'f.proof_image_name', 'f.proof_image_location image_location']);
                $f->joinWith(['qualificationEnc f1'], false);
                $f->onCondition(['f.is_deleted' => 0]);
                $f->orderBy(['f.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanApplicantResidentialInfos g' => function ($g) {
                $g->select(['g.loan_app_res_info_enc_id', 'g.loan_app_enc_id', 'g.loan_co_app_enc_id', 'g.residential_type', 'g.type', 'g.address', 'g.city_enc_id', 'g.state_enc_id', 'g1.name state_name', 'g2.name city_name']);
                $g->joinWith(['stateEnc g1'], false);
                $g->joinWith(['cityEnc g2'], false);
                $g->onCondition(['g.is_deleted' => 0]);
//                $g->orderBy(['g.created_on' => SORT_ASC]);
            }])
            ->where(['a.loan_app_enc_id' => $params['loan_app_enc_id'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($application) {
            if ($application['image']) {
                $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . $application['image_location'] . '/' . $application['image'];
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

            $path_lead = PathToOpenLeads::find()
                ->select(['course_name'])
                ->where(['loan_app_enc_id' => $application['loan_app_enc_id']])
                ->asArray()
                ->one();

            if ($path_claim) {
                $course_name = $path_claim['course_name'];
            } elseif ($path_uclaim) {
                $course_name = $path_uclaim['course_name'];
            } elseif ($path_lead) {
                $course_name = $path_lead['course_name'];
            }

            $application['course_name'] = $course_name;

            if ($application['loanCoApplicants']) {
                foreach ($application['loanCoApplicants'] as $i => $c) {
                    $application['loanCoApplicants'][$i]['finance_proof'] = [];
                    if ($c['image']) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . $c['image_location'] . '/' . $c['image'];
                        $application['loanCoApplicants'][$i]['image'] = $image;
                    }
                    $application['loanCoApplicants'][$i]['annual_income'] = (int)$c['annual_income'];
                    if (!empty($c['loanCertificates'])) {
                        foreach ($c['loanCertificates'] as $jj => $cc) {
                            if ($cc['image']) {
                                $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof . $cc['image_location'] . '/' . $cc['image'];
                                $application['loanCoApplicants'][$i]['loanCertificates'][$jj]['image'] = $image;
                            }
                        }
                    }

                    if (!empty($c['loanCertificates'])) {
                        foreach ($c['loanCertificates'] as $jj => $cc) {
                            if ($cc['name'] == 'ITR' || $cc['name'] == 'Bank Statement') {
                                $application['loanCoApplicants'][$i]['finance_proof'][] = $cc;
                                unset($application['loanCoApplicants'][$i]['loanCertificates'][$jj]);
                            }
                        }
                    }

                    $application['loanCoApplicants'][$i]['loanCertificates'] = array_values($application['loanCoApplicants'][$i]['loanCertificates']);

                }
            }

            if ($application['loanCertificates']) {
                foreach ($application['loanCertificates'] as $j => $c) {
                    if ($c['image']) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof . $c['image_location'] . '/' . $c['image'];
                        $application['loanCertificates'][$j]['image'] = $image;
                    }
                }
            }

            if ($application['loanCandidateEducations']) {
                foreach ($application['loanCandidateEducations'] as $j => $c) {
                    if ($c['image']) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof . $c['image_location'] . '/' . $c['image'];
                        $application['loanCandidateEducations'][$j]['image'] = $image;
                    }
                }
            }

        }

        return $application;
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
        } elseif ($type == 'applicant') {
            $id = $this->updateLoanApplications($params);
            if ($id) {
                return $this->response(200, ['id' => $id]);
            }
        }

    }

    public function actionSaveSecondForm()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
        if (!isset($params['step']) && empty($params['step'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if ($params['step'] === 1) {
            // updating loan applications data
            $this->updateLoanApplications($params);

            // saving or updating id proofs
            if ($params['id_proofs']) {
                foreach ($params['id_proofs'] as $proof) {
                    $proof['loan_app_id'] = $params['loan_app_id'];
                    if ($proof['id']) {
                        $this->saveIdProof($proof, $proof['id']);
                    } else {
                        $this->saveIdProof($proof);
                    }
                }
            }

            // saving or updating address
            if ($params['addresses']) {
                foreach ($params['addresses'] as $address) {
                    $address['loan_app_id'] = $params['loan_app_id'];
                    if ($address['id']) {
                        $this->saveAddress($address, $address['id']);
                    } else {
                        $this->saveAddress($address);
                    }
                }
            }

            // saving or updating qualifications
            if ($params['qualifications']) {
                foreach ($params['qualifications'] as $qualification) {
                    $qualification['loan_app_id'] = $params['loan_app_id'];
                    if ($qualification['id']) {
                        $this->saveQualification($qualification, $qualification['id']);
                    } else {
                        $this->saveQualification($qualification);
                    }
                }
            }

            $data['loan_app_enc_id'] = $params['loan_app_id'];
            $data = $this->getLoanData($data);

            unset($data['loanCoApplicants']);

            return $this->response(200, $data);

        } elseif ($params['step'] === 2) {
            // saving or updating co applicant
            $relations = [];
            if ($params['co_applicants']) {
                foreach ($params['co_applicants'] as $coApplicant) {
                    array_push($relations, $coApplicant['relation']);
                    $coApplicant['loan_app_id'] = $params['loan_app_id'];
                    if ($coApplicant['id']) {
                        $coAppId = $this->saveCoApplicant($coApplicant, $coApplicant['id']);
                    } else {
                        $coAppId = $this->saveCoApplicant($coApplicant);
                    }

                    $coApplicant['loan_co_app_id'] = $coAppId;

                    // saving or updating id proofs
                    if ($coApplicant['id_proofs']) {
                        foreach ($coApplicant['id_proofs'] as $proof) {
                            $proof['loan_co_app_id'] = $coAppId;
                            if ($proof['id']) {
                                $this->saveIdProof($proof, $proof['id']);
                            } else {
                                $this->saveIdProof($proof);
                            }
                        }
                    }

                    // saving or updating finance proof
                    if ($coApplicant['finance_proofs']) {
                        foreach ($coApplicant['finance_proofs'] as $proof) {
                            $proof['loan_co_app_id'] = $coAppId;
                            if ($proof['id']) {
                                $this->saveIdProof($proof, $proof['id']);
                            } else {
                                $this->saveIdProof($proof);
                            }
                        }
                    }

                    // saving or updating address
                    if ($coApplicant['addresses']) {
                        foreach ($coApplicant['addresses'] as $address) {
                            $address['loan_co_app_id'] = $coAppId;
                            if ($address['id']) {
                                $this->saveAddress($address, $address['id']);
                            } else {
                                $res = LoanApplicantResidentialInfo::findone(['loan_co_app_enc_id' => $coAppId]);
                                if ($res) {
                                    $this->saveAddress($address, $res->loan_app_res_info_enc_id);
                                } else {
                                    $this->saveAddress($address);
                                }
                            }
                        }
                    }
                }
            }


            $data['loan_app_enc_id'] = $params['loan_app_id'];
            $data['relations'] = array_unique($relations);

            $d = [];
            if (in_array("Guarantor", $data['relations'])) {
                $d['guarantor'] = $this->getLoanData($data)['loanCoApplicants'];
            } else {
                $d['co_applicants'] = $this->getLoanData($data)['loanCoApplicants'];
            }

            return $this->response(200, $d);
        }

    }

    private function updateLoanApplications($params)
    {
        $loan = LoanApplications::find()
            ->where(['loan_app_enc_id' => $params['loan_app_id']])
            ->one();

        if ($loan) {
            $loan->gender = $params['gender'];
            $loan->updated_on = date('Y-m-d H:i:s');
            $loan->updated_by = $this->userId();
            if ($loan->update()) {
                return $loan->loan_app_enc_id;
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

                if (!empty($params['image'])) {
                    $image_ext = $params['image_ext'];
                    $image = base64_decode($params['image']);

                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }

                    $loan_certificates->proof_image_name = $params['image_name'] . '.' . $image_ext;
                    $loan_certificates->proof_image = $encrypted_string . '.' . $image_ext;
                    $loan_certificates->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->proof . $loan_certificates->proof_image_location . '/';
                    $file = dirname(__DIR__, 4) . '/files/temp/' . $loan_certificates->proof_image;
                }
                if ($loan_certificates->update()) {
                    if (!empty($params['image'])) {
                        if (file_put_contents($file, $image)) {
                            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                            $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_certificates->proof_image, "public");
                            if (file_exists($file)) {
                                unlink($file);
                            }
                            return $loan_certificates->certificate_enc_id;
                        } else {
                            return false;
                        }
                    } else {
                        return $loan_certificates->certificate_enc_id;
                    }
                } else {
                    print_r($loan_certificates->getErrors());
                    die();
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
                    die();
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

            if (!empty($params['image'])) {
                $image_ext = $params['image_ext'];
                $image = base64_decode($params['image']);

                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == ' . ') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $loan_certificates->proof_image_name = $params['image_name'] . '.' . $image_ext;
                $loan_certificates->proof_image = $encrypted_string . '.' . $image_ext;
                $loan_certificates->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->loans->proof . $loan_certificates->proof_image_location . '/';
                $file = dirname(__DIR__, 4) . '/files/temp/' . $loan_certificates->proof_image;
            }
            if ($loan_certificates->save()) {
                if (!empty($params['image'])) {
                    if (file_put_contents($file, $image)) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_certificates->proof_image, "public");
                        if (file_exists($file)) {
                            unlink($file);
                        }
                        return $loan_certificates->certificate_enc_id;
                    } else {
                        return false;
                    }
                } else {
                    return $loan_certificates->certificate_enc_id;
                }
            } else {
                print_r($loan_certificates->getErrors());
                die();
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
            $res_info->residential_type = $params['residential_type'];
            $res_info->type = $params['type'];
            $res_info->address = $params['address'];
            $res_info->city_enc_id = $params['city_id'];
            $res_info->state_enc_id = $params['state_id'];
            $res_info->created_by = $this->userId();
            $res_info->created_on = date('Y-m-d H:i:s');
            if ($res_info->save()) {
                return $res_info->loan_app_res_info_enc_id;
            } else {
                print_r($res_info->getErrors());
                die();
            }
        } else {
            $update_res_info = LoanApplicantResidentialInfo::find()
                ->where(['loan_app_res_info_enc_id' => $id])
                ->one();

            if ($update_res_info) {
                $update_res_info->residential_type = ($params['residential_type'] == 1) ? 1 : 0;
                $update_res_info->type = ($params['type'] == 1) ? 1 : 0;
                $update_res_info->address = $params['address'] ? $params['address'] : $update_res_info->address;
                $update_res_info->city_enc_id = $params['city_id'] ? $params['city_id'] : $update_res_info->city_enc_id;
                $update_res_info->state_enc_id = $params['state_id'] ? $params['state_id'] : $update_res_info->state_enc_id;
                $update_res_info->updated_by = $this->userId();
                $update_res_info->updated_on = date('Y-m-d H:i:s');
                if ($update_res_info->update()) {
                    return $update_res_info->loan_app_res_info_enc_id;
                } else {
                    print_r($update_res_info->getErrors());
                    die();
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
                        die();
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

            if (isset($params['institution']) && !empty($params['institution'])) {
                $education->institution = $params['institution'];
            }
            if (isset($params['obtained_marks']) && !empty($params['obtained_marks'])) {
                $education->obtained_marks = $params['obtained_marks'];
            }
            $education->created_by = $this->userId();
            $education->created_on = date('Y-m-d H:i:s');
            if (!empty($params['image'])) {
                $image_ext = $params['image_ext'];
                $image = base64_decode($params['image']);

                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == '.') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $education->proof_image_name = $params['image_name'] . '.' . $image_ext;
                $education->proof_image = $encrypted_string . '.' . $image_ext;
                $education->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->loans->proof . $education->proof_image_location . '/';
                $file = dirname(__DIR__, 4) . '/files/temp/' . $education->proof_image;
            }
            if ($education->save()) {
                if (!empty($params['image'])) {
                    if (file_put_contents($file, $image)) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $education->proof_image, "public");
                        if (file_exists($file)) {
                            unlink($file);
                        }
                        return $education->loan_candidate_edu_enc_id;
                    } else {
                        return false;
                    }
                }
                return $education->loan_candidate_edu_enc_id;
            } else {
                print_r($education->getErrors());
                die();
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
            $education->updated_by = $this->userId();
            $education->updated_on = date('Y-m-d H:i:s');
            if (!empty($params['image'])) {
                $image_ext = $params['image_ext'];
                $image = base64_decode($params['image']);

                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == '.') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $education->proof_image_name = $params['image_name'] . '.' . $image_ext;
                $education->proof_image = $encrypted_string . '.' . $image_ext;
                $education->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->loans->proof . $education->proof_image_location . '/';
                $file = dirname(__DIR__, 4) . '/files/temp/' . $education->proof_image;
            }
            if ($education->update()) {
                if (!empty($params['image'])) {
                    if (file_put_contents($file, $image)) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $education->proof_image, "public");
                        if (file_exists($file)) {
                            unlink($file);
                        }
                        return $education->loan_candidate_edu_enc_id;
                    } else {
                        return false;
                    }
                }
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
            $loan_co_applicants->annual_income = (int)$params['annual_income'];
            $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['co_applicant_dob']));
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'];
            $loan_co_applicants->occupation = $params['occupation'];
            $loan_co_applicants->address = ($params['address'] == 1) ? 1 : 0;
            $loan_co_applicants->created_by = $this->userId();
            $loan_co_applicants->created_on = date('Y-m-d H:i:s');
            if (!empty($params['image'])) {
                $image_ext = $params['image_ext'];
                $image = base64_decode($params['image']);

                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == ' . ') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $loan_co_applicants->image = $encrypted_string . '.' . $image_ext;
                $loan_co_applicants->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->loans->image . $loan_co_applicants->image_location . '/';
                $file = dirname(__DIR__, 4) . '/files/temp/' . $loan_co_applicants->image;
            }
            if ($loan_co_applicants->save()) {
                if (!empty($params['image'])) {
                    if (file_put_contents($file, $image)) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_co_applicants->image, "public");
                        if (file_exists($file)) {
                            unlink($file);
                        }
                        return $loan_co_applicants->loan_co_app_enc_id;
                    } else {
                        return false;
                    }
                }
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
            $loan_co_applicants->relation = $params['relation'] ? $params['relation'] : $loan_co_applicants->relation;
            $loan_co_applicants->employment_type = $params['employment_type'] ? $params['employment_type'] : $loan_co_applicants->employment_type;
            $loan_co_applicants->annual_income = (int)$params['annual_income'] ? $params['annual_income'] : $loan_co_applicants->annual_income;
            $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['co_applicant_dob'])) ? date('Y-m-d', strtotime($params['co_applicant_dob'])) : $loan_co_applicants->co_applicant_dob;
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'] ? $params['years_in_current_house'] : $loan_co_applicants->years_in_current_house;
            $loan_co_applicants->occupation = $params['occupation'] ? $params['occupation'] : $loan_co_applicants->occupation;
            $loan_co_applicants->address = ($params['address'] == 1) ? 1 : 0;
            $loan_co_applicants->updated_by = $this->userId();
            $loan_co_applicants->updated_on = date('Y-m-d H:i:s');
            if (!empty($params['image'])) {
                $image_ext = $params['image_ext'];
                $image = base64_decode($params['image']);

                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == ' . ') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $loan_co_applicants->image = $encrypted_string . '.' . $image_ext;
                $loan_co_applicants->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->loans->image . $loan_co_applicants->image_location . '/';
                $file = dirname(__DIR__, 4) . '/files/temp/' . $loan_co_applicants->image;
            }
            if ($loan_co_applicants->update()) {
                if (!empty($params['image'])) {
                    if (file_put_contents($file, $image)) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_co_applicants->image, "public");
                        if (file_exists($file)) {
                            unlink($file);
                        }
                        return $loan_co_applicants->loan_co_app_enc_id;
                    } else {
                        return false;
                    }
                }
                return $loan_co_applicants->loan_co_app_enc_id;
            } else {
                print_r($loan_co_applicants->getErrors());
                die();
            }
        }
    }

    public function actionUploadImage()
    {

        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
//        if (!isset($params['type']) && empty($params['type'])) {
//            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
//        }

        $params['type'] = 'applicant';
        $image_ext = $params['image_ext'];
        $image = base64_decode($params['image']);

        if ($id = $this->upload($this->userId(), $params, $image, $image_ext)) {
            return $this->response(200, ['status' => 200, 'id' => $id]);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
        }

    }

    private function upload($user_id, $params, $image, $image_ext)
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
                    $co_applicant->image = $encrypted_string . '.' . $image_ext;
                    $co_applicant->image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->image . $co_applicant->image_location . '/';
                    $co_applicant->updated_by = $user_id;
                    $co_applicant->updated_on = date('Y-m-d H:i:s');
                    $file = dirname(__DIR__, 4) . '/files/temp/' . $co_applicant->image;
                    if ($co_applicant->update()) {
                        if (file_put_contents($file, $image)) {
                            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                            $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $co_applicant->image, "public");
                            if (file_exists($file)) {
                                unlink($file);
                            }
                            return $co_applicant->loan_co_app_enc_id;
                        } else {
                            return false;
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
                    $co_applicant->image = $encrypted_string . '.' . $image_ext;
                    $co_applicant->image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->image . $co_applicant->image_location . '/';
                    $co_applicant->created_by = $user_id;
                    $co_applicant->created_on = date('Y-m-d H:i:s');
                    $file = dirname(__DIR__, 4) . '/files/temp/' . $co_applicant->image;
                    if ($co_applicant->save()) {
                        if (file_put_contents($file, $image)) {
                            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                            $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $co_applicant->image, "public");
                            if (file_exists($file)) {
                                unlink($file);
                            }
                            return $co_applicant->loan_co_app_enc_id;
                        } else {
                            return false;
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

                    $proof->proof_image_name = $params['image_name'] . '.' . $image_ext;
                    $proof->proof_image = $encrypted_string . '.' . $image_ext;
                    $proof->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->proof . $proof->proof_image_location . '/';
                    $proof->updated_by = $user_id;
                    $proof->updated_on = date('Y-m-d H:i:s');
                    $file = dirname(__DIR__, 4) . '/files/temp/' . $proof->proof_image;
                    if ($proof->update()) {
                        if (file_put_contents($file, $image)) {
                            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                            $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $proof->proof_image, "public");
                            if (file_exists($file)) {
                                unlink($file);
                            }
                            return $proof->certificate_enc_id;
                        } else {
                            return false;
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
                $loan_applicant->image = $encrypted_string . '.' . $image_ext;
                $loan_applicant->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->loans->image . $loan_applicant->image_location . '/';
                $loan_applicant->updated_by = $user_id;
                $loan_applicant->updated_on = date('Y-m-d H:i:s');
                $file = dirname(__DIR__, 4) . '/files/temp/' . $loan_applicant->image;
                if ($loan_applicant->update()) {
                    if (file_put_contents($file, $image)) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_applicant->image, "public");
                        if (file_exists($file)) {
                            unlink($file);
                        }
                        return $loan_applicant->loan_app_enc_id;
                    } else {
                        return false;
                    }
                } else {
                    print_r($loan_applicant->getErrors());
                    die();
                }
            }
        }

    }

    public function actionHome()
    {
        $partner_colleges = Organizations::find()
            ->select(['organization_enc_id', 'REPLACE(name, "&amp;", "&") as name', 'case WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) else NULL END org_logo', 'initials_color'])
            ->where(['is_deleted' => 0, 'has_loan_featured' => 1, 'status' => 'Active'])
            ->asArray()
            ->all();

        $lendingPartners = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'lending_partners.json');
        $lendingPartners = json_decode($lendingPartners, true);

        foreach ($lendingPartners as $k => $v) {
            if ($v['image'] == 'AG-logo.png' || $v['image'] == 'ezcapital.png' || $v['image'] == 'phf-leasing.png') {
                $lendingPartners[$k]['org_logo'] = Url::to('@eyAssets/images/pages/index2/' . $v['image'], 'https');
            } else {
                $lendingPartners[$k]['org_logo'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['image'], 'https');
            }
            $lendingPartners[$k]['organization_enc_id'] = 'empoweryouth';
            $lendingPartners[$k]['initials_color'] = '#ea52ce';
        }

        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'faqs.json');
        $faqs = json_decode($strJsonFileContents);

        $data = [];
        $data['partner_college'] = $partner_colleges;
        $data['loan_partners'] = $lendingPartners;
        $data['faqs'] = $faqs;
        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionInterestFree()
    {
        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'interest_free.json');
        $interest_free = json_decode($strJsonFileContents, true);

        $header = $interest_free['header'];
        $header['image'] = Url::to('@eyAssets/images/pages/education-loans/' . $header['image'], 'https');

        $why_interest = $interest_free['why_interest_free'];
        $why_interest['image'] = Url::to('@eyAssets/images/pages/custom/' . $why_interest['image'], 'https');
        foreach ($why_interest['icons'] as $k => $v) {
            $why_interest['icons'][$k]['icon'] = Url::to('@eyAssets/images/pages/custom/' . $v['icon'], 'https');
        }

        $benefits = $interest_free['benefits'];

        $lending_partners = $interest_free['lending_partners'];
        foreach ($lending_partners as $k => $v) {
            if ($v['image'] == 'AG-logo.png' || $v['image'] == 'ezcapital.png') {
                $lending_partners[$k]['image'] = Url::to('@eyAssets/images/pages/index2/' . $v['image'], 'https');
            } else {
                $lending_partners[$k]['image'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['image'], 'https');
            }
        }

        $partner_colleges = $interest_free['partner_colleges'];
        foreach ($partner_colleges as $k => $v) {
            $partner_colleges[$k]['image'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['image'], 'https');
        }

        $data = [];
        $data['header'] = $header;
        $data['why_interest'] = $why_interest;
        $data['benefits'] = $benefits;
        $data['lending_partners'] = $lending_partners;
        $data['partner_colleges'] = $partner_colleges;

        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionRefinance()
    {
        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'refinance.json');
        $refinance = json_decode($strJsonFileContents, true);

        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'lending_partners.json');
        $lendingPartners = json_decode($strJsonFileContents, true);

        $header = $refinance['header'];
        $header['image'] = Url::to('@eyAssets/images/pages/education-loans/finance.png', 'https');

        $student_loan = $refinance['student_loan'];
        $student_loan['image'] = Url::to('@eyAssets/images/pages/education-loans/loan-application-form.png', 'https');

        $process_ease = $refinance['process_ease'];
        foreach ($process_ease as $k => $v) {
            $process_ease[$k]['icon'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['icon'], 'https');
        }

        $when_to_refinance = $refinance['when_to_refinance'];

        $benefits = $refinance['benefits'];

        foreach ($lendingPartners as $k => $v) {
            if ($v['image'] == 'AG-logo.png' || $v['image'] == 'ezcapital.png' || $v['image'] == 'phf-leasing.png') {
                $lendingPartners[$k]['org_logo'] = Url::to('@eyAssets/images/pages/index2/' . $v['image'], 'https');
            } else {
                $lendingPartners[$k]['org_logo'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['image'], 'https');
            }
            $lendingPartners[$k]['organization_enc_id'] = 'empoweryouth';
            $lendingPartners[$k]['initials_color'] = '#ea52ce';
        }

        $data = [];
        $data['header'] = $header;
        $data['student_loans'] = $student_loan;
        $data['process_ease'] = $process_ease;
        $data['process_ease_header'] = 'How To Refinance Your Education Loan';
        $data['when_to_refinance'] = $when_to_refinance;
        $data['benefits'] = $benefits;
        $data['benefits_image'] = Url::to('@eyAssets/images/pages/education-loans/fin-img.png', 'https');
        $data['lending_partners'] = $lendingPartners;

        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionEnquiryForm()
    {
        $user_id = $this->userId();

        $data = Yii::$app->request->post();

        if (!$data) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $model = new LeadsApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->application_enc_id = $enc_id = $utilitiesModel->encrypt();
        $model->application_number = date('ymd') . time();
        if ($user_id) {
            $model->created_by = $user_id;
        }

        $model->first_name = $data['first_name'];
        $model->last_name = $data['last_name'];
        $model->student_mobile_number = $data['phone'];
        $model->student_email = $data['student_email'];
        $model->loan_for = $data['loan_for'];
        $model->admission_taken = $data['admission_taken'];
        $model->college_institute_name = $data['college_name'];
        $model->course_name = $data['course_name'];
        if (isset($data['apply_now']) && $data['apply_now']) {
            $model->loan_amount = $data['loan_amount'];
        }
        if ($user_id) {
            $model->last_updated_by = $user_id;
        }
        if ($model->save()) {
            if ($data['clg_prefs']) {
                $i = 1;
                foreach ($data['clg_prefs'] as $c) {
                    $clg_pref = new LeadsCollegePreference();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $clg_pref->preference_enc_id = $utilitiesModel->encrypt();
                    $clg_pref->application_enc_id = $model->application_enc_id;
                    $clg_pref->sequence = parse_str($i);
                    $clg_pref->college_name = $c;
                    if ($user_id) {
                        $clg_pref->created_by = $user_id;
                    }
                    if (!$clg_pref->save()) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                    $i++;
                }
            }

            return $this->response(200, ['status' => 200, 'app_enc_id' => $model->application_enc_id]);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
        }
    }

    public function actionStudyInIndia()
    {

        $params = Yii::$app->request->post();

        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'loan_options.json');
        $loanTable = json_decode($strJsonFileContents, true);

        $chooseEducationLoan = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'choose_education_loan.json');
        $chooseEducationLoan = json_decode($chooseEducationLoan, true);

        $loanStudyWhy = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'loan_why_study.json');
        $loanStudyWhy = json_decode($loanStudyWhy, true);

        $whyIcons = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'why_icons.json');
        $whyIcons = json_decode($whyIcons, true);

        $loanEase = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'loan_ease.json');
        $loanEase = json_decode($loanEase, true);

        foreach ($whyIcons as $k => $v) {
            $whyIcons[$k]['icon'] = Url::to('@eyAssets/images/pages/custom/' . $v['icon'], 'https');
        }

        foreach ($loanEase as $k => $v) {
            $loanEase[$k]['icon'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['icon'], 'https');
        }

        foreach ($loanTable as $k => $v) {

            $loanTable[$k]['bank_financier'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['bank_financier'], 'https');
            if ($v['bank_financier'] == 'AG-logo.png') {
                $loanTable[$k]['bank_financier'] = Url::to('@eyAssets/images/pages/index2/' . $v['bank_financier'], 'https');
            }
        }

        foreach ($chooseEducationLoan as $key => $val) {
            $chooseEducationLoan[$key]['icon'] = Url::to('@eyAssets/images/pages/education-loans/' . $val['icon'], 'https');
        }

        $whyData = null;
        $bg_image = Url::to('@eyAssets/images/pages/education-loans/study-u.png', 'https');
        if (isset($params['country']) && !empty($params['country'])) {
            $whyData = $loanStudyWhy[$params['country']];
            $whyData['image'] = Url::to('@eyAssets/images/pages/custom/' . $whyData['image'], 'https');
            $bg_image = Url::to('@eyAssets/images/pages/education-loans/' . $whyData['bg_image'], 'https');
        }

        if ($whyData) {
            $data = ['loanTable' => $loanTable, 'chooseEducationLoan' => $chooseEducationLoan, 'study_why' => $whyData, 'bg_image' => $bg_image, 'why_icons' => $whyIcons, 'loan_ease_process' => $loanEase, 'loan_ease_process_header' => 'We Are Here To Ease Your Loan Process'];
        } else {
            $data = ['loanTable' => $loanTable, 'chooseEducationLoan' => $chooseEducationLoan, 'bg_image' => $bg_image, 'why_icons' => $whyIcons, 'loan_ease_process' => $loanEase, 'loan_ease_process_header' => 'We Are Here To Ease Your Loan Process'];
        }


        return $this->response(200, $data);
    }

    public function actionFaqs()
    {
        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'loan_faqs.json');
        $faqs = json_decode($strJsonFileContents, true);

        if ($faqs) {
            return $this->response(200, $faqs);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionPressReleasePublisher()
    {
        $limit = 3;
        $page = 1;
        $params = Yii::$app->request->post();

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = (int)$params['limit'];
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = (int)$params['page'];
        }

        $press_release = PressReleasePubliser::find()
            ->select(['name', 'link', 'sequence',
                'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->pressPublishers->logo, 'https') . '", logo_location, "/", logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=random&color=ffffff") END logo'
            ])
            ->where(['is_deleted' => 0])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->orderBy('sequence')
            ->asArray()
            ->all();

        if ($press_release) {
            return $this->response(200, $press_release);
        }

        return $this->response(404, 'not found');

    }

    public function actionSchoolFeeFinance()
    {
        $schoolFee = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'school_fee.json');
        $schoolFee = json_decode($schoolFee, true);

        $header = $schoolFee['header'];
        $header['image'] = Url::to('@eyAssets/images/pages/education-loans/schoolfee.png', 'https');

        $schoolFeeFinance = $schoolFee['school_fee'];
        $schoolFeeFinance['image'] = Url::to('@eyAssets/images/pages/education-loans/sf-icon.png', 'https');

        $benefits = $schoolFee['benefits'];

        $lendingPartners = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'lending_partners.json');
        $lendingPartners = json_decode($lendingPartners, true);

        foreach ($lendingPartners as $k => $v) {
            if ($v['image'] == 'AG-logo.png' || $v['image'] == 'ezcapital.png' || $v['image'] == 'phf-leasing.png') {
                $lendingPartners[$k]['org_logo'] = Url::to('@eyAssets/images/pages/index2/' . $v['image'], 'https');
            } else {
                $lendingPartners[$k]['org_logo'] = Url::to('@eyAssets/images/pages/education-loans/' . $v['image'], 'https');
            }
            $lendingPartners[$k]['organization_enc_id'] = 'empoweryouth';
            $lendingPartners[$k]['initials_color'] = '#ea52ce';
        }

        $chooseEducationLoan = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'choose_education_loan.json');
        $chooseEducationLoan = json_decode($chooseEducationLoan, true);

        foreach ($chooseEducationLoan as $key => $val) {
            $chooseEducationLoan[$key]['icon'] = Url::to('@eyAssets/images/pages/education-loans/' . $val['icon'], 'https');
        }

        $data = [];
        $data['header'] = $header;
        $data['schoolFeeFinance'] = $schoolFeeFinance;
        $data['benefits'] = $benefits;
        $data['lending_partners'] = $lendingPartners;
        $data['chooseEducationLoan'] = $chooseEducationLoan;
        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionSaveTeachersLoan()
    {
        $params = Yii::$app->request->post();
        if ($params) {
            $model = new LoanApplicationsForm();
            $orgDate = $params['applicant_dob'];
            $userId = $this->userId();
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                $model->months = (($params['months']) ? $params['months'] : null);
                if ($model->validate()) {
                    if ($data = $model->saveTeachersLoan($userId, 'Android', $params)) {
                        if ($data['status']) {
                            $data["name"] = "Empower Youth";
                            $data["description"] = "Application Processing Fee";
                            $data["image"] = Url::to("/assets/common/logos/eylogo2.png", 'https');
                            $data['theme_color'] = "#ff7803";
                            return $this->response(200, ['status' => 200, 'data' => $data]);
                        } else {
                            return $this->response(500, ['status' => 500, 'message' => $data['message']]);
                        }
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Missing information']);
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information']);
        }
    }

    public function actionApply()
    {
        try {
            $params = Yii::$app->request->post();
            $userId = $this->userId();

            // saving school loan
            if (isset($params['loan_type']) && $params['loan_type'] == 0) {
                if ($params) {
                    if ($params['is_applicant'] != 1) {
                        $params['child_information'][0]['child_name'] = $params['applicant_name'];
                        $params['child_information'][0]['child_class'] = $params['child_class'];
                        $params['child_information'][0]['child_school'] = $params['child_school'];
                        $params['child_information'][0]['child_loan_amount'] = $params['amount'];
                    }
                    $model = new LoanApplicationsForm();
//                    $orgDate = $params['applicant_dob'];
                    if ($model->load(Yii::$app->request->post(), '')) {
                        $model->applicant_dob = null;
//                        $model->yearly_income = $params['yearly_income'];
                        if ($model->validate()) {
                            if ($data = $model->saveSchoolFeeLoan($userId, 'Android', $params)) {
                                if ($data['status']) {
                                    $data['loan_app_enc_id'] = implode(',', $data['loan_app_enc_id']);
                                    $data['education_loan_payment_enc_id'] = implode(',', $data['education_loan_payment_enc_id']);
                                    $data["name"] = "Empower Youth";
                                    $data["description"] = "Application Processing Fee";
                                    $data["image"] = Url::to("/assets/common/logos/eylogo2.png", 'https');
                                    $data['theme_color'] = "#ff7803";
                                    return $this->response(200, ['status' => 200, 'data' => $data]);
                                } else {
                                    return $this->response(500, ['status' => 500, 'message' => $data['message']]);
                                }
                            }
                            return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                        }
                        return $this->response(409, ['status' => 409, $model->getErrors()]);
                    }
                    return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
                } else {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information']);
                }
            }

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
        } catch (\Exception $e) {
            return $this->response(500, ['error' => $e]);
        }
    }

}