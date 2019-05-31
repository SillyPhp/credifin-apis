<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<section class="rh-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="search-bar">
                        <input type="text" class="s-input" placeholder="Search Companies, Jobs, Internships, Blogs">
                        <button type="submit" class="s-btn">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="companies">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Companies</div>
            </div>

        </div>
        <div class="row companies-list">

        </div>
    </div>
</section>

<section id="schools">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Schools</div>
            </div>

        </div>
        <div class="row school-list">

        </div>
    </div>
</section>

<section id="colleges">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Colleges</div>
            </div>

        </div>
        <div class="row college-list">

        </div>
    </div>
</section>

<section id="institutes">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Educational Institute</div>
            </div>

        </div>
        <div class="row institute-list">

        </div>
    </div>
</section>

<section id="jobs">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Jobs</div>
            </div>

        </div>
        <div class="row jobs-list">

        </div>
    </div>
</section>

<section id="internships">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Internships</div>
            </div>
        </div>
        <div class="row internships-list">

        </div>
    </div>
</section>

<section id="posts">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Blogs</div>
            </div>

        </div>
        <div class="row blogs-list">

        </div>
    </div>
</section>

<section id="not-found" class="text-center">
    <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
</section>
<?php
$c_user = Yii::$app->user->identity->user_enc_id;
$this->registerCss('
.search-bar{
    width:66%;
    background:#fff;
    border-radius:50px;
    display:flex;
    padding:5px 5px;
    border:1px solid #eee;
    margin:auto;
    box-shadow: 0px 1px 12px 0px #f5f5f5ba;
}
.wp-box-icon a img {
    height: 220px;
    width: 100%;
}
.s-input{
    width:94%;
    padding:10px 15px;
    border:none;
    border-radius:10px;
    color:#777;
}
.s-input::placeholder{
    color:#bcbaba;
}
.s-input:focus{
    outline:none;
    border:none !important;
    box-shadow:none;
}
.s-btn{
    width: 115px;
    border: none;
    background: none;
    color: #fff;
    background-color: #2cb9f3;
    border-radius: 42px;
    line-height: 39px;
    height: 40px;
    text-align: center;
    font-size: 14px;
}
.rh-header{
    background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
    background-size:100% 300px;
    background-repeat: no-repeat;
    padding:100px 0 35px 0;
    color:#fff;
    margin-bottom:20px;
} 
.com-review-box{
    text-align:center;
    border:1px solid #eee;
    padding:20px 10px 3px 10px;
    margin-bottom:20px;
    border-radius:10px;
    color:#999;
}
.com-review-box:hover{
     box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    border-radius:10px;
    border:2px solid rgba(238,238,238,.5);
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
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform: capitalize;
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
    width:100%;
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.read-bttn .vp-bttn a{
     background:#00a0e3;
     border-radius: 0px 0px 0px 10px;
     padding: 5px 20px;
}
.read-bttn .rr-bttn a{
    background:#00a0e3;
     border-radius: 0px 0px 10px 0px;
     padding: 5px 20px;
}
.cm-btns{
    margin-top:10px;
    padding-top:5px;
    border-top:1px solid #eee;
    text-transform: capitalize;
}
.color-blue a{
    color:#bcbaba;
}
.color-blue a:hover{
    color:#00a0e3;
}
.color-orange a{
    color:#bcbaba;
}
.color-orange a:hover{
    color:#ff7803;
}
.padd-0{
    margin-left:15px !important;
    margin-right:15px !important;
}
.whats-new-box{
    border-radius:5px;
    margin-bottom:20px;
}
.what-popular-box:hover, .whats-new-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
    transition:.3s all;
}
.what-popular-box:hover .wp-box-icon img, .whats-new-box:hover .wn-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
    transition:.3s all;
}
.what-popular-box{
    margin-bottom:20px;
    border-radius:5px;
}
.what-popular-box:hover > .wp-box-icon > .middle, .whats-new-box:hover > .wn-box-icon > .middle{
    opacity:1 !important;
}
.what-popular-box:hover > .wp-box-icon > .middle > a > img, .whats-new-box:hover >.wn-box-icon > .middle > a > img{
    opacity:1 !important;
}
.wn-box-title{
    font-weight: bold;
}
.wn-box-details{
    border-top:none;
    padding: 5px 10px 10px 8px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius:0 0 5px 5px;
    position:relative;
    min-height: 125px;
}
.wn-box-cat{
   font-size:14px;
   color: #9e9e9e;
}
a.wn-overlay-text {
  background-color: #00a0e3;
  color: white;
  font-size: 12px;
  padding: 6px 12px;
  border-radius:5px;
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
.wp-box-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;   
}
.wp-btn{
    position:absolute;
    bottom:5px;
}
.wp-btn a{
    color:#00a0e3;
    font-size:14px;
}
.wp-box-des{
    padding-top:15px;
    font-size:13px;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}
.btn-3 {
    background-color: #00a0e3;
}
.btn-3 .round {
    background-color: #38b7ec;
}
.type-1{
    float:right;
    margin-top: 15px;
}
.type-1 div a {
    text-decoration: none;
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
    padding: 12px 53px 12px 23px;
    color: #fff;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: bold;
    position: relative;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    display: inline-block;
}
.type-1 div a span {
    position: relative;
    z-index: 3;
}
.type-1 div a .round {
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    position: absolute;
    right: 3px;
    top: 3px;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    z-index: 2;
}
.type-1 div a .round i {
    position: absolute;
    top: 50%;
    margin-top: -6px;
    left: 50%;
    margin-left: -4px;
    color: #fff;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
.txt {
    font-size: 14px;
    line-height: 1.45;
    color: #fff;
}
.type-1 a:hover {
    padding-left: 48px;
    padding-right: 28px;
}
.type-1 a:hover .round {
    width: calc(100% - 6px);
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
}
.type-1 a:hover .round i {
    left: 12%;
    color: #FFF;
}
.fivestars i{
    color:#fd7100 !important; 
}
.fourstars i.active{
    color:#fa8f01 !important; 
}
.threestars i.active{
    color:#fcac01 !important; 
}
.twostars i.active{
    color:#fabf37 !important; 
}
.onestars i.active{
    color:#ffd478 !important; 
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover{
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
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
#not-found{
    display:none;
}
');

$script = <<< JS

$('.s-input').val(decodeURIComponent((window.location.search.split('=')[1] + '').replace(/\+/g, '%20')));

$(document).on('click', '.s-btn', function(e){
    e.preventDefault();
    var query_string = window.location.search;
    var search_params = new URLSearchParams(query_string);
    var search_key = $('.s-input').val();
    if(search_key){
        if(search_key.trim()){
            search_params.set('keyword', search_key.trim());
            window.location.search = search_params.toString();
        }
    }
});
function fillData(){
    $.ajax({
        type: 'POST',
        async: false,
        url: window.location.pathname,
        data: {
            'keyword' : decodeURIComponent((window.location.search.split('=')[1] + '').replace(/\+/g, '%20'))
        },
        success: function(result){
            result = JSON.parse(result);
            if(result["jobs"].length ==0 && result["organizations"].length ==0 && result["internships"].length == 0 && result["posts"].length==0){
                $('#not-found').fadeIn(1000);
            }
                
            if(result["jobs"].length){
                var application_card = $('#application-card').html();
                var jobs_render = Mustache.render(application_card, result['jobs']);
                $('.jobs-list').html(jobs_render);
            }else{
               $('#jobs').remove(); 
            }
            
            if(result["organizations"].length){
                var company_card = $('#company-card').html();
                var company_render = Mustache.render(company_card, result['organizations']);
                $('.companies-list').html(company_render);
            }else{
               $('#companies').remove(); 
            }
            
            if(result["schools"].length){
                var schools_card = $('#un-card').html();
                var school_render = Mustache.render(schools_card, result['schools']);
                $('.school-list').html(school_render);
            }else{
               $('#schools').remove(); 
            }
            
            if(result["colleges"].length){
                var colleges_card = $('#un-card').html();
                var college_render = Mustache.render(colleges_card, result['colleges']);
                $('.college-list').html(college_render);
            }else{
               $('#colleges').remove(); 
            }
            
            if(result["institutes"].length){
                var institute_card = $('#un-card').html();
                var institute_render = Mustache.render(institute_card, result['institutes']);
                $('.institute-list').html(institute_render);
            }else{
               $('#institutes').remove(); 
            }
            
            if(result["internships"].length){
                var application_card = $('#application-card').html();
                var internships_render = Mustache.render(application_card, result['internships']);
                $('.internships-list').html(internships_render);
            }else{
               $('#internships').remove(); 
            }
            
            if(result["posts"].length){
                var blog_card = $('#blog-card').html();
                var blog_render = Mustache.render(blog_card, result['posts']);
                $('.blogs-list').html(blog_render);
            }else{
               $('#posts').remove(); 
            }
            
            utilities.initials();
        }
    })
}
fillData();

$.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
$('.starr').raty({
  readOnly: true,
  hints:['','','','',''],
 score: function() {
   return $(this).attr('data-score');
 }
});
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
        beforeSend:function(){
//            $('.loader-aj-main').fadeIn(1000);  
        },
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

JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main">
            {{#city}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;{{city}}
                </span>
            {{/city}}
            {{^city}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;All India
                </span>
            {{/city}}
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="{{organization_link}}">
                        {{#logo}}
                        <img src="{{logo}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{organization_name}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="{{link}}"><h4 class="application-title">{{title}}</h4></a>
                    {{#salary}}
                    <h5><i class="fa fa-inr"></i>&nbsp;{{salary}}</h5>
                    {{/salary}}
                    {{^salary}}
                    <h5>Negotiable</h5>
                    {{/salary}}
                    {{#type}}
                    <h5>{{type}}</h5>
                    {{/type}}
                    {{#experience}}
                    <h5><i class="fa fa-clock-o"></i>&nbsp;{{experience}}</h5>
                    {{/experience}}
                </div>
            </div>
            {{#last_date}}
            <h6 class="col-md-5 pl-20 custom_set2 text-center">
                Last Date to Apply
                <br>
                {{last_date}}
            </h6>
            <h4 class="col-md-7 org_name text-right pr-10">
                {{organization_name}}
            </h4>
            {{/last_date}}
            {{^last_date}}
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{organization_name}}</h4>
            </div>
            {{/last_date}}
            <div class="application-card-wrapper">
                <a href="{{link}}" class="application-card-open">View Detail</a>
                <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<script id="un-card" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <div class="com-review-box onestar-box">
            <div class="com-logo">
                {{#logo}}
                <a href="/{{slug}}"><img src="{{logo}}"></a>
                {{/logo}}
                {{^logo}}
                <canvas class="user-icon" name="{{name}}" width="100" height="100"
                        color="{{color}}" font="55px"></canvas>
                {{/logo}}
            </div>
            <a href="/{{slug}}"><div class="com-name">{{name}}</div></a>

            {{#employerApplications}}
            {{#applications_cnt}}
            <div class="com-loc"><span>{{applications_cnt}}</span> Openings</div>
            {{/applications_cnt}}
            {{/employerApplications}}
            {{^employerApplications}}
            <div class="com-loc"><span>No</span> Openings</div>
            {{/employerApplications}}

            {{#organizationReviews}}
            {{#average_rating}}
            <div class="starr" data-score="{{average_rating}}"></div>
            <div class="rating">
                <div class="stars">{{average_rating}}</div>
                <div class="reviews-rate"> of {{reviews_cnt}} reviews</div>
            </div>
            {{/average_rating}}
            {{/organizationReviews}}
            {{^organizationReviews}}
            <div class="starr" data-score="0"></div>
            <div class="rating">
                <div class="reviews-rate">No reviews</div>
            </div>
            {{/organizationReviews}}

            <div class="row">
                <div class="cm-btns padd-0">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="color-orange">
                            <a href="/{{slug}}/reviews">Read Reviews</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<script id="company-card" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <div class="com-review-box onestar-box">
            <div class="com-logo">
                {{#logo}}
                    <a href="/{{slug}}"><img src="{{logo}}"></a>
                {{/logo}}
                {{^logo}}
                    <canvas class="user-icon" name="{{name}}" width="100" height="100"
                        color="{{color}}" font="55px"></canvas>
                {{/logo}}
            </div>
            <a href="/{{slug}}"><div class="com-name">{{name}}</div></a>

            {{#employerApplications}}
                {{#applications_cnt}}
                <div class="com-loc"><span>{{applications_cnt}}</span> Openings</div>
                {{/applications_cnt}}
            {{/employerApplications}}
            {{^employerApplications}}
                <div class="com-loc"><span>No</span> Openings</div>
            {{/employerApplications}}

            {{#organizationReviews}}
                {{#average_rating}}
                    <div class="starr" data-score="{{average_rating}}"></div>
                    <div class="rating">
                        <div class="stars">{{average_rating}}</div>
                        <div class="reviews-rate"> of {{reviews_cnt}} reviews</div>
                    </div>
                {{/average_rating}}
            {{/organizationReviews}}
            {{^organizationReviews}}
                <div class="starr" data-score="0"></div>
                <div class="rating">
                    <div class="reviews-rate">No reviews</div>
                </div>
            {{/organizationReviews}}

            <div class="row">
                 <div class="cm-btns padd-0">
                        <div class="col-md-6">
                            <div class="color-blue">
                                 <a href="/{{slug}}">View Profile</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="color-orange">
                                <a href="/{{slug}}/reviews">Read Reviews</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<script id="blog-card" type="text/template">
    {{#.}}
    <div class="col-md-4">
        <div class="what-popular-box">
            <div class="wp-box-icon">
                <a href="{{link}}"><img src="{{image}}"></a>
            </div>
            <div class="wn-box-details">
                <a href="{{link}}">
                    <div class="wn-box-title">{{title}}</div>
                </a>
                <div class="wp-box-des">{{excerpt}}</div>
                <div class="wp-btn">
                    <a href="{{link}}" class="button">
                        <span>View Post</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>