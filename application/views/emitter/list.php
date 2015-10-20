<div class="container-fluid">
    <div class="row">
        <h2>Listagem dos emissores</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Latitude, Longitude</th>
                <th>Tipo</th>
                <th>Gama de Frequências</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($emissores as $emissor):?>
                    <tr>
                        <td><?php echo $emissor['nome'];?></td>
                        <td><?php echo $emissor['lat'].', '.$emissor['lon'];?></td>
                        <td><?php echo $emissor['tipologia'];?></td>
                        <td><?php echo $emissor['freq_min'].'Khz até '.$emissor['freq_max'].'KHz';?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($admin){
                                    echo anchor(
                                        'emitter/'.$emissor['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Novo',
                                            'class' => 'btn btn-outline btn-success col-xs-6',
                                            'role' => 'button'
                                        )
                                    );
                                    echo anchor(
                                        'emitter/apaga/'.$emissor['id'],
                                        '<span class="glyphicon glyphicon-remove"></span> Apagar',
                                        array(
                                            'title' => 'Novo',
                                            'class' => 'btn btn-outline btn-danger col-xs-6',
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
                            if ($admin){
                                echo anchor(
                                    'emitter/novo',
                                    '<span class="glyphicon glyphicon-plus"></span> Novo',
                                    array(
                                        'title' => 'Novo',
                                        'class' => 'btn-block btn btn-primary btn-outline',
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
