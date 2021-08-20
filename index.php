<?php
/*
require_once('funciones/login.php');
$imagenes ="SELECT * FROM imagenlogin ";
$imagen = mysqli_query($conexion,$imagenes);
$date_now = date("Y-m-d");
$consult_existencia = "SELECT fecha FROM recontacto ORDER BY `recontacto`.`fecha` DESC limit 1";
$consultt = mysqli_query($conexion, $consult_existencia);
while($bajj=mysqli_fetch_array($consultt)){
    $fechass=$bajj[0];
    if($fechass == $date_now){
    }
    else{
        $insert = "INSERT INTO recontacto(fecha) VALUES ('$date_now')";
        $ejecutar = mysqli_query($conexion,$insert);
        $seleccionar_ventas="SELECT * FROM ventas WHERE id_usuario!='39' and  fecha_pago='0001-01-01' and estado='pendiente' order by id_ventas DESC limit 200";
        $ejecuta=mysqli_query($conexion,$seleccionar_ventas);
        $i = 1;
            while($resultados=mysqli_fetch_array($ejecuta)){
            $hoy=date('Y-m-d');  
            //echo "<br>"."#"."<span style='color:black'>$i</span>"."\t";
            $no_polizas=$resultados['no_poliza'];
            //echo "<span style='color:orange'>$no_polizas</span>"."\t";
            $id_ventas=$resultados['id_ventas'];
            //echo "<span style='color:aqua'>$id_ventas</span>"."\t";
            $vigencia_poliza=$resultados['vigencia'];
            //echo "<span style='color:black'>$vigencia_poliza</span>"."\t";
            $vigencia_poliza;
            $d = new DateTime( $vigencia_poliza );
            $d->modify( '+25 day' );
            $nueva_fechas=$d->format( 'Y-m-d' );
                if($nueva_fechas<$hoy){
                $actualiza="UPDATE ventas SET id_usuario='39' where no_poliza='$no_polizas' and  id_ventas>='$id_ventas'";
                $ejecc=mysqli_query($conexion, $actualiza);
                //"UPDATE ventas SET id_usuario='39' where no_poliza='$no_polizas' and  id_ventas>='$id_ventas'";
                //"\n\n\n", "se hara cambio";echo "<br>"; echo "<br>";
                }    
                else{
                
                } 
                $i++;
            }
    }


}
*/
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['idusuario']) && isset($_SESSION['tipo'])) {
    header("Location: principal.php");    
    exit;
}
if(isset($_GET['session'])){
    switch ($_GET['session']) {
        case "1":
//                        $mensaje = "Usuario y/o password incorrectos";
            $mensaje = "Usuario o contraseña incorrectos.";
            break;                    
        case "2":
//                        $mensaje = "Atención, no se permite usar palabras reservadas del sistema";
            $mensaje = "Usuario o contraseña incorrectos.";
            break;
        case "3":
//                        $mensaje = "Atención, en el usuario sólo se permite letras y números";
            $mensaje = "Usuario o contraseña incorrectos.";
            break;
        default:
            $mensaje = "";
            break;
    }
}else{
    $mensaje = "";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto Seguros</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="img/icono.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="resources/js/index.js"></script>
</head>
<body >
<?php //if($loginimg= mysqli_fetch_row($imagen)){?>
    <div class="cuerpo">
        <div class="dinamica">
		
            <img src="img/<?php echo $loginimg[1]; ?>" >
		    <!--<div class="cntr"><span id="clock" class="clock"></span> </div>-->
        </div>

        <div class="login">
           <div class="formulario">
                    <img src="img/Bienvenida_CRM_Logo.jpg">
           </div>
		
           <div class="campos">
                <p>¡Bienvenido! Inicia sesión.</p>
                <form action="<?php echo htmlspecialchars("sesion.php");?>" method="post" >
                    <input type="text" name="usuario" placeholder="Usuario" id=""><br>
                    <input type="password" name="pass" placeholder="Password" id="">
                    <input type="submit" name="submit" value="LISTO">
				</form>
				<?php echo $mensaje;?> 
           </div>
        </div>
        <div class="frase">
            <img src="img/<?php echo $loginimg[2]; ?>" id="frase1">
            <img src="img/<?php echo $loginimg[3]; ?>" id="frase2">
        </div>
    </div>
<?php //}?>
</body>
 <script src="../js/cntr.js"></script>
</html>