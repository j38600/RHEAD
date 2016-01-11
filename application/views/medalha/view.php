<h2 class="text-center">Escala de <?php echo $escala['nome'];?></h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Militares associados</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($militares as $militar):?>
                        <li class="list-group-item"><?php echo $militar['posto_abreviatura'].
                            ' '.$militar['nim'].' '.$militar['apelido'];?></li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalhes</h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Diário</dt>
                        <dd><?php echo ($escala['diario']) ? 'Sim' : 'Não';?></dd>
                        <dt>Número de nomeados</dt>
                        <dd><?php echo $escala['numero_nomeados'];?></dd>
                        <dt>Hora de Início</dt>
                        <dd><?php echo date('h:i', strtotime($escala['hora_inicio']));?></dd>
                        <dt>Hora de Fim</dt>
                        <dd><?php echo date('h:i', strtotime($escala['hora_fim']));?></dd>
                        <dt>Semana?</dt>
                        <dd><?php echo ($escala['semana']) ? 'Sim' : 'Não';?></dd>
                        <dt>Duração em horas</dt>
                        <dd><?php echo $escala['horas_duracao'];?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>