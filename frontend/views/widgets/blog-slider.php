<?php

use yii\helpers\Url;
?>
<section class="news-section">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h2 class="heading-style"><?= Yii::t('frontend', 'Featured Blog'); ?></h2>
            </div>
            <div class="col-md-3">
                <!-- Controls -->
                <div class="controls pull-right hidden-xs">
                    <a class="left fa fa-chevron-left btn btn-success cs-button" href="#carousel-example"
                       data-slide="prev"></a>
                    <a class="right fa fa-chevron-right btn btn-success cs-button" href="#carousel-example"
                       data-slide="next"></a>
                </div>
            </div>
        </div>
        <div id="carousel-example" class="carousel slide hidden-xs" data-ride="carousel">
            <?php
            foreach ($posts as $post) {
                $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                if (!file_exists($image_path)) {
                    $image = '//placehold.it/570x390';
                }
                ?>
                <div class="item active">
                    <a href="<?= Url::to('/blog/' . $post['slug']); ?>">
                        <div class="col-item">
                            <div class="photo">
                                <img src="<?= $image; ?>" class="" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['title']; ?>"/>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="price col-md-12">
                                        <h5><?= $post['title']; ?></h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
<?php
$this->registerCssFile('@eyAssets/css/blog-main.css');
$script = <<<JS
$('#carousel-example').owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    pauseControls: false,
    margin: 20,
    responsiveClass: true,
    navText: [
    '<i class="fa fa-angle-left set_icon"></i>',
    '<i class="fa fa-angle-right set_icon"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        568: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        },
        1400: {
            items: 4
        }
    }
});
        
var owl_1 = $('#carousel-example');
$('.right').click(function() {
    owl_1.trigger('next.owl.carousel',500);
  });
  $('.left').click(function() {
    owl_1.trigger('prev.owl.carousel',500);
  }); 
JS;
$this->registerJs($script);
