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

                <p>Online Admission</p>
                <h2>Get Noticed By Your <br><span>Dream Colleges</span> <br>Without Any Hassle</h2>
                <div class="ls-divider"></div>
                <h4>Enjoy The Benefits Of Interest Free <span class="colorOrange">Education Loans</span></h4>
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
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/upto-2lakhs.png')?>">
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
                    <p>Fill Me For Your Bright Future</p>
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name">

                            <input type="text" class="form-control" placeholder="Last Name">

                            <input type="email" class="form-control" placeholder="Email">

                            <input type="tel" class="form-control" placeholder="Contact Number">

                            <input type="text" class="form-control" placeholder="Course Name">

                            <div class="button-form">
                                <button type="submit" class="btn-frm" name="submit button">Submit</button>
                            </div>
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
    padding: 30px 20px 50px;
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
    width: 80%;
    padding: 12px 12px;
    background-color: #fff;
    border: 1px solid #c2cad8;
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
}
.btn-frm{
    width:100px;
    height:40px;
    background-color: #00a0e3;
    border: 0px solid #c2cad8;
    color: #fff;
    border-radius: 6px;
}
.btn-frm:hover{
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
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
        order: 2;
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