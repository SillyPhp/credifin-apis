<?php

use yii\helpers\Url;

$link = Url::to($org_slug . '/reviews', true);
?>
    <script id="organization-student-reviews" type="text/template">
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
                        <canvas class="user-icon" name="{{first_name}} {{last_name}}" color="{{initials_color}}"
                                width="80" height="80" font="35px"></canvas>
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
                            <div class="num-rate">{{average}}/5</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="publish-date">{{created_on}}</div>
                        <div class="emp-duration">{{reviewer_type}} Student</div>
                    </div>
                    <div class="col-md-12">
                        <div class="utitle">
                            {{stream}}
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
                                <div class="urating">{{academics}}/5</div>
                                <div class="uratingtitle">Academics</div>
                            </div>
                            <div class="ur-bg light-bg padding-none">
                                <div class="urating">{{faculty_teaching_quality}}/5</div>
                                <div class="uratingtitle">Faculty & Teaching Quality</div>
                            </div>
                            <div class="ur-bg">
                                <div class="urating">{{infrastructure}}/5</div>
                                <div class="uratingtitle">Infrastructure</div>
                            </div>
                            <div class="ur-bg light-bg">
                                <div class="urating">{{accomodation_food}}/5</div>
                                <div class="uratingtitle">Accomodation Food</div>
                            </div>
                            <div class="ur-bg">
                                <div class="urating">{{placements_internships}}/5</div>
                                <div class="uratingtitle">Placements /Internships</div>
                            </div>
                            <div class="ur-bg light-bg">
                                <div class="urating">{{social_life_extracurriculars}}/5</div>
                                <div class="uratingtitle">Social Life & Extracurriculars</div>
                            </div>
                            <div class="ur-bg">
                                <div class="urating">{{culture_diversity}}/5</div>
                                <div class="uratingtitle">Culture Diversity</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="ushare">
                            <div class="ushare-heading">Share</div>
                            <i class="fab fa-facebook-square"
                               onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link . ''); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                            <i class="fab fa-twitter-square"
                               onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                            <i class="fab fa-linkedin"
                               onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                            <i class="fab fa-whatsapp wa_icon_hover"
                               onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
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
.ur-bg{
   background:#edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    min-height: 95px;
}
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
    padding-top:20px;
}
.heading_style_1
{
font-size:18px;
}
@media only screen and (max-width: 767px){
    .ur-bg {
        background: #edecec;
        color: #000;
        padding: 10px 5px;
        height: 95px;
        width: 200px;
        float: left;
    }
    .user-rating {
        display: inherit;
        justify-content: center;
        text-align: center;
        padding-top: 20px;
    }
    
}
");

$script = <<<JS
var page_name=0;
var total=0;
function getStudentReviews(limit=null,offset=null) {
    var slug = window.location.pathname.split('/')[1];
    $.ajax({
        method: "POST",
        url : '/organizations/get-unclaimed-student-reviews?slug='+slug+'&limit='+limit+'&offset='+offset,
        beforeSend:function()
        {
            $('#load_more_btn').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        },
        success: function(response) {
            if(response.status === 200) {
                var reviews_data = $('#organization-student-reviews').html();
                $("#org-students-reviews").append(Mustache.render(reviews_data, response.reviews));
                utilities.initials();
                $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true,
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
                 if (response.reviews.length+total==response.total)
                   {
                       $('#load_more_btn1').hide();
                   }
            } else if(response.status === 201){
                $("#org-students-reviews").html('<div class = "heading_style_1">Currenlty No Review Has Been Given To This Company</div>');
                $('.viewbtn').hide();
                $('#load_more_btn1').hide();
            }
            $('#load_more_btn1').html('Load More');
        }
    });
}
$(document).on('click','#load_more_btn1',function(e) {
  e.preventDefault();
  page_name = page_name+3;
  total = total+3;
  getStudentReviews(limit=3,offset=page_name);
});
getStudentReviews(limit=3,offset=page_name);
JS;
$this->registerCss("
.padding-none
{
padding:0;
}
");
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
