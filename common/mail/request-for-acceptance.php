<?php

use yii\helpers\Url; ?>


<p>you are requested to take interview for <?= $data['job']?> job.</p>

<p>send your confirmation</p>

<a href="<?= Url::to('/account/schedular/inerviewer-status?id='.$data['id']. '&type=accept','https')?>">Accept</a>
<a href="<?= Url::to('/account/schedular/inerviewer-status?id='.$data['id']. '&type=reject','https')?>">Reject</a>
