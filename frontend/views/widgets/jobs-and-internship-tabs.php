<?php

use yii\helpers\Url;

?>
<div class="ji-tabs">
    <div class="container">
        <ul id="myTabs" class="nav nav-pills nav-justified set-w" role="tablist" data-tabs="tabs">
            <li class="active use-act"><a href="#Jobs" data-toggle="tab">Jobs In</a></li>
            <li class="use-act"><a href="#Internships" data-toggle="tab">Internships In</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="Jobs">
                <?= $this->render('/widgets/employer_applications/preferred-jobs'); ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="Internships">
                <?= $this->render('/widgets/employer_applications/preferred-jobs'); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registercss('
.set-w {
	width: 40%;
	margin: auto;
	margin-top: 20px;
	background-color: #00a0e3;
	padding: 8px 3px;
	border-radius: 4px;
}
.nav-pills li a{
    color:#fff;
    font-family:roboto;
    font-size:16px;
    font-weight:500;
    margin:0 5px;
    transition:all .3s;
}
.nav-pills li a:hover, .nav-pills li.active > a, .nav-pills li.active > a:hover, .nav-pills li.active > a:focus{
    background-color:#fff !important;
    color:#00a0e3;
}
#featured-head{
    display:block !important;
}
');