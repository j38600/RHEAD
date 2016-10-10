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

        echo form_open('escala/edit/'.$id, ['class' => 'form-horizontal',
                                            'role' => 'form']);
        echo form_hidden ('id',$id);?>
        <div class="form-group">
            <label for="nome" class="col-xs-offset-3 col-xs-2 control-label">Nome</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'nome',
                                    'id' => 'nome',
                                    'type' => 'text',
                                    'value' => $escala['nome'],
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="diario" class="col-xs-offset-3 col-xs-2 control-label">Diário?</label>
            <div class="col-xs-4">
            <?php
                echo form_radio('diario', 1, $escala['diario']).' Sim ';
                echo form_radio('diario', 0, !$escala['diario']).' Não ';
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="semana" class="col-xs-offset-3 col-xs-2 control-label">Escala: </label>
            <div class="col-xs-4">
            <?php
                echo form_radio('semana', 1, $escala['semana']).' A (semana) ';
                echo form_radio('semana', 0, !$escala['semana']).' B (fim de semana) ';
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="hora_inicio" class="col-xs-offset-3 col-xs-2 control-label">Hora de início</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'hora_inicio',
                                    'id' => 'hora_inicio',
                                    'type' => 'time',
                                    'value' => date('H:i',strtotime($escala['hora_inicio'])),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="hora_fim" class="col-xs-offset-3 col-xs-2 control-label">Hora de fim</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'hora_fim',
                                    'id' => 'hora_fim',
                                    'type' => 'time',
                                    'value' => date('H:i',strtotime($escala['hora_fim'])),
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="horas_duracao" class="col-xs-offset-3 col-xs-2 control-label">Horas de duração</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'horas_duracao',
                                    'id' => 'horas_duracao',
                                    'type' => 'number',
                                    'value' => $escala['horas_duracao'],
                                    'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="numero_nomeados" class="col-xs-offset-3 col-xs-2 control-label">Nr de militares a nomear</label>
            <div class="col-xs-4">
            <?php echo form_input([ 'name' => 'numero_nomeados',
                                    'id' => 'numero_nomeados',
                                    'type' => 'number',
                                    'value' => $escala['numero_nomeados'],
                                    'class' => 'form-control']); ?>
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