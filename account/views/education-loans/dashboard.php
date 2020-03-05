<?php
use yii\helpers\Url;
?>
<div class="col-xs-12 col-sm-12">
    <div class="portlet light ">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase">Company Profiles</span>
            </div>
            <div class="actions">
                <div class="btn-group dashboard-button">
                    <a href="/account/hr/company" title="" class="viewall-jobs">View All</a>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_actions_pending">
                    <!-- BEGIN: Actions -->
                    <div class="row">
                        <div class="mt-actions " style="">
                            <div class="col-md-12">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>abc</th>
                                        <th>bcd</th>
                                        <th>cde</th>
                                        <th>def</th>
                                        <th>efg</th>
                                        <th>fgi</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}
')
?>