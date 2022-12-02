(function($){
    "use strict";

    var App = function () {
        var o = this; // Create reference to this instance
        $(document).ready(function () {
            o.initialize();
        }); // Initialize app when document is ready

    };
    var p = App.prototype;

    p.initialize = function () { };


    p.loadData = function(Options){

        var Settings = {
            url: location.href,
            type: "POST",
            data:{},
            target: document.getElementsByTagName("BODY")[0],
            area: document.getElementsByTagName("BODY")[0]
        };
        
        Options = Options || {};

        $.extend( Settings, Options );

        materialadmin.AppCard.addCardLoader(Settings.area);
        $(Settings.target).load(Settings.url,Settings.data,function(response, status, xhr){

            if ( status == "error" )  console.log(xhr.status + " " + xhr.statusText );

            materialadmin.AppCard.removeCardLoader(Settings.area);
        });
    }

    p.popup = function(Options){
        
        var Settings = {
            url: location.href,
            type: "POST",
            data:{},
            modal:$('#popupcx'),
            target: $('#bodycx'),
            popup_type: 1,
            mode:'',
            title:'Popup window',
            area: document.getElementsByTagName("BODY")[0],
        };
        
        Options = Options || {};

        $.extend( Settings, Options );
       
        if(Settings.popup_type==2 && Settings.modal.attr('id')=='popupcx'){
            Settings.modal = $('#popupcx2');
            Settings.target = $('#bodycx2');
        }

        Settings.modal.find('.modal-title').text(Settings.title);

        if(Settings.mode=='md' && (Settings.modal.attr('id')=='popupcx' || Settings.modal.attr('id')=='popupcx2'))
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md').addClass('modal-md');
        else if(Settings.mode=='lg' && (Settings.modal.attr('id')=='popupcx' || Settings.modal.attr('id')=='popupcx2'))
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md').addClass('modal-lg');
        else if(Settings.popup_type==2  && Settings.modal.attr('id')=='popupcx2')
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md').addClass('modal-lg');
        else if(Settings.popup_type==2  && Settings.modal.attr('id')=='popupcx')
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md');

        materialadmin.AppCard.addCardLoader(Settings.area);
        $(Settings.target).load(Settings.url,Settings.data,function(response, status, xhr){

            if ( status == "error" )  console.log(xhr.status + " " + xhr.statusText );

            $(Settings.modal).modal({show:true});

            materialadmin.AppCard.removeCardLoader(Settings.area);
        });
    }

    window.atmedic = window.atmedic || {};
    window.atmedic.App = new App;

}(jQuery));

(function(){

    $(window).load(function() {
        setTimeout(function() {
            $("body").addClass("loaded")
        }, 200)
    });

    if(typeof(Waves) !== 'undefined'){
        Waves.attach('.btn:not(.btn-icon):not(.btn-float)');
        Waves.attach('.btn-icon, .btn-float', ['waves-circle', 'waves-float']);
        Waves.init();
    }
})();