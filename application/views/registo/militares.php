<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation" class="active"><a href="militares">Militares</a></li>
            <li role="presentation"><a href="medalhas">Medalhas e condecorações</a></li>
            <li role="presentation"><a href="atividades">Atividades SOIS</a></li>
        </ul>
    </div>
    <div classe="row">
        <h2>Histórico das alterações à base de dados.</h2>
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
