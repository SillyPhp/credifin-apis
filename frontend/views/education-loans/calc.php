<script src="https://d3js.org/d3.v4.min.js"></script>
<header class="header">
    <div class="header__text-box">
        <h1 class="heading-primary">
            CAR FINANCING CALCULATOR
        </h1>
        <h2 class="heading-secondary">
            Estimate your monthly payment for your next car using the calculator below
        </h2>
    </div>
</header>
<main>
    <section class="section-chart">
        <div class="chart-box">
            <div class="chart"></div>
            <div class="chart__description">
                <div class="chart__legend">
                    <div class="legend__box">
                        <h3 class="chart__description-label label__colored label__colored-1">Interest</h3>
                        <p class="chart__description-value interest">1550</p>
                    </div>
                    <div class="info">
                        <span class="info__icon"></span>
                        <div class="info__tooltip">
                            <h3 class="info__header">Interest</h3>
                            <p class="info__body">Interest is the dollar amount the credit will cost you.</p>
                        </div>
                    </div>
                </div>
                <div class="chart__legend">
                    <div class="legend__box">
                        <h3 class="chart__description-label label__colored label__colored-2">Taxes</h3>
                        <p class="chart__description-value taxes">0</p>
                    </div>
                    <div class="info">
                        <span class="info__icon"></span>
                        <div class="info__tooltip">
                            <h3 class="info__header">Taxes</h3>
                            <p class="info__body">
                                The amount presented for taxes reflects the dollar amount of tax
                                based on the MSRP and Tax Rate shown.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="chart__legend">
                    <div class="legend__box">
                        <h3 class="chart__description-label">
                            Estimated Total Cost
                            <span class="label--sub">(including taxes and interest)</span>
                        </h3>
                        <p class="chart__description-value est_total_cost">31,550</p>
                    </div>
                    <div class="info">
                        <span class="info__icon"></span>
                        <div class="info__tooltip">
                            <h3 class="info__header">Estimated Total Cost</h3>
                            <p class="info__body">
                                The Estimated Total Cost is a summation of the
                                Amount Financed, Finance Charge and Taxes and any cash
                                down payment and/or net trade-in amount.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-chart-controllers">
        <div class="controllers-box">
            <div class="controller-row row" id="price">
                <div class="col-1-of-3">
                    <h3 class="chart__description-label label__colored label__colored-3">Vehicle Price</h3>
                </div>
                <div class="col-1-of-3">
                    <input type="range" class="calc__slider">
                </div>
                <div class="col-1-of-3">
                        <span class="calc__input-group">
                            <span class="calc__input-group-addon">$</span>
                            <input type="number" class="calc__input" placeholder="Vehicle Price">
                            <div class="info-box">
                                <div class="info">
                                    <span class="info__icon"></span>
                                    <div class="info__tooltip">
                                        <h3 class="info__header">Vehicle Price</h3>
                                        <p class="info__body">
                                            The Manufacturer Suggested Retail Price (MSRP) or “sticker price”
                                            is the recommended selling price for the vehicle. The Dealer may adjust
                                            the actual selling price, either higher or lower. The MSRP excludes
                                            transportation and handling charges, destination charges, taxes, title,
                                            registration, preparation and documentary fees, tags, labor and installation
                                            charges, insurance, optional equipment or packages and accessories.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </span>
                </div>
            </div>
            <div class="controller-row row" id="cash_down_payment">
                <div class="col-1-of-3">
                    <h3 class="chart__description-label label__colored label__colored-4">Cash Down Payment</h3>
                </div>
                <div class="col-1-of-3">
                    <input type="range" class="calc__slider">
                </div>
                <div class="col-1-of-3">
                        <span class="calc__input-group">
                            <span class="calc__input-group-addon">$</span>
                            <input type="number" class="calc__input" placeholder="Cash Down Payment">
                            <div class="info-box">
                                <div class="info">
                                    <span class="info__icon"></span>
                                    <div class="info__tooltip">
                                        <h3 class="info__header">Cash Down Payment</h3>
                                        <p class="info__body">
                                            The Down Payment is an up-front cash payment
                                            made when you purchase the vehicle that reduces
                                            the amount financed. This app uses a default cash down payment of
                                            20% of MSRP.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </span>
                </div>
            </div>
            <div class="controller-row row" id="trade_in_value">
                <div class="col-1-of-3">
                    <h3 class="chart__description-label label__colored label__colored-5">Trade-In Value</h3>
                </div>
                <div class="col-1-of-3">
                    <input type="range" class="calc__slider">
                </div>
                <div class="col-1-of-3">
                        <span class="calc__input-group">
                            <span class="calc__input-group-addon">$</span>
                            <input type="number" class="calc__input" placeholder="Trade-In Value">
                            <div class="info-box">
                                <div class="info">
                                    <span class="info__icon"></span>
                                    <div class="info__tooltip">
                                        <h3 class="info__header">Trade-In Value</h3>
                                        <p class="info__body">
                                            The Trade-In Value is the value of your trade-in vehicle.
                                            The dealer will determine the amount you actually receive for your
                                            trade-in vehicle.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </span>
                </div>
            </div>
            <div class="controller-row row" id="tax_rate">
                <div class="col-1-of-3">
                    <h3 class="chart__description-label label__colored label__colored-2">Tax Rate</h3>
                </div>
                <div class="col-1-of-3">
                    <input type="range" class="calc__slider">
                </div>
                <div class="col-1-of-3">
                        <span class="calc__input-group">
                            <input type="number" class="calc__input" placeholder="Tax Rate">
                            <span class="calc__input-group-addon">%</span>
                            <div class="info-box">
                                <div class="info">
                                    <span class="info__icon"></span>
                                    <div class="info__tooltip">
                                        <h3 class="info__header">Tax Rate</h3>
                                        <p class="info__body">
                                            The sales tax rate provided is for sample purposes only.
                                            This app uses a default tax rate of 0%.
                                            If you know the sales tax rate for your location,
                                            please enter it in the field provided.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </span>
                </div>
            </div>
            <div class="controller-row row"  id="term">
                <div class="col-1-of-3">
                    <h3 class="chart__description-label label__colored">Term</h3>
                </div>
                <div class="col-1-of-3">
                    <input type="range" class="calc__slider">
                </div>
                <div class="col-1-of-3">
                        <span class="calc__input-group">
                            <input type="number" class="calc__input" placeholder="Term">
                            <span class="calc__input-group-addon">mo</span>
                            <div class="info-box">
                                <div class="info">
                                    <span class="info__icon"></span>
                                    <div class="info__tooltip">
                                        <h3 class="info__header">Term</h3>
                                        <p class="info__body">
                                            Term represents the repayment period in months for
                                            the amount financed. This app uses a default term of 60 months.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </span>
                </div>
            </div>
            <div class="controller-row row" id="apr">
                <div class="col-1-of-3">
                    <h3 class="chart__description-label label__colored">APR</h3>
                </div>
                <div class="col-1-of-3">
                    <input type="range" class="calc__slider">
                </div>
                <div class="col-1-of-3">
                        <span class="calc__input-group">
                            <input type="number" class="calc__input" placeholder="APR">
                            <span class="calc__input-group-addon">%</span>
                            <div class="info-box">
                                <div class="info">
                                    <span class="info__icon"></span>
                                    <div class="info__tooltip">
                                        <h3 class="info__header">APR</h3>
                                        <p class="info__body">
                                            APR is the Annual Percentage Rate. Actual APR is based on
                                            the creditworthiness of the customer. Not all customers
                                            will qualify for the lowest rate.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </span>
                </div>
            </div>
        </div>
        <div class="section-chart-controllers__footer">
            <button class="btn btn-link btn__toggle-modal">
                *Financing Disclosures
            </button>
            <button class="btn btn-secondary btn__reset">
                Reset
            </button>
        </div>
    </section>
</main>
<div class="dialog">
    <div class="modal-backdrop"></div>
    <div class="modal">
        <div class="modal__header">
            <span class="modal__header__text">Financing Disclosures</span>
            <span class="modal__header__close btn__toggle-modal">&Cross;</span>
        </div>
        <div class="modal__content">
            <p>
                Numerical values are not an advertisement or offer for specific terms of credit.
                Payment amounts presented are estimates and are for illustrative purposes only.
                Actual vehicle price may vary by Dealer. The MSRP excludes transportation and handling charges,
                destination charges, taxes, title, registration, preparation and documentary fees, tags,
                labor and installation charges, insurance, optional products, equipment or packages and accessories.
            </p>
            <h2 class="modal__content-header">
                Lease Transactions:
            </h2>
            <p>
                The amount due at lease signing is the amount to be paid by the lessee prior to or at signing of
                the lease or by delivery of the vehicle. It includes the first month’s payment, any acquisition fee,
                down payment, less any net trade-in amount. The Estimated Monthly Lease Payment shown is based on
                a 36 month term, down payment of $3,000, annual mileage allowance of 12,000 miles, a 0.001 money
                factor, a tax rate of 0.0%, and a $0 net trade-in. A security deposit may be required depending on
                creditworthiness.
            </p>
            <p>
                If you change the Down Payment or Term or Annual Mileage allowance, or if you
                trade in your current vehicle, the Estimated Monthly Payment will change.
            </p>
            <p>
                The payment amount does not include title, license or registration fees.
                Payment amounts may be different due to various factors such as fees, specials,
                rebates, term, down payment, trade-in, applicable tax rate, and creditworthiness of
                the customer. Please contact your selected dealer or lender for program details and actual terms.
            </p>
            <h2 class="modal__content-header">
                Finance Transactions:
            </h2>
            <p>
                The Estimated Monthly Payment is based on a 60 month term, a down payment of $6,000,
                Annual Percentage Rate (APR) of 2.49%, a tax rate of 0.0%, and a $0 net trade-in.
                If you change the Down Payment or Term, or if you trade in your current vehicle,
                the Estimated Monthly Payment will change.
            </p>
            <p>
                The payment amount does not include title, license or registration fees.
                Payment amounts may be different due to various factors such as fees, specials,
                rebates, term, down payment, APR, trade-in, and applicable tax rate. The APR presented
                may not be the lowest rate available. Actual APR is based on the creditworthiness of the customer.
                Not all customers will qualify for the lowest rate. Please contact your selected dealer or
                lender for actual rates, program details and actual terms.
            </p>
        </div>
        <div class="modal__footer">
            <button class="btn btn-secondary btn_close btn__toggle-modal">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    var inputValues = {
        price: {
            _value: 30000,
            set value(val) {
                this._value = parseFloat(val);
                var tiv = inputValues.trade_in_value.value;
                var cdp = inputValues.cash_down_payment.value;

                if(this._value < tiv + cdp) {
                    if(this._value > tiv) {
                        inputValues.cash_down_payment.value = this._value - tiv;
                    } else {
                        inputValues.cash_down_payment.value = 0;
                        inputValues.trade_in_value.value = this._value;
                    }
                }
            },
            get value() {
                return this._value;
            },
            min: 0,
            max: 500000,
            step: 5000,
            reset: function () {
                this._value = 30000;
            }
        },
        cash_down_payment: {
            _value: 6000,
            set value(val) {
                this._value = parseFloat(val);
                var sum = this._value + inputValues.trade_in_value.value;
                if(sum > inputValues.price.value) {
                    inputValues.trade_in_value.value = inputValues.price.value - this._value;
                }
            },
            get value() {
                return this._value;
            },
            min: 0,
            get max() {
                return inputValues.price.value;
            },
            step: 500,
            reset: function () {
                this._value = 6000;
            }
        },
        trade_in_value: {
            _value: 0,
            set value(val) {
                this._value = parseFloat(val);
                var sum = this._value + inputValues.cash_down_payment.value;
                if(sum > inputValues.price.value) {
                    inputValues.cash_down_payment.value = inputValues.price.value - this._value;
                }
            },
            get value() {
                return this._value;
            },
            min: 0,
            get max() {
                return inputValues.price.value;
            },
            step: 500,
            reset: function () {
                this._value = 0;
            }
        },
        tax_rate: {
            min: 0,
            max: 20,
            step: 0.1,
            _value: 0,
            get value() {
                return parseFloat(this._value);
            },
            set value(val) {
                this._value = val;
            },
            reset: function () {
                this._value = 0;
            }
        },
        term: {
            min: 12,
            max: 84,
            step: 12,
            _value: 60,
            get value() {
                return parseFloat(this._value);
            },
            set value(val) {
                this._value = val;
            },
            reset: function () {
                this._value = 60;
            }
        },
        apr: {
            min: 0,
            max: 30,
            step: 0.1,
            _value: 2.5,
            get value() {
                return parseFloat(this._value);
            },
            set value(val) {
                this._value = val;
            },
            reset: function () {
                this._value = 2.5;
            }
        }
    };

    var legendData = {
        get interest() {
            return this.est_total_cost - inputValues.price.value - this.taxes;
        },
        get taxes() {
            return inputValues.price.value * inputValues.tax_rate.value / 100;
        },
        get est_total_cost() {
            return this.est_m_payment * inputValues.term.value + inputValues.cash_down_payment.value + inputValues.trade_in_value.value;
        },
        get est_m_payment() {
            var principal = this.taxes + inputValues.price.value - inputValues.cash_down_payment.value - inputValues.trade_in_value.value;
            var r = inputValues.apr.value / 1200;
            var n = inputValues.term.value;
            var t = Math.pow(1 + r, n);

            if(!r) {
                return 0;
            }

            return principal * r * t / (t - 1);
        }

    };

    var chartData = [
        {
            label: 'Interest',
            id: 'interest',
            color: '#F79082',
            get value() {
                return legendData.interest;
            }
        },
        {
            label: 'Taxes',
            id: 'taxes',
            color: '#DBEFAF',
            get value() {
                return inputValues.price.value * inputValues.tax_rate.value / 100;
            }
        },
        {
            label: 'Trade-In Value',
            id: 'trade-in-value',
            color: '#88D2E0',
            get value() {
                return inputValues.trade_in_value.value;
            }
        },
        {
            label: 'Cash Down Payment',
            id: 'cash_down_payment',
            color: '#4098FF',
            get value() {
                return inputValues.cash_down_payment.value
            }
        },
        {
            label: 'Vehicle Price',
            id: 'price',
            color: '#5A6372',
            get value() {
                return inputValues.price.value;
            }
        }
    ];

    draw();

    function draw() {
        var paddingTop = 30;

        var tooltip = d3.select('.chart-box')
            .append('div')
            .attr('class', 'tooltip');

        tooltip.append('div')
            .attr('class', 'color-icon');

        tooltip.append('div')
            .attr('class', 'label');

        var chart = document.querySelector('.chart');
        chart.innerHTML = '';

        var width = chart.offsetWidth;
        var height = chart.offsetWidth + 2;

        var radius = width / 2;

        var color = d3.scaleOrdinal()
            .domain(chartData.map(function (d) {
                return d.label;
            }))
            .range(function (d) {
                return d.color;
            });

        var svg = d3.select('.chart')
            .append('svg')
            .attr('width', width)
            .attr('height', height)
            .append('g')
            .attr('transform', 'translate(' + (width / 2) +
                ',' + (height / 2) + ')');

        var donutWidth = width > 250 ? 30 : 20;
        var innerRadius = radius - donutWidth;
        var arc = d3.arc()
            .innerRadius(innerRadius)
            .outerRadius(radius);

        var pie = d3.pie()
            .padAngle(.007)
            .value(function (d) {
                return d.value;
            })
            .sort(null);

        var path = svg.selectAll('path')
            .data(pie(chartData))
            .enter()
            .append('path')
            .attr('d', arc)
            .attr('fill', function (d) {
                return d.data.color;
            });

        path.on('mouseover', function (d) {
            var x = arc.centroid(d)[0];
            var y = arc.centroid(d)[1];

            var r = innerRadius + donutWidth / 2;
            var cos = x / r;
            var sin = y / r;

            var top = height / 2 + y + paddingTop;
            var left = width / 2 + x;

            tooltip.select('.label').text(d.data.label);
            tooltip
                .style('top', top + 'px')
                .style('left', left + 'px')
                .style('display', 'flex');

            tooltip.select('.color-icon')
                .style('background-color', d.data.color);

            if (cos > 0.5) {
                tooltip.attr('class', 'tooltip west');
            } else if (cos < -0.5) {
                tooltip.attr('class', 'tooltip east');
            } else if (sin > 0.86) {
                tooltip.attr('class', 'tooltip south');
            } else {
                tooltip.attr('class', 'tooltip north');
            }
        });

        path.on('mouseout', function () {
            tooltip.style('display', 'none');
        });

        var estimateText = d3.select('.chart')
            .append('div')
            .attr('class', 'estimate');

        estimateText
            .append('div')
            .attr('class', 'estimate__heading')
            .append('text')
            .html('Estimated<br>monthly emi payment*');

        estimateText
            .append('div')
            .attr('class', 'estimate__value')
            .text(Math.ceil(legendData.est_m_payment));

        // controllers
        document.querySelectorAll('.controller-row')
            .forEach(function (group) {
                var min = inputValues[group.id].min;
                var max = inputValues[group.id].max;
                var value = inputValues[group.id].value;
                var step = inputValues[group.id].step;

                var boundary = max ? 100 * (value - min) / (max - min) : 0;

                var range = group.querySelector('input[type=range]');

                range.setAttribute('style',
                    'background-image: linear-gradient(90deg, #4098FF 0%, #4098FF ' + boundary + '%, white ' + boundary + '%);'
                );
                range.min = min;
                range.max = max;
                range.value = value;
                range.step = step;

                var textInput = group.querySelector('input[type=number]');
                textInput.min = min;
                textInput.max = max;
                textInput.value = value;
                textInput.step = step;
            });

        // legends
        document.querySelectorAll('.chart__description-value')
            .forEach(function (valueWrapper) {
                var value = legendData[valueWrapper.classList[1]];
                valueWrapper.textContent = Math.round(value);
            })
    }

    document.querySelectorAll('.info')
        .forEach(function (element) {
            element.addEventListener('mouseover', function (e) {
                if(e.screenY > window.innerHeight / 2 + 100) {
                    element.querySelector('.info__tooltip').classList.add('north');
                } else {
                    element.querySelector('.info__tooltip').classList.remove('north');
                }
            });
        });

    document.querySelectorAll('.controller-row')
        .forEach(function (group) {
            var range = group.querySelector('input[type=range]');
            var textInput = group.querySelector('input[type=number]');
            var id = group.id;

            range.addEventListener('input', function (e) {
                inputValues[id].value = e.target.value;
                draw();
            });
            textInput.addEventListener('change', function (e) {
                inputValues[id].value = e.target.value;
                draw();
            });
        });

    document.querySelector('.btn__reset')
        .addEventListener('click', function () {
            Object.values(inputValues).map(function (value) {
                value.reset();
            });
            draw();
        });

    document.querySelectorAll('.btn__toggle-modal')
        .forEach(function (btn) {
            btn.addEventListener('click', function () {
                var dialog = document.querySelector('.dialog');
                dialog.classList.toggle('open');
            });
        });

    d3.select(window)
        .on('resize', draw);



</script>
<?php
$this->registerCss("
*,
*::after,
*::before {
    margin: 0;
    padding: 0;
    box-sizing: inherit;
}

html {
    font-size: 62.5%;
}


@media (max-width: 991px) {
    html {
        font-size: 55%;
    }
}

@media (max-width: 575px) {
    html {
        font-size: 40%;
    }
}


body {
    padding: 3rem;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    line-height: 1.7;
    color: rgb(90, 99, 114);
}

.heading-primary {
    color: rgb(140, 146, 157);
    font-weight: 400;
    margin-bottom: 1.25rem;
    text-transform: uppercase;
    text-align: center;
    font-size: 3rem;
}
.heading-secondary {
    font-size: 1.5rem;
    font-weight: 200;
    margin-bottom: 1.75rem;
    text-align: center;
}

main {
    max-width: 66rem;
    margin: 0 auto;
}

/* Layout */

.row {
    margin: 0 auto;
    display: flex;
    flex-direction: row;
}

[class^=\"col-\"] {
    float: left;
}

[class^=\"col-\"]:not(:last-child) {
    margin-right: 1.5rem;
}

.col-1-of-2 {
    width: calc(50% - 0.5 * 1.5rem);
}

.col-1-of-3 {
    width: calc((100% - 2 * 1.5rem) / 3);
}

.col-2-of-3 {
    width: calc((200%  -  1.5rem) / 3);
}

.col-1-of-4 {
    width: calc(25% - 0.75 * 1.5rem);
}

.col-2-of-4 {
    width: calc(50% -  0.5 * 1.5rem);
}

.col-3-of-4 {
    width: calc(75% - 0.25 * 1.5rem);
}

/* CHART */
.chart-box {
    max-width: 66rem;
    margin: 0 auto;
    padding: 3rem 0;
    display: flex;
    position: relative;
}
.chart {
    width: 50%;
    height: 50%;
    position: relative;
    margin-right: 3.5rem;
}

.tooltip {
    position: absolute;
    display: none;
    padding: .5rem;
    border-radius: .3rem;
    pointer-events: none;
    background-color: rgba(0, 0, 0, .7);
    color: #fff;
    transition: .3s;
    z-index: 100;
    align-items: center;
}
.tooltip:after {
    content: \"\";
    position: absolute;
    width: 0;
    height: 0;
    border-width: .6rem;
    border-style: solid;
}

.tooltip.north {
    transform: translate(-50%, .6rem);
    left: 0px;
}
.tooltip.north:after {
    border-color: transparent transparent rgba(0, 0, 0, .7) transparent;
    top: -1.2rem;
    left: calc(50% - .6rem);
}

.tooltip.west {
    transform: translate(calc(-100% - .6rem), -50%);
}
.tooltip.west:after {
    border-color: transparent transparent transparent rgba(0, 0, 0, .7);
    top: calc(50% - .6rem);
    left: 100%;
}

.tooltip.east {
    transform: translate(.6rem, -50%);
}
.tooltip.east:after {
    border-color: transparent rgba(0, 0, 0, .7) transparent transparent;
    top: calc(50% - .6rem);
    left: -1.2rem
}


.tooltip.south {
    transform: translate(-50%, calc(-100% - .6rem));
}
.tooltip.south:after {
    border-color: rgba(0, 0, 0, .7) transparent transparent transparent;
    top: 100%;
    left: calc(50% - .6rem);
}

.tooltip .color-icon {
    width: 1.5rem;
    height: 1.5rem;
    margin-right: .5rem;
    border: 2px solid #ccc;
    flex: 1 0 auto;
}
.tooltip .label {
    flex: 2 0 auto;
}
.chart path{
    opacity: .9;
    stroke-width: 2;
    stroke: #fff;
}

.chart path:hover{
    opacity: 1;
    stroke: #ccc;
    z-index: 50;
}

.estimate {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.estimate__heading {
    text-transform: uppercase;
    font-size: 1.5rem;
    color: #333;
    width: 100%;
    margin-bottom: 2rem;
}

@media (max-width: 677px) {
    .estimate__heading {
        margin-bottom: .5rem;
    }
}

@media (max-width: 400px) {
    .estimate__heading {
        margin-bottom: 0;
    }
}

.estimate__value {
    font-size: 5.5rem;
    color: #4098FF;
    font-weight: 100;
}

@media (max-width: 677px) {
    .estimate__value {
       font-size: 4rem;
    }
}

.estimate__value:before {
    content: '$';
    font-size: 2.5rem;
    vertical-align: top;
}

.info {
    display: inline-block;
    vertical-align: top;
    width: 2.5rem;
    height: 2.5rem;
    text-align: center;
}

.info__tooltip {
    position: absolute;
    min-width: 45rem;
    width: auto;
    transform: translate(calc( -100% - 1rem), 3rem);

    display: none;
    background: #fff;
    z-index: 100;
    box-shadow: 0 1rem 4rem rgba(0, 0, 0, 0.15);
    border-radius: 3px;
    padding: 1.5rem;
    font-size: 1.5rem;
    pointer-events: none;
    text-align: left;
}

.info__tooltip.north {
    transform: translate(calc( -100% - 1rem), calc(-100% - 1rem));
}

.info__header {
    text-align: center;
    font-weight: 400;
}

.info__icon {
    background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyB3aWR0aD0iMTlweCIgaGVpZ2h0PSIxOXB4IiB2aWV3Qm94PSIwIDAgMTkgMTkiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+ICAgICAgICA8dGl0bGU+aW5mbyBidXR0b24gY29weSAxMDwvdGl0bGU+ICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPiAgICA8ZGVmcz48L2RlZnM+ICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgaWQ9IkFHLUNhbGN1bGF0b3ItdjItLS1Nb2JpbGUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MzIuMDAwMDAwLCAtMjQyLjAwMDAwMCkiPiAgICAgICAgICAgIDxnIGlkPSJHcm91cC0xMC1Db3B5IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyMi4wMDAwMDAsIDI0MS4wMDAwMDApIj4gICAgICAgICAgICAgICAgPGcgaWQ9Ikdyb3VwLTkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDIzOS4wMDAwMDAsIDAuMDAwMDAwKSI+ICAgICAgICAgICAgICAgICAgICA8ZyBpZD0iR3JvdXAtNiI+ICAgICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9ImluZm8tYnV0dG9uIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxNzEuMDAwMDAwLCAxLjAwMDAwMCkiPiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNOS41LDAgQzQuMjQyOTM3NSwwIDAsNC4yNDI5Mzc1IDAsOS41IEMwLDE0Ljc0MjIxODggNC4yNDI5Mzc1LDE5IDkuNSwxOSBDMTQuNzQyODEyNSwxOSAxOSwxNC43NDM0MDYyIDE5LDkuNSBDMTksNC4yNDI5Mzc1IDE0Ljc0MjgxMjUsMCA5LjUsMCBMOS41LDAgWiIgaWQ9IkltcG9ydGVkLUxheWVycyIgZmlsbD0iIzRBOTBFMiI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2Utd2lkdGg9IjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDguMDAwMDAwLCA0LjAwMDAwMCkiIGZpbGw9IiNGRkZGRkYiPiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPHBvbHlnb24gaWQ9IkZpbGwtMSIgcG9pbnRzPSIwIDExIDMgMTEgMyA0IDAgNCI+PC9wb2x5Z29uPiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTMsMS41MDEwODcyNyBDMywzLjQ5ODE4Nzg4IDAsMy40OTgxODc4OCAwLDEuNTAxMDg3MjcgQzAsLTAuNTAwMzYyNDI0IDMsLTAuNTAwMzYyNDI0IDMsMS41MDEwODcyNyIgaWQ9IkZpbGwtMiI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2c+ICAgICAgICAgICAgICAgICAgICAgICAgPC9nPiAgICAgICAgICAgICAgICAgICAgPC9nPiAgICAgICAgICAgICAgICA8L2c+ICAgICAgICAgICAgPC9nPiAgICAgICAgPC9nPiAgICA8L2c+PC9zdmc+);
    width: 2rem;
    height: 2rem;
    background-size: 2rem;
    display: inline-block;
    cursor: pointer;
}

.info__icon:hover + .info__tooltip {
    display: inline-block;
}

.chart__description {
    font-size: 1.6rem;
    padding-left: 2.5rem;
    position: relative;
    justify-content: space-between;
    width: 50%;
}

.chart__legend {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.chart__description-label {
    font-size: 1.8rem;
    font-weight: 400;
}

.chart__description-value {
    font-size: 3rem;
    font-weight: 400;
}

.label__colored + .chart__description-value {
    margin-left: 2.6rem;
}

.chart__description-value:before {
    content: '$';
}

.label__colored:before {
    content: '';
    display: inline-block;
    border-radius: 50%;
    width: 1.6rem;
    height: 1.6rem;
    margin-right: .7rem;
    transform: translateY(.2rem);
}

.label__colored-1:before {
    background: #F79082;
}

.label__colored-2:before {
    background: #DBEFAF;
}

.label__colored-3:before {
    background: #5A6372;
}

.label__colored-4:before {
    background: #4098FF;
}

.label__colored-5:before {
    background: #88D2E0;
}

.label--sub {
    display: block;
    font-size: 1.4rem;
}

/* Controllers */
.controllers-box {
    margin-bottom: 5.5rem;
}

/* Range Slider */

.calc__slider {
    -webkit-appearance: none;
    width: 100%;
    height: 1rem;
    border-radius: 5px;
    outline: none;
    -webkit-transition: .2s;
    transition: opacity .2s;
    display: block;
    margin-top: 1.2rem;
    box-shadow: inset 0 .1rem .3rem #555;
    background-image: linear-gradient(90deg, #4098FF 0%, #4098FF 50%, white 50%);
}

.calc__slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;

    background: #fff;
    border: 1px solid #ddd;
    box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.4);
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1;
}

.calc__slider::-moz-range-thumb {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}

/* input box */
.controller-row {
    flex-wrap: wrap;
    justify-content: space-between;
}

.controller-row:not(:last-child) {
    margin-bottom: 3.7rem;
}

@media (max-width: 600px) {
    .controller-row {
        height: 10rem;
    }
    .controller-row [class^=\"col-\"]:nth-child(2) {
        order: 1;
        flex: 0 1 100%;
    }
    .controller-row [class^=\"col-\"]:nth-child(1),
    .controller-row [class^=\"col-\"]:nth-child(3){
        flex: 0 1 48%;
    }
}

.calc__input-group {
    width: 100%;
    position: relative;
    display: table;
    border-collapse: separate;
    color: #5A6372;
    font-size: 1.8rem;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
    padding-left: 1rem;
}
.calc__input-group-addon {
    display: table-cell;
    width: 4.5rem;
    height: 4.5rem;
    background-color: #FAFAFA;
    padding: 0;
    color: #5A6372;
    text-align: center;
    border: 1px solid #ccc;
    vertical-align: middle;
    border-radius: 0;
    font-weight: 300;
}
.calc__input-group-addon:first-child {
    border-right: 0;
}
.calc__input-group-addon:nth-child(2) {
    border-left: 0;
}


.calc__input {
    display: table-cell;
    position: relative;
    z-index: 2;
    width: 100%;
    padding: .6rem 1.2rem;
    color: #5A6372;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: .4rem;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    height: 4.5rem;
    font-size: 2rem;
    font-weight: 300;
}
.calc__input:focus {
    outline: 0;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
}
.calc__input-group .calc__input:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.calc__input-group .calc__input:nth-child(2) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.info-box {
    display: table-cell;
    width: 3.5rem;
    text-align: right;
    vertical-align: top;
}

.section-chart-controllers__footer {
    display: flex;
    justify-content: space-between;
    padding: 0 2.5rem;
}

.btn {
    display: inline-block;
    font-weight: 500;
    border-width: 2px;
    border-radius: 4rem;
    cursor: pointer;
    outline: none;
    transition: background-color 0.2s linear, border-color 0.2s linear, color 0.2s linear;
}

.btn:hover {
    transform: translateY(-3px);
}

.btn:active {
    transform: translateY(0);
}

.btn-link {
    font-size: 1.7rem;
    padding: 0;
    text-decoration: none;
    color: #4098FF;
    border-color: transparent;
}

.btn-link:hover,
.btn-link:focus {
    background: transparent;
}

.btn-secondary {
    background-color: transparent;
    border-color: #4098FF;
    color: #4098FF;
    padding: 1rem 3.5rem;
    text-transform: uppercase;
}

.btn-secondary:hover,
.btn-secondary:focus {
    background-color: #4098FF;
    color: #fff;
}

/* DIALOG */
.dialog {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 10;
    min-height: 100%;
    overflow: auto;
}
.dialog.open {
    display: block;
}

.modal-backdrop {
    opacity: 0.75;
    background-color: #232933;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
}

.modal {
    position: absolute;
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
    border-radius: .5rem;
    top: 1rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1041;
    background-color: #fff;
    color: #5A6372;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    padding: 1.5rem 0;
    width: 90%;
}
@media(min-width: 992px) {
    .modal {
        width: 900px;
    }
}
@media(min-width: 768px) {
    .modal {
        width: 600px;
    }
}

.modal__header {
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    border-bottom: 1px solid rgb(229, 229, 229);
}

.modal__header__close {
    cursor: pointer;
    font-size: 2.1rem;
    font-weight: bold;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    transform: translateY(-.5rem);
    opacity: 0.5;
    transition: opacity .15s;
}
.modal__header__close:hover {
    opacity: 0.7;
}

.modal__header__text {
    font-size: 1.4rem;
}

.modal__content {
    padding: 1rem 2rem;
    text-align: center;
    color: rgb(90, 99, 114);
    font-size: 1.4rem;
}

.modal__content p:not(:last-child) {
    margin-bottom: 2rem;
}

.modal__content-header {
    text-decoration: underline;
    font-size: 1.6rem;
    font-weight: 400;
}

.modal__footer {
    padding: 1rem 2rem;
}

");