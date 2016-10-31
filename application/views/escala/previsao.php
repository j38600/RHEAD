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
                                echo $militar['nim'];
                                echo br();
                            }
                        ?></td>
                        <td><?php
                            foreach ($reserva[$dia] as $militar)
                            {
                                echo $militar['nim'];
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