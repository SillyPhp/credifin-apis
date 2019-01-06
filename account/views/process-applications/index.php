<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<!--<div class="row">
    <div class="col-md-5 col-md-offset-7">
        <div class="col-md-4">
            <a class="btn btn-primary custom-buttons" href="/account/jobs/application">
                Create a Job
            </a>
        </div>
        <div class="col-md-4">
<?=
Html::button('Add New Candidate', [
    'class' => 'btn btn-primary custom-buttons',
    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'add-candidate-profile'),
    'id' => 'addpro',
    'data-toggle' => 'modal',
    'data-target' => '#addprofile',
]);
?>
        </div>
        <div class="col-md-4">
                  <a class="btn btn-primary custom-buttons" href="/account/companies">
                               Add new company
                            </a>
<?=
Html::button('Add New Company', [
    'class' => 'btn btn-primary custom-buttons',
    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'company-form'),
    'id' => 'open-modal',
    'data-toggle' => 'modal',
    'data-target' => '#add-new',
]);
?>
        </div>
    </div>
</div>-->

<div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                     alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Process Applications of <?= $application['name']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row cd-box">

                                    <?php
                                    Pjax::begin(['id' => 'pjax_filters']);

                                    if (!empty($fields)) {
                                        foreach ($fields as $arr) {
                                            foreach ($arr as $user) {
                                                ?>
                                                <div class="cd-can-box">
                                                    <div class="cd-box-border" id="cd-box-border">
                                                        <div class="row">
                                                            <div class=" cd-user-icon col-md-6">
                                                                <a href="<?= '/user/' . $user['username'] ?>"
                                                                   target="_blank">
                                                                    <?php if ($user['image']): ?>
                                                                        <img src="<?= $user['image'] ?>"
                                                                             class="img-responsive img-thumbnail img-rounded">
                                                                    <?php else: ?>
                                                                        <canvas class="user-icon"
                                                                                name="<?= $user['name'] ?>" width="80"
                                                                                height="80" font="35px"></canvas>
                                                                    <?php endif; ?>
                                                                </a>
                                                            </div>
                                                            <div class="vj-btn col-md-6">
                                                                <a href="<?= '/user/' . $user['username'] ?>">View
                                                                    Profile</a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="cd-user-detail col-md-2">
                                                                <div class="cd-u-name">
                                                                    <a href="<?= '/user/' . $user['username'] ?>"
                                                                       target="_blank">
                                                                        <?= $user['name'] ?>
                                                                    </a>
                                                                </div>
                                                                <div class="cd-u-field"></div>
                                                                <div class="cd-u-p-company"></div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="steps-form-2">
                                                                            <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                                                                <?php
                                                                                $len = count($user['process']);
                                                                                $j = 0;
                                                                                foreach ($user['process'] as $p) {
                                                                                    ?>
                                                                                    <div class="steps-step-2 <?php
                                                                                    if ($j < $user['active']) {
                                                                                        echo 'active';
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>">
                                                                                        <a type="button"
                                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey <?php
                                                                                           if ($j < $user['active']) {
                                                                                               echo 'active';
                                                                                           } elseif ($j == $user['active']) {
                                                                                               echo 'current';
                                                                                           }
                                                                                           ?>" data-toggle="tooltip"
                                                                                           data-placement="top" title=""
                                                                                           data-id="<?= $p['field_enc_id'] ?>"
                                                                                           data-original-title="<?= $p['field_name'] ?>">
                                                                                            <i class="<?= $p['icon'] ?>"
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
                                                            <div class="cd-btns col-md-2">
                                                                <button type="button"
                                                                        class="btn btn-outline btn-circle blue btn-sm approve"
                                                                        value="<?= $user['app_id']; ?>">Approve
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-outline btn-circle blue btn-sm reject">
                                                                    Reject
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="slide-btn">
                                                                    <button class="slide-bttn" type="button">
                                                                        <i class="fa fa-angle-double-down"
                                                                           aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="cd-box-border-hide">

                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Question</th>
                                                                <th>Process Name</th>
                                                                <th>Rating</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="qu_data">
                                                            <?php foreach ($que as $list_que) { ?>
                                                                <tr>
                                                                    <td><a class="blue"
                                                                           href="/account/answers-display?q=<?= $list_que['qid']; ?>&a=<?= $user['app_id']; ?>"
                                                                           value="'+this.qid+'"
                                                                           target="_blank"><?= $list_que['name']; ?></a>
                                                                    </td>
                                                                    <td><?= $list_que['field_label']; ?></td>
                                                                    <td>
                                                                        <fieldset class="rate">
                                                                            <input id="6<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   class="rating_sys rate_input"
                                                                                   type="radio"
                                                                                   name="rate<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   value="5"/>
                                                                            <label class="rate_label">
                                                                                for="6<?= $list_que['qid'] . $user['app_id']; ?>
                                                                                " title="Unsatisfactory">5</label>

                                                                            <input id="7<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   class="rating_sys rate_input"
                                                                                   type="radio"
                                                                                   name="rate<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   value="4"/>
                                                                            <label class="rate_label">
                                                                                for="7<?= $list_que['qid'] . $user['app_id']; ?>
                                                                                " title="Bad">4</label>
                                                                            <input id="8<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   class="rating_sys rate_input"
                                                                                   type="radio"
                                                                                   name="rate<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   value="3"/>
                                                                            <label class="rate_label"
                                                                                   for="8<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   title="Very bad">3</label>

                                                                            <input id="9<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   class="rating_sys rate_input"
                                                                                   type="radio"
                                                                                   name="rate<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   value="2"/>
                                                                            <label class="rate_label"
                                                                                   for="9<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   title="Awful">2</label>

                                                                            <input id="10<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   class="rating_sys rate_input"
                                                                                   type="radio"
                                                                                   name="rate<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   value="1"/>
                                                                            <label class="rate_label"
                                                                                   for="10<?= $list_que['qid'] . $user['app_id']; ?>"
                                                                                   title="Horrific">1</label>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <h3>No Applicant has Applied For This Post</h3>
                                        <?php
                                    }
                                    Pjax::end();
                                    ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="light-box"></div>
<div class="main-outer">
    <div class="main-inner">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <h2 class="text-center"><?= Yii::t('account', 'Select Date and time for Interview'); ?></h2>
                    <a class="close_schedule">&times;</a>
                    <div class="tab">
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-4">Select Title</label>
                                <div class="col-md-8">
                                    <select name="application_id" class="form-control" id="application_id"
                                            style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <?php
                                        foreach ($application as $a) {
                                            ?>
                                            <option value="<?= $a['application_id'] ?>"><?= $a['name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Interviewer</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control input-large" data-role="tagsinput"
                                           id="email"></div>
                            </div>
                            <div class="form-group">
                                <label for="color" class="control-label col-md-4">Select Color</label>
                                <div class="col-md-8">
                                    <select name="color" class="form-control" id="color"
                                            style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                        <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                        <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                        <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                        <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                        <option style="color:#000;" value="#000">&#9724; Black</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Select Interview Date</label>
                                <div class="col-md-8">
                                    <input class="form-control form-control-inline input-medium date-picker" size="16"
                                           type="text" id="datepicker" value=""/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-4">Select Inteview Duration</label>
                                <div class="col-md-8">
                                    <select name="interview_slots" class="form-control" id="interview_slots"
                                            style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <option>15 minutes</option>
                                        <option>30 minutes</option>
                                        <option>45 minutes</option>
                                        <option>60 minutes</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="color" class="control-label col-md-4">Medium</label>
                                <div class="col-md-8">
                                    <select name="color" class="form-control" id="location"
                                            style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <option>In Place</option>
                                        <option>Conference Call</option>
                                        <option>Phone</option>
                                        <option>Skype</option>
                                        <option>Online</option>
                                        <option>Google Hangouts</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Notes</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" value="" id="notes"
                                              style="background-color: #eef1f5; "></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="row">
                            <div id="selected-dates"></div>
                        </div>
                    </div>
                    <div class="row" style="float:right;">
                        <button type="button" class="btn btn-warning" id="previous">Previous</button>
                        <button type="button" class="btn btn-success" id="next">Next</button>
                        <button type="button" class="btn btn-success" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
#submit{
    display:none;
}
.close_schedule{
    background: #b1b1b1bd;
    border: 0px;
    position: absolute;
    right: -10px;
    top: 0;
    font-size: 35px;
    color: #fff;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 0px 0px 0px 15px !important;
}
.rate {
  display: inline-block;
  margin: 0;
  padding: 0;
  border: none;
}

.rate_input {
  display: none;
}

.rate_label {
  float: right;
  font-size: 0;
  color: #d9d9d9;
}

.rate_label:before {
  content: "\f005";
  font-family: FontAwesome;
  font-size: 28px; 
}

.rate_label:hover,
.rate_label:hover ~ label {
  color: #fcd000;
  transition: 0.2s;
}

.rate_label:checked ~ label {
  color: #ffeb3b;
}

.rate_label:checked ~ label:hover,
.rate_label:checked ~ label:hover ~ label {
  color: #fcd000;
  transition: 0.2s;
}

/* Half-star*/
.star-half {
  position: relative;
}

.star-half:before {
  position: absolute;
  content: "\f089";
  padding-right: 0;
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
select{
    padding:5px 10px; border-radius:5px !important;
}
select:focus{
    outline:none;
}
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
 .multiselect-container>li>a>label {
  padding: 0px 20px 0px 20px;
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

.js-title-step span{
    display:none;
}
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
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
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}

//.spin {
//  width: 5em;
//  height: 5em;
//  padding: 0;
//  border-radius: 100%;
//  box-shadow: none;
//}
//.spin::before, .spin::after {
//  box-sizing: inherit;
//  content: "";
//  position: absolute;
//  width: 100%;
//  height: 100%;
//  top: 0;
//  left: 0;
//  border-radius: 100%;
//}
//.spin::before {
//  border: 2px solid transparent;
//
//  border-top-color: #0eb7da;
//  border-right-color: #0eb7da;
//  border-bottom-color: #0eb7da;
//  transition: border-top-color 0.75s linear, border-right-color 0.75s linear 0.5s, border-bottom-color 0.75s linear 0.95s;
//}
//.spin::after {
//  border: 0 solid transparent;
//
//  border-top: 2px solid #0eb7da;
//  border-left-width: 2px;
//  border-right-width: 2px;
//  -webkit-transform: rotate(270deg);
//          transform: rotate(270deg);
//  transition: border-left-width 0s linear 1.75s, -webkit-transform 2.0s linear 0s;
//  transition: transform 2.0s linear 0s, border-left-width 0s linear 1.75s;
//  transition: transform 2.0s linear 0s, border-left-width 0s linear 1.75s, -webkit-transform 2.0s linear 0s;
//}

/* Top Radio filter css starts */
.filters{
    height: auto;
    width: auto;
    font-size:14px;
    margin: 0px 1px;
    background-color:#eee;
    padding:10px 15px;
    border-radius:8px !important;
    cursor: pointer;
    position:relative;
    display:inline-block;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
}
.filters:hover{
    background-color:#00a0e3;
    color:#fff;
}

.super-happy{
    position: absolute;
    opacity: 0;
}
.page-container-bg-solid .page-content{
        background-color: #fff;
    }
    .bootstrap-tagsinput{
        border-radius: 6px;
        background-color: #eef1f5;
    }
    .timepicker{
        background-color: #eef1f5;
    }
    .bootstrap-tagsinput input{
        box-shadow:none !important;
        border-color: transparent;
        background-color: #eef1f5;
    }
    .bootstrap-tagsinput input:focus{
        outline: none;
    }
    .input-medium{
        width: 100% !important;
    }
    .time-slots{
        margin: 15px 0px;
    }
    .remove-add{
        line-height: 34px;
        font-size: 20px;
    }
    .date-picker{
        background-color: #eef1f5;
        margin: auto;
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #c2cad8;
    }
    .timepicker {
        border-radius: 4px !important;
    }
    textarea{
        resize: none;
    }
input[class="super-happy"]:hover + span,
input[class="super-happy"]:checked + span,
input[class="super-happy"]:focus + span {
    color: #fff;
    background-color:#00a0e3;
    border-radius:8px;
}

/* Top Radio filter css ends */
.datepicker>div {
    display: block;
}
/* Modal light box css starts */
.form {
    padding: 0 16px;
    max-width: 750px;
    margin: 15px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}
.form h2{
    margin-bottom:15px;
}
.light-box{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.8;
    display:none;
    z-index: 2000;
}
.main-inner{
    width:100%;
    height:100%;
    display:none;
    background-color: #fff;
    border-radius: 10px !important;
    position:relative;
    padding: 0px 25px;
    padding-bottom: 20px;
    overflow:hidden;
}
.main-outer{
    width:60%;
    height:80%;
    top:10%;
    left:20%;
    display: none;
    position: fixed;
    overflow:hidden;
    z-index: 2000;
    background-color: #fff;
    border-radius: 10px !important;
}
.main-inner form {
    padding: 0 16px;
    max-width: 750px;
    margin: 15px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}
.main-inner form h2{
    margin-bottom:15px;
}
@media(min-width : 1500px) {
    .main-outer{
        width: 50%;
        height: 70%;
        top:15%;
        left:25%;
    }
}
.tab{
    display: none;
}
/* Modal light box css ends */
');
$script = <<<JS
    
        
$('[data-toggle="tooltip"]').tooltip();
        
$('#chkveg').multiselect({
    includeSelectAllOption: true
});

//$('#btnget').click(function() {
//    alert($('#chkveg').val());    
//}); 



$(document).on('click','.slide-bttn',function()
    {   
     $(this).closest('.cd-can-box').find('.cd-box-border-hide').slideToggle('slow');
   })  

$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));   
});
$(document).on('click', '.approve', function() {
    var field_id = $(this).parent().prev('div').find('.current').attr('data-id');  
    var app_id = $(this).val();
    var btn = $(this);
   $.ajax({
       url:'/account/jobs/approve-candidate',
       data:{field_id:field_id,app_id:app_id},
       method:'post',
       beforeSend:function()  {
                    btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                    btn.attr("disabled","true");
                    },    
       success:function(data)
           {
            if(data==true)
                {
                  disable(btn);
                  run(btn);
                }
            else
            {
               disable(btn);
               alert('something went wrong..');
            }
          }
       }) 
});
  function disable(thisObj){thisObj.html('APPROVE');thisObj.removeAttr("disabled");}          
            
   function run(thisObj)
       {
    var current_div = $(thisObj).parent().prev('div').find('.steps-step-2:first');
    if(current_div.hasClass('active')) {
        current_div = $(thisObj).parent().prev('div').find('.steps-step-2.active:last').next('.steps-step-2');
    }
    if(!(current_div.is(':last-child'))) {
        current_div.addClass('active');
        setTimeout(function() {
            current_div.next('div').find('a').addClass('current');
        }, 1000);
        
    }
    current_div.find('a').removeClass('current').addClass('active');
       }
   
//   $('#myModal').modalSteps();
        
   var currentTab = 0;
   showTab(currentTab);
   
   $('#previous').on('click', function(){
        $('#selected-dates').html('');
        nextPrev(-1);
    });
    $('#next').on('click', function(){
        var date_picker_value = $('#datepicker').val();
        if(date_picker_value != ''){
            nextPrev(1);
        }
        else{
            return false;
        }
    });
        
   function nextPrev(n){
        var x = document.getElementsByClassName('tab');
        if(n==1){
            addTimes();
        }
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if(currentTab >= x.length){
            return false;
        }
        showTab(currentTab);
    }
        
   function showTab(n){
        var x = document.getElementsByClassName('tab');
        x[n].style.display = "block";
        if(n==0){
            document.getElementById('previous').style.display = "none";
        }else{
            document.getElementById('previous').style.display = "inline";
        }
        if(n==(x.length-1)){
            document.getElementById('next').style.display = "none";
            document.getElementById('submit').style.display = "inline";
//            document.getElementById('next').innerHTML = 'Submit';
        }else{
            document.getElementById('next').style.display = "inline";
            document.getElementById('submit').style.display = "none";
//            document.getElementById('next').innerHTML = 'Next';
        }
   }
        
   $(document).on('click', '#add-more', function(){
       $(this).closest('div').prev('#times-container').append(Mustache.render($('#add-more-d').html()));
    });
        
   $(document).on('click', '.remove-add', function(){
        $(this).closest('#added-date').remove()
   });
        
    $(document).on('focus', '.timepicker', function(){
        $(this).timepicker(); 
    });
        
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        multidate: true,
        startDate: '-0m'
    });
        
    function convert(str) {
            var mnths = { 
                Jan:"01", Feb:"02", Mar:"03", Apr:"04", May:"05", Jun:"06",
                Jul:"07", Aug:"08", Sep:"09", Oct:"10", Nov:"11", Dec:"12"
            },
            date = str.split(" ");

            return [ date[2], mnths[date[1]], date[3] ].join("-");
        }
        
    var dates = [];
        
    function addTimes() {
            dates=[];
//        var time_intervals = [];
        var the_date = $('.date-picker:first').datepicker('getDates');
        for(var j=0; j<the_date.length; j++){
            var s_date = convert(the_date[j].toString());
            dates.push({date: s_date});
        }
        
        $('#selected-dates').append(Mustache.render($('#dates').html(), dates));
//        var time_l = $('.time-slots').length;
//        for(var i = 1; i<= time_l; i++){
//            time_intervals.push({'start' : $('#start-time-'+i).val(), 'end': $('#end-time-'+i).val()});
//        }
    }
    

        $('#schedule-interview').click(function () {
            $('.light-box').fadeIn(500);
            $('.main-inner').fadeIn(1000);
            $('.main-outer').fadeIn(1000);
        });
        $('.close_schedule').click(function () {
            $('.light-box').fadeOut(500);
            $('.main-inner').fadeOut(1000);
            $('.main-outer').fadeOut(1000);
        });
        $(document).bind('keydown', function (e) {
            if (e.which == 27) {
                $('.light-box').fadeIn(500);
                $('.main-inner').fadeIn(1000);
                $('.main-outer').fadeIn(1000);
            }
        });
        
        
         $(document).on('click', '.city_label', function(){
           var city_id = $(this).find('input').attr('id');
            
            $.ajax({
                url : 'application-process' ,
                method : 'POST' ,
                data : {city_id:city_id} ,
                success : function(data)
                {
                    $.pjax.reload({container: '#pjax_filters', async: false});
//                    JSON_parse(data);
        console.log(data);
                    }
            });
        });
        
        
var ps = new PerfectScrollbar('.main-inner');
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-colorpicker/css/colorpicker.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Dosis|Indie+Flower|Mali|Titillium+Web');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/plugins.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/components.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('http://davidstutz.de/bootstrap-multiselect/dist/css/bootstrap-multiselect.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('http://davidstutz.de/bootstrap-multiselect/dist/js/bootstrap-multiselect.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/multi_tab_modal.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<!--    <script type="text/javascript">
    $(document).on('click', '.approve', function() {
        console.log($(this).closest('.steps-row-2.active:last').next('.steps-row-2'));
    });
    </script>    -->

<script id="dates" type="text/template">
    {{#.}}
    <div class="form-group">

        <label class="control-label col-md-3">{{date}}</label>

        <div class="col-md-9">
            <div class="row">
                <div id="row1" class="row time-slots">
                    <div class="col-md-5">
                        <div class="input-group timepicker-main">
                            <input type="text" class="form-control timepicker timepicker-24" id="start-time-1"
                                   placeholder="from">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h5>-</h5>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group timepicker-main">
                            <input type="text" class="form-control timepicker timepicker-24" id="end-time-1"
                                   placeholder="to">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="times-container"></div>
        <div class="col-md-9 col-md-offset-3">
            <a href="#" id="add-more"><i class="fa fa-plus-circle"></i> Add more</a>
        </div>
    </div>
    {{/.}}
</script>

<script id="add-more-d" type="text/template">
    <div style="padding:0px;margin-top:15px;" id="added-date" class='col-md-9 col-md-offset-3'>
        <div class='col-md-5'>
            <div class='input-group timepicker-main'>
                <input type='text' class='form-control timepicker timepicker-24' placeholder='from'>
            </div>
        </div>
        <div class='col-md-1'>
            <h5>-</h5>
        </div>
        <div class='col-md-5'>
            <div class='input-group timepicker-main'>
                <input type='text' class='form-control timepicker timepicker-24' placeholder='to'>
            </div>
        </div>
        <div class='col-md-1'>
            <a class='remove-add'>
                <i class='fa fa-times'></i>
            </a>
        </div>
    </div>
</script>

