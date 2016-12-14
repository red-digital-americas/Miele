<!doctype html>
<html>
    <head>
        <title>Miele</title>
        <link rel="stylesheet" href="apis/bootstrap/css/bootstrap.css"/>
        <!--<script src="apis/jquery-3.1.1.min.js"></script>-->
        <!--<script src="apis/bootstrap/js/bootstrap.js"></script>-->
        <script data-main="js/main" src="apis/require.js"></script>
    </head>
    <body>
        <div class="col-md-12">
            <div class="row"><center><h1>MIELE</h1></center></div>
        </div>
        
        <div class="col-md-12">
            <div class="row"><center><h2>Ingresar</h2></center></div>
        </div>
        <div class="container col-md-3">

        </div>
        <div class="container col-md-6">
            <div class="col-md-12">
                <form>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Contraseña</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <center><button type="submit" class="btn btn-primary">Entrar</button></center>
                        </div>
                    </div>
                    <fieldset class="form-group row">
                        <div class="col-sm-12">
                            <center><a href="">Olvidé mi contraseña</a></center>
                        </div>
                    </fieldset>            
                    <fieldset class="form-group row">
                        <div class="col-sm-12">
                            <center><a href="">Al entrar acepto los Términos y condificiones y las políticas de privacidad</a></center>
                        </div>
                    </fieldset>            
                </form>
            </div>

        </div>
        <div class="container col-md-3">

        </div>
    </body>
    <script>
        require(['main'], function() {
            require(['login']);
        });
    </script>
</html>