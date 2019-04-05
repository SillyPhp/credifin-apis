<?php

use yii\helpers\Url;
?>


<nav class="min-nav" id="min-nav">
    <ul class="nav nav-stacked navbar-fixed-top">
        <li><a href="#home" data-toggle="tooltip" data-placement="right" title="About Me" class="active"><i class="fa fa-home"></i></a></li>
        <li><a href="#exp" data-toggle="tooltip" data-placement="right" title="Experience"><i class="fa fa-briefcase"></i></a></li>
        <li><a href="#edu" data-toggle="tooltip" data-placement="right" title="Education"><i class="fa fa-graduation-cap"></i></a></li>
        <li><a href="#skills" data-toggle="tooltip" data-placement="right" title="Skills"><i class="fa fa-cogs" ></i></a></li>
        <!--<li><a href="#portfolio" data-toggle="tooltip" data-placement="right" title="Portfolio"><i class="fa fa-folder-open"></i></a></li>-->
        <!--<li><a href="#recommendation" data-toggle="tooltip" data-placement="right" title="Recommendation"><i class="fa fa-pencil"></i></a></li>-->
        <!--<li><a href="#blog" data-toggle="tooltip" data-placement="right" title="Blog"><i class="fa fa-comments"></i></a></li>-->
        <!--<li><a href="" data-toggle="tooltip" data-placement="right" title="Say Hello"><i class="fa fa-envelope-o"></i></a></li>-->
    </ul>
</nav>  
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="sections">   
    <section id="home">    
        <div class="jumbo">
            <div class="container">
                <div class="can-user-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-thumbnail "/></div>
            </div>
        </div>

        <div class="large-container">
            <div class="bdy-content">
                <div class="row">
                    <div class="col-md-5 col-sm-4 head-btns">
                        <div class="col-md-5 col-sm-12">
                            <div class="head-btn1">
                                <a href="">
                                    <i class="fa fa-volume-control-phone"></i>
                                    <span class="btn-txt"> Contact Me</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class=" head-btn1 head-btn11">
                                <a href="">
                                    <i class="fa fa-envelope-o"></i>
                                    <div class="btn-txt2"> Send Email</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-offset-2 col-md-5 col-sm-offset-4 col-sm-4 head-btns">
                        <div class="col-md-offset-1 col-md-5 col-sm-12 ">
                            <div class="head-btn2">
                                <a href="">
                                    <i class="fa fa-cloud-download"></i>
                                    <div class="btn-txt"> Download CV</div>
                                </a>  
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class=" head-btn2 head-btn11">
                                <a href="">
                                    <i class="fa fa-list-ul"></i>
                                    <div class="btn-txt"> Shortlist Profile</div>
                                </a>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="bdy-content">
                        <div class="col-md-12 can-name-heading"><?= $user['first_name']; ?> <?= $user['last_name']; ?></div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="row">
                    <div class="personal-info col-md-12">
                        <div class="personal-detail col-md-6">
                            <h1 class="heading-style ">About Me</h1>
                            <div class="per-discription"><?= $user['description']; ?></div>
                        </div>
                        <div class="col-md-6 per">
                            <div class="per-det col-md-12 row">
                                <h1 class="heading-style col-md-12">Personal Details</h1>
                                <div class="col-md-6 col-sm-6">
                                    <div class="can-name col-md-6 col-sm-4">Nationality:</div>
                                    <div class="can-name-fill col-md-6 col-sm-8">Indian</div>
                                </div>
                                <div class="col-md-6 col-sm-6 ">
                                    <div class="can-name col-md-4 col-sm-4">Skype:</div>
                                    <div class="can-name-fill col-md-6 col-sm-8">YourSkype</div>
                                </div>

                                <div class="col-md-6 col-sm-6 per-ped">
                                    <div class="can-name col-md-6 col-sm-4">Marital:</div>
                                    <div class="can-name-fill col-md-6 col-sm-8">Single</div>
                                </div>
                                <div class="col-md-6 col-sm-6 per-ped">
                                    <div class="can-name col-md-4 col-sm-4">Phone:</div>
                                    <div class="can-name-fill col-md-8 col-sm-8"><?= $user['phone']; ?></div>
                                </div>

                                <div class="col-md-6 col-sm-6 per-ped">
                                    <div class="can-name col-md-6 col-sm-4">DOB:</div>
                                    <div class="can-name-fill col-md-6 col-sm-8">28-09-1993</div>
                                </div>
                                <div class="col-md-6 col-sm-6 per-ped">
                                    <div class="can-name col-md-4 col-sm-4">Email:</div>
                                    <div class="can-name-fill col-md-6 col-sm-8"><?= $user['email']; ?></div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="wrap">
                                        <div class="social">
                                            <a href="<?= $user['facebook']; ?>"><i class="fa fa-facebook fb"></i></a>
                                            <a href="<?= $user['twitter']; ?>"><i class="fa fa-twitter tw"></i></a>
                                            <a href="<?= $user['youtube']; ?>"><i class="fa fa-youtube yt"></i></a>
                                            <a href="<?= $user['linkedin']; ?>"><i class="fa fa-linkedin lk"></i></a>
                                            <a href="<?= $user['skype']; ?>"><i class="fa fa-skype sk"></i></a>
                                            <a href="<?= $user['instagram']; ?>"><i class="fa fa-instagram db"></i></a>
                                            <a href="<?= $user['google']; ?>"><i class="fa fa-google apple"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div> 
        </div> 
    </section>        
    <!--<div class="clearfix"></div>-->
    <!-- experience -->
    <section id="exp">
        <div class="large-container">
            <div class="row">
                <div class="exp col-md-12">
                    <div class="bdy-content">
                        <h1 class="heading-style ">Work Experience</h1>
                        <div class="exp-box1 ">
                            <div class="minus-padding col-md-1">
                                <div class="com-line com-mark">
                                    <i class="fa fa-bullseye"></i>
                                </div>
                                <div class="com-mark-img">
                                </div>
                            </div>
                            <div class="exp-time col-md-3"> 
                                <div class="com-name">DSB Edu Tech</div>
                                <div class="com-loc">Ludhiana</div>
                                <div class="com-time">
                                    <div class="col-md-6">
                                        <div class="com-t">From</div>
                                        <div class="com-due">July - 2018</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="com-t">To</div>
                                        <div class="com-due">Present</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="time-du">( 2 years 9 months )</div>
                            </div>
                            <div class="exp-post col-md-8">
                                <div class="post">WEB DESIGNER</div>
                                <div class="role">Tasks Performed</div>
                                <div class="duty">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,versions of Lorem Ipsum.</div>
                            </div> 
                        </div>

                        <div class="clearfix"></div> 

                        <div class="exp-box1 ">
                            <div class="minus-padding col-md-1">
                                <div class="com-line com-mark">
                                    <i class="fa fa-bullseye"></i>
                                </div>
                                <div class="com-mark-img">
                                </div>
                            </div>
                            <div class="exp-time col-md-3"> 
                                <div class="com-name">DSB Edu Tech</div>
                                <div class="com-loc">Ludhiana</div>
                                <div class="com-time">
                                    <div class="col-md-6">
                                        <div class="com-t">From</div>
                                        <div class="com-due">July - 2018</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="com-t">To</div>
                                        <div class="com-due">Present</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="time-du">( 2 years 9 months )</div>
                            </div>
                            <div class="exp-post col-md-8">
                                <div class="post">WEB DESIGNER</div>
                                <div class="role">Tasks Performed</div>
                                <div class="duty">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,versions of Lorem Ipsum.</div>
                            </div> 
                        </div>

                        <div class="clearfix"></div> 

                        <div class="exp-box1 ">
                            <div class="minus-padding col-md-1">
                                <div class="com-mark">
                                    <i class="fa fa-bullseye"></i>
                                </div>
                                <div class="com-mark-img">
                                </div>
                            </div>
                            <div class="exp-time col-md-3"> 
                                <div class="com-name">DSB Edu Tech</div>
                                <div class="com-loc">Ludhiana</div>
                                <div class="com-time">
                                    <div class="col-md-6">
                                        <div class="com-t">From</div>
                                        <div class="com-due">July - 2018</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="com-t">To</div>
                                        <div class="com-due">Present</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="time-du">( 2 years 9 months )</div>
                            </div>
                            <div class="exp-post col-md-8">
                                <div class="post">WEB DESIGNER</div>
                                <div class="role">Tasks Performed</div>
                                <div class="duty">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,versions of 
                                    Lorem Ipsum.</div>
                            </div> 
                        </div>
                    </div>   
                </div> 
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
    <!-- education -->    
    <section id="edu">
        <div class="large-container">
            <div class="edu">
                <div class="bdy-content">
                    <h1 class="heading-style ">Qualification</h1>
                    <div class="col-md-offset-1 col-md-5">
                        <div class="edubox1">
                            <div class="edu-icon"><i class="fa fa-graduation-cap"></i></div>   
                            <div class="h-school-name">Degree Name</div>
                            <div class="bord-name">University Name</div>
                            <div class="h-year">
                                2010-2011
                            </div>
                        </div> 
                    </div>
                    <div class=" col-md-5">
                        <div class="edubox1">
                            <div class="edu-icon"><i class="fa fa-graduation-cap"></i></div>   
                            <div class="h-school-name">Degree Name</div>
                            <div class="bord-name">University Name</div>
                            <div class="h-year">
                                2010-2011
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="clearfix"></div>

    <!--Skills-->
    <section id="skills">
        <div class="large-container">
            <div class="row">    
                <div class="skills col-md-12">
                    <div class="bdy-content">
                        <div class="col-md-8">
                            <h1 class="heading-style">Skills & Language</h1>
                            <div class="keyheading">Key Skills</div>
                            <div class="col-md-6">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width: 55%" aria-valuenow="55" >HTML</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width: 65%;" aria-valuenow="65" >CSS</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width: 75%" aria-valuenow="75" >Photoshop</div>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width: 40%" aria-valuenow="40" >Javascript</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width: 80%" aria-valuenow="80" >Coraldraw</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width: 80%" aria-valuenow="80" >Bootstrap</div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="skill-tags">
                                <div class="additionalskills">Additional Skills</div>
                                <ul>
                                    <li>HTML</li>
                                    <li>CSS</li>
                                    <li>Javascript</li>
                                    <li>Photoshop</li>
                                    <li>CoralDraw</li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-4 communication">
                            <div class="keyheading">Communication</div>
                            <div class="col-md-12 com-prog">
                                <div class="communication-lvl">Novice <span>Intermediate</span><span> Advanced</span></div>      
                                <div class="progress margin-top-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar"  aria-valuenow="90" 
                                         aria-valuemin="0" aria-valuemax="100" >English</div>
                                </div>
                            </div>
                            <div class="col-md-12 com-prog">
                                <div class="communication-lvl">Novice <span>Intermediate</span><span> Advanced</span></div>
                                <div class="progress  margin-top-0">
                                    <div class="progress-bar progress-bar-info" role="progressbar"  aria-valuenow="90" 
                                         aria-valuemin="0" aria-valuemax="100" >Hindi</div>
                                </div>
                            </div>
                            <div class="col-md-12 com-prog">
                                <div class="communication-lvl">Novice <span>Intermediate</span><span> Advanced</span></div>
                                <div class="progress margin-top-0">
                                    <div class="progress-bar progress-bar-warning " aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                                         role="progressbar" >Punjabi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="clearfix"></div>
<?php
$this->registerCss('
    .large-container{
   max-width: 1400px !important;
   padding-left: 15px;
   padding-right: 15px;
   margin:auto;
}
.bdy-content{margin:0 100px;  }
.jumbo{background: url(../assets/themes/ey/images/pages/candidate-profile/cover.jpg) no-repeat fixed; background-size: cover; width: 100%; height: 100%; min-height: 350px; 
       border-bottom:3px solid #eee}
.nav{background: #00a0e3; max-width: 60px; top:15%; left:0%; box-shadow: 0px 0px 35px rgb(0,0,0,.3);}
.min-nav li a{background: #00a0e3; color: #fff; text-align: center; font-size: 25px; padding: 10px 0 ;  }
.min-nav > .nav >li a.active {color:#00a0e3 !important; background: #fff !important;}
.min-nav li a:hover {color:#00a0e3; background: #fff; transition:.3s ease-in-out; }
.tooltip{background: transparent;}
.tooltip-inner{background: #00a0e3; font-size: 16px; padding: 10px 10px; min-width: 100px; } 
.tooltip.right .tooltip-arrow {
  top: 50%;
  left: 0;
  margin-top: -6px;
  border-width: 6px 6px 6px 0;
  border-right-color: #00a0e3;
}
.can-name-heading{margin: 0 auto; text-align: center; margin-top: 15px; margin-left: 10px;
                 font-size: 28pt; color: #00a0e3; font-family: lobster;}
.can-user-icon{max-height: 200px; max-width: 200px; margin: 0 auto; z-index: 9999; }
.can-user-icon img{  max-height: 200px; max-width: 200px; margin-top:250px;box-shadow: 0px 0px 25px rgb(0,0,0,.3); }
.about{padding-bottom: 20px; }
.text-right{ text-align: right; }
.head-btns {margin-top:30px; padding:0 0 20px 0; text-align: center;  }
.head-btn1,.head-btn2{ max-width: 200px;} 
.head-btn1 a{  padding: 10px 0px; font-size: 14px; display: flex; justify-content: center;
             border-left: 2px solid #00a0e3; border-right: 2px solid #00a0e3; border-radius: 30px 0px 30px 0px;
             filter:gray; -webkit-filter: grayscale(1);  filter: grayscale(1);  }
.head-btn1 i, .head-btn2 i{font-size: 20px; padding: 0 5px 0 0; text-align: center; justify-content: center;  line-height: 18px !important; }
.head-btn1 a:hover,.head-btn2 a:hover {text-decoration: none; background: #00a0e3; color: #fff; transition: .3s ease-in-out;    
                                            filter:none; -webkit-filter: grayscale(0);}
.head-btn2 a{  padding: 10px 0px; font-size: 14px; display: flex; justify-content: center; 
                border-left: 2px solid #00a0e3; border-right: 2px solid #00a0e3; border-radius: 30px 0px 30px 0px;
                  filter:gray; -webkit-filter: grayscale(1);  filter: grayscale(1); }
.btn-txt{margin-top:0px;}
.btn-txt2{margin-top:0px;}
.personal-info{padding-top: 30px;}
.pi-heading{ font-size: 25px; }

.heading-style{
   font-family: lobster;
   font-size: 28pt;
   text-align: left;
   margin: 15px 5px;
}
.heading-style:before{
   content: "";
   position: absolute;
   width: 0;
   height: 0;
   border-style: solid;
   border-width: 0 0 5px 52px;
   border-color: #f07706;
}
.per-discription{ font-size: 15px; line-height: 20px; text-align: justify;}
.per-det{margin-top: 0px;
      border-left: 1px solid rgb(238, 238, 238, .4);}
.per-heading{font-size: 20px; font-family:  Open Sans; font-weight: Bold; padding-bottom: 20px;}
.can-name{padding: 0px 0 0 0; font-weight: bold;}
.can-name-fill{padding: 0px 0 0 15px;}
.per-ped{padding-top: 5px}
.social a{width:auto;float:left;}


/*Experience Section*/
.com-mark{ background: #00a0e3;  font-size: 25px; text-align: center; color:#fff; margin-top:55px; border-top-left-radius: 50px; 
           border-bottom-left-radius: 50px; padding: 20px 0 20px 15px;}
.com-line:before{ content: "";
   position: absolute;
   width: 0;
   height: 150%;
   margin: 55px 0 0 10px;
   border-style: solid;
   border-width: 50px 0px 5px 3px;
   border-color: #00a0e3; }
.com-mark-img{ margin: -2px 0 0 20px; background: none;}
.minus-padding{padding-right :0px !important;}
.exp{ background: #ecf1f7; padding: 20px 0 50px 0; box-shadow: 0 0 25px rgb(0,0,0,.3)}
.exp-box1{padding: 5px; margin-top: 30px;}
.exp-time{ padding: 30px; text-align: center; background: #00a0e3; color:#fff;
         box-shadow: inset 0px 0px 15px rgb(0, 0, 0, .1)}
.com-name{font-size: 20px; font-weight: bold; font-family: open sans;}
.com-loc{font-size: 15px; font-weight: bold; font-family: open sans; font-style: oblique;}
.com-time{padding:20px 0; font-size:15px; font-family: open sans;   }
.com-due{font-weight: bold; font-size: 16px;}
.com-t{font-size:13px;}
.time-du{text-transform: uppercase; font-size: 12px; padding-top: 5px; font-style: oblique; font-weight: bold; 
        font-family: open sans;}
.exp-post{padding: 20px; background: #fff; min-height: 240px; }
.post{font-size: 20px; font-family: open sans; text-transform: uppercase; font-weight: bold;}
.role{text-transform: uppercase; font-family: open sans; font-weight: bold; padding:10px; }
.duty{font-size:14px;}

/*education section*/
.edu{padding: 30px 0 50px 0;}
.edubox1{ text-align: center; padding: 20px 0; box-shadow: 0 0 10px rgb(0,0,0,.5); border-radius: 0px 10% ;
         background: #eee; margin-bottom: 20px; border:1px solid #fff;} 
.h-school-name{font-size: 16px; font-family: open sans; padding-top: 10px; font-weight: bold; }
.bord-name{font-size: 16px; font-family: open sans;  font-weight: bold;}
.h-year{font-size: 16px; font-family: open sans; font-weight: bold;}
.edu-icon{font-size: 65px; color: #00a0e3; }
.edu-icon{margin: 0 auto; background:  rgb(255,255,255,.3); border: 1px solid #fff; max-height: 125px; max-width:125px;
         border-radius: 50% }

/*Skills Section*/
.skills{background: #ecf1f7; padding: 30px 0; margin-top:30px; box-shadow: 0 0 25px rgb(0,0,0,.3);   }
.skill-tags{display: inline; padding-top:10px; }
.skill-tags ul li span{color:#333339; font-size:16px; text-transform: uppercase; font-weight: bold; background: none; }
.skill-tags ul{padding-left: 10px;}
.skill-tags ul li{ display: inline; background: rgb(255,255,255,.6); padding: 5px 10px; border-radius: 10px; font-size: 14px; 
                  font-style: oblique; margin: 0 3px;}
.progress , .progress-bar{height: 15px; font-size: 10px; line-height: 15px;}
.progress{margin: 15px 0 0px 0;}
.custom-bg{background: #00a3e0; }
.keyheading, .additionalskills{font-size: 18px; font-family: open sans; font-weight: bold; padding-left: 15px;}
.additionalskills{padding: 15px 0 15px 15px;}
.margin-top-0{margin-top: 0px !important;}
.communication{padding-top:80px;}
.communication-lvl{font-size: 12px; color: #333;}
.communication-lvl span{padding-left:62px; }
.com-prog{margin-top: 10px;}


@media (min-width:992px) and (max-width:1100px){
    .head-btn1 i, .head-btn2 i{display:none;}
    .head-btn1,.head-btn2{ max-width: 150px;} 
    .can-user-icon img{margin-left: 0px;}
    .head-btn1 a, .head-btn2 a{ padding-left: 5px; padding-right: 5px;}
}
@media screen and (max-width:992px){
    
    .can-name-heading{margin-top: 0px; margin-left: -30px;}
    .head-btn11{margin-top:20px; }
    /*.btn-txt, .btn-txt2{display:none;}*/
    .head-btn1 a, .head-btn2 a{text-align: center;}
    .bdy-content{margin:0 50px 0 100px; }
    .can-user-icon img{margin-left: 20px;}
    .per-det{border: none; padding: 0 0 0 0;}
    .per{padding-top: 20px;}
    .com-mark{display: none;}
}

@-webkit-keyframes wiggle {
  0% {
    -webkit-transform: rotateZ(5deg);
            transform: rotateZ(2deg);
  }
  50% {
    -webkit-transform: rotateZ(-2deg);
            transform: rotateZ(-2deg);
  }
  100% {
    -webkit-transform: rotateZ(2deg);
            transform: rotateZ(2deg);
  }
}
.wrap {
  width: 100%;
 margin-top: 40px;
  text-align: center;
}
.social {
  font-size: 3em;
  height: 55px;
  overflow: hidden;
}
.social i {
  position: relative;
  top: 12px;
  margin: 0 10px;
  transition: all 100ms cubic-bezier(0.42, 0, 0.58, 1);
}
.social i:hover {
  top: 1px;
}

.fb {
  color: #3B5998;
}

.tw {
  color: #09AEEC;
}

.yt {
  color: #AA2A25;
}

.lk {
  color: #0077B5;
}

.sk {
  color: #00A5E6;
}

.db {
  color: #000;
}

.apple {
  color: #dd4b39;
}

.gallary .fa.fa-plus {
    height: 30px;
	width: 30px;
	border: 1px solid #FCAC45;
	font-size: 20px;
	padding: 5px;
	border-radius: 50%;
	color: #FCAC45;
}
.gallary ul {
	padding: 10px 0;
}
.gallary ul li {
	display: inline-block;
	margin-top: 10px;
}
.gallary ol li {
	display: inline-block;
	margin-left: 20px;
}
.gallary ol li:last-child a:after {
	content: "";
}
.gallary ol li a {
	color: #00a0e3;
        font-size: 18px;
        font-weight: 500;
        border: 1px solid #00a0e3;
        padding: 5px 10px;
        background: #00a0e3;
        color:#fff;
        border-radius: 15px;
}
.gallary ol li a:hover{
    text-decoration: none;
    color: #fff;
    background: #ff7803;
    border: 1px solid #ff7803;       
}
.gallary ol li a.active {
        color: #ff7803;
        text-decoration: none;
         border: 1px solid #ff7803;
         background: #ff7803;
         color: #fff;
}
.gallary .gallary-item {
    margin-bottom: 20px !important;
    display: block;
    position: relative;
    margin: 0 auto;
    max-width: 400px;
}
.gallary .gallary-item img{
    max-width: 300px;
    max-height: 250px;
}
.gallary .gallary-item .hover-bg {
	overflow: hidden;
	position: relative;
}
.gallary .hover-bg .hover-text {
	position: absolute;
	text-align: center;
	margin: 0 auto;
	color: #ffffff;
	background: rgba(0, 0, 0, 0.66);
	padding: 25% 0;
	height: 100%;
	width: 100%;
	opacity: 0;
	transition: all 0.5s;
}
.gallary .hover-bg .hover-text>h4 {
	opacity: 0;
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
	transition: all 0.3s;
}

.gallary .hover-bg:hover .hover-text>h4 {
	opacity: 1;
	-webkit-backface-visibility: hidden;
	-webkit-transform: translateY(0);
	transform: translateY(0);
}
.gallary .hover-bg .hover-text>i {
	opacity: 0;
	-webkit-transform: translateY(0);
	transform: translateY(0);
	transition: all 0.3s;
}
.gallary .hover-bg:hover .hover-text>i {
	opacity: 1;
	-webkit-backface-visibility: hidden;
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
}
.isotope-item { 
    z-index: 2;
}
.isotope-hidden.isotope-item { 
	z-index: 1;
}
.isotope,
.isotope .isotope-item {
    -webkit-transition-duration: 0.8s;
    -moz-transition-duration: 0.8s;
    transition-duration: 0.8s;
}
.isotope-item {
    margin-right: -1px;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
}
.isotope {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: height, width;
    -moz-transition-property: height, width;
    transition-property: height, width;
}
.isotope .isotope-item {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform, opacity;
    -moz-transition-property: -moz-transform, opacity;
    transition-property: transform, opacity;
}

@media (max-width: 767px) {
    .isotope {
        height: auto !important;
    }
    .isotope-item {
    	text-align: center;
    	transform: none !important;
    	position: relative !important;
    }
}
.progress-bar .percent{
    display:none;
}
');
$script = <<< JS
document.body.scrollTop = 0;
document.documentElement.scrollTop = 0;
   
     
$('[data-toggle="tooltip"]').tooltip();
var objectPositionTop = $('#skills').offset().top;
//$(window).on('scroll', function () {
//    var currentPosition = $(document).scrollTop();
//    if (currentPosition >= objectPositionTop) {
//        $('.progress .progress-bar').css("width",
//            function () {
//                return $(this).attr("aria-valuenow") + "%";
//            }
//        )
//
//    }
//});

var container = $('.animate-grid .gallary-thumbs');
container.isotope({
    filter: '*',
    animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false
    }
});
 var sections = $('section')
                        , nav = $('nav')
                        , nav_height = nav.outerHeight();

                $(window).on('scroll', function () {
                    var currentPosition = $(document).scrollTop();

                    sections.each(function () {
                        var top = $(this).offset().top - nav_height,
                                bottom = top + $(this).outerHeight();

                        if (currentPosition >= top && currentPosition <= bottom) {
                            nav.find('a').removeClass('active');
                            sections.removeClass('active');

                            $(this).addClass('active');
                            nav.find('a[href="#' + $(this).attr('id') + '"]').addClass('active');
                        }
                    });

//                    var currentPosition = $(document).scrollTop();
                    if (currentPosition >= objectPositionTop) {
                        $('.progress .progress-bar').css("width",
                                function () {
                                    return $(this).attr("aria-valuenow") + "%";
                                }
                        )
                    }
                });

                nav.find('li a').on('click', function () {
                    var el = $(this)
                            , id = el.attr('href');

                    $('html, body').animate({
                        scrollTop: $(id).offset().top - nav_height
                    }, 500);

                    return false;
                });        
$('.animate-grid .categories a').click(function () {
    $('.animate-grid .categories .active').removeClass('active');
    $(this).addClass('active');
    var selector = $(this).attr('data-filter');
    container.isotope({
        filter: selector,
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
    return false;
});
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@eyAssets/js/candidates-list/modernizr-2.8.3-respond-1.4.2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery.isotope.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
