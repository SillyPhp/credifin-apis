<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<div id="detail-main"></div>
    <script id="detail-app" type="text/template">
        {{#.}}
        <section class="bg-set-clr">
            <div class="container">
                <div class="row">
                    <div class="set-line-main">
                        <div class="c-heading">{{title}}</div>
                        <div class="c-suggestion">{{headline}}</div>
                        <div class="c-created">Created by :<span>{{#visible_instructors}}{{display_name}}{{/visible_instructors}}</span></div>
                        <div class="c-lang">Languages : <span>{{#locale}}{{locale.title}}{{/locale}}</span></div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
<!--                        <div class="video-sec">-->
<!--                            <div class="video-thumb">-->
<!--                                <img src="{{image_750x422}}"/>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="about-course">
                            <div class="course-heading">About this course</div>
                            <div class="course-detail">
                                {{{description}}}
                            </div>
                        </div>
                        <div class="learn-box">
                            <h3>What you will learn</h3>
                            <div class="points">
                                <div class="learning-cards"><i class="fas fa-check-circle"></i>
                                    {{#what_you_will_learn_data.items}}
                                        {{.}}
                                    {{/what_you_will_learn_data.items}}
                                </div>
<!--                                <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>-->
<!--                                <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>-->
                            </div>
                        </div>
<!--                        <div class="skills-box">-->
<!--                            <h3>Skills you will gain</h3>-->
<!--                            <div class="points">-->
<!--                                <div class="skills-cards">html</div>-->
<!--                                <div class="skills-cards">html</div>-->
<!--                                <div class="skills-cards">html</div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="c-requirements">
                            <h3>Requirements</h3>
                            <div class="req-points">
                                <ul>
                                    {{#requirements_data.items}}
                                        <li>
                                            {{.}}
                                        </li>
                                    {{/requirements_data.items}}
<!--                                    <li>You will need Microsoft Excel 2010, 2013, or 2016</li>-->
<!--                                    <li>You will need Microsoft PowerPoint 2010, 2013, or 2016</li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="buy-box">
                            <div class="c-preview">
                                <img src="{{image_304x171}}"/>
                            </div>
                            <div class="c-amount">{{#is_paid}}<i class="fas fa-rupee-sign"></i>{{/is_paid}} {{price}}</div>
                            <div class="buy-btn">
                                <a href="https://udemy.com/{{url}}" target="_blank" class="new-btn-set">Enroll Now</a>
                            </div>
<!--                            <div class="discount-set">-->
<!--                                <button onclick="myFunction()" class="coupon-code">Apply Promo Code</button>-->
<!--                            </div>-->
<!--                            <div class="coupon-modal" id="coupon">-->
<!--                                <input class="form-control set-marg" type="text">-->
<!--                                <button class="coupon-btn-set">Apply</button>-->
<!--                            </div>-->
<!--                            <div class="get-coupon input-group">-->
<!--                                <input type="text" id="value-save" class="form-control set-form" value="">-->
<!--                                <div class="input-group-btn">-->
<!--                                    <button class="clipboard btn btn-default get-btn" onClick="valueSave();">-->
<!--                                        <i class="fa fa-clipboard" aria-hidden="true"></i>Copy to Clipboard-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="c-includes">
                                <div class="include-head">This Course Includes</div>
                                <div class="include-inner">
                                    <ul>
                                        <li>{{content_info}} on-demand video</li>
                                        {{#num_article_assets}}<li>{{num_article_assets}} articles</li>{{/num_article_assets}}
                                        {{#num_additional_assets}}<li>{{num_additional_assets}} downloadable resources</li>{{/num_additional_assets}}
                                        {{#num_coding_exercises}}<li>{{num_coding_exercises}} Exercises</li>{{/num_coding_exercises}}
<!--                                        <li>Full lifetime access</li>-->
                                        {{#has_certificate}}<li>Certificate of Completion</li>{{/has_certificate}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{/.}}
    </script>
    <script>
        // function myFunction() {
        //     document.getElementById("coupon").style.display = "block";
        // }

        // function valueSave() {
        //     var copyText = document.getElementById("value-save");
        //     copyText.select();
        //     copyText.setSelectionRange(0, 99999)
        //     document.execCommand("copy");
        //     //alert("Copied the text: " + copyText.value);
        // }
    </script>
    <div id="sectionIsLoading" class="sectionIsLoading">
        <div></div>
        <div></div>
    </div>
<?php
$this->registerCss('
.sectionIsLoading {
    display: block;
    position: relative;
    width: 80px;
    height: 50vh;
    margin: auto;
    margin-top: 25vh;
}
.sectionIsLoading div {
  position: absolute;
  border: 4px solid #00a0e3;
  opacity: 1;
  border-radius: 50%;
  animation: sectionIsLoading 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.sectionIsLoading div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes sectionIsLoading {
  0% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 0px;
    left: 0px;
    width: 72px;
    height: 72px;
    opacity: 0;
  }
}
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
$script = <<< JS
var id = $(location).attr("href").split('/').pop();
$.ajax({
    method: "POST",
    url : '/courses/get-data',
    data:{id:id},
    success: function(response) {
        $('#sectionIsLoading').fadeOut(800);
            response = JSON.parse(response);
        if(response.detail == "Not found.") {
            $('#detail-main').css('text-align', 'center');
            $('#detail-main').css('min-height', '60vh');
            $('#detail-main').css('margin-top', '15vh');
            $('#detail-main').append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
        } else{
            var template = $('#detail-app').html();
            var rendered = Mustache.render(template,response);
            $('#detail-main').append(rendered);
        }
    }
});
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
