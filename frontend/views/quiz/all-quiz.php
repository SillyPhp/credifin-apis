<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>
    <section class="quiz-header">
        <div class="container">

        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">All Quizzes</div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($data as $d) { ?>
                    <div class="col-md-3">
                        <div class="quiz-box">
                            <div class="quiz-icon">
                                <img src="<?= Yii::$app->params->upload_directories->quiz->sharing->image . "/" . $d['sharing_image_location'] . "/" . $d['sharing_image'] ?>">
                            </div>
                            <div class="quiz-title">
                                <?= $d['name']; ?>
                            </div>
                            <div class="quiz-ques">
                                Total Questions : <?= $d['cnt']; ?>
                            </div>
                            <div class="take-quiz">
                                <a href="<?= $d['slug']; ?>">Take Quiz</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.quiz-header{
     background:url(' . Url::to('@eyAssets/images/pages/quiz/quiz-header1.png') . ');
     min-height:450px;
     background-repeat:no-repeat;
     background-size:cover;
     background-position:bottom;
}
.quiz-box{
    border:1px solid #eee;  
    text-align: center;
    border-radius: 10px; 
}
.quiz-box:hover{
    box-shadow:0 0 8px rgba(0,0,0,.3);
}
.quiz-box:hover .quiz-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.quiz-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;  
}
.quiz-icon img{
    border-radius:10px 10px 0 0;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;  
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
}
.quiz-title{
    font-size:15px;
    font-weight:bold;
    padding-top: 10px;
    font-family:lora;
}
.quiz-ques{
    line-height: 13px;
    padding-top: 5px;   
}
.take-quiz{
    margin-bottom: 0px;
    overflow: hidden;
    padding: 20px 0 6px 0;
}
.take-quiz a{
    border:1px solid #eee;
    padding: 8px 13px;
    border-radius:5px 5px 0 0;
    font-size:13px;    
}
.take-quiz a:hover{
    color:#fff;
    background:#00a0e3;
    border-color:#00a0e3;
    transition:.3s ease;
}
');
$script = <<<JS
JS;
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
?>