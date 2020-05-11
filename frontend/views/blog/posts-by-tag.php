<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

    <section>
        <div class="container">
            <div class="section-content">
                <?php
                $i = 1;
                foreach ($posts as $post) {
                    $new_row = ($i % 3 == 0) ? true : false;
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
                    <div class="col-md-4">
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>"><img src="<?= $image; ?>" alt="<?= $post['title']; ?>"</a>
                                <div class="middle">
                                    <a href="" class="">
                                    </a>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>">
                                    <div class="wn-box-title"><?= $post['title']; ?></div>
                                </a>
                                <div class="wp-box-des"><?= $post['excerpt']; ?></div>
                                <div class=""><a href="/blog/<?= $post['slug']; ?>"
                                                 class="button"><span>View Post</span></a>
                                </div>
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
        </div>
    </section>
<?php
$this->registerCss('
.whats-new-box{
    border-radius:5px;
    margin-bottom:20px;
}
.what-popular-box:hover, .whats-new-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
    transition:.3s all;
}
.what-popular-box:hover .wp-box-icon img, .whats-new-box:hover .wn-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
    transition:.3s all;
}
.what-popular-box{
    margin-bottom:20px;
    border-radius:5px;
    min-height:400px;
    border: 1px solid rgba(230, 230, 230, 0.7);
    position:relative;
}
.what-popular-box:hover > .wp-box-icon > .middle, .whats-new-box:hover > .wn-box-icon > .middle{
    opacity:1 !important;
}
.what-popular-box:hover > .wp-box-icon > .middle > a > img, .whats-new-box:hover >.wn-box-icon > .middle > a > img{
    opacity:1 !important;
}
.wn-box-title {
	font-weight: bold;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	max-height: 50px;
	min-height: 50px;
}
.wn-box-details{
    border-top:none;
    padding: 5px 10px 10px 8px;
    border-radius:0 0 5px 5px;
}
.wn-box-cat{
   font-size:14px;
   color: #9e9e9e;
}
a.wn-overlay-text {
  background-color: #00a0e3;
  color: white;
  font-size: 12px;
  padding: 6px 12px;
  border-radius:5px;
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
.wp-box-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;   
}
.wp-box-icon img{
    height:200px;
    width:100%;
    object-fit:cover;
}
.middle img{
    object-fit:contain;
}
.wp-box-des {
	font-size: 13px;
	display: -webkit-box;
	-webkit-line-clamp: 4;
	-webkit-box-orient: vertical;
	overflow: hidden;
	min-height: 92px;
	max-height: 92px;
}
.button {
  display: inline-block;
  background-color: #00a0e3;
  border-radius: 5px;
  border:none;
  color: #FFFFFF;
  text-align: center;
  font-size: 13px;
  padding: 8px 15px;
  transition: all 0.3s;
  cursor: pointer;
  margin-top:15px;
  position:absolute;
  bottom:10px;
}
.button span {
  color:#fff;
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.3s;
}
.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  color:#fff;
  right: -20px;
  transition: 0.5s;
}
.button:hover span {
  padding-right: 20px;
}
.button:hover span:after {
  opacity: 1;
  right: 0;
}
');
?>