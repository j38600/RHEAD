<h2 class="text-center">Informações do <?php echo $militar['posto_nome'].' '.$militar['nim'].' '.$militar['apelido'];?></h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Informações pessoais</h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Posto</dt>
                        <dd><?php echo $militar['posto_nome'];?></dd>
                        <dt>NIM</dt>
                        <dd><?php echo $militar['nim'];?></dd>
                        <dt>Nome completo</dt>
                        <dd><?php echo $militar['nome'].' '.$militar['apelido'];?></dd>
                        <dt>Companhia</dt>
                        <dd><?php echo $militar['companhia_nome'];?></dd>
                        <dt>Quartel</dt>
                        <dd><?php echo $militar['quartel_nome'];?></dd>
                        <dt>Antiguidade</dt>
                        <dd><?php echo date('d-m-Y', strtotime($militar['antiguidade']));?></dd>
                        <dt>Nota de curso</dt>
                        <dd><?php echo $militar['nota_curso'];?></dd>
                        <dt>Ativo?</dt>
                        <dd><?php echo ($militar['ativo']) ? 'Sim' : 'Não';?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Medalhas e condecorações</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($medalhas as $medalha):?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo $medalha['med_cond_nome'];?></h4>
                            <p class="list-group-item-text">
                                <?php
                                if ($medalha['pedida']){
                                    echo 'Pedida em '.date('d-m-Y', strtotime($medalha['data_pedida']));
                                    echo br();
                                }
                                if ($medalha['recebida']){
                                    echo 'Recebida em '.date('d-m-Y', strtotime($medalha['data_recebida']));
                                    echo br();
                                }
                                if ($medalha['imposta']){
                                    echo 'Imposta em '.date('d-m-Y', strtotime($medalha['data_imposta']));
                                    echo br();
                                }
                                    //echo $medalha['pedida'] ? 'Pedida em '.date('d-m-Y', strtotime($medalha['data_pedida'])) : '';
                                    //echo br();
                                    //echo $medalha['recebida'] ? 'Recebida em '.date('d-m-Y', strtotime($medalha['data_recebida'])) : '';
                                    //echo br();
                                    //echo $medalha['imposta'] ? 'Imposta em '.date('d-m-Y', strtotime($medalha['data_imposta'])) : '';
                                    //echo br();
                                    echo $medalha['informacao'];
                                ?>
                            </p>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>