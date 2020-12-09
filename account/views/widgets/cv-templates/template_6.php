<?php

use yii\helpers\Url;

?>
<script id="template_6" type="text/template">
    <div class="res-main">
        <div class="res-head">
            <div class="head-right">
                <h1>PROFESSIONAL SUMMARY</h1>
                <p>{{description}}</p>
            </div>
            <div class="head-left">
                <div class="u-name">{{name}}</div>
                {{#address}}
                <div class="u-location">
                    <span><img src="<?= Url::to('@eyAssets/images/pages/cv_templates/loacation.png') ?>"/></span>
                    <span class="addr">{{address}}</span>
                </div>
                {{/address}}
            </div>
            <div class="user-exp">
                <div class="exp-txt">
                    WORK EXPERIENCE
                </div>
                <div class="work-exp">
                    {{#userWorkExperiences}}
                    <div class="exp">
                        <div class="exp-date">
                            <span>{{from_date}}</span> {{#is_current}} - <span class="set-to">current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}
                        </div>
                        <div class="exp-loc">
                            <div class="lo-name">{{company}}</div>
                            <div class="lo-pos">{{title}}</div>
                        </div>
                    </div>
                    {{/userWorkExperiences}}
                </div>
            </div>
            <div class="skls">
                <div class="us-skill">SKILLS</div>
                <div class="skill">
                    {{#userSkills}}
                    <div class="u-skill">
                        <ul>
                            <li>{{skill}}</li>
                        </ul>
                    </div>
                    {{/userSkills}}
                </div>
                    <div class="edu-txt">EDUCATION</div>
                    {{#userEducations}}
                    <div class="edu">
                        <div class="edu-date">
                            <span>{{from_date}}</span> - <span>{{to_date}}</span> / <span class="ed-name">{{degree}} {{field}}</span>
                        </div>
                        <div class="edu-position">
                            {{institute}}
                        </div>
                    </div>
                    {{/userEducations}}
                </div>
                </div>
            </div>
</script>