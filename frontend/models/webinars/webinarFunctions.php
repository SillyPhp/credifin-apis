<?php

namespace frontend\models\webinars;

use common\models\WebinarRegistrations;
use Yii;
use yii\base\Model;
use yii\db\Expression;

class webinarFunctions extends Model
{
    public function getWebinarRegisteration($id)
    {
        $data = WebinarRegistrations::find()
            ->alias('z')
            ->select(['z.webinar_enc_id', 'z.register_enc_id', 'z.created_by'])
            ->joinWith(['createdBy c'], false)
            ->where(['z.webinar_enc_id' => $id, 'z.is_deleted' => 0, 'z.status' => 1])
            ->asArray()
            ->all();
        return $data;
    }

    public function getRegisteration($id)
    {
        $data = WebinarRegistrations::find()
            ->alias('z')
            ->select(['z.webinar_enc_id', 'z.register_enc_id', 'z.created_by', 'c.image', 'c.image_location', 'z.created_on'])
            ->joinWith(['createdBy c'], false)
            ->where(['z.webinar_enc_id' => $id, 'z.is_deleted' => 0, 'z.status' => 1])
            ->andWhere(['not', ['c.image' => null]])
            ->andWhere(['not', ['c.image' => '']])
            ->orderBy(['z.created_on' => SORT_DESC])
            ->limit(4)
            ->asArray()
            ->all();
        return $data;
    }
}
