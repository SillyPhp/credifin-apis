<?php

use yii\helpers\Url;

?>
<script id="template_4" type="text/template">
    <!-- Begin Paper-->
    <div id="paper">
        <div id="paper-mid">
            <!-- Begin Personal Information -->
            <div class="self">
                <h1 class="name">{{name}}<br/>
                    <span>Interactive Designer</span></h1>
                <ul>
                    {{#address}}
                    <li class="ad">{{address}}</li>
                    {{/address}}
                    <li class="mail">{{email}}</li>
                    <li class="tel">{{phone}}</li>
                </ul>
            </div>
            <!-- End Personal Information -->
            <div class="entry">
                <h2>OBJECTIVE</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dignissim viverra nibh sed varius.
                    Proin bibendum nunc in sem ultrices posuere. Aliquam ut aliquam lacus.</p>
            </div>
            <!-- End 1st Row -->
            <!-- Begin 2nd Row -->
            <div class="entry">
                <h2>EDUCATION</h2>
                {{#userEducations}}
                <div class="content">
                    <h3>{{from_date}} / {{to_date}}</h3>
                    <p>{{institute}}<br/>
                        <em>{{degree}} {{field}}</em></p>
                </div>
                {{/userEducations}}
            </div>
            <!-- End 2nd Row -->
            <!-- Begin 3rd Row -->
            <div class="entry">
                <h2>EXPERIENCE</h2>
                <div class="content">
                    {{#userWorkExperiences}}
                    <h3><span>{{from_date}}</span> {{#is_current}} / <span> Current</span>{{/is_current}}{{^is_current}}/{{to_date}}{{/is_current}}
                    </h3>
                    <p>{{company}}<br/>
                        <em>{{title}}</em>
                    </p>
                    <ul class="info">
                        <li>{{description}}</li>
                    </ul>
                    {{/userWorkExperiences}}
                </div>
            </div>
            <!-- End 3rd Row -->
            <!-- Begin 4th Row -->
            <div class="entry">
                <h2>SKILLS</h2>
                <div class="content">
                    <h3>Skill set</h3>
                    <ul class="skills">
                        {{#userSkills}}
                        <li>{{skill}}</li>
                        {{/userSkills}}
                    </ul>
                </div>
                <div class="content">
                    <h3>Hobbies</h3>
                    <ul class="skills">
                        {{#userHobbies}}
                        <li>{{hobby}}</li>
                        {{/userHobbies}}
                    </ul>
                </div>
                <div class="content">
                    <h3>Interest</h3>
                    <ul class="skills">
                        {{#userInterests}}
                        <li>{{interest}}</li>
                        {{/userInterests}}
                    </ul>
                </div>
            </div>
            <!-- End 4th Row -->
        </div>
        <div class="clear"></div>
    </div>
    <!-- End Paper -->
</script>