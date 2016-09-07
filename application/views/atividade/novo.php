<div class="container-fluid">
    <div class="row">
        <h3 class="text-center">Adicionar nova atividade</h3>
        <?php
        if(validation_errors()){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <?php echo validation_errors() ?>
            </div>
        <?php
        }

        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
                
        echo form_open('atividade/nova', ['class' => 'form-horizontal',
                                          'role' => 'form']); ?>
        <div class="form-group">
            <label for="descricao" class="col-xs-offset-3 col-xs-2 control-label">Descrição</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'descricao',
                                    'id' => 'descricao',
                                    'type' => 'text',
                                    'value' => set_value('descricao'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="de" class="col-xs-offset-3 col-xs-2 control-label">Data de início</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'de',
                                    'id' => 'de',
                                    'type' => 'date',
                                    'value' => set_value('de'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="ate" class="col-xs-offset-3 col-xs-2 control-label">Data de fim</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'ate',
                                    'id' => 'ate',
                                    'type' => 'date',
                                    'value' => set_value('ate'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="sircape" class="col-xs-offset-3 col-xs-2 control-label">SIRCAPE</label>
            <div class="col-xs-4">
            <?php
                echo form_radio('sircape', TRUE).' inserida ';
                echo form_radio('sircape', FALSE).' por inserir ';
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="quartel_id" class="col-xs-offset-3 col-xs-2 control-label">Unidade/Estabelecimento/Órgão</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('quarteis_id',$quarteis,'','class="form-control"');?>
            </div>
        </div>
        <div class="form-group">
            <label for="bipbip_id" class="col-xs-offset-3 col-xs-2 control-label">Secção BipBip</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('bipbip_id',$bipbips,'','class="form-control"');?>
            </div>
        </div>
        <div class="form-group">
            <label for="anuario_id" class="col-xs-offset-3 col-xs-2 control-label">Secção Anuário</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('anuario_id',$anuarios,'','class="form-control"');?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-5 col-xs-4">
                <button class="btn btn-primary" type="submit" name="submit">Adicionar</button>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>