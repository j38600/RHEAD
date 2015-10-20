<div class="container-fluid">
    <div class="row">
        <h2>Listagem dos incidentes</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>GDH</th>
                <th>Latitude, Longitude</th>
                <th>Azimute</th>
                <th>Frequência, Modulação</th>
                <th>Emissor</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($incidentes as $incidente):?>
                    <tr>
                        <td>
                            <?php
                            $datetime = explode(" ",$incidente['gdh']);
                            $date = $datetime[0];
                            $time = $datetime[1];
                            echo $date.$time;
                            ?>
                        </td>
                        <td><?php echo $incidente['lat'].', '.$incidente['lon'];?></td>
                        <td><?php echo $incidente['azimute'];?></td>
                        <td><?php echo $incidente['frequencia'].'Khz, '.$incidente['modulacao'];?></td>
                        <td>
                            <?php
                            if (!$incidente['analisada']){
                                echo anchor(
                                    'incident/analisar/'.$incidente['id'],
                                    '<span class="glyphicon glyphicon-eye-open"></span> Analisar',
                                    array(
                                        'title' => 'Novo',
                                        'class' => 'btn btn-success btn-outline btn-block',
                                        'role' => 'button'
                                    )
                                );
                            }
                            else{
                                echo $incidente['emissor'];
                            }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($admin){
                                echo anchor(
                                    'incident/new',
                                    '<span class="glyphicon glyphicon-plus"></span> Novo',
                                    array(
                                        'title' => 'Novo',
                                        'class' => 'btn btn-outline btn-primary btn-block',
                                        'role' => 'button'
                                    )
                                );
                            }
                            ?>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>
