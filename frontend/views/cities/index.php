<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
    <section class="backgrounds">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-heading">
                        <div class="pos-center">
                            <div class="main-text"><i class="fas fa-map-marker-alt"></i> <?= implode(',', $city) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-set">
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box1">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/job.png') ?>">
                            <?php if ($job_count) { ?>
                                <span class="count"><?= $job_count ?>+</span>
                            <?php } else { ?>
                                <span class="count"><?= $job_count ?></span>
                            <?php } ?>
                            <span class="box-text">Jobs</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box2">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/company.png') ?>">
                            <?php if ($org_count) { ?>
                                <span class="count"><?= $org_count ?>+</span>
                            <?php } else { ?>
                                <span class="count"><?= $org_count ?></span>
                            <?php } ?>
                            <span class="box-text">Companies</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box3">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/internship.png') ?>">
                            <?php if ($internship_count) { ?>
                                <span class="count"><?= $internship_count ?>+</span>
                            <?php } else { ?>
                                <span class="count"><?= $internship_count ?></span>
                            <?php } ?>
                            <span class="box-text">Internships</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box4">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/institute.png') ?>">
                            <?php if ($institute_count) { ?>
                                <span class="count"><?= $institute_count ?>+</span>
                            <?php } else { ?>
                                <span class="count"><?= $institute_count ?></span>
                            <?php } ?>
                            <span class="box-text">Institutes</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box5">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/school.png') ?>">
                            <?php if ($school_count) { ?>
                                <span class="count"><?= $school_count ?>+</span>
                            <?php } else { ?>
                                <span class="count"><?= $school_count ?></span>
                            <?php } ?>
                            <span class="box-text">Schools</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box6">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/college1.png') ?>">
                            <?php if ($college_count) { ?>
                                <span class="count"><?= $college_count ?>+</span>
                            <?php } else { ?>
                                <span class="count"><?= $college_count ?></span>
                            <?php } ?>
                            <span class="box-text">Colleges</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container job-cards">
            <div class="row">
                <div class=" col-md-12">
                    <div class="heading-style">Related Jobs</div>
                </div>
            </div>
            <?php echo $this->render('/widgets/mustache/cities/application-cards', [
                'type' => 'jobs',
                'city' => $city['city']
            ]); ?>
        </div>
    </section>

    <section>
        <div class="container internship-cards">
            <div class="row">
                <div class=" col-md-12">
                    <div class="heading-style">Related Internships</div>
                </div>
            </div>
            <?php echo $this->render('/widgets/mustache/cities/application-cards', [
                'type' => 'internships',
                'city' => $city['city']
            ]); ?>
        </div>
    </section>

    <!--    <section>-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="heading-style">Institutes</div>-->
    <!--                </div>-->
    <!--                <div class="padd-top-20">-->
    <!--                    <div id="companies-card"></div>-->
    <!--                </div>-->
    <!---->
    <!--                --><?php //foreach ($institutes as $i) { ?>
    <!--                    <div class="col-md-4 col-sm-6 col-xs-12">-->
    <!--                        <div class="com-box">-->
    <!--                            <a href="">-->
    <!--                                <div class="com-icon">-->
    <!--                                    <div class="icon"><img-->
    <!--                                                src="--><? //= $i['image'] ?><!--">-->
    <!--                                    </div>-->
    <!--                                    <div class="follow">-->
    <!--                                        <button><i class="fa fa-heart-o"></i></button>-->
    <!--                                    </div>-->
    <!--                                    <!--                                <div class="featured">Featured</div>-->-->
    <!--                                </div>-->
    <!--                                <div class="com-det">-->
    <!--                                    <div class="com-name">--><? //= $i['name']?><!--</div>-->
    <!--                                    <div class="com-cate"><img-->
    <!--                                                src="--><? //= Url::to('@eyAssets/images/pages/training-detail-page/l.png') ?><!--">-->
    <!--                                        <span class="a">Ludhiana</span>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </a>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                --><?php //} ?>
    <!---->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->

<?php if (!empty($college)) { ?>
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Colleges</h1>
            <div class="row">
                <?php foreach ($college as $c) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="com-review-box uncliamed_height fivestar-box">
                            <div class="com-logo">
                                <?php if ($c['image']) { ?>
                                    <a href="#">
                                        <img src="<?= $c['image'] ?>">
                                    </a>
                                <?php } else { ?>
                                    <a href="#">
                                        <canvas class="user-icon" name="<?= $c['name'] ?>" width="100" height="100"
                                                color="<?= $c['initials_color'] ?>" font="35px">
                                        </canvas>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="pos-rel">
                                <div class="com-name"><a href="#"><?= $c['name'] ?></a></div>
                            </div>
                            <?php if ($c['organizationReviews'] != null) { ?>
                                <div class="com-loc"></div>
                                <div class="com-dep"></div>
                                <div class="com-rating">
                                    <div class="starr"
                                         data-score="<?= $c['organizationReviews'][0]['average_rating'] ?>"></div>
                                </div>

                                <div class="rating">
                                    <div class="stars"><?= $c['organizationReviews'][0]['average_rating'] ?></div>
                                    <div class="reviews-rate">
                                        of <?= $c['organizationReviews'][0]['reviews_count'] ?> reviews
                                    </div>
                                </div>
                                <div class="com-rating">
                                    <div class="average-star" data-score="2"></div>
                                </div>
                            <?php } else { ?>
                                <div class="rating">
                                    <div class="reviews-rate no-review"> Currently No Review</div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="cm-btns padd-0">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="color-blue">
                                            <a href="<?= Url::to('/' . $c['slug']) ?>">View Profile</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="color-orange">
                                            <a href="<?= Url::to('/' . $c['slug'] . '/reviews') ?>">Read Reviews</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (!empty($school)) { ?>
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Schools</h1>
            <div class="row">
                <?php foreach ($school as $s) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="com-review-box uncliamed_height fivestar-box">
                            <div class="com-logo">
                                <?php if ($s['image']) { ?>
                                    <a href="#">
                                        <img src="<?= $s['image'] ?>">
                                    </a>
                                <?php } else { ?>
                                    <a href="#">
                                        <canvas class="user-icon" name="<?= $s['name'] ?>" width="100" height="100"
                                                color="<?= $s['initials_color'] ?>" font="35px">
                                        </canvas>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="pos-rel">
                                <div class="com-name"><a href="#"><?= $s['name'] ?></a></div>
                            </div>
                            <?php if ($s['organizationReviews'] != null) { ?>
                                <div class="com-loc"></div>
                                <div class="com-dep"></div>
                                <div class="com-rating">
                                    <div class="average-star"
                                         data-score="<?= $s['organizationReviews'][0]['average_rating'] ?>"></div>
                                </div>

                                <div class="rating">
                                    <div class="stars"><?= $s['organizationReviews'][0]['average_rating'] ?>
                                    </div>
                                    <div class="reviews-rate">
                                        of <?= $s['organizationReviews'][0]['reviews_count'] ?> reviews
                                    </div>
                                </div>
                                <div class="com-rating">
                                    <div class="average-star" data-score="2"></div>
                                </div>
                            <? } else { ?>
                                <div class="rating">
                                    <div class="reviews-rate no-review"> Currently No Review</div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="cm-btns padd-0">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="color-blue">
                                            <a href="<?= Url::to('/' . $s['slug']) ?>">View Profile</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="color-orange">
                                            <a href="<?= Url::to('/' . $s['slug'] . '/reviews') ?>">Read Reviews</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (!empty($institutes)) { ?>
    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Educational Institutes</h1>
            <div class="row">
                <?php foreach ($institutes as $i) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="com-review-box uncliamed_height fivestar-box">
                            <div class="com-logo">
                                <?php if ($i['image']) { ?>
                                    <a href="#">
                                        <img src="<?= $i['image'] ?>">
                                    </a>
                                <?php } else { ?>
                                    <a href="#">
                                        <canvas class="user-icon" name="<?= $i['name'] ?>" width="100" height="100"
                                                color="<?= $i['initials_color'] ?>" font="35px">
                                        </canvas>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="pos-rel">
                                <div class="com-name"><a href="#"><?= $i['name'] ?></a></div>
                            </div>
                            <?php if ($i['organizationReviews'] != null) { ?>
                                <div class="com-loc"></div>
                                <div class="com-dep"></div>
                                <div class="com-rating">
                                    <div class="starr"
                                         data-score="<?= $i['organizationReviews'][0]['average_rating'] ?>"></div>
                                </div>
                                <div class="rating">
                                    <div class="stars"><?= $i['organizationReviews'][0]['average_rating'] ?></div>
                                    <div class="reviews-rate">
                                        of <?= $i['organizationReviews'][0]['reviews_count'] ?> reviews
                                    </div>
                                </div>
                                <div class="com-rating">
                                    <div class="average-star" data-score="2"></div>
                                </div>
                            <?php } else { ?>
                                <div class="rating">
                                    <div class="reviews-rate no-review"> Currently No Review</div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="cm-btns padd-0">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="color-blue">
                                            <a href="<?= Url::to('/' . $i['slug']) ?>">View Profile</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="color-orange">
                                            <a href="<?= Url::to('/' . $i['slug'] . '/reviews') ?>">Read Reviews</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php
$c_user = Yii::$app->user->identity->user_enc_id;
$this->registerCss('
.no-review{height:55px;line-height:50px;}
.backgrounds{
//    background-size: 100% 520px;
    background-image: url("' . Url::to("@eyAssets/images/pages/cities/instituteheader1.png") . '");
//    background-position: right top;
    background-repeat: no-repeat;
    min-height: 410px;
    padding-top: 150px;
    background-size: cover;
    background-position: 48%;
}
.main-heading{
    position:relative;
    height:218px;
    text-align:left;
}
.pos-center{
    position:absolute;
    top:213px;
    transform:translateY(-50%);
    max-width: 650px;
    width: 100%;
    z-index: 9;
}
.main-text{
     font-size:30px;
     color:#fff;
     font-family:lora;  
}
.box1{ background-image: url("/assets/themes/ey/images/pages/cities/1job.png");}
.box2{ background-image: url("/assets/themes/ey/images/pages/cities/1company.png");}
.box3{ background-image: url("/assets/themes/ey/images/pages/cities/1internship.png");}
.box4{ background-image: url("/assets/themes/ey/images/pages/cities/1institute.png");}
.box5{ background-image: url("/assets/themes/ey/images/pages/cities/1school.png");}
.box6{ background-image: url("/assets/themes/ey/images/pages/cities/college.png");}
.col-set {
    width: 85%;
    float: none;
    margin: auto;
}
.box-des {
    background-size: 100% 100%;
    background-repeat: no-repeat;
    position: relative;
    height: 172px;
    margin-top:30px;
}
.box-des img{
    position: absolute;
    max-width: 75px;
    right: 25px;
    top: 15px;
}
.box-text {
    position: absolute;
    bottom: 3px;
    left: 16px;
    color: white;
    font-size: 21px;
    font-family: roboto;
}
.count {
    position: absolute;
    bottom: 28px;
    left: 16px;
    color: white;
    font-size: 19px;
    font-family: roboto;
}
.parent{margin:10px 0;}
.logo{
	text-align: center;
	margin: 0 auto;
	margin-top: 25px;
}
.logo img{
	max-height: 75px;
}
.stat{
	text-align: center;
	margin-top: 15px;
	color: white;
	font-weight: bold;
	font-size: 17px;
}
.text{
	text-align: center;
	color: white;
	font-weight: bold;
	font-size: 17px;
}
.com-box{
    border:1px solid #eee;
    border-radius:5px;
    margin-bottom:20px;
}
.com-icon{
   position:relative;
   height:200px
}
.icon{
    position:absolute;
    max-height:150px;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
.icon img{
    width:150px;
    max-height:125px;
    object-fit:contain;
}
.follow{
    position:absolute;
    bottom:5px;
    right:10px;    
}
.follow button{
    margin-top:5px;  
    background:transparent;
    border:none;
    color:#ddd;
}
.follow button i{
    font-size:20px;
}
.follow button:hover{
    color:#00a0e3;    
}
.com-det{
    border-top:1px solid #eee;
    padding:10px 15px 10px;
    position:relative;
}
.com-name{
    font-size:20px;
    color:#525252;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   text-transform: capitalize;
}
.featured{
    background:#00a0e3;
    padding:5px 15px;
    position:absolute;
    top:15px;
    left:0;
    border-radius:0 5px 5px 0;
    color:#fff;
}
.com-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.1);
    transition:.2s ease-in;
}
.com-box:hover .com-name{
    color:#00a0e3;
    transition:.2s ease-in;
}
.inst-name{
    font-size:16px;
    font-weight:bold;
}
.inst-member{
    padding:5px 10px 10px 10px;
    text-align:center;
}
.inst-icon{
    width:100%;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.inst-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.inst-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:100%;
    position:relative;
    margin: 0 0 20px 0;
}
.review-benifit{
    position: relative;
    padding-bottom: 50px;
    z-index: -1;
}
.cm-btns {
    margin-top:10px;
}  
.color-blue a:hover{
    color:#00a0e3;
}  
.color-orange a:hover{
    color:#ff7803;
}
.com-review-box{
    text-align:center;
     border:1px solid #e5e5e5;
    padding:20px 0 3px 0;
    margin-bottom:20px;
    border-radius:10px; 
    color:#999;
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    border-radius:10px;
     border:1px solid #e5e5e5;
    position:relative;
}
.com-logo img{
    max-width:85px;
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}
.com-name{
    padding-top: 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
}
.uname .md-radio label{
    white-space: normal;
    font-size: 12px;
}
.has-success .md-radio label
{
color: initial;
}
.rating-stars{
    font-size:20px;
}
.rating{
    display:flex;
    justify-content:center;
    font-size:14px;
    min-height:25px;
}
.stars{
    margin-right:5px;
    color:#00a0e3;
    font-weight:bold;
    font-size:16px;
    margin-top:-2px;
}
.rating-stars i{
    color:#eee;
}
.read-bttn{
    padding-top:15px;
}
.read-bttn a{
    padding:5px 10px;
    background:#999;
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover, .fourstar-box:hover, .threestar-box:hover, twostar-box:hover, onestar-box:hover{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
}
.fivestar-box:hover .com-name {
    color:#fd7100;
}
.fivestar-box .read-bttn a{
    background:#fd7100;
}
.fivestar-box .rating-stars i, .fivestar-box .com-loc i, .fivestar-box .com-dep i,
.fivestar-box .stars{
   color:#fd7100;
}
.fourstar-box{
    border-bottom:2px solid #fa8f01;
}
.fourstar-box .read-bttn a{
    background:#fa8f01;
}
.fourstar-box .rating-stars i.active, .fourstar-box .com-loc i, .fourstar-box .com-dep i,
 .fourstar-box .stars{
   color:#fa8f01;
}
.threestar-box{
    border-bottom:2px solid #fcac01;
}
.threestar-box .read-bttn a{
    background:#fcac01;
}
.threestar-box .rating-stars i.active, .threestar-box .com-loc i, .threestar-box .com-dep i,
 .threestar-box .stars{
   color:#fcac01;
}
.twostar-box{
    border-bottom:2px solid #fabf37;
}
.twostar-box .read-bttn a{
    background:#fabf37;
}
.twostar-box .rating-stars i.active, .twostar-box .com-loc i, .twostar-box .com-dep i,
 .twostar-box .stars{
   color:#fabf37;
}
.onestar-box{
    border-bottom:2px solid #ffd478;
}
.onestar-box .read-bttn a{
    background:#ffd478;
}
.onestar-box .rating-stars i.active, .onestar-box .com-loc i, .onestar-box .com-dep i,
 .onestar-box .stars{
   color:#ffd478;
}
   
');
$script = <<<JS

    function renderCards(cards){
            var card = $('#application-card').html();
            var cardsLength = cards.length;
           
            for(var i=0; i<cards.length; i++){
                if(cards[i].skill != null){
                    cards[i].skill = cards[i].skill.split(',')
                } else {
                    cards[i].skill = [];
                }
            }
            var noRows = Math.ceil(cardsLength / 3);
            var j = 0;
            for(var i = 1; i <= noRows; i++){
                $(container).append('<div class="row">' + Mustache.render(card, cards.slice(j, j+3)) + '</div>');
                j+=3;
            }
            checkSkills();
    }
    
    function getCards(city,type) {
        $.ajax({
            method: "POST",
            url : 'index',
            data: {city:city,type:type},
            async:false,
            success: function(response) {
                response = JSON.parse(response);
                if(response.status === 200) {
                    renderCards(response.cards);
                    utilities.initials();
                }
            }
        })
    }
        
        function checkSkills(){
            $('.application-card-main').each(function(){
               var elems = $(this).find('.after');
               var i = 0;
               $(elems).each(function() {
                    if($(this).width() > 100 && $(this).text() != 'Multiple Skills' || i >= 2){
                        $(this).addClass('hidden');
                    }
                    i++;
               });
               var skillsMain = $(this).find('.tags');
               var hddn = $(this).find('.after.hidden');
               var hasMore = $(this).find('span.more-skills');
               if(hddn.length != 0){
                   if(elems.length === hddn.length){
                       $(elems[0]).removeClass('hidden');
                       var countMore = hddn.length - 1;
                       if(countMore != 0 && hasMore.length == 0){
                           skillsMain.append('<span class="more-skills">+ ' + countMore + '</span>');
                       }
                   } else if(hasMore.length == 0) {
                        skillsMain.append('<span class="more-skills">+ ' + hddn.length + '</span>');
                   }
               }
            });
        }
    
    
    $(document).on('click','.application-card-add', function(event){
            event.preventDefault();
            var c_user = "$c_user"
            if(c_user == ""){
                $('#loginModal').modal('show');
                return false;
            }
            var itemid = $(this).closest('.application-card-main').attr('data-id');
            $.ajax({
                url: "/jobs/item-id",
                method: "POST",
                data: {'itemid': itemid},
                success: function (response) {
                    if (response.status == '200' || response.status == 'short') {
                        toastr.success('Added to your Review list', 'Success');
                    } else if (response.status == 'unshort') {
                        toastr.success('Delete from your Review list', 'Success');
                    } else {
                        toastr.error('Please try again Later', 'Error');
                    }
                }
            });
        });
$.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
$('.starr').raty({
  readOnly: true,
  hints:['','','','',''],
 score: function() {
   return $(this).attr('data-score');
 }
});
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);