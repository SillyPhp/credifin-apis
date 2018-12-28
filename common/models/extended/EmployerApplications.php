<?php

namespace common\models\extended;

class EmployerApplications extends \common\models\EmployerApplications {

    public function getPlacementLocations() {
        return $this->getApplicationPlacementLocations()->select(['application_enc_id', 'total' => 'sum(positions)'])->groupBy(['application_enc_id'])->asArray();
    }

}
