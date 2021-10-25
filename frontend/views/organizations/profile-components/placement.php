<?php

use yii\helpers\Url;

?>
    <div class="container">
        <div class="col-md-12">
            <div class="set-sticky">
                <h3 class="ou-head">Highlights</h3>
                <div class="placement-points">
                </div>
            </div>
<!--            <div class="set-sticky">-->
<!--                <h3 class="ou-head">Top Recruiters</h3>-->
<!--                <div class="recruit-box-main">-->
<!--                    <div class="recruiter-box">-->
<!--                        <div class="recruit-logo"><img src="--><?//= Url::to('/assets/common/logos/logo.svg') ?><!--"></div>-->
<!--                        <div class="recrt-content">-->
<!--                            <div class="recruit-name">EmpowerYouth</div>-->
<!--                            <div class="recruit-count">50+ Recruitments</div>-->
<!--                            <div class="recruit-package">50k - 100k Package offered</div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="recruiter-box">-->
<!--                        <div class="recruit-logo"><img src="--><?//= Url::to('/assets/common/logos/logo.svg') ?><!--"></div>-->
<!--                        <div class="recrt-content">-->
<!--                            <div class="recruit-name">EmpowerYouth</div>-->
<!--                            <div class="recruit-count">50+ Recruitments</div>-->
<!--                            <div class="recruit-package">50k - 100k Package offered</div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="recruiter-box">-->
<!--                        <div class="recruit-logo"><img src="--><?//= Url::to('/assets/common/logos/logo.svg') ?><!--"></div>-->
<!--                        <div class="recrt-content">-->
<!--                            <div class="recruit-name">EmpowerYouth</div>-->
<!--                            <div class="recruit-count">50+ Recruitments</div>-->
<!--                            <div class="recruit-package">50k - 100k Package offered</div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="recruiter-box">-->
<!--                        <div class="recruit-logo"><img src="--><?//= Url::to('/assets/common/logos/logo.svg') ?><!--"></div>-->
<!--                        <div class="recrt-content">-->
<!--                            <div class="recruit-name">EmpowerYouth</div>-->
<!--                            <div class="recruit-count">50+ Recruitments</div>-->
<!--                            <div class="recruit-package">50k - 100k Package offered</div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="set-sticky row">
                <h3 class="ou-head">Recruitment By Course</h3>
                <div class="course-outer">
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.placement-points {
	display: flex;
	justify-content: flex-start;
	align-items: center;
	flex-wrap: wrap;
	width: 100%;
}
.place-point {
	width: 25%;
	display: flex;
	align-items: center;
	margin-bottom: 10px;
	padding: 5px;
}
.fa-icon {
	font-size: 28px;
	margin-right: 8px;
	color: #00a0e3;
	width: 34px;
	text-align: center;
}
.fa-text h3 {
	font-size: 12px;
	margin: 0;
	font-family:roboto;
}
.fa-text p {
	font-size: 14px;
	margin: 0;
	font-weight:500;
}
.recruit-box-main {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
}
.recruiter-box {
	width: 32.6%;
	margin:0 1% 12px 0;
	box-shadow: 0 0 4px 0px rgba(0,0,0,0.1);
	padding: 10px;
	display: flex;
	align-items: center;
}
.recruiter-box:nth-child(3) {
    margin-right: 0px;
}
.recruit-logo {
	width: 90px;
	height: 90px;
}
.recruit-logo img {
	width: 100%;
	height: 100%;
	object-fit: contain;
}
.recrt-content {
	margin-left: 10px;
}
.recruit-name {
    font-size:16px;
	font-weight: 500;
}
.by-course-name {
	font-size: 20px;
	color:#00a0e3;
    font-weight: 700;
}
.by-data {
	display: flex;
	flex-wrap: wrap;
}
.by-data div {
    margin-bottom: 10px;
}
.by-data h6 {
    font-weight: 700;
    font-family: Roboto;
    line-height: 15px;
    color: #7E7E7E;
    margin: 0;
}
.by-data h2 {
    margin: 0;
    font-size: 21px;
    font-family: Roboto;
    font-weight: 700;
}
.by-data div {
	flex-basis: 50%;
}
.by-course-main {
	box-shadow: 0 0 3px 0 rgba(0,0,0,0.2);
	padding: 2px 15px;
    margin-bottom: 30px;
}
.by-course-main:nth-child(2) {
	margin-right: 0;
}
@media only screen and (max-width: 992px) {
.recruiter-box {
    width: 49%;
    margin: 0 0px 12px 0;
    }
}
@media only screen and (max-width: 767px) {
.place-point{width:50%;}
.recruiter-box {
    width: 100%;
    margin: 0 0px 12px 0;
    }
.by-course-main {
    flex-basis: 100%;
    margin: 0 0 15px 0;
    }
}
@media only screen and (max-width: 550px) {
.place-point{width:100%;}
.by-data div{flex-basis:100%;}
}
');
?>
<script>
async function getPlacementData() {
    let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/placement-highlights`,{
        method: 'POST',
        body: data,
    })
    let res = await response.json();
    if(res['response']['status'] == 200){
        createHighlightsDiv(res['response']['highlights'])
    }else {
        createHighlightsDiv()
    }
}
getPlacementData();

function createHighlightsDiv(highlights){
    document.querySelector('.placement-points').innerHTML = ` <div class="place-point">
            <div class="fa-icon"><i class="fas fa-university"></i></div>
            <div class="fa-text">
                <h3>No. of Companies visited</h3>
                <p>${highlights ? highlights.companies_visited : '-' }</p>
            </div>
        </div>
        <div class="place-point">
            <div class="fa-icon"><i class="fab fa-affiliatetheme"></i></div>
            <div class="fa-text">
                <h3>Top Recruiters</h3>
                <p>${highlights ? highlights.top_recruiter : '-'}</p>
            </div>
        </div>
        <div class="place-point">
            <div class="fa-icon"><i class="fas fa-scroll"></i></div>
            <div class="fa-text">
                <h3>Highest Stipend Offered</h3>
                <p>${highlights ? highlights.highest_stipend_offered : '-'}</p>
            </div>
        </div>
        <div class="place-point">
            <div class="fa-icon"><i class="fas fa-microchip"></i></div>
            <div class="fa-text">
                <h3>Highest placement package</h3>
                <p>${highlights ? highlights.highest_placement_package : '-'}</p>
            </div>
        </div>
        <div class="place-point">
            <div class="fa-icon"><i class="fas fa-clipboard-check"></i></div>
            <div class="fa-text">
                <h3>No. of Companies Offering Dream Packages</h3>
                <p>${highlights ? highlights.companies_offering_dream_packages : '-'}</p>
            </div>
        </div>`;

}

async function getCoursePlacements(){
    let response = await fetch(`${baseUrl}/api/v3/ey-college-profile/course-recruitments`, {
        method: 'POST',
        body: data,
    })
    let res = await response.json()
    if(res['response']['status'] == 200){
        createPlacementBox(res['response']['recruitments'])
    }else{
        document.querySelector('.course-outer').innerHTML = '<p class="noResults"> No Details Added </p>'
    }
}
getCoursePlacements()

function createPlacementBox(coursePlacement){
    let placements = coursePlacement.map(placement => {
        return `<div class="col-md-4 col-sm-6">
                    <div class="by-course-main">
                        <div class="by-course-name">${placement.course_name}</div>
                        <div class="by-data">
                            <div class="avg-pack">
                                <h6>Average Package</h6>
                                <h2>${placement.average_package}</h2>
                            </div>
                            <div class="high-pack">
                                <h6>Highest Package</h6>
                                <h2>${placement.highest_package}</h2>
                            </div>
                            <div class="comp-visit">
                                <h6>Companies Visited</h6>
                                <h2>${placement.companies_visiting}</h2>
                            </div>
                            <div class="total-offers">
                                <h6>Total Offers</h6>
                                <h2>${placement.total_offers}</h2>
                            </div>
                            <div class="student-offer">
                                <h6>Student Placed</h6>
                                <h2>${placement.students_placed}</h2>
                            </div>
                        </div>
                    </div>
                </div>`
    }).join('');
    document.querySelector('.course-outer').innerHTML = placements;
}
</script>
