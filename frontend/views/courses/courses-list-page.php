<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>

<section class="head-search">
    <div class="search-bar">
        <div class="search-head">
            <div class="c-heading">Search All type of Courses which you want to do</div>
        </div>
        <div class="search-box1">
            <form action="<?= Url::to('/courses/courses-list') ?>">
                <input type="text" placeholder="Search" name="keyword" value="<?= $_GET['keyword'];?>"/>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="heading-style">Courses</div>
        </div>
        <div class="row" id="list-main">
<!--            <div class="col-md-4 col-sm-6">-->
<!--                <a href="#">-->
<!--                    <div class="course-box">-->
<!--                        <div class="course-upper">-->
<!--                            <div class="course-logo">-->
<!--                                <img src="--><?//= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?><!--"/>-->
<!--                            </div>-->
<!--                            <div class="course-provider">udemy</div>-->
<!--                            <div class="course-description">-->
<!--                                <div class="course-name">html</div>-->
<!--                                <div class="course-duration"><i class="far fa-clock"></i>3 months</div>-->
<!--                                <div class="course-fees"><i class="fas fa-rupee-sign"></i>15000</div>-->
<!--                                <div class="course-start"><i class="far fa-calendar-check"></i>15/10/12</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="course-skills">-->
<!--                            <div class="skills-set">html</div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
        </div>
    </div>
</section>
<?php
echo $this->render('/widgets/mustache/courses-card');
$this->registerCss('
.head-search {
    background-color: #60969f;
    min-height: 250px;
}
.search-bar {
    padding-top: 90px;
    text-align: center;
}
.c-heading {
    font-size: 30px;
    color: #fff;
    font-family: roboto;
    font-weight: 500;
    text-transform: capitalize;
}
.search-box1{
    max-width:500px;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 0 auto;
    margin-top:20px;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
    width: calc(100% - 38px);
}

.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    padding: 9px 10px;
    background: #fff;
    font-size: 18px;
    border-radius:0 10px 10px 0;
    border: none;
    cursor: pointer;
}
.search-box1 button:hover {
    color: #ff7803; 
}
');
$script = <<<JS
$.ajax({
    method: "POST",
    url : window.location.href,
    success: function(response) {
            response = JSON.parse(response);
        if(response.detail == "Not found.") {
            console.log('cards not found');
        } else{
            var template = $('#course-card').html();
            var rendered = Mustache.render(template,response.results);
            $('#list-main').append(rendered);
            $('.c-author').each(function() {
                var strVal = $.trim($(this).text());
                var lastChar = strVal.slice(-1);
                if (lastChar == ',') { // check last character is string
                    strVal = strVal.slice(0, -1); // trim last character
                    $(this).text(strVal);
                }
            });
        }
    }
});
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);