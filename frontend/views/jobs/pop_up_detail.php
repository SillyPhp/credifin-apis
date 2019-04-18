<?php
use yii\helpers\Url;

//print_r($data);
//exit();
?>
    <div id="openModal" class="modalDialog">
        <div class="modal-bg">
            <div class="col-md-12">
                <div class="row">
                    <!--                <div class="arrow arrow-left col-xs-1 ">-->
                    <!--                    <a href="#" class="previous"><img src="images/left.png"></a>-->
                    <!--                </div>-->
                    <div class="modal-main col-md-offset-1  col-sm-offset-1 col-xs-offset-1  col-md-10 col-sm-10 col-xs-10">
                        <a href="#" title="Close" class="jd-close">X</a>
                        <div class="row bottom-line">
                            <div class="com-initials col-md-2 col-sm-2">
                                <div class="company-logo center-block">
                                    <?php
                                    if(!empty($application_details['logo'])) {
                                        ?>
                                        <img src="<?= Yii::$app->params->upload_directories->organizations->logo . $application_details['logo_location'] . DIRECTORY_SEPARATOR . $application_details['logo'] ?>" class="img-responsive" />
                                        <?php
                                    } else {
                                        ?>
                                        <canvas class="user-icon" name="<?= $application_details['org_name'] ?>" color="<?= $application_details['color']?>" width="100" height="100" font="55px"></canvas>
                                        <?php
                                    }
                                        ?>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-6">
                                <div class="com-name"><?= $application_details['org_name']?></div>
                                <div class="com-est"><?= $application_details['tag_line']?></div>
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
                        </div>
                        <div class=" text-center divide"><div class="col-md-offset-1">
                                <img src="<?= Url::to('@eyAssets/images/pages/pop-up-detail/divider.png') ?>" class="img-responsive">
                            </div></div>
                        <div class="clearfix"></div>
                        <div class="j-details col-md-4">
                            <div class="j-title "><?= $data['cat_name']?></div>
                            <div class="j-exp"><span>Experience Required:</span> <?= $data['experience'] ?></div>
                            <div class="j-exp"><span>Education/Qualification:</span> <?php foreach ($data['applicationEducationalRequirements'] as $qualifications){ echo $qualifications['educational_requirement'] . ','; }?></div>
                            <div class="j-exp"><span>Job Location:</span> <?php foreach ($data['applicationPlacementLocations'] as $locations){ echo $locations['name'] . ','; }?> </div>
                            <?php
                            $amount1 = $data['min_wage'];
                            $amount2 = $data['max_wage'];
                            setlocale(LC_MONETARY, 'en_IN');
                            if (!empty($min_wage) && !empty($max_wage)) {
                                $amount = '&#8377 ' . utf8_encode(money_format('%!.0n', $amount1)) . 'p.a.' . '&nbspTo&nbsp' . '&#8377 ' . utf8_encode(money_format('%!.0n', $amount2)) . 'p.a.';
                            } elseif (!empty($min_wage)) {
                                $amount = 'From &#8377 ' . utf8_encode(money_format('%!.0n', $amount1)) . 'p.a.';
                            } elseif (!empty($max_wage)) {
                                $amount = 'Upto &#8377 ' . utf8_encode(money_format('%!.0n', $amount2)) . 'p.a.';
                            } elseif (empty($min_wage) && empty($max_wage)) {
                                $amount = 'Negotiable';
                            }
                            ?>
                            <div class="j-exp"><span>Salary:</span><?= $amount; ?></div>
                            <div class="j-exp"><span>Industry:</span> <?= $data['industry']?></div>
<!--                            <div class="j-exp"><span>Functional Area:</span> IT Software - Other</div>-->
                            <div class="j-exp"><span>Role:</span> <?= $data['designation']?></div>
                            <div class="j-exp"><span>Employment Type:</span> <?= $application_details['type']?></div>
                            <?php
                            $total_vac = 0;
                            foreach ($data['applicationPlacementLocations'] as $placements) {
                                $total_vac += $placements['positions'];
                            }
                            ?>
                            <div class="j-exp"><span>No. of Positions:</span> <?= (($total_vac) ? $total_vac : 'Not Applicable'); ?></div>
                            <div class="j-exp"><span>Skills Required:</span>
                                <div class="skills">
                                    <?php
                                    foreach ($data['applicationSkills'] as $skill){
                                        ?>
                                    <span><?= $skill['skill'] ?></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="j-discription col-md-8"><div class="j-title">Job Discription</div>
                            <div class="j-text">
                                <p>
                                    <?= $data['description']?>
                                </p>
                                <p><ul>
                                    <?php
                                    foreach ($data['applicationJobDescriptions'] as $jd){
                                        ?>
                                    <li><?= $jd['job_description'] ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul></p>
<!--                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>-->
                            </div>
                            <div class="apply-bttns">
                                <div class="b-apply foo"><button type="submit">Apply Now</button></div>
                                <div class="b-email foo"><button type="submit"> Email to Friend </button></div>
                            </div>
                        </div>
                    </div>
                    <!--                <div class="arrow arrow-right ">-->
                    <!--                    <a href="#" class="next"><img src="images/right.png" ></a>-->
                    <!--                </div>-->
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.modalDialog {
    position: fixed;
    font-family: Arial, Helvetica, sans-serif;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0,0,0,0.7);
    z-index: 99999;
//    opacity: 0;
    -webkit-transition: opacity 400ms ease-in;
    -moz-transition: opacity 400ms ease-in;
    transition: opacity 400ms ease-in;
//    pointer-events: none;
    overflow:auto;
    margin-right:-18px;	
}
//.modalDialog:target {
//    opacity: 1;
//    pointer-events: auto;
//}
.modalDialog > .modal-bg {
    width:100%;
    margin: 3% auto; 
    position:relative;                   
    padding: 5px 20px 13px 20px;
    border-radius: 10px;
    color:#2d2d2d;  
}
.modal-main{ background:rgba(255,255,255,.9); border-radius:10px; padding:15px 20px; box-shadow:0px 0px 10px #fff; -moz-box-shadow: 0px 0px 10px #fff;
-webkit-box-shadow: 0px 0px 10px #fff; margin-bottom:40px;
}
/*@keyframes animateCircle{
0%{ transform: rotate(0deg );}
100%{ transform: rotate(360deg );}
}*/
.modal-main .jd-close {
    background:#fff;
    color: #777672;
    line-height: 25px;
    position: absolute;
    right: -10px;
    text-align: center;
    top: -10px;
    width: 34px;
    text-decoration: none;
    font-weight:400;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px;
    -moz-box-shadow: 0px 0px 3px #fff;
    -webkit-box-shadow: 0px 0px 3px #fff;
    box-shadow: 0px 0px 3px #fff;
    opacity:1 !important; 
}
.modal-main .jd-close:hover {
    background:#fff;
    color:#ff7803;
    transition:.5s;
}
.divide{ text-align:center; margin:0 auto;}
.arrow{padding-top:18%; font-size:25px;   }
.arrow-left{position:fixed;}
.arrow-right{position:fixed; right:50px;}
.pbar{margin-top:10px;}
.com-name{ font-size:24px; font-weight:600; padding-top:20px;}
.com-est{ font-size:15px; font-style:italic; font-weight:lighter;}
.company-logo img{ }
.company-logo{max-height:100px; max-width:100px; text-align:center; padding:5px 0 10px 0 ; }
.j-details{padding-top:20px;}
.j-title{font-size:20px; font-weight:bold; padding-top:20px; color:#ff7803;}
.j-exp{font-size:15px; font-style:oblique; padding-top:10px; }
.j-exp span{font-weight:bold;}
.j-discription{ text-align:justify; font-size:14px; padding-top:15px;}
.j-discription ul{ list-style-image:url(../images/check-circle1.png);}
.j-text{ padding-top:10px;}
.j-skills{font-style:italic; padding:20px 0;}
.b-apply{  text-align:center; padding-top:30px;}
.c-links{padding-top:25px;}
.cp-heading{font-size:16px; color:#2d2d2d; font-weight:bold; margin-left:5px;}
.c-socal-links a{ padding:3px; color:#ff7803; font-size:16px; font-weight:bold;}
.c-socal-links a.fb{margin-left:0px;}
.c-socal-links a.fb:hover{color:#3B5998;}
.c-socal-links a.gplus:hover{color:#d34836;}
.c-socal-links a.tw:hover{color:#1DA1F2;}
.c-socal-links a.ln:hover{color:#0077B5;}
.c-socal-links a.lk:hover{color:#ff7803;}
/*.b-apply button{ background-color:#1aabe7; border:2px solid #fff; color:#fff; padding:10px 15px; }*/
.apply-bttns{ display:flex;     max-width: 300px;   margin: auto;}
.skills{ line-height:35px; }
.skills span{background:#ff7803; padding:5px 10px; margin:0 3px; color:#fff; border-radius:15px; line-height:15px; box-shadow:0px 0px 2px rgba(0,0,0,0.1);}
.apply-bttns .b-save,.apply-bttns .b-email{ padding-left:20px; }
.b-email button, .b-save button{ margin-top:30px; background:#1aabe7 !important;   border:2px solid #1aabe7 !important; border-radius:5px;}
.b-email button:after, .b-save button:after{ background:#1aabe7 !important;}
.b-email button:hover, .b-save button:hover{background-color:#fff !important; color:#1aabe7!important; transition:all .8s; border:2px solid #fff; box-shadow:2px 2px 15px rgba(0,0,0,0.7); border:none;}
.b-apply button:hover{
	background-color:#fff; color:#ff7803!important; transition:all .8s; border:2px solid #fff; box-shadow:2px 2px 15px rgba(0,0,0,0.7);}
.b-apply button, .b-email button, .b-save button {
    position: relative;
    background-color:#ff7803;
    border:2px solid #ff7803; border-radius:5px;
    font-size: 15px;
    color: #fff;
    padding:10px 15px;
    text-align: center;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;
	box-shadow:2px 2px 10px rgba(0,0,0,0.4);
}
.b-apply button:after, .b-email button:after, .b-save button:after{
    content: "";
    background: #ff7803;
    display: block;
    position: absolute;
    padding-top: 300%;
    padding-left: 350%;
    margin-left: -20px!important;
    margin-top: -120%;
    opacity: 0;
    transition: all 1s
}
.foo{}
.b-apply button:active:after, .b-email button:active:after, .b-save button:active:after{
    padding: 0;
    margin: 0;
    opacity: 1;
    transition: 0s;
	/*background: #1aabe7;*/
}
@media (max-width:1024px){
.arrow-right{ right:30px;}
}
@media (max-width:769px){
	.arrow-left{left:10px;}
.arrow-right{ right:20px;}
}
');
$this->registerJs('
var load_template = `<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body"><img src="/assets/themes/dashboard/global/img/loading-spinner-grey.gif" class="loading"><span>Loading... </span></div></div></div>`;
$(document).on("click", ".jd-close", function(){
    $("#pop_up_modal").modal("hide");
    $("#pop_up_modal").html(load_template);
});
');