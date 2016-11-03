<div class="modal fade" id="caixaNOMEAR" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirma nomeação para próximo serviço?</h4>
            </div>
            <div class="modal-body">
                <?php
                    echo form_open('escala/nomear/', ['class' => 'form-horizontal',
                                                      'role' => 'form']);
                    echo form_hidden('escala_id', $escala['id']);
                    echo form_input(
                        ['name'  => 'nomeado',
                        'type'  => 'hidden',
                        'value' => set_value('nomeado'),
                        'class' => 'nomeado']
                        );
                    echo form_input(
                        ['name'  => 'militar_nim',
                        'type'  => 'hidden',
                        'value' => set_value('militar_nim'),
                        'class' => 'militar_nim']
                        );
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar informação</button>
                <?php echo form_close();?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid">
    <div class="row">
        <h2>Previsao da escala de <?php echo $escala['nome'];?></h2>
        <h4><?php
            echo $escala['numero_nomeados'].' militares por dia; ';
            echo ($escala['diario']) ? 'Diário; ' : 'Não diário; ';
            echo ($escala['semana']) ? 'Escala A (semana); ' : 'Escala B (fdsemana/feriado); ';
        ?></h4>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Dia</th>
                <th>Previsto(s)</th>
                <th>Reserva(s)</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($previsto as $dia=>$militares):?>
                    <tr>
                        <td><?php echo $dia;?></td>
                        <td><?php
                            foreach ($militares as $militar)
                            {
                                echo anchor(
                                    '#caixaNOMEAR',
                                    $militar['posto_abreviatura'].' '.$militar['nim'].' '.$militar['apelido'],
                                    array(
                                        'class' => ($militar['nomeado'] ? 'bg-primary' : 'bg-info'),
                                        'data-toggle' => 'modal',
                                        'data-militar-nim'=>$militar['nim'],
                                        'data-nomeado'=>$militar['nomeado']
                                    )
                                );
                                //echo $militar['nim'];
                                echo br();
                            }
                        ?></td>
                        <td><?php
                            foreach ($reserva[$dia] as $militar)
                            {
                                echo anchor(
                                    'militar/view/'.$militar['nim'],
                                    $militar['posto_abreviatura'].' '.$militar['nim'].' '.$militar['apelido'],
                                    array(
                                        'class' => 'bg-danger'
                                    )
                                );
                                echo br();
                            }
                        ?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($permissoes['admin']){
                                    echo anchor(
                                        'escala/view/'.$escala['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success col-xs-6',
                                            'role' => 'button'
                                        )
                                    );
                                    echo anchor(
                                        'escala/previsao/'.$escala['id'],
                                        '<span class="glyphicon glyphicon-list-alt"></span> Previsão',
                                        array(
                                            'title' => 'Previsão',
                                            'class' => 'btn btn-outline btn-warning col-xs-6',
                                            'role' => 'button'
                                        )
                                    );
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<script>//pega no id da escala, no nim do militar e altero o estado do campo nomeado.
    $('#caixaNOMEAR').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var nomeado = button.data('nomeado') // Extract info from data-* attributes
      var militar_nim = button.data('militar-nim') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.militar_nim').val(militar_nim) //no DOM com class medalha dou o valor da variavel medalha_id
      modal.find('.nomeado').val(nomeado) //no DOM com proximacerimonia dou o valor da variavel proxima_cerimonia
    })
</script>