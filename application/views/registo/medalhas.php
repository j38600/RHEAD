<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs nav-justified">
            <?php foreach ($registos as $registo):?>
            boto aqui os botões para filtar um pouco da informação? 
            tbm posso por na primeira linha dropdowns, em que uma delas escolhe o tipo.
                outra pode ser nim, para saber o que alguem fez
                outra pode ser data inicio e fim, para limitar no tempo as atividades mostradas.
            <?php endforeach;?>
            <li role="presentation"><a href="militares"> Militares</a></li>
            <li role="presentation" class="active"><a href="medalhas">Medalhas</a></li>
            <li role="presentation"><a href="atividades">Atividades SOIS</a></li>
        </ul>
    </div>
    <div classe="row">
        <h2>Histórico dos toques automáticos efetuados</h2>
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