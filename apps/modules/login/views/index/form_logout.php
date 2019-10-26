<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Eac Consulting</title>
        <meta charset="utf-8">
    </head>
    <body onload="document.form.submit();">
        <form name="form" action="/login/index" method="POST">
            <input type="hidden" name="opt" value="<?php echo $p['opt'];?>" />
            <input type="hidden" name="mensaje" value="<?php echo $p['mensaje'];?>" />
        </form>
    </body>
</html>