<?php
class Contactos{
    private $Nombre;
    private $Correo;
    private $Telefono;
    private $CP;
    private $Marca;
    private $Anio;
    private $Version;
    private $Edad;
    private $Medio;
    private $IdContactos;
    private $IdUsuario;
    public function getId(){
        $catalogos = new catalogos();
        $consulta = "SELECT id_contactos, nombre, email, phone, cp, marca, anio, version, edad, aseguradora 
                    FROM contactos WHERE id_contactos='$this->IdContactos'";
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            $this->IdContactos = $rs['id_contactos'] ;
            $this->Nombre = $rs['nombre'] ;
            $this->Correo = $rs['email'] ;
            $this->Telefono = $rs['phone'] ;
            $this->CP = $rs['cp'] ;
            $this->Marca = $rs['marca'] ;
            $this->Anio = $rs['anio'] ;
            $this->Version = $rs['version'] ;
            $this->Edad = $rs['edad'] ;
            $this->Medio = $rs['aseguradora'] ;
            return true;
    	}
    	return false;
    }
    public function newContactos(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO contactos( nombre, email, phone, cp, marca, anio, version, edad, aseguradora, aseguradora2, hora, id_usuario )
                   VALUES ( '$this->Nombre', '$this->Correo','$this->Telefono', '$this->CP', '$this->Marca','$this->Anio', '$this->Version','$this->Edad', '$this->Medio', '$this->Medio', NOW(), '$this->IdUsuario');";
        $this->IdAseguradoraRel = $catalogos->insertarRegistro($insert);
        if ($this->IdAseguradoraRel != null && $this->IdAseguradoraRel != 0) {
            return true;
        }
        return false;
    }
    public function EditContactos() {
        $consulta = "UPDATE contactos SET nombre = '$this->Nombre', email = '$this->Correo', phone = '$this->Telefono', cp = '$this->CP',
                     marca = '$this->Marca', anio = '$this->Anio', version = '$this->Version', edad = '$this->Edad', aseguradora = '$this->Medio'
                     WHERE id_contactos= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditUser() {
        $consulta = "UPDATE contactos SET id_usuario = '$this->IdUsuario'
                     WHERE id_contactos= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditContactado() {
        $consulta = "UPDATE contactos SET contactado = '$this->Contactado'
                     WHERE id_contactos= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditGMA() {
        $consulta = "UPDATE contactos SET comentario = '$this->GMA'
                     WHERE id_contactos= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditGMG() {
        $consulta = "UPDATE contactos SET comentario_de_gerente = '$this->GMG'
                     WHERE id_contactos= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditGMAR() {
        $consulta = "UPDATE renovacion SET comentario_renovacion = '$this->GMA'
                     WHERE id_renovacion= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditGMGR() {
         $consulta = "UPDATE renovacion SET comentario_de_gerente = '$this->GMG'
                     WHERE id_renovacion= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditContactadoR() {
        $consulta = "UPDATE renovacion SET contactado = '$this->Contactado'
                     WHERE id_renovacion= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function EditUserR() {
        $consulta = "UPDATE renovacion SET id_usuario = '$this->IdUsuario'
                     WHERE id_renovacion= '$this->IdContactos' ";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "contactos", "WHERE id_contactos= '$this->IdContactos'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function DeleteRenovaciones(){
        $where = "id_renovacion= '$this->IdContactos'";
        $tabla = "contactos";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function DeleteContactos(){
        $where = "id_contactos= '$this->IdContactos'";
        $tabla = "contactos";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    function setIdContactos($IdContactos){
        $this->IdContactos= $IdContactos;
    }
    function setNombre($Nombre){
        $this->Nombre= $Nombre;
    }
    function setCorreo($Correo){
        $this->Correo= $Correo;
    }
    function setTelefono($Telefono){
        $this->Telefono= $Telefono;
    }
    function setCP($CP){
        $this->CP= $CP;
    }
    function setMarca($Marca){
        $this->Marca= $Marca;
    }
    function setAnio($Anio){
        $this->Anio= $Anio;
    }
    function setVersion($Version){
        $this->Version= $Version;
    }
    function setEdad($Edad){
        $this->Edad= $Edad;
    }
    function setMedio($Medio){
        $this->Medio= $Medio;
    }
    function setIdUsuario($IdUsuario){
        $this->IdUsuario= $IdUsuario;
    }
    function setContactado($Contactado){
        $this->Contactado= $Contactado;
    }
    function setGMA($GMA){
        $this->GMA= $GMA;
    }
    function setGMG($GMG){
        $this->GMG= $GMG;
    }
    function getGMG(){
        return $this->GMG;
    }
    function getGMA(){
        return $this->GMA;
    }
    function getContactado(){
        return $this->Contactado;
    }
    function getIdUsuario(){
        return $this->IdUsuario;
    }
    function getMedio(){
        return $this->Medio;
    }
    function getEdad(){
        return $this->Edad;
    }
    function getVersion(){
        return $this->Version;
    }
    function getAnio(){
        return $this->Anio;
    }
    function getMarca(){
        return $this->Marca;
    }
    function getCP(){
        return $this->CP;
    }
    function getTelefono(){
        return $this->Telefono;
    }
    function getCorreo(){
        return $this->Correo;
    }
    function getNombre(){
        return $this->Nombre;
    }
    function getIdContactos(){
        return $this->IdContactos;
    }
}
?>