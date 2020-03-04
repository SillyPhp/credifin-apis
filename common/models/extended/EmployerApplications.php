<?php

namespace common\models\extended;

class EmployerApplications extends \common\models\EmployerApplications {

    public function getPlacementLocations() {
        return $this->getApplicationPlacementLocations()->select(['application_enc_id', 'total' => 'sum(positions)'])->groupBy(['application_enc_id'])->asArray();
    }

    public function getLocations() {
        return $this->getApplicationPlacementLocations()->alias('aa')->select(['aa.application_enc_id','aa.location_enc_id','bb.city_enc_id','cc.name'])->innerJoinWith(["locationEnc bb" => function($b){$b->innerJoinWith(['cityEnc cc'],false);}],false)->asArray();
    }

}
