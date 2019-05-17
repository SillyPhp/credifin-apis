<?php
namespace frontend\models\reviews;

use common\models\AssignedCategories;
use common\models\BusinessActivities;
use common\models\Categories;
use common\models\Designations;
use common\models\NewOrganizationReviews;
use common\models\Qualifications;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use common\models\Utilities;
use common\models\RandomColors;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RegistrationForm extends Model {

    public $organization_name;
    public $website;
    public $bussiness_activity;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['organization_name','bussiness_activity'],'required'],
            [['organization_name'],'string','max'=>50],
            [['website'], 'url', 'defaultScheme' => 'http'],
            [['website'],'safe'],
        ];
    }

    public function types()
    {
      $data =   BusinessActivities::find()->select(['business_activity_enc_id',
          '(CASE
                WHEN business_activity = "College" THEN "Colege/Universities"
                WHEN business_activity = "Educational Institute" THEN "Educational Institute/Tution Centers"
                WHEN business_activity = "School" THEN "School"
                WHEN business_activity = "Others" THEN "Others"
                ELSE "Others"
                END) as business_activity'
          ])->where(['in','business_activity',['College','School','Educational Institute','Others']])->asArray()->all();

      return ArrayHelper::map($data, 'business_activity_enc_id', 'business_activity');
    }

    public function saveVal($org_name,$website,$org_category)
    {
       $model = new UnclaimedOrganizations();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->organization_enc_id = $utilitiesModel->encrypt();
        $model->organization_type_enc_id = (($org_category) ? $org_category : null);
        $utilitiesModel->variables['name'] = $org_name.rand(1000, 100000);
        $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $slug = $utilitiesModel->create_slug();
        $slug_replace_str = str_replace("-","",$slug);
        $model->slug = $slug_replace_str;
        $model->website = $website;
        $model->name = $org_name;
        $model->created_by = Yii::$app->user->identity->user_enc_id;
        $model->initials_color = RandomColors::one();
        $model->status = 1;
        if ($model->save())
        {
            $username = new Usernames();
            $username->username = $slug_replace_str;
            $username->assigned_to = 3;
            if ($username->save())
            {
                return [
                    'status'=>200,
                    'org_id'=>$model->organization_enc_id,
                    'slug'=>$username->username
                ];
            }
            else
            {
                return [
                    'status'=>201,
                ];
            }


        }
        else
        {
            return false;
        }
    }

    public function postReviews($org_id)
    {
        $arr = Yii::$app->request->post('data');
        $f_time = strtotime($arr['from']);
        $from_time = date('Y-m-d', $f_time);
        $t_time = strtotime($arr['to']);
        $to_time = date('Y-m-d', $t_time);
        $companyReview = new NewOrganizationReviews();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $companyReview->review_enc_id = $utilitiesModel->encrypt();
        $companyReview->show_user_details = (($arr['user'] == 'anonymous') ? 0 : 1);
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $arr['department']]);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $categoriesModel->name = $arr['department'];
            $utilitiesModel->variables['name'] = $arr['department'];
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id,$companyReview,$type='Reviews');
            } else {
                return false;
            }
        }
        else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id','b.parent_enc_id','b.assigned_to'])
                ->andWhere(['b.parent_enc_id'=>null])
                ->andWhere(['b.assigned_to'=>'Reviews'])
                ->asArray()
                ->one();
            if (empty($chk_assigned))
            {
              $this->addNewAssignedCategory($chk_cat['category_enc_id'],$companyReview,$type='Reviews');
            }
            else{
                $companyReview->category_enc_id = $chk_cat['category_enc_id'];
            }
        }
        $data = Designations::find()
            ->where(['designation'=>$arr['designation']])
            ->asArray()
            ->one();
        if (!empty($data))
        {
            $companyReview->designation_enc_id = $data['designation_enc_id'];
        }
        else{
            $desigModel = new Designations;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $desigModel->designation_enc_id = $utilitiesModel->encrypt();
            $utilitiesModel->variables['name'] = $arr['designation'];
            $utilitiesModel->variables['table_name'] = Designations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $desigModel->slug = $utilitiesModel->create_slug();
            $desigModel->designation = $arr['designation'];
            $desigModel->created_on = date('Y-m-d H:i:s');
            $desigModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($desigModel->save()) {
                $companyReview->designation_enc_id = $desigModel->designation_enc_id;
            } else {
                return false;
            }
        }
        $companyReview->organization_enc_id = $org_id;
        $companyReview->average_rating = $arr['average_rating'];
        $companyReview->reviewer_type = (($arr['current_employee'] == 'current') ? 1 : 0);
        $companyReview->from_date = $from_time;
        $companyReview->to_date = $to_time;
        $companyReview->skill_development = $arr['skill_development'];
        $companyReview->work_life = $arr['work_life'];
        $companyReview->compensation = $arr['compensation'];
        $companyReview->organization_culture = $arr['organization_culture'];
        $companyReview->job_security = $arr['job_security'];
        $companyReview->growth = $arr['growth'];
        $companyReview->work = $arr['work'];
        $companyReview->city_enc_id = $arr['location'];
        $companyReview->likes = $arr['likes'];
        $companyReview->dislikes = $arr['dislikes'];
        $companyReview->created_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->status = 1;
        $companyReview->created_on = date('Y-m-d H:i:s');
        if (!$companyReview->save()) {
            return false;
        } else {
            return true;
        }
    }

    public function postCollegeReviews($org_id)
    {
        $arr = Yii::$app->request->post('data');
        $avg =  ($arr['academics']+$arr['faculity']+$arr['infrastructure']+$arr['accomodation_food']+$arr['placement']+$arr['social_life']+$arr['culture'])/7;
        $f_time = strtotime($arr['from']);
        $from_time = date('Y-m-d', $f_time);
        $t_time = strtotime($arr['to']);
        $to_time = date('Y-m-d', $t_time);
        $companyReview = new NewOrganizationReviews();
        $companyReview->reviewer_type = (($arr['current_employee'] == 'current') ? 3 : 2);
        $data = Qualifications::find()
            ->where(['name'=>$arr['stream']])
            ->asArray()
            ->one();
        if (!empty($data))
        {
            $companyReview->educational_stream_enc_id = $data['qualification_enc_id'];
        }
        else{
            $model = new Qualifications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->qualification_enc_id = $utilitiesModel->encrypt();
            $model->name = $arr['stream'];
            $utilitiesModel->variables['name'] = $arr['stream'];
            $utilitiesModel->variables['table_name'] = Qualifications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            if ($model->save())
            {
                $companyReview->educational_stream_enc_id = $model->qualification_enc_id;
            }
            else
            {
                return false;
            }
        }
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $companyReview->review_enc_id = $utilitiesModel->encrypt();
        $companyReview->show_user_details = (($arr['user'] == 'anonymous') ? 0 : 1);
        $companyReview->organization_enc_id = $org_id;
        $companyReview->from_date = $from_time;
        $companyReview->to_date = $to_time;
        $companyReview->city_enc_id = $arr['college_city'];
        $companyReview->academics = $arr['academics'];
        $companyReview->faculty_teaching_quality = $arr['faculity'];
        $companyReview->infrastructure = $arr['infrastructure'];
        $companyReview->accomodation_food = $arr['accomodation_food'];
        $companyReview->placements_internships = $arr['placement'];
        $companyReview->social_life_extracurriculars = $arr['social_life'];
        $companyReview->culture_diversity = $arr['culture'];
        $companyReview->average_rating = ceil($avg);
        $companyReview->likes = $arr['likes'];
        $companyReview->dislikes = $arr['dislikes'];
        $companyReview->created_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->status = 1;
        $companyReview->created_on = date('Y-m-d H:i:s');
        if ($companyReview->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function postSchoolReviews($org_id)
    {
        $arr = Yii::$app->request->post('data');
        $avg =  ($arr['student_engagement']+$arr['infrastructure']+$arr['faculty']+$arr['accessibility_of_faculty']+$arr['co_curricular_activitie']+$arr['leadership_development']+$arr['sports'])/7;
        $f_time = strtotime($arr['from']);
        $from_time = date('Y-m-d', $f_time);
        $t_time = strtotime($arr['to']);
        $to_time = date('Y-m-d', $t_time);
        $companyReview = new NewOrganizationReviews();
        $companyReview->reviewer_type = (($arr['current_employee'] == 'current') ? 5 : 4);
        $data = Qualifications::find()
            ->where(['name'=>$arr['stream']])
            ->asArray()
            ->one();
        if (!empty($data))
        {
            $companyReview->educational_stream_enc_id = $data['qualification_enc_id'];
        }
        else{
            $model = new Qualifications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->qualification_enc_id = $utilitiesModel->encrypt();
            $model->name = $arr['stream'];
            $utilitiesModel->variables['name'] = $arr['stream'];
            $utilitiesModel->variables['table_name'] = Qualifications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            if ($model->save())
            {
                $companyReview->educational_stream_enc_id = $model->qualification_enc_id;
            }
            else
            {
                return false;
            }
        }
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $companyReview->review_enc_id = $utilitiesModel->encrypt();
        $companyReview->show_user_details = (($arr['user'] == 'anonymous') ? 0 : 1);
        $companyReview->organization_enc_id = $org_id;
        $companyReview->from_date = $from_time;
        $companyReview->to_date = $to_time;
        $companyReview->city_enc_id = $arr['college_city'];
        $companyReview->student_engagement = $arr['student_engagement'];
        $companyReview->school_infrastructure = $arr['infrastructure'];
        $companyReview->faculty = $arr['faculty'];
        $companyReview->accessibility_of_faculty = $arr['accessibility_of_faculty'];
        $companyReview->co_curricular_activities = $arr['co_curricular_activitie'];
        $companyReview->leadership_development = $arr['leadership_development'];
        $companyReview->sports = $arr['sports'];
        $companyReview->average_rating = ceil($avg);
        $companyReview->likes = $arr['likes'];
        $companyReview->dislikes = $arr['dislikes'];
        $companyReview->created_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->status = 1;
        $companyReview->created_on = date('Y-m-d H:i:s');
        if ($companyReview->save()) {
            return true;
        } else {
            return false;
        }
    }
    public function postInstituteReviews($org_id)
    {
        $arr = Yii::$app->request->post('data');
        $avg =  ($arr['student_engagement']+$arr['infrastructure']+$arr['faculty']+$arr['value_for_money']+$arr['teaching_style']+$arr['coverage_of_subject_matter']+$arr['accessibility_of_faculty'])/7;
        $f_time = strtotime($arr['from']);
        $from_time = date('Y-m-d', $f_time);
        $t_time = strtotime($arr['to']);
        $to_time = date('Y-m-d', $t_time);
        $companyReview = new NewOrganizationReviews();
        $companyReview->reviewer_type = (($arr['current_employee'] == 'current') ? 7 : 6);
        $data = Qualifications::find()
            ->where(['name'=>$arr['stream']])
            ->asArray()
            ->one();
        if (!empty($data))
        {
            $companyReview->educational_stream_enc_id = $data['qualification_enc_id'];
        }
        else{
            $model = new Qualifications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->qualification_enc_id = $utilitiesModel->encrypt();
            $model->name = $arr['stream'];
            $utilitiesModel->variables['name'] = $arr['stream'];
            $utilitiesModel->variables['table_name'] = Qualifications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            if ($model->save())
            {
                $companyReview->educational_stream_enc_id = $model->qualification_enc_id;
            }
            else
            {
                return false;
            }
        }
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $companyReview->review_enc_id = $utilitiesModel->encrypt();
        $companyReview->show_user_details = (($arr['user'] == 'anonymous') ? 0 : 1);
        $companyReview->organization_enc_id = $org_id;
        $companyReview->from_date = $from_time;
        $companyReview->to_date = $to_time;
        $companyReview->city_enc_id = $arr['college_city'];
        $companyReview->student_engagement = $arr['student_engagement'];
        $companyReview->school_infrastructure = $arr['infrastructure'];
        $companyReview->faculty = $arr['faculty'];
        $companyReview->value_for_money = $arr['value_for_money'];
        $companyReview->teaching_style = $arr['teaching_style'];
        $companyReview->coverage_of_subject_matter = $arr['coverage_of_subject_matter'];
        $companyReview->accessibility_of_faculty = $arr['accessibility_of_faculty'];
        $companyReview->average_rating = ceil($avg);
        $companyReview->likes = $arr['likes'];
        $companyReview->dislikes = $arr['dislikes'];
        $companyReview->created_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $companyReview->status = 1;
        $companyReview->created_on = date('Y-m-d H:i:s');
        if ($companyReview->save()) {
            return true;
        } else {
            return false;
        }
    }
    private function addNewAssignedCategory($category_id,$companyReview,$type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = NULL;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $companyReview->category_enc_id = $category_id;
        }
        else
        {
           return false;
        }
    }
}