<?php

use yii\helpers\Url;
$this->registerJs($script);
if ($type == 'mustache-explore-company-card') {
    ?>
<script id="explore-company-card" type="text/template">
        {{#.}}
        <div class="col-md-3 col-sm-6">
                <div class="cards-outer">
                    <a href="/{{organization_link}}">
                        <div class="post-module">
                            <div class="thumbnail">
                                <img src="{{cover_image}}"/>
                            </div>
                            <div class="post-content">
                                <div class="profile__picture">
                                    {{#logo}}
                                    <img class="logos-img" src="{{logo}}">
                                    {{/logo}}
                                    {{^logo}}
                                    <span><canvas class="user-icon explore" name="{{org_name}}" width="80" height="80" font="35px"></canvas></span>
                                    {{/logo}}
                                </div>
                                <h1 class="title">{{org_name}}</h1>
                                <h2 class="sub_title">{{tag_line}}</h2>
                                <p class="description">{{description}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        {{/.}}    
    </script>
    <?php
} elseif ($type == 'mustache-company-card-featured') {
    ?>
    <script id="company-card-featured" type="text/template">
        {{#.}}
        <div class="col-md-6">
        <div class="p-cards-main-inner">
        <img src="{{cover_image}}">
        <div class="profile-cards-title">
        <a class="toggle-info toogle-btn">
        <span class="left"></span>
        <span class="right"></span>
        </a>
        <h2>
        {{org_name}}
        <small>{{tag_line}}</small>
        </h2>
        </div>
        <div class="card-flap flap1">
        <div class="card-description">
        {{description}}
        </div>
        <div class="card-flap flap2">
        <div class="card-actions">
        <a href="/{{organization_link}}" class="toogle-btn">View Profile</a>
        </div>
        </div>
        </div>
        </div>
        </div>
        {{/.}}    
    </script>
    <?php
}

