<?php
$imgArray = ['gd2.png', 'gd3.png', 'gd4.png', 'gd5.png', 'gd6.png'];
$colorArray = ['#C7DDEF', '#F9A18B', '#525E7A', '#FED217', '#525E7A'];
$randomIndex = rand(0,4);
?>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<div class="godaddy-offer <?= $revert ? 'revert' : ''?>">
    <div class="logo">
        <img src="https://godaddyacademy.com/img/godaddy-logo.png"/>
    </div>
    <div class="bg-box" style="background: <?= $colorArray[$randomIndex];?>;"></div>
    <div class="banner-img">
        <img src="/assets/themes/ey/images/pages/webinar-widgets/<?=$imgArray[$randomIndex];?>"/>
    </div>
    <div class="offer">
        <div class="offer-text">
            <span class="upper-text">Shape Your Career with GoDaddy <?= $course ? $course . ' Course' : "";?></span>
            <?php if($webinar){ ?>
            <h1>Attend a webinar and avail <?= $discount ? $discount : '20';?>% discount on GoDaddy Academy Courses</h1>
            <?php } else{ ?>
            <h1>Apply for an education loan and get <?= $discount ? $discount : '20';?>% discount on GoDaddy Academy Courses</h1>
            <?php } ?>
            <a href="/courses/godaddy-academy">Check Out</a>
        </div>
    </div>
    <img src="/assets/themes/ey/images/pages/webinar-widgets/godaddy5.png" class="verticle-logo-design"/>
</div>
<?php
$this->registerCss("
.verticle-logo-design{
    position: absolute;
    width: 265px;
    transform: rotate(-90deg);
    right: -50px;
    bottom: 100px;
}
.godaddy-offer{
  width: 100%;
  height: 480px;
  background: #fff;
  position: relative;
  color:#111;
  margin: 20px 0;
}

.bg-box{
  background: #FED217;
  width: 80%;
  height: 100%;
}
.logo img,.banner-img img{
  width: 100%;
}
.banner-img{
  width: 250px;
  position: absolute;
  top: 50%;
  left: 80%;
  transform: translate(-50%, -50%);
}
.logo{
  position: absolute;
  top: 10px;
  left: 10px;
  width: 150px;
}
.godaddy-offer .offer *{
    font-family: 'Playfair Display', serif;
}
.godaddy-offer .offer{
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  max-width: 650px;
  left: 80px;
  font-family: 'Playfair Display', serif;
}
.upper-text{
    font-weight: 600;
    font-family: monospace;
    color: #222;
    font-size:18px;
}
.offer h1{
  font-weight: 800;
  font-size: 2.5rem;
  margin:0px;
  color:#111;
}
.offer a{
  text-decoration: none;
  background: #fff;
  padding: 10px 20px;
  display: inline-block;
  margin-top: 20px;
  color: #333;
  font-weight: 700;
}
.godaddy-offer.revert{
    direction:rtl;
}
.godaddy-offer.revert .banner-img{
    right: 65%;
    left: auto;
}
.godaddy-offer.revert .offer{
    right: 17%;
    left: auto;
    text-align: left;
}
@media only screen and (max-width: 991px){
  .godaddy-offer .offer{
    max-width: 450px;
  }
}
@media only screen and (max-width: 767px){
  .banner-img {
    width: 195px;
    }
    .bg-box{
        width: 100%;
    }
    .godaddy-offer .offer {
        max-width: 300px;
        left: 18px;
    }
    .verticle-logo-design{
        transform: rotate(0deg);
        bottom: 10px;
        left: 10px;
        right: auto;
      }
    }
  @media only screen and (max-width: 575px){     
    .godaddy-offer .offer {
      max-width: 196px;
  }
}
");