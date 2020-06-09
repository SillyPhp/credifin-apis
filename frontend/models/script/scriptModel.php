<?php

namespace frontend\models\script;

use frontend\models\script\phpqrcode\bindings\tcpdf\QRcode;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use yii\helpers\Url;

class scriptModel extends Model
{
    public $company_name;
    public $logo;

    public function rules()
    {
        return [
            [['company_name'], 'required'],
            [['company_name'], 'trim'],
            [['company_name'], 'string', 'max' => 80],
            [['logo'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function genrate($filepath = null, $dir = null)
    {
        ini_set('max_execution_time', 0);
        $start = microtime(true);
        $company_name = $this->company_name;
        $company_name = trim(strtoupper($company_name));
        for ($i = 1; $i <= 49; $i++) {
            $img = imagecreatefrompng(Url::to('@rootDirectory/assets/common/covid/img-(' . $i . ').png'));
            $box = new Box($img);
            $box->setFontFace(Url::to('@rootDirectory/assets/common/fonts/times.ttf'));
            $box->setFontSize(44);
            $box->setFontColor(new Color(0, 0, 0));
            // $box->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
            $box->setBox(717, 3240, 1200, 0);
            $box->setTextAlign('center', 'center');
            $box->draw('Issued In Public Health And Safety By: ' . $company_name);
            //$profile_image = imagecreatefrompng(Url::to('@rootDirectory/assets/common/dum_icons/icon.png'));
            $profile_image = imagecreatefrompng($filepath);
            $color = imagecolorallocatealpha($profile_image, 0, 0, 0, 127);
            imagefill($profile_image, 0, 0, $color);
            imagecopy($img, $profile_image, 100, 100, 0, 0, 300, 300);
            header("Content-type: image/png");
            $filename = Yii::$app->getSecurity()->generateRandomString() . '.png';
            $save = Url::to('@rootDirectory/files/temp/' . $dir . '/' . $filename);
            imagepng($img, $save);
            imagedestroy($img);
        }
        $slug = $this->createSlug($company_name);
        $pathdir = Url::to('@rootDirectory/files/temp/' . $dir . '/');
        $zipcreated = Url::to('@rootDirectory/files/temp/' . $dir . '/' . $slug . '.zip');
        $user_path = Url::to('@root/files/temp/' . $dir . '/' . $slug . '.zip');
        $zip = new \ZipArchive();
        if ($zip->open($zipcreated, \ZipArchive::CREATE) === TRUE) {
            $dir = opendir($pathdir);
            while ($file = readdir($dir)) {
                if (is_file($pathdir . $file)) {
                    $zip->addFile($pathdir . $file, $file);
                }
            }
            $zip->close();
        }
        $end = number_format((microtime(true) - $start), 2);
        return [
            'path' => $save,
            'filename' => $user_path,
            'time' => $end,
        ];
    }

    public function createSlug($str, $delimiter = '-')
    {
        $unwanted_array = ['ś' => 's', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
            'Ś' => 's', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z']; // Polish letters for example
        $str = strtr($str, $unwanted_array);

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug . '-' . rand(10, 1000);
    }
}