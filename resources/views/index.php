<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
        <link rel="stylesheet" href="/css/index.css"/>
        <script data-main="/js/main" src="/apis/require.js"></script>
    </head>
    <body>
        <div class="background-index"></div>
        <div class="miele-logo">
            <img src="/img/logo.png">
        </div>
    </body>
    <script>
        require(['main'], function() {
            require(['index'], function(home) {
                home.init();
            });
        });
    </script>
</html>
