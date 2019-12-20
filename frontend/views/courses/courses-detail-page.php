<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>


    <section class="bg-set-clr">
        <div class="container">
            <div class="row">
                <div class="set-line-main">
                    <div class="c-heading">AWS Certified Solutions Architect - Associate 2020</div>
                    <div class="c-suggestion">Want to pass the AWS Solutions Architect - Associate Exam?</div>
                    <div class="c-created">Created by :<span>Ryan Kroonenburg, Faye Ellis</span></div>
                    <div class="c-lang">Languages : <span>English</span></div>
                    <div class="cart">
                        <span><i class="fas fa-cart-plus" title="Add To Cart"></i>Add To Cart</span>
                        <span><i class="far fa-heart" title="Add To Wishlist"></i>Wishlist</span>
                    </div>
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
                        <div class="course-detail">This course introduces you to important concepts and terminology for
                            working with Google Cloud Platform (GCP). You learn about, and compare, many of the
                            computing and storage services available in Google Cloud Platform, including Google App
                            Engine, Google Compute Engine, Google Kubernetes Engine, Google Cloud Storage, Google Cloud
                            SQL, and BigQuery. You learn about important resource and policy management tools,
                        </div>
                    </div>
                    <div class="learn-box">
                        <h3>What you will learn</h3>
                        <div class="points">
                            <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>
                            <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>
                            <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>
                        </div>
                    </div>
                    <div class="skills-box">
                        <h3>skills you will gain</h3>
                        <div class="points">
                            <div class="skills-cards">html</div>
                            <div class="skills-cards">html</div>
                            <div class="skills-cards">html</div>
                        </div>
                    </div>
                    <div class="c-requirements">
                        <h3>Requirements</h3>
                        <div class="req-points">
                            <ul>
                                <li>Absolutely no experience is required. We will start from the basics and gradually
                                    build up your knowledge. Everything is in the course.
                                </li>
                                <li>You will need Microsoft Excel 2010, 2013, or 2016</li>
                                <li>You will need Microsoft PowerPoint 2010, 2013, or 2016</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="buy-box">
                        <div class="c-preview">
                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                        </div>
                        <div class="c-amount"><i class="fas fa-rupee-sign"></i> 5000</div>
                        <div class="buy-btn">
                            <button class="new-btn-set">Buy Now</button>
                        </div>
                        <div class="discount-set">
                            <button onclick="myFunction()" class="coupon-code">Apply Promo Code</button>
                        </div>
                        <div class="coupon-modal" id="coupon">
                            <input class="form-control set-marg" type="text">
                            <button class="coupon-btn-set">Apply</button>
                        </div>
                        <div class="get-coupon input-group">
                            <input type="text" id="value-save" class="form-control set-form" value="">
                            <div class="input-group-btn">
                                <button class="clipboard btn btn-default get-btn"  onClick="valueSave();">
                                    <i class="fa fa-clipboard" aria-hidden="true"></i>Copy to Clipboard
                                </button>
                            </div>
                        </div>
                        <div class="c-includes">
                            <div class="include-head">This Course Includes</div>
                            <div class="include-inner">
                                <ul>
                                    <li>17 hours on-demand video</li>
                                    <li>2 articles</li>
                                    <li>462 downloadable resources</li>
                                    <li>Full lifetime access</li>
                                    <li>Certificate of Completion</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function myFunction() {
            document.getElementById("coupon").style.display = "block";
        }
        function valueSave() {
            var copyText = document.getElementById("value-save");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            //alert("Copied the text: " + copyText.value);
        }
    </script>
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
.cart{
    padding-top:5px;
}
.cart span {
    margin-right: 20px;
    font-size: 16px;
    cursor: pointer;    
}
.cart span:hover {
    color:#eee;
}
.cart span > i{
    font-size:20px;
    margin-right:10px;
    color: #fff !important;
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
    width: 48%;
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
.cart span{
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
.buy-box {
    border: 1px solid #eee;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 5px 0px #eee;
    margin-top: 10px;
}
.c-preview {
    margin: 0 auto;
    margin-top: 20px;
    line-height: 100px;
    text-align: center;
}
.c-preview img{
    height:auto;
    width:auto;
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