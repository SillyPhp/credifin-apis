<div id="mycarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
    <?php
    if (count($webinars) > 1) {
      foreach ($webinars as $x => $webinar) {
        if ($x !== 0) {
    ?>
          <li data-target="#mycarousel" data-slide-to="<?= $x ?>"></li>

    <?php }
      }
    } ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php
    foreach ($webinars as $webinar) {
    ?>
      <div class="item webiItems">
        <div id="<?= $webinar['webinar_enc_id'] ?>"></div>
        <?= $this->render($webinar['template_path'] . '/' . $webinar['template_name'],  [
          'webinar_enc_id' => $webinar['webinar_enc_id'],
        ]) ?>
      </div>
    <?php
    }
    ?>
    <!-- more slides here -->
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php
$this->registerCss('
.carousel-indicators .active{
  background-color: #d1d1d1;
}
.carousel-indicators li{
  border: 1px solid #d1d1d1;
}
  // #mycarousel{
  //   display: none;
  // }
  .item{
    margin: 0 !important;
    text-align: unset !important;
    color: unset !important;
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

@media only screen and (max-width: 575px){
  #mycarousel {
    height: 650px;
    overflow: hidden;
  }
  .item > section {
    padding: 0 !important; 
    max-height: 750px;
    min-height: 750px;
  }
}
@media (min-width:576px) and (max-width: 767px){
  .item > section {
    min-height: 750px;
    max-height: 750px;
}
.item.webiItems section {
  min-height: 650px !important;
}
}
@media (min-width: 768px) and (max-width: 991px){
  .item > section {
    min-height: 450px;    
  }
}
');
$script = <<<JS
function getWebinarDetails(id){
    $.ajax({
        url: 'webinars/webinar-widget-detail',
        method: 'POST',
        data: {'webinar_enc_id': id},
        success: function(response){
            let temp = $('#temp_'+id).html()
            $('#'+id).html(Mustache.render(temp, response.detail))
        },
        complete: function (){
            let webiItems = document.querySelectorAll('.webiItems') 
            if($(webiItems[0]).hasClass('active')){
               return false 
            }else{
                $(webiItems[0]).addClass('active');
            }
        }   
    })
}

JS;
$this->registerJs($script)
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