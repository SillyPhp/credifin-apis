<?php

use yii\helpers\Url;
?>
<section class="quiz-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="quiz-name">Predicted JEE Main 2019 (April)</div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="question-section">
                    <div class="ques">
                        <p>A hollow vertical cylinder of radius r and height h has a smooth internal surface.
                            A small particle is placed in contact with the inner side of the upper rim, at point A,
                            and given a horizontal speed u, tangential to the rim. It leaves the lower rim at point B,
                            vertically below A. If n is an integer then.</p>
                    </div>
                        <form>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="labl">
                                    <input type="radio" name="radioname" value="one_value" checked="checked"/>
                                    <div>
                                        <span>1</span>
                                        Radius r and height h has a smooth internal surface
                                    </div>
                                </label>
                            </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="labl">
                                    <input type="radio" name="radioname" value="another" />
                                    <div>
                                        <span>2</span>
                                        A hollow vertical cylinder
                                    </div>
                                </label>
                            </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="labl">
                                        <input type="radio" name="radioname" value="another" />
                                        <div>
                                            <span>3</span>
                                            A hollow vertical cylinder
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="labl">
                                        <input type="radio" name="radioname" value="another" />
                                        <div>
                                            <span>4</span>
                                            A hollow vertical cylinder
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ques-bts">
                        <div class="">

                        </div>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="ques-indi">
                    <h3>Total Questions</h3>
                    <ul>
                        <li><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">4</a></li>
                        <li><a href="">5</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.quiz-header{
    color: #fff;
    background: #00a0e3;
    max-height: 300px;
    display: flex;
    align-items: center; 
}
.quiz-name{
    font-size: 20px;
    font-family: roboto;
    font-weight: 500;
    padding-top: 100px;
    padding-bottom: 50px;
}
.ques{
    color:#000;
    font-size: 16px;
    line-height: 22px;
    padding: 10px 15px;
}
.labl {
    display : block;
    width: 100%;
}
.labl > input{ 
    visibility: hidden; /* Makes input not-clickable */
    position: absolute; /* Remove input from document flow */
}
.labl > input + div{
    cursor:pointer;
    border:1px solid #eee;
    padding: 10px 15px;
    font-weight: 500;
}
.labl > input + div span{
    background: #00a0e3;
    padding: 5px 8px;
    color: #fff;
    border-radius: 5px;
    margin-right: 10px;
}
.labl > input:checked + div{ /* (RADIO CHECKED) DIV STYLES */
    background-color: #00a0e3;
    border: 1px solid #00a0e3;
    color: #fff;
}
.labl > input:checked + div span{
    background: #fff;
    padding: 5px 8px;
    color: #00a0e3;
    border-radius: 5px;
}
.ques-indi{
    box-shadow: 0 0 10px rgba(0,0,0,.1);
}
.ques-indi ul{
    margin: 0 0 10px 10px;
}
.ques-indi ul li{
    display: inline-block;
    margin: 5px 0 15px 5px;
}
.ques-indi ul li a{
    padding: 5px 10px;
    background: #eee;
    border-radius: 5px;
}
.ques-indi ul li a:hover{
    background: #00a0e3;
    color:#fff;
}
.ques-indi h3{
    background: #00a0e3;
    color:#fff;
    font-size: 18px;
    padding: 8px 10px;    
}
');
$script = <<<JS

JS;
$this->registerJS($script);
?>