var xhr;

function getResult(q, url){
    if(xhr && xhr.readyState != 4){
        xhr.abort();
    }
    xhr = $.ajax({
        url: url + q,
        beforeSend: function(){
            $('.ss-spinner').show();
            $('.search_menu').hide();
        },
        success: function(data) {
            $('.search_menu').show();
            $('.ss-spinner').hide();
            $('.search_menu').html("");
            data = JSON.parse(data);
            for(var i=0;i<data.results.length;i++){
                $('.search_menu').append('<div class="ss-suggestion" id="' + data.results[i].id + '">' + data.results[i].title + '</div>');
            }
        }
    });
};

function initializeSearch(el, url){
    var html = $(el).get().map(function(v){return v.outerHTML}).join('');
    var pp = $(el).parent();
    $('<span class="search_init" style="position:relative;display:inline-block;"></span>').insertBefore(el);
    $(el).remove();
    pp.children('.search_init').append(html);
    pp.children('.search_init').append('<i class="ss-spinner fas fa-circle-notch fa-spin fa-fw" style="display:none;"></i>');
    pp.children('.search_init').append('<div class="search_menu"></div>');
    pp.children('.search_init').children(el).attr('autocomplete','off');
    pp.children('.search_init').children(el).keyup(function(e) {
        var getVal = $(this).val();
        if(getVal != "" && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40){
            getResult(getVal, url);
        }
    });
    pp.children('.search_init').children(el).blur(function() {
        $('.search_menu').hide();
    });
    pp.children('.search_init').children(el).focus(function() {
        showMenu($(this));
    });
    pp.children('.search_init').children(el).keydown(function(e) {
        switch(e.which) {
            case 13:
                e.preventDefault();
                previewCourse(el);
                break;

            case 38:
                selectPrev(el);
                break;

            case 40:
                selectNext(el);
                break;

            default: return;
        }
    });
}
function previewCourse() {
    if($('.ss-cursor').length != 0){
        var id = $('.ss-cursor').attr('id');
        window.location.replace('/courses/detail/' + id);
    } else{
        var val = $('#get-courses-list').val();
        window.location.replace('/courses/courses-list?keyword=' + val );
    }
}
function selectPrev(el) {
    var pSelected = true;
    $('.ss-suggestion').each(function() {
        if($(this).hasClass("ss-cursor")){
            pSelected = false;
            $(this).removeClass('ss-cursor');
            if($(this).prev()){
                $(el).val($(this).prev().text());
                $(this).prev().addClass('ss-cursor');
            }
            return false;
        }
    });
    if(pSelected){
        $(el).val($('.ss-suggestion:last-child').text());
        $('.ss-suggestion:last-child').addClass('ss-cursor');
    }
    scrollToSelected();
}
function selectNext(el) {
    var nSelected = true;
    $('.ss-suggestion').each(function() {
        if($(this).hasClass("ss-cursor")){
            nSelected = false;
            $(this).removeClass('ss-cursor');
            if($(this).next()){
                $(el).val($(this).next().text());
                $(this).next().addClass('ss-cursor');
            }
            return false;
        }
    });
    if(nSelected){
        $(el).val($('.ss-suggestion:first-child').text());
        $('.ss-suggestion:first-child').addClass('ss-cursor');
    }
    scrollToSelected();
}
function scrollToSelected() {
    $(".search_menu").scrollTop(0);
    if($('.ss-cursor').length != 0){
        $(".search_menu").scrollTop($('.ss-cursor:first').offset().top-$(".search_menu").height()-$('.search_menu').offset().top+$(".ss-cursor:first").height()+20);
    }
}
function showMenu(){
    if($('.search_menu').children().length != 0){
        $('.search_menu').show();
    }
}