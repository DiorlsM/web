<!DOCTYPE html>

<html lang="es">

<?php
set_time_limit(0);
ini_set("memory_limit", "-1");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
header('X-XSS-Protection: 1');
header('X-Content-Type-Options: nosniff');
header("Connection: Keep-alive");
?>


<head>
    <meta charset="UTF-8">
    

    <title>Eac Consulting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <meta name="theme-color" content="#2C3747">
    <meta name="msapplication-navbutton-color" content="#2C3747">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2C3747">


    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/LoginFinal.css">

    


</head>
<body>
    <!--</div>-->
    <div class="error-msg hide"><span class="info-icon icon-warning"></span><span class="texto-error">Error</span></div>
    
    <section class="selec1-home">
        <div class="publi-1">
            <div class="mascara"></div>    
            
        </div>
        <div class="publi-2">
            
            <div class="sign-up-form">
                <div class="content">
                    <div>
                        <img src="/images/icon/log_eaconsulting.gif" width="280px" height="95px"/>
                    </div>
                    <p>
                        EAC CONSULTING SAC es una empresa peruana dedicada a la comercialización y distribución de tecnología informática (equipamiento, renovación de infraestructura tecnológica de hardware y software, arrendamiento operativo) así como también a la consultoría de TI (soluciones empresariales de alta disponibilidad, resguardo de la información y comunicaciones, redes SAN, cableado estructurado y energía).
                    </p>
                </div>
                <form action="/login/index/valida" method="post" id="myForm">
                    <div>
                        <fieldset>
                            <div class="field-item first-of-type">
                               <input type="text" class="input" placeholder="Ingrese usuario" autocomplete="off" name="vp_codigo" id="usuario" required>
                            </div>
                            <div class="field-item">
                                <input type="password" class="input" placeholder="Ingrese contraseña" autocomplete="off" name="vp_clave" id="password" required>
                            </div>
                        </fieldset>
                        <div class="button-container">
                            <button name="register" class="btn-register ripple" type="submit"><div>INGRESAR</div></button>
                            <!--<p class="legal"><a href="/login/index/cambiar_password/" class="change_pass">Cambiar contraseña</a></p>-->
                        </div>
                    </div>
                </form>

                <footer>
                    <p>
                        <span>Copyright&copy; Eac consulting </span>
                        <span>Todos los derechos reservados</span>
                    </p>
                </footer>
            </div>
        </div>
    </section>

   


<script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>


<script type="text/javascript">
    var login = {
        id: 'login',
        error: parseInt('<?php echo htmlspecialchars($p["opt"],ENT_QUOTES);?>'),
        init: function(){
            $('#usuario').focus();
            $('.error-msg').click(function(){
                $('.error-msg').slideDown('fast').delay(100).fadeOut(400);
            });

            $('#usuario').keyup(function(){
                var str = $("#usuario").val().trim();
                var regex = /((\%3C) <)((\%2F) \/)*[a-z0-9\%]+((\%3E) >)/i;
                $("#usuario").val(str.replace(regex, "\n"));
                //$("#usuario").val(str.replace(/&/g,'&amp;').replace(/"/i,'&quot;').replace(/</i,'&lt;').replace(/>/i,'&gt;').replace(/'/i,'&apos;'));
                $("#usuario").val(str.replace(/&/g,'').replace(/"/i,'').replace(/</i,'').replace(/>/i,'').replace(/'/i,''));
            });

            $('#password').keyup(function(){
                var str = $("#password").val().trim();
                var regex = /((\%3C) <)((\%2F) \/)*[a-z0-9\%]+((\%3E) >)/i;
                $("#password").val(str.replace(regex, "\n"));
                //$("#usuario").val(str.replace(/&/g,'&amp;').replace(/"/i,'&quot;').replace(/</i,'&lt;').replace(/>/i,'&gt;').replace(/'/i,'&apos;'));
                $("#password").val(str.replace(/&/g,'').replace(/"/i,'').replace(/</i,'').replace(/>/i,'').replace(/'/i,''));
            });

            

            if (login.error < 0){
                $( ".texto-error" ).text('<?php echo htmlspecialchars($p["mensaje"],ENT_QUOTES);?>');
                $( ".error-msg" ).slideDown('slow', function(){});
            }

        }
    }
    $(document).ready(function(){
        login.init();
    });
</script>
</body>
</html>