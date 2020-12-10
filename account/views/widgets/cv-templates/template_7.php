<?php

use yii\helpers\Url;

?>
<script id="template_7" type="text/template">
    <div class="resume-main">
        <div class="resume-head">
            <h3 class="us-name marg-b">{{name}}</h3>
            <p class="us-email">{{email}}</p>
            <p class="us-number">{{phone}}</p>
            <div class="us-address">{{address}}</div>
        </div>
        <div class="personal-sum">
            {{#description}}
            <h3>Personal Summary</h3>
            <p>{{description}}</p>
            {{/description}}
        </div>
        <div class="us-skills">SKILLS</div>
        <div class="skills">
            {{#userSkills}}
            <div class="u-skills">
                <ul>
                    <li>{{skill}}</li>
                </ul>
            </div>
            {{/userSkills}}
        </div>
        <div class="edu-text">EDUCATION</div>
        {{#userEducations}}
        <div class="educ">
            <div class="educ-date">
                <span>{{from_date}}</span> - <span>{{to_date}}</span> / <span class="ed-name">{{degree}} {{field}}</span>
            </div>
            <div class="educ-position">
                {{institute}}
            </div>
        </div>
        {{/userEducations}}
        <div class="work-experience">Work Experience</div>
            {{#userWorkExperiences}}
            <div class="experience">
                <div class="expe-date">
                    <span>{{from_date}}</span> {{#is_current}} - <span class="set-to">current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}
                </div>
                <div class="expe-loc">
                    <div class="l-name">{{company}}</div>
                    <div class="l-pos">{{title}}</div>
                </div>
            </div>
            {{/userWorkExperiences}}
    </div>
</script>