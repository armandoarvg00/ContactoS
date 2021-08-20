$(document).ready(function(){
    $('#TVentas').DataTable(
    {
        "scrollX": true,
    	"pageLength":10,
        "language": 
        {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "order": [[ 8, "asc" ]]
        //"ordering": false
    });
    let controlador = "WEB-INF/Controllers/Nominas/ControllerV.php";
	var form = "#formReexpedicion";
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
            Marca: {required: " * Ingrese una Marca por favor"},
            Anio: {required: " * Ingrese un año por favor",number: "* Ingresa solo numeros"},
            Version: {required: " * Ingrese una Version por favor"},
            Edad: {required: " * Ingrese una Edad por favor",number: "* Ingresa solo numeros"},
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
              
                cambiarContenidos('Nominas/lista_nominas.php',id_menu ,id_submenu);
            });    
        }else{
            event.preventDefault();
        } 
    });
});
function DatosEditar(IdContactos){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"Buscar":"Buscar","IdContactos":IdContactos}).done(function (data) {
        //alert(data);
        console.log(data);
        pagina = data.split('/*',13);
        $("#IdVentas").val(pagina[0]);
        $("#NoPoliza").val(pagina[1]);
        $("#Serie").val(pagina[2]);
        $("#Nombre").val(pagina[3]);
        $("#Correo").val(pagina[4]);
        $("#Telefono").val(pagina[5]);
        $("#Registro").val(pagina[6]);
        $("#Vigencia").val(pagina[7]);
        $("#Proximo").val(pagina[8]);
        $("#Fechapago").val(pagina[9]);
        $("#Aseguradora").val(pagina[10]);
        $("#Fpago").val(pagina[11]);
        $("#Pneta").val(pagina[12]);
        $("#accion").val("Editar");
        $("#GuardarA").html("Editar");
    });
}
var IdContacto="";
function GenerarP(IdContacto, accion){
    $("#IdContacto").val(IdContacto);
    $("#accion").val(accion);
    $("#GuardarA").html("Guardar");
}
function cambiaraccion(accion){
    $("#IdVentas").val('');
    $("#NoPoliza").val('');
    $("#Serie").val('');
    $("#Nombre").val('');
    $("#Correo").val('');
    $("#Telefono").val('');
    $("#Registro").val('');
    $("#Vigencia").val('');
    $("#Proximo").val('');
    $("#Fechapago").val('');
    $("#Aseguradora").val('');
    $("#Fpago").val('');
    $("#Pneta").val('');
    $("#accion").val(accion);
    $("#GuardarA").html("Guardar");
}
function eliminar(IdContacto){
    let confirmar =confirm("Eliminar Registro?");
    if (confirmar == true) {
        let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
        $.post(controller, {"Eliminar":"Eliminar","IdContacto":IdContacto}).done(function (data) {
            alert(data)
            let id_menu= $("#id_menu").val();
            let id_submenu=$("#id_submenu").val();
            cambiarContenidos('Nominas/lista_nominas.php',id_menu ,id_submenu);
        }); 
    }
}
function cambiarUser(IdVentas,IdUser){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"cambiarUser":"cambiarUser","IdVentas":IdVentas,"IdUser":IdUser}).done(function (data) {
        alert(data)
    }); 
}
function TipoNegocio(Negocio){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"TipoNegocio":"TipoNegocio","Negocio":Negocio}).done(function (data) {
        $('#tiponegocio').html(data);
   
    }); 
}
function Perfiles(Perfil){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"Perfiles":"Perfiles","Perfil":Perfil}).done(function (data) {
        $('#asesores').html(data);
        $( "#datostabla" ).load( "Nominas/lista_nominas.php" );
    }); 
}
function asesores(Asesor){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"Asesores":"Asesores","Asesor":Asesor}).done(function (data) {
        $( "#datostabla" ).load( "Nominas/lista_nominas.php" );

    }); 
}
function FechaF(FechaFf){
    //alert("si paso ");
    let FechaI= $('#FechaI').val();
    if(FechaI!=""){
        let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
        $.post(controller, {"FechaF":"FechaF","FechaI":FechaI,"FechaFf":FechaFf}).done(function (data) {
            $( "#datostabla" ).load( "Nominas/lista_nominas.php" );
        }); 
    }else{
        alert("ingresa una fecha inicial por Favor");
    }
}
function AsignarFeP(IdVentas,Fecha){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"AsignarFeP":"AsignarFeP","IdVentas":IdVentas,"Fecha":Fecha}).done(function (data) {
        cambiarContenidos('Nominas/lista_nominas.php',id_menu ,id_submenu);
    }); 
}
function ComentarioC(IdVentas,msj){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";   
    $.post(controller, {"ComentarioC":"ComentarioC","IdVentas":IdVentas,"msj":msj}).done(function (data) {
        alert(data)
       // cambiarContenidos('Contactos/lista_cobranza.php',id_menu ,id_submenu);
    }); 
}
function SetIdcontacto(IdContacto){
    $("#IdContactoE").val(IdContacto);
}
function AgregarEvento(){
    let controller = "WEB-INF/Controllers/Nominas/ControllerV.php";  
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
        cambiarContenidos('Nominas/lista_nominas.php',id_menu ,id_submenu);
    }); 
}