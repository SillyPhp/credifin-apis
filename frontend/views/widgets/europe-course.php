<?php
use yii\helpers\Url;
?>
    <section class="egoven-jobs-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="egov-job">
                        <a href="/education-loans/apply">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/uk-mba-prime.png')?>" alt="">
                            <h1 class="link-none">STEM MBA Prime </h1>
                            <p class="link-sub-head">Education Financing to fulfil your aspirations</p>
                            <div class="gj-text gj-blue">
                                <ul>
                                    <li>Covering 20 esteemed colleges in <br>
                                        Europe offering STEM programs</li>
                                    <li>Unsecured Loan Limit Up to ₹25 Lac*</li>
                                    <li>Maximum LoanTenure of 10 Years</li>
                                </ul>
                            </div>
                            <div class="applyBtn applyBlue">Apply</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="egov-job">
                        <a href="/education-loans/apply">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/us-mba-ultra-bg.png')?>" alt="">
                            <h1 class="link-none">STEM MBA Advanced</h1>
                            <p class="link-sub-head">Education Financing to fulfil your aspirations</p>
                            <div class="gj-text gj-orange">
                                <ul>
                                    <li>Covering 15 esteemed colleges in <br>
                                        Europe offering STEM programs</li>
                                    <li>Unsecured Loan Limit Up to ₹20 Lac*</li>
                                    <li>Maximum LoanTenure of 10 Years</li>
                                </ul>
                            </div>
                            <div class="applyBtn">Apply</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.applyBtn{
    position: absolute;
    bottom: 0px;
    right: 0px;
    color: #ff7803;
    font-size: 22px;
    font-family: lora;
    text-transform: capitalize;
    font-weight: 500;
    background: #fff;
    padding: 5px 15px;
    border-radius: 16px 0;
}
.applyBlue{
    color: #00a0e3;
}
.egoven-jobs-sec{
    background:url('. Url::to('@eyAssets/images/pages/index2/gov-job-sec-bg.png') .');
    background-repeat: no-repeat;
    background-size:cover;
    padding: 40px 0px 40px 0px;
}
.egov-heading {
    text-align: center;
    font-size: 30px;
    font-family: lobster;
    margin: 0px 0px 20px 0;
}
.egov-job {
  overflow: hidden;
  margin-bottom: 15px !important;
  max-width: 500px;
  height: 300px;
  width: 100%;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
  margin:auto;
}
.egov-job img {
    max-width: inherit;
    height: 100%;
    position: absolute;
    right: 0;
    -webkit-transition: all 2s ease-out;
    transition: all 2s ease-out;
}
.egov-job:hover img {
  -webkit-transform: translateX(100px);
  transform: translateX(100px);
}
.egov-job{
    text-align:center;
    position:relative;
}
.egov-job, .egov-job img{
    border-radius: 18px;
}

.link-none{
    position:absolute;
    top:5px;
    left:20px;
    color:#fff;
    font-size:40px;
    margin:0;
    font-family: lora;
}
.link-sub-head{
    position: absolute;
    top: 49px;
    left: 20px;
    color: #000;
    font-size: 18px;
}
.gj-text{
    background: #fff;
    position: absolute; 
    top: 116px;
    padding: 15px 20px;
    border-radius: 0 10px 10px 0;
    box-shadow: 2px 7px 10px rgba(0,0,0,.2);
}
.gj-text ul{
    text-align: left;
    list-style: none;
    padding-inline-start: 15px; 
    color: #000;      
}
.gj-text ul li{
    color: #000;
    margin-bottom: 7px;
    line-height: 18px;
}
.gj-text ul li::before {
    content: "\f111";
    font-weight: 900;
    font-family: "Font Awesome 5 Free";
    display: inline-block; 
    font-size: 10px;
    margin-left: -1.5em;
    padding-right: 5px;
  
}
.gj-orange ul li::before{
    color: #fca006;
}
.gj-blue ul li::before{
    color: #00a0e3;    
}
@media (max-width:415px){
.gov-heading{
    font-size:25px;
}
.gov-job{
    margin:0;
    margin-bottom:10px;
}
}
');