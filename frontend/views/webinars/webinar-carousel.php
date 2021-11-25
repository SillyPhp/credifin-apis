<div id="mycarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
 <!-- <ol class="carousel-indicators">
   <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
   <li data-target="#mycarousel" data-slide-to="1"></li>
 </ol> -->

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    </div>

    <!-- more slides here -->
  </div>

  <!-- Controls -->
 <!-- <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
   <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
   <span class="sr-only">Previous</span>
 </a>
 <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
   <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
   <span class="sr-only">Next</span>
 </a> -->
</div>
<?php
$this->registerCss('
  #mycarousel{
    display: none;
  }
.box {
  border: 1px solid grey;
  background-color: #d3d3d3;
}

.large {
  font-size: 150%;
}

.navbar-brand {
  font-size:1.8em;
}

 #topContainer {
    background-color: #e0e0e0;
background-size: cover;
width:100%;
}


#topRow h1 {
  font-size: 300%;
}

.bold {
  font-weight: bold;
}

.marginTop {
  margin-top: 30px;
}

.center {
  text-align:center;
}

.title {
  margin-top: 100px;
  font-size: 300%;
}


.full-screen {
background-size: cover;
background-position: center;
background-repeat: no-repeat;
}
 
.carousel-control{
  width: 5% !important;
  background: none !important;
}

@media only screen and (max-width: 576px){
  #mycarousel {
    height: 650px;
    overflow: hidden;
  }
}
');


?>


<!--<script type="text/javascript">-->
<!--  $('.carousel').carousel({-->
<!--    interval: 6000,-->
<!--    pause: "false"-->
<!--  });-->
<!---->
<!---->
<!--  var item = $('.carousel .item');-->
<!--  var wHeight = $(window).height();-->
<!---->
<!--  item.height(wHeight);-->
<!--  item.addClass('full-screen');-->
<!---->
<!--  $('.carousel img').each(function() {-->
<!--    var src = $(this).attr('src');-->
<!--    var color = $(this).attr('data-color');-->
<!--    $(this).parent().css({-->
<!--      'background-image': 'url(' + src + ')',-->
<!--      'background-color': color-->
<!--    });-->
<!--    $(this).remove();-->
<!--  });-->
<!---->
<!--  $(window).on('resize', function() {-->
<!--    wHeight = $(window).height();-->
<!--    item.height(wHeight);-->
<!--  });-->
<!--</script>-->