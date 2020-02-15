<?php

use yii\helpers\Url;
?>
<script id="template_4" type="text/template">
    <div class="r-parent col-md-8 p-0 col-md-offset-2">
        <div class="r-head">
            <div class="r-head-data col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                <div class="user-name">{{name}}</div>
                <div class="user-work">{{title}}</div>
            </div>
        </div>
        <div class="r-inner">
            <div class="r-left col-md-4 col-sm-4 p-0">
                <div class="user-photo">
                    <img src="<?= Url::to('@eyAssets/images/pages/world-job/hong-kong.png') ?>">
                </div>
                <div class="user-profile hed">Profile</div>
                <div class="user-detail u-txt">Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                    the 1500s
                </div>
                <div class="user-contact hed">contact</div>
                <div class="user-detail">
                    <div class="user-email u-txt">{{email}}</div>
                    <div class="user-num u-txt">{{phone}}</div>
                    <div class="user-address u-txt">{{address}}</div>
                </div>
                <div class="user-skills hed">skills</div>
                <div class="user-detail">
                    <ul>
                        {{#userSkills}}
                        <li>{{skill}}</li>
                        {{/userSkills}}
                    </ul>
                </div>
                <div class="user-interest hed">interest</div>
                {{#interests}}
                <div class="user-detail">
                    <ul>
                        <li>{{interests}}</li>
                    </ul>
                </div>
                {{/interests}}
                <div class="user-hobbies hed">hobbies</div>
                <div class="user-detail">
                    {{#hobbies}}
                    <ul>
                        <li>{{hobbies}}</li>
                    </ul>
                    {{/hobbies}}
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="user-working right-head">
                    <span>Work Experience</span>
                    <div class="user-inner-d">
                        {{#userWorkExperiences}}
                        <div class="user-year">
                            <span>{{from_date}} - {{#is_current}} {{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}</span>|
                            <span>{{title}}</span>|
                            <span>{{company}}</span>
                        </div>
                        <div class="user-desc">{{description}}</div>
                        {{/userWorkExperiences}}
                    </div>
                </div>
                <div class="user-education right-head">
                    <span>education</span>
                    <div class="user-inner-d">
                        {{#userEducations}}
                        <div class="user-stdy">
                            <span>{{from_date}} - {{to_date}}</span>/
                            <span>{{degree}} {{field}}</span>
                        </div>
                        <div class="user-uni">{{institute}}</div>
                        {{/userEducations}}
                    </div>
                </div>
                <div class="user-languages right-head">
                    <span>archievements</span>
                    {{#userAchievements}}
                    <div class="user-inner-d">
                        <div class="langs">{{achievement}}</div>
                    </div>
                    {{/userAchievements}}
                </div>
                <div class="user-languages right-head">
                    <span>languages</span>
                    <div class="user-inner-d">
                        <div class="langs">English, hindi, punjabi,</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>