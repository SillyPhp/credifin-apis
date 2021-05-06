<?php
use yii\helpers\Url;
?>

<section class="loanBlogs">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-4 col-xs-12">
                <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'Related Blogs'); ?></h2>
            </div>

            <div class="col-md-6 col-sm-4 col-xs-12">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/blog/tag/'. $param); ?>" class="btn btn-3">
                            <span class="txting"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fas fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                foreach ($blogs as $blog){
                $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $blog['featured_image_location'] . DIRECTORY_SEPARATOR . $blog['featured_image'];
                $image = Yii::$app->params->upload_directories->posts->featured_image . $blog['featured_image_location'] . DIRECTORY_SEPARATOR . $blog['featured_image'];
                if (!file_exists($image_path)) {
                    $image = '//placehold.it/570x390';
                }
            ?>
            <div class="col-md-3">
                <a href="<?= Url::to('/blog/c/'.$blog['slug']) ?>">
                    <div class="col-item">
                        <div class="photo">
                            <img src="<?= $image ?>" class="" alt="interest free" title="interest free">
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
.col-item {
    border: 1px solid #E1E1E1;
    border-radius: 5px;
    background: #FFF;
    min-height: 250px;
	box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
}
.loanBlogs{
    padding: 0 20px;
}
.heading-style{
    color: #000;
}
.col-item .photo img {
    width: 100%;
    height: 200px;
    object-fit:cover !important;
}
.col-item .info{
    text-align:center;
    font-family:roboto;
}
.col-item .price h5{
    font-size:16px;
    display: -webkit-box;
    font-family:roboto;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
');
$script = <<<JS

JS;
$this->registerJS($script)
?>
