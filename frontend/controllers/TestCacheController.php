<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionIndex()
    {
        return 'cache';
    }

    public function actionTest()
    {
        $script_image_location = Yii::$app->getSecurity()->generateRandomString();
        $script_image = Yii::$app->getSecurity()->generateRandomString() . '.png';
        $base_path = Yii::$app->params->upload_directories->employer_applications->ai->image_path.$script_image_location;
        return $base_path.DIRECTORY_SEPARATOR.$script_image;
    }

    public function actionScript()
    {
        $output_image = 'image_final.png';
        $company_name = 'Capital Bank';
        $font = Url::to('@rootDirectory/assets/common/image/image_script/GeoSlb712MdBTBold.ttf');
        $font2 = Url::to('@rootDirectory/assets/common/image/image_script/Gelasio-Regular.ttf');
        $font3 = Url::to('@rootDirectory/assets/common/image/image_script/GeoSlb712MdBTBold.ttf');
        $script_path = Url::to('@rootDirectory/assets/common/image/image_script/image_genrate_script.py');
        $job_title = 'Full Stack Developer s';
        $canvas_name = 'A';
        $icon_path = Url::to('@rootDirectory/assets/common/image/image_script/icon.png');
        $temp_image = Url::to('@rootDirectory/assets/common/image/image_script/share-orignal-image.png');
        $res = exec('python "'.$script_path.'" "'.$company_name.'" "'.$job_title.'" "'.$canvas_name.'" "'.$temp_image.'" "'.$font.'" "'.$font2.'" "'.$font3.'" "'.$output_image.'" "'.$icon_path.'" ',$output, $return_var);
        echo $res;
    }
}