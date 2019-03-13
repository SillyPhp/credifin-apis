<div class="col-md-8">
    <div class="box">
        <li class="fixed"><i class="fa fa-sitemap" aria-hidden="true"></i> Get Applications</li>
        <ul class="connected-sortable draggable-right">
            <h1 class="drag_placeholder"><i class="fa fa-cloud-download" aria-hidden="true"></i> Drag And Drop Processes Here</h1>
            <?php if (!empty($process)):
            unset($process['interviewProcessFields'][0]);
            unset($process['interviewProcessFields'][count($process['interviewProcessFields'])]);
            foreach ($process['interviewProcessFields'] as $process){ ?>
                <div class="li_66502 form_builder_field"><li class="a form_output" data-type="interview_process"><i class="<?=$process['icon']; ?>" aria-hidden="true"></i><?= $process['field_label']; ?><a href="#" class="edit_process" data-field="66502"><i class="fa fa-pencil-square-o"></i></a><a href="#" class="remove_process" data-field="66502"><i class="fa fa-times"></i></a><ul class="process_desc"><textarea type="text" name="name_66502" placeholder="Add Description(optional)" class="form-control custom_font"></textarea></ul></li></div>
            <?php } endif; ?>
        </ul>
        <li class="fixed"><i class="fa fa-paper-plane" aria-hidden="true"></i> Hire Applicants</li>
    </div>
</div>