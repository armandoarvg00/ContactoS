<?php
session_start();
if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
    header("Location: index.php");
}
include_once "../../Classes/catalogos.class.php";
include_once "../../Classes/Aseguradoras.class.php";
$catalogo     = new catalogos();
$Aseguradoras = new Aseguradoras();
if (isset($_POST['nuevo']) && $_POST['nuevo'] == "nuevoA") {
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $errores = 0;
    $Nombre  = $parametros["Nombre"];
    $Estado  = $parametros["Estado"];
    $Aseguradoras->setNombre($Nombre);
    $Aseguradoras->setEstado($Estado);
    if ($Aseguradoras->CorroborarAseguradora($Nombre)) {
        if ($Aseguradoras->newAseguradoraG()) {
            echo "Registro guardado con exito";
        } else {
            echo "Ocurrio un error por favor reportalo";
        }
    } else {
        echo "Error: La aseguradora ya existe";
    }
} elseif (isset($_POST['Buscar']) && $_POST['Buscar'] == "Buscar") {
    $IdAseguradora = $_POST['IdAseguradora'];

    $Aseguradoras->setIdAseguradora($IdAseguradora);
    $Aseguradoras->getId();
    echo $Aseguradoras->getNombre() . "/*" . $Aseguradoras->getEstado() . "/*" . $IdAseguradora;
} elseif (isset($_POST['nuevo']) && $_POST['nuevo'] == "Editar") {
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $IdAseguradora = $parametros['IdAseguradora'];
    $Aseguradoras->setIdAseguradora($IdAseguradora);
    $Aseguradoras->setNombre($parametros['Nombre']);
    $Aseguradoras->setEstado($parametros['Estado']);
    if ($Aseguradoras->EditAseguradora()) {
        echo "Edición Exitosa";
    } else {
        echo "Ocurrio un error por favor reportalo";
    }

} elseif (isset($_POST['Eliminar']) && $_POST['Eliminar'] == "Eliminar") {
    $IdAseguradora = $_POST['IdAseguradora'];
    $Aseguradoras->setIdAseguradora($IdAseguradora);
    if ($Aseguradoras->DeleteAseguradora()) {
        echo "Se Borro la Aseguradora de manera Exitosa";
    } else {
        echo "No se puede eliminar por que el registro tiene datos asociados";
    }
}
