<div class="modal fade" id="caixaGDH" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Insira a informação nova</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('medalha/alterarGDH/'.$id, ['class' => 'form-horizontal',
                                                          'role' => 'form']);?>
                <div class="form-group">
                    <label for="GDH" class="col-xs-3 control-label">Data:</label>
                    <div class="col-xs-8">
                    <?php echo form_input([ 'name' => 'GDH',
                                            'id' => 'GDH',
                                            'placeholder' => 'AAAA-MM-DD',
                                            'type' => 'date',
                                            'class' => 'form-control']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="informacao" class="col-xs-3 control-label">Informações:</label>
                    <div class="col-xs-8">
                    <?php echo form_textarea(
                            ['name' => 'informacao',
                            'id' => 'informacao',
                            'type' => 'text',
                            'value' => set_value('informacao'),
                            'rows' => '3',
                            'class' => 'form-control informacao']
                            ); ?>
                    </div>
                </div>
                <?php
                    echo form_input(
                        ['name'  => 'operacao',
                        'type'  => 'hidden',
                        'class' => 'operacao',]
                        );
                    echo form_input(
                        ['name'  => 'medalha',
                        'type'  => 'hidden',
                        'class' => 'medalha',]
                        );
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar informação</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="caixaINFORMACAO" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selecione o NIM do militar</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('medalha/atribuir', ['class' => 'form-horizontal',
                                                        'role' => 'form']);
                    echo form_hidden('med_cond_id', $medalha['id']);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar informação</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid">
    <div class="row">
        <h2 class="text-center">Informações do <?php echo $militar['posto_nome'].' '.$militar['nim'].' '.$militar['apelido'];?></h2>
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
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Informações pessoais</h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Posto</dt>
                        <dd><?php echo $militar['posto_nome'];?></dd>
                        <dt>NIM</dt>
                        <dd><?php echo $militar['nim'];?></dd>
                        <dt>Nome completo</dt>
                        <dd><?php echo $militar['nome'].' '.$militar['apelido'];?></dd>
                        <dt>Companhia</dt>
                        <dd><?php echo $militar['companhia_nome'];?></dd>
                        <dt>Quartel</dt>
                        <dd><?php echo $militar['quartel_nome'];?></dd>
                        <dt>Antiguidade</dt>
                        <dd><?php echo date('d-m-Y', strtotime($militar['antiguidade']));?></dd>
                        <dt>Nota de curso</dt>
                        <dd><?php echo $militar['nota_curso'];?></dd>
                        <dt>Ativo?</dt>
                        <dd><?php echo ($militar['ativo']) ? 'Sim' : 'Não';?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Medalhas e condecorações</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($medalhas as $medalha):?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo $medalha['med_cond_nome'];?></h4>
                            <p class="list-group-item-text">
                                <?php
                                if ($medalha['pedida']){
                                    echo 'Pedida em '.date('d-m-Y', strtotime($medalha['data_pedida']));
                                    echo br();
                                }
                                else{
                                    echo anchor(
                                        '#caixaGDH',
                                        'Inserir data pedida',
                                        array(
                                            'class' => 'list-group-item list-group-item-warning',
                                            'role' => 'button',
                                            'data-toggle' => 'modal',
                                            'data-medalha-id'=>$medalha['med_cond_id'],
                                            'data-operacao'=>'pedida',
                                            'data-informacao'=>$medalha['informacao'],
                                        )
                                    );
                                }
                                if ($medalha['recebida']){
                                    echo 'Recebida em '.date('d-m-Y', strtotime($medalha['data_recebida']));
                                    echo br();
                                }
                                else{
                                    echo anchor(
                                        '#caixaGDH',
                                        'Inserir data recebida',
                                        array(
                                            'class' => 'list-group-item list-group-item-warning',
                                            'role' => 'button',
                                            'data-toggle' => 'modal',
                                            'data-medalha-id'=>$medalha['med_cond_id'],
                                            'data-operacao'=>'recebida',
                                            'data-informacao'=>$medalha['informacao'],
                                        )
                                    );
                                }
                                if ($medalha['imposta']){
                                    echo 'Imposta em '.date('d-m-Y', strtotime($medalha['data_imposta']));
                                    echo br();
                                }
                                else{
                                    echo anchor(
                                        '#caixaGDH',
                                        'Inserir data imposta',
                                        array(
                                            'class' => 'list-group-item list-group-item-warning',
                                            'role' => 'button',
                                            'data-toggle' => 'modal',
                                            'data-medalha-id'=>$medalha['med_cond_id'],
                                            'data-operacao'=>'imposta',
                                            'data-informacao'=>$medalha['informacao'],
                                        )
                                    );
                                }
                                if ($medalha['informacao']){
                                    echo anchor(
                                        '#',
                                        'Informações',
                                        array(
                                            'class' => 'alert-link',
                                        )
                                    );
                                    echo ': '.$medalha['informacao'];
                                }
                                else{
                                    echo anchor(
                                        '#caixaINFORMACAO',
                                        'Inserir informações',
                                        array(
                                            'class' => 'list-group-item list-group-item-warning',
                                            'role' => 'button',
                                            'data-toggle' => 'modal',
                                        )
                                    );
                                }
                                ?>
                            </p>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>


<script>//pega no id da medalha e na operacao desejada, e envia para o modal.
    $('#caixaGDH').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var medalha_id = button.data('medalha-id') // Extract info from data-* attributes
      var operacao = button.data('operacao') // Extract info from data-* attributes
      var informacao = button.data('informacao') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.operacao').val(operacao) //no DOM com classe operacao dou o valor da variavel operacao
      modal.find('.informacao').val(informacao) //no DOM com classe operacao dou o valor da variavel operacao
      modal.find('.medalha').val(medalha_id) //no DOM com classe medalha dou o valor da variavel medalha_id
    })
</script>