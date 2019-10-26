<script type="text/javascript">

	var tab = Ext.getCmp(inicio.id + '-tabContent');
	if (!Ext.getCmp('panel-tab')){
		var panel = {
			id: 'panel',
            id_menu: '<?php echo $p["id_menu"]; ?>',
            url: '/intranet/panel/',
            init:function(){
            	tab.add({
                    id: panel.id + '-tab',
                    title:'Carga de Imagenes & Contenido',
                    border: false,
                    autoScroll: true,
                    closable: true,
                    layout: {
                        type: 'fit'
                    },
                    items: [
                        {
                            xtype:'panel',
                            border:false,
                            layout:'fit',
                            tbar:[
                                {
                                    xtype:'combo',
                                    id: panel.id+'-tipo',
                                    fieldLabel:'Tipo',
                                    labelWidth:30,
                                    store:Ext.create('Ext.data.Store',{
                                        fields:[
                                            {name: 'id_tipo', type: 'number'},
                                            {name: 'descrip', type: 'string'},
                                        ],
                                        autoLoad:true,
                                        proxy: {
                                            type: 'ajax',
                                            url: panel.url + 'lista_tipo/',
                                            reader: {
                                                type: 'json',
                                                rootProperty: 'data'
                                            }
                                        }
                                    }),
                                    queryMode: 'local',
                                    triggerAction: 'all',
                                    valueField: 'id_tipo',
                                    displayField: 'descrip',
                                    emptyText: '[Seleccione]',
                                    forceSelection: true,
                                    selectOnFocus: true,
                                    listeners:{
                                        afterrender:function(obj){
                                            obj.setValue(3);
                                        },
                                        select:function(obj,rec){
                                            panel.buscar();
                                        }
                                    }
                                },
                                {
                                    xtype:'combo',
                                    id:panel.id+'-cantidad',
                                    fieldLabel:'Cantidad',
                                    labelWidth:55,
                                    store:Ext.create('Ext.data.Store',{
                                        fields:[
                                            {name: 'id_tipo', type: 'number'},
                                            {name: 'descrip', type: 'string'},
                                        ],
                                        autoLoad:true,
                                        proxy: {
                                            type: 'ajax',
                                            url: panel.url + 'lista_cantidad/',
                                            reader: {
                                                type: 'json',
                                                rootProperty: 'data'
                                            }
                                        }
                                    }),
                                    queryMode: 'local',
                                    triggerAction: 'all',
                                    valueField: 'id_tipo',
                                    displayField: 'descrip',
                                    emptyText: '[Seleccione]',
                                    forceSelection: true,
                                    selectOnFocus: true,
                                    listeners:{
                                        afterrender:function(obj){
                                            obj.setValue(0);
                                        }
                                    }
                                },
                                {
                                    xtype:'textfield',
                                    id:panel.id+'-codigo',
                                    fieldLabel:'Codigo',
                                    labelWidth:50
                                },
                                {
                                    xtype:'textfield',
                                    id:panel.id+'-nombre',
                                    fieldLabel:'Nombre',
                                    labelWidth:50
                                },
                                {
                                    text:'buscar',
                                    icon:'/images/icon/search.png',
                                    listeners:{
                                        click:function(){
                                            panel.buscar();
                                        }
                                    }
                                }
                            ],
                            items:[
                                {
                                    xtype:'grid',
                                    id:panel.id+'-grid',
                                    columnLines: true,
                                    store: Ext.create('Ext.data.Store',{
                                        fields:[
                                        ],
                                        proxy:{
                                            type:'ajax',
                                            url:panel.url + 'SP_Panel_Img/',
                                            reader:{
                                                type:'json',
                                                rootProperty:'data'
                                            }
                                        }
                                    }),
                                    columns:[
                                        {
                                            text:'Menu',
                                            dataIndex:'codigo',
                                            renderer:function(value, metaData, record, rowIndex, colIndex, store, view){
                                                var dis_upload = false;
                                                var dis_edit = false;
                                                var dis_relation = true;
                                                var dis_banner = false;
                                                var tipo = Ext.getCmp(panel.id+'-tipo').getValue();
                                                if (tipo == 1){
                                                    dis_upload = true;
                                                    dis_edit = true;
                                                    dis_relation = false;
                                                }else if (tipo ==2 || tipo == 4){
                                                    dis_edit = true;
                                                }else if (tipo == 3){
                                                    dis_banner = true;
                                                }
                                                return global.permisos({
                                                    type: 'link',
                                                    extraCss: 'ftp-procesar-link',
                                                    icons: [
                                                        {disable:dis_upload,img: 'upload.png', qtip: 'Cargar Imagen', js: 'panel.cargaImagenes(\''+value+'\')',style:''},
                                                        {disable:dis_edit,img: 'edit.png', qtip: 'Editar Texto', js: 'panel.EditComentarioProducto(\''+value+'\')',style:''},
                                                        {disable:dis_relation,img: 'relation.png', qtip: 'Relacionar por Categoria', js: 'panel.Relation(\''+value+'\')',style:''},
                                                        {disable:dis_banner,img: 'upload.png', qtip: 'Carga Banner', js: 'panel.CargaDeBaner(\''+value+'\')',style:''},
                                                        
                                                    ]
                                                });
                                            }
                                        },
                                        {
                                            text:'Codigo',
                                            dataIndex:'codigo',
                                            width:177
                                        },
                                        {
                                            text:'Nombre',
                                            dataIndex:'descripcion',
                                            flex:1
                                        },
                                        {
                                            text:'Cnt. Imagen',
                                            dataIndex:''
                                        }
                                    ]
                                }
                            ]
                        }
                    ],
                    listeners: {
                        
                    }

                }).show();
            },
            buscar:function(){
                var vp_tipo = Ext.getCmp(panel.id+'-tipo').getValue();
                var vp_cant = Ext.getCmp(panel.id+'-cantidad').getValue();
                var vp_id = Ext.getCmp(panel.id+'-codigo').getValue();
                var vp_clave = Ext.getCmp(panel.id+'-nombre').getValue();

                Ext.getCmp(panel.id+'-grid').getStore().load({
                    params:{
                        vp_tipo:vp_tipo,
                        vp_cant:vp_cant,
                        vp_id:vp_id,
                        vp_clave:vp_clave
                    }
                })  
            },
            Relation:function(codigo){
                Ext.create('Ext.window.Window',{
                    id:panel.id+'relation-win',
                    height: 500,
                    width: 800,
                    resizable: false,
                    modal: true,
                    border: false,
                    header: false,
                    layout:'fit',
                    tbar: [
                            {
                                xtype: 'panel',
                                border: false,
                                layout: 'fit',
                                width: '100%',
                                html: '<div class="gk-panel" style="border-left: 0px solid #157fcc">' +
                                        '<header style="background-color:#157fcc" class="#157fcc">' +
                                        '<div class="cH">' +
                                        '<div class="logo"><span class="icon-signup" /></div>' +
                                        '<div class="cT">' +
                                        '<span class="title ue-uppercase">Relacionar Clasificación y Categoría</span>' +
                                        '<span class="sub-title ue-uppercase">Activa la relación</span>' +
                                        '</div>' +
                                        '</div>' +
                                        '</header>' +
                                        '</div>'
                            }
                    ],
                    items:[
                        {
                            xtype:'grid',
                            id:panel.id+'-relation-grid',
                            store: Ext.create('Ext.data.Store',{
                                fields:[],
                                autoLoad:true,
                                proxy:{
                                    type:'ajax',
                                    url:panel.url+'SP_Lista_clasi_cate/',
                                    extraParams:{vp_codigo:codigo},
                                    reader:{
                                        type:'json',
                                        rootProperty:'data'
                                    }
                                }
                            }),
                            columns:[
                                {
                                    text:'codigo',
                                    dataIndex:'codigo',
                                    width:110,
                                },
                                {
                                    text:'Categoría',
                                    dataIndex:'nombre',
                                    flex:1
                                },
                                {
                                    xtype: 'checkcolumn',
                                    //headerCheckbox:true,
                                    dataIndex: 'chk',
                                    width: 60,
                                    renderer: function (value, metaData, record, rowIndex, colIndex, store, view) {
                                        var cssPrefix = Ext.baseCSSPrefix,
                                                cls = cssPrefix + 'grid-checkcolumn';
                                        var setDisable = record.get('setDisable');
                                        if (setDisable == true) {
                                            metaData.tdCls += ' ' + this.disabledCls;
                                        }
                                        if (value) {
                                            cls += ' ' + cssPrefix + 'grid-checkcolumn-checked';
                                        }
                                        //return '<img class="' + cls + '" src="' + Ext.BLANK_IMAGE_URL + '"/>';
                                        return '<span class="' + cls + '" />';
                                    },
                                    listeners: {
                                        checkchange: function (obj, rowIndex, checked, eOpts) {
                                            panel.SaveServicio(rowIndex, checked,codigo);
                                        }
                                    }
                                }
                            ]
                        }
                    ],
                    dockedItems:[
                        {
                            xtype: 'toolbar',
                            dock: 'bottom',
                            ui: 'footer',
                            alignTarget: 'center',
                            layout: {
                                pack: 'center'
                            },
                            baseCls: 'gk-toolbar',
                            items:[
                                {
                                    xtype: 'button',
                                    text: 'Salir',
                                    tooltip: 'Salir',
                                    icon: '/images/icon/back.png',
                                    listeners: {
                                        click: function (obj, e) {
                                            Ext.getCmp(panel.id+'relation-win').close();
                                        }
                                    }
                                }
                            ]
                        }
                    ]
                }).show().center();
            },
            SaveServicio: function (rowIndex, checked,vp_cod_clasi) {
                var record = Ext.getCmp(panel.id+'-relation-grid').getStore().getAt(rowIndex);
                
                var vp_cod_cate = record.get('codigo');
                var vp_estado =record.get('chk') == true?1:0;
                Ext.Ajax.request({
                    url: panel.url + 'SP_Graba_clasi_cate/',
                    params: {
                        vp_cod_clasi:vp_cod_clasi,
                        vp_cod_cate:vp_cod_cate,
                        vp_estado:vp_estado
                    },
                    success: function (response, options) {
                        var res = Ext.JSON.decode(response.responseText).data[0];
                        if (res.error_sql < 0) {
                            global.toas({warning: 2, msg: res.error_info, timeout: 2000});
                        } else {
                            global.toas({warning: 0, msg: res.error_info, timeout: 2000});
                        }
                    }
                });
            },
            CargaDeBaner:function(codigo){
                Ext.create('Ext.window.Window',{
                    id:panel.id+'-win-img',
                    height: 500,
                    width: 600,
                    resizable: false,
                    modal: true,
                    border: false,
                    header: false,
                    layout:'fit',
                    tbar: [
                            {
                                xtype: 'panel',
                                border: false,
                                layout: 'fit',
                                width: '100%',
                                html: '<div class="gk-panel" style="border-left: 0px solid #157fcc">' +
                                        '<header style="background-color:#157fcc" class="#157fcc">' +
                                        '<div class="cH">' +
                                        '<div class="logo"><span class="icon-signup" /></div>' +
                                        '<div class="cT">' +
                                        '<span class="title ue-uppercase">Carga de Banner</span>' +
                                        '<span class="sub-title ue-uppercase">Sube las Banner al portal</span>' +
                                        '</div>' +
                                        '</div>' +
                                        '</header>' +
                                        '</div>'
                            }
                    ],
                    items:[
                        {
                            xtype:'form',
                            id:panel.id+'-form',
                            layout:'column',
                            items:[
                                {
                                    xtype:'filefield',
                                    margin: '10 10 10 10',
                                    columnWidth: 0.55,
                                    id: panel.id+'-file-img',
                                    name: panel.id+'-file-img',
                                    labelWidth: 50,
                                    fieldLabel: 'Imagen',
                                    allowBlank: false,
                                    width: 300,
                                    emptyText: 'Seleccione Archivo',
                                    buttonText: '',
                                    buttonConfig: {
                                        iconCls: 'panel-directory'
                                    },
                                    listeners: {
                                        change: function (fld, value) {
                                            var newValue = value.replace(/C:\\fakepath\\/g, '');
                                            fld.setRawValue(newValue);
                                            var elem = fld.value.split('.');
                                            var ext = elem[elem.length - 1];
                                            ext = ext.toLowerCase();
                                            //console.log(ext);
                                            if (ext == 'jpg') {
                                            } else {
                                                global.Msg({
                                                    msg: 'La extencion: ' + ext + ' del archivo no es valido</br>Solo debes subir imagenes "jpg"',
                                                    icon: 1,
                                                    buttons: 1,
                                                    fn: function () {
                                                        fld.reset();
                                                    }
                                                });
                                            }
                                        }
                                    }
                                },
                                {
                                    xtype:'panel',
                                    columnWidth:1,
                                    height:350,
                                    html:'<div id="GaleryFullImgs" class="links plugin-links"></div>'
                                }
                            ]
                        }
                    ],
                    listeners:{
                        afterrender:function(){
                            panel.getImgVisitaBanner(codigo);
                        }
                    },
                    dockedItems:[
                        {
                            xtype: 'toolbar',
                            dock: 'bottom',
                            ui: 'footer',
                            alignTarget: 'center',
                            layout: {
                                pack: 'center'
                            },
                            baseCls: 'gk-toolbar',
                            items:[
                                {
                                    xtype: 'button',
                                    margin: '10 0 0 10',
                                    text: 'Grabar',
                                    tooltip: 'Grabar',
                                    icon: '/images/icon/save.png',
                                    columnWidth: 0.05,
                                    listeners: {
                                        click: function (obj, e) {
                                            panel.upload_img_banner(codigo);
                                        }
                                    }
                                },
                                {
                                    xtype: 'button',
                                    text: 'Salir',
                                    tooltip: 'Salir',
                                    icon: '/images/icon/back.png',
                                    listeners: {
                                        click: function (obj, e) {
                                            Ext.getCmp(panel.id+'-win-img').close();
                                        }
                                    }
                                }
                            ]
                        }
                    ]
                }).show().center();
            },
            upload_img_banner:function(codigo){
                console.log(codigo);
                var form = Ext.getCmp(panel.id+'-form').getForm();
                var mask = new Ext.LoadMask(Ext.getCmp(panel.id+'-form'), {
                    msg: 'Cargando Imagen...'
                });
                var vp_tipo_carga = Ext.getCmp(panel.id+'-tipo').getValue();
                if (form.isValid()){
                    mask.show();
                    form.submit({
                        url:  panel.url+'set_uploadBanner/',
                        params: {
                            vp_tipo_carga:vp_tipo_carga,
                            vp_cod:codigo,
                        },
                        witMsg:'Upload....',
                        success:function(fp,o) {
                            mask.hide();
                            panel.getImgVisitaBanner(codigo);   
                            
                        },
                        failure: function (fp, o) {
                            mask.hide();
                        }
                    });

                }else{
                    global.Msg({
                        msg: 'Debes seleccionar una imagen jpg',
                        icon: 0,
                        buttons: 1,
                        fn: function () {
                        }
                    });
                }
            },
            getImgVisitaBanner:function(vp_cod){
                var vp_tipo_carga = Ext.getCmp(panel.id+'-tipo').getValue();
                panel.getGaleryBanner({container: 'GaleryFullImgs', url:  panel.url+'Lista_baner/', params: {vp_tipo_carga:vp_tipo_carga,vp_cod:vp_cod}});
            },
            getGaleryBanner:function(params){
                var mask = new Ext.LoadMask(Ext.getCmp(panel.id + '-form'), {
                    msg: 'Cargando Galeria...'
                });
                mask.show();
                Ext.get(params.container).update('');
                Ext.Ajax.request({
                    url: params.url,
                    params: params.params,
                    success: function (response, options) {
                        mask.hide();
                        var html = '';
                        var res = Ext.decode(response.responseText);
                        //console.log(res);
                        var carouselLinks = [],
                                //linksContainer = $('#'+params.container),
                                linksContainer = document.getElementById(params.container),
                                baseUrl;
                        for (var j = 0; j < res.data.length; j++) {
                            //console.log(res);
                            var img_id = res.data[j].id;
                            var resp = res.data[j].nombre;
                            html += ' ';
                            html += '<div class="img-cont">';
                            html += '<a class="plugin_delete" id="img-del-' + j + '" onClick="panel.deleteBanner('+img_id+',\''+params.params.vp_cod+'\')">X</a>';
                            html += '<a href="' + res.data[j].nombre + '" title="' + res.data[j].time + '" data-gallery="">';
                                html += '<img src="' + res.data[j].nombre + '" style="width: 100px;height:100px;margin: -21px -5px;">';
                            html += '</a>';
                            html += '</div>';
                        }

                        Ext.get(linksContainer).update(html);
                    }
                });
            },
            deleteBanner:function(img_id,vp_cod){
                global.Msg({
                    msg: '¿Deseas eliminar la imagen?',
                    icon: 1,
                    buttons: 3,
                    fn: function (resul) {
                        if (resul == 'yes') {
                            global.Msg({
                                msg: 'Este proceso no tiene reversion!! </br>¿Realmente deseas eliminar la imagen?',
                                icon: 1,
                                buttons: 3,
                                fn: function (res) {
                                    if (res == 'yes') {
                                        var maska = new Ext.LoadMask(Ext.getCmp(panel.id + '-form'), {
                                            msg: 'Borrando Imagen...'
                                        });
                                        maska.show();
                                        Ext.Ajax.request({
                                            url:  panel.url+'SP_elimina_imagen_banner/',//scm_del_img
                                            params: {
                                                vp_id:img_id
                                            },
                                            success: function (response, options) {
                                                //console.log(img_id);
                                                maska.hide();
                                                var res = Ext.JSON.decode(response.responseText).data[0];
                                                if (parseInt(res.error_sql) == 0) {
                                                    global.Msg({
                                                        msg: res.error_info,
                                                        icon: 1,
                                                        buttons: 1,
                                                        fn: function () {
                                                           panel.getImgVisitaBanner(vp_cod);   
                                                        }
                                                    });
                                                } else {
                                                    global.Msg({
                                                        msg: res.error_info,
                                                        icon: 0,
                                                        buttons: 1,
                                                        fn: function () {
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            },
            cargaImagenes:function(codigo){
                Ext.create('Ext.window.Window',{
                    id:panel.id+'-win-img',
                    height: 500,
                    width: 600,
                    resizable: false,
                    modal: true,
                    border: false,
                    header: false,
                    layout:'fit',
                    tbar: [
                            {
                                xtype: 'panel',
                                border: false,
                                layout: 'fit',
                                width: '100%',
                                html: '<div class="gk-panel" style="border-left: 0px solid #157fcc">' +
                                        '<header style="background-color:#157fcc" class="#157fcc">' +
                                        '<div class="cH">' +
                                        '<div class="logo"><span class="icon-signup" /></div>' +
                                        '<div class="cT">' +
                                        '<span class="title ue-uppercase">Carga de Imagenes</span>' +
                                        '<span class="sub-title ue-uppercase">Sube las imagenes al portal</span>' +
                                        '</div>' +
                                        '</div>' +
                                        '</header>' +
                                        '</div>'
                            }
                    ],
                    items:[
                        {
                            xtype:'form',
                            id:panel.id+'-form',
                            layout:'column',
                            items:[
                                {
                                    xtype:'combo',
                                    fieldLabel:'Tipo',
                                    id:panel.id+'-tipo_imagen',
                                    columnWidth:0.4,
                                    margin: '10 10 10 10',
                                    labelWidth:40,
                                    store:Ext.create('Ext.data.Store',{
                                        fields:[
                                            {name: 'id_tipo', type: 'number'},
                                            {name: 'descrip', type: 'string'},
                                        ],
                                        autoLoad:true,
                                        proxy: {
                                            type: 'ajax',
                                            url: panel.url + 'tipo_imagen/',
                                            reader: {
                                                type: 'json',
                                                rootProperty: 'data'
                                            }
                                        }
                                    }),
                                    queryMode: 'local',
                                    triggerAction: 'all',
                                    valueField: 'id_tipo',
                                    displayField: 'descrip',
                                    emptyText: '[Seleccione]',
                                    forceSelection: true,
                                    selectOnFocus: true,
                                    listeners:{
                                        afterrender:function(obj){
                                            obj.setValue(1);
                                        }
                                    }
                                },
                                {
                                    xtype:'filefield',
                                    margin: '10 10 10 10',
                                    columnWidth: 0.55,
                                    id: panel.id+'-file-img',
                                    name: panel.id+'-file-img',
                                    labelWidth: 50,
                                    fieldLabel: 'Imagen',
                                    allowBlank: false,
                                    width: 300,
                                    emptyText: 'Seleccione Archivo',
                                    buttonText: '',
                                    buttonConfig: {
                                        iconCls: 'panel-directory'
                                    },
                                    listeners: {
                                        change: function (fld, value) {
                                            var newValue = value.replace(/C:\\fakepath\\/g, '');
                                            fld.setRawValue(newValue);
                                            var elem = fld.value.split('.');
                                            var ext = elem[elem.length - 1];
                                            ext = ext.toLowerCase();
                                            //console.log(ext);
                                            if (ext == 'jpg') {
                                            } else {
                                                global.Msg({
                                                    msg: 'La extencion: ' + ext + ' del archivo no es valido</br>Solo debes subir imagenes "jpg"',
                                                    icon: 1,
                                                    buttons: 1,
                                                    fn: function () {
                                                        fld.reset();
                                                    }
                                                });
                                            }
                                        }
                                    }
                                },
                                {
                                    xtype:'panel',
                                    columnWidth:1,
                                    height:350,
                                    html:'<div id="GaleryFullImgs" class="links plugin-links"></div>'
                                }
                            ]
                        }
                    ],
                    listeners:{
                        afterrender:function(){
                            panel.getImgVisita(codigo);
                        }
                    },
                    dockedItems:[
                        {
                            xtype: 'toolbar',
                            dock: 'bottom',
                            ui: 'footer',
                            alignTarget: 'center',
                            layout: {
                                pack: 'center'
                            },
                            baseCls: 'gk-toolbar',
                            items:[
                                {
                                    xtype: 'button',
                                    margin: '10 0 0 10',
                                    text: 'Grabar',
                                    tooltip: 'Grabar',
                                    icon: '/images/icon/save.png',
                                    columnWidth: 0.05,
                                    listeners: {
                                        click: function (obj, e) {
                                            panel.upload_img(codigo);
                                        }
                                    }
                                },
                                {
                                    xtype: 'button',
                                    text: 'Salir',
                                    tooltip: 'Salir',
                                    icon: '/images/icon/back.png',
                                    listeners: {
                                        click: function (obj, e) {
                                            Ext.getCmp(panel.id+'-win-img').close();
                                        }
                                    }
                                }
                            ]
                        }
                    ]
                }).show().center()
            },
            upload_img:function(codigo){
                console.log(codigo);
                var form = Ext.getCmp(panel.id+'-form').getForm();
                var mask = new Ext.LoadMask(Ext.getCmp(panel.id+'-form'), {
                    msg: 'Cargando Imagen...'
                });
                var vp_tipo_carga = Ext.getCmp(panel.id+'-tipo').getValue();
                var vp_tipo_imagen = Ext.getCmp(panel.id+'-tipo_imagen').getValue();
                if (form.isValid()){
                    mask.show();
                    form.submit({
                        url:  panel.url+'set_upload/',
                        params: {
                            vp_tipo_carga:vp_tipo_carga,
                            vp_cod:codigo,
                            vp_tipo_imagen:vp_tipo_imagen,
                        },
                        witMsg:'Upload....',
                        success:function(fp,o) {
                            mask.hide();
                            panel.getImgVisita(codigo);   
                            
                        },
                        failure: function (fp, o) {
                            mask.hide();
                        }
                    });

                }else{
                    global.Msg({
                        msg: 'Debes seleccionar una imagen jpg',
                        icon: 0,
                        buttons: 1,
                        fn: function () {
                        }
                    });
                }
            },
            getImgVisita: function (vp_cod) {
                //console.log(vp_cod);
                var vp_tipo_carga = Ext.getCmp(panel.id+'-tipo').getValue();
                panel.getGalery({container: 'GaleryFullImgs', url:  panel.url+'lista_imagenes/', params: {vp_tipo_carga:vp_tipo_carga,vp_cod:vp_cod}});
            },
            getGalery: function (params) {
                
                var mask = new Ext.LoadMask(Ext.getCmp(panel.id + '-form'), {
                    msg: 'Cargando Galeria...'
                });
                mask.show();
                Ext.get(params.container).update('');
                Ext.Ajax.request({
                    url: params.url,
                    params: params.params,
                    success: function (response, options) {
                        mask.hide();
                        var html = '';
                        var res = Ext.decode(response.responseText);
                        //console.log(res);
                        var carouselLinks = [],
                                //linksContainer = $('#'+params.container),
                                linksContainer = document.getElementById(params.container),
                                baseUrl;
                        for (var j = 0; j < res.data.length; j++) {
                            //console.log(res);
                            var img_id = res.data[j].id;
                            var resp = res.data[j].nombre;
                            html += ' ';
                            html += '<div class="img-cont">';
                            html += '<a class="plugin_delete" id="img-del-' + j + '" onClick="panel.deleteGalery('+img_id+','+params.params.vp_tipo_carga+',\''+params.params.vp_cod+'\');">X</a>';
                            html += '<a href="' + res.data[j].nombre + '" title="' + res.data[j].time + '" data-gallery="">';
                            html += '<img src="' + res.data[j].nombre + '" style="width: 100px;height:100px;margin: -21px -5px;">';
                            html += '</a>';
                            html += '</div>';
                        }

                        Ext.get(linksContainer).update(html);

                        /*for (var h = 0; h < res.data.length; h++) {
                            var img_id = res.data[h].id;
                            Ext.get('img-del-' + h).on('click', function () {
                                global.Msg({
                                    msg: '¿Deseas eliminar la imagen?',
                                    icon: 1,
                                    buttons: 3,
                                    fn: function (resul) {
                                        //console.log(resul);
                                        if (resul == 'yes') {
                                            global.Msg({
                                                msg: 'Este proceso no tiene reversion!! </br>¿Realmente deseas eliminar la imagen?',
                                                icon: 1,
                                                buttons: 3,
                                                fn: function (res) {
                                                    if (res == 'yes') {
                                                        var maska = new Ext.LoadMask(Ext.getCmp(panel.id + '-form'), {
                                                            msg: 'Borrando Imagen...'
                                                        });
                                                        maska.show();
                                                        Ext.Ajax.request({
                                                            url:  panel.url+'scm_del_img/',
                                                            params: {
                                                                vp_tipo_carga:params.params.vp_tipo_carga,
                                                                vp_id:img_id
                                                            },
                                                            success: function (response, options) {
                                                                //console.log(img_id);
                                                                maska.hide();
                                                                var res = Ext.JSON.decode(response.responseText).data[0];
                                                                if (parseInt(res.error_sql) == 0) {
                                                                    global.Msg({
                                                                        msg: res.error_info,
                                                                        icon: 1,
                                                                        buttons: 1,
                                                                        fn: function () {
                                                                           panel.getImgVisita(params.params.vp_cod);   
                                                                        }
                                                                    });
                                                                } else {
                                                                    global.Msg({
                                                                        msg: res.error_info,
                                                                        icon: 0,
                                                                        buttons: 1,
                                                                        fn: function () {
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            });
                                        }
                                    }
                                });
                            });
                        }*/
                    }
                });
            },
            deleteGalery:function(img_id,vp_tipo_carga,vp_cod){
                global.Msg({
                    msg: '¿Deseas eliminar la imagen?',
                    icon: 1,
                    buttons: 3,
                    fn: function (resul) {
                        //console.log(resul);
                        if (resul == 'yes') {
                            global.Msg({
                                msg: 'Este proceso no tiene reversion!! </br>¿Realmente deseas eliminar la imagen?',
                                icon: 1,
                                buttons: 3,
                                fn: function (res) {
                                    if (res == 'yes') {
                                        var maska = new Ext.LoadMask(Ext.getCmp(panel.id + '-form'), {
                                            msg: 'Borrando Imagen...'
                                        });
                                        maska.show();
                                        Ext.Ajax.request({
                                            url:  panel.url+'scm_del_img/',
                                            params: {
                                                vp_tipo_carga:vp_tipo_carga,
                                                vp_id:img_id
                                            },
                                            success: function (response, options) {
                                                //console.log(img_id);
                                                maska.hide();
                                                var res = Ext.JSON.decode(response.responseText).data[0];
                                                if (parseInt(res.error_sql) == 0) {
                                                    global.Msg({
                                                        msg: res.error_info,
                                                        icon: 1,
                                                        buttons: 1,
                                                        fn: function () {
                                                           panel.getImgVisita(vp_cod);   
                                                        }
                                                    });
                                                } else {
                                                    global.Msg({
                                                        msg: res.error_info,
                                                        icon: 0,
                                                        buttons: 1,
                                                        fn: function () {
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            },
            EditComentarioProducto:function(vp_cod){
                Ext.Ajax.request({
                    url:panel.url+'Lista_Prod/',
                    params:{
                        vp_cod:vp_cod   
                    },
                    success: function (response, options){
                        var res = Ext.decode(response.responseText).data[0];
                        console.log(res);
                        Ext.create('Ext.window.Window',{
                            id:panel.id+'-win-producto',
                            height: '80%',
                            width: '90%',
                            resizable: false,
                            modal: true,
                            border: false,
                            header: false,
                            layout:'fit',
                            tbar: [
                                    {
                                        xtype: 'panel',
                                        border: false,
                                        layout: 'fit',
                                        width: '100%',
                                        html: '<div class="gk-panel" style="border-left: 0px solid #157fcc">' +
                                                '<header style="background-color:#157fcc" class="#157fcc">' +
                                                '<div class="cH">' +
                                                '<div class="logo"><span class="icon-signup" /></div>' +
                                                '<div class="cT">' +
                                                '<span class="title ue-uppercase">Modificar Descripción, Caracteristicas, Especificaciones</span>' +
                                                '<span class="sub-title ue-uppercase">Edita el producto en la web</span>' +
                                                '</div>' +
                                                '</div>' +
                                                '</header>' +
                                                '</div>'
                                    }
                            ],
                            items:[
                                {
                                    xtype:'tabpanel',
                                    layout:'fit',
                                    tbar:[
                                        {
                                            xtype:'combo',
                                            id:panel.id+'tipo-producto',
                                            fieldLabel:'Tipo Producto',
                                            labelWidth:100,
                                            store:Ext.create('Ext.data.Store',{
                                                fields:[
                                                    {name: 'id_tipo', type: 'number'},
                                                    {name: 'descrip', type: 'string'},
                                                ],
                                                autoLoad:true,
                                                proxy: {
                                                    type: 'ajax',
                                                    url: panel.url + 'tipo_producto/',
                                                    reader: {
                                                        type: 'json',
                                                        rootProperty: 'data'
                                                    }
                                                }
                                            }),
                                            queryMode: 'local',
                                            triggerAction: 'all',
                                            valueField: 'id_tipo',
                                            displayField: 'descrip',
                                            emptyText: '[Seleccione]',
                                            forceSelection: true,
                                            selectOnFocus: true,
                                            allowBlank:false,
                                            listeners:{
                                                afterrender:function(obj){
                                                    obj.setValue(res.prod_tipo);
                                                }
                                            }
                                        }
                                    ],
                                    items:[
                                        {
                                            title:'Descripción',
                                            layout:'fit',
                                            items:[
                                                {
                                                    xtype:'textarea',
                                                    id:panel.id+'-descripcion',
                                                    emptyText: 'Ingrese la Descripción',
                                                    enforceMaxLength:true,
                                                    maxLength:60000,
                                                    maxLengthText:'El maximo de caracteres permitidos para este campo es {0}',
                                                    value:res.prod_descri
                                                }
                                            ]
                                        },
                                        {
                                            title:'Caracteristicas',
                                            layout:'fit',
                                            items:[
                                                {
                                                    xtype:'textarea',
                                                    id:panel.id+'caracteristicas',
                                                    emptyText: 'Ingrese las Caracteristicas',
                                                    enforceMaxLength:true,
                                                    maxLength:60000,
                                                    maxLengthText:'El maximo de caracteres permitidos para este campo es {0}',
                                                    value: res.prod_caract
                                                }
                                            ]
                                        },
                                        {
                                            title:'Especificaciones',
                                            layout:'fit',
                                            items:[
                                                {
                                                    xtype:'textarea',
                                                    id:panel.id+'especificaciones',
                                                    emptyText: 'Ingrese las Especificaciones',
                                                    enforceMaxLength:true,
                                                    maxLength:60000,
                                                    maxLengthText:'El maximo de caracteres permitidos para este campo es {0}',
                                                    value: res.prod_especif
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ],
                            dockedItems:[
                                {
                                    xtype: 'toolbar',
                                    dock: 'bottom',
                                    ui: 'footer',
                                    alignTarget: 'center',
                                    layout: {
                                        pack: 'center'
                                    },
                                    baseCls: 'gk-toolbar',
                                    items:[
                                        {
                                            xtype: 'button',
                                            margin: '10 0 0 10',
                                            text: 'Grabar',
                                            tooltip: 'Grabar',
                                            icon: '/images/icon/save.png',
                                            columnWidth: 0.05,
                                            listeners: {
                                                click: function (obj, e) {
                                                   panel.SaveProductos(vp_cod);
                                                }
                                            }
                                        },
                                        {
                                            xtype: 'button',
                                            text: 'Salir',
                                            tooltip: 'Salir',
                                            icon: '/images/icon/back.png',
                                            listeners: {
                                                click: function (obj, e) {
                                                    Ext.getCmp(panel.id+'-win-producto').close();
                                                }
                                            }
                                        }
                                    ]
                                }
                            ]
                        }).show().center();
                    }
                })  
            },
            SaveProductos:function(vp_cod){
                var vp_opt = Ext.getCmp(panel.id+'tipo-producto').getValue();
                var vp_descri = Ext.getCmp(panel.id+'-descripcion').getValue();
                var vp_caract = Ext.getCmp(panel.id+'caracteristicas').getValue();
                var vp_especi = Ext.getCmp(panel.id+'especificaciones').getValue();

                if (!Ext.getCmp(panel.id+'tipo-producto').isValid()){
                    global.toas({warning: 2, msg: 'Tienes que seleccionar un tipo de producto', timeout: 2000});
                    return;
                }
                Ext.Ajax.request({
                    url:panel.url+'SP_Graba_Prod/',
                    params:{
                        vp_cod:vp_cod,
                        vp_descri:vp_descri,
                        vp_caract:vp_caract,
                        vp_especi:vp_especi,
                        vp_opt:vp_opt
                    },
                    success: function (response, options){
                        var res = Ext.decode(response.responseText).data[0];
                        if (parseInt(res.error_sql) < 0){
                            global.toas({warning: 2, msg: res.error_info, timeout: 2000});
                        }else{
                            global.toas({warning: 0, msg: res.error_info, timeout: 2000});
                            Ext.getCmp(panel.id+'-win-producto').close();
                        }
                        
                    }
                })
            },
		}
		Ext.onReady(panel.init, panel);
	}else {
        tab.setActiveTab(panel.id + '-tab');
    }

</script>