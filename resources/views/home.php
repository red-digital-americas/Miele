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
                                            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"></a>
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
            require(['bootstrap']);
            require(['login']);
            require(['jquery'], function($) {
                $(document).ready(function() {
                    $("#menu-toggle").click(function(e) {
                        e.preventDefault();
                        $("#wrapper").toggleClass("toggled");
                    });
                    $('.container').css({width: $(window).width()});
                    $('.productos-content').height($(window).height());
                    $('.encuestas-content').height($(window).height());

                    $('.option').click(function(e) {
                        e.preventDefault();
//                        window.location.href = document.location.origin + "/" + $(this).attr('option') + "/?token=<?php echo $token ?>";
                    });
                });

                $(window).on('orientationchange', function() {
                    $('.container').css({width: $(window).width()});
                    $('.productos-content').height($(window).height());
                    $('.encuestas-content').height($(window).height());
                });
            });
        });
    </script>
</html>
