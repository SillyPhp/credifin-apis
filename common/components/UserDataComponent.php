<?php

namespace common\components;

use common\models\UserPreferences;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\base\Component;

class UserDataComponent extends Component
{

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
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) ELSE NULL END image'
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
}