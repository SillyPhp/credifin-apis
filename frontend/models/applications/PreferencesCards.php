<?php
namespace frontend\models\applications;
use common\models\UserPreferences;
use Yii;
class PreferencesCards extends \frontend\models\applications\ApplicationCards
{
    private function getPreferences($user_id,$type='Jobs')
    {
        $user_pref = UserPreferences::find()
            ->alias('a')
            ->select(['a.preference_enc_id','assigned_to','timings_from','timings_to','min_expected_salary','max_expected_salary','experience'])
            ->where(['a.created_by'=>$user_id])
            ->andWhere(['assigned_to'=>$type])
            ->joinWith(['userPreferredJobProfiles b'=>function($b)
            {
                $b->select(['b.preference_enc_id','c.name']);
                $b->joinWith(['jobProfileEnc c'],false);
                $b->onCondition(['b.is_deleted'=>0]);
            }])
            ->joinWith(['userPreferredSkills d'=>function($b)
            {
                $b->select(['d.preference_enc_id','e.skill']);
                $b->joinWith(['skillEnc e'],false);
                $b->onCondition(['d.is_deleted'=>0]);
            }])
            ->joinWith(['userPreferredLocations f'=>function($b)
            {
                $b->select(['f.preference_enc_id','g.name']);
                $b->joinWith(['cityEnc g'],false);
                $b->onCondition(['f.is_deleted'=>0]);
            }])
            ->joinWith(['userPreferredIndustries h'=>function($b)
            {
                $b->select(['h.preference_enc_id','i.industry']);
                $b->joinWith(['industryEnc i'],false);
                $b->onCondition(['h.is_deleted'=>0]);
            }])->asArray()->one();
        return $user_pref;
    }

   public function getPreferenceCards($type='Jobs',$option=[])
   {
       $user_id = Yii::$app->user->identity->user_enc_id;
       if ($user_id) {
          return  $this->getPreferences($user_id,$type,$option);
       }
   }
}