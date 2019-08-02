<div class="acc-wizard">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading" id="headingOne">
                <h3>
                    <a href="#collapseOne" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">Basic
                        infomation</a>
                </h3>
            </div>
            <input type="hidden" id="selected_application_id" value="">
            <input type="hidden" id="selected_round_id" value="">
            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form method="POST">
                        <fieldset>
                            <div class="form-row">
                                <div class="form-select" id="select-application-sch">
                                    <label for="rounds" class="form-label">Select Application</label>
                                    <div class="select-group" id="applications-lisitng">

                                    </div>
                                </div>
                                <div class="form-select" id="select-app-round">

                                </div>



                            </div>
                            <div class="form-row">
                                <div class="form-select" id="select-application-process">

                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" id="headingTwo">
                <h3>
                    <a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Additional infomation</a>
                </h3>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="post">
                        <fieldset>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="datepicker" class="form-label">Select Interview Dates</label>
                                    <input class="date-picker" placeholder="Select Dates" size="16" type="text"
                                           id="datepicker" value=""/>
                                </div>
                                <div class="form-group">
                                    <div id="same-timings-cont">

                                    </div>
                                    <div class="col-md-12">
                                        <input type="checkbox" id="all-dates" class="float_to_left" name="" checked>
                                        <label for="all-dates" class="float_to_left">For all Interview Dates</label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div id="selected-dates"></div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" id="headingThree">
                <h3>
                    <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Specialities</a>
                </h3>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="post">
                        <fieldset id="specialities-data">
                            <div class="form-row" id="specialities-subdata">
                                <div class="form-group">
                                    <label>Select Mode</label>
                                    <div class="col-sm-6">
                                        <input type="radio" id="online" class="float_to_left" value="2" name="mode" checked="checked">
                                        <label for="online" class="float_to_left">Online</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="radio" id="inplace" class="float_to_left" value="1" name="mode"/>
                                        <label for="inplace" class="float_to_left">Inplace</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>