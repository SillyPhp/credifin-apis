<script id="popularVideo" type="text/template">
    {{#.}}
    <div class="item">
        <div class="imgTitle">
            <a href="{{link}}" >
                <img src="{{thumb}}" alt=""/>
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="blogTitle">
            <a href="{{link}}">
                {{videoName}}
            </a>
        </div>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
#mixedSlider .MS-content .item {
  display: inline-block;
  width: 33.3333%;
  position: relative;
  vertical-align: top;
  overflow: hidden;
  height: 100%;
  white-space: normal;
  padding: 0 10px;
}
@media (max-width: 991px) {
  #mixedSlider .MS-content .item {
    width: 50%;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-content .item {
    width: 100%;
  }
}
#mixedSlider .MS-content .item .imgTitle a {
  position: relative;
}
#mixedSlider .MS-content .item .blogTitle  a{
  color: #252525;
  font-style:normal !important;
  background-color: rgba(255, 255, 255, 0.5);
  width: 100%;
  bottom: 0;
  font-weight: bold;
  padding: 10px 0 0 0;
  font-size: 16px;
  
}
#mixedSlider .MS-content .item .imgTitle img {
  height: auto;
  width: 100%;
}
#mixedSlider .MS-content .item p {
  font-size: 16px;
  margin: 0px 0px 0 5px;
text-align: left;
  padding-top: 0px !important;
}
#mixedSlider .MS-content .item a {
  margin: 0 0 0 0;
  font-size: 16px;
  font-style: italic;
  color: rgba(173, 0, 0, 0.82);
  font-weight: bold;
  transition: linear 0.1s;
}
#mixedSlider .MS-content .item a:hover {
  text-shadow: 0 0 1px grey; text-decoration: none;
}
')
?>