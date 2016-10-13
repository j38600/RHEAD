<div class="container-fluid">
    <div class="row">
        <h2>Listagem dos feriados(dias de atividade reduzida / escala B)</h2>
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
                                        'escala/feriado/edit/'.$feriado['id'],
                                        '<span class="glyphicon glyphicon-pencil"></span> Atualizar',
                                        array(
                                            'title' => 'Atualizar',
                                            'class' => 'btn btn-outline btn-warning btn-block',
                                            'role' => 'button'
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
                                    'escala/feriado/novo',
                                    '<span class="glyphicon glyphicon-plus"></span> Novo',
                                    array(
                                        'title' => 'Novo',
                                        'class' => 'btn btn-outline btn-primary btn-block',
                                        'role' => 'button'
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
