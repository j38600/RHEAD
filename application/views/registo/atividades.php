<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a href="militares">Militares</a></li>
            <li role="presentation"><a href="medalhas">Medalhas</a></li>
            <li role="presentation" class="active"><a href="atividades">Atividades SOIS</a></li>
        </ul>
    </div>
    <div classe="row">
        <h2>Histórico dos agendamentos e dos feriados</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>GDH</th>
                <th>Username</th>
                <th>Computador</th>
                <th>Ação efetuada</th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($registos as $registo):?>
                    <tr>
                        <td><?php echo $registo['gdh'];?></td>
                        <td><?php echo $registo['username'];?></td>
                        <td><?php echo $registo['ip_maquina'];?></td>
                        <td><?php echo $registo['accao'];?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
