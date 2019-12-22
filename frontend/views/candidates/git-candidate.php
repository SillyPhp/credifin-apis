<?php
$this->params['header_dark'] = true;

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <section>
        <div class="container">
            <div class="row">
                <?php
                foreach ($users as $u) {
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="cand-box">
                            <div class="cand-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                            </div>
                            <div class="cand-detail">
                                <h3><?= $u['first_name'] . ' ' . $u['last_name'] ?></h3>
                                <div class="cand-position"><?= (!empty($u['userWorkExperiences'][0]['company']) && !empty($u['userWorkExperiences'][0]['title']))?$u['userWorkExperiences'][0]['title'] . ' at ' . $u['userWorkExperiences'][0]['company'] : '' ?></div>
                                <div class="cand-skills">
                                    <ul>
                                        <?php
                                        for ($i = 0; $i < 3; $i++) {
                                            if (!empty($u['userSkills'][$i])) {
                                                ?>
                                                <li><?= $u['userSkills'][$i]['skill'] ?></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?= ($u['sk_count'] > 3) ? '+' . ($u['sk_count'] - 3) : '' ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="cand-location"><i class="fas fa-map-marker-alt"></i> <?= ($u['city_name'])?$u['city_name']:'' ?></div>
                            <div class="view-btn">
                                <a href="#">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.cand-box {
    border: 1px solid #eee;
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0px 0px 3px 0px #eee;
    transition: all 250ms ease-out, transform 250ms ease-out, -webkit-transform 250ms ease-out;
    cursor:pointer;
}
.cand-box:hover {
    box-shadow: 0px 7px 13px rgba(0, 0, 0, 0.14);
    transform: translate3d(0, -3px, 0);
}
.cand-img {
    height: 100px;
    width: 100px;
    margin: 0 auto;
    border-radius: 50px;
    border: 1px solid #ddd;
    overflow: hidden;
}
.cand-img img {
    height: auto;
    width: auto;
    border: 3px solid #fff;
    border-radius: 50px;
}
.cand-detail {
    height: 140px;
}
.cand-detail h3 {
    text-align: center;
    margin: 10px 0px 0px 0;
    font-family: roboto;
    text-transform: capitalize;
}
.cand-position {
    text-align: center;
    font-size: 14px;
    font-family: roboto;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cand-skills {
    text-align: center;
    margin: 5px 0px;
}
.cand-skills > ul > li {
    border: 1px solid #ddd;
    padding: 1px 10px;
    display: inline-block;
    border-radius: 15px;
    font-family: roboto;
    font-size: 13px;
    margin-right: 4px;
}
.cand-location {
    text-align: center;
    margin: 5px 0px;
    font-size:13px;
}
.view-btn {
    text-align: center;
    margin: 10px 0px 3px 0px;
}
.view-btn a {
    background-color: #fff;
    color:#00a0e3;
    padding: 4px 15px;
    border-radius: 3px;
    border: 1px solid #00a0e3;
    transition: ease-out 0.3s;
}
.view-btn a:hover {
    background-color:#00a0e3;
    color:#fff;
}
');
