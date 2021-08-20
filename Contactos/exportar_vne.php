<?php 
  session_start();
  if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
      header("Location: index.php");
  }
  
ini_set("memory_limit", "256M");
set_time_limit(0);
  error_reporting(0);
  include_once("../WEB-INF/Classes/Permisos.class.php");
  include_once("../WEB-INF/Classes/catalogos.class.php");
  include_once("../WEB-INF/Classes/Usuario.class.php");
include_once("../WEB-INF/Classes/PHP_XLSXWriter-master/xlsxwriter.class.php");
  $catalogos = new catalogos();
  $Permisos = new Permisos();
  $Usuario = new Usuario();
  $filename = "ContactosVN.xlsx";
  $leyenda = "Generado el día " . $catalogos->formatoFechaReportes(date("Y-m-d")) . " a las " . date("H:i:s");
  $where="";
  $msn_fecha="";
  ini_set('display_errors', 0);
  ini_set('log_errors', 1);
  error_reporting(E_ALL & ~E_NOTICE);
  
  header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
  header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header('Content-Transfer-Encoding: binary');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  $writer = new XLSXWriter();
  $writer->setAuthor('Solbintec');
  $hoja = "Contactos VN";
  //$hoja2 = "Inventario2";
  if(isset($_SESSION['Asesor']) and $_SESSION['Asesor']!=""){
    $where= " Where". $_SESSION['Asesor'];
    
}
if(isset($_SESSION['Fechas']) and $_SESSION['Fechas']!=""){
    if($where==""){
        $where= " Where";
    }else{
        $where.= " AND";
    }
    $where.= $_SESSION['Fechas'];
    
}
  $encabezado = array("Contactos" => "string");
  $writer->writeSheetHeader($hoja, $encabezado);
  $writer->writeSheetRow($hoja, array("Fecha: $msn_fecha"));
  $writer->writeSheetRow($hoja, array("$leyenda"));
$cabeceras = array("ID" ,"NOMBRE","CORREO", "TELÉFONO", "CP", "MARCA", "AÑO", "VERSIÓN", "EDAD", "ASEGURADORA", "HORA", "ASIGNADO");

  $writer->writeSheetRow($hoja, $cabeceras);

  $consulta1 = "SELECT   c.*, u.nombre as asesor FROM
                contactos AS c
                INNER JOIN usuario AS u ON u.id_usuario = c.id_usuario 
                $where
                ORDER BY
                id_contactos DESC 
                ";
  $query1 = $catalogos->obtenerLista($consulta1);
  while ($rs = mysqli_fetch_array($query1)) {
          $arreglo = array();
              array_push($arreglo, $rs['id_contactos']);
              array_push($arreglo, $rs['nombre']);
              array_push($arreglo, $rs['email']);
              array_push($arreglo, $rs['phone']);
              array_push($arreglo, $rs['cp']);
              array_push($arreglo, $rs['marca']);
              array_push($arreglo, $rs['anio']);
              array_push($arreglo, $rs['version']);
              array_push($arreglo, $rs['edad']);
              array_push($arreglo, $rs['aseguradora']);
              array_push($arreglo, $rs['hora']);
              array_push($arreglo, $rs['asesor']);
      
          $writer->writeSheetRow($hoja, $arreglo);
  }
    $writer->writeToStdOut();
    exit(0);
  
  ?>