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
        <?= $this->render('/widgets/preloader-application-card'); ?>
        <a href="#" id="loadMore" class="ajax-paginate-link btn btn-border btn-more btn--primary load-more loading_more">
            <span class="load-more-text">Load More</span>
            <svg class="load-more-spinner" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg"
                 stroke="currentColor">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="2">
                        <circle cx="8.90684" cy="50" r="5">
                            <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50"
                                     calcMode="linear" repeatCount="indefinite"></animate>
                            <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5"
                                     calcMode="linear" repeatCount="indefinite"></animate>
                        </circle>
                        <circle cx="25.0466" cy="8.99563" r="5">
                            <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5"
                                     values="5;50;50;5" calcMode="linear"
                                     repeatCount="indefinite"></animate>
                            <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27"
                                     values="27;49;5;27" calcMode="linear"
                                     repeatCount="indefinite"></animate>
                        </circle>
                        <circle cx="47.0466" cy="46.0044" r="5">
                            <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50"
                                     calcMode="linear" repeatCount="indefinite"></animate>
                            <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s"
                                     values="49;5;27;49" calcMode="linear"
                                     repeatCount="indefinite"></animate>
                        </circle>
                    </g>
                </g>
            </svg>
        </a>
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
$(window).animate({scrollTop:0}, '300');
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
var cat = getUrlVars()["cat"];
var keyword = getUrlVars()["keyword"];
var page = 1;
var loading = true;
var load_more_cards = true;
console.log(window.location.href);
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height() - ($('#footer').height() + 80)){
        if(load_more_cards && loading){
            loading = false;
            getCourseList();
        }
    }
});
$(document).on('click','.loading_more', function(e){
    e.preventDefault();
    getCourseList();
});
function getCourseList(){
    $.ajax({
        method: "POST",
        url : window.location.href,
        data:{keyword:keyword,cat:cat,page:page},
        beforeSend: function(){
           $('.load-more-text').css('visibility', 'hidden');
           $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
            response = JSON.parse(response);
            $('.loader-main').hide();
            $(window).animate({scrollTop:$(document).height() - ($('#footer').height() + 500)}, '300');
            $('#loadMore').addClass("loading_more");
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(response.count == 0) {
                $('#loadMore').hide();
                load_more_cards = false;
            } else{
                page++;
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
        },
        complete: function() {
            loading = true;
        }
    });
}
getCourseList();
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);