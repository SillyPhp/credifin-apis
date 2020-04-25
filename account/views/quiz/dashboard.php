<?php

use yii\helpers\Url;
?>
<section>
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">
            <div class="stats">
                <div class="row">
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Earnings This Month</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Earnings Lifetime</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Total Quiz</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Quiz Created This Month</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Quiz Played Lifetime</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Quiz Played This Month </div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <i class="fa fa-inr"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="top-quiz">
                            <div class="tq-heading">Top Quiz</div>
                            <ul>
                                <li>
                                    <div class="tq-box">
                                        <div class="tq-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg')?>">
                                        </div>
                                        <div class="tq-details">
                                           <div class="tq-name">Basics of Social Media</div>
                                            <div>Total Played: <span>100</span></div>
                                            <div>Total Earnings: <span><i class="fa fa-inr"></i> 1000</span></div>
                                        </div>
                                    </div>
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
.quiz-stats-box{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    width: 100%;
    min-height: 100px;
    display: flex;
    padding: 10px 20px;
    align-items: center;
    margin-bottom: 20px;
}
.stats-details{
    flex: 2;
}
.qsb-heading{
    font-size: 16px;
    color: #000;
    font-family: lora;
    letter-spacing: .8px;
}
.qsb-price{
    font-size: 22px;
    color: #333;
    font-family: roboto;
}
.qsb-rise{
    font-size: 12px;
    color: #00a0e3;
    font-family: roboto;
}
.qsb-icons{
   background: #00a0e3;
    width: 50px;
    height: 50px;
    position: relative;
    border-radius: 50%;
    font-size: 22px;
    color: #fff;
}
.qsb-icons i{
    position: absolute;
    top: 50%;
    left:50%;
    transform: translate(-50%,-50%);
}
.top-quiz ul{
    list-style: none;
    padding-inline-start: 0;
}
.tq-box{
    display: flex;
}
.tq-icon{
    max-width: 80px;
    max-height: 80px;
}
.tq-icon img{
    width: 100%;
    height:100%;
}
.tq-details{
    padding:0 0 0 10px;
}
.tq-name{
    font-weig
}
')

?>
