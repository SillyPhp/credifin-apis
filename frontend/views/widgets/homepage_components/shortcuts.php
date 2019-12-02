<?php
use yii\helpers\Url;
?>
<section class="search-lists">
    <div class="container">
        <div id="quick-links-c">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Popular Searches</div>
                <ul class="quick-links" id="searches">
                    <?php foreach ($search_words as $sw) { ?>
                        <li class="hide">
                            <a href="<?= Url::to('/search?keyword=' . $sw['name']); ?>"
                               title="<?= $sw['name'] ?>">
                                <?= $sw['name'] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Jobs</div>
                <ul class="quick-links" id="jobs">
                    <?php foreach ($job_profiles as $jp) { ?>
                        <li class="hide">
                            <a href="<?= Url::to('/jobs/list?company=&location=&keyword=' . $jp['name']); ?>"
                               title="<?= $jp['name']; ?> Jobs">
                                <?= $jp['name']; ?> Jobs
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Browse by City</div>
                <ul class="quick-links" id="cities">
                    <?php foreach ($cities as $c) { ?>
                        <li class="hide">
                            <a href="<?= Url::to($c['link'], "https"); ?>" title="Jobs in <?= $c['name']; ?>">
                                Jobs in <?= $c['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="list-heading">Internships</div>
                <ul class="quick-links" id="internships">
                    <?php foreach ($internship_profiles as $ip) { ?>
                        <li class="hide">
                            <a href="<?= Url::to('/jobs/list?company=&location=&keyword=' . $ip['name']); ?>"
                               title="<?= $ip['name']; ?> Internships">
                                <?= $ip['name']; ?> Internships
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <button type="button" class="showHideBtn">More</button>
            </div>
        </div>
    </div>
</section>
<script>
    expandFirst('searches');
    expandFirst('cities');
    expandFirst('jobs');
    expandFirst('internships');

    function expandFirst(elem) {
        var i = 0;
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        var k = 0;
        while (k < listElementsLength) {
            if (k < i + 4) {
                if (document.getElementById(elem)) {
                    document.getElementById(elem).children[k].classList.remove('hide');
                }
            } else {
                break;
            }
            k += 1;
        }
    }

    $(document).on('click', '.showHideBtn', function () {
        showMoreEvent();
    });

    function showMoreEvent() {
        hideMore('searches');
        hideMore('cities');
        hideMore('jobs');
        hideMore('internships');
    }

    function hideMore(elem) {
        // var i = 0;
        // i += 5;
        // var k = 4;
        var ll = 0;``
        var zz = 0;
        var tt = 0;
        var f = true;
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        while (ll < listElementsLength) {
            if (document.getElementById(elem).children[ll]) {
                if (document.getElementById(elem).children[ll].classList.contains('hide') && zz < 5) {
                    document.getElementById(elem).children[ll].classList.remove('hide');
                    zz += 1;
                    f = false;
                }
            }
            ll += 1;
        }
        if (f) {
            document.getElementById(elem).parentNode.children[2].innerHTML = 'Less';
            document.getElementById(elem).parentNode.children[2].classList.add('hideElem');
        }
    }

    $(document).on('click', '.hideElem', function () {
        showLessEvent();
    });

    function showLessEvent() {
        hideLess('searches');
        hideLess('cities');
        hideLess('jobs');
        hideLess('internships');
    }

    function hideLess(elem) {
        shrinkFirst(elem);
        document.getElementById(elem).parentNode.children[2].innerHTML = 'More';
        document.getElementById(elem).parentNode.children[2].classList.remove('hideElem');
        expandFirst(elem);
    }

    function shrinkFirst(elem) {
        var listElementsLength = document.getElementById(elem).getElementsByTagName('li').length;
        var k = 5;
        while (k < listElementsLength) {
            if (document.getElementById(elem)) {
                document.getElementById(elem).children[k].classList.add('hide');
            }
            k += 1;
        }
    }
</script>