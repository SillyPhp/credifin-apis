<?php
use yii\helpers\Url;
?>
<section class="upcoming-webinar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <div class="webinar-heading">
                    Upcoming Webinar
                </div>
            </div>
            <div class="col-sm-6">
                <div class="webinar-name">
                    <?= $upcomingWebinar['title'] ?>
                    <!--                                How to build long term wealth in Stock Market?-->
                </div>
            </div>
            <div class="col-sm-3">
                <div class="view-detail">
                    <a href="/webinar/<?= $upcomingWebinar['slug'] ?>" class="view-btn">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
  .upcoming-webinar{
        width: 100%;
        background: #1F1F1F;
        display: flex;
        position: relative;
        margin-top:-39px;
        // top: 0;
        z-index: 20;
      }
      .upcoming-webinar .container-fluid{
          padding-top: 0 !important;
          width: 100%;
      }
      .upcoming-webinar .row{
        display: flex;
      }
      .webinar-heading{
        text-transform: capitalize;
        font-family: lora;
        font-weight: 700;
        font-size: 22px;
        line-height: 28px;
        color: #FFDF39;
        display: flex;
        align-items: center;
        height: 100%;
      }
      .webinar-name{
        font-family: Lobster;
        font-style: normal;
        font-weight: normal;
        font-size: 22px;
        text-align: center;
        color: #FFFFFF;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        height: 100%;
        letter-spacing: 1.3px;
      }
      .view-btn{
        background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
        border-radius: 27px;
        color: #fff;
        padding: 2px 13px;
        display: block;
        margin-left: auto;
        width: fit-content;
        letter-spacing: 0.5px;
      }
      .view-detail{
        display: flex;
        align-items: center;
        height: 100%;
      }
      .view-btn:hover{
        text-decoration: none;
        color: #fff;
        opacity: 0.9;
      }
      
      @media only screen and (max-width: 767px){
          .webinar-heading{
              font-size: 19px;
          }
        .upcoming-webinar .row{
          display: block;
        }
        .webinar-name{
          background: none;
        }
        .upcoming-webinar{
          //background: url(' . Url::to('https://user-images.githubusercontent.com/72601463/133765334-22ac93c4-167b-4f7a-b145-11caa4175341.png') . '), #0e1c3d;
          background-repeat: no-repeat;
          background-size: 100% 100%;
          display: block;
          text-align: center;
        }
        .view-btn{
          margin: 10px auto;
        }
        .webinar-heading{
          justify-content: center;
        }
      }
');

