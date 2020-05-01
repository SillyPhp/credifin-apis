<?php

use yii\helpers\Url;

?>
<section>
    <div class="row">
        <div class="w3-sidebar w3-bar-block w3-light-grey w3-card stepsList">
            <h5 class="quiz-heading pl10">Steps To Create Quiz</h5>
            <button class="w3-bar-item w3-button tablink active" onclick="openCity(event, 'Group')">Group</button>
            <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Subject')">Subject</button>
            <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Topic')">Topic</button>
            <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Introduction')">Introduction
            </button>
            <button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Questions')">Questions</button>
            <button class="w3-bar-item w3-button tablink payLink" onclick="openCity(event, 'Payment')">Payment</button>
        </div>

        <div class="ml250">
            <div id="Group" class="w3-container steps" style="display:none">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="quiz-heading">Search Or Create Group</h2>
                        <div class="quiz-top">
                            <form>
                                <input type="text" placeholder="Enter Group Name" class="topic-input type-group" id="groupInput">
                                <div class="type_load">
                                    <img src="https://gifimage.net/wp-content/uploads/2017/09/ajax-loader-gif-5.gif" width="35" height="35">
                                    <span class="text_load">Loading Results...</span>
                                </div>
                                <button type="button" onclick="creteGroup()"><i class="fa fa-share"></i></button>
                            </form>
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
            </div>

            <div id="Subject" class="w3-container steps" style="display:none">
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

            </div>

            <div id="Topic" class="w3-container steps" style="display:none">
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
            </div>

            <div id="Introduction" class="w3-container steps" style="display:none">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="quiz-heading">Introduction To Quiz</h2>
                        <p class="recom-charac">Minimum 300 characters recommended</p>
                        <div class="quiz-intro">
                            <textarea class="quiz-intro-textarea" placeholder="Enter Quiz Intro"></textarea>
                            <button type="button" onclick="nextStep()">Submit</button>
                            <button type="button" onclick="nextStep()">Skip</button>
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
            </div>

            <div id="Questions" class="w3-container steps" style="display:none">
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="quiz-heading">Enter Questions And Choose Correct Answer</h2>
                        <div class="quiz-ques">
                            <div class="">
                                <input type="text" placeholder="Enter Question" class="ques-input">
                            </div>
                            <div class="dis-flex">
                                <input type="text" placeholder="Enter Option" class="ques-input max200">
                                <label class="checkbox-container correctAns">
                                    <input type="radio" name="answer" class="ca-ans">
                                    <span class="checkmark"></span>
                                </label>
                                <p class="ca-message"></p>
                            </div>
                            <div class="dis-flex">
                                <input type="text" placeholder="Enter Option" class="ques-input max200">
                                <label class="checkbox-container correctAns">
                                    <input type="radio" name="answer" class="ca-ans">
                                    <span class="checkmark"></span>
                                </label>
                                <p class="ca-message"></p>
                            </div>
                            <div class="dis-flex">
                                <input type="text" placeholder="Enter Option" class="ques-input max200">
                                <label class="checkbox-container correctAns" value="">
                                    <input type="radio" name="answer" class="ca-ans">
                                    <span class="checkmark"></span>
                                </label>
                                <p class="ca-message"></p>
                            </div>
                            <div class="dis-flex">
                                <input type="text" placeholder="Enter Option" class="ques-input max200">
                                <label class="checkbox-container correctAns">
                                    <input type="radio" name="answer" class="ca-ans">
                                    <span class="checkmark"></span>
                                </label>
                                <p class="ca-message"></p>
                            </div>
                            <button type="button">Create Question</button>
                            <button type="button" onclick="finishQuiz()">Finish Quiz</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h2 class="quiz-heading">Questions Created</h2>
                        <div class="created-ques">
                            <div class="c-ques"><span>Q1:</span> Capital Of India</div>
                            <ul>
                                <li>Ludhiana</li>
                                <li>Delhi</li>
                                <li>Mumbai</li>
                                <li>Jalandhar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="Payment" class="w3-container steps" style="display: none">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="quiz-heading">Payment</h2>
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
                                    <button type="button" onclick="">Create Quiz</button>
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
    </div>


</section>
<?php
$this->registerCss('
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
.quiz-ques{
    display: flex;
    flex-direction: column;
}
.ques-input{
    width: 400px;
//    width: 100%;
    border:1px solid #eee;
    padding: 8px 10px;
    margin-bottom: 10px;
    overflow-wrap: break-word;
}
.max200{
    max-width: 200px;
}
.quiz-ques button, .quiz-intro button, .pay-btns button{
    max-width: 200px;
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 10px 0;
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

.typeahead,
.tt-query,
 {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}



.tt-hint {
  color: #999
}
.tt-menu {
  width: 98%;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.Typeahead-input {
    position: relative;
    background-color: transparent;
    outline: none;
}
.twitter-typeahead {
     width: 89% !important;
}
.type_load{
text-align: center;
    position: absolute;
    top: 100%;
    left: 16px;
    z-index: 100;
    background: #fff;
    display:none;
    width: 89%;
    margin: 12px 0;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
    max-height: 158px;
    overflow-y: auto;
}
.text_load
{
font-style: italic;
}
');
?>
<script>
let customRadio = document.getElementsByClassName('customRadio');
    for (let i = 0; i < customRadio.length; i++) {
        customRadio[i].addEventListener('change', nextStep)
    }


    function nextStep() {
        let steps = document.querySelector('.stepsList');
        // Hide show div elemnt
        let nxtStep = steps.querySelector('.active').nextElementSibling.innerHTML;
        console.log(nxtStep)
        document.getElementById(nxtStep).style.display = "block";
        let currentStep = steps.querySelector('.active').innerHTML;
        document.getElementById(currentStep).style.display = "none";
        //changing active class in side nav
        steps.querySelector('.active').nextElementSibling.classList.add('active')
        steps.querySelector('.active').classList.remove('active');
    }

    let topicList = document.getElementsByClassName('topicList');
    for (let i = 0; i < topicList.length; i++) {
        topicList[i].addEventListener('click', nextStep)
    }

    function openCity(evt, stepName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("steps");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(stepName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    let activeID = document.querySelector('.active').innerHTML;
    document.getElementById(activeID).style.display = "block";

    //chaning input color
    let optionRadio = document.getElementsByClassName('ca-ans');
    for (let i = 0; i < optionRadio.length; i++) {
        optionRadio[i].addEventListener('click', function () {
            let correctAnswer = document.querySelectorAll(".correctAnswer");
            console.log(correctAnswer.length);
            if (correctAnswer.length == 1) {
                correctAnswer[0].classList.remove('correctAnswer');
                let sParent = correctAnswer[0].parentElement;
                sParent.querySelector('.ca-message').innerHTML = "";
            }
            let checkRadio = document.querySelector('input[name="answer"]:checked');
            let parentlabel = checkRadio.parentElement;
            let rootParent = parentlabel.parentElement;
            let correctInput = rootParent.querySelector('.ques-input');
            let correctMessage = rootParent.querySelector('.ca-message');
            correctInput.classList.add('correctAnswer');
            correctMessage.innerHTML = "Correct Answer";
        })
    }

    function showPatment() {
        document.getElementById('payment-details').style.display = "block";
    }

    function finishQuiz() {
        document.querySelector('.payLink').style.display = "block";
        nextStep()
    }

    function createQuiz() {
        alert('Your Quiz Has Been Created')
    }

    function creteGroup() {
        let newGroupName = document.getElementById('groupInput').value;
        const groupRow = document.getElementById('group-row');

        let newDiv = document.createElement('div');
        newDiv.setAttribute('class', 'col-md-2');
        newDiv.innerHTML = '<label class="radioLabel"><input type="radio" name="group" value="small" class="customRadio"><div class="quiz-group-box"><div class="quiz-class">' + newGroupName + '</div></div></label>'
        groupRow.appendChild(newDiv);

        document.getElementById('groupInput').value = "";

        let customRadio = document.getElementsByClassName('customRadio');
        for (let i = 0; i < customRadio.length; i++) {
            customRadio[i].addEventListener('change', nextStep)
        }
    }
</script>
<?php
$script = <<< JS
function genrateTypeahead(element,data,url) {
            var datum = new Bloodhound({
                datumTokenizer: function (d) { 
                    return Bloodhound.tokenizers.whitespace(d);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //local: data
                remote: {
                url: url+'?q=%QUERY',
                wildcard: '%QUERY',
                cache: true,     
                },
            });
            datum.initialize();
            jQuery('.type-' + element).typeahead(null, {displayKey: 'word',highlight: true,delay:500,source: datum.ttAdapter()}).on('typeahead:asyncrequest', function() {
            $('.type_load').show();
            }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
            $('.type_load').hide();
             });
            } 
genrateTypeahead('group', null,'/account/categories-list/groups');
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

