<?php
use yii\helpers\Url;
?>
<section>
    <div class="row">
        <div class="h-job-main">
            <div class="h-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/blog/speaker2.png') ?>" alt=""/>
            </div>
            <div class="h-heading">Hot Jobs On EmpowerYouth</div>
            <ul class="h-type">
                <li><a href="/sales-jobs">sales jobs</a></li>
                <li><a href="/marketing-job">marketing jobs</a></li>
                <li><a href="/information-technology-job">It jobs</a></li>
            </ul>
            <div class="h-line"></div>
            <div class="explore-btn">
                <a href="/jobs/list">Explore More Jobs</a>
            </div>
        </div>
    </div>
</section>
<?php
$this->RegisterCss('
.h-job-main {
    float: left;
    margin: 40px 0 20px 0;
    padding: 15px;
    width: 100%;
    box-shadow: 0 2px 10px 0 rgba(0,0,0,.2);
    border-radius:4px;
    position:relative;
}
.h-logo{
    position: absolute;
    top: -27px;
    width: 55px;
    right: 8px;
}
.h-heading {
    padding-top: 15px;
    font-size: 20px;
    font-family: roboto;
    font-weight: 600;
    text-align:center;
}
.h-type li {
    text-align: center;
    margin: 20px 0;
}
.h-type li a{
    color:#fff;
    font-size: 16px;
    text-transform: capitalize;
    font-family: roboto;
    font-weight: 500;
    background: #00a0e3;
    display: block;
    padding: 5px;
    border-radius: 4px;
}
.h-line {
    border: 1px solid #eee;
}
.explore-btn {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 10px;
}
.explore-btn a{
    padding: 8px 25px;
    border-radius: 4px;
    background-color: #00a0e3;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    transition: ease-out .5s;
}
.explore-btn a:hover {
    box-shadow: 0 0px 10px 0px #aaa8a8;
 }
');