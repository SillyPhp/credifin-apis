<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main shadow">
            <div class="app-box">
                <div class="row">
                    <div class="application-card-img">
                        <a href="{{organization_link}}" title="{{organization_name}}">
                            {{#logo}}
                            <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                            {{/logo}}
                            {{^logo}}
                            <canvas class="user-icon" name="{{organization_name}}" width="80" height="80"
                                    color="{{color}}" font="35px"></canvas>
                            {{/logo}}
                        </a>
                    </div>
                    <div class="comps-name-1 application-card-description">
                            <span class="skill">
                                <a href="{{link}}" title="{{title}}" class="application-title capitalize org_name">
                                    {{title}}
                                </a>
                            </span>
                        <a href="{{organization_link}}" title="{{organization_name}}" style="text-decoration:none;">
                            <h4 class="org_name comp-name org_name">{{organization_name}}</h4>
                        </a>
                    </div>
                    {{#city}}
                    <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                          data-long="{{longitude}}">
                             <i class="fas fa-map-marker-alt"></i>&nbsp;{{city}}
                        </span>
                    {{/city}}
                    {{^city}}
                    <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                          data-long="{{longitude}}"
                          data-locations="">
                        <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                        </span>
                    {{/city}}
                    </span>
                    <div class="detail-loc application-card-description">
                        <div class="job-loc">
                            {{#salary}}
                            <h5 class="salary">{{salary}}</h5>
                            {{/salary}}
                            {{^salary}}
                            <h5 class="salary">Negotiable</h5>
                            {{/salary}}
                            {{#type}}
                            <h5 class="salary">{{type}}</h5>
                            {{/type}}
                            {{#experience}}
                            <h5 class="salary"><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                            {{/experience}}
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="tag-box">
                            <div class="tags">
                                {{#skill}}
                                <span class="after">{{.}}</span>
                                {{/skill}}
                                {{^skill}}
                                <span class="after">Multiple Skills</span>
                                {{/skill}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="application-card-wrapper">
                    <a href="{{link}}" class="application-card-open" title="View Detail">View Detail</a>
                    <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i
                                class="fas fa-plus"></i>&nbsp;</a>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>


<?php

$this->registerCss('
.application-card-description h5{
    margin-top:0px !important;
    margin-bottom: 8px !important;
}
.application-card-main {
    background-color: transparent !important;
    margin-bottom: 20px !important;
    border-radius: 10px;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
.app-box {
    text-align: left;
    padding: 10px;
    border-radius: 10px;
    position:relative;
    background:#fff;
}
.img{
    max-width: 66px;
}
.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    padding-left: 15px;
    padding-top: 15px;
}
.org_name{display:block;}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.detail-loc{
    margin-top:5px;
}
.location{
    margin-right: 4px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;

}
.city, .city i{
    color: #fff;
}
.show-responsive{
    display:none;
}

.job-fill{
    padding: 5px 10px 4px !important;
    margin: 3px !important;
    background-color:#ff7803 !important;
    color: #fff !important;
    border-radius: 0px 10px 0px 10px !important;
    float: right !important;
    position:absolute !important;
    right: -4px !important;
    top: -3px !important;
}

.clear{
    clear:both;
}

.sal{
    margin-right: 5px;
}

.salary{
    font-family:roboto;
}

.tag-box{
    border-top: 1px solid lightgray;
    padding-left:15px;
    padding-top:10px;
}

.tags{
    font-size: 17px;
    color:gray;
    font-family: Georgia !important;
}
.after{
    padding-right: 25px;
    padding-left: 16px;
}
.after{
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 3px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}
.after::after{
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
.city-box{
    padding-bottom:5px;
}
.ADD-more{
    background-color: #eeeeee;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
}
.more-skills{
    background-color: #00a0e3;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
}
.salary{ 
    padding-left: 16px;
}
@media only screen and (max-width: 974px){
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}

}
/*cards-box css*/

');
$script = <<<JS

    var type = '$type';
    var city = '$city';
    
    if(type == 'jobs'){
        container = '.job-cards';
    }else{
        container = '.internship-cards'
    }
    
    getCards(city,type);
    
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
