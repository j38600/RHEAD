<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<?php
if(validation_errors()){
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo validation_errors() ?>
    </div>
<?php
}

<?php echo form_open("auth/create_user", ['class' => 'form-horizontal',
                                        'role' => 'form']); ?>

<div class="form-group">
    <label for="first_name" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_fname_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($first_name); ?>
    </div>
</div>

<div class="form-group">
    <label for="last_name" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_lname_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($last_name); ?>
    </div>
</div>

<?php
    if($identity_column!=='email') {
    ?>
    <div class="form-group">
        <label for="identity" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_identity_label');?></label>
        <div class="col-xs-4">
        <?php echo form_input($identity); ?>
        </div>
    </div>
    <?php
    }
?>

<div class="form-group">
    <label for="company" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_company_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($company); ?>
    </div>
</div>

<div class="form-group">
    <label for="email" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_email_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($email); ?>
    </div>
</div>

<div class="form-group">
    <label for="phone" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_phone_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($phone); ?>
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_password_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($password); ?>
    </div>
</div>

<div class="form-group">
    <label for="password_confirm" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('create_user_password_confirm_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($password_confirm); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-2">
        <button class="btn btn-primary" type="submit" name="submit"><?php echo lang('create_user_submit_btn');?></button>
    </div>
</div>
<?php
echo form_close();
?>