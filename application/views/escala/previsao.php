<div class="container-fluid">
    <div class="row">
        <h2>Previsao da escala de <?php echo $escala['nome'];?></h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Nr. de militares</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($escalas as $escala):?>
                    <tr>
                        <td><?php echo $escala['nome'];?></td>
                        <td><?php echo $escala['nr_militares'];?></td>
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
                <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($permissoes['admin']){
                                echo anchor(
                                    'escala/nova',
                                    '<span class="glyphicon glyphicon-plus"></span> Nova',
                                    array(
                                        'title' => 'Nova',
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