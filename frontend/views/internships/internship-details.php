<?php
$this->title = Yii::t('frontend', 'Internship Details');
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section>
    <div class="img">
        <img class="home-img" src="<?= Url::to('@eyAssets/images/pages/home/check1.png'); ?>">
        <?php
        $user_type = Yii::$app->session->get('user_type');
        if (Yii::$app->user->isGuest) {
            ?>
            <a class="img-btn" href="/login">Log in to Apply</a>
        <?php } elseif ($user_type == 'Member') {
            ?>
            <a class="img-btn btn btn-dark" href="#" data-toggle="modal" data-target="#myModal"> Apply Now</a>
        <?php }
        ?>
    </div>
</section>
<div id="sticky-anchor"></div>
<div id="myHeader-anchor"></div>
<section>
        <div class="col-md-2">
           <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'internships',
        ]);
        ?>
        </div>
        <div class="col-md-10">
                <div class="col-md-8 mb-80 pb-5">
                    <div id="content">
                        <nav class="navbar" data-spy="affix" data-offset-top="400">
                        <ul class="nav navbar-nav nav-tabs pt-5 pb-5"  role="tablist">
                            <li><a href="#overview-a" value="Scroll To Div1" onclick="scroll_to_div('overview-a')" id="overview">Overview</a></li>
                            <li><a href="#prerequisites-a" value="Scroll To Div2" onclick="scroll_to_div('prerequisites-a')" id="prerequisites">Prerequisites</a></li>
                            <li><a href="#visa-a" value="Scroll To Div2" onclick="scroll_to_div('visa-a')" id="visa">Visa and Logistics</a></li>
                            <li><a href="#testimonials" value="Scroll To Div2" onclick="scroll_to_div('testimonials-a')" id="testimonials">Testimonials</a></li>
                        </ul> 
                        </nav>
                        <div class="icon-box mb-0 p-0">
                            <a href="#" class="icon icon-gray pull-left mb-0 mr-10">
                                <i class="pe-7s-users"></i>
                            </a>
                            <h3 class="icon-box-title pt-15 mt-0 mb-40">Finance Manager</h3>
                            <hr>
                            <p class="text-gray">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi id perspiciatis facilis nulla possimus quasi, amet qui. Ea rerum officia, aspernatur nulla neque nesciunt alias repudiandae doloremque, dolor, quam nostrum laudantium earum illum odio quasi excepturi mollitia corporis quas ipsa modi nihil, ad ex tempore.</p>
                            <p class="text-gray">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi id perspiciatis facilis nulla possimus quasi, amet qui. Ea rerum officia, aspernatur nulla.</p>
                        </div>
                        <div id="overview-a">
                            Overview
                            Sustainable development goal
                            Responsible Consumption And Production
                            By 2030, achieve the sustainable management and efficient use of natural resources

                            More Opportunities for Responsible Consumption And Production

                            Role description
                            You will deal with children by changing their mentality , improving their English , collecting a trash and reusing it to create a new creative product . learning them the meaning of recycling by your skills, Be one of creative national youth who will change a big issue. Also, you will work in Habiba organic farm in Sinai, red sea for 2 weeks. You will farm, up-cycle and create compost out of seaweed. Enjoy living the adventure of camping in huts at the beach. utility fees 100$
                            Main activities
                            Teach children English ( beginner )

                            Brainstorm with your fellow intern to come up with creative ideas to create new products from trash

                            Create recycled products that could later be sold in bazar, and students can gain a revenue from.

                            Work on organic Farm and Create fertilizers from seaweed in Nuweiba.

                            Come up with creative recycling or up-cycling idea to make the farm more edgy (Ex: Graffiti).

                            Deliver sessions about Recycling and how youth can be more creative.
                        </div>
                        <div id="prerequisites-a">
                            <h5 class="mt-30">PREREQUISITES:</h5>
                            <ul class="list theme-colored">
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                            </ul>
                        </div>
                        <div id="visa-a">
                            <h5 class="mt-30">VISA AND LOGISTICS:</h5>
                            <ul class="list theme-colored">
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                            </ul> 
                        </div>
                        <div id="testimonials-a">
                            <h5 class="mt-30">TESTIMONIALS</h5>
                            <ul class="list theme-colored">
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                                <li>Lorem ipsum dolor sit elit</li>
                            </ul>
                        </div>
                        <hr> 
                        <div class="col-md-5">
                            <div class="btn_effect mt-15" >
                                <a class="">Add to review</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="btn_effect mt-15" >
                                <a class="">Shortlist</a>
                            </div>
                        </div>
                        
                        <script type="text/javascript">
                            function scroll_to_div(div_id) {
                                $('html,body').animate({
                                    scrollTop: $("#" + div_id).offset().top
                                }, 'slow');
                            }
                        </script>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content p-30 pt-10">
                                <h3 class="text-center text-theme-colored mb-20">Apply Now</h3>
                                <form id="job_apply_form" name="job_apply_form" action="includes/job.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Message <small>*</small></label>
                                        <textarea id="form_message" name="form_message" class="form-control required" rows="5" placeholder="Your cover letter/message sent to the employer"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>C/V Upload</label>
                                        <input name="form_attachment" class="file" type="file" multiple data-show-upload="false" data-show-caption="true">
                                        <small>Maximum upload file size: 12 MB</small>
                                    </div>
                                    <div class="form-group">
                                        <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="" />
                                        <button type="submit" class="btn btn-block btn-dark btn-theme-colored btn-sm mt-20 pt-10 pb-10" data-loading-text="Please wait...">Apply Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pt-30 pr-0">
                    <div id="myHeader" class="border-1px header-1 mb-150 mt-10 pb-20" style="background-color: white">
                        <div class="icon-box mb-0 p-0">
                            <a href="#" class="icon icon-gray pull-left mb-0 mr-10">
                                <i class="pe-7s-users"></i>
                            </a>
                            <h3 class="icon-box-title pt-15 mt-0 mb-40">Finance Manager</h3>
                            <hr class="set_hr">
                        </div>
                        <h5 class="">Requirements:</h5>
                        <ul class="list theme-colored color-black">
                            <li>Lorem ipsum dolor sit elit</li>
                            <li>Lorem ipsum dolor sit amet</li>
                        </ul>
                        <hr class="set_hr">
                        <div class="row p-10 pb-5">
                            <div class="col-md-3 col-xs-6 color-black" align="center">
                                <i class="fa fa-calendar text-theme-colored mt-5 font-15"></i>
                                <h5 class="mt-0">Date Posted:</h5>
                                <p>Posted 10 days ago</p>
                            </div>
                            <div class="col-md-3 col-xs-6 color-black" align="center">
                                <i class="fa fa-map-marker text-theme-colored mt-5 font-15"></i>
                                <h5 class="mt-0">Location:</h5>
                                <p>Anywhere</p>
                            </div>
                            <div class="col-md-3 col-xs-6 color-black" align="center">
                                <i class="fa fa-user text-theme-colored mt-5 font-15"></i>
                                <h5 class="mt-0">Job Title:</h5>
                                <p>Finance Manager</p>
                            </div>
                            <?php
                            $user_type = Yii::$app->session->get('user_type');
                            if ($user_type == 'Member' || Yii::$app->user->isGuest) {
                                ?>
                                <div class="col-md-3 col-xs-6 color-black" align="center"> 
                                    <i class="fa fa-money text-theme-colored mt-5 font-15" align="center"></i>
                                    <h5 class="mt-0">Stipend:</h5>
                                    <p>₹1 - 1.5</p>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col-md-3 col-xs-6" align="center">
                                    <i class="fa fa-users text-theme-colored mt-5 font-15"></i>
                                    <h5 class="mt-0">Number of Students:</h5>
                                    <p>31</p>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-12">
                            <?php
                            $user_type = Yii::$app->session->get('user_type');
                            if (Yii::$app->user->isGuest) {
                                ?>
                                <hr class="set_hr">
                                <div class="btn_effect mt-30 mb-5" align="center">
                                    <a class="" href="/login">Apply Now</a>
                                </div>
                                <?php
                            } elseif ($user_type == 'Member') {
                                ?>
                                <hr class="set_hr">
                                <div class="btn_effect mt-30 mb-5" align="center">
                                    <a class=""data-toggle="modal" data-target="#myModal" href="#">Apply Now</a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="wrapper mt-20">
                            <h4>Share With Friends</h4>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank"><i class="fa fa-3x fa-facebook-square share_fb"></i></a>
                            <a href="" target="_blank"><i class="fa fa-3x fa-linkedin-square share_ld"></i></a>
                            <a href="https://twitter.com/home?status=" target="_blank"><i class="fa fa-3x fa-twitter-square share_tw"></i></a>
                            <a href="https://plus.google.com/share?url=" target="_blank"><i class="fa fa-3x fa-google-plus-square share_gp"></i></a>
                            <a href="" target="_blank"><i class="fa fa-3x fa-envelope-square share_em"></i></a>
                        </div>
                    </div>
               </div>
            <div id="footerown" class="col-md-12 mt-20">
                <h3 class="title"><b>View similar internships</b></h3>
            </div>
            <div class="col-md-4 pt-5 mb-10">
                <div class="product shadow iconbox-border iconbox-theme-colored" style="box-shadow: 0 1px 3px 0px #797979">
                    <span class="tag-sale color-o pl-10 pr-10 ">Paid
                    </span>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 pt-5" >
                            <a href="#" class="icon set_logo">
                                <img src="http://www.eygb.co/assets/img/favicon.png">
                            </a> 
                        </div>
                        <div class="col-md-8  col-xs-8 pt-20">
                            <h5 class="icon-box-title"> 
                                <strong>Finance Manager
                                </strong>
                            </h5>
                            <h6>
                                <i class="fa fa-map-marker">
                                </i> Amritsar
                            </h6>
                            <h6>
                                <i class="fa fa-clock-o">
                                </i> 2 Months
                            </h6>
                        </div>
                        <div class="btn-add-to-cart-wrapper">
                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                            </a>
                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                <i class="fa fa-plus">
                                </i>
                            </a>
                        </div>
                    </div>
                    <hr class="set_hr">
                    <h6 class="pull-left pl-10 custom_set2" align="center">
                        <strong>Last Date to Apply
                        </strong>
                        <br>
                        20 Feb, 2018
                    </h6>
                    <h4 class="pull-right pr-5 pt-10 custom_set" align="center">
                        <strong>DSB EduTech
                        </strong>
                    </h4>
                </div>
            </div>
            <div class="col-md-4 pt-5 mb-10">
                <div class="product shadow iconbox-border iconbox-theme-colored" style="box-shadow: 0 1px 3px 0px #797979">
                    <span class="tag-sale color-o pl-10 pr-10 ">Paid
                    </span>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 pt-5" >
                            <a href="#" class="icon set_logo">
                                <img src="http://www.eygb.co/assets/img/favicon.png">
                            </a> 
                        </div>
                        <div class="col-md-8  col-xs-8 pt-20">
                            <h5 class="icon-box-title"> 
                                <strong>Finance Manager
                                </strong>
                            </h5>
                            <h6>
                                <i class="fa fa-map-marker">
                                </i> Amritsar
                            </h6>
                            <h6>
                                <i class="fa fa-clock-o">
                                </i> 2 Months
                            </h6>
                        </div>
                        <div class="btn-add-to-cart-wrapper">
                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                            </a>
                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                <i class="fa fa-plus">
                                </i>
                            </a>
                        </div>
                    </div>
                    <hr class="set_hr">
                    <h6 class="pull-left pl-10 custom_set2" align="center">
                        <strong>Last Date to Apply
                        </strong>
                        <br>
                        20 Feb, 2018
                    </h6>
                    <h4 class="pull-right pr-5 pt-10 custom_set" align="center">
                        <strong>DSB EduTech
                        </strong>
                    </h4>
                </div>
            </div>
            <div class="col-md-4 pt-5 mb-10">
                <div class="product shadow iconbox-border iconbox-theme-colored" style="box-shadow: 0 1px 3px 0px #797979">
                    <span class="tag-sale color-o pl-10 pr-10 ">Paid
                    </span>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 pt-5" >
                            <a href="#" class="icon set_logo">
                                <img src="http://www.eygb.co/assets/img/favicon.png">
                            </a> 
                        </div>
                        <div class="col-md-8  col-xs-8 pt-20">
                            <h5 class="icon-box-title"> 
                                <strong>Finance Manager
                                </strong>
                            </h5>
                            <h6>
                                <i class="fa fa-map-marker">
                                </i> Amritsar
                            </h6>
                            <h6>
                                <i class="fa fa-clock-o">
                                </i> 2 Months
                            </h6>
                        </div>
                        <div class="btn-add-to-cart-wrapper">
                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                            </a>
                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                <i class="fa fa-plus">
                                </i>
                            </a>
                        </div>
                    </div>
                    <hr class="set_hr">
                    <h6 class="pull-left pl-10 custom_set2" align="center">
                        <strong>Last Date to Apply
                        </strong>
                        <br>
                        20 Feb, 2018
                    </h6>
                    <h4 class="pull-right pr-5 pt-10 custom_set" align="center">
                        <strong>DSB EduTech
                        </strong>
                    </h4>
                </div>
            </div>
        </div>
</section>
<script>
</script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>-->
<?php
$this->registerCss("
.img .img-btn {
    position: absolute;
    top: 80%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background-color: #16315b;
    color: white;
    font-size: 16px;
    padding: 12px 24px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
}  
a:hover {
    text-decoration: none;
}
.icon-box
{
    padding: 0px 0px !important;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979 !important;
}
.product{
    margin-bottom:0px !important;
    margin-top:0px !important;
}
.hr{
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.color-o{
    background:#FF4500 !important;
}
.header-1 {
    padding: 10px 10px;
    background: transparent;
    color: #f1f1f1;
}
.color-black{
    color: #3f3333 !important;
}
.wrapper {
    width:100%;
    clear:both !important;
    margin: 0;
    padding: 0;
    padding-top: 10px;
    align-items: center;
    justify-content: center;
}
.wrapper i {
    padding: 0px 8px;
    float: left;
    text-align: center;
    width: 20%;
    margin-bottom: 20px;
}
.wrapper h4{
    margin: 0px;
    padding: 0px;
    font-family:Georgia;
    margin-bottom: 10px;
    text-align: center;
}
.share_fb {
    color: #4867AA;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}
.share_fb:hover {
    margin-top: -10px;
    text-shadow: 0px 20px 15px rgba(0, 0, 0, 0.3);
    transform: translate(0, -8);
}
.share_tw {
    color: #1DA1F2;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}
.share_tw:hover {
    margin-top: -10px;
    text-shadow: 0px 20px 15px rgba(0, 0, 0, 0.3);
    transform: translate(0, -8);
}
.share_gp {
    color: #d34836;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}
.share_gp:hover {
    margin-top: -10px;
    text-shadow: 0px 20px 15px rgba(0, 0, 0, 0.3);
    transform: translate(0, -5);
}
.share_em {
    color: #ed2301;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}
.share_em:hover {
    margin-top: -10px;
    text-shadow: 0px 20px 15px rgba(0, 0, 0, 0.3);
    transform: translate(0, -8);
}
.share_ld {
    color: #0075B5;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}
.share_ld:hover {
    margin-top: -10px;
    text-shadow: 0px 20px 15px rgba(0, 0, 0, 0.3);
    transform: translate(0, -5);
}
.set_hr{
    margin: 5px !important;
}
.btn_effect{
    width: 140px;
    height: 42px;  
    clear: both;
    font-size: 13px;
    margin:auto;
    color: #FFF;
    text-align: center;
    background-color: #000;
    padding: 10px 10px;
    transition: all .5s ease;
    border-radius: 3px;
    cursor: pointer;
}
.btn_effect a {
    text-decoration: none;
    color: #FFF;
}
.is-active{
    box-shadow: -2px 20px 28px -10px #000;
    transform: translateY(10px);
}
.affix {
  top: 51px;
  background-color: #fff;
  border:1px solid #ddd;
  width: 52.666667%;
  z-index: 999 !important;
}
.affix + .icon-box {
   padding-top: 70px !important;
}
 #myHeader {
    border-radius: 0.5ex;
    float:left;
}
#myHeader.stick {
    position: fixed !important;
    top: 0;
    z-index: 10;
}
#footerown {
  z-index:99;
 }
 .home-img{
     width:100%;
     max-height:398px;
 }
 .side-menu{
     position: static;
     max-width: 170px;
 }
 .set_logo {
    display: table-cell;
    vertical-align: middle;
    height: 125px;
}
");

$script = <<<JS

        
        
function sticky_relocates() {
    var window_top = $(window).scrollTop();
    var footer_top = $("#footerown").offset().top;
    var div_top = $('#myHeader-anchor').offset().top;
    var div_height = $("#myHeader").height();
    
    var padding = 20;  // tweak here or get from margins etc
    
    if (window_top + div_height > footer_top - padding)
        $('#myHeader').css({top: (window_top + div_height - footer_top + padding) * -1})
    else if (window_top > div_top) {
        $('#myHeader').addClass('stick');
        $('#myHeader').css({top: 30})
    } else {
        $('#myHeader').removeClass('stick');
    }
}

$(function () {
    $(window).scroll(sticky_relocates);
    sticky_relocates();
});
        
        
        


function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var footer_top = $("#footer").offset().top;
    var div_top = $('#sticky-anchor').offset().top;
    var div_height = $("#sticky").height();
    
    var padding = 20;  // tweak here or get from margins etc
    
    if (window_top + div_height > footer_top - padding)
        $('#sticky').css({top: (window_top + div_height - footer_top + padding) * -1})
    else if (window_top > div_top) {
        $('#sticky').addClass('stick');
        $('#sticky').css({top: 0})
        $('#sticky').removeClass('settop');
    } else {
        $('#sticky').removeClass('stick');
        $('#sticky').addClass('settop');
    }
}

$(function () {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

        
        
        
$(".btn_effect").hover(function(){
  $(this).toggleClass("is-active");
});
        
$("#job_apply_form").validate({
    submitHandler: function (form) {
        var form_btn = $(form).find('button[type="submit"]');
        var form_result_div = '#form-result';
        $(form_result_div).remove();
        form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
        var form_btn_old_msg = form_btn.html();
        form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
        $(form).ajaxSubmit({
            dataType: 'json',
            success: function (data) {
                if (data.status == 'true') {
                    $(form).find('.form-control').val('');
                }
                form_btn.prop('disabled', false).html(form_btn_old_msg);
                $(form_result_div).html(data.message).fadeIn('slow');
                setTimeout(function () {
                    $(form_result_div).fadeOut('slow')
                }, 6000);
            }
        });
    }
});
        
        
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 400) {
        $(".overview").addClass("active");
    }
}); 
 
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);