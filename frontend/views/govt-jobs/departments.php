<?php
$this->params['header_dark'] = True;

use yii\helpers\Url;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">All Departments</div>
            </div>
            <div class="row">
                <div id="departments_cards">

                </div>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/mustache/departments_govt');
$script = <<<JS
fetchDepartments(template=$('#departments_cards'),limit=40,offset=0);
JS;
$this->registerJs($script);
