<?php
$this->title = Yii::t('frontend', 'Internships');
$this->params['header_dark'] = true;

$this->registerCssFile('https://fonts.googleapis.com/css?family=Crimson+Text');
$this->registerCss('
.change-hr{
    margin-bottom: 30px;
    margin-top: 15px;
    border-top: 1px solid #ccc;
    width:100%;
}
.blogbox{
    margin:0px;
    margin-bottom: 20px;
}
a:hover {
    text-decoration: none;
}
.btn-div{
    border-top: 1px solid transparent;
    margin-top: 20px;
    padding-top: 20px;
    margin-bottom: 20px;
}
.border-top-set{
    border-top: 1px solid #ccc;
    padding-top: 20px;
}
.main-content{
    min-height:100vh !important;
}
.not-found{
    width: 300px;
    margin: auto;
    display: block;
}
');
?>

    <section>
        <div class="row">
            <div class="col-md-2 col-sm-3">
                <?=
                $this->render('/widgets/sidebar-review', [
                    'type' => 'internships',
                ]);
                ?>
            </div>
            <div class="col-md-10 col-sm-9 ">
                <?=
                $this->render('/widgets/search-bar1');
                ?>
                <div class=" col-md-12 col-sm-12">
                    <div id="cardBlock" class="row work-load blogbox border-top-set"></div>
                    <div class="loader-main">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                    <span class="tag-load">
                                        <div class="loader anim"></div>
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                    <span class="tag-load">
                                        <div class="loader anim"></div>
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5">
                                            <a href="#" class="icon set_logo">
                                                <div class="loader anim"></div>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title">
                                                <div class="loader anim"></div>
                                            </h4>
                                            <h5>
                                                <i class="locations">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                            <h5>
                                                <i class="periods">
                                                    <div class="loader anim"></div>
                                                </i>
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <h6 class="pull-left custom_set2">
                                        <div class="loader anim"></div>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                    <h4 class="pull-right pt-20 custom_set">
                                        <div class="loader anim"></div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="btn-div" align="center">
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
                </div>
                <hr class="change-hr">
                <?= $this->render('/widgets/featured-employers-carousel'); ?>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/application-card');
$script = <<<JS
$('#review-internships').scroll(function(){
    if($(this).scrollTop() + $(this).height() >= $(window).height()){
        sidebarpage+=2;
        $.ajax({
            method: "GET",
            url : "/internships/review-list?sidebarpage="+sidebarpage,
            beforeSend: function(){
                $('.side-loader').show();
            },
            success: function(response) {
                $('.side-loader').hide();
                reviewlists(response);
            }
        });
    }
});
loader = true;
type = "Internships";
getCards();
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

echo $this->render('/widgets/application-card', [
    'type' => 'mustache-company',
]);