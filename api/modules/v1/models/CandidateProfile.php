<?php

namespace api\modules\v1\models;

use common\models\AssignedCategories;
use common\models\Skills;
use common\models\SpokenLanguages;
use common\models\UserAccessTokens;
use common\models\Users;
use common\models\Categories;
use common\models\Cities;
use common\models\UserSkills;
use common\models\UserSpokenLanguages;
use yii\helpers\Url;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\Utilities;

class CandidateProfile extends Model
{
    public $full_name;
    public $gender;
    public $category;
    public $job_title;
    public $exp_month;
    public $exp_year;
    public $dob;
    public $languages;
    public $skills;
    public $availability;
    public $description;
    public $state;
    public $city;
    public $facebook;
    public $twitter;
    public $google;
    public $linkedin;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['exp_month', 'gender', 'exp_year', 'dob', 'availability', 'state', 'city'], 'required'],
            [['facebook', 'twitter', 'google', 'linkedin'], 'safe'],
            ['category', 'safe'],
            ['job_title', 'safe'],
            ['job_title', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['exp_month', 'integer', 'max' => 12],
            ['exp_year', 'integer', 'max' => 99]
        ];
    }

    public function update()
    {

        $flag = 0;

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => $candidate->user_enc_id])
            ->one();
        $user->dob = date('Y-m-d', strtotime($this->dob));
        $user->city_enc_id = $this->city;
        $user->is_available = $this->availability;
        $user->experience = json_encode(['' . $this->exp_year . '', '' . $this->exp_month . '']);
        $user->gender = $this->gender;

        if (!empty($this->job_title)) {
            $category_execute = Categories::find()
                ->alias('a')
                ->where(['name' => $this->job_title]);
            $chk_cat = $category_execute->asArray()->one();
            if (empty($chk_cat)) {
                $categoriesModel = new Categories;
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
                $categoriesModel->name = $this->job_title;
                $utilitiesModel->variables['name'] = $this->job_title;
                $utilitiesModel->variables['table_name'] = Categories::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $categoriesModel->slug = $utilitiesModel->create_slug();
                $categoriesModel->created_on = date('Y-m-d H:i:s');
                $categoriesModel->created_by = $candidate->user_enc_id;
                if ($categoriesModel->save()) {
                    $this->addNewAssignedCategory($categoriesModel->category_enc_id, $user, $flag);
                } else {
                    return false;
                }
            } else {
                $chk_assigned = $category_execute
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                    ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                    ->andWhere(['not', ['b.parent_enc_id' => null]])
                    ->andWhere(['b.assigned_to' => 'Profiles', 'b.parent_enc_id' => $this->category])
                    ->asArray()
                    ->one();
                if (empty($chk_assigned)) {
                    $this->addNewAssignedCategory($chk_cat['category_enc_id'], $user, $flag);
                } else {
                    $user->job_function = $chk_assigned['category_enc_id'];
                    $user->asigned_job_function = $chk_assigned['assigned_category_enc_id'];
                    $flag++;
                }
            }
        } else {
            $user->job_function = null;
        }
        
        if ($user->update())
        {
            $flag++;
        }

        if ($flag == 0) {
            return false;
        } else {
            return true;
        }
    }

    private function addNewAssignedCategory($category_id,$user,$flag)
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->category;
        $assignedCategoryModel->assigned_to = 'Profiles';
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = $candidate->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $user->job_function = $assignedCategoryModel->category_enc_id;
            $user->asigned_job_function = $assignedCategoryModel->assigned_category_enc_id;
            $flag++;
        }
        else
        {
            return false;
        }
    }

    public function getCurrentCategory()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if (!empty($candidate->job_function)) {
            $getCategory = Categories::find()
                ->alias('a')
                ->select(['a.name', 'a.category_enc_id', 'b.parent_enc_id'])
                ->joinWith(['assignedCategories b'], false)
                ->where(['a.category_enc_id' => $candidate->job_function])
                ->asArray()
                ->one();
            $cat_name = Categories::find()->select(['name', 'category_enc_id'])->where(['category_enc_id' => $getCategory['parent_enc_id']])->one();
            return $cat_name;
        } else {
            $getCategory = '';
            return $getCategory;
        }
    }

    public function getJobFunction()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if (!empty($candidate->job_function)) {
            $getName = AssignedCategories::find()
                ->alias('a')
                ->select(['a.category_enc_id', 'c.name profile', 'b.name title', 'a.parent_enc_id'])
                ->where(['assigned_category_enc_id' => Yii::$app->user->identity->asigned_job_function])
                ->joinWith(['parentEnc c'], false)
                ->joinWith(['categoryEnc b'], false)
                ->asArray()
                ->one();
            return $getName;
        } else {
            $getName = '';
            return $getName;
        }
    }

    public function getExperience()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if (!empty($candidate->experience)) {
            $getExperience = json_decode($candidate->experience);
            return $getExperience;
        } else {
            $getExperience = '';
            return $getExperience;
        }
    }

    public function getCurrentCity()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if (!empty($candidate->city_enc_id)) {
            $getCurrentCity = Cities::find()
                ->alias('a')
                ->select(['a.city_enc_id', 'a.name city_name', 'b.name state_name', 'b.state_enc_id'])
                ->joinWith(['stateEnc b'], false)
                ->where(['city_enc_id' => $candidate->city_enc_id])
                ->asArray()
                ->one();
            return $getCurrentCity;
        } else {
            $getCurrentCity = '';
            return $getCurrentCity;
        }
    }

    public function getUserSkills()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $getSkills = UserSkills::find()
            ->alias('a')
            ->select(['a.skill_enc_id', 'b.skill'])
            ->where(['a.created_by' => $candidate->user_enc_id])
            ->andWhere(['a.is_deleted' => 0])
            ->joinWith(['skillEnc b'], false)
            ->asArray()
            ->all();
        return $getSkills;
    }

    public function getUserLanguages()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $languages = UserSpokenLanguages::find()
            ->alias('a')
            ->select(['a.language_enc_id', 'b.language'])
            ->where(['a.created_by' => $candidate->user_enc_id])
            ->andWhere(['a.is_deleted' => 0])
            ->joinWith(['languageEnc b'], false)
            ->asArray()
            ->all();
        return $languages;
    }

    public function updateValues()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => $candidate->user_enc_id])
            ->one();
        $user->facebook = $this->facebook;
        $user->twitter = $this->twitter;
        $user->linkedin = $this->linkedin;
        $user->google = $this->google;
        if ($user->update()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProfilePicture()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if(!empty($candidate->image_location)){
            return Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $candidate->image_location . DIRECTORY_SEPARATOR . $candidate->image, 'https');
        }else {
            return '';
        }
    }
}

