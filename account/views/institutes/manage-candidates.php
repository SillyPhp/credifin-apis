<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Application Processes of candidates</h3>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (!empty($users)) {
                                foreach ($users as $u) {
                                    ?>
                                    <div class="row cd-box">
                                        <div class="cd-can-box">
                                            <div class="cd-box-border" id="cd-box-border">
                                                <div class="row">
                                                    <div class=" cd-user-icon col-md-6">
                                                        <a href="/<?= $u['appliedEnc']['username'] ?>" target="_blank">
                                                            <?php
                                                            $name = $image = NULL;
                                                            if (!empty($u['appliedEnc']['image'])) {
                                                                $image = Yii::$app->params->upload_directories->users->image . $u['appliedEnc']['image_location'] . DIRECTORY_SEPARATOR . $u['appliedEnc']['image'];
                                                            }
                                                            $name = $u['appliedEnc']['name'];
                                                            if ($image):
                                                                ?>
                                                                <img src="<?= $image; ?>" alt="<?= $name; ?>"
                                                                     class="img-circle"/>
                                                            <?php else: ?>
                                                                <img src="https://ui-avatars.com/api/?name=<?= $name . '&size=200&rounded=false&background=' . str_replace("#", "", $u['appliedEnc']['initials_color']) . '&color=ffffff' ?>"
                                                                     alt="<?= $name; ?>" class="img-circle"/>
                                                            <?php endif; ?>
                                                        </a>
                                                        <div class="cand-name capitalize">
                                                            <a href="/<?= $u['appliedEnc']['username'] ?>"
                                                               target="_blank">
                                                                <?= $u['appliedEnc']['name'] ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="vj-btn col-md-6">
                                                        <a href="<?= Url::to('/' . $u['appliedEnc']['username']); ?>">View
                                                            Profile</a>
                                                    </div>
                                                </div>
                                                <div class="row margn">
                                                    <div class="col-md-5 col-sm-12 col-xs-12">
                                                        <div class="cmp-profile">
                                                            <div class="cmp-logo">
                                                                <?php
                                                                $org_name = $org_logo = NULL;
                                                                if (!empty($u['appliedEnc']['applicationEnc']['organizationEnc']['logo'])) {
                                                                    $org_logo = Yii::$app->params->upload_directories->organizations->logo . $u['appliedEnc']['applicationEnc']['organizationEnc']['logo_location'] . DIRECTORY_SEPARATOR . $u['appliedEnc']['applicationEnc']['organizationEnc']['logo'];
                                                                }
                                                                $org_name = $u['appliedEnc']['applicationEnc']['organizationEnc']['name'];
                                                                if ($org_logo):
                                                                    ?>
                                                                    <img src="<?= $org_logo; ?>" alt="<?= $org_name; ?>"
                                                                         class="user-icon" style="width: 100%;"/>
                                                                <?php else: ?>
                                                                    <img src="https://ui-avatars.com/api/?name=<?= $org_name . '&size=200&rounded=false&background=' . str_replace("#", "", $u['appliedEnc']['applicationEnc']['organizationEnc']['org_initials']) . '&color=ffffff' ?>"
                                                                         alt="<?= $org_name; ?>" class="user-icon"
                                                                         style="width: 100%;"/>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="inline">
                                                                <h3 class="cmp-name"><a
                                                                            href="/<?= ($u['appliedEnc']['applicationEnc']['assigned_to'] == 'Jobs') ? 'job' : 'internship' ?>/<?= $u['appliedEnc']['applicationEnc']['application_slug'] ?>"><?= $u['appliedEnc']['applicationEnc']['application_title'] ?></a>
                                                                </h3>
                                                                <h5 class="cmp-desg"><a
                                                                            href="/<?= $u['appliedEnc']['applicationEnc']['organizationEnc']['slug'] ?>"><?= $u['appliedEnc']['applicationEnc']['organizationEnc']['name'] ?></a>
                                                                </h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 floating col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-12 padd">
                                                                <div class="steps-form-2">
                                                                    <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                                                        <?php
                                                                        $j = 1;
                                                                        foreach ($u['appliedEnc']['appliedApplicationProcesses'] as $d) {
                                                                            ?>
                                                                            <div class="steps-step-2 <?= ($j < $u['appliedEnc']['current_round']) ? 'active' : '' ?>">
                                                                                <a class="circle-group btn btn-circle-2 waves-effect btn-blue-grey <?php
                                                                                if ($j < $u['appliedEnc']['current_round']) {
                                                                                    echo 'active';
                                                                                } elseif ($j == $u['appliedEnc']['current_round']) {
                                                                                    echo 'current';
                                                                                }
                                                                                ?>" data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   data-original-title="<?= $d['field_name']; ?>">
                                                                                    <i class="<?= $d['icon']; ?>"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <?php
                                                                            $j++;
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--                                            <div class="row">-->
                                                <!--                                                <div class="col-md-4 col-sm-12 col-xs-12">-->
                                                <!--                                                    <div class="cmp-profile">-->
                                                <!--                                                        <div class="cmp-logo">-->
                                                <!--                                                            <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png"-->
                                                <!--                                                                 class="user-icon" style="width: 100%;">-->
                                                <!--                                                        </div>-->
                                                <!--                                                        <div class="inline">-->
                                                <!--                                                            <h3 class="cmp-name">empower youth</h3>-->
                                                <!--                                                            <h5 class="cmp-desg">web designer</h5>-->
                                                <!---->
                                                <!--                                                        </div>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-8 floating col-sm-12 col-xs-12">-->
                                                <!--                                                    <div class="row">-->
                                                <!--                                                        <div class="col-md-12 padd">-->
                                                <!--                                                            <div class="steps-form-2">-->
                                                <!--                                                                <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey current"-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="jL9zWvg3wlJxz9GN0PM5ypoqEG6OB1"-->
                                                <!--                                                                           data-original-title="Get Applications">-->
                                                <!--                                                                            <i class="fa fa-sitemap"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="EV8KoxNaQZzMAegqqQPqyp539GLgXD"-->
                                                <!--                                                                           data-original-title="Technical Inteview">-->
                                                <!--                                                                            <i class="fa fa-cogs"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="LREdPVpMwyooRen33AP6y3kGB1Ye4r"-->
                                                <!--                                                                           data-original-title="HR Interview">-->
                                                <!--                                                                            <i class="fa fa-user-circle"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="EV8KoxNaQZzMAegqWVxnyp539GLgXD"-->
                                                <!--                                                                           data-original-title="Video Call">-->
                                                <!--                                                                            <i class="fa fa-video-camera"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="rND6P3qwg7D0z3qOYRg674ajv0oeAQ"-->
                                                <!--                                                                           data-original-title="Written Examination">-->
                                                <!--                                                                            <i class="fa fa-pencil-square-o"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="rND6P3qwg7D0z3qOYWqP74ajv0oeAQ"-->
                                                <!--                                                                           data-original-title="Employee Verification">-->
                                                <!--                                                                            <i class="fa fa-check"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                    <div class="steps-step-2 ">-->
                                                <!--                                                                        <a type="button"-->
                                                <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                                <!--                                                                           data-toggle="tooltip"-->
                                                <!--                                                                           data-placement="top" title=""-->
                                                <!--                                                                           data-id="d8WwBN62KlBn2eGN6zj2ljpEJLD9mv"-->
                                                <!--                                                                           data-original-title="Hire Applicants">-->
                                                <!--                                                                            <i class="fa fa-paper-plane"-->
                                                <!--                                                                               aria-hidden="true"></i>-->
                                                <!--                                                                        </a>-->
                                                <!--                                                                    </div>-->
                                                <!--                                                                </div>-->
                                                <!--                                                            </div>-->
                                                <!--                                                        </div>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                            </div>-->
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <h2>The candidate hasn't applied for any application yet.</h2>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.cand-name{
    font-weight: bold;
    font-size: 16px;
    }
.margn{
    margin-top:20px;
    }
.cmp-logo{
    width: 65px;
    border: 5px solid #f9f9f9;
    border-radius: 4px;
    float: left;
    margin-right: 10px;
    background-color: #fff;
    margin-left:50px;
    }
.cmp-name{
    float:left;
    margin-top: 0;
    font-weight: 500;
    color: #555;
    text-transform:capitalize;
    }
.cmp-name a{
    color: #555;
}
.cmp-desg{
    float: left;
    clear: both;
    font-weight: 500;
    color: #777;
    margin:0px;
    }
.cmp-desg a{
    color: #777;
}
.inline{
    display: inline-block;
    }

.floating{
    float:right;
    }
.cmp-profile{
    margin-bottom:40px;
    }
.padd{
    margin-bottom:40px;
    }
.btn_hired{
    background-color: #8dd644;
    color: #fff;
    border: #8dd644;
}  
.btn_reject{
    background-color: #ff0000;
    color: #fff;
    border: #8dd644;
}
.btn_reject_temp{
    background-color: #ff0000;
    color: #fff;
    border: #8dd644;
    display:none;
}
.btn_hired_temp{
    background-color: #8dd644;
    color: #fff;
    border: #8dd644;
    display:none;
}
/*new*/
.slide-btn{
    text-align:center;
    margin-bottom:-1px;
    padding-top:10px;
}
.slide-bttn{
    background:#00a0e3;
    border:none;
    color:#fff;
    border-radius:10px 10px 0 0 !important;
    padding:1px 15px;
}
.slide-bttn:hover{
    box-shadow:0px -2px 8px rgba(0, 0, 0, .3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all; 
}
.slide-bttn:focus{
    outline:none;
}
/*new ends*/
.cd-box-border-hide{
    border:2px solid #eef1f4; 
    border-top:none;
    padding:10px 20px 0 10px; 
    background:#fff; 
    border-radius:0 0 10px 10px !important; 
    color:#999999;
    margin:0 20px; 
    display:none; 
}   
.btn.btn-outline.blue {
    border-color: #00a0e3;
    color: #00a0e3;
    background: 0 0;
}
.btn.btn-outline.blue:hover {
    border-color: #00a0e3 !important;
    color:#fff ;
    background:#00a0e3 !important;
}
.vj-btn{
    text-align:right;
    margin-top: -7px;
    right: 8px;
}
.vj-btn a{
    background:#00a0e3;
    padding:5px 10px;
    font-size:13px;
     color:#fff;
    border-radius:0 0 10px 10px !important; 
}
.vj-btn a:hover{
    box-shadow:0 4px 4px rgba(0,0,0,0.3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all;     
}
.cd-can-box{
    text-align-center !important; 
    margin-top:60px;
} 
//.cd-user-icon{margin:0 auto;}
.cd-user-icon img, .cd-user-icon canvas{
    max-width:80px; 
    height:80px; 
    margin-top:-50px;
    border-radius: 6px!important;
}
.cd-user-detail{padding:10px 0px 0 15px; }
.cd-box{
    margin-bottom:3px;
    padding:5px 15px;
}
.cd-box-border{
    border:2px solid #eef1f4; 
    padding:10px 20px 0 10px;
    background:#fff; 
    border-radius:10px !important;
    color:#999999; 
}
.cd-box-border:hover{
    box-shadow:0 0 20px rgb(0,0,0,.1); 
    background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg.jpg') . ');
    background-size:cover; color:#000 !important;
}                    
.cd-u-name{
    font-weight:bold; 
    font-size:16px; 
}
.cd-u-field{
    font-size:16px;
}
.cd-u-p-company{
    font-size:14px;
}
.cd-btns{
    text-align:center;
}
.cd-btns button{
    margin:20px 0 0 0;
}
.portlet.light .portlet-body{
    padding-top:0px;
}
.tooltip-inner {
    background-color: #00acd6 !important;
    color: #fff;
    padding:5px 10px;
    border-radius:20px !important;
}
.tooltip.top .tooltip-arrow {
    border-top-color: #00acd6;
}
a:hover{
    text-decoration:none;
}

/*stepbar css*/

.steps-form-2 {
    display: table;
    width: 100%;
    position: relative; 
}    
.steps-form-2 .steps-row-2 {
    display: table-row; 
}
.steps-form-2 .steps-row-2 .steps-step-2:before {
    top: 33px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 2px;
    background-color:#eee; 
    background: linear-gradient(to right, #00a0e3 50%, #eee 50%);
    background-size: 200% 100%;
    background-position:right bottom;
    transition:all 1s ease;
}
.steps-form-2 .steps-row-2 .steps-step-2.active:before {
    top: 33px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 2px;
    background-color:#eee; 
    background: linear-gradient(to right, #00a0e3 50%, #eee 50%);
    background-size: 200% 100%;
    background-position:left bottom;
    transition:all 1s ease;
}
.steps-form-2 .steps-row-2 .steps-step-2:last-child::before{
    content:"";
    display:none;
}
//.steps-form-2 .steps-row-2 .steps-step-2.active:after{
//   top: 33px;
//    bottom: 0;
//    position: absolute;
//    content: " ";
//    width: 100%;
//    height: 2px;
//    background-color:#00a0e3 !important; 
//}
.steps-form-2 .steps-row-2 .steps-step-2 {
    display: table-cell;
    text-align: center;
    position: relative; 
}
.steps-form-2 .steps-row-2 .steps-step-2 p {
    margin-top: 0.5rem; 
}
.steps-form-2 .steps-row-2 .steps-step-2 button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2 {
    width: 50px;
    height: 50px;
    border: 2px solid #eee;
    background-color: #fff !important;
    color: #eee !important;
    border-radius: 50% !important;
    padding: 18px 0px 15px 0px;
    margin-top: 8px; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2:hover,
.steps-form-2 .steps-row-2 .steps-step-2 .active{
    border: 2px solid #00a0e3;
    color: #fff !important;
    background-color: #00a0e3 !important; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .current{
      border: 2px solid #00a0e3;
    color: #00a0e3 !important;
    background-color: #fff !important; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2 .fa {
    font-size: 18px; 
}
@media only screen and (max-width: 675px){
    .steps-form-2, .steps-form-2 .steps-row-2, .steps-form-2 .steps-row-2 .steps-step-2 {
        display: block;
    }
    .steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2{
        margin-top: 18px;
    }
    .steps-form-2 .steps-row-2 .steps-step-2:before, .steps-form-2 .steps-row-2 .steps-step-2.active:before{
        top: 33px;
        left: 49.9%;
        width: 2px;
        height: 57px;
    }
     .vj-btn{
        margin-top: 0px;
        right: 0px;
    }
    .vj-btn a{
        display: inline-block;
        border-radius: 4px !important;
        margin: 5px;
    }
}
@media only screen and (max-width: 388px) and (min-width: 300px){
.cmp-logo{margin:auto}
}
');
$script = <<<JS
$('[data-toggle="tooltip"]').tooltip();

   
JS;
$this->registerJs($script);
?>