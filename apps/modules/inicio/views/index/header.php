<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">LOGO EAC.com</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto ">
      
      <!--<li class="nav-item dropdown active">
        <button id="btn-producto" class="btn btn-secondary mr-2 mb-2 mt-2 d-none d-sm-block " type="button" data-toggle="collapse" data-target="#producto" aria-expanded="false" aria-controls="producto">
          Productos
        </button>
      </li>-->
      <li class="nav-item dropdown active"><!--d-none d-sm-block-->
       <button class="btn btn-secondary dropdown-toggle mr-2 mb-2 mt-2 " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Productos
        </button>
        <div class="dropdown-menu mega-menu" aria-labelledby="dropdownMenuButton">
          <div class="row">
           
            <?php

              $this->linea_producto();
            ?>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown active">
       <button class="btn btn-secondary dropdown-toggle mr-2 mb-2 mt-2 " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
          <div onClick="window.location='/inicio/index/?marcas=!'" style="display: inline-block;">Marca</div>
        </button>
        <div class="dropdown-menu mega-menu" aria-labelledby="dropdownMenuButton" >
          <div class="row"> 
          <?php
              $this->linea_marca();
            ?>
          </div>
        </div>
      </li>
      <!--<li class="nav-item dropdown active">
        <button id="btn-marca" class="btn btn-secondary  mr-2 mb-2 mt-2 d-none d-sm-block" type="button" data-toggle="collapse" data-target="#marca" aria-expanded="false" aria-controls="marca">
          Marca
        </button>
      </li>-->
      <li class="nav-item dropdown active">
        <form action="/inicio/index/">
          <input class="form-control d-none mr-sm-2" value="OFERTA" type="text" placeholder="Buscar" aria-label="Buscar" name="oferta">
          <button id="btn-oferta" type="submit" class="btn btn-secondary  mr-2 mb-2 mt-2" type="button" data-toggle="collapse" data-target="#oferta" aria-expanded="false" aria-controls="oferta">
            Ofertas
          </button>
      </form>
      </li>
      <li class="nav-item dropdown active">
        <button id="btn-contactos" class="btn btn-secondary  mr-2 mb-2 mt-2" type="button" data-toggle="collapse" data-target="#contacto" aria-expanded="false" aria-controls="contacto">
          <div onClick="window.location='/inicio/index/contacto/'" style="display: inline-block;">Contactenos</div>
        </button>
      </li>
      <li class="nav-item dropdown active">
        <button id="btn-cuentas" class="btn btn-secondary  mr-2 mb-2 mt-2" type="button" data-toggle="collapse" data-target="#cuentas" aria-expanded="false" aria-controls="cuentas">
          <div onClick="window.location='/inicio/index/cuentas/'" style="display: inline-block;">Numeros de Cuentas</div>
        </button>
      </li>
      <li class="nav-item dropdown active">
        <button class="btn btn-secondary  mr-2 mb-2 mt-2"  onClick="window.location='/inicio/index/compras'" type="button" style="background-color: transparent;border-color: transparent;padding: 0px;font-size: 0px;">
          <i class="material-icons" style="font-size: 36px;">
          local_grocery_store
          </i>
          <span id="cant_carrito" style="height: 20px;min-width: 20px;position: absolute;z-index: 99999;background-color: white;color: #455a64;line-height: 14px;top: 8px;text-align: center;border-radius: 20px;font-size: 13px;padding-top: 3px;font-weight: bold;">0</span>
        </button>
      </li>
    </ul>
    <form  id="busqueda" class="form-inline my-2 my-lg-0" action="/inicio/index/">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Buscar" name="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  </div>
</nav>
<!--<div class="collapse" id="contacto" >
  <div class="container">
      <section class="main row pt-5" >
          <div class="col-12 col-lg-12 pt-3">
              <div class="card" style="width:100%">
                <h5 class="card-header">Tienda Centro -Lima</h5>
                <div class="card-body row">
                  <div class="col-12 col-sm-6 col-lg-3">
                    <div class="text-center">
                      <h5>Direccion</h5>
                      <div class="font-weight-light"> Av. Garcilazo de la vega 1348 interior SSA-140 Centro Comercial Cyber Plaza</div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-3">
                    <div class="text-center">
                      <h5>Telefono</h5>
                      <div class="font-weight-light">+51 709-4801</div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-3">
                    <div class="text-center">
                      <h5>Contacto</h5>
                      <div class="font-weight-light"> Angel Puma</div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-3">
                    <div class="text-center">
                      <h5>Horario</h5>
                      <div class="font-weight-light"> 9:00 a 18:00</div>
                    </div>
                  </div>
                  
                </div>
              </div>   
          </div>
      </section>
  </div>
</div>-->
<div class="collapse" id="cuentas">
</div>


