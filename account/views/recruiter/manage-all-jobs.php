<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
?>
<style>
    input:hover,input:focus{outline:none}
    :-webkit-input-placeholder{opacity:1}
    :-moz-placeholder{opacity:1}
    :-ms-input-placeholder{opacity:1}
    input[type="text"],
    input[type="password"],
    input[type="email"], textarea {
        background: #e4e4e4 none repeat scroll 0 0;
        border: medium none;
        float: left;
        font-size: 12px;
        font-weight: 400;
        margin-bottom: 20px;
        padding: 19px 28px;
        width: 100%;
    }
    aside, label{
        margin:0;
        padding:0;
        border:0;
        font-size:100%;
        font:inherit;
        vertical-align:baseline;
        display:block;
    }
    aside .widget {
        margin-top: 25px;
    }
    aside .widget:first-child {
        margin: 0;
    }
    aside .widget > div {
        margin-top: 15px;
    }
    aside .widget.border {
        margin-top: 10px;
    }
    aside .widget.border:first-child {
        margin-top: 30px;
    }
    label::before,
    label::after {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 20px !important;
        height: 20px !important;
    }
    label::before {
        content: " ";
        border: 2px solid #e6e7ef;

        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -ms-border-radius: 3px;
        -o-border-radius: 3px;
        border-radius: 3px;
    }
    input[type="checkbox"],
    input[type="radio"] {
        position: absolute;
        opacity: 0;
        z-index: -1;
        margin: 0;
    }
    input[type="checkbox"] + label::after {
        content: "\2714";
        color: #2c3e50;
        line-height: 1.5;
        text-align: center;
        border: none !important;
    }
    /* Radio */
    input[type="radio"] + label::before {
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;

    }
    input[type=radio] + label::after {
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
    input[type="checkbox"]:checked + label::before,
    input[type="radio"]:checked + label::before {
        background: #ffffff;
        border-color: #e6e7ef;
    }
    input[type="checkbox"] + label::after,
    input[type=radio] + label::after {
        -webkit-transform: scale(0);
        -moz-transform: scale(0);
        -ms-transform: scale(0);
        -o-transform: scale(0);
        transform: scale(0);
    }
    input[type="checkbox"]:checked + label::after,
    input[type=radio]:checked + label::after {
        -webkit-transform: scale(1);
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -o-transform: scale(1);
        transform: scale(1);
    }
    label {
        position: relative;
        display: inline-block;
        padding: 0 0 0 2em;
        margin-right: 10px;
        height: 1.5em;
        line-height: 1.5;
        cursor: pointer;
    }
    /* Transition */
    label::before,
    label::after {
        -webkit-transition: .25s all ease;
        -moz-transition: .25s all ease;
        -ms-transition: .25s all ease;
        -o-transition: .25s all ease;
        transition: .25s all ease;
    }
    .border-right {
        padding-right: 40px;
        border-right: 1px solid #edeff7;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #fff;
    }
    .widget {
        float: left;
        width: 100%;
    }
    .widget > h3 {
        float: left;
        width: 100%;
        margin: 0;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
    }
    .search_widget_job {
        float: left;
        width: 100%;
    }
    .field_w_search {
        float: left;
        width: 100%;
        position: relative;
        border: 2px solid #e8ecec;

        -webkit-border-radius: 8px !important;
        -moz-border-radius: 8px !important;
        -ms-border-radius: 8px !important;
        -o-border-radius: 8px !important;
        border-radius: 8px !important;

        margin-bottom: 20px;
    }
    .field_w_search input {
        float: left;
        width: 100%;
        background: none;
        padding: 15px 25px;
        font-size: 13px;
        margin: 0;
        border: none;
    }
    .field_w_search i {
        position: absolute;
        right: 15px;
        top: 17px;
        color: #fb236a;
        font-size: 18px;
    }
    .search_widget_job .field_w_search:last-child {
        margin: 0;
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
        margin-bottom: 0;
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
    .sb-title.closed::after {
        height: 15px;
    }
    .sb-title.closed::before {
        width: 17px;
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
    .specialism_widget {
        float: left;
        width: 100%;
    }
    p {
        color: #666666;
        line-height: 29px;
    }
    .simple-checkbox p {
        float: left;
        width: 100%;
        margin: 0;
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
    .subscribe_widget {
        float: left;
        width: 100%;
    }
    .subscribe_widget > p {
        width: 100%;
        float: left;
        font-family: Open Sans;
        font-size: 13px;
        color: #7a8493;
        line-height: 20px;
    }
    .subscribe_widget form {
        float: left;
        width: 100%;
        position: relative;
    }
    .subscribe_widget form input{
        border: 1px solid #7a8493;
        -webkit-border-radius: 8px !important;
        -moz-border-radius: 8px !important;
        -ms-border-radius: 8px !important;
        -o-border-radius: 8px !important;
        border-radius: 8px !important;
        background: none;
        margin: 0;
        font-family: Open Sans;
        font-size: 13px;
        color: #dae4f3;
        padding: 15px 30px;
    }
    .subscribe_widget form button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        -webkit-border-radius: 0 6px 6px 0px !important;
        -moz-border-radius: 0 6px 6px 0px !important;
        -ms-border-radius: 0 6px 6px 0px !important;
        -o-border-radius: 0 6px 6px 0px !important;
        border-radius: 0 6px 6px 0px !important;
        width: 50px;
        background: #1e83f0;
        padding: 0;
        font-size: 18px;
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
    aside .subscribe_widget form input {
        border: 2px solid #e8ecec;
        color: #333333;
    }
    aside .subscribe_widget form button {
        background: #fb236a;
        border: none;
        color: #fff;
    }
    .subscribe_widget form button:hover {
        background: #fb236a;
    }

    .sb-title::after,
    .sb-title::before,
    .sb-title, .subscribe_widget form button{
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
</style>

<div class="row">
    <aside class="col-md-3 border-right">
        <div class="widget">
            <div class="search_widget_job">
                <div class="field_w_search">
                    <input type="text" placeholder="Search Keywords" />
                    <i class="fa fa-search"></i>
                </div><!-- Search Widget -->
                <div class="field_w_search">
                    <input type="text" placeholder="All Locations" />
                    <i class="fa fa-map-marker"></i>
                </div><!-- Search Widget -->
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title open">Date Posted</h3>
            <div class="posted_widget">
                <input type="radio" name="choose" id="232"><label for="232">Last Hour</label><br />
                <input type="radio" name="choose" id="wwqe"><label for="wwqe">Last 24 hours</label><br />
                <input type="radio" name="choose" id="erewr"><label for="erewr">Last 7 days</label><br />
                <input type="radio" name="choose" id="qwe"><label for="qwe">Last 14 days</label><br />
                <input type="radio" name="choose" id="wqe"><label for="wqe">Last 30 days</label><br />
                <input type="radio" name="choose" id="qweqw"><label class="nm" for="qweqw">All</label><br />
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title open">Job Type</h3>
            <div class="type_widget">
                <p class="flchek"><input type="checkbox" name="choosetype" id="33r"><label for="33r">Freelance (9)</label></p>
                <p class="ftchek"><input type="checkbox" name="choosetype" id="dsf"><label for="dsf">Full Time (8)</label></p>
                <p class="ischek"><input type="checkbox" name="choosetype" id="sdd"><label for="sdd">Internship (8)</label></p>
                <p class="ptchek"><input type="checkbox" name="choosetype" id="sadd"><label for="sadd">Part Time (5)</label></p>
                <p class="tpchek"><input type="checkbox" name="choosetype" id="assa"><label for="assa">Temporary (5)</label></p>
                <p class="vtchek"><input type="checkbox" name="choosetype" id="ghgf"><label for="ghgf">Volunteer (8)</label></p>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title open">Specialism</h3>
            <div class="specialism_widget">
                <div class="field_w_search">
                    <input type="text" placeholder="Search Spaecialisms" />
                </div><!-- Search Widget -->
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="spealism" id="as"><label for="as">Accountancy (2)</label></p>
                    <p><input type="checkbox" name="spealism" id="asd"><label for="asd">Banking (2)</label></p>
                    <p><input type="checkbox" name="spealism" id="errwe"><label for="errwe">Charity & Voluntary (3)</label></p>
                    <p><input type="checkbox" name="spealism" id="fdg"><label for="fdg">Digital & Creative (4)</label></p>
                    <p><input type="checkbox" name="spealism" id="sc"><label for="sc">Estate Agency (3)</label></p>
                    <p><input type="checkbox" name="spealism" id="aw"><label for="aw">Graduate (2)</label></p>
                    <p><input type="checkbox" name="spealism" id="ui"><label for="ui">IT Contractor (7)</label></p>
                    <p><input type="checkbox" name="spealism" id="saas"><label for="saas">Charity & Voluntary (3)</label></p>
                    <p><input type="checkbox" name="spealism" id="rrrt"><label for="rrrt">Digital & Creative (4)</label></p>
                    <p><input type="checkbox" name="spealism" id="eweew"><label for="eweew">Estate Agency (3)</label></p>
                    <p><input type="checkbox" name="spealism" id="bnbn"><label for="bnbn">Graduate (2)</label></p>
                    <p><input type="checkbox" name="spealism" id="ffd"><label for="ffd">IT Contractor (7)</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title closed">Offerd Salary</h3>
            <div class="specialism_widget">
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="smplechk" id="1"><label for="1">10k - 20k</label></p>
                    <p><input type="checkbox" name="smplechk" id="2"><label for="2">20k - 30k</label></p>
                    <p><input type="checkbox" name="smplechk" id="3"><label for="3">30k - 40k</label></p>
                    <p><input type="checkbox" name="smplechk" id="4"><label for="4">40k - 50k</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title closed">Career Level</h3>
            <div class="specialism_widget">
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="smplechk" id="5"><label for="5">Intermediate</label></p>
                    <p><input type="checkbox" name="smplechk" id="6"><label for="6">Normal</label></p>
                    <p><input type="checkbox" name="smplechk" id="7"><label for="7">Special</label></p>
                    <p><input type="checkbox" name="smplechk" id="8"><label for="8">Experienced</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title closed">Experince</h3>
            <div class="specialism_widget">
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="smplechk" id="9"><label for="9">1Year to 2Year</label></p>
                    <p><input type="checkbox" name="smplechk" id="10"><label for="10">2Year to 3Year</label></p>
                    <p><input type="checkbox" name="smplechk" id="11"><label for="11">3Year to 4Year</label></p>
                    <p><input type="checkbox" name="smplechk" id="12"><label for="12">4Year to 5Year</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title closed">Gender</h3>
            <div class="specialism_widget">
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="smplechk" id="13"><label for="13">Male</label></p>
                    <p><input type="checkbox" name="smplechk" id="14"><label for="14">Female</label></p>
                    <p><input type="checkbox" name="smplechk" id="15"><label for="15">Others</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title closed">Industry</h3>
            <div class="specialism_widget">
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="smplechk" id="16"><label for="16">Meezan Job</label></p>
                    <p><input type="checkbox" name="smplechk" id="17"><label for="17">Speicalize Jobs</label></p>
                    <p><input type="checkbox" name="smplechk" id="18"><label for="18">Business Jobs</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="sb-title closed">Qualification</h3>
            <div class="specialism_widget">
                <div class="simple-checkbox">
                    <p><input type="checkbox" name="smplechk" id="19"><label for="19">Matriculation</label></p>
                    <p><input type="checkbox" name="smplechk" id="20"><label for="20">Intermidiate</label></p>
                    <p><input type="checkbox" name="smplechk" id="21"><label for="21">Gradute</label></p>
                </div>
            </div>
        </div>
        <div class="widget">
            <div class="subscribe_widget">
                <h3>Still Need Help ?</h3>
                <p>Let us now about your issue and a Professional will reach you out.</p>
                <form>
                    <input placeholder="Enter Valid Email Address" type="text">
                    <button type="submit"><i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </aside>
    <div class="col-md-9">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Manage Job Applications</span>
                    </div>
                    <!--                    <div class="actions">
                                            <div class="btn-group dashboard-button">
                    <?=
                    Html::button('Add New', [
                        'class' => 'btn blue btn-outline btn-circle btn-sm',
                        'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'add-candidate-profile'),
                        'id' => 'addpro',
                        'data-toggle' => 'modal',
                        'data-target' => '#addprofile',
                    ]);
                    ?>
                    
                                            </div>
                                        </div>-->
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <div class="row">

                                <!-- BEGIN: Actions -->
                                <!--<div class="mt-actions scroller " style="height: 450px;" >-->
                                <div class="col-md-12">
                                    <!-- BEGIN BORDERED TABLE PORTLET-->
                                    <div class="portlet light portlet-fit ">
                                        <div class="portlet-body">
                                            <div class="table-scrollable table-scrollable-borderless">
                                                <table class="table table-hover table-light">
                                                    <thead>
                                                        <tr class="uppercase">
                                                            <th> # </th>
                                                            <th> Title </th>
                                                            <th> Applications </th>
                                                            <th>Company Name </th>                                                            <th> Status </th>
                                                            <!--<th> Action </th>-->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td> 1 </td>
                                                            <td width="30%"> Business Development Executive </td>
                                                            <td> 3 Applied</td>
                                                            <td> DSB Edu Tech</td>
                                                            <td>
                                                                <span class="label label-sm label-success"> Approved </span>
                                                            </td>
<!--                                                            <td class="act-icons"> 
                                                                <div class="tooltip">
                                                                    <a href="/site/candidate-profile" class="bttn"> <i class="fa fa-eye"></i></a>
                                                                    <span class="tooltiptext">View</span>
                                                                </div>
                                                                <div class="tooltip pad-10">
                                                                    <a href="/job/php-developer-senior-developer-1536039714" class=" bttn"><i class="fa fa-pencil"></i></a>
                                                                    <span class="tooltiptext">Edit</span>
                                                                </div>
                                                                <div class="tooltip">
                                                                    <a class="bttn removejob"><i class="fa fa-trash"></i></a>
                                                                    <span class="tooltiptext">Delete</span>
                                                                </div>    
                                                            </td>-->
                                                        </tr>
                                                        <tr>
                                                            <td> 2 </td>
                                                            <td> Business Development Executive </td>
                                                            <td> 3 Applied </td>
                                                            <td> DSB Edu Tech </td>
                                                            <td>
                                                                <span class="label label-sm label-info"> Pending </span>
                                                            </td>
<!--                                                            <td class="act-icons"> 
                                                                <div class="tooltip">
                                                                    <a href="/site/candidate-profile" class="bttn"> <i class="fa fa-eye"></i></a>
                                                                    <span class="tooltiptext">View</span>
                                                                </div>
                                                                <div class="tooltip pad-10">
                                                                    <a href="/job/php-developer-senior-developer-1536039714" class=" bttn"><i class="fa fa-pencil"></i></a>
                                                                    <span class="tooltiptext">Edit</span>
                                                                </div>
                                                                <div class="tooltip">
                                                                    <a class="bttn removejob"><i class="fa fa-trash"></i></a>
                                                                    <span class="tooltiptext">Delete</span>
                                                                </div>    
                                                            </td>-->
                                                        </tr>
                                                        <tr>
                                                            <td> 3 </td>
                                                            <td> Business Development Executive </td>
                                                            <td> 3 Applied </td>
                                                            <td> DSB Edu Tech </td>
                                                            <td>
                                                                <span class="label label-sm label-danger"> Rejected </span>
                                                            </td>
<!--                                                            <td class="act-icons"> 
                                                                <div class="tooltip">
                                                                    <a href="/site/candidate-profile" class="bttn"> <i class="fa fa-eye"></i></a>
                                                                    <span class="tooltiptext">View</span>
                                                                </div>
                                                                <div class="tooltip pad-10">
                                                                    <a href="/job/php-developer-senior-developer-1536039714" class=" bttn"><i class="fa fa-pencil"></i></a>
                                                                    <span class="tooltiptext">Edit</span>
                                                                </div>
                                                                <div class="tooltip">
                                                                    <a class="bttn removejob"><i class="fa fa-trash"></i></a>
                                                                    <span class="tooltiptext">Delete</span>
                                                                </div>    
                                                            </td>-->
                                                        </tr>
                                                        <tr>
                                                            <td> 4 </td>
                                                            <td> Business Development Executive </td>
                                                            <td> 3 Applied </td>
                                                            <td> DSB Edu Tech </td>
                                                            <td>
                                                                <span class="label label-sm label-danger"> Rejected </span>
                                                            </td>
<!--                                                            <td class="act-icons"> 
                                                                <div class="tooltip">
                                                                    <a href="/site/candidate-profile" class="bttn"> <i class="fa fa-eye"></i></a>
                                                                    <span class="tooltiptext">View</span>
                                                                </div>
                                                                <div class="tooltip pad-10">
                                                                    <a href="/job/php-developer-senior-developer-1536039714" class=" bttn"><i class="fa fa-pencil"></i></a>
                                                                    <span class="tooltiptext">Edit</span>
                                                                </div>
                                                                <div class="tooltip">
                                                                    <a class="bttn removejob"><i class="fa fa-trash"></i></a>
                                                                    <span class="tooltiptext">Delete</span>
                                                                </div>    
                                                            </td>
                                                        </tr>-->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END BORDERED TABLE PORTLET-->
                                </div>
                                <!--                        </div>-->
                                <!-- END: Actions -->
                            </div>
                        </div>
                        <div class="com-load-more-btn">
                            <button type="button" id="comloadmore" class="btn blue">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addprofile" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
 .large-container{
   max-width: 1400px !important;
   padding-left: 15px;
   padding-right: 15px;
   margin:auto;
 }
.dashboard-button a, .dashboard-button button{    
    margin-left:10px !important;
}
.intl-tel-input {
    width: 100%;
}

.thumbnail{
    padding: 0px !important;
    margin: 20px auto 25px auto !important;
}
.thumbnail img{
    width: 100%;
    height: 100%;
}
.js-title-step span{
    display:none;
}
.com-load-more-btn{text-align:center;}
tr{height:60px;}

//.tooltip {
//    position: relative;
//    display: inline-block;
//    opacity:1 !important;
//  z-index:0;
//  }
//.tooltip .tooltiptext {
//    visibility: hidden;
//    width:80px;
//    background-color:rgba(0,0,0,.5);
//    color: #fff;
//    text-align: center;
//    padding: 5px 0;
//    border-radius: 60px;
//    bottom: 100%;
//    left: 50%; 
//    margin-left: -40px;
//    position: absolute;
//  
//}
//.tooltip .tooltiptext::after {
//    content: " ";
//    position: absolute;
//    top: 100%; /* At the bottom of the tooltip */
//    left: 50%;
//    margin-left: -5px;
//    border-width: 5px;
//    border-style: solid;
//    border-color: rgba(0,0,0,.5) transparent transparent transparent;
//}
//
//.tooltip:hover .tooltiptext {
//    visibility: visible;
//}
');
$script = <<<JS

$(document).on("click", "#addpro", function () {
    $(".modal-body").load($(this).attr("url"));
});
        
        
$('.sb-title.open').next().slideDown();
$('.sb-title.closed').next().slideUp();
$('.sb-title').on('click', function(){
    $(this).next().slideToggle();
    $(this).toggleClass('active');
    $(this).toggleClass('closed');
});

 
        
!function(a){"use strict";a.fn.modalSteps=function(b){var c=this,d=a.extend({btnCancelHtml:"Cancel",btnPreviousHtml:"Previous",btnNextHtml:"Next",btnLastStepHtml:"Complete",disableNextButton:!1,completeCallback:function(){},callbacks:{},getTitleAndStep:function(){}},b),e=function(){var a=d.callbacks["*"];if(void 0!==a&&"function"!=typeof a)throw"everyStepCallback is not a function! I need a function";if("function"!=typeof d.completeCallback)throw"completeCallback is not a function! I need a function";for(var b in d.callbacks)if(d.callbacks.hasOwnProperty(b)){var c=d.callbacks[b];if("*"!==b&&void 0!==c&&"function"!=typeof c)throw"Step "+b+" callback must be a function"}},f=function(a){return void 0!==a&&"function"==typeof a&&(a(),!0)};return c.on("show.bs.modal",function(){var l,m,n,o,p,b=c.find(".modal-footer"),g=b.find(".js-btn-step[data-orientation=cancel]"),h=b.find(".js-btn-step[data-orientation=previous]"),i=b.find(".js-btn-step[data-orientation=next]"),j=d.callbacks["*"],k=d.callbacks[1];d.disableNextButton&&i.attr("disabled","disabled"),h.attr("disabled","disabled"),e(),f(j),f(k),g.html(d.btnCancelHtml),h.html(d.btnPreviousHtml),i.html(d.btnNextHtml),m=a("<input>").attr({type:"hidden",id:"actual-step",value:"1"}),c.find("#actual-step").remove(),c.append(m),l=1,p=l+1,c.find("[data-step="+l+"]").removeClass("hide"),i.attr("data-step",p),n=c.find("[data-step="+l+"]").data("title"),o=a("<span>").addClass("label label-success").html(l),c.find(".js-title-step").append(o).append(" "+n),d.getTitleAndStep(m.attr("data-title"),l)}).on("hidden.bs.modal",function(){var a=c.find("#actual-step"),b=c.find(".js-btn-step[data-orientation=next]");c.find("[data-step]").not(c.find(".js-btn-step")).addClass("hide"),a.not(c.find(".js-btn-step")).remove(),b.attr("data-step",1).html(d.btnNextHtml),c.find(".js-title-step").html("")}),c.find(".js-btn-step").on("click",function(){var m,n,o,p,b=a(this),e=c.find("#actual-step"),g=c.find(".js-btn-step[data-orientation=previous]"),h=c.find(".js-btn-step[data-orientation=next]"),i=c.find(".js-title-step"),j=b.data("orientation"),k=parseInt(e.val()),l=d.callbacks["*"];if(m=c.find("div[data-step]").length,"complete"===b.attr("data-step"))return d.completeCallback(),void c.modal("hide");if("next"===j)n=k+1,g.attr("data-step",k),e.val(n);else{if("previous"!==j)return void c.modal("hide");n=k-1,h.attr("data-step",k),g.attr("data-step",n-1),e.val(k-1)}parseInt(e.val())===m?h.attr("data-step","complete").html(d.btnLastStepHtml):h.attr("data-step",n).html(d.btnNextHtml),d.disableNextButton&&h.attr("disabled","disabled"),c.find("[data-step="+k+"]").not(c.find(".js-btn-step")).addClass("hide"),c.find("[data-step="+n+"]").not(c.find(".js-btn-step")).removeClass("hide"),parseInt(g.attr("data-step"))>0?g.removeAttr("disabled"):g.attr("disabled","disabled"),"previous"===j&&h.removeAttr("disabled"),o=c.find("[data-step="+n+"]"),o.attr("data-unlock-continue")&&h.removeAttr("disabled"),p=o.attr("data-title");var q=a("<span>").addClass("label label-success").html(n);i.html(q).append(" "+p),d.getTitleAndStep(o.attr("data-title"),n);var r=d.callbacks[e.val()];f(l),f(r)}),this}}(jQuery);
        $('#add-new').modalSteps();
        
   var callback = function(){
 
//        if($('#company-form').yiiActiveForm('validate', true))
//        {
//          disableNextButton:1;
//         }
//        else
//        {
//          disableNextButton:!1;
//        }
       $('form').valid();
   }
       
  $('#add-new').modalSteps({
       callbacks:{
           '*':callback
        }
   });    
        

        
      



        
$(document).on('click','.removejob',function(){
    $(this).closest("tr").remove();
});
        
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
