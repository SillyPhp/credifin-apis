<?php
use yii\helpers\Url;

$link = Url::to($org_slug.'/reviews', true);
?>
<script id="organization-reviews" type="text/template">
    {{#.}}
    <div class="row">
        <div class="re-box refirst">
            <div class="col-md-2 col-sm-2">
                {{#show_user_details}}
                <div class="uicon">
                    {{#image}}
                    <img src="{{image}}">
                    {{/image}}
                    {{^image}}
                    <canvas class="user-icon" name="{{first_name}} {{last_name}}" color="{{initials_color}}" width="80" height="80" font="35px"></canvas>
                    {{/image}}
                </div>
                <div class="uname">{{first_name}} {{last_name}}</div>
                {{/show_user_details}}
                {{^show_user_details}}
                <div class="uicon">
                    <img src="https://www.bsn.eu/wp-content/uploads/2016/12/user-icon-image-placeholder-300-grey.jpg" width="50" height="50">
                </div>
                <div class="uname">Anonymous</div>
                {{/show_user_details}}
            </div>
            <div class="col-md-10 col-sm-10 user-review-main">
                <div class="col-md-6 col-sm-6">
                    <div class="com-rating">
                        <div class="average-star" data-score="{{average}}"></div>
                        <div class="num-rate">{{average}}/5.00</div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="re-bttn">
                        <button type="button" data-toggle="modal" data-target="#report">
                            <i class="fa fa-flag"></i> Report
                        </button>
                    </div>
                    <div class="publish-date">{{created_on}}</div>
                    {{#is_current_employee}}
                    <div class="emp-duration">Current Employee</div>
                    {{/is_current_employee}}
                    {{^is_current_employee}}
                    <div class="emp-duration">Formal employee</div>
                    {{/is_current_employee}}
                </div>
                <div class="col-md-12">
                    <div class="utitle">
                        {{profile}}
                    </div>
                </div>
                <div class=" col-md-12 user-saying">
                    <div class="uheading">Likes</div>
                    <div class="utext">
                        {{likes}}
                    </div>
                    <div class="uheading padd-10">Dislikes</div>
                    <div class="utext">
                        {{dislikes}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 user-rating">
                        <div class="ur-bg padd-lr-5">
                            <div class="urating">{{job_security}}/5</div>
                            <div class="uratingtitle">Job Security</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{growth}}/5</div>
                            <div class="uratingtitle">Career Growth</div>
                        </div>
                        <div class="ur-bg">
                            <div class="urating">{{organization_culture}}/5</div>
                            <div class="uratingtitle">Company Culture</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{compensation}}/5</div>
                            <div class="uratingtitle">Salary & Benefits</div>
                        </div>
                        <div class="ur-bg">
                            <div class="urating">{{work}}/5</div>
                            <div class="uratingtitle">Work Satisfaction</div>
                        </div>
                        <div class="ur-bg light-bg">
                            <div class="urating">{{work_life}}/5</div>
                            <div class="uratingtitle">Work-Life Balance</div>
                        </div>
                        <div class="ur-bg">
                            <div class="urating">{{skill_development}}/5</div>
                            <div class="uratingtitle">Skill Development</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="ushare">
                        <div class="ushare-heading">Share</div>
                        <i class="fa fa-facebook-square" onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u='.$link.''); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fa fa-twitter-square" onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fa fa-linkedin-square" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                        <i class="fa fa-whatsapp wa_icon_hover" onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"></i>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="usefull-bttn pull-right">
                        <div class="use-bttn">
                            <button type="button"><i class="fa fa-thumbs-up"></i> Usefull
                            </button>
                        </div>
                        <div class="notuse-bttn">
                            <button type="button"><i class="fa fa-thumbs-down"></i> Not Usefull
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$script = <<<JS

function getReviews() {
    var slug = window.location.pathname.split('/')[1];
    $.ajax({
        method: "POST",
        url : '/organizations/get-reviews?slug=' + slug,
        success: function(response) {
            if(response.status === 200) {
                console.log(response.reviews);
                var reviews_data = $('#organization-reviews').html();
                $("#org-reviews").html(Mustache.render(reviews_data, response.reviews));
                utilities.initials();
                $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true,
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
            } else if(response.status === 201){
                $('.viewbtn').hide();
            }
        }
    });
}

getReviews();
JS;
$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/raty-master/css/jquery.raty.css');
$this->registerJsFile('@root/assets/vendor/raty-master/js/jquery.raty.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
