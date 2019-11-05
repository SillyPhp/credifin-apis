<?php
$this->params['header_dark'] = false;
$this->params['url'] = $org['website'];

use yii\helpers\Url;
use yii\helpers\Html;

Yii::$app->view->registerJs('var slug_var = "' . $org['slug'] . '"', \yii\web\View::POS_HEAD);
echo $this->render('/widgets/drop_resume', [
    'username' => Yii::$app->user->identity->username,
    'type' => 'application'
]);
?>

<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-header wform">
                    <div class="nav-com-logo">
                        <a href="<?= Url::to($org['website']) ?>">
                            <img src="<?= Url::to($org['logo']); ?>" alt="<?= $org['name'] ?>">
                        </a>
                    </div>
                    <div class="job-search-sec">
                        <div class="job-search">
                            <h4>Opportunities in <?= $org['name'] ?></h4>
                            <form id="search_form">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="job-field">
                                            <input type="text" name="keywords" id="keywords"
                                                   placeholder="Job title, keywords or company name"/>
                                            <i class="far fa-keyboard"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="job-field">
                                            <?= Html::dropDownList('cities_drp', null, $cities, ['id' => 'cities_drp', 'prompt' => 'Choose City', 'data-placeholder' => 'City, province or region', 'class' => 'chosen-city']) ?>
                                            <i class="la la-map-marker"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 column">
                <div class="widget border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="sb-title open">Date Posted</h3>
                            <div class="posted_widget">
                                <input type="radio" name="choose" value="1" id="232"><label for="232">Last
                                    Hour</label><br/>
                                <input type="radio" name="choose" value="2" id="wwqe"><label for="wwqe">Last 24
                                    hours</label><br/>
                                <input type="radio" name="choose" value="3" id="erewr"><label for="erewr">Last 7
                                    days</label><br/>
                                <input type="radio" name="choose" value="4" id="qwe"><label for="qwe">Last 14
                                    days</label><br/>
                                <input type="radio" name="choose" value="5" id="wqe"><label for="wqe">Last 30
                                    days</label><br/>
                                <input type="radio" name="choose" value="6" id="qweqw"><label class="nm"
                                                                                              for="qweqw">All</label><br/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="sb-title open">Job Type</h3>
                            <div class="type_widget">
                                <p class="ftchek"><input type="checkbox" name="choosetype[]" id="dsf" value="Full Time"><label
                                            for="dsf">Full
                                        Time</label></p>
                                <p class="ptchek"><input type="checkbox" name="choosetype[]" id="sadd"
                                                         value="Part Time"><label for="sadd">Part
                                        Time</label></p>
                                <p class="tpchek"><input type="checkbox" name="choosetype[]" id="assa"
                                                         value="Work From Home"><label for="assa">Work From Home
                                    </label></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="sb-title closed">Offerd Salary</h3>
                            <div class="specialism_widget">
                                <div class="posted_widget">
                                    <p><input type="radio" name="salry" id="sal1" min-value="10000"
                                              max-value="20000"><label for="sal1">10k - 20k</label>
                                    </p>
                                    <p><input type="radio" name="salry" id="sal2" min-value="20000"
                                              max-value="30000"><label for="sal2">20k - 30k</label>
                                    </p>
                                    <p><input type="radio" name="salry" id="sal3" min-value="30000"
                                              max-value="40000"><label for="sal3">30k - 40k</label>
                                    </p>
                                    <p><input type="radio" name="salry" id="sal4" min-value="40000"
                                              max-value="50000"><label for="sal4">40k - 50k</label>
                                    </p>
                                    <p><input type="radio" name="salry" id="sal5" min-value="50000" max-value=""><label
                                                for="sal5"> More Then 50k</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <div class="widget border">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-md-12">-->
                <!--                            <h3 class="sb-title closed">Career Level</h3>-->
                <!--                            <div class="specialism_widget">-->
                <!--                                <div class="simple-checkbox">-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="5"><label for="5">Intermediate</label>-->
                <!--                                    </p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="6"><label for="6">Normal</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="7"><label for="7">Special</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="8"><label for="8">Experienced</label>-->
                <!--                                    </p>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="widget border">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-md-12">-->
                <!--                            <h3 class="sb-title closed">Experince</h3>-->
                <!--                            <div class="specialism_widget">-->
                <!--                                <div class="simple-checkbox">-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="9"><label for="9">1Year to-->
                <!--                                            2Year</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="10"><label for="10">2Year to-->
                <!--                                            3Year</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="11"><label for="11">3Year to-->
                <!--                                            4Year</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="12"><label for="12">4Year to-->
                <!--                                            5Year</label></p>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="widget border">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="sb-title closed">Gender</h3>
                            <div class="specialism_widget">
                                <div class="simple-checkbox">
                                    <p><input type="checkbox" name="smplechk[]" id="13" value="1"><label
                                                for="13">Male</label></p>
                                    <p><input type="checkbox" name="smplechk[]" id="14" value="2"><label
                                                for="14">Female</label></p>
                                    <p><input type="checkbox" name="smplechk[]" id="15" value="3"><label
                                                for="15">Others</label></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <div class="widget border">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-md-12">-->
                <!--                            <h3 class="sb-title closed">Industry</h3>-->
                <!--                            <div class="specialism_widget">-->
                <!--                                <div class="simple-checkbox">-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="16"><label for="16">Meezan Job</label>-->
                <!--                                    </p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="17"><label for="17">Speicalize-->
                <!--                                            Jobs</label>-->
                <!--                                    </p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="18"><label for="18">Business-->
                <!--                                            Jobs</label></p>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="widget border">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-md-12">-->
                <!--                            <h3 class="sb-title closed">Qualification</h3>-->
                <!--                            <div class="specialism_widget">-->
                <!--                                <div class="simple-checkbox">-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="19"><label-->
                <!--                                                for="19">Matriculation</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="20"><label-->
                <!--                                                for="20">Intermidiate</label></p>-->
                <!--                                    <p><input type="checkbox" name="smplechk" id="21"><label for="21">Gradute</label>-->
                <!--                                    </p>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div> -->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <div class="col-lg-9 col-md-9 column">
                <div class="modrn-joblist">
                    <!--                    <div class="tags-bar">-->
                    <!--                        <span>Full Time<i class="close-tag">x</i></span>-->
                    <!--                        <span>UX/UI Design<i class="close-tag">x</i></span>-->
                    <!--                        <span>Istanbul<i class="close-tag">x</i></span>-->
                    <!--                        <div class="action-tags">-->
                    <!--                            <a href="#" title=""><i class="fas fa-cloud-upload-alt"></i> Save</a>-->
                    <!--                            <a href="#" title=""><i class="fas fa-trash-alt"></i> Clean</a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!-- Tags Bar -->
                    <div class="filterbar">
                        <!--                        <span class="emlthis"><a href="mailto:example.com" title=""><i class="far fa-envelope"></i> Email me Jobs Like These</a></span>-->
                        <!--                        <div class="sortby-sec">-->
                        <!--                            <span>Sort by</span>-->
                        <!--                            <select data-menu>-->
                        <!--                                <option>Most Recent</option>-->
                        <!--                                <option selected>Most Recent</option>-->
                        <!--                                <option>Most Recent</option>-->
                        <!--                                <option>Most Recent</option>-->
                        <!--                            </select>-->
                        <!--                            <select data-menu>-->
                        <!--                                <option>Most Recent</option>-->
                        <!--                                <option selected>Most Recent</option>-->
                        <!--                                <option>Most Recent</option>-->
                        <!--                                <option>Most Recent</option>-->
                        <!--                            </select>-->
                        <!--                        </div>-->
                        <h5>Total <span id="count"></span> Opportunities</h5>
                        <ul class="nav nav-tabs nav-padd-20 set-fonts">
                            <li class="active"><a data-toggle="tab" href="#jobs_list">Jobs</a></li>
                            <li><a data-toggle="tab" href="#internships_list">Internships</a></li>
                        </ul>
                    </div>
                </div><!-- MOdern Job LIst -->
                <div class="job-list-modern tab-content">
                    <div id="jobs_list" class="tab-pane fade in active">
                        <div class="loader_screen">
                            <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                        </div>
                        <div class="job-listings-sec" id="career_job_list">

                        </div>
                        <div class="col-md-12">
                            <div class="viewmore">
                                <button type="button" id="jobMore">View More</button>
                            </div>
                        </div>
                    </div>
                    <div id="internships_list" class="tab-pane fade">
                        <div class="job-listings-sec" id="career_internship_list">

                        </div>
                        <div class="col-md-12">
                            <div class="viewmore">
                                <button type="button" id="jobMoreIntern">View More</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="new-position-widget">
                            <?=
                            $this->render('/widgets/new-position');
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="empty-field">
            <input type="hidden" id="dropcv">
        </div>
        <!-- Modal -->
        <div class="modal fade" id="existsModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Company hasn't created any data for this feature</h4>
                    </div>
                    <div class="modal-body">
                        <p>Wait for company to create the feature</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="empty-field">
            <input type="hidden" id="loggedIn"
                   value="<?= (!Yii::$app->user->identity->organization->organization_enc_id && !Yii::$app->user->isGuest) ? 'yes' : '' ?>">
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <p>Please Login as Candidate to drop your resume</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
echo $this->render('/widgets/mustache/career-job-box');

$this->registerCssFile('@eyAssets/css/chosen.css');
$this->registerCss('
.loader_screen img
{
display:none;
margin:auto
}
.nav-tabs > li > a{
    font-family: roboto !important;
    font-size: 14px !important;
    border:none;
}
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
    color: #fff !important;
    background-color: #00a0e3 !important;
    font-weight: 500 !important;
    font-family: roboto !important;
}
#myModal{
    top: 50%;
    transform: translateY(-50%);
}
.viewmore{
    text-align:center;
    margin-top:20px;
}
.viewmore button{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-left: 5px;
    background: #fff;
    border:none;
}
.nav-com-logo{
    text-align: center;
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    height: 80px;
    width: 80px;
    background: rgba(255,255,255,1);
    border-radius:50%;
    z-index:9;
}
.nav-com-logo a{
    height:80px;
    width:80px;
}
.nav-com-logo img{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width: 100%;
    height: 100%;
    max-width: 55px;
    max-height: 55px;

}
.new-position-widget{
    margin-top:50px;
}
.chosen-container-single .chosen-single div::before{
    display:none;
}
.block.overlape {
    z-index: 2;
}
section.overlape {
    z-index: 2;
}
.block {
    float: left;
    padding: 0px 0;
    position: relative;
    width: 100%;  
}   
.inner-header::before {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    content: "";
    z-index: -1;
    
    background: rgb(139,145,221);
    background: -moz-linear-gradient(45deg,  rgba(139,145,221,1) 0%, rgba(16,25,93,1) 71%, rgba(16,25,93,1) 100%);
    background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,rgba(139,145,221,1)), color-stop(71%,rgba(16,25,93,1)), color-stop(100%,rgba(16,25,93,1)));
    background: -webkit-linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    background: -o-linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    background: -ms-linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    background: linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#8b91dd\', endColorstr=\'#10195d\',GradientType=1 );
    opacity: 0.8;
}
.inner-header::after {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    content: "";
    background-image: url("/assets/themes/ey/images/pages/index2/lines.png");
    z-index: 0;
    opacity: 0.14;
}
.inner-header {
    float: left;
    width: 100%;
    position: relative;
    padding-top: 130px;
     padding-bottom: 15px;
    z-index: 0;
}
.inner-header.wform .job-search-sec {
    position: relative;
    float: left;
    z-index: 4;
    top: 0;
    padding:0 15px;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);

}
.job-search-sec {
    position: absolute;
    left: 50%;
    top: 50%;
    max-width: 1180px;
    content: "";
    
    -webkit-transform: translateY(-50%) translateX(-50%);
    -moz-transform: translateY(-50%) translateX(-50%);
    -ms-transform: translateY(-50%) translateX(-50%);
    -o-transform: translateY(-50%) translateX(-50%);
    transform: translateY(-50%) translateX(-50%);

    margin-top: 0px;
}
.job-search {
    float: left;
    width: 100%;
    padding: 0;
    margin-bottom: 50px;
}
.job-search > h4 {
    float: left;
    width: 100%;
    margin: 0;
    color: #ffffff;
    text-align: center;
    font-weight: bold;
    font-size: 30px;
}
.job-search > h3 {
    float: left;
    width: 100%;
    font-family: Quicksand;
    font-size: 40px;
    font-weight: normal;
    color: #ffffff;
    letter-spacing: 0px;
    text-align: center;
    line-height: 39px;
    margin-bottom: 13px;
}
.job-search > span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    font-weight: 400;
    color: #d5d8f3;
    text-align: center;
    margin-top: 10px;
}
.job-search form {
    float: left;
    width: 100%;
    margin-top: 40px;
}
.job-field {
    float: left;
    width: 100%;
    position: relative;
    
}

.job-field input {
    float: left;
    width: 100%;
    background: no-repeat;
    border: none;
    font-size: 13px;
    color: #888888;
    margin: 0;
    padding: 0 70px 0 30px;
    height: 53px;
    line-height: 53px;

    background-color: #FFF;

     -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
}

.job-field input::-webkit-input-placeholder { /* Chrome */
  color: #888888;font-size: 13px
}
.job-field input:-ms-input-placeholder { /* IE 10+ */
  color: #888888;font-size: 13px
}
.job-field input::-moz-placeholder { /* Firefox 19+ */
  color: #888888;font-size: 13px
}
.job-field input:-moz-placeholder { /* Firefox 4 - 18 */
  color: #888888;font-size: 13px
}
.job-field i {
    position: absolute;
    right: 18px;
    top: 17px;
    font-size: 20px;
    color:#00a0e3;
}
.job-search form button {
   float: left;
    width: 100%;
    padding: 9px 0;
    font-size: 20px;
    background-color: #00a0e3;
    height: 53px;
    border-radius: 8px;
    border: none;
    color: #fff;
}
.job-search form .row {
    margin: 0 -12px;
}
.job-search form .row > div {
    padding: 0 12px;
}
.tags-bar {
    float: left;
    width: 100%;
    margin-top: 40px;
    border: 2px solid #e8ecec;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    padding: 10px;
    position: relative;
}
.job-is.pt,
.job-list-modern .job-is.pt{
    color: #7dc246;
    border-color: #7dc246;
}
.job-listing:hover {
    border-left-color: #8b91dd;
    -webkit-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    z-index: 1;
    position: relative;
}
.follow-companies > ul li .job-listing.wtabs .go-unfollow:hover {
    background: #fb236a;
    border-color: #fb236a;
    color: #fff;
}
.job-listing {
    float: left;
    width: 100%;
    display: table;
    border-bottom: 1px solid #e8ecec;
    padding: 30px 0;
    background: #ffffff;
    border-left: 2px solid #ffffff;
    padding-right: 30px;
}
.filterbar {
    float: left;
    width: 100%;
    margin-bottom: 30px;
}
.filterbar > h5 {
    float: left;
    font-family: lora;
    font-size: 20px;
    color: #222222;
    font-weight: bold;
    line-height: 33px;
    margin: 0;
}
.modrn-joblist {
    width: 100%;
    display:flex;
    border-bottom: 1px solid #edeff7;
}
.tags-bar > span {
    float: left;
    background: #f4f5fa;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    font-family: Open Sans;
    font-size: 13px;
    padding: 7px 17px;
    margin-right: 15px;
    position: relative;
}
.tags-bar > span i {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #fb236a;
    
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;

    color: #ffffff;
    text-align: center;
    line-height: 13px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
.action-tags {
    float: right;
}
.action-tags a {
    float: left;
    font-size: 13px;
    color: #8b91dd;
    padding: 7px 6px;
    line-height: 17px;
}
.action-tags a i {
    float: left;
    font-size: 18px;
    margin-right: 4px;
    color:#00a0e3;
}
.modrn-joblist .filterbar {
    margin-top: 30px;
}
.modrn-joblist.np {
    padding: 0;
}
.filterbar .emlthis {
    margin: 0;
    padding: 10px 30px;
}
.emlthis.active {
    background: #fb236a;
    border-color: #fb236a;
    color: #ffffff;
}
.emlthis.active i {
    color: #ffffff;
}
.emlthis {
    float: left;
    border: 2px solid #d8dcdc;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    border-radius: 6px;

    padding: 12px 30px;
    font-size: 13px;
    color: #888888;
    margin-bottom: 30px;

    line-height: 18px;
}
.emlthis i {
    float: left;
    font-size: 19px;
    margin-right: 11px;
    position: relative;
    top: -1px;
    color: #B3B3B3;
}
.sortby-sec {
    float: right;
    display: inline-flex;
}
.sortby-sec > span {
    float: left;
    font-size: 13px;
    line-height: 33px;
    color: #888888;
    padding-right:10px;
    margin-right: 10px;
}
.sortby-sec .chosen-container > a {
    border: none;
    background: #f4f5fa;
    font-size: 13px;
    width: auto;
    padding: 7px 20px;
}
.sortby-sec .chosen-container {
    border: none;
    float: left;
    width: auto !important;
    clear: none;
    margin-left: 10px;
}
.sortby-sec .chosen-container > a div::before {
    font-size: 11px;
    color: #737373;
}
.sortby-sec .chosen-container.chosen-container-single.chosen-container-single-nosearch.chosen-with-drop.chosen-container-active a {
    background: #dfdfdf;
    color: #222222;
}
.modrn-joblist .filterbar h5 {
    float: left;
    width: 100%;
    margin: 0;
    margin-bottom: 20px;
    color: #383838;
    text-align: right;
    font-size: 17px;
}
.job-style-bx > i {
    position: absolute;
    right: 16px;
    bottom: 0;
    font-style: normal;
    font-size: 13px;
    color: #888888;
}
.job-list-modern .job-listing.wtabs {
    margin: 0;
        margin-top: 0px;
    
    -webkit-border-radius: 0 0;
    -moz-border-radius: 0 0;
    -ms-border-radius: 0 0;
    -o-border-radius: 0 0;
    border-radius: 0 0;

    border-left-color: #ffffff;
    border-right-color: #ffffff;
    border-top-color: #edeff7;
    border-bottom-color: #edeff7;
    margin-top: -1px;
    padding: 30px 0px;
}
.job-list-modern .job-listing.wtabs .job-style-bx {
    padding-bottom: 31px;
    bottom: 50%;
    
    -webkit-transform: translateY(50%);
    -moz-transform: translateY(50%);
    -ms-transform: translateY(50%);
    -o-transform: translateY(50%);
    transform: translateY(50%);

}
.job-style-bx {
    float: left;
    width: 30%;
    position: absolute;
    right: 0px;
    bottom: 0;
    padding: 15px;
}
.job-style-bx .fav-job {
    font-size: 20px;
    float: right;
    margin-top: 5px;
    margin-right: 10px;
}
.job-style-bx .job-is {
    margin: 0;
    
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;

    color: #ffffff;
}
.ss-wrapper {
  overflow: hidden;
  width: 100%;
  height: 100%;
  position: relative;
  z-index: 1;
  float: left;
}

.ss-content {
  height: 100%;
  width: calc(100% + 18px);
  padding: 0 0 0 0;
  position: relative;
  overflow: auto;
  box-sizing: border-box;
}
.job-is.ft,
.job-list-modern .job-is.ft{
    color: #8b91dd;
    border-color: #8b91dd;
}
.job-is.pt,
.job-list-modern .job-is.pt{
    color: #7dc246;
    border-color: #7dc246;
}
.job-is.fl,
.job-list-modern .job-is.fl{
    color: #fb236a;
    border-color: #fb236a;
}
.job-is.tp,
.job-list-modern .job-is.tp{
    color: #26ae61;
    border-color: #26ae61;
}
.job-is {
    display: table-cell;
    vertical-align: middle;
    font-family: Open Sans;
    font-size: 12px;
    border: 1px solid;
    float: right;
    padding: 7px 0;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;
    width: 108px;
    margin: 9px 0;
    text-align: center;
}
.fav-job.active {
    color: red;
}
.job-listing.wtabs {
    border: 1px solid #ebefef;
    margin-top: 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    display: inherit;
    text-align: left;
    position: relative;
}
.job-listing.wtabs .job-title-sec {
    float: left;
    width: 70%;
}
.job-listing.wtabs .job-title-sec > span {
    color: #1e83f0;
    display: table;
    float: none;
}
.job-listing.wtabs .job-lctn {
    display: inline;
    padding-top: 20px;
    width: 100%;
    font-size: 13px;
}
.job-listing.wtabs .job-lctn i {
    float: none;
    font-size: 15px;
}
.job-listings-sec.style2 .job-listing .job-title-sec span {
    color: #26ae61;
}
.job-listings-sec.style2 .job-listing .job-lctn {
    font-size: 13px;
    color: #888888 !important;;
    line-height: 20px;
    margin-left: 14px;
}
.job-listings-sec.style2 .job-title-sec {
    width: 70%;
}
.job-grid.style2 .job-title-sec {
    padding: 0;
    border: none;
}
.job-grid.style2 .job-title-sec .c-logo {
    margin: 0;
    padding: 0 20px;
}
.job-title-sec {
    display: table-cell;
    vertical-align: middle;
    width: 60%;
}
.job-title-sec h3 {
    display: table;
    font-size: 18px;
    color: #232323;
    margin: 10px 0px;
}
.job-title-sec span {
    float: left;
    font-family: Open Sans;
    font-size: 13px;
 }
 .c-logo {
    float: left;
    width: 130px;
    min-height:100px;
    text-align: center;
}
.ft {
    background: none;
    border-top: 1px solid #eaeeee;
    margin-top: 60px;
}
.c-logo img {
    float: none;
    display: inline-block;
    max-width: 100px;
}
.job-lctn {
    display: table-cell;
    vertical-align: middle;
    font-family: open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 23px;
    width: 25%;
}
.job-lctn i {
    font-size: 24px;
    float: left;
    margin-right: 7px;
}
.fav-job {
    display: table-cell;
    vertical-align: middle;
    font-size: 25px;
    color: #888888;
    line-height: 10px;
    text-align: center;
    cursor: pointer;
}

.job-grid .job-title-sec {
    float: left;
    width: 100%;
    text-align: center;
    position: relative;
    padding-bottom: 20px;
    border-bottom: 1px solid #e8ecec;
}
.job-grid .job-title-sec .c-logo {
    float: left;
    width: 100%;
    margin-top: 50px;
    margin-bottom: 30px;
}
.job-grid .job-title-sec h3 {
    float: left;
    width: 100%;
    margin: 0;
        margin-bottom: 0px;
    text-align: left;
    padding-left: 0px;
    margin-bottom: 6px;
}
.job-grid .job-title-sec span {
    margin-left: 0px;
}

.select-menu {
  --background: #00a0e3;
  --text: #fff;
  --icon: #fff;
  --icon-active: #3F4656;
  --list: #f2f2f2;
  --list-text: rgba(0, 0, 0, 1);
  --list-text-hover: #00a0e3;
  position: relative;
  z-index: 2;
  height:40px;
  font-weight: 500;
  font-size: 14px;
  line-height: 25px;
  margin-right: 10px;
}
.select-menu select,
.select-menu .button {
  font-family: inherit;
  margin: 0;
  border: 0;
  text-align: left;
  text-transform: none;
  -webkit-appearance: none;
}
.select-menu select {
  pointer-events: none;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  opacity: 0;
  padding: 8px 36px 8px 12px;
  visibility: hidden;
  font-weight: 500;
  font-size: 14px;
  line-height: 25px;
}
.select-menu ul {
  margin: 0;
  padding: 0;
  list-style: none;
  position: absolute;
  left: 0;
  top: 0;
  right: 0;
  -webkit-transform: translateY(var(--t));
          transform: translateY(var(--t));
  transition: opacity 0.3s ease, -webkit-transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  transition: opacity 0.3s ease, transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  transition: opacity 0.3s ease, transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1), -webkit-transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
}
.select-menu ul li {
  padding: 8px 36px 8px 12px;
  cursor: pointer;
}
.select-menu > ul {
  background: var(--list);
  color: var(--list-text);
  border-radius: 6px;
}
.select-menu > ul li {
  transition: color .3s ease;
}
.select-menu > ul li:hover {
  color: var(--list-text-hover);
}
.select-menu .button {
  position: absolute;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  padding: 0;
  z-index: 1;
  width: 100%;
  display: block;
  overflow: hidden;
  border-radius: 6px;
  color: var(--text);
  background: var(--background);
}
.select-menu .button em {
  --r: 45deg;
  display: block;
  position: absolute;
  right: 12px;
  top: 0;
  width: 7px;
  height: 7px;
  margin-top: 13px;
  -webkit-backface-visibility: hidden;
}
.select-menu .button em:before, .select-menu .button em:after {
  --o: .4;
  content: \'\';
  width: 7px;
  height: 7px;
  opacity: var(--o);
  display: block;
  position: relative;
  transition: opacity .2s ease;
  -webkit-transform: rotate(var(--r)) scale(0.75);
          transform: rotate(var(--r)) scale(0.75);
}
.select-menu .button em:before {
  border-left: 2px solid var(--icon);
  border-top: 2px solid var(--icon);
  top: 1px;
}
.select-menu .button em:after {
  border-right: 2px solid var(--icon);
  border-bottom: 2px solid var(--icon);
  bottom: 1px;
}
.select-menu:not(.open) > ul {
  opacity: 0;
  pointer-events: none;
}
.select-menu.open.tilt-up {
  -webkit-animation: tilt-up .4s linear forwards;
          animation: tilt-up .4s linear forwards;
}
.select-menu.open.tilt-up .button em:before {
  --o: 1;
}
.select-menu.open.tilt-down {
  -webkit-animation: tilt-down .4s linear forwards;
          animation: tilt-down .4s linear forwards;
}
.select-menu.open.tilt-down .button em:after {
  --o: 1;
}

@-webkit-keyframes tilt-up {
  40%,
    60% {
    -webkit-transform: perspective(500px) rotateX(8deg);
            transform: perspective(500px) rotateX(8deg);
  }
}

@keyframes tilt-up {
  40%,
    60% {
    -webkit-transform: perspective(500px) rotateX(8deg);
            transform: perspective(500px) rotateX(8deg);
  }
}
@-webkit-keyframes tilt-down {
  40%,
    60% {
    -webkit-transform: perspective(500px) rotateX(-8deg);
            transform: perspective(500px) rotateX(-8deg);
  }
}
@keyframes tilt-down {
  40%,
    60% {
    -webkit-transform: perspective(500px) rotateX(-8deg);
            transform: perspective(500px) rotateX(-8deg);
  }
}
.chosen-container{
    border:none !important; 
}
/*--- filters----*/
.widget.border {
    border: 2px solid #e6e7ef;
    padding: 18px 20px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

}
.widget.border:first-child {
    margin-top: 30px;
}
.sb-title {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #111111;
    margin: 0;
    position: relative;
    padding-right: 30px;
    margin-bottom: 10px;
    cursor: pointer;
}
.sb-title::before {
    position: absolute;
    right: 0;
    top: 11px;
    width: 20px;
    height: 1px;
    background: #222222;
    content: "";
}
.posted_widget {
    float: left;
    width: 100%;
}
.posted_widget label {
    float: left;
    width: 100%;
    font-size: 13px;
    color: #888888;
    margin-bottom: 16px;
    padding-left: 30px;
}
.type_widget {
    float: left;
    width: 100%;
}
.type_widget p {
    float: left;
    width: 100%;
    margin: 0;
    font-size: 13px;
    color: #888888;
    margin-bottom: 4px;
}
.type_widget p label {
    padding-left: 31px;
}
.flchek label::before {
    border-color: #fb236a !important;
}
.ftchek label::before {
    border-color: #8b91dd !important;
}
.ischek label::before {
    border-color: #f831e3 !important;
}
.ptchek label::before {
    border-color: #7dc246 !important;
}
.tpchek label::before {
    border-color: #26ae61 !important;
}
.vtchek label::before {
    border-color: #18f0f8 !important;
}
.sb-title::after {
    position: absolute;
    right: 8px;
    top: 4px;
    width: 1px;
    height: 0px;
    background: #222222;
    content: "";
}
.sb-title.open.active::before {
    width: 17px;
}
.sb-title::after {
    height: 0px;
}
.sb-title.open.active::after {
    height: 15px;
}

.sb-title.open.active {
    margin-bottom: 0;
}
.specialism_widget {
    float: left;
    width: 100%;
}
.simple-checkbox p {
    float: left;
    width: 100%;
    margin: 0;
        margin-bottom: 0px;
    font-family: Open Sans;
    font-size: 13px;
    margin-bottom: 4px;
}
.simple-checkbox p label {
    padding-left: 31px;
}
.simple-checkbox p input[type="checkbox"]:checked + label::before, .simple-checkbox p input[type="radio"]:checked + label::before {
    background: #2c7dfa;
    border-color: #2c7dfa;
}
.simple-checkbox p input[type="checkbox"] + label::after {
    color: #ffffff;
}
.simple-checkbox {
    float: left;
    width: 100% !important;
}
.simple-checkbox.scrollbar {
    height: 232px;
}
.sb-title.closed::after {
    height: 15px;
}
.sb-title.closed::before {
    width: 17px;
}
.subscribe_widget > h3 {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #111111;
    margin: 0;
        margin-bottom: 0px;
    position: relative;
    padding-right: 30px;
    margin-bottom: 15px;
    cursor: pointer;
}
 .subscribe_widget form input {
    border: 2px solid #e8ecec;
    color: #333333;
}
 .subscribe_widget form button {
    background: #fb236a;
}

/*---form elements----*/
.widget input[type="checkbox"],
.widget input[type="radio"] {
  position: absolute;
  opacity: 0;
  z-index: -1;
  margin: 0;
}
.widget label {
  position: relative;
  display: inline-block;
  padding: 0 0 0 2em;
  margin-right: 10px;
  height: 1.5em;
  line-height: 1.5;
  cursor: pointer;
}
.widget label::before,
.widget label::after {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 20px !important;
  height: 20px !important;
}
.widget label::before {
  content: " ";
  border: 2px solid #e6e7ef;
  
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  -ms-border-radius: 3px;
  -o-border-radius: 3px;
  border-radius: 3px;

}
/* Checkbox */
.widget input[type="checkbox"] + label::after {
  content: "\2714";
  color: #2c3e50;
  line-height: 1.5;
  text-align: center;
  border: none !important;
}
/* Radio */
.widget input[type="radio"] + label::before {
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  -o-border-radius: 50%;
  border-radius: 50%;

}
.widget input[type=radio] + label::after {
  content: " ";
  top: 7px;
  left: 7px;
  width: 6px !important;
  height: 6px !important;
  background: #fff;
  border: 3px solid #fb236a;
  
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  -o-border-radius: 50%;
  border-radius: 50%;

}
/* :checked */
.widget input[type="checkbox"]:checked + label::before,
.widget input[type="radio"]:checked + label::before {
  background: #ffffff;
  border-color: #e6e7ef;
}
.widget input[type="checkbox"] + label::after,
.widget input[type=radio] + label::after {
  -webkit-transform: scale(0);
  -moz-transform: scale(0);
  -ms-transform: scale(0);
  -o-transform: scale(0);
  transform: scale(0);
}
.widget input[type="checkbox"]:checked + label::after,
.widget input[type=radio]:checked + label::after {
  -webkit-transform: scale(1);
  -moz-transform: scale(1);
  -ms-transform: scale(1);
  -o-transform: scale(1);
  transform: scale(1);
}
/* Transition */
.widget label::before,
.widget label::after {
  -webkit-transition: .25s all ease;
  -moz-transition: .25s all ease;
  -ms-transition: .25s all ease;
  -o-transition: .25s all ease;
  transition: .25s all ease;
}


');
$script = <<< JS
$('.sb-title.open').next().slideDown();
$('.sb-title.closed').next().slideUp();
$('.sb-title').on('click', function(){
    $(this).next().slideToggle();
    $(this).toggleClass('active');
    $(this).toggleClass('closed');
});
let page = 1;
let limit = 10;
var loadmore=false;
var jobPage = 0;
var internPage = 0;
function load_all(page,limit,keywords=null,city=null,date=null,choosetype=null,gender=null,minsalary=null,maxsalary=null)
{
    $.ajax({
    url:window.location.href,
    method: 'post',
    data:{
        page: page, limit: limit,keywords:keywords,location:city,date:date,choosetype:choosetype,gender:gender,minsalary:minsalary,maxsalary:maxsalary
        },
    beforeSend: function()
    {
        $('.img_load').css('display','block');
    },    
    success:function(data){
        $('.img_load').css('display','none');
        if(data.status == 200){
            var career = $('#career-job-box').html();
            $("#career_job_list").html(Mustache.render(career, data.jobs));
            var intern = $('#career-job-box').html();
            $("#career_internship_list").html(Mustache.render(intern, data.internships));
            $('#count').text(data.count);
            if(data['jobs'].length >= 10){
                jobPage = 2;
            }else{ 
                $('#jobMore').hide();
            }
             if(data['internships'].length >= 10){
                internPage = 2;
            }else{
                $('#jobMoreIntern').hide();
            }
        }
    }
 }); 
}
load_all(page=1,limit=10);
$('#jobMore').on('click',function(e) {
  e.preventDefault();
  $.ajax({
    url:window.location.href,
    method: 'post',
    data:{page: jobPage, limit: limit, type: 'jobs'},
    success:function(data){
        if(data.status == 200){
            if(data['jobs'].length > 0){
                var career = $('#career-job-box').html();
                $("#career_job_list").append(Mustache.render(career, data.jobs));
                if(data['jobs'].length >= 10){
                    jobPage++;
                }else{
                    $('#jobMore').hide()
                }
            } else {
                $('#jobMore').hide()
            }
        }
    }
 });
})
$('#jobMoreIntern').on('click',function(e) {
  e.preventDefault();
  $.ajax({
    url:window.location.href,
    method: 'post',
    data:{page: internPage, limit: limit, type: 'internships'},
    success:function(data){
        if(data.status == 200){
            if(data['internships'].length > 0){
                var intern = $('#career-job-box').html();
                $("#career_internship_list").append(Mustache.render(intern, data.internships));
                if(data['internships'].length >= 10){
                    internPage++;
                }else{
                    $('#jobMoreIntern').hide()
                }
            }else {
                $('#jobMoreIntern').hide()
            }
        }
    }
 });
})
 $('.fav-job').on('click', function(){
        $(this).toggleClass('active');
    })
    
 $('select[data-menu]').each(function() {

    let select = $(this),
        options = select.find('option'),
        menu = $('<div />').addClass('select-menu'),
        button = $('<div />').addClass('button'),
        list = $('<ul />'),
        arrow = $('<em />').prependTo(button);

    options.each(function(i) {
        let option = $(this);
        list.append($('<li />').text(option.text()));
    });

    menu.css('--t', select.find(':selected').index() * -41 + 'px');

    select.wrap(menu);

    button.append(list).insertAfter(select);

    list.clone().insertAfter(button);

});

$(document).on('click', '.select-menu', function(e) {

    let menu = $(this);

    if(!menu.hasClass('open')) {
        menu.addClass('open');
    }

});

$(document).on('click', '.select-menu > ul > li', function(e) {

    let li = $(this),
        menu = li.parent().parent(),
        select = menu.children('select'),
        selected = select.find('option:selected'),
        index = li.index();

    menu.css('--t', index * -41 + 'px');
    selected.attr('selected', false);
    select.find('option').eq(index).attr('selected', true);

    menu.addClass(index > selected.index() ? 'tilt-down' : 'tilt-up');

    setTimeout(() => {
        menu.removeClass('open tilt-up tilt-down');
    }, 500);

});

$(document).click(e => {
    e.stopPropagation();
    if($('.select-menu').has(e.target).length === 0) {
        $('.select-menu').removeClass('open');
    }
})
var slugg = slug_var;  
var data = {slug: slugg};

$.ajax({
   type: 'POST',
   url: '/drop-resume/check-resume',
   data : data,
   success: function(response){
       $('#dropcv').val(response.message);
   }
});
$(document).on('submit','#search_form',function(e) {
    e.preventDefault();
    var key = $('#keywords').val();
    var city = $('#cities_drp').val();
    if (key==''&&city=='')
        {
            alert('select atleast one city or atleast enter one keyword');
            return false;
        }
    load_all(page=1,limit=20,keywords=key,city=city);
});  
$(document).on('click','input[name="choose"]',function(e) {
  load_all(page=1,limit=20,keywords=$('#keywords').val(),city=$('#cities_drp').val(),date=$(this).val(),choosetype=getChoosetype(type=[]),gender=getGender(gend=[]),minsalary=getminSalry(),maxsalary=getmaxSalry());
});
$(document).on('click','input[name="choosetype[]"]',function(e) {
  load_all(page=1,limit=20,keywords=$('#keywords').val(),city=$('#cities_drp').val(),date=$('input[name="choose"]:checked').val(),choosetype=getChoosetype(type=[]),gender=getGender(gend=[]),minsalary=getminSalry(),maxsalary=getmaxSalry());
});

$(document).on('click','input[name="smplechk[]"]',function(e) {
      load_all(page=1,limit=20,keywords=$('#keywords').val(),city=$('#cities_drp').val(),date=$('input[name="choose"]:checked').val(),choosetype=getChoosetype(type=[]),gender=getGender(gend=[]),minsalary=getminSalry(),maxsalary=getmaxSalry());
});

$(document).on('click','input[name="salry[]"]',function(e) {
      load_all(page=1,limit=20,keywords=$('#keywords').val(),city=$('#cities_drp').val(),date=$('input[name="choose"]:checked').val(),choosetype=getChoosetype(type=[]),gender=getGender(gend=[]),minsalary=getminSalry(),maxsalary=getmaxSalry());
});

function getGender(gend) {
  $.each($("input[name='smplechk[]']:checked"), function(){            
                gend.push(($(this).val()));
            });
  return gend;
}

function getChoosetype(type) {
  $.each($("input[name='choosetype[]']:checked"), function(){            
                type.push($(this).val());
            });
  return type;
}

function getminSalry() { 
  return $('input[name="salry"]:checked').attr("min-value");
}
function getmaxSalry() {
  return $('input[name="salry"]:checked').attr("max-value");
}
$(document).on('click','input[name="salry"]',function(e) {
  load_all(page=1,limit=20,keywords=$('#keywords').val(),city=$('#cities_drp').val(),date=$('input[name="choose"]:checked').val(),choosetype=getChoosetype(type=[]),gender=getGender(gend=[]),minsalary=getminSalry(),maxsalary=getmaxSalry());
});
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/chosen.css');
$this->registerJsFile('@eyAssets/js/select-chosen.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>


</script>
