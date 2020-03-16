<section>
    <div class="row">
        <div class="h-job-main">
            <div class="h-logo"></div>
            <div class="h-heading">Hot Jobs On EmpowerYouth</div>
            <ul class="h-type">
                <li>sales</li>
                <li>marketing</li>
                <li>product</li>
            </ul>
            <div class="h-line"></div>
            <div class="explore-btn">
                <a href="#">Explore More</a>
            </div>
        </div>
    </div>
</section>
<?php
$this->RegisterCss('
.h-job-main {
    float: left;
    margin: 35px 0;
    padding: 15px;
    width: 100%;
    box-shadow: 0 2px 10px 0 rgba(0,0,0,.2);
    border-radius:4px;
}
.h-heading {
    padding-top: 12px;
    font-size: 20px;
    font-family: roboto;
    font-weight: 600;
}
.h-type li {
    text-align: center;
    border: 1px solid;
    padding: 5px;
    margin: 20px 0;
    font-size: 16px;
    text-transform: capitalize;
    font-family: roboto;
    font-weight: 500;
    border-radius: 5px;
}
.h-line {
    border: 1px solid #000;
}
.explore-btn {
    text-align: center;
    margin-top: 25px;
    margin-bottom: 15px;
}
.explore-btn a{
    padding: 8px 25px;
    border-radius: 4px;
    background-color: #00a0e3;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}
');