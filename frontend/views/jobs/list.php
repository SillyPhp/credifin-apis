<?php
if (Yii::$app->request->get('location')){
    $this->title = 'Jobs in '.ucwords(str_replace("-"," ",Yii::$app->request->get('location'))).' | Empoweryouth.com';
}
elseif(Yii::$app->request->get('keyword'))
{
    $this->title = ucwords(str_replace("-"," ",Yii::$app->request->get('keyword'))).' Jobs | Empoweryouth.com';
}
else
{
    $this->title = 'Jobs | Empoweryouth.com';
}
$this->params['header_dark'] = true;
$keywords = 'Free job alert,naukri,job search,Latest jobs,internship,fresher jobs,internship,Empower youth';
$description = 'Free job alert,naukri,job search,Latest jobs,internship,fresher jobs,internship,Empower youth';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
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
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
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
');
?>

    <section class="applications-cards-list">
        <div class="row m-0">
            <div class="col-md-2 col-sm-3 sidebar-review-bar pl-0">
                <?=
                $this->render('/widgets/sidebar-review', [
                    'type' => 'jobs',
                ]);
                ?>
            </div>
            <div class="col-md-10 col-sm-9 col-xs-12">
                <?=
                $this->render('/widgets/search-bar1');
                ?>
                <div class=" col-md-12 col-sm-12">
                    <div id="cardBlock" class="row work-load blogbox border-top-set m-0 mb-20"></div>
                    <?= $this->render('/widgets/preloader-application-card-with-skills'); ?>
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
            </div>
        </div>
    </section>


<?php

echo $this->render('/widgets/mustache/application-card', [
    'type' => 'Jobs',
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
draggable = true;


getCards();


var sidebarpage = 1;
getReviewList(sidebarpage);

JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
