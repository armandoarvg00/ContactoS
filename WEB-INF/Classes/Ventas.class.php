<?php
class Ventas{
    private $IdVentas;
    private $NoPoliza;
    private $Serie;
    private $Nombre;
    private $Correo;
    private $Telefono;
    private $Registro;
    private $Vigencia;
    private $ProxPago;
    private $FechaPago;
    private $Aseguradora;
    private $FormaPago;
    private $PrimaNeta;
    public function getId(){
        $catalogos = new catalogos();
        $consulta = "SELECT no_poliza, serie, nombre, correo, telefono, registrof, vigencia, fecha_pago,vigencia2, compania,
                    forma_de_pago, prima_neta
        FROM ventas WHERE id_ventas='$this->IdVentas'";
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            $this->NoPoliza = $rs['no_poliza'] ;
            $this->Serie = $rs['serie'] ;
            $this->Nombre = $rs['nombre'] ;
            $this->Correo = $rs['correo'] ;
            $this->telefono = $rs['telefono'] ;
            $this->Registro = $rs['registrof'] ;
            $this->Vigencia = $rs['vigencia'] ;  
            $this->FechaPago = $rs['fecha_pago'] ; 
            $this->ProxPago = $rs['vigencia2'] ;    
            $this->Aseguradora = $rs['compania'] ;            
            $this->FormaPago = $rs['forma_de_pago'] ;            
            $this->PrimaNeta = $rs['prima_neta'] ;                      
            return true;
    	}
    	return false;
    }

    public function newVentas(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO usuario(nombre, apellidos, correo, pass, usuario , IdPerfil, estado)
                   VALUES ('$this->Nombre', '$this->Apellido', '$this->Correo', '$this->Contrasena', '$this->Usuario', '$this->Perfil', '$this->Estado' );";
        $this->IdUsuario = $catalogos->insertarRegistro($insert);
        if ($this->IdUsuario != null && $this->IdUsuario != 0) {
            return true;
        }
        return false;
    }
    public function EditVentas(){
        $consulta = "UPDATE usuario SET nombre = '$this->Nombre', apellidos = '$this->Apellido', correo = '$this->Correo'
        , pass = '$this->Contrasena', IdPerfil = '$this->Perfil', estado = '$this->Estado'
        WHERE id_usuario= '$this->IdUsuario'";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "usuario", "WHERE id_usuario= '$this->IdUsuario'");
        if ($query == 1) {
        return true;
        }
        return false;
    }
    public function DeleteVentas(){
        $where = "id_usuario= '$this->IdUsuario'";
        $tabla = "usuario";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditFechaPago() {
        $consulta = "UPDATE ventas SET fecha_pago = '$this->FechaPago', estado='pagado', cobranza= '$this->IdUsuario'
                     WHERE id_ventas= '$this->IdVentas' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "ventas", "WHERE id_ventas= '$this->IdVentas'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditComentarioC() {
        $consulta = "UPDATE ventas SET comentario_cobranza = '$this->Mensaje'
                     WHERE id_ventas= '$this->IdVentas' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "ventas", "WHERE id_ventas= '$this->IdVentas'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditUserR() {
        $consulta = "UPDATE ventas SET id_usuario = '$this->IdUsuario'
                     WHERE id_ventas= '$this->IdVentas' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_ventas= '$this->IdVentas'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    function setIdVentas($IdVentas){
        $this->IdVentas= $IdVentas;
    }
    function setNoPoliza($NoPoliza){
        $this->NoPoliza= $NoPoliza;
    }
    function setSerie($Serie){
        $this->Serie= $Serie;
    }
    function setNombre($Nombre){
        $this->Nombre= $Nombre;
    }
    function setCorreo($Correo){
        $this->Correo= $Correo;
    }
    function setTelefono($telefono){
        $this->telefono= $telefono;
    }
    function setRegistro($Registro){
        $this->Registro= $Registro;
    }  
    function setVigencia($Vigencia){
        $this->Vigencia= $Vigencia;
    }
    function setProxPago($ProxPago){
        $this->ProxPago= $ProxPago;
    }
    function setFechaPago($ProxPago){
        $this->FechaPago= $ProxPago;
    }
    function setAseguradora($Aseguradora){
        $this->Aseguradora= $Aseguradora;
    }
    function setFormaPago($FormaPago){
        $this->FormaPago= $FormaPago;
    }
    function setPrimaNeta($PrimaNeta){
        $this->PrimaNeta= $PrimaNeta;
    }
    function setIdUsuario($IdUsuario){
        $this->IdUsuario= $IdUsuario;
    }
    function setMensaje($Mensaje){
        $this->Mensaje= $Mensaje;
    }
    /*function setNegocio($Negocio){
        $this->Negocio= $Negocio;
    }
    function getNegocio(){
        return $this->Negocio;
    }*/
    function getMensaje(){
        return $this->Mensaje;
    }
    function getIdUsuario(){
        return $this->IdUsuario;
    }
    function getPrimaNeta(){
        return $this->PrimaNeta;
    }
    function getFormaPago(){
        return $this->FormaPago;
    }
    function getAseguradora(){
        return $this->Aseguradora;
    }
    function getFechaPago(){
        return $this->FechaPago;
    }
    function getProxPago(){
        return $this->ProxPago;
    }
    function getVigencia(){
        return $this->Vigencia;
    }
    function getRegistro(){
        return $this->Registro;
    }
    function getTelefono(){
        return $this->telefono;
    }
    function getCorreo(){
        return $this->Correo;
    }
    function getNombre(){
        return $this->Nombre;
    }
    function getSerie(){
        return $this->Serie;
    }
    function getNoPoliza(){
        return $this->NoPoliza;
    }
    function getIdVentas(){
        return $this->IdVentas;
    }
}
?>