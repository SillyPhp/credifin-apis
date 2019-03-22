<?php

namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\OrganizationVideos;
use yii\httpclient\Client;

class OrganizationVideoForm extends Model {

    public $link;
    public $description;
    public $name;

    public function rules() {
        return [
            [['link','description','name'], 'required'],
        ];
    }

    public function attributeLabels() {
        return[
            'link' => Yii::t('frontend', 'Link'),
            'description' => Yii::t('frontend', 'Description'),
            'name' => Yii::t('frontend', 'Name'),
        ];
    }

    public function add() {
        if ($this->validate()) {
            $organizationVideosModel = new OrganizationVideos();
            $utilitiesModel = new Utilities();
            $client = new Client(['baseUrl' => 'https://www.googleapis.com/youtube/v3']);
            
            $response = $client->get('videos', [
                        'key' => 'AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk',
                        'part' => 'snippet',
                        'id' => $this->link,
                    ])->send();
            $video = $response->getData();
            $organizationVideosModel->name = $video['items'][0]['snippet']['title'];
            $organizationVideosModel->link = $this->link;
            $organizationVideosModel->cover_image = $video['items'][0]['snippet']['thumbnails']['high']['url'];
            $organizationVideosModel->description = $video['items'][0]['snippet']['description'];
            $organizationVideosModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationVideosModel->video_enc_id = $utilitiesModel->encrypt();
            $organizationVideosModel->created_by = Yii::$app->user->identity->user_enc_id;
            $organizationVideosModel->created_on = date('Y-m-d H:i:s');
            if ($organizationVideosModel->validate() && $organizationVideosModel->save()) {
                return true;
            } else {
                return false;
            }
        }
    }

}
