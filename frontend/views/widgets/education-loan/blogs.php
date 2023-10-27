<?php
use yii\helpers\Url;
?>

<section class="loanBlogs">
    <div class="container">
        <div class="row  blog-heading">
            <div class="col-xs-7">
                <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'Related Blogs'); ?></h2>
            </div>
            <?php if($blogs['count'] > 4){   ?>
            <div class="col-xs-5">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/blog/tag/'. $param); ?>" class="btn btn-3">
                            <span class="txting"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fas fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row">
            <?php
                foreach ($blogs['blogs'] as $blog){
                $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $blog['featured_image_location'] . DIRECTORY_SEPARATOR . $blog['featured_image'];
                $image = Yii::$app->params->upload_directories->posts->featured_image . $blog['featured_image_location'] . DIRECTORY_SEPARATOR . $blog['featured_image'];
                if (!file_exists($image_path)) {
                    $image = 'https://via.placeholder.com/570x390?text=Image';
                }
            ?>
            <div class="col-md-3">
                <a href="<?= Url::to('/blog/'.$blog['slug']) ?>"  target="_blank">
                    <div class="col-item">
                        <div class="photo">
                            <img src="/<?= $image ?>" class="" alt="<?= $param ?>" title="<?= $param ?>">
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="price col-md-12">
                                    <h5><?= $blog['title'] ?></h5>
                                </div>
                            </div>
                            <div class="clearfix">
                            </div>
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
$this->registerCss('
.blog-heading{
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.type-1{
    margin: 0 !important;
}
.col-item {
    border: 1px solid #E1E1E1;
    border-radius: 5px;
    background: #FFF;
    min-height: 250px;
	box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
	margin-bottom: 20px;
}
.col-item:hover{
    color: #000;
}
.heading-style{
    color: #000;
}
.photo{
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 5px 5px 0 0;
    position: relative;
}
.photo img{
    order-radius: 5px 5px 0 0;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
    opacity: 1;
    display: block;
    width: 100%;
    height: 200px;
    transition: .5s ease;
    backface-visibility: hidden;
    object-fit: fill;
}
.col-item:hover .photo img{
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1;
    transition: .5s ease;
}
.col-item .info{
    text-align:left;
    font-family:roboto;
    color: #333;
    min-height: 60px;
}
.col-item .price h5{
    font-size:14px;
    display: -webkit-box;
    font-family:roboto;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
  padding: 0 10px;
}
');
$script = <<<JS

JS;
$this->registerJS($script)
?>
