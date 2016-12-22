<!doctype html>
<html>
    <head>
        <title>Miele</title>
        <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">

        <link rel="stylesheet" href="/apis/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/css/simple-sidebar.css"/>
        <link rel="stylesheet" href="/css/Home.css"/>
        <script data-main="/js/main" src="/apis/require.js"></script>
    </head>
    <body>
        <div id="wrapper" class="toggled">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">
                            Miele
                        </a>
                    </li>
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="#">Cerra Sesión</a>
                    </li>
                    <li>
                        <a href="#">Overview</a>
                    </li>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="home-wrapper">
                            <div class="container">
                                <div class="col-md-6 col-xs-6">
                                    <div class="productos-content side option" option="products">
                                        <span class="btn-menu glyphicon glyphicon-menu-hamburger" id="menu-toggle"></span>
                                        <div>
                                            <p><h1>Productos</h1></p>
                                            <hr>
                                            <p>Conoce las diferentes catégorias que Miele tiene para tí.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="encuestas-content side option" option="surveys">
                                        <div>
                                            <p><h1>Encuestas</h1></p>
                                            <hr>
                                            <p>En Miele nos gusta siempre escuchar al cliente y mejorar nuestro servicio.</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/#page-content-wrapper--> 

        </div>
        <!-- /#wrapper -->
    </body>
    <script>
        require(['main'], function() {
            require(['jquery', 'bootstrap', 'menu', 'home'], function($, bootstrap, menu, home) {
                home.init("<?php echo $token ?>");
            });
        });
    </script>
</html>
