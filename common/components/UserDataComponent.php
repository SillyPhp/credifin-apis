<?php

namespace common\components;

use common\models\Cities;
use common\models\LoanApplications;
use common\models\SelectedServices;
use common\models\Services;
use common\models\UserPreferences;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class UserDataComponent extends Component
{
    public function checkSelectedService($user_id, $name)
    {
        $chkPermission = SelectedServices::find()
            ->alias('z')
            ->select(['z.selected_service_enc_id', 'z.organization_enc_id', 'z.service_enc_id', 'z.is_selected', 'a.name', 'a.link'])
            ->innerJoinWith(['serviceEnc a' => function ($a) use ($name) {
                $a->andWhere(['a.name' => $name]);
            }], false)
            ->andWhere(['z.is_selected' => 1]);
        if (Yii::$app->user->identity->organization) {
            $chkPermission->andWhere(['z.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]);
        } else {
            $chkPermission->andWhere(['z.created_by' => $user_id]);
            $chkPermission->andWhere(['or',
                ['z.organization_enc_id' => NULL],
                ['z.organization_enc_id' => '']
            ]);
        }
        $chkPermission = $chkPermission->asArray()->one();
        return $chkPermission;
    }

    public function getPreference($user_id, $type)
    {
        $data = UserPreferences::find()
            ->alias('a')
            ->select([
                'a.preference_enc_id',
                'a.type',
                'a.assigned_to',
                'a.timings_from',
                'a.timings_to',
                'a.salary',
                'a.min_expected_salary',
                'a.max_expected_salary',
                'a.experience',
                'a.working_days',
                'c1.slug industry_slug',
            ])
            ->innerJoinWith(['userPreferredJobProfiles b' => function ($b) {
                $b->select(['b.preference_enc_id', 'b.job_profile_enc_id', 'b1.category_enc_id', 'b1.name']);
                $b->joinWith(['jobProfileEnc b1'], false);
                $b->andWhere(['b.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredIndustries c' => function ($c) {
                $c->select(['c.preference_enc_id', 'c.industry_enc_id', 'c1.industry']);
                $c->joinWith(['industryEnc c1'], false);
                $c->andWhere(['c.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredSkills d' => function ($d) {
                $d->select(['d.preference_enc_id', 'd.preferred_skill_enc_id', 'd1.skill_enc_id', 'd1.skill']);
                $d->joinWith(['skillEnc d1'], false);
                $d->andWhere(['d.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredLocations e' => function ($e) {
                $e->select(['e.preference_enc_id', 'e.city_enc_id', 'e1.name city_name', 'e2.name state_name', 'e3.name country_name']);
                $e->joinWith(['cityEnc e1' => function ($e1) {
                    $e1->joinWith(['stateEnc e2' => function ($e2) {
                        $e2->joinWith(['countryEnc e3']);
                    }]);
                }], false);
                $e->andWhere(['e.is_deleted' => 0]);
            }])
            ->andWhere(['a.is_deleted' => 0, 'a.created_by' => $user_id, 'a.assigned_to' => $type])
            ->asArray()
            ->one();
        $skills = [];
        $locations = [];
        $profiles = [];
        $industries = [];
        foreach ($data['userPreferredIndustries'] as $inds) {
            array_push($industries, $inds['industry']);
        }
        foreach ($data['userPreferredJobProfiles'] as $prof) {
            array_push($profiles, $prof['name']);
        }
        foreach ($data['userPreferredSkills'] as $s) {
            array_push($skills, $s['skill']);
        }
        foreach ($data['userPreferredLocations'] as $l) {
            $loc = $l['city_name'] . ", " . $l['state_name'] . ", " . $l['country_name'];
            array_push($locations, $loc);
        }
        return [
            'profiles' => array_unique($profiles),
            'industries' => array_unique($industries),
            'skills' => array_unique($skills),
            'locations' => array_unique($locations),
            'working_days' => $data['working_days'],
            'experience' => $data['experience'],
            'min_expected_salary' => $data['min_expected_salary'],
            'max_expected_salary' => $data['max_expected_salary'],
            'timings_from' => $data['timings_from'],
            'timings_to' => $data['timings_to'],
            'salary' => $data['salary'],
            'work_type' => $data['type'],
        ];
    }

    public function getResumeData($userId)
    {
        $data = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'a.city_enc_id', 'CONCAT(first_name," ",last_name) name', 'email', 'dob', 'phone', 'GROUP_CONCAT(DISTINCT(g.hobby) SEPARATOR ",") hobbies', 'GROUP_CONCAT(DISTINCT(h.interest) SEPARATOR ",") interests',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) ELSE NULL END image'
            ])
            ->joinWith(['userSkills b' => function ($b) {
                $b->select(['b.created_by', 'c.skill', 'b.user_skill_enc_id']);
                $b->andWhere(['b.is_deleted' => 0]);
                $b->joinWith(['skillEnc c'], false);
            }])
            ->joinWith(['userWorkExperiences d' => function ($b) {
                $b->joinWith(['cityEnc e' => function ($e) {
                    $e->joinWith(['stateEnc e1' => function ($e1) {
                        $e1->joinWith(['countryEnc e2']);
                    }]);
                }], false);
                $b->select(['d.created_by', 'd.experience_enc_id', 'd.title', 'd.description', 'd.company', 'd.from_date', 'd.to_date', 'd.is_current', 'e.name city', 'e1.name state', 'e2.name country']);
            }])
            ->joinWith(['userAchievements f' => function ($b) {
                $b->select(['f.user_enc_id', 'f.achievement', 'f.user_achievement_enc_id']);
                $b->andWhere(['f.is_deleted' => 0]);
            }])
            ->joinWith(['userHobbies g' => function ($b) {
                $b->select(['g.user_enc_id', 'g.hobby', 'g.user_hobby_enc_id']);
                $b->andWhere(['g.is_deleted' => 0]);
            }])
            ->joinWith(['userInterests h' => function ($b) {
                $b->select(['h.user_enc_id', 'h.interest', 'h.user_interest_enc_id']);
                $b->andWhere(['h.is_deleted' => 0]);
            }])
            ->joinWith(['userSpokenLanguages j' => function ($j) {
                $j->select(['j.user_language_enc_id', 'j.created_by', 'k.language']);
                $j->joinWith(['languageEnc k'], false);
                $j->andWhere(['j.is_deleted' => 0]);
            }])
            ->joinWith(['userEducations i'])
            ->where(['a.user_enc_id' => $userId])
            ->asArray()
            ->one();

        return $data;
    }

    public function loanApplication($app_id, $user_id){
        return LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.loan_app_enc_id',
                'a.applicant_name',
                '(CASE
                    WHEN a.gender = "1" THEN "Male"
                    WHEN a.gender = "2" THEN "Female"
                    ELSE "N/A"
                END) as gender',
                'DATE_FORMAT(a.applicant_dob, \'%d-%b-%Y\') applicant_dob',
                'a.degree',
                'a.phone',
                'a.image',
                'a.image_location',
                'a.email',
                'a.ask_guarantor_info',
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
            ->innerJoinWith(['educationLoanPayments elp' => function ($g) {
                $g->andWhere(['in', 'elp.payment_status', ['captured', 'created', 'waived off']]);
            }])
            ->andWhere(['a.loan_app_enc_id' => $app_id, 'a.created_by' => $user_id])
            ->asArray()
            ->one();
    }

    public function LoanApplicationObj(){
        return LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.loan_app_enc_id',
                'a.created_on',
                'a.loan_type',
                'a.amount',
                'a.applicant_name',
                '(CASE
                    WHEN a.gender = "1" THEN "Male"
                    WHEN a.gender = "2" THEN "Female"
                    ELSE "N/A"
                END) as gender',
                'DATE_FORMAT(a.applicant_dob, \'%d-%b-%Y\') applicant_dob',
                'a.degree',
                'a.phone',
                'a.image',
                'a.image_location',
                'a.email',
                'a.ask_guarantor_info',
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
            ->joinWith(['assignedLoanProviders alp' => function ($alp) {
                $alp->select(['alp.assigned_loan_provider_enc_id', 'alp.loan_application_enc_id', 'alp.status', 'alp1.name provider_name', 'alp1.logo_location lander_logo_location', 'alp1.logo lander_logo']);
                $alp->joinWith(['providerEnc alp1'], false);
                $alp->onCondition(['alp.is_deleted' => 0]);
                $alp->orderBy(['alp.created_on' => SORT_ASC]);
            }])
            ->joinWith(['loanApplicationNotifications lan' => function ($lan) {
                $lan->onCondition(['lan.is_deleted' => 0]);
                $lan->orderBy(['lan.created_on' => SORT_DESC]);
            }])
            ->innerJoinWith(['educationLoanPayments elp' => function ($g) {
                $g->andWhere(['in', 'elp.payment_status', ['captured', 'created']]);
            }]);
    }

    public function getCurrentCity(){
        $cityId = Yii::$app->user->identity->city_enc_id;
        if($cityId){
            return Cities::findOne(['city_enc_id' => $cityId]);
        }
        return false;
    }
}