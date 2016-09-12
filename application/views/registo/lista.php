<div class="container-fluid">
    <div class="row">
        <h2>Histórico das alterações à base de dados.</h2>
        <div class="row">
            <ul class="nav nav-tabs">
                <li role="presentation" class='<?php if($obter == 'atividades'){echo 'active';}?>'>
                    <a href="<?php echo base_url()?>registo/lista/atividades">Atividades</a></li>
                <li role="presentation" class='<?php if($obter == 'medalhas'){echo 'active';}?>'>
                    <a href="<?php echo base_url()?>registo/lista/medalhas">Medalhas</a></li>
                <li role="presentation" class='<?php if($obter == 'militares'){echo 'active';}?>'>
                    <a href="<?php echo base_url()?>registo/lista/militares">Militares</a></li>
            </ul>
        </div>
    <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>GDH</th>
                <th>Username</th>
                <th>Computador</th>
                <th>Tipo</th>
                <th>Ação</th>
                <th>Informação</th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($registos as $registo):?>
                    <tr>
                        <td><?php echo $registo['gdh'];?></td>
                        <td><?php echo $registo['username'];?></td>
                        <td><?php echo $registo['ip_maquina'];?></td>
                        <td><?php echo $registo['tipo'];?></td>
                        <td><?php echo $registo['accao'];?></td>
                        <td><?php echo $registo['informacao'];?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
