<div class="review-summary">
    <h1 class="heading-style">Overall Ratings</h1>
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <div class="rs-main <?= (($reviews_students) ? '' : 'fade_background') ?>">
                <div class="rating-large"><?= $round_students_avg ?>/5</div>
                <div class="com-rating-1">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <i class="fas fa-star <?= (($round_students_avg < $i) ? '' : 'active') ?>"></i>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Student Engagement</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['student_engagement']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['student_engagement'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Infrastructure</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['school_infrastructure']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['school_infrastructure'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Faculty</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['faculty']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['faculty'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Value For Money</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['value_for_money']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['value_for_money'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Teaching Style</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['teaching_style']; ?> </div>
                    <div class="threestar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['teaching_style'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Coverage Of Subject Matter</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['coverage_of_subject_matter']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['coverage_of_subject_matter'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="rs1">
                <div class="re-heading">Accessibility of Faculty</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['accessibility_of_faculty']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['accessibility_of_faculty'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>