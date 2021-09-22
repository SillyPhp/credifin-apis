<?php
$this->title = Yii::t('frontend', 'Training Programs');
$this->params['header_dark'] = true;
$keywords = 'Trainings,Trainings in Ludhiana,Trainings in Jalandhar,Trainings in Chandigarh,Government Trainings,IT Trainings,Top 10 Websites for Training Programs,Top lists of Trainings Program sites,Trainings Program services in india,top 50 Trainings Program portals in india,Trainings Program in india for freshers';
$description = '';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
$this->registerCss('
.change-hr{
    margin-bottom: 30px;
    margin-top: 15px;
    border-top: 1px solid #ccc;
    width:100%;
}
.border-top-set{
    border-top: 1px solid #ccc;
    padding-top: 20px;
}
.main-content{
    min-height:100vh !important;
}
.application-card-img{
    margin-left:0px;
    margin-top:30px;
}
.application-card-description{
    margin:20px 0 0 15px !important;
}
');
?>

    <section class="applications-cards-list">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?=
                    $this->render('/widgets/search-bar1',
                        ['placeholder' => 'Course Title, Keywords or Institute Name']);
                    ?>
                    <div class=" col-md-12 col-sm-12 p-0">
                        <div id="cardBlock" class="row work-load blogbox border-top-set m-0 mb-20"></div>
                        <?= $this->render('/widgets/preloader-application-card'); ?>
                        <a href="#" id="loadMore"
                           class="ajax-paginate-link btn btn-border btn-more btn--primary load-more loading_more">
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
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/training_cards/cards', [
]);
$script = <<<JS
var loading = false;
var load_more_cards = true;
$(window).animate({scrollTop:0}, '300');
$('body').css('overflow','hidden');
setTimeout(
    function(){
    $('body').css('overflow','inherit');
}, 1300);

setTimeout(
    function(){
        loading = true;
    }, 900);

$(window).scroll(function() { //detact scroll
    
			if($(window).scrollTop() + $(window).height() >= $(document).height() - ($('#footer').height() + 80)){ //scrolled to bottom of the page
                if(load_more_cards && loading){
                    loading = false;
                    $('#loadMore').removeClass("loading_more");
                    $('.load-more-text').css('visibility', 'hidden');
                    $('.load-more-spinner').css('visibility', 'visible');
				    getCards();
                    setTimeout(
                        function(){
				            loading = true;
				    }, 900);
                }
			}
		});

$(document).on('click','.loading_more', function(e){
    e.preventDefault();
    $('#loadMore').removeClass("loading_more");
    getCards();
});
loader = true;
draggable = false;
getCards("Trainings");
JS;
$this->registerJs($script);
