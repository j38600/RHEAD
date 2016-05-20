<div class="container-fluid">
    <div class="row">
        <h2>Listagem de medalhas e condecorações</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Nr. de militares</th>
                <th>Stock</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($medalhas as $medalha):?>
                    <tr>
                        <td><abbr title='<?php echo $medalha['descricao'];?>'><?php echo $medalha['nome'];?></abbr></td>
                        <td><?php echo $medalha['nr_militares'];?></td>
                        <td><?php echo $medalha['stock'];?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                    echo anchor(
                                        'medalha/view/'.$medalha['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success btn-block',
                                            'role' => 'button'
                                        )
                                    );
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($permissoes['secpess']) {
                                echo anchor(
                                    'medalha/novo/',
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
