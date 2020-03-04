<?php
if (Yii::$app->request->get('location') && Yii::$app->request->get('keyword')) {
    $this->title = Yii::$app->request->get('keyword') . ' internship vacancies available in ' . Yii::$app->request->get('location') . ' - ' . date('M Y');
} elseif (Yii::$app->request->get('location')) {
    $this->title = 'Total internship vacancies available in ' . Yii::$app->request->get('location') . ' - ' . date('M Y');
} elseif (Yii::$app->request->get('keyword')) {
    $this->title =  Yii::$app->request->get('keyword') . ' internship vacancies available - ' . date('M Y');
} else {
    $this->title = 'Total internship vacancies available';
}

$this->params['header_dark'] = true;

if (Yii::$app->request->get('location') && Yii::$app->request->get('keyword')) {
    $location = Yii::$app->request->get('location');
    $keywords = Yii::$app->request->get('keyword').' internship vacancies, internships in '. $location .', latest '.Yii::$app->request->get('keyword').' internships in '.$location.', latest '.Yii::$app->request->get('keyword').' internships';
} elseif (Yii::$app->request->get('location')) {
    $location = Yii::$app->request->get('location');
    $keywords = 'Total internships vacancies available in ' . $location . ', ' . $location . ' careers, ' . $location . ' internship listings, ' . $location . ' internship search,' . $location . ' internships';
} elseif (Yii::$app->request->get('keyword')) {
    $keyword = Yii::$app->request->get('keyword');
    $keywords = 'Internships, ' . $keyword . ' internship vacancies available, ' . $keyword . ' careers, ' . $keyword . ' internship listings, ' . $keyword . ' internship search,' . $keyword . ' internships';
} else {
    $keywords = 'internship vacancies, Empower Youth, latest internships vacancies available in Porsche country, Porsche countries internships';
}

if (Yii::$app->request->get('location') && Yii::$app->request->get('keyword')) {
    $description = Yii::$app->request->get('keyword').' internships vacancies available in '.Yii::$app->request->get('location').' - '.date('M Y').'. Signup and apply on empoweryouth.com for free of cost.  Also, if not having a resume than build with us.';
} elseif (Yii::$app->request->get('location')) {
    $description = 'Total internships vacancies available in ' . Yii::$app->request->get('location') . ' on empoweryouth.com. Signup and apply for free. Also, build a resume with us.';
} elseif (Yii::$app->request->get('keyword')) {
    $description = Yii::$app->request->get('keyword') . ' internship vacancies available on empoweryouth.com. Signup and apply for free. Also, build a resume with us.';
} else {
    $description = 'Total internship vacancies are available in countries. Explore, signup and apply now.';
}
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
                    'type' => 'internships',
                ]);
                ?>
            </div>
            <div class="col-md-10 col-sm-9">
                <?=
                $this->render('/widgets/search-bar1',['type'=>'internships']);
                ?>
                <div class="col-md-12 col-sm-12">
                    <div id="cardBlock" class="row work-load blogbox border-top-set m-0 mb-20"></div>
                    <?= $this->render('/widgets/preloader-application-card-with-skills'); ?>
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
    </section>
<?php
echo $this->render('/widgets/mustache/application-card', [
    'type' => 'Internships',
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
				    getCards("Internships");
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
    getCards("Internships");
});
loader = true;
draggable = true;
getCards("Internships");
var sidebarpage = 1;
getReviewList(sidebarpage);
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);