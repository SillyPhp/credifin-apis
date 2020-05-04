<?php

use yii\helpers\Url;

?>
<section>
    <div class="row">
        <div class="w3-sidebar w3-bar-block w3-light-grey w3-card stepsList">
            <h5 class="quiz-heading pl10">Steps To Create Quiz</h5>
            <button class="w3-bar-item w3-button steps-btn tablink btn-primary active" value="#step-1">Group</button>
            <button class="w3-bar-item w3-button steps-btn tablink" value="#step-2" disabled="disabled">Subject</button>
            <button class="w3-bar-item w3-button steps-btn tablink" value="#step-3" disabled="disabled">Topic</button>
            <button class="w3-bar-item w3-button steps-btn tablink" value="#step-4" disabled="disabled">Introduction</button>
            <button class="w3-bar-item w3-button steps-btn tablink" value="#step-5" disabled="disabled">Questions</button>
            <button class="w3-bar-item w3-button steps-btn tablink payLink" value="#step-6" disabled="disabled">Rules</button>
        </div>
        <div class="ml250">
            <form role="form">
                <div class="row setup-content" id="step-1">
                    <div class="col-md-12">
                        <div id="Group" class="w3-container steps">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="quiz-heading">Create New Group or Choose One Below</h2>
                                    <div class="quiz-top">
                                        <input type="text" placeholder="Enter Group Name" class="topic-input" id="groupInput">
                                        <button type="button" onclick="creteGroup()"><i class="fa fa-share"></i></button>
                                    </div>
                                </div>
                            </div>
                            <h2 class="quiz-heading">Select Group</h2>
                            <div class="row" id="group-row">
                                <div class="col-md-2">
                                    <label class="radioLabel">
                                        <input type="radio" name="group" value="small" class="customRadio">
                                        <div class="quiz-group-box">
                                            <div class="quiz-class">9th</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radioLabel">
                                        <input type="radio" name="group" value="small" class="customRadio">
                                        <div class="quiz-group-box">
                                            <div class="quiz-class">10th</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radioLabel">
                                        <input type="radio" name="group" value="small" class="customRadio">
                                        <div class="quiz-group-box">
                                            <div class="quiz-class">+1</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radioLabel">
                                        <input type="radio" name="group" value="small" class="customRadio">
                                        <div class="quiz-group-box">
                                            <div class="quiz-class">+2</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radioLabel">
                                        <input type="radio" name="group" value="small" class="customRadio">
                                        <div class="quiz-group-box">
                                            <div class="quiz-class">JEE</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radioLabel">
                                        <input type="radio" name="group" value="small" class="customRadio">
                                        <div class="quiz-group-box">
                                            <div class="quiz-class">IEEE</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="step-next-btn">
                                    <button class="btn btn-primary btn-md nextBtn pull-right" type="button" >Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-2">
                    <div id="Subject" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Search or Create Subject</h2>
                                <div class="quiz-top">
                                    <form>
                                        <input type="text" placeholder="Enter Subject Name" class="topic-input">
                                        <button type="button" onclick="nextStep()"><i class="fa fa-share"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="quiz-heading">Select Subject</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="radioLabel">
                                    <input type="radio" name="subject" value="small" class="customRadio">
                                    <div class="quiz-group-box">
                                        <div class="quiz-subject">Maths</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radioLabel">
                                    <input type="radio" name="subject" value="small" class="customRadio">
                                    <div class="quiz-group-box">
                                        <div class="quiz-subject">English</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radioLabel">
                                    <input type="radio" name="subject" value="small" class="customRadio">
                                    <div class="quiz-group-box">
                                        <div class="quiz-subject">Physics</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radioLabel">
                                    <input type="radio" name="subject" value="small" class="customRadio">
                                    <div class="quiz-group-box">
                                        <div class="quiz-subject">Computer Science</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radioLabel">
                                    <input type="radio" name="subject" value="small" class="customRadio">
                                    <div class="quiz-group-box">
                                        <div class="quiz-subject">Data Structure and Algorithms</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radioLabel">
                                    <input type="radio" name="subject" value="small" class="customRadio">
                                    <div class="quiz-group-box">
                                        <div class="quiz-class">Accountancy</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="step-next-btn">
                                <button class="btn btn-primary btn-md nextBtn pull-right" type="button" >Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-3">
                    <div id="Topic" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Select Topic</h2>
                                <div class="quiz-top">
                                    <form>
                                        <input type="text" placeholder="Enter Topic" class="topic-input">
                                        <button type="button" onclick="nextStep()"><i class="fa fa-share"></i></button>
                                    </form>
                                </div>
                                <div class="previous-topics">
                                    <h2 class="quiz-heading">Recommendation</h2>
                                    <ul>
                                        <li class="topicList">Tokyo is the capital of Japan.</li>
                                        <li class="topicList">It is the center of the Greater Tokyo Area</li>
                                        <li class="topicList">Tokyo is the capital of Japan.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="previous-topics">
                                    <h2 class="quiz-heading">Previous Topics</h2>
                                    <ul>
                                        <li class="topicList">Tokyo is the capital of Japan.</li>
                                        <li class="topicList">It is the center of the Greater Tokyo Area</li>
                                        <li class="topicList">Tokyo is the capital of Japan.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="step-next-btn">
                                <button class="btn btn-primary btn-md nextBtn pull-right" type="button" >Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-4">
                    <div id="Introduction" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Introduction To Quiz</h2>
                                <p class="recom-charac">Minimum 300 characters recommended</p>
                                <div class="quiz-intro">
                                    <textarea class="quiz-intro-textarea" placeholder="Enter Quiz Intro"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="previous-topics">
                                    <h2 class="quiz-heading">Previous Introductions</h2>
                                    <ul>
                                        <li class="topicList">Tokyo is the capital of Japan.</li>
                                        <li class="topicList">It is the center of the Greater Tokyo Area</li>
                                        <li class="topicList">Tokyo is the capital of Japan.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="step-next-btn">
                                <button class="btn btn-primary btn-md nextBtn pull-right" type="button" >Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-5">
                    <div id="Questions" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Enter Questions And Choose Correct Answer</h2>
                                <div class="quiz-ques">
                                    <div class="quiz-textarea">
                                        <textarea placeholder="Enter Question" class="ques-input"></textarea>
                                    </div>
                                    <div class="dis-flex">
                                        <textarea placeholder="Enter Option" class="ques-input max300"></textarea>
                                        <label class="checkbox-container correctAns">
                                            <input type="radio" name="answer" class="ca-ans">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p class="ca-message"></p>
                                    </div>
                                    <div class="dis-flex">
                                        <textarea placeholder="Enter Option" class="ques-input max300"></textarea>
                                        <label class="checkbox-container correctAns">
                                            <input type="radio" name="answer" class="ca-ans">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p class="ca-message"></p>
                                    </div>
                                    <div class="dis-flex">
                                        <textarea placeholder="Enter Option" class="ques-input max300"></textarea>
                                        <label class="checkbox-container correctAns" value="">
                                            <input type="radio" name="answer" class="ca-ans">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p class="ca-message"></p>
                                    </div>
                                    <div class="dis-flex">
                                        <textarea placeholder="Enter Option" class="ques-input max300"></textarea>
                                        <label class="checkbox-container correctAns">
                                            <input type="radio" name="answer" class="ca-ans">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p class="ca-message"></p>
                                    </div>
                                    <div class="quiz-button-flex">
                                        <button type="button">Create Question</button>
                                        <button type="button" onclick="finishQuiz()">Finish Quiz</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Questions Created</h2>
                                <div class="card">
                                    <div class="card-header" role="tab" id="quesThree">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseOne" class="collapsed flex2">
                                            <div class="q1">
                                                <div class=""><span>Q:</span>Lorem Ipsum is simply dummy text of the printing and
                                                    typesetting industry. Lorem Ipsum has
                                                </div>
                                            </div>
                                        </a>
                                        <span class="btnedit"><i class="fa fa-pencil"></i></span>
                                        <span class="btndelete"><i class="fa fa-trash-o"></i></span>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseOne" class="collapsed"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="quesThree" aria-expanded="false">
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
                </div>
                <div class="row setup-content" id="step-6">
                    <div id="Rules" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="quiz-heading">Quiz Rules</h2>
                                <div class="payment-text">Total Marks Quiz</div>
                                <div class="pay-input">
                                    <input type="text" placeholder="Enter Marks">
                                </div>
                                <div class="payment-text">Quiz Time Duration </div>
                                <div class="pay-input">
                                    <input type="text" placeholder="Enter Marks">
                                </div>
                                <div class="payment-text">Marks for every Correct answer </div>
                                <div class="pay-input">
                                    <input type="text" placeholder="Enter Marks">
                                    <span><i class="fa fa-plus"></i></span>
                                </div>
                                <div class="payment-text">Marks for every Wrong answer </div>
                                <div class="pay-input">
                                    <input type="text" placeholder="Enter Marks">
                                    <span><i class="fa fa-minus"></i></span>
                                </div>
                                <div class="payment-text">Would you like to charge students for this quiz</div>
                                <div class="pay-btns">
                                    <button type="button" onclick="showPatment()"> Yes</button>
                                    <button type="button" onclick="createQuiz()"> No</button>
                                </div>
                                <div id="payment-details">
                                    <div class="pay-form">
                                        <div class="pay-input">
                                            <input type="text" placeholder="Enter Amount">
                                            <span><i class="fa fa-inr"></i></span>
                                        </div>
                                        <div class="pay-btns">
                                            <button type="button" onclick="createQuiz()">Create Quiz</button>
                                        </div>
                                    </div>
                                    <div class="note-text">
                                        <span>Note: </span> We Charge 20% as maintenance charges
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div id="shareQuizModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <div class="qModal">
            <h2>Share Quiz</h2>
            <div class="qm-logo">
                <img src="/assets/themes/ey/images/pages/candidate-profile/Girls2.jpg" alt="">
            </div>
            <p class="qm-name">Quiz on human ethics</p>
            <p>If someone plays this quiz through this link, It will earn you 20 extra credits</p>
            <h4>Share on</h4>
            <ul class="qshare">
                <li><a href=""><i class="fa fa-facebook-f"></i></a> </li>
                <li><a href=""><i class="fa fa-twitter"></i></a> </li>
                <li><a href=""><i class="fa fa-instagram"></i></a> </li>
                <li><a href=""><i class="fa fa-whatsapp"></i></a> </li>
            </ul>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.quiz-textarea textarea{
    height: 100px;
    resize: none;
}
.quiz-button-flex{
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
}
#payment-details{
    display: none;
}
.recom-charac{
    margin: 0;
    font-size: 12px;
}
.note-text{
    background: #F8F8F8;
    max-width: 400px;
    padding: 18px 0;
    font-size: 16px;
    font-family: lora;
    text-transform: capitalize;
}
.note-text span{
    background: #eee;
    padding: 20px;
    margin-right: 10px;
}
.pay-input{
    max-width: 400px;
     border:1px solid #eee;
     position: relative;
     margin-bottom: 10px;
}
.pay-input span{
    position: absolute;
    right:0;
    top:0;
    padding:8px 15px;
    color:#fff;
    background: #00a0e3;
}
.pay-input input{
    width: 100%;
    border:none;
    padding: 8px 10px; 
}
.radioLabel{
    width: 100%;
}
.customRadio { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}
.customRadio + .quiz-group-box {
  cursor: pointer;
     text-align: center;
    width: 100%;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    min-height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: 20px;
    padding: 5px;
}
.customRadio:checked ~ .quiz-group-box {
    background: #00a0e3;
    color: #fff;
    transition: .3s ease;
    cursor: pointer;
}
.pl10{
    padding-left: 10px;
}
.quiz-heading{
    font-size: 20px;
    font-family: lora;
    margin-top: 40px;
}
.dis-flex{
    display: flex;
}
.dis-flex textarea{
    height: 60px;
    resize: none;
}
.quiz-ques{
    display: flex;
    flex-direction: column;
}
.ques-input{
//    max-width: 400px;
    width: 100%;
    border:1px solid #eee;
    padding: 8px 10px;
    margin-bottom: 10px;
    overflow-wrap: break-word;
}
.max300{
    max-width: 400px;
}
.quiz-ques button, .quiz-intro button, .pay-btns button{
    max-width: 200px;
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 10px 0;
}
.quiz-ques button{
    padding: 10px 15px;
}
.quiz-ques button, .pay-btns button{
    margin-bottom: 10px;
}
.pay-btns{
    margin: 10px 0;
}
.pay-btns button{
    margin-right: 10px;
    
      padding: 10px 15px;
}
.quiz-intro button{
    padding: 10px 15px;
    float:right;
    margin-left: 10px;
}
.quiz-intro-textarea{
    height: 180px;
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #eee;
    resize: none;
}
.previous-topics ul{
    list-style: none;
    padding: 0;
    border-top: 1px solid #eee;
}
.previous-topics ul li{
    padding: 8px 10px;
}
.previous-topics ul li:nth-child(even){
    background: #f2f2f2
}
.quiz-top, .quiz-search{
    width:100%;
    border:1px solid #eee;
}
.quiz-top button, .quiz-search button{
    padding: 8px 14px;
    border: none;
    background: #00a0e3;
    color: #fff;
    float: right;
}
.quiz-top button i{
    transform: rotate(180deg);
}
.topic-input{
    width: 89%;
    padding:8px 10px;
//     border:1px solid #eee;
    border:transparent;
}

.quiz-class{
    font-size: 20px;
    font-family: lora; 
}
.quiz-subject{
    font-size: 18px;
    font-family: lora;
}
.qc-heading{
    margin-top: 30px;
}
.copyright{
    display: none;
}
.container-fluid{
    padding-left: 0px;
    padding-right: 0px;
}
.page-content{
    padding: 30px 15px !important;
}
.position-rel{
    position: relative;
    max-width: 200px;
}
.ml250{
       margin-left: 200px;
    padding: 0 50px;
}
.w3-sidebar{
    height:100%;
    width:200px;
    background-color:#fff;
    position:fixed!important;
    z-index:1;
    overflow:auto
}
.w3-light-grey, .w3-hover-light-grey:hover, .w3-light-gray, .w3-hover-light-gray:hover {
    color: #000!important;
    background-color: #f8f8f8!important;
}
.w3-bar-block .w3-bar-item {
    width: 100%;
    padding: 8px 16px;
    text-align: left;
    border: none;
    white-space: normal;
    float: none;
    outline: 0;
}
.w3-btn, .w3-button {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.w3-btn, .w3-button {
    padding: 8px 16px;
    vertical-align: middle;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    background-color: inherit;
    text-align: center;
    cursor: pointer;
    white-space: nowrap;
}
.active{
    background: #00a0e3;
    color: #fff;
}
.w3-padding {
    padding: 8px 16px!important;
}
.w3-container, .w3-panel {
    padding: 0.01em 16px;
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
.topicList:hover{
    cursor: pointer;
}
.payment-text{
    font-family: lora;
    font-size: 18px;
}
.payLink{
    display:none;
}
.ca-message{
    margin: 10px 0 0 20px;
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
.flex2{
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
  margin:5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
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

//steps form
.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
.step-next-btn
{
margin-top:40px;
}
.steps-btn{
float:left !important;
text-decoration: none;
}
button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}
');
?>
<?php
$script = <<< JS
$('#groupInput').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		creteGroup();
	}
});
//steps form
var navListItems = $('.steps-btn'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();
    $('#step-1').show();
    navListItems.click(function (e) {
        e.preventDefault();
        var target = $($(this).attr('value')), 
                item = $(this);

        if (!item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default'); 
            item.addClass('btn-primary');
            allWells.hide();
            target.show();
            target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('.stepsList button[value="#' + curStepBtn + '"]').next(),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

