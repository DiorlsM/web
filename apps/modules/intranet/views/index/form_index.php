<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>Eac consulting</title>

    <link rel="stylesheet" type="text/css" href="/css/inicio_bootstrap.css">
    <link rel="stylesheet" href="/js/iviewer/jquery.iviewer.css" />
    
    <!--<script type="text/javascript" src="/js/ext-5.1.0/bootstrap.js"></script>
    <script type="text/javascript" src="/js/ext-5.1.0/packages/ext-locale/build/ext-locale-es.js"></script>-->

    <script type="text/javascript" src="/js/ext-6.2.1/ext-bootstrap.js"></script>
    <script type="text/javascript" src="/js/ext-6.2.1/build/ext-all.js"> </script>
    <script type="text/javascript" src="/js/ext-6.2.1/build/classic/locale/locale-es.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>
    
    <script src="/mdl/material.min.js"></script>
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js" ></script>
    <script type="text/javascript" src="/js/jquery-migrate-1.2.1.min.js" ></script>
    <script type="text/javascript" src="/js/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" src="/js/fusioncharts/js/fusioncharts.js"></script>
    <script type="text/javascript" src="/js/fusioncharts/js/fusioncharts.charts.js"></script>
    <script type="text/javascript" src="/js/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
    
    <script type="text/javascript" src="/js/least.min.js"></script>
    <script type="text/javascript" src="/js/jquery.Jcrop.min.js"></script>
    <script type="text/javascript" src="/js/calendario/calendario.js"></script>
    <script type="text/javascript" src="/js/d3.min.js" charset="utf-8"></script>

    <script type="text/javascript" src="/js/iviewer/jqueryui.js" ></script>
    <script type="text/javascript" src="/js/iviewer/jquery.mousewheel.min.js" ></script>
    <script type="text/javascript" src="/js/iviewer/jquery.iviewer.min.js" ></script>

    <link rel="stylesheet" href="/js/Gallery-2.16.0/css/blueimp-gallery.css">
    <link rel="stylesheet" href="/js/Gallery-2.16.0/css/blueimp-gallery-indicator.css">
    <link rel="stylesheet" href="/js/Gallery-2.16.0/css/demo.css">
    <link rel="stylesheet" href="/js/toastr/toastr.css">
    <link rel="stylesheet" href="/js/calendario/css/calendario.css">


     <!-- Stylesheets -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,400italic,300italic' rel='stylesheet' type='text/css'>
    <!--<link rel="stylesheet" href="/mdl/OwlCarousel2-2.2.1/docs/assets/css/docs.theme.min.css">-->

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="/mdl/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/mdl/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.theme.default.min.css">
    <script src="/mdl/OwlCarousel2-2.2.1/docs/assets/owlcarousel/owl.carousel.js"></script>

    <script src="/mdl/amcharts/amcharts/amcharts.js"></script>
    
    <!--<link rel="stylesheet" href="/mdl/leafletjs/leaflet.css">
    <script src="/mdl/leafletjs/leaflet.js"></script>
    <script src="/mdl/leafletjs/L.Routing.js"></script>
    <script src="/mdl/leafletjs/L.Routing.Draw.js"></script>
    <script src="/mdl/leafletjs/L.Routing.Edit.js"></script>-->

    <script type="text/javascript">
        Ext.Loader.setConfig({
            enabled: true,
            paths: {
                //'Ext.ux': '/js/ext-5.0.1/ux',
                'Ext.ux': '/js/ext-6.2.1/packages/ux/classic/src',
                'Ext.global': '/js/global'
            }
        });

        Ext.require([
            '*',
            'Ext.ux.Spotlight',
            'Ext.ux.form.SearchField',
            
        ]);
        
        Ext.Ajax.setTimeout(60000);

        var inicio = {
            id: 'inicio',
            url: '/intranet/index/',
            url_nv: '/gestion/novedades/',
            development: parseInt('<?php echo DEVELOPMENT;?>'),
            runner: new Ext.util.TaskRunner(),
            task: null,
            cofingM:{
                width:240,
                start:false,
                fous:true
            },
            id_nov:0,
            fil:0,
            idx:-1,
            type:'',
            view:{},
            record:{},
            id_msn:0,
            novedad:0,
            google:{
                map:null
            },
            dir_px:'<?php echo LATITUD_MAP;?>',
            dir_py:'<?php echo LONGITUD_MAP;?>',
            init: function(){

                

                Ext.tip.QuickTipManager.init();

                inicio.task = inicio.runner.newTask({
                    run: function(){
                        inicio.status();
                    },
                    interval: (1000 * 30)
                });

                inicio.task.start();

                /* ----------------------------------------------------- */
                var html_header = '<header class="Header">' +
                    '<div class="logo"></div>' +
                    '<div class="flag"></div>' +
                    '<div class="sistemas" id="sistemas"></div>' +
                    '<nav id="menu" class="menu"></nav>' +
                    '<div class="usuario">' +
                        '<img src="/images/icon/user.png" class="user_profile" data-qtip="Click para modificar contraseña."/>' +
                        '<span class="tit_usuario">Usuario: <?php echo USR_LOGIN;?> - </span>' +
                        '<span class="nom_usuario"><?php echo USR_NOMBRE;?></span>' +
                    '</div>' +
                    '<div class="exit" onclick="inicio.logout();" data-qtip="Click para salir del sistema."></div>' +
                '</header>';

                var html_footer = '<footer class="Footer">' +
                    '<div class="sello_izq"></div>' +
                    '<div class="creditos">' +
                        '<p>' +
                            '<span>Copyright&copy; </span>' +
                            '<span>Todos los derechos reservados</span>' +
                        '</p>' +
                    '</div>' +
                    '<div class="sello_der"></div>' +
                '</footer>';

                var htmlFondo = '<div class="fondo_principal " id="inicio-panel-proceso" >'+
                    '<div class="nX">'+
                        '<div class="oP">'+
                            '<div class="j"></div>'+
                            '<div class="j1"></div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

                

                var sistemasTpl = new Ext.XTemplate(
                    '<ul>',
                        '<tpl for=".">',
                            '<li class="container_list_system" >',
                                '<a class="pointer-list-system" >',
                                    '<span class="container-image-icon-system" >',
                                        '<img data-qtip="{nombre}" class="icon-system" src="/images/icon/google.png">',
                                    '</span>',
                                    '<span class="name-system" >',
                                        '{nombre}',
                                    '</span>',
                                '</a>',
                            '</li>',
                        '</tpl>',
                    '</ul>'
                );
                Ext.create('Ext.container.Viewport',{
                    id: inicio.id + '-contenedor',
                    border: false,
                    defaults:{
                        border: false,
                        style:{
                            margin: '0px'
                        }
                    },
                    layout: 'border',
                    items:[
                        {
                            region: 'north',
                            layout:'border',
                            height: 40,
                            border:false,
                            hidden:true,
                            items:[
                                
                            ]
                        },
                        {
                            region:'center',
                            layout:'border',
                            id: inicio.id+'-region-content',
                            border:false,
                            items:[
                                {
                                    region:'west',
                                    border:false,
                                    hidden:true,
                                    layout:'fit',
                                    items:[
                                        {
                                            xtype:'panel',
                                            id:'index_web_carga',
                                            hidden:true,
                                            hideMode:'offsets'
                                        }
                                    ]
                                },
                                {
                                    region: 'center',
                                    xtype: 'tabpanel',
                                    id: inicio.id+'-tabContent',
                                    activeItem: 0,
                                    autoScroll: false,
                                    defaults:{
                                        closable: true,
                                        hideMode: 'display',
                                        autoScroll: true
                                    },
                                    border: true,
                                    layout: 'fit',
                                    tabPosition: 'top',
                                    items:[
                                        /*{
                                            title: '',
                                            icon: '/images/icon/home.png',
                                            id:inicio.id+'-home',
                                            closable: false,
                                            layout: 'fit',
                                            html: htmlFondo,
                                            listeners:{
                                                afterrender: function(obj){
                                                },
                                            }
                                        }*/
                                    ],
                                    listeners:{
                                        afterrender:function(){
                                            win.show({vurl: '/intranet/panel/index', id_menu: 0, class: ''});
                                        }
                                    }
                                }
                            ]
                        }
                    ],
                    listeners:{
                        afterrender: function(obj){
                            inicio.status();
                            /*inicio.renderMenu();
                            
                            inicio.menu_vw();*/
                            
                        }
                    }
                });
            },
            
            logout: function(){
                Ext.getCmp(inicio.id + '-contenedor').mask('Saliendo del Sistema...');
                Ext.Ajax.request({
                    url: inicio.url + 'logout/',
                    params:{},
                    success: function(response, options){
                        Ext.getCmp(inicio.id + '-contenedor').unmask();
                        window.location = '/intranet/index/';
                    }
                });
            },
            status: function(){
                Ext.Ajax.request({
                    url: '/login/index/status_session/',
                    params:{},
                    success: function(response, options){
                        var res = Ext.JSON.decode(response.responseText);
                        if (parseInt(res.time) == 0 ){
                            inicio.task.stop();
                            global.Msg({
                                msg: 'Su sesión de usuario ha caducado, volver a ingresar al sistema.',
                                icon: 1,
                                buttons: 1,
                                fn: function(btn){
                                    window.location = '/login/index/'
                                }
                            });
                        }
                    }
                });
            },
        }
        Ext.onReady(inicio.init, inicio);

        
    </script>
</head>
<body>
    <div id="popup_jquery">
        <span class="button b-close"><span>X</span></span>
        <div id="popup_jquery_in" class="content" style="height: auto; width: auto;"></div>
    </div>
    <div id="menu_split">
    </div>

    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>

    <script src="/js/Gallery-2.16.0/js/blueimp-helper.js"></script>
    <script src="/js/Gallery-2.16.0/js/blueimp-gallery.js"></script>
    <script src="/js/Gallery-2.16.0/js/blueimp-gallery-fullscreen.js"></script>
    <script src="/js/Gallery-2.16.0/js/blueimp-gallery-indicator.js"></script>
    <script src="/js/Gallery-2.16.0/js/jquery.blueimp-gallery.js"></script>
    <script src="/js/toastr/toastr.js"></script>
    <script src="/js/load-image/load-image.js"></script>

    <div id="contentChat" class="contentChat_master">
    </div>
</body>
</html>