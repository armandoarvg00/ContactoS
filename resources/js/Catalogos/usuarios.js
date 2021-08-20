
$(document).ready(function(){
  
    $('#Tusuarios').DataTable(
    {
        "scrollX": true,
    	"pageLength":15,
        "language": 
        {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "order": [[ 0, "desc" ]]
        //"ordering": false

    });
  
    $('#pre-selected-options').multiSelect();
    
	let controlador = "WEB-INF/Controllers/Catalogos/ControllerUsuarios.php";
	var form = "#formusuarios";
    $(form).validate({
        rules: {
            Nombre: {required: true},
            Apellido: {required: true},
            Correo: {required: true},
            Contrasena: {required: true},
            Usuario: {required: true},
            Perfil: {required: true},
            Estado: {required: true}
        },
        messages: {
            Nombre: {required: " * Ingrese un Nombre por favor"},
            Apellido: {required: " * Ingrese un Apellido por favor"},
            Correo: {required: " * Ingrese un Correo por favor"},
            Contrasena: {required: " * Ingrese un Contraseña por favor"},
            Usuario: {required: " * Ingrese un Usuario por favor"},
            Perfil: {required: " * Ingrese un Perfil por favor"},
            Estado: {required: " * Seleccione un Estado por favor"}
        }
    });
    $("#GuardarU").click(function(event){
        if ($(form).valid()) {
            let nuevoUsuario=$("#accion").val();
            $.post(controlador, {form: $(form).serialize(), "nuevo":nuevoUsuario}).done(function(data) {
              /*  alert(data)
                console.log(data)*/
                let id_menu= $("#id_menu").val();
                let id_submenu=$("#id_submenu").val();
                
                /*$('#ModalPerfil').modal('hide');
                $('#ModalPerfil').modal('toggle');
                $('#ModalPerfil').modal('handleUpdate');*/
                $('#ModalPerfil').modal('toggle');
                $('.modal-backdrop').remove()
                $(document.body).removeClass("modal-open");
                cambiarContenidoSinSesion('Catalogos/lista_usuarios.php',id_menu ,id_submenu,data);
            });    
        }else{
            //alert("VLV")
            event.preventDefault();
        } 
    });
});

function DatosEditar(IdUsuario){
   
    let controller = "WEB-INF/Controllers/Catalogos/ControllerUsuarios.php";   
    let aseguradorasdatos= new Array();
    $.post(controller, {"Buscar":"Buscar","IdUsuario":IdUsuario}).done(function (data) {
        //alert(data);
        pagina = data.split('/*',9);
        $("#Nombre").val(pagina[0]);
        $("#Apellido").val(pagina[1]);
        $("#Correo").val(pagina[2]);
        $("#Contrasena").val(pagina[3]);
        $("#Username").val(pagina[4]);
        $("#Username").attr('readonly', true);
        $("#Perfil").val(pagina[5]);
        $("#Estado").val(pagina[6]);
        $("#IdUsuario").val(pagina[7]);
        aseguradorasdatos= JSON.parse(pagina[8]);
        //la libreria sin un for no se pudo poner en producción
        for( contador=0; contador < aseguradorasdatos.length; contador++ )
        {
            $('#pre-selected-options').multiSelect('select', [aseguradorasdatos[contador]]);
        }
        $("#accion").val("Editar");
        $("#GuardarA").html("Editar");
        /*var div = document.getElementById("eliminarAu");
        div.style.display = "inline";*/
    });
}
function cambiaraccion(accion){
    $("#Nombre").val("");
    $('#Apellido').val("");
    $('#Correo').val("");
    $('#Contrasena').val("");
    $('#Username').val("");
    $('#Perfil').val("");
    $('#Estado').val("");
    $("#Username").attr('readonly', false);
    $("#IdUsuario").val("");
    $('#pre-selected-options').multiSelect('deselect_all');
    $("#accion").val(accion);
    $("#GuardarA").html("Guardar");
}

function eliminar(IdUsuario){
    let confirmar =confirm("Eliminar Registro?");
    if (confirmar == true) {
        let controller = "WEB-INF/Controllers/Catalogos/ControllerUsuarios.php";   
        $.post(controller, {"Eliminar":"Eliminar","IdUsuario":IdUsuario}).done(function (data) {
            alert(data)
            let id_menu= $("#id_menu").val();
            let id_submenu=$("#id_submenu").val();
            cambiarContenidos('Catalogos/lista_usuarios.php',id_menu ,id_submenu);
        }); 
    }
}
function perfil(idperfil){
    
    let controller = "WEB-INF/Controllers/Catalogos/ControllerUsuarios.php";   
    $.post(controller, {"perfil":"perfil","idperfil":idperfil}).done(function (data) {
        $( "#datostabla" ).load( "Catalogos/lista_usuarios.php" );

    }); 
}