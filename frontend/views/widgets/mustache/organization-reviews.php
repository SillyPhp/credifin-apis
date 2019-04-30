<?php
use yii\helpers\Url;
$link = Url::to($org_slug.'/reviews', true);
?>
<script id="organization-reviews" type="text/template">
    {{#.}}
    <div class="row">
        <div class="re-box refirst">
            <div class="col-md-2 col-sm-2">
                {{#show_user_details}}
                <div class="uicon">
                    {{#image}}
                    <img src="{{image}}">
                    {{/image}}
                    {{^image}}
                    <canvas class="user-icon" name="{{first_name}} {{last_name}}" color="{{initials_color}}" width="80" height="80" font="35px"></canvas>
                    {{/image}}
                </div>
                <div class="uname">{{first_name}} {{last_name}}</div>
                {{/show_user_details}}
                {{^show_user_details}}
                <div class="uicon">
                    <img src="/assets/common/images/user1.png" width="50" height="50">
                </div>
                <div class="uname">Anonymous</div>
                {{/show_user_details}}
            </div>
            <div class="col-md-10 col-sm-10 user-review-main">
                <div class="col-md-6 col-sm-6">
                    <div class="com-rating">
                        <div class="average-star" data-score="{{average}}"></div>
                        <div class="num-rate">{{average}}/5.00</div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
<!--                    <div class="re-bttn">-->
<!--                        <button type="button" data-toggle="modal" data-target="#report">-->
<!--                            <i class="fa fa-flag"></i> Report-->
<!--                        </button>-->
<!--                    </div>-->
                    <div class="publish-date">{{created_on}}</div>
                    {{#is_current_employee}}
                    <div class="emp-duration">Current Employee</div>
                    {{/is_current_employee}}
                    {{^is_current_employee}}
                    <div class="emp-duration">Formal employee</div>
                    {{/is_current_employee}}
                </div>
                <div class="col-md-12">
                    <div class="utitle">
                        {{designation}} in {{profile}}
                    </div>
                </div>
                <div class=" col-md-12 user-saying">
                    <div class="uheading">Likes</div>
                    <div class="utext">
                        {{likes}}
                    </div>
                    <div class="uheading padd-10">Dislikes</div>
                    <div class="utext">
                        {{dislikes}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 user-rating">
                        <div class="ur-bg padd-lr-5">
                            <div class="urating">{{overall_experience}}/5</div>
                            <div class="uratingtitle">Overall Experience</div>
                        </div>
                        <div class="ur-bg padd-lr-5 light-bg">
                            <div class="urating">{{job_security}}/5</div>
                            <div class="uratingtitle">Job Security</div>
                        </div>
                        <div class="ur-bg ">
                            <div class="urating">{{growth}}/5</div>
                            <div class="uratingtitle">Career Growth</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{organization_culture}}/5</div>
                            <div class="uratingtitle">Company Culture</div>
                        </div>
                        <div class="ur-bg ">
                            <div class="urating">{{compensation}}/5</div>
                            <div class="uratingtitle">Salary & Benefits</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{work}}/5</div>
                            <div class="uratingtitle">Work Satisfaction</div>
                        </div>
                        <div class="ur-bg ">
                            <div class="urating">{{work_life}}/5</div>
                            <div class="uratingtitle">Work-Life Balance</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{skill_development}}/5</div>
                            <div class="uratingtitle">Skill Development</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="ushare">
                        <div class="ushare-heading">Share</div>
                        <i class="fa fa-facebook-square" onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u='.$link.''); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fa fa-twitter-square" onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fa fa-linkedin-square" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fa fa-whatsapp wa_icon_hover" onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
<!--                    <div class="usefull-bttn pull-right">-->
<!--                        <div class="use-bttn">-->
<!--                            <button type="button"><i class="fa fa-thumbs-up"></i> Usefull-->
<!--                            </button>-->
<!--                        </div>-->
<!--                        <div class="notuse-bttn">-->
<!--                            <button type="button"><i class="fa fa-thumbs-down"></i> Not Usefull-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss("
.heading_style_1{
    font-size:18px;
}
.refirst{
   margin:0 0 0 0 !important; 
}
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
    padding-top:20px;
}
.user-saying{
    padding-top:20px;
}
.uname{
    text-align:center;
    text-transform:uppercase;
    font-weight:bold;
    padding-top:10px;
    line-height:15px;
    color:#00a0e3;
}
.publish-date{
    text-align:right;
    font-size: 14px;
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
.viewbtn{
    text-align:center;
    margin:60px 0 0 0 ;
}
.uicon{
    text-align:center;
}
.uicon img, .uicon canvas{
    max-height:80px;
    max-width:80px;
}
.uheading{
    font-weight:bold;
    
}
.utext{
    text-align:justify;
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
@media screen and (max-width: 768px){
    .user-rating{
        display: block !important;
        justify-content: normal !important;
    }
    .ur-bg{
        display: inline-block;
        margin-bottom: 5px;
    }
    .refirst {
        border-bottom: 2px solid #ccc;
        margin-bottom: 20px !important;
    }
    .user-review-main {
        border-left: 0px;
    }
}
");

$script = <<<JS
$(document).on('click','.follow',function(e){
    e.preventDefault();
    var org_id = $(this).val();
    $.ajax({
        url:'/organizations/follow',
        data: {org_id:org_id},                         
        method: 'post',
        beforeSend:function(){
         $('.follow').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        },
        success:function(data){  
            if(data.message == 'Following'){
                $('.follow').html('<i class="fa fa-heart-o hvr-icon"></i> Following');
                $('.follow').addClass('followed');
            }
            else if(data.message == 'Unfollow'){
                $('.follow').html('<i class="fa fa-heart-o hvr-icon"></i> Follow');
                $('.follow').removeClass('followed');
            }
        }
    });        
});

function getReviews() {
    var slug = window.location.pathname.split('/')[1];
    $.ajax({
        method: "POST",
        url : '/organizations/get-reviews?slug=' + slug,
        success: function(response) {
            if(response.status === 200) {
                var reviews_data = $('#organization-reviews').html();
                $("#org-reviews").html(Mustache.render(reviews_data, response.reviews));
                utilities.initials();
                $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true,
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
            } else if(response.status === 201){
                $("#org-reviews").html('<div class = "heading_style_1">Currenlty No Review Has Been Given To This Company</div>');
                $('.viewbtn').hide();
            }
        }
    });
}

getReviews();
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
