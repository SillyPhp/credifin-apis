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
                        <!--                        <div id="btn-group1" class="btn-group dashboard-button btns1">
                                                    <button id="selectMultiple" class="viewall-jobs">Select Multiple</button>
                                                </div>-->
                        <div id="btn-group2" class="btn-group dashboard-button btns2 ">
                            <button class="viewall-jobs">Shortlist</button>
                            <button class="viewall-jobs">Reject</button>
                            <button id="cancelBtn" class="viewall-jobs">Cancel</button>
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

                                        <!-- There is data before. -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="com-load-more-btn">
                            <button type="button" id="comloadmore" class="btn custom-buttons">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
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
        padding:5px 20px 0;
        
}
.paid-candidate-box-extra ul {
    margin: 10px 0;
	padding:0;
}
.paid-candidate-box-extra ul li {
    display: inline-block;
    list-style: none;
    padding:3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 50px !important;
    margin: 5px;
    font-weight: 500;
    color: #657180;
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
');
$script = <<<JS
     // var multi = document.getElementById("selectMultiple");
        // multi.addEventListener("click", showBttn);
    
   // function showBttn(){
   //       document.getElementById("btn-group1").style.display = "none";
   //       document.getElementById("btn-group2").style.display = "block";
   // } 
   
  // var canBtn = document.getElementById("cancelBtn");
  //       canBtn.addEventListener("click", revert);
  //  
  //  function revert(){
  //       document.getElementById("btn-group1").style.display = "block";
  //       document.getElementById("btn-group2").style.display = "none";
  //  }
        
  // var reject = document.getElementsByClassName("reject");
  //     for(i=0; i<reject.length; i++){
  //         reject[i].addEventListener("click", removeCandidate);
  //       }
  //     function removeCandidate(){
  //           var del = this.closest("article"); 
  //           del.remove();
  //       }
   //   
   //  $(document).on('click','#comloadmore', function(){
   //     $('.cd-box:first').clone().appendTo('.tab-pane');     
   // }); 
   
            var template = $("#card").html();
            var rendered = Mustache.render(template);
            $('#card-data').append(rendered);
        
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    var listOfSelected = [];
    function showBtns(t){
        if(t.checked){
            listOfSelected.push(t.getAttribute('id'));
            document.getElementById("btn-group2").style.display = "block";
        }else{
            var index = listOfSelected.indexOf(t.getAttribute('id'));
            if(index!=-1){
                listOfSelected.splice(index, 1);
            }
            if(listOfSelected.length == 0){
                document.getElementById("btn-group2").style.display = "none";
            }
        }
    }
</script>

<script id="card" type="text/template">
    <article>
        <div class="col-lg-3 col-md-3 col-sm-6 p-category-main">
            <input type="checkbox" onchange="showBtns(this);" name="pasta" id="can1" class="checkbox-input"/>
            <label for="can1" class="checkbox-label">
                <div class="paid-candidate-container">
                    <div class="paid-candidate-box">
                        <div class="dropdown">
                            <div class="btn-group fl-right">
                                <button type="button" class="btn-trans" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-gear"></i>
                                </button>
                                <div class="dropdown-menu pull-right animated flipInX">
                                    <a href="#">Shortlist</a>
                                    <button class="reject">Reject</button>
                                </div>
                            </div>
                        </div>
                        <div class="paid-candidate-inner--box">
                            <div class="paid-candidate-box-thumb">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" class="img-responsive img-circle" alt="" />
                            </div>
                            <div class="paid-candidate-box-detail">
                                <h4>Daniel Disroyer</h4>
                                <span class="desination">App Designer</span>
                            </div>
                        </div>
                        <div class="paid-candidate-box-extra">
                            <ul>
                                <li>Php</li>
                                <li>Android</li>
                                <!--                                                            <li>Html</li>-->
                                <li class="more-skill bg-primary">+3</li>
                            </ul>
                        </div>
                        <div class="paid-candidate-box-exp">
                            <div class="desination"><i class="fa fa-map-marker"></i> Ludhian </div>
                            <div class="desination"><i class="fa fa-briefcase"></i> 5 years </div>
                        </div>
                    </div>
                    <a href="/user/shshank" class="btn btn-paid-candidate bt-1">View Detail</a>
                </div>
            </label>
        </div>
    </article>
</script>