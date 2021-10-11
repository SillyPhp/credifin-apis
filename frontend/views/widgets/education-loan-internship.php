<?php
use yii\helpers\Url;
?>
<section class="bg-Green">
    <div class="bg-Green-overlay"></div>
    <div class="container">
        <div class="row row-flex">
            <div class="col-sm-6 col-xs-12">
                <div class="internshipHeading">
                    <h5>Worried About Paying For Your Education While Studying?</h5>
                    <p>Apply for Our <span>Education Loan</span> + <span>Internship Programme</span>.<br>
                    Pay For Your Education Loan Yourself By Earning With Our <br>
                        High Paying <span>Internship Programme</span>.</p>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="internship-btn text-center">
                    <a href="https://www.empoweryouth.com/internship/marketing-education-loan-28751616658499" target="_blank">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.row-flex{
    display: flex;
    align-items: center;
}
.internshipHeading h5{
    font-size: 25px;
    text-transform: capitalize;
    color: #fff;
    font-weight: 500;
    margin-bottom: 15px;
}
.internshipHeading p{
    text-transform: capitalize;
    font-size: 16px;
    margin-bottom: 30px;
}
.internshipHeading p span{
    text-transform: uppercase;
    font-size: 18px;
    font-weight: 500;
    color:#ff7803
}
.bg-Green .container{
    padding-top: 0px !important;
}
.bg-Green{
    background: url('. Url::to('@eyAssets/images/pages/educational-loans/schoolfee-financing.png') .');
    background-position: center;
    background-size: cover;
    color: #fff;
    min-height: 400px;
    display: flex;
    align-items: center;
    position: relative;
    padding: 60px 0;
}
.bg-Green-overlay{
    position: absolute;
    top:0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, #073b4c 40%, #073b4c02);
    opacity: 1;
}
.bg-Green::before,
.bg-Green::after{
    content:"";
    position: absolute;
    top:0px;
    left: 0px;
    background: #ff7803;
    max-width: 50%;
    width: 100%; 
    height: 20px;
    z-index: 2
}
.bg-Green::after{
    top: unset;
    left: unset;
    bottom: 0px;
    right: 0px;
}
.internshipHeading{
    max-width: 450px;
}
.internship-btn a{
    padding: 20px 40px;
    border: 1px solid #ff7803;
    background: #ff7803;
    color: #fff;
    font-size: 20px;
    text-transform: uppercase;
    display: inline-block;
}
@media only screen and (max-width: 767px){
    .row-flex{
        display: block;
    }
    .bg-Green{
        background: linear-gradient(to right, #073b4c 59%, #073b4c02 233%);
    }
    .internship-btn a{
        padding: 8px 35px;
    }
    .internshipHeading p{
        //text-align: center;
        font-size: 14px;
    }
    .internship-btn{
        text-align: left;
    }
}
')
?>
