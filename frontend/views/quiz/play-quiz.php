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
                        A hollow vertical cylinder of radius r and height h has a smooth internal surface.
                        A small particle is placed in contact with the inner side of the upper rim, at point A,
                        and given a horizontal speed u, tangential to the rim. It leaves the lower rim at point B,
                        vertically below A. If n is an integer then.
                    </div>
                    <div class="">
                        <form>
                            <div class="form-group">
                                <label class="labl">
                                    <input type="radio" name="radioname" value="one_value" checked="checked"/>
                                    <div>Small</div>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="labl">
                                    <input type="radio" name="radioname" value="another" />
                                    <div>
                                        <
                                    </div>
                                </label>
                            </div>
                        </form>
                    </div>
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
    min-height: 300px;
    display: flex;
    align-items: center; 
}
.quiz-name{
    font-size: 20px;
    font-family: roboto;
    font-weight: 500;
    padding-top: 50px;
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
    border:2px solid transparent;
}
.labl > input:checked + div{ /* (RADIO CHECKED) DIV STYLES */
    background-color: #ffd6bb;
    border: 1px solid #ff6600;
}

');
$script = <<<JS

JS;
$this->registerJS($script);
?>
