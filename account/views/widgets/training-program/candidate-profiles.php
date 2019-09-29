<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div id="card-data" class="row cd-box">
            <?php
            foreach ($user_data as $u) {
                ?>
                <article>
                    <div class="col-lg-3 col-md-3 col-sm-6 p-category-main">
                        <label for="can1" class="checkbox-label">
                            <div class="paid-candidate-container">
                                <div class="paid-candidate-box">
                                    <div class="paid-candidate-inner--box">
                                        <div class="paid-candidate-box-thumb">
                                            <?php
                                            $name = $image = NULL;
                                            if (!empty($u['createdBy']['image'])) {
                                                $image = Yii::$app->params->upload_directories->users->image . $u['createdBy']['image_location'] . DIRECTORY_SEPARATOR . $u['createdBy']['image'];
                                            }
                                            $name = $u['createdBy']['first_name'] . ' ' . $u['createdBy']['last_name'];
                                            if ($image):
                                                ?>
                                                <img src="<?= $image; ?>"
                                                     alt="<?= $name; ?>"
                                                     class="img-responsive img-circle"/>
                                            <?php else: ?>
                                                <canvas class="user-icon img-circle img-responsive"
                                                        name="<?= $name; ?>"
                                                        color="<?= $u['createdBy']['initials_color']; ?>"
                                                        width="140" height="140"
                                                        font="70px"></canvas>
                                            <?php endif; ?>
                                        </div>
                                        <div class="paid-candidate-box-detail">
                                            <h4><?= ucfirst($u['createdBy']['first_name']) ?>
                                                <?= $u['createdBy']['last_name'] ?>
                                            </h4>
                                            <span class="desination"><?= $u['createdBy']['name'] ?></span>
                                        </div>
                                    </div>
                                    <?php if (!empty($u['createdBy']['userSkills'])): ?>
                                    <div class="paid-candidate-box-extra">
                                        <ul>
                                            <?php
                                            $i = 0;
                                            foreach ($u['createdBy']['userSkills'] as $sk) {
                                                ?>
                                                <li>
                                                    <?php
                                                    echo $sk['skill'];
                                                    $i++;
                                                    if ($i == 3) break;
                                                    ?>
                                                </li>
                                            <?php }
                                            if (count($u['createdBy']['userSkills']) >= 4) {
                                                ?>
                                                <li class="more-skill bg-primary">
                                                    +<?= count($u['createdBy']['userSkills']) - 3 ?></li>
                                            <?php } ?></ul>
                                    </div>
                                    <?php endif; ?>
                                    <div class="paid-candidate-box-exp">
                                        <?php if (!empty($u['createdBy']['city_name'])) { ?>
                                            <div class="desination"><i
                                                        class="fa fa-map-marker"></i><?= $u['createdBy']['city_name'] ?>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        $exp = json_decode($u['createdBy']['experience'],true);
                                        ?>
                                        <?php if (!empty($exp)): ?>
                                        <div class="desination"><i
                                                    class="fa fa-briefcase"></i> <?= $exp[0].'Years'.$exp[1].'Months' ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="/<?= $u['createdBy']['username'] ?>"
                                   class="btn btn-paid-candidate bt-1">View Profile</a>
                            </div>
                        </label>
                    </div>
                </article>
                <?php
                  }
                  ?>
                  </div>
            </div>
        </div>


<?php
$this->registerCss('
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
?>
