<div class="container-fluid">
    <div class="row">
        <h2>Listagem de atividades previstas / realizadas</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>De</th>
                <th>Até</th>
                <th>Secção BipBip</th>
                <th>Secção Anuário</th>
                <tH></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($atividades as $atividade):?>
                    <tr>
                        <td><?php echo $atividade['descricao'];?></td>
                        <td><?php echo date('d-m-Y', strtotime($atividade['de']));?></td>
                        <td><?php echo date('d-m-Y', strtotime($atividade['ate']));?></td>
                        <td><?php echo $atividade['seccao_bipbip'];?></td>
                        <td><?php echo $atividade['seccao_anuario'];?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                $classe = ($permissoes['secpess']) ? 'col-xs-6' : 'col-xs-12';
                                    echo anchor(
                                        'militar/view/'.$atividade['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success '.$classe,
                                            'role' => 'button'
                                        )
                                    );
                                if ($permissoes['secpess']){
                                    echo anchor(
                                        'militar/edit/'.$atividade['id'],
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($permissoes['secpess']){
                                echo anchor(
                                    'militar/novo',
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
