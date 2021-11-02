<?php

use yii\helpers\Url;
?>

<section style="background:#c8e6f3;padding: 80px 0 20px;">
    <div class="container headsec">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="mentee-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/mentee-heading.png'); ?>" align="right"
                             class="responsive"/>
                    </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 topp-pad">
                <div class="mentor-heading-set">
                    <h3 class="ment-up">Find The best mentor</h3>
                    <h3 class="ment-down">Only on <span class="em">Empower</span><span class="yo">Youth</span></h3>
                    <div class="search-box1">
                        <form action="<?= Url::to('#') ?>">
                            <input type="text" placeholder="Search" name="keyword" id="get-mentors">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <?= $this->render('/widgets/mentorships/mentorship-card') ?>
            </div>
            <div class="col-md-4 col-sm-6">
                <?= $this->render('/widgets/mentorships/mentorship-card') ?>
            </div>
            <div class="col-md-4 col-sm-6">
                <?= $this->render('/widgets/mentorships/mentorship-card') ?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="mentee-heading">Top Webinars</p>
            </div>
        </div>
        <div class="row">
            <?= $this->render('/widgets/mentorships/webinar-card',[
                'webinars'=>$webinars,
            ]) ?>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.mentee-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:20px;
    text-transform: capitalize;
    text-align:center;
}
.topp-pad{
    margin-top: 80px !important;
}
.mentee-img{
    width: 400px;
    margin: auto;
}
.mentee-img img {
    width: 100%;
    height: auto;
}
.ment-up {
	font-size: 32px;
	font-family: lora;
	margin: 0;
	text-transform: capitalize;
	color: #fff;
	padding-left: 10px;
}
.ment-down {
	font-size: 36px;
	margin: 0;
	font-family: lora;
    padding-left: 10px;
}
.em{
    color:#00a0e3;
}
.yo{
    color:#ff7803;
}
.search-box1{
    max-width:500px;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 15px 0 0 0;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
    width: calc(100% - 38px);
}
.search-box1 .search_init input{
    width: 100%;
}
.search_init{
    width: calc(100% - 38px);
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    width:38px;
    padding: 9px 10px;
    background: #fff;
    font-size: 18px;
    border-radius:0 10px 10px 0;
    border: none;
    cursor: pointer;
}
.search-box1 button:hover {
    color: #ff7803; 
}
@media(max-width:550px){
.mentee-img{
    width: 320px;
}
.topp-pad {
    margin-top: 30px !important;
}
}

');
$script = <<<JS

JS;
$this->registerJS($script);
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