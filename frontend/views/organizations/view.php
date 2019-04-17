<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['disablefacebookMessenger'] = true;

if ($organization['logo']) {
    $image_path = Yii::$app->params->upload_directories->organizations->logo_path . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    $image = Yii::$app->params->upload_directories->organizations->logo . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    if (!file_exists($image_path)) {
        $image = $organization['name'];
    }
} else {
    $image = $organization['name'];
}
if ($organization['cover_image']) {
    $cover_image_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    $cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    if (!file_exists($cover_image_path)) {
        $cover_image = "/assets/themes/ey/images/backgrounds/default_cover.png";
    }
} else {
    $cover_image = "/assets/themes/ey/images/backgrounds/default_cover.png";
}
?>
    <section>
        <div class="header-bg" style='background-image:url("<?= Url::to($cover_image); ?>");'>
            <div class="cover-bg-color"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="h-inner">
                            <div class="logo-absolute">
                                <div class="logo-box">
                                    <div class="logo">
                                        <?php
                                        if (!empty($image_path)):
                                            ?>
                                            <img id="logo-img" src="<?= Url::to($image); ?>">
                                        <?php else: ?>
                                            <canvas class="user-icon" name="<?= $image; ?>"
                                                    color="<?= $organization['initials_color'] ?>" width="200"
                                                    height="200" font="100px"></canvas>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="com-details">
                                    <div class="com-name"><?= Html::encode($organization['name']) ?></div>
                                    <?php if (!empty($organization['tag_line'])) { ?>
                                        <div class="com-establish"><span
                                                class="detail-title">Tagline:</span> <?= Html::encode($organization['tag_line']); ?>
                                        </div><?php } ?>
                                    <?php if (!empty($industry['industry'])) { ?>
                                        <div class="com-establish"><span
                                                class="detail-title">Industry:</span> <?= Html::encode($industry['industry']); ?>
                                        </div><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container padd-top-0">
            <div class="row">
                <div class="col-md-6 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-12">
                    <ul class="nav nav-tabs nav-padd-20">
                        <li class="active"><a data-toggle="tab" href="#home">Overview</a></li>
                        <li><a data-toggle="tab" href="#menu1">Opportunities</a></li>
                        <li><a data-toggle="tab" href="#tab4">Locations</a></li>
                        <li><a data-toggle="tab" href="#menu4">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="follow-btn">
                        <?php if (!empty($follow) && $follow['followed'] == 1) {
                            ?>
                            <button class="follow">Following</button>

                            <?php
                        } elseif (!Yii::$app->user->isGuest) {
                            ?>
                            <button class="follow">Follow</button>
                        <?php } ?>
                    </div>
                    <div class="social-btns">
                        <?php if (!empty($organization['facebook'])) { ?><a
                            href="<?= Html::encode($organization['facebook']) ?>" class="facebook" target="_blank"><i
                                        class="fa fa-facebook"></i> </a><?php } ?>
                        <?php if (!empty($organization['twitter'])) { ?><a
                            href="<?= Html::encode($organization['twitter']) ?>" class="twitter" target="_blank"><i
                                        class="fa fa-twitter"></i> </a><?php } ?>
                        <?php if (!empty($organization['linkedin'])) { ?><a
                            href="<?= Html::encode($organization['linkedin']) ?>" class="linkedin" target="_blank"><i
                                        class="fa fa-linkedin"></i> </a><?php } ?>
                        <?php if (!empty($organization['website'])) { ?><a
                            href="<?= Html::encode($organization['website']) ?>" class="web" target="_blank"><i
                                        class="fa fa-link"></i> </a><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="heading-style">
                            About <?= Html::encode($organization['name']) ?>
                        </div>
                        <div class="divider"></div>

                        <div class="col-md-7 col-xs-12">
                            <div class="com-description">
                                <?= Html::encode($organization['description']) ?>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="a-boxs">
                                <div class="row margin-0">
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <?= $organization['number_of_employees'] ? Html::encode($organization['number_of_employees']) : 'N/A' ?>
                                                </div>
                                                <div class="det-heading">Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det"><?= $count_opportunities ?></div>
                                                <div class="det-heading">Opportunities</Opper></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <?= $organization['establishment_year'] ? $organization['establishment_year'] : 'N/A' ?>
                                                </div>
                                                <div class="det-heading">Established</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($organization['mission']) || !empty($organization['vision'])) { ?>
                        <div class="row">
                            <div class="mv-box">
                                <div class="heading-style">Mission & Vision</div>
                                <div class="divider"></div>
                                <div class="col-md-12">
                                    <?php if (!empty($organization['mission'])) { ?>
                                        <div class="mv-heading">
                                            Mission
                                        </div>
                                        <div class="mv-text">
                                            <?= Html::encode($organization['mission']) ?>
                                        </div>
                                    <?php }
                                    if (!empty($organization['vision'])) {
                                        ?>
                                        <div class="vission-box">
                                            <div class="mv-heading">
                                                Vision
                                            </div>
                                            <div class="mv-text">
                                                <?= Html::encode($organization['vision']) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (!empty($benefit)) {
                        ?>
                        <div class="row">
                            <div class="company-benefits">
                                <div class="heading-style">Employee Benefits</div>
                                <div class="divider"></div>
                                <div class="com-benefits no-padd">
                                    <?php
                                    foreach ($benefit as $benefits) {
                                        ?>
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="benefit-box">
                                                <div class="bb-icon">
                                                    <?php
                                                    if (!empty($benefits['icon'])) {
                                                        $benefit_icon = Url::to('/assets/icons/' . $benefits['icon_location'] . DIRECTORY_SEPARATOR . $benefits['icon']);
                                                    } else {
                                                        $benefit_icon = Url::to('@commonAssets/employee-benefits/plus-icon.svg');
                                                    }
                                                    ?>
                                                    <img src="<?= Url::to($benefits['icon']); ?>">
                                                </div>
                                                <div class="bb-text">
                                                    <?= Html::encode($benefits['benefit']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (!empty($gallery)) {
                    ?>
                    <div class="row">
                        <div class="office-view">
                            <div class="heading-style">
                                Inside <?= Html::encode($organization['name']) ?>
                            </div>
                            <div class="divider"></div>
                            <div class="office-pics">
                                <?php
                                foreach ($gallery as $g_image) {
                                    ?>
                                    <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                        <div class="img1">
                                            <a href="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $g_image['image_location'] . DIRECTORY_SEPARATOR . $g_image['image']) ?>"
                                               data-fancybox="image">
                                                <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $g_image['image_location'] . DIRECTORY_SEPARATOR . $g_image['image']) ?>"
                                                     alt="company image 1">
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    if(!empty($org_products['organizationProductImages']) || !empty($org_products['description'])){
                        ?>
                        <div class="row">
                            <div class="office-view">
                                <div class="heading-style">
                                    Products
                                </div>
                                <div class="divider"></div>
                                <?php if(!empty($org_products['organizationProductImages'])){ ?>
                                <div class="office-pics">
                                    <div class="col-md-10 col-md-offset-1 col-sm-6 col-xs-12 no-padd">
                                        <div class="p-preview-img">
                                            <a href="" data-fancybox="images">
                                                <img src="" alt="company image 1">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 col-xs-12 no-padd text-center">
                                        <?php
                                        foreach ($org_products['organizationProductImages'] as $p_image) {
                                            ?>
                                            <div class="p-img-thumbnail" style="float: none;display: inline-block;">
                                                <a href="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $p_image['image_location'] . DIRECTORY_SEPARATOR . $p_image['image']) ?>"
                                                   data-fancybox="images">
                                                    <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $p_image['image_location'] . DIRECTORY_SEPARATOR . $p_image['image']) ?>"
                                                         alt="<?= $p_image['title'] ?>">
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                }
                                if(!empty($org_products['description'])){
                                ?>
                                <div class="col-md-12 col-sm-6 col-xs-12 no-padd">
                                    <h4>Brief Desciption</h4>
                                    <p>
                                        <?= $org_products['description']; ?>
                                    </p>
                                </div>
                                    <?php } ?>
                            </div>
                        </div>
                    <?php }
                    if (!empty($our_team)) {
                        ?>
                        <div class="row">
                            <div class="company-team">
                                <div class="heading-style">Meet The Team</div>
                                <div class="divider"></div>
                                <div class="team-box">
                                    <?php
                                    foreach ($our_team as $team) {
                                        ?>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="team-container">
                                                <a href="#">
                                                    <div class="team-icon">
                                                        <img src="<?= Url::to('/' . $team['image_location'] . DIRECTORY_SEPARATOR . $team['image']) ?>">
                                                        <?php if (!empty($team['facebook']) || !empty($team['linkedin']) || !empty($team['twitter'])) { ?>
                                                            <div class="team-overlay">
                                                                <div class="team-text">
                                                                    <div class="know-bet">Know me better</div>
                                                                    <?php if (!empty($team['facebook'])) { ?><a
                                                                        href="<?= Html::encode($team['facebook']); ?>"
                                                                        target="_blank"><i
                                                                                    class="fa fa-facebook t-fb"></i>
                                                                        </a><?php } ?>
                                                                    <?php if (!empty($team['linkedin'])) { ?><a
                                                                        href="<?= Html::encode($team['linkedin']); ?>"
                                                                        target="_blank"><i
                                                                                    class="fa fa-linkedin t-ln"></i>
                                                                        </a><?php } ?>
                                                                    <?php if (!empty($team['twitter'])) { ?><a
                                                                        href="<?= Html::encode($team['twitter']); ?>"
                                                                        target="_blank"><i
                                                                                    class="fa fa-twitter t-tw"></i>
                                                                        </a><?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="t-member">
                                                        <div class="t-name"><?= Html::encode($team['first_name'] . $team['last_name']); ?></div>
                                                        <div class="t-post"><?= Html::encode($team['designation']) ?></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="row">
                        <div class="heading-style">
                            Available Jobs
                            <div class="pull-right">
                                <a href="/jobs/list?company=<?= $organization['slug'] ?>" class="write-review">View
                                    All</a>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="blogbox"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="internships-block">
                            <div class="heading-style">
                                Available Internships
                                <div class="pull-right">
                                    <a href="/internships/list?company=<?= $organization['slug'] ?>"
                                       class="write-review">View All</a>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="internships_main"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab4" class="tab-pane fade">
                    <div class="row">
                        <div class="address-division">
                            <div class="heading-style">
                                Address
                            </div>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="head-office">

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu4" class="tab-pane fade">
                    <div class="row">
                        <div class="address-division">
                            <div class="heading-style">
                                <?= Html::encode($organization['name']) ?> Reviews
                                <div class="pull-right">
                                    <a href="/<?= $organization['slug'] ?>/reviews" class="write-review">Write
                                        Review</a>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div id="org-reviews"></div>
                            <div class="viewbtn">
                                <a href="/<?= $organization['slug'] ?>/reviews">View All Review</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                         alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="organisation_id" value="<?= Html::encode($organization['organization_enc_id']) ?>"/>
    <section>
        <div class="container">
            <div class="empty-field">
                <input type="hidden" id="loggedIn"
                       value="<?= (!Yii::$app->user->identity->organization->organization_enc_id && !Yii::$app->user->isGuest) ? 'yes' : '' ?>">
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p>Please Login as Candidate to drop your resume</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </section>
    <section>
        <div class="container">
            <div class="empty-field">
                <input type="hidden" id="dropcv">
            </div>
            <!-- Modal -->
            <div class="modal fade" id="existsModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Company hasn't created any data for this feature</h4>
                        </div>
                        <div class="modal-body">
                            <p>Wait for company to create the feature</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </section>
<?php
echo $this->render('/widgets/mustache/organization_locations', [
    'Edit' => false
]);
echo $this->render('/widgets/mustache/application-card');
echo $this->render('/widgets/drop_resume', [
    'username' => Yii::$app->user->identity->username
]);
echo $this->render('/widgets/mustache/organization-reviews', [
    'org_slug' => $organization['slug']
]);
$this->registerCss('
.write-review{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #00a0e3;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
.write-review:hover{
    background-color: #00a0e3;
    color: #fff;
}
/*----jobs and internships----*/
.internships-block{
    padding-top:30px;
}
/*----jobs and internships ends----*/
/*----review----*/
.viewbtn a{
    border: 1px solid #ebefef;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    -o-box-shadow: none;
    box-shadow: none;
    padding: 15px 44px;
    font-size: 15px;
    color: #111111;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px
}
.viewbtn a:hover{
    background-color: #00a0e3;
    color: #fff;
    border-color: transparent;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.re-box{
    margin: 60px 0 0 0;
}
.refirst{
   margin:0 0 0 0 !important; 
}
.viewbtn{
    text-align:center;
    margin:60px 0 0 0 ;
}
.uicon{
    text-align:center;
}
.uicon img{
    max-height:80px;
    max-width:80px;
}
.uname{
    text-align:center;
    text-transform:uppercase;
    font-weight:bold;
    padding-top:10px;
    line-height:15px;
    color:#00a0e3;
}
.user-saying{
    padding-top:20px;
}
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
    padding-top:20px;
}
.uheading{
    font-weight:bold;
    
}
.utext{
    text-align:justify;
}
.publish-date{
    text-align:right;
    font-size: 14px;
}
.view-detail-btn button{
    background:transparent;
    border:none;
    font-size:14px;
    padding:0px
}
.view-detail-btn button:hover, .re-btns button:hover{
    color:#00a0e3;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
}
.re-btns{
    text-align:right;
    padding-top: 5px;
}
.re-btns button{
    background:none;
    border:none;
    font-size:19px;
    color:#ccc;
}
.re-btns button:hover{
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.re-btns button:hover i.fa-flag{
    color:#d72a2a;
}
.re-btns button i.fa-thumbs-down{
    margin-left:-8px;
}
.utitle{
    font-size:20px;
    font-weight:bold;
    padding-top:8px;
    color:#00a0e3;
}
.user-review-main{
    border-left:2px solid #ccc;
    margin-bottom:30px;
}
.ur-bg{
   background:#edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    height: 95px;
}
.uratingtitle{
    font-size:12px;
    line-height:15px;
}
.urating{
    font-size:25px;
}
.emp-duration{
    text-align:right;
}
.ushare i{
   font-size:20px;
    color:#ccc; 
}
.ushare i.fa-facebook-square:hover{
    color:#4267B2; 
    cursor: pointer;
}
.ushare i.fa-twitter-square:hover{
    color:#38A1F3; 
    cursor: pointer;
}
.ushare i.fa-linkedin-square:hover{
    color:#0077B5;
    cursor: pointer; 
}
.ushare i.fa-google-plus-square:hover{
    color:#CC3333;
    cursor: pointer;
}
.ushare-heading{
    font-size:14px;
    padding-top:20px;
    line-height:23px;
    font-weight:bold;
}
.usefull-bttn{
    padding-top:33px;
    display:flex;
}
.re-bttn{
    text-align:right
}
.use-bttn button, .notuse-bttn button, .re-bttn button{
    background: transparent !important;
    border:1px solid #ccc;
    color:#ccc;
    padding:5px 15px;
    margin-left:10px;
    border-radius:10px;
    font-size:14px;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn{
    padding-bottom:5px;
}
.use-bttn button:hover{
    color:#00a0e3;
    border-color:#00a0e3;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn button:hover, .notuse-bttn button:hover{
    color:#d72a2a;
    border-color:#d72a2a;
     transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.review-summary{
    text-align:left;
    padding-left:50px
}
.oa-review{
    font-size:30px;
    font-family:lobster;
    padding-bottom:22px;
}
.rs1{
    padding-top:20px;
}
.re-heading{
    font-size: 17px;
    text-transform: capitalize;
    font-weight: bold;
}
.com-rating i{
    font-size:16px;
    background:#ccc;
    color:#fff;
    padding:7px 5px;
    border-radius:5px;
}
.com-rating i.active{
    background:#ff7803;
    color:#fff;
}
/*----review ends----*/
/*----company benefits----*/
.company-benefits{
    padding:30px 0 0 0;
}
.benefit-box{
    text-align:center;
    border:1px solid rgba(221, 216, 216, 0.1);
    padding:25px 10px;
    margin:0 0 15px 0;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
    padding-bottom: 0px;
    min-height: 165px;
    position:relative;
}
.bb-icon img{
    width:75px;
    height:75px;
}
.bb-text{
    padding-top:10px;
    text-transform:uppercase;
    font-size:15px;
    font-weight:bold;
}
/*----company benefits ends----*/
/*----mission & vission----*/
.mv-heading{
    font-size:20px;
    font-weight:bold;
    text-transform:uppercase;
}
.vission-box{
    padding-top:20px;
}
.mv-box{
    padding-top:20px;
}
/*----mission & vission end----*/
/*----team----*/
.company-team{
    padding-top:20px;
}
.team-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:100%;
    position:relative;
    margin: 0 0 20px 0;
}
.t-fb:hover{
    color:#3C5A99
}
.t-ln:hover{
    color:#0077B5;
}
.t-tw:hover{
    color:#1DA1F2;
}
.team-container:hover{
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.know-bet{
    font-size:14px;
    text-transform:uppercase;
    color:#00a0e3;
}
.team-container:hover .team-overlay {
  height: 100%;
}
.team-text {
  color: #000;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
.team-text a{
    padding:0 5px;
}
.team-icon{
    width:100%;
    height:186px;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.team-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.team-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(255,255,255,.9);
  overflow: hidden;
  width: 100%;
  height: 0;
  border-radius:10px 10px 0 0 ;
  transition: .5s ease;
}
.t-member{
    padding:5px 10px 10px 10px;
    text-align:center;
}
.t-name{
    font-size:16px;
    font-weight:bold;
}
/*----team ends----*/
/*----office view-----*/
.img1 img{
    width:285px;
    height:200px;
    object-fit:cover;
}
.office-view{
    padding:40px 0 0 0;
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important;
}
/*----office view ends----*/
/*----address----*/
.office-heading{
    font-weight:bold;
    font-size:18px;
    text-transform:uppercase;
}
.office-heading img{
    max-width:25px;
    margin-top:-5px;
}
.office-loc{
    padding:10px 20px;
}
.o-h2 img{
    max-width:15px;
    margin:0 5px 0 5px;
    margin-top:-5px;
}
#map{
    height: 300px; 
}
/*----address ends----*/
/*----about us-----*/
.com-description{
    font-size:15px;
    text-align:justify;
    line-height:22px;
}
.com-des-list{
    padding:10px 25px;
}
.com-des-list li{
  list-style-image:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/next.png') . ');  
}
.divider{
    border-top:1px solid #eee;
    padding:0 0 20px 0;
}
/*----about us ends----*/
/*----grid box----*/
.a-boxs{
        box-shadow: 2px 5px 24px rgba(221, 216, 216, 0.5);
}
.about-box{
    height:100px;
    border:1px solid rgba(238, 238, 238, .5);;
    text-align:center;
    position:relative;
}
.margin-0{
    margin-left:0px;
    margin-right:0px;
}
.about-det{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%); 
}
.det-heading{
    font-size:13px;
    font-weight:bold;
}
.det{
    font-size:16px;
    color:#00a0e3;
}
/*----grid box ends*/
/*----follow btn----*/
.follow-btn,.social-btns{
    text-align:center
}
.social-btns{
   margin-top:15px;
}
.social-btns a{
    margin:0 5px;
    padding:8px 0;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
a.twitter{
    padding:8px 6px 8px 10px;
      color:#1DA1F2;
}
.twitter:hover{
    background:#1da1f2;
    color:#fff;
}
a.facebook{
    padding:8px 9px 8px 12px;
    color:#3C5A99;   
}
.facebook:hover{
    background:#3c5a99;
    color:#fff;
}
a.linkedin{
    padding:8px 9px 8px 11px;
     color:#0077B5;
}
.linkedin:hover{
    background:#0077b5;
    color:#fff;
}
a.web{
    padding:8px 11px 8px 11px;
    color:#ff7803; 
}
.web:hover{
    background:#ff7803;
    color:#fff;
}
.follow{
    padding:10px 0px;
    width:167px;
     background: transparent;
    border:none;
    font-size: 16px;
    text-transform: capitalize;
    color: #00a0e3;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
.follow:hover{
    background:#00a0e3;
    color:#fff;
}
.follow, .follow:hover, a.facebook, .facebook:hover,
a.twitter, .twitter:hover, a.linkedin, .linkedin:hover, a.web, .web:hover{
    transition:.3s all;
}
/*----follow btn ends----*/
/*----tabs----*/
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
    color: #fff;
    background-color: #00a0e3 !important;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
     transition:.2s all;
     
}
.nav-tabs > li > a:hover{
   box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
   color:#00a0e3;
}
.nav-tabs>li>a{
    border:none;
}
.nav-tabs>li>a:hover{
    border:none;
}
/*----tabs end----*/
/*----company products css starts----*/
.p-img-thumbnail {
    width: 120px;
    height: 120px;
    float: left;
    line-height: 116px;
    border: 1px solid #eee;
    margin: 2px 5px;
}
.p-preview-img{
    height: 300px;
    text-align: center;
    line-height: 300px;
}
.p-preview-img a img{
    max-height: 300px;
}
.p-img-thumbnail a img{
    width: 100%;
    height: 100%;
}
/*----company products css ends----*/
.header-bg{
    background-repeat: no-repeat !important;
    background-size: 100% 100% !important;
    min-height:400px;
}
.h-inner{
    position:relative;
    min-height:400px;
    display: -webkit-box;
}
.logo-absolute{
    position:absolute;
    bottom:-60px;
    display:inherit;
    width:100%;
}
.com-details{width:auto;}
.logo-box{
    height:200px;
    width:200px;
    padding:0px;
    background:#fff;
    display:table; 
    text-align:center;
    border-radius:4px;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
    position:relative;
}
.logo{
    display:table-cell;
    vertical-align: middle;
}
.logo img, .logo canvas{
    border-radius:4px;
    max-height: 200px;
    width: 100%;
}
#upload-logo{
    margin-bottom:0px;
}
.com-name{
    font-size:40px;
    font-family:lobster;
    color:#fff;
    padding: 0 0 0 30px; 
}
.com-establish{
    color:#fff;
    padding: 0 0 0 30px; 
    font-size:15px;
}
.com-establish .detail-title{
    font-weight:bold;
    color:#fafafa;
}
.nav-padd-20{
    padding-left:50px;
}

@media screen and (min-width: 992px) and (max-width:1200px){
       .nav-padd-20{
        padding-left:90px;
    }
}
@media screen and (max-width: 992px){
    .img1 img{
        width:180px;
        height:125px;
        object-fit:cover;
    }
    .nav-padd-20{
        padding-left:120px;
        padding-bottom:20px;
    }
    .follow-btn,.social-btns{
        text-align:right
    }
}
@media screen and (max-width: 768px){
    .img1 img{
        width:100%;
        height:100%;   
    }
    .logo-box{
        margin:0 auto;
    }
    .padd-top-0{
        padding-top: 0px!important;
        margin-top:-20px !important;
    }
    .h-inner{
        display: block;
        min-height:500px;
    }
    .follow-btn, .social-btns{
        text-align:center;
    }
    .logo-absolute{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
    }
    .nav-padd-20{
        text-align:center;
        padding-left:0px;
    }
    .header-inner{
        height:100%;
        width:100%;
        padding:50px 0;
    }
    
}
.followed {
    background: #00a0e3;
    color: #fff;
}
.cover-bg-color{
    height: 100%;
    width: 100%;
    position: absolute;
    background-color: #00000057;
}
');
$script = <<<JS
$(document).on('click','.follow',function(e){
    e.preventDefault();
    var org_id = $('#organisation_id').val();
    $.ajax({
        url:'/organizations/follow',
        data: {org_id:org_id},                         
        method: 'post',
        beforeSend:function(){
         $('.follow').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        },
        success:function(data){  
            if(data.message == 'Following'){
                $('.follow').html('Following');
                $('.follow').addClass('followed');
            }
            else if(data.message == 'Unfollow'){
                $('.follow').html('Follow');
                $('.follow').removeClass('followed');
            }
        }
    });        
});

var data = {slug: window.location.pathname.split('/')[1]};
$.ajax({
    type: 'POST',
    url: '/drop-resume/check-resume',
    data : data,
    success: function(response){
        $('#dropcv').val(response.message);
    }
});

var first_preview = $('.p-img-thumbnail:first-child a').attr('href');
$('.p-preview-img a').attr('href', first_preview);
$('.p-preview-img a img').attr('src', first_preview);

$(document).on('mouseover', '.p-img-thumbnail', function(){
    var path = $(this).find('a').attr('href');
    $('.p-preview-img a').attr('href', path);
    $('.p-preview-img a img').attr('src', path);
});
JS;
$this->registerJs("
getCards('Jobs','.blogbox','/organizations/organization-opportunities/?org=" . $organization['slug'] . "');
getCards('Internships','.internships_main','/organizations/organization-opportunities/?org=" . $organization['slug'] . "');
");
$this->registerJs($script);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);