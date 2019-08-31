<?php
namespace frontend\models\twitterjobs;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\AssignedSkills;
use common\models\Categories;
use common\models\Skills;
use common\models\TwitterJobs;
use common\models\TwitterJobSkills;
use common\models\TwitterPlacementCities;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class TwitterJobsForm extends Model
{
    public $profile;
    public $title;
    public $job_type;
    public $twitter_url;
    public $contact_email;
    public $skills;
    public $city;
    public $company_name;
    public $html = null;
    public $author_name = null;
    public $fixed_wage;
    public $min_salary;
    public $max_salary;
    public $wage_type = 1;
    public $country = 'India';

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['profile','title','job_type','country','wage_type','salary','city','twitter_url','contact_email','company_name','skills'],'required'],
            [['html','author_name','fixed_wage', 'min_salary', 'max_salary'],'safe'],
            [['title', 'twitter_url','salary','company_name','contact_email'], 'trim'],
            [['twitter_url'], 'url', 'defaultScheme' => 'http'],
            ['contact_email', 'email'],
        ];
    }

    public function save($type)
    {
        switch ($this->wage_type) {
            case 1:
                $wage_type = 'Fixed';
                break;
            case 2:
                $wage_type = 'Negotiable';
                break;
            case 3:
                $wage_type = 'Performance Based';
                break;
            case 0:
                $wage_type = 'Unpaid';
                break;
            default:
                $wage_type = 'Unpaid';
        }
        $twitterJobs = new TwitterJobs();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $twitterJobs->tweet_enc_id = $utilitiesModel->encrypt();
        $twitterJobs->url = $this->twitter_url;
        $twitterJobs->application_type_enc_id = ApplicationTypes::findOne(['name'=>$type])->application_type_enc_id;
        $twitterJobs->author_name = $this->author_name;
        $twitterJobs->job_type = $this->job_type;
        $twitterJobs->author_url = $this->twitter_url;
        $twitterJobs->html_code = $this->html;
        $twitterJobs->contact_email = $this->contact_email;
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $this->title]);
        $chk_cat = $category_execute->asArray()->one();

        if (empty($chk_cat)) {
            $categoriesModel = new Categories();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $this->title;
            $utilitiesModel->variables['name'] = $this->title;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $twitterJobs, 'Jobs');
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => $this->profile])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $twitterJobs, 'Jobs');
            } else {
                $twitterJobs->job_title = $chk_assigned['assigned_category_enc_id'];
            }
        }
        $twitterJobs->profile = $this->profile;
        $twitterJobs->wage_type = $wage_type;
        $twitterJobs->fixed_wage = (($this->fixed_wage) ? str_replace(',', '', $this->fixed_wage) : null);
        $twitterJobs->min_wage = (($this->min_salary) ? str_replace(',', '', $this->min_salary) : null);
        $twitterJobs->max_wage = (($this->max_salary) ? str_replace(',', '', $this->max_salary) : null);
        $twitterJobs->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
        $chk_com = UnclaimedOrganizations::find()
            ->select(['organization_enc_id'])
            ->where(['name' => $this->company_name])
            ->one();
        if (!empty($chk_com)) :
            $twitterJobs->unclaim_organization_enc_id = $chk_com->organization_enc_id;
        else:
            $model = new UnclaimedOrganizations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->organization_enc_id = $utilitiesModel->encrypt();
            $model->organization_type_enc_id = null;
            $utilitiesModel->variables['name'] = $this->company_name . rand(1000, 100000);
            $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $slug = $utilitiesModel->create_slug();
            $slug_replace_str = str_replace("-", "", $slug);
            $model->slug = $slug_replace_str;
            $model->website = null;
            $model->name = $this->company_name;
            $model->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);;
            $model->initials_color = '#73ef9c';
            $model->status = 1;
            if ($model->save()) {
                $username = new Usernames();
                $username->username = $slug_replace_str;
                $username->assigned_to = 3;
                if (!$username->save()) {
                    return false;
                }
                $twitterJobs->unclaim_organization_enc_id = $model->organization_enc_id;
            }
        endif;
            if ($twitterJobs->save())
            {
                if (!empty($this->skills)) {
                    foreach ($this->skills as $skill) {
                        $data_skill = Skills::find()
                            ->alias('a')
                            ->select(['a.skill_enc_id'])
                            ->where(['skill' => $skill]);

                        $skills_set = $data_skill->asArray()->one();
                        if (!empty($skills_set)) {
                            $applicationSkillsModel = new TwitterJobSkills();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                            $applicationSkillsModel->skill_enc_id = $skills_set['skill_enc_id'];
                            $applicationSkillsModel->tweet_enc_id = $twitterJobs->tweet_enc_id;
                            $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                            $applicationSkillsModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);;
                            if ($applicationSkillsModel->save()) {
                                $chk_skill = $data_skill
                                    ->innerJoin(AssignedSkills::tableName().'as b','b.skill_enc_id = a.skill_enc_id')
                                    ->andWhere(['b.assigned_to'=>'Jobs','category_enc_id'=>$cat_id])
                                    ->asArray()
                                    ->one();
                                if (empty($chk_skill)):
                                    $this->assignedSkill($skills_set['skill_enc_id'], $cat_id,'Jobs');
                                endif;
                            }
                        } else {
                            $skillsModel = new Skills();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                            $skillsModel->skill = $skill;
                            $skillsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                            $skillsModel->created_on = date('Y-m-d H:i:s');
                            $skillsModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
                            if ($skillsModel->save()) {
                                $applicationSkillsModel = new TwitterJobSkills();
                                $utilitiesModel = new Utilities();
                                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                                $applicationSkillsModel->skill_enc_id = $skillsModel->skill_enc_id;
                                $applicationSkillsModel->tweet_enc_id = $twitterJobs->tweet_enc_id;
                                $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                                $applicationSkillsModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);;
                                if ($applicationSkillsModel->save()) {
                                    $this->assignedSkill($skillsModel->skill_enc_id, $cat_id,'Jobs');
                                }
                            }
                        }
                    }
                }

                if (!empty($this->city)) {
                    foreach ($this->city as $city) {
                        $placementCity = new TwitterPlacementCities();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $placementCity->placement_cities_enc_id = $utilitiesModel->encrypt();
                        $placementCity->tweet_enc_id = $twitterJobs->tweet_enc_id;
                        $placementCity->city_enc_id = $city;
                        $placementCity->created_on = date('Y-m-d H:i:s');
                        $placementCity->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);;
                        if (!$placementCity->save()) {
                            return false;
                        }
                    }
                }

                return true;
            }
            else
            {
                return false;
            }

    }

    private function addNewAssignedCategory($category_id, $twitterJobs, $typ)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->profile;
        $assignedCategoryModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $assignedCategoryModel->assigned_to = $typ;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);;
        if ($assignedCategoryModel->save()) {
            $twitterJobs->job_title = $assignedCategoryModel->assigned_category_enc_id;
        } else {
            return false;
        }
    }

    private function assignedSkill($s_id, $cat_id,$typ)
    {
        $asignedSkillModel = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedSkillModel->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $asignedSkillModel->skill_enc_id = $s_id;
        $asignedSkillModel->assigned_to = $typ;
        $asignedSkillModel->category_enc_id = $cat_id;
        $asignedSkillModel->created_on = date('Y-m-d H:i:s');
        $asignedSkillModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
        ;
        if (!$asignedSkillModel->save()) {
            return false;
        }
    }

}