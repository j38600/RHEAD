<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

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
    <label for="first_name" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_user_fname_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($first_name); ?>
    </div>
</div>

<div class="form-group">
    <label for="last_name" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_user_lname_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($last_name); ?>
    </div>
</div>

<div class="form-group">
    <label for="company" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_user_company_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($company); ?>
    </div>
</div>

<div class="form-group">
    <label for="phone" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_user_phone_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($phone); ?>
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_user_password_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($password); ?>
    </div>
</div>

<div class="form-group">
    <label for="password_confirm" class="col-xs-offset-3 col-xs-2 control-label"><?php echo lang('edit_user_password_confirm_label');?></label>
    <div class="col-xs-4">
    <?php echo form_input($password_confirm); ?>
    </div>
</div>

    <?php if ($this->ion_auth->is_admin()): ?>
        <div class="form-group">
            <label for="checkbox" class="col-xs-offset-3 col-xs-2 control-label">
                <?php echo lang('edit_user_groups_heading');?>
              </label>
            <div class="col-xs-4">
              <div class="checkbox">
                <?php foreach ($groups as $group):?>
                  <label>
                  <?php
                      $gID=$group['id'];
                      $checked = null;
                      $item = null;
                      foreach($currentGroups as $grp) {
                          if ($gID == $grp->id) {
                              $checked= ' checked="checked"';
                          break;
                          }
                      }
                      $data = array(
                          'name'        => 'groups[]',
                          'value'       => $group['id'],
                          'checked'     => $checked,
                      );
                  echo form_checkbox($data);
                  echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                  </label>
              <?php endforeach?>
              </div>
            </div>
        </div>

    <?php
        endif;
        echo form_hidden('id', $user->id);
        echo form_hidden($csrf); ?>
    
    <div class="form-group">
    <div class="col-xs-offset-2">
        <button class="btn btn-primary" type="submit" name="submit"><?php echo lang('edit_user_submit_btn');?></button>
    </div>
</div>
<?php
echo form_close();
?>