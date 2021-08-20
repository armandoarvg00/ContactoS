<?php
require_once "Conexion.class.php";
class catalogos
{
    private $tabla;
    public function ejecutar_consulta($consulta)
    {
        $conexion = new $Conexion();
        $conexion->conectar();
        $query = $conexion->ejecutar($consulta);
        $conexion->Desconectar();
        return $query;
    }
    public function satinizar_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = str_replace("'", "´", $data);
        return $data;
    }
    public function insertarRegistro($consulta)
    {
        $conexion = new Conexion();
        $conexion->Conectar();
        $this->preparaLog($consulta);
        $query = $conexion->Ejecutar($consulta);
        $id    = mysqli_insert_id($conexion->getconexion());
        $conexion->Desconectar();
        return $id;
    }
    public function ejecutaConsultaActualizacion($consulta, $tabla, $where)
    {
        $conexion = new Conexion();
        $conexion->Conectar();
        $query = $conexion->Ejecutar($consulta);
        $conexion->Desconectar();
        return $query;
    }
    private function preparaLog($consulta)
    {
        $this->log = false;
        if (strpos(strtoupper($consulta), 'INSERT') !== false) {
            $this->tipo  = "INSERT";
            $nombreTabla = explode(" ", substr($consulta, 12));
            $posicion    = strpos($nombreTabla[0], "(");
            if ($posicion !== false) {
                $this->tabla = substr($nombreTabla[0], 0, $posicion);
            } else {
                $this->tabla = $nombreTabla[0];
            }
            $this->accion = "insertó";
            $this->log    = true;
        } else if (strpos(strtoupper($consulta), 'DELETE') !== false) {
            $this->tipo  = "DELETE FROM ";
            $nombreTabla = explode(" ", substr($consulta, 12));
            $posicion    = strpos($nombreTabla[0], "(");
            if ($posicion !== false) {
                $this->tabla = substr($nombreTabla[0], 0, $posicion);
            } else {
                $this->tabla = $nombreTabla[0];
            }
            $this->accion = "eliminó";
            $this->log    = true;
        } else if (strpos(strtoupper($consulta), 'UPDATE') !== false) {
            $this->tipo  = "UPDATE";
            $nombreTabla = explode(" ", substr($consulta, 7));
            $posicion    = strpos($nombreTabla[0], "(");
            if ($posicion !== false) {
                $this->tabla = substr($nombreTabla[0], 0, $posicion);
            } else {
                $this->tabla = $nombreTabla[0];
            }
            $this->accion = "actualizó";
            $this->log    = true;
        }
    }
    public function obtenerLista($consulta)
    {
        $conexion = new Conexion();
        if (isset($this->empresa)) {
            $conexion->setEmpresa($this->empresa);
        }
        $conexion->Conectar();
        $query = $conexion->Ejecutar($consulta);
        $conexion->Desconectar();
        return $query;
    }
    public function formatoFechaReportes($fecha)
    {
        if (empty($fecha)) {
            return "";
        }
        $mes = "";
        $aux = explode("-", $fecha);
        switch ($aux[1]) {
            case '01':
                $mes = "Enero";
                break;
            case '02':
                $mes = "Febrero";
                break;
            case '03':
                $mes = "Marzo";
                break;
            case '04':
                $mes = "Abril";
                break;
            case '05':
                $mes = "Mayo";
                break;
            case '06':
                $mes = "Junio";
                break;
            case '07':
                $mes = "Julio";
                break;
            case '08':
                $mes = "Agosto";
                break;
            case '09':
                $mes = "Septiembre";
                break;
            case '10':
                $mes = "Octubre";
                break;
            case '11':
                $mes = "Noviembre";
                break;
            case '12':
                $mes = "Diciembre";
                break;
        }
        $formatFecha = $aux[2] . " de " . $mes . " de " . $aux[0];
        return $formatFecha;
    }
    /*function enviarCorreo($subject, $correos, $message, $pintar_mensaje) {
    $mail = new Mail();
    $parametroGlobal = new ParametroGlobal();
    if (isset($this->empresa)) {
    $parametroGlobal->setEmpresa($this->empresa);
    }
    if ($parametroGlobal->getRegistroById("10")) {
    // $mail->setFrom($parametroGlobal->getValor());
    } else {
    // $mail->setFrom("notificador@solbintec.com");
    }
    $mail->setSubject($subject);
    $mail->setBody($message);
    foreach ($correos as $value) {*/
    /* if (isset($value) && $value != "" && filter_var($value, FILTER_VALIDATE_EMAIL)) {*//* Si el correo es valido */
    /*  $mail->setTo($value);
if ($mail->enviarMail() == "1") {
if ($pintar_mensaje) {
echo "<br/>Un correo fue enviado a $value.";
}
} else {
if ($pintar_mensaje) {
echo "<br/>Error: No se pudo enviar el correo a $value";
}
}
}
}
}*/
}
