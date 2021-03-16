<?php

?>
<section>
    <div class="container m0">
        <div class="row">
            <div class="col-md-8">
                <div class="set-sticky">
                    <h1 class="heading-style">Reviews </h1>
                    <div id="org-reviews"></div>
                    <div class="load-more-bttn">
                        <button type="button" id="load_more_btn">Load More</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="set-sticky">
                    <div class="review-summary">
                        <h1 class="heading-style">Overall Ratings</h1>
                        <div id="reviewSum"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
echo $this->render('/widgets/mustache/college-review-card');
$user_id = '';
if(!Yii::$app->user->isGuest){
    $user_id = Yii::$app->user->identity->user_enc_id;
}
$this->registerCSS('
.m0, section > .container, section > .container-fluid{
    padding-top: 0px !important;
}
.rev-image {
	text-align: center;
	margin: 40px;
}
.heading_style_1 {
	font-size: 18px;
	text-align: center;
	font-family: roboto;
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
.ushare i.fa-linkedin:hover{
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
    text-align: left;
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
.usefull_btn_color{
    color: #00a0e3 !important;
    border-color: #00a0e3 !important;
}
.notusefull_btn_color
{
    color: #d72a2a !important;;
    border-color: #d72a2a !important;;
}
.wa_icon_hover:hover {
    cursor: pointer;
    color: #56dc56 !important;
}
.rs-main{
    background: #00a0e3;
    max-width: 220px;
    padding: 10px 13px 15px 13px;
    text-align: center;
    color: #fff;
    border-radius: 6px;
}
.rating-large{
    font-size:56px;
}

.com-rating-1 i {
    font-size: 16px;
    background: #fff;
    color: #ccc;
    padding: 7px 5px;
    border-radius: 5px;
    margin: 0px 2px;
}
.com-rating-1 i.active {
    background: #fff;
    color: #7453c6;
}
.rs1{
    padding-top:20px;
    text-align:left;
}
.summary-box{ 
    display:flex;
    justify-content:left;
}
.sr-rating{
   background: #00a0e3;
    padding: 12px 15px;
    z-index: 0;
    color: #fff;
    font-size: 19px;
    border-radius:5px;    
}
.com-rating-2 {
    padding: 10px 23px 15px 42px;
    height: 46px;
    margin-top: 5px;
    border: 2px solid #00a0e3;
    border-radius: 5px;
    margin-left: -30px;
}
.review-summary .rs1 .summary-box .com-rating-2 {
    border-color: #7453c6;
}
.review-summary .rs-main, 
.review-summary .rs1 .summary-box .sr-rating {
    background: #7453c6;
}
.com-rating-2 i {
    font-size: 22px;
    color: #ccc;
}
.fourstar-box i.active {
    color: #fa8f01;
}
.load-more-bttn{
    text-align: center;
}
.filter-bttn button, .load-more-bttn button {
    background: #00a0e3;
    border: 1px solid #00a0e3;
    padding: 12px 25px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 40px;
    transition: .3s all;
    -webkit-transition: .3s all;
    -moz-transition: .3s all;
    -o-transition: .3s all;
}
.noReview{
    text-align: center !important;
    font-size: 20px;
    font-family: roboto;
    
}
@media screen and (max-width: 1200px){
    .rs-main{
        margin: auto;
    }
    .re-heading, .rs1, .review-summary {
        text-align: center;
    }
    .review-summary{
        padding-left: 0px;
    }
    .summary-box {
        justify-content: center;    
    }
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
');
$script = <<<JS
var user_id = '$user_id';
var baseUrl = '';

function getReviews(){
    var org_enc_id = $('#orgDetail').attr('data-id');
    $.ajax({
        url: baseUrl+"/api/v3/ey-college-profile/reviews",
        method: 'POST',
        data: {org_enc_id:org_enc_id},
        success: function (res){
            if(res.response.status == 200){
                let overall_rating = res.response.data.overall_rating;
                let reviewSideStats = reviewStats(overall_rating);
                $('#reviewSum').append(reviewSideStats);
            }
        }
        
    })
}
getReviews();
var count = 0;
var page = 1;
function getUserReviews(limit=3, page=null){
    var org_enc_id = $('#orgDetail').attr('data-id');
    $.ajax({
        url: baseUrl+'/api/v3/ey-college-profile/user-reviews',
        method: 'POST',
        data: {org_enc_id:org_enc_id, limit:limit, page:page},
        success: function (res){
            var reviews_data = $('#organization-reviews').html();
            $("#org-reviews").append(Mustache.render(reviews_data, res.response.data.reviews));
            $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
            $('.average-star').raty({
                readOnly: true,
                hints:['','','','',''],
                score: function() {
                    return $(this).attr('data-score');
                }
            });
            if(res.response.data.reviews.length+count == res.response.data.count){
                $('#load_more_btn').hide()  
            }
            if($("#org-reviews").children().length == 0){
                $('#load_more_btn').hide(); 
                $("#org-reviews").html("<p class='noReview'>No Review's To Display</p>");
            }
            count = count+limit;
        }
    })
}
getUserReviews();

$(document).on('click','#load_more_btn',function(e){
    e.preventDefault();
    page = page + 1;
    getUserReviews(limit=3, page=page)
});
function reviewStats(overall_rating){
    let reviewStat = ` <div class="row">
        <div class="col-md-12 col-sm-4">
            <div class="rs-main">
                <div class="rating-large">`+overall_rating['average_count']+`/5</div>
                <div class="com-rating-1">`+ showStars(overall_rating['average_count']) +`</div>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Job Security</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Job_Security']+`</div>
                    <div class="fourstar-box com-rating-2">`+  showStars(overall_rating['Job_Security']) +`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Career Growth</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Career_Growth']+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(overall_rating['Career_Growth'])+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Company Culture</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Company_Culture']+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(overall_rating['Company_Culture'])+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Salary & Benefits</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Salary_And_Benefits']+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(overall_rating['Salary_And_Benefits'])+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Work Satisfaction</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Work_Satisfaction']+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(overall_rating['Work_Satisfaction'])+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Work Life Balance</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Work_Life_Balance']+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(overall_rating['Work_Life_Balance'])+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Skill Development</div>
                <div class="summary-box">
                    <div class="sr-rating">`+overall_rating['Skill_Development']+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(overall_rating['Skill_Development'])+`</div>
                </div>
            </div>
        </div>
    </div>`;
    return reviewStat;
}
function showStars(count){
    let stars = '';
    for (var i = 1; i <= 5; i++) {
        stars += `<i class="fas fa-star `+ ((count < i) ? '' : 'active') +`"></i>`;
    }
    return stars;
}
$(document).on('click','.btn_usefull',function() {
  var id = $(this).attr('value');
  var r_id = $(this).attr('data-key');
  if (id=='one'){
      if ($(this).hasClass('usefull_btn_color'))
          {
              return false;
          }
      $(this).addClass('usefull_btn_color');
      $(this).closest('.usefull-bttn').find('.notuse-bttn button').removeClass('notusefull_btn_color');
  }
  else if(id=='zero'){
      if ($(this).hasClass('notusefull_btn_color'))
          {
              return false;
          }
      $(this).addClass('notusefull_btn_color');
      $(this).closest('.usefull-bttn').find('.use-bttn button').removeClass('usefull_btn_color');
  }
  $.ajax({
    url: baseUrl+'/api/v3/ey-college-profile/like-dislike',
    method: 'POST',
    data: {review_enc_id:r_id, user_enc_id: user_id, value: id}, 
    success: function (res){
         // if (res.response.status==200){
        // }
    },
  })
});
$(document).on('click','input[name="reporting_radio"]',function() {
  var r_id = $('#review_enc_id').val();
  var id = $(this).val();
    $.ajax({
        url:baseUrl+'/api/v3/ey-college-profile/report',
        data:{review_enc_id:r_id, value:id, user_enc_id: user_id},                         
        method: 'post',
        success:function(response){  
           if (response.response.status == 200)
               {
                   toastr.success(response.message, 'Review Reported');
               }
           else 
               {
                   toastr.error(response.message, 'Something went wrong');
               }
            $('#report').modal('toggle');
           $("#report_form").trigger("reset");
        }
    });
})
$(document).on('click','#report_btn',function() {
  $('#review_enc_id').val($(this).attr('data-key'));
})
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>