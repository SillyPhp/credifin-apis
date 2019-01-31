<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 27-01-2019
 * Time: 00:25
 */
namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use common\models\Utilities;

class UserProfileSocialEdit extends Model {

    public $facebook;
    public $twitter;
    public $google;
    public $linkedin;

    public function formName()
    {
        return '';
    }

    public function rules() {
        return [
            [['facebook','twitter','google','linkedin'],'required']
        ];
    }

}