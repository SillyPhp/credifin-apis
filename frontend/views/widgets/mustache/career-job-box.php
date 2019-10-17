<script id="career-job-box" type="text/template">
    {{#.}}
    <div class="career-job-box">
    <div class="row">
    <div class="col-md-12">

        <div class="job-listing wtabs">
        <div class="job-title-sec">
        <div class="c-logo"> <img src="{{icon}}" alt="" /> </div>
        <h3><a href="career-job-detail?slug={{slug}}" >{{title}}</a></h3>
        <span>{{organization_name}}</span>
            <div class="job-lctn"><i class="fas fa-map-marker-alt"></i>{{city}}</div>
        </div>
        <div class="job-style-bx">
            <span class="job-is ft ">{{type}}</span>
        <span class="fav-job"><i class="far fa-heart"></i></span>
        <i>5 months ago</i>
        </div>
        </div>
    </div>
    </div>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss('
.job-listing:hover {
    border-left-color: #8b91dd;
    -webkit-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    z-index: 1;
    position: relative;
}
.follow-companies > ul li .job-listing.wtabs .go-unfollow:hover {
    background: #fb236a;
    border-color: #fb236a;
    color: #fff;
}
.job-listing {
    float: left;
    width: 100%;
    display: table;
    border-bottom: 1px solid #e8ecec;
    padding: 30px 0;
    background: #ffffff;
    border-left: 2px solid #ffffff;
    padding-right: 30px;
}
.job-list-modern .job-listing.wtabs {
    margin: 0;
        margin-top: 0px;
    
    -webkit-border-radius: 0 0;
    -moz-border-radius: 0 0;
    -ms-border-radius: 0 0;
    -o-border-radius: 0 0;
    border-radius: 0 0;

    border-left-color: #ffffff;
    border-right-color: #ffffff;
    border-top-color: #edeff7;
    border-bottom-color: #edeff7;
    margin-top: -1px;
    padding: 30px 0px;
}
.job-list-modern .job-listing.wtabs .job-style-bx {
    padding-bottom: 31px;
    bottom: 50%;
    
    -webkit-transform: translateY(50%);
    -moz-transform: translateY(50%);
    -ms-transform: translateY(50%);
    -o-transform: translateY(50%);
    transform: translateY(50%);

}
.job-listing.wtabs {
    border: 1px solid #ebefef;
    margin-top: 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    display: inherit;
    text-align: left;
    position: relative;
}
.job-listing.wtabs .job-title-sec {
    float: left;
    width: 70%;
}
.job-listing.wtabs .job-title-sec > span {
    color: #1e83f0;
    display: table;
    float: none;
}
.job-listing.wtabs .job-lctn {
    display: inline;
    padding-top: 20px;
    width: 100%;
    font-size: 13px;
}
.job-listing.wtabs .job-lctn i {
    float: none;
    font-size: 15px;
}
.job-listings-sec.style2 .job-listing .job-title-sec span {
    color: #26ae61;
}
.job-listings-sec.style2 .job-listing .job-lctn {
    font-size: 13px;
    color: #888888 !important;;
    line-height: 20px;
    margin-left: 14px;
}
.job-listings-sec.style2 .job-title-sec {
    width: 70%;
}
 .c-logo {
    float: left;
    width: 130px;
    min-height:100px;
    text-align: center;
}
.ft {
    background: none;
    border-top: 1px solid #eaeeee;
    margin-top: 60px;
}
.c-logo img {
    float: none;
    display: inline-block;
    max-width: 100px;
}
');
?>