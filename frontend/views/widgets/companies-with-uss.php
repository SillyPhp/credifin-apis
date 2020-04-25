<?php
use yii\helpers\Url;
?>
<section class="companies">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="com-grid">
                    <h1 class="heading-style">Companies With Us</h1>
                    <div class="ac-subheading">Companies recruiting top talent from our portal.</div>
                    <div class="all-coms"><a href="/organizations">View All Companies</a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-4">
                <a href="/capitalbank" title="Capital Small Finance Bank">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/capital-small-finance.png') ?>" alt="Capital Small Finance Bank" title="Capital Small Finance Bank" />
                        </div>
                        <div class="cmp-name">Capital Small Finance Bank </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/midland" title="Midland MicroFin">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>" alt="Midland MicroFin" title="Midland MicroFin" />
                        </div>
                        <div class="cmp-name">Midland MicroFin</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/dsb" title="DSB Law Group">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/dsb.png') ?>" alt="DSB Law Group" title="DSB Law Group" />
                        </div>
                        <div class="cmp-name">DSB Law Group</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/citizensbank" title="Citizens Bank">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/citizen-bank.png') ?>" alt="Citizens Bank" title="Citizens Bank" />
                        </div>
                        <div class="cmp-name">Citizens Bank</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/agile" title="Agile Finserv">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/agile.png') ?>" alt="Agile Finserv" title="Agile Finserv" />
                        </div>
                        <div class="cmp-name">Agile Finserv</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/becre8v" title="Be Cre8v">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/be-creative.png') ?>" alt="Be Cre8v" title="Be Cre8v" />
                        </div>
                        <div class="cmp-name">Be Cre8v</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/amritmalwa" title="Amrit Malwa Capital Limited">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/amrit-malwa.png') ?>" alt="Amrit Malwa Capital Limited" title="Amrit Malwa Capital Limited" />
                        </div>
                        <div class="cmp-name">Amrit Malwa Capital Limited</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/hamco" title="Hamco Ispat">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>" alt="Hamco Ispat" title="Hamco Ispat" />
                        </div>
                        <div class="cmp-name">Hamco Ispat</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/upmoney" title="Up Money Ltd">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/up-money.png') ?>" alt="Up Money Ltd" title="Up Money Ltd" />
                        </div>
                        <div class="cmp-name">Up Money Ltd</div>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-4">
                <a href="/apurva" title="Code Nomad">
                    <div class="cmp-main">
                        <div class="cmp-log">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/codenomad.png') ?>" alt="Code Nomad" title="Code Nomad" />
                        </div>
                        <div class="cmp-name">Code Nomad</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<?php
$this->registercss('
.companies {
    background-color: #f5f5f5;
}
.ac-subheading{
    margin-top:-15px;
    font-family:Roboto;
    font-weight:400;
}
.all-coms a{
    color:#00a0e3;
}
.all-coms{
    font-family: roboto;
}
.all-coms a:hover{
    font-weight:500;
    font-family: roboto;
    margin-left:10px;
    transition:.3s ease;
}
.com-grid {
    margin-bottom: 20px;
}
.cmp-main {
    border: 2px solid transparent;
    text-align: center;
    padding: 15px;
    margin-bottom: 20px;
    background-color:#fff;
    border-radius: 5px;
    height: 147px !important;
    cursor: pointer;
    transition: all 0.3s;
}
.cmp-main:hover{
    box-shadow:0 0 15px 10px #eee; 
}
.cmp-log {
    width: 65px;
    margin: auto;
    height: 65px;
    line-height: 61px;
    transition: all 0.3s;
}
.cmp-main:hover .cmp-log{
    transform:scale(1.05);
}
.cmp-name {
    font-size: 15px;
    font-family: roboto;
    line-height: 22px;
    padding: 10px 5px 0 5px;
    font-weight: 500;
}
');