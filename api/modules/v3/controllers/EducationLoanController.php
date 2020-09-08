<?php

namespace api\modules\v3\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use api\modules\v3\models\Courses;
use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\AssignedLoanProvider;
use common\models\CertificateTypes;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
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
use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class EducationLoanController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-course-list' => ['POST', 'OPTIONS'],
                'get-fee-components' => ['POST', 'OPTIONS'],
                'save-widget-application' => ['POST', 'OPTIONS'],
                'update-widget-loan-application' => ['POST', 'OPTIONS'],
                'loan-applications' => ['POST', 'OPTIONS'],
                'course-pool-list' => ['GET'],
                'save-application' => ['POST', 'OPTIONS'],
                'get-loan' => ['POST', 'OPTIONS'],
                'loan-second-form' => ['POST', 'OPTIONS'],
                'upload-image' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetCourseList()
    {
        $params = Yii::$app->request->post();
        if ($params['id']) {
            $courses = AssignedCollegeCourses::find()
                ->alias('a')
                ->select(['a.assigned_college_enc_id college_course_enc_id', 'b.course_name'])
                ->joinWith(['courseEnc b'], false, 'INNER JOIN')
                ->where(['a.organization_enc_id' => $params['id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();
            if ($courses) {
                return $this->response(200, ['status' => 200, 'courses' => $courses]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionGetFeeComponents()
    {
        $params = Yii::$app->request->post();
        $college_id = $params['id'];
        if ($college_id) {
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
                return $this->response(200, ['status' => 200, 'fee_components' => $fee_components, 'loan_types' => $loan_types]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionSaveWidgetApplication()
    {
        $params = Yii::$app->request->post();
        if ($params['id']) {
            $college_id = $params['id'];
            $orgDate = $params['applicant_dob'];
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                if ($model->validate()) {
                    if ($data = $model->add(null, $college_id, 'CollegeWebsite')) {
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionUpdateWidgetLoanApplication()
    {
        $params = Yii::$app->request->post();
        if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
            $loan_app_id = $params['loan_app_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if (isset($params['loan_payment_id']) && !empty($params['loan_payment_id'])) {
            $loan_payment_id = $params['loan_payment_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
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
            $loan_payments->updated_by = null;
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            $loan_payments->update();
        }
        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionCoursePoolList()
    {
        $get = Courses::get();
        if ($get) {
            return $get;
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionSaveApplication()
    {
        $params = Yii::$app->request->post();
        if ($params) {
            $organizationObject = new OrganizationList();
            $courseObject = new Courses();
            $options = [];
            $options['name'] = $params['college_name'];
            $org = $organizationObject->getOrgId($options);
            $college_id = $org['id'];
            if (!$college_id) {
                return $this->response(500, ['status' => 500, 'message' => 'Error in Getting College Information']);
            }
            $orgDate = $params['applicant_dob'];
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                if ($model->validate()) {
                    if ($data = $model->add(null, $college_id, 'Ey', $org['is_claim'])) {
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
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
                'a.applicant_dob',
                'a.degree',
                'a.phone',
                'a.email',
                'c1.course_name',
            ])
            ->innerJoinWith(['pathToClaimOrgLoanApplications c' => function ($c) {
                $c->joinWith(['createdBy b' => function ($b) {
                    $b->joinWith(['userOtherInfo b1']);
                }], false);
                $c->joinWith(['assignedCourseEnc cc' => function ($cc) {
                    $cc->joinWith(['courseEnc c1']);
                }]);
            }], false)
            ->joinWith(['loanCoApplicants d' => function ($d) {
                $d->select([
                    'd.loan_co_app_enc_id',
                    'd.loan_app_enc_id',
                    'd.name',
                    'd.relation',
                    'd.email',
                    'd.phone',
                    'd.co_applicant_dob',
                    'd.employment_type',
                    'd.annual_income',
                    'd.address'
                ]);
                $d->joinWith(['loanCertificates de' => function ($e) {
                    $e->select(['de.certificate_enc_id', 'de.loan_co_app_enc_id', 'de.certificate_type_enc_id', 'de1.name', 'de.number']);
                    $e->joinWith(['certificateTypeEnc de1'], false);
                    $e->onCondition(['de.is_deleted' => 0]);
                }]);
                $d->joinWith(['loanApplicantResidentialInfos dg' => function ($g) {
                    $g->select(['dg.loan_app_res_info_enc_id', 'dg.loan_app_enc_id', 'dg.loan_co_app_enc_id', 'dg.residential_type', 'dg.type', 'dg.address', 'dg.city_enc_id', 'dg.state_enc_id']);
                    $g->onCondition(['dg.is_deleted' => 0]);
                }]);
            }])
            ->joinWith(['loanCertificates e' => function ($e) {
                $e->select(['e.certificate_enc_id', 'e.loan_app_enc_id', 'e.certificate_type_enc_id', 'e1.name', 'e.number']);
                $e->joinWith(['certificateTypeEnc e1'], false);
                $e->onCondition(['e.is_deleted' => 0]);
            }])
            ->joinWith(['loanCandidateEducations f' => function ($f) {
                $f->select(['f.loan_candidate_edu_enc_id', 'f.loan_app_enc_id', 'f.qualification_enc_id', 'f.institution', 'f.obtained_marks', 'f1.name']);
                $f->joinWith(['qualificationEnc f1'], false);
                $f->onCondition(['f.is_deleted' => 0]);
            }])
            ->joinWith(['loanApplicantResidentialInfos g' => function ($g) {
                $g->select(['g.loan_app_res_info_enc_id', 'g.loan_app_enc_id', 'g.loan_co_app_enc_id', 'g.residential_type', 'g.type', 'g.address', 'g.city_enc_id', 'g.state_enc_id']);
                $g->onCondition(['g.is_deleted' => 0]);
            }])
            ->where(['a.loan_app_enc_id' => $params['loan_app_enc_id'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($application) {
            $application['applicant_dob'] = date('d/m/Y', strtotime($application['applicant_dob']));
            return $this->response(200, ['status' => 200, 'data' => $application]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function actionLoanSecondForm()
    {
        $params = Yii::$app->request->post();

        if (isset($params['user_enc_id']) && !empty($params['user_enc_id'])) {
            $user_id = $params['user_enc_id'];
        } else {
            if ($user = $this->isAuthorized()) {
                $user_id = $user->user_enc_id;
            } else {
                return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
            }
        }

        if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if (!isset($params['type']) && empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $type = $params['type'];
        $id = $params['id'];

        if ($type == 'id_proof') {
            $id = $this->saveIdProof($user_id, $params, $id);
            if ($id) {
                return $this->response(200, ['status' => 200, 'id' => $id]);
            }
        } elseif ($type == 'address') {
            $id = $this->saveAddress($user_id, $params, $id);
            if ($id) {
                return $this->response(200, ['status' => 200, 'id' => $id]);
            }
        } elseif ($type == 'qualification') {
            $id = $this->saveQualification($user_id, $params, $id);
            if ($id) {
                return $this->response(200, ['status' => 200, 'id' => $id]);
            }
        } elseif ($type == 'co_applicant') {
            $id = $this->saveCoApplicant($user_id, $params, $id);
            if ($id) {
                return $this->response(200, ['status' => 200, 'id' => $id]);
            }
        }
    }

    private function saveIdProof($user_id, $params, $id = null)
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
                $loan_certificates->updated_by = $user_id;
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
            $loan_certificates->created_by = $user_id;
            $loan_certificates->created_on = date('Y-m-d H:i:s');
            if ($loan_certificates->save()) {
                return $loan_certificates->certificate_enc_id;
            } else {
                print_r($loan_certificates->getErrors());
                return false;
            }

        }
    }

    private function saveAddress($user_id, $params, $id = null)
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
            $res_info->created_by = $user_id;
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
                $update_res_info->residential_type = $params['address_type'];
                $update_res_info->type = $params['res_type'];
                $update_res_info->address = $params['address'];
                $update_res_info->city_enc_id = $params['city_id'];
                $update_res_info->state_enc_id = $params['state_id'];
                $update_res_info->created_by = $user_id;
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

    private function saveQualification($user_id, $params, $id = null)
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
            $education->created_by = $user_id;
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
            $education->institution = $params['institution'];
            $education->obtained_marks = $params['obtained_marks'];
            $education->created_by = $user_id;
            $education->created_on = date('Y-m-d H:i:s');
            if ($education->update()) {
                return $education->loan_candidate_edu_enc_id;
            } else {
                print_r($education->getErrors());
                return false;
            }

        }
    }

    private function saveCoApplicant($user_id, $params, $id = null)
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
            $loan_co_applicants->co_applicant_dob = $params['co_applicant_dob'];
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'];
            $loan_co_applicants->occupation = $params['occupation'];
            $loan_co_applicants->address = $params['address'];
            $loan_co_applicants->created_by = $user_id;
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

            $loan_co_applicants->name = $params['name'];
            $loan_co_applicants->email = $params['email'];
            $loan_co_applicants->phone = $params['phone'];
            $loan_co_applicants->employment_type = $params['employment_type'];
            $loan_co_applicants->annual_income = $params['annual_income'];
            $loan_co_applicants->co_applicant_dob = $params['co_applicant_dob'];
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'];
            $loan_co_applicants->occupation = $params['occupation'];
            $loan_co_applicants->address = $params['address'];
            $loan_co_applicants->updated_by = $user_id;
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

        if (isset($params['user_enc_id']) && !empty($params['user_enc_id'])) {
            $user_id = $params['user_enc_id'];
        } else {
            if ($user = $this->isAuthorized()) {
                $user_id = $user->user_enc_id;
            } else {
                return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
            }
        }

        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
        if (!isset($params['type']) && empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $image = UploadedFile::getInstanceByName('image');

        if ($id = $this->upload($user_id, $params, $image)) {
            return $this->response(200, ['status' => 200, 'id' => $id]);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
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
        } else {
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