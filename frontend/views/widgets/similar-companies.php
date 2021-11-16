<?php

use yii\helpers\Url;

?>
<?php foreach ($companies as $c) { ?>
    <div class="col-md-4 col-sm-6">
        <div class="similar-company">
            <div class="sim-company-head">
                <div class="sim-company-logo">
                    <a href="/<?= $c['slug'] ?>" target="_blank">
                        <img src="<?= $c['logo'] ?>" class="do-image" data-name="<?= $c['name'] ?>" data-width="80"
                             data-height="80"
                             data-color="<?= $c['color'] ?>" data-font="45px">
                    </a>
                </div>
                <div class="sim-company-details">
                    <h3 class="sim-comp-Name"><a href="/<?= $c['slug'] ?>" target="_blank"
                                                 title="<?= $c['name'] ?>"><?= $c['name'] ?></a>
                    </h3>
                    <h3 class="sim-comp-relate"><?= $c['business_activity'] ? $c['business_activity'] : 'Others' ?></h3>
                </div>
            </div>
                <div class="btn-action">
                    <div class="sim-comp-jobs-intern">
                        <a href="/jobs/list?slug=<?= $c['slug']?>" target="_blank"><span
                                    class="jobs">
                                <?= $c['employerApplications'][0]['name'] == 'Jobs' ? $c['employerApplications'][0]['total_application'] : ($c['employerApplications'][1]['name'] == 'Jobs' ? $c['employerApplications'][1]['total_application'] : 0) ?>
                                Jobs</span></a>
                        <a href="/internships/list?slug=<?= $c['slug']?>" target="_blank"><span class="interns">
                                <?= $c['employerApplications'][0]['name'] == 'Internships' ? $c['employerApplications'][0]['total_application'] : ($c['employerApplications'][1]['name'] == 'Internships' ? $c['employerApplications'][1]['total_application'] : 0) ?>
                                Internships</span></a>
                    </div>
<!--                    <div class="sim-view-detail">-->
<!--                        <a href="/--><?//= $c['slug'] ?><!--">View Detail</a>-->
<!--                    </div>-->
                </div>
        </div>
    </div>
<?php } ?>
<?php

$this->registercss('
.similar-company {
    border: 1px solid #eee;
    box-shadow: 0px 2px 10px rgb(0 0 0 / 10%);
    text-align: center;
    position: relative;
    margin: 10px 0 20px;
    border-radius: 4px;
    padding: 20px 10px;
    transition: all .3s;
    height: 243px;
    max-height: 243px;
}
.similar-company:hover{
//    transform:scale(1.01);
    box-shadow:0px 10px 25px rgba(0,0,0,0.10);
}
//.sim-company-head {
//    display: flex;
//    align-items: center;
//}
.sim-company-details {
    text-align: center;
}
.sim-company-logo img, .sim-company-logo canvas{
	min-width: 80px;
	height: 80px;
	object-fit:contain;
//	border-radius: 50%;
	overflow: hidden;
//	border: 1px solid #eee;
//	box-shadow: 0 0 13px 4px #eee;
	line-height: 80px;
//	margin-top:10px;
}
.sim-comp-Name {
    font-size: 20px;
    font-family: roboto;
    margin: 10px 10px 0;
    line-height: 30px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.sim-comp-relate {
    margin: 2px 15px 0;
    font-size: 16px;
    font-family: roboto;
    color: #9fa0a2;
    height: 26px;
}
.sim-comp-jobs-intern {
    padding: 5px 0px;
    font-size: 16px;
    color: #999c9d;
    font-family: roboto;
}
.sim-comp-jobs-intern a {
    margin: 0 8px;
    background-color: #eee;
    padding: 5px 8px;
    border-radius: 6px;
    font-size: 15px;
    font-family: roboto;
    font-weight:500;
    transition: ease-out .3s;
}
.sim-comp-jobs-intern a:hover{
    background-color:#00a0e3;
    color:#fff;
}
.sim-view-detail{
    display: flex;
}
.sim-view-detail a {
	color: #fff;
	font-size: 12px;
	font-family: roboto;
	padding: 2px 8px;
	font-weight: 500;
	border-radius: 4px;
	text-transform: uppercase;
	border:2px solid #00a0e3;
	background-color: #00a0e3;
	margin: 0 4px;
	display: inline-block;
}
.sim-view-detail a:hover{
	background-color: #fff;
	color: #00a0e3;
	transition: all .3s;
}
.btn-action {
//    display: flex;
//    align-items: center;
//    justify-content: space-between;
    margin-top: 10px;
}
');


