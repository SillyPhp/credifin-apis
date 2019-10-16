<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 28-05-2019
 * Time: 10:46
 */
namespace frontend\models\organizations;

use common\models\EmployerApplications;
use common\models\OrganizationBlogInfoLocations;
use common\models\OrganizationBlogInformation;
use common\models\OrganizationBlogInformationApplications;
use common\models\OrganizationBlogInformationImages;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\Utilities;

class OrgAutoGenrateBlog extends Model
{
    public $title;
    public $images;
    public $applications;
    public $description;
    public $industry;
    public $cities;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['title','description'],'required'],
            [['cities'],'required','when'=>function($model,$attribute)
            {
                return ((Yii::$app->user->isGuest)? true : false);
            }],
            [['industry'],'required','when'=>function($model,$attribute)
            {
                return ((Yii::$app->user->isGuest)? true : false);
            }],
            [['applications'],'required','when'=>function($model,$attribute)
            {
                return ((Yii::$app->user->identity->organization)? true : false);
            }],
            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4,'maxSize'=>1024*1024*2],
        ];
    }

    public function getJobs()
    {
        $result = EmployerApplications::find()
                  ->alias('a')
                  ->select(['c.name','a.application_enc_id'])
                  ->joinWith(['title b'=>function($b)
                  {
                      $b->joinWith(['categoryEnc c']);
                  }],false)
                  ->where(['a.organization_enc_id'=>Yii::$app->user->identity->organization->organization_enc_id,'a.is_deleted'=>0])
                  ->asArray()
                  ->all();
        return ArrayHelper::map($result, 'application_enc_id', 'name');

    }

    public function save()
    {
        $orgBlogInfo = new OrganizationBlogInformation();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $orgBlogInfo->blog_information_enc_id = $utilitiesModel->encrypt();
        $orgBlogInfo->title = $this->title;
        $orgBlogInfo->description = $this->description;
        $orgBlogInfo->industry = $this->industry;
        $orgBlogInfo->organization_enc_id = ((Yii::$app->user->identity->organization->organization_enc_id) ? Yii::$app->user->identity->organization->organization_enc_id : null);
        $orgBlogInfo->created_by = Yii::$app->user->identity->user_enc_id;
        if ($orgBlogInfo->save())
        {
            if (!empty($this->applications)) {
                foreach ($this->applications as $application) {
                    $orgBlogInfoApplication = new OrganizationBlogInformationApplications();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $orgBlogInfoApplication->blog_information_applications_enc_id = $utilitiesModel->encrypt();
                    $orgBlogInfoApplication->blog_information_enc_id = $orgBlogInfo->blog_information_enc_id;
                    $orgBlogInfoApplication->application_enc_id = $application;
                    $orgBlogInfoApplication->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : null);
                    if (!$orgBlogInfoApplication->save()) {
                        return false;
                    }
                }
            }
            if (!empty($this->cities))
            {
                foreach ($this->cities as $city) {
                    $orgBlogInfoLocations = new OrganizationBlogInfoLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $orgBlogInfoLocations->blog_information_location_enc_id = $utilitiesModel->encrypt();
                    $orgBlogInfoLocations->city_enc_id = $city;
                    $orgBlogInfoLocations->blog_information_enc_id = $orgBlogInfo->blog_information_enc_id;
                    $orgBlogInfoLocations->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : null);
                    if (!$orgBlogInfoLocations->save())
                    {
                        return false;
                    }

                }
            }
            if (!empty($this->images))
            {
                foreach ($this->images as $images)
                {
                    $orgBlogInfoimages = new OrganizationBlogInformationImages();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $orgBlogInfoimages->image_enc_id = $utilitiesModel->encrypt();
                    $orgBlogInfoimages->blog_information_enc_id = $orgBlogInfo->blog_information_enc_id;
                    $orgBlogInfoimages->image_location = Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->organization_blog->image_path . $orgBlogInfoimages->image_location;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $orgBlogInfoimages->image = $utilitiesModel->encrypt() . '.' . $images->extension;
                    $orgBlogInfoimages->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : null);
                    if (!is_dir($base_path)) {
                        if (mkdir($base_path, 0755, true)) {
                            if ($images->saveAs($base_path . DIRECTORY_SEPARATOR . $orgBlogInfoimages->image)) {
                                if (!$orgBlogInfoimages->save())
                                {
                                    return false;
                                }
                            }

                        }
                    }

                }
            }
        }

        return true;
    }

}