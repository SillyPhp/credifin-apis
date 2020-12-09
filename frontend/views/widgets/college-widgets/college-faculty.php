<?php

use yii\helpers\Url;
?>

<div class="container">
    <div class="row">
        <div class="faculty-main">
            <div class="col-md-3">
                <div class="teacher-box">
                    <div class="faculty-Img"><img src="<?= Url::to('@eyAssets/images/pages/company-profile/user_avatar.png')?>"></div>
                    <h4>Tarandeep Singh Rakhra</h4>
                    <p>HOD</p>
                    <p>Computer Science</p>
                    <p>35 Years</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="teacher-box">
                    <div class="faculty-Img">
                        <img src="<?= Url::to('@eyAssets/images/pages/company-profile/user_avatar.png')?>">
                    </div>
                    <h4>Tarandeep Singh Rakhra</h4>
                    <p>HOD</p>
                    <p>Computer Science</p>
                    <p>35 Years</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="teacher-box">
                    <div class="faculty-Img"><img src="<?= Url::to('@eyAssets/images/pages/company-profile/user_avatar.png')?>"></div>
                    <h4>Tarandeep Singh Rakhra</h4>
                    <p>HOD</p>
                    <p>Computer Science</p>
                    <p>35 Years</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="teacher-box">
                    <div class="faculty-Img"><img src="<?= Url::to('@eyAssets/images/pages/company-profile/user_avatar.png')?>"></div>
                    <h4>Tarandeep Singh Rakhra</h4>
                    <p>HOD</p>
                    <p>Computer Science</p>
                    <p>35 Years</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="teacher-box">
                    <div class="faculty-Img"><img src="<?= Url::to('@eyAssets/images/pages/company-profile/user_avatar.png')?>"></div>
                    <h4>Tarandeep Singh Rakhra</h4>
                    <p>HOD</p>
                    <p>Computer Science</p>
                    <p>35 Years</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="teacher-box">
                    <div class="faculty-Img"><img src="<?= Url::to('@eyAssets/images/pages/company-profile/user_avatar.png')?>"></div>
                    <h4>Tarandeep Singh Rakhra</h4>
                    <p>HOD</p>
                    <p>Computer Science</p>
                    <p>35 Years</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.teacher-box{
	-webkit-box-shadow: 0 0 10px rgba(0,0,0,.2);
	box-shadow: 0 0 10px rgba(0,0,0,.2);
	padding: 10px;
	border-bottom: 5px solid #00a0e3;
	position: relative;
	margin-bottom:20px;
	font-family:roboto;
}
.faculty-Img{
	width: 70px;
	height: 70px;
	border: 1px solid #eee;
	padding: 3px;
	margin-bottom: 10px;
	position: relative;
}
.faculty-Img img{
	width: 100%;
	height: 100%;
}
.teacher-box h4{
	font-size: 18px;
	color: #00a0e3;
	margin-bottom: 5px !important;
	font-family:roboto;
}
.teacher-box p{
	margin-bottom: 5px;
}
');
