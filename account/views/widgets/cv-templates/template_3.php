<?php

use yii\helpers\Url;

?>
<script id="template_3" type="text/template">
    <div class="r-parent">
        <div class="r-head">
            <div class="r-head-data">
                <div class="user-name">{{name}}</div>
                <div class="user-work">{{title}}</div>
            </div>
        </div>
        <div class="r-inner">
            <div class="r-left">
                {{#image}}
                <div class="user-photo">
                    <img src="<?= Url::to('{{image}}') ?>">
                </div>
                {{/image}}
                {{#description}}
                <div class="user-profile hed">Profile</div>
                <div class="user-detail u-txt">{{description}}</div>
                {{/description}}
                <div class="user-contact hed">contact</div>
                <div class="user-detail">
                    <div class="user-email u-txt">{{email}}</div>
                    <div class="user-num u-txt">{{phone}}</div>
                    <div class="user-address u-txt">{{address}}</div>
                </div>
                <div class="user-skills hed">skills</div>
                <div class="user-detail">
                    {{#userSkills}}
                    <div>{{skill}}</div>
                    {{/userSkills}}
                </div>
                <div class="user-interest hed">interest</div>
                <div class="user-detail">
                    {{#userInterests}}
                    <div>{{interest}}</div>
                    {{/userInterests}}
                </div>
                <div class="user-hobbies hed">hobbies</div>
                <div class="user-detail">
                    {{#userHobbies}}
                    <div>{{hobby}}</div>
                    {{/userHobbies}}
                </div>
            </div>
            <div class="r-right">
                <div class="user-working right-head">
                    <span>Work Experience</span>
                    <div class="user-inner-d">
                        {{#userWorkExperiences}}
                        <div class="user-year">
                            <span>{{from_date}}</span> {{#is_current}} - <span> Current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}|
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
                    <div class="user-inner-d">
                        {{#userAchievements}}
                        <div class="langs">{{achievement}}</div>
                        {{/userAchievements}}
                    </div>
                </div>
                <div class="user-languages right-head">
                    <span>languages</span>
                    <div class="user-inner-d">
                        {{#userSpokenLanguages}}
                        <div class="langs">{{language}}</div>
                        {{/userSpokenLanguages}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>