<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="gallery-view">
    <?php if (!empty($object)) {
        foreach ($object as $obj) {
            $link = Url::to('question/' . $obj['slug'], true);
            ?>
            <div class="col-md-4 col-sm-6 card-box">
                <div class="card">
                    <div class="card__block card__block--main">
                        <div class="head">
                            <div class="user-img">
                                <?php if ($obj['privacy'] == 1) { ?>
                                    <?php if ($obj['image']) { ?>
                                        <img src="<?= $obj['image']; ?>"
                                             alt="<?= $obj['user_name']; ?>"/>
                                    <?php } else { ?>
                                        <canvas class="user-icon img-circle img-responsive"
                                                name="<?= $obj['user_name']; ?>"
                                                color="<?= $obj['initials_color']; ?>" width="35"
                                                height="35"
                                                font="20px"></canvas>
                                    <?php } ?>
                                <?php } else { ?>
                                    <img src="<?= Url::to('/assets/common/images/user1.png'); ?>">
                                <?php } ?>
                            </div>
                            <div class="user-topic">
                                <div class="topic-name"><a href="<?= $link ?>"><?= $obj['name'] ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="sharing-links" id="share">
                            <i class="fa fa-share-alt"></i>
                            <div class="set">
                                <div class="fb">
                                    <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                                       target="blank">
                                        <span><i class="fab fa-facebook-f"></i></span></a>
                                </div>
                                <div class="tw">
                                    <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                       target="blank">
                                        <span><i class="fab fa-twitter"></i></span></a>
                                </div>
                                <div class="male">
                                    <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                       target="blank">
                                        <span><i class="fab fa-linkedin"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="box-content">
                            <?= $obj['question']; ?>
                        </div>
                        <div class="t-answers">
                            <span class="answers"><a href="<?= $link ?>" target="_blank"><?= sizeof($obj['questionsPoolAnswers']); ?><answers> Answers</answers></a></span>
                            <div class="best-answers">
                                <?php if (!empty($obj['questionsPoolAnswers'])): ?>
                                    <span class="best-images">
                                          <?php foreach ($obj['questionsPoolAnswers'] as $o) { ?>
                                              <a href="<?= Url::to($o['username'],true); ?>" data-toggle="tooltip"
                                                 title="<?= $o['name'] ?>">
                                            <?php if ($o['image']) { ?>
                                                <img src="<?= $o['image']; ?>" alt="<?= $o['name']; ?>"/>
                                            <?php } else { ?>
                                                <canvas class="user-icon img-circle img-responsive"
                                                        name="<?= $o['name']; ?>"
                                                        color="<?= $o['initials_color']; ?>" width="20" height="20"
                                                        font="10px"></canvas>
                                            <?php } ?>
                                        </a>
                                          <?php } ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
</div>