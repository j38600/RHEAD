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
                    echo form_open('escala/dispensa/associar', ['class' => 'form-horizontal',
                                                                'role' => 'form']);
                    echo form_hidden('indisponibilidade_id', $dispensa['id']);
                ?>
                <div class="form-group">
                    <label for="de" class="col-xs-offset-1 col-xs-4 control-label">Militar</label>
                    <div class="col-xs-6">
                    <?php echo form_dropdown('militar_nim',$option_militares,'','class="form-control"'); ?>
                    </div>
                </div>
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

<h2 class="text-center"><?php echo $dispensa['razao'].', com início em '.date('d H:i M Y', strtotime($dispensa['gdh_inicio']));?></h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Militares associados</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($militares as $militar):
                        echo anchor(
                            'militar/view/'.$militar['nim'],
                            $militar['posto_abreviatura'].' '.$militar['nim'].' '.$militar['apelido'],
                            array(
                                'class' => 'list-group-item',
                            )
                        );
                    endforeach;
                    if ($permissoes['secpess']) {
                        echo anchor(
                            '#caixaNIMs',
                            'Associar novo militar',
                            array(
                                'class' => 'list-group-item list-group-item-success',
                                'role' => 'button',
                                'data-toggle' => 'modal',
                            )
                        );
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalhes</h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Razão</dt>
                        <dd><?php echo $dispensa['razao'];?></dd>
                        <dt>GDH de Início</dt>
                        <dd><?php echo date('d H:i M Y', strtotime($dispensa['gdh_inicio']));?></dd>
                        <dt>GDH de Fim</dt>
                        <dd><?php echo date('d H:i M Y', strtotime($dispensa['gdh_fim']));?></dd>
                        <dt>Informações</dt>
                        <dd><?php echo $dispensa['informacao'];?></dd>
                        <dt><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></dt>
                        <dd><a href="<?php echo base_url()?>escala/dispensa/edit/<?php echo $dispensa['id'];?>">Editar</a></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>