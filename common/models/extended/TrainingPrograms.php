<?php

namespace common\models\extended;

use common\models\TrainingProgramApplication;

class TrainingPrograms extends TrainingProgramApplication {
    public function getTotalSeats() {
        return $this->getTrainingProgramBatches()->select(['application_enc_id', 'total' => 'sum(seats)'])->groupBy(['application_enc_id'])->asArray();
    }
}