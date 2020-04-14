<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
?>
<script>
    /**
     *
     *  Base64 encode / decode
     *  http://www.webtoolkit.info/
     *
     **/

    var Base64 = {

        // private property
        _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

        // public method for encoding
        encode : function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;

            input = Base64._utf8_encode(input);

            while (i < input.length) {

                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);

                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;

                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }

                output = output +
                    this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                    this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

            }

            return output;
        },

        // public method for decoding
        decode : function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;

            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

            while (i < input.length) {

                enc1 = this._keyStr.indexOf(input.charAt(i++));
                enc2 = this._keyStr.indexOf(input.charAt(i++));
                enc3 = this._keyStr.indexOf(input.charAt(i++));
                enc4 = this._keyStr.indexOf(input.charAt(i++));

                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;

                output = output + String.fromCharCode(chr1);

                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }

            }

            output = Base64._utf8_decode(output);

            return output;

        },

        // private method for UTF-8 encoding
        _utf8_encode : function (string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";

            for (var n = 0; n < string.length; n++) {

                var c = string.charCodeAt(n);

                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }

            }

            return utftext;
        },

        // private method for UTF-8 decoding
        _utf8_decode : function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;

            while ( i < utftext.length ) {

                c = utftext.charCodeAt(i);

                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                }
                else if((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i+1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                }
                else {
                    c2 = utftext.charCodeAt(i+1);
                    c3 = utftext.charCodeAt(i+2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }

            }

            return string;
        }

    }
</script>
    <section style="background: #061540;">
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="newlogoset">
                        <div class="main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/courses/coursescvr.png'); ?>" align="right"
                                 class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 topp-pad">
                    <div class="main-heading-set">
                        <div class="min-heading">Learn anything, anytime, anywhere</div>
                        <div class="jumbo-heading">Aquire and Find best courses from top institutes</div>
                        <div class="search-box1">
                            <form action="<?= Url::to('/courses/courses-list') ?>">
                                <input type="text" placeholder="Search" name="keyword" id="get-courses-list">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">Learning Hub Category</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate" id="categories"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-skills">
        <h3>Popular Categories</h3>
        <div class="container" id="popular-category"></div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">Courses</div>
            </div>
            <div class="row" id="card-main"></div>
        </div>
    </section>

    <script id="courses-categories" type="text/template">
        {{#.}}
        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
            <a href="/courses/courses-list?cat={{title}}">
                <div class="newset">
                    <div class="imag">
                        <img src="/assets/themes/ey/images/pages/learning-corner/othercategory.png" alt="{{title}}"/>
                    </div>
                    <div class="txt">{{title}}</div>
                </div>
            </a>
        </div>
        {{/.}}
    </script>
<?php
echo $this->render('/widgets/mustache/courses-card');
$this->registerCss('
/*---Categories css start---*/
.cat-padding{
    padding-top:20px;
}
.newset{
    text-align:center;
    max-width: 160px;
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
.imag{
    text-align: right;
}
.txt {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: -4px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
/*---Categories css end---*/
.topp-pad{
    margin-top: 80px !important;
}
.newlogoset{
    max-width:500px;
    margin: 0 auto;
    position:relative;
}
.main-img {
    position: relative;
    display: inline-block;
    z-index: 9;
    margin-bottom: 10px;
    margin-top:20px;
}
.main-heading-set {
    display: block;
    z-index: 9;
    position: relative;
    padding-top: 55px;
}
.min-heading {
    color: #fff;
    text-transform: uppercase;
    border-left: 3px solid #ff7803;
    padding-left: 10px;
    font-weight: 500;
    font-size: 11px;
    font-family: roboto;
    letter-spacing: 1px;
}
.jumbo-heading {
    font-size: 40px;
    font-weight: bold;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
}
.search-box1{
    max-width:500px;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
    width: calc(100% - 38px);
}
.search-box1 .search_init input{
    width: 100%;
}
.search_init{
    width: calc(100% - 38px);
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    width:38px;
    padding: 9px 10px;
    background: #fff;
    font-size: 18px;
    border-radius:0 10px 10px 0;
    border: none;
    cursor: pointer;
}
.search-box1 button:hover {
    color: #ff7803; 
}
.newlogoset img{
    width:100%;
    height:100%;
}
.pro-box{
    border:1px solid #eee;
    text-align:center;
    box-shadow: 0px 0px 8px 0px #eee;
    margin-bottom: 20px;
    background: #fff;
    transition: all 250ms ease-out, transform 250ms ease-out, -webkit-transform 250ms ease-out;
    border-radius: 4px;
    cursor: pointer;
}
.pro-box:hover{
    transform: translate3d(0, -3px, 0);
    box-shadow: 0px 7px 13px rgba(0, 0, 0, 0.14);
}
.pro-logo{
    width: 100px;
    margin: 0 auto;
    margin-top: 20px;
    height: 100px;
    line-height: 100px;
    text-align: center;
}
.pro-logo img{
    width: auto;
    height: auto;
    max-height: 100px;
    max-width: 100px;
}
.pro-name{
    text-transform:capitalize;
    text-align: center;
    padding: 5px 5px 5px 5px;
    font-size: 16px;
    font-weight: 500;
    font-family: roboto;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 65px;
}
.set-padding-col{
    padding:0px 3px !important;
}
.popular-skills {
    padding: 20px 20px 40px 20px;
    background-image: linear-gradient(98deg, #ba0803, #c2582b);
    margin-top:30px;
}
.popular-skills h3 {
    color:#ef9f89;
    font-size: 29px;
    text-align: center;
}
.popular-skills .popular-cards {
    text-align: center;
    display: inline-block;
    width: 23.6%;
    margin: 5px;
}
.popular-skills .popular-cards a {
    color: white;
    display: block;
    padding: 15px;
    background: #ffffff36;
    text-align: left;
    transition: all 0.3s ease;
}
@media screen and (max-width: 768px){
    .popular-skills .popular-cards a {
        font-size: 11px;
        padding: 12px 9px;
    }
    .popular-skills .popular-cards {
        width: 48%;
        margin: 1px;
    }
    .topp-pad{
        margin-top: 10px !important;
    }
    .jumbo-heading {
        font-size: 28px;
    }
}
@media screen and (max-width: 456px){
    .popular-skills {
        padding: 18px 3px;
        text-align: center;
    }
    .set-padding-col {
        padding: 0px 10px !important;
    }
    .jumbo-heading {
        font-size: 25px;
    }
    .topp-pad{
        margin-top: 10px !important;
    }
    .main-heading-set{
        padding:0px 0px 20px 0px !important;
    }
}
');
$script = <<<JS
browse = {
    navigation_categories:[{"type":"category","icon_name":"development","title":"Development","id":288,"absolute_url":"/courses/development/","title_cleaned":"development","slug":"development"},{"type":"category","icon_name":"business","title":"Business","id":268,"absolute_url":"/courses/business/","title_cleaned":"business","slug":"business"},{"type":"category","icon_name":"finance","title":"Finance & Accounting","id":328,"absolute_url":"/courses/finance-and-accounting/","title_cleaned":"finance-and-accounting","slug":"finance"},{"type":"category","icon_name":"it-and-software","title":"IT & Software","id":294,"absolute_url":"/courses/it-and-software/","title_cleaned":"it-and-software","slug":"it-and-software"},{"type":"category","icon_name":"office-productivity","title":"Office Productivity","id":292,"absolute_url":"/courses/office-productivity/","title_cleaned":"office-productivity","slug":"office-productivity"},{"type":"category","icon_name":"personal-development","title":"Personal Development","id":296,"absolute_url":"/courses/personal-development/","title_cleaned":"personal-development","slug":"personal-development"},{"type":"category","icon_name":"design","title":"Design","id":269,"absolute_url":"/courses/design/","title_cleaned":"design","slug":"design"},{"type":"category","icon_name":"marketing","title":"Marketing","id":290,"absolute_url":"/courses/marketing/","title_cleaned":"marketing","slug":"marketing"},{"type":"category","icon_name":"lifestyle","title":"Lifestyle","id":274,"absolute_url":"/courses/lifestyle/","title_cleaned":"lifestyle","slug":"lifestyle"},{"type":"category","icon_name":"photography","title":"Photography","id":273,"absolute_url":"/courses/photography/","title_cleaned":"photography","slug":"photography"},{"type":"category","icon_name":"health-and-fitness","title":"Health & Fitness","id":276,"absolute_url":"/courses/health-and-fitness/","title_cleaned":"health-and-fitness","slug":"health-and-fitness"},{"type":"category","icon_name":"music","title":"Music","id":278,"absolute_url":"/courses/music/","title_cleaned":"music","slug":"music"},{"type":"category","icon_name":"academics","title":"Teaching & Academics","id":300,"absolute_url":"/courses/teaching-and-academics/","title_cleaned":"teaching-and-academics","slug":"academics"}]
};
var i_list = [];
var count_list = 8;
for(var a=0;a<count_list;a++){
    var index = Math.floor(Math.random() * browse.navigation_categories.length);
    var raw_html = '<div class="popular-cards"><a href="/courses/courses-list?cat=' + browse.navigation_categories[index].title + '">' + browse.navigation_categories[index].title + '</a></div>';
    if(!i_list.includes(index)){
        i_list.push(index);
        $('#popular-category').append(raw_html);
    } else{
        count_list++;
    }
}
var categories_template = $('#courses-categories').html();
$("#categories").html(Mustache.render(categories_template, browse.navigation_categories));
$.ajax({
    method: "POST",
    url : window.location.href,
    success: function(response) {
            response = JSON.parse(response);
        if(response.detail == "Not found.") {
            console.log('cards not found');
        } else{
            var template = $('#course-card').html();
            var rendered = Mustache.render(template,response.results);
            $('#card-main').append(rendered);
            $('.c-author').each(function() {
                var strVal = $.trim($(this).text());
                var lastChar = strVal.slice(-1);
                if (lastChar == ',') { // check last character is string
                    strVal = strVal.slice(0, -1); // trim last character
                    $(this).text(strVal);
                }
            });
        }
    }
});
initializeSearch('#get-courses-list', "/courses/search?q=");

function make_base_auth(user, password) {
  var tok = user + ':' + password;
  var hash = Base64.encode(tok);
  return "Basic " + hash;
}
var service_url = "https://www.udemy.com/api-2.0/courses/"
$.ajax({
    type: "GET",
    url: service_url,
    dataType: "json", 
    contentType: "text/plain",
    data: "page=1&page_size=6",
    processData: false,
    beforeSend : function(req) {
         req.setRequestHeader('Authorization', 
               make_base_auth ('sOC2x6AgLEJvPOk5Lqyq3hectqYhuIEQYk4ksLGk', 'Khwq8GuROULCfAoOe6cQjoYftoXMYgaCWsPoL1fKmVloubbSesQRsxSaWR6nu3E31U33PQLk8zqbH43x8td8GGFkIgRTxGNc4QjJKnUUjSSVWNol8B5shnGvD6pXXAp1'));
    },
    error: function(data) {   
         console.log(data);
    },
    success: function(xml) { console.log(xml); }
});
JS;
$this->registerJs($script);
$this->registerCssFile('/assets/themes/search/css/main.css');
$this->registerJsFile('/assets/themes/search/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
