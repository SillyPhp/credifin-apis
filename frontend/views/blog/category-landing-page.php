<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>

    <section class="bg-img" style="background: url('/assets/themes/ey/images/pages/blog/<?= $slug; ?>.png');"></section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $sl = str_replace("-", " ", $slug);
                    ?>
                    <div class="heading-style">All <?= $sl; ?></div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <?php
                $i = 1;
                foreach ($posts as $post) {
                    $new_row = ($i % 4 == 0) ? true : false;
                    if ($new_row) {
                        ?>
                        <div class="row">
                        <?php
                    }
                    $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                    $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                    if (!file_exists($image_path)) {
                        $image = '//placehold.it/330x200';
                    }
                    ?>
                <div class="col-md-3">
                    <div class="whats-new-box">
                        <div class="wn-box-icon">
                            <a href="<?= Url::to('/blog/' . $post['slug']); ?>">
                                <img src="<?= $image; ?>" alt="<?= $post['title']; ?>"/>
                            </a>
                        </div>
                        <div class="wn-box-details">
                            <a href="<?= Url::to('/blog/' . $post['slug']); ?>">
                                <div class="wn-box-title">
                                    <?= $post['title']; ?>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                    <?php
                    if ($new_row) {
                        ?>
                        </div>
                        <?php
                    }
                    $i++;
                }
            ?>
        </div>
    </section>

    <!--Subscribe Widget start-->
<?php
if (Yii::$app->user->isGuest) {
    echo $this->render('/widgets/subscribe-section');
}
?>
    <!--Subscribe Widget ends-->

<?php
$this->registerCss('
.heading-style{
    text-transform: capitalize;
}
.bg-img{
    min-height: 480px;
    background-position: 0px -100px;
    background-repeat: no-repeat;
    background-size: 100% 580px;
    }
.whats-new-box {
    border-radius: 5px;
    margin-bottom: 20px;
}
.wn-box-icon {
    max-width: 100% !important;
}
.wn-box-icon {
    max-width: 255px;
    height: 100%;
    overflow: hidden;
    border-radius: 5px 5px 0 0;
    position: relative;
    }
.wn-box-icon img {
    height: 200px !important;
    object-fit: fill;
}
.wn-box-icon img {
    border-radius: 5px 5px 0 0;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
}
.wn-box-details {
    min-height: 100px !important;
}
.wn-box-details {
    border-top: none;
    padding: 5px 10px 10px 8px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius: 0 0 5px 5px;
}
.whats-new-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
}
.whats-new-box:hover .wn-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.whats-new-box:hover > .wn-box-icon > .middle{
    opacity:1 !important;
}
.whats-new-box:hover >.wn-box-icon > .middle > a > img{
    opacity:1 !important;
}
@media screen and (max-width: 768px){
    .wn-box-icon{
        max-width: 100% !important;
    }
} 
');