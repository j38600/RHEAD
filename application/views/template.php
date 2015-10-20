<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title; ?></title>
        <?php
            echo link_tag('css/bootstrap.min.css');
            echo link_tag('css/metisMenu.min.css');
            echo link_tag('css/sb-admin-2.css');
            echo link_tag('css/font-awesome.min.css');
            echo link_tag('imgs/logo.ico', 'shortcut icon');
        ?>
        <script src='<?php echo base_url()?>js/jquery-2.1.1.min.js' > </script>
        <script src='<?php echo base_url()?>js/bootstrap.min.js'> </script>
        <script src='<?php echo base_url()?>js/metisMenu.min.js'></script>
        <script src='<?php echo base_url()?>js/sb-admin-2.js'></script>

        <?php if (isset($map)){
            echo $map['js'];
                }
         ?>
        
    </head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href='<?php echo base_url()?>' title="Collected Records of Eletronic Warfare">C.R.E.W.</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="glyphicon glyphicon-flag"></span> Emissores
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo base_url()?>emitter">Lista</a></li>
                        <li><a href="<?php echo base_url()?>emitter/map">Mapa</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="glyphicon glyphicon-map-marker"></span> Incidentes
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo base_url()?>incident">Lista</a></li>
                        <li><a href="<?php echo base_url()?>incident/map">Mapa</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($admin) { ?>
                            <li><a href="<?php echo base_url()?>auth">Utilizadores</a></li>
                            <li><a href="<?php echo base_url()?>registo/automaticos">Histórico</a></li>
                            <li class="divider"></li>
                        <?php }?>
                        <li><a href='<?php echo base_url()?>auth/logout'>Logout</a></li>
                    </ul>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $contents ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
</body>

</html>
