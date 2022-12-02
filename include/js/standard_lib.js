function popupwindow(url, title, w, h,is_fullscreen) {
    
  if(is_fullscreen=='yes'){
    
    w=window.parent.screen.width - 15;
    
    h=window.parent.screen.height - 60;
  }
  var left = (screen.width/2)-(w/2),
      top = (screen.height/2)-(h/2),
      newwindow = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  
  if (window.focus) {newwindow.focus()}
  return newwindow;
}

function popup_detail_jurnal(url,glid){
    
    popupwindow(url+'/'+glid,'',1300,600,'yes');
    
}

var decimalSeparator = Number("1.2").toLocaleString().substr(1,1);

function format_money(data){
    
    if(data=='-' || data=='0,' || data =='-0' || data =='-0,') return data;
    
    data = (typeof(data)=='number')?data.toString():data;
    data = data.replace(/\./g, '');
    data = data.replace(/\,/g, '.');
    data = parseFloat(data ? data : 0);
    
    data = data.toLocaleString();
    
    if(decimalSeparator =='.'){
        data = data.replace(/\./g,'#');
        data = data.replace(/\,/g,'.');
        data = data.replace(/\#/g,',');    
    }
    
    return data;
}
    
function reset_format_money(data){
    data = data.replace(/\./g, '');
    return data.replace(/\,/g, '.');
}

function cxround(nominal, decimal){
    
    decimal = (typeof(decimal)=='undefined')?4:decimal;
    decimal = Math.pow(10,decimal);
    decimal = parseInt(decimal);
    return Math.round(nominal * decimal) / decimal;
}

function cek_angka(e){
        
    var ank=e.charCode? e.charCode : e.keyCode;
    
    if ((ank!=8) && (ank!=46) && (!(ank>=37)||!(ank<=40))){        
        if (ank<48||ank>57){
            return false;
        }
    }
}
  
/*! Idle Timer v1.0.1 2014-03-21 | https://github.com/thorst/jquery-idletimer | (c) 2014 Paul Irish | Licensed MIT */
!function(a){a.idleTimer=function(b,c){var d;"object"==typeof b?(d=b,b=null):"number"==typeof b&&(d={timeout:b},b=null),c=c||document,d=a.extend({idle:!1,timeout:3e4,events:"mousemove keydown wheel DOMMouseScroll mousewheel mousedown touchstart touchmove MSPointerDown MSPointerMove"},d);var e=a(c),f=e.data("idleTimerObj")||{},g=function(b){var d=a.data(c,"idleTimerObj")||{};d.idle=!d.idle,d.olddate=+new Date;var e=a.Event((d.idle?"idle":"active")+".idleTimer");a(c).trigger(e,[c,a.extend({},d),b])},h=function(b){var d=a.data(c,"idleTimerObj")||{};if(null==d.remaining){if("mousemove"===b.type){if(b.pageX===d.pageX&&b.pageY===d.pageY)return;if("undefined"==typeof b.pageX&&"undefined"==typeof b.pageY)return;var e=+new Date-d.olddate;if(200>e)return}clearTimeout(d.tId),d.idle&&g(b),d.lastActive=+new Date,d.pageX=b.pageX,d.pageY=b.pageY,d.tId=setTimeout(g,d.timeout)}},i=function(){var b=a.data(c,"idleTimerObj")||{};b.idle=b.idleBackup,b.olddate=+new Date,b.lastActive=b.olddate,b.remaining=null,clearTimeout(b.tId),b.idle||(b.tId=setTimeout(g,b.timeout))},j=function(){var b=a.data(c,"idleTimerObj")||{};null==b.remaining&&(b.remaining=b.timeout-(+new Date-b.olddate),clearTimeout(b.tId))},k=function(){var b=a.data(c,"idleTimerObj")||{};null!=b.remaining&&(b.idle||(b.tId=setTimeout(g,b.remaining)),b.remaining=null)},l=function(){var b=a.data(c,"idleTimerObj")||{};clearTimeout(b.tId),e.removeData("idleTimerObj"),e.off("._idleTimer")},m=function(){var b=a.data(c,"idleTimerObj")||{};if(b.idle)return 0;if(null!=b.remaining)return b.remaining;var d=b.timeout-(+new Date-b.lastActive);return 0>d&&(d=0),d};if(null===b&&"undefined"!=typeof f.idle)return i(),e;if(null===b);else{if(null!==b&&"undefined"==typeof f.idle)return!1;if("destroy"===b)return l(),e;if("pause"===b)return j(),e;if("resume"===b)return k(),e;if("reset"===b)return i(),e;if("getRemainingTime"===b)return m();if("getElapsedTime"===b)return+new Date-f.olddate;if("getLastActiveTime"===b)return f.lastActive;if("isIdle"===b)return f.idle}return e.on(a.trim((d.events+" ").split(" ").join("._idleTimer ")),function(a){h(a)}),f=a.extend({},{olddate:+new Date,lastActive:+new Date,idle:d.idle,idleBackup:d.idle,timeout:d.timeout,remaining:null,tId:null,pageX:null,pageY:null}),f.idle||(f.tId=setTimeout(g,f.timeout)),a.data(c,"idleTimerObj",f),e},a.fn.idleTimer=function(b){return this[0]?a.idleTimer(b,this[0]):this}}(jQuery);

(function(c,d){"object"===typeof exports?d(exports):"function"===typeof define&&define.amd?define(["exports"],d):d(c)})(this,function(c){c.Nanobar=function(){var d,c,e,f,g,h,k={width:"100%",height:"2px",zIndex:9999,top:"0"},l={width:0,height:"100%",clear:"both",transition:"height .3s"};d=function(a,b){for(var c in b)a.style[c]=b[c];a.style["float"]="left"};f=function(){var a=this,b=this.width-this.here;.1>b&&-.1<b?(g.call(this,this.here),this.moving=!1,100==this.width&&(this.el.style.height=0,setTimeout(function(){a.cont.el.removeChild(a.el)},
300))):(g.call(this,this.width-b/4),setTimeout(function(){a.go()},16))};g=function(a){this.width=a;this.el.style.width=this.width+"%"};h=function(){var a=new c(this);this.bars.unshift(a)};c=function(a){this.el=document.createElement("div");this.el.style.backgroundColor=a.opts.bg;this.here=this.width=0;this.moving=!1;this.cont=a;d(this.el,l);a.el.appendChild(this.el)};c.prototype.go=function(a){a?(this.here=a,this.moving||(this.moving=!0,f.call(this))):this.moving&&f.call(this)};e=function(a){a=this.opts=
a||{};var b;a.bg=a.bg||"#7B1FA2";this.bars=[];b=this.el=document.createElement("div");d(this.el,k);a.id&&(b.id=a.id);b.style.position=a.target?"relative":"fixed";a.target?a.target.insertBefore(b,a.target.firstChild):document.getElementsByTagName("body")[0].appendChild(b);h.call(this)};e.prototype.go=function(a){this.bars[0].go(a);100==a&&h.call(this)};return e}();return c.Nanobar});

$(document).ready(function(){
   
   $('#cxnextpage').on('click',function(){
        
        $page = isNaN(parseInt($(this).attr('data-page')))?1:(parseInt($(this).attr('data-page'))+1);
        
        $myform = ($(this).attr('data-form') === '')?$("form:first"):$('#'+$(this).attr('data-form'));
        
        $('<input />',{
            name: 'page',
            id: 'page',
            type: 'hidden',
            value: $page
        }).appendTo($myform);
        
        $myform.submit();
   }); 
   
   $('#cxprevpage').on('click',function(){
        
        $page = isNaN(parseInt($(this).attr('data-page')))?1:(parseInt($(this).attr('data-page'))-1);
        
        $myform = ($(this).attr('data-form') === '')?$("form:first"):$('#'+$(this).attr('data-form'));
        
        $('<input />',{
            name: 'page',
            id: 'page',
            type: 'hidden',
            value: $page
        }).appendTo($myform);
        
        $myform.submit();
   });
   
   $("#cxpage").on('keydown',function (event) {
      var key = event.charCode ? event.charCode : event.keyCode ? event.keyCode : 0;
      if (key == 13) {
        
          $myform = ($(this).attr('data-form') === '')?$("form:first"):$(this).attr('data-form');
    
          $('<input />',{
                name: 'page',
                id: 'page',
                type: 'hidden',
                value: (this.value - 1)
            }).appendTo($myform);
            
            $myform.submit();
      }
    
      if ((key!=8) && (key!=46) && (!(key>=37)||!(key<=40))){        
          if (key<48||key>57){
              return false;
          }
      }
   });
  
   $( document ).idleTimer( {timeout:100000,idle:true });
    
   $(document).on("active.idleTimer", function (event, elem, obj) {
      
      $.post(base_url()+'login/check_seesion',function(data){
        
        if(data=='session_expired') window.location.replace(base_url()+'login/do_logout');
      });
       
   });

   var nanobar = new Nanobar(); nanobar.go(100);
   
});
