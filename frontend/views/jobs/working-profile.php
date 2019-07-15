<?php
$this->params['header_dark'] = false;

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="bg-img"></section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">All Job Profiles</div>
                </div>
            </div>
            <div class="row">
                <div id="job-profiles"></div>
            </div>

        </div>
    </section>
<?php
$this->registerCss('
.bg-img{
    background: url(\'/assets/themes/ey/images/job-profiles/jobprofilebg.png\');
    min-height: 400px;
    background-position: bottom;
    background-repeat: no-repeat;
    background-size:cover;
    }
');

$script = <<<JS
    
JS;
$this->registerJs($script);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->render('/widgets/mustache/working-profile-card');