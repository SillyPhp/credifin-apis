<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\Designations;
use common\models\EmployerApplications;
use common\models\Industries;
use common\models\Organizations;
use common\models\Posts;
use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class SearchController extends Controller
{

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $s = Yii::$app->request->post('keyword');
            $result = [];

            $organizations = Organizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'a.initials_color color'])
                ->joinWith(['organizationReviews f' => function ($y) {
                    $y->select(['f.organization_enc_id', 'f.average_rating', 'COUNT(f.review_enc_id) reviews_cnt']);
                    $y->andWhere(['f.status' => 1]);
                    $y->andWhere(['f.is_deleted' => 0]);
                }])
                ->joinWith(['employerApplications e' => function ($x) {
                    $x->select(['e.organization_enc_id', 'COUNT(e.application_enc_id) applications_cnt']);
                    $x->andWhere(['e.status' => 'Active']);
                    $x->andWhere(['e.is_deleted' => 0]);
                }])
                ->joinWith(['organizationTypeEnc b'], false)
                ->joinWith(['businessActivityEnc c'], false)
                ->joinWith(['industryEnc d'], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 'Active'
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'a.name', $s],
                    ['like', 'a.slug', $s],
                    ['like', 'a.website', $s],
                    ['like', 'b.organization_type', $s],
                    ['like', 'c.business_activity', $s],
                    ['like', 'd.industry', $s]
                ])
                ->groupBy(['a.organization_enc_id'])
                ->limit(8);

            $result['organizations'] = $organizations->asArray()->all();

            $jobs = EmployerApplications::find()
                ->alias('a')
                ->select([
                    'a.application_enc_id application_id',
                    'a.last_date',
                    'a.type',
                    'CONCAT("/job/", a.slug) link',
                    '(CASE
                    WHEN a.experience = "0" THEN "No Experience"
                    WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                    WHEN a.experience = "2" THEN "1 Year Experience"
                    WHEN a.experience = "3" THEN "2-3 Years Experience"
                    WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                    WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                    WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                    WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                    ELSE "No Experience"
                    END) as experience',
                    'c.initials_color color',
                    'CONCAT("/", c.slug) organization_link',
                    'c.name as organization_name',
                    'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", c.logo_location, "/", c.logo) ELSE NULL END logo',
                    'h.name category',
                    'g.name as title',
                    'e.designation',
                    'l.fixed_wage as fixed_salary',
                    'l.wage_type salary_type',
                    'l.max_wage as max_salary',
                    'l.min_wage as min_salary',
                    'l.wage_duration as salary_duration',
                    'i.location_enc_id location_id',
                    "k.name as city",
                ])
                ->joinWith(['applicationTypeEnc b'], false)
                ->joinWith(['organizationEnc c'], false)
                ->joinWith(['title d' => function ($x) {
                    $x->joinWith(['categoryEnc g'], false);
                    $x->joinWith(['parentEnc h'], false);
                }], false)
                ->joinWith(['designationEnc e'], false)
                ->joinWith(['preferredIndustry f'], false)
                ->joinWith(['applicationPlacementLocations i' => function ($x) {
                    $x->joinWith(['locationEnc j' => function ($x) {
                        $x->joinWith(['cityEnc k'], false);
                    }], false);
                }], false)
                ->joinWith(['applicationOptions l'], false)
                ->where([
                    'b.name' => 'Jobs',
                    'a.is_deleted' => 0,
                    'a.status' => 'Active'
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'a.slug', $s],
                    ['like', 'a.description', $s],
                    ['like', 'b.name', $s],
                    ['like', 'a.type', $s],
                    ['like', 'c.name', $s],
                    ['like', 'c.slug', $s],
                    ['like', 'c.website', $s],
                    ['like', 'g.name', $s],
                    ['like', 'h.name', $s],
                    ['like', 'g.slug', $s],
                    ['like', 'e.designation', $s],
                    ['like', 'e.slug', $s],
                    ['like', 'f.industry', $s],
                    ['like', 'f.slug', $s],
                    ['like', 'l.wage_type', $s],
                    ['like', 'l.wage_duration', $s],
                    ['like', 'j.location_name', $s],
                    ['like', 'j.address', $s],
                    ['like', 'k.name', $s],
                ])
                ->groupBy(['a.application_enc_id'])
                ->limit(6);

            $final_jobs = $jobs->asArray()->all();

            $i = 0;
            foreach ($final_jobs as $val) {
                $final_jobs[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] * 12;
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] * 40 * 52;
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] * 52;
                    } else {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'];
                    }
                } elseif ($val['salary_type'] == "Negotiable") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_jobs[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52);
                        } else {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']);
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_jobs[$i]['salary'] = (string)$val['min_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 52);
                        } else {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary']);
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_jobs[$i]['salary'] = (string)$val['max_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_jobs[$i]['salary'] = (string)($val['max_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_jobs[$i]['salary'] = (string)($val['max_salary'] * 52);
                        } else {
                            $final_jobs[$i]['salary'] = (string)($val['max_salary']);
                        }
                    }
                }
                $i++;
            }

            $result['jobs'] = $final_jobs;

            $internships = EmployerApplications::find()
                ->alias('a')
                ->select([
                    'a.application_enc_id application_id',
                    'a.last_date',
                    'a.type',
                    'CONCAT("/internship/", a.slug) link',
                    'c.initials_color color',
                    'CONCAT("/", c.slug) organization_link',
                    'c.name as organization_name',
                    'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", c.logo_location, "/", c.logo) ELSE NULL END logo',
                    'h.name category',
                    'g.name as title',
                    'l.fixed_wage as fixed_salary',
                    'l.wage_type salary_type',
                    'l.max_wage as max_salary',
                    'l.min_wage as min_salary',
                    'l.wage_duration as salary_duration',
                    'i.location_enc_id location_id',
                    "k.name as city",
                ])
                ->joinWith(['applicationTypeEnc b'], false)
                ->joinWith(['organizationEnc c'], false)
                ->joinWith(['title d' => function ($x) {
                    $x->joinWith(['categoryEnc g'], false);
                    $x->joinWith(['parentEnc h'], false);
                }], false)
                ->joinWith(['applicationPlacementLocations i' => function ($x) {
                    $x->joinWith(['locationEnc j' => function ($x) {
                        $x->joinWith(['cityEnc k'], false);
                    }], false);
                }], false)
                ->joinWith(['applicationOptions l'], false)
                ->where([
                    'b.name' => 'Internships',
                    'a.is_deleted' => 0,
                    'a.status' => 'Active'
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'a.slug', $s],
                    ['like', 'a.description', $s],
                    ['like', 'b.name', $s],
                    ['like', 'a.type', $s],
                    ['like', 'c.name', $s],
                    ['like', 'c.slug', $s],
                    ['like', 'c.website', $s],
                    ['like', 'g.name', $s],
                    ['like', 'h.name', $s],
                    ['like', 'g.slug', $s],
                    ['like', 'l.wage_type', $s],
                    ['like', 'l.wage_duration', $s],
                    ['like', 'j.location_name', $s],
                    ['like', 'j.address', $s],
                    ['like', 'k.name', $s],
                ])
                ->groupBy(['a.application_enc_id'])
                ->limit(6);

            $final_internships = $internships->asArray()->all();

            $i = 0;
            foreach ($final_internships as $val) {
                $final_internships[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $final_internships[$i]['salary'] = $val['fixed_salary'] * 12;
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $final_internships[$i]['salary'] = $val['fixed_salary'] * 40 * 52;
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $final_internships[$i]['salary'] = $val['fixed_salary'] * 52;
                    } else {
                        $final_internships[$i]['salary'] = $val['fixed_salary'];
                    }
                } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_internships[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_internships[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_internships[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52);
                        } else {
                            $final_internships[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']);
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_internships[$i]['salary'] = (string)$val['min_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_internships[$i]['salary'] = (string)($val['min_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_internships[$i]['salary'] = (string)($val['min_salary'] * 52);
                        } else {
                            $final_internships[$i]['salary'] = (string)($val['min_salary']);
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_internships[$i]['salary'] = (string)$val['max_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_internships[$i]['salary'] = (string)($val['max_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_internships[$i]['salary'] = (string)($val['max_salary'] * 52);
                        } else {
                            $final_internships[$i]['salary'] = (string)($val['max_salary']);
                        }
                    }
                }
                $i++;
            }

            $result['internships'] = $final_internships;

            $posts = Posts::find()
                ->select([
                    'title',
                    'CONCAT("/blog/", slug) link',
                    'excerpt',
                    'CASE WHEN featured_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image) . '", featured_image_location, "/", featured_image) ELSE NULL END image'
                ])
                ->where([
                    'status' => 'Active',
                    'is_deleted' => 0
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'title', $s],
                    ['like', 'slug', $s],
                    ['like', 'meta_keywords', $s],
                ])
                ->limit(3);

            $posts_filter = $posts->asArray()->all();

            $result['posts'] = $posts_filter;

            return json_encode($result);
        }
        return $this->render('index');
    }

}