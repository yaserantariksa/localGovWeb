$(document).ready(function () {
    
	var topLayout;    
    topLayout = $('body').layout({
		center__maskContents: true,
        north__size         : 50,
        south__size         : 0,
        spacing_open        : 0,
        spacing_closed      : 0,
        north__showOverflowOnHover : true,
        center__onresize: "innerLayout.resizeAll"
	});
    
    innerLayout = $('div.centercx').layout({ 
		center: {
            paneSelector: ".contentcx"
		}
	});

    $('.link-module').on('click',function(){
        $('#submodule-app').css('left',0);
        $('#title-module').html($(this).data('title-module'));
        $('#icon-module').removeClass().addClass($(this).data('icon-module'));
        let link = $(this).data('link');
        $.post(base_url()+'main/get_submodule',{'mmid':link},function(data){
            $('#submodule').html(data);
        });
    });

    $('#header-back').on('click',function(e){
        e.preventDefault();
        $('#submodule-app').css('left','-610px');
    });
  
    $("#logoutcx").click(function() {
        window.location.replace('login/do_logout');
    });
    
    $("#pass").click(function() {
        popupwindow('mst_users/change_password','change_password',550,350);
    });

    $("#submodule").on("click", ".link-submenu", function(e) {
        e.preventDefault();
        document.getElementById('contentcx').src = base_url()+$(this).data('link');
        $('.main-sidebar').sideNav('hide');
    });
});

function getContent(link)
{
    document.getElementById('contentcx').src = link;
}

function popupwindow(url, title, w, h,is_fullscreen) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  
  if(is_fullscreen=='yes'){
    
    w=window.parent.screen.width - 15;
    
    h=window.parent.screen.height - 60;
  }
  
  var newwindow = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  
  if (window.focus) {newwindow.focus()}
  return newwindow;
}

