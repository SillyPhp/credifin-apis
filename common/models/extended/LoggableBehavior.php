<?php

namespace common\models\extended;

use common\models\extended\AuditTrail;

class LoggableBehavior extends \sammaye\audittrail\LoggableBehavior
{
    public $className = '';

    public function leaveTrail($action, $name = null, $value = null, $old_value = null)
    {
        if ($this->active) {
            $log = new AuditTrail();
            $log->model = $this->className;
            $log->old_value = $old_value;
            $log->new_value = $value;
            $log->action = $action;
            $log->model_id = (string) $this->getNormalizedPk();
            $log->field = $name;
            $log->stamp = $this->storeTimestamp ? time() : date($this->dateFormat); // If we are storing a timestamp lets get one else lets get the date
            $log->user_id = (string) $this->getUserId(); // Lets get the user id
            return $log->save();
        } else {
            return true;
        }
    }
}
