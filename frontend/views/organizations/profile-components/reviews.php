<?php
//if(!$isAjax) {
//    echo $this->render("profile-header");
//}
?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb15 r_type_btns">

            </div>
        </div>
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

<?php
echo $this->render('/widgets/mustache/college-review-card');
echo $this->render('/widgets/mustache/organization-unclaimed-college-reviews');
$user_id = '';
if(!Yii::$app->user->isGuest){
    $user_id = Yii::$app->user->identity->user_enc_id;
}
$this->registerCSS('
.display-flex{
    display: flex;
    align-items: center;
    justify-content: space-between
}
.mb15{
    margin-bottom: 15px;
}
.mr15{
    margin-right: 5px;
}
.reviewType{
    background: transparent;
    padding: 10px 15px;
    border: 1px solid #00a0e3;
    color: #00a0e3;
    border-radius: 10px;
    font-size: 14px;
}
.reviewType.reviewActive{
    background: #00a0e3;
    color: #fff;
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

reviewObj = {
    org_id: '',
    fetchReviews(org_id, type='employee'){
        getReviews(org_id, type)
        getUserReviews(org_id, '', '', type)
    },
    get getOrgId(){
        return this.org_id;
    },    
    set setOrgId(org_id){
        this.org_id = org_id;
        this.fetchReviews(org_id);
    } 
}
if(collegeStats != null){
    reviewObj.fetchReviews(collegeStats.organization_enc_id);
}

function getReviews(org_id=null, type=null){
    $.ajax({
        url: baseUrl+"/api/v3/ey-college-profile/reviews",
        method: 'POST',
        data: {org_enc_id:org_id},
        success: function (res){
            if(res.response.status == 200){
                let reviewSideStats = '';
                if(type == 'employee'){
                    reviewSideStats = reviewStats(res.response.data.overall_rating);
                }else{
                    reviewSideStats = studentReviewStats(res.response.data.student_overall_rating);
                }
                if(reviewSideStats){
                    $('#reviewSum').empty();
                    $('#reviewSum').append(reviewSideStats);
                }
                let reviewType = document.querySelectorAll('.reviewType');
                if(reviewType.length == 0){
                    showBtns(res['response']['data']['org_detail']);
                }
            }
        }
    })
}

function showBtns(org_details){
    if(org_details.org_type == 'unclaimed'){
        var btns = `<button data-type="employee" class="reviewType mr15 reviewActive">Employee</button>
            <button data-type="student" class="reviewType">Student</button>`;
        $('.r_type_btns').append(btns);
    }
}

$(document).on('click', '.reviewType', function (){
    let reviewActive = document.querySelectorAll('.reviewActive');
    if(reviewActive.length > 0){
        reviewActive[0].classList.remove('reviewActive')
    }
    event.target.classList.add('reviewActive');
    let type = event.target.getAttribute('data-type');
    reviewObj.fetchReviews(collegeStats.organization_enc_id, type)
})

$('.showReviews').on('click', function (e){
   getUserReviews("", 3,"",e.target.getAttribute('data-id')); 
});
var count = 0;
var page = 1;
function getUserReviews(org_id=null, limit=3, page=null, type=null){
    var org_enc_id = org_id;
    $.ajax({
        url: baseUrl+'/api/v3/ey-college-profile/user-reviews',
        method: 'POST',
        data: {org_enc_id:org_enc_id, limit:limit, page:page, type:type, user_enc_id:user_id},
        success: function (res){
            if(res.response.status == 200){
                if(type == 'employee'){
                    var reviews_data = $('#organization-reviews').html();
                }else{
                    var reviews_data = $('#organization-student-reviews').html();
                }
                $("#org-reviews").html('')
                let dataRev = res.response.data.reviews
                for(var i = 0; i < dataRev.length; i++){
                    if(dataRev[i]['feedback_type'] == 1){
                        dataRev[i].feedback_type_in = true;
                    }else if(dataRev[i]['feedback_type'] == 0){
                        dataRev[i].feedback_type_not = true;
                    }
                }
                $("#org-reviews").append(Mustache.render(reviews_data, dataRev));
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
            }else if(res.response.status == 404){
                   $('#load_more_btn').hide(); 
                   $("#org-reviews").html("<p class='noReview'>No Review's To Display</p>");
            }
        }
    })
}

$(document).on('click','#load_more_btn',function(e){
    e.preventDefault();
    page = page + 1;
    getUserReviews(limit=3, page=page)
});
function reviewStats(overall_rating){
    const {average_count, Job_Security, Career_Growth, Company_Culture, Salary_And_Benefits, 
      Work_Satisfaction, Work_Life_Balance, Skill_Development} = overall_rating;
    
    let reviewStat = ` <div class="row">
        <div class="col-md-12 col-sm-4">
            <div class="rs-main">
                <div class="rating-large">`+showRatingNum(average_count)+`/5</div>
                <div class="com-rating-1">`+ showStars(average_count) +`</div>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Job Security</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Job_Security)+`</div>
                    <div class="fourstar-box com-rating-2">`+  showStars(Job_Security) +`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Career Growth</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Career_Growth)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Career_Growth)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Company Culture</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Company_Culture)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Company_Culture)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Salary & Benefits</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Salary_And_Benefits)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Salary_And_Benefits)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Work Satisfaction</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Work_Satisfaction)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Work_Satisfaction)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Work Life Balance</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Work_Life_Balance)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Work_Life_Balance)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Skill Development</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Skill_Development)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Skill_Development)+`</div>
                </div>
            </div>
        </div>
    </div>`;
    return reviewStat;
}
function studentReviewStats(student_overall_rating){
    const {Academics, Accomodation_Food, Culture_Diversity ,Faculty_Teaching_Quality, Infrastructure, 
    Placements_Internships, Social_Life_Extracurriculars, average_count} =  student_overall_rating   
    let reviewStat = ` <div class="row">
        <div class="col-md-12 col-sm-4">
            <div class="rs-main">
                <div class="rating-large">`+showRatingNum(average_count)+`/5</div>
                <div class="com-rating-1">`+ showStars(average_count) +`</div>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Academics</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Academics)+`</div>
                    <div class="fourstar-box com-rating-2">`+  showStars(Academics) +`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Accomodation Food</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Accomodation_Food)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Accomodation_Food)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Culture Diversity</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Culture_Diversity)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Culture_Diversity)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Faculty Teaching Quality</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Faculty_Teaching_Quality)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Faculty_Teaching_Quality)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Infrastructure</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Infrastructure)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Infrastructure)+`</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Placements Internships</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Placements_Internships)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Placements_Internships)+`</div>
                </div>
            </div>
        </div>
           <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Social Life Extracurriculars</div>
                <div class="summary-box">
                    <div class="sr-rating">`+showRatingNum(Social_Life_Extracurriculars)+`</div>
                    <div class="fourstar-box com-rating-2">`+ showStars(Social_Life_Extracurriculars)+`</div>
                </div>
            </div>
        </div>
    </div>`;
    return reviewStat;
}
function showRatingNum(count){
    return (count == null ? 0 : count)
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
  let newUsefulNum;
  if (id=='one'){
      if ($(this).hasClass('usefull_btn_color'))
          {
              return false;
          }
      let notusefull_btn_color = $(this).closest('.usefull-bttn').find('.notusefull_btn_color');
      if(notusefull_btn_color.length > 0){
          let useNum = parseInt(notusefull_btn_color.find('.notUsefulNum').html());
          newUsefulNum = useNum - 1;
          notusefull_btn_color.find('.notUsefulNum').html(newUsefulNum);
      }
      let useFulBtn = $(this).find('.usefulNum')
      let useFulNum = parseInt(useFulBtn.html());
      newUsefulNum =  useFulNum + 1;
      useFulBtn.html(newUsefulNum);
      $(this).addClass('usefull_btn_color');
      $(this).closest('.usefull-bttn').find('.notuse-bttn button').removeClass('notusefull_btn_color');
  }
  else if(id=='zero'){
      if ($(this).hasClass('notusefull_btn_color'))
        {
          return false;
        }
      let usefull_btn_color = $(this).closest('.usefull-bttn').find('.usefull_btn_color');
      if(usefull_btn_color.length > 0){  
         let useNum = parseInt(usefull_btn_color.find('.usefulNum').html());
         newUsefulNum = useNum - 1;
         usefull_btn_color.find('.usefulNum').html(newUsefulNum);
      }
        let notUseBtn = $(this).find('.notUsefulNum')
        let notUseNum = parseInt(notUseBtn.html())
        newUsefulNum = notUseNum + 1
        notUseBtn.html(newUsefulNum)
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
});

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script>

</script>
