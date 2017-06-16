<!DOCTYPE html>
<html>
    <head>
        <title>Rabousy</title>
        <link href="<?php echo(core\App::base_url()) ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo(core\App::base_url()) ?>/assets/css/mdb.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo(core\App::base_url()) ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo(core\App::base_url()) ?>/assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="<?php echo(core\App::base_url()) ?>/assets/img/favicon.png" />
        <link href="<?php echo(core\App::base_url()) ?>/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" type="text/css"/>
    </head>
    <body ng-app="app" ng-controller="main">
        <nav class="navbar navbar-toggleable-md navbar-dark stylish-color z-depth-2">
            <a class="navbar-brand" href="#">
                Rabousy <strong>MyGen</strong>
            </a>
        </nav>
        <div class="container-fluid">
            <section class="sidebar z-depth-1 animated fadeIn">
                <div class="logo red white-text">
                    <h5>Rabousy <strong>1.0</strong></h5>
                </div>
                <div class="sidebar-wrapper">
                    <ul>
                        <li class="togglable">
                            <i class="fa fa-database"></i> <a>Databases</a>
                            <ul class="animated fadeIn">
                                <li ng-repeat="row in databases">
                                    <a ng-click="getTables(row)">{{row.Database}}</a>
                                    <ul>
                                        <li class="animated fadeIn" ng-repeat="table in row.tables">
                                            <i class="fa fa-table"></i>
                                            <a ng-href="#/db/{{row.Database}}/{{table[0]}}">{{table[0]}}</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="togglable">
                            <i class="fa fa-wrench"></i> <a>Configuration</a>
                            <ul class="animated fadeIn">
                                <li><a href="#/dico">Dictionnary</a></li>
                                <li><a href="#/lorem">Lorem Ipsum</a></li>
                            </ul>
                        </li>
                        <li>
                            <i class="fa fa-lock"></i> <a href="<?php echo(core\App::base_url()); ?>/public/index.php/login/logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="mainpanel">
                <h3><strong>MySql</strong> random data generator</h3>
                <div ng-view>
                </div>
            </section>
        </div>


        <script src="<?php echo(core\App::base_url()) ?>/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/tether.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/mdb.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/angular.min.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/angular-route.min.js" type="text/javascript"></script>

        <script>
            var BASE_URL = "<?php echo(core\App::base_url()) ?>/index.php/";
            var BASE_URL_NO_INDEX = "<?php echo(core\App::base_url()) ?>";
            $(function () {
                var h = $(document).height() - 100;
                $('.sidebar-wrapper').slimScroll({
                    height: h + "px"
                });

                $(".sidebar-wrapper ul li.togglable>a").each(function (i, elt) {
                    $(elt).click(function () {
                        $(elt).parent("li").toggleClass("toggled");
                    });
                });
            });
        </script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/plugins/momentjs/moment.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/app/app.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/app/table.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/app/dico.js" type="text/javascript"></script>
        <script src="<?php echo(core\App::base_url()) ?>/assets/js/app/lorem.js" type="text/javascript"></script>
    </body>
</html>
