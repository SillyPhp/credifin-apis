<input type="hidden" id="parent_enc_id">
<div class="portlet light nd-shadow">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <i class=" icon-social-twitter font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Resume Bank</span>
        </div>
        <div class="actions">
            <div class="btn-group dashboard-button">
                <button title="" data-toggle="modal" data-target="#resumeBank" class="viewall-jobs">Add New</button>
            </div>
        </div>
    </div>

    <div class="portlet-body" id="resume-bank"></div>

</div>

<div id="resumeBank" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" id="profiles">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="submit" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Categories</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" id="text" placeholder="Search Here" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row padd10">
                    <?php foreach ($data as $p) { ?>
                        <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search search">
                            <input type="radio" data-id="<?= $p['category_enc_id']?>" class="category-input"/>
                            <label class="work-profile-box parent_category" data-id = "<?= $p['category_enc_id']?>">
                                <div class="work-profile">
                                    <p><?php echo $p['name'] ?></p>
                                </div>
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="modal-footer">
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

$script = <<<JS
$(document).ready(function(){
  $("#text").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".search").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).on('click', '.parent_category', function(){
        var data = {
            parent_id:$(this).attr('data-id'),
            type: 'Jobs'
        };
        $.ajax({
            type:"POST",
            url:"/account/resume/first",
            data: data,
            beforeSend:function(){
              $('#page-loading').fadeIn(1000);  
            },
            success:function (response) {
                $('#page-loading').fadeOut(1000);  
                var response = JSON.parse(response);
                $('#parent_enc_id').val(response.parent_enc_id);
                var template = $('#modal-two').html();
                var rendered = Mustache.render(template,response.second_modal_categories);
                $('#profiles').hide();
                $('#resumeBank').append(rendered);
                for(var i = 0; i< response.already_selected_categories.length; i++){
                    var chckbox = $("#"+response.already_selected_categories[i]["category_enc_id"]);
                    chckbox.attr("checked", true);
                }
            }
        });
    
});
showSelectedCategories();
function showSelectedCategories(){
    var data = {
            type: 'Jobs'
        };
    var div = document.getElementById('resume-bank');
    while(div.firstChild){
        div.removeChild(div.firstChild);
    }
    $.ajax({
        type: "POST",
        data: data,
        url: "/account/resume/final-data",
        success: function (response){
            var response = JSON.parse(response);
            var template = $("#selected-categories").html();
            var rendered = Mustache.render(template, response);
            $('#resume-bank').append(rendered);
        }
    })
}


$(document).on('click', '#save', function(e){
       e.preventDefault();
        var checks = document.getElementsByClassName('checks');
        var lengthh = document.getElementsByClassName('checks').length;
        var parent_id = $('#parent_enc_id').val();
        var check = [];

        for(var i=0;i<lengthh;i++){
            if(checks[i].checked === true){
                check.push(checks[i].value);
            }
        }
        
        if (check.length == 0){
            toastr.error('Please Select Job Title','Error');
        } 
        else {
            $.ajax({
            type:"POST",
            url:"/account/resume/save",
            data: {
                    checked:check,
                    parent_enc_id:parent_id,
                    type: 'Jobs'
                  },            
            success: function(response){
                if(JSON.parse(response)["status"] == 200){
                    toastr.success('Successfully Saved','Job Profile');
                    $('#resumeBank').modal('hide');
                    $('#titles').remove();
                    $('#profiles').show();
                    showSelectedCategories();
                } else {
                    toastr.error('Not Saved','Error');
                }
            }
        });
        }
        
        
        
    
});

$(document).on('click', '#previous, .close-modal', function(){
    $('#titles').remove();
    $('#profiles').show();
});

function addNew(){
      var new_to_add = document.getElementById('add_new').value;
      var parent_id = $('#parent_enc_id').val();
      if(new_to_add){
      $.ajax({
                type:"POST",
                url:"/account/resume/add",
                data: {
                        new_value:new_to_add,
                        parent_enc_id:parent_id,
                        type: 'Jobs'
                      },            
                success: function(response){
                    response = JSON.parse(response);
                    if(response.status == 201){
                     toastr.error("It can't be added",'Error');   
                    }
                    else{
                        document.getElementById('add_new').value = "";
                    $('#add_new').focus();
                    var template = $('#new-data').html();
                    var rendered = Mustache.render(template,response);
                    $('.cards-cont').append(rendered);
                    }
                    
                }
      });
      }else{
         toastr.error("please write something",'Error'); 
      }
}

$(document).on('click','#add_new_btn', function() {
    addNew();
});

$(document).on("keypress", "#add_new",function(event){
    if(event.which == '13'){
        addNew();
    }
});


JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
</script>
<script id="new-data" type="text/template">
    <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search">
        <input type="checkbox" id="{{category_enc_id}}" class="category-input checks" value="{{category_enc_id}}"/>
        <label for="{{category_enc_id}}" class="work-profile-box unique2">

        <div class="work-profile">
        {{name}}
    </div>

    </label>
    </div>
</script>
<script id="modal-two" type="text/template">
    <div class="modal-dialog" id="titles">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Job Title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group add_new_field">
                            <input type="text" id="add_new" placeholder="Add New Category" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="add_new_btn" class="btn btn-default">Add To The List</button>
                        </div>
                    </div>
                </div>
                <div class="row padd10 cards-cont">
                    {{#.}}
                    <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search">
                        <input type="checkbox" id="{{category_enc_id}}" class="category-input checks" value="{{category_enc_id}}"/>
                        <label for="{{category_enc_id}}" class="work-profile-box unique2">

                            <div class="work-profile">
                                {{name}}
                            </div>

                        </label>
                    </div>
                    {{/.}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="previous" class="btn btn-default">Back</button>
                <button id="save" type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</script>

<script id="selected-categories" type="text/template">


    <div class="tab-content">
        <div class="tab-pane active" id="tab_actions_pending">
            <!-- BEGIN: Actions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-actions" style="" >
                        <div class="row padd10">
                            {{#.}}
                            <div class="col-md-4 col-sm-6 padd-5">
                                <a href="/account/uploaded-resume/candidate-resumes?id={{assigned_category_enc_id}}&type=Jobs">
                                    <div class="work-profile-box">
                                        <div class="work-profile">
                                            {{name}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            {{/.}}
                        </div>
                        <div class="divider"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</script>
