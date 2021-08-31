<?php
namespace frontend\models\script;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\IndianGovtJobs;
use Yii;
use yii\base\Widget;
use yii\db\Expression;

class ImageScript extends Widget
{
    public $content = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $params = http_build_query($this->content);
        $url = "https://services.empoweryouth.com/script"."?".$params;
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
                    ->update(IndianGovtJobs::tableName(), ['image' => $this->content['app_id'].'.png'], ['job_enc_id' => $this->content['app_id']])
                    ->execute();
            }else{
                $update = Yii::$app->db->createCommand()
                    ->update(EmployerApplications::tableName(), ['image' => $this->content['app_id'].'.png', 'last_updated_on' => date('Y-m-d H:i:s')], ['application_enc_id' => $this->content['app_id']])
                    ->execute();
            }
            return $results['url'];
        }else{
            return Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/fb-image.png');
        }
    }

    public static function getProfile($profile)
    {
        $path = Categories::find()
            ->alias('a')
            ->select(['a.category_enc_id','a.icon_png'])
            ->where([
                'or',
                ['!=','a.icon_png',null],
                ['!=','a.icon_png',''],

            ])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where([
                'or',
                ['!=','a.icon_png',null],
                ['!=','a.icon_png',''],

            ])
            ->andWhere(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
            ->andWhere(['b.status' => 'Approved']);

        if ($profile){
            $bg_icon = $path->andWhere(['a.category_enc_id'=>$profile])->asArray()->one();
            return $bg_icon['icon_png'];
        }else
        {
            $bg_icon = $path->orderBy(new Expression('rand()'))->asArray()->one();
           return $bg_icon['icon_png'];
        }
    }
}