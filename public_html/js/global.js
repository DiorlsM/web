
/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

win = {
    request:[],
    modules:[],
    loaded:false,
    getModule:function(v){
        var ms = this.modules;
        for(var i = 0, len = ms.length; i < len; i++){
            if(ms[i].id == v ){
                return ms[i];
            }
        }
        return null;
    },
    loadModuleComplete:function(success, vid){
        if(success === true && vid){
            this.request.push({
                id:vid
            });
        }
    },
    requestModule:function(id){
        var ms = this.request;
        for(var i = 0, len = ms.length; i < len; i++){
            if(id==ms[i].id) return true;
        }
        return false;
    },
    /**
     * Función para la carga de objetos Extjs (tabs, ventanas, etc)
     * ------------------------------------------------------------
     * Para la carga optimizada modificar parámetros de configuración
     * en el archivo config.ini( app.development = false )
     * El menu de opciones se encarga de cargarlos dinámicamente
     * según el nombre del objeto javascript
     */
    show:function(param){
        this.p = param;

        this.p.vurl = this.p.vurl == undefined ? '' : this.p.vurl;
        this.p.id_menu = this.p.id_menu == undefined ? 0 : this.p.id_menu;
        this.p.options = this.p.options == undefined?'':this.p.options;
        
        if (Ext.util.Format.trim(this.p.vurl) != ''){
            /*if (this.p.vurl.split('?').length > 1){
                params = Ext.Object.fromQueryString(this.p.vurl.split('?')[1]+'&id_menu='+this.p.id_menu);
            }else{
                params = {
                    id_menu: this.p.id_menu
                }
            }*/

            Ext.getCmp(inicio.id + '-contenedor').mask('Please wait...');
            Ext.get('index_web_carga').load({
                url: this.p.vurl,
                scripts: true,
                mask: true,
                method: 'POST',
                //params: params,
                callback:function(){
                    Ext.getCmp(inicio.id + '-contenedor').unmask();
                }
            });

            
            
        }else{
            global.Msg({
                msg: 'No tiene url asignada!',
                icon: 2,
                buttons: 1,
                fn: function(btn){

                }
            });
        }
    },
    getGalery:function(params){
        Ext.get(params.container).update('');
        Ext.Ajax.request({
            url:params.url,
            params:params.params,
            success:function(response,options){
                var res = Ext.decode(response.responseText);

                var html = '';
                html = '<div class="slides"></div>';
                html += '<h3 class="title"></h3>';
                html += '<a class="prev">‹</a>';
                html += '<a class="next">›</a>';
                html += '<a class="close">×</a>';
                html += '<a class="play-pause"></a>';
                html += '<ol class="indicator"></ol>';
                Ext.get('blueimp-gallery').update(html);

                //console.log(res);
                var carouselLinks = [],
                linksContainer = $('#'+params.container),
                baseUrl;
                for(var j=0;j<res.data.length;j++){
                    //baseUrl = 'fotos_iridio/';
                    $('<a/>')
                        .append($('<img>').prop('src', res.data[j].img_thumbs).height(70).width(70))
                        .prop('href', res.data[j].img_path)
                        .prop('title', res.data[j].time+"")
                        .attr('data-gallery', '')
                        .appendTo(linksContainer);
                }
            }
        });
    },
    getGaleryControlRuta:function(params){
        Ext.get(params.container).update('');
        Ext.Ajax.request({
            url:params.url,
            params:params.params,
            success:function(response,options){
                var res = Ext.decode(response.responseText);
                
                var html = '';
                html = '<div class="slides"></div>';
                html += '<h3 class="title"></h3>';
                html += '<a class="prev">‹</a>';
                html += '<a class="next">›</a>';
                html += '<a class="close">×</a>';
                html += '<a class="play-pause"></a>';
                html += '<ol class="indicator"></ol>';
                Ext.get('blueimp-gallery').update(html);

                var carouselLinks = [],
                linksContainer = $('#'+params.container),
                baseUrl;
                for(var j=0;j<res.data.length;j++){
                    //baseUrl = 'fotos_iridio/';
                    $('<div/>')
                        .width('50%')
                        .css({
                            'float': 'left'
                        })
                        .append($('<a>')
                            .width(73)
                            .attr('data-gallery', '')
                            .prop('href', res.data[j].img_path)
                            .css({
                                'float': 'left'
                            })
                            .append($('<img>')
                                    .prop('src', res.data[j].img_thumbs)
                                    .prop('title', res.data[j].time+"")
                                    )
                                )
                        .append($('<div>')
                            .prop('title', res.data[j].time+"")
                            .width(140)
                            .height(73)
                            .css({
                            'float': 'left'
                            })
                        )
                        .appendTo(linksContainer);
                }
            }
        });
    },
}

var LarSyrExt = function(){
    this.Msg = function(p){
        var icons = [Ext.Msg.ERROR, Ext.Msg.INFO, Ext.Msg.WARNING, Ext.Msg.QUESTION];
        var button = [Ext.Msg.CANCEL, Ext.Msg.OK, Ext.Msg.OKCANCEL, Ext.Msg.YESNO, Ext.Msg.YESNOCANCEL];
        p.title = p.title==undefined?'Eac consulting':p.title;
        p.msg = p.title==undefined?'':p.msg;
        p.buttons = p.buttons==undefined?1:p.buttons;
        p.icon = p.icon==undefined?1:p.icon;
        p.fn = p.fn==undefined?false:p.fn;
        Ext.Msg.show({
            title: p.title,
            msg: p.msg,
            buttons: button[p.buttons],
            icon: icons[p.icon],
            fn:p.fn
        });
    };
    this.toas =function(p){
        var war = ['success','warning','error'];
        p.warning = p.warning ==undefined?0:p.warning;
        p.msg = p.msg;
        p.timeout = p.timeout == undefined?1000:p.timeout;
        p.audio = p.audio == undefined?false:p.audio;

        

        Command: toastr[war[p.warning]](p.msg);
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": true,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": p.timeout,
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        console.log(p.audio);
        if (p.audio == true){
            Ext.DomQuery.select('.pyp_chicharra >audio')[0].play();
        }
    };
    this.notification = function(p){
        this.p = p;
        this.p.vtitle = this.p.vtitle == undefined?'Notificacion':this.p.vtitle;
        this.p.vhtml = this.p.vhtml == undefined?'M&oacute;dulos Cargados':this.p.vhtml;
        this.p.vtime = this.p.vtime == undefined?5000:parseInt(this.p.vtime);
        new Ext.ux.Notification({
            title : this.p.vtitle,
            html : this.p.vhtml,
            autoDestroy : true,
            hideDelay : this.p.vtime,
            shadow : false,
            padding : 5
        }).show(Ext.getBody());
    };
   
    this.permisos = function(p){
        var type = p.type == undefined ? 'btn' : p.type;
        var a = [];
        /*var view = Ext.getCmp(inicio.id+'-menu-view');
        var record = view.getStore().getAt(p.id_menu);
        */
        /*Ext.Object.each(Ext.JSON.decode(Ext.JSON.encode(record.data.permisos)), function(index, value){
            a.push(parseInt(value.serv_id));
        });*/
        if (type == 'btn'){
            Ext.getCmp(p.id_btn).enable();
            Ext.getCmp(p.id_btn).resumeEvents();
            /*var index = a.indexOf(parseInt(p.id_serv));
            if (index >= 0){
                Ext.getCmp(p.id_btn).enable();
                Ext.getCmp(p.id_btn).resumeEvents();
            }else{
                Ext.getCmp(p.id_btn).suspendEvents();
                Ext.getCmp(p.id_btn).disable();
                if (p.fn.length > 0){
                    for(var i = 0; i < p.fn.length; ++i)
                        eval("if (" + p.fn[i] + ") delete " + p.fn[i]);
                }
            }*/
        }else if(type == 'link'){
            var html = '<div class="gk-column-icon">';
            extraCss = p.extraCss != undefined && p.extraCss != '' ? p.extraCss : '';
            Ext.Object.each(p.icons, function(index, value){
                //var index = a.indexOf(parseInt(value.id_serv));
                var index = 100;
                var clsDisabled = 'disable_link';
                
                var disable = value.disable == false || value.disable == undefined ?false:true;
                if (index >= 0 && !disable){
                    clsDisabled = '';
                    value.js = value.js != undefined && value.js != '' ? value.js : '';
                    value.anchor = value.anchor != undefined && value.anchor != '' ? value.anchor:'#';
                }else{
                    value.js = '';
                    value.qtip = '';
                    value.anchor = '#';
                }
                var style = value.style == undefined ?'':value.style;
                if (value.img != undefined && value.img != '')
                    html+='<img src="/images/icon/' + value.img + '" class="link ' + clsDisabled + ' '+extraCss+'" data-qtip="' + value.qtip + '" onclick="' + value.js + '" style="'+style+'"/>';
                else{
                    var ceroDisable = value.ceroDisable;
                    if (ceroDisable == undefined ){
                        ceroDisable = true;
                    }
                    if (ceroDisable){
                        clsDisabled = parseFloat(value.value) == 0 ? 'disable_link' : clsDisabled;
                        if (clsDisabled == 'disable_link'){
                           value.js = ''; 
                        }
                        html+='<div class="link ' + clsDisabled + ' '+extraCss+'" data-qtip="' + value.qtip + '" onclick="' + value.js + '" style="'+style+'">'+value.value+'</div>';    
                    }else{
                        //clsDisabled = '';//                   
                        html+='<div class="link ' + clsDisabled + ' '+extraCss+'" data-qtip="' + value.qtip + '" onclick="' + value.js + '" style="'+style+'">'+value.value+'</div>';    
                    }

                    
                }
            });
            html+='</div>';
            return html;
        }
    };
    this.state_item_menu = function(id_menu, bool){
        //Ext.getCmp('menu-' + id_menu).setDisabled(bool);
        //var view=Ext.getCmp(inicio.id+'-menu-view');
    };
    /**
     * PHP tiene una función sleep (), pero JavaScript no.
     * Realiza una parada en la ejecucion del JavaScript al mismo estilo de PHP.
     */
    this.sleep = function(milliseconds){
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds){
              break;
            }
        }
    };
    this.isEmptyJSON = function(obj) {
      for(var i in obj) { return false; }
      return true;
    };
    this.chek_header = function(obj){
        Ext.getCmp(obj).setautoChekedOrd();
    };
    this.chek_header2 = function(obj){
        Ext.getCmp(obj).setautoChekedOrd2();
    };

    this.formatoNumero = function(value,decimales) {
        var partes, array;
        separadorDecimal='.';
        separadorMiles=',';
        if ( !isFinite(value) || isNaN(value = parseFloat(value)) ) {
            return "";
        }
        if (typeof separadorDecimal==="undefined") {
            separadorDecimal = ".";
        }
        if (typeof separadorMiles==="undefined") {
            separadorMiles = ",";
        }
        // Redondeamos
        if ( !isNaN(parseInt(decimales)) ) {
            if (decimales >= 0) {
                value = value.toFixed(decimales);
            } else {
                value = (
                    Math.round(value / Math.pow(10, Math.abs(decimales))) * Math.pow(10, Math.abs(decimales))
                ).toFixed();
            }
        } else {
            value = value.toString();
        }
        // Damos formato
        partes = value.split(".", 2);
        array = partes[0].split("");
        for (var i=array.length-3; i>0 && array[i-1]!=="-"; i-=3) {
            array.splice(i, 0, separadorMiles);
        }
        value = array.join("");
        if (partes.length>1) {
            value += separadorDecimal + partes[1];
        }
        return value;
    };
}

var global = new LarSyrExt();
