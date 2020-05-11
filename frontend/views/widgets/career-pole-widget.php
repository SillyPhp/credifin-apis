<?php
use yii\helpers\Url;
?>

<div class="row poll-main">
    <div class="col-md-12">
        <div class="poll-question">
            <h2>Rate the Article</h2>
        </div>
        <div class="poll-answers">
            <div class="poll-ans-item col-md-3">
                <input type="radio" id="control_01" name="select" value="1">
                <label for="control_01">
                    <img src="<?= Url::to('@eyAssets/images/pages/career-blog/smile15.png')?>">
                    <h3>Like a Lot</h3>
                </label>
            </div>
            <div class="poll-ans-item col-md-3">
                <input type="radio" id="control_02" name="select" value="2">
                <label for="control_02">
                    <img src="<?= Url::to('@eyAssets/images/pages/career-blog/smile25.png')?>">
                    <h3>Like a Little</h3>
                </label>
            </div>
            <div class="poll-ans-item col-md-3">
                <input type="radio" id="control_03" name="select" value="3">
                <label for="control_03">
                    <img src="<?= Url::to('@eyAssets/images/pages/career-blog/smile35.png')?>">
                    <h3>Indifferent</h3>
                </label>
            </div>
            <div class="poll-ans-item col-md-3">
                <input type="radio" id="control_04" name="select" value="4">
                <label for="control_04">
                    <img src="<?= Url::to('@eyAssets/images/pages/career-blog/smile45.png')?>">
                    <h3>Not Much</h3>
                </label>
            </div>
            <div class="poll-ans-item col-md-3">
                <input type="radio" id="control_05" name="select" value="5">
                <label for="control_05">
                    <img src="<?= Url::to('@eyAssets/images/pages/career-blog/smile55.png')?>">
                    <h3>Not at All</h3>
                </label>
            </div>

        </div>
    </div>
</div>

<?php
$this->registerCss('
.poll-main{
    margin: 50px 0px;
    padding: 10px 10px;
    border-radius: 5px;
//    background-color: #356BAB;
    box-shadow:0 0 10px rgba(0,0,0,.2);
}

input[type="radio"] {
    display: none;
}
input[type="radio"]:not(:disabled) ~ label {
    cursor: pointer;
}
input[type="radio"]:disabled ~ label {
    color: #bcc2bf;
    border-color: #bcc2bf;
    box-shadow: none;
    cursor: not-allowed;
}

.poll-ans-item > label {
    height: 80px;
    display: block;
    background: white;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 1rem;
    margin-bottom: 1rem;
    text-align: center;
    box-shadow: 0px 3px 10px 2px rgba(57, 57, 57, 0.5);
    position: relative;
}

input[type="radio"]:checked + label {
    background: #20df80;
    color: white;
    box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);
    border-color: #20df80;
    -webkit-animation-name: checked_label; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 1s; /* Safari 4.0 - 8.0 */
    animation-name: checked_label;
    animation-duration: 1s;
}
@-webkit-keyframes checked_label {
    from {background: white;box-shadow: 0px 3px 10px 2px rgba(57, 57, 57, 0.5);border-color: #ddd;}
    to {background: #20df80;box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);border-color: #20df80;}
}
@keyframes checked_label {
    from {background: white;box-shadow: 0px 3px 10px 2px rgba(57, 57, 57, 0.5);border-color: #ddd;}
    to {background: #20df80;box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);border-color: #20df80;}
}
.poll-ans-item{
    width: 20%;
    padding: 0px 5px;
}
.poll-image-m img{
    width: 100%;
}
.poll-question h2{
    font-size: 25px;
    color: #000;
    text-align:center;
    font-weight: 700;
    margin-bottom: 35px;
}
.poll-ans-item > label >h3{
    position: absolute;
    font-size: 15px;
    font-weight: 600;
    width: 100%;
    text-transform: uppercase;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, 0px);
    font-family: inherit;
}
.poll-ans-item label img{
    width: 25px;
    float: none;
    transition:1s all
}
.poll-ans-item label:hover img{
    animation: rotateFace 1s infinite; 
    animation-direction:alternate;
    transform: scale(.1)
}
@keyframes rotateFace{
    0%{
        transform: rotate(50deg);
        -webkit-transform: rotate(50deg);
        transition:1s ease;
    }
    100%{
        transform: rotate(-50deg);
        -webkit-transform: rotate(-50deg);
    }
} 
@-webkit-keyframes rotateFace{
        0%{
        transform: rotate(50deg);
        -webkit-transform: rotate(50deg);
    }
    100%{
        transform: rotate(-50deg);
        -webkit-transform: rotate(-50deg);
    }
} 

input[type="radio"]:checked + label h3{
    opacity: 0;
    -webkit-animation-name: checked_h3; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 1s; /* Safari 4.0 - 8.0 */
    animation-name: checked_h3;
    animation-duration: 1s;
}
@-webkit-keyframes checked_h3 {
    from {opacity: 1;}
    to {opacity: 0;}
}
@keyframes checked_h3 {
    from {opacity: 1;}
    to {opacity: 0;}
}
input[type="radio"]:checked + label img{
    width: 50px;
    float: none;
    -webkit-animation-name: checked_img; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 1s; /* Safari 4.0 - 8.0 */
    animation-name: checked_img;
    animation-duration: 1s;
}
@-webkit-keyframes checked_img {
    from {width: 25px;float: none;}
    to {width: 50px;float: none;}
}
@keyframes checked_img {
    from {width: 25px;float: none;}
    to {width: 50px;float: none;}
}
')
?>
