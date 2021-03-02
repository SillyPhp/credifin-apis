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
                <div class="col-md-4 col-sm-6">
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
                <div class="col-md-8 col-sm-6">
                    <div class="usefull-bttn pull-right">
                        <div class="use-bttn">
                            {{#feedback_type}}
                                <button type="button" class="btn_usefull usefull_btn_color" data-key="{{review_enc_id}}" value="1"><i
                                        class="fas fa-thumbs-up"></i> Usefull
                            </button>
                            {{/feedback_type}}
                            {{^feedback_type}}
                            <button type="button" class="btn_usefull" data-key="{{review_enc_id}}" value="1"><i
                                        class="fas fa-thumbs-up"></i> Usefull
                            </button>
                            {{/feedback_type}}
                        </div>
                        <div class="notuse-bttn">
                            {{#feedback_type_not}}
                                <button type="button" class="btn_usefull notusefull_btn_color" data-key="{{review_enc_id}}" value="0"><i
                                        class="fas fa-thumbs-down"></i> Not Usefull
                                </button>
                            {{/feedback_type_not}}
                            {{^feedback_type_not}}
                            <button type="button" class="btn_usefull" data-key="{{review_enc_id}}" value="0"><i
                                        class="fas fa-thumbs-down"></i> Not Usefull
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
.light-bg {
    background: #f4f4f4 !important;
}
');

