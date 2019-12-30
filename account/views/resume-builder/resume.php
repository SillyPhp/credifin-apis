<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;


function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

?>
    <div class="row">

        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <div class="col-md-12 col-sm-12">
                <div class="row bg-lighter shadow round working">
                    <div class="col-md-8 col-sm-8">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Education
                        </h4>

                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="modal fade " id="add-education-modal" tabindex="-1" role="dialog"
                             aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 id="eduTitle"
                                            class="modal-title"><?= Yii::t('account', 'Add Education'); ?></h4>
                                    </div>
                                    <?php
                                    $fforms = ActiveForm::begin([
                                        'id' => 'add-education-form',
                                        'fieldConfig' => [
                                            'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                        ],
                                    ]);
                                    ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="load-suggestions Typeahead-spinner school-spin"
                                                     style="display: none;">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                <?= $fforms->field($addQualificationForm, 'school')->textInput(['id'=>'school','autocomplete' => 'off','placeholder'=>'School/College'])->label(false); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $fforms->field($addQualificationForm, 'degree')->textInput(['autocomplete' => 'off'])->label('Class/Degree'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $fforms->field($addQualificationForm, 'field')->textInput(['autocomplete' => 'off'])->label('Stream'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?=
                                                $fforms->field($addQualificationForm, 'qualification_from')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'From Year'],
                                                    'readonly' => true,
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy/mm/dd',
                                                        'name' => 'qualification_from',
                                                        'todayHighlight' => true,
                                                    ]])->label(false);
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="check_exp">
                                                    <?=
                                                    $fforms->field($addQualificationForm, 'qualification_to')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => 'To Year'],
                                                        'readonly' => true,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy/mm/dd',
                                                            'name' => 'qualification_to',
                                                            'todayHighlight' => true,
                                                        ]])->label(false);
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary  eduSave']); ?>
                                        <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade " id="update-education-modal" tabindex="-1" role="dialog"
                             aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 id="eduTitle"
                                            class="modal-title"><?= Yii::t('account', 'Update Education'); ?></h4>
                                    </div>
                                    <?php
                                    $update_edu_form = ActiveForm::begin([
                                        'id' => 'update-education-form',
                                        'fieldConfig' => [
                                            'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                        ],
                                    ]);
                                    ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="load-suggestions Typeahead-spinner school-spin"
                                                     style="display: none;">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                <?= $update_edu_form->field($addQualificationForm, 'school')->textInput(['autocomplete' => 'off', 'id' => 'update_school','placeholder'=>'School/College'])->label(false); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $update_edu_form->field($addQualificationForm, 'degree')->textInput(['autocomplete' => 'off', 'id' => 'update_degree'])->label('Class/Degree'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $update_edu_form->field($addQualificationForm, 'field')->textInput(['autocomplete' => 'off', 'id' => 'update_field'])->label('Stream'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?=
                                                $update_edu_form->field($addQualificationForm, 'qualification_from')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'From Year', 'id' => 'update_qualification_from'],
                                                    'readonly' => true,
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy/mm/dd',
                                                        'name' => 'qualification_from',
                                                        'todayHighlight' => true,
                                                    ]])->label(false);
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="check_exp">
                                                    <?=
                                                    $update_edu_form->field($addQualificationForm, 'qualification_to')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => 'To Year', 'id' => 'update_qualification_to'],
                                                        'readonly' => true,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy/mm/dd',
                                                            'name' => 'qualification_to',
                                                            'todayHighlight' => true,
                                                        ]])->label(false);
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-primary  eduUpdate']); ?>
                                        <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>

                        <button id="addEdu" class="btn btn-primary btn-lg btn-block">
                            <icon class="fa fa-plus"></icon>
                            Add Education
                        </button>
                    </div>
                    <?php
                    Pjax::begin(['id' => 'pjax_qualification']);
                    ?>
                    <div class="col-md-10 col-md-offset-1">
                        <?php
                        if (!empty($education)) {
                            foreach ($education as $e) { ?>
                                <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
                                    <hr class="gradient_line"/>
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <div class="text-right">
                                            <h4 class="colored"><strong><?= $e['degree']; ?></strong></h4>
                                            <?php
                                            $from = strtotime($e['from_date']);
                                            $to = strtotime($e['to_date']);
                                            ?>
                                            <?= date('Y', $from) ?> to <?= date('Y', $to) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8">
                                        <div class="experience-detail">
                                            <h4><strong><?= $e['institute']; ?></strong></h4>
                                            <p><?= $e['field']; ?></p>
                                        </div>
                                        <div class="avatar-edit edu-pen" id="<?= $e['education_enc_id']; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <div class="avatar-edit edu-del" id="<?= $e['education_enc_id']; ?>">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo 'No data found';
                        }
                        ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>

                <div class="row bg-lighter shadow round working">

                    <div class="col-md-8 col-sm-8">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Work Experience
                        </h4>
                    </div>
                    <div class="experiences">
                        <div class="col-md-4  col-sm-4">
                            <div class="modal fade" id="add-experience-modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 id="expTitle"
                                                class="modal-title"><?= Yii::t('account', 'Add Work Experience'); ?></h4>
                                        </div>
                                        <?php
                                        $fform = ActiveForm::begin([
                                            'id' => 'add-experience-form',
                                            'fieldConfig' => [
                                                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                            ],
                                        ]);
                                        ?>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <?= $fform->field($addExperienceForm, 'title')->textInput(['autocomplete' => 'off'])->label(true); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="load-suggestions Typeahead-spinner company-spin"
                                                         style="display: none;">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <?= $fform->field($addExperienceForm, 'company')->textInput(['id'=>'company','autocomplete' => 'off','placeholder'=>'Company'])->label(false); ?>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="load-suggestions Typeahead-spinner city-spin"
                                                         style="display: none;">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <?= $fform->field($addExperienceForm, 'location')->textInput(['id' => 'cities', 'placeholder' => 'Location', 'autocomplete' => 'off'])->label(false); ?>
                                                    <?= $fform->field($addExperienceForm, 'city_id', ['template' => '{input}'])->hiddenInput(['id' => 'city_id_exp'])->label(false); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'exp_from')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => 'Work Experience From'],
                                                        'readonly' => true,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy/mm/dd',
                                                            'name' => 'exp_from',
                                                            'todayHighlight' => true,
                                                        ]])->label(false);
                                                    ?>
                                                </div>
                                                <div class="col-md-6 experience">
                                                    <div class="check_exp">
                                                        <?=
                                                        $fform->field($addExperienceForm, 'exp_to')->widget(DatePicker::classname(), [
                                                            'options' => ['placeholder' => 'Work Experience To'],
                                                            'readonly' => true,
                                                            'pluginOptions' => [
                                                                'autoclose' => true,
                                                                'format' => 'yyyy/mm/dd',
                                                                'name' => 'earliestjoiningdate',
                                                                'todayHighlight' => true,
                                                            ]])->label(false);
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="md-checkbox-inline">
                                                        <?=
                                                        $fform->field($addExperienceForm, 'present')->checkBoxList([
                                                            1 => 'I currently work here',
                                                        ], [
                                                            'item' => function ($index, $label, $name, $checked) {
                                                                $return = '<div class="md-checkbox check_this">';
                                                                $return .= '<input type="checkbox" id="exp_present" value="0" name="' . $name . '"  class="md-check" ' . $checked . ' >';
                                                                $return .= '<label for="exp_present">';
                                                                $return .= '<span></span>';
                                                                $return .= '<span class="check"></span>';
                                                                $return .= '<span class="box"></span> ' . $label . ' </label>';
                                                                $return .= '</div>';
                                                                return $return;
                                                            }
                                                        ])->label(false);
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <?= $fform->field($addExperienceForm, 'salary')->textInput(['autocomplete' => 'off', 'data-toggle' => 'tooltip',  'title' => 'Hooray!'])->label('Salary'); ?>
                                                    <i class="fas fa-info-circle info-icon"></i>
                                                </div>
                                                <div class="col-md-4">
                                                    <?= $fform->field($addExperienceForm, 'ctc')->textInput(['autocomplete' => 'off'])->label('CTC'); ?>
                                                    <i class="fas fa-info-circle info-icon"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'description')->textarea(['rows' => 6,])->label('Description');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary  expSave']); ?>
                                            <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="update-experience-modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 id="expTitle"
                                                class="modal-title"><?= Yii::t('account', 'Add Work Experience'); ?></h4>
                                        </div>
                                        <?php
                                        $fform = ActiveForm::begin([
                                            'id' => 'update-experience-form',
                                            'fieldConfig' => [
                                                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                            ],
                                        ]);
                                        ?>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <?= $fform->field($addExperienceForm, 'title')->textInput(['autocomplete' => 'off', 'id' => 'update_exp_title'])->label(true); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="load-suggestions Typeahead-spinner company-spin"
                                                         style="display: none;">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <?= $fform->field($addExperienceForm, 'company')->textInput(['autocomplete' => 'off', 'id' => 'update_exp_company','placeholder'=>'Company'])->label(false); ?>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="load-suggestions Typeahead-spinner city-spin"
                                                         style="display: none;">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <?= $fform->field($addExperienceForm, 'location')->textInput(['id' => 'update_cities', 'placeholder' => 'Location', 'autocomplete' => 'off'])->label(false); ?>
                                                    <?= $fform->field($addExperienceForm, 'city_id', ['template' => '{input}'])->hiddenInput(['id' => 'update_city_id_exp'])->label(false); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'exp_from')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => 'Work Experience From', 'id' => 'update_exp_from'],
                                                        'readonly' => true,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy/mm/dd',
                                                            'name' => 'exp_from',
                                                            'todayHighlight' => true,
                                                        ]])->label(false);
                                                    ?>
                                                </div>
                                                <div class="col-md-6 update_experience">
                                                    <div class="check_exp">
                                                        <?=
                                                        $fform->field($addExperienceForm, 'exp_to')->widget(DatePicker::classname(), [
                                                            'options' => ['placeholder' => 'Work Experience To', 'id' => 'update_exp_to'],
                                                            'readonly' => true,
                                                            'pluginOptions' => [
                                                                'autoclose' => true,
                                                                'format' => 'yyyy/mm/dd',
                                                                'name' => 'earliestjoiningdate',
                                                                'todayHighlight' => true,
                                                            ]])->label(false);
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-checkbox-inline">
                                                        <?=
                                                        $fform->field($addExperienceForm, 'present')->checkBoxList([
                                                            1 => 'I currently work here',
                                                        ], [
                                                            'id' => 'update_present',
                                                            'item' => function ($index, $label, $name, $checked) {
                                                                $return = '<div class="md-checkbox check_this">';
                                                                $return .= '<input type="checkbox" id="update_exp_present" value="0" name="' . $name . '"  class="md-check" ' . $checked . ' >';
                                                                $return .= '<label for="update_exp_present">';
                                                                $return .= '<span></span>';
                                                                $return .= '<span class="check"></span>';
                                                                $return .= '<span class="box"></span> ' . $label . ' </label>';
                                                                $return .= '</div>';
                                                                return $return;
                                                            }
                                                        ])->label(false);
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'description')->textarea(['rows' => 6, 'id' => 'update_description'])->label('Description');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?= Html::submitButton('Update', ['class' => 'btn btn-primary  expUpdate']); ?>
                                            <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>

                            <button id="addExp" class="btn btn-primary btn-lg btn-block"
                            <!--data-target="#add-experience-modal-->">
                            <icon class="fa fa-plus"></icon>
                            Add Work Experience
                            </button>
                        </div>
                    </div>

                    <?php
                    Pjax::begin(['id' => 'pjax_experience']);
                    ?>
                    <div class="col-md-10 col-md-offset-1 col-sm-12">
                        <?php
                        if (!empty($experience)) {
                            foreach ((array)$experience as $ex) { ?>
                                <div class="row" style="margin-top: 30px;">
                                    <hr class="gradient_line"/>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="rounded-experience-period">
                                            <canvas class="user-icon company-logo" name="<?= $ex['company']; ?>" width="100" height="100" color="" font="50px"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <div class="experience-detail">
                                            <span><?=  Yii::$app->formatter->asDate($ex['from_date'], 'long'); ?>
                                             to <br/>
                                            <?php if ($ex['is_current']) {
                                                echo 'Present';
                                            } else {
                                                echo Yii::$app->formatter->asDate($ex['to_date'], 'long');
                                            } ?>
                                            </span>
                                            <h4><?= $ex['company']; ?></h4>
                                            <h4 class="colored"><?= $ex['title']; ?></h4>
                                            <p><?= $ex['description']; ?></p>
                                        </div>

                                        <div class="avatar-edit exp-pen" id="<?= $ex['experience_enc_id']; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </div>

                                        <div class="avatar-edit exp-del" id="<?= $ex['experience_enc_id']; ?>">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo 'No data found';
                        }
                        ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>

                <div class="row bg-lighter shadow round  working">

                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Skills
                        </h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_skills',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">

                                        <?php
                                        if (!empty($skills)) {
                                            foreach ($skills as $skill) { ?>
                                                <li class="addedTag"><?= $skill['skill'] ?>
                                                    <span id="<?= $skill['user_skill_enc_id'] ?>"
                                                          class="skill_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="skill_input"
                                                       class="skill_search input_search"
                                                       placeholder="skills">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-lighter shadow round working">
                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Achievements
                        </h4>

                        <hr>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_achievements',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($achievements)) {
                                            foreach ($achievements as $achievement) { ?>
                                                <li class="addedTag"><?= $achievement['achievement'] ?>
                                                    <span id="<?= $achievement['user_achievement_enc_id'] ?>"
                                                          class="achievement_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="achievement_input"
                                                       class="achievement_search input_search"
                                                       placeholder="Achievements">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-lighter shadow round working">
                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Hobbies
                        </h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_hobby',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($hobbies)) {
                                            foreach ($hobbies as $hobby) { ?>
                                                <li class="addedTag"><?= $hobby['hobby'] ?>
                                                    <span id="<?= $hobby['user_hobby_enc_id'] ?>"
                                                          class="hobby_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="hobby_input" class="hobby_search input_search"
                                                       placeholder="Hobbies">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-lighter shadow round working">
                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Interests
                        </h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_interest',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($interests)) {
                                            foreach ($interests as $interest) { ?>
                                                <li class="addedTag"><?= $interest['interest'] ?>
                                                    <span id="<?= $interest['user_interest_enc_id'] ?>"
                                                          class="interest_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="interest_input"
                                                       class="interest_search input_search" placeholder="interest">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <div class="loader-aj-main">
        <div class="loader-aj">
            <div class="dot first"></div>
            <div class="dot second"></div>
        </div>
    </div>
    <input type="hidden" id="skill_id">

<?php
$script = <<< JS
$(document).ready(function(){
  $('.info-icon').tooltip();
});
function compareDates(from,to){
    var a = new Date(from);
    var b = new Date(to);
    return a > b;
}

function floatingLabel() {
   $('.form-md-floating-label .form-control').each(function(){
       if ($(this).val().length > 0) {
           $(this).addClass('edited');
       } else{
           $(this).removeClass('edited');
       }
   });
}

$(document).on('click','.exp-pen, .edu-pen, #addEdu, #addExp',function(e){
    setTimeout(function(){
      floatingLabel();}
      ,1000
  );
});

$('#exp_present').click(function(){
    if (this.checked) {
        $(this).val('1');
        $('.experience').hide();
    }else{
        $(this).val('0');
        $('.experience').show();
        $('#addexperienceform-exp_to').val('');
    }
}) ;
    
$('#update_exp_present').click(function(){
    if (this.checked) {
        $(this).val('1');
        $('.update_experience').hide();
    }else{
        $(this).val('0');
        $('.update_experience').show();
        $('#update_exp_to').val('');
        $('#update_exp_to').focus();
    }
}) ;

$(document).on('click','#addEdu',function(e){   
            e.preventDefault();
            $('#add-education-modal').modal('toggle');
            $('#school').val('');
            $('#addqualificationform-degree').val('');
            $('#addqualificationform-field').val('');
            $('#addqualificationform-qualification_from').val('');
            $('#addqualificationform-qualification_to').val('');
            setTimeout(function(){
                $('#school').focus();
                }, 500);
        });
        
$(document).on('click','#addExp',function(event){
            event.preventDefault();
            $('#add-experience-modal').modal('toggle');
            
             $('#addexperienceform-title').val('');
             $('#company').val('');
             $('#city_id_exp').val('');
             $('#cities').val('');
             $('#addexperienceform-exp_from').val('');
            $('#addexperienceform-exp_to').val('');
            if($('#exp_present').prop("checked")){
                $('#exp_present').prop('checked', false);
                $('.experience').show();
            }
             $('#addexperienceform-description').val('');
            setTimeout(function(){
                $('#addexperienceform-title').focus();
                }, 500);
            
        });

$(document).on('submit','#add-education-form',function(e){   
        e.preventDefault();
        var school = $('#school').val();
        var degree = $('#addqualificationform-degree').val();
        var field = $('#addqualificationform-field').val();
        var from = $('#addqualificationform-qualification_from').val();
        var to = $('#addqualificationform-qualification_to').val();
        var data = $('#add-education-form').serialize();
        if(school == ''  || degree == '' || field == '' || from == '' || to == ''){
            return false;    
        }else if(compareDates(from,to)){
            toastr.error('please enter correct dates', 'error');
        }else{
            $.ajax({
                url: '/account/resume-builder/education',
                method : 'POST',
                data : data,
                beforeSend:function(){     
                          $('.loader-aj-main').fadeIn(1000);
                },
                success : function(res)
                {
                    $('.loader-aj-main').fadeOut(1000);
                     if(res == true){
                        $('#add-education-modal').modal('toggle');
                        $.pjax.reload({container: '#pjax_qualification', async: false});
                    }else{
                         toastr.error('something went wrong.Try Again', 'error');
                    }
                } 
            });
        }
});

$(document).on('click', '.edu-pen', function(a) {
            a.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
            url: '/account/resume-builder/edit-education',
            method : 'POST',
            data : {id:id},
            beforeSend:function(){
                    $('.loader-aj-main').fadeIn(100);
                 },
            success : function(res)
            {   
                 $('.loader-aj-main').fadeOut(50);
                $('#update-education-modal').modal('show');
                var obj = JSON.parse(res);
                $('#update_school').val(obj.institute);
                $('#update_degree').val(obj.degree);
                $('#update_field').val(obj.field);
                $('#update_qualification_from').val(obj.from_date);
                $('#update_qualification_to').val(obj.to_date);
                $('.eduUpdate').attr('id',obj.education_enc_id);
            } 
            });
        });
        
$(document).on('submit','#update-education-form',function(e){   
        e.preventDefault();
        var id = $('.eduUpdate').attr('id');
        var school = $('#update_school').val();
        var degree = $('#update_degree').val();
        var field = $('#update_field').val();
        var from = $('#update_qualification_from').val();
        var to = $('#update_qualification_to').val();
        if(school == ''  || degree == '' || field == '' || from == '' || to == ''){
            return false;    
        }else if(compareDates(from,to)){
            toastr.error('please enter correct dates', 'error');
        }else{
        $.ajax({
            url: '/account/resume-builder/update-education',
            method : 'POST',
            data : {school:school,degree:degree,field:field,from:from,to:to,id:id},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);
            },
            success : function(res)
            {
                $('.loader-aj-main').fadeOut(1000);
                 if(res == true){
                    $('#update-education-modal').modal('toggle');
                    $.pjax.reload({container: '#pjax_qualification', async: false});
                 }else{
                    $('#update-education-modal').modal('toggle');
                    $.pjax.reload({container: '#pjax_qualification', async: false}); 
                 }
            } 
            });
            
        }
        });

$(document).on('click','.edu-del',function(e){
           e.preventDefault();
           
           var  id = $(this).attr('id');
           
           $.ajax({
                url: '/account/resume-builder/delete-education',
                 method : 'POST',
                 data : {id:id},
                 beforeSend:function(){
                    $('.loader-aj-main').fadeIn(100);
                 },
                  success : function(response)
                  {
                      $('.loader-aj-main').fadeOut(50);
                      var res = JSON.parse(response);
                      
                      if(res.status == 200){
                          $.pjax.reload({container: '#pjax_qualification', async: false});
                      }else if(res.status == 201){
                          toastr.error(res.message, res.title);
                      }
                      
                  }
            });
        });
    
$(document).on('submit','#add-experience-form',function(e){
    e.preventDefault();
    var title = $('#addexperienceform-title').val();
    var company = $('#company').val();
    var city = $('#city_id_exp').val();
    var salary = $('#addexperienceform-salary').val();
    var ctc = $('#addexperienceform-ctc').val();
   
    var from = $('#addexperienceform-exp_from').val();
    if($('#exp_present').prop("checked")){
            var checkbox = 1;
            $('#addexperienceform-exp_to').val('');
            var to = $('#addexperienceform-exp_to').val();
        }else{
            var checkbox = 0;
            if($('#addexperienceform-exp_to').val() == ''){
                 toastr.error('please enter all fields.', 'error');
                 return false;
            }else{
                var to = $('#addexperienceform-exp_to').val();
            }
        }
    var description = $('#addexperienceform-description').val();
    if(compareDates(from,to)){
        toastr.error('please enter correct dates', 'error');
        return false;
    }
    $.ajax({
       url: '/account/resume-builder/experience',
       method: 'POST',
       data : {title:title,company:company,city:city,from:from,to:to,checkbox:checkbox,description:description,salary:salary,ctc:ctc},
        beforeSend:function(){     
            $('.loader-aj-main').fadeIn(1000);  
        },
       success : function(response){
           $('.loader-aj-main').fadeOut(1000);
           var res = JSON.parse(response);
           if(res.status == 200)
           {
               $('#add-experience-modal').modal('toggle');
               $.pjax.reload({container: '#pjax_experience', async: false});
               utilities.initials();
           } else {
               toastr.error('something went wrong.Try Again', 'error');
           }
        }
    });
});

$(document).on('submit','#update-experience-form',function(e){
    e.preventDefault();
   
    var id = $('.expUpdate').attr('id');
    var title = $('#update_exp_title').val();
    var company = $('#update_exp_company').val();
    var city = $('#update_city_id_exp').val();
    var from = $('#update_exp_from').val();
    if($('#update_exp_present').prop("checked")){
        var checkbox = 1;
        $('#update_exp_to').val('');
        var to = $('#update_exp_to').val();
    }else{
        var checkbox = 0;
        if($('#update_exp_to').val() == ''){
             return false;
        }else{
            var to = $('#update_exp_to').val();
        }
    }
    var description = $('#update_description').val();
    
    if(compareDates(from,to)){
        toastr.error('please enter correct dates', 'error');
        return false;
    }
    
    if(title == '' || company == '' || city == '' || from == '' || description == ''){
        return false;
    }else{            
        $.ajax({
            url: '/account/resume-builder/update-experience',
            method : 'POST',
            data: {id:id,title:title,company:company,city:city,from:from,to:to,check:checkbox,description:description},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);
            },
            success:function(res)
            {
                $('.loader-aj-main').fadeOut(1000);
                if(res==true){
                    $('#update-experience-modal').modal('toggle');
                    $.pjax.reload({container: '#pjax_experience', async: false});
                    utilities.initials();
                }else {
                    $('#update-experience-modal').modal('toggle');
                  //toastr.error('An error occured.try again', 'error');  
                }
            }
        });
    }
});

$(document).on('click','.exp-del',function(e){
   e.preventDefault();
   
   var  id = $(this).attr('id');
   
   $.ajax({
        url: '/account/resume-builder/delete-experience',
         method : 'POST',
         data : {id:id},
         beforeSend:function(){
            $('.loader-aj-main').fadeIn(100);
         },
          success : function(response)
          {
              $('.loader-aj-main').fadeOut(50);
              var res = JSON.parse(response);
              
              if(res.status == 200){
                  $.pjax.reload({container: '#pjax_experience', async: false});
                  utilities.initials();
              }else if(res.status == 201){
                  toastr.error(res.message, res.title);
              }
              
          }
   });
});
        
$(document).on('click','.exp-pen',function(e){
    e.preventDefault();
    
    var id = $(this).attr('id');
    $.ajax({
        url: '/account/resume-builder/edit-experience',
         method : 'POST',
         data : {id:id},
         beforeSend:function(){
            $('.loader-aj-main').fadeIn(100);
         },
          success : function(res)
          {
              $('.loader-aj-main').fadeOut(50);
              $('#update-experience-modal').modal('show');
              var obj = JSON.parse(res);
              $('#update_exp_title').val(obj.title);
              $('#update_exp_company').val(obj.company);
              $('#update_city_id_exp').val(obj.city_enc_id);
              $('#update_cities').val(obj.name);
              $('#update_exp_from').val(obj.from_date);
              $('#update_exp_to').val(obj.to_date);
              if(obj.is_current == 1){
                  $('#update_exp_present').prop('checked', true);
                  $('#update_exp_to').val(0);
                  $('.update_experience').hide();
              }
              $('#update_description').val(obj.description );
              $('.expUpdate').attr('id',obj.experience_enc_id);
          }
    });
});
    
$(document).on('keyup','#achievement_input',function(e){   
    e.preventDefault();
    if(e.which==13){
    var achievement_name = $('#achievement_input').val();
    if(achievement_name == ''){
        toastr.error('please enter something', 'error');
    }else {
        var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
        var new_tag = '<li class="addedTag">'+ achievement_name +'<span class="achievement_remove">x</span></li>';
        $(new_tag).insertAfter(last_child);
        $('#achievement_input').val('');
        $.ajax({
            url: '/account/resume-builder/achievements',
            method : 'POST',
            data : {achievement_name:achievement_name},
            success : function(response)
            {
                 var res = JSON.parse(response);
                 $.pjax.reload({container: '#pjax_achievements', async: false});
                 if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
        });
      }
    }
});
        
$(document).on('click','.achievement_remove', function(e) {
    e.preventDefault();
    var tag_main = $(this).parent();
    tag_main.hide();
        var id = e.target.id;
    $.ajax({
        url: "/account/resume-builder/achievement-remove",
        method: "POST",
        data: {id:id},
       
        success: function (response) {
            var data = JSON.parse(response);
            if(data.status == 200){
                $.pjax.reload({container: '#pjax_achievements', async: false});
            }else{
                tag_main.show();
                toastr.error(data.message, data.title);
            }
        }
    });
});
        
$(document).on('keyup','#hobby_input',function(e){   
    e.preventDefault();
    if(e.which==13){
    var hobby_name = $('#hobby_input').val();
    if(hobby_name == ''){
        toastr.error('please enter something', 'error');
    }else {     
        var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
        var new_tag = '<li class="addedTag">'+ hobby_name +'<span class="hobby_remove">x</span></li>';
        $(new_tag).insertAfter(last_child);
        $('#hobby_input').val('');
        $.ajax({
            url: '/account/resume-builder/hobbies',
            method : 'POST',
            data : {hobby_name:hobby_name},
            success : function(response)
            {
                 var res = JSON.parse(response);
                 $.pjax.reload({container: '#pjax_hobby', async: false});
                 if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
        });
      }
    }
});

$(document).on('click','.hobby_remove', function(e) {
    e.preventDefault();
    var tag_main = $(this).parent();
    tag_main.hide();
        var id = e.target.id;
    $.ajax({
        url: "/account/resume-builder/hobby-remove",
        method: "POST",
        data: {id:id},
       
        success: function (response) {
            var data = JSON.parse(response);
            if(data.status == 200){
                $.pjax.reload({container: '#pjax_hobby', async: false});
            }else{
                tag_main.show();
                toastr.error(data.message, data.title);
            }
        }
    });
});
        
$(document).on('keyup','#skill_input',function(e){   
    e.preventDefault();
    if(e.which==13){
    var skill_name = $('#skill_input').val();
    if(skill_name == ''){
        toastr.error('please enter something', 'error');
    }else {        
        var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
        var new_tag = '<li class="addedTag">'+ skill_name +'<span class="skill_remove">x</span></li>';
        $(new_tag).insertAfter(last_child);
        $('#skill_input').val('');
        $.ajax({
            url: '/account/resume-builder/skills',
            method : 'POST',
            data : {skill_name:skill_name},
            success : function(response)
            {
                 var res = JSON.parse(response);
                $.pjax.reload({container: '#pjax_skills', async: false});
                 if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
            });
          }
        }
});
        
$(document).on('click','.skill_remove', function(e) {
    e.preventDefault();
    var tag_main = $(this).parent('li');
    tag_main.hide();
        var id = e.target.id;
    $.ajax({
        url: "/account/resume-builder/skill-remove",
        method: "POST",
        data: {id:id},
        
        success: function (response) {
            var data = JSON.parse(response);
            if(data.status == 200){
                $.pjax.reload({container: '#pjax_skills', async: false});
            }else{
                tag_main.show();
                toastr.error(data.message, data.title);
            }
        }
    });
});
        
$(document).on('keyup','#interest_input',function(e){   
    e.preventDefault();
    if(e.which==13){
    var interest_name = $('#interest_input').val();
    
    if(interest_name == ''){
        toastr.error('please enter something', 'error');
    }else {
        var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
        var new_tag = '<li class="addedTag">'+ interest_name +'<span class="interest_remove">x</span></li>';
        $(new_tag).insertAfter(last_child);
        $('#interest_input').val('');
        $.ajax({
            url: '/account/resume-builder/interests',
            method : 'POST',
            data : {interest_name:interest_name},
            success : function(response)
            {
                 var res = JSON.parse(response);
                 $.pjax.reload({container: '#pjax_interest', async: false});
                 if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
        });
}

}
});

$(document).on('click','.interest_remove', function(e) {
            e.preventDefault();
            var tag_main = $(this).parent();
            tag_main.hide();
                var id = e.target.id;
            $.ajax({
                url: "/account/resume-builder/interest-remove",
                method: "POST",
                data: {id:id},
                
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status == 200){
                        $.pjax.reload({container: '#pjax_interest', async: false});
                    }else{
                        tag_main.show();
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
        
var global = [];
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/account/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
            global = list;
             return list;
        }
  }
});

        
$('#cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.city-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.city-spin').hide();
  }).on('typeahead:selected typeahead:completed',function(e,datum)
      {
        $('#city_id_exp').val(datum.id);
     }).blur(validateSelection);


function validateSelection() {
  var theIndex = -1;
 for (var i = 0; i < global.length; i++) {
 if (global[i].text == $(this).val()) {
 theIndex = i;
break;
  }
}
  if (theIndex == -1) {
  $('#cities').val("");
 }

}

$('#update_cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.city-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.city-spin').hide();
  }).on('typeahead:selected typeahead:completed',function(e,datum)
      {
        $('#update_city_id_exp').val(datum.id);
     });

var org = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/account/resume-builder/organizations?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(org) {
             return org;
        }
  }
});

$('#company').typeahead(null, {
  name: 'company',
  highlight: true,       
  display: 'text',
  source: org,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.company-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.company-spin').hide();
  });
  
$('#update_exp_company').typeahead(null, {
name: 'company',
highlight: true,       
display: 'text',
source: org,
limit: 15,
hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.company-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.company-spin').hide();
  });

var school = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/account/resume-builder/schools?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(school) {
             return school;
        }
  }
});

$('#school').typeahead(null, {
  name: 'school',
  highlight: true,       
  display: 'text',
  source: school,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.school-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.school-spin').hide();
  });

$('#update_school').typeahead(null, {
  name: 'school',
  highlight: true,       
  display: 'text',
  source: school,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.school-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.school-spin').hide();
  });


JS;
$this->registerJs($script);
$this->registerCss("
.info-icon {
    position: absolute;
    top: 32px;
    right: 15px;
}
.field-addexperienceform-salary, .field-addexperienceform-ctc {
    position: relative;
}
ul.widget-todo-list {
    list-style: none;
    padding: 0 20px;
    margin: 0;
    position: relative;
    height: 300px;
    display: block;
    overflow-x: scroll;
}
ul.widget-todo-list li {
    border-bottom: 1px dotted #ddd;
    padding: 15px 15px 15px 0;
    position: relative;
}
.checkbox-custom label {
    cursor: pointer;
    margin-bottom: 0;
    text-align: left;
    line-height: 1.5;
}
ul.widget-todo-list li .todo-actions  {
    position: absolute;
    top: 14px;
    right: 0;
    bottom: 14px;
}
ul.widget-todo-list li .todo-actions .todo-remove  {
    font-size: 10px;
    vertical-align: middle;
    color: #999;
}


ul.widget-todo-list li label.line-through span {
    text-decoration: line-through;
}

//ricky/

.round{
    border-radius: 10px;
}
.working{
    padding: 20px 0px !important;
    margin-bottom: 15px;
    margin-top:8px;
    background-color:#FFF;
   
}
.working .col-md-8{
     color: black;
}
//.working .col-md-4 .btn-primary{
//    font-size: 15px ;
//    padding: 12px 15px 10px !important;
//}
.round-info-upper{
    border-radius: 10px 10px 0px 0px;
    background: orange;
}
.bg-theme-colored{
    border-radius: 10px;
    background-color:#FFF;
    margin-bottom:10px;
}
.round-info-lower{
    border:1px;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 1px 3px 0px #797979;
    margin:5px 0px;
    background-color:#fff;
}
.info{
    background:#f9f9f9;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
#school_info{
    display:none;
}
#h{
    display:none;
}
.active{
    color:white !important;
}
.change-pic{
    position:absolute;
    top:0;
    right:0;
    height:22px;
    background-color:#DDD;
    border-radius:0px 6px;
}
.change-pic label{
    background-color:#DDD;
    border-radius: 0px 6px;
    padding: 4px 10px 5px !important;
}
.label {
   cursor: pointer;
   color:#000;
}
#profile_pic {
   opacity: 0;
   position: absolute;
   z-index: -1;
}

.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}



.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
//  padding: 8px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.twitter-typeahead{
    width:100%;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    top:1px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */

.rounded-experience-period{
    width: 100px;
    height: 100px;
    border-radius: 100%;
    margin: auto;
    overflow:hidden;
    box-shadow: 2px 2px 6px #333;
}
.experience-title{
    font-size: 58px;
    line-height: 125px;
    padding:0px;
}
.experience-detail{
    width:78%;
}
.experience-detail span{
    float: right;
    display: block;
}
.experience-detail h2{
    font-weight: 500;
    margin-top: 20px;
    color: #222;
    text-transform: uppercase;
}
.experience-detail h4{
    font-weight:700;
    max-width: 65%;
}
h4.colored{
    color:#4aa1e3;
}
.experience-detail p{
    color:#777;
    margin:0px;
}
.avatar-edit {
    position: absolute;
    right: 12px;
    z-index: 1;
    top: 10px;
    display: inline-block;
    width: 34px;
    height: 34px;
    text-align: center;
    line-height: 31px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow:0px 1px 4px 1px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
}
.avatar-edit input {
  display: none;
}
.avatar-edit:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.profile-label{
    display: block;
    text-align: left;
    box-shadow: none;
    margin: 0px;
    font-size: 14px;
    font-weight: normal;
    color: #6f6f6f;
    padding: 0;
}
.dropdown-menu{
    padding:0px;
}
.dropdown-menu li a .form-group{
    margin-bottom:0px;
}
.dropdown-menu li a{
    line-height: 28px;
    border-bottom: 1px solid #eee;
}
.dropdown-menu li a:hover, .dropdown-menu li a:hover label{
    background-color: #4aa1e3;
    color: #fff;
    border-color:transparent;
}
.dropdown-menu li a label{
    font-weight:normal;
    font-size:14px;
    margin:0px;
}
.hiden{
    display:none;
    position: absolute;
    width: 100%;
    background-color: #f9f9f9;
    padding: 10px 5px;
    box-shadow: 0px 0px 12px 2px #cecece;
    border-radius: 6px;
    text-align: center;
    top: 75px;
    left: 212px;
    z-index:9;
}
.hiden:before{
    content: '';
    left: 34%;
    top: -14px;
    position: absolute;
    border-left: 10px solid transparent;
    border-bottom: 15px solid #f9f9f9;
    border-right: 10px solid transparent;
}
.round #img_id{
    border-radius: 10px;
}
.round:first-child{
    padding:0px;
}
.loader-aj-main{
    display:none;
    position:fixed;
    background-color:#f9f9f9b0;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:99999;
}
.loader-aj {
    display: flex;
    animation: rotate 1s ease-in-out infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
.loader-aj .dot {
    width: 50px;
    height: 50px;
    background: #4aa1e3;
    border-radius: 50%;
  }
.loader-aj .dot.first {
    animation: dot-1 1s ease-in-out infinite;
  }
.loader-aj .dot.second {
    animation: dot-2 1s ease-in-out infinite;
  }
@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes dot-1 {
  0% {
    transform: translate(0px, 0) rotate(0deg);
  }
  50% {
    transform: translate(-50px, 0) rotate(180deg);
  }
  100% {
    transform: translate(0px, 0) rotate(360deg);
  }
}
@keyframes dot-2 {
  0% {
    transform: translate(0px, 0) rotate(0deg);
  }
  50% {
    transform: translate(50px, 0) rotate(180deg);
  }
  100% {
    transform: translate(0px, 0) rotate(360deg);
  }
}
.edu-pen{
    right:10px;
    top:0;
}

.edu-del{
    right:10px;
    top:0;
}

.exp-pen
{
top:0;
}

.exp-del
{
top:0;
}


.gradient_line{ 
    margin: 0 0 20px 0;
    display: block;
    border: none;
    height: 1px;
    background: #4aa1e3;
    background: linear-gradient(to right, white, #4aa1e3, white);
}

@media screen and (min-width: 480px) {
  .experiences{
    text-align:left;
  }
}

@media screen and (min-width: 480px) {
  .edu-pen{
    right:90px;
    top:0;
    }
    
  .edu-del{
    right:40px;
    top:0;
    }  
}


@media screen and (min-width: 480px) {
  .exp-pen{
    right:90px;
    top:0;
    }
    
  .exp-del{
    right:40px;
    top:0;
    }
}
/*-- skills tags input css starts --*/
.tags > .addedTag{
    margin-bottom:10px;
}
.tags > .addedTag > span{
    background: #00a0e3;
}
.taglist{
    float:left !important;
}
.input_search{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 15px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}
.skill_wrapper{position:relative;}
.no-margin {
    margin: 0 !important;
}
.pf-field {
    float: left;
    width: 100%;
    position: relative;
}
.tags {
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    padding: 8px;
}
.tags > .addedTag {
    float: left;
    background: #f4f5fa;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    font-family: Open Sans;
    font-size: 13px;
    padding: 7px 17px;
    margin-right: 10px;
    position: relative;
}

.tags li {
    margin: 0;
}
.tags > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #00a0e3;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    color: #ffffff;
    text-align: center;
    line-height: 13px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
.tagAdd.taglist input {
    float: left;
    width: auto;
    background: #ffffff;
    border: 1px solid #e8ecec !important;
    height: 19px;
    margin: 5px 0;
    margin-left: 15px;
    font-size: 12px;
    font-weight: 400;
}
ul.tags.skill_tag_list {
    list-style: outside none none;
    margin: 0 0 30px;
}
/*-- skills tags input css starts --*/
.has-error .form-group .help-block.help-block-error{
    opacity: 1 !important;
    color: #e73d4a !important;
    filter: alpha(opacity=100);
}
");
$this->registerCssFile("@root/assets/themes/jobhunt/css/icons.css");
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [JqueryAsset::className()]]);
