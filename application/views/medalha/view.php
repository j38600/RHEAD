<h2 class="text-center"><?php echo $medalha['nome'];?></h2>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Militares galardoados</h3>
                </div>
                <ul class="list-group">
                    <?php foreach ($militares as $militar):
                        echo anchor(
                            'militar/view/'.$militar['nim'],
                            $militar['posto_abreviatura'].' '.$militar['nim'].' '.$militar['apelido'],
                            array(
                                'class' => 'list-group-item',
                            )
                        );
                    endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Descrição</h3>
                </div>
                <div class="panel-body">
                    <?php echo $medalha['descricao'];?>
                </div>
            </div>
        </div>
    </div>
</div>