<?php
use yii\helpers\Url;


?>

<div class="portlet light portlet-fit nd-shadow">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-social-twitter font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Registered Quizzes'); ?>
                    <span data-toggle="tooltip" title="Here you will see your registered detail">
                        <i class="fa fa-info-circle"></i>
                    </span>
                </span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row quizCards">
            <?php
                foreach ($registeredQuizzes as $quiz){
                    $date = new DateTime($quiz['quiz_start_datetime']);
                    $newDate = $date->format('d-M-Y h:i A');
               ?>
                <div class="col-md-12">
                    <div class="quiz-card">
                        <div class="quiz-img">
                            <img src="<?= $quiz['sharing_banner_image'] ? $quiz['sharing_image'] : 'https://www.empoweryouth.com/assets/themes/ey/images/pages/quiz/quiz-template-default.png' ?>">
                        </div>
                        <div class="quiz-title">
                            <h2><?= $quiz['name'] ?></h2>
                            <p>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?= $newDate ?>
                            </p>
                        </div>
                        <div class="regis">
                            <p>Questions: <b><?= $quiz['num_of_ques'] ?></b></p>
                            <p>Duration: <b><?= $quiz['duration'] ?> <?= $quiz['duration'] > 1 ? 'minutes' : 'minute' ?></b></p>
                            <?php
                                if($quiz['quizEnc']['quizRewards']){
                            ?>
                                    <p>Prize: <b><i class="fas fa-rupee-sign"></i> <?= floor($quiz['quizEnc']['quizRewards']['0']['price']) ?></b></p>
                            <?php } ?>
                        </div>
                        <div class="view-btn">
                            <a href="<?= Url::to('/quiz/'.$quiz['slug']) ?>" class="view-link">View Quiz</a>
                        </div>
                    </div>
                </div>
            <?php
             }
            ?>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.quizCards .quiz-card{
    display: flex;
    align-items: center;
    border-bottom: 0.07rem dashed #ebedf2;
    padding: 10px 0;
}
.quizCards > div.col-md-12:first-child .quiz-card{
    padding: 0 0 10px;
}
.quizCards > div.col-md-12:last-child .quiz-card{
    border-bottom: none;
}
.quiz-img{
  min-width: 120px;
  max-width: 120px;
  border-radius: 5px;
  overflow: hidden;
  margin-right: 10px;
}
.quiz-img img{
  width: 100%;
}
.quiz-title{
   flex-basis:40%;
}
.quiz-title h2{
  font-size: 16px;
  font-family: roboto;
  margin: 0;
  font-weight: 500;
  line-height: 20px;
}
.quiz-title p{
  margin: 2px 0 0 0;
  font-family: roboto;
  font-weight: 500;
  font-size: 14px;
}
.regis{
    text-align: center;
}
.view-btn{
  align-self: center;
  text-align: right;
    flex: auto; 
}
.view-link{
  background: #00a0e3;
  border: 1px solid #00a0e3;
  padding: 10px 15px;
  color: #fff;
  border-radius: 6px;
  font-family: roboto;
}
.view-link:hover{
  background: #fff;
  border: 1px solid #00a0e3;
  color: #00a0e3;
  transition: .3s ease;
}
')
?>
