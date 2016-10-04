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
                    echo form_open('atividade/associar', ['class' => 'form-horizontal',
                                                        'role' => 'form']);
                    echo form_hidden('atividade_id', $atividade['id']);
                ?>

                <div class="form-group">
                    <label for="de" class="col-xs-offset-1 col-xs-4 control-label">Militar</label>
                    <div class="col-xs-6">
                    <?php echo form_dropdown('militar_nim',$option_militares,'','class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gdh_inicio" class="col-xs-offset-1 col-xs-4 control-label">Data de início</label>
                    <div class="col-xs-4">
                    <?php echo form_input([ 'name' => 'gdh_inicio',
                                            'id' => 'gdh_inicio',
                                            'type' => 'date',
                                            'value' => set_value('gdh_inicio'),
                                            'class' => 'form-control']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gdh_fim" class="col-xs-offset-1 col-xs-4 control-label">Data de fim</label>
                    <div class="col-xs-4">
                    <?php echo form_input([ 'name' => 'gdh_fim',
                                            'id' => 'gdh_fim',
                                            'type' => 'date',
                                            'value' => set_value('gdh_fim'),
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

<h2 class="text-center"><?php echo $atividade['descricao'];?></h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Militares envolvidos</h3>
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
                    //var_dump($atividade);
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
                    <h3 class="panel-title">Informações</h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>De:</dt>
                        <dd><?php echo date('d-m-Y', strtotime($atividade['de']));?></dd>
                        <dt>Até: </dt>
                        <dd><?php echo date('d-m-Y', strtotime($atividade['ate']));?></dd>
                        <dt>Cancelada?</dt>
                        <dd><?php echo ($atividade['cancelada']) ? 'Sim' : 'Não';?></dd>
                        <dt>Cobertura fotográfica?</dt>
                        <dd><?php echo ($atividade['fotografias']) ? 'Sim' : 'Não';?></dd>
                        <dt>Rel. Empenham. Op.:</dt>
                        <dd><?php echo ($atividade['rel_empenhamento_op']) ? 'Feito' : 'Por fazer';?></dd>
                        <dt>Secção Bipbip:</dt>
                        <dd><?php echo $atividade['seccao_bipbip'];?></dd>
                        <dt>Secção Anuário:</dt>
                        <dd><?php echo $atividade['seccao_anuario'];?></dd>
                        <dt>Notícia:</dt>
                        <dd><?php echo $atividade['noticia'];?></dd>
                        <dt><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></dt>
                        <dd><a href="<?php echo base_url()?>atividade/edit/<?php echo $atividade['id'];?>">Editar</a></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>