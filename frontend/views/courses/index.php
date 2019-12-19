<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>
    <section style="background: #061540; overflow: hidden;">
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
                        <div class="jumbo-heading">Aquire and Find best  courses from top institutes</div>
                        <!--                    <div class="jumbo-subheading"> Learn Something <span class="jumbo-heading">New Everyday</span></div>-->
                        <div class="search-box1">
                            <form action="<?= Url::to('#') ?>">
                                <input type="text" placeholder="Search" name="keyword">
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
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <a href="#">
                        <div class="course-box">
                            <div class="course-upper">
                                <div class="course-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/element-image.png'); ?>"/>
                                </div>
                                <div class="course-provider">udemy</div>
                                <div class="course-description">
                                    <div class="course-name">html</div>
                                    <div class="course-duration"><i class="far fa-clock"></i>3 months</div>
                                    <div class="course-fees"><i class="fas fa-rupee-sign"></i>15000</div>
                                    <div class="course-start"><i class="far fa-calendar-check"></i>15/10/12</div>
                                </div>
                            </div>
                            <div class="course-skills">
                                <div class="skills-set">html</div>
                            </div>
                        </div>
                    </a>
                </div>
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
<?php
echo $this->render('/widgets/mustache/learning-categories');
$this->registerCss('
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
    color: 
    #fff;
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

.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
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
.course-description {
    display:inline-block;
    margin: 22px 10px 10px 23px;
    font-family:roboto;
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
');

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
