<!doctype html>
<html>
    <head>
        <title>Miele</title>
        <link rel="stylesheet" href="/apis/bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" href="/css/Miele.css"/>
        <script data-main="/js/main" src="/apis/require.js"></script>
    </head>
    <body>
        <div class="login-logo">

        </div>
        <div class="col-md-12">
            <div class="row"><center><h3>Ingresar</h3></center></div>
        </div>
        <div class="container col-xs-4 col-md-4">

        </div>
        <form>
            <div id="login-container" class="login-container container col-xs-4 col-md-4">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8 ">
                            <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-4 col-form-label">Contraseña</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="alert alert-danger login-alerts col-md-12" style="display: none">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <center><button id="btnLogin" class="btn btn-primary">Entrar</button></center>
                        </div>
                    </div>
                    <div class="login-info form-group row">
                        <div class="col-sm-12">
                            <center><a href="">Olvidé mi contraseña</a></center>
                        </div>
                    </div>            
                    <div class="login-info form-group row">
                        <div class="col-sm-12">
                            <center><a href="">Al entrar acepto los Términos y condificiones y las políticas de privacidad</a></center>
                        </div>
                    </div>            
                </div>

            </div>
        </form>
        <div class="container col-xs-4 col-md-4">

        </div>
    </body>
    <script>
        require(['main'], function() {
            require(['login']);
            require(['jquery'], function($){
                $(document).ready(function(){
                    var exceptions = "<?php echo $exceptions ?>";
                    if(exceptions.length > 0)
                    $('.login-alerts').show().append('<?php echo $exceptions?>');
                 });
            });
        });
    </script>
</html>