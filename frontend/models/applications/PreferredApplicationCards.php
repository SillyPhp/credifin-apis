<?php

namespace frontend\models\applications;

use frontend\models\employerApplications\EmployerApplicationsSearch;
use Yii;
use yii\helpers\Url;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Cities;

class PreferredApplicationCards
{
    public static function jobs($options = [])
    {
        return self::_getCardsFromJobs($options);
    }

    public function getDataProvider($options, $filters)
    {
        $modelSearch = new EmployerApplicationsSearch();
        $dataProvider = $modelSearch->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['z.is_deleted' => 0, 'a.name' => 'Jobs', 'e.assigned_to' => 'Jobs']);
        $dataProvider->query->select([
            'z.created_on', 'z.application_enc_id application_id', 'z.type',
            'n1.html_code',
            'GROUP_CONCAT(DISTINCT(aa1.skill) SEPARATOR ",") skill', 'g.name category',
            'CONCAT("/job/", z.slug) link',
            'f.name as title',
            'z.last_date',
            'k.industry',
            'CONCAT(1) percentage',
            'g.icon',
            '(CASE
                    WHEN z.experience = "0" THEN "No Experience"
                    WHEN z.experience = "1" THEN "Less Than 1 Year Experience"
                    WHEN z.experience = "2" THEN "1 Year Experience"
                    WHEN z.experience = "3" THEN "2-3 Years Experience"
                    WHEN z.experience = "3-5" THEN "3-5 Years Experience"
                    WHEN z.experience = "5-10" THEN "5-10 Years Experience"
                    WHEN z.experience = "10-20" THEN "10-20 Years Experience"
                    WHEN z.experience = "20+" THEN "More Than 20 Years Experience"
                    ELSE "No Experience"
               END) as experience', 'z.organization_enc_id', 'z.unclaimed_organization_enc_id',
            '(CASE WHEN d.name IS NOT NULL THEN d.name ELSE q.name END) as city',
        ]);
        if (isset($filters['job_titles'])) {
            $dataProvider->query->andWhere(['in', 'f.name', $filters['job_titles']]);
        }
        if (isset($filters['profiles'])) {
            $dataProvider->query->andWhere(['in', 'g.name', $filters['profiles']]);
        }
        if (isset($filters['industries'])) {
            $dataProvider->query->andWhere(['in', 'k.industry', $filters['industries']]);
        }
        if (isset($filters['skills'])) {
            $dataProvider->query->andWhere(['in', 'aa1.skill', $filters['skills']]);
        }
        if (isset($filters['experience'])) {
            $dataProvider->query->andWhere(['z.experience' => $filters['experience']]);
        }
        if (isset($filters['timings_from'])) {
            $dataProvider->query->andWhere(['z.timings_from' => $filters['timings_from']]);
        }
        if (isset($filters['timings_to'])) {
            $dataProvider->query->andWhere(['z.timings_to' => $filters['timings_to']]);
        }
        if (isset($filters['work_type'])) {
            $dataProvider->query->andWhere(['z.type' => $filters['work_type']]);
        }
        if (isset($filters['cities'])) {
            $dataProvider->query->andWhere(['in', 'd.name', $filters['cities']]);
        }

        if (isset($filters['limit'])) {
            $dataProvider->query->limit($filters['limit']);
        }

        if ($options['dataType'] == 'ai') {
            $dataProvider->query->andWhere(['z.unclaimed_organization_enc_id' => null]);
            $dataProvider->query->andWhere(['not', ['z.interview_process_enc_id' => null]]);
            if (isset($filters['min_wage'])) {
                $dataProvider->query->andWhere(['n.min_wage' => $filters['min_wage']]);
            }
            if (isset($filters['max_wage'])) {
                $dataProvider->query->andWhere(['n.max_wage' => $filters['max_wage']]);
            }
            if (isset($filters['salary'])) {
                $dataProvider->query->andWhere(['n.fixed_wage' => $filters['salary']]);
            }
            $dataProvider->query->addSelect([
                'CONCAT("/", h.slug) organization_link',
                'h.initials_color color',
                'n.fixed_wage as fixed_salary',
                'n.wage_type salary_type',
                'n.max_wage as max_salary',
                'n.min_wage as min_salary',
                'n.wage_duration as salary_duration',
                'h.name as organization_name',
                'CASE WHEN h.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", h.logo_location, "/", h.logo) ELSE NULL END logo',
            ]);
        } else if ($options['dataType'] == 'quick') {
            $dataProvider->query->andWhere(['z.unclaimed_organization_enc_id' => null, 'z.interview_process_enc_id' => null]);
            if (isset($filters['min_wage'])) {
                $dataProvider->query->andWhere(['n.min_wage' => $filters['min_wage']]);
            }
            if (isset($filters['max_wage'])) {
                $dataProvider->query->andWhere(['n.max_wage' => $filters['max_wage']]);
            }
            if (isset($filters['salary'])) {
                $dataProvider->query->andWhere(['n.fixed_wage' => $filters['salary']]);
            }
            $dataProvider->query->addSelect([
                'CONCAT("/", h.slug) organization_link',
                'h.initials_color color',
                'n.fixed_wage as fixed_salary',
                'n.wage_type salary_type',
                'n.max_wage as max_salary',
                'n.min_wage as min_salary',
                'n.wage_duration as salary_duration',
                'h.name as organization_name',
                'CASE WHEN h.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", h.logo_location, "/", h.logo) ELSE NULL END logo',
            ]);
        } else if ($options['dataType'] == 'mis') {
            $dataProvider->query->andWhere(['not', ['z.unclaimed_organization_enc_id' => null]]);
            $dataProvider->query->andWhere(['r.user_of' => 'MIS']);
            if (isset($filters['working_days'])) {
                $dataProvider->query->andWhere(['n.working_days' => $filters['working_days']]);
            }
            if (isset($filters['min_wage'])) {
                $dataProvider->query->andWhere(['nn.min_wage' => $filters['min_wage']]);
            }
            if (isset($filters['max_wage'])) {
                $dataProvider->query->andWhere(['nn.max_wage' => $filters['max_wage']]);
            }
            if (isset($filters['salary'])) {
                $dataProvider->query->andWhere(['nn.fixed_wage' => $filters['salary']]);
            }
            $dataProvider->query->addSelect([
                'CONCAT("/", o.slug) organization_link',
                'o.initials_color color',
                'nn.fixed_wage as fixed_salary',
                'nn.wage_type salary_type',
                'nn.max_wage as max_salary',
                'nn.min_wage as min_salary',
                'nn.wage_duration as salary_duration',
                'o.name as organization_name',
                'CASE WHEN o.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", o.logo_location, "/", o.logo) ELSE NULL END logo',
            ]);
        } else if ($options['dataType'] == 'free') {
            $dataProvider->query->andWhere(['not', ['z.unclaimed_organization_enc_id' => null]]);
            $dataProvider->query->andWhere(['z.created_by' => NULL]);
            if (isset($filters['min_wage'])) {
                $dataProvider->query->andWhere(['nn.min_wage' => $filters['min_wage']]);
            }
            if (isset($filters['max_wage'])) {
                $dataProvider->query->andWhere(['nn.max_wage' => $filters['max_wage']]);
            }
            if (isset($filters['working_days'])) {
                $dataProvider->query->andWhere(['n.working_days' => $filters['working_days']]);
            }
            if (isset($filters['salary'])) {
                $dataProvider->query->andWhere(['nn.fixed_wage' => $filters['salary']]);
            }
            $dataProvider->query->addSelect([
                'CONCAT("/", o.slug) organization_link',
                'o.initials_color color',
                'nn.fixed_wage as fixed_salary',
                'nn.wage_type salary_type',
                'nn.max_wage as max_salary',
                'nn.min_wage as min_salary',
                'nn.wage_duration as salary_duration',
                'o.name as organization_name',
                'CASE WHEN o.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", o.logo_location, "/", o.logo) ELSE NULL END logo',
            ]);
        }
        if (isset($options['limit'])) {
            $dataProvider->query->limit($options['limit']);
        }
        return $dataProvider->query->groupBy('z.application_enc_id')->distinct()->asArray()->all();
    }


    private static function _getCardsFromJobs($options)
    {
        $userId = Yii::$app->user->identity->user_enc_id;
        $locations = [];
        $resumeSkills = [];
        $filters = [];

        $controllerId = Yii::$app->controller->id;
        $actionId = Yii::$app->controller->action->id;
        switch ([$controllerId, $actionId]) {
            case ['jobs', 'preferred-list'] :
                if (!empty($options['location'])) {
                    $optLocations = explode(", ", $options['location']);
                    foreach ($optLocations as $loc) {
                        array_push($locations, $loc);
                    }
                }
                if ($userId) {
                    $resumeData = Yii::$app->userData->getResumeData($userId);
                    $job_preference = Yii::$app->userData->getPreference($userId, $options['type']);
                    if (!empty($job_preference) || !empty($resumeData)) {
                        if (!empty($job_preference['locations'])) {
                            foreach ($job_preference['locations'] as $loc) {
                                $expLoc = explode(", ", $loc);
                                foreach ($expLoc as $el) {
                                    array_push($locations, $el);
                                }
                            }
                        }
                        if (!empty($resumeData['userSkills'])) {
                            $resumeSkills = ArrayHelper::getColumn($resumeData['userSkills'], 'skill');
                        }

                        $filters['job_titles'] = [];
                        if (!empty($resumeData['userWorkExperiences'])) {
                            foreach ($resumeData['userWorkExperiences'] as $exp) {
                                array_push($filters['job_titles'], $exp['title']);
                                array_push($locations, $exp['city'], $exp['state'], $exp['country']);
                            }
                        }

                        $locations = array_unique($locations);
                        $filters['profiles'] = $job_preference['profiles'];
                        $filters['industries'] = $job_preference['industries'];
                        $filters['skills'] = array_unique(array_merge($job_preference['skills'], $resumeSkills));
                        $filters['working_days'] = $job_preference['working_days'];
                        $filters['experience'] = $job_preference['experience'];
                        $filters['min_expected_salary'] = $job_preference['min_expected_salary'];
                        $filters['max_expected_salary'] = $job_preference['max_expected_salary'];
                        $filters['timings_from'] = $job_preference['timings_from'];
                        $filters['timings_to'] = $job_preference['timings_to'];
                        $filters['salary'] = $job_preference['salary'];
                        $filters['work_type'] = $job_preference['work_type'];
                    }
                }
                break;
            default :
                if (!empty($options['location'])) {
                    $optLocations = explode(", ", $options['location']);
                    foreach ($optLocations as $loc) {
                        array_push($locations, $loc);
                    }
                }
        }

        if (!empty($locations)) {
            $filters['cities'] = [];
            $filters['states'] = [];
            $filters['countries'] = [];
            foreach ($locations as $loc) {
//                $chkCountries = Countries::findOne(['name' => $loc]);
//                if ($chkCountries) {
//                    array_push($filters['countries'], $chkCountries['name']);
//                }
//                $chkStates = States::findOne(['name' => $loc]);
//                if ($chkStates) {
//                    array_push($filters['states'], $chkStates['name']);
//                }
                $chkCities = Cities::findOne(['name' => $loc]);
                if ($chkCities) {
                    array_push($filters['cities'], $chkCities['name']);
                }
            }
        }

        $data = [];
        $filters = array_filter($filters);
        $filter_keys = array_keys($filters);
        $filter_combos = Yii::$app->filterCombinations->getFilterCombos($filter_keys);
        foreach ($filter_combos as $combo) {
            $flip_combo = array_flip($combo);
            $filter_combo = array_diff_key($filters, $flip_combo);
            $ai_jobs = self::getDataProvider($options, $filter_combo);
            if ($ai_jobs) {
                foreach ($ai_jobs as $ai) {
                    array_push($data, $ai);
                }
            }
            if (count($data) >= 6) {
                break;
            }
        }
//        $quick_jobs = self::getDataProvider('quick', $filters);
//        $mis_jobs = self::getDataProvider('mis', $filters);
//        $free_jobs = self::getDataProvider('free', $filters);

        $result = array_slice($data, 0, $options['limit']);
        $i = 0;
        foreach ($result as $val) {
            $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
            $currency = (($val['html_code']) ? $val['html_code'] : '₹ ');
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] * 12 . ' p.a.';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] . ' Per Hour';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] . ' Per Week';
                } else {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] . ' p.a.';
                }
            } elseif ($val['salary_type'] == "Negotiable") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $currency . (string)$val['min_salary'] * 12 . " - " . $currency . (string)$val['max_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . " - " . $currency . (string)($val['max_salary']) . ' Per Hour';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . " - " . $currency . (string)($val['max_salary']) . ' Per Week';
                    } else {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . " - " . $currency . (string)($val['max_salary']) . ' p.a.';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $currency . (string)$val['min_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . ' Per Hour';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . ' Per Week';
                    } else {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . ' p.a.';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $currency . (string)$val['max_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $currency . (string)($val['max_salary']) . ' Per Hour';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $currency . (string)($val['max_salary']) . ' Per Week';
                    } else {
                        $result[$i]['salary'] = $currency . (string)($val['max_salary']) . ' p.a.';
                    }
                }
            }
            $i++;
        }
        return $result;
    }
}