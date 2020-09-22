<?php
namespace frontend\models\referral;
use common\models\WebinarRegistrations;

class PromoCodes
{
    public static function getVarify($code){
           if (empty($code)||!isset($code)||$code==null)
           {
               return false;
           }else{
                if ($code=='Redbull50')
                {
                    $count = self::getCount($code);
                    if ($count<50)
                    {
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else if ($code=='EyBJ4QG0g')
                {
                    $count = self::getCount($code);
                    if ($count<400)
                    {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
           }
        }

        private static function getCount($code)
        {
            $r = \common\models\Referral::find()
                ->where(['code'=>$code])
                ->asArray()->one();

            $count = WebinarRegistrations::find()
                ->where(['referral_enc_id'=>$r['referral_enc_id'],'status'=>1])
                ->count();
            return $count;
        }
}