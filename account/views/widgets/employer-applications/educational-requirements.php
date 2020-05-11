<div class="module2-heading">Education, Experiences And Qualifications</div>
<div class="row padd-10">
    <div class="col-md-6">
        <div id="manual_questions">
            <div class="edu_wrapper">
                <div class="load-suggestions Typeahead-spinner">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <input type="text" class="form-control" maxlength="150" id="quali_field"
                       placeholder="Type custom educational requirements and press enter.">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="manual_notes">
            Select from predefined educational requirement list
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <div id="quali_listarea">
            <h3 id="heading_quali"> Please type the educational requirements above or
                select from predefined list <i class="fa fa-share"></i></h3>
            <ul class="quali_drop_options connected-sortable droppable-area">

            </ul>
        </div>

    </div>
    <div class="col-md-6">
        <div class="md-checkbox" id="quali_list">

        </div>
        <div id="error-edu-msg"></div>
        <?= $form->field($model, 'qualifications_arr', ['template' => '{input}'])->hiddenInput(['id' => 'qaulific_array']); ?>
    </div>
</div>
<input type="text" name="qualific_count" id="qualific_count" readonly>
<?php
$script = <<< JS
var count_edu = 0;
function make_removable_edu()
{
    var edu_list = [];
    $.each($('.quali_drop_options li'),function(index,value)
    {
    edu_list.push($.trim($(this).text()));
    });
    $('.quali_drop_options').empty();
    count_edu = 0;
    var i;
    for(i=0; i<edu_list.length; i++)
        {
            drop_edu(id="",edu_list[i]);
        }
}
function drop_edu(id,qualification)
        {
            duplicate_ed=[];
            $.each($('.quali_drop_options li'),function(index,value)
                        {
                         duplicate_ed.push($.trim($(this).text()).toUpperCase());
                        });
           if(jQuery.inArray($.trim(qualification).toUpperCase(), duplicate_ed) != -1) {
                return false;
                    } else {
                     $('#heading_quali').hide();$(".quali_drop_options").append('<li  value-id="'+id+'" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' +qualification+ '<span> <a href = "#" class = "remove_this_item"><i class="fa fa-times"></i></a></span> </li>');   
               scroll_qualifications();
              count_edu++;
              edu_counter_set();
                }
           $('#quali_field').blur(function(){
                         $(this).val('');
                            });
                          }
        $('#quali_field').keypress(function(e){
        if(e.which == 13){
        qualification  = $('#quali_field').val();
        if(qualification == "")
        {
         return false;
        }
        else{
              drop_edu(id="",qualification);
              $('#quali_field').val("");
            }
        } 
    });
if (doc_type=='Clone_Jobs'||doc_type=='Clone_Internships'||doc_type=='Edit_Jobs'||doc_type=='Edit_Internships') 
    {
        $.each($model->clone_edu,function(i,v) {
            drop_edu(id="",v);
        });
    }
$(document).on('click','.quali_drop_options span a', function(event){
		event.preventDefault();
                var btn = $(this);
                var tag = btn.closest("li").remove();
                count_edu--;
                edu_counter_set();
	});
$('#quali_list').on('click', ':checkbox', function () {
            if ($(this).is(':checked')) {
                $('#heading_quali').hide();
                $(".quali_drop_options").append('<li value-id="' + $(this).attr("id") + '" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' + $(this).closest("div").find("label").text() + '</li>');
                scroll_checklist();
               count_edu++;
              edu_counter_set();
            } else if ($(this).is(':unchecked')) {
              $('.quali_drop_options [value-id = "'+$(this).attr("id")+'"]').remove();
              count_edu--;
              edu_counter_set();
            }
        });
function edu_counter_set()
        {
             if(count_edu == 0)
               {
                 $('#qualific_count').val("");
               }
           else
           {
           $('#qualific_count').val("1");
          }
         }
   function scroll_qualifications() {
        $("#quali_listarea").animate({ scrollTop: $('#quali_listarea').prop("scrollHeight")}, 1000);
    }
 function educational_update(data)
   {
     $.ajax({
     url:"/account/categories-list/job-qualifications",
     data:{data:data},
     method:"post",
     success:function(data)
     {
      var obj = JSON.parse(data);
      var html = [];
     $.each(obj,function()
     {
     html.push ("<div class=\'md-checkbox\'>"+
     "<input type=\'checkbox\' id=\'"+this.e_id+"\' value = \'"+this.e_id+"\' class=\'md-check\' name = \'qualifications[]\'>"+
     "<label for=\'"+this.e_id+"\'>"+
     "<span></span>"+
     "<span class=\'check\'></span>"+
     "<span class=\'box\'></span>"+this.ed_req+"</label>"+
     "</div>");  
     });                                
     $("#quali_list").html(html); 
     }
     });
   }
var Education = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('educational_requirement'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/categories-list/educations?q=%QUERY', 
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  }
});   
        
var edu_type = $('#quali_field').typeahead(null, {
  name: 'quali_field',
  display: 'educational_requirement',
   limit: 4,      
  source: Education
}).on('typeahead:asyncrequest', function() {
    $('.edu_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.edu_wrapper .Typeahead-spinner').hide(); 
  }).on('typeahead:selected',function(e, datum)
  { 
      var id = datum.educational_requirement_enc_id;
      var qualification = datum.educational_requirement;  
      drop_edu(id,qualification);
      edu_type.typeahead('val','');  
   });     
var ps = new PerfectScrollbar('#quali_listarea');
var ps = new PerfectScrollbar('#quali_list');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>