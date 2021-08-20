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
  include_once("../WEB-INF/Classes/Menu.class.php");
    include_once("../WEB-INF/Classes/fpdf/fpdf.php");
    include_once("../WEB-INF/Classes/fpdf/tfpdf.php");
    $catalogos = new catalogos();
    $Permisos = new Permisos();
    $Usuario = new Usuario();
    //$pdf = new FPDF();
    
    //$pdf=new FPDF('L','mm','A4');
    $pdf=new tFPDF('L','mm','A4');
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
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',8);
    $header = array("ID" ,"NOMBRE","CORREO", "TELÉFONO", "CP", "MARCA", "AÑO", "VERSIÓN", "EDAD", "ASEGURADORA", "HORA", "ASIGNADO");
    $w = array(10,50,50,18,10,22,10,22,10,24,24);
    $pdf->SetFillColor(31,191,65);
    $pdf->SetTextColor(0);
    //$pdf->SetDrawColor(128,0,0);
    //$pdf->SetLineWidth(.3);

    $pdf->Cell($w[0],7,$header[0],1,0,'C',true);
    $pdf->Cell($w[1],7,$header[1],1,0,'C',true);
    $pdf->Cell($w[2],7,$header[2],1,0,'C',true);
    $pdf->Cell($w[3],7,$header[3],1,0,'C',true);
    $pdf->Cell($w[4],7,$header[4],1,0,'C',true);
    $pdf->Cell($w[5],7,$header[5],1,0,'C',true);
    $pdf->Cell($w[6],7,$header[6],1,0,'C',true);
    $pdf->Cell($w[7],7,$header[7],1,0,'C',true);
    $pdf->Cell($w[8],7,$header[8],1,0,'C',true);
    $pdf->Cell($w[9],7,$header[9],1,0,'C',true);
    $pdf->Cell($w[10],7,$header[10],1,0,'C',true);
    $pdf->Cell($w[11],7,$header[11],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetFillColor(255);
    $pdf->SetFont('Arial','',7);
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',7);
    $consulta1 = "SELECT   c.*, u.nombre as asesor FROM
    contactos AS c
    INNER JOIN usuario AS u ON u.id_usuario = c.id_usuario 
    $where
    ORDER BY
    id_contactos DESC 
    ";
    $query1 = $catalogos->obtenerLista($consulta1);
    while ($rs = mysqli_fetch_array($query1)) {
        $pdf->Cell($w[0],7,$rs['id_contactos'],1,0,'C',true);
        $pdf->Cell($w[1],7,$rs['nombre'],1,0,'C',true);
        $pdf->Cell($w[2],7,$rs['email'],1,0,'C',true);
        $pdf->Cell($w[3],7,$rs['phone'],1,0,'C',true);
        $pdf->Cell($w[4],7,$rs['cp'],1,0,'C',true);
        $pdf->Cell($w[5],7,$rs['marca'],1,0,'C',true);
        $pdf->Cell($w[6],7,$rs['anio'],1,0,'C',true);
        $pdf->Cell($w[7],7,$rs['version'],1,0,'C',true);
        $pdf->Cell($w[8],7,$rs['edad'],1,0,'C',true);
        $pdf->Cell($w[9],7,$rs['aseguradora'],1,0,'C',true);
        $pdf->Cell($w[10],7,$rs['hora'],1,0,'C',true);
        $pdf->Cell($w[11],7,$rs['asesor'],1,0,'C',true);
        $pdf->Ln();
    }
    $pdf->Output();
    $pdf->Output('F', 'ContactosVN.pdf');

?>