<script id="course-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-6">
        <a href="/courses/courses-detail?id={{id}}">
            <div class="course-box">
                <div class="course-upper">
                    <div class="course-logo">
                        <img src="{{image_240x135}}"/>
                    </div>
                    <div class="course-provider">udemy</div>
                    <div class="course-description">
                        <div class="course-name">{{title}}</div>
                        <!--                            <div class="course-duration"><i class="far fa-clock"></i>3 months</div>-->
                        <div class="course-fees"><i class="fas fa-rupee-sign"></i>{{price}}</div>
                        <!--                            <div class="course-start"><i class="far fa-calendar-check"></i>15/10/12</div>-->
                        <div class="course-start"><i class="far fa-user"></i>
                            <span class="c-author">
                                    {{#visible_instructors}}
                                        {{display_name}},
                                    {{/visible_instructors}}
                                </span>
                        </div>
                    </div>
                </div>
                <div class="course-skills">
                    <div class="skills-set">html</div>
                </div>
            </div>
        </a>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss('
.course-box {
    position: relative;
    box-shadow: 0 1px 3px 0px #797979;
    background-color:#fff;
    margin-bottom: 15px;
    border-radius: 5px;
    overflow: hidden;
    color:#000;
}
.course-upper{
    padding:5px 10px;
    display:flex;
}
.course-provider {
    position: absolute;
    text-align: center;
    text-transform: uppercase;
    right: 0;
    top: 0;
    color: #fff;
    padding: 4px 15px;
    background: #FF4500;
    font-size: 13px;
    font-weight: 500;
    font-family: roboto;
}
.course-logo {
    height: 80px;
    border-radius: 50%;
    box-shadow: 0px 2px 20px 1px #bbbbbb8c;
    width: 80px;
    margin-top: 25px;
    margin-bottom: 5px;
    overflow:hidden;
}
.course-logo img{
    width:100%;
    height:100%;
}
.course-description {
    display:inline-block;
    margin: 22px 10px 10px 23px;
    font-family:roboto;
    width: calc(100% - 115px);
}
.course-duration > i, .course-fees > i, .course-start > i{
    margin-right:5px;
}
.course-name{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform: capitalize;
    font-size: 20px;
    font-weight: 400;
}
.course-duration, .course-fees, .course-start {
    text-transform: capitalize;
    font-size: 15px;
    font-weight: 400;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.course-skills {
    border-top: 2px solid #eee;
    padding: 10px 15px;
}
.skills-set {
    background: #eee;
    border-radius: 3px 0 0 3px;
    color:#777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 0px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}

.skills-set::after {
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
');