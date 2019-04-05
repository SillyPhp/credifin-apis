<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 27-01-2019
 * Time: 00:25
 */
namespace frontend\models\profile;

use common\models\Users;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class UserProfileSocialEdit extends Model {

    public $facebook;
    public $twitter;
    public $skype;
    public $linkedin;

    public function formName()
    {
        return '';
    }

    public function rules() {
        return [
            [['facebook','twitter','skype','linkedin'],'safe']
        ];
    }

    public function updateValues()
    {
        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->one();

        $user->facebook = $this->facebook;
        $user->twitter = $this->twitter;
        $user->linkedin = $this->linkedin;
        $user->skype = $this->skype;
        if ($user->update())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}