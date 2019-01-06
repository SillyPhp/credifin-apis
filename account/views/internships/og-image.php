<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Sorts+Mill+Goudy" rel="stylesheet">
        <?= Html::csrfMetaTags(); ?>
        <style>
            body{margin: 0 auto; padding: 0; background: #b5e0f3; font-family: 'Sorts Mill Goudy', serif;}
            .top-row{text-align: center; padding-top: 50px;}
            .circle1{max-width: 150px; margin: 0 auto; background: #fff; border-radius:50%;height: 150px; line-height: 150px; padding: 0 30px;}
            .box{background: #fff;border-radius: 25px;height: 140px;margin-top: 5px;line-height: 140px;text-align: center;}
            .box span{display: inline-block;vertical-align: middle;line-height: normal;font-size: 50px;width: 80%;}
            .circle1 ~ p {font-size: 30px; line-height: 30px; width: 80%; margin: auto;}
            .main-img{ max-width: 100%; height: auto; margin: 0 auto; }
            .botom-row{ position: absolute; right: 20px; bottom: 10px; width: 200px; }
            img { margin: auto; }
            .circle1 img {width: 100%;}
        </style>
    </head>
    <body>
        <?php
        $name = $logo = $color = NULL;
        if (Yii::$app->user->identity->organization->organization_enc_id) {
            if (Yii::$app->user->identity->organization->logo) {
                $logo = Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
            }
            $name = Yii::$app->user->identity->organization->name;
            $color = Yii::$app->user->identity->organization->initials_color;
        }
        ?>
        <div class="top-row">
            <div class="col-md-3 col-sm-3">
                <div class="circle1">
                    <?php if ($logo): ?>
                        <img src="<?= Url::to($logo); ?>" />
                    <?php else: ?>
                        <canvas class="user-icon" name="<?= $name; ?>" color="<?= $color; ?>" width="100" height="100" font="20px"></canvas>
                    <?php endif; ?>
                </div>
                <p><?= $details['name']; ?></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="box">
                    <span><?= $category['name']; ?></span>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="circle1"> 
                    <img src="<?= $category['icon']; ?>" />
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="main-img">
                <img src="<?= Url::to('@commonAssets/images/hiring.svg'); ?>" class="img-responsive" />
            </div>
            <div class="botom-row">
                <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg'); ?>" class="img-responsive" />
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="<?= Url::to('@adminAssets/vendor/html2canvas/html2canvas.min.js'); ?>" type="text/javascript"></script>
        <script src="<?= Url::to('@adminAssets/vendor/html2canvas/html2canvas.svg.min.js'); ?>" type="text/javascript"></script>
        <script src="<?= Url::to('@eyAssets/assets/themes/ey/js/functions.js'); ?>"></script>
        <script type="text/javascript">
            function getUrlVars() {
                var vars = {};
                var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
                    vars[key] = value;
                });
                return vars;
            }
            $(document).ready(function () {
                html2canvas(document.body, {background: '#B5E0F3', width: 1583, height: 738, imageTimeout: 0}).then(function (canvas) {

                    var base64URL = canvas.toDataURL('image/jpeg').replace('image/jpeg', 'image/octet-stream');
                    $.ajax({
                        url: '/account/jobs/job-card?application=' + getUrlVars()["application"],
                        type: 'post',
                        data: {image: base64URL, _csrf: '<?= Yii::$app->request->getCsrfToken(); ?>'},
                        success: function (data) {
                            console.log('Upload successfully');
                        }
                    });
                });
            });
        </script>
    </body>
</html>