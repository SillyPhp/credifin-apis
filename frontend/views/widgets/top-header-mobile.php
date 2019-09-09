<nav>
    <div class="ey-mob-menu-main-items">
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/jobs">Jobs</a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                    <i class="fas fa-arrow-down"></i>
                </span>
            </div>
            <div class="ey-mob-sub-main ey-mob-sub-menu-has-container">
                <div class="ey-mob-sub-items">
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/jobs/near-me">Jobs Near Me</a>
                            <!--                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler">-->
                            <!--                                <i class="fas fa-arrow-down"></i>-->
                            <!--                            </span>-->
                        </div>
                        <!--                        <div class="ey-mobile-sub-menu-container">-->
                        <!--                            <div class="ey-mobile-sub-nav-items">-->
                        <!--                                <div class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">-->
                        <!--                                    <a href="/">-->
                        <!--                                        <div>-->
                        <!--                                            <span class="ey-services-icons"></span>-->
                        <!--                                        </div>-->
                        <!--                                        <span>Test</span>-->
                        <!--                                    </a>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/organizations">Explore Companies</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/jobs/compare">Compare Jobs</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/organizations/explore">Featured Companies</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/tweets/jobs">Job Tweets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/internships">Internships</a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                    <i class="fas fa-arrow-down"></i>
                </span>
            </div>
            <div class="ey-mob-sub-main ey-mob-sub-menu-has-container">
                <div class="ey-mob-sub-items">
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/internships/near-me">Internships Near Me</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/organizations">Explore Companies</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/internships/compare">Compare Internships</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/organizations/explore">Featured Companies</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/tweets/internships">Internship Tweets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a href="/reviews">Reviews</a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                    <i class="fas fa-arrow-down"></i>
                </span>
            </div>
            <div class="ey-mob-sub-main ey-mob-sub-menu-has-container">
                <div class="ey-mob-sub-items">
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/reviews/companies">Companies</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/reviews/colleges">Colleges</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/reviews/schools">Schools</a>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="/reviews/institutes">Educational Institutes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ey-mob-menu-inner-item">
            <div class="ey-mobile-item-main">
                <a href="/blog">Blog</a>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <div class="ey-mob-menu-inner-item">
                <div class="ey-mobile-item-main">
                    <a href="/account/dashboard">Dashboard</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <ul class="ey-mob-menu-main-items"></ul>
</nav>
<?php
$this->registerJs('
 $(".ey-sub-nav-items .ey-head-sub-menu-has-child, .ey-sub-sec").mouseenter(function(){
    $(".ey-header-sub-menu-container").addClass("ey-header-sub-menu-container-show");
});
$(".ey-sub-nav-items .ey-head-sub-menu-has-child, .ey-sub-sec").mouseleave(function(){
    $(".ey-header-sub-menu-container").removeClass("ey-header-sub-menu-container-show");
});
$(document).on("click", "#open-mobile-menu", function(e){
    e.preventDefault();
    $(".ey-mobile-content").toggleClass("ey-mobile-show");
});
$(document).on("click", ".ey-mob-menu-inner-item.ey-mob-menu-has-sub .ey-mobile-item-main .ey-mobile-menu-toggler", function(e){
    e.preventDefault();
    $(this).parent().next(".ey-mob-sub-menu-has-container").toggleClass("ey-mobile-sub-menu-show");
});
$(document).on("click", ".ey-mob-sub-item.ey-mobile-sub-has-container .ey-mobile-sub-menu-heading", function(e){
    e.preventDefault();
    $(this).next(".ey-mobile-sub-menu-container").toggleClass("ey-mobile-sub-nav-show");
});
');
?>