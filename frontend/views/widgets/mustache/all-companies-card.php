<script id="all-companies-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="com-box">
            <a href="{{slug}}">
                <div class="com-icon">
                    <div class="icon">
                        {{#logo}}
                        <a href="/{{slug}}">
                            <img src="{{logo}}">
                        </a>
                        {{/logo}}
                        {{^logo}}
                        <a href="/{{slug}}">
                            <canvas class="user-icon" name="{{name}}" width="100" height="100"
                                    color="{{color}}" font="35px"></canvas>
                        </a>
                        {{/logo}}
                    </div>
<!--                    <div class="follow"><button><i class="fa fa-heart-o"></i> </button></div>-->
                    {{#is_featured}}
                     <div class="featured">Featured</div>
                    {{/is_featured}}
                </div>
                <div class="com-det">
                    <div class="com-name">{{name}}</div>
                    <div class="com-cate">{{category}} </div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
.com-box{
    border:1px solid #eee;
    border-radius:5px;
    margin-bottom:20px;
}
.com-icon{
   position:relative;
   height:200px
}
.icon{
    position:absolute;
    max-height:150px;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
.icon img{
    width:150px;
    max-height:125px;
    object-fit:contain;
}
.follow{
    position:absolute;
    bottom:5px;
    right:10px;    
}
.follow button{
    margin-top:5px;  
    background:transparent;
    border:none;
    color:#ddd;
}
.follow button i{
    font-size:20px;
}
.follow button:hover{
    color:#00a0e3;    
}
.com-det{
    border-top:1px solid #eee;
    padding:10px 15px 20px;
    position:relative;
}
.com-name{
    font-size:20px;
    color:#525252;
}
.featured{
    background:#00a0e3;
    padding:5px 15px;
    position:absolute;
    top:15px;
    left:0;
    border-radius:0 5px 5px 0;
    color:#fff;
}
.com-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.1);
    transition:.2s ease-in;
}
.com-box:hover .com-name{
    color:#00a0e3;
    transition:.2s ease-in;
}

');