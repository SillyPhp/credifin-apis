<?php


namespace api\modules\v2\models;

use common\models\OnlineClassComments;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class ClassComments extends Model
{
    public $id;
    public $comment;
    public $reply_to;
    public $class_id;

    public function rules()
    {
        return [
            [['id','comment','class_id'], 'required'],
            [['reply_to'],'safe']
        ];
    }

    public function saveComment($user_id)
    {
        $commentModel = new OnlineClassComments();
//        $utilitiesModel = new Utilities();
//        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $commentModel->comment_enc_id = $this->id;
        $commentModel->comment = $this->comment;
        $commentModel->reply_to = $this->reply_to;
        $commentModel->class_enc_id = $this->class_id;
        $commentModel->user_enc_id = $user_id;
        $commentModel->created_on = date('Y-m-d H:i:s');
        if ($commentModel->save()) {
            return true;
        } else {
            return false;
        }
    }
}