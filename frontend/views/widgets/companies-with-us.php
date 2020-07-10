<?php
use yii\helpers\Url;
?>
    <section class="companies">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="com-grid">
                        <h1 class="heading-style">Companies With Us</h1>
                        <div class="ac-subheading">Companies recruiting top talent from our portal.</div>
                        <div class="all-coms"><a href="/organizations">View All Companies</a></div>
                        <div class="com1 animatable fadeIn">
                            <a href="/capitalbank" title="Capital Small Finance Bank">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/capital-small-finance.png') ?>" alt="Capital Small Finance Bank" title="Capital Small Finance Bank" />
                                </div>
                                <div class="com-name">
                                    Capital Small Finance Bank
                                </div>
                            </a>
                        </div>
                        <div class="com2 animatable fadeIn">
                            <a href="/midland" title="Midland MicroFin">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>" alt="Midland MicroFin" title="Midland MicroFin" />
                                </div>
                                <div class="com-name">
                                    Midland MicroFin
                                </div>
                            </a>
                        </div>
                        <div class="com3 animatable fadeIn">
                            <a href="/dsb" title="DSB Law Group">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/dsb.png') ?>" alt="DSB Law Group" title="DSB Law Group" />
                                </div>
                                <div class="com-name">
                                    DSB Law Group
                                </div>
                            </a>
                        </div>
                        <div class="com4 animatable fadeIn">
                            <a href="/citizensbank" title="Citizens Bank">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/citizen-bank.png') ?>" alt="Citizens Bank" title="Citizens Bank" />
                                </div>
                                <div class="com-name">
                                    Citizens Bank
                                </div>
                            </a>
                        </div>
                        <div class="com5 animatable fadeIn">
                            <a href="/agile" title="Agile Finserv">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/agile.png') ?>" alt="Agile Finserv" title="Agile Finserv" />
                                </div>
                                <div class="com-name">
                                    Agile Finserv
                                </div>
                            </a>
                        </div>
                        <div class="com6 animatable fadeIn">
                            <a href="/becre8v" title="Be Cre8v">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/be-creative.png') ?>" alt="Be Cre8v" title="Be Cre8v" />
                                </div>
                                <div class="com-name">
                                    Be Cre8v
                                </div>
                            </a>
                        </div>
                        <div class="com8 animatable fadeIn">
                            <a href="/amritmalwa" title="Amrit Malwa Capital Limited">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/amrit-malwa.png') ?>" alt="Amrit Malwa Capital Limited" title="Amrit Malwa Capital Limited" />
                                </div>
                                <div class="com-name">
                                    Amrit Malwa Capital Limited
                                </div>
                            </a>
                        </div>
                        <div class="com9 animatable fadeIn">
                            <a href="/hamco" title="Hamco Ispat">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>" alt="Hamco Ispat" title="Hamco Ispat" />
                                </div>
                                <div class="com-name">
                                    Hamco Ispat
                                </div>
                            </a>
                        </div>
                        <div class="com10 animatable fadeIn">
                            <a href="/upmoney" title="Up Money Ltd">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/up-money.png') ?>" alt="Up Money Ltd" title="Up Money Ltd" />
                                </div>
                                <div class="com-name">
                                    Up Money Ltd
                                </div>
                            </a>
                        </div>
                        <div class="com11 animatable fadeIn">
                            <a href="/apurva" title="Code Nomad">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/codenomad.png') ?>" alt="Code Nomad" title="Code Nomad" />
                                </div>
                                <div class="com-name">
                                    Code Nomad
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.ac-subheading{
    margin-top:-15px;
    font-family:Roboto;
    font-weight:400;
}
.all-coms a{
    color:#00a0e3;
}
.all-coms{
    font-family: roboto;
}
.all-coms a:hover{
    font-weight:500;
    font-family: roboto;
    margin-left:10px;
    transition:.3s ease;
}
/*companies section css*/
.companies{
    margin-top:20px;
    position:relative;
    padding:0 0 105px 0;
}
.com-grid{
    text-transform:capitalize;
    min-height:400px;
    position:relative;
}
.com-logo{
    width:100px;
    height:100px;
    background:#fff;
    border-radius:50%;
    box-shadow: 8px 13px 30px 5px rgba(162, 153, 153, 0.3);
    padding: 18px !important; 
    line-height: 0px;
}
.com-name{ 
    padding-top:8px;
    font-size:15px;
    display:none;
    line-height:20px;
    max-width:109px;
    font-weight:500;
    font-family: roboto;
    text-align:center;
    color:#00a0e3;
}
.com-logo:hover ~ .com-name{
    display:block;
}
.com-logo img{
    max-width:100%;
    max-height:100%;
    position: relative;
    top:50%;
    left:50%;
    -webkit-transform: translate(-50%, -50%); 
    transform: translate(-50%, -50%); 
}
.com1, .com2, .com3, .com4, .com5, .com6, .com7, .com8, .com9, .com10, .com11{
      position:absolute;
}
.com1{
   top: -23px;
    left: 51%;
}
.com5{
    top: 1%;
    left: 84%;;
}
.com2{
   top: 31%;
    left: 40%;
}
.com3{
    top:21%;
    left:65%;
}
.com4{
   top: 42%;
    left: 81%;
}
.com6{
    top: 55%;
    left: 18%;
} 
.com7{
    top: 55%;
    left: 24%;
}
.com8{
   top: 63%;
   left: 51%;
}
.com9{
    top: 83%;
    left: 69%;
}
.com10{
    top: 78%;
    left: 90%;
}
.com11{
    top: 84%;
    left: 32%;
}
/*companies css ends*/
.animated.fadeIn {
	-webkit-animation-name: fadeIn;
	-moz-animation-name: fadeIn;
	-o-animation-name: fadeIn;
	animation-name: fadeIn;
}
.animatable {
  
  /* initially hide animatable objects */
  visibility: hidden;
  
  /* initially pause animatable objects their animations */
  -webkit-animation-play-state: paused;   
  -moz-animation-play-state: paused;     
  -ms-animation-play-state: paused;
  -o-animation-play-state: paused;   
  animation-play-state: paused; 
}

/* show objects being animated */
.animated {
  visibility: visible;
  
  -webkit-animation-fill-mode: both;
  -moz-animation-fill-mode: both;
  -ms-animation-fill-mode: both;
  -o-animation-fill-mode: both;
  animation-fill-mode: both;
  
  -webkit-animation-duration: .3s;
  -moz-animation-duration: .3s;
  -ms-animation-duration: .3s;
  -o-animation-duration: .3s;
  animation-duration: .3s;

  -webkit-animation-play-state: running;
  -moz-animation-play-state: running;
  -ms-animation-play-state: running;
  -o-animation-play-state: running;
  animation-play-state: running;
}
@-webkit-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@-moz-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@-o-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@keyframes fadeIn {
	0% {
		opacity: 0;
	}
	60% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@media screen and (max-width: 767px){
    .com-grid{
        min-height:480px;
    }
    .com1{
        top: 0%;
        left: 75%;
    }
    .com5{
        top: 28%;
        left: 5%;;
    }
    .com2{
       top: 30%;
        left: 41%;
    }
    .com3{
        top:33%;
        left:75%;
    }
    .com4{
       top: 59%;
        left: 30%;
    }
    .com6{
        top: 62%;
        left: 66%;
    } 
    .com7{
        top: 80%;
        left: 5%;
    }
    .com8{
       top: 90%;
       left: 47%;
    }
    .com9{
        top: 93%;
        left: 77%;
    }
    .com10{
        top: 65%;
        left: 2%;
    }
    .com11{
       display:none;
    }
}
@media screen and (max-width: 495px){
    .com-grid{
        min-height:580px;
    }
    
    .companies{
        padding: 0px 0 55px 0;
    }
    
    .header-row{
        margin-top:10px;
    }
    .com1{
        top: 22%;
        left: -2%;
    }
    .com5{
        top: 19%;
        left: 36%;;
    }
    .com2{
       top: 22%;
        left: 73%;
    }
    .com3{
        top:50%;
        left:-2%;
    }
    .com4{
       top: 47%;
        left: 36%;
    }
    .com6{
        top: 50%;
        left: 73%;
    } 
    .com8{
       top: 80%;
       left: -2%;
    }
    .com9{
        top: 77%;
        left: 36%;
    }
    .com10{
        top: 80%;
        left: 73%;
    }   
}
');
$this->registerJs("
var doAnimations = function() {
    var offset = $(window).scrollTop() + $(window).height(), animatables = $('.animatable');
    if (animatables.length == 0) {
      $(window).off('scroll', doAnimations);
    }
		animatables.each(function(i) {
       var animatable = $(this);
			if ((animatable.offset().top + animatable.height() - 20) < offset) {
        animatable.removeClass('animatable').addClass('animated');
	}
      });
    };
    $(window).on('scroll', doAnimations);
  $(window).trigger('scroll'); 
");
?>