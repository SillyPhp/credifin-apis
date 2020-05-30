<?php

use yii\helpers\Url;

?>
<!--Accordion wrapper-->
<div class="row">
    <div class="col-md-12">
        <div class="quiz-name">
            <div class="quiz-title">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                <span class="btninfo"><i class="fa fa-pencil"></i></span>
            </div>
            <div class="q-flex">
                <div class="qm-logo">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                </div>
                <div class="f2">
                    <div class="quiz-details">
                        <p><span>Total Questions:</span> 5</p>
                        <p><span>Group:</span> 9th</p>
                        <p><span>Subject:</span> GK</p>
                    </div>
                    <div class="quiz-details">
                        <p><span>Last Edited:</span> 20-09-2019</p>
                        <p><span>Total Played:</span> 100</p>
                        <p><span>Total Earnings:</span> <i class="fa fa-inr"></i> 2000</p>
                    </div>

                </div>
            </div>


            <div class="quiz-info">
                <p><span>Introduction:</span> Tokyo is the capital of Japan. It is the center of the Greater Tokyo Area
                </p>
            </div>
            <div class="quiz-btn">
                <button type="button" onclick="openEditModal()" class="btnadd">Add New Question</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" role="tab" id="headingThree">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false"
                       aria-controls="collapseOne" class="collapsed flex2">
                        <div class="q1">
                            <div class=""><span>Q:</span> Capital Of India</div>
                        </div>
                    </a>
                    <span class="btnedit"><i class="fa fa-pencil"></i></span>
                    <span class="btndelete"><i class="fa fa-trash-o"></i></span>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false"
                       aria-controls="collapseOne" class="collapsed"><i class="fa fa-plus"></i></a>
                </div>
                <div id="collapseSix" class="collapse" role="tabpanel" aria-labelledby="headingThree"
                     aria-expanded="false">
                    <div class="card-block">
                        <div class="q-ans">
                            <ul>
                                <li>Ludhiana</li>
                                <li class="correct">Delhi</li>
                                <li>Mumbai</li>
                                <li>Jalandhar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" role="tab" id="quesTwo">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                       aria-controls="collapseOne" class="collapsed flex2">
                        <div class="q1">
                            <div class=""><span>Q:</span> Capital Of India</div>
                        </div>
                    </a>
                    <span class="btnedit"><i class="fa fa-pencil"></i></span>
                    <span class="btndelete"><i class="fa fa-trash-o"></i></span>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                       aria-controls="collapseOne" class="collapsed minus"><i class="fa fa-plus"></i></a>
                </div>
                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="quesTwo"
                     aria-expanded="false">
                    <div class="card-block">
                        <div class="q-ans">
                            <ul>
                                <li>Ludhiana</li>
                                <li class="correct">Delhi</li>
                                <li>Mumbai</li>
                                <li>Jalandhar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" role="tab" id="quesThree">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                       aria-controls="collapseOne" class="collapsed flex2">
                        <div class="q1">
                            <div class=""><span>Q:</span>Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has
                            </div>
                        </div>
                    </a>
                    <span class="btnedit"><i class="fa fa-pencil"></i></span>
                    <span class="btndelete"><i class="fa fa-trash-o"></i></span>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                       aria-controls="collapseOne" class="collapsed"><i class="fa fa-plus"></i></a>
                </div>
                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="quesThree"
                     aria-expanded="false">
                    <div class="card-block">
                        <div class="q-ans">
                            <ul>
                                <li>Ludhiana</li>
                                <li class="correct">Delhi</li>
                                <li>Mumbai</li>
                                <li>Jalandhar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editQuesModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="">
            <h2 class="quiz-heading">Update Question</h2>
            <div class="quiz-ques">
                <div class="">
                    <input type="text" placeholder="Enter Question" class="ques-input">
                </div>
                <div class="dis-flex max400">
                    <input type="text" placeholder="Enter Option" class="ques-input">
                    <label class="checkbox-container correctAns">
                        <input type="radio" name="answer" class="ca-ans">
                        <span class="checkmark"></span>
                    </label>
                    <p class="ca-message"></p>
                </div>
                <div class="dis-flex max400">
                    <input type="text" placeholder="Enter Option" class="ques-input">
                    <label class="checkbox-container correctAns">
                        <input type="radio" name="answer" class="ca-ans">
                        <span class="checkmark"></span>
                    </label>
                    <p class="ca-message"></p>
                </div>
                <div class="dis-flex max400">
                    <input type="text" placeholder="Enter Option" class="ques-input">
                    <label class="checkbox-container correctAns" value="">
                        <input type="radio" name="answer" class="ca-ans">
                        <span class="checkmark"></span>
                    </label>
                    <p class="ca-message"></p>
                </div>
                <div class="dis-flex max400">
                    <input type="text" placeholder="Enter Option" class="ques-input">
                    <label class="checkbox-container correctAns">
                        <input type="radio" name="answer" class="ca-ans">
                        <span class="checkmark"></span>
                    </label>
                    <p class="ca-message"></p>
                </div>
                <button type="button">Update Question</button>
            </div>
        </div>
    </div>
</div>
<div id="editQuizInfo" class="modal">
    <div class="modal-content">
        <span class="closeInfo">&times;</span>
        <div class="row max800">
            <div class="col-md-12">
                <div class="updateInfo">
                    <div class="pos-rel">
                        <label class="text-bold">Quiz Name</label>
                    </div>
                    <input type="text" placeholder="" class="ques-input">
                </div>
            </div>
            <div class="col-md-6">
                <div class="updateInfo">
                    <div class="pos-rel">
                        <label class="text-bold">Group</label>
                    </div>
                    <input type="text" placeholder="" class="ques-input max200">
                </div>
            </div>
            <div class="col-md-6">
                <div class="updateInfo">
                    <div class="pos-rel">
                        <label class="text-bold">Subject</label>
                    </div>
                    <input type="text" placeholder="" class="ques-input max200">
                </div>
            </div>
            <div class="col-md-12">
                <div class="updateInfo">
                    <div class="pos-rel">
                        <label class="text-bold">Intoduction</label>
                    </div>
                    <textarea placeholder="" class="ques-input max200"></textarea>
                </div>
            </div>
            <button type="button" class="ui-btn">Update Information</button>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.max800{
    max-width: 800px;
    margin: 0 auto;
}
.ui-btn{
    padding: 10px 15px; 
    background: #00a0e3;
    color: #fff;
    border: none;
}
.ui-btn:hover{
    box-shadow: 0 0 8px rgba(0,0,0,.3);
    transition: .3s ease;
}
.q-flex{
    display: flex;
    padding: 20px
}
.qm-logo{
    max-width:100px;
    max-height: 100px;    
    margin: 0 auto;
}
.qm-logo img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 10px;
}

.card {
    -moz-box-direction: normal;
    -moz-box-orient: vertical;
    background-color: #fff;
    border-radius: 0.25rem;
    display: flex;
    flex-direction: column;
    position: relative;
    margin-bottom:20px;
    border:none;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
}
.card-header:first-child {
    border-radius: 0;
}

.card-header {
    background-color: #f7f7f9;
    margin-bottom: 0;
    padding: 10px 1.25rem;
    border: none;
    display: flex;
    
}
.card-header i{      
    font-size:17px;
    margin-top:15px;
    margin-right:10px;
}
.flex2, .f2{
    flex:2;
}
.card-header a{
    float:left;
    color:#333;
}
.card-header a:focus{
    text-decoration: none;
}
.card-header p{
    margin:0;
}

.card-header h3{
    margin:0 0 0px;
    font-size:20px;
    font-family: lora
    font-weight:bold;
    color:#3fc199;
}
.card-block {
    -moz-box-flex: 1;
    flex: 1 1 auto;
    padding: 20px;
    color:#232323;
    border-radius:0;
}

/*-----------*/
.quiz-title{
  background: #f8f8f8;
    color: #000;
    padding: 10px 15px;
    font-size: 18px;
    font-family: lora;
    display: flex;
    align-items: center;
}
.quiz-title p{
    margin: 10px 0;
    flex: 2;
}
.btnadd{
    padding: 12px 18px;
    background: #00a0e3;
    color: #fff;
    border: none;   
}
.btndelete{
    background: transparent;
    color: #333333;
    border: none;
    font-size: 12px;
}
.quiz-name{
    margin-top: 20px;
}
.quiz-details{
    display: flex;
    justify-content: flex-start;
    padding: 10px 15px 0;
    align-content: center;
}
.quiz-details p{
    margin:10px 0;
    flex:1
}
.quiz-details p span, .quiz-info p span{
    font-weight: bold;
}
.quiz-info{
   padding: 10px 15px; 
}
.quiz-btn{
    text-align: center;
    padding: 10px 0;
}
.questionbox, .quiz-name{
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    margin-bottom: 25px;
}
.q-ans ul{
    padding-inline-start: 0px;
    list-style: none;
}
.q1{
    background: #f8f8f8;
    color: #000;
    padding: 10px 0px;
    font-size: 18px;
    font-family: lora;
    display: flex;
    justify-content: space-between
}
.q-ans{
    background: #fff;
    padding: 10px 0px;
    font-family: roboto;
}
.q-ans ul li{
    padding: 5px 0px;
    font-family: roboto;
    border: 1px solid #eee;
    padding: 10px;
}
.correct{
    color: #fff;
    background: #00a0e3;
    border-color: #00a0e3;
}
.btnedit, .btninfo{
    background: transparent;
    color: #333333;
    border: none;
    padding: 0px 0px;
    font-size: 12px;
}
.btninfo{
    font-size: 16px;
}
.btnedit:hover, .btninfo:hover{
    cursor: pointer;
    color: #00a0e3;
}
textarea{
    resize: none;   
}
/*-------modal ----------*/
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 10px; /* Location of the box */
  left: 0;
  top: 100px;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: scroll; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin:0 auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  text-align: center;

}

/* The Close Button */
.close, .closeInfo {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 10px;
  right: 10px
}

.close:hover,
.closeInfo:hover,
.close:focus,
.closeInfo:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

/*---- */
.quiz-heading{
    font-size: 20px;
    font-family: lora;
    margin-top: 40px;
}
.dis-flex{
    display: flex;
    justify-content: center;
}
.max400{
    max-width: 400px;
    margin: 10px auto;
}

.quiz-ques{
    display: flex;
    flex-direction: column;
}
.ques-input{
//    width: 600px;
    width: 100%;
    border:1px solid #eee;
    padding: 8px 10px;
    margin-bottom: 10px;
    overflow-wrap: break-word;
}
.quiz-ques button, .quiz-intro button, .pay-btns button{
    max-width: 200px;
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 10px ;
    margin: 0 auto;
}
.checkbox-container {
  display: block;
  position: relative;
  margin: 6px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
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
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  border: 2px solid #eee;
}

/* On mouse-over, add a grey background color */

/* When the checkbox is checked, add a blue background */
.checkbox-container input:checked ~ .checkmark, .checkbox-container input:hover ~ .checkmark {
  background-color: #2196F3;
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.checkbox-container input:checked ~ .checkmark:after{
  display: block;
}

/* Style the checkmark/indicator */
.checkbox-container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.correctAnswer{
   color: #00a0e3;
    border: 1px solid #00a0e3;
}
.pos-rel{
    position: relative;
}
.pos-rel label{
    font-weight: bold;

}
');
$script = <<< JS

JS;
$this->registerJS($script);
?>
<script>
    //getting buttons
    let editBtn = document.getElementsByClassName('btnedit');
    let infoBtn = document.querySelector('.btninfo')

    //getting modals
    let modal = document.getElementById("editQuesModal");
    let infoModal = document.getElementById("editQuizInfo");

    for (let i = 0; i < editBtn.length; i++) {
        editBtn[i].addEventListener('click', openEditModal);
    }

    function openEditModal() {
        modal.style.display = "block";

    }

    infoBtn.addEventListener('click', openInfoModal);

    function openInfoModal() {
        infoModal.style.display = 'block';
    }

    var span = document.querySelector(".close");
    span.onclick = function () {
        modal.style.display = "none";
    }
    var closeInfo = document.querySelector(".closeInfo");
    closeInfo.onclick = function () {
        infoModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == infoModal) {
            infoModal.style.display = "none";
        }
    }
</script>