<h1><?php echo lang('create_group_heading');?></h1>
<p><?php echo lang('create_group_subheading');?></p>

<?php
if(validation_errors()){
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo validation_errors() ?>
    </div>
<?php
}
?>
<?php echo form_open("auth/create_group", ['class' => 'form-horizontal',
                                        'role' => 'form']); ?>
<div class="form-group">
    <label for="group_name" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_group_name_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($group_name); ?>
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_group_desc_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($description); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-5 col-xs-4">
        <button class="col-xs-offset-4 btn btn-primary" type="submit" name="submit"><?php echo lang('create_group_submit_btn');?></button>
    </div>
</div>
<?php
echo form_close();
?>