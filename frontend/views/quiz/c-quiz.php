<?php

use yii\helpers\Url;

if ($result == Null) {
    ?>
    <div class='m-cover'></div>
    <div class='m-modal'>
        <div class='m-content'>
            <img src='<?= Url::to("@commonAssets/logos/logo.svg"); ?>'>
            <h3><?= $quiz['name'] ?></h3>
            <hr/>
            <div class="detail-body">
                <h4>Before you begin</h4>
                <p>Quiz must be completed in one session, make sure that you have a stable internet connection & you must
                    finish the quiz.</p>
                <p>Your results will be displayed at the end of the quiz.</p>
                <p><i class="fa fa-clock-o"></i> Quiz must be completed in <?= $quiz["duration"];?> minutes.</p>
            </div>
            <hr/>
            <div class='m-actions'>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <a href='javascript:;' class='close-m-mo'>Start Quiz</a>
                <?php else: ?>
                    <a href='/login' target="_blank">Please login to play this quiz.</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
?>
    <section class="container">
        <div class="col-md-3">
            <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px"
                 data-ad-client="ca-pub-2186770765824304" data-ad-slot="first"></ins>
        </div>
        <div class="col-md-6">
            <div class="questionBox">
                <div class="questionContainer">
                    <?php
                    if ($result == Null) {
                        ?>
                        <form id="c-quiz">
                            <header>
                                <h1 class="title is-6"><?= $quiz['name'] ?></h1>
                                <div class="row">
                                    <div class="col-md-12 time-limit">
                                        <h4>Time Left</h4>
                                        <h2 id="timer"></h2>
                                    </div>
                                </div>
                            </header>
                            <div class="quiz-body">
                                <div id="quiz-data" class="hidden">
                                    <h2 class="titleContainer title" id="c-question"
                                        data-key="<?= $quiz['quizPoolEnc']['quizQuestionsPools'][0]['quiz_question_pool_enc_id']; ?>"><?= $quiz['quizPoolEnc']['quizQuestionsPools'][0]['question']; ?></h2>
                                    <div class="optionContainer">
                                        <?php
                                        foreach ($quiz['quizPoolEnc']['quizQuestionsPools'][0]['quizAnswersPools'] as $ans) {
                                            ?>
                                            <input type="radio" id="<?= $ans['quiz_answer_pool_enc_id'] ?>"
                                                   name="<?= $ans['quiz_question_pool_enc_id'] ?>"
                                                   value="<?= $ans['quiz_answer_pool_enc_id'] ?>"/>
                                            <label for="<?= $ans['quiz_answer_pool_enc_id'] ?>" class="option">
                                                <?= $ans['answer'] ?>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="loading-question">
                                    <img src="<?= Url::to('/assets/themes/quiz/loading.gif');?>"/>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <div class="quiz-body">
                            <div class="optionContainer">
                                <div class="quizCompleted has-text-centered">
                                <span class="icon">
                                    <i class="fa fa-check-circle-o is-active"></i>
                                </span>
                                    <h2 class="title">You have already taken this quiz!</h2>
                                    <p class="subtitle">Total score: <?= $result; ?> / <?= $noOfQuestion['num_of_ques'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px"
                 data-ad-client="ca-pub-2186770765824304" data-ad-slot="second"></ins>
        </div>
    </section>
    <script id="c-quiz-options" type="text/template">
        <div class="optionContainer">
            {{#.}}
            <input type="radio" id="{{quiz_answer_pool_enc_id}}" name="{{quiz_question_pool_enc_id}}"
                   value="{{quiz_answer_pool_enc_id}}"/>
            <label for="{{quiz_answer_pool_enc_id}}" class="option">
                {{answer}}
            </label>
            {{/.}}
        </div>
    </script>
<?php
$this->registerCss('
   @import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");
@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700");
body {
  font-family: "Open Sans", sans-serif;
  font-size: 14px;
  height: 100vh;
  background: #CFD8DC;
  cursor: default !important;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  user-drag: none;
  display: flex;
  align-items: center;
  justify-content: center;
}

.button {
  transition: 0.3s;
}

.title,
.subtitle {
  font-family: Montserrat, sans-serif;
  font-weight: normal;
}

.animated {
  transition-duration: 0.15s;
}

.container {
  margin: 0 0.5rem;
}
.time-limit h4, .time-limit h2{
    margin:0px;
}

.questionBox {
  max-width: 530px;
  width: 100%;
  margin: auto;
  min-height: 30rem;
  background: #FAFAFA;
  position: relative;
  display: flex;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
}
.questionBox header {
  background: rgba(0, 0, 0, 0.025);
  padding: 1.5rem;
  text-align: center;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.questionBox header h1 {
  font-weight: bold;
  margin-bottom: 1rem !important;
}
.questionBox header .progressContainer {
  width: 100%;
  margin: 0 auto;
}
.questionBox header .progressContainer > progress {
  margin: 0;
  border-radius: 5rem;
  overflow: hidden;
  border: none;
  color: #3D5AFE;
}
.questionBox header .progressContainer > progress::-moz-progress-bar {
  background: #3D5AFE;
}
.questionBox header .progressContainer > progress::-webkit-progress-value {
  background: #3D5AFE;
}
.questionBox header .progressContainer > p {
  margin: 0;
  margin-top: 0.5rem;
}
.questionBox .titleContainer {
  text-align: center;
  margin: 0 auto;
  padding: 1.5rem;
}
.questionBox .quizForm {
  display: block;
  white-space: normal;
  height: 100%;
  width: 100%;
}
.questionBox .quizForm .quizFormContainer {
  height: 100%;
  margin: 15px 18px;
}
.questionBox .quizForm .quizFormContainer .field-label {
  text-align: left;
  margin-bottom: 0.5rem;
}
.questionBox .quizCompleted {
  width: 100%;
  padding: 1rem;
  text-align: center;
}
.questionBox .quizCompleted > .icon {
  color: #FF5252;
  font-size: 5rem;
}
.questionBox .quizCompleted > .icon .is-active {
  color: #00E676;
}
.questionBox .questionContainer {
  white-space: normal;
  height: 100%;
  width: 100%;
}
.questionBox .questionContainer .optionContainer {
  margin-top: 12px;
  flex-grow: 1;
}
.questionBox .questionContainer .optionContainer .option {
  border-radius: 290486px;
  padding: 9px 18px;
  margin: 0 18px;
  margin-bottom: 12px;
  transition: 0.3s;
  cursor: pointer;
  background-color: rgba(0, 0, 0, 0.05);
  color: rgba(0, 0, 0, 0.85);
  border: transparent 1px solid;
  display:block;
}
.questionBox .questionContainer .optionContainer input:checked + .option {
  border-color: #00a0e3;
  background-color: #00a0e3;
  color:#fff;
}
.questionBox .questionContainer .optionContainer .option:hover, .questionBox .questionContainer .optionContainer .option:focus {
  background-color: #00a0e3;
  color:#fff;
}
.questionBox .questionContainer .optionContainer .option:active {
  -webkit-transform: scaleX(0.9);
          transform: scaleX(0.9);
}
.optionContainer > input[type="radio"]{
    position:absolute;
    left:-9999px;
}
.quiz-body{position:relative}
.loading-question{
    display:none;
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background-color:#dcdcdc73;
}
.loading-question > img {
    overflow: visible !important;
    width: 150px;
    height: 150px;
    margin: auto;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -40%);
}
.m-cover {
  z-index: 1;
  position: fixed;
  height: 100%;
  width: 100%;
  background-color: #333;
  top: 0;
  left: 0;
  opacity: .9;
}
.m-modal {
  z-index: 2;
  height: 370px;
  width: 600px;
  background-color: #ffffff;
  border-radius: 5px;
  text-align: center;
  border-top: solid 3px #ababab;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}
.detail-body{
    text-align:left;
    padding:0px 20px;
}
.detail-body h4{
    color: #111;
}
.m-modal .m-content p {
  font-size: 1em;
  color: #333;
}
.m-content img{
    max-width: 175px;
    display: block;
    margin: 20px auto;
}
.zoom {
  display: block;
  animation: zoom 0.7s;
  animation-fill-mode: forwards;
  box-shadow:0px 2px 10px 2px #dcdcdcc7;
}
.m-actions a {
  display: inline-block;
    border: 1px solid #ddd;
    padding: 10px 15px;
    box-shadow: 0px 2px 10px 1px #eee;
    border-radius: 4px;
    color: #fff;
    background-color: #00a0e3;
}
.m-actions a:hover {
    text-decoration:none;
}
@keyframes zoom {
  0% {
    opacity: 0;
    transform: scale(0, 0);
  }
  30% {
    opacity: 0;
  }
  100% {
    bottom: 0;
  }
}
.hidden {
  display: none;
}
.reverse {
  animation-direction: reverse;
}
@media screen and (max-width: 600px) {
    .m-content img{max-width: 290px;}
    .m-modal{
        height: 430px;
        width: 300px;
    }
}

@keyframes slide {
  0% {
    transform: translateY(-50px);
  }
  100% {
    transform: translateY(50px);
  }
}
@keyframes escalade {
  0% {
    stroke-dasharray: 0 157px;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 156px 157px;
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dasharray: 156px 157px;
    stroke-dashoffset: -156px;
  }
}

@media screen and (min-width: 769px) {
  .questionBox {
    align-items: center;
    justify-content: center;
  }
  .questionBox .questionContainer {
    display: flex;
    flex-direction: column;
  }
}
@media screen and (max-width: 768px) {
  .sidebar {
    height: auto !important;
    border-radius: 6px 6px 0px 0px;
  }
}
');
$noOfQuestion = $quiz["num_of_ques"];
$duration = $quiz["duration"];
$script = <<<JS
$('.m-modal').addClass("zoom");
var validate = false;
var x;
function startInterval() {
    validate = true;
    var timeLimit = new Date();
    var countDownDate = timeLimit.setMinutes(timeLimit.getMinutes() + $duration);
    x = setInterval(function() {
      var now = new Date().getTime();
      var distance = countDownDate - now;   
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      document.getElementById("timer").innerHTML = minutes + ":" + seconds;
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "Time Up";
        $('.loading-question').fadeIn(500);
        $.ajax({
            type: 'POST',
            url: '/quiz/get-result',
            success: function(data){
                $('.loading-question').fadeOut(500);
                if(data.status == 205) {
                    showResult(data);                
                } else {
                    alert('Error has Occured, Please try again Later.');
                }
            }
        });
      }
    }, 1000);
}
$(".close-m-mo").on("click", function() {
  $('.m-modal').attr('class', 'm-modal');
  $('.m-modal, .m-cover').addClass("hidden");
  $('#quiz-data').removeClass('hidden');
  startInterval();
});
$(document).on('change', '.optionContainer input[type=radio]', function(){
    if(validate){
        $('.loading-question').fadeIn(500);
        var question_id = $('#c-question').attr('data-key');
        var ans_val;
        $('.option').each(function(){
            var id =  $(this).attr('for');
            if($('#'+id).is(":checked")){
                ans_val = $('#'+id).attr('value');
            }
        });
        
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {question:question_id,ans:ans_val},
            success: function(data){
                $('.loading-question').fadeOut(500);
                if(data.status == 200){
                    var q_body = $('#c-quiz-options').html();
                    $(".optionContainer").html(Mustache.render(q_body, data.question.quizPoolEnc.quizQuestionsPools[0].quizAnswersPools));
                    $('#c-question').html(data.question.quizPoolEnc.quizQuestionsPools[0].question);
                    $('#c-question').attr('data-key', data.question.quizPoolEnc.quizQuestionsPools[0].quiz_question_pool_enc_id);
                    animateShow();
                } else if(data.status == 205) {
                    clearInterval(x);
                    showResult(data);                
                } else {
                    alert('Error has Occured, Please try again Later.');
                }
            },
            error: function (jqXHR, exception) {
                $('.loading-question').fadeOut(500);
                alert('Error has Occured, Please try again.');
            },
        });
    }
});
function showResult(data) {
    $('#c-question').fadeOut(1000);
    var result = '<div class="quizCompleted has-text-centered"><span class="icon"><i class="fa fa-check-circle-o is-active"></i></span><h2 class="title">You did '+ data.result +' amazing good job!</h2><p class="subtitle">Total score: '+ data.result +' / $noOfQuestion</p></div>';
    $(".optionContainer").html(result);
}
function animateShow() {
  $('.quiz-body').addClass('animated');
    $('.quiz-body').addClass('zoomOut');
    setTimeout(function(){
        $('.quiz-body').removeClass('animated');
        $('.quiz-body').removeClass('zoomOut');
        $('.quiz-body').addClass('animated');
        $('.quiz-body').addClass('zoomIn');
    }, 500);
    setTimeout(function(){
        $('.quiz-body').removeClass('animated');
        $('.quiz-body').removeClass('zoomIn');
    }, 1000);
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);