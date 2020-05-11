<script id="top-channel-card" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4 col-xs-12">
        <div class="tp-box">
            <div class="row">
                <a href="{{link}}">
                    <div class="col-md-5 col-sm-5 col-xs-5 padd-10">
                        <div class="tp-icon">
                            <img src="{{icon}}">
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7 no-padd">
                        <div class="tp-heading">{{channel_name}}</div>
                        <div class="tp-date">{{videos_count}}</div>
                        <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                    </div>
                </a>
            </div>
        </div>
    </div>
    {{/.}}
</script>

<?php
$this->registerCSS('
.tp-box{
    margin-bottom:10px;
}
.tp-box:hover .tp-icon img{
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 0.3;
}
.tp-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
    border-radius:5px; 
    position:relative; 
}
.tp-icon img{
    border-radius:5px; 
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;  
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
}
.tp-heading{
    font-weight:bold;
    color:#000;
}
.padd-10{
   padding-left:10px;
   padding-right:10px;
}
.no-padd{
    padding-right:0px;
    padding-left:0px;
}
');
?>