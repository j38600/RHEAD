<div class="container-fluid">
    <div class="row">
        <h3 class="text-center">Atualizar informações</h3>
        <?php
        if(validation_errors()){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo validation_errors() ?>
            </div>
        <?php
        }

        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
                
        echo form_open('atividade/edit/'.$id, ['class' => 'form-horizontal',
                                               'role' => 'form']);
        echo form_hidden ('id',$id);?>
        <div class="form-group">
            <label for="descricao" class="col-xs-offset-3 col-xs-2 control-label">Descrição</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'descricao',
                                    'id' => 'descricao',
                                    'type' => 'text',
                                    'value' => $atividade['descricao'],
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="de" class="col-xs-offset-3 col-xs-2 control-label">Data de início</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'de',
                                    'id' => 'de',
                                    'type' => 'date',
                                    'value' => date('Y-m-d',strtotime($atividade['de'])),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="ate" class="col-xs-offset-3 col-xs-2 control-label">Data de fim</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'ate',
                                    'id' => 'ate',
                                    'type' => 'date',
                                    'value' => date('Y-m-d',strtotime($atividade['ate'])),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="cancelada" class="col-xs-offset-3 col-xs-2 control-label">Cancelada</label>
            <div class="col-xs-4">
            <?php
                echo form_radio('cancelada', 1, $atividade['cancelada']).' Sim ';
                echo form_radio('cancelada', 0, !$atividade['cancelada']).' Não ';
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="rel_empenhamento_op" class="col-xs-offset-3 col-xs-2 control-label">Rel. Empenhamento Op.</label>
            <div class="col-xs-4">
            <?php
                echo form_radio('rel_empenhamento_op', 1, $atividade['rel_empenhamento_op']).' feito ';
                echo form_radio('rel_empenhamento_op', 0, !$atividade['rel_empenhamento_op']).' por fazer ';
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="fotografias" class="col-xs-offset-3 col-xs-2 control-label">Cobertura fotográfica</label>
            <div class="col-xs-4">
            <?php
                echo form_radio('fotografias', 1, $atividade['fotografias']).' Sim ';
                echo form_radio('fotografias', 0, !$atividade['fotografias']).' Não ';
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="noticia" class="col-xs-offset-3 col-xs-2 control-label">Notícia:</label>
            <div class="col-xs-4">
            <?php echo form_textarea(
                    ['name' => 'noticia',
                    'id' => 'noticia',
                    'type' => 'text',
                    'value' => $atividade['noticia'],
                    'rows' => '6',
                    'class' => 'form-control']
                    ); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="quartel_id" class="col-xs-offset-3 col-xs-2 control-label">Unidade/Estabelecimento/Órgão</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('quarteis_id', $quarteis, $atividade['quarteis_id'], 'class="form-control"');?>
            </div>
        </div>
        <div class="form-group">
            <label for="bipbip_id" class="col-xs-offset-3 col-xs-2 control-label">Secção BipBip</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('bipbip_id', $bipbips, $atividade['bipbip_id'], 'class="form-control"');?>
            </div>
        </div>
        <div class="form-group">
            <label for="anuario_id" class="col-xs-offset-3 col-xs-2 control-label">Secção Anuário</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('anuario_id', $anuarios, $atividade['anuario_id'], 'class="form-control"');?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-5 col-xs-4">
                <button class="btn btn-primary" type="submit" name="submit">Atualizar</button>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>