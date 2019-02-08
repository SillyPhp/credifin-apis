<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\UploadedFile;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class ProfilePicture extends Model{
    public $profile_image;

    public function formName(){
        return '';
    }

    public function rules(){
        return [
          [['profile_image'], 'file', 'skipOnEmpty'=>false, 'extensions'=>'png, jpg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize'=>1024*1024*1]
        ];
    }

    public function update(){

    }
}
