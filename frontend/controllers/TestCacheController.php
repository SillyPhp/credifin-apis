<?php
namespace frontend\controllers;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use Yii;
use yii\web\Controller;
use common\models\spaces\Spaces;
class TestCacheController extends Controller
{
   public function actionUnclaimedUpload($page,$limit=20)
   {
       $offset = ($page - 1) * $limit;
       $getData = UnclaimedOrganizations::find()
           ->select(['logo','logo_location'])
           ->limit($limit)
           ->offset($offset)
           ->asArray()
           ->all();

       foreach ($getData as $get)
       {
           if (!empty($get['logo'])){
               $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey,Yii::$app->params->digitalOcean->secret);
               $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
               $imageSourcePath = Yii::$app->params->upload_directories->unclaimed_organizations->logo_path.$get['logo_location'].'/'.$get['logo'];
               $result = $my_space->uploadFile($imageSourcePath, "images/ey-logos/uncliamed-organizations/".$get['logo_location'].'/'.$get['logo'], "public");
           }
       }
   }

    public function actionClaimedUpload($page,$limit=20)
    {
        $offset = ($page - 1) * $limit;
        $getData = Organizations::find()
            ->select(['logo','logo_location'])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        foreach ($getData as $get)
        {
            if (!empty($get['logo'])){
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey,Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $imageSourcePath = Yii::$app->params->upload_directories->organizations->logo_path.$get['logo_location'].'/'.$get['logo'];
                $result = $my_space->uploadFile($imageSourcePath, "images/ey-logos/organizations/".$get['logo_location'].'/'.$get['logo'], "public");
            }
        }
    }
}
