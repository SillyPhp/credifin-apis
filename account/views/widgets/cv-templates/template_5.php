<?php

use yii\helpers\Url;

?>
<script id="template_5" type="text/template">
    <div class="r-parent col-md-8 p-0 col-md-offset-2">
        <div class="r-inner">
            <div class="r-left col-md-4 col-sm-4 p-0">
                <div class="user-photo">
                    <img src="<?= Url::to('@eyAssets/images/pages/world-job/hong-kong.png') ?>">
                </div>
                <div class="user-detail">
                    <div class="user-email u-txt"><i class="fa fa-envelope"></i> {{email}}</div>
                    <div class="user-num u-txt"><i class="fa fa-phone-square"></i> {{phone}}</div>
                    {{#address}}
                    <div class="user-address u-txt"><i class="fas fa-map-marker-alt"></i> {{address}}</div>
                    {{/address}}
                </div>
                <div class="user-skills hed">skills</div>
                <div class="user-detail">
                    <ul>
                        {{#userSkills}}
                        <li>{{skill}}</li>
                        {{/userSkills}}
                    </ul>
                </div>
                {{#interests}}
                <div class="user-interest hed">interest</div>
                <div class="user-detail">
                    <ul>
                        <li>{{interests}}</li>
                    </ul>
                </div>
                {{/interests}}
                <div class="user-interest hed">Languages</div>
                <div class="user-detail">
                    <ul>
                        <li>English</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8" style="padding-right:0;">
                <div class="r-head">
                    <div class="user-name">{{name}}</div>
                    <div class="user-work">{{title}}</div>
                    {{#description}}
                    <div class="user-inf">{{description}}</div>
                    {{/description}}
                </div>
                <div class="user-working right-head">
                    <div class="heading-set">Work Experience</div>
                    <div class="user-inner-d">
                        {{#userWorkExperiences}}
                        <div class="user-year">
                            <div class="user-pos">{{title}}</div>
                            <div class="user-cmp">{{company}}</div>
                            <div class="both">
                                <span class="user-ye">{{from_date}}</span> {{#is_current}} / <span> Current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}
                                <!--                                    <div class="user-loc">ludhiana</div>-->
                            </div>
                        </div>
                        <div class="user-desc">{{description}}</div>
                        {{/userWorkExperiences}}
                    </div>
                </div>
                <div class="user-education right-head">
                    <div class="heading-set">education</div>
                    <div class="user-inner-d">
                        {{#userEducations}}
                        <div class="user-year">
                            <div class="user-pos">{{degree}} {{field}}</div>
                            <div class="user-cmp">{{institute}}</div>
                            <div class="both">
                                <div class="user-ye">{{from_date}} / {{to_date}}</div>
                                <!--                                    <div class="user-loc">ludhiana</div>-->
                            </div>
                        </div>
                        {{/userEducations}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
