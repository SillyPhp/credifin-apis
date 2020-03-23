<?php
use yii\helpers\Url;
?>
<section class="virus-bg">
    <div class="virus-icons">
        <img src="<?= Url::to('@eyAssets/images/pages/college/coronavi.png') ?>">
    </div>
    <div class="virus-icon-left">
        <img src="<?= Url::to('@eyAssets/images/pages/college/coronavi.png') ?>">
    </div>
    <div class="container">
        <div class="onlineClasses">
            <div class="online-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/college/online-class.png') ?>">
            </div>
            <div class="online-content">
                <p class="oc-sub-heading">Protecting Education against Corona Virus</p>
                <p class="oc-text">We at Empower Youth are transforming your physical classroom to digital and taking
                    it online so the education of child is not hampered</p>
                <div class="oc-text-icons">
                    <div class="collegeSignupModal">
                        <span>
                            <img src="<?= Url::to('@eyAssets/images/pages/college/school-icon.png')?>" class="hoverHide">
                            <img src="<?= Url::to('@eyAssets/images/pages/college/school-icon-white.png')?>" class="hoverShow">
                        </span>
                        <p>Schools</p>
                    </div>
                    <div class="collegeSignupModal">
                        <span>
                            <img src="<?= Url::to('@eyAssets/images/pages/college/colg-icon.png')?>" class="hoverHide">
                            <img src="<?= Url::to('@eyAssets/images/pages/college/colg-icon-white.png')?>" class="hoverShow">
                        </span>
                        <p>Universities & Colleges</p>
                    </div>
                    <div class="collegeSignupModal">
                        <span>
                            <img src="<?= Url::to('@eyAssets/images/pages/college/educational-institute.png')?>" class="hoverHide">
                            <img src="<?= Url::to('@eyAssets/images/pages/college/educational-institute-white.png')?>" class="hoverShow">
                        </span>
                        <p>Educational Institutes</p>
                    </div>
                </div>
                <div class="oc">
                    <button type="button" class="collegeSignupModal">Join The Movement</button>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="virusModal" class="collegeSignUpmodal">

    <!-- Modal content -->
    <div class="college-modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <div class="col-md-6">
                <div class="cmc-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/college/online-class-white.png')?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="csu-heading">Join the movement today</div>
                <form class="mx-600">
                    <div class="uname">
                        <div class="form-group field-username required">
                            <input type="text" id="username" class="uname-in" name="username" autofocus=""
                                   autocomplete="off" placeholder="Full Name" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="uname">
                        <div class="form-group field-username required">
                            <input type="text" id="collegeName" class="uname-in" name="collegeName" autofocus=""
                                   autocomplete="off" placeholder="Organization Name" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="uname">
                        <div class="form-group field-username required">
                            <input type="text" id="position" class="uname-in" name="position" autofocus=""
                                   autocomplete="off" placeholder="Designation" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="uname">
                        <div class="form-group field-username required">
                            <input type="text" id="email" class="uname-in" name="email" autofocus=""
                                   autocomplete="off" placeholder="Email" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="uname">
                        <div class="form-group field-username required">
                            <input type="text" id="phone" class="uname-in" name="phone" autofocus=""
                                   autocomplete="off" placeholder="Phone Number" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="uname checkBox-padding">
                        <div class="form-group field-username required">
                            <label class="checkbox-container">Campus Placement
                                <input type="checkbox" checked="checked">
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkbox-container">Online Classes
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkbox-container">Hiring
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-oc">
                        <button type="submit"> Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php

$this->registerCss('
.virus-bg{
    position: ralative;
    overflow: hidden;
    background:#eee ;
    background-size: contain;
    padding:30px 0 50px 0;
}
.virus-icons, .virus-icon-left{
    position: absolute;
}
.virus-icons{
    top:-150px; 
    right:-150px;
    max-width: 350px;
    opacity:.5;
}
.virus-icon-left{
    bottom: -100px;
    left: -100px;
    max-width:250px;
    opacity:.4;
}

.oc button, .modal-oc button{
    background: transparent;
    border: 1px solid #00a0e3;
    color:#00a0e3;
    padding:15px 20px;
    margin-top: 30px;
    text-transform: uppercase;
    font-family: roboto;
}
.modal-oc button{    
    margin-top: 0px;
    padding:10px 15px;
}
.oc button:hover, .modal-oc button:hover{
    background: #00a0e3;
    color:#fff;
    transition: .3s ease;
}
.oc-text-icons div span{
    position: relative;   
    display:inline-block;
}
.oc-text-icons div span .hoverShow{
    display: none;
    position: absolute;
    top:0;
    left:0;
    z-index:99;
}
.oc-text-icons div:hover  span .hoverShow{
    display: inline;
    transition: 0.2s ease;
}
.oc-text-icons div:hover  span .hoverHide{
    display: hidden;
}
.oc-text-icons div{
    flex-basis: 200px;
    text-align: center;
     box-shadow:0 0 10px rgba(0,0,0,.1);
    margin:10px 10px 0 0;
    padding:10px 10px 5px 10px;
    border-radius: 10px;
} 
.oc-text-icons div:hover{
    background:#00a0e3;
    color:#fff;
    transition:.3s ease;
    cursor: pointer;
}
.oc-text-icons p{
    font-size:16px; 
    padding-top: 5px;
    font-family: roboto;
    line-height:20px;
}
.oc-text-icons{
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}

.onlineClasses{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.oc-text{
    font-size: 18px;
    font-family: roboto;
    color: #333;
}
.online-content{
    flex-basis:60%;
    margin-left: 40px;
}
.online-icon{
    text-align:center;
    flex-basis:30%
}
.oc-sub-heading{
   font-size: 30px;
    font-weight: 600;
    color: #000;
    font-family: lora;
    margin: 0px;
    text-transform: capitalize;
}
@media screen and (max-width:1200px){
    .onlineClasses{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        text-align:center;
    }
    .online-content{
        flex-basis:100%;
        margin-left: 40px;
    }
    .online-icon{
        text-align:center;
        flex-basis:100%
    }
    .online-icon img{
        max-width:250px;
    }
    .oc-text-icons{
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        justify-content: center;
    }
}
/*virus Modal*/
.collegeSignUpmodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0px;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
 z-index: 9999;
}

/* Modal Content/Box */
.college-modal-content {
    background: linear-gradient(to right, #00a0e3 50%, #fff 50%);
    position:absolute;
    top:50%;
    left:50%;
    transform: translate(-50%, -50%);
    text-align:center;  
    border-radius: 10px;
    width: 70%; /* Could be more or less, depending on screen size */
     padding:30px 0 30px 0;
     
     
}
.csu-heading{
    text-transform: capitalize;
    font-size:18px;
    color:#000;
    font-family: roboto;
}
/* The Close Button */
.close {
  position: absolute;
  top:10px;
  right: 10px;
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.checkbox-container {
  display: inline-block;
  position: relative;
  padding-left: 25px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 500;
  margin-right: 20px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cmc-icon{
    margin-top: 50px;
}
.checkBox-padding{
    padding: 0 50px !important;
    text-align: left !important;
}
/* Hide the browser\'s default checkbox */
.checkbox-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 4px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.checkbox-container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.checkbox-container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkbox-container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkbox-container .checkmark:after {
  left: 8px;
  top: 4px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.mx-600 .uname{
    padding: 10px 0 0px 0;
}
.mx-600 .uname-in {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 80%;
    font-size: 13px;
}
.mx-600 .form-group{
    margin-bottom: 5px;
}
@media screen and (max-width: 992px){
    .college-modal-content {
        background: linear-gradient(to right, #fff 50%, #fff 50%);
    }
    .cmc-icon {
        margin-top: 00px;
    }
    .cmc-icon img{
        max-width: 200px;
    }
}
');
?>
<script>
    var modal = document.getElementById("virusModal");
    // Get the button that opens the modal
    var btn = document.getElementsByClassName("collegeSignupModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    for(var i=0; i< btn.length; i++){
        btn[i].onclick = function () {
            modal.style.display = "block";
        }
    }
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
