<div class="modal fade" id="caixaupdateFERIADO" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atualizar feriado</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('escala/feriado/update', ['class' => 'form-horizontal',
                                                             'role' => 'form']);?>
                <div class="form-group">
                    <label for="nome" class="col-xs-3 control-label">Nome:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'nome',
                            'id' => 'feriadonome',
                            'type' => 'text',
                            'value' => set_value('feriadonome'),
                            'class' => 'form-control feriadonome']
                            ); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data" class="col-xs-3 control-label">Data:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'data',
                            'id' => 'feriadodata',
                            'type' => 'text',
                            'value' => set_value('feriadodata'),
                            'placeholder' => 'aaaa-mm-dd',
                            'class' => 'form-control feriadodata']
                            ); ?>
                    </div>
                </div>
                <?php
                    echo form_input(
                        ['name'  => 'id',
                        'type'  => 'hidden',
                        'class' => 'feriadoid']
                        );
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar feriado</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="caixanovoFERIADO" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Novo feriado</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('escala/feriado/novo', ['class' => 'form-horizontal',
                                                           'role' => 'form']);?>
                <div class="form-group">
                    <label for="nome" class="col-xs-3 control-label">Nome:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'nome',
                            'type' => 'text',
                            'class' => 'form-control']
                            ); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data" class="col-xs-3 control-label">Data:</label>
                    <div class="col-xs-8">
                    <?php echo form_input(
                            ['name' => 'data',
                            'type' => 'text',
                            'placeholder' => 'aaaa-mm-dd',
                            'class' => 'form-control']
                            ); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Criar feriado</button>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid">
    <div class="row">
        <h2>Listagem dos feriados (dias de atividade reduzida / escala B)</h2>
        <?php
        if(isset($erro)){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo 'Operação não foi bem sucedida. Tem que preencher todos os campos do formulário.' ?>
            </div>
        <?php
        }
        ?>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Data</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($feriados as $feriado):?>
                    <tr>
                        <td><?php echo $feriado['nome'];?></td>
                        <td><?php echo date('d M Y', strtotime($feriado['data']));?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($permissoes['admin']){
                                    echo anchor(
                                        '#caixaupdateFERIADO',
                                        '<span class="glyphicon glyphicon-pencil"></span> Atualizar',
                                        array(
                                            'class' => 'btn btn-outline btn-warning btn-block',
                                            'data-toggle' => 'modal',
                                            'data-feriado-id'=>$feriado['id'],
                                            'data-feriado-gdh'=>$feriado['data'],
                                            'data-feriado-nome'=>$feriado['nome']
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
                                    '#caixanovoFERIADO',
                                    '<span class="glyphicon glyphicon-plus"></span> Novo',
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
    $('#caixaupdateFERIADO').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var feriadoid = button.data('feriado-id') // Extract info from data-* attributes
      var feriadodata = button.data('feriado-gdh') // Extract info from data-* attributes
      var feriadonome = button.data('feriado-nome') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.feriadoid').val(feriadoid) //no DOM com class feriadoid o valor da variavel feriadoid
      modal.find('.feriadodata').val(feriadodata) //no DOM com class feriadodata dou o valor da variavel mferiadodata
      modal.find('.feriadonome').val(feriadonome) //no DOM com class feriadonome dou o valor da variavel feriadonome
    })
    $('#caixanovoFERIADO').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
    })
</script>