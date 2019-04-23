<?php
$this->params['header_dark'] = true;
?>
<div class="row">
    <div class="col-md-6 near-me-map pr-0">
        <div id="map"></div>
    </div>
    <div class="col-md-2 near-me-filters pl-0">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'jobs',
        ]);
        ?>
<!--        <div class="filter-heading">-->
<!--            Search companies by-->
<!--        </div>-->
<!--        <form>-->
<!--            <div class="filters">-->
<!--                <div class="filter-search">-->
<!--                    <div class="f-search-loc">-->
<!--                        <input type="text" id="city_search" placeholder="Location"/>-->
<!--                        <i class="fa fa-search"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="col-md-12 pr-0 pl-0">-->
<!--                    <div class="f-ratings f-rating-box-2">-->
<!--                        <div class="overall-box-heading">By Location</div>-->
<!--                        <div class="form-group form-md-checkboxes">-->
<!--                            <div class="md-checkbox-list">-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Ludhiana</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-11" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-11">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Jalandhar</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-21" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-21">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Chandigarh</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-13" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-13">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Delhi</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-12 pr-0 pl-0">-->
<!--                    <div class="f-ratings f-rating-box-2">-->
<!--                        <div class="overall-box-heading">By Category</div>-->
<!--                        <div class="form-group form-md-checkboxes">-->
<!--                            <div class="md-checkbox-list">-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-41" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-41">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">IT</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-15" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-15">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Human Resources</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-51" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-51">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Designing</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-61" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-61">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">Military</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-12 pr-0 pl-0">-->
<!--                    <div class="f-ratings f-rating-box-2">-->
<!--                        <div class="overall-box-heading">Business Activities</div>-->
<!--                        <div class="form-group form-md-checkboxes">-->
<!--                            <div class="md-checkbox-list">-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-12 pr-0 pl-0">-->
<!--                    <div class="f-ratings f-rating-box-2">-->
<!--                        <div class="overall-box-heading">Business Activities</div>-->
<!--                        <div class="form-group form-md-checkboxes">-->
<!--                            <div class="md-checkbox-list">-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                                <div class="md-checkbox">-->
<!--                                    <input type="checkbox" name="activities[]" id="checkbox-1" class="md-check"-->
<!--                                           name="business[]">-->
<!--                                    <label for="checkbox-1">-->
<!--                                        <span></span>-->
<!--                                        <span class="check"></span>-->
<!--                                        <span class="box"></span>-->
<!--                                        <div class="all-label-2">School</div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->
    </div>
    <div class="col-md-4 col-md-offset-2">
        <div class="row">
            <div class="col-md-12">
                <div class="n-header-bar">
                    <h4>Available Jobs (30)</h4>
                    <select class="pull-right">
                        <option>Test 1</option>
                        <option>Test 2</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
                <div data-id="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v"
                     data-key="e8b1AYDBa7n3JMJOa4YKyqJjLwQp9v-jL9zWvg3wlJxzjODM8WRypoqEG6OB1"
                     class="application-card-main ui-draggable ui-draggable-handle">
            <span class="application-card-type location" data-lat="" data-long="" data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;Daman
                </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="/ajayjuneja">
                                <img src="/images/organizations/logo/n06X3CGtUPP9UI64ABAK/t9HswuvW19giC3ymSUD5IYhnBeRWPBvL/5WdJRgv0a78wKLo0XkLXl2nPpwbXzK..png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="/job/hfhetdsh-hsedhsetdh-60491554888389"><h4 class="application-title">
                                    hfhetdsh</h4>
                            </a>
                            <h5>Negotiable</h5>
                            <h5>Full Time</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;Less Than 1 Year Experience</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                        25-04-2019
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                        Ajay
                    </h4>
                    <div class="application-card-wrapper">
                        <a href="/job/hfhetdsh-hsedhsetdh-60491554888389" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.near-me-map{
    float:right !important;
}
#map{
    height:100vh;
}
.side-menu{
    width:16%;
}
#review-internships{
    width:auto;
}
.near-me-filters{
    position:fixed;
    width: 16%;
    top: 52px;
    left: 0;
    height: calc(100vh - 52px);
    overflow-y: scroll;
    overflow-x: hidden;
    box-shadow: 0px 0px 10px 1px #e6e6e6;
}
.near-me-map{
    position:fixed;
    top: 52px;
    right: 0;
    height: calc(100vh - 52px);
}
.n-header-bar{
    padding: 20px;
    box-shadow: 0px 0px 12px 2px #e6e6e6;
    margin: 15px 0px;
    border-radius: 4px;
}
.n-header-bar h4{
    display: inline;
    font-size: 16px;
}
//.filter-search{
//    padding-bottom: 20px;
//}
//.f-main-heading{
//    display: flex;
//}
//.show-search{
//    margin-left: 15px;
//    margin-top: 5px;
//}
//.show-search button{
//    background: transparent;
//    border:none;
//    font-size: 15px;
//    color: #666;
//    float:right;
//}
//.show-search button:hover{
//    color:#00a0e3;
//}
//.f-search-loc{
//   border:1px solid #eee; 
//   padding:5px 15px;
//   border-radius:10px;
//   margin-top:15px;
//   position:relative;  
//}
//.f-search-loc input{
//    border:none;
//    font-size: 14px;
//}
//.f-search-loc input::placeholder{
//    color:#999;
//}
//.f-search-loc i{
//    color: #999;
//    position: absolute;
//    right: 10px;
//    top: 10px;
//}
//.md-checkbox label>.box{
//    top:6px;
//    border: 2px solid #ddd;
//}
//.md-checkbox-list .md-checkbox{
//    margin-bottom:-10px;
//}
//.f-ratings{
//    padding:5px 15px;
//    border:1px solid #eee;
//    border-radius:10px;
//}
//.form label{
//    margin-bottom: 0px !important;
//}
//.filter-heading{
//    padding: 4px 0px 10px 10px;
//    font-size: 13px;
//    font-weight: 600;
//    text-transform: uppercase;
//}
//.overall-box-heading{
//    font-size:13px;
//    padding-top:5px;
//    font-weight:bold;
//}
//.all-label-2{
//    padding-top:7px;
//    font-weight:500;
//    font-size:13px;
//    text-transform: capitalize;;
//}
//.f-rating-box-2{
//    margin-top:20px;
//    position:relative; 
//}
');
$script = <<< JS
var data = [$lat_long];
var map;
var marker;
var  purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
// var infowindow = null;
function showCards(){
    var i;
    // var inprange = {
    //     rangerval : 10
    // };
    var centre = {lat: 30.900965, lng: 75.857277};
    map = new google.maps.Map(document.getElementById('map'),{
        center: centre,
        zoom: 4,
        mapTypeId: 'roadmap'
    });
    for(i=0;i<data.length;i++){
        console.log(data[i]);
        var res = data[i].split(",");
        console.log(res);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(Number(res[0]),Number(res[1])),
            map: map,
            icon: purple_icon,
            draggable: true
        });
    }
    // $(document).on("click",".opens",function() {
    //     if (infowindow) {
    //         infowindow.close();
    //     }
    //     types = $(this).find('#set-types').attr('type');
    //     lat = $(this).find('#set-types').attr('lat');
    //     lon = $(this).find('#set-types').attr('long');
    //     titles = $(this).find('#set-types').attr('title');
    //     locations =  $(this).find('#set-types').attr('location');
    //     lastDates = $(this).find('#set-types').attr('lastdate');
    //     periods = $(this).find('#set-types').attr('period');
    //     companys =  $(this).find('#set-types').attr('company');
    //     logos = $(this).find('#set-types').attr('logo');
    //      var contentString = '<div style="width:400px;" class="product shadow iconbox-border iconbox-theme-colored"><span class="type tag-sale color-o pl-20 pr-20 ">'+types+'</span><div class="row"><div class="col-md-4 col-xs-4 pt-5" ><a href="#" class="icon set_logo"><img class="logo" src="'+logos+'"></a></div><div class="col-md-8 col-xs-8 pt-20"><h4 class="title icon-box-title"><strong>'+titles+'</strong></h4><h5><i class="location fa fa-map-marker" lat="'+lat+'" long="'+lon+'"> '+locations+'</i></h5><h5><i class="period fa fa-clock-o"> '+periods+'</i></h5></div><div class="btn-add-to-cart-wrapper"><a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS</a><a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#"><i class="fa fa-plus"></i></a></div></div><hr class="hr"><h6 class="pull-left pl-20 custom_set2" align="center"><strong>Last Date to Apply</strong><br><div class="lastDate">'+lastDates+'</div></h6><h4 class="company pull-right pr-10 pt-20 custom_set" align="center"><strong>'+companys+'</strong></h4></div>';    
    //      infowindow = new google.maps.InfoWindow({
    //       content: contentString
    //     });
    //      marker = new google.maps.Marker({
    //         position: new google.maps.LatLng(Number(lat),Number(lon)),
    //         map: map,
    //         icon: purple_icon,
    //         draggable: true
    //     });
    //      var position = new google.maps.LatLng(Number(lat),Number(lon));
    //      map.setCenter(position);
    //      map.setZoom(16);
    //      infowindow.open(map, marker);
    // });
    //
    // $("#mapper").on("input change", function() {
    //     inprange.rangerval = $(this).val();
    //     console.log(inprange.rangerval);
    // });
    // var myCity = null;
    // $(document).on('click', ".button__bg", function(){
    //    
    //     if(myCity){
    //         myCity.setMap(null);
    //     }
    //     var geocoder = new google.maps.Geocoder();
    //     var city = $('#form_control_3').val();
    //     var location = $('#form_control_1').val();
    //     var address = city + " " + location;
    //     console.log(address);
    //     geocoder.geocode({'address': address}, function(results, status) {
    //       if (status === 'OK') {
    //        
    //         console.log(inprange.rangerval);
    //           myCity = new google.maps.Circle({
    //             center: results[0].geometry.location,
    //             radius: inprange.rangerval * 1000,
    //             strokeColor: "#0000FF",
    //             strokeOpacity: 0.8,
    //             strokeWeight: 2,
    //             fillColor: "#0000FF",
    //             fillOpacity: 0.4
    //           });
    //           var position = results[0].geometry.location;
    //           map.setCenter(position);
    //           console.log(position);
    //           map.setZoom(12);
    //          
    //           myCity.setMap(map);
    //       } else {
    //         alert("Location does not exist.");
    //       }
    //     });
    // });
    
}
        


function initMap(){
    
    showCards();
}
          initMap();
var ps = new PerfectScrollbar('.near-me-filters');
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>
