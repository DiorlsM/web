<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>EAC</title>
   
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap-4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!--<link href="/bootstrap-4.0.0/carousel.css" rel="stylesheet">-->
    <link href="/css/Footer-with-button-logo.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">-->
    <link href="/css/extjs.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZFvBg-F9XobATZDQyLAr_-QqRDvJvUV8">
    </script>-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    
  </head>
  <body>
    <header>
      <?php
        $this->header(array());
      ?>
    </header>
    <main role="main" style="margin-top: 64px;">
      <div class="container-fluid" style="min-height: 800px;">
          <section class="main row align-items-start" style="margin-top: 12px;">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
              <div class="col-12 col-lg-12 font-eac">
                <div class="card" style="width:100%">
                  <h5 class="card-header">CARRITO DE COMPRAS</h5>
                  <div class="card-body ">
                    <?php
                      $this->htmlCarrito(array());
                    ?>
                  </div>
                </div>   
              </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4" >
              <form class="needs-validation">
                <div class="form-group">
                  <label for="nombre_completo">Nombre Completo</label>
                  <input type="text" class="form-control" id="nombre_completo" placeholder="Nombre Completo" value="<?php echo $p['nombre_completo'];?>">
                </div>
                <div class="form-group">
                  <label for="telefono">Telefono</label>
                  <input type="text" class="form-control" id="telefono" placeholder="Telefono" value="<?php echo $p['telefono'];?>">
                </div>
                <div class="form-group">
                  <label for="correo">Correo Electrónico</label>
                  <input type="email" class="form-control" id="correo" aria-describedby="emailHelp" placeholder="Correo Electrónico" value="<?php echo $p['correo'];?>">
                </div>
                <div type="" class="btn btn-primary submit">Procesar Compra</div>
              </form>
            </div>
          </section>
      </div>            
    </main>


     <!--Footer-->
     <?php
        $this->footer(array());
      ?>
  </body>
</html>
