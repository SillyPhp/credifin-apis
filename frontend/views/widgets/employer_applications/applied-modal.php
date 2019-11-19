<?php

use yii\helpers\Url;

?>
<section>
    <div id="appliedModal" class="appliedModal">
        <!-- Modal content -->
        <div class="appliedModal-content">
            <span class="applied-close" data-dismiss="modal">&times;</span>
            <div class="appcon-center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6 col-sm-6">
                            <div class="appliedPic">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/exciting.png') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="applied-heading">
                                <h2>How Exciting!</h2>
                            </div>
                            <div class="applied-text">You just applied for a job on Empower Youth, High fives all
                                rounds!
                                Here's hoping you get selected.
                            </div>
                            <div class="applied-btns">
                                <ul>
                                    <li>
                                        <a href="/<?= Yii::$app->user->identity->username . '/edit' ?>">Update
                                            Profile</a>
                                    </li>
                                    <li>
                                        <a href="<?= "/account/jobs/applied" ?>">View Application</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
$this->registerCss('
.appliedPic img{
    max-width:300px;
    width: 100%;
}
.applied-btns ul li{
    display:inline;
}
@media only screen and (min-width: 1400px){
    .appliedPic img{
        max-width:500px;
        width: 100%;
    }
}
@media only screen and (max-width: 992px){
    .applied-btns ul li{
        display: block;
        margin-bottom: 39px;
    }  
}
@media only screen and (max-width: 767px){
    .appliedPic img{
        max-width:100px;
        width: 100%;
    }    
    .applied-btns ul li{
        display: block;
        margin-bottom: 39px;
    }
}
.applied-btns{
    margin-top:40px;
}
.applied-btns a{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-left: 5px;
    background: #fff;
}
.applied-btns a:hover{
    background-color: #00a0e3;
    color: #fff;
}
.applied-heading h2{
    color: #e67f31;
}
.applied-abso-btn{
    position:absolute;
    bottom:8px;
    right:15px;
}
.applied-abso-btn a{
    color:#000;
}
.applied-abso-btn a:hover{
    color:#00a0e3;
}
.appliedModal {
  display: none;
  position: fixed;
  z-index: 99999;
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%;
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4);
}
.applied-text{
    max-width: 350px;
    margin: 0 auto;
    font-size: 17px;
}
#myBtn{
    margin-top:150px;
}
/* Modal Content/Box */
.appliedModal-content {
    background-color: #fefefe;
    margin: 10vh auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    height: 75%;
    text-align:center;
    position:relative;
}
.appcon-center{
    position:absolute;
    top:50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width:100%;
}
/* The Close Button */
.applied-close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  position:absolute;
  top:-8px;
  right:8px;
}
.applied-close:hover,
.applied-close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
');
?>
