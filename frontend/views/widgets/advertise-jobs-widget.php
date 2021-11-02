<?php
use yii\helpers\url;
?>

    <div class="row">
        <div class="col-md-12">
            <div class="wid-box">
                <div class="wid-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/jb.png') ?>" alt="">
                </div>
                <div class="wid-name">
                    Latest Jobs & Internships
                </div>
                <div class="wid-sub-name">
                    Click on the link below to check out the <br><span>Jobs & Internships</span>
                </div>
                <div class="wid-link">
                    <a href="/jobs/list">View Jobs</a>
                    <a href="/internships/list">View Internships</a>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.wid-link {
	margin-top: 25px;
	display: flex;
	justify-content: center;
}
.wid-link a {
	padding: 8px 0;
	background: linear-gradient(45deg, #00a0e3, #89d8f9);
	color: #fff;
	border-radius: 5px;
	flex-basis: 40%;
	font-size: 14px;
	font-family: roboto;
	margin: 0 6px;
}
.wid-link a:hover{
    background: linear-gradient(45deg, #89d8f9, #00a0e3);
    transition:.3s all;
}
.wid-box{
    text-align:center;
    box-shadow:0 0 10px rgba(0,0,0,.3);
    margin-top:20px;
    padding:30px 15px;
    border-radius:10px;
}
.wid-name{
    font-family: Roboto;
    font-weight:500;
    font-size:20px;
    text-align:center;
    color:#000;
    padding-top:40px;
                                          
}
.wid-sub-name{
    text-align:center;
    color:#000;
    font-family: roboto;
    font-size:16px;
}
.wid-sub-name span{
    font-weight:500;
}
');