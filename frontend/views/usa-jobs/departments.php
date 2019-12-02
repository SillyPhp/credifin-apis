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
echo $this->render('/widgets/mustache/departments_usa');
$this->registerCss('
.agency-box {
    border: 1px solid #fff;
    box-shadow: 0px 0px 8px 0px #eee;
    margin-bottom: 20px;
    background:#fff;
    border-radius: 2px;
}
.agency-box:hover {
    box-shadow: 0px 0px 20px 5px #eee !important;
    transition: .3s ease-in-out;
}
.agency-box:hover .agency-count a {
    color:#fff;
    background-color:#00a0e3;
}
.agency-logo {
    width: 100px;
    margin: 0 auto; 
    margin-top: 20px;
    height: 100px;
    line-height: 100px;
    text-align: center;
}
.agency-logo img {
    width: auto;
    height: auto;
}
.agency-name {
    text-align: center;
    padding: 25px 18px 0px 18px;
    font-size: 16px;
    font-weight: 500;
    font-family: roboto;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height:78px;
}
.agency-count {
    text-align: center;
    padding: 5px 0px 10px 0px;
}
.agency-count a {
    font-family: roboto;
    color: #bdbdbd;
    padding: 4px 6px;
    font-size: 14px;
    border-radius: 4px;
    margin: 0px 4px;
    transition: all ease-out .3s;
}
.button-set{
    text-align:center;
    padding:0px 0px 20px 0px;
}
');
$script = <<<JS
fetchDepartments(template=$('#departments_cards'),limit=20,offset=0);
JS;
$this->registerJs($script);
