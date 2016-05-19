<div class="container-fluid">
    <div class="row">
        <h3 class="text-center">Adicionar informações da nova medalha ou condecoração</h3>
        <?php
        if(validation_errors()){
        ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo validation_errors() ?>
            </div>
        <?php
        }
        echo form_open('medalha/novo', ['class' => 'form-horizontal',
                                              'role' => 'form']); ?>
        <div class="form-group">
            <label for="nome" class="col-xs-offset-3 col-xs-2 control-label">Nome</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'nome',
                                    'id' => 'nome',
                                    'type' => 'text',
                                    'value' => set_value('nome'),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="descricao" class="col-xs-offset-3 col-xs-2 control-label">Descrição</label>
            <div class="col-xs-4">
            <?php echo form_textarea([ 'name' => 'descricao',
                                        'id' => 'descricao',
                                        'rows' => '3',
                                        'value' => set_value('descricao'),
                                        'class' => 'form-control']); ?>
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