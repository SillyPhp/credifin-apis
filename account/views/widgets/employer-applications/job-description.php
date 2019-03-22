<div class="module2-heading">Provide job description</div>
<div class="row padd-10">
    <div class="col-md-6">
        <div id="manual_questions">
            <div class="descrip_wrapper">
                <div class="load-suggestions Typeahead-spinner">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <input type="text" class="form-control" maxlength="150"
                       id="question_field"
                       placeholder="Type Custom Job Description And Press Enter.">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="manual_notes">
            Select from predefined job descriptions list
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div id="checkboxlistarea">
            <h3 id="heading_placeholder"> Please type Atleast 3 Job Description above or
                select from predefined list <i class="fa fa-share"
                                               aria-hidden="true"></i></h3>
            <ul class="drop-options connected-sortable droppable-area">

            </ul>
        </div>

    </div>
    <div class="col-md-6">
        <div class="md-checkbox-list" id="md-checkbox">
        </div>
        <div id="error-checkbox-msg"></div>
        <?= $form->field($model, 'checkboxArray', ['template' => '{input}'])->hiddenInput(['id' => 'checkbox_array']); ?>
    </div>
</div>
<input type="text" name="desc_count" id="desc_count" readonly>
<?php
$script = <<< JS
var quesn_count = 0;
function make_removable_jd()
{
    var jd_list = [];
    $.each($('.drop-options li'),function(index,value)
    {
    jd_list.push($.trim($(this).text()));
    });
    $('.drop-options').empty();
    quesn_count = 0;
    var i;
    for(i=0; i<jd_list.length; i++)
        {
            drop_options(id="",jd_list[i]);
        }
}
$(document).on('click','.drop-options span a', function(event){
		event.preventDefault();
                var btn = $(this);
                var tag = btn.closest("li").remove();
                quesn_count--
                quesn_upt();
	});
function drop_options(id,questions)
        {
            var duplicate_jd = [];
           $.each($('.drop-options li'),function(index,value)
                        {
                         duplicate_jd.push($.trim($(this).text()).toUpperCase());
                        });
           if(jQuery.inArray($.trim(questions).toUpperCase(), duplicate_jd) != -1) {
                return false;
                    } else {
                     $('#heading_placeholder').hide();$(".drop-options").append('<li  value-id="'+id+'" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' +questions+ '<span> <a href = "#" class = "remove_this_item"><i class="fa fa-times"></i></a></span> </li>');
                        scroll_checklist();
                        quesn_count++
                        quesn_upt();
                        // console.log(quesn_count);
                }
           $('#question_field').blur(function(){
                         $(this).val('');
                            });
        }
        $('#question_field').keypress(function(e){
        if(e.which == 13){
        
        questions  = $('#question_field').val();
        
        if(questions == "")
        {
         return false;
        }
        else{
             drop_options(id="",questions);
              $('#question_field').val("");
            }
        } 
    });
$('#md-checkbox').on('click', ':checkbox', function () {
            if ($(this).is(':checked')) {
                $('#heading_placeholder').hide();
                $(".drop-options").append('<li value-id="' + $(this).attr("id") + '" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' + $(this).closest("div").find("label").text() + '</li>');
                scroll_checklist();
                quesn_count++
               quesn_upt();
            } else if ($(this).is(':unchecked')) {
              $('.drop-options [value-id = "'+$(this).attr("id")+'"]').remove();
              quesn_count--
              quesn_upt();
            }
        });
function quesn_upt()
        {
             if(quesn_count <= 2)
               {
                 $('#desc_count').val("");
               }
           else
           {
           $('#desc_count').val("1");
          }
         }
function scroll_checklist() {
        $("#checkboxlistarea").animate({ scrollTop: $('#checkboxlistarea').prop("scrollHeight")}, 1000);
    }
 function job_desc_update(data)
{
    $.ajax({
      url:"/account/categories-list/job-description",
      data:{data:data},
      method:"post",
      success:function(response)
     {
     var obj = JSON.parse(response);
     var html = [];
     $.each(obj,function()
     { 
      html.push ("<div class=\'md-checkbox\'>"+
     "<input type=\'checkbox\' id=\'"+this.jd_id+"\' value = \'"+this.jd_id+"\' class=\'md-check\' name = \'checkbox[]\'>"+
     "<label for=\'"+this.jd_id+"\'>"+
     "<span></span>"+
     "<span class=\'check\'></span>"+
     "<span class=\'box\'></span>"+this.jd+"</label>"+
     "</div>");  
     });
     $("#md-checkbox").html(html); 
     }
     });
}  

var Descriptions = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('job_description'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/categories-list/description?q=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  }
});   
        
var que_type = $('#question_field').typeahead(null, {
  name: 'question_field',
  display: 'job_description',
   limit: 4,      
  source: Descriptions
}).on('typeahead:asyncrequest', function() {
    $('.descrip_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.descrip_wrapper .Typeahead-spinner').hide(); 
  }).on('typeahead:selected',function(e, datum)
  { 
      var id = datum.job_description_enc_id;
      var questions = datum.job_description;  
      drop_options(id,questions);
   });   
var ps = new PerfectScrollbar('#checkboxlistarea');
var ps = new PerfectScrollbar('#md-checkbox');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>