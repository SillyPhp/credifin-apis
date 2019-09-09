<nav>
    <div class="ey-mob-menu-main-items">
        <div class="ey-mob-menu-inner-item ey-mob-menu-has-sub">
            <div class="ey-mobile-item-main">
                <a role="button" aria-expanded="false" href="#">Member Benefits</a>
                <span aria-hidden="true" class="ey-mobile-menu-toggler">
                                            <i class="fas fa-arrow-down"></i></span>
            </div>
            <div class="ey-mob-sub-main ey-mob-sub-menu-has-container">
                <div class="ey-mob-sub-items">
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="#">Hosting</a>
                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler"><i
                                        class="fas fa-arrow-down"></i></span>
                        </div>
                        <div class="ey-mobile-sub-menu-container">
                            <div class="ey-mobile-sub-nav-items">
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/">
                                        <div>
                                            <span class="ey-services-icons"></span>
                                        </div>
                                        <span>Features</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a href="#">Site Management</a>
                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler"><i
                                        class="fas fa-arrow-down"></i></span>
                        </div>
                        <div class="ey-mobile-sub-menu-container">
                            <div class="ey-mobile-sub-nav-items">
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>The Hub</span>
                                    </a>
                                </div>

                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/multisite/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>Multisite</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a role="button" aria-expanded="false" href="#">Optimization</a>
                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler"><i
                                        class="fas fa-arrow-down"></i></span>
                        </div>
                        <div class="ey-mobile-sub-menu-container">
                            <div class="ey-mobile-sub-nav-items">
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/project/wp-smush-pro/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>Image Optimization</span>
                                    </a>
                                </div>
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/project/smartcrawl-wordpress-seo/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>SEO Optimization</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ey-mob-sub-item ey-mobile-sub-has-container">
                        <div class="ey-mobile-sub-menu-heading">
                            <a role="button" aria-expanded="false" href="#">Marketing</a>
                            <span aria-hidden="true" class="ey-mobile-menu-item-toggler"><i
                                        class="fas fa-arrow-down"></i></span>
                        </div>
                        <div class="ey-mobile-sub-menu-container">
                            <div class="ey-mobile-sub-nav-items">
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/project/forminator-pro/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>Forms &amp; Quizes</span>
                                    </a>
                                </div>
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/white-label-branding/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>White Label Branding</span>
                                    </a>
                                </div>
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/project/smartcrawl-wordpress-seo/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>SEO Optimization</span>
                                    </a>
                                </div>
                                <div
                                        class="ey-mobile-sub-icons ey-mobile-nav-item-with-icons">
                                    <a href="/marketing/">
                                        <div><span
                                                    class="ey-services-icons"></span>
                                        </div>
                                        <span>Optins &amp; Popups</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ey-mob-menu-inner-item">
            <div class="ey-mobile-item-main">
                <a href="/">Plugins</a>
            </div>
        </div>
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
$(document).on("click", ".ey-mob-menu-inner-item.ey-mob-menu-has-sub .ey-mobile-item-main", function(e){
    e.preventDefault();
    $(this).next(".ey-mob-sub-menu-has-container").toggleClass("ey-mobile-sub-menu-show");
});
$(document).on("click", ".ey-mob-sub-item.ey-mobile-sub-has-container .ey-mobile-sub-menu-heading", function(e){
    e.preventDefault();
    $(this).next(".ey-mobile-sub-menu-container").toggleClass("ey-mobile-sub-nav-show");
});
');
?>