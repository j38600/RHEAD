<div class="container-fluid">
    <div class="row">
        <h2>Listagem das Indisponibilidades</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Razão</th>
                <th>Nr. de militares</th>
                <th>Data de início</th>
                <th>Data de fim</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($dispensas as $dispensa):?>
                    <tr>
                        <td><?php echo $dispensa['razao'];?></td>
                        <td><?php echo $dispensa['nr_militares'];?></td>
                        <td><?php echo date('d H:i M Y', strtotime($dispensa['gdh_inicio']));?></td>
                        <td><?php echo date('d H:i M Y', strtotime($dispensa['gdh_fim']));?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($permissoes['admin']){
                                    echo anchor(
                                        'escala/dispensa/view/'.$dispensa['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success btn-block',
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
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($permissoes['admin']){
                                echo anchor(
                                    'escala/dispensa/nova',
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
