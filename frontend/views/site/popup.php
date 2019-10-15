<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

$this->registerCssFile('@eyAssets/css/popup.css');
?>
<a href="#openModal">Open Modal</a>

<div id="openModal" class="modalDialog">
    <div class="modal-bg">
        <div class="col-md-12">
            <div class="row">
                <div class="arrow arrow-left">
                    <a href="#" class="previous"><img src="<?= Url::to('@eyAssets/images/pages/pop-up-detail/left.png'); ?>"></a>
                </div>
                <div class="modal-main col-md-offset-1  col-sm-offset-1 col-xs-offset-1  col-md-10 col-sm-10 col-xs-10">
                    <a href="#close" title="Close" class="close"><i class="fa fa-times"></i></a>
                    <!--                    <div class="row bottom-line">
                                            <div class="com-initials col-md-2 col-sm-2">
                                                <div class="company-logo center-block"> <img src="<?= Url::to('@eyAssets/images/pages/pop-up-detail/demo.png'); ?>" class="img-responsive"></div>
                                            </div>
                                            <div class="col-md-8 col-sm-6">
                                                <div class="com-name">Your Company Name</div>
                                                <div class="com-est">Tag Line</div>
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <div class="c-links">
                                                    <div class="cp-heading col-md-12">More About Us</div>
                                                    <div class="c-socal-links col-md-12">
                                                        <a href="" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                        <a href="" class="gplus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                                        <a href="" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                                        <a href="" class="ln"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                                        <a href="" class="lk"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                    <div class="col-md-4 border-r">
                        <div class="job-title">Job Title</div>
                        <div class="apply-bttns">
                            <div class="b-apply foo"><button type="submit">Apply Now</button></div>
                            <!--                            <div class="b-email foo"><button type="submit"> Email to Friend </button></div>-->
                        </div>
                        <div class="share-bar">
                            <div class="share-bar-text">Share</div>
                            <a href="#" title="" class="share-fb"><i class="fa fa-facebook"></i></a>
                            <a href="#" title="" class="share-twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" title="" class="share-email"><i class="fa fa-envelope-o"></i></a>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="job-overview">                        
                            <ul>
                                <li><i class="fa fa-money"></i><h3>Offerd Salary</h3><span>£15,000 - £20,000</span></li>
                                <li><i class="fa fa-mars-double"></i><h3>Gender</h3><span>Female</span></li>
                                <li><i class="fa fa-thumb-tack"></i><h3>Career Level</h3><span>Executive</span></li>
                                <li><i class="fa fa-puzzle-piece"></i><h3>Industry</h3><span>Management</span></li>
                                <li><i class="fa fa-shield"></i><h3>Experience</h3><span>2 Years</span></li>
                                <li><i class="fa fa-line-chart "></i><h3>Qualification</h3><span>Bachelor Degree</span></li>
                                <li><i class="fa fa-map-marker "></i><h3>Locations</h3><span>Sacramento, California</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row"> 
                        <div class="divider"></div>
                    </div>
                    <!--                    <div class="text-center divide">
                                            <img src="<?= Url::to('@eyAssets/images/pages/pop-up-detail/divider.png'); ?>" class="img-responsive">
                                        </div>-->
                    <div class="clearfix"></div>
                    <!--                    <div class="j-details col-md-4">
                                            <div class="company-logo"> 
                                                <img src="<?= Url::to('@eyAssets/images/pages/pop-up-detail/demo.png'); ?>" class="img-responsive">
                                            </div>                 
                                            <div class="j-title ">Company Name</div>
                                            <div class="j-text com-text">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                                    galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but
                                                    also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s 
                                                    with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing 
                                                    software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                            </div>
                                            <div class="j-exp"><span>Experience Required:</span> 0-3 years</div>
                                           <div class="j-exp"><span>Education/Qualification:</span> Undergraduate, Postgraduate</div>	               		
                                           <div class="j-exp"><span>Job Location:</span> Ludhiana, Ludhiana, Ludhiana, Ludhiana, </div>
                                           <div class="j-exp"><span>Salary:</span> 4.2 Lakhs Yearly </div>
                                           <div class="j-exp"><span>Industry:</span> IT-Software</div>
                                           <div class="j-exp"><span>Functional Area:</span> IT Software - Other</div>
                                           <div class="j-exp"><span>Role:</span> Programming & Design</div>
                                           <div class="j-exp"><span>Employment Type:</span> Permanent Job, Full Time</div>
                                           <div class="j-exp"><span>No. of Positions:</span> 10</div>
                                           <div class="j-exp"><span>Skills Required:</span>
                                               <div class="skills"><span>HTML</span>
                                                   <span>CSS</span>
                                                   <span>Javascript</span>
                                                   <span>jQuery</span>
                                                   <span>Photoshop</span>
                                                   <span>Wordpress</span>
                                                   <span>Joomla</span>
                                                   <span>Coraldraw</span></div>
                                           </div>
                                        </div>-->
                    <div class="j-discription col-md-6">
                        <div class="j-title">Job Discription</div>
                        <div class="j-text"> 
                            <p>
                            <ul>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                    <div class="j-discription col-md-6">
                        <div class="j-title">Education + Experience</div>
                        <div class="j-text"> 
                            <p>
                            <ul>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                            </ul>
                            </p>
                        </div>
<!--                        <div class="j-title">Other Details</div>
                        <div class="j-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but
                                also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s 
                                with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing 
                                software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="arrow arrow-right">
                    <a href="#" class="next"><img src="<?= Url::to('@eyAssets/images/pages/pop-up-detail/right.png'); ?>" ></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<<JS
//$(document).ready(function() {
//    $(document).on('click', '.previous, .next', function(event) {
//        event.preventDefault();
//        $('#openModal2').modal('toggle');
//    });
//});
//
//$(function(){
//  $(document).keyup(function(e){
//    if(e.which == 27)
//    {
//       $("#").css("opacity", "0");
//    }
//  });
//});
JS;
$this->registerJs($script);
