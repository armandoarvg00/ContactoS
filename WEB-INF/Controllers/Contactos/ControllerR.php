<?php
 session_start();
 if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
     header("Location: index.php");
 }
include_once("../../Classes/catalogos.class.php");
include_once("../../Classes/Contactos.class.php");
include_once("../../Classes/Eventos.class.php");
$catalogo = new catalogos();
$Contactos = new Contactos();
$Eventos= new Eventos();
if(isset($_POST['nuevo']) && $_POST['nuevo']=="nuevo"){
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $Contactos->setNombre($parametros['Nombre']);
    $Contactos->setCorreo($parametros['Correo']);
    $Contactos->setTelefono($parametros['Telefono']);
    $Contactos->setCP($parametros['CP']);
    $Contactos->setMarca($parametros['Marca']);
    $Contactos->setAnio($parametros['Anio']);
    $Contactos->setVersion($parametros['Version']);
    $Contactos->setEdad($parametros['Edad']);
    $Contactos->setMedio($parametros['Medio']);
    $Contactos->setIdUsuario($_SESSION['idusuario']);
    if($Contactos->newContactos()){
        echo "Registro Exitoso";
    }else{
       echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['Buscar']) && $_POST['Buscar']=="Buscar"){
    $IdContactos=$_POST['IdContactos'];
    $Contactos->setIdContactos($IdContactos);
    $Contactos->getId();
    echo $IdContactos."/*".$Contactos->getNombre()."/*".$Contactos->getCorreo()."/*".$Contactos->getTelefono()."/*".$Contactos->getCP()
    ."/*".$Contactos->getMarca()."/*".$Contactos->getAnio()."/*".$Contactos->getVersion()."/*".$Contactos->getEdad()."/*".$Contactos->getMedio();
}elseif(isset($_POST['nuevo']) && $_POST['nuevo']=="Editar"){
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $IdContacto=$parametros['IdContacto'];
    $Contactos->setIdContactos($IdContacto);
    $Contactos->setNombre($parametros['Nombre']);
    $Contactos->setCorreo($parametros['Correo']);
    $Contactos->setTelefono($parametros['Telefono']);
    $Contactos->setCP($parametros['CP']);
    $Contactos->setMarca($parametros['Marca']);
    $Contactos->setAnio($parametros['Anio']);
    $Contactos->setVersion($parametros['Version']);
    $Contactos->setEdad($parametros['Edad']);
    $Contactos->setMedio($parametros['Medio']);
    if($Contactos->EditContactos()){
        echo "Edición Exitosa";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['Eliminar']) && $_POST['Eliminar']=="Eliminar"){
    $IdContacto=$_POST['IdContacto'];
    $Contactos->setIdContactos($IdContacto);
    if($Contactos->DeleteRenovaciones()){
        echo "Se Borro el Contacto de manera Exitosa";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['cambiarUser']) && $_POST['cambiarUser']=="cambiarUser"){
    $IdUser=$_POST['IdUser'];
    $IdContacto=$_POST['IdContacto'];
    $Contactos->setIdUsuario($IdUser);
    $Contactos->setIdContactos($IdContacto);
    if($Contactos->EditUserR()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['cambiarEstatus']) && $_POST['cambiarEstatus']=="cambiarEstatus"){
    $IdContacto=$_POST['IdContacto'];
    $Contactado=$_POST['Contactado'];
    $Contactos->setIdContactos($IdContacto);
    $Contactos->setContactado($Contactado);
    if($Contactos->EditContactadoR()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['cambiarGMA']) && $_POST['cambiarGMA']=="cambiarGMA"){
    $IdContacto=$_POST['IdContacto'];
    $msj=trim($_POST['msj']);
    $Contactos->setIdContactos($IdContacto);
    $Contactos->setGMA($msj);
    if($Contactos->EditGMAR()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['cambiarGMG']) && $_POST['cambiarGMG']=="cambiarGMG"){
    $IdContacto=$_POST['IdContacto'];
    $msj=trim($_POST['msj']);
    $Contactos->setIdContactos($IdContacto);
    $Contactos->setGMG($msj);
    if($Contactos->EditGMGR()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['AgregarEvento']) && $_POST['AgregarEvento']=="AgregarEvento"){
    $IdContacto=$_POST['IdContactoE'];
    $Titulo=$_POST['Titulo'];
    $Color=$_POST['Color'];
    $Fecha=$_POST['Fecha'];
    $Eventos->setIdContactos($IdContacto);
    $Eventos->setTitulo($Titulo);
    $Eventos->setColor($Color);
    $Eventos->setFecha($Fecha);
    $Eventos->setIdUsuario($_SESSION['idusuario']);
    if($Eventos->newEventos()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['FechaF']) && $_POST['FechaF']=="FechaF"){
    $FechaI=$_POST['FechaI'];
    $FechaFf=$_POST['FechaFf'];
    $_SESSION['Fechas']= "  (vigencia >= '$FechaI' and vigencia <='$FechaFf') ";
}elseif(isset($_POST['Asesores']) && $_POST['Asesores']=="Asesores"){
    $Asesor=$_POST['Asesor'];
    $_SESSION['Asesor']= "  u.id_usuario = ".$Asesor;
}
?>