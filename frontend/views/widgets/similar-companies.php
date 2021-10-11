<?php

use yii\helpers\Url;

?>
<?php foreach ($companies as $c) { ?>
    <div class="col-md-4 col-sm-6">
        <div class="similar-company">
            <div class="sim-company-head">
                <div class="sim-company-logo">
                    <a href="/<?= $c['slug'] ?>" target="_blank">
                        <img src="<?= $c['logo'] ?>" class="do-image" data-name="<?= $c['name'] ?>" data-width="110"
                             data-height="110"
                             data-color="<?= $c['color'] ?>" data-font="45px">
                    </a>
                </div>
                <div class="sim-company-details">
                    <h3 class="sim-comp-Name"><a href="/<?= $c['slug'] ?>" target="_blank"
                                                 title="<?= $c['name'] ?>"><?= $c['name'] ?></a>
                    </h3>
                    <h3 class="sim-comp-relate"><?= $c['business_activity'] ? $c['business_activity'] : 'Others' ?></h3>
                    <div class="sim-comp-jobs-intern">
                        <a href="/jobs/list?slug=<?= $c['slug']?>" target="_blank"><span
                                    class="jobs">
                                <?php if ($c['employerApplications'][0]['name'] == 'Jobs') {
                                    echo $c['employerApplications'][0]['total_application'];
                                } else {
                                    if ($c['employerApplications'][1]['name'] == 'Jobs') {
                                        echo $c['employerApplications'][1]['total_application'];
                                    } else {
                                        echo 0;
                                    }
                                } ?>
                                Jobs</span></a>
                        <a href="/internships/list?slug=<?= $c['slug']?>" target="_blank"><span class="interns">
                                <?php if ($c['employerApplications'][0]['name'] == 'Internships') {
                                    echo $c['employerApplications'][0]['total_application'];
                                } else {
                                    if ($c['employerApplications'][1]['name'] == 'Internships') {
                                        echo $c['employerApplications'][1]['total_application'];
                                    } else {
                                        echo 0;
                                    }
                                } ?> Internships</span></a>
                    </div>
                    <div class="sim-view-detail">
                        <a href="/<?= $c['slug'] ?>">View Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php

$this->registercss('
.similar-company {
    border: 1px solid #eee;
    box-shadow: 0px 2px 10px rgb(0 0 0 / 10%);
    border-radius
    text-align: center;
    position: relative;
    margin: 10px 0 20px;
	border-radius: 4px;
    padding: 15px 15px;
    transition: all .3s;
}
.similar-company:hover{
//    transform:scale(1.01);
    box-shadow:0px 10px 25px rgba(0,0,0,0.10);
}
.sim-company-head {
    display: flex;
    align-items: center;
}
.sim-company-details {
    text-align: left;
}
.sim-company-logo {
	width: 110px;
	height: 110px;
	margin: auto;
	border-radius: 60px;
	overflow: hidden;
	border: 1px solid #eee;
	box-shadow: 0 0 13px 4px #eee;
	line-height:104px;
	margin-top:12px;
}
.sim-comp-Name {
    font-size: 24px;
    font-family: lora;
    margin: 20px 15px 5px;
    line-height: 30px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.sim-comp-relate {
    margin: 10px 15px 0;
    font-size: 18px;
    font-family: roboto;
    color: #9fa0a2;
    height: 26px;
}
.sim-comp-jobs-intern {
    padding: 10px 0px 5px;
    font-size: 16px;
    color: #999c9d;
    font-family: roboto;
}
.sim-comp-jobs-intern a {
    margin: 0 15px;
}
.sim-view-detail{
    display: flex;
}
.sim-view-detail a {
	color: #fff;
	font-size: 12px;
	font-family: roboto;
	padding: 5px 10px;
	font-weight: 500;
	border-radius: 4px;
	text-transform: uppercase;
	border:2px solid #00a0e3;
	background-color: #00a0e3;
	margin: 0 4px;
	transform: translate(19px, 15px);
	display: inline-block;
	margin-left:auto;
}
.sim-view-detail a:hover{
	background-color: #fff;
	color: #00a0e3;
	transition: all .3s;
}
');


