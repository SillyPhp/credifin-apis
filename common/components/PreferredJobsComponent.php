<?php


namespace common\components;

use common\models\ApplicationTypes;
use common\models\EmailLogs;
use common\models\EmployerApplications;
use common\models\UserPreferences;
use common\models\Users;
use Yii;
use yii\base\Component;
use common\models\Utilities;

class PreferredJobsComponent extends Component
{

    public function sendPreferredEmails($type = "Jobs")
    {
        $users = Users::find()
            ->alias('a')
            ->distinct()
            ->select(['a.user_enc_id', 'a.username', 'a.first_name', 'a.last_name', 'a.email', 'd.name', 'c.is_selected'])
            ->joinWith(['userTypeEnc b'], false)
            ->joinWith(['selectedServices c' => function ($c) {
                $c->joinWith(['serviceEnc d']);
            }], false)
            ->where([
                'a.status' => 'Active',
                'a.is_deleted' => 0,
                'b.user_type' => 'Individual',
                'd.name' => $type,
                'c.is_selected' => 1
            ])
            ->asArray()
            ->all();

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

            if ($type == 'Jobs') {
                $cards = $jobs_cards;
            } elseif ($type == 'Internships') {
                $cards = $internship_cards;
            }

            $data = [];
            $data['user_detail'] = $userDetails;
            $data['cards'] = $cards;
            $data['user_prefs'] = $user_pref_exists;

            if (!empty($data['cards'])) {
                $email_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $email_logs->email_log_enc_id = $utilitesModel->encrypt();
                $email_logs->email_type = 2;
                $email_logs->receiver_email = $user['email'];
                $email_logs->receiver_name = $data['user_detail']['name'];
                $email_logs->user_enc_id = $user['user_enc_id'];
                $email_logs->data = json_encode($data);
                $email_logs->subject = 'Empower Youth Updates For You';
                $email_logs->template = 'applications-list';
                $email_logs->created_on = date('Y-m-d H:i:s');
                if (!$email_logs->save()) {
                    return false;
                }
            }
        }
        return true;
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
            ->select(['a.application_enc_id', 'b.designation', 'c.name', 'GROUP_CONCAT(DISTINCT(f.name) SEPARATOR ",") city', 'bb.name title', 'a.slug', 'g.name type'])
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
            ->joinWith(['applicationTypeEnc g'], false)
            ->where(['a.application_enc_id' => $id])
            ->asArray()
            ->one();

        unset($data['application_enc_id']);
        return $data;
    }

}