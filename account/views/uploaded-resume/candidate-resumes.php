<?php

use yii\helpers\Html;
use yii\helpers\Url;


?>
<div class="">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Applied Profiles</span>
                    </div>
                    <div class="actions">
                        <div id="btn-group2" class="btn-group dashboard-button btns2 ">
                            <button class="viewall-jobs" data-toggle="modal" data-target="#shortList">Shortlist</button>
                            <button class="viewall-jobs" onclick="rejection()">Reject</button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- BEGIN: Actions -->
                                    <div id="card-data" class="row cd-box">
                                    <?php
                                    if(!empty($user_data)) {
                                        foreach ($user_data as $u) {
                                            ?>
                                            <article>
                                                <div class="col-lg-3 col-md-3 col-sm-6 p-category-main"
                                                     onclick="makeChecked(this);">
                                                    <?php if ($u["status"] == 0) { ?>
                                                        <input type="checkbox"
                                                               name="<?= $u['applied_application_enc_id'] ?>"
                                                               id="<?= $u['userEnc']['user_enc_id'] ?>"
                                                               class="checkbox-input"/>
                                                    <?php } ?>
                                                    <label for="can1" class="checkbox-label">
                                                        <div class="paid-candidate-container">
                                                            <div class="paid-candidate-box">
                                                                <div class="dropdown">
                                                                    <div class="btn-group fl-right">
                                                                        <div class="dropdown-menu pull-right animated flipInX">
                                                                            <a href="#" data-toggle="modal"
                                                                               data-target="#shortList">Shortlist</a>
                                                                            <button class="reject">Reject</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="paid-candidate-inner--box">
                                                                    <div class="paid-candidate-box-thumb">
                                                                        <?php
                                                                        $name = $image = NULL;
                                                                        if (!empty($u['userEnc']['image'])) {
                                                                            $image = Yii::$app->params->upload_directories->users->image . $u['userEnc']['image_location'] . DIRECTORY_SEPARATOR . $u['userEnc']['image'];
                                                                        }
                                                                        $name = $u['userEnc']['first_name'] . ' ' . $u['userEnc']['last_name'];
                                                                        if ($image):
                                                                            ?>
                                                                            <img src="<?= $image; ?>"
                                                                                 alt="<?= $name; ?>"
                                                                                 class="img-responsive img-circle"/>
                                                                        <?php else: ?>
                                                                            <canvas class="user-icon img-circle img-responsive"
                                                                                    name="<?= $name; ?>"
                                                                                    color="<?= $u['userEnc']['initials_color']; ?>"
                                                                                    width="140" height="140"
                                                                                    font="70px"></canvas>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="paid-candidate-box-detail">
                                                                        <h4><?= ucfirst($u['userEnc']['first_name']) ?>
                                                                            <?= $u['userEnc']['last_name'] ?>
                                                                        </h4>
                                                                        <span class="desination"><?= $u['userEnc']['name'] ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="paid-candidate-box-extra">
                                                                    <ul>
                                                                        <?php
                                                                        $i = 0;
                                                                        foreach ($u['userEnc']['userSkills'] as $sk) {

                                                                            ?>
                                                                            <li>
                                                                                <?php
                                                                                echo $sk['skill'];
                                                                                $i++;
                                                                                if ($i == 3) break;
                                                                                ?>
                                                                            </li>
                                                                        <?php }
                                                                        if (count($u['userEnc']['userSkills']) >= 4) {
                                                                            ?>
                                                                            <li class="more-skill bg-primary">
                                                                                +<?= count($u['userEnc']['userSkills']) - 3 ?></li>
                                                                        <?php } ?></ul>
                                                                </div>
                                                                <div class="paid-candidate-box-exp">
                                                                    <?php if (!empty($u['userEnc']['city_name'])) { ?>
                                                                        <div class="desination"><i
                                                                                    class="fa fa-map-marker"></i> <?= $u['userEnc']['city_name'] ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php

                                                                    $exp = $u['experience'];

                                                                    switch ($exp) {

                                                                        case 0:
                                                                            $exp = '0 Years';
                                                                            break;

                                                                        case 1:
                                                                            $exp = '0.6 Months';
                                                                            break;

                                                                        case 2:
                                                                            $exp = '1 Year';
                                                                            break;

                                                                        case 3:
                                                                            $exp = '2-3 Years';
                                                                            break;

                                                                        case 4:
                                                                            $exp = '3-5 Years';
                                                                            break;

                                                                        case 5:
                                                                            $exp = '5-10 Years';
                                                                            break;

                                                                        case 6:
                                                                            $exp = '10-20 Years';
                                                                            break;

                                                                        case 7:
                                                                            $exp = '20+ Years';
                                                                            break;
                                                                    };
                                                                    ?>
                                                                    <div class="desination"><i
                                                                                class="fa fa-briefcase"></i> <?= $exp ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="/<?= $u['userEnc']['username'] ?>"
                                                               class="btn btn-paid-candidate bt-1">View Detail</a>

                                                            <?php if ($u["status"] == 1) { ?>
                                                                <div class="shortlist-strip">
                                                                    <div class="s-strip"> Shortlisted</div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </label>
                                                </div>
                                            </article>
                                            <?php
                                        }
                                    }else {
                                    ?>
                                        <div class="tab-empty">
                                            <div class="tab-empty-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/applyingjob.png'); ?>"
                                                     class="img-responsive" alt=""/>
                                            </div>
                                            <div class="tab-empty-text">
                                                <div class="">There is no Application to Display</div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal-->
<div id="shortList" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" id="profiles">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="submit" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose Applications to Shortlist for</h4>
            </div>
            <div class="modal-body">
                <?php
                if(count($available_applications) > 0) {
                    foreach ($available_applications as $a) {
                        ?>
                        <div class="row padd10">
                            <div class="col-md-12 text-center">
                                <div class="radio_questions">
                                    <div class="inputGroup process_radio">
                                        <input type="radio" name="applications" id="<?= $a['application_enc_id'] ?>"
                                               value="<?= $a['application_enc_id'] ?>">
                                        <label for="<?= $a['application_enc_id'] ?>">
                                            <?= $a['name'] ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>

            <div class="modal-footer">
                <?php if(count($available_applications) > 0) { ?>
                    <button id="submitData" type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                <?php }else{ ?>
                    <a class="btn btn-primary" href="/account/<?=$type?>/create">Create New <?=$type?></a>
                <?php } ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<?php
$this->registerCss('
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:250px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
.shortlist-strip{
    position:absolute;
    top:0;
    left:0;
}
.s-strip{
    padding:5px 10px;
    border:1px solid #00a0e3;
    border-radius:0 0 10px 0;
    background:#00a0e3;
    color:#fff;
}
 button.viewall-jobs{
    border:none;
}   
 *:focus{
    outline:none !important;
}
#btn-group1{
    display:hidden;
}
#btn-group2{
    display:none;
}
.paid-candidate-container{
    background: #ffffff;
    border-radius: 6px !important;
    overflow: hidden;
	text-align:center;
    margin-bottom:30px;
	position:relative;
	transition: .4s;
    border:1px solid #eaeff5;
}
.paid-candidate-container:hover, .paid-candidate-container:focus{
    transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
}
.paid-candidate-box-thumb img{
    height:100%;
}
.com-load-more-btn{
    max-width:150px;
    margin:0 auto;
    color:#fff;
    font-size:14px;
}
.paid-candidate-box{
    text-align: center;
    padding:20px 10px 15px;
}
.paid-candidate-status {
    position: absolute;
    left:32px;
    top: 25px;
    background:#01c73d;
    color: #ffffff;
    padding: 4px 18px;
    border-radius: 50px;
    font-weight: 500;
}

.paid-candidate-box-thumb {
    margin-bottom: 30px;
    width: 120px;
	height:120px;
    margin: 0 auto 25px auto;
	border-radius:50% !important;
	overflow:hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}

.paid-candidate-box-detail h4{
	margin-bottom:4px;
	font-size:20px;
}
.paid-candidate-box-exp{
    display: flex;
    justify-content: center;
}
.paid-candidate-box-detail .desination, .paid-candidate-box-detail .location,
.paid-candidate-box-exp .desination{
	font-weight:500;
	font-size:15px;
	display:block;
	color:#677484;
	height:27px;
        padding:5px 20px 0;
        
}
.paid-candidate-box-extra ul {
    margin: 10px 0;
	padding:0;
	min-height:74px;
	height: 115px;
}
.paid-candidate-box-extra ul li {
    list-style: none;
    padding:3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 50px !important;
    margin: 5px;
    font-weight: 500;
    color: #657180;
    text-overflow: ellipsis;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    display: -webkit-inline-box;
    overflow: hidden;
}
.paid-candidate-box-extra ul li.more-skill{
	color:#ffffff;
	border-color:#1194f7;
}
a.btn.btn-paid-candidate {
    padding: 10px !important;
    display: inline-block;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    border-radius: 0;
}

a.btn.btn-paid-candidate:hover, a.btn.btn-paid-candidate:focus{
	background:#00a0e3; 
	color:#ffffff;
	-webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}
.paid-candidate-box .dropdown{
	position:absolute;
	right:30px;
	top:25px;
}
.btn-trans {
    background: transparent;
    border: none;
	font-size:20px;
    color:#99abb9;
}
.dropdown-menu.pull-right {
    right: 0;
    left: auto !important;
    top: 90% !important;
}
.dropdown-menu.pull-right {
    right: 0;
	border-color: #ebf2f7;
	padding: 0;
    left: auto !important;
    top: 90% !important;
}
.dropdown-menu>a, .dropdown-menu>button {
    display: block;
    padding: 14px 12px 14px 12px; 
    clear: both;
    font-weight: 300; 
    line-height: 1.42857143;
    color: #67757c;
    border-bottom: 1px solid #f1f6f9;
    background:transparent;
}
.dropdown-menu>button {
    text-align: left;
    border: none;
    width: 100%;
}
.bt-1 {
    border-top: 1px solid #eaeff5!important;
}
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
}
.dashboard-button a, .dashboard-button button{    
    margin-left:10px !important;
}
/*----------------------*/
.checkbox-input {
  display: none;
}
.checkbox-label {
  vertical-align: top;
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
.p-category-main:hover .checkbox-label:before {
    top:-5px !important;
} 
.checkbox-label:before {
  content: "";
  position: absolute;
  top: 80px;
  left: 15px;
  width: 35px;
  height: 35px;
  opacity: 0;
  background-color: #2196F3;
  background-repeat: no-repeat; 
  background-size: 30px;
  border-radius: 8px 0;
//  -webkit-transform: translate(0%, -50%);
//  transform: translate(0%, -50%);
  transition: all 0.4s ease;
  z-index:999;
  
}
.checkbox-input:checked + .checkbox-label:before {
  top: 0;
  opacity: 1;

}
.checkox-input:checked + .checkbox-label{
   transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
}
.checkbox-input:checked + .checkbox-label .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
.radio_questions {
    max-width: 100%;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
    position: relative;
}
.inputGroup {
    background-color: #fff;
    display: block;
    margin: 10px 0;
    position: relative;
}
.inputGroup input {
    width: 32px;
    height: 32px;
    order: 1;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    visibility: hidden;
}
.inputGroup input:checked ~ label {
    color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,.3) !important;
}
.inputGroup label {
    padding: 6px 75px 10px 25px;
    width: 96%;
    display: block;
    margin: auto;
    text-align: left;
    color: #3C454C !important;
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 1ms ease-out;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid #eee;
}
.inputGroup input:checked ~ label:before {
    transform: translate(-50%, -50%) scale3d(56, 56, 1);
    opacity: 1;
}
.inputGroup label:before {
    width: 100%;
    height: 10px;
    border-radius: 50%;
    content: \'\';
    background-color: #fff;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) scale3d(1, 1, 1);
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    z-index: -1;
    box-shadow: 0 0 10px rgba(0,0,0,.5) !important;
}
.inputGroup input:checked ~ label:after {
    background-color: #00a0e3;
    border-color: #00a0e3;
}
.process_radio label:after {
    width: 32px;
    height: 32px;
    content: \'\';
    border: 2px solid #D1D7DC;
    background-color: #fff;
    background-repeat: no-repeat;
    background-position: 2px 3px;
    background-image: url("data:image/svg+xml,%3Csvg width=\'32\' height=\'32\' viewBox=\'0 0 32 32\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z\' fill=\'%23fff\' fill-rule=\'nonzero\'/%3E%3C/svg%3E ");
    border-radius: 50%;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    transition: all 200ms ease-in;
}
');
$script = <<<JS

JS;

$this->registerJs($script);
//$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


?>
<script>
    var listOfSelected = [];
    var applied_enc_id = [];

    function makeChecked(t){
        if(!t.querySelector('input').checked)
            t.querySelector('input').checked = true;
        else
            t.querySelector('input').checked = false;

        if(t.querySelector('input').checked){
            listOfSelected.push(t.querySelector('input').getAttribute('id'));
            applied_enc_id.push(t.querySelector('input').getAttribute('name'));
            document.getElementById("btn-group2").style.display = "block";
        }else{
            var index = listOfSelected.indexOf(t.querySelector('input').getAttribute('id'));
            var index2 = applied_enc_id.indexOf(t.querySelector('input').getAttribute('name'));
            if(index!=-1 || index2!=-1){
                listOfSelected.splice(index, 1);
                applied_enc_id.splice(index2, 1);
            }
            if(listOfSelected.length == 0 || applied_enc_id.length == 0){
                document.getElementById("btn-group2").style.display = "none";
            }
        }
    }

    function rejection() {
        $.ajax({
            type:"POST",
            url:"/account/uploaded-resume/reject",
            data: {'selectedList':applied_enc_id},
            success:function (response) {
                if(JSON.parse(response)["status"] == 200){
                    window.location.reload();
                }
            }
        });
    }

    document.getElementById('submitData').addEventListener('click', function(){
        var submitted_data = {};
        if(applied_enc_id.length > 0){
            submitted_data["selected_candidates"] = applied_enc_id;
        }
        var applications = document.getElementsByName('applications');
        var selected_value;
        for(var i = 0; i < applications.length; i++){
            if(applications[i].checked){
                selected_value = applications[i].value;
            }
        }
        submitted_data["application_selected"] = selected_value;
        $.ajax({
            type:"POST",
            url:"/account/uploaded-resume/short-list",
            data: submitted_data,
            success:function (response) {
                if(JSON.parse(response)["status"] == 200){
                    window.location.reload();
                }

            }
        });
    })




</script>
