
$(document).ready(function(){
   
    $('#Tperfil').DataTable(
    {
        "scrollX": true,
    	"pageLength":10,
        "language": 
        {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "order": [[ 0, "desc" ]]
        //"ordering": false

    });
    $('#pre-selected-options').multiSelect();

	let controlador = "WEB-INF/Controllers/Catalogos/ControllerPerfil.php";
	var form = "#formperfil";
    $(form).validate({
        rules: {
            Nombre: {required: true},
            Descripcion: {required: true},
            Estado: {required: true}
        },
        messages: {
            Nombre: {required: " * Ingrese un nombre por favor"},
            Descripcion: {required: " * Ingrese una Descripción por favor"},
            Estado: {required: " * Seleccione un estado por favor"}
        }
    });
    $("#GuardarP").click(function(event){
        if ($(form).valid()) {
            let nuevoPerfil=$("#accion").val();
            $.post(controlador, {form: $(form).serialize(), "nuevo":nuevoPerfil}).done(function(data) {
                alert(data)
                let id_menu= $("#id_menu").val();
                let id_submenu=$("#id_submenu").val();
                
                $('#ModalPerfil').modal('toggle');
                $('.modal-backdrop').remove()
                $(document.body).removeClass("modal-open");
                cambiarContenidos('Catalogos/lista_perfil.php',id_menu ,id_submenu);
            });    
        }else{
            //alert("VLV")
            event.preventDefault();
        } 
    });
});
function DatosEditar(IdPerfil){
   
    let controller = "WEB-INF/Controllers/Catalogos/ControllerPerfil.php";   
    $.post(controller, {"Buscar":"Buscar","IdPerfil":IdPerfil}).done(function (data) {
        //alert(data);
        //console.log(data);
        let Permisosespeciales= new Array();
        pagina = data.split('/*',5);
        $("#Nombre").val(pagina[0]);
        $("#Descripcion").val(pagina[1]);
        $("#Estado").val(pagina[2]);
        $("#IdPerfil").val(pagina[3]);
        Permisosespeciales= JSON.parse(pagina[4]);
        //la libreria sin un for no se pudo poner en producción
        for( contador=0; contador < Permisosespeciales.length; contador++ )
        {
            $('#pre-selected-options').multiSelect('select', [Permisosespeciales[contador]]);
        }
        $("#accion").val("Editar");
        $("#GuardarA").html("Editar");
        /*var div = document.getElementById("eliminarAu");
        div.style.display = "inline";*/
    });
}
function cambiaraccion(accion){
    $("#Nombre").val("");
    $('#Estado').val("");
    $('#Descripcion').val("");
    $("#IdAseguradora").val("");
    $('#pre-selected-options').multiSelect('deselect_all');
    $("#accion").val(accion);
    $("#GuardarA").html("Guardar");
}

function eliminar(IdPerfil){
    let confirmar =confirm("Eliminar Registro?");
    if (confirmar == true) {
        let controller = "WEB-INF/Controllers/Catalogos/ControllerPerfil.php";   
        $.post(controller, {"Eliminar":"Eliminar","IdPerfil":IdPerfil}).done(function (data) {
            alert(data)
            let id_menu= $("#id_menu").val();
            let id_submenu=$("#id_submenu").val();
            cambiarContenidos('Catalogos/lista_perfil.php',id_menu ,id_submenu);
        }); 
    }
}