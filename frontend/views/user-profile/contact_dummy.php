<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 27-01-2019
 * Time: 21:43
 */
?>
            <div class="contact-edit" id="ci">
                <h3>Contact</h3>

<?php ActiveForm::begin(['id'=>'contactDetailForm','action'=>'/users/update-contact-detail']) ?>

                    <div class="row">
                        <?= $form->field($contactDetails, 'contact',['template'=>'<div class="col-lg-4"><span class="pf-title">Phone Number</span><div class="pf-field">{input}</div></div>','options'=>[]])->textInput(['placeholder'=>'+90 538 963 58 96'])->label(false) ?>
                        <?= $form->field($contactDetails, 'email',['template'=>'<div class="col-lg-4"><span class="pf-title">Email</span><div class="pf-field">{input}</div></div>','options'=>[]])->textInput(['placeholder'=>'demo@empoweryouth.com','value'=>!empty($userData->email)?$userData->email:''])->label(false) ?>
                        <?= $form->field($contactDetails, 'website',['template'=>'<div class="col-lg-4"><span class="pf-title">Website</span><div class="pf-field">{input}</div></div>','options'=>[]])->textInput(['placeholder'=>'www.empoweryouth.com'])->label(false) ?>

                        <div class="col-lg-6">
                            <span class="pf-title">State</span>
                            <div class="pf-field">
                                <select data-placeholder="Please Select Specialism" class="chosen" style="display: none;">
                                    <option>Web Development</option>
                                    <option>Web Designing</option>
                                    <option>Art &amp; Culture</option>
                                    <option>Reading &amp; Writing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <span class="pf-title">City</span>
                            <div class="pf-field">
                                <select data-placeholder="Please Select Specialism" class="chosen" style="display: none;">
                                    <option>Web Development</option>
                                    <option>Web Designing</option>
                                    <option>Art &amp; Culture</option>
                                    <option>Reading &amp; Writing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <?= Html::submitButton('Update',['class'=>'btn_pink btn_submit_contact','id'=>'contact_submit']); ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>