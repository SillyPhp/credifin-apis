<div class="portlet light ">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <i class=" icon-social-twitter font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Resume Bank</span>
        </div>
        <div class="actions">
            <div class="btn-group dashboard-button">
                <button title="" data-toggle="modal" data-target="#resumeBank" class="viewall-jobs">Add New</button>
            </div>
            <div class="btn-group dashboard-button">
                <a href="/account/uploaded-resume/all-resume-profiles" title="" class="viewall-jobs">View All</a>
            </div>
        </div>
    </div>
    <div class="portlet-body" id="resume-bank">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_actions_pending">
                <!-- BEGIN: Actions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-actions" style="" >
                            <div class="row padd10">
                               <!-- <?php /*foreach ($data as $p) { */?>
                                    <div class="col-md-4 col-sm-6 padd-5">
                                        <a href="/account/uploaded-resume/candidate-resumes">
                                            <div class="work-profile-box">
                                                <div class="work-profile">
                                                    <?php /*echo $p['name'] */?> <span class="badge-num">1005</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    --><?php
/*                                }
                                */?>
                            </div>
                            <div class="divider"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="resumeBank" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="submit" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Categories</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" id="text" placeholder="Search Here Or Add New Category" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="add_new_btn" class="btn btn-default">Add To The List</button>
                        </div>
                    </div>
                </div>
                <div class="row padd10">
                    <?php foreach ($data as $p) { ?>
                        <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search">
                            <input type="radio" id="<?= $p['category_enc_id']?>" class="category-input" data-toggle="modal" data-target="#titleModal"/>
                            <label for="<?= $p['category_enc_id']?>" class="work-profile-box">
                                <div class="work-profile">
                                    <?php echo $p['name'] ?> <span class="badge-num">1005</span>
                                </div>
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="titleModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Job Title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" id="text" placeholder="Search Here Or Add New Category" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="add_new_btn" class="btn btn-default">Add To The List</button>
                        </div>
                    </div>
                </div>
                <div class="row padd10">
                   <!-- <?php /*foreach ($data as $p) { */?>
                        <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search">
                            <input type="checkbox" id="<?/*= $p['category_enc_id']*/?>" class="category-input"/>
                            <label for="<?/*= $p['category_enc_id']*/?>" class="work-profile-box">

                                <div class="work-profile">
                                    <?php /*echo $p['name'] */?> <span class="badge-num">1005</span>
                                </div>

                            </label>
                        </div>
                        --><?php
/*                    }
                    */?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php
$this->registerCss('
.work-profile-box{
    border: 2px solid #eef1f5;
    text-align:center;
    height:65px !important;
    display: table;
    width:100%;
    padding:0px 0 5px 0;
    position:relative;
    border-radius:12px !important;
    color:#000;
} 
.work-profile{
    display: table-cell;
    text-align: center;
    vertical-align: middle;
    padding:0 0px 0 0;
}
.work-profile-box span{
    background:#eee;
    padding:3px 8px;
    font-weight:bold;
    font-size:13px;
    border-radius:10px 0 10px 0px !important;
    position:absolute;
    bottom:0px;
    right:0px;
}
.work-profile-box:hover{
    background:#00a0e3;
    color:#fff;
    border:2px solid #00a0e3;
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.work-profile-box:hover span{
    background:#fff;
    color:#00a0e3;
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.padd10{
    padding-left:5px !important; 
    padding-right:5px !important; 
} 
.padd-5{
    padding-top:10px !important;
    padding-left:5px !important; 
    padding-right:5px !important; 
}
.category-input{
    display:none;
}
.category-input:checked + label{
    background: #00a0e3;
    color: #fff;
    border: 2px solid #00a0e3;
}
.category-input:checked + label div span{
    background: #fff;
    color: #00a0e3;
}
.dashboard-button button{
    border-color:transparent;
    height: 34px;
    line-height: 15px;
}
');