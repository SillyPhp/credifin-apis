<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\SubmittedVideos;

class LearningCornerForm extends Model {

    public $video_title;
    public $video_type;
    public $type_input;
    public $category;
    public $sub_category;
    public $cover_image;
    public $description;
    public $tags;
    public $video_url;

    public function rules() {
        return [
            [['video_title', 'video_type', 'video_url', 'cover_image', 'description'], 'required'],
            [['video_title', 'video_type', 'category', 'video_url', 'cover_image', 'sub_category', 'description', 'tags'], 'trim'],
            [['description'], 'string'],
            [['video_url', 'cover_image'], 'url', 'defaultScheme' => 'http'],
            [['video_type', 'category', 'sub_category'], 'string', 'max' => 30],
            [['video_title', 'cover_image'], 'string', 'max' => 100],
            [
                ['type_input'], 'required', 'when' => function ($model, $attribute) {
                    return $model->video_type == 'Others';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#video_type').val() == 'Others';
                }"
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'video_title' => Yii::t('frontend', 'Video Title'),
            'video_type' => Yii::t('frontend', 'Video Type'),
            'type_input' => Yii::t('frontend', 'Video Type'),
            'category' => Yii::t('frontend', 'Category'),
            'video_url' => Yii::t('frontend', 'Video URL'),
            'sub_category' => Yii::t('frontend', 'Sub Category'),
            'youtube_description' => Yii::t('frontend', 'Youtube Description'),
            'description' => Yii::t('frontend', 'Description'),
            'tags' => Yii::t('frontend', 'Tags'),
        ];
    }

    public function save($userID = NULL) {
        if ($this->validate()) {
            $submittedVideosModel = new SubmittedVideos();
            $utilitiesModel = new Utilities();
            $submittedVideosModel->name = $this->video_title;
            $submittedVideosModel->link = $this->video_url;
            $submittedVideosModel->cover_image = $this->cover_image;
            $submittedVideosModel->description = $this->description;
            if (!empty($this->tags)) {
                $submittedVideosModel->tags = $this->tags;
            } else {
                $submittedVideosModel->tags = NULL;
            }
            if (!empty($this->category)) {
                $submittedVideosModel->category = $this->category;
            } else {
                $submittedVideosModel->category = NULL;
            }
            if (!empty($this->sub_category)) {
                $submittedVideosModel->sub_category = $this->sub_category;
            } else {
                $submittedVideosModel->sub_category = NULL;
            }
            if ($this->video_type == 'Others') {
                $submittedVideosModel->type = $this->type_input;
            } else {
                $submittedVideosModel->type = $this->video_type;
            }
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $submittedVideosModel->video_enc_id = $utilitiesModel->encrypt();
            if ($userID) {
                $submittedVideosModel->created_by = $userID;
            } else {
                $submittedVideosModel->created_by = Yii::$app->user->identity->user_enc_id;
            }
            $submittedVideosModel->created_on = date('Y-m-d H:i:s');
            if ($submittedVideosModel->validate() && $submittedVideosModel->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
