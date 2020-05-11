<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="alerts">
    <?=
    Html::button('<i class="fas fa-envelope"></i> Email Jobs', [
        'class' => 'btn btn-md bubbly-button',
        'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'jobalert'),
        'id' => 'open-modal',
        'data-toggle' => 'modal',
        'data-target' => '#myModal2',
    ]);
    ?>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
.alerts{
    position:fixed;
    left:0%;
    bottom:2%;
    z-index:9999;
}
.bubbly-button {
  font-family: "Helvetica", "Arial", sans-serif;
  display: inline-block;
  font-size: 1em;
  padding: 1em 2em;
  margin-left:10px;
  -webkit-appearance: none;
  appearance: none;
  background-color: #ed4303;
  color: #fff;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  position: relative;
  transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
  box-shadow: 0 2px 25px rgba(237, 67, 3, 0.5);
}
.bubbly-button:hover {
    color:#FFF;
}
.bubbly-button:focus {
  outline: 0;
  color:#FFF;
}
.bubbly-button:before, .bubbly-button:after {
  position: absolute;
  content: "";
  display: block;
  width: 140%;
  height: 100%;
  left: -20%;
  z-index: 999999 !important;
  transition: all ease-in-out 0.5s;
  background-repeat: no-repeat;
}
.bubbly-button:before {
  display: none;
  top: -75%;
  background-image: radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, transparent 20%, #ed4303 20%, transparent 30%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ed4303 15%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%);
  background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;
}
.bubbly-button:after {
  display: none;
  bottom: -75%;
  background-image: radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ed4303 15%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%);
  background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;
}
.bubbly-button:active {
  transform: scale(0.9);
  background-color: #de4f19;
  box-shadow: 0 2px 25px rgba(237, 67, 3, 0.5);
}
.bubbly-button.animate:before {
  display: block;
  animation: topBubbles ease-in-out 0.75s forwards;
}
.bubbly-button.animate:after {
  display: block;
  animation: bottomBubbles ease-in-out 0.75s forwards;
}

@keyframes topBubbles {
  0% {
    background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;
  }
  50% {
    background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;
  }
  100% {
    background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;
    background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
  }
}
@keyframes bottomBubbles {
  0% {
    background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;
  }
  50% {
    background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;
  }
  100% {
    background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;
    background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
  }
}
');
$script = <<<JS
    $(document).on("click", "#open-modal", function () {
        $(".modal-body").load($(this).attr("url"));
    });
    
    $(".btn_effect").hover(function () {
        $(this).toggleClass("is-active");
    });
            
    var animateButton = function(e) {
    
      e.preventDefault;
      e.target.classList.remove('animate');
      
      e.target.classList.add('animate');
      setTimeout(function(){
        e.target.classList.remove('animate');
      },700);
    };
    
    var bubblyButtons = document.getElementsByClassName("bubbly-button");
    
    for (var i = 0; i < bubblyButtons.length; i++) {
      bubblyButtons[i].addEventListener('click', animateButton, false);
    }
JS;
$this->registerJs($script);