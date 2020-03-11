<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

$this->title = Yii::t('frontend', $data['title']);
$keywords = $data['title'] . "," . $data['primary_category']['title'] . "," . $data['primary_subcategory']['title'] . ', Udemy Courses';
$description = $data['headline'];
$image = $data['image_750x422'];
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section class="bg-set-clr">
        <div class="container">
            <div class="row">
                <div class="set-line-main">
                    <div class="c-heading"><?= $data['title']; ?></div>
                    <div class="c-suggestion"><?= $data['headline'] ?></div>
                    <div class="c-created">Created by :
                        <span>
                                <?php
                                $cr = [];
                                foreach ($data['visible_instructors'] as $c) {
                                    array_push($cr, $c['display_name']);
                                }
                                echo implode(",", $cr);
                                ?>
                            </span>
                    </div>
                    <div class="c-lang">Languages : <span><?= $data['locale']['title'] ?></span></div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="about-course">
                        <div class="course-heading">About this course</div>
                        <div class="course-detail">
                            <?= $data['description']; ?>
                        </div>
                    </div>
                    <div class="learn-box">
                        <h3>What you will learn</h3>
                        <div class="points">
                            <?php
                            foreach ($data['what_you_will_learn_data']['items'] as $d) {
                                ?>
                                <div class="learning-cards"><i class="fas fa-check-circle"></i>
                                    <?= $d ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="c-requirements">
                        <h3>Requirements</h3>
                        <div class="req-points">
                            <ul>
                                <?php
                                foreach ($data['requirements_data']['items'] as $r) {
                                    ?>
                                    <li>
                                        <?= $r; ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="buy-box">
                        <div class="c-preview">
                            <img src="<?= $data['image_304x171'] ?>"/>
                        </div>
                        <div class="c-amount"><?= $data['price'] ?></div>
                        <div class="buy-btn">
                            <a href="https://udemy.com<?= $data['url'] ?>" target="_blank" class="new-btn-set">Enroll
                                Now</a>
                        </div>
                        <div class="c-includes">
                            <div class="include-head">This Course Includes</div>
                            <div class="include-inner">
                                <ul>
                                    <li><?= $data['content_info'] ?> on-demand video</li>
                                    <?php if ($data['num_article_assets']) { ?>
                                        <li><?= $data['num_article_assets'] ?> articles</li><?php } ?>
                                    <?php if ($data['num_additional_assets']) { ?>
                                        <li><?= $data['num_additional_assets'] ?> downloadable resources</li><?php } ?>
                                    <?php if ($data['num_coding_exercises']) { ?>
                                        <li><?= $data['num_coding_exercises'] ?> Exercises</li><?php } ?>
                                    <?php if ($data['has_certificate']) { ?>
                                        <li>Certificate of Completion</li><?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- CD Detail -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-2186770765824304"
                         data-ad-slot="7361632777"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <br/>
                    <!-- CD Detail 1 -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-2186770765824304"
                         data-ad-slot="2035786927"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <br/>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.bg-set-clr {
    background-color:#505763;
    color:#fff;
    font-family: roboto;
}
.bg-set-clr > .container {
    padding-top:0px !important;
}
.set-line-main{
    padding: 60px;
    text-align: center;
}
.c-heading {
    font-size: 30px;
    font-weight: 500;
}
.c-suggestion {
    font-size: 20px;
}
.c-created span, .c-lang span{
    font-size: 16px;
    color:aquamarine;
    margin-left:8px;
}
.c-lang, .c-created {
    font-size: 16px;
}
.about-course {
    padding: 10px 0px 30px 0px;
    font-family: roboto;
}
.course-heading {
    font-size: 25px;
    font-weight: 500;
    text-transform: capitalize;
    color:#333;
}
.course-detail {
    font-size: 15px;
    text-align: justify;
}
.learn-box, .skills-box {
    border: 1px solid #eee;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px -3px #eee;
    margin-bottom:25px;
}
.learn-box h3, .skills-box h3, .c-requirements h3{
    margin:0px;
    font-family: roboto;
    font-weight: 500;
    text-transform:capitalize;
}
.learning-cards {
    text-align: left;
    display: inline-flex;
    width: 100%;
    margin: 5px;
    font-size: 16px;
    text-transform: capitalize;
    font-family: roboto;
}
.learning-cards > i {
    margin-right:10px;
    color: #42ca26;
    padding-top: 5px;
}
@media (max-width:417px){
.learning-cards{
    width:100%;
}
.c-heading{
    font-size:20px;
}
.c-suggestion {
    font-size: 14px;
}
.c-lang, .c-created {
    font-size: 13px;
}
.c-created span, .c-lang span {
    font-size: 13px;
}
.buy-box{
    margin-top:35px;
}
}
.points {
    padding-top: 10px;
}
.skills-cards {
    display: inline-block;
    background-color: #eee;
    padding: 2px 10px;
    border-radius: 5px;
    margin-right: 10px;
    font-size: 15px;
    font-family: roboto;
}
.video-sec {
    border: 1px solid #eee;
    margin-top: 10px;
    border-radius: 5px;
    box-shadow: 0px 0px 5px 0px #eee;
}
.video-thumb {
    width: 100%;
    height: 400px;
}
.video-thumb img{
    width: 100%;
    height: 100%;
    border-radius: 5px;
}
.buy-box {
    border: 1px solid #eee;
    padding:20px;
    border-radius: 5px;
    box-shadow: 0px 0px 5px 0px #eee;
    margin-top: 10px;
}
.c-preview {
    margin: 0 auto;
    line-height: 100px;
    text-align: center;
}
.c-preview img{
    height:auto;
    width:100%;
}
.c-amount {
    text-align: center;
    padding: 25px 10px 15px 10px;
    font-size: 20px;
    font-family: roboto;
    font-weight: 500;
}
.buy-btn {
    transition: all 250ms ease-out, transform 250ms ease-out, -webkit-transform 250ms ease-out;
}
.buy-btn:hover {
    transform: translate3d(0, -3px, 0);
    box-shadow: 0px 7px 13px rgba(0, 0, 0, 0.14);
}
.new-btn-set {
    width: 100%;
    color: #fff;
    background-color:#00a0e3;
    border: 1px solid transparent;
    padding: 11px 12px;
    font-size: 20px;
    border-radius: 4px;
    font-weight: 500;
    font-family: roboto;
    display:block;
    text-align:center;
}
.include-head {
    padding-top: 10px;
    font-size: 16px;
    font-family: roboto;
    font-weight: 500;
}
.include-inner > ul > li {
    list-style: inside;
    font-size: 15px;
    font-family: roboto;
}
.req-points {
    padding-top: 10px;
    padding-left: 18px;
}
.req-points > ul > li {
    list-style: disc;
    font-size: 15px;
    font-family: roboto;
}
.discount-set {
    text-align: right;
}
.discount-set a{
    font-size: 13px;
    color:#bd6666;
    font-family: roboto;
}
.btn-primary{
    width:100%;
}
.coupon-modal{
    display:none;
}
.coupon-code {
    border: none;
    background-color: #fff;
    color:#ce3c3c;
    font-size: 12px;
    font-family: roboto;
}
.set-marg {
    margin: 10px 0px;
}
.coupon-btn-set {
    width: 100%;
    color: #fff;
    background-color:#ff7803;
    border: 1px solid transparent;
    padding: 11px 12px;
    font-size: 20px;
    border-radius: 4px;
    font-weight: 500;
    font-family: roboto;
}
.set-form{
    height: 50px;
    font-size: 20px;
    line-height: 30px;
    font-weight: bold;
    border: 1px dashed;
    border-color: #5677fc;
}
.get-btn{
    height: 50px;
    background-color: #00a0e3;
    color:#ffffff;
    border-color:#00a0e3;
    -webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    -o-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;
}
.get-btn > i{
    margin-right:5px;
}
.get-btn:hover {
    color:#00a0e3;
    background-color:#ffffff;
    border-color:#00a0e3;
}
.clipboard.btn.btn-default.get-btn:focus {
    background-color: #fff;
}
.clipboard.btn.btn-default.get-btn:active{
    background-color: #fff;
}
.get-coupon{
    margin: 10px 0px;
}
');