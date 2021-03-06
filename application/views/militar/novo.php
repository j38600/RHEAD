<div class="container-fluid">
    <div class="row">
        <h3 class="text-center">Adicionar informações do novo militar</h3>
        <?php
        if(validation_errors()){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo validation_errors() ?>
            </div>
        <?php
        }

        $this->form_validation->set_rules('nim', 'Número de Indentificação Militar', 'trim|required');
        $this->form_validation->set_rules('nome', 'Nome Completo', 'trim|required');
        $this->form_validation->set_rules('apelido', 'Apelido', 'trim|required');
        $this->form_validation->set_rules('antiguidade', 'Antiguidade', 'trim|required');
        $this->form_validation->set_rules('nota_curso', 'Nota de Curso', 'trim|required');

        echo form_open('militar/novo', ['class' => 'form-horizontal',
                                              'role' => 'form']); ?>
        <div class="form-group">
            <label for="nim" class="col-xs-offset-3 col-xs-2 control-label">NIM</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'nim',
                                    'id' => 'nim',
                                    'type' => 'number',
                                    'value' => set_value('nim'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="nome" class="col-xs-offset-3 col-xs-2 control-label">Nome Completo (exceto Apelido)</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'nome',
                                    'id' => 'nome',
                                    'type' => 'text',
                                    'value' => set_value('nome'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="apelido" class="col-xs-offset-3 col-xs-2 control-label">Apelido</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'apelido',
                                    'id' => 'apelido',
                                    'type' => 'text',
                                    'value' => set_value('apelido'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="antiguidade" class="col-xs-offset-3 col-xs-2 control-label">Data de Promoção</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'antiguidade',
                                    'id' => 'antiguidade',
                                    'type' => 'date',
                                    'value' => set_value('antiguidade'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="nota_curso" class="col-xs-offset-3 col-xs-2 control-label">Nota de Curso (0000-2000)</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'nota_curso',
                                    'id' => 'nota_curso',
                                    'type' => 'decimal',
                                    'value' => set_value('nota_curso'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="posto_id" class="col-xs-offset-3 col-xs-2 control-label">Posto</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('posto_id',$postos,'','class="form-control"');?>
            </div>
        </div>
        <div class="form-group">
            <label for="quartel_id" class="col-xs-offset-3 col-xs-2 control-label">Unidade/Estabelecimento/Órgão</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('quartel_id',$quarteis,'','class="form-control"');?>
            </div>
        </div>
        <div class="form-group">
            <label for="companhia_id" class="col-xs-offset-3 col-xs-2 control-label">Companhia</label>
            <div class="col-xs-4">
            <?php 
            echo form_dropdown('companhia_id',$companhias,'','class="form-control"');?>
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