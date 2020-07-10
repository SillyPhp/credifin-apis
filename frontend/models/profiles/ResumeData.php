<?php

namespace frontend\models\profiles;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use common\models\User;
use common\models\UserAchievements;
use common\models\UserEducation;
use common\models\UserHobbies;
use common\models\UserInterests;
use common\models\UserSkills;
use common\models\UserWorkExperience;

class ResumeData
{
    public function getUser()
    {
        $user = Users::find()
            ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->one();
        return $user;
    }

    public function getSkills()
    {
        $skillist = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted', 'a.user_skill_enc_id'])
            ->joinWith(['skillEnc c'], false)
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        return $skillist;
    }

    public function getExperiece()
    {
        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.experience_enc_id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current', 'b.name city'])
            ->innerJoin(\common\models\Cities::tableName() . 'b', 'b.city_enc_id = a.city_enc_id')
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();
        return $experience;
    }

    public function getAcheivements()
    {
        $achievements = UserAchievements::find()
            ->alias('a')
            ->select(['a.user_achievement_enc_id', 'a.achievement'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        return $achievements;
    }

    public function getHobbies()
    {
        $hobbies = UserHobbies::find()
            ->alias('a')
            ->select(['a.user_hobby_enc_id', 'a.hobby'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        return $hobbies;
    }

    public function getEducation()
    {
        $education = UserEducation::find()
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        return $education;
    }

    public function getInterest()
    {
        $interests = UserInterests::find()
            ->alias('a')
            ->select(['a.user_interest_enc_id', 'a.interest'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        return $interests;
    }

    public function getResumeData($id)
    {
       $out = Users::find()
           ->alias('a')
           ->select(['a.user_enc_id','a.city_enc_id','CONCAT(first_name," ",last_name) name','email','dob','phone','GROUP_CONCAT(DISTINCT(g.hobby) SEPARATOR ",") hobbies','GROUP_CONCAT(DISTINCT(h.interest) SEPARATOR ",") interests',
               'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) ELSE NULL END image',
               'a.description','ii.name title'
               ])
           ->joinWith(['userSkills b'=>function($b)
           {
               $b->select(['b.created_by','c.skill','b.user_skill_enc_id']);
               $b->andWhere(['b.is_deleted' => 0]);
               $b->joinWith(['skillEnc c'], false);
           }])
           ->joinWith(['userWorkExperiences d'=>function($b)
           {
               $b->joinWith(['cityEnc e' => function($e){
                   $e->joinWith(['stateEnc e1' => function($e1){
                       $e1->joinWith(['countryEnc e2']);
                   }]);
               }],false);
               $b->select(['d.created_by','d.experience_enc_id', 'd.title', 'd.description', 'd.company', 'd.from_date', 'd.to_date', 'd.is_current','e.name city','e1.name state','e2.name country']);
           }])
           ->joinWith(['userAchievements f'=>function($b)
           {
               $b->select(['f.user_enc_id', 'f.achievement','f.user_achievement_enc_id']);
               $b->andWhere(['f.is_deleted'=>0]);
           }])
           ->joinWith(['userHobbies g'=>function($b)
           {
               $b->select(['g.user_enc_id', 'g.hobby','g.user_hobby_enc_id']);
               $b->andWhere(['g.is_deleted'=>0]);
           }])
           ->joinWith(['userInterests h'=>function($b)
           {
               $b->select(['h.user_enc_id', 'h.interest','h.user_interest_enc_id']);
               $b->andWhere(['h.is_deleted'=>0]);
           }])
           ->joinWith(['userSpokenLanguages j'=>function($j)
           {
                $j->select(['j.user_language_enc_id','j.created_by','k.language']);
                $j->joinWith(['languageEnc k'],false);
                $j->andWhere(['j.is_deleted'=>0]);
           }])
           ->joinWith(['userEducations i'])
           ->joinWith(['jobFunction ii'],false)
           ->where(['a.user_enc_id'=>$id])
           ->asArray()
           ->one();
       return $out;
    }
}