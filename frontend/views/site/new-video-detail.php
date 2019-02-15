<?php
$this->params['header_dark'] = true;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="video-frame">
                    <iframe width="100%" height="480" src="https://www.youtube.com/embed/<?= $video_detail->link; ?>"
                            frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="video-options">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="flex-view">
                            <div class="views"><i class="fa fa-eye"></i> 1,200</div>
                            <div class="share"><i class="fa fa-share"></i> Share</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="flex-view align-right">
                            <div class="likebtn">
                                <button id="like" data-toggle="tooltip" title="Like this">
                                    <span class="imageGray" id="imageOn"></span>
                                </button>20
                            </div>
                            <div class="dislikebtn">
                                <button id="dislike" data-toggle="tooltip" title="Don't like this">
                                    <span class="dislikeGray" id="imageOff"></span>
                                </button>0
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="v-title">Lorem Ipsum is simply dummy text of the printing and typesetting industry of the
                    printing and typesetting industry
                </div>
                <div class="v-category">
                    <ul>
                        <li>Category: <span><a href=""> Web Designing </a></span></li>
                        <li>Sub Category: <span><a href=""> Web Designing</a></span></li>
                    </ul>
                </div>
                <div class="v-tags">
                    <ul>
                        <a href=""><li> Web Design</li></a>
                        <a href=""><li> Html</li></a>
                        <a href=""><li> CSS</li></a>
                        <a href=""><li> Bootstrap</li></a>
                    </ul>
                </div>
                <div class="divider"></div>
                <div class="about-video">Video Description</div>
                <div class="video-dis">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                        scrambled it to make
                        a type specimen book.</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                        scrambled it to make
                        a type specimen book.</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                        scrambled it to make
                        a type specimen book.</p>
                    <div class="">
                        <button class="load-more">Load More</button>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="channel">
                    <a href="">
                    <div class="channel-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png') ?>">
                    </div>
                    </a>
                    <div class="channel-details">
                        <div class="channel-name"><a href=""> Empower Youth </a></div>
                        <div class="publish-date">Published on 1 Jan 2019</div>
                    </div>

                </div>
                <div class="divider"></div>
                <div class="about-video">Related Videos</div>
                <div class="related-video-box">
                   <div class="row">
                    <div class="col-md-5">
                        <div class="re-v-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                        </div>
                    </div>
                       <div class="col-md-7 padd-left-0">
                           <div class="re-v-name">Lorem Ipsum is simply dummy text of the simply dummy text of the printin</div>
                       </div>
                   </div>
                </div>
                <div class="related-video-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="re-v-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                            </div>
                        </div>
                        <div class="col-md-7 padd-left-0">
                            <div class="re-v-name">Lorem Ipsum is simply dummy text of the printin is simply dummy text of the printin</div>
                        </div>
                    </div>
                </div>
                <div class="related-video-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="re-v-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                            </div>
                        </div>
                        <div class="col-md-7 padd-left-0">
                            <div class="re-v-name">text of the printin is simply dummy text of the printin</div>
                        </div>
                    </div>
                </div>
                <div class="related-video-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="re-v-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                            </div>
                        </div>
                        <div class="col-md-7 padd-left-0">
                            <div class="re-v-name">Lorem Ipsum is simply dummy text of the printin is simply dummy</div>
                        </div>
                    </div>
                </div>
                <div class="related-video-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="re-v-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                            </div>
                        </div>
                        <div class="col-md-7 padd-left-0">
                            <div class="re-v-name">Lorem Ipsum is simply dummy text of the printin is simply dummy text of the printin</div>
                        </div>
                    </div>
                </div>
                <div class="related-video-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="re-v-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                            </div>
                        </div>
                        <div class="col-md-7 padd-left-0">
                            <div class="re-v-name">Lorem Ipsum is simply dummy text of</div>
                        </div>
                    </div>
                </div>
                <div class="related-video-box">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="re-v-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                            </div>
                        </div>
                        <div class="col-md-7 padd-left-0">
                            <div class="re-v-name">Lorem Ipsum is simply dummy text of</div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="padd-top"></div>
            <div class="col-md-12">
                <div class="heading-style">Related Topics </div>
            </div>
            <div class="col-md-3">
                <div class="video-container">
               <a href="">
                <div class="video-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg')?>">
                </div>
                <div class="r-video">
                    <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                    <div class="r-ch-name">DSB Edu Tech</div>
                </div>
               </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="video-container">
                    <a href="">
                    <div class="video-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg')?>">
                    </div>
                    <div class="r-video">
                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                        <div class="r-ch-name">DSB Edu Tech</div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="video-container">
                    <a href="">
                    <div class="video-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/solution-tile-stream.png')?>">
                    </div>
                    <div class="r-video">
                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                        <div class="r-ch-name">DSB Edu Tech</div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="video-container">
                    <a href="">
                    <div class="video-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg')?>">
                    </div>
                    <div class="r-video">
                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                        <div class="r-ch-name">DSB Edu Tech</div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.padd-left-0{
    padding-left:0px !important;
}
.imageGray{
     background:url(' . Url::to('@eyAssets/images/pages/learning-corner/like.png') . ');
     width:20px;
     height:20px; 
     display:block;
}
.imageBlue{
    background:url('. Url::to('@eyAssets/images/pages/learning-corner/likeb.png').');
     width:20px;
     height:20px; 
     display:block;
}
.imageBlue2{
    background:url('. Url::to('@eyAssets/images/pages/learning-corner/likeb.png').') !important;
}
.dislikeGray{
     background:url(' . Url::to('@eyAssets/images/pages/learning-corner/dislike.png') . ');
     width:20px;
     height:20px; 
     display:block;
}
.dislikeBlue{
      background:url(' . Url::to('@eyAssets/images/pages/learning-corner/dislikeb.png') . ');
     width:20px;
     height:20px; 
     display:block;  
}
.dislikeBlue2{
    background:url('. Url::to('@eyAssets/images/pages/learning-corner/dislikeb.png').') !important;
}
.video-options{
    padding:5px 10px;
    border:1px solid #eee;
    border-radius:0 0 10px 10px;
}
.related-video-box{
    padding:5px 0;
}
.re-v-icon img{
    border-radius:10px;
}
.re-v-name{
    font-size:15px;
    font-weight:bold;
    line-height:20px;
}
.video-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:300px;
    position:relative;
}
.video-container:hover{
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.video-icon{
    max-width:270px;
    height:186px;
    overflow:hidden;
    object-fit:cover;
}
.video-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.r-video{
    padding:5px 10px 10px 10px;
}
.r-v-name{
    font-size:16px;
    font-weight:bold;
}
.r-ch-name{
    position:absolute;
    bottom:5px;
    left:10px;
}
.channel{
    display:flex
}
.channel-details{
    padding:5px 0px 0 10px;
}
.channel-name{
    font-size:17px;
    font-weight:bold;
}
.channel-icon{
    background:#fff;
    box-shadow:0 0 10px rgba(0, 0, 0, .5);
    border-radius:50px;
    width:75px;
    height:75px;
    position:relative;
}
.channel-icon img{
    width:50px;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    line-height:0px;
}
.reply-box-input{
    display:none
}
.u-comment{
    position:relative;
}
.reply-btn{
    position:absolute;
    top:0;
    right:10px;
}
.reply-btn button{
    background:none;
    border:none;
    color:#999;
    font-size:14px;
}
.user-name{
    font-weight:bold;
    font-size:17px;
}
.align-right{
    justify-content:flex-end;
}
.divider{
    border-top:1px solid #eee;
    margin-top:15px;
}
.padd-top{
    margin-top:30px;
}
.v-category{
    padding-top:10px;
    font-weight:bold
}
.v-category ul li{
    display:inline;
    margin-right:20px;
}
.v-category span{
    font-weight:500;
}
.v-tags{
    padding:20px 0 20px;
}
.v-tags ul li{
    display:inline;
    padding:5px 10px;
    border:1px solid #999;
    border-radius:8px;
    margin-right:5px;        
}
.flex-view{
    display:flex;
}
.share{
    padding-left: 20px;
}
.like i, .dislike i,{
    color:#999;
    font-size:20px;
}
.likebtn, .dislikebtn{
    font-size:14px;
    margin: 0px 5px;
}
.views i, .share i{
    font-size:18px;
}
.align-right button{
    background:none;
    border:none;
    font-size:20px;
}
.fluid-width-video-wrapper{
    padding-top: 0px !important;
    height: 400px;
}
.about-video{
    font-weight:bold;
    text-transform:uppercase;
    font-size:17px; 
    padding-top:20px;
}
.video-dis{
    text-align:justify;
    padding-bottom:15px;
}
.v-title{
    font-size:16px;
    font-weight:bold;
    text-transform:capitalize;
}
');
$script = <<< JS
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

var like = document.getElementById('like');
var imageOn = document.getElementById('imageOn'); 
    like.onmouseover = function() {
        imageOn.classList.add('imageBlue');
        imageOn.classList.remove('imageGray');
    } 
    like.onmouseleave = function() {
      imageOn.classList.add('imageGray');
      imageOn.classList.remove('imageBlue');
    }
    like.onclick = function() {
      imageOn.classList.toggle('imageBlue2');
    }
    
 var dislike = document.getElementById('dislike');
 var imageOff = document.getElementById('imageOff');
    dislike.onmouseover = function() {
      imageOff.classList.add('dislikeBlue');
      imageOff.classList.remove('dislikeGray');
    }
    dislike.onmouseleave = function() {
      imageOff.classList.add('dislikeGray');
      imageOff.classList.remove('dislikeBlue');
    }
    dislike.onclick = function() {
      imageOff.classList.toggle('dislikeBlue2');
    }
JS;
$this->registerJs($script);
?>
