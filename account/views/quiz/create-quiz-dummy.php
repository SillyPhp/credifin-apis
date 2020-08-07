<?php

use yii\helpers\Url;

?>
<section>
    <div class="row">
        <div class="col-md-2" id="side-bar-main" style="padding: 0; height: 200vh;background-color: #f8f8f8;">
            <div class="w3-sidebar w3-bar-block w3-light-grey w3-card stepsList">
                <h5 class="quiz-heading pl10">Steps To Create Quiz</h5>
                <button class="w3-bar-item w3-button steps-btn tablink btn-primary active" value="#step-1">Group
                </button>
                <button class="w3-bar-item w3-button steps-btn tablink" value="#step-2" disabled="disabled">Subject
                </button>
                <button class="w3-bar-item w3-button steps-btn tablink" value="#step-3" disabled="disabled">Topic
                </button>
                <button class="w3-bar-item w3-button steps-btn tablink" value="#step-4" disabled="disabled">
                    Introduction
                </button>
                <button class="w3-bar-item w3-button steps-btn tablink" value="#step-5" disabled="disabled">Questions
                </button>
                <button class="w3-bar-item w3-button steps-btn tablink payLink" value="#step-6" disabled="disabled">
                    Rules
                </button>
            </div>
        </div>
        <div class="col-md-8" id="integration-main">
            <div id="form-data">
                <div class="row setup-content" id="step-1">
                    <div class="col-md-12">
                        <div id="Group" class="w3-container steps">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="quiz-heading">Create New Group or Choose One Below</h2>
                                    <div class="quiz-top">
                                        <input type="text" maxlength="50" placeholder="Enter Group Name"
                                               class="topic-input" id="groupInput">
                                        <button type="button" id="grpinputbtn"><i class="fa fa-share"></i></button>
                                    </div>
                                </div>
                            </div>
                            <h2 class="quiz-heading">Select Group</h2>
                            <div class="row" id="group-row">
                                <?php if (!empty($categories)) { ?>
                                    <?php foreach ($categories as $cat) { ?>
                                        <div class="col-md-3">
                                            <label class="radioLabel" onclick="displayValue()">
                                                <input type="radio" name="group" txtvalue="<?= $cat['name'] ?>"
                                                       value="<?= $cat['id'] ?>" class="customRadio" >
                                                <div class="quiz-group-box" >
                                                    <p class="quiz-class"><?= $cat['name'] ?></p>
                                                </div>
                                            </label>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                            <div class="row">
                                <div class="step-next-btn">
                                    <button class="btn btn-primary btn-md nextBtn pull-right" type="button">Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-2">
                    <div id="Subject" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Create New Subject or Choose One Below</h2>
                                <div class="quiz-top">
                                    <input type="text" maxlength="50" placeholder="Enter Subject Name"
                                           class="topic-input" id="subjectInput">
                                    <button type="button" id="subjectinputbtn"><i class="fa fa-share"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="quiz-heading">Select Subject</h2>
                            </div>
                        </div>
                        <div class="row" id="subject-row">
                            <?php if (!empty($subject)) { ?>
                                <?php foreach ($subject as $sub) { ?>
                                    <div class="col-md-3">
                                        <label class="radioLabel"  onclick="displaysecond()">
                                            <input type="radio" name="subject" txtvalue="<?= $sub['name'] ?>"
                                                   value="<?= $sub['id'] ?>" class="customRadio">
                                            <div class="quiz-group-box">
                                                <p class="quiz-subject"><?= $sub['name'] ?></p>
                                            </div>
                                        </label>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <div>
                            <div class="step-next-btn">
                                <button class="btn btn-primary btn-md nextBtn pull-right" type="button">Next
                                </button>
                            </div>
                            <div class="step-next-prev">
                                <button class="btn btn-primary btn-md prevBtn" type="button">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-3">
                    <div id="Topic" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Create New Topic or Choose One From Below</h2>
                                <div class="quiz-top">
                                    <input type="text" maxlength="100" placeholder="Enter Topic" class="topic-input"
                                           id="topicinput">
                                    <button type="button" id="topicinputbtn"><i class="fa fa-share"></i></button>
                                </div>
                                <div class="previous-topics">
                                    <h2 class="quiz-heading">Recommendation</h2>
                                    <?php if (!empty($recommend_topics)) { ?>
                                        <?php echo '<ul>';
                                        foreach ($recommend_topics as $rec) { ?>
                                            <label class="radio_topics">
                                                <input type="radio" name="topic" txtvalue="<?= $rec['name'] ?>"
                                                       value="<?= $rec['id'] ?>" class="customRadio_topic">
                                                <li class="topicList"><?= $rec['name'] ?></li>
                                            </label>
                                        <?php }
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="previous-topics">
                                    <h2 class="quiz-heading">Create Or Choose One Topics</h2>
                                    <div id="user_topic_divs">
                                        <?php if (!empty($user_topics)) { ?>
                                            <?php echo '<ul id="user_topics">';
                                            foreach ($user_topics as $tp) { ?>
                                                <label class="radio_topics">
                                                    <input type="radio" name="topic" txtvalue="<?= $tp['name'] ?>"
                                                           value="<?= $tp['id'] ?>" class="customRadio_topic">
                                                    <li class="topicList"><?= $tp['name'] ?></li>
                                                </label>
                                            <?php }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="step-next-btn">
                                <button class="btn btn-primary btn-md nextBtn pull-right" type="button">Next
                                </button>
                            </div>
                            <div class="step-next-prev">
                                <button class="btn btn-primary btn-md prevBtn" type="button">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-4">
                    <div id="Introduction" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Introduction To Quiz</h2>
                                <p class="recom-charac">Minimum 160 characters recommended</p>
                                <div class="quiz-intro">
                                    <textarea class="quiz-intro-textarea" maxlength="280" id="inro_input"
                                              placeholder="Enter Quiz Intro"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="previous-topics">
                                    <h2 class="quiz-heading">Previous Introductions</h2>
                                    <?php if (!empty($intros_Desc)) { ?>
                                        <?php echo '<ul id="user_intros">';
                                        foreach ($intros_Desc as $int) { ?>
                                            <label class="radio_topics">
                                                <input type="radio" name="intros" txtvalue="<?= $int['name'] ?>"
                                                       value="<?= $int['id'] ?>" class="customRadio_topic">
                                                <li class="topicList"><?= $int['name'] ?></li>
                                            </label>
                                        <?php }
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="step-next-btn">
                                <button class="btn btn-primary btn-md nextBtn pull-right" type="button">Next
                                </button>
                            </div>
                            <div class="step-next-prev">
                                <button class="btn btn-primary btn-md prevBtn" type="button">Back</button>
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
                                        <textarea placeholder="Enter Question" id="input_question"
                                                  class="ques-input"></textarea>
                                    </div>
                                    <div class="optionList">
                                        <div class="dis-flex">
                                            <textarea placeholder="Enter Option" id="input_answer1"
                                                      class="ques-input max300"></textarea>
                                            <label class="checkbox-container correctAns">
                                                <input type="radio" name="answer" class="ca-ans">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p class="ca-message"></p>
                                        </div>
                                        <div class="dis-flex">
                                            <textarea placeholder="Enter Option" id="input_answer2"
                                                      class="ques-input max300"></textarea>
                                            <label class="checkbox-container correctAns">
                                                <input type="radio" name="answer" class="ca-ans">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p class="ca-message"></p>
                                        </div>
                                        <div class="dis-flex">
                                            <textarea placeholder="Enter Option" id="input_answer3"
                                                      class="ques-input max300"></textarea>
                                            <label class="checkbox-container correctAns" value="">
                                                <input type="radio" name="answer" class="ca-ans">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p class="ca-message"></p>
                                            <button type="button" class="deleteBtn"
                                                    onclick="this.parentElement.remove()"><i
                                                        class="fa fa-trash"></i></button>
                                        </div>
                                        <div class="dis-flex">
                                            <textarea placeholder="Enter Option" id="input_answer4"
                                                      class="ques-input max300"></textarea>
                                            <label class="checkbox-container correctAns">
                                                <input type="radio" name="answer" class="ca-ans">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p class="ca-message"></p>
                                            <button type="button" class="deleteBtn"
                                                    onclick="this.parentElement.remove()"><i
                                                        class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="dis-flex">
                                        <button type="button" id="add_options_btn">Add More Options</button>
                                    </div>
                                    <div class="quiz-button-flex">
                                        <button type="button" id="create_question">Create Question</button>
                                        <button type="button" id="finish_quiz">Proceed To Final Step</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="quiz-heading">Questions Created</h2>
                                <div class="question_created_zone"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-6">
                    <div id="Rules" class="w3-container steps">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="payment-text">Total Marks</div>
                                        <div class="pay-input">
                                            <input type="text" maxlength="4" id="input_m" placeholder="Marks">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="payment-text">Time Duration</div>
                                        <div class="pay-input">
                                            <input type="text" maxlength="4" id="input_t" placeholder="In Minutes">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt20">
                                        <div class="payment-text">Marks For Every Correct answer</div>
                                        <div class="pay-input">
                                            <input type="text" maxlength="4" id="input_cam" placeholder="Marks">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt20">
                                        <div class="payment-text">Would you like to negative marking for this quiz
                                        </div>
                                        <div class="pay-btns">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="radioLabel">
                                                        <input type="radio" name="choice_marks_system"
                                                               txtvalue="yes"
                                                               value="1" class="customRadio">
                                                        <div class="quiz-group-box btn-shape">
                                                            <div class="quiz-subject">Yes</div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="radioLabel">
                                                        <input type="radio" name="choice_marks_system" txtvalue="no"
                                                               value="0" class="customRadio">
                                                        <div class="quiz-group-box btn-shape">
                                                            <div class="quiz-subject">No</div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="marking-details">
                                            <div class="payment-text">Penalty For Every Wrong answer</div>
                                            <div class="pay-input">
                                                <input type="text" maxlength="3" id="penelty_score"
                                                       placeholder="Penalty">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt20">
                                        <div class="payment-text">Would you like to charge students for this quiz
                                        </div>
                                        <div class="pay-btns">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="radioLabel">
                                                        <input type="radio" name="choice_payment" txtvalue="yes"
                                                               value="1" class="customRadio">
                                                        <div class="quiz-group-box btn-shape">
                                                            <div class="quiz-subject">Yes</div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="radioLabel">
                                                        <input type="radio" name="choice_payment" txtvalue="no"
                                                               value="0" class="customRadio">
                                                        <div class="quiz-group-box btn-shape">
                                                            <div class="quiz-subject">No</div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="payment-details">
                                            <div class="pay-form">
                                                <div class="pay-input">
                                                    <input type="text" id="p_input" placeholder="Enter Amount">
                                                    <span><i class="fa fa-inr"></i></span>
                                                </div>
                                                <div class="pay-btns">
                                                    <button type="button" id="sbt_btn_p">Submit Quiz</button>
                                                    <button class="buttonload">
                                                        <i class="fa fa-refresh fa-spin"></i>Loading
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="note-text">
                                                <span>Note: </span> We Charge 20% as maintenance charges
                                            </div>
                                        </div>
                                        <div id="final-details">
                                            <div class="pay-form">
                                                <div class="pay-btns">
                                                    <button type="button" id="sbt_btn_wp">Submit Quiz</button>
                                                    <button class="buttonload">
                                                        <i class="fa fa-refresh fa-spin"></i>Loading
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="quiz-name">
                                    <div class="quiz-title">
                                        <p id="quiz_question_topic"></p>
                                    </div>
                                    <div class="quiz-details">
                                        <p><span>Total Questions:</span> <span id="quiz_question_counts"
                                                                               class="font-weight-500"></span></p>
                                        <p><span>Group:</span> <span id="quiz_question_group"
                                                                     class="font-weight-500"></span></p>
                                        <p><span>Subject:</span> <span id="quiz_question_subject"
                                                                       class="font-weight-500"></span></p>
                                    </div>
                                    <div class="quiz-info">
                                        <p><span>Introduction:</span>
                                        <p id="quiz_question_intro" class="font-weight-500"></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 pos" id="side-bar-2">
            <div class="steps">
                <ul class="step">
                    <li id="fet-name"></li>
                    <li id="second"></li>
                </ul>
            </div>
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
                <li><a href=""><i class="fa fa-facebook-f"></i></a></li>
                <li><a href=""><i class="fa fa-twitter"></i></a></li>
                <li><a href=""><i class="fa fa-instagram"></i></a></li>
                <li><a href=""><i class="fa fa-whatsapp"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.col-md-2.pos {
    background-color: #f8f8f8;
    padding:0;
}
.steps {
    position: sticky;
    top: 130px;
}
.step {
    padding: 0 10px;
    text-align: center;
    list-style:none;
}
.step h3 {
    margin: 0 0 20px;
    font-family: roboto;
    text-transform: capitalize;
}
.step i{
    font-size:40px;
}
#marking-details
{
display:none;
}
.quiz-textarea textarea{
    height: 100px;
    resize: none;
}
.quiz-button-flex{
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
}
#payment-details,#final-details{
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
.radioLabel,.radio_topics{
    width: 100%;
}
.customRadio,.customRadio_topic { 
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

.customRadio_topic:checked ~ .topicList {
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
.w3-sidebar {
	position: sticky;
	overflow: auto;
	top: 100px;
}
.w3-light-grey, .w3-hover-light-grey:hover, .w3-light-gray, .w3-hover-light-gray:hover {
    color: #000!important;
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
  margin: 0px;
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
  border: 1px solid #00a0e3;    
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
.btn-shape
{
    border-radius: 21px !important;
    min-height: 20px !important;
}
.buttonload {
  background-color: #4CAF50; /* Green background */
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 12px 16px; /* Some padding */
  font-size: 16px /* Set a font size */
}
.buttonload
{
display:none;
}
.quiz-title {
    background: #f8f8f8;
    color: #000;
    padding: 10px 15px;
    font-size: 18px;
    font-family: lora;
    display: flex;
    align-items: center;
}
.mt20{
    margin-top: 20px;
}
.quiz-title{
    background: #f8f8f8;
    color: #000;
    padding: 10px 15px;
    font-size: 18px;
    font-family: lora;
    display: flex;
    align-items: center;
}
.quiz-details p span, .quiz-info p span{
    font-weight: bold;
}
#Rules{
    margin: 40px 0 0 0;
}
.qModal h4{
    font-weight: bold;
    color: #333;
    font-family: roboto;
    font-size: 20px;
}
.qModal h2{
    font-weight: bold;
    color: #00a0e3;
    font-family: lora;
    font-size: 30px;
}
.qModal p{
    color: #333;
    font-family: roboto;
    font-size: 16px;
}
.qshare {
    padding-inline-start: 0;
}
.qshare li{
    list-style: none;
    display: inline;
   padding:10px 10px;
}
.qshare li a{
    font-size: 23px;
    color: #333; 
}
.qshare li a:hover{
    color: #00a0e3; 
}
.qm-logo{
    max-width:100px;
    max-height: 100px;    
    margin: 0 auto;
}
.qm-name{
    margin-bottom: 10px;
    margin-top: 10px;
}
.qm-logo img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 10px;
}
.font-weight-500{font-weight: 500 !important;}
.deleteBtn{
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 8px 6px !important;
    background: transparent !important;
    border:1px solid #00a0e3 !important;
    color: #00a0e3 !important;   
}
.deleteBtn:hover{
    background: #00a0e3 !important;
       color: #fff !important;   
}
.dis-flex{
    display: flex;
    position: relative;
    margin: 0px 0 16px 0;
    max-width: 425px;
}
.dis-flex textarea{
    height: 60px;
    resize: none;
}
');
$script = <<< JS
$('#p_input').mask("#,#0,#00", {reverse: true});
$('#input_m').mask("#000", {reverse: true});
$('#input_t').mask("#000", {reverse: true});
$('#input_cam').mask("#000", {reverse: true});
$('#penelty_score').mask("#000", {reverse: true});

function initializePosSticky() {
  var mainHeight = $('#integration-main').height();
  $('#side-bar-main').css('height',mainHeight);
  $('#side-bar-2').css('height',mainHeight);
}
initializePosSticky();
$(document).on('click', '.scroll-to-sec', function(e) {
    e.preventDefault();
    var sectionId = $(this).attr('href');
    var offsetHeight = $(sectionId).offset().top - 90 ;
    $('html, body').animate({scrollTop: offsetHeight}, 600);
});
JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/ey/quiz/quiz-nano.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    function displayValue() {
        var ele = document.getElementsByClassName('customRadio');
        for (i = 0; i < ele.length; i++) {
            if (ele[i].checked) {
                var name = ele[i].parentElement.getElementsByTagName('p')[0].innerText;
                document.getElementById("fet-name").innerHTML = "1. " + name;
            }
        }
    }
    function displaysecond() {
        var ele = document.getElementsByClassName('customRadio');
        for (i = 0; i < ele.length; i++) {
            if (ele[i].checked) {
                var name = ele[i].parentElement.getElementsByTagName('p')[0].innerText;
                document.getElementById("second").innerHTML = "2. " + name;
            }
        }
    }
</script>
