<?php

namespace frontend\models\profiles;
use common\models\Users;
use Yii;
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

    public function getResumeData()
    {

    }
}