<div class="govt-job-box">
    <div class="row">
        <div class="col-md-6">
            <div class="us-job-box">
                <div class="us-text">USA Govt. Jobs</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="in-job-box">
                <div class="in-text">Indian Govt. Jobs</div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
.govt-job-box{
    background:#eee;
    padding:20px;
}
.us-job-box{
    background:url("assets/themes/ey/images/pages/govt-jobs/usa-govt.png")
}
.in-job-box{
    background:url("assets/themes/ey/images/pages/govt-jobs/indian-govt.png")
}
.us-job-box, .in-job-box{
    border:2px solid #fff;
    text-align:left;
    width:75%;
    margin:0 auto;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 300px;
    border-radius:10px;
}
.us-text, .in-text {
    padding: 17px;
    color: #fff;
    font-size: 19px;
    font-weight: 700;
    font-family: roboto;
}
');