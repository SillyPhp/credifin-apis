<div class="portlet box primary_colr">
    <div class="portlet-title">
        <div class="caption text-center">
            Confirm your details
        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table class="table table-bordered table-striped table-condensed flip-content">
            <tbody>
            <tr>
                <?php if ($type == 'Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
                <td><strong>Job Profile</strong></td>
                <?php elseif ($type=='Internships'||$type=='Clone_Internships'||$type=='Edit_Internships'): ?>
                    <td><strong>Internship Profile:</strong></td>
                <?php endif; ?>
                <td><p class="final_confrm"
                       data-display="primaryfield"
                       id="fieldvalue"></p></td>
                <?php if ($type =='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
                <td><strong>Job Title:</strong></td>
                <?php elseif ($type=='Internships'||$type=='Clone_Internships'||$type=='Edit_Internships'): ?>
                <td><strong>Internship Title:</strong></td>
                <?php endif; ?>
                <td><p class="final_confrm"
                       data-display="title"></p></td>
                <?php if ($type=='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
                    <td><strong>Job Type:</strong></td>
                <?php elseif ($type =='Internships'||$type=='Clone_Internships'||$type=='Edit_Internships'): ?>
                    <td><strong>Internship Type:</strong></td>
                <?php endif; ?>
                <td><p class="final_confrm"
                       data-display="type"></p></td>
            </tr>
            <?php if ($type=='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'):?>
                <tr>
                    <td><strong>Designation:</strong></td>
                    <td><p class="final_confrm"
                           data-display="designations"></p></td>
                    <td colspan="2"><strong>CTC:</strong></td>
                    <td colspan="2"><p class="final_confrm" data-display="ctc"></p>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <?php if ($type=='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
                    <td><strong>Salary Type:</strong></td>
                <?php elseif ($type=='Internships'||$type=='Clone_Internships'||$type=='Edit_Internships'): ?>
                <td><strong>Stipend Type:</strong></td>
                <?php endif; ?>
                <td><p class="final_confrm" data-display="wage_type"></p></td>
                <?php if ($type=='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
                <td colspan="2"><strong>Salary Duration:</strong></td>
                <?php elseif ($type=='Internships'||$type=='Clone_Internships'||$type=='Edit_Internships'): ?>
                    <td colspan="2"><strong>Stipend Duration:</strong></td>
                <?php endif; ?>
                <td colspan="2"><p class="final_confrm"
                                   data-display="wage_duration"></p></td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td><strong>Minimum:</strong></td>
                <td><p class="final_confrm" data-display="min_wage"></p>
                </td>
                <td colspan="2"><strong>Maximum:</strong></td>
                <td colspan="2"><p class="final_confrm"
                       data-display="max_wage"></p></td>
            </tr>
            <tr>
                <td><strong>Fixed:</strong></td>
                <td><p class="final_confrm"
                       data-display="fixed_wage"></p></td>
                <td colspan="2"><strong>Joining Date:</strong></td>
                <td colspan="2"><p class="final_confrm"
                       data-display="earliestjoiningdate"></p></td>
            </tr>
            <tr>
                <td><strong>Special Skills:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="specialskillsrequired"
                                   id="skillvalues"></p></td>
            </tr>
            <tr>
                <td><strong>Timing From:</strong></td>
                <td><p class="final_confrm" data-display="from"></p>
                </td>
                <td colspan="2"><strong>Upto:</strong></td>
                <td colspan="2"><p class="final_confrm" data-display="to"></p>
                </td>
            </tr>
            <tr>
                <td><strong>Interview Start:</strong></td>
                <td><p class="final_confrm"
                       data-display="startdate"></p></td>
                <td colspan="2"><strong>Interview End:</strong></td>
                <td colspan="2"><p class="final_confrm"
                       data-display="enddate"></p></td>
            </tr>
            <tr>
                <td><strong>Interview Start Time:</strong></td>
                <td><p class="final_confrm"
                       data-display="interviewstarttime"
                       id="time1"></p></td>
                <td colspan="2"><strong>Interview End Time:</strong></td>
                <td colspan="2"><p class="final_confrm"
                       data-display="interviewendtime"
                       id="time2"></p></td>
            </tr>
            <tr>
                <td><strong>Job Description:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="checkbox[]"
                                   id="chackboxvalues"></p></td>
            </tr>
            <tr>
                <td><strong>Educational Qualification:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="qualifications[]"
                                   id="education_vals"></p></td>
            </tr>
            <tr>
                <td><strong>Placement Locations (No. of positions):</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="placement_locations[]"
                                   id="place_locations"></p></td>
            </tr>
            <tr>
                <td><strong>Interview Location:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="interviewcity[]"
                                   id="interviewcitycityvalues"></p>
                    <span class="final_confrm" data-display="randomfunc"> </span></td>
            </tr>
            <tr>
                <td><strong>Preferred Gender:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="gender"
                                   id="gendr_text"></p></td>
            </tr>
            <?php if ($type=='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
            <tr>
                <td><strong>Preferred Industry:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="<?= (($type=='Clone_Jobs'||$type=='Edit_Jobs') ? 'pref_indus' : 'industry');?>"></p>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td><strong>Last Date:</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="last_date"></p>
                </td>
            </tr>
            <?php if ($type=='Jobs'||$type=='Clone_Jobs'||$type=='Edit_Jobs'): ?>
            <tr>
                <td><strong>Minimum Experience (Years):</strong></td>
                <td colspan="5"><p class="final_confrm"
                                   data-display="minimum_exp"></p></td>
            </tr>
                <tr>
                    <td><strong>Maximum Experience (Years):</strong></td>
                    <td colspan="5"><p class="final_confrm"
                                       data-display="maximum_exp"></p></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$script = <<< JS
JS;
$this->registerJs($script);
?>