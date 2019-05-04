<?php

namespace console\controllers;

use common\models\ApplicationTypes;
use common\models\EmployerApplications;
use common\models\Tags;
use common\models\Users;
use Yii;
use yii\console\Controller;
use yii\helpers\Url;

class DailyEmailsController extends Controller
{

    public function actionList()
    {
        $tags = new Tags();
        $tags->tag_enc_id = 'ODFrdDVxZGsrdEFBb09HV3pjRDNnQAAA';
        $tags->name = 'Aditya';
        $tags->slug = 'aditya';
        $tags->created_on = date('Y-m-d H:i:s');
        $tags->created_by = 'e8b1AYDBa7n3MoRMkqNayqJjLwQp9v';
        $tags->save();

        //fetch user to send email and fetch their application

        //send emails to user with their content

//        $user = Users::find()
//                ->asArray()
//                ->one();
//        $rootyii = realpath(dirname(__FILE__).'/../../');
//        $filename = date('H:i:s'). '.txt';
//        $folder = $rootyii . '/cronjob/' . $filename;
//        $f = fopen($folder, 'w');
//        $fw = fwrite($f, $user['first_name']);
//        fclose($f);

//        return Yii::$app->mailer->compose()
//            ->setFrom(['info@empoweryouth.in' => 'Empower Youth'])
//            ->setTo(['bansaladitya209@gmail.com' => 'Aditya'])
//            ->setSubject('adklshjadvn')
//            ->send();

//        Yii::$app->urlManager->hostInfo = 'http://www.aditya.eygb.me';
//        Yii::$app->urlManager->scriptUrl = 'http://www.aditya.eygb.me';
//        $user['name'] = 'Aditya';
//        $user['link'] = Yii::$app->urlManager->createAbsoluteUrl(['/verify/klnasldvnadv']);
//
//        Yii::$app->mailer->htmlLayout = 'layouts/email';
//
//         return Yii::$app->mailer->compose(
//                ['html' => 'verification-email'], ['data' => $user]
//            )
//            ->setFrom(['info@empoweryouth.in' => 'Empower Youth'])
//            ->setTo(['bansaladitya209@gmail.com' => 'aditya'])
//            ->setSubject('klasvjadnvn')
//            ->send();
    }

    //for notification purpose - job alerts
    public function actionAlertEmails()
    {

    }

    //for prefered categories
    public function actionPreferedEmails()
    {

    }

    private function findJobs($keyword)
    {

        $result = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.application_enc_id application_id',
                'e.location_enc_id location_id',
                'a.last_date',
                'a.type',
                'i.name category',
                'l.designation',
                'CONCAT("/job/", a.slug) link',
                'd.initials_color color',
                'CONCAT("/", d.slug) organization_link',
                "g.name as city",
                'c.name as title',
                'i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
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
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration'
            ])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->joinWith(['organizationEnc d'], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g'], false);
                }], false);
            }], false)
            ->joinWith(['preferredIndustry h'], false)
            ->joinWith(['designationEnc l'], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->joinWith(['applicationOptions m'], false)
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere([
                'or',
                ['g.name' => $keyword],
                ['like', 'l.designation', $keyword],
                ['like', 'a.type', $keyword],
                ['like', 'c.name', $keyword],
                ['like', 'h.industry', $keyword],
                ['like', 'i.name', $keyword],
                ['like', 'd.name', $keyword],
                ['like', 'g.name', $keyword]
            ])
            ->orderBy(['a.id' => SORT_DESC])->asArray()->all();

        $i = 0;
        foreach ($result as $val) {
            $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] * 12 . 'p.a';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] * 40 * 52 . 'p.a';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] * 52 . 'p.a';
                } else {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] . 'p.a';
                }
            } elseif ($val['salary_type'] == "Negotiable") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹ " . (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . 'p.a';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . 'p.a';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . 'p.a';
                    } else {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . 'p.a';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹ " . (string)$val['min_salary'] * 12 . 'p.a';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 40 * 52) . 'p.a';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 52) . 'p.a';
                    } else {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary']) . 'p.a';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹ " . (string)$val['max_salary'] * 12 . 'p.a';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['max_salary'] * 40 * 52) . 'p.a';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['max_salary'] * 52) . 'p.a';
                    } else {
                        $result[$i]['salary'] = "₹ " . (string)($val['max_salary']) . 'p.a';
                    }
                }
            }
            $i++;
        }
        return $result;
    }

    private function findInternships($keyword){
        $result = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.application_enc_id application_id',
                'f.location_enc_id location_id',
                'a.last_date',
                'i.name category',
                'CONCAT("/internship/", a.slug) link',
                'd.initials_color color',
                'CONCAT("/", d.slug) organization_link',
                "g.name as city",
                'a.type',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'c.name as title',
                'i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->joinWith(['organizationEnc d'], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g'], false);
                }], false);
            }], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->joinWith(['applicationOptions m'], false)
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere([
                'or',
                ['like', 'a.type', $keyword],
                ['like', 'c.name', $keyword],
                ['like', 'i.name', $keyword],
                ['like', 'g.name', $keyword],
                ['like', 'd.name', $keyword],
            ])
            ->orderBy(['a.id' => SORT_DESC])->asArray()->all();
        $i = 0;
        foreach ($result as $val) {
            $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] * 12 . "p.a.";
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] * 40 * 52 . "p.a.";
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] * 52 . "p.a.";
                } else {
                    $result[$i]['salary'] = "₹ " . $val['fixed_salary'] . "p.a.";
                }
            } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹ " . (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . "p.a.";
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . "p.a.";
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . "p.a.";
                    } else {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . "p.a.";
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹ " . (string)$val['min_salary'] * 12 . "p.a.";
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 40 * 52) . "p.a.";
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary'] * 52) . "p.a.";
                    } else {
                        $result[$i]['salary'] = "₹ " . (string)($val['min_salary']) . "p.a.";
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹ " . (string)$val['max_salary'] * 12 . "p.a.";
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['max_salary'] * 40 * 52) . "p.a.";
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹ " . (string)($val['max_salary'] * 52) . "p.a.";
                    } else {
                        $result[$i]['salary'] = "₹ " . (string)($val['max_salary']) . "p.a.";
                    }
                }
            }
            $i++;
        }
        return $result;
    }

    private function openingDetail($id)
    {
        $data = $this->getApplication($id);

        if (!is_array($data) || empty($data)) {
            return false;
        }

        if ($data['application_type'] == 'Job') {
            if ($data['wage_type'] == 'Fixed') {
                if ($data['wage_duration'] == 'Monthly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 12;
                } elseif ($data['wage_duration'] == 'Hourly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 40 * 52;
                } elseif ($data['wage_duration'] == 'Weekly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.a.';
            } else if ($data['wage_type'] == 'Negotiable') {
                if ($data['wage_duration'] == 'Monthly') {
                    $data['min_wage'] = $data['min_wage'] * 12;
                    $data['max_wage'] = $data['max_wage'] * 12;
                } elseif ($data['wage_duration'] == 'Hourly') {
                    $data['min_wage'] = $data['min_wage'] * 40 * 52;
                    $data['max_wage'] = $data['max_wage'] * 40 * 52;
                } elseif ($data['wage_duration'] == 'Weekly') {
                    $data['min_wage'] = $data['min_wage'] * 52;
                    $data['max_wage'] = $data['max_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                if (!empty($data['min_wage']) && !empty($data['max_wage'])) {
                    $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
                } elseif (!empty($data['min_wage'])) {
                    $data['amount'] = 'From ₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . 'p.a.';
                } elseif (!empty($data['max_wage'])) {
                    $data['amount'] = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
                } elseif (empty($data['min_wage']) && empty($data['max_wage'])) {
                    $data['amount'] = 'Negotiable';
                }
            }
            $subject = $data['organization_name'] . ' is hiring for ' . $data['cat_name'] . ' with a ' . $data['amount'] . ' package.';
        }

        if ($data['application_type'] == 'Internship') {
            if ($data['wage_type'] == 'Fixed') {
                if ($data['wage_duration'] == 'Weekly') {
                    $data['fixed_wage'] = $data['fixed_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.m.';
            } elseif ($data['wage_type'] == 'Negotiable' || $data['wage_type'] == 'Performance Based') {
                if ($data['wage_duration'] == 'Weekly') {
                    $data['min_wage'] = $data['min_wage'] / 7 * 30;
                    $data['max_wage'] = $data['max_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.m.';
            }
            $subject = $data['organization_name'] . ' is looking for ' . $data['cat_name'] . ' interns with a stipend ' . $data['amount'];
        }

        return $data;

    }

    private function getApplication($id)
    {
        $this->application = \common\models\EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $id])
            ->joinWith(['preferredIndustry x'], false)
            ->select(['a.id', 'a.application_number', 'a.application_enc_id', 'x.industry', 'a.title', 'a.preferred_gender', 'a.description', 'a.designation_enc_id', 'n.designation', 'l.category_enc_id', 'm.category_enc_id as cat_id', 'm.name as cat_name', 'l.name', 'l.icon_png', 'a.type', 'a.slug', 'a.preferred_industry', 'a.interview_process_enc_id', 'a.timings_from', 'a.timings_to', 'a.joining_date', 'a.last_date', 'w.name organization_name', 'w.initials_color color', 'w.slug organization_link',
                '(CASE
                WHEN w.logo IS NULL OR w.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", w.name, "&size=200&rounded=false&background=", REPLACE(w.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Yii::$app->params->empower_youth->url . Yii::$app->params->empower_youth->upload_directories->organizations->logo . '", w.logo_location, "/", w.logo) END
                ) organization_logo',
                '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                ELSE "No Experience"
                END) as experience', 'b.*, SUBSTRING(r.name, 1, CHAR_LENGTH(r.name) - 1) application_type'])
            ->joinWith(['applicationOptions b'], false)
            ->joinWith(['applicationEmployeeBenefits c' => function ($b) {
                $b->onCondition(['c.is_deleted' => 0]);
                $b->joinWith(['benefitEnc d'], false);
                $b->select(['c.application_enc_id', 'c.benefit_enc_id', 'c.is_deleted', 'd.benefit', 'CASE WHEN d.icon IS NULL OR d.icon = "" THEN "' . Url::to('assets/common/employee-benefits/plus-icon.svg') . '" ELSE CONCAT(icon_location, "/", icon) END icon']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->andWhere(['e.is_deleted' => 0]);
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->andWhere(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->andWhere(['i.is_deleted' => 0]);
                $b->joinWith(['jobDescriptionEnc j'], false);
                $b->select(['i.application_enc_id', 'j.job_description_enc_id', 'j.job_description']);
            }])
            ->joinwith(['title0 k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->onCondition(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 't.city_enc_id', 't.name']);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($b) {
                $b->onCondition(['p.is_deleted' => 0]);
                $b->joinWith(['locationEnc u' => function ($b) {
                    $b->joinWith(['cityEnc v'], false);
                }], false);
                $b->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name']);
            }])
            ->joinWith(['applicationInterviewQuestionnaires q' => function ($b) {
                $b->onCondition(['q.is_deleted' => 0]);
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->joinwith(['applicationTypeEnc r'], false, 'INNER JOIN')
            ->joinwith(['organizationEnc w' => function ($s) {
                $s->onCondition(['w.status' => 'Active', 'w.is_deleted' => 0]);
            }], false)
            ->asArray()
            ->one();
        return $this->application;
    }
}