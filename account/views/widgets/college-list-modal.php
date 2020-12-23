<?php

use yii\helpers\Url;

?>
<div class="frame">
    <div class="college">
        <div class="inset college">
            <div class="button close"><i class="fa fa-close"></i></div>

            <div class="body-college">
                <div class="college-row" id="college_modal">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="overlay"></div>

<?php
$this->registerCss('
.college-row {
	display: flex;
	justify-content: center;
	align-items: center;
	flex-wrap: wrap;
}
.colleges {
	width: 170px;
	box-shadow: 0 0 4px 0px rgba(0,0,0,0.3);
	margin: 0 5px 12px;
	padding: 20px 10px 10px;
}
.colleges img {
	width: 80px;
	height: 80px;
	object-fit: contain;
}
.colleges p {
	font-size: 14px;
	font-family: roboto;
	height: 42px;
	margin: 10px 0 0 0;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  background-color: #fff;
  opacity: 0;
  visibility: hidden;
  z-index: 9999;
  height: 100vh;
  -moz-transition: opacity 0.25s ease 0s, visibility 0.35s linear;
  -o-transition: opacity 0.25s ease 0s, visibility 0.35s linear;
  -webkit-transition: opacity 0.25s ease, visibility 0.35s linear;
  -webkit-transition-delay: 0s, 0s;
  transition: opacity 0.25s ease 0s, visibility 0.35s linear;
}
.overlay.state-show {
  opacity: .7;
  visibility: visible;
  -moz-transition-delay: 0s;
  -o-transition-delay: 0s;
  -webkit-transition-delay: 0s;
  transition-delay: 0s;
  -moz-transition-duration: 0.2s, 0s;
  -o-transition-duration: 0.2s, 0s;
  -webkit-transition-duration: 0.2s, 0s;
  transition-duration: 0.2s, 0s;
}

.frame {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 99999;
  /*     display: table; */
  display: -webkit-flex;
  display: flex;
  -webkit-align-items: center;
  align-items: center;
  -moz-box-align: center;
  -webkit-box-pack: center;
  -webkit-justify-content: center;
  justify-content: center;
  -moz-box-pack: center;
  -ms-flex-pack: center;
  width: 100%;
  text-align: center;
  visibility: hidden;
}
.frame.state-appear {
  visibility: visible;
}
.frame.state-appear .inset {
  -moz-animation: modalComeIn 0.25s ease;
  -webkit-animation: modalComeIn 0.25s ease;
  animation: modalComeIn 0.25s ease;
  visibility: visible;
  /* to keep @ final state */
}
.frame.state-appear .body-college {
  opacity: 1;
  -moz-transform: translateY(0) scale(1, 1);
  -ms-transform: translateY(0) scale(1, 1);
  -webkit-transform: translateY(0) scale(1, 1);
  transform: translateY(0) scale(1, 1);
}
.frame.state-leave {
  visibility: visible;
}
.frame.state-leave .inset {
  -moz-animation: modalHeadOut 0.35s ease 0.1s;
  -webkit-animation: modalHeadOut 0.35s ease 0.1s;
  animation: modalHeadOut 0.35s ease 0.1s;
  visibility: visible;
}
.frame.state-leave .body-college {
  opacity: 0;
  -moz-transition-delay: 0s;
  -o-transition-delay: 0s;
  -webkit-transition-delay: 0s;
  transition-delay: 0s;
  -moz-transition-duration: 0.35s;
  -o-transition-duration: 0.35s;
  -webkit-transition-duration: 0.35s;
  transition-duration: 0.35s;
  -moz-transition-timing-function: ease;
  -o-transition-timing-function: ease;
  -webkit-transition-timing-function: ease;
  transition-timing-function: ease;
  -moz-transform: translateY(25px);
  -ms-transform: translateY(25px);
  -webkit-transform: translateY(25px);
  transform: translateY(25px);
}

@-moz-document url-prefix() {
  .frame {
    height: calc(100% - 55px);
  }
}
.college {
  display: block;
  vertical-align: middle;
  text-align: center;
}

.inset {
  position: relative;
  padding: 30px 20px 20px;
  background-color: white;
  min-width: 320px;
  max-width: 950px;
  min-height: 126px;
  max-height: 75vh;
  overflow-x: hidden;
overflow-y: scroll;
  margin: auto;
  visibility: hidden;
  -moz-box-shadow: 2px 2px 8px 1px rgba(0, 0, 0, 0.2);
  -webkit-box-shadow: 2px 2px 8px 1px rgba(0, 0, 0, 0.2);
  box-shadow: 2px 2px 8px 1px rgba(0, 0, 0, 0.2);
  -moz-backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -moz-transform: translate3d(0, 0, 0);
  -ms-transform: translate3d(0, 0, 0);
  -webkit-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
  -moz-transform-style: preserve-3d;
  -webkit-transform-style: preserve-3d;
  transform-style: preserve-3d;
  top:35px;
}
.inset .close {
  display: block;
  cursor: pointer;
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 10px;
  opacity: .4;
}
.inset .close:hover {
  opacity: 1;
}
.body-college {
  margin: auto;
  opacity: 0;
  -moz-transform: translateY(0) scale(0.8, 0.8);
  -ms-transform: translateY(0) scale(0.8, 0.8);
  -webkit-transform: translateY(0) scale(0.8, 0.8);
  transform: translateY(0) scale(0.8, 0.8);
  -moz-transition-property: opacity, -moz-transform;
  -o-transition-property: opacity, -o-transform;
  -webkit-transition-property: opacity, -webkit-transform;
  transition-property: opacity, transform;
  -moz-transition-duration: 0.25s;
  -o-transition-duration: 0.25s;
  -webkit-transition-duration: 0.25s;
  transition-duration: 0.25s;
  -moz-transition-delay: 0.1s;
  -o-transition-delay: 0.1s;
  -webkit-transition-delay: 0.1s;
  transition-delay: 0.1s;
}
@-webkit-keyframes modalComeIn {
  0% {
    visibility: hidden;
    opacity: 0;
    -moz-transform: scale(0.8, 0.8);
    -ms-transform: scale(0.8, 0.8);
    -webkit-transform: scale(0.8, 0.8);
    transform: scale(0.8, 0.8);
  }
  65.5% {
    -moz-transform: scale(1.03, 1.03);
    -ms-transform: scale(1.03, 1.03);
    -webkit-transform: scale(1.03, 1.03);
    transform: scale(1.03, 1.03);
  }
  100% {
    visibility: visible;
    opacity: 1;
    -moz-transform: scale(1, 1);
    -ms-transform: scale(1, 1);
    -webkit-transform: scale(1, 1);
    transform: scale(1, 1);
  }
}
@-moz-keyframes modalComeIn {
  0% {
    visibility: hidden;
    opacity: 0;
    -moz-transform: scale(0.8, 0.8);
    -ms-transform: scale(0.8, 0.8);
    -webkit-transform: scale(0.8, 0.8);
    transform: scale(0.8, 0.8);
  }
  65.5% {
    -moz-transform: scale(1.03, 1.03);
    -ms-transform: scale(1.03, 1.03);
    -webkit-transform: scale(1.03, 1.03);
    transform: scale(1.03, 1.03);
  }
  100% {
    visibility: visible;
    opacity: 1;
    -moz-transform: scale(1, 1);
    -ms-transform: scale(1, 1);
    -webkit-transform: scale(1, 1);
    transform: scale(1, 1);
  }
}
@keyframes modalComeIn {
  0% {
    visibility: hidden;
    opacity: 0;
    -moz-transform: scale(0.8, 0.8);
    -ms-transform: scale(0.8, 0.8);
    -webkit-transform: scale(0.8, 0.8);
    transform: scale(0.8, 0.8);
  }
  65.5% {
    -moz-transform: scale(1.03, 1.03);
    -ms-transform: scale(1.03, 1.03);
    -webkit-transform: scale(1.03, 1.03);
    transform: scale(1.03, 1.03);
  }
  100% {
    visibility: visible;
    opacity: 1;
    -moz-transform: scale(1, 1);
    -ms-transform: scale(1, 1);
    -webkit-transform: scale(1, 1);
    transform: scale(1, 1);
  }
}
@-webkit-keyframes modalHeadOut {
  0% {
    visibility: visible;
    opacity: 1;
    -moz-transform: translateY(0) scale(1, 1);
    -ms-transform: translateY(0) scale(1, 1);
    -webkit-transform: translateY(0) scale(1, 1);
    transform: translateY(0) scale(1, 1);
  }
  100% {
    visibility: hidden;
    opacity: 0;
    -moz-transform: translateY(35px) scale(0.97, 0.97);
    -ms-transform: translateY(35px) scale(0.97, 0.97);
    -webkit-transform: translateY(35px) scale(0.97, 0.97);
    transform: translateY(35px) scale(0.97, 0.97);
  }
}
@-moz-keyframes modalHeadOut {
  0% {
    visibility: visible;
    opacity: 1;
    -moz-transform: translateY(0) scale(1, 1);
    -ms-transform: translateY(0) scale(1, 1);
    -webkit-transform: translateY(0) scale(1, 1);
    transform: translateY(0) scale(1, 1);
  }
  100% {
    visibility: hidden;
    opacity: 0;
    -moz-transform: translateY(35px) scale(0.97, 0.97);
    -ms-transform: translateY(35px) scale(0.97, 0.97);
    -webkit-transform: translateY(35px) scale(0.97, 0.97);
    transform: translateY(35px) scale(0.97, 0.97);
  }
}
@keyframes modalHeadOut {
  0% {
    visibility: visible;
    opacity: 1;
    -moz-transform: translateY(0) scale(1, 1);
    -ms-transform: translateY(0) scale(1, 1);
    -webkit-transform: translateY(0) scale(1, 1);
    transform: translateY(0) scale(1, 1);
  }
  100% {
    visibility: hidden;
    opacity: 0;
    -moz-transform: translateY(35px) scale(0.97, 0.97);
    -ms-transform: translateY(35px) scale(0.97, 0.97);
    -webkit-transform: translateY(35px) scale(0.97, 0.97);
    transform: translateY(35px) scale(0.97, 0.97);
  }
}
@media only screen and (max-width: 600px) {
  body {
    background-color: lightblue;
  }
}
');
$script = <<<JS
 var modal = $('.frame');
    var overlay = $('.overlay');

    /* Need this to clear out the keyframe classes so they dont clash with each other between ener/leave. Cheers. */
    modal.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e){
      if(modal.hasClass('state-leave')) {
        modal.removeClass('state-leave');
      }
    });

    $('.close').on('click', function(){
      overlay.removeClass('state-show');
      modal.removeClass('state-appear').addClass('state-leave');
      $('body').removeClass('modal-open');
    });
    
    // $(document).on('click', '.open', function(){
    //   $('.overlay').addClass('state-show');
    //   $('.frame').removeClass('state-leave').addClass('state-appear');
    //   $('body').addClass('modal-open');
    // });
    
    var ps = new PerfectScrollbar('.inset');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script id="college-modal" type="text/template">
    {{#.}}

    <div class="colleges">
        <a href="/{{slug}}" target="_blank"> <img src="{{college_logo}}"></a>
        <a href="/{{slug}}" target="_blank" title="{{{college_name}}}"><p>{{{college_name}}}</p></a>
    </div>

    {{/.}}
</script>
