<?php 
  include_once("WEB-INF/Classes/catalogos.class.php");
  include_once("WEB-INF/Classes/Session.class.php");
  include_once("WEB-INF/Classes/Usuario.class.php");

    if(isset($_POST['usuario']) && $_POST['usuario']!="" && isset($_POST['pass']) && $_POST['pass']!=""){
        ini_set("session.gc_maxlifetime", 7200);
        session_start();
        $catalogos = new catalogos();
        $sesion = new Session();
        $usuario = new Usuario();
        if (stripos($_POST['usuario'], "DELETE") !== false || stripos($_POST['usuario'], "INSERT") !== false ||
                stripos($_POST['usuario'], "UPDATE") !== false || stripos($_POST['usuario'], "DELETE") !== false ||
                stripos($_POST['usuario'], "INSERT") !== false || stripos($_POST['usuario'], "UPDATE")
        ) {//Si tiene alguna palabra reservada de mysql
            header("Location: index.php?session=1");
        } else {
            if (preg_match("[^A-Za-z0-9]", $_POST['usuario'])) {
                header("Location: index.php?session=3");
            } 
            if($sesion->login($_POST['usuario'],$_POST['pass'])){
                $_SESSION['usuario']= $sesion->getUsuario();
                $_SESSION['idusuario']= $sesion->getIdUsuario();
                $_SESSION['tipo']= $sesion->getTipo();
                header("Location: principal.php");
            }else{
                header("Location: index.php?session=2".$sesion->login($_POST['usuario'],$_POST['pass']));
            }
        }

    }elseif (isset($_GET['cerrar']) && $_GET['cerrar'] == '1') {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
?>