<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>
<section class="csb-header">
    <div class="csb-pos-rel">
        <div class="csb-header-text"><?= $careerBlog[0]['cat'] ?></div>
    </div>
</section>
<section>
    <div class="visible_in_mobile">
        <div class="csb-header-text-mobile"><?= $careerBlog[0]['cat'] ?></div>
    </div>
</section>
<section>
    <div class="container">

        <?php
        if (empty($careerBlog)) {
            ?>
            <div class="noResult">No result found</div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading-style">Related Blogs</h2>
                </div>
                <?php
                $count = 0;
                foreach ($careerBlog as $c) {
                    ?>
                    <div class="col-md-<?php if ($count == 1 || $count == 4) {
                        echo 6;
                    } else {
                        echo 3;
                    } ?>  col-sm-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-4">
                                <div class="tp-box">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="/career-advice/<?= $c['category'] ?>/<?= $c['slug'] ?>">
                                                <div class="img-box">
                                                    <a href="/career-advice/<?= $c['category'] ?>/<?= $c['slug'] ?>">
                                                        <img class="blog-img" src="<?= $c['image'] ?>" alt="Error">
                                                    </a>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="cs-blog-detail">
                                                <div class="heading-text">
                                                    <a href="/career-advice/<?= $c['category'] ?>/<?= $c['slug'] ?>">
                                                        <?= $c['title'] ?>
                                                    </a>
                                                </div>
                                                <div class="box-des">
                                                    <?= substr($c['description'], 0, 160) ?>
                                                </div>
                                                <div class="cs-read-btn">
                                                    <a href="/career-advice/<?= $c['category'] ?>/<?= $c['slug'] ?>">Read</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($count == 2) {
                        break;
                    }
                    $count++;
                }
                ?>
            </div>
            <?php if (count($careerBlog) > 3) { ?>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-md-8">
                        <?php
                        //                        $count = 0;
                        for ($i = 3; $i < count($careerBlog); $i++) {
//                            $count++
                            ?>
                            <div class="vertical-blog">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="ca-vb-icon">
                                            <a href="/career-advice/<?= $careerBlog[$i]['category'] ?>/<?= $careerBlog[$i]['slug'] ?>">
                                                <img src="<?= $careerBlog[$i]['image'] ?>" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="ca-vd-details">
                                            <div class="heading-text">
                                                <a href="/career-advice/<?= $careerBlog[$i]['category'] ?>/<?= $careerBlog[$i]['slug'] ?>">
                                                    <?= $careerBlog[$i]['title'] ?>
                                                </a>
                                            </div>
                                            <div class="box-des">
                                                <?= substr($careerBlog[$i]['description'], 0, 160) ?>
                                            </div>
                                            <div class="cs-vd-btn">
                                                <a href="/career-advice/<?= $careerBlog[$i]['category'] ?>/<?= $careerBlog[$i]['slug'] ?>">Read</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <!--                    <//= $this->render("/widgets/square_ads"); ?>-->
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>
<?php
$this->registerCss('
@media only screen and (max-width:500px){
    .csb-header{
        background-size: cover !important;
        background-repeat: no-repeat !important;
        max-height: 300px !important;
        min-height: 300px !important;
        background-position: center !important;
    }
}  
@media only screen and (max-width:992px){
    .csb-header-text{
        display:none;
    }
    .visible_in_mobile{
        display:block !important;
    }
    .heading-style{
        display:none;
    }
    .csb-header-text-mobile{
        color:#000;
        font-family:Lobster;
        font-size:30px;
    }
} 
.visible_in_mobile{
    display:none;
}
.csb-header-text-mobile{
    background:#00a0e3;
    color:#fff;
    font-family:lobster;
    font-size:40px;
    width:100%;
    text-align:center;
    
}
.noResult{
    font-family:Lobster;
    font-weight:bold;
    font-size:30px;
    text-align:center;
    padding-top:50px;
}
.csb-header-text{
    text-align:right;
}
.vertical-blog{
    border:1px solid rgba(230, 230, 230, .8);
    border-radius:5px;
    margin-bottom:20px;
    transition:0.5s;
}
.ca-vb-icon{
    height:160px;
    width:180px;
}
.ca-vb-icon img{
    height:100%;
    width:100%;
    object-fit:cover;
    border-radius:5px 0 0 5px;
}
.ca-vd-details{
    min-height:160px;
    position:relative;
}
.cs-vd-btn{
    text-align: right;
    margin-top: 10px;
    position: absolute;
    bottom: 10px;
    right: 10px;
}
.divider{
    border-top:1px solid #eee;
    margin:20px 0 40px;
}
.csb-header{
//    background:url(' . Url::to('@eyAssets/images/pages/custom/ci.png') . ');
    background-size:cover !important;
    min-height:400px;
    min-width:100%;
}  
.csb-pos-rel{
    text-align:right;
    width:100%;
    min-height:400px;
    position:relative;
}  
.csb-header-text{
    background:#00a0e3;
    bottom:0;
    color:#fff;
    font-family:lobster;
    font-size:40px;
    width:100%;
    text-align:center;
    position:absolute;
}
.new-box{
    margin-bottom: 20px;
    transition: 0.5s;
}  
.new-box:hover{
    border-radius: 5px;
    box-shadow: 1px 2px 6px 6px #bbb6b6; 
}
#border-r{
 border-right: 1px solid lightgray;
}
   
.blog-img{
    width: 100%;
	max-height: 430px;
	border-radius: 5px 5px 0px 0px;
}
.heading{
    margin-bottom: 15px;
} 
.pop-box{
    margin-bottom:20px;
    transition:0.5s;
}
.box-detail{
	padding: 5px 10px 10px 8px;
	border: 1px solid rgba(230, 230, 230, .8);
	border-radius: 0 0 5px 5px;	
}   
.box-des{
    padding-top: 15px;
    font-size: 13px;
    padding: 0 10px;
}
.box-detail a{
	text-decoration: none;
	color: gray;
}
.box-title{
  font-weight: bold;
  padding: 0 10px;
}
.trending-heading{
	font-size: 18px;
	padding-bottom: 15px;
	font-weight: bold;
 
}
.tp-box{
    border-radius: 5px;
    transition:0.5s;
    margin-bottom: 20px;
}
.tp-box:hover, .vertical-blog:hover, .pop-box:hover{
	border-radius: 5px;
	box-shadow: 0px 0px 10px rgba(0,0,0,.3); 
	transition:.5s ease;
	cursor: pointer;
}
.heading-text{
	padding: 5px 10px 10px 8px;
	color:gray;
	font-weight: bold;
}
.cs-blog-detail, .box-detail{
	border: 1px solid rgba(230, 230, 230, .8);
	border-radius: 0 0px 5px 5px;
    padding:5px 5px 10px 5px; 
}
.cs-read-btn{
    text-align:right;
    margin-top: 10px;
}
.cs-read-btn a, .cs-vd-btn a{
    background:#00a0e3;
    padding:5px 10px;
    border-radius:5px;
    color:#fff;
}
');
?>
<script>
    var pathname = window.location.pathname.split('/');
    var bgSet = pathname[2]
    console.log(bgSet);
    var bg = document.getElementsByClassName('csb-header');
    bg[0].style.background = "url(/assets/themes/ey/images/pages/custom/" + bgSet + "-bg.png)";
</script>
