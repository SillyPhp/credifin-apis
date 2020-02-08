<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>
    <section style="background: #061540;">
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="newlogoset">
                        <div class="main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/courses/coursescvr.png'); ?>" align="right"
                                 class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 topp-pad">
                    <div class="main-heading-set">
                        <div class="min-heading">Learn anything, anytime, anywhere</div>
                        <div class="jumbo-heading">Aquire and Find best courses from top institutes</div>
                        <!--                    <div class="jumbo-subheading"> Learn Something <span class="jumbo-heading">New Everyday</span></div>-->
                        <div class="search-box1">
                            <form action="<?= Url::to('#') ?>">
                                <input type="text" placeholder="Search" name="keyword" id="get-courses-list">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">Courses By top providers</div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3 set-padding-col">
                    <a href="#">
                        <div class="pro-box">
                            <div class="pro-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                            </div>
                            <div class="pro-name">udemy</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 set-padding-col">
                    <a href="#">
                        <div class="pro-box">
                            <div class="pro-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                            </div>
                            <div class="pro-name">udemy</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 set-padding-col">
                    <a href="#">
                        <div class="pro-box">
                            <div class="pro-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                            </div>
                            <div class="pro-name">udemy</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 set-padding-col">
                    <a href="#">
                        <div class="pro-box">
                            <div class="pro-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                            </div>
                            <div class="pro-name">udemy</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 set-padding-col">
                    <a href="#">
                        <div class="pro-box">
                            <div class="pro-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                            </div>
                            <div class="pro-name">udemy</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 set-padding-col">
                    <a href="#">
                        <div class="pro-box">
                            <div class="pro-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                            </div>
                            <div class="pro-name">udemy</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-skills">
        <h3>Popular Skills</h3>
        <div class="container">
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
            <div class="popular-cards">
                <a href="#">html</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">Courses</div>
            </div>
            <div class="row" id="card-main">
                <!--                <div class="col-md-4 col-sm-6">-->
                <!--                    <a href="#">-->
                <!--                        <div class="course-box">-->
                <!--                            <div class="course-upper">-->
                <!--                                <div class="course-logo">-->
                <!--                                    <img src="-->
                <?//= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?><!--"/>-->
                <!--                                </div>-->
                <!--                                <div class="course-provider">udemy</div>-->
                <!--                                <div class="course-description">-->
                <!--                                    <div class="course-name">html</div>-->
                <!--                                    <div class="course-duration"><i class="far fa-clock"></i>3 months</div>-->
                <!--                                    <div class="course-fees"><i class="fas fa-rupee-sign"></i>15000</div>-->
                <!--                                    <div class="course-start"><i class="far fa-calendar-check"></i>15/10/12</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="course-skills">-->
                <!--                                <div class="skills-set">html</div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </a>-->
                <!--                </div>-->
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">Learning Hub Category</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate" id="categories"></div>
                </div>
            </div>
        </div>
    </section>
    <script id="course-card" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-6">
            <a href="{{url}}">
                <div class="course-box">
                    <div class="course-upper">
                        <div class="course-logo">
                            <img src="{{image_240x135}}"/>
                        </div>
                        <div class="course-provider">udemy</div>
                        <div class="course-description">
                            <div class="course-name">{{title}}</div>
                            <!--                            <div class="course-duration"><i class="far fa-clock"></i>3 months</div>-->
                            <div class="course-fees"><i class="fas fa-rupee-sign"></i>{{price}}</div>
                            <!--                            <div class="course-start"><i class="far fa-calendar-check"></i>15/10/12</div>-->
                            <div class="course-start"><i class="far fa-user"></i>
                                <span class="c-author">
                                    {{#visible_instructors}}
                                        {{display_name}},
                                    {{/visible_instructors}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="course-skills">
                        <div class="skills-set">html</div>
                    </div>
                </div>
            </a>
        </div>
        {{/.}}
    </script>
    <script id="courses-categories" type="text/template">
        {{#.}}
        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
            <a href="javascript:;">
                <div class="newset">
                    <div class="imag">
                        <img src="/assets/themes/ey/images/pages/learning-corner/othercategory.png" alt="{{title}}"/>
                    </div>
                    <div class="txt">{{title}}</div>
                </div>
            </a>
        </div>
        {{/.}}
    </script>
<?php
//echo $this->render('/widgets/mustache/learning-categories');
$this->registerCss('
/*---Categories css start---*/
.cat-padding{
    padding-top:20px;
}
.newset{
    text-align:center;
    max-width: 160px;
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
.imag{
    text-align: right;
}
.txt {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: -4px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
/*---Categories css end---*/
.topp-pad{
    margin-top: 80px !important;
}
.newlogoset{
    max-width:500px;
    margin: 0 auto;
    position:relative;
}
.main-img {
    position: relative;
    display: inline-block;
    z-index: 9;
    margin-bottom: 10px;
    margin-top:20px;
}
.main-heading-set {
    display: block;
    z-index: 9;
    position: relative;
    padding-top: 55px;
}
.min-heading {
    color: #fff;
    text-transform: uppercase;
    border-left: 3px solid #ff7803;
    padding-left: 10px;
    font-weight: 500;
    font-size: 11px;
    font-family: roboto;
    letter-spacing: 1px;
}
.jumbo-heading {
    font-size: 40px;
    font-weight: bold;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
}
.search-box1{
    max-width:500px;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
    width: calc(100% - 38px);
}
.search-box1 .search_init input{
    width: 100%;
}
.search_init{
    width: calc(100% - 38px);
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    width:38px;
    padding: 9px 10px;
    background: #fff;
    font-size: 18px;
    border-radius:0 10px 10px 0;
    border: none;
    cursor: pointer;
}
.search-box1 button:hover {
    color: #ff7803; 
}
.newlogoset img{
    width:100%;
    height:100%;
}
.pro-box{
    border:1px solid #eee;
    text-align:center;
    box-shadow: 0px 0px 8px 0px #eee;
    margin-bottom: 20px;
    background: #fff;
    transition: all 250ms ease-out, transform 250ms ease-out, -webkit-transform 250ms ease-out;
    border-radius: 4px;
    cursor: pointer;
}
.pro-box:hover{
    transform: translate3d(0, -3px, 0);
    box-shadow: 0px 7px 13px rgba(0, 0, 0, 0.14);
}
.pro-logo{
    width: 100px;
    margin: 0 auto;
    margin-top: 20px;
    height: 100px;
    line-height: 100px;
    text-align: center;
}
.pro-logo img{
    width: auto;
    height: auto;
    max-height: 100px;
    max-width: 100px;
}
.pro-name{
    text-transform:capitalize;
    text-align: center;
    padding: 5px 5px 5px 5px;
    font-size: 16px;
    font-weight: 500;
    font-family: roboto;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 65px;
}
.set-padding-col{
    padding:0px 3px !important;
}
.popular-skills {
    padding: 20px 20px 40px 20px;
    background-image: linear-gradient(98deg, #ba0803, #c2582b);
    margin-top:30px;
}
.popular-skills h3 {
    color:#ef9f89;
    font-size: 29px;
    text-align: center;
}
.popular-skills .popular-cards {
    text-align: center;
    display: inline-block;
    width: 23.6%;
    margin: 5px;
}
.popular-skills .popular-cards a {
    color: white;
    display: block;
    padding: 15px;
    background: #ffffff36;
    text-align: left;
    transition: all 0.3s ease;
}
@media screen and (max-width: 768px){
.popular-skills .popular-cards a {
    font-size: 11px;
    padding: 12px 9px;
}
.popular-skills .popular-cards {
    width: 48%;
    margin: 1px;
}
.topp-pad{
    margin-top: 10px !important;
}
.jumbo-heading {
    font-size: 28px;
    }
}
@media screen and (max-width: 456px){
.popular-skills {
    padding: 18px 3px;
    text-align: center;
}
.set-padding-col {
    padding: 0px 10px !important;
}
.jumbo-heading {
    font-size: 25px;
}
.topp-pad{
    margin-top: 10px !important;
}
.main-heading-set{
    padding:0px 0px 20px 0px !important;
}
}
.course-box {
    position: relative;
    box-shadow: 0 1px 3px 0px #797979;
    background-color:#fff;
    margin-bottom: 15px;
    border-radius: 5px;
    overflow: hidden;
    color:#000;
}
.course-upper{
    padding:5px 10px;
    display:flex;
}
.course-provider {
    position: absolute;
    text-align: center;
    text-transform: uppercase;
    right: 0;
    top: 0;
    color: #fff;
    padding: 4px 15px;
    background: #FF4500;
    font-size: 13px;
    font-weight: 500;
    font-family: roboto;
}
.course-logo {
    height: 80px;
    border-radius: 50%;
    box-shadow: 0px 2px 20px 1px #bbbbbb8c;
    width: 80px;
    margin-top: 25px;
    margin-bottom: 5px;
    overflow:hidden;
}
.course-logo img{
    width:100%;
    height:100%;
}
.course-description {
    display:inline-block;
    margin: 22px 10px 10px 23px;
    font-family:roboto;
    width: calc(100% - 115px);
}
.course-duration > i, .course-fees > i, .course-start > i{
    margin-right:5px;
}
.course-name{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform: capitalize;
    font-size: 20px;
    font-weight: 400;
}
.course-duration, .course-fees, .course-start {
    text-transform: capitalize;
    font-size: 15px;
    font-weight: 400;
}
.course-skills {
    border-top: 2px solid #eee;
    padding: 10px 15px;
}
.skills-set {
    background: #eee;
    border-radius: 3px 0 0 3px;
    color:#777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 0px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}

.skills-set::after {
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
.search_init input{
    color:#999;
}
.search_menu {
  display:none;
  position: absolute;
  top: 100%;
  left: 0px;
  z-index: 100;
  width: 100%;
  margin: 0px 0;
  text-align:left;
  background-color: #fff;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.ss-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.ss-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.ss-suggestion.ss-cursor {
  color: #fff;
  background-color: #0097cf;
}
.ss-spinner {
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 18px;
    display: none;
}
');
$script = <<<JS
browse = {
    navigation_categories: [{"type":"category","icon_name":"development","title":"Development","children":[{"children":null,"icon_name":"web-development","title":"Web Development","type":"subcategory","id":8,"absolute_url":"/courses/development/web-development/","title_cleaned":"web-development"},{"children":null,"icon_name":"analytics-and-automation","title":"Data Science","type":"subcategory","id":558,"absolute_url":"/courses/development/data-science/","title_cleaned":"data-science"},{"children":null,"icon_name":"mobile-apps","title":"Mobile Apps","type":"subcategory","id":10,"absolute_url":"/courses/development/mobile-apps/","title_cleaned":"mobile-apps"},{"children":null,"icon_name":"programming-languages","title":"Programming Languages","type":"subcategory","id":12,"absolute_url":"/courses/development/programming-languages/","title_cleaned":"programming-languages"},{"children":null,"icon_name":"game-development","title":"Game Development","type":"subcategory","id":14,"absolute_url":"/courses/development/game-development/","title_cleaned":"game-development"},{"children":null,"icon_name":"databases","title":"Databases","type":"subcategory","id":16,"absolute_url":"/courses/development/databases/","title_cleaned":"databases"},{"children":null,"icon_name":"software-testing","title":"Software Testing","type":"subcategory","id":18,"absolute_url":"/courses/development/software-testing/","title_cleaned":"software-testing"},{"children":null,"icon_name":"software-engineering","title":"Software Engineering","type":"subcategory","id":20,"absolute_url":"/courses/development/software-engineering/","title_cleaned":"software-engineering"},{"children":null,"icon_name":"development-tools","title":"Development Tools","type":"subcategory","id":362,"absolute_url":"/courses/development/development-tools/","title_cleaned":"development-tools"},{"children":null,"icon_name":"e-commerce","title":"E-Commerce","type":"subcategory","id":354,"absolute_url":"/courses/development/e-commerce/","title_cleaned":"e-commerce"}],"id":288,"absolute_url":"/courses/development/","title_cleaned":"development"},{"type":"category","icon_name":"business","title":"Business","children":[{"type":"subcategory","icon_name":"finance","title":"Finance","children":null,"id":24,"absolute_url":"/courses/business/finance-courses/","title_cleaned":"finance-courses"},{"type":"subcategory","icon_name":"entrepreneurship","title":"Entrepreneurship","children":null,"id":26,"absolute_url":"/courses/business/entrepreneurship/","title_cleaned":"entrepreneurship"},{"type":"subcategory","icon_name":"communications","title":"Communications","children":null,"id":28,"absolute_url":"/courses/business/communications/","title_cleaned":"communications"},{"type":"subcategory","icon_name":"management","title":"Management","children":null,"id":30,"absolute_url":"/courses/business/management/","title_cleaned":"management"},{"type":"subcategory","icon_name":"sales","title":"Sales","children":null,"id":32,"absolute_url":"/courses/business/sales/","title_cleaned":"sales"},{"type":"subcategory","icon_name":"strategy","title":"Strategy","children":null,"id":34,"absolute_url":"/courses/business/strategy/","title_cleaned":"strategy"},{"type":"subcategory","icon_name":"operations","title":"Operations","children":null,"id":36,"absolute_url":"/courses/business/operations/","title_cleaned":"operations"},{"type":"subcategory","icon_name":"project-management","title":"Project Management","children":null,"id":38,"absolute_url":"/courses/business/project-management/","title_cleaned":"project-management"},{"type":"subcategory","icon_name":"business-law","title":"Business Law","children":null,"id":40,"absolute_url":"/courses/business/business-law/","title_cleaned":"business-law"},{"type":"subcategory","icon_name":"data-and-analytics","title":"Data \u0026 Analytics","children":null,"id":44,"absolute_url":"/courses/business/data-and-analytics/","title_cleaned":"data-and-analytics"},{"type":"subcategory","icon_name":"home-business","title":"Home Business","children":null,"id":46,"absolute_url":"/courses/business/home-business/","title_cleaned":"home-business"},{"type":"subcategory","icon_name":"human-resources","title":"Human Resources","children":null,"id":48,"absolute_url":"/courses/business/human-resources/","title_cleaned":"human-resources"},{"type":"subcategory","icon_name":"industry","title":"Industry","children":null,"id":50,"absolute_url":"/courses/business/industry/","title_cleaned":"industry"},{"type":"subcategory","icon_name":"media","title":"Media","children":null,"id":52,"absolute_url":"/courses/business/media/","title_cleaned":"media"},{"type":"subcategory","icon_name":"real-estate","title":"Real Estate","children":null,"id":58,"absolute_url":"/courses/business/real-estate/","title_cleaned":"real-estate"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":60,"absolute_url":"/courses/business/other-business/","title_cleaned":"other-business"}],"id":268,"absolute_url":"/courses/business/","title_cleaned":"business"},{"type":"category","icon_name":"finance","title":"Finance \u0026 Accounting","children":[{"type":"subcategory","icon_name":"sales","title":"Accounting \u0026 Bookkeeping","children":null,"id":530,"absolute_url":"/courses/finance-and-accounting/accounting-bookkeeping/","title_cleaned":"accounting-bookkeeping"},{"type":"subcategory","icon_name":"it-certification","title":"Compliance","children":null,"id":532,"absolute_url":"/courses/finance-and-accounting/compliance/","title_cleaned":"compliance"},{"type":"subcategory","icon_name":"cryptocurrency-and-blockchain","title":"Cryptocurrency \u0026 Blockchain","children":null,"id":534,"absolute_url":"/courses/finance-and-accounting/cryptocurrency-and-blockchain/","title_cleaned":"cryptocurrency-and-blockchain"},{"type":"subcategory","icon_name":"productivity","title":"Economics","children":null,"id":536,"absolute_url":"/courses/finance-and-accounting/economics/","title_cleaned":"economics"},{"type":"subcategory","icon_name":"personal-finance","title":"Finance","children":null,"id":540,"absolute_url":"/courses/finance-and-accounting/finance-management/","title_cleaned":"finance-management"},{"type":"subcategory","icon_name":"test-prep","title":"Finance Cert \u0026 Exam Prep","children":null,"id":542,"absolute_url":"/courses/finance-and-accounting/finance-certification-and-exam-prep/","title_cleaned":"finance-certification-and-exam-prep"},{"type":"subcategory","icon_name":"analytics-and-automation","title":"Financial Modeling \u0026 Analysis","children":null,"id":544,"absolute_url":"/courses/finance-and-accounting/financial-modeling-and-analysis/","title_cleaned":"financial-modeling-and-analysis"},{"type":"subcategory","icon_name":"investing-and-trading","title":"Investing \u0026 Trading","children":null,"id":546,"absolute_url":"/courses/finance-and-accounting/investing-and-trading/","title_cleaned":"investing-and-trading"},{"type":"subcategory","icon_name":"money-management-tools","title":"Money Management Tools","children":null,"id":548,"absolute_url":"/courses/finance-and-accounting/money-management-tools/","title_cleaned":"money-management-tools"},{"type":"subcategory","icon_name":"office-productivity","title":"Taxes","children":null,"id":550,"absolute_url":"/courses/finance-and-accounting/taxes/","title_cleaned":"taxes"},{"type":"subcategory","icon_name":"finance","title":"Other Finance \u0026 Economics","children":null,"id":552,"absolute_url":"/courses/finance-and-accounting/other-finance-and-accounting/","title_cleaned":"other-finance-and-accounting"}],"id":328,"absolute_url":"/courses/finance-and-accounting/","title_cleaned":"finance-and-accounting"},{"type":"category","icon_name":"it-and-software","title":"IT \u0026 Software","children":[{"type":"subcategory","icon_name":"it-certification","title":"IT Certification","children":null,"id":132,"absolute_url":"/courses/it-and-software/it-certification/","title_cleaned":"it-certification"},{"type":"subcategory","icon_name":"network-and-security","title":"Network \u0026 Security","children":null,"id":134,"absolute_url":"/courses/it-and-software/network-and-security/","title_cleaned":"network-and-security"},{"type":"subcategory","icon_name":"hardware","title":"Hardware","children":null,"id":136,"absolute_url":"/courses/it-and-software/hardware/","title_cleaned":"hardware"},{"type":"subcategory","icon_name":"operating-systems","title":"Operating Systems","children":null,"id":138,"absolute_url":"/courses/it-and-software/operating-systems/","title_cleaned":"operating-systems"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":140,"absolute_url":"/courses/development/other-it-and-software/","title_cleaned":"other-it-and-software"}],"id":294,"absolute_url":"/courses/it-and-software/","title_cleaned":"it-and-software"},{"type":"category","icon_name":"office-productivity","title":"Office Productivity","children":[{"type":"subcategory","icon_name":"microsoft","title":"Microsoft","children":null,"id":96,"absolute_url":"/courses/office-productivity/microsoft/","title_cleaned":"microsoft"},{"type":"subcategory","icon_name":"apple","title":"Apple","children":null,"id":98,"absolute_url":"/courses/office-productivity/apple/","title_cleaned":"apple"},{"type":"subcategory","icon_name":"google","title":"Google","children":null,"id":100,"absolute_url":"/courses/office-productivity/google/","title_cleaned":"google"},{"type":"subcategory","icon_name":"sap","title":"SAP","children":null,"id":102,"absolute_url":"/courses/office-productivity/sap/","title_cleaned":"sap"},{"type":"subcategory","icon_name":"oracle","title":"Oracle","children":null,"id":106,"absolute_url":"/courses/office-productivity/oracle/","title_cleaned":"oracle"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":108,"absolute_url":"/courses/office-productivity/other-productivity/","title_cleaned":"other-productivity"}],"id":292,"absolute_url":"/courses/office-productivity/","title_cleaned":"office-productivity"},{"type":"category","icon_name":"personal-development","title":"Personal Development","children":[{"type":"subcategory","icon_name":"personal-transformation","title":"Personal Transformation","children":null,"id":142,"absolute_url":"/courses/personal-development/personal-transformation/","title_cleaned":"personal-transformation"},{"type":"subcategory","icon_name":"productivity","title":"Productivity","children":null,"id":144,"absolute_url":"/courses/personal-development/productivity/","title_cleaned":"productivity"},{"type":"subcategory","icon_name":"leadership","title":"Leadership","children":null,"id":146,"absolute_url":"/courses/personal-development/leadership/","title_cleaned":"leadership"},{"type":"subcategory","icon_name":"personal-finance","title":"Personal Finance","children":null,"id":148,"absolute_url":"/courses/personal-development/personal-finance/","title_cleaned":"personal-finance"},{"type":"subcategory","icon_name":"career-development","title":"Career Development","children":null,"id":150,"absolute_url":"/courses/personal-development/career-development/","title_cleaned":"career-development"},{"type":"subcategory","icon_name":"parenting-and-relationships","title":"Parenting \u0026 Relationships","children":null,"id":152,"absolute_url":"/courses/personal-development/parenting-and-relationships/","title_cleaned":"parenting-and-relationships"},{"type":"subcategory","icon_name":"happiness","title":"Happiness","children":null,"id":156,"absolute_url":"/courses/personal-development/happiness/","title_cleaned":"happiness"},{"type":"subcategory","icon_name":"religion-and-spirituality","title":"Religion \u0026 Spirituality","children":null,"id":158,"absolute_url":"/courses/personal-development/religion-and-spirituality/","title_cleaned":"religion-and-spirituality"},{"type":"subcategory","icon_name":"personal-brand-building","title":"Personal Brand Building","children":null,"id":160,"absolute_url":"/courses/personal-development/personal-brand-building/","title_cleaned":"personal-brand-building"},{"type":"subcategory","icon_name":"creativity","title":"Creativity","children":null,"id":164,"absolute_url":"/courses/personal-development/creativity/","title_cleaned":"creativity"},{"type":"subcategory","icon_name":"influence","title":"Influence","children":null,"id":166,"absolute_url":"/courses/personal-development/influence/","title_cleaned":"influence"},{"type":"subcategory","icon_name":"self-esteem","title":"Self Esteem","children":null,"id":168,"absolute_url":"/courses/personal-development/self-esteem/","title_cleaned":"self-esteem"},{"type":"subcategory","icon_name":"stress-management","title":"Stress Management","children":null,"id":170,"absolute_url":"/courses/personal-development/stress-management/","title_cleaned":"stress-management"},{"type":"subcategory","icon_name":"memory","title":"Memory \u0026 Study Skills","children":null,"id":172,"absolute_url":"/courses/personal-development/memory/","title_cleaned":"memory"},{"type":"subcategory","icon_name":"motivation","title":"Motivation","children":null,"id":176,"absolute_url":"/courses/personal-development/motivation/","title_cleaned":"motivation"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":178,"absolute_url":"/courses/personal-development/other-personal-development/","title_cleaned":"other-personal-development"}],"id":296,"absolute_url":"/courses/personal-development/","title_cleaned":"personal-development"},{"type":"category","icon_name":"design","title":"Design","children":[{"type":"subcategory","icon_name":"web-design","title":"Web Design","children":null,"id":6,"absolute_url":"/courses/design/web-design/","title_cleaned":"web-design"},{"type":"subcategory","icon_name":"graphic-design","title":"Graphic Design","children":null,"id":110,"absolute_url":"/courses/design/graphic-design/","title_cleaned":"graphic-design"},{"type":"subcategory","icon_name":"design-tools","title":"Design Tools","children":null,"id":112,"absolute_url":"/courses/design/design-tools/","title_cleaned":"design-tools"},{"type":"subcategory","icon_name":"user-experience","title":"User Experience","children":null,"id":114,"absolute_url":"/courses/design/user-experience/","title_cleaned":"user-experience"},{"type":"subcategory","icon_name":"game-design","title":"Game Design","children":null,"id":116,"absolute_url":"/courses/design/game-design/","title_cleaned":"game-design"},{"type":"subcategory","icon_name":"design-thinking","title":"Design Thinking","children":null,"id":118,"absolute_url":"/courses/design/design-thinking/","title_cleaned":"design-thinking"},{"type":"subcategory","icon_name":"3d-and-animation","title":"3D \u0026 Animation","children":null,"id":120,"absolute_url":"/courses/design/3d-and-animation/","title_cleaned":"3d-and-animation"},{"type":"subcategory","icon_name":"fashion","title":"Fashion","children":null,"id":122,"absolute_url":"/courses/design/fashion/","title_cleaned":"fashion"},{"type":"subcategory","icon_name":"architectural-design","title":"Architectural Design","children":null,"id":124,"absolute_url":"/courses/design/architectural-design/","title_cleaned":"architectural-design"},{"type":"subcategory","icon_name":"interior-design","title":"Interior Design","children":null,"id":128,"absolute_url":"/courses/design/interior-design/","title_cleaned":"interior-design"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":130,"absolute_url":"/courses/design/other-design/","title_cleaned":"other-design"}],"id":269,"absolute_url":"/courses/design/","title_cleaned":"design"},{"type":"category","icon_name":"marketing","title":"Marketing","children":[{"type":"subcategory","icon_name":"digital-marketing","title":"Digital Marketing","children":null,"id":62,"absolute_url":"/courses/marketing/digital-marketing/","title_cleaned":"digital-marketing"},{"type":"subcategory","icon_name":"search-engine-optimization","title":"Search Engine Optimization","children":null,"id":64,"absolute_url":"/courses/marketing/search-engine-optimization/","title_cleaned":"search-engine-optimization"},{"type":"subcategory","icon_name":"social-media-marketing","title":"Social Media Marketing","children":null,"id":66,"absolute_url":"/courses/marketing/social-media-marketing/","title_cleaned":"social-media-marketing"},{"type":"subcategory","icon_name":"branding","title":"Branding","children":null,"id":68,"absolute_url":"/courses/marketing/branding/","title_cleaned":"branding"},{"type":"subcategory","icon_name":"marketing-fundamentals","title":"Marketing Fundamentals","children":null,"id":70,"absolute_url":"/courses/marketing/marketing-fundamentals/","title_cleaned":"marketing-fundamentals"},{"type":"subcategory","icon_name":"analytics-and-automation","title":"Analytics \u0026 Automation","children":null,"id":72,"absolute_url":"/courses/marketing/analytics-and-automation/","title_cleaned":"analytics-and-automation"},{"type":"subcategory","icon_name":"public-relations","title":"Public Relations","children":null,"id":74,"absolute_url":"/courses/marketing/public-relations/","title_cleaned":"public-relations"},{"type":"subcategory","icon_name":"advertising","title":"Advertising","children":null,"id":76,"absolute_url":"/courses/marketing/advertising/","title_cleaned":"advertising"},{"type":"subcategory","icon_name":"video-and-mobile-marketing","title":"Video \u0026 Mobile Marketing","children":null,"id":78,"absolute_url":"/courses/marketing/video-and-mobile-marketing/","title_cleaned":"video-and-mobile-marketing"},{"type":"subcategory","icon_name":"content-marketing","title":"Content Marketing","children":null,"id":80,"absolute_url":"/courses/marketing/content-marketing/","title_cleaned":"content-marketing"},{"type":"subcategory","icon_name":"growth-hacking","title":"Growth Hacking","children":null,"id":86,"absolute_url":"/courses/marketing/growth-hacking/","title_cleaned":"growth-hacking"},{"type":"subcategory","icon_name":"affiliate-marketing","title":"Affiliate Marketing","children":null,"id":88,"absolute_url":"/courses/marketing/affiliate-marketing/","title_cleaned":"affiliate-marketing"},{"type":"subcategory","icon_name":"product-marketing","title":"Product Marketing","children":null,"id":90,"absolute_url":"/courses/marketing/product-marketing/","title_cleaned":"product-marketing"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":94,"absolute_url":"/courses/marketing/other-marketing/","title_cleaned":"other-marketing"}],"id":290,"absolute_url":"/courses/marketing/","title_cleaned":"marketing"},{"type":"category","icon_name":"lifestyle","title":"Lifestyle","children":[{"children":null,"icon_name":"arts-and-crafts","title":"Arts \u0026 Crafts","type":"subcategory","id":180,"absolute_url":"/courses/lifestyle/arts-and-crafts/","title_cleaned":"arts-and-crafts"},{"children":null,"icon_name":"food-and-beverage","title":"Food \u0026 Beverage","type":"subcategory","id":182,"absolute_url":"/courses/lifestyle/food-and-beverage/","title_cleaned":"food-and-beverage"},{"children":null,"icon_name":"beauty-and-makeup","title":"Beauty \u0026 Makeup","type":"subcategory","id":184,"absolute_url":"/courses/lifestyle/beauty-and-makeup/","title_cleaned":"beauty-and-makeup"},{"children":null,"icon_name":"travel","title":"Travel","type":"subcategory","id":186,"absolute_url":"/courses/lifestyle/travel/","title_cleaned":"travel"},{"children":null,"icon_name":"gaming","title":"Gaming","type":"subcategory","id":188,"absolute_url":"/courses/lifestyle/gaming/","title_cleaned":"gaming"},{"children":null,"icon_name":"home-improvement","title":"Home Improvement","type":"subcategory","id":190,"absolute_url":"/courses/lifestyle/home-improvement/","title_cleaned":"home-improvement"},{"children":null,"icon_name":"pet-care-and-training","title":"Pet Care \u0026 Training","type":"subcategory","id":192,"absolute_url":"/courses/lifestyle/pet-care-and-training/","title_cleaned":"pet-care-and-training"},{"children":null,"icon_name":"line-star","title":"Other","type":"subcategory","id":194,"absolute_url":"/courses/lifestyle/other-lifestyle/","title_cleaned":"other-lifestyle"}],"id":274,"absolute_url":"/courses/lifestyle/","title_cleaned":"lifestyle"},{"type":"category","icon_name":"photography","title":"Photography","children":[{"type":"subcategory","icon_name":"digital-photography","title":"Digital Photography","children":null,"id":370,"absolute_url":"/courses/photography/digital-photography/","title_cleaned":"digital-photography"},{"type":"subcategory","icon_name":"photography-fundamentals","title":"Photography Fundamentals","children":null,"id":196,"absolute_url":"/courses/photography/photography-fundamentals/","title_cleaned":"photography-fundamentals"},{"type":"subcategory","icon_name":"portraits","title":"Portraits","children":null,"id":204,"absolute_url":"/courses/photography/portraits/","title_cleaned":"portraits"},{"type":"subcategory","icon_name":"photography-tools","title":"Photography Tools","children":null,"id":198,"absolute_url":"/courses/photography/photography-tools/","title_cleaned":"photography-tools"},{"type":"subcategory","icon_name":"commercial-photography","title":"Commercial Photography","children":null,"id":208,"absolute_url":"/courses/photography/commercial-photography/","title_cleaned":"commercial-photography"},{"type":"subcategory","icon_name":"video-design","title":"Video Design","children":null,"id":218,"absolute_url":"/courses/photography/video-design/","title_cleaned":"video-design"},{"type":"subcategory","icon_name":"line-star","title":"Other","children":null,"id":220,"absolute_url":"/courses/photography/other-photography/","title_cleaned":"other-photography"}],"id":273,"absolute_url":"/courses/photography/","title_cleaned":"photography"},{"type":"category","icon_name":"health-and-fitness","title":"Health \u0026 Fitness","children":[{"children":null,"icon_name":"fitness","title":"Fitness","type":"subcategory","id":222,"absolute_url":"/courses/health-and-fitness/fitness/","title_cleaned":"fitness"},{"children":null,"icon_name":"general-health","title":"General Health","type":"subcategory","id":224,"absolute_url":"/courses/health-and-fitness/general-health/","title_cleaned":"general-health"},{"children":null,"icon_name":"sports","title":"Sports","type":"subcategory","id":226,"absolute_url":"/courses/health-and-fitness/sports/","title_cleaned":"sports"},{"children":null,"icon_name":"nutrition","title":"Nutrition","type":"subcategory","id":228,"absolute_url":"/courses/health-and-fitness/nutrition/","title_cleaned":"nutrition"},{"children":null,"icon_name":"yoga","title":"Yoga","type":"subcategory","id":230,"absolute_url":"/courses/health-and-fitness/yoga/","title_cleaned":"yoga"},{"children":null,"icon_name":"mental-health","title":"Mental Health","type":"subcategory","id":232,"absolute_url":"/courses/health-and-fitness/mental-health/","title_cleaned":"mental-health"},{"children":null,"icon_name":"dieting","title":"Dieting","type":"subcategory","id":234,"absolute_url":"/courses/health-and-fitness/dieting/","title_cleaned":"dieting"},{"children":null,"icon_name":"self-defense","title":"Self Defense","type":"subcategory","id":236,"absolute_url":"/courses/health-and-fitness/self-defense/","title_cleaned":"self-defense"},{"children":null,"icon_name":"safety-and-first-aid","title":"Safety \u0026 First Aid","type":"subcategory","id":238,"absolute_url":"/courses/health-and-fitness/safety-and-first-aid/","title_cleaned":"safety-and-first-aid"},{"children":null,"icon_name":"dance","title":"Dance","type":"subcategory","id":240,"absolute_url":"/courses/health-and-fitness/dance/","title_cleaned":"dance"},{"children":null,"icon_name":"meditation","title":"Meditation","type":"subcategory","id":242,"absolute_url":"/courses/health-and-fitness/meditation/","title_cleaned":"meditation"},{"children":null,"icon_name":"line-star","title":"Other","type":"subcategory","id":244,"absolute_url":"/courses/health-and-fitness/other-health-and-fitness/","title_cleaned":"other-health-and-fitness"}],"id":276,"absolute_url":"/courses/health-and-fitness/","title_cleaned":"health-and-fitness"},{"type":"category","icon_name":"music","title":"Music","children":[{"children":null,"icon_name":"instruments","title":"Instruments","type":"subcategory","id":296,"absolute_url":"/courses/music/instruments/","title_cleaned":"instruments"},{"children":null,"icon_name":"production","title":"Production","type":"subcategory","id":298,"absolute_url":"/courses/music/production/","title_cleaned":"production"},{"children":null,"icon_name":"music-fundamentals","title":"Music Fundamentals","type":"subcategory","id":300,"absolute_url":"/courses/music/music-fundamentals/","title_cleaned":"music-fundamentals"},{"children":null,"icon_name":"vocal","title":"Vocal","type":"subcategory","id":302,"absolute_url":"/courses/music/vocal/","title_cleaned":"vocal"},{"children":null,"icon_name":"music-techniques","title":"Music Techniques","type":"subcategory","id":304,"absolute_url":"/courses/music/music-techniques/","title_cleaned":"music-techniques"},{"children":null,"icon_name":"music-software","title":"Music Software","type":"subcategory","id":306,"absolute_url":"/courses/music/music-software/","title_cleaned":"music-software"},{"children":null,"icon_name":"line-star","title":"Other","type":"subcategory","id":308,"absolute_url":"/courses/music/other-music/","title_cleaned":"other-music"}],"id":278,"absolute_url":"/courses/music/","title_cleaned":"music"},{"type":"category","icon_name":"academics","title":"Teaching \u0026 Academics","children":[{"type":"subcategory","icon_name":"development-tools","title":"Engineering","children":null,"id":366,"absolute_url":"/courses/teaching-and-academics/engineering/","title_cleaned":"engineering"},{"type":"subcategory","icon_name":"humanities","title":"Humanities","children":null,"id":380,"absolute_url":"/courses/teaching-and-academics/humanities/","title_cleaned":"humanities"},{"type":"subcategory","icon_name":"educational-development","title":"Math","children":null,"id":310,"absolute_url":"/courses/teaching-and-academics/math/","title_cleaned":"math"},{"type":"subcategory","icon_name":"math-and-science","title":"Science","children":null,"id":312,"absolute_url":"/courses/teaching-and-academics/science/","title_cleaned":"science"},{"type":"subcategory","icon_name":"instructional-design","title":"Online Education","children":null,"id":523,"absolute_url":"/courses/teaching-and-academics/online-education/","title_cleaned":"online-education"},{"type":"subcategory","icon_name":"social-science","title":"Social Science","children":null,"id":376,"absolute_url":"/courses/teaching-and-academics/social-science/","title_cleaned":"social-science"},{"type":"subcategory","icon_name":"language","title":"Language","children":null,"id":521,"absolute_url":"/courses/teaching-and-academics/language/","title_cleaned":"language"},{"type":"subcategory","icon_name":"teacher-training","title":"Teacher Training","children":null,"id":527,"absolute_url":"/courses/teaching-and-academics/teacher-training/","title_cleaned":"teacher-training"},{"type":"subcategory","icon_name":"test-prep","title":"Test Prep","children":null,"id":529,"absolute_url":"/courses/teaching-and-academics/test-prep/","title_cleaned":"test-prep"},{"type":"subcategory","icon_name":"academics","title":"Other Teaching \u0026 Academics","children":null,"id":525,"absolute_url":"/courses/teaching-and-academics/other-teaching-academics/","title_cleaned":"other-teaching-academics"}],"id":300,"absolute_url":"/courses/teaching-and-academics/","title_cleaned":"teaching-and-academics"}],
};
console.log(browse.navigation_categories);
var categories_template = $('#courses-categories').html();
$("#categories").html(Mustache.render(categories_template, browse.navigation_categories));
$.ajax({
    method: "POST",
    url : window.location.href,
    success: function(response) {
            response = JSON.parse(response);
        if(response.detail == "Not found.") {
            console.log('cards not found');
        } else{
            var template = $('#course-card').html();
            var rendered = Mustache.render(template,response.results);
            $('#card-main').append(rendered);
            $('.c-author').each(function() {
                // $(this).text().slice(0,-1);
                var strVal = $.trim($(this).text());
                var lastChar = strVal.slice(-1);
                if (lastChar == ',') { // check last character is string
                    strVal = strVal.slice(0, -1); // trim last character
                    $(this).text(strVal);
                }
            });
        }
    }
});

var xhr;

function getResult(q){
    if(xhr && xhr.readyState != 4){
        xhr.abort();
    }
    xhr = $.ajax({
        url: '/courses/search?q=' + q,
        beforeSend: function(){
            $('.ss-spinner').show();
            $('.search_menu').hide();
        },
        success: function(data) {
            $('.search_menu').show();
            $('.ss-spinner').hide();
            $('.search_menu').html("");
            data = JSON.parse(data);
            for(var i=0;i<data.results.length;i++){
                $('.search_menu').append('<div class="ss-suggestion">' + data.results[i].title + '</div>');
            }
        }
    });
};
function initializeSearch(el){
    var html = $(el).get().map(function(v){return v.outerHTML}).join('');
    var pp = $(el).parent();
    $('<span class="search_init" style="position:relative;display:inline-block;"></span>').insertBefore(el);
    $(el).remove();
    pp.children('.search_init').append(html);
    pp.children('.search_init').append('<i class="ss-spinner fas fa-circle-notch fa-spin fa-fw"></i>');
    pp.children('.search_init').append('<div class="search_menu"></div>');
    pp.children('.search_init').children(el).attr('autocomplete','off');
    pp.children('.search_init').children(el).keyup(function(e) {
        var getVal = $(this).val();
        if(getVal != "" && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40){
            getResult(getVal);
        }
    });
    pp.children('.search_init').children(el).blur(function() {
        $('.search_menu').hide();
    });
    pp.children('.search_init').children(el).focus(function() {
        showMenu($(this));
    });
    pp.children('.search_init').children(el).keydown(function(e) {
        switch(e.which) {
            case 38:
                selectPrev(el);
            break;
    
            case 40:
                selectNext(el);
            break;
    
            default: return;
        }
    });
}
function selectPrev(el) {
    var pSelected = true;
    $('.ss-suggestion').each(function() {
        if($(this).hasClass("ss-cursor")){
            pSelected = false;
            $(this).removeClass('ss-cursor');
            if($(this).prev()){
                $(el).val($(this).prev().text());
                $(this).prev().addClass('ss-cursor');
            }
            return false;
        }
    });
    if(pSelected){
        $(el).val($('.ss-suggestion:last-child').text());
        $('.ss-suggestion:last-child').addClass('ss-cursor');
    }
    scrollToSelected();
}
function selectNext(el) {
    var nSelected = true;
    $('.ss-suggestion').each(function() {
        if($(this).hasClass("ss-cursor")){
            nSelected = false;
            $(this).removeClass('ss-cursor');
            if($(this).next()){
                $(el).val($(this).next().text());
                $(this).next().addClass('ss-cursor');
            }
            return false;
        }
    });
    if(nSelected){
        $(el).val($('.ss-suggestion:first-child').text());
        $('.ss-suggestion:first-child').addClass('ss-cursor');
    }
    scrollToSelected();
}
function scrollToSelected() {
  $(".search_menu").scrollTop(0);
  if($('.ss-cursor').length != 0){
    $(".search_menu").scrollTop($('.ss-cursor:first').offset().top-$(".search_menu").height()-$('.search_menu').offset().top+$(".ss-cursor:first").height()+20);
  }
}
function showMenu(){
    if($('.search_menu').children()){
        $('.search_menu').show();
    }
}
initializeSearch('#get-courses-list');
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
