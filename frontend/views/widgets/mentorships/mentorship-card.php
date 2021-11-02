<?php
use yii\helpers\Url;
?>
<div class="mentorship-card-bg">
    <div class="md-flex">
        <div class="mentorship-card-profile">
            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg') ?>">
        </div>
        <div class="mentor-details">
            <p class="mentor-name">Mr. Tarry</p>
            <p class="mentor-designation"><i class="fas fa-rupee-sign"></i> 200 Per Hour</p>
            <p class="mentor-designation">20 Sessions</p>
            <div class="mentor-demo">
                <button type="button">Demo Available</button>
            </div>
        </div>
    </div>
    <div class="career-c">Career Counselling</div>
    <div class="md-flex spaceBetween">
        <div class="md-rating">9.7 <span>Rating</span></div>
        <div class="md-progress">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                    <span class="sr-only">70% Complete</span>
                </div>
            </div>
        </div>
        <div class="md-like">
            <button type="button" title="shortlist"><i class="far fa-bookmark"></i></button>
        </div>
    </div>
    <div class="men-box-fields">
        <h4>Area Of Mentorship</h4>
        <ul class="mentor-skills-taught">
            <li>Web Designing</li>
            <li>Web Development</li>
            <li>Personality Development</li>
        </ul>
    </div>
    <div class="ask-mentee">
        <h4>Mentor Skills</h4>
        <ul class="ask-people">
            <li><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"></li>
            <li><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg') ?>"></li>
        </ul>
    </div>
    <div class="btn-flex">
        <div class="apply-btn">
            <button type="button">Apply</button>
        </div>
        <div class="apply-btn">
            <button type="button">View Profile</button>
        </div>
        <div class="share-btn">
            <div class="sharing-links" id="share">
                <i class="fa fa-share-alt new-share"></i>
                <div class="set">
                    <div class="fb">
                        <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                           target="blank">
                            <span><i class="fab fa-facebook-f"></i></span></a>
                    </div>
                    <div class="tw">
                        <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                           target="blank">
                            <span><i class="fab fa-twitter"></i></span></a>
                    </div>
                    <div class="male">
                        <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                           target="blank">
                            <span><i class="fab fa-linkedin"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.wts-app, .fb, .tw, .male{
    width: 30px;
    text-align: center;
    border-radius: 50px;
    height: 30px;
    font-size: 15px;
    padding-top: 3px;
    margin-bottom: 4px;
}
.wts-app{ background-color: #25D366;}
.male{  background-color: #d3252b;}
.tw{ background-color: #1c99e9;}
.fb{background-color: #236dce;}
.wts-app a, .male a, .tw a, .fb a{color:white;}
.set {
	position: absolute;
	bottom: 90%;
	right: -25%;
	padding: 0px;
	border-radius: 10px;
	height: 0px;
	overflow: hidden;
	-moz-transition: all 0.3s ease-out;
	-webkit-transition: all 0.3s ease-out;
	-o-transition: all 0.3s ease-out;
	transition: all 0.3s ease-out;
}
.share-btn {
	flex-basis: 10%;
	position: relative;
}
.sharing-links {
	position: absolute;
	width: 100%;
	left: 7%;
	top: 4%;
}
.new-share {
	font-size: 18px;
	background: #00a0e3;
	color: #fff;
	padding: 8px 8px;
}
.new-share:hover {
	box-shadow: 0 0 8px rgba(0,0,0,.3);
	background: #fff;
	color: #00a0e3;
	transition: .2s ease;
	transform: scale(1.01);
}
.sharing-links:hover .set{
    height:110px;
    padding: 5px;
}
.career-c {
    font-size: 18px;
    font-family: lora;
    font-weight: bold;
    margin-top: 15px;
}
.mentor-demo button{
    padding: 0px 00px;
    border: none;
    background: transparent;
    color:#00a0e3;
    font-size: 13px; 
    letter-spacing: .5px;
}
.btn-flex{
    display: flex;
    margin-top: 20px;
}
.apply-btn{
    flex-basis: 50%;
}
.apply-btn button{
    width: 100%;
    padding: 10px 0;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: #00a0e3;
    color: #fff;
    border: 1px solid #fff;
    font-family: roboto;
    font-weight: 500;
}
.apply-btn button:hover{
    box-shadow: 0 0 8px rgba(0,0,0,.3);
    background: #fff;
    color:#00a0e3;
    transition: .2s ease;
    transform: scale(1.03);
}
.ask-people{
    margin-top: 10px;
}
.ask-people li{
    width: 50px;
    height: 50px;
    border: 2px solid #fff;
    border-radius: 50%;
    display: inline-block;
    margin-right: -20px;
}
.ask-people li img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.md-flex{
    display: flex;
    align-items: center;
}
.md-progress{
    width: 50%; 
}
.md-progress .progress {
    height: 6px;
    margin-bottom: 0px;
    background-color: #f5f5f5;
    border-radius: 4px;
    width: 100%;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}
.md-progress .progress-bar{
    background-color:#00a0e3;
}
.spaceBetween{
    justify-content: space-between;
//    margin-top: 5px;
}
.md-like button{
    background: transparent;
    border: 1px solid #eee;
    padding: 11px 10px 9px 10px;
    border-radius: 50px;
    line-height: 13px;
}
.md-like button:hover{
    color:#00a0e3;
    border-color: #00a0e3;
    transition: .3s ease;
}
.md-rating{
    font-size: 16px;
    font-weight: bold;
    color:#333;
}
.md-rating span{
    font-size: 14px;
    font-weight: normal;   
}
.mentor-skills-taught{
    margin-top: 10px;
}
.mentor-skills-taught li{
    display: inline-block;
    font-size: 14px !important;
    color: #333 !important;
    background: #f7f8fa;
    padding: 5px 15px;
    margin-right: 5px;
    margin-bottom: 5px;
}
.mt50{
    padding-top: 50px;
}
.mentorship-card-bg{
    box-shadow: 0 0 10px rgba(0,0,0,.1);
    padding: 20px 20px;
    border-radius: 0px;
    font-family: roboto;
    margin-bottom: 25px;
    position: relative;
}
.mentorship-card-profile {
    min-width: 90px;
    max-width: 9px;
    height: 100px;
    border-radius: 20px;
    -webkit-border-radius: 20px;
    -ms-border-radius: 20px;
    background: #fff;
    
    overflow: hidden;
}
.mentorship-card-profile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    
}
.mentor-details{
    margin-left: 20px;
    font-family: roboto;
    color:#333;   
    text-transform: capitalize;  
}
.mentor-details .mentor-name{
    color:#333;
    font-family: lora;
    font-size:20px;
    font-weight: bold;
       margin-bottom: 5px;
}
.mentor-details p, .men-box-fields p{
    margin: 0px;
    font-size: 14px;
    line-height: 20px;
    color: #333;
}
.men-box-fields h4, .ask-mentee h4{
    font-family: lora;
    font-weight: bold;
    margin-bottom: 0;
}
.men-box-fields{
    margin-top: 15px
}

.mentor-pay{
    margin-top: 20px;
//    background: #00a0e3;
    color: #00a0e3;
    text-align: center;
    font-family: roboto;
    font-size: 15px;
    padding: 10px 0;
    width: 100%;
    border: none;
    border-radius: 0 0 10px 10px;
}
')

?>

<script>
    let demoBtn = document.querySelectorAll('.mentor-demo button');
    for (let i=0; i<demoBtn.length; i++){
        demoBtn[i].addEventListener('mouseover', function(e){
            e.currentTarget.innerHTML = 'Apply For Demo';
        })
        demoBtn[i].addEventListener('mouseleave', function(e){
            e.currentTarget.innerHTML = 'Demo Available';
        })
    }
</script>