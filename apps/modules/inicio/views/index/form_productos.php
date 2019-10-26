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
    <link href="/bootstrap-4.0.0/carousel.css" rel="stylesheet">
    <link href="/css/Footer-with-button-logo.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">-->
    <link href="/css/extjs.css" rel="stylesheet">
    <!--<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>-->
   

    <link rel="stylesheet" href="/mdl/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/mdl/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

   
  </head>
  <body>
    <header>
      <?php
        $this->header(array());
      ?>
    </header>
    <main role="main" style="margin-top: 22px;">
       <div class="container-fluid" >
          <section class="main row justify-content-center align-items-center">
            <?php
              if($p['produc'] != ''){
                $this->detalleProducto(array('produc'=>$p['produc']));
              }
            ?>
          </section>

       </div>            
    </main>
     <!--Footer-->
    <?php
      $this->footer(array());
    ?>
    <script src="/mdl/OwlCarousel2-2.2.1/docs/assets/owlcarousel/owl.carousel.js"></script>
    <script>
      function carousel(){
        var owl1 = $('#productos');
        owl1.owlCarousel({
            nav:true,
            navText: ["<",">"],
            navClass: [ 'owl-prev-new', 'owl-next-new' ],
            items: 1,
            loop: false,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            center:true,
            //autoWidth:true,
        });
      }
      carousel();
    </script>
  </body>
</html>
