<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Saved Candidates</span>
                </div>
            </div>

            <?php if ($savedApplicants['count'] > 0) { ?>
                <div class="portlet-body">
                    <div class="row">
                        <?= $this->render('/widgets/applications/saved-candidates', [
                            'savedApplicants' => $savedApplicants,
                            'type' => 'job'
                        ]); ?>
                    </div>
                </div>
            <?php } else { ?>
                <d4>Not Found</d4>
            <?php } ?>

        </div>
    </div>
</div>
<?php
$this->registerCss('
.cd-box-border {
    position: absolute;
    top: 172px;
    width: 80%;
    z-index: 111;
    box-shadow: 0px 5px 10px 0px rgb(0 0 0 / 20%);
}
');