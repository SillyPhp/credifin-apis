<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;
$this->registerCssFile('@eyAssets/css/blog-main.css');
$careerAdviceCategories = [
    [
        "name" => "How To Write Cover Letter",
        "icon" => Url::to('@eyAssets/images/pages/custom/cover-letter.png'),
        "slug" => "how-to-write-cover-letter",
        "buttonColor" => "vb-blue",
    ],
    [
        "name" => "Resume Tips",
        "icon" => Url::to('@eyAssets/images/pages/custom/resume-tip.png'),
        "slug" => "resume-tips",
        "buttonColor" => "vb-pink",
    ],
    [
        "name" => "Job Interviews",
        "icon" => Url::to('@eyAssets/images/pages/custom/job-interviews.png'),
        "slug" => "job-interviews",
        "buttonColor" => "vb-orange",
    ],
    [
        "name" => "Finding Your Dream Company",
        "icon" => Url::to('@eyAssets/images/pages/custom/find-company.png'),
        "slug" => "finding-your-dream-company",
        "buttonColor" => "vb-purple",
    ],
    [
        "name" => "Finding Your Passion",
        "icon" => Url::to('@eyAssets/images/pages/custom/find-passion.png'),
        "slug" => "finding-your-passion",
        "buttonColor" => "vb-red",
    ],
    [
        "name" => "Self Improvement",
        "icon" => Url::to('@eyAssets/images/pages/custom/self-improvement.png'),
        "slug" => "self-improvement",
        "buttonColor" => "vb-green",
    ],
    [
        "name" => "Entrepreneurship",
        "icon" => Url::to('@eyAssets/images/pages/custom/entrepreneurship.png'),
        "slug" => "entrepreneurship",
        "buttonColor" => "vb-blue",
    ],
    [
        "name" => "Job Search",
        "icon" => Url::to('@eyAssets/images/pages/custom/job-search.png'),
        "slug" => "job-search",
        "buttonColor" => "vb-red",
    ],
    [
        "name" => "Career Advancement",
        "icon" => Url::to('@eyAssets/images/pages/custom/career-advancement.png'),
        "slug" => "career-advancement",
        "buttonColor" => "vb-orange",
    ],
    [
        "name" => "Networking",
        "icon" => Url::to('@eyAssets/images/pages/custom/networking.png'),
        "slug" => "networking",
        "buttonColor" => "vb-purple",
    ],
    [
        "name" => "Personal Branding",
        "icon" => Url::to('@eyAssets/images/pages/custom/brand.png'),
        "slug" => "personal-branding",
        "buttonColor" => "vb-pink",
    ],
    [
        "name" => "Employers Corner",
        "icon" => Url::to('@eyAssets/images/pages/custom/employee.png'),
        "slug" => "employers-corner",
        "buttonColor" => "vb-green",
    ]
];
?>
    <section class="career-advice-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="career-txt">
                        <h1>Develop Your Skills With<br> Expert Career Advice</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="background-mirror blog-section-0">
        <div class="container">
                <div class="row">
                    <div class="col-md-9 col-xs-9">
                        <h1 class="heading-style"><?= Yii::t('frontend', 'Informative Blogs to Read'); ?></h1>
                    </div>
                    <div class="col-md-3 col-xs-3">
                        <!-- Controls -->
                        <div class="controls pull-right">
                            <a class="left fas fa-chevron-left bttn-left" href="#carousel-example"
                               data-slide="prev"></a>
                            <a class="right fas fa-chevron-right bttn-right" href="#carousel-example"
                               data-slide="next"></a>
                        </div>
                    </div>
                </div>
                <div id="carousel-example" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php
                        $rows = ceil(count($posts) / 4);
                        $next = 0;
                        for ($i = 0; $i < $rows; $i++) {
                            ?>
                            <div class="item <?php echo $next == 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php
                                    for ($j = 0; $j < 4; $j++) {
                                        $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $posts[$next]['featured_image_location'] . DIRECTORY_SEPARATOR . $posts[$next]['featured_image'];
                                        $image = Yii::$app->params->upload_directories->posts->featured_image . $posts[$next]['featured_image_location'] . DIRECTORY_SEPARATOR . $posts[$next]['featured_image'];
                                        if (!file_exists($image_path)) {
                                            $image = '//placehold.it/570x390';
                                        }
                                        ?>
                                        <div class="col-sm-3">
                                            <a href="<?= Url::to('/blog/' . $posts[$next]['slug']); ?>">
                                                <div class="col-item">
                                                    <div class="photo">
                                                        <img src="<?= $image; ?>" class=""
                                                             alt="<?= $posts[$next]['featured_image_alt']; ?>"
                                                             title="<?= $posts[$next]['featured_image_title']; ?>"/>
                                                    </div>
                                                    <div class="info">
                                                        <div class="row">
                                                            <div class="price col-md-12">
                                                                <h5> <?= $posts[$next]['title']; ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                        $next++;
                                    }
                                    ?>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <div class="row">
                <div class="view-all-articles">
                    <a href="<?= Url::to('/blog/category/articles'); ?>" class="artic">view all</a>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-section-2">
        <div class="container">
            <div class="col-md-3 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="whats-block-heading">What's New</div>
                    </div>
                </div>
                <div id="whats-new" class="row">

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="whats-popular-heading">What's Popular</div>
                    </div>
                </div>
                <div class="row">
                    <div id="popular-blog" class="col-md-12 col-sm-12">

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <div class="trending-posts">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?= $this->render('/widgets/follow-widget') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="trending-heading">Trending Posts</div>
                            </div>
                        </div>
                        <div id="trending-post">

                        </div>
                    </div>
                </div>
<!--                <div class="col-md-12 row">-->
<!--                    <div class="infographics">-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="info-head">-->
<!--                                    Infographics-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="info-g">-->
<!--                                --><?php
//                                $i = 1;
//                                if ($infographicsPosts) {
//                                    foreach ($infographicsPosts as $post) {
//                                        $new_row = ($i % 4 == 0) ? true : false;
//                                        if ($new_row) {
//                                            ?>
<!--                                            <div class="row">-->
<!--                                            --><?php
//                                        }
//                                        $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
//                                        $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
//                                        if (!file_exists($image_path)) {
//                                            $image = '//placehold.it/330x200';
//                                        }
//                                        ?>
<!--                                        <div class="col-md-12">-->
<!--                                            <div class="whats-new-box">-->
<!--                                                <div class="wn-box-icon">-->
<!--                                                    <a href="--><?//= Url::to('/blog/' . $post['slug']); ?><!--">-->
<!--                                                        <img src="--><?//= $image; ?><!--" alt="--><?//= $post['title']; ?><!--"/>-->
<!--                                                    </a>-->
<!--                                                </div>-->
<!--                                                <div class="wn-box-details">-->
<!--                                                    <a href="--><?//= Url::to('/blog/' . $post['slug']); ?><!--">-->
<!--                                                        <div class="wn-box-title">-->
<!--                                                            --><?//= $post['title']; ?>
<!--                                                        </div>-->
<!--                                                    </a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        --><?php
//                                        if ($new_row) {
//                                            ?>
<!--                                            </div>-->
<!--                                            --><?php
//                                        }
//                                        $i++;
//                                    }
//                                }
//                                ?>
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="info-btn">-->
<!--                                    <a href="--><?//= Url::to('/blog/category/infographics'); ?><!--" target="_blank">-->
<!--                                        View All-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div>
                    <div class="articles">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="articles-head">
                                    Articles
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="articles-g">
                                <?php
                                $i = 1;
                                if ($articalsPosts) {
                                    foreach ($articalsPosts as $post) {
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
                                        <div class="col-md-12">
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
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="articles-btn">
                                    <a href="<?= Url::to('/blog/category/articles'); ?>" target="_blank">
                                        View All
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mar-top-20">
                    <h1 class="heading-style">Career Advice</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="gallery-view">
                <?php foreach ($careerAdviceCategories as $category): ?>
                    <div class="col-md-4 col-sm-6 card-box">
                        <a href="<?= Url::to("/career-advice/" . $category["slug"]); ?>">
                            <div class="card">
                                <div class="card__block card__block--main">
                                    <h3 class="card__title">
                                        <?= $category["name"]; ?>
                                    </h3>
                                    <div class='card__element card__element--user-img'>
                                        <div class="pos-rel">
                                            <img src="<?= $category["icon"]; ?>" alt="<?= $category["name"]; ?>"/>
                                        </div>
                                    </div>
                                    <div class="view-btn <?= $category["buttonColor"]; ?>">
                                        <span>View</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?= $this->render('/widgets/news-update') ?>
    <!--    <section class="ca-coming-soon-sec">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-12">-->
    <!--                <div class="col-md-5 col-md-offset-1">-->
    <!--                    <div class="ca-coming-pos-rel">-->
    <!--                        <div class="max-500">-->
    <!--                            <div class="ca-coming-text">Hey There,</div>-->
    <!--                            <div class="ca-soon-text">-->
    <!--                                We are launching a detailed space for you to understand the in and out of each-->
    <!--                                profession.-->
    <!--                            </div>-->
    <!--                            <div class="ca-coming-text">Be exited</div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="col-md-6">-->
    <!--                    <div class="ca-comming-soon-icon">-->
    <!--                        <img src="--><? //= Url::to('@eyAssets/images/pages/custom/career-advice-vector.png') ?><!--" alt="">-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <section>

        <section class="blog-mirror">
            <div class="my-container">
                <div class="container pt-20 pb-5">
                    <hr style="color: #ff704d;width: 50px;margin-left: 5px; border-top:3px solid #ff704d;margin-bottom: 0px;"/>
                    <h3 style="font-family:lobster;font-size:28pt;color:#FFF;margin-top:3px;"><?= Yii::t('frontend', 'Food for Thoughts'); ?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <article class="post clearfix">
                                <div class="entry-header">
                                    <div class="post-thumb">
                                        <div id="slider1" class="owl-carousel-4col" data-nav="true">
                                            <?php
                                            foreach ($quotes as $post) {
                                                ?>
                                                <div class="zoom">
                                                    <img class="imgsdds" src="<?= Url::to($post['image']); ?>"
                                                         width="570"
                                                         height="133" alt="<?= $post['featured_image_alt']; ?>"
                                                         title="<?= $post['featured_image_title']; ?>"
                                                         url="<?= Yii::$app->urlManager->createAbsoluteUrl('/blog/' . $post['slug']); ?>">
                                                    <a href="<?= Url::to('/blog/' . $post['slug']); ?>" class="carousel-content">

                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container-fluid no-padd">
            <div class="row mar-0">
                <div class="col-md-6 col-sm-6 no-padd">
                    <div class="ca-coming-pos-rel">
                        <div class="max-500">
                            <div class="ca-coming-text">Hey There,</div>
                            <div class="ca-soon-text">
                                We are launching a detailed space for you to understand the in and out of each
                                profession.
                            </div>
                            <div class="ca-coming-text">Be excited</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 no-padd">
                    <div class="ca-comming-soon-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/career-advice-vector.png') ?>" alt="">
                    </div>
                </div>
            </div>
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
echo $this->render('/widgets/blogs/whats-new');
echo $this->render('/widgets/blogs/popular-blogs');
echo $this->render('/widgets/blogs/trending-posts');
$this->registerCss('
#slider1 .owl-stage-outer {
    overflow: visible !important;
    z-index:1000;
}
.carousel-content{
    width:100%;
    height:100%;
}
.owl-controls {
    display: none !important;
}
.zoom {
    transition: transform .4s;
    width: 253px;
    height: 320px;
    margin: 0 auto;
    padding: 50px 0;
    top:-10px;
    left:-10px;
    transition-timing-function: linear;
    z-index:300;
}
.zoom img{
    height:200px;
    z-index:-500;
}
.zoom:hover{
    -ms-transform: scale(1.4); /* IE 9 */
    -webkit-transform: scale(1.4); /* Safari 3-8 */
    transform: scale(1.4);
    z-index: 999;
}
.info-head, .articles-head {
    font-size: 20px;
    font-family: \'Lobster\';
    color: #000;
    text-align: center;
    padding: 15px;
}
.info-btn, .articles-btn {
    text-align: center;
    margin-top: -15px;
}
.info-btn a, .articles-btn a{
    background-color: #00a0e3;
    border-radius: 5px;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 13px;
    padding: 8px 15px;
    transition: all 0.3s;
    cursor: pointer;
    margin-top: 15px;
    display: inline-block;
}
.info-btn a:hover, .articles-btn a:hover{
    background-color: #fff;
    border: 1px solid #00a0e3;
    color: #00a0e3;
}
.whats-new-box {
    border-radius: 5px;
    margin-bottom: 20px;
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
    height: 150px !important;
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
    text-align:left;
}
.wn-box-details {
    border-top: none;
    padding: 10px 10px 10px 15px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius: 0 0 5px 5px;
}
.wn-box-title {
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	font-family: roboto;
	font-size: 16px;
	text-align: left;
	font-weight: 500 !important;
}
.blog-mirror {
    background: linear-gradient(180deg, #2b2d32 60%, #fff 40%);
}
.whats-block-heading, .whats-popular-heading, .trending-heading{
    position:relative;
    text-align:right;
    font-size:14px;
    text-transform: uppercase;
    padding: 0px 25px 2px 0px;
    font-weight: bold;
    margin-bottom:20px;
}
.whats-block-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 130px 0px 0px;
    top: 11px;
    left: 5px;
}
.whats-block-heading:after, .whats-popular-heading:after, .trending-heading:after{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 18px 0px 0px;
    top: 11px;
    right: 5px;
}
.whats-popular-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 380px 0px 0px;
    top: 11px;
    left: 5px;
}
.trending-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 68px 0px 0px;
    top: 11px;
    left: 5px;
}
.view-all-articles {
	text-align: center;
	margin: 25px 0 0;
}
.artic {
    border:2px solid transparent;
	background-color: #00a0e3;
	color: #fff;
	font-size: 18px;
	font-family: roboto;
	padding: 7px 30px;
	border-radius: 4px;
	text-transform: capitalize;
	transition: all .3s;
}
.artic:hover{
    background-color:#fff;
    color:#00a0e3;
    border:2px solid #00a0e3;
}
.career-txt h1 {
    font-size: 42px;
    font-family: lobster;
    min-height: 370px;
    display: flex;
    justify-content: flex-start;
    align-items: flex-end;
    color: #000;
}
.ca-comming-soon-icon{
    text-align:right
}
.no-padd{
    padding-left:0px;
    padding-right:0px;
}
.mar-0{
    margin-left:0px;
    margin-right:0px;
}
.mar-top-20{
    margin-top:40px;
}
.career-advice-header{
    background:url(' . Url::to('@eyAssets/images/pages/custom/careeradvice-hdr-bg.png') . ');
    min-height:500px;
    background-size:cover;
    background-position: left;
    background-repeat: no-repeat;
}
body {
  background-color:#fefefe;
  font-family: var(--font-family-primary);
  font-size: 16px;
  line-height: 1.425;
}
#footer{
    margin-top:0px;
}
.ca-coming-pos-rel{
    position:relative;
    min-height:400px;
}
.max-500{
    max-width: 500px;
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
}
.ca-soon-text{
    font-size:25px;
    font-family:lora;
    color:#000;
}
.ca-coming-text{
    font-size:30px;
    font-family:lora;
    color:#000;
}
.ca-coming-soon-sec{
    background-repeat: no-repeat;
    background-size: cover;
    min-height:400px;
    margin-top:50px;
    position:relative;
}
.vb-blue a:hover, .card:hover > .card__block--main > .vb-blue > a{
    color: #0c9aff;
}
.vb-pink a:hover, .card:hover > .card__block--main > .vb-pink > a{
    color: #ff6386;
}
.vb-orange a:hover, .card:hover > .card__block--main > .vb-orange > a{
    color: #ffd3a5;
}
.vb-green a:hover, .card:hover > .card__block--main > .vb-green > a{
    color: #4f9b94;
}
.vb-purple a:hover, .card:hover > .card__block--main > .vb-purple > a{
    color: #5f3d8c;
}
.vb-red a:hover, .card:hover > .card__block--main > .vb-red > a{
    color: #e85b56;
}
.view-btn{
    position:absolute;
    bottom:10px;
    right:15px
}
.view-btn span { 
    color:#333;
    font-size:15px;
}
.layout__wrapper {
  margin: auto;
  width: 990px;
}

.section {
  padding: 40px;
}

.section__title {
  color: #000000;
  font-size: 2.15rem;
  margin: 0;
  margin-bottom: 2.5rem;
}

.gallery__item--highlight {
  grid-column: span 2;
}
.card-box:nth-child(1n) .card::before, card-box:nth-child(7n) .card::before {
   background-image:linear-gradient( 135deg, #9cd6ff 10%, #0c9aff 100%); /*blue*/
}
.card-box:nth-child(2n) .card::before, .card-box:nth-child(11n) .card::before{
   background-image:linear-gradient( 135deg, #ffa3b8 10%, #ff6386 100%); /*pink*/
}
.card-box:nth-child(3n) .card::before {
    background-image:linear-gradient( 135deg, #FFD3A5 10%, #FD6585 100%); 
}
.card-box:nth-child(4n) .card::before {
   background-image:linear-gradient( 135deg, #b875e8 10%, #5f3d8c 100%); 
}
.card-box:nth-child(6n) .card::before,.card-box:nth-child(12n) .card::before  {
   background-image:linear-gradient( 135deg, #8bf4bb 10%, #4f9b94 100%); /*Green*/
}
.card-box:nth-child(5n) .card::before, .card-box:nth-child(8n) .card::before {
   background-image:linear-gradient( 135deg, #e85b56 10%, #6f2347 100%); 
}
 .card-box:nth-child(10n) .card::before{
   background-image:linear-gradient( 135deg, #b875e8 10%, #5f3d8c 100%); 
}

.card {
  position: relative;
  padding-top: 75px;
  max-width:230px;
  margin: 15px auto;
}
@media only screen and (max-width: 1200px) and (min-width:992px){
    .card{
        margin: 0 auto;
    }
} 
@media only screen and (max-width: 992px){
    .career-advice-header{
        min-height:300px;
    }
    .career-txt h1{
    font-size: 35px;
    min-height: 260px;
    }
}
.card:hover::before{
    right: 0px;
    bottom: 0px;
    curser: pointer;
    transition: .5s ease;
}
.card::before {
  background-image: var(--gradient-1);
  border-radius: 15px;
  box-shadow: 2px 0px 20px rgba(0, 0, 0, .1);
  bottom: 30px;
  content: \'\';
  left: -35px;
  position: absolute;
  right: 35px;
  top: 20px;  
  transition: .5s ease;
}

.card__block--main {
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 2px 5px 25px rgba(0, 0, 0, .15);
  min-height: 200px;
  padding: 20px;
  padding-top: 50px;
  position: relative;
  z-index: 2;
}

.card__element--user-img,
.card__element--user-img svg {
  --size: 70px;  
  background-color: #fff;
  border-radius: 50%;
  box-shadow:0 0 10px rgba(0,0,0,.1);
  left: 10px;
  position: absolute;
  top: calc(-1 * (var(--size) / 2));
  width: var(--size);
  height: var(--size);
}
.pos-rel{
    position: relative;
    height:70px;
    width:70px;   
}
.card__element--user-img img{
    max-width:100%;
    max-height:100%;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}

.card__element--user-img svg {
  background-color: hsl(35, 92%, 71%);
  fill: #000;
}

.card__title {
  font-size: 1.40rem;
  font-weight: 500;
  line-height: 1.3;
  margin: 0;
  font-family:roboto;
}

.card__subtitle {
  color: hsl(210, 5%, 41%);
  font-size: 1rem;
  margin-top: .93rem;
}

.card__text {
  margin-top: .66rem;
}

.trade {
  bottom: 0;
  padding-top: 1.5rem !important /* @TODO temp !!!*/;
  position: absolute;
  right: 1.5rem;
  transition: transform .2s;
}

.trade:hover {
  transform: translateY(.25rem);
}

//.button {
//  background-color: #000000;
//  border: 1px solid #000000;
//  box-shadow: 0 3px 0 #000000;
//  border-radius: 10px;
//  cursor: pointer;
//  color: #ffffff;
//  font-family: var(--font-family-primary);
//  font-size: 1rem;
//  font-weight: bold;
//  letter-spacing: .15rem;
//  padding: .75rem 1.5rem;
//}
.button--primary {
  background-color: hsl(210, 5%, 41%);
  border-color: hsl(210, 5%, 36%);
  box-shadow: 0 5px 0 hsl(210, 5%, 20%);
}

.button--primary:hover {
  background-color: hsl(210, 5%, 51%);
  border-color: hsl(210, 5%, 41%);
}

.like {
  right: 35px;
  position: absolute;
  top: 0;
}

.like {
  background-color: transparent;
  border-color: transparent;
  box-shadow: none;
  padding: .75rem;
} 

.like .button-text {
  display: none;
}

.like svg {
  fill: #fff;
  height: 25px;
  width: 25px;
} 
@media only screen and (max-width: 600px) and (min-width:320px){
.career-txt h1 {
    font-size: 30px;
    min-height:190px;
    }
}
@media only screen and (max-width: 1200px) and (min-width: 992px){
    .blog-img img{
        height:220px;
        object-fit:cover;
    }
    .whats-block-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 87px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .whats-popular-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 290px 0px 0px;
        top: 11px;
        left: 5px
    }
}
@media only screen and (max-width: 991px){
    .blog-box{
        margin-top:15px;
        box-shadow:0 0 10px rgba(0,0,0,.5);
    }
    .blog-discription{
        height:200px;
    }
    .blog-img img{
        height:210px;
        object-fit:cover;
    }
    .whats-block-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 521px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .whats-block-heading {
        position: relative;
        text-align: right;
        text-transform: uppercase;
        padding: 0px 70px 2px 0px;
        font-weight: bold;
    }
    .whats-block-heading:after {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 58px 0px 0px;
        top: 11px;
        right: 5px;
    }
    .whats-popular-heading {
        position: relative;
        text-align: right;
        text-transform: uppercase;
        padding: 0px 70px 2px 0px;
        font-weight: bold;  
    }
     .whats-popular-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 290px 0px 0px;
        top: 11px;
        left: 5px
    }
    .whats-popular-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 490px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .whats-popular-heading:after {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 58px 0px 0px;
        top: 12px;
        right: 5px;
    }
    .section-1-shadow {
        box-shadow: none;
    }
 }
 a.button {
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
}
a.button span {
  color:#fff;
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.3s;
}
a.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  color:#fff;
  right: -20px;
  transition: 0.5s;
}
a.button:hover span {
  padding-right: 20px;
}

a.button:hover span:after {
  opacity: 1;
  right: 0;
}
@media screen and (max-width: 450px){
    .zoom img{
        width:79vw !important;
    }
    .zoom{
        padding-left: 26px;
    }
}
@media screen and (max-width: 768px){
    .controls {
        margin-top: 35px;
    }
    .owl-stage-outer{
        overflow: hidden !important;
    }
    .zoom:hover{
        -ms-transform: scale(1.5,1.2);
        -webkit-transform: scale(1.5,1.2);
        transform: scale(1.5,1.2);
        left: 8%;
   }   
}

');
$script = <<<JS
$.ajax({
    method: "POST",
    url : '/blog/trending-posts',
    success: function(response) {
    if(response.status === 200) {
        var wn_data = $('#whats-new-blog').html();
        $("#whats-new").html(Mustache.render(wn_data, response.whats_new_posts));
        var pb_data = $('#trending-blog').html();
        $("#trending-post").html(Mustache.render(pb_data, response.trending_posts));
        var tb_data = $('#popular-blog-post').html();
        $("#popular-blog").html(Mustache.render(tb_data, response.popular_posts));
    }
}
});
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');