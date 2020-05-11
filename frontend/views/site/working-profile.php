<?php
$this->params['header_dark'] = true;

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <section>
        <div class="container">
            <!--            <div class="row">-->
            <!--                <div class="col-md-12">-->
            <!--                    <div class="heading-style">All Profiles</div>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="row">
                <div id="job-profiles"></div>
            </div>

        </div>
    </section>
<?php
$this->registerCss('
');

$script = <<<JS
    function getProfiles() {
        $.ajax({
            method: "POST",
            url : window.location.href,
            success: function(response) {
                if(response.status === 200) {
                    var card = $('#workingProfileCard').html();
                    var rendered = Mustache.render(card, response.categories.jobs);
                    // console.log(response.categories.jobs);
                    // $("#job-profiles").append(rendered);
                    // $("#intern-profiles").append(Mustache.render(card, response.categories.internships));
                }
            }
        });
    }
    getProfiles();
JS;
$this->registerJs($script);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->render('/widgets/mustache/working-profile-card');