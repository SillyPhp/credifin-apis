<?php

use yii\helpers\Url;

?>
<script id="template_5" type="text/template">
    <div class="main-parent">
        <div class="main-header">
            {{#userimage}}
            <div class="user-photo">
                <img src="<?= Url::to('{{image}}') ?>" alt="">
            </div>
            {{/userimage}}
            <div class="user-main">
                <div class="user-name">{{name}}</div>
                <div class="user-job-title">{{title}}</div>
            </div>
            <div class="user-info">
                {{#address}}
                <div class="user-email">{{address}}</div>
                {{/address}}
                <div class="user-email">{{email}}</div>
                <div class="user-number">{{phone}}</div>
            </div>
        </div>
        <div class="main-middle">
            <div class="both-sides">
                {{#description}}
                <h3>Personal Profile</h3>
                <p>{{description}}</p>
                {{/description}}
            </div>
            <div class="clear"></div>
            <div class="both-sides">
                <h3>Work Experience</h3>
                <div class="inner">
                    {{#userWorkExperiences}}
                    <div class="using-padding">
                        <div class="user-title">{{title}}</div>
                        <div class="user-cmpny">{{company}}</div>
                        <div class="user-date"><span>{{from_date}}</span> {{#is_current}} / <span> Current</span>{{/is_current}}{{^is_current}}/{{to_date}}{{/is_current}}
                        </div>
                        <div class="user-description">{{description}}</div>
                    </div>
                    {{/userWorkExperiences}}
                </div>
            </div>
            <div class="clear"></div>
            <div class="both-sides">
                <h3>Education</h3>
                <div class="inner">
                    {{#userEducations}}
                    <div class="using-padding">
                        <div class="user-title">{{institute}}</div>
                        <div class="user-stdy">{{degree}} {{field}}</div>
                        <div class="user-date">{{from_date}} / {{to_date}}</div>
                    </div>
                    {{/userEducations}}
                </div>
            </div>
            <div class="clear"></div>
            <div class="both-sides">
                <h3>Key Skills</h3>
                <div class="inner">
                    {{#userSkills}}
                    <div class="skills">{{skill}}</div>
                    {{/userSkills}}
                </div>
            </div>
            <div class="clear"></div>
            <div class="both-sides">
                <h3>Hobbies</h3>
                <div class="inner">
                    {{#userHobbies}}
                    <div class="skills">{{hobby}}</div>
                    {{/userHobbies}}
                </div>
            </div>
            <div class="clear"></div>
            <div class="both-sides">
                <h3>Interests</h3>
                <div class="inner">
                    {{#userInterests}}
                    <div class="skills">{{interest}}</div>
                    {{/userInterests}}
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</script>
