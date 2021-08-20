
$(document).ready(function(){
  
    $('#TAseguradoras').DataTable(
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
  

	let controlador = "WEB-INF/Controllers/Catalogos/ControllerAseguradoras.php";
	var form = "#formAseguradoras";
    $(form).validate({
        rules: {
            Nombre: {required: true},
         
            Estado: {required: true}
        },
        messages: {
            Nombre: {required: " * Ingrese un Nombre por favor"},
            Estado: {required: " * Seleccione un Estado por favor"}
        }
    });
    $("#GuardarA").click(function(event){
        if ($(form).valid()) {
            let nuevaAseguradora=$("#accion").val();
            $.post(controlador, {form: $(form).serialize(), "nuevo":nuevaAseguradora}).done(function(data) {
                alert(data)
                let id_menu= $("#id_menu").val();
                let id_submenu=$("#id_submenu").val();
                $('#ModalAseguradoras').modal('toggle');
                $('.modal-backdrop').remove()
                $(document.body).removeClass("modal-open");
              
                cambiarContenidos('Catalogos/lista_aseguradoras.php',id_menu ,id_submenu);
            });    
        }else{
            //alert("VLV")
            event.preventDefault();
        } 
    });
});


function DatosEditar(IdAseguradora){
   
    let controller = "WEB-INF/Controllers/Catalogos/ControllerAseguradoras.php";   
    $.post(controller, {"Buscar":"Buscar","IdAseguradora":IdAseguradora}).done(function (data) {
        //alert(data);
        //console.log(data);
        pagina = data.split('/*',3);
        $("#Nombre").val(pagina[0]);
        $("#Estado").val(pagina[1]);
        $("#IdAseguradora").val(pagina[2]);
        $("#accion").val("Editar");
        $("#GuardarA").html("Editar");
        /*var div = document.getElementById("eliminarAu");
        div.style.display = "inline";*/
    });
}
function cambiaraccion(accion){
    $("#Nombre").val("");
    $('#Estado').val("");
    $("#IdAseguradora").val("");
    $("#accion").val(accion);
    $("#GuardarA").html("Guardar");
}

function eliminar(IdAseguradora){
    let confirmar =confirm("Eliminar Registro?");
    if (confirmar == true) {
        let controller = "WEB-INF/Controllers/Catalogos/ControllerAseguradoras.php";   
        $.post(controller, {"Eliminar":"Eliminar","IdAseguradora":IdAseguradora}).done(function (data) {
            alert(data)
            let id_menu= $("#id_menu").val();
            let id_submenu=$("#id_submenu").val();

            cambiarContenidos('Catalogos/lista_aseguradoras.php',id_menu ,id_submenu);
        }); 
    }
}