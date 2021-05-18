<nav>
    <div class="ey-mob-menu-main-items">
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/account/dashboard">
                    Dashboard
                </a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                        <i class="fa fa-arrow-down"></i>
                    </span>
            </div>
        </div>
        <?= $this->render('education-loans-mobile'); ?>
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/account/jobs/dashboard">Manage Jobs</a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                    <i class="fa fa-arrow-down"></i>
                </span>
            </div>
            <div class="ey-mob-sub-main ey-mob-sub-menu-has-container">
                <div class="ey-mob-sub-items">
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="javascript:;">Create Job</a>
                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler">
                                <i class="fa fa-arrow-down"></i>
                            </span>
                        </div>
                        <div class="ey-mobile-sub-menu-container">
                            <div class="ey-mobile-sub-nav-items">
                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/account/jobs/create">
                                        <div>
                                            <span class="ey-services-icons ai"></span>
                                        </div>
                                        <span>Create AI Job</span>
                                    </a>
                                </div>
                                <?php
                                if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                                    ?>
                                    <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                        <a href="/account/jobs/campus-placement">
                                            <div>
                                                <span class="ey-services-icons campus"></span>
                                            </div>
                                            <span>Campus Hiring</span>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/tweets/job/create">
                                        <div>
                                            <span class="ey-services-icons tweet"></span>
                                        </div>
                                        <span>Post Job Tweet</span>
                                    </a>
                                </div>
                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/account/jobs/quick-job">
                                        <div>
                                            <span class="ey-services-icons quick"></span>
                                        </div>
                                        <span>Create Quick Job</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/account/jobs">Active Jobs</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/account/jobs/active-erexx-jobs">Campus Jobs</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/account/jobs/campus-placement">Campus Hiring</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/account/internships/dashboard">Manage Internships</a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                    <i class="fa fa-arrow-down"></i>
                </span>
            </div>
            <div class="ey-mob-sub-main ey-mob-sub-menu-has-container">
                <div class="ey-mob-sub-items">
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="javascript:;">Create Internship</a>
                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler">
                                <i class="fa fa-arrow-down"></i>
                            </span>
                        </div>
                        <div class="ey-mobile-sub-menu-container">
                            <div class="ey-mobile-sub-nav-items">
                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/account/internships/create">
                                        <div>
                                            <span class="ey-services-icons ai"></span>
                                        </div>
                                        <span>Create AI Internship</span>
                                    </a>
                                </div>
                                <?php
                                if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                                    ?>
                                    <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                        <a href="/account/internships/campus-placement">
                                            <div>
                                                <span class="ey-services-icons campus"></span>
                                            </div>
                                            <span>Campus Hiring</span>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/tweets/internship/create">
                                        <div>
                                            <span class="ey-services-icons tweet"></span>
                                        </div>
                                        <span>Post Internship Tweet</span>
                                    </a>
                                </div>
                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/account/internships/quick-internship">
                                        <div>
                                            <span class="ey-services-icons quick"></span>
                                        </div>
                                        <span>Create Quick Internship</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/account/internships">Active Internships</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/account/internships/active-erexx-internships">Campus Internships</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/account/internships/campus-placement">Campus Hiring</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (Yii::$app->user->identity->businessActivity->business_activity == "Educational Institute") {
            ?>
            <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
                <div class="ey-mobile-item-main">
                    <a href="/account/training-program">Manage Training Programs</a>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if (Yii::$app->user->identity->businessActivity->business_activity == "Educational Institute") {
            ?>
            <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
                <div class="ey-mobile-item-main">
                    <a href="javascript:;">Create Training Programs</a>
                    <span aria-hidden="true" class="ey-mobile-menu-toggler">
                        <i class="fa fa-arrow-down"></i>
                    </span>
                </div>
                <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                    <div class="ey-mobile-sub-menu-heading">
                        <a href="/account/training-program/create">
                            Create AI Training Programs
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/account/templates">Templates</a>
            </div>
        </div>
    </div>
    <ul class="ey-mob-menu-main-items"></ul>
</nav>
<?php
$this->registerJs('
function closeOpened(){
    $(".ey-sub-menu").each(function(){
        if($(this).hasClass("ey-header-delay")){
            $(this).removeClass("ey-header-delay");
        }
    });
}
$(".ey-head-main .ey-header-item-is-menu").mouseenter(function(){
    closeOpened();
    $(this).children(".ey-sub-menu").addClass("ey-header-delay");
});
$(".ey-head-main .ey-header-item-is-menu").mouseleave(function(){
    var elem = $(this);
    setTimeout(function(){
        elem.children(".ey-sub-menu").removeClass("ey-header-delay");
    }, 4000);
});
$(".ey-sub-nav-items .ey-head-sub-menu-has-child, .ey-sub-sec").mouseenter(function(){
    $(".ey-header-sub-menu-container").addClass("ey-header-sub-menu-container-show");
});
$(".ey-sub-nav-items .ey-head-sub-menu-has-child, .ey-sub-sec").mouseleave(function(){
    $(".ey-header-sub-menu-container").removeClass("ey-header-sub-menu-container-show");
});
$(document).on("click", "#open-mobile-menu", function(e){
    e.preventDefault();
    $(this).toggleClass("text-black");
    $(".ey-mobile-content").toggleClass("ey-mobile-show");
    var h_main_header = $("#header-main");
    if(h_main_header.hasClass("header-show")){
        h_main_header.removeClass("header-show");
    }
});
$(document).on("click", ".ey-mob-menu-inner-item.ey-mob-menu-has-sub .ey-mobile-item-main .ey-mobile-menu-toggler", function(e){
    e.preventDefault();
    $(this).parent().next(".ey-mob-sub-menu-has-container").toggleClass("ey-mobile-sub-menu-show");
});
$(document).on("click", ".ey-mob-sub-item.ey-mobile-sub-has-container .ey-mobile-sub-menu-heading", function(e){
    $(this).next(".ey-mobile-sub-menu-container").toggleClass("ey-mobile-sub-nav-show");
});
');
?>