<?php

namespace account\models\skillsUp;

use common\models\SkillsUpSources;
use common\models\spaces\Spaces;
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
            [['description'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'source_name' => Yii::t('account', 'Source Name'),
            'link' => Yii::t('account', 'Link'),
            'description' => Yii::t('account', 'Description'),
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
        if ($this->image) {
            $sources->image_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->feed_sources->image . $sources->image_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $sources->image = $utilitiesModel->encrypt() . '.' . $this->image->extension;
            $type = $this->image->type;
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $my_space->uploadFileSources($this->image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $sources->image, "public",['params' => ['ContentType' => $type]]);
        }
        if (!$sources->save()) {
            return [
                'status' => 500,
                'title' => 'Error',
                'message' => array_values($sources->firstErrors)[0],
            ];
        }

        return [
            'status' => 200,
            'title' => 'Success',
            'message' => 'Source Added.',
            'id' => $sources->source_enc_id,
            'val' => $sources->name
        ];

    }
}