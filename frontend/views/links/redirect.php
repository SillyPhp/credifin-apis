<?php

use yii\helpers\Url;

$image = Url::to(Yii::$app->params->upload_directories->sharing_links->image . $link_data['image_location'] . '/' . $link_data["image"], true);
list($width, $height, $type, $attr) = getimagesize($image);
?>
<html>
<head>
    <meta property="og:title" content="<?= $link_data['title']; ?>"/>
    <meta property="og:description" content="<?= $link_data['description']; ?>"/>
    <meta property="og:image" content="<?= $image; ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="EmpowerYouth"/>
    <meta property="og:image:width" content="<?= $width; ?>"/>
    <meta property="og:image:height" content="<?= $height; ?>"/>
    <meta property="fb:app_id" content="973766889447403"/>
    <style>
        .message {
            position: absolute;
            margin-left: 25vw;
            margin-top: 42vh;
            width: 50vw;
        }
    </style>
</head>
<body>
<div class="Container">
    <input type="hidden" id="url" value="<?= $link_data["redirect_url"]; ?>" />
    <script>
        var url = document.getElementById("url");
        setTimeout(function () {
            window.location.href = removeTrailingSlash(url.value);
        }, 1000);

        function removeTrailingSlash(url) {
            return url.replace(/\/$/, '')
        }
    </script>
    <div class="message">
        <img width="100%" src="/assets/common/images/tagline.svg"/>
    </div>
</div>
</body>
</html>