<?php
if(validation_errors()){
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo validation_errors() ?>
    </div>
<?php
}
echo form_open('emiter/novo', ['class' => 'form-horizontal',
                                      'role' => 'form']); ?>
<div class="form-group">
    <label for="lat" class="col-xs-offset-3 col-xs-2 control-label">Latitude</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'lat',
                            'id' => 'lat',
                            'type' => 'number',
                            'value' => set_value('lat'),
                            'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <label for="lon" class="col-xs-offset-3 col-xs-2 control-label">Longitude</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'lon',
                            'id' => 'lon',
                            'type' => 'number',
                            'value' => set_value('lon'),
                            'class' => 'form-control']); ?>
    </div>
</div>
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
    <label for="nome_ficheiro" class="col-xs-offset-3 col-xs-2 control-label">Ficheiro</label>
    <div class="col-xs-4">
    <?php 
    echo form_dropdown('nome_ficheiro',$pasta,'','class="form-control"');?>
    </div>
</div>



<div class="form-group">
    <label for="descricao" class="col-xs-offset-3 col-xs-2 control-label">Tipo</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'lon',
                            'id' => 'lon',
                            'type' => 'deciaml',
                            'value' => set_value('lon'),
                            'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <label for="potencia_emissao" class="col-xs-offset-3 col-xs-2 control-label">Potência de emissão (KW)</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'potencia_emissao',
                            'id' => 'potencia_emissao',
                            'type' => 'number',
                            'value' => set_value('potencia_emissao'),
                            'class' => 'form-control']); ?>
    </div>
</div>
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
    <label for="caracteristicas" class="col-xs-offset-3 col-xs-2 control-label">Características</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'caracteristicas',
                            'id' => 'caracteristicas',
                            'type' => 'text',
                            'value' => set_value('caracteristicas'),
                            'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <label for="freq_max" class="col-xs-offset-3 col-xs-2 control-label">Frequência máxima</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'freq_max',
                            'id' => 'freq_max',
                            'type' => 'number',
                            'value' => set_value('freq_max'),
                            'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <label for="freq_min" class="col-xs-offset-3 col-xs-2 control-label">Frequnência mínima</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'freq_min',
                            'id' => 'freq_min',
                            'type' => 'number',
                            'value' => set_value('freq_min'),
                            'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-xs-offset-2">
        <button class="btn btn-primary" type="submit" name="submit">Adicionar</button>
    </div>
</div>
<?php
echo form_close();
?>