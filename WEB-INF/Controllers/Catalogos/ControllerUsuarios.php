<?php
 session_start();
 if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
     header("Location: index.php");
 }
include_once("../../Classes/catalogos.class.php");
include_once("../../Classes/Usuario.class.php");
include_once("../../Classes/Aseguradoras.class.php");
$catalogo = new catalogos();
$Usuario = new Usuario();
$Aseguradoras = new Aseguradoras();
$Aseguradora= array();
if(isset($_POST['nuevo']) && $_POST['nuevo']=="nuevoU"){
    $parametros = "";
    parse_str($_POST['form'], $parametros);
    $errores=0;
    $Nombre=$parametros["Nombre"];
    $Apellido=$parametros["Apellido"]; 
    $Correo=$parametros["Correo"]; 
    $Contrasena=$parametros["Contrasena"]; 
    $User=$parametros["Username"]; 
    $Perfil=$parametros["Perfil"]; 
    $Estado=$parametros["Estado"]; 
    $Usuario->setNombre($parametros["Nombre"]);
    $Usuario->setApellido($Apellido);
    $Usuario->setCorreo($Correo);
    $Usuario->setContrasena(base64_encode($Contrasena));
    $Usuario->setUsuario($User);
    $Usuario->setPerfil($Perfil);
    $Usuario->setEstado($Estado);
    if(isset($parametros["Aseguradoras"])){
        $Aseguradora=$parametros["Aseguradoras"]; 
    }
    if($Usuario->CorroborarUsuario($User)){
        if($Usuario->newUsuario()){
            $IdUsuario=$Usuario->getIdUsuario();
            $Aseguradoras->setIdUsuario($IdUsuario);
            for ($i=0;$i<count($Aseguradora);$i++)    
            {   
                $Aseguradoras->setIdAseguradora($Aseguradora[$i]);
                if($Aseguradoras->newAseguradora()){
                   
                } else{
                    $errores++;
                }
            } 
            if($errores==0){
                echo "Registro guardado con exito";
            }else{
                echo "Ocurrio un error en aseguradoras";
            }
        }else{
            echo "Ocurrio un error por favor reportalo";
        }
    }else{
        echo "Error: El Usuario ya existe"; 
    }
}
elseif(isset($_POST['Buscar']) && $_POST['Buscar']=="Buscar"){
    $IdUsuario=$_POST['IdUsuario'];
    $Usuario->setIdUsuario($IdUsuario);
    $Usuario->getId();
    $Aseguradoras->setIdUsuario($IdUsuario);
    $Aseguradoras->getId_rel();
    //print_r($Aseguradoras->getIdRel());
    echo $Usuario->getNombre()."/*".$Usuario->getApellido()."/*".$Usuario->getCorreo()."/*".
    $Usuario->getContrasena()."/*".$Usuario->getUsuario()."/*".$Usuario->getPerfil()."/*".
    $Usuario->getEstado()."/*".$IdUsuario."/*".json_encode($Aseguradoras->getIdRel());
}elseif(isset($_POST['nuevo']) && $_POST['nuevo']=="Editar"){
    $parametros = "";
    $errores=0;
    parse_str($_POST['form'], $parametros);
    $IdUsuario=$parametros['IdUsuario'];
    $Nombre=$parametros["Nombre"];
    $Apellido=$parametros["Apellido"]; 
    $Correo=$parametros["Correo"]; 
    $Contrasena=$parametros["Contrasena"]; 
    $User=$parametros["Username"]; 
    $Perfil=$parametros["Perfil"]; 
    $Estado=$parametros["Estado"]; 
    $Usuario->setIdUsuario($IdUsuario);
    $Usuario->setNombre($parametros["Nombre"]);
    $Usuario->setApellido($Apellido);
    $Usuario->setCorreo($Correo);
    $Usuario->setContrasena(base64_encode($Contrasena));
    $Usuario->setUsuario($User);
    $Usuario->setPerfil($Perfil);
    $Usuario->setEstado($Estado);
    if(isset($parametros["Aseguradoras"])){
        $Aseguradora=$parametros["Aseguradoras"]; 
    }
    if($Usuario->EditUsuario()){
        $IdUsuario=$Usuario->getIdUsuario();
        $Aseguradoras->setIdUsuario($IdUsuario);
        if($Aseguradoras->DeleteAseguradoraG()){ 
            for ($i=0;$i<count($Aseguradora);$i++)    
            {   
                $Aseguradoras->setIdAseguradora($Aseguradora[$i]); 
                if($Aseguradoras->newAseguradora()){             
                }else{
                    $errores++;
                }
            } 
        }
        if($errores==0){
            echo "Registro Actualizado con exito";
        }else{
            echo "Ocurrio un error #301 en aseguradoras";
        }
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['Eliminar']) && $_POST['Eliminar']=="Eliminar"){
    $IdUsuario=$_POST['IdUsuario'];
    $Aseguradoras->setIdUsuario($IdUsuario);
    if($Aseguradoras->DeleteAseguradoraG()){ 
        $Usuario->setIdUsuario($IdUsuario);
        if($Usuario->DeleteUsuario()){ 
            echo "Se Borro el Usuario de manera Exitosa";
        }else{
            echo "Ocurrio un error por favor reportalo";
        }
    }else{
        echo "Ocurrio un error por favor reportalo";
    }
}elseif(isset($_POST['perfil']) && $_POST['perfil']=="perfil"){
    $idperfil=$_POST['idperfil'];
    $_SESSION['perfil']= "  p.IdPerfil = ".$idperfil;
}
?>