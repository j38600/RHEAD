<h1><?php echo lang('edit_group_heading');?></h1>
<p><?php echo lang('edit_group_subheading');?></p>

<?php
if($message){
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message ?>
    </div>
<?php
}
echo form_open(uri_string(), ['class' => 'form-horizontal',
                                        'role' => 'form']); ?>

    <div class="form-group">
        <label for="group_name" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_group_name_label');?></label>
        <div class="col-xs-4">
        <?php echo form_input($group_name); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="group_description" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_group_desc_label');?></label>
        <div class="col-xs-4">
        <?php echo form_input($group_description); ?>
        </div>
    </div>

    <div class="form-group">
    <div class="col-xs-offset-2">
        <button class="btn btn-primary col-xs-offset-3" type="submit" name="submit"><?php echo lang('edit_group_submit_btn');?></button>
    </div>
</div>
<?php
echo form_close();
?>