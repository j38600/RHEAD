<div class="modal fade" id="caixaNIMs" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selecione o NIM do militar</h4>
            </div>
            <div class="modal-body">
                <?php   $option_militares = array();
                    foreach ($todos_militares as $um_militar){
                        $option_militares[$um_militar['nim']] = $um_militar['nim'].' '.$um_militar['posto_abreviatura'].' '.$um_militar['apelido'];
                    }
                    echo form_open('medalha/atribuir', ['class' => 'form-horizontal',
                                                        'role' => 'form']);
                    echo form_hidden('med_cond_id', $medalha['id']);
                    echo form_dropdown('militar_nim',$option_militares,'','class="form-control"');
                ?>
            </div>
            <div class="modal-footer">
                <?php
                    echo anchor(
                        'militar/novo/',
                        'Criar militar',
                        array(
                            'class' => 'btn btn-success',
                        )
                    );
                ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar informação</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h2 class="text-center">Listagens de medalhas e condecorações</h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">por receber</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($medalhas as $medalha):?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo $medalha['nome'];?></h4>
                            <p class="list-group-item-text">
                            <?php
                            foreach ($nims_por_receber as $militar):
                                if ($militar['med_cond_id'] == $medalha['id']){
                                    echo anchor(
                                        'militar/view/'.$militar['militar_nim'],
                                        $militar['militar_nim'].' '.$militar['posto_abreviatura'].' '.$militar['militar_apelido'],
                                        array(
                                            'class' => 'list-group-item',
                                        )
                                    );
                                    //$militar['impor_proxima_cerimonia']
                                    //echo $militar['militar_nim'].' '.$militar['posto_abreviatura'].' '.$militar['militar_apelido'];
                                    //echo br();
                                }
                            endforeach;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">por impor</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($medalhas as $medalha):?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo $medalha['nome'];?></h4>
                            <p class="list-group-item-text">
                            <?php
                            foreach ($nims_por_impor as $militar):
                                if ($militar['med_cond_id'] == $medalha['id']){
                                    echo anchor(
                                        'militar/view/'.$militar['militar_nim'],
                                        $militar['militar_nim'].' '.$militar['posto_abreviatura'].' '.$militar['militar_apelido'],
                                        array(
                                            'class' => 'list-group-item',
                                        )
                                    );
                                    //echo $militar['militar_nim'].' '.$militar['posto_abreviatura'].' '.$militar['militar_apelido'];
                                    //echo br();
                                }
                            endforeach;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>