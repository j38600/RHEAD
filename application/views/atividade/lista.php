<div class="container-fluid">
    <div class="row">
        <h2>Listagem de atividades previstas / realizadas</h2>
        <a class="btn btn-primary btn-outline" role="button" data-toggle="collapse" href="#filtros" aria-expanded="false" aria-controls="collapseExample">
          Filtros
        </a>
        <div class="collapse" id="filtros">
          <div class="well">
              <?php echo form_open('atividade', ['class' => 'form-horizontal, form-inline',
                                                        'role' => 'form']); ?>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">De</div>
                    <?php echo form_input([ 'name' => 'de',
                                            'id' => 'de',
                                            'type' => 'date',
                                            'value' => set_value('de'),
                                            'class' => 'form-control']); ?>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Até</div>
                    <?php echo form_input([ 'name' => 'ate',
                                            'id' => 'ate',
                                            'type' => 'date',
                                            'value' => set_value('ate'),
                                            'class' => 'form-control']); ?>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Bipbip</div>
                <?php 
                echo form_dropdown('bipbip_id',$bipbips,'','class="form-control"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Anuário</div>
                <?php 
                echo form_dropdown('anuario_id',$anuarios,'','class="form-control"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">Cancelada:</div>
                <?php 
                echo form_dropdown('cancelada',$canceladas,'','class="form-control"');?>
                </div>
              </div>
              <button type="submit" class="btn btn-default">Filtrar</button>
            <?php
            echo form_close();
            ?>
          </div>
        </div><!--
        <div class="collapse" id="collapseExample2">
          <div class="well">
            <form class="form-inline">
              <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                <div class="input-group">
                  <div class="input-group-addon">Bipbip</div>
                  <select class="form-control">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                <div class="input-group">
                  <div class="input-group-addon">Anuário</div>
                  <select class="form-control">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                <div class="input-group">
                  <div class="input-group-addon">Relatório Semanal BrigInt/G9</div>
                  <select class="form-control">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                </div>
              </div>
              <button type="submit" class="btn btn-default">Exportar RTF</button>
            </form>
          </div>
        </div> -->
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>De</th>
                <th>Até</th>
                <th>Nr. de Militares</th>
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
                        <td><?php echo $atividade['nr_militares'];?></td>
                        <td><?php echo $atividade['seccao_bipbip'];?></td>
                        <td><?php echo $atividade['seccao_anuario'];?></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php
                                if ($permissoes['sois'] || $permissoes['secpess']){
                                    echo anchor(
                                        'atividade/view/'.$atividade['id'],
                                        '<span class="glyphicon glyphicon-eye-open"></span> Consultar',
                                        array(
                                            'title' => 'Consultar',
                                            'class' => 'btn btn-outline btn-success col-xs-12',
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
                            if ($permissoes['secpess'] || $permissoes['sois']){
                                echo anchor(
                                    'atividade/nova',
                                    '<span class="glyphicon glyphicon-plus"></span> Nova',
                                    array(
                                        'title' => 'Nova',
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
