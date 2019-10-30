<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\httpclient\Client;
use common\models\JsonMachine\JsonMachine;

class GovtJobsController extends Controller
{
  public function actionIndex()
  {
      return $this->render('index');
  }

  public function actionDetail()
  {

  }
    public function actionGetData($min = null, $max = null)
    {
        if (Yii::$app->request->isAjax) {
            $csv = [];
            $i = 0;
            $path = Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.'scrapped_jobs.csv';
            ini_set('auto_detect_line_endings', TRUE);
            if (($handle = fopen($path, "r")) !== false) {
                $columns = fgetcsv($handle, 1000, ",");
                while (($row = fgetcsv($handle)) !== false) {
                    $csv[] = array_combine($columns, $row);
                    $i++;
                }
                ini_set('auto_detect_line_endings', FALSE);
                fclose($handle);
            }
            $csv = $this->utf8ize($csv);
            return json_encode($csv);
        }
    }
    private  function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = $this->utf8ize($value);
        }
        } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
        return $mixed;
    }
}