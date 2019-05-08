<div class="review-summary">
    <h1 class="heading-style">Overall Reviews</h1>
    <div class="row">
        <div class="col-md-12 col-sm-4">
            <div class="rs-main <?= (($reviews_students) ? '' : 'fade_background') ?>">
                <div class="rating-large"><?= $round_students_avg ?>/5</div>
                <div class="com-rating-1">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <i class="fa fa-star <?= (($round_students_avg < $i) ? '' : 'active') ?>"></i>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Student Engagement</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['job_avg']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['student_engagement'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">School Infrastructure</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['growth_avg']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['school_infrastructure'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Faculty</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['avg_cult']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['faculty'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Accessibility Of Faculty</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['avg_compensation']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['accessibility_of_faculty'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Co Curricular Activities</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['avg_work']; ?> </div>
                    <div class="threestar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['co_curricular_activities'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Leadership Development</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['avg_work_life']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['leadership_development'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Sports</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats['avg_skill']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= (($stats_students['sports'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>