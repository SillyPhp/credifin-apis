<?php
$this->title = Yii::t('frontend', 'Internships');
$this->params['header_dark'] = true;
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
        <div class="row">
            <div class="col-md-2 col-sm-3 sidebar-review-bar">
                <?=
                $this->render('/widgets/sidebar-review', [
                    'type' => 'internships',
                ]);
                ?>
            </div>
            <div class="col-md-10 col-sm-9">
                <?=
                $this->render('/widgets/search-bar1');
                ?>
                <div class="col-md-12 col-sm-12">
                    <div id="cardBlock" class="row work-load blogbox border-top-set m-0 mb-20"></div>
                    <?= $this->render('/widgets/preloader-application-card'); ?>
                        <a href="#" id="loadMore"
                           class="ajax-paginate-link btn btn-border btn-more btn--primary load-more">
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
                    <hr class="change-hr">
                    <?= $this->render('/widgets/mustache/featured-employers-carousel'); ?>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/application-card', [
    'type' => 'Internships',
]);
$script = <<<JS
$('#loadMore').on('click', function(e){
    e.preventDefault();
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