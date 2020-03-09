<?php

namespace account\controllers;

use account\models\preferences\CandidatePreferenceForm;
use account\models\preferences\CandidateInternshipPreferenceForm;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EmailLogs;
use common\models\EmployerApplications;
use common\models\Industries;
use common\models\Users;
use common\models\Utilities;
use yii\web\HttpException;
use common\models\UserPreferences;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class PreferencesController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->identity->organization) {

            $applicationpreferenceformModel = new CandidatePreferenceForm();
            $internapplicationpreferenceformModel = new CandidateInternshipPreferenceForm();

            $jobprimaryfields = Categories::find()
                ->alias('a')
                ->select(['a.name', 'a.category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['b.assigned_to' => 'Jobs', 'b.status' => 'Approved'])
                ->asArray()
                ->all();

            $internprimaryfields = Categories::find()
                ->alias('a')
                ->select(['a.name', 'a.category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['b.assigned_to' => 'Internships', 'b.status' => 'Approved'])
                ->asArray()
                ->all();

            $juser_skills = UserPreferences::find()
                ->alias('a')
                ->select(['b.skill'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Jobs'])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc b'], false);
                }], false)
                ->asArray()
                ->all();

            $job_data = UserPreferences::find()
                ->alias('a')
                ->select(['c.job_profile_enc_id', 'a.min_expected_salary'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Jobs'])
                ->joinWith(['userPreferredJobProfiles c' => function ($x) {
                    $x->where(['c.is_deleted' => 0]);
                }])
                ->asArray()
                ->all();


            $job_profile_id = [];

            foreach ($job_data as $jd) {
                array_push($job_profile_id, $jd['job_profile_enc_id']);
            }

            if ($job_profile_id) {
                $applicationpreferenceformModel->job_category = $job_profile_id;
            }

            $intern_data = UserPreferences::find()
                ->alias('a')
                ->select(['c.job_profile_enc_id'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Internships'])
                ->joinWith(['userPreferredJobProfiles c' => function ($x) {
                    $x->where(['c.is_deleted' => 0]);
                }])
                ->asArray()
                ->all();

            $iuser_skills = UserPreferences::find()
                ->alias('a')
                ->select(['b.skill'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Internships'])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc b'], false);
                }], false)
                ->asArray()
                ->all();

            $intern_profile_id = [];

            foreach ($intern_data as $jd) {
                array_push($intern_profile_id, $jd['job_profile_enc_id']);
            }

            if ($intern_profile_id) {
                $internapplicationpreferenceformModel->job_category = $intern_profile_id;
            }

            if (Yii::$app->request->isPost) {

                if ($applicationpreferenceformModel->load(Yii::$app->request->post())) {

                    $skill = Yii::$app->request->post('skills');

                    if (empty($skill)) {
                        return json_encode([
                            'status' => 201,
                            'message' => 'Please Enter Skills',
                        ]);
                    }

                    $applicationpreferenceformModel->key_skills = Yii::$app->request->post('skills');


                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $userdata = UserPreferences::find()
                        ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                        ->andWhere(['assigned_to' => "Jobs"])
                        ->one();

                    if ($userdata) {

                        if ($applicationpreferenceformModel->updateData()) {
                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    } else {
                        if ($applicationpreferenceformModel->saveData()) {

                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    }
                } elseif ($internapplicationpreferenceformModel->load(Yii::$app->request->post())) {

                    $skill = Yii::$app->request->post('intern_skills');

                    if (empty($skill)) {
                        return json_encode([
                            'status' => 201,
                            'message' => 'Please Enter Skills',
                        ]);
                    }
                    $internapplicationpreferenceformModel->key_skills = Yii::$app->request->post('intern_skills');
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $userdata = UserPreferences::find()
                        ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                        ->andWhere(['assigned_to' => 'Internships'])
                        ->one();

                    if ($userdata) {
                        if ($internapplicationpreferenceformModel->updateData()) {
                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    } else {
                        if ($internapplicationpreferenceformModel->saveData()) {

                            return json_encode([
                                'status' => 200,
                                'message' => 'Saved',
                            ]);
                        } else {
                            return json_encode([
                                'status' => 201,
                                'message' => 'Something went wrong',
                            ]);
                        }
                    }
                } else {
                    return json_encode([
                        'status' => 201,
                        'message' => 'Something went wrong',
                    ]);
                }
            }

            return $this->render('candidate', [
                'applicationpreferenceformModel' => $applicationpreferenceformModel,
                'internapplicationpreferenceformModel' => $internapplicationpreferenceformModel,
                'jobprimaryfields' => $jobprimaryfields,
                'internprimaryfields' => $internprimaryfields,
                'juser_skills' => $juser_skills,
                'iuser_skills' => $iuser_skills
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionGetIndustry($q = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($q)) {
            $industryModel = new Industries();
            $industry = $industryModel->find()
                ->select(['industry_enc_id AS id', 'industry AS text'])
                ->where('industry LIKE "%' . $q . '%"')
                ->orderBy(['industry' => SORT_ASC])
                ->asArray()
                ->all();

            return $industry;
        }
    }

    public function actionGetJobData()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $data = UserPreferences::find()
                ->alias('a')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Jobs'])
                ->joinWith(['userPreferredLocations c' => function ($x) {
                    $x->onCondition(['c.is_deleted' => 0]);
                    $x->joinWith(['cityEnc']);
                }])
                ->joinWith(['userPreferredIndustries d' => function ($y) {
                    $y->onCondition(['d.is_deleted' => 0]);
                    $y->joinWith(['industryEnc']);
                }])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc']);
                }])
                ->asArray()
                ->all();


            if (empty($data)) {
                return json_encode(['status' => 201]);
            } else {
                return json_encode($data);
            }

        }
    }

    public function actionGetInternData()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $data = UserPreferences::find()
                ->alias('a')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'assigned_to' => 'Internships'])
                ->joinWith(['userPreferredLocations c' => function ($x) {
                    $x->onCondition(['c.is_deleted' => 0]);
                    $x->joinWith(['cityEnc']);
                }])
                ->joinWith(['userPreferredIndustries d' => function ($y) {
                    $y->onCondition(['d.is_deleted' => 0]);
                    $y->joinWith(['industryEnc']);
                }])
                ->joinWith(['userPreferredSkills e' => function ($z) {
                    $z->onCondition(['e.is_deleted' => 0]);
                    $z->joinWith(['skillEnc']);
                }])
                ->asArray()
                ->all();

            if (empty($data)) {
                return json_encode(['status' => 201]);
            } else {
                return json_encode($data);
            }

        }
    }

    //testing preferred email data

    public function actionPreferredEmails()
    {
        $users = Users::find()
            ->alias('a')
            ->joinWith(['userTypeEnc b'], false)
            ->joinWith(['selectedServices c'=>function($c){
                $c->joinWith(['serviceEnc d']);
            }])
            ->where([
                'a.status' => 'Active',
                'a.is_deleted' => 0,
                'b.user_type' => 'Individual',
                'a.user_enc_id' => 'zroPWqDpjZxLp0KL0EvqZJnYE3wX6x'
            ])
            ->asArray()
            ->all();

        print_r($users);
        die();

        foreach ($users as $user) {
            $u = $user['user_enc_id'];

            $user_pref_exists = UserPreferences::find()
                ->where([
                    'created_by' => $u,
                    'is_deleted' => 0
                ])
                ->exists();

            $user_keyword = [];

            if ($user_pref_exists) {
                $prefs = UserPreferences::find()
                    ->alias('a')
                    ->joinWith(['userPreferredSkills b' => function ($x) {
                        $x->select(['b.preference_enc_id', 'f.skill_enc_id', 'f.skill']);
                        $x->andWhere(['b.is_deleted' => 0]);
                        $x->joinWith(['skillEnc f'], false);
                    }])
                    ->joinWith(['userPreferredLocations c' => function ($x) {
                        $x->select(['c.preference_enc_id', 'g.city_enc_id', 'g.name']);
                        $x->andWhere(['c.is_deleted' => 0]);
                        $x->joinWith(['cityEnc g'], false);
                    }])
                    ->joinWith(['userPreferredJobProfiles d' => function ($x) {
                        $x->select(['d.preference_enc_id', 'i.category_enc_id', 'i.name']);
                        $x->andWhere(['d.is_deleted' => 0]);
                        $x->joinWith(['jobProfileEnc i'], false);
                    }])
                    ->joinWith(['userPreferredIndustries e' => function ($x) {
                        $x->select(['e.preference_enc_id', 'h.industry_enc_id', 'h.industry']);
                        $x->andWhere(['e.is_deleted' => 0]);
                        $x->joinWith(['industryEnc h'], false);
                    }])
                    ->where([
                        'a.created_by' => $u,
                        'a.is_deleted' => 0,
                    ])
                    ->asArray()
                    ->all();
                foreach ($prefs as $pref) {
                    array_push($user_keyword, $pref['type']);
                    foreach ($pref['userPreferredSkills'] as $s) {
                        array_push($user_keyword, $s['skill']);
                    }
                    foreach ($pref['userPreferredLocations'] as $l) {
                        array_push($user_keyword, $l['name']);
                    }
                    foreach ($pref['userPreferredIndustries'] as $i) {
                        array_push($user_keyword, $i['industry']);
                    }
                    foreach ($pref['userPreferredJobProfiles'] as $j) {
                        array_push($user_keyword, $j['name']);
                    }
                }
            } else {
                $user_prefs = Users::find()
                    ->alias('a')
                    ->joinWith(['cityEnc b'])
                    ->joinWith(['userSkills c' => function ($x) {
                        $x->select(['c.created_by', 'e.skill_enc_id', 'e.skill']);
                        $x->andWhere(['c.is_deleted' => 0]);
                        $x->joinWith(['skillEnc e'], false);
                    }])
                    ->joinWith(['jobFunction d'])
                    ->where([
                        'a.status' => 'Active',
                        'a.user_enc_id' => $u,
                        'a.is_deleted' => 0,
                    ])
                    ->asArray()
                    ->all();
                foreach ($user_prefs as $u) {
                    array_push($user_keyword, $u['cityEnc']['name']);
                    array_push($user_keyword, $u['jobFunction']['name']);
                    foreach ($u['userSkills'] as $user_skill) {
                        array_push($user_keyword, $user_skill['skill']);
                    }
                }
            }

            $job_applications = $this->findJobs($user_keyword);
            $internship_applications = $this->findInternships($user_keyword);

            if (count($job_applications) > 1 && count($internship_applications) > 1) {
                if (count($job_applications) > 4) {
                    $random_jobs = array_rand($job_applications, 5);
                } elseif (count($job_applications) > 3) {
                    $random_jobs = array_rand($job_applications, 4);
                } else {
                    $random_jobs = array_rand($job_applications, 2);
                }
                if (count($internship_applications) > 4) {
                    $random_internships = array_rand($internship_applications, 5);
                } elseif (count($internship_applications) > 3) {
                    $random_internships = array_rand($internship_applications, 4);
                } else {
                    $random_internships = array_rand($internship_applications, 2);
                }
            } else {
                continue;
            }

            $jobs_apps = [];
            $internship_apps = [];

            foreach ($random_jobs as $rj) {
                array_push($jobs_apps, $job_applications[$rj]);
            }
            foreach ($random_internships as $ri) {
                array_push($internship_apps, $internship_applications[$ri]);
            }

            $jobs_cards = [];
            foreach ($jobs_apps as $j) {
                array_push($jobs_cards, $this->getApplicationTitle($j));
            }


            $internship_cards = [];
            foreach ($internship_apps as $i) {
                array_push($internship_cards, $this->getApplicationTitle($i));
            }

            $userDetails = [
                'name' => $user['first_name'] . " " . $user['last_name'],
                'email' => $user['email']
            ];


            if ($this->sendMail($userDetails, $jobs_cards, $internship_cards, $user_pref_exists)) {
                $email_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $email_logs->email_log_enc_id = $utilitesModel->encrypt();
                $email_logs->email_type = 2;
                $email_logs->user_enc_id = $user['user_enc_id'];
                $email_logs->subject = 'Empower Youth Updates For You';
                $email_logs->template = 'applications-list';
                $email_logs->created_on = date('Y-m-d H:i:s');
                $email_logs->save();
            }
        }
    }

    private function sendMail($userDetails, $jobs_cards, $internship_cards, $user_pref)
    {


//        Yii::$app->urlManager->hostInfo = 'http://www.aditya.eygb.me';
//        Yii::$app->urlManager->scriptUrl = 'http://www.aditya.eygb.me';

        $data['jobs'] = $jobs_cards;
//        $data['internships'] = $internship_cards;

        Yii::$app->mailer->htmlLayout = 'layouts/email';

        $mail = Yii::$app->mailer->compose(
            ['html' => 'applications-list'], ['data' => $data, 'name' => $userDetails['name'],'pref'=>$user_pref]
        )
            ->setFrom([Yii::$app->params->contact_email => Yii::$app->params->site_name])
            ->setTo([$userDetails['email'] => $userDetails['name']])
            ->setSubject('Empower Youth Updates For You');

        if ($mail->send()) {
            return true;
        }
        return false;
    }

    private function applicationDetail($id)
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
        }

        return $data;

    }

    private function getApplication($id)
    {
        return \common\models\EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $id])
            ->joinWith(['preferredIndustry x'], false)
            ->select([
                'm.name as cat_name',
                'l.name',
                'a.type',
                'a.slug',
                'a.last_date',
                'w.name organization_name',
                'w.initials_color color',
                'w.slug organization_link',
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
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->andWhere(['i.is_deleted' => 0]);
                $b->joinWith(['jobDescriptionEnc j'], false);
                $b->select(['i.application_enc_id', 'j.job_description_enc_id', 'j.job_description']);
            }])
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->onCondition(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 't.city_enc_id', 't.name']);
            }])
            ->joinwith(['applicationTypeEnc r'], false, 'INNER JOIN')
            ->joinwith(['organizationEnc w' => function ($s) {
                $s->onCondition(['w.status' => 'Active', 'w.is_deleted' => 0]);
            }], false)
            ->asArray()
            ->one();
    }

    private function findJobs($keyword)
    {
        $results = [];
        foreach ($keyword as $k) {
            if (!empty($k)) {
                $result = EmployerApplications::find()
                    ->alias('a')
                    ->select([
                        'a.application_enc_id application_id'
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
                    ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.for_careers' => 0])
                    ->andWhere(['not', ['a.organization_enc_id' => null]])
                    ->andWhere([
                        'or',
                        ['like', 'l.designation', $k],
                        ['like', 'c.name', $k],
                        ['like', 'g.name', $k],
                        ['like', 'a.type', $k],
                        ['like', 'h.industry', $k],
                        ['like', 'i.name', $k],
                        ['like', 'd.name', $k],
                    ])
                    ->orderBy(['a.id' => SORT_DESC])->asArray()->all();
                foreach ($result as $r) {
                    array_push($results, $r['application_id']);
                }
            }
        }

        return array_unique($results);
    }

    private function findInternships($keyword)
    {
        $results = [];
        foreach ($keyword as $k) {
            if (!empty($k)) {
                $result = EmployerApplications::find()
                    ->alias('a')
                    ->select([
                        'a.application_enc_id application_id',
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
                    ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                    ->joinWith(['applicationOptions m'], false)
                    ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.for_careers' => 0])
                    ->andWhere(['not', ['a.organization_enc_id' => null]])
                    ->andWhere([
                        'or',
                        ['like', 'a.type', $k],
                        ['like', 'c.name', $k],
                        ['like', 'i.name', $k],
                        ['like', 'd.name', $k],
                        ['like', 'g.name', $k],
                    ])
                    ->orderBy(['a.id' => SORT_DESC])->asArray()->all();
                foreach ($result as $r) {
                    array_push($results, $r['application_id']);
                }
            }
        }
        return array_unique($results);
    }

    private function getApplicationTitle($id)
    {
        $data = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'b.designation', 'c.name', 'GROUP_CONCAT(DISTINCT(f.name) SEPARATOR ",") city', 'bb.name title', 'a.slug'])
            ->joinWith(['title aa' => function ($aa) {
                $aa->joinWith(['categoryEnc bb']);
            }], false)
            ->joinWith(['designationEnc b'], false)
            ->joinWith(['organizationEnc c'], false)
            ->joinWith(['applicationPlacementLocations d' => function ($d) {
                $d->joinWith(['locationEnc e' => function ($e) {
                    $e->joinWith(['cityEnc f']);
                }]);
            }], false)
            ->where(['a.application_enc_id' => $id])
            ->asArray()
            ->one();

        return $data;
    }
}