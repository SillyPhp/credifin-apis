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
                'enquiry-form',
                'study-in-india'
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
                'a.gender'
//                'c1.course_name',
            ])
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
            }])
            ->joinWith(['loanCertificates e' => function ($e) {
                $e->select(['e.certificate_enc_id', 'e.loan_app_enc_id', 'e.certificate_type_enc_id', 'e1.name', 'e.number', 'e.proof_image_name', 'e.proof_image image', 'e.proof_image_location image_location']);
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
                    if ($c['image']) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . $c['image_location'] . '/' . $c['image'];
                        $application['loanCoApplicants'][$i]['image'] = $image;
                    }
                    if (!empty($c['loanCertificates'])) {
                        foreach ($c['loanCertificates'] as $jj => $cc) {
                            if ($cc['image']) {
                                $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof . $cc['image_location'] . '/' . $cc['image'];
                                $application['loanCoApplicants'][$i]['loanCertificates'][$jj]['image'] = $image;
                            }
                        }
                    }
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
        }

        if ($application) {
            return $this->response(200, $application);
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
        } elseif ($type == 'applicant') {
            $id = $this->updateLoanApplications($params);
            if ($id) {
                return $this->response(200, ['id' => $id]);
            }
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

            if (!empty($params['image'])) {
                $image_ext = $params['image_ext'];
                $image = base64_decode($params['image']);

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

        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
        if (!isset($params['type']) && empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

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
            ->select(['organization_enc_id', 'REPLACE(name, "&amp;", "&") as name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END org_logo', 'initials_color'])
            ->where(['is_deleted' => 0, 'has_loan_featured' => 1, 'status' => 'Active'])
            ->asArray()
            ->all();

        $loan_partners = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'REPLACE(a.name, "&amp;", "&") as name', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END org_logo', 'a.initials_color'])
            ->innerJoinWith(['selectedServices b' => function ($b) {
                $b->innerJoinWith(['serviceEnc c']);
            }], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'c.name' => 'Loans', 'b.is_selected' => 1])
            ->asArray()
            ->all();

        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'faqs.json');
        $faqs = json_decode($strJsonFileContents);


        $data = [];
        $data['partner_college'] = $partner_colleges;
        $data['loan_partners'] = $loan_partners;
        $data['faqs'] = $faqs;
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
        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'loan_options.json');
        $loanTable = json_decode($strJsonFileContents, true);

        $chooseEducationLoan = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'choose_education_loan.json');
        $chooseEducationLoan = json_decode($chooseEducationLoan, true);

        foreach ($loanTable as $k => $v) {

            $loanTable[$k]['bank_financier'] = 'https://www.empoweryouth.com/assets/themes/ey/images/pages/education-loans/' . $v['bank_financier'];
            if ($v['bank_financier'] == 'AG-logo.png') {
                $loanTable[$k]['bank_financier'] = 'https://www.empoweryouth.com/assets/themes/ey/images/pages/index2/' . $v['bank_financier'];
            }
        }

        foreach ($chooseEducationLoan as $key => $val) {
            $chooseEducationLoan[$key]['icon'] = 'https://www.empoweryouth.com/assets/themes/ey/images/pages/education-loans/' . $val['icon'];
        }

        return $this->response(200, ['loanTable' => $loanTable, 'chooseEducationLoan' => $chooseEducationLoan]);
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

}