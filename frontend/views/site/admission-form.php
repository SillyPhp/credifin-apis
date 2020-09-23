<?php

use yii\helpers\Url;
?>

    <section class="admission-form">
        <div class="oa-container">
            <div class="ey-logo">
                <a href="/"> <img src="<?= Url::to('@commonAssets/logos/logo.svg')?>"></a>
            </div>
            <div class="flex-main">
                <div class="left-sec">

                    <h2>Get Admission In Your <br><span>Dream Colleges</span> <br>Without Any Hassle</h2>
                    <div class="ls-divider"></div>
                    <h4 class="mb0">Don’t Let Money Stop You From Getting into Your Dream College!</h4>
                    <h4 class="mt10">Get Interest Free <span class="colorOrange">Education Loans</span> both in
                        <span class="colorOrange">India</span> and <span class="colorOrange">Abroad</span>.</h4>
                    <div class="el-icons-flex">
                        <div class="el-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/loan-application.png')?>">
                            <p>Online <br>Application</p>
                        </div>
                        <div class="el-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/quick-sanction.png')?>">
                            <p>Quick <br>Sanction</p>
                        </div>
                        <div class="el-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/collateral.png')?>">
                            <p>Collateral Free <br>Loans</p>
                        </div>
                    </div>
                    <h3>Only on
                        <a href="/education-loans">
                            <span class="colorBlue">Empower</span><span class="colorOrange">Youth</span>.com
                        </a>
                    </h3>
                </div>
                <div class="right-sec">
                    <div class="ls-box-shadow">
                        <p id="headingText">Fill Me For Your Bright Future</p>
                        <form>
                            <div class="form-group" id="step1">
                                <div class="form-flex">
                                    <div class="ff-input">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                    <div class="ff-input">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="form-flex">
                                    <div class="ff-input">
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="ff-input">
                                        <input type="tel" class="form-control" placeholder="Contact Number (WhatsApp)">
                                    </div>
                                </div>

                                <div class="form-flex">
<!--                                    <div class="ff-input">-->
<!--                                        <select class="form-control">-->
<!--                                            <option>Degree</option>-->
<!--                                            <option value="diploma">Diploma</option>-->
<!--                                            <option value="under graduation">Under Graduation</option>-->
<!--                                            <option value="post graduation">Post Graduation</option>-->
<!--                                            <option value="phd">PhD</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
                                    <div class="ff-input">
                                        <input type="text" class="form-control" placeholder="Degree">
                                    </div>
                                    <div class="ff-input">
                                        <input type="text" class="form-control" placeholder="Course Name">
                                    </div>
                                </div>

                                <div class="form-flex">
                                    <div class="fw-input">
                                        <input type="text" class="form-control" placeholder="College Or University Name">
                                    </div>
                                </div>

                                <div class="form-flex-2">
                                    <div class="font14">Have You Already Applied In This College</div>
                                    <div class="radio-container">
                                    <input type="radio" name="field" id="Uno"/>
                                    <label for="Uno">
                                        <svg class="check" viewbox="0 0 40 40">
                                            <defs>
                                                <linearGradient id="gradient" x1="0" y1="0" x2="0" y2="100%">
                                                    <stop offset="0%" stop-color="#0db6fc"></stop>
                                                    <stop offset="100%" stop-color="#00a0e3"></stop>
                                                </linearGradient>
                                            </defs>
                                            <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                            <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                        </svg>Yes
                                    </label>
                                    <input type="radio" name="field" id="Dos"/>
                                    <label for="Dos">
                                        <svg class="check" viewbox="0 0 40 40">
                                            <defs>
                                                <linearGradient id="gradient" x1="0" y1="0" x2="0" y2="100%">
                                                    <stop offset="0%" stop-color="#0db6fc"></stop>
                                                    <stop offset="100%" stop-color="#00a0e3"></stop>
                                                </linearGradient>
                                            </defs>
                                            <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                            <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                        </svg>No
                                    </label>
                                </div>
                                </div>

                                <div class="form-flex">
                                    <div class="fw-input">
                                        <input type="text" class="form-control" placeholder="Loan Amount Required (Optional)">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="step2">
                                <div class="form-flex">
                                    <div class="fw-input">
                                        <input type="text" class="form-control" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-flex">
                                    <div class="fw-input">
                                        <input type="text" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-flex">
                                    <div class="fw-input">
                                        <input type="text" class="form-control" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>

                            <div class="button-form">
                                <button type="button" class="btn-frm" id="nextBtn" name="submitButton">Next</button>
                                <button type="Submit" class="btn-frm" id="submitBtn" name="submitButton">Sumbit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('

body{
    margin: 0px;
    padding:0px; 
    font-family: roboto;
}
.oa-container{
    max-width: 85vw;
    margin: 0 auto;
}
.admission-form{
    background: url('. Url::to('@eyAssets/images/pages/custom/form-bg1.png') .');
    background-attachment: fixed;
    background-size: cover;
    min-height: 100vh;
}
.ey-logo {
    text-align: center;
    padding-top:50px;
    padding-bottom: 20px;
}
.ey-logo img{
    max-width: 200px;
}
.flex-main{
    display: flex;
    height: calc(100vh - 60px);
    align-items: center;
    
}
.left-sec{
    flex-basis: 50%;
    padding-left: 50px;
}
.left-sec h2{
    font-size: 30px;
    color: #333;
    line-height: 45px;
    margin-top: 0px;
}
.left-sec h2 span{
    font-size: 45px;
    color: #00a0e3
}   
.right-sec{
    flex-basis: 50%;
}
.left-sec p{
    margin:0
}
.ls-box-shadow{
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    background: #fff;
    padding: 15px 20px 30px;
    max-width: 500px
}
.ls-box-shadow p{
    font-size: 21px;
    color: #333;
    text-align: center;
    font-family: roboto;
    font-weight: 500;
}
.right-sec form .form-group{
    display: flex;
    flex-direction: column;
}
.ls-divider{
    height: 2px; 
    background: #666;
    max-width: 150px;
}
.el-icons-flex{
    display: flex;
}
.el-icons{
    text-align: center;
    margin: 0 30px 0 0px;
}
.el-icons p{
    font-size: 15px;
}
.left-sec h4{
    color: #333;
}
.left-sec h3 a{
    text-decoration: none;
    color: #333;
}
.form-control{
    margin: 10px auto;
    padding: 12px 12px;
    background-color: #fff;
    border: 1px solid #c2cad8;
    width: calc(100% - 25px);
}
.form-control:focus{
//    border: 1px solid #c2cad8;
    box-shadow: 0 0 5px rgba(0,0,0,.2);
    outline: none;
}
.colorOrange{
    color: #ff7803;
}
.colorBlue{
    color: #00a0e3;
}
.button-form{
    text-align: center;
    display: flex;
    justify-content: center;
}
.btn-frm{
    width:100px;
    height:40px;
    background-color: #00a0e3;
    border: 0px solid #c2cad8;
    color: #fff;
    border-radius: 6px;
    margin: 10px 5px 0;
}
.btn-frm:hover{
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
.btn-frm:focus{
    outline: none;
}
.form-flex{
    display: flex;
    width: 100%;
    justify-content: center;
    align-content: center;
    margin: 0 auto;
} 

.form-flex-2{
    display: flex;
    width: 100%;
    flex-direction: column; 
    padding: 10px 10px 0;  
} 
.font14{
    font-size: 15px;
} 
.ff-input{
    margin: 0 5px;
    flex-basis: 50%;
}
.ff-input select{
    display: block;
    width: 100%;
}
.fw-input{
    margin: 0 5px;
    flex-basis: 100%;
}
.radio-container{
    display: flex;
    
}
.radio-container svg {
  width: 1.35rem;
  height: 1.35rem;
}
.radio-container svg.gear {
  order: 1;
  margin-left: 1.35rem;
  cursor: help;
}
.radio-container svg.gear:hover ~ h4 {
  transform: scale(1);
}
label {
  position: relative;
  margin: 0.675rem 1.35rem 0.675rem 0;
  display: flex;
  width: auto;
  align-items: center;
  cursor: pointer;
}

.check {
  margin-right: 7px;
  width: 1.35rem;
  height: 1.35rem;
}
.check #border {
  fill: none;
  stroke: #7a7a8c;
  stroke-width: 3;
  stroke-linecap: round;
}
.check #dot {
  fill: url(#gradient);
  transform: scale(0);
  transform-origin: 50% 50%;
}

.radio-container input {
  display: none;
}
.radio-container input:checked + label {
  background: linear-gradient(180deg, #0db6fc, #00a0e3);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.radio-container input:checked + label svg #border {
  stroke: url(#gradient);
  stroke-dasharray: 145;
  stroke-dashoffset: 145;
  animation: checked 500ms ease forwards;
}
.radio-container input:checked + label svg #dot {
  transform: scale(1);
  transition: transform 500ms cubic-bezier(0.57, 0.21, 0.69, 3.25);
}

@keyframes checked {
  to {
    stroke-dashoffset: 0;
  }
}

.mb0{
    margin-bottom: 0px;
}
.mt10{
    margin-top: 10px;
}
#step2, #submitBtn{
    display: none;
}
@media screen and (max-width: 1030px){
    .flex-main {
        height: calc(100vh - 150px);
    }
}
@media screen and (max-width: 768px){
    .flex-main{
        flex-direction: column;
        height: unset;
        padding-bottom: 30px;
    }
    .left-sec {
        flex-basis: 100%;
        padding-left: 00px;
        text-align: center;
        width: 100%;
        padding-top: 30px
    }
    .right-sec{
        flex-basis: 100%;
        width: 100%;
    }
    .ls-box-shadow{
        max-width: unset;
        width: auto;
    }
    .ls-divider{
        margin: 0 auto;
    }
    .el-icons-flex{
        justify-content: center;
        flex-wrap: wrap;
    }
    .el-icons{
        margin: 10px 15px 0 15px;
    }
    .admission-form{
        min-height: unset;
        
    }
}
@media screen and (max-width: 500px){
    .left-sec h2{
        font-size: 22px;
        line-height: 32px;
    }
    .left-sec h2 span{
        font-size: 30px;
    }
}
');
?>
<script>
    let nextBtn = document.getElementById('nextBtn');
    nextBtn.onclick = function () {
        let step1 = document.getElementById('step1');
        let step2 = document.getElementById('step2');
        let headingText = document.getElementById('headingText');
        let submitBtn = document.getElementById('submitBtn');

        let stepActive = document.getElementsByClassName('stepActive');
        if (stepActive.length == 1){
            step1.style.display = "block";
            step2.style.display = "none";
            step2.classList.remove('stepActive');

            submitBtn.style.display = "none";
            nextBtn.innerHTML = "Next";
            headingText.innerHTML = "Fill Me For Your Bright Future";
        }else{
            step1.style.display = "none";
            step2.style.display = "block";
            step2.classList.add('stepActive');

            submitBtn.style.display = "block";
            headingText.innerHTML = "Please Sign Up";
            nextBtn.innerHTML = "Previous";

        }
    }
</script>
