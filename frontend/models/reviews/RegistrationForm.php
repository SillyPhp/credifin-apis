<?php
namespace frontend\models\reviews;

use common\models\BusinessActivities;
use common\models\NewOrganizationReviews;
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
            [['organization_name'],'required'],
            [['website','bussiness_activity'],'safe'],
        ];
    }

    public function types()
    {
      $data =   BusinessActivities::find()->where(['in','business_activity',['School','College','Business','Others']])->asArray()->all();

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
        $companyReview->category_enc_id = $arr['department'];
        $companyReview->designation_enc_id = $arr['designation'];
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
}