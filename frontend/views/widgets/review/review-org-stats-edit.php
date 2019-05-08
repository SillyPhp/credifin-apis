            <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Career Growth</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'career_growth', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="career' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="career' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Company Culture</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'compnay_culture', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="compnay_culture' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="compnay_culture' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Salary Benefits</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'salary_benefits', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="salary_benefits' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="salary_benefits' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Work satisfaction</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'work_satisfaction', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="work_satisfaction' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="work_satisfaction' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Work-Life Balance</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'work_life', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="work_life' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="work_life' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Skill Development</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'skill_devel', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="skill_devel' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="skill_devel' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Job Security</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'job_security', ['template' => '{input}{error}'])->inline()->radioList([
                                        5 => '5 stars',
                                        4 => '4 stars',
                                        3 => '3 stars',
                                        2 => '2 stars',
                                        1 => '1 stars',
                                    ], [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $return = '<input type="radio" id="job_security' . $index . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="job_security' . $index . '" title="' . $label . '">"' . $label . '"</label>';
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>