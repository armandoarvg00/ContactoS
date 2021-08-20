
$(document).ready(function(){
  
    $('#Tpermisos').DataTable(
    {
        "scrollX": true,
    	"pageLength":25,
        "language": 
        {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "order": [[ 0, "desc" ]]
        //"ordering": false

    });
    
	let controlador = "WEB-INF/Controllers/Catalogos/ControllerPermisos.php";
	var form = "#formpermisos";
    $(form).validate({
        rules: {
            Puesto: {required: true},
            Menu: {required: true},
            Submenu: {required: true}
        },
        messages: {
            Puesto: {required: " * Ingrese un puesto por favor"},
            Menu: {required: " * Ingrese un menú por favor"},
            Submenu: {required: " * Seleccione un submenú por favor"}
        }
    });
    $("#GuardarPermisos").click(function(event){

        let nuevoPermiso=$("#accion").val();
        if ($(form).valid()) {
            
            $.post(controlador, {form: $(form).serialize(), "nuevo":nuevoPermiso}).done(function(data) {
                //alert(data)
              
                let id_menu= $("#id_menu").val();
                let id_submenu=$("#id_submenu").val();
 
                $('#ModalPerfil').modal('toggle');
                $('.modal-backdrop').remove()
                $(document.body).removeClass("modal-open");
              
                cambiarContenidoSinSesion('Catalogos/lista_permisos.php',id_menu ,id_submenu,data);
            });    
        }else{
            //alert("VLV")
            event.preventDefault();
        } 
    });
});

function cargarsub() {
    var Menu = $('#Menu').val();
    $('#Submenu').load("WEB-INF/Controllers/Catalogos/ControllerPermisos.php", {"tipoSelect": "cargar", "Menu": Menu}, function (data) {/*Refrescamos el select y volvemos a poner filtros*/
        $('#Submenu').select("refresh", true);
    });
}
function DatosEditar(IdCatPerfil, IdSubmmenu){
   
    let controller = "WEB-INF/Controllers/Catalogos/ControllerPermisos.php";   
    $.post(controller, {"Buscar":"Buscar","IdCatPerfil":IdCatPerfil,"IdSubmmenu":IdSubmmenu}).done(function (data) {
        //alert(data);
        //console.log(data);
        pagina = data.split('/*',7);
        if(pagina[0]==1){
            $("#Alta").prop("checked", true);
        }else{
            $("#Alta").prop("checked", false);
        }
        if(pagina[1]==1){
            $("#Baja").prop("checked", true);
        }else{
            $("#Baja").prop("checked", false);
        }
        if(pagina[2]==1){
            $("#Consulta").prop("checked", true);
        }else{
            $("#Consulta").prop("checked", false);
        }
        if(pagina[3]==1){
            $("#Modificacion").prop("checked", true);
        }else{
            $("#Modificacion").prop("checked", false);
        }
        $("#Permiso").val(pagina[4]);
        $('#Menu').val(pagina[5]);
        $('#Submenu').val(pagina[6]);
        $("#accion").val("Editar");
        $("#GuardarPermisos").html("Editar");
        /*var div = document.getElementById("eliminarAu");
        div.style.display = "inline";*/
    });
}
function cambiaraccion(accion){
    $("#Alta").prop("checked", false);
    $("#Baja").prop("checked", false);
    $("#Consulta").prop("checked", false);
    $("#Modificacion").prop("checked", false);
    $("#Permiso").val("");
    $('#Menu').val("");
    $('#Submenu').val("");
    $("#accion").val(accion);
    $("#GuardarPermisos").html("Guardar");
}

function eliminar(IdCatPerfil, IdSubmmenu){
    let confirmar =confirm("Eliminar Registro?");
    if (confirmar == true) {
        let controller = "WEB-INF/Controllers/Catalogos/ControllerPermisos.php";   
        $.post(controller, {"Eliminar":"Eliminar","IdCatPerfil":IdCatPerfil,"IdSubmmenu":IdSubmmenu}).done(function (data) {
            alert(data)
            let id_menu= $("#id_menu").val();
            let id_submenu=$("#id_submenu").val();
            cambiarContenidos('Catalogos/lista_permisos.php',id_menu ,id_submenu);
        }); 
    }
}
function perfil(idperfil){
    
    let controller = "WEB-INF/Controllers/Catalogos/ControllerPermisos.php";   
    $.post(controller, {"perfil":"perfil","idperfil":idperfil}).done(function (data) {
        $( "#datostabla" ).load( "Catalogos/lista_permisos.php" );

    }); 
}