<script id="categoryCard" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <a href="{{link}}">
            <div class="product-thumb">
                <div class="image">
                    <img src="{{thumb}}" class="img-responsive" alt="img" />
                </div>
                <div class="caption">
                    <h3>{{subCategory}}</h3>
                    <h4>{{topicName}}</h4>
                </div>
            </div>
        </a>
    </div>
    {{/.}}
</script>

<?php
$this->regiterCss('
a.product-thumb:hover{
 box-shadow:0 0 10px rgba(0,0,0,.5);
}
.product-thumb {
	margin-bottom:30px;
}
.product-thumb img{
	border-radius:4px 4px 0 0;
}
.product-thumb .caption{
	border:1px solid #E5E5E5;
	border-top:0;
	border-radius: 0 0px 4px 4px;
	background:#fff;
}
.product-thumb .caption h3{
	font-size:14px;
	font-weight:600;
	color:#686868;
	padding:15px 15px 28px;
	margin:0;
	line-height:16px;
}
.product-thumb .caption h3 .price, .product-thumb .caption h3 .text{
	color:#F4BD01;
	float:right;
	font-size:24px;
	font-weight:700;
}
.product-thumb .caption h3 .text{
	color:#2AB5F0;
}
.product-thumb .caption h4{
	font-size:18px;
	font-weight:600;
	color:#000;
	margin:0;
	padding:0 15px 30px;
}
.product-thumb .caption p{
	font-size:14px;
	font-weight:400;
	margin:0 13px 17px;
	color:#686868;
	display:none;
}
.product-thumb .caption ul{
	margin:0;
	border-top:1px solid #e5e5e5;
}
.product-thumb .caption ul li{
	border-right:1px solid #e5e5e5;
	padding:13px 13px;
}
.product-thumb .caption ul li:last-child{
	border-right:none;
}
.product-thumb .caption ul li a{
	font-size:14px;
	font-weight:600;
	margin:0;
	color:#b2b2b2;
}
.product-thumb .caption ul li i{
	margin-right:3px;
}
.product-thumb .caption ul li:last-child i{
	font-size:14px;
	color:#F4BD01;
}

');