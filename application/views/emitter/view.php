<h2>Informação do emissor <?php echo '"'.$emissor['nome'].'"';?></h2>
<div class="col-xs-offset-4">
    <dl class="dl-horizontal">
        <dt>Latitude:</dt>
        <dd><?php echo $emissor['lat'];?></dd>
        <dt>Longitude:</dt>
        <dd><?php echo $emissor['lon'];?></dd>
        <dt>Tipologia:</dt>
        <dd><?php echo $emissor['tipologia'];?></dd>
        <dt>Pot. de emissão(KW):</dt>
        <dd><?php echo $emissor['potencia_emissao'];?></dd>
        <dt>Frequência máxima:</dt>
        <dd><?php echo $emissor['freq_max'];?></dd>
        <dt>Frequência mínima:</dt>
        <dd><?php echo $emissor['freq_min'];?></dd>
        <dt>Descrição:</dt>
        <dd><?php echo $emissor['descricao'];?></dd>
        <dt>Características:</dt>
        <dd><?php echo $emissor['caracteristicas'];?></dd>
    </dl>
</div>