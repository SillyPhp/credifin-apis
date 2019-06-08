<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;

$this->title = Yii::t('frontend', 'Blog');

$data = [
    'title' => $this->title,
    'background' => '/assets/images/bg/blog.png',
];
echo $this->render('/widgets/breadcrumbs', [
    'data' => $data,
]);

$this->registerCssFile('https://fonts.googleapis.com/css?family=Lobster');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Crimson+Text');
?>
<div class="myfade1"></div>
<div class="imgmain-div"><img class="imgmain"/></div>
<ul class="styled-icons icon-bordered icon-md mb-5 lightbox-ul">
    <li><a link='https://www.facebook.com/sharer/sharer.php?u=' target="_blank" class="overfb"><i class="fa fa-facebook"></i></a></li>
    <li><a link='https://twitter.com/home?status=' target="_blank" class="overtw"><i class="fa fa-twitter"></i></a></li>
    <li><a link='https://plus.google.com/share?url=' target="_blank" class="overgp"><i class="fa fa-google-plus"></i></a></li>
    <li><a href link="https://www.pinterest.com/pin/create/button/?url={link}&media={image}&description={title}" target="_blank" class="overpt"><i class="fa fa-pinterest"></i></a></li>
    <li><a target="_blank" class="overdw" download><i class="fa fa-download"></i></a></li>
</ul>
<div id="posts"></div>
<div id="loading" class="text-center mb-20">
    <img src="<?= Url::to('/assets/images/preloaders/8.gif'); ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>…" />
</div> 
<section class="blog-mirror">
    <div class="my-container">
        <div class="container pt-20 pb-5">
            <hr style="color: #ff704d;width: 50px;margin-left: 5px; border-top:3px solid #ff704d;margin-bottom: 0px;"/>
            <h3 style="font-family:lobster;font-size:28pt;color:#FFF;margin-top:3px;"><?= Yii::t('frontend', 'Food Of Thoughts'); ?></h3>
            <div class="row">
                <div class="col-md-12">
                    <article class="post clearfix">
                        <div class="entry-header">
                            <div class="post-thumb">
                                <div id="slider1" class="owl-carousel-4col" data-nav="true">
                                    <?php
                                    foreach ($quotes as $post) {
                                        $path = Yii::$app->params->upload_directories->posts->featured_image.$post['featured_image_location'];
                                        $image = $path . DIRECTORY_SEPARATOR . $post['featured_image'];
                                        if (!file_exists($image_path)) {
                                            $image = '//placehold.it/320x200';
                                        }
                                        ?>
                                        <div class="zoom">
                                            <img class="imgsdds" src="<?= Url::to($image); ?>" width="570" height="133" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['featured_image_title']; ?>" url="<?= Yii::$app->urlManager->createAbsoluteUrl('/blog/' . $post['slug']); ?>">
                                            <div class="carousel-content">
                                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>"></a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div> 
        </div>
    </div>
</section>

<?php
$this->registerCss('
.myfade1{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.8;
    display:none;
    z-index: 2000;
}
.imgmain{
    width:100%;
    height:100%;
    display:none;
}
.imgmain-div{
    width:60%;
    height:80%;
    top:10%;
    left:20%;
    display: none;
    position: fixed;
    z-index: 2000;
}
@media(min-width : 1500px) {
    .imgmain-div{
        width: 50%;
        height: 70%;
        top:15%;
        left:25%;
    }
}
.lightbox-ul{
    display: none;
    float:right;
    position: fixed;
    right:10%;
    width:50px !important;
    top:20%;
    z-index: 2000;
}
.lightbox-ul li a{
    border-radius: 25px !important;
}
.lightbox-ul li a{
    clear: both !important;
    color:white;
}
@media only screen and (min-width:2000px){
    .lightbox-ul{
        right:18%;
        width:64px !important;
    }
    .lightbox-ul li a{
        border-radius: 35px !important;
    }
    .styled-icons.icon-md a {
        font-size: 34px;
        height: 60px;
        line-height: 60px;
        width: 60px;
    }
}
.imgsdds{
    cursor:pointer !important;
}
.zoom {
    transition: transform .4s;
    width: 253px;
    height: 320px;
    margin: 0 auto;
    padding: 50px;
    top:-10px;
    left:-10px;
    transition-timing-function: linear;
    z-index:300;
}
.zoom img{
    width:150px;
    height:200px;
    z-index:-500;
    position:absolute;
}
.zoom:hover{
    -ms-transform: scale(2.0,2.0); /* IE 9 */
    -webkit-transform: scale(2.0,2.0); /* Safari 3-8 */
    transform: scale(2.0,2.0); 
    top:-20%;
    left:0;
    position: absolute;
    z-index: 999;
}
.c_content{
    left:44%;
}
.tag {
    background-color: #e0e0eb;
    border-left: 6px solid  #33334d;
}
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid  #ff704d;
    margin: 1em 0;
    padding: 0; 
}
.caption{
    background-color: #e0e0eb;
    border-left: 6px solid  #33334d;
}
#slider1 .owl-stage-outer{
    overflow: visible !important;
    z-index: 1000;
}
.owl-controls{
    display: none !important;
}
@media only screen and (max-width: 640px) {
    body {
        excerpt:20%;
    }
    img {
        width:40%;
    }
}
.overdw:hover{
    background-color:#1c99e9 !important;
    color:white;
    border:0px !important;
}
#slider1 {
    margin-bottom: 20px;
    margin-top: -40px;
}
#slider1 .owl-stage{
    margin-left: -56px !important;
}
.blog-mirror{
    background: linear-gradient(180deg, #2b2d32 60%, #fff 40%);
}
.my-container{
    max-width: 100%;
    overflow:hidden;
    display: block;
    margin: auto;
}');

$script = <<<JS
$(document).on('click', '.imgsdds', function () {
    var u = $(this).attr('url');
    var t = $(this).attr('alt');
    var image = $(location).attr('protocol') + '//' + $(location).attr('hostname') + $(this).attr('src');
    $('.lightbox-ul li a').each(function () {
        if ($(this).attr('class') != 'overpt' || $(this).attr('class') != 'overdw') {
            $(this).attr('href', $(this).attr('link') + u);
        }
    });

    $(function () {
        var link = $('.overpt').attr('link');
        $('.overdw').attr('href', image);
        $('.overpt').each(function () {
            this.href = this.href.replace('{link}', u);
            this.href = this.href.replace('{image}', image);
            this.href = this.href.replace('{title}', t);
        });
    });
});

$(function () {
    $('.imgsdds').click(function () {
        var c = $(this).attr('src');
        $('.imgmain').attr('src', c);
        $('.myfade1').fadeIn(500);
        $('.imgmain').fadeIn(1000);
        $('.imgmain-div').fadeIn(1000);
        $('.lightbox-ul').fadeIn(1000);

    });
    $('.myfade1').click(function () {
        var d = $(this).attr('src');
        $('.main').attr('src', d);
        $('.imgmain').fadeOut(1000);
        $('.myfade1').fadeOut(1000);
        $('.imgmain-div').fadeOut(1000);
        $('.lightbox-ul').fadeOut(1000);

    });

    $(document).bind('keydown', function (e) {
        if (e.which == 27) {
            var d = $(this).attr('src');
            $('.main').attr('src', d);
            $('.imgmain').fadeOut(1000);
            $('.myfade1').fadeOut(1000);
            $('.imgmain-div').fadeOut(1000);
            $('.lightbox-ul').fadeOut(1000);
        }
    });
});

$('.owl-carousel-4col').owlCarousel({
    loop: true,
    nav: true,
    pauseControls: true,
    margin: 20,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsiveClass: true,
    navText: [
        '<i class="fa fa-chevron-left"></i>',
        '<i class="fa fa-chevron-right"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        568: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        }
    }
});

$(document).on('click', '#side-preview-image, #side-preview-title, #side-preview-excerpt', function () {
    var parent_section = $(this).closest('section');
    var parent_divison = $(this).closest('#side-col-div');
    parent_section.find('#preview-image').attr('src', parent_divison.find('#side-preview-image').attr('src'));
    parent_section.find('#preview-title').html($(this).html());
    parent_section.find('#preview-title').attr('href', $(this).attr('url'));
    parent_section.find('#preview-excerpt').empty().append(parent_divison.find('#side-preview-excerpt').html());
    parent_section.find('#preview-link').attr('href', $(this).attr('url'));
    parent_section.find('#preview-date').html($(this).attr('date'));
    parent_section.find('#preview-month').html($(this).attr('date_my'));
});

var categories = [
    {
        name: 'Articles',
        slug: 'articles',
        color: '#289dcc'
    },
    {
        name: 'Infographics',
        slug: 'infographics',
        color: '#dd5a5a'
    }];
$.each(categories, function (key, category) {
    getPosts(category.name, category.slug, category.color);
});
function getPosts(category, slug, color) {
    $.ajax({
        url: '/blog/category-posts/' + slug,
        type: 'GET',
        beforeSend: function () {
            $('#loading').show();
        }
    })
    .done(function (data) {
        if (data.status == 200) {
            featured_post = data.posts.featured;
            var featured_post_date = new Date(featured_post.date);
            var fp_date = featured_post_date.getDate() < 10 ? '0' + featured_post_date.getDate().toString() : featured_post_date.getDate();
            var fp_my = featured_post_date.toLocaleString("en", {month: "short"}) + ', ' + featured_post_date.getFullYear();
            var section = '<section><div class="container mt-5 mb-10 pt-5 pb-10"><div class="row"><div class="col-md-12"><h3 class="widget-title" style="border-bottom-color: ' + color + '; padding-bottom: 0; border-bottom: 3px solid ' + color + ' "><span style="background-color: ' + color + '; border-bottom: 1px solid ' + color + '; padding: 2px 12px; color:#ffffff;">' + category + ' </span></h3></div></div><div class="row"><div class="col-sm-12 col-md-6 blog-pull-left" id="side-bar-preview"><div class="gallery-item"><article class="post clearfix mb-30 bg-lighter"><div class="entry-header"><div class="post-thumb thumb"><img src="' + featured_post.image + '" width="100%" height="390" id="preview-image" alt="' + featured_post.image_title + '" title="' + featured_post.image_alt + '"></div><div class="entry-date media-left text-center flip bg-theme-colored border-top-theme-color-2-3px pt-5 pr-15 pb-5 pl-15"><ul><li class="font-16 font-weight-600" id="preview-date">' + fp_date + '</li><li class="font-12 text-uppercase" id="preview-month">' + fp_my + '</li></ul></div></div><h4 class="entry-title text-white text-uppercase font-weight-600 m-0 mt-5"><a id="preview-title" href="' + featured_post.url + '">' + featured_post.title + '</a></h4><p class="mt-5"><span id="preview-excerpt">' + featured_post.excerpt + '</span><br><a class=" btn-primary btn-xs" id="preview-link" href="' + featured_post.url + '">Read More</a></p><div class="clearfix"></div></article></div></div><div class="col-sm-12 col-md-6 blog-pull-left">';
            $.each(data.posts.other, function (key, other_post) {
                var post_date = new Date(other_post.date);
                var p_date = post_date.getDate() < 10 ? '0' + post_date.getDate().toString() : post_date.getDate();
                var p_my = post_date.toLocaleString("en", {month: "short"}) + ', ' + post_date.getFullYear();
                section += '<div class="row mb-15" id="side-col-div"><div class="col-sm-4 col-md-4"><img data-frz-src="' + other_post.image + '" src="/assets/images/preloaders/8.gif" url="' + other_post.url + '" onload=lzld(this) onerror=lzld(this) width="200" height="100" id="side-preview-image" alt="' + other_post.image_alt + '" title="' + other_post.image_title + '"></div><div class="col-sm-8 col-md-8"><h5 class="entry-title text-white text-uppercase font-weight-600 m-0 mt-5"><a id="side-preview-title" url="' + other_post.url + '" date="' + p_date + '" date_my="' + p_my + '" href="javascript:;">' + other_post.title + '</a></h5><p id="side-preview-excerpt" url="' + other_post.url + '" class="mt-5">' + other_post.excerpt + '</p></div></div>';
            });
            section += '</div></div></div></section>';
            $("#posts").append(section);
        }
        $('#loading').hide();
    })
    .fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('server not responding...');
    });
}
JS;

$this->registerJs($script);
