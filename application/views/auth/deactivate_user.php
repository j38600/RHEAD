<h1><?php echo lang('deactivate_heading');?></h1>

<?php
echo form_open('auth/deactivate/'.$user->id, ['class' => 'form-horizontal',
                                                'role' => 'form']); ?>
<div class="form-group">
    <label for="confirm" class="col-xs-offset-3 col-xs-3 control-label">
        <?php echo sprintf(lang('deactivate_subheading'), $user->username);?>
    </label>
    <div class="col-xs-4 text-left">
    <?php
        echo form_radio('confirm', 'yes').' Sim ';
        echo form_radio('confirm', 'no').' Não';
    ?>
    </div>
</div>

<?php echo form_hidden($csrf); ?>
<?php echo form_hidden(array('id'=>$user->id)); ?>

<div class="form-group">
    <div>
        <button class="btn btn-primary" type="submit" name="submit">Submeter</button>
    </div>
</div>

<?php echo form_close();?>