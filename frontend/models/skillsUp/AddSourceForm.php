<?php

namespace frontend\models\skillsUp;

use common\models\SkillsUpSources;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Organizations;
use common\models\OrganizationEmployees;

class AddSourceForm extends Model
{

    public $source_name;
    public $image;
    public $link;
    public $description;

    public function rules()
    {
        return [
            [['source_name', 'link'], 'required'],
            [['link'], 'url', 'defaultScheme' => 'http'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
            [['source_name', 'link', 'description'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'source_name' => Yii::t('frontend', 'Source Name'),
            'link' => Yii::t('frontend', 'Link'),
            'description' => Yii::t('frontend', 'Description'),
        ];
    }


    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $sources = new SkillsUpSources();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $sources->source_enc_id = $utilitiesModel->encrypt();
        $sources->name = $this->source_name;
        $sources->url = $this->link;
        $sources->description = $this->description;
        $sources->created_on = date('Y-m-d H:i:s');
        $sources->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$sources->save()) {
            return false;
        }

        return ['id' => $sources->source_enc_id, 'val' => $sources->name];
    }
}