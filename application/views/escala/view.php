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
                    echo form_open('escala/associar', ['class' => 'form-horizontal',
                                                        'role' => 'form']);
                    echo form_hidden('escala_id', $escala['id']);
                ?>

                <div class="form-group">
                    <label for="de" class="col-xs-offset-1 col-xs-4 control-label">Militar</label>
                    <div class="col-xs-6">
                    <?php echo form_dropdown('militar_nim',$option_militares,'','class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gdh_ultimo" class="col-xs-offset-1 col-xs-4 control-label">Data de último serviço</label>
                    <div class="col-xs-4">
                    <?php echo form_input([ 'name' => 'gdh_ultimo',
                                            'id' => 'gdh_ultimo',
                                            'type' => 'date',
                                            'value' => set_value('gdh_ultimo'),
                                            'class' => 'form-control']); ?>
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

<div class="modal fade" id="caixaTROCAS" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selecione os militares</h4>
            </div>
            <div class="modal-body">
                <?php   $option_militares = array();
                    foreach ($todos_militares as $um_militar){
                        $option_militares[$um_militar['nim']] = $um_militar['nim'].' '.$um_militar['posto_abreviatura'].' '.$um_militar['apelido'];
                    }
                    echo form_open('escala/troca/nova', ['class' => 'form-horizontal',
                                                        'role' => 'form']);
                    echo form_hidden('escala_id', $escala['id']);
                ?>

                <div class="form-group">
                    <label for="de" class="col-xs-offset-1 col-xs-4 control-label">Militar nomeado</label>
                    <div class="col-xs-6">
                    <?php echo form_dropdown('militar_nim_um',$option_militares,'','class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="de" class="col-xs-offset-1 col-xs-4 control-label">Militar voluntário</label>
                    <div class="col-xs-6">
                    <?php echo form_dropdown('militar_nim_dois',$option_militares,'','class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar informação</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h2 class="text-center">Escala de <?php echo $escala['nome'];?></h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Trocas e Destrocas</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-right">NIM 1</th>
                                <th></th>
                                <th>NIM 2</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trocas as $troca):?>
                                    <tr>
                                        <td class="text-right">
                                            <?php echo ($troca['gdh_troca']) ? $troca['militar_nim_dois'] : $troca['militar_nim_um'];?>
                                        </td>
                                        <td class="text-center"><?php echo ($troca['gdh_troca']) ? 'PD' : 'PT';?></td>
                                        <td>
                                            <?php echo ($troca['gdh_troca']) ? $troca['militar_nim_um'] : $troca['militar_nim_dois'];?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                    </table>
                    <?php
                    if ($permissoes['secpess']) {
                        echo anchor(
                            '#caixaTROCAS',
                            'Adicionar uma troca',
                            array(
                                'class' => 'list-group-item list-group-item-success',
                                'role' => 'button',
                                'data-toggle' => 'modal',
                            )
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
                        <dt>Diário</dt>
                        <dd><?php echo ($escala['diario']) ? 'Sim' : 'Não';?></dd>
                        <dt>Tipo</dt>
                        <dd><?php echo ($escala['semana']) ? 'Semana' : 'Fim de semana';?></dd>
                        <dt>Militares a nomear</dt>
                        <dd><?php echo $escala['numero_nomeados'];?></dd>
                        <dt>Hora de Início</dt>
                        <dd><?php echo date('h:i', strtotime($escala['hora_inicio']));?></dd>
                        <dt>Hora de Fim</dt>
                        <dd><?php echo date('h:i', strtotime($escala['hora_fim']));?></dd>
                        <dt>Duração em horas</dt>
                        <dd><?php echo $escala['horas_duracao'];?></dd>
                        <dt><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></dt>
                        <dd><a href="<?php echo base_url()?>escala/edit/<?php echo $escala['id'];?>">Editar</a></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>