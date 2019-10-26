<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>EAC Consulting</title>
   
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
      <div class="row">
        <div class="main col-12 col-sm-12 col-md-12 col-lg-12">
          <?php
            if ($p['S1'] != ''){
              $this->promociones(array('vp_cod'=>$p['S1'],'vp_tipo_carga'=>'1'));
            }else if($p['M1'] != ''){
              $this->promociones(array('vp_cod'=>$p['M1'],'vp_tipo_carga'=>'4'));
            }else if($p['CA'] != ''){
              $this->promociones(array('vp_cod'=>$p['CA'],'vp_tipo_carga'=>'2'));
            }
          ?>
        </div>
      </div>
      <div class="container-fluid" >
          <section class="main row align-items-start" style="margin-top: 12px;">
            <?php
              if ($p['S1'] != ''){//clasificacion
                $this->categorias(array('codigo'=>$p['S1']));
              }else if($p['CA'] != ''){//categoria
                $this->like(array('codigo' =>$p['CA'],'tipo'=>1));
              }else if ($p['M1'] != ''){//marcas
                $this->like(array('codigo' =>$p['M1'],'tipo'=>2));
              }else if($p['search'] !=''){//busqueda
                $this->like(array('codigo' =>$p['search'],'tipo'=>3));
              }else if($p['oferta'] != ''){
                $this->like(array('codigo' =>'oferta','tipo'=>4));
              }else if($p['marcas'] != ''){
                $this->listaMarcas();
              }else{
                $this->like(array('codigo' =>'oferta','tipo'=>4));
              }
            ?>
          </section>
      </div>            
    </main>


     <!--Footer-->
     <?php
        $this->footer(array());
      ?>
  </body>
</html>
