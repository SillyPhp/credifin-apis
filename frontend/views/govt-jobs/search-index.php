<?php
$this->title = ucwords(str_replace("-"," ",$s)).' Govt Jobs';
$this->params['header_dark'] = true;
Yii::$app->view->registerJs('var keyword = "' . $s . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var url_path = "' . Yii::$app->controller->id . '"', \yii\web\View::POS_HEAD);
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
#loadMore
{
display:none;
}
');
echo $this->render('/widgets/mustache/govt-jobs-card');
?>
<section class="applications-cards-list">
    <div class="row m-0">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?=
            $this->render('/widgets/search-bar-single',['s'=>$s]);
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
$script = <<< JS
var offset = 0;
$(document).on('click','#loadMore',function(e) {
  e.preventDefault();
  fetchLocalData(template=$('#cardBlock'),limit=12,offset=offset+12,loader=false,loader_btn=true);
})
fetchLocalData(template=$('#cardBlock'),limit=50,offset=0,loader=true,loader_btn=false,keyword=keyword,replace=true);
JS;
$this->registerJs($script);
?>
