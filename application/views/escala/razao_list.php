<div class="modal fade" id="caixaupdateRAZAO" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atualizar razão</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('escala/razao/update', ['class' => 'form-horizontal',
                                                             'role' => 'form']);?>
                <div class="form-group">
                    <label for="razao" class="col-xs-3 control-label">Razão:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'razao',
                            'id' => 'razao',
                            'type' => 'text',
                            'value' => set_value('razao'),
                            'class' => 'form-control razao']
                            ); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descricao" class="col-xs-3 control-label">Descrição:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'descricao',
                            'id' => 'descricao',
                            'type' => 'text',
                            'value' => set_value('descricao'),
                            'class' => 'form-control descricao']
                            ); ?>
                    </div>
                </div>
                <?php
                    echo form_input(
                        ['name'  => 'id',
                        'type'  => 'hidden',
                        'class' => 'razaoid']
                        );
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar razão</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="caixanovaRAZAO" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nova Razão</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('escala/razao/nova', ['class' => 'form-horizontal',
                                                         'role' => 'form']);?>
                <div class="form-group">
                    <label for="razao" class="col-xs-3 control-label">Razão:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'razao',
                            'type' => 'text',
                            'class' => 'form-control']
                            ); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descricao" class="col-xs-3 control-label">Descrição:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'descricao',
                            'type' => 'text',
                            'class' => 'form-control']
                            ); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Criar razão</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid">
    <div class="row">
        <h2>Listagem das razões para ficar indisponível ao serviço</h2>
        <?php
        if(isset($erro)){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo 'Operação não foi bem sucedida. Tem que preencher o campo da razão.' ?>
            </div>
        <?php
        }
        ?>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Razão</th>
                <th>Descrição</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($razoes as $razao):?>
                    <tr>
                        <td><?php echo $razao['razao'];?></td>
                        <td><?php echo $razao['descricao'];?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($permissoes['admin']){
                                    echo anchor(
                                        '#caixaupdateRAZAO',
                                        '<span class="glyphicon glyphicon-pencil"></span> Atualizar',
                                        array(
                                            'class' => 'btn btn-outline btn-warning btn-block',
                                            'data-toggle' => 'modal',
                                            'data-razao-id'=>$razao['id'],
                                            'data-razao'=>$razao['razao'],
                                            'data-descricao'=>$razao['descricao']
                                        )
                                    );
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($permissoes['admin']){
                                echo anchor(
                                    '#caixanovaRAZAO',
                                    '<span class="glyphicon glyphicon-plus"></span> Nova',
                                    array(
                                        'class' => 'btn btn-outline btn-primary btn-block',
                                        'data-toggle' => 'modal'
                                    )
                                );
                            }
                            ?>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>

<script>//pega no id, nome e data do feriado, e envia para o modal.
    $('#caixaupdateRAZAO').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var razaoid = button.data('razao-id') // Extract info from data-* attributes
      var razao = button.data('razao') // Extract info from data-* attributes
      var descricao = button.data('descricao') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.razaoid').val(razaoid) //no DOM com class feriadoid o valor da variavel feriadoid
      modal.find('.razao').val(razao) //no DOM com class feriadodata dou o valor da variavel mferiadodata
      modal.find('.descricao').val(descricao) //no DOM com class feriadonome dou o valor da variavel feriadonome
    })
    $('#caixanovaRAZAO').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
    })
</script>