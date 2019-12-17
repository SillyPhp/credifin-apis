<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use kartik\mpdf\Pdf;
class TestCacheController extends Controller
{
    public function actionIndex()
    {
        $cache = Yii::$app->cache->flush();

        if ($cache) {
            $this->redirect(Yii::$app->request->referrer);
        } else {
            $this->redirect('/jobs/clear-my-cache');
            return 'something went wrong...! please try again later';
        }
    }

    public function actionPdf()
    {
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('pdf');

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Empower Youth Resume'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['Krajee Report Header'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
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