   <!--image slider start-->
    <div class="slider">
      <div class="slides">
        <!--radio buttons start-->
        <input type="radio" name="radio-btn" id="radio1">
        <input type="radio" name="radio-btn" id="radio2">
        <!--radio buttons end-->
        <!--slide images start-->
        <div class="slide first">
            <?= $this->render('/widgets/webinar-templates/webinar-one-speaker')?>
        </div>
        <div class="slide">
            <?= $this->render('/widgets/webinar-templates/webinar-one-speaker1')?>
        </div>
        <!--slide images end-->
        <!--automatic navigation start-->
        <div class="navigation-auto">
          <div class="auto-btn1"></div>
          <div class="auto-btn2"></div>
        </div>
        <!--automatic navigation end-->
      </div>
      <!--manual navigation start-->
      <div class="navigation-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
      </div>
      <!--manual navigation end-->
      
    </div>
    <!--image slider end-->

<?php
$this->registerCss('
  
  .slider{
    width: 100%;
    overflow: hidden;
    margin-bottom: 50px;
  }
  
  .slides{
    width: 500%;
    display: flex;
  }
  
  .slides input{
    display: none;
  }
  
  .slide{
    width: 20%;
    transition: 2s;
  }
  
  
  /*css for manual slide navigation*/
  
  .navigation-manual{
    position: absolute;
    width: 100%;
    margin-top: 10px;
    display: flex;
    justify-content: center;
  }
  
  .manual-btn{
    border: 2px solid #b7b7b7;
    padding: 5px;
    border-radius: 10px;
    cursor: pointer;
    transition: 1s;
  }
  
  .manual-btn:not(:last-child){
    margin-right: 10px;
  }
  
  .manual-btn:hover{
    background: #b7b7b7;
  }
  
  #radio1:checked ~ .first{
    margin-left: 0;
  }
  
  #radio2:checked ~ .first{
    margin-left: -20%;
  }
  
  #radio3:checked ~ .first{
    margin-left: -40%;
  }
  
  #radio4:checked ~ .first{
    margin-left: -60%;
  }
  
  /*css for automatic navigation*/
  
  .navigation-auto{
    position: absolute;
    display: flex;
    width: 100%;
    justify-content: center;
    margin-top: 560px;
  }
  
  .navigation-auto div{
    border: 2px solid #b7b7b7;
    padding: 5px;
    border-radius: 10px;
    transition: 1s;
  }
  
  .navigation-auto div:not(:last-child){
    margin-right: 10px;
  }
  
  #radio1:checked ~ .navigation-auto .auto-btn1{
    background: #b7b7b7;
  }
  
  #radio2:checked ~ .navigation-auto .auto-btn2{
    background: #b7b7b7;
  }
  
  #radio3:checked ~ .navigation-auto .auto-btn3{
    background: #b7b7b7;
  }
  
  #radio4:checked ~ .navigation-auto .auto-btn4{
    background: #b7b7b7;
  }

  @media only screen and (max-width: 767px){
    .navigation-auto{
        margin-top: 760px;
      }
  }
  @media only screen and (max-width: 576px){
    .navigation-auto{
        margin-top: 660px;
      }
  }
        
');


$script = <<<JS

jQuery(document).ready(function ($) {

setInterval(function () {
    moveRight();
}, 3000);

var slideCount = $('#slider ul li').length;
var slideWidth = $('#slider ul li').width();
var slideHeight = $('#slider ul li').height();
var sliderUlWidth = slideCount * slideWidth;

$('#slider').css({ width: slideWidth, height: slideHeight });

$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

$('#slider ul li:last-child').prependTo('#slider ul');

function moveLeft() {
    $('#slider ul').animate({
        left: + slideWidth
    }, 200, function () {
        $('#slider ul li:last-child').prependTo('#slider ul');
        $('#slider ul').css('left', '');
    });
};

function moveRight() {
    $('#slider ul').animate({
        left: - slideWidth
    }, 200, function () {
        $('#slider ul li:first-child').appendTo('#slider ul');
        $('#slider ul').css('left', '');
    });
};

$('a.control_prev').click(function () {
    moveLeft();
});

$('a.control_next').click(function () {
    moveRight();
});

});    

JS;

?>


<script type="text/javascript">
    var counter = 1;
    setInterval(function(){
      document.getElementById('radio' + counter).checked = true;
      counter++;
      if(counter > 2){
        counter = 1;
      }
    }, 12000);
    </script>