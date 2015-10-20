<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CTGE</title>
        <?php
            echo link_tag('css/bootstrap.min.css');
            echo link_tag('css/metisMenu.min.css');
            echo link_tag('css/sb-admin-2.css');
            echo link_tag('css/font-awesome.min.css');
            echo link_tag('imgs/logo.ico', 'shortcut icon');
        ?>
        <script src='<?php echo base_url()?>js/jquery-2.1.1.min.js' ></script>
        <script src='<?php echo base_url()?>js/bootstrap.min.js'></script>
        <script src='<?php echo base_url()?>js/metisMenu.min.js'></script>
        <script src='<?php echo base_url()?>js/sb-admin-2.js'></script>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <?php if(!empty($message)){?>
                                    <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $message; ?>
                                    </div>
                                    <?php
                                    }
                                echo form_open(current_url());
                                ?>
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Identidade" name="identity" id="identity" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a> -->
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
                                    </div>
                                </fieldset>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>