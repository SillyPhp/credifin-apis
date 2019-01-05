<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\Url;
use common\models\EmployerApplications;

class Detail extends EmployerApplications {

    

    public function fields() {

        return [
            'application_enc_id',
            'name' => function($model) {
                $category = $model->getTitle()
                        ->select('b.name')
                        ->joinWith(['categoryEnc b'], false)
                        ->asArray()
                        ->one();

                return $category['name'];
            },
            'job_decription' => function($model) {
                $description = $model->getApplicationJobDescriptions()
                        ->select(['GROUP_CONCAT( DISTINCT j.job_description SEPARATOR ", ") descriptions'])
                        ->joinWith(['jobDescriptionEnc j'], false)
                        ->asArray()
                        ->one();
                return $description['descriptions'];
            },
            'educational_requirements' => function($model) {
                $requirements = $model->getApplicationEducationalRequirements()
                        ->select(['GROUP_CONCAT( DISTINCT a.educational_requirement SEPARATOR ", ") educational_requirements'])
                        ->joinWith(['educationalRequirementEnc a'], false)
                        ->asArray()
                        ->one();
                return $requirements['educational_requirements'];
            },
            'interview_locations' => function($model) {
                $location = $model->getApplicationPlacementLocations()
                        ->select(['GROUP_CONCAT(DISTINCT z.name SEPARATOR ", ") locations'])
                        ->joinWith(['locationEnc x' => function($y) {
                                $y->joinWith(['cityEnc z']);
                            }], false)
                        ->asArray()
                        ->one();
                return $location['locations'];
            },
            'salary' => function($model) {
                $salary = $model->getApplicationOptions()
                        ->select(['value salary'])
                        ->where(['option_name' => 'salary'])
                        ->asArray()
                        ->one();

                return $salary['salary'];
            },
            'salary' => function($model) {
                $salary = $model->getApplicationOptions()
                        ->select(['value salary'])
                        ->where(['option_name' => 'salary'])
                        ->asArray()
                        ->one();

                return $salary['salary'];
            },
            'ctc' => function($model) {
                $salary = $model->getApplicationOptions()
                        ->select(['value ctc'])
                        ->where(['option_name' => 'ctc'])
                        ->asArray()
                        ->one();

                return $salary['ctc'];
            },
            'working_days' => function($model) {
                $working_days = $model->getApplicationOptions()
                        ->select(['value working_days'])
                        ->where(['option_name' => 'working_days'])
                        ->asArray()
                        ->one();

                return $working_days['working_days'];
            },
            'organization' => function($model) {
                if ($model->organizationEnc->logo) {
                    $logo = Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . $model->organizationEnc->logo_locatoin . $model->organizationEnc->logo;
                } else {
                    $logo = NULL;
                }
                return [
                    'name' => $model->organizationEnc->name,
                    'logo' => $logo,
                    'initials_color' => $model->organizationEnc->initials_color,
                ];
            },
            'designation' => function($model) {
                return $model->designationEnc->designation;
            },
            'industry' => function($model) {
                return $model->preferredIndustry->industry;
            },
            'experience' => function($model) {
                switch ($model->experience) {
                    case '0':
                        return "No Experience";
                    case '1':
                        return "Less than 1 Year Experience";
                    case '2':
                        return "1 Year Experience";
                    case '3':
                        return "2-3 Years Experience";
                    case '3-5':
                        return "3-5 Years Experience";
                    case '5-10':
                        return "5-10 Years Experience";
                    case '10+':
                        return "10+ Years Experience";
                    default:
                        return "No Experience";
                }
            },
            'type' => function($model) {
                return $model->type;
            },
            'gender' => function($model) {
                return $model->preferred_gender;
            },
            'total_vacancy' => function($model) {
                $vacancy = $model->getApplicationPlacementLocations()
                        ->select(['SUM(positions) vacancies'])
                        ->asArray()
                        ->one();
                return $vacancy['vacancies'];
            }
        ];
    }

}
