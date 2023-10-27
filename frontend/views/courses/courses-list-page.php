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
                    <input type="text" placeholder="Search" name="keyword" value="<?= $_GET['keyword'] ?? ''; ?>"/>
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row" id="list-main"></div>
            <?= $this->render('/widgets/preloader-application-card'); ?>
        <a href="#" id="loadMore" class="ajax-paginate-link load-more loading_more">
            <svg xmlns="http://www.w3.org/2000/svg" style="margin:auto;background:transparent;display:block;"
                 width="60px" height="60px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <g transform="translate(50,50)">
                    <g transform="scale(0.9)">
                        <g transform="translate(-50,-50)">
                            <g>
                                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" values="360 50 50;0 50 50" keyTimes="0;1" dur="0.9900990099009901s" keySplines="0.7 0 0.3 1" calcMode="spline"></animateTransform>
                                <path fill="#00a0e3" d="M42.9,17.8c-1.4-5.4,1.9-11,7.3-12.4c0.6-0.2,1.3-0.3,1.9-0.3l0.8,0l0,0c4-0.2,8,0.1,11.9,1.1 c3.6,0.9,7.2,2.5,10.6,4.7c3.3,2.2,6.2,4.8,8.4,7.6c2.3,3,4.2,6.2,5.4,9.7c0.3,0.9,0.6,1.8,0.9,2.7c0.2,0.9,0.4,1.8,0.6,2.7l0.1,0.6 l0.4,3.4c0,0.3,0,0.6,0,0.9l0,1.8c0,0.4,0,0.8,0,1.2c-0.1,0.9-0.2,1.8-0.2,2.7c-0.3,2-0.6,3.6-1.2,5.2c-1.1,3.5-2.6,6.6-4.6,9.3 c-2,2.8-4.4,5.2-7.1,7.2c-0.2,0.2-0.5,0.3-0.7,0.5c-0.5,0.3-1,0.7-1.4,0.9l-2.3,1.3c-1.6,0.7-3.1,1.4-4.6,1.8 c-3.3,1-6.6,1.5-9.6,1.4c-3.2-0.1-6.4-0.7-9.3-1.7c-2.9-1.1-5.6-2.6-8-4.5l-1.1-0.9c-0.2-0.2-0.4-0.3-0.6-0.5l-1.6-1.6 c-1.6-1.8-3-3.8-4.1-5.9c1.4,1.9,3.1,3.5,4.9,5c0.8,0.6,1.7,1.3,2.6,1.8l1.1,0.6c2.5,1.3,5.1,2.2,7.9,2.8c2.6,0.4,5.4,0.4,8,0 c2.4-0.3,5-1.2,7.5-2.4c1.1-0.5,2-1.1,2.9-1.7l1.9-1.5c0.3-0.3,0.6-0.6,0.9-0.8c0.1-0.1,0.3-0.3,0.4-0.4l0.1-0.1 c1.7-1.8,3.1-3.8,4.2-6.1c1-2.1,1.6-4.4,1.9-6.8c0.2-1,0.2-2,0.1-2.8l0-0.6l0-0.3c-0.1-0.5-0.1-1-0.1-1.4c0-0.4-0.1-0.8-0.2-1.1 l-0.2-1c0-0.2-0.1-0.3-0.1-0.5L78,37.7l-0.4-1c-0.2-0.4-0.4-0.9-0.6-1.3L77,35.1c-0.2-0.4-0.5-0.8-0.7-1.2l-0.1-0.1 c-1.1-1.8-2.5-3.5-4.1-4.9c-1.5-1.3-3.2-2.4-5.4-3.2c-2.1-0.8-4-1.2-5.8-1.3C53.9,24.2,45.5,27.5,42.9,17.8z"></path>
                                <path fill="#ff7803" d="M33.2,74.3c-2.1-0.9-3.9-1.9-5.4-3.2c-1.6-1.4-3-3-4.1-4.9l-0.1-0.1c-0.2-0.4-0.4-0.8-0.7-1.2l-0.1-0.3 c-0.2-0.4-0.4-0.9-0.6-1.3c-3.2-8.4-0.9-17.9,5.7-24.1c9-8.4,22.7-8,32.3-0.9c1.8,1.5,3.5,3.1,4.9,5c-1.1-2.2-2.5-4.1-4.1-5.9 C44.8,20.4,17,28.7,10.2,50.4c-0.5,1.6-0.8,3.2-1.2,5.2c-0.1,0.9-0.2,1.8-0.2,2.7c0,0.4,0,0.8,0,1.2l0,1.9c0,0.3,0,0.6,0,0.9 l0.4,3.4l0.1,0.6c0.2,0.9,0.4,1.8,0.6,2.7c0.3,0.9,0.6,1.8,0.9,2.7c1.3,3.5,3.1,6.7,5.4,9.7c2.2,2.9,5.1,5.4,8.4,7.6 c3.4,2.2,7,3.8,10.6,4.7c3.8,1,7.8,1.4,11.9,1.1l0,0l0.8,0c0.6,0,1.3-0.1,1.9-0.3c2.6-0.7,4.8-2.4,6.2-4.7c1.4-2.3,1.8-5.1,1.1-7.7 c-1.4-5.4-7-8.7-12.4-7.3c-1.9,0.5-3.7,0.7-5.6,0.6C37.3,75.5,35.3,75.1,33.2,74.3z"></path>
                            </g></g></g></g>
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
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
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
            $('.loader-main').hide();
            $(window).animate({scrollTop:$(document).height() - ($('#footer').height() + 500)}, '300');
            $('#loadMore').addClass("loading_more");
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(!response.data || !response.data.length) {
                $('#loadMore').hide();
                load_more_cards = false;
                var alreadyExist = $('#list-main').children().length;
                if(alreadyExist == 0){
                    $('#list-main').append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
                }
            } else{
                page++;
                var template = $('#course-card').html();
                var rendered = Mustache.render(template,response.data);
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