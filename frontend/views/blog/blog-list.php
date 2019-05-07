<?php
$this->params['header_dark'] = true;
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">All Blogs</div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($posts as $post) {
                    if(!empty($post['featured_image_location'])){
                        $image = Yii::$app->params->upload_directories->posts->featured_image.$post['featured_image_location']. DIRECTORY_SEPARATOR . $post['featured_image'];
                    } else{
                        $image = '//placehold.it/320x200';
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= $image ?>"></a>
                                <div class="middle">
                                    <a href="" class="">
<!--                                        <img src="--><?//= Url::to('@eyAssets/images/pages/blog/audio.png') ?><!--">-->
                                    </a>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
<!--                                    <div class="wn-box-cat">Audio</div>-->
                                    <div class="wn-box-title"><?= $post['title'] ?></div>
                                </a>
                                <div class="wp-box-des"><?= $post['excerpt']?></div>
                                <div class="wp-btn"><a href="/blog/<?= $post['slug']?>" class="button"><span>View Post</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
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
    border: 1px solid rgba(230, 230, 230, .3);
    position:relative;
}
.what-popular-box:hover > .wp-box-icon > .middle, .whats-new-box:hover > .wn-box-icon > .middle{
    opacity:1 !important;
}
.what-popular-box:hover > .wp-box-icon > .middle > a > img, .whats-new-box:hover >.wn-box-icon > .middle > a > img{
    opacity:1 !important;
}
.wn-box-title{
    font-weight: bold;
   
}
.wn-box-details{
    border-top:none;
    padding: 5px 10px 10px 8px;
//    border: 1px solid rgba(230, 230, 230, .3);
    border-radius:0 0 5px 5px;
    min-height: 125px;
    position:relative;
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
.wp-btn{
    position:absolute;
    bottom:5px;
}
.wp-box-des{
    padding-top:15px;
    font-size:13px;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}
.wp-btn{
    position:absolute;
    bottom:0px;
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
//  width: 200px;
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

$script = <<< JS

JS;
$this-> registerJs($script);
?>