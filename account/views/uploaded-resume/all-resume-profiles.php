<?php

use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;
?>
<section>
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="col-md-4">
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">All Profiles </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <!-- BEGIN: Actions -->
                        <div class="mt-actions">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="/account/candidate-resumes">
                                        <div class="hr-company-box">
                                            <div class="rt-bttns">
                                                <!--<a href="" type="button" class="j-delete">
                                                    <i class="fa fa-eye"></i>
                                                    </a>-->
                                            </div>
                                            <div class="lf-bttn">
                                                <!--<button class="j-star j-whatsapp share_btn">
                                                    <i class="fa fa-star"></i>
                                                </button>-->
                                            </div>
                                            <div class="hr-com-icon hr-com-icon2">
                                                <img src="<?= Url::to('@commonAssets/categories/information_technology.svg') ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Information Technology
                                            </div>
                                            <div class="hr-com-jobs">
                                                250 Resumes
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="/account/candidate-resumes">
                                        <div class="hr-company-box">
                                            <div class="rt-bttns">
                                                <!--<a href="" type="button" class="j-delete">
                                                    <i class="fa fa-eye"></i>
                                                    </a>-->
                                            </div>
                                            <div class="lf-bttn">
                                                <!--<button class="j-star j-whatsapp share_btn">
                                                   <i class="fa fa-star"></i>
                                               </button>-->
                                            </div>
                                            <div class="hr-com-icon hr-com-icon2">
                                                <img src="<?= Url::to('@commonAssets/categories/information_technology.svg') ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Information Technology
                                            </div>
                                            <div class="hr-com-jobs">
                                                0 Resumes
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="/account/candidate-resumes">
                                        <div class="hr-company-box">
                                            <div class="rt-bttns">
                                                <!--<a href="" type="button" class="j-delete">
                                                    <i class="fa fa-eye"></i>
                                                    </a>-->
                                            </div>
                                            <div class="lf-bttn">
                                                <!--<button class="j-star j-whatsapp share_btn">
                                                   <i class="fa fa-star"></i>
                                               </button>-->
                                            </div>
                                            <div class="hr-com-icon hr-com-icon2">
                                                <img src="<?= Url::to('@commonAssets/categories/information_technology.svg') ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Information Technology
                                            </div>
                                            <div class="hr-com-jobs">
                                                200 Resumes
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="/account/candidate-resumes">
                                        <div class="hr-company-box">
                                            <div class="rt-bttns">
                                                <!--<a href="" type="button" class="j-delete">
                                                    <i class="fa fa-eye"></i>
                                                   </a>-->
                                            </div>
                                            <div class="lf-bttn">
                                                <!--<button class="j-star j-whatsapp share_btn">
                                                    <i class="fa fa-star"></i>
                                                </button>-->
                                            </div>
                                            <div class="hr-com-icon hr-com-icon2">
                                                <img src="<?= Url::to('@commonAssets/categories/information_technology.svg') ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Information Technology
                                            </div>
                                            <div class="hr-com-jobs">
                                                15 Resumes
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
.hr-company-box{
    padding-bottom:0px;
}
');
?>
