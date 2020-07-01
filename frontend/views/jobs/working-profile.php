<?php
$this->params['header_dark'] = false;

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="bg-img"></section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">All Job Profiles</div>
                </div>
            </div>
            <div class="row">
                <div id="job-profiles"></div>
            </div>
        </div>
    </section>

<!--    <section>-->
<!--        <div class="container padd-top-0">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12 col-sm-12 col-xs-12">-->
<!--                    <ul class="nav nav-tabs nav-padd-20">-->
<!--                        <li class="active"><a data-toggle="tab" href="#jobs" class="fontt">Top Sales Job</a></li>-->
<!--                        <li><a data-toggle="tab" href="#marketing" class="fontt">Top Marketing Jobs</a></li>-->
<!--                        <li><a data-toggle="tab" href="#it" class="fontt">Top Information Technology Jobs</a></li>-->
<!--                        <li><a data-toggle="tab" href="#accounting" class="fontt">Top Accounting Jobs </a></li>-->
<!--                                                <li><a data-toggle="tab" href="#menu4" class="fontt"></a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                                <div class="col-md-4 col-sm-12 col-xs-12">-->
<!--                                    <div class="follow-btn">-->
<!--                                        <button class="follow">Follow</button>-->
<!--                                    </div>-->
<!--                                    <div class="social-btns">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
<!---->
<!--    <section>-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="tab-content">-->
<!--                    <div id="jobs" class="tab-pane fade in active">-->
<!--                                            <div class="row">-->
<!--                                                <div class="heading-style">Top JObs</div>-->
<!--                                            </div>-->
<!--                        <div class="divider"></div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-4 col-sm-12 col-xs-12 pt-5">-->
<!--                                <div class="application-card-main">-->
<!--                        <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;-->
<!--                      </span>-->
<!---->
<!--                                    <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India-->
<!--                        </span>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">-->
<!--                                        <div class="application-card-img">-->
<!--                                            <a href="" title="">-->
<!--                                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                        <div class="application-card-description">-->
<!--                                            <a href="" title=""><h4 class="application-title">Sales manager</h4></a>-->
<!--                                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>-->
<!--                                            <h5>Full Time</h5>-->
<!--                                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12">-->
<!--                                        <h4 class="org_name text-right">dsb law group</h4>-->
<!--                                    </div>-->
<!--                                    <div class="application-card-wrapper">-->
<!--                                        <a href="" class="application-card-open" title="View Detail">View Detail</a>-->
<!--                                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i-->
<!--                                                    class="fas fa-plus"></i>&nbsp;</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="marketing" class="tab-pane">-->
<!--                                            <div class="row">-->
<!--                                                <div class="heading-style">Top Internships</div>-->
<!--                                            </div>-->
<!--                        <div class="divider"></div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-4 col-sm-12 col-xs-12 pt-5">-->
<!--                                <div class="application-card-main">-->
<!--                        <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;-->
<!--                      </span>-->
<!---->
<!--                                    <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India-->
<!--                        </span>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">-->
<!--                                        <div class="application-card-img">-->
<!--                                            <a href="" title="">-->
<!--                                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                        <div class="application-card-description">-->
<!--                                            <a href="" title=""><h4 class="application-title">Marketing</h4></a>-->
<!--                                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>-->
<!--                                            <h5>Full Time</h5>-->
<!--                                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12">-->
<!--                                        <h4 class="org_name text-right">dsb law group</h4>-->
<!--                                    </div>-->
<!--                                    <div class="application-card-wrapper">-->
<!--                                        <a href="" class="application-card-open" title="View Detail">View Detail</a>-->
<!--                                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i-->
<!--                                                    class="fas fa-plus"></i>&nbsp;</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="it" class="tab-pane">-->
<!--                                            <div class="row">-->
<!--                                                <div class="heading-style">Top Cities</div>-->
<!--                                            </div>-->
<!--                        <div class="divider"></div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-4 col-sm-12 col-xs-12 pt-5">-->
<!--                                <div class="application-card-main">-->
<!--                        <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;-->
<!--                      </span>-->
<!---->
<!--                                    <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India-->
<!--                        </span>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">-->
<!--                                        <div class="application-card-img">-->
<!--                                            <a href="" title="">-->
<!--                                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                        <div class="application-card-description">-->
<!--                                            <a href="" title=""><h4 class="application-title">web design</h4></a>-->
<!--                                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>-->
<!--                                            <h5>Full Time</h5>-->
<!--                                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12">-->
<!--                                        <h4 class="org_name text-right">dsb law group</h4>-->
<!--                                    </div>-->
<!--                                    <div class="application-card-wrapper">-->
<!--                                        <a href="" class="application-card-open" title="View Detail">View Detail</a>-->
<!--                                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i-->
<!--                                                    class="fas fa-plus"></i>&nbsp;</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="accounting" class="tab-pane">-->
<!--                        <div class="divider"></div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-4 col-sm-12 col-xs-12 pt-5">-->
<!--                                <div class="application-card-main">-->
<!--                        <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;-->
<!--                      </span>-->
<!---->
<!--                                    <span class="application-card-type location">-->
<!--                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India-->
<!--                        </span>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">-->
<!--                                        <div class="application-card-img">-->
<!--                                            <a href="" title="">-->
<!--                                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                        <div class="application-card-description">-->
<!--                                            <a href="" title=""><h4 class="application-title">Accountant</h4></a>-->
<!--                                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>-->
<!--                                            <h5>Full Time</h5>-->
<!--                                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-md-12 col-sm-12 col-xs-12">-->
<!--                                        <h4 class="org_name text-right">dsb law group</h4>-->
<!--                                    </div>-->
<!--                                    <div class="application-card-wrapper">-->
<!--                                        <a href="" class="application-card-open" title="View Detail">View Detail</a>-->
<!--                                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i-->
<!--                                                    class="fas fa-plus"></i>&nbsp;</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

<?php
$this->registerCss('
.fontt{
    font-size: 15px !important;
    font-family: roboto !important;
    }
.bg-img{
    background: url(\'/assets/themes/ey/images/job-profiles/jobprofilebg.png\');
    min-height: 400px;
    background-position: bottom;
    background-repeat: no-repeat;
    background-size:cover;
    }
.divider{
    border-top:1px solid #eee;
    padding:0 0 20px 0;
}
');

$script = <<<JS
    
JS;
$this->registerJs($script);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->render('/widgets/mustache/working-profile-card');