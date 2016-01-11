<div class="container-fluid">
    <div class="row">
        <h2>Listagem de medalhas e condecorações</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Nr. de militares</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($medalhas as $medalha):?>
                    <tr>
                        <td><?php echo $medalha['nome'];?></td>
                        <td><?php echo $medalha['nr_militares'];?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($admin){
                                    echo anchor(
                                        'medalha/view/'.$medalha['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success col-xs-6',
                                            'role' => 'button'
                                        )
                                    );
                                    echo anchor(
                                        'medalha/edit/'.$medalha['id'],
                                        '<span class="glyphicon glyphicon-pencil"></span> Atualizar',
                                        array(
                                            'title' => 'Atualizar',
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
                            if ($admin){
                                echo anchor(
                                    'medalha/novo/',
                                    '<span class="glyphicon glyphicon-plus"></span> Novo',
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
