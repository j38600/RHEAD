<div class="container-fluid">
    <div class="row">
        <h2>Listagem dos militares</h2>
        <a class="btn btn-primary btn-outline" role="button" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
          Filtros
        </a>
        <div class="collapse" id="collapseExample1">
          <div class="well">
              <?php echo form_open('militar', ['class' => 'form-horizontal, form-inline',
                                                        'role' => 'form']); ?>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Posto</div>
                <?php 
                echo form_dropdown('posto_id',$postos,'','class="form-control"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Quartel</div>
                <?php 
                echo form_dropdown('quartel_id',$quarteis,'','class="form-control"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Companhia</div>
                <?php 
                echo form_dropdown('companhia_id',$companhias,'','class="form-control"');?>
                </div>
              </div>
              <div class="form-group">
                  <div class="checkbox">
                    <?php echo form_checkbox('ativo','').' Fora do ativo';?>
                  </div>
              </div>
              <button type="submit" class="btn btn-default">Filtrar</button>
            <?php
            echo form_close();
            ?>
          </div>
        </div>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>NIM</th>
                <th>Posto</th>
                <th class="text-right">Nome</th>
                <th>Apelido</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($militares as $militar):?>
                    <tr>
                        <td><?php echo $militar['nim'];?></td>
                        <td><?php echo $militar['posto_abreviatura'];?></td>
                        <td class="text-right"><?php echo $militar['nome'];?></td>
                        <td><?php echo $militar['apelido'];?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                $classe = ($permissoes['secpess']) ? 'col-xs-6' : 'col-xs-12';
                                    echo anchor(
                                        'militar/view/'.$militar['nim'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success '.$classe,
                                            'role' => 'button'
                                        )
                                    );
                                if ($permissoes['secpess']){
                                    echo anchor(
                                        'militar/edit/'.$militar['nim'],
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
