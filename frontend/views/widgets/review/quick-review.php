<?php
use yii\helpers\Url;
?>
<section>
    <div class="container">
        <div class="quick-review">
            <div class="row quick-review-inner">
                <div class="col-md-3 quick-review-img"><img src="<?= Url::to('@eyAssets/images/pages/review/quick-review.png');?>"></div>
                <div class="col-md-7 overflow-hidden set-heading-c">
                    <h2>Help The Community</h2>
                    <div class="quick-review-t">find empoweryouth reviews Helpful?start helping others by sharing your
                        personal experience.
                    </div>
                    <div class="quick-review-action" id="review_btn">
                        <a href="javascript:;">Start Your First Review</a>
                    </div>
                    <div class="row">
                        <div class="r-btns">
                            <div class="btn1 _1">
                                <a href="javascript:;" class="show-ss" data-placeholder="Search Companies" data-key="Others,Recruiter,Business,Scholarship Fund,Banking & Finance Company">companies</a>
                            </div>
                            <div class="btn1 _2">
                                <a href="javascript:;" class="show-ss" data-placeholder="Search College,Universities" data-key="College">colleges</a>
                            </div>
                            <div class="btn1 _3">
                                <a href="javascript:;" class="show-ss" data-placeholder="Search Schools" data-key="School">schools</a>
                            </div>
                            <div class="btn1 _4">
                                <a href="javascript:;" class="show-ss" data-placeholder="Search educational institute" data-key="Educational Institute">educational institutes</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <div class="close-search">
        <i class="fas fa-times"></i>
    </div>

    <div class="search">
<!--        <button class="show-ss">showwww</button>-->
<!--        <input type="text" class="input-ss">-->
        <div class='search-box2'>
            <div class="load-suggestions Typeahead-spinner">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <form id="form-search-q" action="<?= Url::to(['search']) ?>">
                <input class='form-control input-ss' name="keywords" id="search_company-q"
                       name="search_company" placeholder='Search Companies' type='text'>
                <button class='btn btn-link search-btn'>
                    <i class='fas fa-search'></i>
                </button>
            </form>
        </div>
    </div>
<?php
echo $this->render('/widgets/review/quick-review-search-bar');
$this->registerCss('
.set-heading-c > h2{
    font-family: lora;
}
.overflow-hidden{
    overflow:hidden;
}
.quick-review{
	border:2px solid #eee;
	margin: 20px;
	background-color:  #fbfcfc ;
	border-radius: 5px;
}
.quick-review-inner{margin:15px;}
.quick-review-img img{
	max-width: 200px;
}
.quick-review-t{
	margin: 15px 0;
	font-size: 15px;
	font-family: roboto;
}
.quick-review-action {
	font-family: "Roboto", sans-serif;
	padding: 10px 0;
}
.quick-review-action a:hover, .quick-review-action a:focus, .quick-review-action:active{
	outline: none;
	box-shadow: none;
} 
.quick-review-action a, .btn1 a{  
	text-align:center;
	display:inline-block; 
    padding:5px 15px; 
    background:#00a0e3; 
    border-radius:4px; 
    font-size:15px; 
    font-weight:500; 
    color:#fff;
    text-decoration: none;
    text-transform: capitalize;
    font-family: roboto;
}
.btn1 {
	font-family: "Roboto", sans-serif;
	padding: 4px 0;
	display: inline-block;
	margin: 5px;
}
._1 a{background: #51bce9;}
._2 a{background: #9983d0e0;}
._3 a{background: #57a84bc4;}
._4 a{background: #e47f87d4;}
.r-btns{
    opacity:0;
    height:0px;
//    display: none;
//    transition: .3s ease-in-out;
}
.r-btns.actives{
    opacity:1;
    height:55px;
    -webkit-animation-name: s_button; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 1s; /* Safari 4.0 - 8.0 */
    animation-name: s_button;
    animation-duration: 1s;
//    display: block;
}
@-webkit-keyframes s_button {
  from {margin-left: -1000px;}
  to {margin-left: 0px;}
}
@keyframes s_button {
  from {margin-left: -1500px;}
  to {margin-left: 0px;}
}

.close-search{
  position:fixed;
  color:#fff;
  top:50px;
  right:100px;
  font-size:2em;
  cursor:pointer;
  display:none;
  z-index: 9999999;
  -webkit-transform:rotate(0deg);
  transform:rotate(0deg);
  -webkit-transition: all 600ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
  transition:         all 600ms cubic-bezier(0.68, -0.55, 0.265, 1.55); 
}

.close-search:hover{
    top:46px;
  font-size:2.4em;
  -webkit-transform:rotate(360deg);
  transform:rotate(360deg);
}
/*-------------- saerch section -----------*/
.search{
  position:fixed;
  top:50%;
  left:50%;
  -webkit-transform:translate(-50%, -50%);
  transform:translate(-50%, -50%);
  border-radius:1000px;
  width:0;
  height:0;
  background:#03a9f4d6;
   -webkit-transition: all .4s linear;
  transition:  all .4s linear;
  z-index: 999999;
}
.search.College{
    background:#7453c6e3;
}
.search.School{
    background:#0caa41d9;
}
.search.Educational.Institute{
    background:#da4453db;
}
.search button{
  color:#03a9f4;
  font-size:1.7em;
  cursor:pointer;
}

.search .search-box2{
  position:absolute;
  top:47%;
  left:50%;
  -webkit-transform:translate(-50%, -50%);
  transform:translate(-50%, -50%);
  width:500px;
  height:55px;
  border:none;
  outline:none;
  border-bottom:3px solid #eee;
  color:#eee;
  font-size:1.3em;
  display:none;
}


.search.open{
  height:4000px;
  width:4000px;
}

.search-box2 {
    height:42px;
    display: inline-block;
    width: 100%;
    border-radius: 3px;
    margin-bottom:10px;
    padding: 0px 0px 0px 15px;
    position: relative;
    background: #fff;
    border: 1px solid #ddd;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box2 input[type=text] {
    border: none;
    box-shadow: none;
    display: inline-block;
    height: 55px;
    padding: 0;
    background: transparent;
}
.search-box2 input[type=text]:hover, .search-box2 input[type=text]:focus, .search-box2 input[type=text]:active {
    box-shadow: none;
}
.search-box2 .search-btn {
   position: absolute !Important;
    right: 4px;
    top: 11px;
    color: #eee;
    font-size: 20px;
    padding: 5px 10px 5px;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box2 .search-btn:hover {
    color: #fff;
    background-color: #00a0e3;
}
.fs-box{
    border:1px solid #eee;
}
#form-search-q .twitter-typeahead
{
width:85%;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.logo_wrap
{
    display: inline-block;
    max-width:50px;
    height: 25px;
    vertical-align: middle;
    margin-right: .6rem;
    float:left;
}

.tt-hint {
  color: #999
}
.tt-menu {
    width: 100%;
    margin: 12px 0;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
    text-align: left;
    max-height:210px;
    overflow-y:auto;
    overscroll-behavior: none;
}
.tt-menu .tt-dataset .suggestion_wrap:nth-child(odd) {
    background-color: #eff1f6;
    }
 .suggestion_wrap
 {
     margin-top: 3px;
 }   
.suggestion
{
    display: inline-block;
    vertical-align: middle;
    max-width: 70%;
}
@media screen and (max-width: 400px) {
    .suggestion{
        max-width: 65%;
    }
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
  height:54px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
/*Load Suggestions loader css starts*/
.search-box2 .load-suggestions{
    display:none;
    position: absolute;
    right: 45px !important;
    z-index: 999;
}
.search-box2 .load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 25px 1px !important;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
#search_company
{
    width: 100%;
}
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
@media screen and (max-width: 767px){
    .search-box2{
        width: 350px !important;
    }
    .close-search{
        top:10px;
        right:30px;
    }
}
@media screen and (max-width: 616px){
    .search-box2{
        width: 320px !important;
    }
    .close-search{
        top:10px;
    }
    .r-btns.actives{
        height:105px !Important;
    }
}
@media screen and (max-width: 400px){
    .search-box2{
        width: 300px !important;
    }
    .close-search{
        top:5px;
    }
    .r-btns.actives{
        height:165px !Important;
    }
}
');
$this->registerJs("
$(document).on('click','#review_btn',function(e) {
    e.preventDefault();
    $('.r-btns').toggleClass('actives');
    $('#review_btn').hide();
});

(function($){
    var search_button = $('.show-ss'),
        close_button  = $('.close-search'),
        input = $('.search-box2');
        var dataKey;
    search_button.on('click',function(e){
        e.preventDefault();
        dataKey = $(this).attr('data-key');
        var placeHolder = $(this).attr('data-placeholder');
        $('#search_company-q').attr('placeholder', placeHolder);
        $('.search').addClass(dataKey);
        $('.search').addClass('open');
        close_button.fadeIn(500);
        input.fadeIn(500);
        $('input').focus();
        $('body').css('overflow-y','hidden');
    });
    
    close_button.on('click',function(){
        close_button.fadeOut(500);
        input.fadeOut(200);
        $('.search').removeClass('open');
        $('body').css('overflow-y','visible');
        setTimeout(function(){
            $('.search').delay(1000).removeClass(dataKey);
            $('#search_company-q').val('');
        }, 1000);
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            close_button.fadeOut(500);
            input.fadeOut(200);
            $('.search').removeClass('open');
            $('body').css('overflow-y','visible');
            setTimeout(function(){
                $('.search').delay(1000).removeClass(dataKey);
                $('#search_company-q').val('');
            }, 1000);
        }
    });
    })(jQuery);
$(document).on('click','.add_new_org_q',function(e) {
  e.preventDefault();
  window.location.replace('/reviews/post-unclaimed-reviews?tempname='+$('#search_company-q').val());
})
");