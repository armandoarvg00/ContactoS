<?php
session_start();
if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
    header("Location: index.php");
}

include_once "../../Classes/catalogos.class.php";
include_once "../../Classes/Permisos.class.php";
$catalogos = new catalogos();
$Permisos  = new Permisos();
$Menu      = "";
if (isset($_POST['nuevo']) && $_POST['nuevo'] == "nuevoPermiso") {
    $parametros   = "";
    $Alta         = 0;
    $Baja         = 0;
    $Consulta     = 0;
    $Modificacion = 0;
    parse_str($_POST['form'], $parametros);
    $Permisos->setIdPerfil($parametros['Permiso']);
    $Permisos->setIdsubmenu($parametros['Submenu']);

    if (isset($parametros['Alta']) && $parametros['Alta'] == "on") {
        $Alta = 1;
    }
    if (isset($parametros['Baja']) && $parametros['Baja'] == "on") {
        $Baja = 1;
    }
    if (isset($parametros['Consulta']) && $parametros['Consulta'] == "on") {
        $Consulta = 1;
    }
    if (isset($parametros['Modificacion']) && $parametros['Modificacion'] == "on") {
        $Modificacion = 1;
    }
    $Permisos->setAlta($Alta);
    $Permisos->setBaja($Baja);
    $Permisos->setConsulta($Consulta);
    $Permisos->setModificacion($Modificacion);
    if ($Permisos->CorroborarPermiso($parametros['Permiso'], $parametros['Submenu'])) {
        if ($Permisos->newPermiso()) {
            echo "Registro Exitoso";
        } else {
            echo "Ocurrio un error por favor reportalo";
        }
    } else {
        echo "Error: El Permiso ya existe";
    }
} elseif (isset($_POST['tipoSelect']) && $_POST['tipoSelect'] == "cargar") {
    $Menu        = $_POST['Menu'];
    $consultasub = "SELECT IdSubmenu, Nombre as Nombre from submenu WHERE IdMenu='$Menu' ;";
    $resultado   = $catalogos->obtenerLista($consultasub);
    echo '<option value="">Selecciona un submenú</option>';
    while ($row = mysqli_fetch_array($resultado)) {
        echo '<option value="' . $row['IdSubmenu'] . '" >' . $row['Nombre'] . '</option>';
    }
} elseif (isset($_POST['Buscar']) && $_POST['Buscar'] == "Buscar") {
    $IdCatPerfil = $_POST['IdCatPerfil'];
    $IdSubmmenu  = $_POST['IdSubmmenu'];
    $Permisos->setIdPerfil($IdCatPerfil);
    $Permisos->setIdsubmenu($IdSubmmenu);
    $Permisos->getId();
    echo $Permisos->getAlta() . "/*" . $Permisos->getBaja() . "/*"
    . $Permisos->getConsulta() . "/*" . $Permisos->getModificacion() . "/*" .
    $Permisos->getIdPerfil() . "/*" . $Permisos->getIdMenu() . "/*" . $Permisos->getIdsubmenu();
} elseif (isset($_POST['nuevo']) && $_POST['nuevo'] == "Editar") {
    $parametros   = "";
    $Alta         = 0;
    $Baja         = 0;
    $Consulta     = 0;
    $Modificacion = 0;
    parse_str($_POST['form'], $parametros);
    $Permisos->setIdPerfil($parametros['Permiso']);
    $Permisos->setIdsubmenu($parametros['Submenu']);
    if (isset($parametros['Alta']) && $parametros['Alta'] == "on") {
        $Alta = 1;
    }
    if (isset($parametros['Baja']) && $parametros['Baja'] == "on") {
        $Baja = 1;
    }
    if (isset($parametros['Consulta']) && $parametros['Consulta'] == "on") {
        $Consulta = 1;
    }
    if (isset($parametros['Modificacion']) && $parametros['Modificacion'] == "on") {
        $Modificacion = 1;
    }
    $Permisos->setAlta($Alta);
    $Permisos->setBaja($Baja);
    $Permisos->setConsulta($Consulta);
    $Permisos->setModificacion($Modificacion);
    if ($Permisos->EditPermiso()) {
        echo "Edición Exitosa";
    } else {
        echo "Ocurrio un error por favor reportalo";
    }

} elseif (isset($_POST['Eliminar']) && $_POST['Eliminar'] == "Eliminar") {
    $IdCatPerfil = $_POST['IdCatPerfil'];
    $IdSubmmenu  = $_POST['IdSubmmenu'];
    $Permisos->setIdPerfil($IdCatPerfil);
    $Permisos->setIdsubmenu($IdSubmmenu);
    if ($Permisos->DeletePermiso()) {
        echo "Se Borro el permiso de manera Exitosa";
    } else {
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['perfil']) && $_POST['perfil']=="perfil"){
    $idperfil=$_POST['idperfil'];
    $_SESSION['perfil']= "  p.IdPerfil = ".$idperfil;
}