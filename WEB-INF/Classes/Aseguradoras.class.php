<?php
class Aseguradoras{
    private $IdUsuario;
    private $IdAseguradora;
    private $IdAseguradoraRel;
    private $Nombre;
    private $Estado;
    private $Rel;
    public function CorroborarAseguradora($nombre){
        $catalogos = new catalogos();
        $consulta = "SELECT NombreA FROM aseguradoras WHERE NombreA='$nombre' LIMIT 1";
        $query = $catalogos->obtenerLista($consulta);
        if(mysqli_num_rows($query)==0){
            return true;
        }else{
            return false;
        }
    }
    public function getId(){
        $catalogos = new catalogos();
        $consulta = "SELECT NombreA, Estado FROM aseguradoras WHERE IdAseguradoras='$this->IdAseguradora'";
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            $this->Nombre = $rs['NombreA'] ;
            $this->Estado = $rs['Estado'] ;
            return true;
    	}
    	return false;
    }
    public function getId_rel(){
        $catalogos = new catalogos();
        $this->Rel= array();
        $consulta = "SELECT IdAseguradora, IdUsuario FROM aseguradoras_rel WHERE IdUsuario='$this->IdUsuario'";
        $query = $catalogos->obtenerLista($consulta);
        if(mysqli_num_rows($query)>0){
            while ($rs = mysqli_fetch_array($query)) {
                array_push($this->Rel,$rs['IdAseguradora']);
            }
            return true;
        }
    	return false;
    }
    public function newAseguradoraG(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO aseguradoras(NombreA, Estado)
                   VALUES ( '$this->Nombre', '$this->Estado');";
        $this->IdAseguradora = $catalogos->insertarRegistro($insert);
        if ($this->IdAseguradora != null && $this->IdAseguradora != 0) {
            return true;
        }
        return false;
    }
    public function newAseguradora(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO aseguradoras_rel( IdAseguradora, IdUsuario)
                   VALUES ( '$this->IdAseguradora', '$this->IdUsuario');";
        $this->IdAseguradoraRel = $catalogos->insertarRegistro($insert);
        if ($this->IdAseguradoraRel != null && $this->IdAseguradoraRel != 0) {
            return true;
        }
        return false;
    }
    public function EditAseguradora() {
        $consulta = "UPDATE aseguradoras SET NombreA = '$this->Nombre', Estado = '$this->Estado'  
                     WHERE IdAseguradoras= '$this->IdAseguradora' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "aseguradoras", "WHERE IdAseguradora= '$this->IdAseguradora'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function DeleteAseguradora(){
        $where = "IdAseguradoras= '$this->IdAseguradora'";
        $tabla = "aseguradoras";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function DeleteAseguradoraG(){
        $where = "IdUsuario= '$this->IdUsuario'";
        $tabla = "aseguradoras_rel";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }

    function setIdUsuario($IdUsuario){
        $this->IdUsuario= $IdUsuario;
    }
    function setIdAseguradora($IdAseguradora){
        $this->IdAseguradora= $IdAseguradora;
    }
    function setIdAseguradoraRel($IdAseguradoraRel){
        $this->IdAseguradoraRel= $IdAseguradoraRel;
    }
    function setNombre($Nombre){
        $this->Nombre= $Nombre;
    }
    function setEstado($Estado){
        $this->Estado= $Estado;
    }
    
    function getEstado(){
        return $this->Estado;
    }
    function getNombre(){
        return $this->Nombre;
    }
    function getIdAseguradoraRel(){
        return $this->IdAseguradoraRel;
    }
    function getIdAseguradora(){
        return $this->IdAseguradora;
    }
    function getIdUsuario(){
        return $this->IdUsuario;
    }
    function getIdRel(){
        return $this->Rel;
    }
}
?>