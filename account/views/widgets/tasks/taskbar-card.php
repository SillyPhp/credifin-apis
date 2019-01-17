<?php

use yii\helpers\Url;
?>

<section class="card card-transparent">
    <div class="card-body">
        <section class="card card-group">
            <header class="card-header bg-primary">
                <div class="widget-profile-info">
                    <div class="profile-picture">
                        <?php
                        $name = $image = $link = NULL;
                        if (!empty(Yii::$app->user->identity->organization)) {
                            if (Yii::$app->user->identity->organization->logo) {
                                $image = Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
                            }
                            $name = Yii::$app->user->identity->organization->name;
                            $color = Yii::$app->user->identity->organization->initials_color;
                            $link = Url::to('/company/' . Yii::$app->user->identity->organization->slug);
                        } else {
                            if (Yii::$app->user->identity->image) {
                                $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
                            }
                            $name = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
                            $color = Yii::$app->user->identity->initials_color;
                            $link = Url::to('/user/' . Yii::$app->user->identity->username);
                        }

                        if (empty($image)) :
                            ?>
                            <canvas class="user-icon" name="<?= $name; ?>" color="<?= $color; ?>" width="100" height="100" font="40px"></canvas>
                        <?php else: ?>
                            <img src="<?= Url::to($image); ?>" title="<?= $name; ?>" alt="<?= $name; ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="profile-info">
                        <h4 class="name font-weight-semibold"><?= $name; ?></h4>
                        <div class="profile-footer">
                            <a href="<?= $link; ?>">(<?= Yii::t('account', 'Edit Profile'); ?>)</a>
                        </div>
                    </div>
                </div>
            </header>
            <div id="accordion" class="task_sec w-100">
                <div class="card card-accordion card-accordion-first">
                    <div class="card-header border-bottom-0">
                        <h4 class="card-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
                                <i class="fa fa-check mr-1"></i> Tasks
                            </a>
                        </h4>
                    </div>
                    <div id="collapse1One" class="accordion-body collapse show">
                        <div class="card-body padding-0" style="text-align:center">
                            <form id="task-form" method="post" action="<?= Url::to('/account/tasks/create'); ?>" class="form-horizontal form-bordered">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-3">
                                            <input type="text" name="task" class="form-control">
                                            <div class="input-group-btn">
                                                <input type="submit" class="btn btn-primary" tabindex="-1" value="Add">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <ul class="widget-todo-list" data-url="<?= Url::to('/account/tasks'); ?>"></ul>
                            <i class="fa fa-spinner fa-spin" id="spin-attr"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<?php
$this->registerCss("
.card {
    background: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.card-body {
    background: #fdfdfd;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
}
.mb-3{
    margin-bottom: 1rem !important;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-clip: border-box;
    border-radius: 0.25rem;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
}
html .card-transparent > .card-header {
    background: none;
    border: 0;
    padding-left: 0;
    padding-right: 0;
}
.card-header {
    border-radius: 5px 5px 0 0 !important;
    padding: 18px;
    background-color: #e7eaed !important;
    padding-left: 18px !important;
    position: relative;
}
.card-title {
    color: #33353F;
    font-size: 20px;
    font-weight: 400;
    line-height: 20px;
    padding: 0;
    text-transform: none;
    margin: 0;
}
html .card-transparent > .card-header + .card-body {
    border-radius: 5px;
}
html .card-transparent > .card-body {
    padding: 0;
    background: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.card-header.bg-primary {
    background: #CCC;
    color: #FFF;
    border-bottom: 0 none;
    border-right: 0 none;
}
html .bg-primary, html .background-color-primary {
    background-color: #0088CC !important;
}
#spin-attr{
    font-size:24px; 
    padding : 15px;
}
.accordion-toggle{
    color:#00A0E3;
}
ul.widget-todo-list {
    list-style: none;
    padding: 0 20px 20px 20px;
    margin: 0;
    position: relative;
    max-height: 600px;
    min-height:205px;
    display: block;
    overflow-x: scroll;
}
ul.widget-todo-list li {
    border-bottom: 1px dotted #ddd;
    padding: 15px 15px 15px 0;
    position: relative;
}
ul.widget-todo-list li .checkbox-custom {
    margin-bottom: 0;
}
.checkbox-custom {
    position: relative;
    padding: 0 0 0 25px;
    margin-top: 0;
}
.checkbox-custom input[type='checkbox'] {
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 3px;
    margin: -6px 0 0 0;
    z-index: 2;
    cursor: pointer;
}
ul.widget-todo-list li .checkbox-custom label {
    padding-left: 10px;
}
.checkbox-custom label {
    cursor: pointer;
    margin-bottom: 0;
    text-align: left;
    line-height: 1.5;
}
.checkbox-custom label:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    margin-top: -9px;
    width: 19px;
    height: 18px;
    display: inline-block;
    border-radius: 2px;
    border: 1px solid #bbb;
    background: #fff;
}
.checkbox-custom input[type='checkbox']:checked + label:after {
    position: absolute;
    display: inline-block;
    font-family: 'FontAwesome';
    content: '\F00C';
    top: 50%;
    left: 4px;
    margin-top: -5px;
    font-size: 11px;
    line-height: 1;
    width: 16px;
    height: 16px;
    color: #333;
}
ul.widget-todo-list li label.line-through span {
    text-decoration: line-through;
}
.line-pass{
    text-decoration: line-through;
}
ul.widget-todo-list li .todo-actions {
    position: absolute;
    top: 14px;
    right: 0;
    bottom: 14px;
}
ul.widget-todo-list li .todo-actions .todo-remove {
    font-size: 10px;
    vertical-align: middle;
    color: #999;
}
.widget-profile-info .profile-picture {
    display: table-cell;
    vertical-align: middle;
    width: 1%;
}
.widget-profile-info .profile-picture img, .widget-profile-info .profile-picture canvas {
    display: block;
    width: 100px;
    height: 100px;
    margin-right: 15px;
    border: 4px solid #fff;
    border-radius: 50px;
}
.widget-profile-info .profile-picture img{
    background-color:#fff;
}
.font-weight-semibold {
    font-weight: 600 !important;
}
.widget-profile-info .profile-info .profile-footer {
    border-top-color: rgba(0, 170, 255, 0.7);
}
.widget-profile-info .profile-info .profile-footer {
    padding: 5px 0 0;
    border-top: 1px solid rgba(255, 255, 255, 0.6);
    text-align: right;
}
.widget-profile-info .profile-info .profile-footer a {
    color: #fff;
    opacity: 0.6;
}
.card-header {
    margin-bottom: 0;
    background-color: rgba(0, 0, 0, 0.03);
}
.widget-profile-info .profile-info {
    display: table-cell;
    vertical-align: bottom;
    width: 100%;
    color: #FFF;
}
.card {
    background: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: none;
}
.padding-0{
    padding-left:0px;
    padding-right:0px;
}
#collapse1One .card-body .form-horizontal .form-group{
    margin-bottom:0px;
}
.card-header border-bottom-0 {
    min-height: 3000px;
}
.ps__rail-x{
    display:none !important;
}
");
$script = <<< JS
    var ps = new PerfectScrollbar('.widget-todo-list');
    var page = 0;
    var action = 1;
    var todo_template = $('#todo-template').html();
    
    $(document).on('submit', '#task-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();
        var btn_submit = $("input[type=submit]", form);
        $.ajax({
            url: url,
            type: method,
            dataType: 'JSON',
            data: data,
            beforeSend: function () {
                btn_submit.prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 200) {
                    toastr.success(response.message, response.title);
                    btn_submit.prop('disabled', '');
                    $('.widget-todo-list').prepend(Mustache.render(todo_template, response.data));
                    form[0].reset();
                } else {
                    toastr.error(response.message, response.title);
                    btn_submit.prop('disabled', '');
                }
            },
            error: function (response) {
                btn_submit.prop('disabled', '');
            }
        });
    });
    
    $(document).on('click', '.todo-remove', function (e) {
        console.log('click');
        e.preventDefault();
            var id = $(this).parent().prev().children('input').attr('id');
            var remove = $(this).closest('li');
        $.ajax({
            url: "/account/tasks/remove",
            method: "POST",
            data: {id:id},
            success: function (response) {
                $(remove).remove();
            }
        });
    });
        
    $(document).on('keypress', '#task_input', function (e) {
        if (e.which == 13) {
            if ($(this).val() === '') {
                return false;
            } else {
                $("#add_task").trigger("click");
                return false;
            }
        }
    });

    $(document).on('change', '.list input', function () {
        if ($(this).hasClass('todo-check')) {
            $(this).closest('li').find('.todo-label').addClass('line-pass');
            $(this).removeClass('todo-check');
            $(this).addClass('uncheck');
        } else {
            $(this).closest('li').find('.todo-label').removeClass('line-pass');
            $(this).removeClass('uncheck');
            $(this).addClass('todo-check');
        }
    });
        
    load_list();
        
    $('.widget-todo-list').scroll(function () {
        var loadedListHeight = $(this)[0].scrollHeight;
        var listHeight = $('.widget-todo-list').height() + 30;
        if ($('.widget-todo-list').scrollTop() + listHeight > loadedListHeight && action === 0) {
            action = 1;
            setTimeout(function () {
                load_list();
                $('#spin-attr').hide(500);
            }, 100);
            $('#spin-attr').show();
        }
    });
        
    function load_list() {
        if (page <= 0) {
            page = 1;
        } else {
            page += 1;
        }
        var url = $('.widget-todo-list').attr('data-url');
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            data: {page: page},
            cache: false,
            beforeSend: function () {
                $('#spin-attr').show();
            },
            success: function (response) {
                $('#spin-attr').hide();
                console.log(response);
                if (response.status == 200) {
                    $('.widget-todo-list').append(Mustache.render(todo_template, response.tasks));
                    action = 1;
                } else {
                    action = 2;
                }
            }
        });
    }

JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://ciphertrick.com/demo/jquerysession/js/jquerysession.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('@vendorAssets/tutorials/js/intro.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/assets/themes/dashboard/tutorials/dashboard_tutorial.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);

//$options = [
//    'where' => ['and',
//        ['a.name' => 'taskbar_card'],
//        ['b.is_viewed' => 0],
//    ],
//];
//
//$tutorials = Yii::$app->Tutorials->getTutorialsByUser($options);
//echo "Hello";
//print_r($tutorials);

if (!Yii::$app->session->has("tutorial_organization_tasks")) {
    echo '<script>dashboard_organization_taskbar()</script>';
    Yii::$app->session->set("tutorial_organization_tasks", "Yes");
}
?>

<!--<script type="text/javascript">

    var limit = 7;
        var start = 0;
        var action = 'inactive';
        function load_list(start, limit)
        {
         $.ajax({
          url:"/account/dashboard",
          method:"POST",
          data:{limit:limit, start:start},
          cache:false,
          success:function(data){
            var a = data.tasks_list;
            var c = data.task_count;
            for(var i in a){
              var name = a[i].name;
              var id = a[i].task_id;
              var is_completed = a[i].is_completed;
              var test = (is_completed == 0)? "todo-check" : "uncheck";
              $('.widget-todo-list').append('<li class="list"><div class="checkbox-custom checkbox-default" style = "text-align:left;"><input type="checkbox"  id="' + id + '" class="'+test+'" ' + ((a[i].is_completed == 1) ? 'checked' : '') + '><label class="todo-label ' + ((a[i].is_completed == 1) ? 'line-pass' : '') + '" data-type="text">' + name + '</label></div><div class="todo-actions"><a class="todo-remove" href="#"><i class="fa fa-times"></i></a></div></li>');
                
              if(data == '')
              {
                action = 'active';
                  }
              else
              {
                action = 'inactive';
                  }
        
            }
          }
         });
        }


    $(document).on('click', '.todo-remove', function (e) {
        e.preventDefault();
        var id = $(this).parent().prev().children().attr('id');
        var remove = $(this).closest('li');
        $.ajax({
            url: "/account/todo",
            method: "POST",
            data: {
                id: id
            },
            success: function (response) {
                $(remove).remove();
            }
        });
    });

    $(document).on('click', '.todo-check', function () {
        var id = $(this).attr('id');
        if ($(this).is(':checked')) {
            $.ajax({
                url: "/account/todocomplete",
                method: "POST",
                data: {
                    id: id
                },
                success: function (response) {

                }
            });
        }
    });

    // function to complete the task
    $(document).on('click', '.uncheck', function () {
        var id = $(this).attr('id');
        if (id) {
            $.ajax({
                url: "/account/todoincomplete",
                method: "POST",
                data: {
                    id: id
                },
                success: function (response) {

                }
            });
        }
    });


    function load_list(page = 0) {
        if (page <= 0) {
            page = 1;
        }
        var url = $('.widget-todo-list').attr('data-url');
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            data: {page: page},
            cache: false,
            success: function (response) {
                if (response.status == 200) {
                    action = 'inactive';
                } else {
                    action = 'active';
                }
                var a = data.tasks_list;
                for (var i in a) {
                    var name = a[i].name;
                    var id = a[i].task_id;
                    var is_completed = a[i].is_completed;
                    var test = (is_completed == 0) ? "todo-check" : "uncheck";
                    $('.widget-todo-list').append('<li class="list"><div class="checkbox-custom checkbox-default" style = "text-align:left;"><input type="checkbox"  id="' + id + '" class="' + test + '" ' + ((a[i].is_completed == 1) ? 'checked' : '') + '><label class="todo-label ' + ((a[i].is_completed == 1) ? 'line-pass' : '') + '" data-type="text">' + name + '</label></div><div class="todo-actions"><a class="todo-remove" href="#"><i class="fa fa-times"></i></a></div></li>');
                    if (data == '') {
                        action = 'active';
                    } else {

                    }

                }
            }
        });
    }



    $(function () {
        var default_val;
        // make field editable
        $(document).on('dblclick', '.todo-label', function () {
            default_val = $(this).text();
            var name = $(this).text();
            if ($(this).prev('input:checkbox').prop("checked") != true) {
                $(this).html('<input type="text" class="edit_task" value="' + name + '" autofocus>');
                $('.widget-todo-list li').find('input:text:visible').focus();
            }
            return default_val;
        });
        // update task
        $(document).on('keypress', '.edit_task', function (a) {
            if (a.which == 13) {
                var name = $(this).val();
                var parent = $(this).parent();
                var edit_id = $(this).closest('label').prev().attr('id');
                if ($(this).val() == '') {
                    $('.edit_task').hide();
                    parent.text(default_val);
                } else {
                    $.ajax({
                        url: '/account/edittask',
                        method: 'POST',
                        data: {
                            name: name,
                            edit_id: edit_id
                        },
                        success: function (data) {
                            if (data == true) {
                                var dattaa = $('.edit_task').val();
                                $('.edit_task').hide();
                                parent.text(dattaa);
                            }
                        }
                    });
                }
            }
        });
        // focus out
        $(document).on('focusout', '.edit_task', function () {
            var parent = element.parent();
            var id = element.attr('id');
            id.hide();
            parent.text(default_val);
        });
    });
</script>-->


<script type="text/template" id="todo-template">
    {{#.}}
    <li>
        <div class="checkbox-custom checkbox-default" style="text-align:left;">
            <input type="checkbox" name="task" id="{{task_id}}{{id}}" class="{{#is_completed}}uncheck{{/is_completed}}{{^is_completed}}todo-check{{/is_completed}}" {{#is_completed}}checked{{/is_completed}} />
            <label class="todo-label {{#is_completed}}line-pass{{/is_completed}}" data-type="text">{{name}}</label>
        </div>
        <div class="todo-actions">
            <a class="todo-remove" href="#">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </li>
    {{/.}}
</script>
<!--<li>
    <div class="checkbox-custom checkbox-default" style="text-align:left;">
        <input type="checkbox" id="{{id}}" class="" {{#if}} ({{is_completed}} == 1) checked {{/if}} />
        <label class="todo-label {{#if}} ({{is_completed}} == 1) line-pass {{/if}}" data-type="text">{{name}}</label>
    </div>
    <div class="todo-actions">
        <a class="todo-remove" href="#">
            <i class="fa fa-times"></i>
        </a>
    </div>
</li>-->
<!--<script type="text/javascript">
    $(document).on('keypress', '#task_input', function (e) {
        if (e.which == 13) {
            if ($(this).val() == '')
            {
                return false;
            } else
            {
                $("#add_task").trigger("click");
                return false;
            }
        }
    });



    $(document).on('change', '.list input', function () {
        if ($(this).hasClass('todo-check')) {
            $(this).closest('li').find('.todo-label').addClass('line-pass');
            $(this).removeClass('todo-check');
            $(this).addClass('uncheck');
        } else {
            $(this).closest('li').find('.todo-label').removeClass('line-pass');
            $(this).removeClass('uncheck');
            $(this).addClass('todo-check');
        }
    });

    //ricky current working end   

    $(document).on('click', '.todo-remove', function (e) {
        e.preventDefault();
        var id = $(this).parent().prev().children().attr('id');
        var remove = $(this).closest('li');
        $.ajax({
            url: "/account/todo",
            method: "POST",
            data: {id: id},
            success: function (response) {
                $(remove).remove();
            }
        });
    });

    $(document).on('click', '.todo-check', function () {
        var id = $(this).attr('id');
//        console.log(id);
        if ($(this).is(':checked')) {
            $.ajax({
                url: "/account/todocomplete",
                method: "POST",
                data: {id: id},
                success: function (response) {

                }
            });
        }
    });

    $(document).on('click', '.uncheck', function () {
        var id = $(this).attr('id');
        if (id) {
            $.ajax({
                url: "/account/todoincomplete",
                method: "POST",
                data: {id: id},
                success: function (response) {

                }
            });
        }
    });



// onScroll end

//        Working onScrolling start

    var limit = 10;
    var start = 0;
    var action = 'inactive';
    function load_list(start, limit) {
        $.ajax({
            url: "/account/dashboard",
            method: "POST",
            data: {limit: limit, start: start},
            cache: false,
            success: function (data) {
                var a = data.tasks_list;
                var c = data.task_count;
                console.log(c);
                for (var i in a) {
                    var name = a[i].name;
                    var id = a[i].task_id;
                    var is_completed = a[i].is_completed;
                    var test = (is_completed === 0) ? "todo-check" : "uncheck";
                    $('.widget-todo-list').append('<li class="list"><div class="checkbox-custom checkbox-default" style = "text-align:left;"><input type="checkbox"  id="' + id + '" class="' + test + '" ' + ((a[i].is_completed == 1) ? 'checked' : '') + '><label class="todo-label ' + ((a[i].is_completed == 1) ? 'line-pass' : '') + '" data-type="text">' + name + '</label></div><div class="todo-actions"><a class="todo-remove" href="#"><i class="fa fa-times"></i></a></div></li>');
                    if (data === '') {
                        action = 1;
                    } else {
                        action = 2;
                    }
                }
            }
        });
    }

    if (action === 0) {
        action = 1;
        load_list();
        $('#spin-attr').show();
        $('#spin-attr').delay(1000).hide();
    }

    $('.widget-todo-list').scroll(function () {
        var loadedListHeight = $(this)[0].scrollHeight;
        var listHeight = $('.widget-todo-list').height() + 30;
        if ($('.widget-todo-list').scrollTop() + listHeight > loadedListHeight && action === 0) {
            action = 1;
            setTimeout(function () {
                load_list();
                $('#spin-attr').hide(500);
            }, 100);
            $('#spin-attr').show();
        }
    });

// onScroll end


    $(function () {
        var default_val;
        $(document).on('dblclick', '.todo-label', function () {
            default_val = $(this).text();
            var name = $(this).text();

            if ($(this).prev('input:checkbox').prop("checked") === true) {
                console.log('Completed task can not be edited or modified');
            } else {
                $(this).html('<input type="text" id="ricky" class="edit_task" value="' + name + '" autofocus>');
                $('.widget-todo-list li').find('input:text:visible').focus();
            }
            return default_val;
        });

        $(document).on('keypress', '.edit_task', function (a) {
            if (a.which === 13) {
                var name = $(this).val();
                var parent = $(this).parent();
                var edit_id = $(this).closest('label').prev().attr('id');
                if ($(this).val() === '') {
                    $('.edit_task').hide();
                    parent.text(default_val);
                } else {
                    $.ajax({
                        url: '/account/edittask',
                        method: 'POST',
                        data: {name: name, edit_id: edit_id},
                        success: function (data) {
                            if (data === true) {
                                var dattaa = $('.edit_task').val();
                                $('.edit_task').hide();
                                parent.text(dattaa);
                            }
                        }
                    });
                }
            }
        });

        $(document).on('focusout', '.edit_task', function () {
            $('#ricky').hide();
            parent.text(default_val);
        });
    });

    var ps = new PerfectScrollbar('.widget-todo-list');
</script>-->