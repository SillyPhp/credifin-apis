<?php

namespace api\modules\v3\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use api\modules\v3\models\Courses;
use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\AssignedLoanProvider;
use common\models\CertificateTypes;
use common\models\Cities;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\EducationLoanPayments;
use common\models\extended\CloneLoanApplication;
use common\models\InstituteLeadsPayments;
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
use common\models\PathToOpenLeads;
use common\models\PathToUnclaimOrgLoanApplication;
use common\models\spaces\Spaces;
use common\models\States;
use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\Utilities;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

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
                'save-teachers-loan' => ['POST', 'OPTIONS'],
                'save-school-fee-loan' => ['POST', 'OPTIONS'],
                'get-loan' => ['POST', 'OPTIONS'],
                'loan-second-form' => ['POST', 'OPTIONS'],
                'upload-image' => ['POST', 'OPTIONS'],
                'update-institute-payment' => ['POST', 'OPTIONS'],
                'refinance' => ['POST', 'OPTIONS'],
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
            return $this->response(404, ['status' => 404, 'message' => 'Parameters Not Found']);
        }
    }

    public function actionSaveWidgetApplication()
    {
        $params = Yii::$app->request->post();
        if ($params['id']) {
            $college_id = $params['id'];
            $orgDate = $params['applicant_dob'];
            $model = new LoanApplicationsForm();
            $modelOrg = new OrganizationList();
            $userId = (($params['userID']) ? $params['userID'] : null);
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                $model->college_course_enc_id = $modelOrg->getAssigneWidgetCourse($model->college_course_enc_id, $college_id);
                if (!$model->college_course_enc_id) {
                    return $this->response(401, ['status' => 422, 'message' => 'Course Inforation Not Found']);
                }
                if ($model->validate()) {
                    if ($data = $model->add(1, $userId, $college_id, 'CollegeWebsite')) {
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
            $loan_applications = LoanApplications::find()
                ->where(['in','loan_app_enc_id', $loan_app_id])
                ->all();
            if ($loan_applications) {
                foreach ($loan_applications as $loan_application){
                    $loan_application->status = 0;
                    $loan_application->updated_by = null;
                    $loan_application->updated_on = date('Y-m-d H:i:s');
                    $loan_application->update();
                    $params['loan_app_enc_id'] = $loan_application->loan_app_enc_id;
                    $params['name'] = $loan_application->applicant_name;
                    $params['email'] = $loan_application->email;
                }
            }
            Yii::$app->notificationEmails->educationLoanThankYou($params);
        }

        $loan_payment = EducationLoanPayments::find()
            ->where(['in','education_loan_payment_enc_id' ,$loan_payment_id])
            ->all();
        if ($loan_payment) {
            foreach ($loan_payment as $loan_payments){
                $loan_payments->payment_id = (($params['payment_id']) ? $params['payment_id'] : null);
                $loan_payments->payment_status = $params['status'];
                $loan_payments->payment_signature = $params['signature'];
                $loan_payments->updated_by = null;
                $loan_payments->updated_on = date('Y-m-d H:i:s');
                $loan_payments->update();
            }
        }
        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionCoursePoolList()
    {
        $get = Courses::get();
        if ($get) {
            return $this->response(200, ['status' => 200, 'course' => $get]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionSaveApplication()
    {
        $params = Yii::$app->request->post();
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
                $pref = $params['clg_pref'];
            }
            $orgDate = $params['applicant_dob'];
            $userId = (($params['userID']) ? $params['userID'] : null);
            if (!$params['is_india']) {
                $model->country_enc_id = $params['country_enc_id'];
            }
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = null;
                if ($model->validate()) {
                    if ($data = $model->add($params['is_addmission_taken'], $userId, $parser['college_id'], 'Ey', $parser['is_claim'], $course_name, $pref, $params['refferal_id'],$params['is_applicant'],$params['getLender'])) {
                        if ($data['status']){
                            return $this->response(200, ['status' => 200, 'data' => $data]);
                        }else{
                            return $this->response(500, ['status' => 500, 'message' => $data['message']]);
                        }
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

    public function actionSaveTeachersLoan()
    {
        $params = Yii::$app->request->post();
        if ($params) {
            $model = new LoanApplicationsForm();
            $orgDate = $params['applicant_dob'];
            $userId = (($params['userID']) ? $params['userID'] : null);
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                $model->months = (($params['months']) ? $params['months'] : null);
                $model->employement_type = $params['employement_type'];
                if ($model->validate()) {
                    if ($data = $model->saveTeachersLoan($userId, 'Ey', $params)) {
                        if ($data['status']) {
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
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionSaveSchoolFeeLoan(){
        $params = Yii::$app->request->post();
        if ($params){
            $model = new LoanApplicationsForm();
            $orgDate = $params['applicant_dob'];
            $userId = (($params['userID']) ? $params['userID'] : null);
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = null;
                $model->yearly_income = $params['yearly_income'];
                if ($model->validate()) {
                    if ($data = $model->saveSchoolFeeLoan( $userId,'Ey',$params)) {
                        if ($data['status']){
                            return $this->response(200, ['status' => 200, 'data' => $data]);
                        }else{
                            return $this->response(500, ['status' => 500, 'message' => $data['message']]);
                        }
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
                'a.gender',
                'DATE_FORMAT(a.applicant_dob, \'%d-%b-%Y\') applicant_dob',
                'a.degree',
                'a.phone',
                'a.image',
                'a.image_location',
                'a.email',
                'c1.course_name',
            ])
            ->joinWith(['pathToClaimOrgLoanApplications c' => function ($c) {
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
                $d->groupBy(['d.loan_co_app_enc_id']);
            }])
            ->joinWith(['loanCertificates e' => function ($e) {
                $e->select(['e.certificate_enc_id', 'e.loan_app_enc_id', 'e.certificate_type_enc_id', 'e1.name', 'e.number', 'e.proof_image image', 'e.proof_image_location image_location']);
                $e->joinWith(['certificateTypeEnc e1'], false);
                $e->onCondition(['e.is_deleted' => 0]);
                $e->orderBy(['e.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanCandidateEducations f' => function ($f) {
                $f->select(['f.loan_candidate_edu_enc_id', 'f.loan_app_enc_id', 'f.qualification_enc_id', 'f.institution', 'f.obtained_marks', 'f1.name', 'f.proof_image image', 'f.proof_image_location image_location']);
                $f->joinWith(['qualificationEnc f1'], false);
                $f->onCondition(['f.is_deleted' => 0]);
                $f->orderBy(['f.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanApplicantResidentialInfos g' => function ($g) {
                $g->select(['g.loan_app_res_info_enc_id', 'g.is_sane_cur_addr', 'g.loan_app_enc_id', 'g.loan_co_app_enc_id', 'g.residential_type', 'g.type', 'g.address', 'g.city_enc_id', 'g.state_enc_id', 'g1.name state_name', 'g2.name city_name']);
                $g->joinWith(['stateEnc g1'], false);
                $g->joinWith(['cityEnc g2'], false);
                $g->onCondition(['g.is_deleted' => 0]);
                $g->orderBy(['g.created_on' => SORT_ASC]);
            }])
            ->where(['a.loan_app_enc_id' => $params['loan_app_enc_id'], 'a.is_deleted' => 0])
            ->groupBy(['a.loan_app_enc_id'])
            ->asArray()
            ->one();

        if ($application) {
            if ($application['image']) {
//                return Yii::$app->params->upload_directories->loans;
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
            if ($application['loanCandidateEducations']) {
                foreach ($application['loanCandidateEducations'] as $j => $c) {
                    if ($c['image']) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof . $c['image_location'] . '/' . $c['image'];
                        $application['loanCandidateEducations'][$j]['image'] = $image;
                    }
                }
            }
        }

        if ($application) {
            return $this->response(200, ['status' => 200, 'data' => $application]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function getFile($image_location, $file_name)
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
        $url = $s3->getObjectUrl($bucketName, $image_location . '/' . $file_name);
        return $url;
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


        switch ($type) {
            case 'applicant' :
                $result = $this->saveApplicant($user_id, $params, $id);
                break;
            case 'id_proof' :
                $result = $this->saveIdProof($user_id, $params, $id);
                break;
            case 'address' :
                $result = $this->saveAddress($user_id, $params, $id);
                break;
            case 'qualification' :
                $result = $this->saveQualification($user_id, $params, $id);
                break;
            case 'co_applicant' :
                $result = $this->saveCoApplicant($user_id, $params, $id);
                break;
            default :
                $result = false;
        }
        if ($result) {
            return $this->response(200, ['status' => 200, 'id' => ($id)?$id:$result]);
        }
    }

    private function saveApplicant($user_id, $params, $id = null)
    {
        $model = LoanApplications::findOne(['loan_app_enc_id' => $params['loan_app_id']]);
        $model->updated_by = $user_id;
        $model->updated_on = date('Y-m-d H:i:s');
        $model->gender = $params['gender'] ? $params['gender'] : $model->gender;
        $model->phone = $params['phone'] ? $params['phone'] : $model->phone;
        if ($model->save()) {
            return true;
        }
        return false;
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
                $update_res_info->is_sane_cur_addr = $params['is_sane_cur_addr'] ? $params['is_sane_cur_addr'] : $update_res_info->residential_type;
                $update_res_info->residential_type = $params['address_type'] ? $params['address_type'] : $update_res_info->residential_type;
                $update_res_info->type = ($params['res_type'] != null) ? $params['res_type'] : $update_res_info->type;
                $update_res_info->address = $params['address'] ? $params['address'] : $update_res_info->address;
                if ($params['state_id'] && $params['state_id'] != $update_res_info->state_enc_id) {
                    $update_res_info->state_enc_id = $params['state_id'] ? $params['state_id'] : $update_res_info->state_enc_id;
                    $update_res_info->city_enc_id = NULL;
                } else {
                    $update_res_info->city_enc_id = $params['city_id'] ? $params['city_id'] : $update_res_info->city_enc_id;
                }
                $update_res_info->updated_by = $user_id;
                $update_res_info->updated_on = date('Y-m-d H:i:s');
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
            $education->institution = $params['institution'] ? $params['institution'] : $education->institution;
            $education->obtained_marks = $params['obtained_marks'] ? $params['obtained_marks'] : $education->obtained_marks;
            $education->updated_by = $user_id;
            $education->updated_on = date('Y-m-d H:i:s');
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
            if ($params['co_applicant_dob']) {
                $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['co_applicant_dob']));
            }
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

            $loan_co_applicants->name = $params['name'] ? $params['name'] : $loan_co_applicants->name;
            $loan_co_applicants->email = $params['email'] ? $params['email'] : $loan_co_applicants->email;
            $loan_co_applicants->phone = $params['phone'] ? $params['phone'] : $loan_co_applicants->phone;
            $loan_co_applicants->employment_type = $params['employment_type'] ? $params['employment_type'] : $loan_co_applicants->employment_type;
            $loan_co_applicants->annual_income = $params['annual_income'] ? $params['annual_income'] : $loan_co_applicants->annual_income;
            if ($params['co_applicant_dob']) {
                $coAppDOB = date('Y-m-d', strtotime($params['co_applicant_dob']));
                $loan_co_applicants->co_applicant_dob = $coAppDOB;
            }
            $loan_co_applicants->years_in_current_house = $params['years_in_current_house'] ? $params['years_in_current_house'] : $loan_co_applicants->years_in_current_house;
            $loan_co_applicants->occupation = $params['occupation'] ? $params['occupation'] : $loan_co_applicants->occupation;
            $loan_co_applicants->address = ($params['address'] != null) ? $params['address'] : $loan_co_applicants->address;
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

        $image = UploadedFile::getInstanceByName('image');
        $image_ext = $image->extension;

        if(!$image_ext){
            $image_ext = 'pdf';
        }

        $image_temp = $image->tempName;
        if ($res = $this->upload($user_id, $params, $image_temp, $image_ext)) {
            return $this->response(200, ['status' => 200, 'id' => $res['id'], 'fileUrl' => $res['fileUrl']]);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
        }

    }

    private function upload($user_id, $params, $file, $image_ext)
    {

        if ($params['type'] == 'co_applicant') {

            $co_applicant = "";
            if (isset($params['id']) && !empty($params['id']) && $params['id'] != '') {
                $co_applicant = LoanCoApplicants::find()
                    ->where(['loan_co_app_enc_id' => $params['id']])
                    ->one();
            }

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
                    if ($co_applicant->update()) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $co_applicant->image, "public");
                        return ['id' => $co_applicant->loan_co_app_enc_id, 'fileUrl' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . $base_path . $co_applicant->image];
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
                    $co_applicant->relation = $params['relation'];
                    $co_applicant->image = $encrypted_string . '.' . $image_ext;
                    $co_applicant->image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->image . $co_applicant->image_location . '/';
                    $co_applicant->created_by = $user_id;
                    $co_applicant->created_on = date('Y-m-d H:i:s');
                    if ($co_applicant->save()) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $co_applicant->image, "public");
                        return ['id' => $co_applicant->loan_co_app_enc_id, 'fileUrl' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . $base_path . $co_applicant->image];
                    } else {
                        print_r($co_applicant->getErrors());
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

                    $proof->proof_image_name = $params['image_name'];
                    $proof->proof_image = $encrypted_string . '.' . $image_ext;
                    $proof->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->proof . $proof->proof_image_location . '/';
                    $proof->updated_by = $user_id;
                    $proof->updated_on = date('Y-m-d H:i:s');
                    if ($proof->update()) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $proof->proof_image, "public");
                        return ['id' => $proof->certificate_enc_id, 'fileUrl' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . $base_path . $proof->proof_image];
                    } else {
                        print_r($proof->getErrors());
                        die();
                    }
                }
            }
        } else if ($params['type'] == 'qualification') {
            if (isset($params['id']) && !empty($params['id'])) {
                $proof = LoanCandidateEducation::find()
                    ->where(['loan_candidate_edu_enc_id' => $params['id']])
                    ->one();

                if ($proof) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }

                    $proof->proof_image_name = $params['image_name'];
                    $proof->proof_image = $encrypted_string . '.' . $image_ext;
                    $proof->proof_image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->loans->proof . $proof->proof_image_location . '/';
                    $proof->updated_by = $user_id;
                    $proof->updated_on = date('Y-m-d H:i:s');
                    if ($proof->update()) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $proof->proof_image, "public");
                        return ['id' => $proof->loan_candidate_edu_enc_id, 'fileUrl' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . $base_path . $proof->proof_image];
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
                if ($loan_applicant->update()) {
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_applicant->image, "public");
                    return ['id' => $loan_applicant->loan_app_enc_id, 'fileUrl' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . $base_path . $loan_applicant->image];
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

    public function actionGetStates($search = null)
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09']);
        if ($search != null && $search != '') {
            $states->andWhere(['like', 'name', $search]);
        }
        $states = $states->limit(10)->asArray()
            ->all();
        return $states;
    }

    public function actionGetCities($search = null, $state_id)
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['a.city_enc_id', 'a.name'])
            ->joinWith(['stateEnc b'], false)
            ->where(['b.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])
            ->andWhere(['b.state_enc_id' => $state_id]);
        if ($search != null && $search != '') {
            $cities->andWhere(['like', 'a.name', $search]);
        }
        $cities = $cities->limit(10)->asArray()
            ->all();
        return $cities;
    }

    public function actionUpdateInstitutePayment()
    {
        $params = Yii::$app->request->post();
        if ($params) {
            $loan_payments = InstituteLeadsPayments::find()
                ->where(['payment_enc_id' => $params['payment_enc_id']])
                ->one();
            if ($loan_payments) {
                $loan_payments->payment_id = (($params['payment_id']) ? $params['payment_id'] : null);
                $loan_payments->payment_status = $params['status'];
                $loan_payments->payment_signature = (($params['signature']) ? $params['signature'] : null);
                $loan_payments->updated_by = null;
                $loan_payments->updated_on = date('Y-m-d H:i:s');
                $loan_payments->update();
            }
            return $this->response(200, ['status' => 200, 'message' => 'success']);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'No Params Found']);
        }
    }

    public function actionRefinance()
    {
        try {
            $cloneLoanModel = new CloneLoanApplication();

            $params = Yii::$app->request->post();

            if (!isset($params['loan_app_id']) || !isset($params['amount']) || !isset($params['year']) || !isset($params['semester']) || !isset($params['user_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $loan_data = $cloneLoanModel->_getLoanData($params['loan_app_id']);
            $loan_data['amount'] = $params['amount'];
            $loan_data['years'] = $params['year'];
            $loan_data['semesters'] = $params['semester'];
            $loan_data['user_id'] = $params['user_id'];


            if ($cloneLoanModel->_saveApplication($loan_data)) {
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            }
        } catch (\Exception $e) {
            return $this->response(500, ['status' => 500, 'message' => $e->getMessage()]);
        }

    }
}