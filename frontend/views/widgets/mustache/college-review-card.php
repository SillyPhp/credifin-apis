<?php
?>
<script id="organization-reviews" type="text/template">
    {{#.}}
        <div class="row">
        <div class="col-md-12">
            <div class="re-box refirst" id="{{review_enc_id}}">
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        {{#show_user_details}}
                            <div class="uicon">
                            {{#image}}
                                <img src="{{image}}">
                            {{/image}}
                            {{^image}}
                            <canvas class="user-icon" name="{{first_name}} {{last_name}}" color="{{initials_color}}"
                                    width="80" height="80" font="35px"></canvas>
                            {{/image}}
                        </div>
                        <div class="uname">{{first_name}} {{last_name}}</div>
                        {{/show_user_details}}
                        {{^show_user_details}}
                        <div class="uicon">
                            <img src="/assets/common/images/user1.png" width="50" height="50">
                        </div>
                        <div class="uname">Anonymous</div>
                        {{/show_user_details}}
                    </div>
                    <div class="col-md-10 col-sm-10 user-review-main">
                <div class="col-md-6 col-sm-6">
                    <div class="com-rating">
                        <div class="average-star" data-score="{{average_rating}}"></div>
                        <div class="num-rate">{{average_rating}}/5</div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="publish-date">{{created_on}}</div>
                    {{#is_current_employee}}
                        <div class="emp-duration">Current Employee</div>
                    {{/is_current_employee}}
                    {{^is_current_employee}}
                    <div class="emp-duration">Formal employee</div>
                    {{/is_current_employee}}
                </div>
                <div class="col-md-12">
                    <div class="utitle">
                        {{designation}} in {{profile}}
                    </div>
                </div>
                <div class=" col-md-12 user-saying">
                    <div class="uheading">Likes</div>
                    <div class="utext">
                        {{likes}}
                    </div>
                    <div class="uheading padd-10">Dislikes</div>
                    <div class="utext">
                        {{dislikes}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 user-rating">
                        <div class="ur-bg padd-lr-5">
                            <div class="urating">{{rating.Job_Security}}/5</div>
                            <div class="uratingtitle">Job Security</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{rating.Career_Growth}}/5</div>
                            <div class="uratingtitle">Career Growth</div>
                        </div>
                        <div class="ur-bg">
                            <div class="urating">{{rating.Company_Culture}}/5</div>
                            <div class="uratingtitle">Company Culture</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{rating.Salary_And_Benefits}}/5</div>
                            <div class="uratingtitle">Salary & Benefits</div>
                        </div>
                        <div class="ur-bg">
                            <div class="urating">{{rating.Work_Satisfaction}}/5</div>
                            <div class="uratingtitle">Work Satisfaction</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{rating.Work_Life_Balance}}/5</div>
                            <div class="uratingtitle">Work-Life Balance</div>
                        </div>
                        <div class="ur-bg">
                            <div class="urating">{{rating.Skill_Development}}/5</div>
                            <div class="uratingtitle">Skill Development</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5">
                    <div class="ushare">
                        <div class="ushare-heading">Share</div>
                        <i class="fab fa-facebook-square"
                           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{review_sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fab fa-twitter-square"
                           onclick="window.open('https://twitter.com/intent/tweet?text={{seo_title}}&url={{review_sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fab fa-linkedin"
                           onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url={{review_sharing_link}} &title={{seo_title}}&summary={{seo_title}}', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fab fa-whatsapp wa_icon_hover"
                           onclick="window.open('https://api.whatsapp.com/send?text={{review_sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                    </div>
                </div>
                <div class="col-md-9 col-sm-7">
                    <div class="usefull-bttn pull-right">
                        <div class="use-bttn">
                            {{#feedback_type_in}}
                                <button type="button" class="btn_usefull usefull_btn_color" data-key="{{review_enc_id}}" value="one"><i
                                            class="fas fa-thumbs-up"></i> Usefull <span class="usefulNum">{{useful}}</span>
                            </button>
                            {{/feedback_type_in}}
                            {{^feedback_type_in}}
                            <button type="button" class="btn_usefull" data-key="{{review_enc_id}}" value="one"><i
                                        class="fas fa-thumbs-up"></i> Usefull <span class="usefulNum">{{useful}}</span>
                            </button>
                            {{/feedback_type_in}}
                        </div>
                        <div class="notuse-bttn">
                            {{#feedback_type_not}}
                                <button type="button" class="btn_usefull notusefull_btn_color" data-key="{{review_enc_id}}" value="zero"><i
                                        class="fas fa-thumbs-down"></i> Not Usefull <span class="notUsefulNum">{{not_useful}}</span>
                                </button>
                            {{/feedback_type_not}}
                            {{^feedback_type_not}}
                            <button type="button" class="btn_usefull" data-key="{{review_enc_id}}" value="zero"><i
                                        class="fas fa-thumbs-down"></i> Not Usefull <span class="notUsefulNum">{{not_useful}}</span>
                                </button>
                            {{/feedback_type_not}}
                        </div>
                        <div class="re-bttn" id="report_btn" data-key="{{review_enc_id}}">
                            <button type="button" data-toggle="modal" data-target="#report">
                                <i class="fas fa-flag"></i> Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
    <input type="hidden" name="review_enc_id" id="review_enc_id">
    <div id="report" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reason for reporting?</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-md-radios">
                        <label></label>
                        <form id="report_form">
                            <div class="md-radio-list">
                                <div class="md-radio">
                                    <input type="radio" id="radio1" name="reporting_radio" value="1"
                                           class="md-radiobtn">
                                    <label for="radio1">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        This post contains hateful, violent, or inappropriate content </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio2" name="reporting_radio" value="2"
                                           class="md-radiobtn">
                                    <label for="radio2">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        This post contains advertising or spam</label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio3" name="reporting_radio" value="3"
                                           class="md-radiobtn">
                                    <label for="radio3">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Off-topic </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio4" name="reporting_radio" value="4"
                                           class="md-radiobtn">
                                    <label for="radio4">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        This post contains conflicts of interest </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCSS('
.ur-bg {
    background: #edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    min-height: 95px;
}
.usefulNum{
//    background: #00a0e3;
    padding: 2px 5px;
    border-radius: 5px;
    color: #00a0e3;
    margin-left:4px; 
}
.notUsefulNum{
//    background: #d72a2a;
    padding: 2px 5px;
    border-radius: 5px;
    color: #d72a2a;
    margin-left:4px; 
}
.light-bg {
    background: #f4f4f4 !important;
}
.md-radio {
  position: relative;
}
.md-radio input[type=radio] {
    visibility: hidden;
    position: absolute; 
}
.md-radio label {
    cursor: pointer;
    padding-left: 30px; 
}
.md-radio label > span {
    display: block;
    position: absolute;
    left: 0;
    -webkit-transition-duration: 0.3s;
    -moz-transition-duration: 0.3s;
    transition-duration: 0.3s; 
}
.md-radio label > span.inc {
    background: #fff;
    left: -20px;
    top: -20px;
    height: 60px;
    width: 60px;
    opacity: 0;
    border-radius: 50% !important;
    -moz-border-radius: 50% !important;
    -webkit-border-radius: 50% !important; 
}
.md-radio label > .box {
    top: 0px;
    border: 2px solid #666;
    height: 20px;
    width: 20px;
    border-radius: 50% !important;
    -moz-border-radius: 50% !important;
    -webkit-border-radius: 50% !important;
    z-index: 5;
 }
.md-radio label > .check {
    top: 5px;
    left: 5px;
    width: 10px;
    height: 10px;
    background: #36c6d3;
    opacity: 0;
    z-index: 6;
    border-radius: 50% !important;
    -moz-border-radius: 50% !important;
    -webkit-border-radius: 50% !important;
    -webkit-transform: scale(0);
    -moz-transform: scale(0);
    transform: scale(0); 
}
.md-radio label > span.inc {
    -webkit-animation: growCircleRadio 0.3s ease;
    -moz-animation: growCircleRadio 0.3s ease;
    animation: growCircleRadio 0.3s ease; 
}
.md-radio input[type=radio]:checked ~ label > .check {
    opacity: 1;
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    transform: scale(1); 
}
');
$script = <<<JS
    
JS;
$this->registerJS($script);
