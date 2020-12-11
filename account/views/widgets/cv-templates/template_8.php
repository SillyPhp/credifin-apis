<?php

use yii\helpers\Url;

?>
<script id="template_8" type="text/template">
    <div class="hed-main">
        <div class="hed-res mar-b">
            <h3 class="usr-name">{{name}}</h3>
            <p class="usr-email">{{email}}</p>
            <p class="usr-number">{{phone}}</p>
        </div>
        <div class="personal-summary">
            {{#description}}
            <h3>PERSONAL SUMMARY</h3>
            <p>{{description}}</p>
            {{/description}}
        </div>
        <div class="educaton-text">EDUCATION</div>
        {{#userEducations}}
        <div class="educaton">
            <div class="educaton-date">
                <span>{{from_date}}</span> - <span>{{to_date}}</span> / <span class="ed-name">{{degree}} {{field}}</span>
            </div>
            <div class="educaton-location">
                {{institute}}
            </div>
        </div>
        {{/userEducations}}
        <div class="usr-skills">SKILLS</div>
        <div class="skillss">
            {{#userSkills}}
            <div class="u-skillss">
                <ul>
                    <li>{{skill}}</li>
                </ul>
            </div>
            {{/userSkills}}
        </div>
        <div class="work-experence">WORK EXPERIENCE</div>
        {{#userWorkExperiences}}
        <div class="experince">
            <div class="experince-date">
                <span>{{from_date}}</span> {{#is_current}} - <span class="set-to">current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}
            </div>
            <div class="experince-loc">
                <div class="l-name">{{company}}</div>
                <div class="l-pos">{{title}}</div>
            </div>
        </div>
        {{/userWorkExperiences}}
    </div>
</script>
