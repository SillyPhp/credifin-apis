<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section class="rh-header">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="header">
                    <div class="num-companies"><span> 244,945</span> Company Reviews & Ratings in India</div>
                    <div class="">Know In-depth information about the companies you want to work for.</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="wr-bttn hvr-icon-pulse pull-right">
                    <button type="button" id="myBtn"><i class="fa fa-building-o hvr-icon"></i> Search Company</button>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="filter-heading">
                    Search companies by
                </div>
                <form>
                    <div class="filters">
                        <div class="filter-search">
                            <div class="f-search">
                                <input type="text" placeholder="Name" />
                                <i class="fa fa-search"></i>
                            </div>
                            <div class="f-search-loc">
                                <input type="text" placeholder="Location" />
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 f-main-heading">
                                <div class="filter-heading">
                                    Filter companies by
                                </div>
                                <div class="show-search">
                                    <button type="button" onclick="showSearch()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="f-ratings">
                            <div class="overall-box-heading">Avg. Employee Ratings </div>
                            <div class="form-group form-md-checkboxes">
                                <div class="md-checkbox-list">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox0" class="md-check">
                                        <label for="checkbox0">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label"> All</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox1" class="md-check">
                                        <label for="checkbox1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="fivestars rating-stars">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox2" class="md-check">
                                        <label for="checkbox2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="fourstars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox3" class="md-check">
                                        <label for="checkbox3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="threestars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox4" class="md-check">
                                        <label for="checkbox4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="twostars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox5" class="md-check">
                                        <label for="checkbox5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="onestars rating-stars">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="slimScrollDiv">
                            <div class="f-ratings f-rating-box-2 scroller">
                                <div class="overall-box-heading">Industry Names </div>
                                <div class="form-group form-md-checkboxes">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i1" class="md-check">
                                            <label for="checkbox-i1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2"> Financial Services</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i2" class="md-check">
                                            <label for="checkbox-i2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">IT / ITES </div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i3" class="md-check">
                                            <label for="checkbox-i3">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Computer Hardware & Software</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i4" class="md-check">
                                            <label for="checkbox-i4">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Industrial Manufacturing</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i5" class="md-check">
                                            <label for="checkbox-i5">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Consulting</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i6" class="md-check">
                                            <label for="checkbox-i6">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Advertising & Marketing </div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i1" class="md-check">
                                            <label for="checkbox-i1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2"> Financial Services</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i2" class="md-check">
                                            <label for="checkbox-i2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">IT / ITES </div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i3" class="md-check">
                                            <label for="checkbox-i3">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Computer Hardware & Software</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i4" class="md-check">
                                            <label for="checkbox-i4">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Industrial Manufacturing</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i5" class="md-check">
                                            <label for="checkbox-i5">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Consulting</div>
                                            </label>
                                        </div>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox-i6" class="md-check">
                                            <label for="checkbox-i6">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <div class="all-label-2">Advertising & Marketing </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="f-ratings f-rating-box-2">
                            <div class="overall-box-heading">Work Profile </div>
                            <div class="form-group form-md-checkboxes">
                                <div class="md-checkbox-list">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w1" class="md-check">
                                        <label for="checkbox-w1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2"> Web Design / Development</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w2" class="md-check">
                                        <label for="checkbox-w2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Accountant </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w3" class="md-check">
                                        <label for="checkbox-w3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Business Development</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w4" class="md-check">
                                        <label for="checkbox-w4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Human Resource Manager</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w5" class="md-check">
                                        <label for="checkbox-w5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Android Developer</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w6" class="md-check">
                                        <label for="checkbox-w6">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Marketing </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w1" class="md-check">
                                        <label for="checkbox-w1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2"> Web Design / Development</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w2" class="md-check">
                                        <label for="checkbox-w2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Accountant </div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w3" class="md-check">
                                        <label for="checkbox-w3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Business Development</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w4" class="md-check">
                                        <label for="checkbox-w4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Human Resource Manager</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w5" class="md-check">
                                        <label for="checkbox-w5">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Android Developer</div>
                                        </label>
                                    </div>
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox-w6" class="md-check">
                                        <label for="checkbox-w6">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <div class="all-label-2">Marketing </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div class="companies-reviews">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="com-review-box fivestar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">5 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box fourstar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">4 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box threestar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">3 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box twostar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">2 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box onestar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">1 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box fivestar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">5 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box fourstar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">4 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box threestar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">3 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box twostar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">2 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="com-review-box onestar-box">
                                <div class="com-logo">
                                    <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                </div>
                                <div class="com-name">Empower Youth</div>
                                <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                <div class="rating-stars">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="rating">
                                    <div class="stars">1 </div>
                                    <div class="reviews-rate"> of 1.5k review</div>
                                </div>
                                <div class="read-bttn">
                                    <a href="/site/review-home">Read Reviews</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="load-more-bttn">
                                <button type="button">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="empty-section">
                    <div class="e-icon"></div>
                    <div class="e-text">Oops ! There are no reviews for this company</div>
                    <div class="e-text padd-20">Be the first one & write review for this company</div>
                    <div class="e-bttn">
                        <div class="wr-bttn hvr-icon-pulse">
                            <button type="button" id="wr"><i class="fa fa-comments-o hvr-icon"></i> Write Review</button>
                        </div>
                    </div>
                    <div class="related-company">
                        <div class="heading-style">Related Companies</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="com-review-box fivestar-box">
                                    <div class="com-logo">
                                        <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                    </div>
                                    <div class="com-name">Empower Youth</div>
                                    <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                    <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                    <div class="rating-stars">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="rating">
                                        <div class="stars">5 </div>
                                        <div class="reviews-rate"> of 1.5k review</div>
                                    </div>
                                    <div class="read-bttn">
                                        <a href="/site/review-home">Read Reviews</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="com-review-box fourstar-box">
                                    <div class="com-logo">
                                        <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                    </div>
                                    <div class="com-name">Empower Youth</div>
                                    <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                    <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                    <div class="rating-stars">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="rating">
                                        <div class="stars">4 </div>
                                        <div class="reviews-rate"> of 1.5k review</div>
                                    </div>
                                    <div class="read-bttn">
                                        <a href="/site/review-home">Read Reviews</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="com-review-box fourstar-box">
                                    <div class="com-logo">
                                        <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                                    </div>
                                    <div class="com-name">Empower Youth</div>
                                    <div class="com-loc"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                    <div class="com-dep"><i class="fa fa-briefcase"></i> IT</div>
                                    <div class="rating-stars">
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star active"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="rating">
                                        <div class="stars">4 </div>
                                        <div class="reviews-rate"> of 1.5k review</div>
                                    </div>
                                    <div class="read-bttn">
                                        <a href="/site/review-home">Read Reviews</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="wr-modal-header">
            <span class="close">&times;</span>
            <p>Enter Company Name</p>
        </div>
        <div class="wr-modal-body">
            <form>
                <div class="com-name-modal">
                    <input type="text">
                </div>
                <div class="wr-modal-bttn">
                    <button href="" class="i-review-next">
                        <span class="i-review-button-text"> Search Company</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<?php
$this->registerCss('
.related-company{
    padding-top:50px;
}    
.rh-header{
    background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
    background-size:100% 300px;
    background-repeat: no-repeat;
    padding:60px 0 35px 0;
    color:#fff;
    margin-bottom:20px;
} 
.header{
    text-align: left;
}
.num-companies{
    font-size: 25px;
}
.num-companies span{
    font-weight: bold;
}
.filter-search{
    padding-bottom: 20px;
}
.f-main-heading{
    display: flex;
}
.show-search{
    margin-left: 15px;
    margin-top: 5px;
}
.show-search button{
    background: transparent;
    border:none;
    font-size: 15px;
    color: #666;
    float:right;
}
.show-search button:hover{
    color:#00a0e3;
}
.f-search, .f-search-loc, .f-search-1{
   border:1px solid #eee; 
   padding:5px 15px;
   border-radius:10px;   
}
.f-search input, .f-search-loc input, .f-search-1 input {
    border:none;
    font-size: 14px;
}
.f-search-loc{
    margin-top:15px;
}
.f-search input::placeholder, .f-search-loc input::placeholder, .f-search-1 input::placeholder{
    color:#999;
}
.f-search i, .f-search-loc i, .f-search-1 i{
    float:right;
    padding-top:3px;
    color:#999;
}
.fivestars i{
    color:#fd7100 !important; 
}
.fourstars i.active{
    color:#fa8f01 !important; 
}
.threestars i.active{
    color:#fcac01 !important; 
}
.twostars i.active{
    color:#fabf37 !important; 
}
.onestars i.active{
    color:#ffd478 !important; 
}
.md-checkbox label>.box{
    top:6px;
    border: 2px solid #ddd;
}
.md-checkbox-list .md-checkbox{
    margin-bottom:-10px;
}
.f-ratings{
    padding:5px 15px;
    border:1px solid #eee;
    border-radius:10px;
}
.form label{
    margin-bottom: 0px !important;
}
.filter-heading{
    padding:00px 15px 10px 10px;
    font-size:18px;
    text-transform:uppercase;
}
.overall-box-heading{
    font-size:16px;
    padding-top:5px;
    font-weight:bold;
}
.all-label{
    padding-top:5px;
    font-weight:500;
    text-transform:uppercase;
}
.all-label-2{
    padding-top:5px;
    font-weight:500;
    text-transform: capitalize;;
}
.f-rating-box-2{
    margin-top:20px;
    max-height:400px;
    overflow-y: scroll;
}

.f-search-1{
    margin-bottom:10px;
    display:none;
}
/**/

.com-review-box{
    text-align:center;
    border:1px solid #eee;
    padding:20px 0 3px 0;
    margin-bottom:20px;
    border-radius:10px;
    color:#999;
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    padding:0 10px;
    border-radius:10px;
    border:2px solid rgba(238,238,238,.5);
    position:relative;
}
.com-logo img{
    max-width:85px;
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}
.com-name{
    padding-top: 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
}
.rating-stars{
    font-size:20px;
}
.rating{
    display:flex;
    justify-content:center;
    font-size:14px;
}
.stars{
    margin-right:5px;
    color:#00a0e3;
    font-weight:bold;
    font-size:16px;
    margin-top:-2px;
}
.rating-stars i{
    color:#eee;
}
.read-bttn{
    padding-top:15px;
}
.read-bttn a{
    padding:5px 10px;
    background:#999;
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
}
.fivestar-box:hover .com-name {
    color:#fd7100;
}
.fivestar-box .read-bttn a{
    background:#fd7100;
}
.fivestar-box .rating-stars i, .fivestar-box .com-loc i, .fivestar-box .com-dep i,
.fivestar-box .stars{
   color:#fd7100;
}
.fourstar-box{
    border-bottom:2px solid #fa8f01;
}
.fourstar-box .read-bttn a{
    background:#fa8f01;
}
.fourstar-box .rating-stars i.active, .fourstar-box .com-loc i, .fourstar-box .com-dep i,
 .fourstar-box .stars{
   color:#fa8f01;
}
.threestar-box{
    border-bottom:2px solid #fcac01;
}
.threestar-box .read-bttn a{
    background:#fcac01;
}
.threestar-box .rating-stars i.active, .threestar-box .com-loc i, .threestar-box .com-dep i,
 .threestar-box .stars{
   color:#fcac01;
}
.twostar-box{
    border-bottom:2px solid #fabf37;
}
.twostar-box .read-bttn a{
    background:#fabf37;
}
.twostar-box .rating-stars i.active, .twostar-box .com-loc i, .twostar-box .com-dep i,
 .twostar-box .stars{
   color:#fabf37;
}
.onestar-box{
    border-bottom:2px solid #ffd478;
}
.onestar-box .read-bttn a{
    background:#ffd478;
}
.onestar-box .rating-stars i.active, .onestar-box .com-loc i, .onestar-box .com-dep i,
 .onestar-box .stars{
   color:#ffd478;
}
.form-group{
    margin-bottom: 0px;
}
.form-md-checkboxes{
    padding-top:0px;
}
.md-checkbox label>.check{
    top: 5px;
}
.fivestar-box:hover, .fourstar-box:hover, .threestar-box:hover, .twostar-box:hover,
.onestar-box:hover{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
    transition: .3s all;
    -webkit-transition: .3s all;
    -moz-transition: .3s all;
    -o-transition: .3s all;
}
.fivestar-box:hover .com-name {
    color:#fd7100;
}
.fourstar-box:hover .com-name {
    color:#fa8f01;
}
.threestar-box:hover .com-name {
    color:#fcac01;
}
.twostar-box:hover .com-name {
    color:#fabf37;
}
.onestar-box:hover .com-name {
    color:#ffd478;
}
.follow-bttn button ,.wr-bttn button, .cp-bttn a{
    background:#fff;
    border:1px solid #00a0e3;
    color:#00a0e3;
    padding:12px 15px;
    font-size:14px;
    border-radius:5px;
    text-transform:uppercase;
}
.hvr-icon-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    padding-right:1.2em;
}
.hvr-icon-pulse .hvr-icon {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-icon-pulse:hover .hvr-icon, .hvr-icon-pulse:focus .hvr-icon, .hvr-icon-pulse:active .hvr-icon {
    -webkit-animation-name: hvr-icon-pulse;
    animation-name: hvr-icon-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}
.hvr-icon-pulse:before{
    content:"" !important;
}
.load-more-bttn button{
    background: #00a0e3;
    border: 1px solid #00a0e3;
    padding: 12px 25px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 40px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.load-more-bttn button:hover{
    border-radius:8px;
    -webkit-border-radius:8px;
    -moz-border-radius:8px;
    -o-border-radius:8px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.load-more-bttn{
    padding-top:50px;
    text-align:center;
}
.empty-section{
    text-align:center;
    padding-top:50px;
}
.e-text{
    font-size: 20px;
    color: #959494;
    font-family: lobster;
    line-height:20px;
} 
.padd-20{
    padding-top:50px;
}
.e-bttn{
    padding-top:20px;
}
/*new modal css*/
.modal {
  display: none;
  position: fixed; 
  z-index: 9; 
  left: 0;
  top: 0;
  width: 100% important;
  height: 100% !important;
  overflow: auto; 
  background-color: rgb(0,0,0) !important;
  background-color: rgba(0,0,0,0.4) !important;
}

.modal-content {
  padding:50px 50px !important;
  background-color: #2995c2; 
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  top: 50%;
  position:relative; 
  transform: translateY(-50%);
   -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
}
.wr-modal-header p{
   color:#333333 !important;
   font-size:42px; 
   font-weight:500;
}
.close {
  color: #aaaaaa;  
  right:10px; 
  top:10px;
  position:absolute;
  font-size: 28px !important;
  font-weight: bold;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.com-name-modal input{
    width:100%;
    padding:10px 25px;
    background: transparent;
    border:2px solid #000;
    color:#000;
    font-size: 25px;
}
.wr-modal-bttn{
    text-align:center !important; 
    padding-top:50px !important;   
}
.wr-modal-bttn a{
    color:#000 !important;
}
/*new modal css ends*/
');
$script = <<< JS

       
JS;
$this->registerJs($script);

$this->registerCssFile('@eyAssets/ideaboxpopup/ideabox-popup.css');
$this->registerCssFile('http://www.empoweryouth.in/assets/themes/dashboard/global/css/components-md.min.css');
//$this->registerJsFile('http://www.empoweryouth.in/assets/themes/dashboard/global/scripts/app.min.js');
$this->registerJsFile('@eyAssets/ideaboxpopup/ideabox-popup.js');
?>
<!--<script type="text/javascript">
    function showSearch(){
      var element = document.querySelector('.f-search-1');
       element.classList.toggle("hide-search");
    }
</script>    -->

<!--<script type="text/javascript">

    var modal = document.getElementById('myModal');
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
        modal.style.display = "block";
    }
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>-->