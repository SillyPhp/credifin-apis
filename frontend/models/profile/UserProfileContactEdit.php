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

class UserProfileContactEdit extends Model {

    public $contact;
    public $email;
    public $website;
    public $state;
    public $city;

    public function formName()
    {
        return '';
    }

    public function rules() {
        return [
            [['contact','email','website','state','city'],'required'],
            ['contact', 'integer','min'=>10],
        ];
    }

}