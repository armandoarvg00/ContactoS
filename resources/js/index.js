$(document).ready(function() {

} );
function cambiarContenidos(pagina, idmenu, idsubmenu, funcion) {
    $("#contenidos").empty();
    limpiarMensaje();

    $("#contenidos").load(pagina,{ "datos": "borrar"}, function (response, status, xhr) {
        
        if (status == "error") {
        /*var msg = "Lo sentimos, se ha presentado el error 101 del sistema, nuestros ingenieros están actualmente trabajando en el desarrollo de éste módulo: ";
         $("#mensajes").html(msg + xhr.status + " " + xhr.statusText);*/
        }else {
            $('html,body').scrollTop(0);
            $(".espacio_foot").css("max-heigth", "0.3em");                    
        }
        $("#id_menu").val(idmenu);
        $("#id_submenu").val(idsubmenu);
    }).css("margin-left", "0%").css("margin-right", "0%");
}
function cambiarContenidoSinSesion(pagina, idmenu, idsubmenu,data, funcion) {
    $("#contenidos").empty();
    limpiarMensaje();

    $("#contenidos").load(pagina, function (response, status, xhr) {
        
        if (status == "error") {
        /*var msg = "Lo sentimos, se ha presentado el error 101 del sistema, nuestros ingenieros están actualmente trabajando en el desarrollo de éste módulo: ";
         $("#mensajes").html(msg + xhr.status + " " + xhr.statusText);*/
        }else {
           // alert(data);
           console.log(data);
            $('html,body').scrollTop(0);
            $(".espacio_foot").css("max-heigth", "0.3em");                    
        }
        
        $("#id_menu").val(idmenu);
        $("#id_submenu").val(idsubmenu);
    }).css("margin-left", "0%").css("margin-right", "0%");
}
var Ruta;
function Manual(NombreM){
    
    Ruta="Manuales/"+NombreM;
 }
 function imprimirmanual(){
   
    window.open(Ruta, '_blank');
}
function limpiarMensaje() {
    $('#mensajes').empty();
}
function filtros(){
    
    let estatus =$('#filtro_vista').val();
    $('#filtros').css("display", estatus);
    if(estatus=="block"){
        $('#filtro_vista').val('none');
    }else{
        $('#filtro_vista').val('block');
    }
}
