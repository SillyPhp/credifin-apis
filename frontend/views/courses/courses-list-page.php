<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>

<section class="head-search">
    <div class="search-bar">
        <div class="search-head">
            <div class="c-heading">Search All type of Courses which you want to do</div>
        </div>
        <div class="search-box1">
            <form action="<?= Url::to('#') ?>">
                <input type="text" placeholder="Search" name="keyword">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
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

<?php
$this->registerCss('
.head-search {
    background-color: #60969f;
    min-height: 250px;
}
.search-bar {
    padding-top: 90px;
    text-align: center;
}
.c-heading {
    font-size: 30px;
    color: #fff;
    font-family: roboto;
    font-weight: 500;
    text-transform: capitalize;
}
.search-box1{
    max-width:500px;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 0 auto;
    margin-top:20px;
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