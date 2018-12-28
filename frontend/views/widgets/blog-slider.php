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
                    <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example"
                       data-slide="prev"></a>
                    <a class="right fa fa-chevron-right btn btn-success" href="#carousel-example"
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
<!--                                    <div class="rating hidden-sm col-md-4">
                                        <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                        </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                        </i><i class="fa fa-star"></i>
                                    </div>-->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
            <!--                <div class="item">
                                <a href="">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Product Example</h5>
                                                    <h5 class="price-text-color">
                                                        $249.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Next Sample Product</h5>
                                                    <h5 class="price-text-color">
                                                        $149.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                    <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Sample Product</h5>
                                                    <h5 class="price-text-color">
                                                        $199.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                    <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="item">
                                <div class="row">
                                <div class="col-sm-3">
                                <a href=""> 
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Product with Variants</h5>
                                                    <h5 class="price-text-color">
                                                        $199.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                    <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                                            </div>
                                                            <div class="col-sm-3">
            
                                                            </div>
                                                            <div class="col-sm-3">
            
                                                            </div>
                                                            <div class="col-sm-3">
            
                                                            </div>
                                                        </div>
                            </div>
                            <div class="item">
                                <a href="">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Grouped Product</h5>
                                                    <h5 class="price-text-color">
                                                        $249.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Product with Variants</h5>
                                                    <h5 class="price-text-color">
                                                        $149.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                    <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a> 
                            </div>
                            <div class="item">
                                <a href="">
                                    <div class="col-item">
                                        <div class="photo">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>" class="img-responsive" alt="a" />
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6">
                                                    <h5>
                                                        Product with Variants</h5>
                                                    <h5 class="price-text-color">
                                                        $199.99</h5>
                                                </div>
                                                <div class="rating hidden-sm col-md-6">
                                                    <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                                    </i><i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>-->
        </div>
        <!--        <div class="row">
                    <div class="col-md-12">
                        <div id="blog-slider" class="owl-carousel-4col" data-dots="false" data-nav="true">
                            <php
                            foreach ($posts as $post) {
                                $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                                $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                                if (!file_exists($image_path)) {
                                    $image = '//placehold.it/570x390';
                                }
                                ?>
                                <div class="item owl-item">
                                    <div class="single-news-content single-item-hoverly first-column">
                                        <figure class="img-box">
                                            <img src="<?= $image; ?>" width="100%" height="212px" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['featured_image_title']; ?>"/>
                                            <div class="overlay">
                                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>" class="btn-one btn-bg"><?= Yii::t('frontend', 'Read More'); ?></a>
                                            </div>
                                        </figure>
                                        <ul class="meta in-block">
                                            <li><?= date('d M, Y', strtotime($post['created_on'])); ?></li>
                                        </ul>
                                        <div class="lower-content">
                                            <div class="title"><h4><a href="<?= Url::to('/blog/' . $post['slug']); ?>"><?= $post['title']; ?></a></h4></div>
                                            <div class="text">
                                                <p>
                                                    <php
                                                    $post['slug'] = strip_tags($post['excerpt']);
                                                    if (strlen($post['excerpt']) > 55) {
                                                        Yii::t('frontend', substr($post['excerpt'], 0, 55) . ' ....<a href="' . Url::to('/blog/' . $post['title']) . '">Read More</a>');
                                                    } else {
                                                        Yii::t('frontend', $post['excerpt'] . ' ... ');
                                                        ?>
                                                        <a href="<?= Url::to('/blog/' . $post['slug']); ?>" style="color:red;padding-left:5px;font-size:16px;"><?= Yii::t('frontend', 'Read More'); ?></a>
                                                        <php
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <php
                            }
                            ?>
                        </div>
                    </div>
                </div>-->
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
