<?php

use yii\helpers\Url;

?>

    <section class="sub-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cou-heading">Be the first to know about new course and discounts: subscribe to
                        newsletter
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <input type="text" class="form-control fm-set" id="name" placeholder="Enter Name">
                </div>
                <div class="col-md-5">
                    <input type="email" class="form-control fm-set" id="email" placeholder="Enter Email" name="email">
                </div>
                <div class="col-md-2">
                    <div class="sub-btn">
                        <button type="submit" class="btn btn-default">SUBSCRIBE</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registercss('
.sub-sec{
    background-color: #00a0e3;
    padding: 10px 0 50px;
    margin: 25px 0;
}
.cou-heading {
    font-size: 22px;
    color: #fff;
    padding-bottom: 8px;
    text-transform: capitalize;
    font-family: roboto;
    font-weight: 500;
}
.fm-set {
    border-radius: 4px;
    font-size: 16px;
    font-family: roboto;
}
.sub-btn button{
    padding: 7px 25px;
    font-size: 18px;
    color: #fff;
    font-family: roboto;
    transition: ease-out .3s;
    background-color:#00a0e3;
    border:3px solid;
    font-weight: 500;
}
.sub-btn:hover button{
    color:#00a0e3;
    background-color:#fff;
}
');