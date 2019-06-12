 <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="control-label padding_top">Academics</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'academics', ['template' => '{input}{error}'])->inline()->radioList([
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
                            <label class="control-label padding_top">Faculty Teaching Quality</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'faculty_teaching_quality', ['template' => '{input}{error}'])->inline()->radioList([
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
                            <label class="control-label padding_top">Infrastructure</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'infrastructure', ['template' => '{input}{error}'])->inline()->radioList([
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
                            <label class="control-label padding_top">Accomodation Food</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'accomodation_food', ['template' => '{input}{error}'])->inline()->radioList([
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
                            <label class="control-label padding_top">Social Life Extracurriculars</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'social_life_extracurriculars', ['template' => '{input}{error}'])->inline()->radioList([
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
                            <label class="control-label padding_top">Culture Diversity</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'culture_diversity', ['template' => '{input}{error}'])->inline()->radioList([
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
                            <label class="control-label padding_top">Placements Internships</label>
                        </div>
                        <div class="col-md-8">
                            <div class="star-rating1">
                                <fieldset>
                                    <?=
                                    $form->field($editReviewForm, 'placements_internships', ['template' => '{input}{error}'])->inline()->radioList([
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