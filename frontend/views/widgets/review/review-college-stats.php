<div class="review-summary">
    <h1 class="heading-style">Overall Ratings</h1>
    <div class="row">
        <div class="col-md-12 col-sm-4">
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
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Academics</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['academics']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['academics'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Faculity & Teaching Quality</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['faculty_teaching_quality']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['faculty_teaching_quality'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Infrastructure</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['infrastructure']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['infrastructure'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Accomodation & Food</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['accomodation_food']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['accomodation_food'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Placements/Internships</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['placements_internships']; ?> </div>
                    <div class="threestar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['placements_internships'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Social Life/Extracurriculars</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['social_life_extracurriculars']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['social_life_extracurriculars'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-4">
            <div class="rs1">
                <div class="re-heading">Culture & Diversity</div>
                <div class="summary-box">
                    <div class="sr-rating <?= (($reviews_students) ? '' : 'fade_background') ?>"> <?= $stats_students['culture_diversity']; ?> </div>
                    <div class="fourstar-box com-rating-2 <?= (($reviews_students) ? '' : 'fade_border') ?>">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fas fa-star <?= (($stats_students['culture_diversity'] < $i) ? '' : 'active') ?>"></i>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>