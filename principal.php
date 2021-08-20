<?php 
    session_start();
    if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
        header("Location: index.php");
    }
    
    error_reporting(0);

    include_once("WEB-INF/Classes/Usuario.class.php"); 
    include_once("WEB-INF/Classes/Menu.class.php"); 
    include_once("WEB-INF/Classes/Permisos.class.php"); 
    $permisos = new Permisos();
    $usuario= new Usuario();
    $menu= new Menu();
    $menuactual="";
    $primero=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto Seguros</title>
    <link rel="shortcut icon" href="img/icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="resources/css/vn.css"></head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!--datatables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="resources/js/index.js"></script>

    <script src="resources/js/jquery.multi-select.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/css/multi-select.css">


<body>
    <div class='header'>
        <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #333645;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="img/LogoBlanco_CS.png" alt="" width="155px" height="45px" class="d-inline-block align-text-top">
                </a>
            </div>
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php 
                        $datosmenu= $menu->getPermisos($_SESSION['idusuario']);
                        while($datos =mysqli_fetch_array($datosmenu)){
                            $IdMenu=$datos['IdMenu'];
                            $IdSubmenu=$datos['IdSubmenu'];
                            $Manual=$datos['NombreManual'];
                            if($menuactual==$datos['mn']){
                                $submenuactual=$datos['RefSubmenu'];
                                echo '
                                    <li onclick="Manual(\''.$Manual.'\');">
                                    <a class="dropdown-item" href="#" onclick="cambiarContenidos(\''.$submenuactual.'\', \''.$IdMenu.'\',\''.$IdSubmenu.'\');">'.$datos['nsm'].'</a></li>
                                    ';
                                $primero++;
                            }else{
                                if($primero!=0 ){
                                    echo "</ul></li>";
                                } 
                                $primero++;
                                $menuactual=$datos['mn'];
                                $submenuactual=$datos['RefSubmenu'];
                                echo '<li class="nav-item dropdown">
                                        <a class="nav-link active dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#" >'.$menuactual.'</a>';
                                echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li onclick="Manual(\''.$Manual.'\');"><a class="dropdown-item" href="#" onclick="cambiarContenidos(\''.$submenuactual.'\', \''.$IdMenu.'\',\''.$IdSubmenu.'\');">'.$datos['nsm'].'</a></li>
                                                ';
                                }
                            }
                            if($primero!=0 ){
                                echo "</ul></li>";
                            } 
                        
                        ?>
                        <li class="nav-item" onMouseOver="this.style.cssText='background: #fe0000'" onMouseOut="this.style.cssText='color: #FFFFFF'">
                            <a class="nav-link active" aria-current="page" href="sesion.php?cerrar=1" >Salir</a>
                        </li>
                        <li class="nav-item bi bi-question-circle-fill " style="margin-left:20px; font-size: 1.5rem; color: white; cursor:pointer;" onclick="imprimirmanual();">
                            <!--<a href="Manuales/manual_catalogo_perfil.pdf" target="_blank" id="manuales"></a>-->
                        </i>
                        <li class="nav-item bi bi-arrow-down-circle-fill" style="margin-left:20px; font-size: 1.5rem; color: white; cursor:pointer;" onclick="filtros();">
                        </i>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <input type="hidden" id="filtro_vista" name="filtro_vista" value="block"> 
    <div class="contenedor" id="contenidos">
        
        
    </div>
</body>
</html>