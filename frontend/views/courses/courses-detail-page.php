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
                <div class="col-md-8">
                    <div class="about-course">
                        
                    </div>
                    <div class="learn-box">
                        <h3>What you will learn</h3>
                        <div class="points">
                            <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>
                            <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>
                            <div class="learning-cards"><i class="fas fa-check-circle"></i>html</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>

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
.learn-box {
    border: 1px solid #ddd;
    padding: 10px 20px;
}
.learn-box h3{
    margin:0px;
    font-family: roboto;
    font-weight: 500;
}
.learning-cards {
    text-align: left;
    display: inline-block;
    width: 48%;
    margin: 5px;
    font-size: 16px;
    text-transform: capitalize;
    font-family: roboto;
}
.learning-cards > i {
    margin-right:10px;
    color: #42ca26;
}
');