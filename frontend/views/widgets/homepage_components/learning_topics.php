<section>
    <div class="container ">
        <div class="cat-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8 col-sm-7 col-xs-12 p-0">
                        <h2 class="heading-style">Enhance Your Skills Learn Something New</h2>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-12">
                        <div class="type-1">
                            <div>
                                <a href="/learning/categories" class="btn btn-3">
                                    <span class="txt-cate">View all</span>
                                    <span class="round"><i class="fas fa-chevron-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate" id="categories"></div>
                </div>
            </div>
            <div class="row" id="loading-learning-categories">
                <div class="col-md-12">
                    <?= $this->render('/widgets/preloaders/learning-categories-preloader'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
echo $this->render('/widgets/mustache/learning-categories');