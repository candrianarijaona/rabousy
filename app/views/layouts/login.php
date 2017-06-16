<!DOCTYPE html>
<html>
    <head>
        <title>Rabousy</title>
        <link href="<?php echo(core\App::base_url()) ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo(core\App::base_url()) ?>/assets/css/mdb.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo(core\App::base_url()) ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo(core\App::base_url()) ?>/assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="<?php echo(core\App::base_url()) ?>/assets/img/favicon.png" />
    </head>
    <body>
        <div class="m-3">
            <div class="flex-center flex-column">
                <img src="<?php echo(core\App::base_url()) ?>/assets/img/logo_big.png" alt="logo" width="250"/>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-3">
                    <div class="card">
                        <div class="card-block">
                            <form method="post">
                                <?php if (core\App::data("error")): ?>
                                <div class="alert alert-danger">
                                    Error while connecting to database
                                </div>
                                <?php endif; ?>
                                <!--Body-->
                                <div class="md-form">
                                    <i class="fa fa-server prefix"></i>
                                    <input type="text" id="form2" class="form-control" name="server">
                                    <label for="form2">Server</label>
                                </div>

                                <div class="md-form">
                                    <i class="fa fa-user prefix"></i>
                                    <input type="text" id="form3" class="form-control" name="username">
                                    <label for="form3">Username</label>
                                </div>

                                <div class="md-form">
                                    <i class="fa fa-lock prefix"></i>
                                    <input type="password" id="form4" class="form-control" name="password">
                                    <label for="form4">Password</label>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-orange">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/tether.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/mdb.js" type="text/javascript"></script>
    </body>
</html>