<!doctype html>
<html>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, target-densityDpi=device-dpi" />
    <head>
        <title>Encuestas</title>
        <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
        <link rel="stylesheet" href="/apis/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/apis/bootstrap3-dialog/dist/css/bootstrap-dialog.css"/>
        <link rel="stylesheet" href="/css/menu.css"/>
        <link rel="stylesheet" href="/css/surveys.css"/>
        <link rel="stylesheet" href="/apis/font-awesome/css/font-awesome.min.css"/>
        <script data-main="/js/main" src="/apis/require.js"></script>
    </head>
    <body>
        <div id="pageWrapper">
        <div class="background-surveys"></div>
            <div class="searcher-content">
                <div class="navbar">
                    <div class="container">
                        <div class="navbar-header">
                            <span class="navbar-brand btn-menu glyphicon glyphicon-menu-hamburger" id="menu-toggle"></span>
                        </div>
                        <div class="navbar-collapse collapse">
                            <form class="navbar-form">
                                <div class="form-group" style="display:inline;">
                                    <div class="input-group" style="display:table;">
                                        <span class="input-group-addon" style="width:1%;"><span class="glyphicon glyphicon-search"></span></span>
                                        <input class="form-control" name="search" placeholder="Search" autocomplete="off" autofocus="autofocus" type="text">
                                        <span class="input-group-addon" style="width:1%;"><span class="fa fa-microphone fa-lg"></span></span> 
                                    </div>
                                </div>
                            </form>

                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <div class="col-sm-12 boxes-content" id="boxContent"></div>
        </div>
    </body>

    <script>
        require(['main'], function () {
            require(['survey'], function (home) {
                home.init();
            });
        });
    </script>
</html>