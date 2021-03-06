<h1><?php echo lang('index_heading');?></h1>
<p><?php echo lang('index_subheading');?></p>

<?php
if($message){
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message; ?>
    </div>
<?php
}
?>

<!--<div id="infoMessage"><?php echo $message;?></div>-->

<table class="table table-striped table-condensed table-hover">
    <thead>
    <tr>
        <th><?php echo lang('index_fname_th');?></th>
        <th><?php echo lang('index_lname_th');?></th>
        <th><?php echo lang('index_email_th');?></th>
        <th><?php echo lang('index_groups_th');?></th>
        <th><?php echo lang('index_status_th');?></th>
        <th><?php echo lang('index_action_th');?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user):?>
            <tr class="text-left">
                <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                <td>
                    <?php foreach ($user->groups as $group):?>
                        <?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
                    <?php endforeach?>
                </td>
                <td><?php echo ($user->active) ?
                    anchor("auth/deactivate/".$user->id, lang('index_active_link')) :
                    anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                <td><?php echo anchor("auth/edit_user/".$user->id, 'Editar') ;?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<div class="btn-group" role="group">
    <?php
        echo anchor('auth/create_user',
                        lang('index_create_user_link'),
                        array(
                            'title' => lang('index_create_user_link'),
                            'class' => 'btn btn-primary',
                            'role' => 'button'
                        )
                    );

        echo anchor('auth/create_group',
                        lang('index_create_group_link'),
                        array(
                            'title' => lang('index_create_group_link'),
                            'class' => 'btn btn-primary',
                            'role' => 'button'
                        )
                    );
    ?>
</div>