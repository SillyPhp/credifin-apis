<section class="container">
    <div class="questionBox">
        <div class="questionContainer">
            <header>
                <h1 class="title is-6">VueQuiz</h1>
                <div class="progressContainer">
                    <progress class="progress is-info is-small" value="80" max="100">80%</progress>
                    <p>80% complete</p>
                </div>
            </header>
            <div class="quiz-body">
                <h2 class="titleContainer title">Question</h2>
                <div class="optionContainer">
                    <div class="option">
                        ans 1
                    </div>
                    <div class="option">
                        ans 2
                    </div>
                    <div class="option">
                        ans 3
                    </div>
                    <div class="option">
                        ans 4
                    </div>
                </div>
                <div class="loading-question">
                    <svg>
                        <g>
                            <path d="M 50,100 A 1,1 0 0 1 50,0"/>
                        </g>
                        <g>
                            <path d="M 50,75 A 1,1 0 0 0 50,-25"/>
                        </g>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#f07704;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#00a0e3;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
            <footer class="questionFooter">
                <nav class="pagination" role="navigation" aria-label="pagination">
                    <a class="button nxxt">
                        Next
                    </a>
                </nav>
            </footer>
        </div>
        <div class="quizCompleted has-text-centered hidden">
				<span class="icon">
                    <i class="fa fa-check-circle-o is-active"></i>
                </span>
            <h2 class="title">
                You did 7 amazing good job!
            </h2>
            <p class="subtitle">
                Total score: 7 / 10
            </p>
            <br>
<!--            <a class="button">restart <i class="fa fa-refresh"></i></a>-->
        </div>
    </div>
</section>
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
  width: 60%;
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
}
.questionBox .questionContainer .optionContainer .option.is-selected {
  border-color: rgba(0, 0, 0, 0.25);
  background-color: white;
}
.questionBox .questionContainer .optionContainer .option:hover {
  background-color: rgba(0, 0, 0, 0.1);
}
.questionBox .questionContainer .optionContainer .option:active {
  -webkit-transform: scaleX(0.9);
          transform: scaleX(0.9);
}
.questionBox .questionContainer .questionFooter {
  background: rgba(0, 0, 0, 0.025);
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  width: 100%;
  align-self: flex-end;
}
.questionBox .questionContainer .questionFooter .pagination {
  margin: 15px 25px;
}

.pagination {
  display: block !Important;
}

.button {
  padding: 0.5rem 1rem;
  border: 1px solid rgba(0, 0, 0, 0.25);
  border-radius: 5rem;
  margin: 0 0.25rem;
  transition: 0.3s;
  float:right;
}
.button:hover {
  cursor: pointer;
  background: #ECEFF1;
  border-color: rgba(0, 0, 0, 0.25);
}
.button.is-active {
  background: #3D5AFE;
  color: white;
  border-color: transparent;
}
.button.is-active:hover {
  background: #0a2ffe;
}
.quiz-body{position:relative}
.loading-question{
    display:none;
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background-color:#54545473;
}
svg {
    overflow: visible !important;
    width: 150px;
    height: 150px;
    margin: auto;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -40%);
}
svg g {
  animation: slide 2s linear infinite;
}
svg g:nth-child(2) {
  animation-delay: 0.5s;
}
svg g:nth-child(2) path {
  animation-delay: 0.5s;
  stroke-dasharray: 0px 158px;
  stroke-dashoffset: 1px;
}
svg path {
  stroke: url(#gradient);
  stroke-width: 20px;
  stroke-linecap: round;
  fill: none;
  stroke-dasharray: 0 157px;
  stroke-dashoffset: 0;
  animation: escalade 2s cubic-bezier(0.8, 0, 0.2, 1) infinite;
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
$script = <<<JS
$(document).on('click', '.option', function(){
    $('.option').each(function(){
        $(this).removeClass('is-selected');
    });
    $(this).addClass('is-selected');
});
$(document).on('click', '.nxxt', function(){
    $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
    $('.loading-question').fadeIn(500);
    setTimeout(function() {
        $('.loading-question').fadeOut(500);
        $('.nxxt').html('Next');
        animateShow();
    }, 1500);
});
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