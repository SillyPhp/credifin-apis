<div class="container">
    <div class="box-parent row">
        <div class="bolls">
            <div class="boll1 bol2"></div>
            <div class="boll2 bol2"></div>
            <div class="boll3 bol"></div>
            <div class="boll4 bol"></div>
            <div class="boll5 bol2"></div>
            <div class="boll6 bol2"></div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">2000+</div>
                <div class="j-name">Jobs</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">1500+</div>
                <div class="j-name">Internships</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">500+</div>
                <div class="j-name">Locations</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">10k+</div>
                <div class="j-name">opportunities</div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.box-parent {
    background:#00a0e3;
    border-radius: 8px;
    padding: 90px 50px;
    overflow:hidden;
}
.jobs-content {
    text-align: left;
    border-left: 4px solid #79c5e6;
    padding-left: 20px;
}
.j-count{
    font-size:40px;
    color:#fff;
    font-weight: 700;
    font-family: roboto;
}
.j-name{
    font-size:25px;
    color:#fff;
    font-weight: 300;
    font-family: roboto;
}
@media (max-width:768px){
    .box-parent{padding:20px 50px !important;}
    .jobs-content{margin-bottom:10px;}
}
.bolls{position:relative;}
.bol{
    position: absolute;
    width: 85px;
    height: 85px;
    background: #79c5e62e;
    border-radius: 50%;
}
.bol2{
    position: absolute;
    width: 125px;
    height: 125px;
    background: #79c5e62e;
    border-radius: 50%;
}
.boll1 {
    top: -100px;
    left: -56px;
}
.boll2 {
    left: 171px;
    top: 164px;
}
.boll3 {
    left: 371px;
    top: -25px;
}
.boll4 {
    right: 1px;
    top: 76px;
}
.boll5 {
    right: 195px;
    top: 18px;
}
.boll6 {
    right: -69px;
    bottom: 12px;
}
');