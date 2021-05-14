<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<section>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Followed Companies</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <?=
                        $this->render('/widgets/organization/card', [
                            'organization_data' => $shortlist_org,
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
