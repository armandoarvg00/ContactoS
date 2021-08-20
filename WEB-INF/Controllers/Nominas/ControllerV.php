<?php
 session_start();
 if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
     header("Location: index.php");
 }
include_once("../../Classes/catalogos.class.php");
include_once("../../Classes/Contactos.class.php");
include_once("../../Classes/Eventos.class.php");
include_once("../../Classes/Ventas.class.php");

$catalogos = new catalogos();
$Contactos = new Contactos();
$Eventos= new Eventos();
$Ventas= new Ventas();
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
    $IdVentas=$_POST['IdContactos'];
    $Ventas->setIdVentas($IdVentas);
    $Ventas->getId();
    echo $IdVentas."/*".$Ventas->getNoPoliza()."/*".$Ventas->getSerie()."/*".$Ventas->getNombre()."/*".$Ventas->getCorreo()
    ."/*".$Ventas->getTelefono()."/*".$Ventas->getRegistro()."/*".$Ventas->getVigencia()."/*".$Ventas->getProxPago()
    ."/*".$Ventas->getFechaPago()."/*".$Ventas->getAseguradora()."/*".$Ventas->getFormaPago()."/*".$Ventas->getPrimaNeta();
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
    $IdVentas=$_POST['IdVentas'];
    $Ventas->setIdVentas($IdVentas);
    $Ventas->setIdUsuario($IdUser);
    if($Ventas->EditUserR()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['AsignarFeP']) && $_POST['AsignarFeP']=="AsignarFeP"){
    $IdVentas=$_POST['IdVentas'];
    $Fecha=$_POST['Fecha'];
    $Ventas->setIdVentas($IdVentas);
    $Ventas->setFechaPago($Fecha);
    $Ventas->setIdUsuario($_SESSION['idusuario']);
    if($Ventas->EditFechaPago()){
        echo "Fecha asignada con exito";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['ComentarioC']) && $_POST['ComentarioC']=="ComentarioC"){
    $IdVentas=$_POST['IdVentas'];
    $msj=trim($_POST['msj']);
    $Ventas->setIdVentas($IdVentas);
    $Ventas->setMensaje($msj);
    if($Ventas->EditComentarioC()){
        echo "Cambio Exitoso";
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['TipoNegocio']) && $_POST['TipoNegocio']=="TipoNegocio"){
    $Negocio=$_POST['Negocio'];
    $consulta_cl ="SELECT id, tiponegocios from negocio where id_tipo='$Negocio'" ;
    $ccl= $catalogos->obtenerLista($consulta_cl);
    $dato="";
    while ($rowcl = mysqli_fetch_array($ccl)) {
        $id=$rowcl['id'];
        $tiponegocios=$rowcl['tiponegocios'];
        $dato.= ' <option value="'.$id.'">'.$tiponegocios.'</option>';
    }
    echo $dato;
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
}elseif(isset($_POST['Perfiles']) && $_POST['Perfiles']=="Perfiles"){
    $Perfil=$_POST['Perfil'];
    $_SESSION['perfil'] = "  IdPerfil = ".$Perfil;
    $consulta_cl ="SELECT id_usuario, CONCAT(nombre,' ', usuario) as usuarios from
                    usuario WHERE  IdPerfil='$Perfil' order by nombre;" ;
    $ccl= $catalogos->obtenerLista($consulta_cl);
    $dato="";
    echo '<option value="">Selecciona una opción</option>';
    while ($rowcl = mysqli_fetch_array($ccl)) {
        $id=$rowcl['id_usuario'];
        $usuarios=$rowcl['usuarios'];
        $dato.= ' <option value="'.$id.'">'.$usuarios.'</option>';
    }
    echo $dato;
}
elseif(isset($_POST['Asesores']) && $_POST['Asesores']=="Asesores"){
    $Asesor=$_POST['Asesor'];
    $_SESSION['Asesor']="  usu.id_usuario = ".$Asesor;
}
elseif(isset($_POST['FechaF']) && $_POST['FechaF']=="FechaF"){
    $FechaI=$_POST['FechaI'];
    $FechaFf=$_POST['FechaFf'];
    $_SESSION['FechaI']= "(vigencia2 >= '$FechaI' and vigencia2 <='$FechaFf')";
    $_SESSION['FechaFf']="(fecha_pago >= '$FechaI' and fecha_pago <='$FechaFf')" ;
    $_SESSION['Fechas']= " ( (vigencia2 >= '$FechaI' and vigencia2 <='$FechaFf') or 
    (fecha_pago >= '$FechaI' and fecha_pago <='$FechaFf') )";

}
?>