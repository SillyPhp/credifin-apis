<?php
$this->params['header_dark'] = true;
use yii\helpers\Url;
?>

<div style="position: fixed;width: 100%;z-index: 99;top: 110px;right: 0; border-right:1px solid #ddd;">
    <div class="row row-offcanvas active">
        <div class="sidebar-offcanvas sidebar">
            <?=
            $this->render('/widgets/sidebar-review', [
                'type' => 'jobs',
            ]);
            ?>
        </div>
        <a type="button" id="change" class="btn btn-collapse btn-" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-down"></i> <span id="change-text">Review List</span></a>
    </div>
</div>

<section>
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <table>
                    <tr>
                        <td width="10%" class="boldfont"> Choose Jobs you want to compare</td>
                        <form>
                            <td width="30%">
                                <div class='search-box'>
                                    <input class='form-control' placeholder='Choose Company' type='text'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class='search-box'>
                                    <input class='form-control' placeholder='Choose Job' type='text'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class="empty"></div>
                            </td>
                            <td width="30%">
                                <div class='search-box'>
                                    <input class='form-control' placeholder='Choose Company' type='text'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class='search-box'>
                                    <input class='form-control' placeholder='Choose Job' type='text'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class="empty"></div>
                            </td>
                            <td width="30%">
                                <div class='search-box'>
                                    <input class='form-control' placeholder='Choose Company' type='text'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class='search-box'>
                                    <input class='form-control' placeholder='Choose Job' type='text'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class="empty"></div>
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <th >Selected Jobs</th>
                        <th>
                            <div class="job-name fill" draggable="true">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/marketing.svg')?>">
                                <div class="jn">Digital Marketing Executive</div>
                            </div>
                        </th>
                        <th>
                            <div class="job-name" draggable="true">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/marketing.svg')?>">
                                <div class="jn">Human Resources</div>
                            </div>
                        </th>
                        <th>
                            <div class="job-name">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/marketing.svg')?>">
                                <div class="jn">Business Development</div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Profile
                        </td>
                        <td>
                            Marketing
                        </td>
                        <td>
                            Human Resources
                        </td>
                        <td>
                            Business Development
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Designation
                        </td>
                        <td>
                            Digital Marketing Executive
                        </td>
                        <td>
                            Executive
                        </td>
                        <td>
                            Executive
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Type
                        </td>
                        <td>
                            Full Time
                        </td>
                        <td>
                            Full Time
                        </td>
                        <td>
                            Full Time
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Offered Salary
                        </td>
                        <td>
                            ₹ 96000p.a. To ₹ 180000p.a.
                        </td>
                        <td>
                            ₹ 96000p.a. To ₹ 180000p.a.
                        </td>
                        <td>
                            ₹ 96000p.a. To ₹ 180000p.a.
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Experience
                        </td>
                        <td>
                            Less Than 1 Year
                        </td>
                        <td>
                            Less Than 1 Year
                        </td>
                        <td>
                            Less Than 1 Year
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Total Vacancies
                        </td>
                        <td>
                            5
                        </td>
                        <td>
                            2
                        </td>
                        <td>
                            5
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Location
                        </td>
                        <td>
                            Ludhiana, Jalandhar
                        </td>
                        <td>
                            Ludhiana
                        </td>
                        <td>
                            Ludhiana, Jalandhar, Amritsar, Mohali, Delhi
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Working Days
                        </td>
                        <td>
                            Mon - Sat
                        </td>
                        <td>
                            Mon - Fri
                        </td>
                        <td>
                            Mon - Sat
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Work Timing
                        </td>
                        <td>
                            09:30 - 06:00
                        </td>
                        <td>
                            09:30 - 06:00
                        </td>
                        <td>
                            09:30 - 06:00
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Required Knowledge, Skills, and Abilities
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- SOCIAL MEDIA OPTIMIZATION</li>
                                <li>- SOCIAL MEDIA MARKETING</li>
                                <li>- SEARCH ENGINE OPTIMIZATION</li>
                                <li>- SEARCH ENGINE MARKETING</li>
                                <li>- CREATIVE WRITING</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- PROFICIENCY IN ENGLISH(SPOKEN)</li>
                                <li>- PROFICIENCY IN ENGLISH(WRITTEN)</li>
                                <li>- MS-EXCEL</li>
                                <li>- MS-WORD</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- BUSINESS INTELLIGENCE</li>
                                <li>- NEGOTIATION</li>
                                <li>- SALES</li>
                                <li>- STRATEGIC SKILLS</li>
                                <li>- PROJECT MANAGEMENT</li>
                                <li>- EXCELLENT COMMUNICATION</li>
                                <li>- COLLABORATION SKILLS</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Description
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- Work On SEO (search Engine Optimization) For Our Existing Websites.</li>
                                <li>- Work With Our Web Development Team To Optimize The Website For A Higher Ranking On Google.</li>
                                <li>- Work On Digital Marketing For Our Website.</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- Sourcing And Interviewing Candidates That Meet The Qualifications For Various Positions For Clients.</li>
                                <li>- Screening Applicants And Sourced Profiles Over The Phone. Build And Maintain A Pipeline Of Candidates For Various Technical Positions.</li>
                                <li>- Researching Various Companies, Websites, Organizations, Community Groups That May Have Prospective Candidates.</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- Understanding Of The B2B Application Thoroughly.</li>
                                <li>- Market Analysis In The Specified Field.</li>
                                <li>- Sales And Marketing Of B2B Mobile Application To Business Owners And Training The Users.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Education
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- Bachelor's Degree</li>
                                <li>- Master's Degree</li>
                                <li>- Diploma In Digital Marketing</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- Master's Degree</li>
                                <li>- MBA</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="text-left">
                                <li>- Bachelor's Degree</li>
                                <li>- Master's Degree</li>
                                <li>- MBA</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Interview Locations
                        </td>
                        <td>
                            Ludhiana
                        </td>
                        <td>
                            Ludhiana
                        </td>
                        <td>
                            Ludhiana
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>

<?php

echo $this->render('/widgets/mustache/application-card', [
    'type' => 'Jobs',
]);

$this->registerCss('
.empty{
    height:150px;
    border:1px solid #999; 
    background:#fff;  
}
.invisible{
    display:none;
}
body{
    background-color:#fff !important;
}
.fil-btn{
    background:#00a0e3;
    border:none;
    color:#fff;
    padding:10px 15px;
    font-size:14px;
    border-radius:8px;
}
.fil-btn:hover{
    box-shadow:0 0 8px rgba(0,0,0,.5);
    transition:.3s all;
}
.slide-right{
    position:fixed;
    left:0;
    top:60px;
    z-index:999;
    font-size:15px;
    max-width:30px;
    padding:15px 6px;
    background:rgba(0,160,227,.7);
    border:none;
    color:#fff;
    border-radius: 0 10px 10px 0;
}
.slide-right span{
  writing-mode: vertical-rl;
  text-align:center;
}
.filter-links{
    padding:10px 20px;
    border:1px solid #eee;
    margin-bottom:20px;
}
.filter-links ul li{
    display:inline;
    padding:0 15px;
}
.filter-links ul li button{
    border:none;
    background:none;
    font-size:14px;
    font-weight:bold;
}
.filter-links ul li button:hover{
    color:#00a0e3;
    transition:.3s ease-in;
}
table{
    width:100%;
}
tr:nth-child(odd){
    background:#f2f2f2;
}
th, td {
  text-align: center;
  padding: 8px;
}
th{
   border:1px solid #e2e1e1;
   padding:15px 20px;
   min-height:100px; 
    position:sticky;
   position: -webkit-sticky; /* Safari */
   top:50px; 
   background:#fff
}
td{
    border:1px solid #e2e1e1;
    padding:15px 20px;
}
.boldfont{
    font-weight:bold;
}
.bgray{
   background:#f2f2f2;
   border:1px solid #e2e1e1;  
}
.btn-abso{
    position:absolute;
    top:0;
    right:0;
}
.btn-abso button{
    background:none;
    border:none;
    color:#000;
    font-size:14px;
}
.btn-abso button:hover{
    color:#00a0e3;
}
/*---Search bar---*/
.search-box {
    display: inline-block;
    width: 100%;
    border-radius: 3px;
    margin-bottom:10px;
    padding: 4px 55px 4px 15px;
    position: relative;
    background: #fff;
    border: 1px solid #ddd;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box.hovered, .search-box:hover, .search-box:active {
    border: 1px solid #aaa;
}
.search-box input[type=text] {
    border: none;
    box-shadow: none;
    display: inline-block;
    padding: 0;
    background: transparent;
}
.search-box input[type=text]:hover, .search-box input[type=text]:focus, .search-box input[type=text]:active {
    box-shadow: none;
}
.search-box .search-btn {
   position: absolute;
    right: 0px;
    top: 0px;
    color: #eee;
    font-size: 20px;
    padding: 5px 10px 5px;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box .search-btn:hover {
    color: #fff;
    background-color: #00a0e3;
}
.search-form{
    margin-bottom:0px;
}
.form-control{
    height: 32px;
}
/*---Search bar ends---*/
.job-name{
    text-align:center;
    padding:5px 0 5px;
    position:relative;
}
.sticky-top{
    position:sticky;
   position: -webkit-sticky; /* Safari */
   top:50px;
   background:#fff;
}
.job-name img{
    max-width:70px;
    max-height:70px;
}
.jn{
    padding-top:10px;
    font-size:18px;
}
.module-list ul li{
    border:1px solid #e2e1e1;
    text-align:center;
    padding:10px 10px;
    font-weight:bold;
}
.module-list ul li:nth-child(even){
    background:#eee
}
/*---light box---*/
.lightbox-title, .internLight-title{
//    margin-bottom:15px;
    font-weight: 500;
    font-size: 24px;
    color: #444;
//    border-bottom: 1px solid #ddd;
//    padding:0 0px 15px;
}
.light-box, .internLight{
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
.main-inner, .internInner{
    width:100%;
    height:100%;
    display:none;
    background-color: #fff;
    border-radius: 10px;
    position:relative;
    padding:0 20px;
}
.main-inner{
    -webkit-overflow-scrolling: touch;
}
.main-outer, .internOuter{
    width:60%;
    height:70%;
    top:12%;
    left:20%;
    display: none;
    position: fixed;
    overflow:hidden;
    z-index: 2000;
}
@media(min-width : 1500px) {
    .main-outer{
        width: 70%;
        height: 70%;
        top:15%;
        left:15%;
    }
}
.ps__rail-x{
    display:none !important;
}
/*---light box end---*/
@media screen and (min-width: 768px) {
  .row-offcanvas {
    position: relative;
    left: 235px;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas.active {
    left: 0;
    max-width:300px;
  }
  .row-offcanvas .sidebar-offcanvas {
    position: absolute;
    top: 0;
    left: -220px;
    width: 230px;
  }
}
@media screen and (max-width: 767px) {
  .row-offcanvas {
    left: 0;
    position: relative;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas.active {
    left: 50%;
  }
  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 50%;
    left: -50%;
  }
}
.sidebar {
  padding: 10px 25px 10px 12px;
  margin-top: -20px;
  border-radius: 0px 10px 10px 0px;
}
.sidebar h3{
    margin-top:10px;
}
.btn-collapse {
  position: absolute;
  padding: 8px 12px;
  border-radius: 0px 0px 10px 10px;
  top: 20px;
  left: 0;
  margin-left: -26px;
  background: rgba(51, 122, 183, 0.7);
  color:#fff;
  transform: rotate(-90deg);
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.row-offcanvas.active .btn-collapse {
    top:30px;
  left: 0px;
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.row-offcanvas.active .btn-collapse i {
  transform: rotate(180deg);
}
@media only screen  
');
$script = <<<JS
     $('[data-toggle=offcanvas]').click(function () {
         $('.row-offcanvas').toggleClass('active');
     });  

  
    draggable = true;
    var sidebarpage = 1;
    getReviewList(sidebarpage);
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>