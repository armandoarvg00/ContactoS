$(document).ready(function(){
    $('#TContactos').DataTable(
    {
        "scrollX": true,
    	"pageLength":5,
        "language": 
        {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "order": [[ 0, "desc" ]]
        //"ordering": false
    });
    let controlador = "WEB-INF/Controllers/Contactos/ControllerR.php";
	var form = "#formContactos";
    $(form).validate({
        rules: {
            Nombre: {required: true},
            Correo: {required: true, email: true},
            Telefono: {required: true, number: true},
            CP: {required: true, number: true},
            Marca: {required: true},
            Anio: {required: true, number: true},
            Version: {required: true},
            Edad: {required: true, number: true},
            Medio: {required: true}
        },
        messages: {
            Nombre: {required: " * Ingrese un Nombre por favor"},
            Correo: {required: " * Seleccione un Correo por favor",email: "Usa un formato de correo Valído" },
            Telefono: {required: " * Ingrese un Telefono por favor",number: "* Ingresa solo numeros"},
            CP: {required: " * Ingrese un CP por favor",number: "* Ingresa solo numeros"},
            Marca: {required: " * Ingrese un Marca por favor"},
            Anio: {required: " * Ingrese un Anio por favor",number: "* Ingresa solo numeros"},
            Version: {required: " * Ingrese un Version por favor"},
            Edad: {required: " * Ingrese un Edad por favor",number: "* Ingresa solo numeros"},
            Medio: {required: " * Selecciona un Medio por favor"}

        }
    });
    $("#GuardarA").click(function(event){
        if ($(form).valid()) {
            let nuevoc=$("#accion").val();
            $.post(controlador, {form: $(form).serialize(), "nuevo":nuevoc}).done(function(data) {
                alert(data)
                let id_menu= $("#id_menu").val();
                let id_submenu=$("#id_submenu").val();
                $('#formcvn').modal('toggle');
                $('.modal-backdrop').remove()
                $(document.body).removeClass("modal-open");
              
                cambiarContenidos('Contactos/lista_renovaciones.php',id_menu ,id_submenu);
            });    
        }else{
            event.preventDefault();
        } 
    });
});
function DatosEditar(IdContactos){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
    $.post(controller, {"Buscar":"Buscar","IdContactos":IdContactos}).done(function (data) {
        //alert(data);
        console.log(data);
        pagina = data.split('/*',10);
        $("#IdContacto").val(pagina[0]);
        $("#Nombre").val(pagina[1]);
        $("#Correo").val(pagina[2]);
        $("#Telefono").val(pagina[3]);
        $("#CP").val(pagina[4]);
        $("#Marca").val(pagina[5]);
        $("#Anio").val(pagina[6]);
        $("#Version").val(pagina[7]);
        $("#Edad").val(pagina[8]);
        if(pagina[9]=="Chat"){
            $("#Chat").prop("checked", true);
        }else{
            $("#Chat").prop("checked", false);
        }
        if(pagina[9]=="Correo"){
            $("#CCorreo").prop("checked", true);
        }else{
            $("#CCorreo").prop("checked", false);
        }
        if(pagina[9]=="Impreso"){
            $("#Impreso").prop("checked", true);
        }else{
            $("#Impreso").prop("checked", false);
        }
        if(pagina[9]=="Messenger"){
            $("#Messenger").prop("checked", true);
        }else{
            $("#Messenger").prop("checked", false);
        }
        if(pagina[9]=="Llamada"){
            $("#Llamada").prop("checked", true);
        }else{
            $("#Llamada").prop("checked", false);
        }
        if(pagina[9]=="Referido"){
            $("#Referido").prop("checked", true);
        }else{
            $("#Referido").prop("checked", false);
        }
        $("#accion").val("Editar");
        $("#GuardarA").html("Editar");
    });
}
function cambiaraccion(accion){
    $("#IdContacto").val("");
    $("#Nombre").val("");
    $("#Correo").val("");
    $("#Telefono").val("");
    $("#CP").val("");
    $("#Marca").val("");
    $("#Anio").val("");
    $("#Version").val("");
    $("#Edad").val("");
    $("#Chat").prop("checked", false);
    $("#CCorreo").prop("checked", false);
    $("#Impreso").prop("checked", false);
    $("#Messenger").prop("checked", false);
    $("#Llamada").prop("checked", false);
    $("#Referido").prop("checked", false);
    $("#accion").val(accion);
    $("#GuardarA").html("Guardar");
}
function eliminar(IdContacto){
    let confirmar =confirm("Eliminar Registro?");
    if (confirmar == true) {
        let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
        $.post(controller, {"Eliminar":"Eliminar","IdContacto":IdContacto}).done(function (data) {
            alert(data)
            let id_menu= $("#id_menu").val();
            let id_submenu=$("#id_submenu").val();
            cambiarContenidos('Contactos/lista_renovaciones.php',id_menu ,id_submenu);
        }); 
    }
}
function cambiarUser(IdContacto,IdUser){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
    $.post(controller, {"cambiarUser":"cambiarUser","IdContacto":IdContacto,"IdUser":IdUser}).done(function (data) {
        alert(data)
    }); 
}
function CambiarEmitir(IdContacto,Contactado){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
    $.post(controller, {"cambiarEstatus":"cambiarEstatus","IdContacto":IdContacto,"Contactado":Contactado}).done(function (data) {
        //alert(data)
    }); 
}
function GMA(IdContacto,msj){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
    $.post(controller, {"cambiarGMA":"cambiarGMA","IdContacto":IdContacto,"msj":msj}).done(function (data) {
       // alert(data)
    }); 
}
function GMG(IdContacto,msj){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
    $.post(controller, {"cambiarGMG":"cambiarGMG","IdContacto":IdContacto,"msj":msj}).done(function (data) {
       // alert(data)
    }); 
}
function SetIdcontacto(IdContacto){
    $("#IdContactoE").val(IdContacto);
}
function AgregarEvento(){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";  
    let IdContactoE= $("#IdContactoE").val();
    let Titulo= $("#Titulo").val();
    let Color= $("#Color").val();
    let Fecha= $("#Fecha").val();
    $.post(controller, {"AgregarEvento":"AgregarEvento","IdContactoE":IdContactoE,"Titulo":Titulo,"Color":Color,"Fecha":Fecha}).done(function (data) {
        alert(data);  
        $('#formcvn').modal('toggle');
        $('.modal-backdrop').remove()
        $(document.body).removeClass("modal-open");
        let id_menu= $("#id_menu").val();
        let id_submenu=$("#id_submenu").val();
        cambiarContenidos('Contactos/lista_renovaciones.php',id_menu ,id_submenu);
    }); 
}
function FechaF(FechaFf){
    let FechaIn= $('#FechaI').val();
    if(FechaIn!=""){
        let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
        $.post(controller, {"FechaF":"FechaF","FechaI":FechaIn,"FechaFf":FechaFf}).done(function (data) {
            
            $( "#datostabla" ).load( "Contactos/lista_renovaciones.php" );
        }); 
    }else{
        alert("ingresa una fecha inicial por Favor");
    }
}
function asesores(Asesor){
    let controller = "WEB-INF/Controllers/Contactos/ControllerR.php";   
    $.post(controller, {"Asesores":"Asesores","Asesor":Asesor}).done(function (data) {
        $( "#datostabla" ).load( "Contactos/lista_renovaciones.php" );

    }); 
}