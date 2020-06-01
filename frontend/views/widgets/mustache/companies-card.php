<?php

use yii\helpers\Url;

?>
    <script id="companies-card-all" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-6">
            <div class="company-main">
                <a href="{{slug}}">
                    {{#is_featured}}
                    <div class="comp-featured">Featured</div>
                    {{/is_featured}}
                    <div class="total-vacancies">
                        <a href="#">25 Vacancies</a>
                    </div>
                    <div class="comp-logo">
                        {{#logo}}
                        <a href="/{{slug}}">
                            <img src="{{logo}}">
                        </a>
                        {{/logo}}
                        {{^logo}}
                        <a href="/{{slug}}">
                            <canvas class="user-icon" name="{{name}}" width="100" height="100"
                                    color="{{color}}" font="35px"></canvas>
                        </a>
                        {{/logo}}
                    </div>
                    <h3 class="comp-Name"><a href="{{slug}}">{{name}}</a></h3>
                    <h3 class="comp-relate">{{business_activity}}</h3>
                    <div class="comp-ratings">
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star"></i></span>
                        <span><i class="fas fa-star-half-alt"></i></span>
                        <span class="rate-in">4.0</span>
                    </div>
                    <div class="comp-jobs-intern">
                        <span class="jobs">10 Jobs</span>
                        <span class="interns">15 Internships</span>
                    </div>
                    <div class="follow-btn">
                        <a href="#">Follow</a>
                    </div>
                </a>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$this->registercss('
.company-main {
	border: 1px solid #eee;
	box-shadow:0px 2px 10px rgba(0,0,0,0.10);
	border-radius: 6px;
	text-align: center;
	position: relative;
	margin:30px 0 20px;
	overflow: hidden;
	padding: 30px 0px 10px;
	transition:all .3s;
}
.company-main:hover{
    transform:scale(1.01);
    box-shadow:0px 2px 15px rgba(0,0,0,0.10);
}
.comp-featured {
	position: absolute;
	top: 17px;
	left: -35px;
	transform: rotate(-43deg);
	background: #ff7803;
	padding: 2px 35px;
	color: #fff;
	font-family: roboto;
	font-weight: 500;
	font-size: 18px;
	border: 1px dashed #fff;
}
.comp-logo {
	width: 110px;
	height: 110px;
	margin: auto;
	border-radius: 60px;
	overflow: hidden;
	border: 1px solid #eee;
	padding: 20px;
	box-shadow: 0 0 13px 4px #eee;
}
.comp-Name {
	font-size: 24px;
	font-family: lora;
	margin: 20px 10px 5px;
	line-height: 30px;
	height: 60px;
	overflow: hidden;
}
.comp-relate {
	margin: 0;
	font-size: 18px;
	font-family: roboto;
	color: #9fa0a2;
	height:26px;
}
.comp-ratings {
	display: inline-flex;
	border: 1px solid #eee;
	padding:5px;
	box-shadow: 0 2px 6px rgba(0,0,0,0.10);
	margin: 15px 0 5px;
	border-radius:3px;
}
.comp-ratings span{
    margin:0 2px;
}
.comp-ratings span i{
    font-size:20px;
    color:#ff8a00;
}
.rate-in {
	background-color: forestgreen;
	color: #fff;
	font-family: roboto;
	margin-left: 5px !important;
	padding: 0 5px;
	border-radius:3px;
	font-weight:500;
}
.comp-jobs-intern {
	display: flex;
	padding: 10px 0 5px;
	font-size: 18px;
	color: #999c9d;
	font-family: roboto;
	flex: 1 1;
	align-items: center;
	justify-content: space-around;
}
.total-vacancies {
	position: absolute;
	top: 0;
	right: 0px;
	background-color: #00a0e3;
	border-radius: 0 4px 0 4px;
	padding: 3px 8px;
}
.total-vacancies a {
	font-size: 17px;
	font-family: roboto;
	color: #fff;
	font-weight: 500;
	display: block;
}
.follow-btn {
    margin:5px 0;
}
.follow-btn a {
    background-color: #ff7803;
    color: #fff;
    font-size: 20px;
    font-family: roboto;
    padding: 5px 20px;
    border-radius: 4px;
    font-weight: 500;
}
');

