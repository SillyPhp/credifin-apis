<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section class="rh-header">
    <div class="container">
        <div class="row">
            <div class=" col-md-2 col-md-offset-0 col-sm-4 col-sm-offset-2">
                <div class="logo-box">
                    <div class="logo">
                        <!--<img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">-->
                        <img src="<?= Url::to('@eyAssets/images/pages/review/dummy-logo.png') ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="com-name">Company Name</div>
                <div class="com-rating-1">
                    <i class="fa fa-star active"></i>
                    <i class="fa fa-star active"></i>
                    <i class="fa fa-star active"></i>
                    <i class="fa fa-star active"></i>
                    <i class="fa fa-star"></i>
                </div>
                <div class="com-rate">4/5 - based on 234 reviews</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="header-bttns">
                    <div class="header-bttns-flex">
                        <div class="follow-bttn hvr-icon-pulse">
                            <button type="button"><i class="fa fa-heart-o hvr-icon"></i> Follow</button>
                        </div>
                        <div class="wr-bttn hvr-icon-pulse">
                            <button type="button" id="wr"><i class="fa fa-comments-o hvr-icon"></i> Write Review</button>
                        </div>
                    </div>
                    <div class="col-md-12 cp-center no-padd">
                        <div class="cp-bttn hvr-icon-pulse">
                            <a href="/site/company-profile" type="button"><i class="fa fa-eye hvr-icon"></i> View Company Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="rh-body">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="heading-style">Company Name Reviews </div>
                <div class="re-box refirst">
                    <div class="col-md-2 col-sm-2">
                        <div class="uicon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/user2.png') ?>">
                        </div>
                        <div class="uname">Employee Name</div>
                        <!--<div class="emp-duration">Current Employee, Worked Since 10 july 2018 - Present  </div>-->
                    </div>
                    <div class="col-md-10 col-sm-10 user-review-main">
                        <div class="col-md-6 col-sm-6">
                            <div class="com-rating">
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star"></i>
                                <div class="num-rate">4.50/5.00</div>
                                <div class="view-detail-btn"><button type="button">View Detailed Review</button> </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="re-bttn">
                                <button type="button" data-toggle="modal" data-target="#report"><i class="fa fa-flag"></i> Report</button>
                                <!--                            <button type="button"><i class="fa fa-thumbs-up"></i></button>
                                                            <button type="button"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>-->
                            </div>
                            <div class="publish-date">Published 54 minutes ago</div>
                            <div class="emp-duration">Current Employee</div>
                        </div>
                        <div class="col-md-12">
                            <div class="utitle">
                                Job Title
                            </div>
                        </div>
                        <div class=" col-md-12 user-saying">
                            <div class="uheading">Likes</div>
                            <div class="utext">Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola
                                sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has
                                ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie
                                suscipiantur his et.
                            </div>
                            <div class="uheading padd-10">Dislikes</div>
                            <div class="utext">Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola
                                sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has
                                ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie
                                suscipiantur his et.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 user-rating">
                                <div class="ur-bg padd-lr-5">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Job Security</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Career Growth</div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Company Culture</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Salary & Benefits</div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Work Satisfaction</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Work-Life Balance </div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Skill Development</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="ushare">
                                <div class="ushare-heading">Share</div>
                                <i class="fa fa-facebook-square"></i>
                                <i class="fa fa-twitter-square"></i>
                                <i class="fa fa-linkedin-square"></i>
                                <i class="fa fa-google-plus-square"></i>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="usefull-bttn pull-right">
                                <div class="use-bttn">
                                    <button type="button"><i class="fa fa-thumbs-up"></i> Usefull</button>
                                </div>
                                <div class="notuse-bttn">
                                    <button type="button"><i class="fa fa-thumbs-down"></i> Not Usefull</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="re-box">
                    <div class="col-md-2 col-sm-2">
                        <div class="uicon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/uicon.png') ?>">
                        </div>
                        <div class="uname">Employee Name</div>
                        <!--<div class="emp-duration">Current Employee, Worked Since 10 july 2018 - Present  </div>-->
                    </div>
                    <div class="col-md-10 col-sm-10 user-review-main">
                        <div class="col-md-6 col-sm-6">
                            <div class="com-rating">
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star"></i>
                                <div class="num-rate">4.50/5.00</div>
                                <div class="view-detail-btn"><button type="button">View Detailed Review</button> </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="re-bttn">
                                <button type="button" data-toggle="modal" data-target="#report"><i class="fa fa-flag"></i> Report</button>
                                <!--                            <button type="button"><i class="fa fa-thumbs-up"></i></button>
                                                            <button type="button"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>-->
                            </div>
                            <div class="publish-date">Published 54 minutes ago</div>
                            <div class="emp-duration">Current Employee</div>
                        </div>
                        <div class="col-md-12">
                            <div class="utitle">
                                Job Title
                            </div>
                        </div>
                        <div class=" col-md-12 user-saying">
                            <div class="uheading">Likes</div>
                            <div class="utext">Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola
                                sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has
                                ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie
                                suscipiantur his et.
                            </div>
                            <div class="uheading padd-10">Dislikes</div>
                            <div class="utext">Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola
                                sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has
                                ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie
                                suscipiantur his et.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 user-rating">
                                <div class="ur-bg padd-lr-5">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Job Security</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Career Growth</div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Company Culture</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Salary & Benefits</div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Work Satisfaction</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Work-Life Balance </div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Skill Development</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="ushare">
                                <div class="ushare-heading">Share</div>
                                <i class="fa fa-facebook-square"></i>
                                <i class="fa fa-twitter-square"></i>
                                <i class="fa fa-linkedin-square"></i>
                                <i class="fa fa-google-plus-square"></i>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="usefull-bttn pull-right">
                                <div class="use-bttn">
                                    <button type="button"><i class="fa fa-thumbs-up"></i> Usefull</button>
                                </div>
                                <div class="notuse-bttn">
                                    <button type="button"><i class="fa fa-thumbs-down"></i> Not Usefull</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="re-box">
                    <div class="col-md-2 col-sm-2">
                        <div class="uicon">
                            <img src="<?= Url::to('@eyAssets/images/pages/review/user2.png') ?>">
                        </div>
                        <div class="uname">Employee Name</div>
                        <!--<div class="emp-duration">Current Employee, Worked Since 10 july 2018 - Present  </div>-->
                    </div>
                    <div class="col-md-10 col-sm-10 user-review-main">
                        <div class="col-md-6 col-sm-6">
                            <div class="com-rating">
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star"></i>
                                <div class="num-rate">4.50/5.00</div>
                                <div class="view-detail-btn"><button type="button">View Detailed Review</button> </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="re-bttn">
                                <button type="button" data-toggle="modal" data-target="#report"><i class="fa fa-flag"></i> Report</button>
                                <!--                            <button type="button"><i class="fa fa-thumbs-up"></i></button>
                                                            <button type="button"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>-->
                            </div>
                            <div class="publish-date">Published 54 minutes ago</div>
                            <div class="emp-duration">Current Employee</div>
                        </div>
                        <div class="col-md-12">
                            <div class="utitle">
                                Job Title
                            </div>
                        </div>
                        <div class=" col-md-12 user-saying">
                            <div class="uheading">Likes</div>
                            <div class="utext">Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola
                                sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has
                                ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie
                                suscipiantur his et.
                            </div>
                            <div class="uheading padd-10">Dislikes</div>
                            <div class="utext">Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola
                                sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has
                                ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie
                                suscipiantur his et.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 user-rating">
                                <div class="ur-bg padd-lr-5">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Job Security</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Career Growth</div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Company Culture</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Salary & Benefits</div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Work Satisfaction</div>
                                </div>
                                <div class="ur-bg light-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Work-Life Balance </div>
                                </div>
                                <div class="ur-bg">
                                    <div class="urating">4/5</div>
                                    <div class="uratingtitle">Skill Development</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="ushare">
                                <div class="ushare-heading">Share</div>
                                <i class="fa fa-facebook-square"></i>
                                <i class="fa fa-twitter-square"></i>
                                <i class="fa fa-linkedin-square"></i>
                                <i class="fa fa-google-plus-square"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-6">
                            <div class="usefull-bttn pull-right">
                                <div class="use-bttn">
                                    <button type="button"><i class="fa fa-thumbs-up"></i> Usefull</button>
                                </div>
                                <div class="notuse-bttn">
                                    <button type="button"><i class="fa fa-thumbs-down"></i> Not Usefull</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-offset-2 load-more-bttn">
                    <button type="button">Load More</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="review-summary">
                    <div class="heading-style">Overall Reviews</div>
                    <div class="row">
                        <div class="col-md-12 col-sm-4">
                            <div class="rs-main">
                                <div class="rating-large">4/5</div>
                                <div class="com-rating-1">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Job Security</div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 4 </div>
                                    <div class="fourstar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Career growth </div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 4 </div>
                                    <div class="fourstar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Company culture </div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 4 </div>
                                    <div class="fourstar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Salary & Benefits</div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 4 </div>
                                    <div class="fourstar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Work Satisfaction</div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 3 </div>
                                    <div class="threestar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Work-Life Balance</div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 4 </div>
                                    <div class="fourstar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Skill development </div>
                                <div class="summary-box">
                                    <div class="sr-rating"> 4 </div>
                                    <div class="fourstar-box com-rating-2">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-md-offset-2 col-sm-11 col-sm-offset-1 no-padd">
                    <div class="filter-review">
                        <div class="oa-review">Filter Reviews</div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" id="form_control_1">
                            <label for="form_control_1">Job Profile</label>
                            <span class="help-block">Eg: Web Developer</span>
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" id="form_control_1">
                            <label for="form_control_1">Location</label>
                            <span class="help-block">Eg: Ludhiana</span>
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" id="form_control_1">
                            <label for="form_control_1">Division</label>
                            <span class="help-block">Eg: IT, Finance, Design</span>
                        </div>
                        <div class="form-group">
                            <div class="filter-bttn">
                                <button type="button">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="report" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title">Reason for reporting?</h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-md-radios">
                    <label></label>
                    <div class="md-radio-list">
                        <div class="md-radio">
                            <input type="radio" id="radio1" name="radio1" class="md-radiobtn">
                            <label for="radio1">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                This post contains hateful, violent, or inappropriate content </label>
                        </div>
                        <div class="md-radio">
                            <input type="radio" id="radio2" name="radio1" class="md-radiobtn">
                            <label for="radio2">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                This post contains advertising or spam</label>
                        </div>
                        <div class="md-radio">
                            <input type="radio" id="radio3" name="radio1" class="md-radiobtn">
                            <label for="radio3">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> Off-topic </label>
                        </div>
                        <div class="md-radio">
                            <input type="radio" id="radio4" name="radio1" class="md-radiobtn">
                            <label for="radio4">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                This post contains conflicts of interest </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php
$this->registerCss('
.padd-lr-5{
    padding-left:10px !important;
    padding-right:10px !important;
}   
.light-bg{
    background:#f4f4f4 !important;
}
.rh-header{
    background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
    background-size:100% 300px;
    background-repeat: no-repeat;
} 
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important
}
.padd-10{
    padding-top:20px;
}
.header-bttns-flex{
    display:flex;
    padding: 20px 0 0 0;
    justify-content:center;
}
.follow-bttn button ,.wr-bttn button, .cp-bttn a{
    background:#fff;
    border:1px solid #00a0e3;
    color:#00a0e3;
    padding:12px 15px;
    font-size:14px;
    border-radius:5px;
    text-transform:uppercase;
}
.cp-center{
    text-align:center;
}
.cp-bttn{
    margin-top:25px;
}
.rh-header{
    padding:80px 0;
}    
.logo-box{
    height:150px;
    width:150px;
    padding:0 10px;
    background:#fff;
    display:table; 
    text-align:center;
    border-radius:6px;
}  
.logo{
    display:table-cell;
    vertical-align: middle;     
}
.com-name{
    font-size:40px;
    font-family:lobster;
    color:#fff;
    margin-top: -16px;
}
.com-rating i{
    font-size:16px;
    background:#ccc;
    color:#fff;
    padding:7px 5px;
    border-radius:5px;
}
.com-rating i.active{
    background:#ff7803;
    color:#fff;
}
.com-rate{
    color: #fff;
    font-size: 13px;
    font-style: italic;
    padding:10px 0;
}
.rh-main-heading{
    font-size:30px;
    font-family:lobster;
    padding-left:20px;
}
.refirst{
    padding-top:25px !important;
}
.re-box{
    padding-top:60px;
}
.uicon{
    text-align:center;
}
.uicon img{
    max-height:80px;
    max-width:80px;
}
.uname{
    text-align:center;
    text-transform:uppercase;
    font-weight:bold;
    padding-top:10px;
    line-height:15px;
    color:#00a0e3;
}
.user-saying{
    padding-top:20px;
}
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
    padding-top:20px;
}
.uheading{
    font-weight:bold;
    
}
.utext{
    text-align:justify;
}
.publish-date{
    text-align:right;
//    font-style:italic;
    font-size: 14px;
}
.view-detail-btn button{
    background:transparent;
    border:none;
    font-size:14px;
    padding:0px
}
.view-detail-btn button:hover, .re-btns button:hover{
    color:#00a0e3;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
}
.num-rate{
    
}
.re-btns{
    text-align:right;
    padding-top: 5px;
}
.re-btns button{
    background:none;
    border:none;
    font-size:19px;
    color:#ccc;
}
.re-btns button:hover{
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.re-btns button:hover i.fa-flag{
    color:#d72a2a;
}
.re-btns button i.fa-thumbs-down{
    margin-left:-8px;
}
.utitle{
    font-size:20px;
    font-weight:bold;
    padding-top:8px;
    color:#00a0e3;
}
.user-review-main{
    border-left:2px solid #ccc;
}
.ur-bg{
   background:#edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    height: 95px;
}
.uratingtitle{
    font-size:12px;
    line-height:15px;
}
.urating{
    font-size:25px;
}
.emp-duration{
    text-align:right;
//    line-height:18px;
//    padding-top:20px;
}
.ushare i{
   font-size:20px;
    color:#ccc; 
}
.ushare i.fa-facebook-square:hover{
    color:#4267B2; 
    cursor: pointer;
}
.ushare i.fa-twitter-square:hover{
    color:#38A1F3; 
    cursor: pointer;
}
.ushare i.fa-linkedin-square:hover{
    color:#0077B5;
    cursor: pointer; 
}
.ushare i.fa-google-plus-square:hover{
    color:#CC3333;
    cursor: pointer;
}
.ushare-heading{
    font-size:14px;
    padding-top:20px;
    line-height:23px;
    font-weight:bold;
}
.usefull-bttn{
    padding-top:33px;
    display:flex;
}
.re-bttn{
    text-align:right
}
.use-bttn button, .notuse-bttn button, .re-bttn button{
    background: transparent !important;
    border:1px solid #ccc;
    color:#ccc;
    padding:5px 15px;
    margin-left:10px;
    border-radius:10px;
    font-size:14px;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn{
    padding-bottom:5px;
}
.use-bttn button:hover{
    color:#00a0e3;
    border-color:#00a0e3;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn button:hover, .notuse-bttn button:hover{
    color:#d72a2a;
    border-color:#d72a2a;
     transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.review-summary{
    text-align:left;
    padding-left:50px
}
.oa-review{
    font-size:30px;
    font-family:lobster;
    padding-bottom:22px;
}
.rs1{
    padding-top:20px;
}
.re-heading{
    font-size: 17px;
    text-transform: capitalize;
    font-weight: bold;
}
.filter-review{
    padding-top:80px;
//    text-align:center;
}
.form-group.form-md-line-input {
    position: relative;
    margin: 0 0 10px;
    padding-top: 10px;
    text-align:left;
}
.filter-bttn{
    padding-top:15px;
}
.rs-main{
    background: #00a0e3;
    max-width: 200px;
    padding: 10px 13px 15px 13px;
    text-align: center;
    color: #fff;
    border-radius: 6px;
}
.rating-large{
    font-size:56px;
}
.com-rating-1 i{ 
    font-size:16px;
    background:#fff;
    color:#ccc;
    padding:7px 5px;
    border-radius:5px;
}
.com-rating-1 i.active{
    background:#fff;
    color:#00a0e3;
}
.summary-box{ 
    display:flex
}
.com-rating-2 {
    padding: 13px 23px 15px 42px;
    height: 46px;
    margin-top: 5px;
    border: 2px solid #00a0e3;
    border-radius: 5px;
    margin-left: -30px;
}
.com-rating-2 i{
    font-size:22px;
    color: #ccc;
}
.com-rating-2 .active{
    color:#ff7803;
}
.sr-rating{
   background: #00a0e3;
    padding: 12px 15px;
    z-index: 9;
    color: #fff;
//    margin-left: 11px;
    font-size: 19px;
    border-radius:5px;    
}
.hvr-icon-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    padding-right:1.2em;
}
.hvr-icon-pulse .hvr-icon {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-icon-pulse:hover .hvr-icon, .hvr-icon-pulse:focus .hvr-icon, .hvr-icon-pulse:active .hvr-icon {
    -webkit-animation-name: hvr-icon-pulse;
    animation-name: hvr-icon-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}
.hvr-icon-pulse:before{
    content:"" !important;
}
.filter-bttn button, .load-more-bttn button{
    background: #00a0e3;
    border: 1px solid #00a0e3;
    padding: 12px 25px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 40px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.filter-bttn button:hover, .load-more-bttn button:hover{
    border-radius:8px;
    -webkit-border-radius:8px;
    -moz-border-radius:8px;
    -o-border-radius:8px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.load-more-bttn{
    padding-top:50px;
    text-align:center;
}
.form-group.form-md-line-input.form-md-floating-label .form-control~label{
    font-size: 14px;
}
.fivestar-box i.active {
    color:#fd7100;
}
.fourstar-box i.active {
    color:#fa8f01;
}
.threestar-box i.active {
    color:#fcac01;
}
.twostar-box i.active {
    color:#fabf37;
}
.onestar-box i.active {
    color:#ffd478;
}
@media only screen and (max-width: 992px){
    .cp-bttn button {
        margin-top: 20px; 
    }
    .cp-bttn {
        padding-left: 0px;
    }
    .header-bttns{
        display: flex;
        justify-content:center;
        margin: 20px 0 0 0;
    }
    .com-name{
        margin-top:0px;
    }
    .rh-header {
        padding: 65px 0;
    }
    .review-summary{
        padding-top:40px;
    }
    .oa-review{
        padding-bottom:20px;
    }
}
');
$script = <<< JS
var popup = new ideaboxPopup({
background : '#2995c2',
popupView : 'full',
startPage: {
        msgTitle        : 'Rate the company on the following criteria :',
        msgDescription 	: '',
        startBtnText	: "Let's Get Start",
        showCancelBtn	: false,
        cancelBtnText	: 'Cancel'
        
},
endPage: {
        msgTitle	: 'Thank you :) ',
        msgDescription 	: 'We thank you for giving your review about the company',
        showCloseBtn	: true,
        closeBtnText	: 'Close All',
        inAnimation     : 'zoomIn'
},
data: [
        {
            question 	: 'Post your review',
            answerType	: 'radio',
            formName	: 'user',
            choices     : [
                    { label : 'Anonymously', value : 'anonymous' },
                    { label : 'With your credentials', value : 'credentials' },
            ],
            description	: 'Please select anyone choice.',
            nextLabel	: 'Go to Step 2',
            required	: true,
            errorMsg	: '<b style="color:#900;">Please select one</b>'
        },
        {
            question 	: 'Are you a current or former employee?',
            answerType	: 'radio',
            formName	: 'current_employee',
            choices     : [
                    { label : 'Current', value : 'current' },
                    { label : 'Former', value : 'former' },
            ],
            description	: 'Please select anyone choice.',
            nextLabel	: 'Go to Step 3',
            required	: true,
            errorMsg	: '<b style="color:#900;">Please select one</b>'
        },
        {
            question 	: 'Period of work',
            answerType	: 'selectbox',
            formName	: 'tenure',
            choices : [
                [
                    { label : '-Select-', value : '' },
                    { label : 'January', value : '1' },
                    { label : 'February', value : '2' },
                    { label : 'March', value : '3' },
                    { label : 'April', value : '4' },
                    { label : 'May', value : '5' },
                    { label : 'June', value : '6' },
                    { label : 'July', value : '7' },
                    { label : 'August', value : '8' },
                    { label : 'September', value : '9' },
                    { label : 'October', value : '10' },
                    { label : 'Novemeber', value : '11' },
                    { label : 'December', value : '12' },
                ],
                [
                    { label : '-Select-', value : '' },
                    { label : '1950', value : '1950' },
                    { label : '1951', value : '1951' },
                    { label : '1952', value : '1952' },
                    { label : '1953', value : '1953' },
                    { label : '1954', value : '1954' },
                    { label : '1955', value : '1955' },
                    { label : '1956', value : '1956' },
                    { label : '1957', value : '1957' },
                    { label : '1958', value : '1958' },
                    { label : '1959', value : '1959' },
                    { label : '1960', value : '1960' },
                    { label : '1961', value : '1962' },
                    { label : '1962', value : '1963' },
                    { label : '1963', value : '1964' },
                    { label : '1964', value : '1965' },
                    { label : '1965', value : '1966' },
                    { label : '1966', value : '1967' },
                    { label : '1967', value : '1968' },
                    { label : '1968', value : '1969' },
                    { label : '1969', value : '1970' },
                    { label : '1970', value : '1971' },
                    { label : '1971', value : '1972' },
                    { label : '1972', value : '1973' },
                    { label : '1973', value : '1974' },
                    { label : '1974', value : '1975' },
                    { label : '1975', value : '1976' },
                    { label : '1976', value : '1977' },
                    { label : '1977', value : '1978' },
                    { label : '1978', value : '1979' },
                    { label : '1979', value : '1980' },
                    { label : '1980', value : '1981' },
                    { label : '1981', value : '1982' },
                    { label : '1982', value : '1983' },
                    { label : '1983', value : '1984' },
                    { label : '1984', value : '1985' },
                    { label : '1985', value : '1986' },
                    { label : '1986', value : '1987' },
                    { label : '1987', value : '1988' },
                    { label : '1988', value : '1989' },
                    { label : '1989', value : '1990' },
                    { label : '1991', value : '1991' },
                    { label : '1992', value : '1992' },
                    { label : '1993', value : '1993' },
                    { label : '1994', value : '1994' },
                    { label : '1995', value : '1995' },
                    { label : '1996', value : '1996' },
                    { label : '1997', value : '1997' },
                    { label : '1998', value : '1998' },
                    { label : '1999', value : '1999' },
                    { label : '2000', value : '2000' },
                    { label : '2001', value : '2001' },
                    { label : '2002', value : '2002' },
                    { label : '2003', value : '2003' },
                    { label : '2004', value : '2004' },
                    { label : '2005', value : '2005' },
                    { label : '2006', value : '2006' },
                    { label : '2007', value : '2007' },
                    { label : '2008', value : '2008' },
                    { label : '2009', value : '2009' },
                    { label : '2010', value : '2010' },
                    { label : '2011', value : '2011' },
                    { label : '2012', value : '2012' },
                    { label : '2013', value : '2013' },
                    { label : '2014', value : '2014' },
                    { label : '2015', value : '2015' },
                    { label : '2016', value : '2016' },
                    { label : '2017', value : '2017' },
                    { label : '2018', value : '2018' },
                ]
            ],
            description	: 'Choose dates of work.',
            nextLabel	: 'Go to Step 4',
            required	: true,
            errorMsg	: '<b style="color:#900;">Please selecty our tenure</b>'
        },
        
        {
            question 	: 'Overall Experience',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'overall_experience',
            description	: '',
            nextLabel	: 'Go to Step 5',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
        {
            question 	: 'Skill Development & Learning',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'skill_development',
            description	: '',
            nextLabel	: 'Go to Step 6',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
        {
            question 	: 'Work-Life Balance',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'work_life',
            description	: '',
            nextLabel	: 'Go to Step 7',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
        {
            question 	: 'Compensation & Benefits',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'compensation',
            description	: '',
            nextLabel	: 'Go to Step 8',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
         {
            question 	: 'Company culture',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'organization_culture',
            description	: '',
            nextLabel	: 'Go to Step 9',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
         {
            question 	: 'Job Security',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'job_security',
            description	: '',
            nextLabel	: 'Go to Step 10',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
         {
            question 	: 'Growth & Opportunities',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'growth',
            description	: '',
            nextLabel	: 'Go to Step 11',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
        {
            question 	: 'Work Satisfaction',
            answerType	: 'starrate',
            starCount	: 5,
            formName	: 'work',
            description	: '',
            nextLabel	: 'Go to Step 12',
            required	: true,
            errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
        },
     
        {
            question 	: 'Location of your office',
            answerType	: 'location_autocomplete',
            formName	: 'location',
            description	: 'Please enter your office location',
            nextLabel	: 'Go to Step 13',
            required	: true,
            errorMsg	: '<b style="color:#900;">Please select a location.</b>'
        },
         {
            question 	: 'your department or division you worked in',
            answerType	: 'department_autocomplete',
            formName	: 'department',
            description	: 'Please enter your department or division',
            nextLabel	: 'Go to Step 14',
            required	: true,
            errorMsg	: '<b style="color:#900;">Please select a department</b>'
        },
         {
            question 	: 'Things you like about the company',
            answerType	: 'textarea',
            formName	: 'likes',
            description	: 'For eg :- Talk about teammates, training, job security, career growth, salary appraisal, travel, politics, learning, work environment, innovation, work-life balance, etc.',
            nextLabel	: 'Go to Step 15',
            required	: true,
            errorMsg	: '<b style="color:#900;">Please write a review</b>'
        },
         {
            question 	: 'Things you dislike about the company',
            answerType	: 'textarea',
            formName	: 'dislikes',
            description	: 'For eg :- Talk about teammates, training, job security, career growth, salary appraisal, travel, politics, learning, work environment, innovation, work-life balance, etc.',
            nextLabel	: 'Finish',
             required	: true,
             errorMsg	: '<b style="color:#900;">Please share your reviews.</b>'
        
        }
]
});
	
        document.getElementById("wr").addEventListener("click", function(e){
                popup.open();
});

JS;
$this->registerJs($script);

$this->registerCssFile('@eyAssets/ideaboxpopup/ideabox-popup.css');
$this->registerCssFile('http://www.empoweryouth.in/assets/themes/dashboard/global/css/components-md.min.css');
//$this->registerJsFile('http://www.empoweryouth.in/assets/themes/dashboard/global/scripts/app.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideaboxpopup/ideabox-popup.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="review-cards" type="text/template">

</script>