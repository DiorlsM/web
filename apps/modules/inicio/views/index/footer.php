 <!--Footer-->
<footer id="myFooter" class="">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h2 class="logo"><a href="#"> LOGO </a></h2>
            </div>
            <!--<div class="col-sm-2">
                <h5>Productos</h5>
                <ul>
                    <li><a href="#">PC</a></li>
                    <li><a href="#">Tablet</a></li>
                    <li><a href="#">Antivirus</a></li>
                </ul>
            </div>-->
            <div class="col-sm-4">
                <h5>Contactenos</h5>
                <ul>
                    <li><a href="#">Av. Garcilazo de la vega 1348 interior SSA-140 Centro Comercial Cyber Plaza</a></li>
                    <li><a href="#">+51 709-4801</a></li>
                    
                </ul>
            </div>
            <!--<div class="col-sm-2">
                <h5>Recomendado</h5>
                <ul>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
            </div>-->
            <div class="col-sm-3">
                <div class="social-networks">
                    <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.facebook.com/Apuma2017/" class="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="google"><i class="fa fa-google-plus"></i></a>
                </div>
                <!--<button type="button" class="btn btn-default">Contactanos</button>-->

            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p>© 2018 Copyright EAC Consulting </p>
    </div>
</footer>


<script type="text/javascript" src="/js/jquery-1.11.1.min.js" ></script>
<script src="/bootstrap-4.0.0/assets/js/vendor/popper.min.js"></script>    
<script src="/bootstrap-4.0.0/js/bootstrap.min.js"></script>
<script src="/bootstrap-4.0.0/assets/js/vendor/holder.min.js"></script> 
<!--<script type="text/javascript">
    jQuery(document).ready(function(){
      function initMap() {
          var local = {lat: -12.0537827, lng: -77.040442};
          var map = new google.maps.Map(document.getElementById('mapa'), {
            zoom: 10,
            center: local
          });
          var marker = new google.maps.Marker({
            position: local,
            map: map
          });

          var local2 = {lat: -11.8724956, lng: -77.1289011};
          var marker = new google.maps.Marker({
            position: local2,
            map: map
          });
      }
      initMap();
    }); 
 </script>-->
<!-- BEGIN JIVOSITE CODE {literal} -->
<script>
  $( document ).ready(function() {
    $("#btn-producto").click(function(){
      var cod_produc = $("#btn-producto")[0].attributes[1].value;
      $.ajax(
        {
          url: "/inicio/index/addCarrito/",
          data:{cod_produc:cod_produc},
          success: function(result){
            console.log(result);
            $.ajax({
              url:"/inicio/index/cuentaCarro/",
              success:function(result){
                console.log(result);
                $("#cant_carrito").html(result);
                //
              }
            });
          }
      });
    });
    $.ajax({
      url:"/inicio/index/cuentaCarro/",
      success:function(result){
        //console.log(result);
        $("#cant_carrito").html(result);
        //
      }
    });
    /*$( "select" )
      .change(function () {
        var str = "";
        $( "select option:selected" ).each(function() {
          //str += $( this ).text() + " ";
          $.ajax({
            url:"/inicio/index/changeCnt/",
            data:{
              cod_produc:$( this ).context.attributes[0].value,
              cnt: $( this ).text(),
            },
            success:function(result){
              
            }
          });
        });
    }).change();*/
    $('select').on('change', function() {
      console.log($( this ).val()  );
      $.ajax({
        url:"/inicio/index/changeCnt/",
        data:{
          cod_produc:$( this )[0].id,
          cnt: $( this ).val(),
        },
        success:function(result){
          window.location = '/inicio/index/compras?&nombre_completo='+$('#nombre_completo').val().trim()+'&telefono='+$('#telefono').val().trim()+'&correo='+$('#correo').val().trim();
        }
      });
    });

    $('#nombre_completo').keyup(function(){
      var nombre = $('#nombre_completo').val().trim();
      if (nombre.length > 3){
        $('#nombre_completo').addClass('is-valid').removeClass('is-invalid');
      }else{
        $('#nombre_completo').addClass('is-invalid').removeClass('is-valid');
      }
      
    });
    $('#telefono').keyup(function(){
      var telefono = $('#telefono').val().trim();
      if (telefono.length> 3){
        $('#telefono').addClass('is-valid').removeClass('is-invalid');
      }else{
        $('#telefono').addClass('is-invalid').removeClass('is-valid');
      }
    });
    $('#correo').keyup(function(){
      var correo = validarEmail($('#correo').val().trim());
      if (correo){
        $('#correo').addClass('is-invalid').removeClass('is-valid');
      }else{
        $('#correo').addClass('is-valid').removeClass('is-invalid');
      }
    });
    $('.submit').click(function(){
      var nombre = $('#nombre_completo').val().trim();
      var telefono = $('#telefono').val().trim();
      var correo = $('#correo').val().trim();
      var correo = validarEmail($('#correo').val().trim());
      if (nombre.length < 4){
        alert('ingrese un nombre');
        return;
      }
      if (telefono.length < 4){
        alert('ingrese un telefono'); 
        return;
      }

      if (correo){
        alert('Correo no Válido');
        return;
      }

      $.ajax({
        url:"/inicio/index/cuentaCarro/",
        success:function(result){
          if (result > 0){
            $.ajax({
              url:"/inicio/index/sendMail/",
              data:{
                nombre:nombre,
                telefono:telefono,
                correo:$('#correo').val().trim()
              },
              success:function(result){
                if (result == 'OK'){
                  alert('Compra Porcesado correctamente');
                  window.location = '/inicio/index/compras';
                }
              }
            });
          }else{
            alert('No hay productos en el carrito');
          }
        }
      });
    });

    function validarEmail (email) {
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!expr.test(email)) {
            return true;
        }
        return false;
    }
  });
</script>
<script type='text/javascript'>
  (function(){ var widget_id = 'wa3tVHpYo3';var d=document;var w=window;function l(){
  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->