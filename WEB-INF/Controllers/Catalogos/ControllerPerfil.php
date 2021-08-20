<?php
session_start();
if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
    header("Location: index.php");
}

include_once "../../Classes/catalogos.class.php";
include_once "../../Classes/Perfil.class.php";
include_once "../../Classes/Permisos.class.php";
$catalogo = new catalogos();
$perfil   = new Perfil();
$Permisos = new Permisos();
$errores  = 0;
$PermisosEspeciales= array();

if (isset($_POST['nuevo']) && $_POST['nuevo'] == "nuevoP") {
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $perfil->setNombrePerfil($parametros['Nombre']);
    $perfil->setDescripcion($parametros['Descripcion']);
    $perfil->setEstado($parametros['Estado']);
    $perfil->setUsuarioCreacion($_SESSION['usuario']);
    $perfil->setPantalla('ControllerPerfil.php');
    if(isset($parametros["PermisosEspeciales"])){
        $PermisosEspeciales = $parametros["PermisosEspeciales"];
    }
    if ($perfil->CorroborarPerfil($parametros['Nombre'])) {
        if ($perfil->newPerfil()) {
            $IdPerfil = $perfil->getIdPerfil();
            $Permisos->setIdPerfil($IdPerfil);
            for ($i = 0; $i < count($PermisosEspeciales); $i++) {
                $Permisos->setIdPermisoEspecial($PermisosEspeciales[$i]);
                if ($Permisos->newPermisoEspecial()) {
                } else {
                    $errores++;
                }
            }
            if ($errores == 0) {
                echo "Registro exito";
            } else {
                echo "Ocurrio un error #301 en Permisos Especiales";
            }
        } else {
            echo "Ocurrio un error por favor reportalo";
        }
    } else {
        echo "Error: El Perfil ya existe";
    }
} elseif (isset($_POST['Buscar']) && $_POST['Buscar'] == "Buscar") {
    $IdPerfil = $_POST['IdPerfil'];
    $perfil->setIdPerfil($IdPerfil);
    $perfil->getId();
    $Permisos->setIdPerfil($IdPerfil);
    $Permisos->getIdEspeciales();
    echo $perfil->getNombrePerfil() . "/*" . $perfil->getDescripcion() . "/*" .
    $perfil->getEstado() . "/*" . $IdPerfil . "/*" . json_encode($Permisos->getIdPE());
} elseif (isset($_POST['nuevo']) && $_POST['nuevo'] == "Editar") {
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $IdPerfil = $parametros['IdPerfil'];
    $perfil->setIdPerfil($IdPerfil);
    $perfil->setNombrePerfil($parametros['Nombre']);
    $perfil->setDescripcion($parametros['Descripcion']);
    $perfil->setEstado($parametros['Estado']);
    if(isset($parametros["PermisosEspeciales"])){
        $PermisosEspeciales = $parametros["PermisosEspeciales"];
    }
    if ($perfil->EditPerfil()) {
        $Permisos->setIdPerfil($IdPerfil);
        if ($Permisos->DeletePermisoEspecial()) {
            for ($i = 0; $i < count($PermisosEspeciales); $i++) {
                $Permisos->setIdPermisoEspecial($PermisosEspeciales[$i]);
                if ($Permisos->newPermisoEspecial()) {
                } else {
                    $errores++;
                }
            }
        }
        if ($errores == 0) {
            echo "Actualización exitosa";
        } else {
            echo "Ocurrio un error #301 en Permisos Especiales";
        }
    } else {
        echo "Ocurrio un error por favor reportalo";
    }

} elseif (isset($_POST['Eliminar']) && $_POST['Eliminar'] == "Eliminar") {
    $IdPerfil = $_POST['IdPerfil'];
    $perfil->setIdPerfil($IdPerfil);
    if ($perfil->DeletePerfil()) {
        echo "Se Borro el Perfil de manera Exitosa";
    } else {
        echo "No se puede borrar el perfil por que ya tiene datos asociados.";
    }
}
