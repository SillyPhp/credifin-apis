<?php


namespace common\models\extended;


use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplications;
use common\models\LoanCandidateEducation;
use common\models\LoanCertificates;
use common\models\LoanCoApplicants;
use common\models\PathToClaimOrgLoanApplication;
use common\models\PathToOpenLeads;
use common\models\PathToUnclaimOrgLoanApplication;
use Yii;

class CloneLoanApplication extends LoanApplications
{
    public function _getLoanData($loan_id)
    {
        $loan_data = LoanApplications::find()
            ->alias('a')
            ->select([
                'a.loan_app_enc_id',
                'a.had_taken_addmission',
                'a.loan_type_enc_id',
                'a.applicant_name',
                'a.employement_type',
                'a.image',
                'a.image_location',
                'a.applicant_dob',
                'a.applicant_current_city',
                'a.degree',
                'a.years',
                'a.months',
                'a.semesters',
                'a.phone',
                'a.email',
                'a.cibil_score',
                'a.gender',
                'a.yearly_income',
                'a.aadhaar_number',
                'a.source',
                'a.ask_guarantor_info',
                'a.aadhaar_link_phone_number',
                'a.loan_type',
            ])
            ->joinWith(['loanCoApplicants b' => function ($b) {
                $b->select([
                    'b.loan_co_app_enc_id',
                    'b.loan_app_enc_id',
                    'b.name',
                    'b.email',
                    'b.cibil_score',
                    'b.phone',
                    'b.relation',
                    'b.employment_type',
                    'b.annual_income',
                    'b.co_applicant_dob',
                    'b.image',
                    'b.image_location',
                    'b.years_in_current_house',
                    'b.occupation',
                    'b.address',
                    'b.pan_number',
                    'b.aadhaar_number',
                    'b.aadhaar_link_phone_number'
                ]);
                $b->joinWith(['loanCertificates de' => function ($de) {
                    $de->select(['de.certificate_enc_id', 'de.loan_co_app_enc_id', 'de.certificate_type_enc_id',
                        'de.number', 'de.proof_image_name', 'de.proof_image', 'de.proof_image_location', 'de.proof_of']);
                    $de->joinWith(['certificateTypeEnc de1'], false);
                    $de->onCondition(['de.is_deleted' => 0]);
                }]);
                $b->joinWith(['loanApplicantResidentialInfos dg' => function ($dg) {
                    $dg->select(['dg.loan_app_res_info_enc_id', 'dg.loan_app_enc_id', 'dg.loan_co_app_enc_id',
                        'dg.residential_type', 'dg.type', 'dg.address', 'dg.city_enc_id', 'dg.state_enc_id', 'dg.is_sane_cur_addr']);
                    $dg->onCondition(['dg.is_deleted' => 0]);
                }]);
            }])
            ->joinWith(['loanCertificates e' => function ($e) {
                $e->select([
                    'e.certificate_enc_id', 'e.loan_app_enc_id', 'e.certificate_type_enc_id',
                    'e.number', 'e.proof_image_name', 'e.proof_image', 'e.proof_image_location', 'proof_of'
                ]);
                $e->onCondition(['e.is_deleted' => 0]);
            }])
            ->joinWith(['loanCandidateEducations f' => function ($f) {
                $f->select(['f.loan_candidate_edu_enc_id', 'f.loan_app_enc_id', 'f.qualification_enc_id', 'f.institution',
                    'f.obtained_marks', 'f.proof_image', 'f.proof_image_name', 'f.proof_image_location']);
                $f->onCondition(['f.is_deleted' => 0]);
            }])
            ->joinWith(['loanApplicantResidentialInfos g' => function ($g) {
                $g->select(['g.loan_app_res_info_enc_id', 'g.loan_app_enc_id', 'g.loan_co_app_enc_id', 'g.residential_type',
                    'g.type', 'g.address', 'g.city_enc_id', 'g.state_enc_id', 'g.is_sane_cur_addr']);
                $g->joinWith(['stateEnc g1'], false);
                $g->joinWith(['cityEnc g2'], false);
                $g->onCondition(['g.is_deleted' => 0]);
            }])
            ->joinWith(['pathToClaimOrgLoanApplications h' => function ($h) {
                $h->select(['h.bridge_enc_id', 'h.loan_app_enc_id', 'h.assigned_course_enc_id', 'h.country_enc_id']);
                $h->onCondition(['h.is_deleted' => 0]);
            }])
            ->joinWith(['pathToOpenLeads i' => function ($i) {
                $i->select(['i.bridge_enc_id', 'i.loan_app_enc_id', 'i.course_name', 'i.country_enc_id']);
                $i->onCondition(['i.is_deleted' => 0]);
            }])
            ->joinWith(['pathToUnclaimOrgLoanApplications j' => function ($j) {
                $j->select(['j.bridge_enc_id', 'j.loan_app_enc_id', 'j.assigned_course_enc_id', 'j.country_enc_id']);
                $j->onCondition(['j.is_deleted' => 0]);
            }])
            ->where(['a.loan_app_enc_id' => $loan_id])
            ->asArray()
            ->one();

        return $loan_data;
    }

    public function _saveApplication($data)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $loan = new LoanApplications();
            $loan->loan_app_enc_id = Yii::$app->security->generateRandomString(32);
            $loan->parent_application_enc_id = $data['loan_app_enc_id'];
            $loan->had_taken_addmission = $data['had_taken_addmission'];
            $loan->loan_type_enc_id = $data['loan_type_enc_id'];
            $loan->applicant_name = $data['applicant_name'];
            $loan->employement_type = $data['employement_type'];
            $loan->image = $data['image'];
            $loan->image_location = $data['image_location'];
            $loan->applicant_dob = $data['applicant_dob'];
            $loan->applicant_current_city = $data['applicant_current_city'];
            $loan->degree = $data['degree'];
            $loan->years = $data['years'];
            $loan->months = $data['months'];
            $loan->semesters = $data['semesters'];
            $loan->amount = $data['amount'];
            $loan->phone = $data['phone'];
            $loan->email = $data['email'];
            $loan->cibil_score = $data['cibil_score'];
            $loan->gender = $data['gender'];
            $loan->yearly_income = $data['yearly_income'];
            $loan->aadhaar_number = $data['aadhaar_number'];
            $loan->source = $data['source'];
            $loan->ask_guarantor_info = $data['ask_guarantor_info'];
            $loan->aadhaar_link_phone_number = $data['aadhaar_link_phone_number'];
            $loan->loan_type = $data['loan_type'];
            $loan->created_by = $data['user_id'];
            $loan->created_on = date('Y-m-d H:i:s');
            if (!$loan->save()) {
                $transaction->rollback();
                throw new \Exception(json_encode($loan->getErrors()));
            }

            if ($data['pathToClaimOrgLoanApplications']) {

                $pathToClaim = new PathToClaimOrgLoanApplication();
                $pathToClaim->bridge_enc_id = Yii::$app->security->generateRandomString(32);
                $pathToClaim->loan_app_enc_id = $loan->loan_app_enc_id;
                $pathToClaim->assigned_course_enc_id = $data['pathToClaimOrgLoanApplications'][0]['assigned_course_enc_id'];
                $pathToClaim->country_enc_id = $data['pathToClaimOrgLoanApplications'][0]['country_enc_id'];
                $pathToClaim->created_by = $data['user_id'];
                if (!$pathToClaim->save()) {
                    $transaction->rollback();
                    throw new \Exception(json_encode($pathToClaim->getErrors()));
                }

            } elseif ($data['pathToOpenLeads']) {

                $pathToLeads = new PathToOpenLeads();
                $pathToLeads->bridge_enc_id = Yii::$app->security->generateRandomString(32);
                $pathToLeads->loan_app_enc_id = $loan->loan_app_enc_id;
                $pathToLeads->course_name = $data['pathToOpenLeads'][0]['course_name'];
                $pathToLeads->country_enc_id = $data['pathToOpenLeads'][0]['country_enc_id'];
                $pathToLeads->created_by = $data['user_id'];
                if (!$pathToLeads->save()) {
                    $transaction->rollback();
                    throw new \Exception(json_encode($pathToLeads->getErrors()));
                }

            } elseif ($data['pathToUnclaimOrgLoanApplications']) {

                $pathToUnclaim = new PathToUnclaimOrgLoanApplication();
                $pathToUnclaim->bridge_enc_id = Yii::$app->security->generateRandomString(32);
                $pathToUnclaim->loan_app_enc_id = $loan->loan_app_enc_id;
                $pathToUnclaim->assigned_course_enc_id = $data['pathToUnclaimOrgLoanApplications'][0]['assigned_course_enc_id'];
                $pathToUnclaim->country_enc_id = $data['pathToUnclaimOrgLoanApplications'][0]['country_enc_id'];
                $pathToUnclaim->created_by = $data['user_id'];
                if (!$pathToUnclaim->save()) {
                    $transaction->rollback();
                    throw new \Exception(json_encode($pathToUnclaim->getErrors()));
                }
            }

            if ($data['loanCertificates']) {
                foreach ($data['loanCertificates'] as $cer) {
                    $this->_saveCertificates($cer, $data['user_id'], $transaction, $loan->loan_app_enc_id, null);
                }
            }

            if ($data['loanApplicantResidentialInfos']) {
                foreach ($data['loanApplicantResidentialInfos'] as $r) {
                    $this->_saveResInfo($r, $data['user_id'], $transaction, $loan->loan_app_enc_id, null);
                }
            }

            if ($data['loanCandidateEducations']) {
                foreach ($data['loanCandidateEducations'] as $e) {
                    $loanEdu = new LoanCandidateEducation();
                    $loanEdu->loan_candidate_edu_enc_id = Yii::$app->security->generateRandomString(32);
                    $loanEdu->loan_app_enc_id = $loan->loan_app_enc_id;
                    $loanEdu->qualification_enc_id = $e['qualification_enc_id'];
                    $loanEdu->institution = $e['institution'];
                    $loanEdu->obtained_marks = $e['obtained_marks'];
                    $loanEdu->proof_image = $e['proof_image'];
                    $loanEdu->proof_image_name = $e['proof_image_name'];
                    $loanEdu->proof_image_location = $e['proof_image_location'];
                    $loanEdu->created_by = $data['user_id'];
                    $loanEdu->created_on = date('Y-m-d H:i:s');
                    if (!$loanEdu->save()) {
                        $transaction->rollback();
                        throw new \Exception(json_encode($loanEdu->getErrors()));
                    }
                }
            }

            if ($data['loanCoApplicants']) {
                foreach ($data['loanCoApplicants'] as $co) {
                    $coApplicant = new LoanCoApplicants();
                    $coApplicant->loan_co_app_enc_id = Yii::$app->security->generateRandomString(32);
                    $coApplicant->loan_app_enc_id = $loan->loan_app_enc_id;
                    $coApplicant->name = $co['name'];
                    $coApplicant->email = $co['email'];
                    $coApplicant->cibil_score = $co['cibil_score'];
                    $coApplicant->phone = $co['phone'];
                    $coApplicant->relation = $co['relation'];
                    $coApplicant->employment_type = $co['employment_type'];
                    $coApplicant->annual_income = $co['annual_income'];
                    $coApplicant->co_applicant_dob = $co['co_applicant_dob'];
                    $coApplicant->image = $co['image'];
                    $coApplicant->image_location = $co['image_location'];
                    $coApplicant->years_in_current_house = $co['years_in_current_house'];
                    $coApplicant->occupation = $co['occupation'];
                    $coApplicant->address = $co['address'];
                    $coApplicant->pan_number = $co['pan_number'];
                    $coApplicant->aadhaar_number = $co['aadhaar_number'];
                    $coApplicant->aadhaar_link_phone_number = $co['aadhaar_link_phone_number'];
                    if (!$coApplicant->save()) {
                        $transaction->rollback();
                        throw new \Exception(json_encode($coApplicant->getErrors()));
                    }

                    if ($co['loanCertificates']) {
                        foreach ($co['loanCertificates'] as $cer) {
                            $this->_saveCertificates($cer, $data['user_id'], $transaction, null, $coApplicant->loan_co_app_enc_id);
                        }
                    }

                    if ($co['loanApplicantResidentialInfos']) {
                        foreach ($co['loanApplicantResidentialInfos'] as $r) {
                            $this->_saveResInfo($r, $data['user_id'], $transaction, null, $coApplicant->loan_co_app_enc_id);
                        }
                    }
                }
            }

            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function _saveCertificates($certificate, $user_id, $transaction, $loan_app_id = null, $co_app_id = null)
    {
        $loanCertificates = new LoanCertificates();
        $loanCertificates->certificate_enc_id = Yii::$app->security->generateRandomString(32);
        if ($loan_app_id != null) {
            $loanCertificates->loan_app_enc_id = $loan_app_id;
        } else {
            $loanCertificates->loan_co_app_enc_id = $co_app_id;
        }
        $loanCertificates->certificate_type_enc_id = $certificate['certificate_type_enc_id'];
        $loanCertificates->number = $certificate['number'];
        $loanCertificates->proof_image_name = $certificate['proof_image_name'];
        $loanCertificates->proof_image = $certificate['proof_image'];
        $loanCertificates->proof_image_location = $certificate['proof_image_location'];
        $loanCertificates->proof_of = $certificate['proof_of'];
        $loanCertificates->created_by = $user_id;
        $loanCertificates->created_on = date('Y-m-d H:i:s');
        if (!$loanCertificates->save()) {
            $transaction->rollback();
            throw new \Exception(json_encode($loanCertificates->getErrors()));
        }

        return true;
    }

    public function _saveResInfo($res, $user_id, $transaction, $loan_app_id = null, $co_app_id = null)
    {
        $residentialInfo = new LoanApplicantResidentialInfo();
        $residentialInfo->loan_app_res_info_enc_id = Yii::$app->security->generateRandomString(32);
        if ($loan_app_id != null) {
            $residentialInfo->loan_app_enc_id = $loan_app_id;
        } else {
            $residentialInfo->loan_co_app_enc_id = $co_app_id;
        }
        $residentialInfo->residential_type = $res['residential_type'];
        $residentialInfo->type = $res['type'];
        $residentialInfo->address = $res['address'];
        $residentialInfo->city_enc_id = $res['city_enc_id'];
        $residentialInfo->state_enc_id = $res['state_enc_id'];
        $residentialInfo->is_sane_cur_addr = $res['is_sane_cur_addr'];
        $residentialInfo->created_by = $user_id;
        $residentialInfo->created_on = date('Y-m-d H:i:s');
        if (!$residentialInfo->save()) {
            $transaction->rollback();
            throw new \Exception(json_encode($residentialInfo->getErrors()));
        }

    }
}