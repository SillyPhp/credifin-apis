<?php
namespace frontend\models\script;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\IndianGovtJobs;
use Yii;
use yii\base\Widget;
use yii\db\Expression;

class InstaImageScript extends Widget
{
    public $content = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $params = http_build_query($this->content);
        $url = "https://services.empoweryouth.com/script/parse-insta-image"."?".$params;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $header = [
            'Accept: application/json, text/plain, */*',
            'Content-Type: application/json;charset=utf-8',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $results = curl_exec($ch);
        $results = json_decode($results,true);
        if ($results['status']==200)
        {
            if (isset($this->content['is_govt_job'])&&$this->content['is_govt_job']==true){
                $update = Yii::$app->db->createCommand()
                    ->update(IndianGovtJobs::tableName(), ['square_image' => 'square-'.$this->content['app_id'].'.png'], ['job_enc_id' => $this->content['app_id']])
                    ->execute();
            }else{
                $update = Yii::$app->db->createCommand()
                    ->update(EmployerApplications::tableName(), ['square_image' => 'square-'.$this->content['app_id'].'.png'], ['application_enc_id' => $this->content['app_id']])
                    ->execute();
            }
            return $results['url'];
        }else{
            return Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/fb-image.png');
        }
    }
}