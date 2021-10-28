<?php
use yii\helpers\Url;
?>
<div id="rejectConsiderModal" class="modal">
    <div class="modal-content">
        <div class="modal-body modal-jobs">
            <span class="close" onclick="closeModal()"><i class="fas fa-times"></i></span>
            <div class="row h100">
                <div class="col-md-12">
                    <p class="modalHeading">Select Job</p>
                </div>
                <form id="considerJobsModal">
                    <div id="showJobsCards">

                    </div>
                    <div class="col-md-12 text-center">
                        <button class="doneCloseModal">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('

');
$script = <<<JS

JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    var modal = document.getElementById("rejectConsiderModal");
    function closeModal() {
        modal.style.display = "none";
        bdy[0].classList.remove('modal-open');
    }
</script>
<script id="reject-job-card" type="text/template">
    {{#.}}
    <div class="col-md-3 col-sm-4">
        <div class="suggestJob">
        <input type="checkbox" value="{{job_title}}" name="suggested-jobs" id="{{application_enc_id}}">
        <label for="{{application_enc_id}}">
            <div class="jobCard">
                <div class="jc-icon">
                    <img src="<?= Url::to('@commonAssets/categories/{{icon}}'); ?>">
                </div>
                <div class="jc-details">
                    <h3>{{job_title}}</h3>
                    <p>
                        <?php
                        if ($app['applicationPlacementLocations']) {
                            foreach ($app['applicationPlacementLocations'] as $ps) {
                                $cnt += $ps['positions'];
                                if (count($arry) >= 3) {
                                    $more = true;
                                } else {
                                    array_push($arry, $ps['name']);
                                }
                            }
                            echo implode(', ', array_unique($arry));
                            echo $more ? ' and more' : ' ';
                        } else {
                            echo 'Work From Home';
                        }
                        ?></p>
                    <p><?= $cnt ?> Openings</p>
                </div>
            </div>
        </label>
        <a href="<?= Url::to('/job/{{slug}}') ?>" target="_blank">
            <div class="clickSelect">View Job</div>
        </a>
    </div>
    </div>
    {{/.}}
</script>

