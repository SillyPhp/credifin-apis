<script id="template_2" type="text/template">
                    <div class="r-main">
                        <div class="user-name">
                            <div>{{name}}</div>
                            <div class="title-set">{{title}}</div>
                        </div>
                        <div class="r-left">
                            <div class="p-info-head">Personal Information</div>
                            <div class="p-info">
                                <div class="r-phone-no">
                                    <div class="ph-head">Phone</div>
                                    <div class="ph-inner">{{phone}}</div>
                                </div>
                                <div class="r-email">
                                    <div class="e-head">E-mail</div>
                                    <div class="e-inner">{{email}}</div>
                                </div>
                                {{#dob}}
                                <div class="r-birth">
                                    <div class="b-head">Date Of Birth</div>
                                    <div class="b-inner">{{dob}}</div>
                                </div>
                                {{/dob}}
                            </div>
                            <div class="p-info-head">Skills</div>
                            <div class="r-skills">
                                {{#userSkills}}
                                <div class="r-skill">{{skill}}</div>
                                {{/userSkills}}
                            </div>
                            <div class="p-info-head">Hobbies</div>
                            <div class="r-skills">
                                {{#userHobbies}}
                                <div class="r-skill">{{hobby}}</div>
                                {{/userHobbies}}
                            </div>
<!--                            <div class="p-info-head">Languages</div>-->
<!--                            <div class="r-languages">-->
<!--                                <div class="r-lang">hindi</div>-->
<!--                                <div class="r-lang">Punjabi</div>-->
<!--                                <div class="r-lang">english</div>-->
<!--                            </div>-->
                        </div>
                        <div class="r-right">
                            <div class="r-info">
                                <div class="r-head">{{description}}</div>
                                <div class="info-head">Experience</div>
                                <div class="e-main">
                                    {{#userWorkExperiences}}
                                    <div class="e-record">
                                        <div class="e-date">
                                            <span>{{from_date}}</span> {{#is_current}} - <span class="set-to">current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}
                                        </div>
                                        <div class="e-loc">
                                            <div class="loc-name">{{company}}</div>
                                            <div class="loc-pos">{{title}}</div>
                                        </div>
                                    </div>
                                    {{/userWorkExperiences}}
                                </div>
                                <div class="info-head">Education</div>
                                <div class="e-main">
                                    {{#userEducations}}
                                    <div class="e-record">
                                        <div class="ed-date">
                                            <span>{{from_date}}</span> - <span class="set-to">{{to_date}}</span>
                                        </div>
                                        <div class="ed-loc">
                                            <div class="loc-name">{{degree}} {{field}}</div>
                                            <div class="loc-pos">{{institute}}</div>
                                        </div>
                                    </div>
                                    {{/userEducations}}
                                </div>
                                {{#userAchievements.length}}
                                <div class="info-head">Achievements</div>
                                <div class="e-main">
                                    {{#userAchievements}}
                                    <div class="hobbies">{{achievement}}</div>
                                    {{/userAchievements}}
                                </div>
                                {{/userAchievements.length}}
                                {{^userAchievements.length}}
                                {{/userAchievements.length}}
                                <div class="info-head">Interest</div>
                                <div class="e-main">
                                {{#userInterests}}
                                    <div class="hobbies">{{interest}}</div>
                                {{/userInterests}}
                                </div>
                            </div>
                        </div>
                    </div>
</script>