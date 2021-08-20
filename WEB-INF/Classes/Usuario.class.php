<?php
class Usuario{
    private $Nombre;
    private $Apellido;
    private $Correo;
    private $Contrasena;
    private $Usuario;
    private $Perfil;
    private $Estado;

    public function CorroborarUsuario($usuario){
        $catalogos = new catalogos();
        $consulta = "SELECT usuario FROM usuario WHERE usuario='$usuario' LIMIT 1";
        $query = $catalogos->obtenerLista($consulta);
        if(mysqli_num_rows($query)==0){
            return true;
        }else{
            return false;
        }
    }
    public function newUsuario(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO usuario(nombre, apellidos, correo, pass, usuario , IdPerfil, estado)
                   VALUES ('$this->Nombre', '$this->Apellido', '$this->Correo', '$this->Contrasena', '$this->Usuario', '$this->Perfil', '$this->Estado' );";
        $this->IdUsuario = $catalogos->insertarRegistro($insert);
        if ($this->IdUsuario != null && $this->IdUsuario != 0) {
            return true;
        }
        return false;
    }
    public function EditUsuario(){
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
    public function getId(){
        $catalogos = new catalogos();
        $consulta = "SELECT
        u.nombre, u.apellidos, u.correo, u.pass, u.usuario, u.IdPerfil, u.estado
        FROM
        usuario AS u
        INNER JOIN perfil AS p ON p.IdPerfil = u.IdPerfil WHERE id_usuario='$this->IdUsuario'";
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            $this->Nombre = $rs['nombre'] ;
            $this->Apellido = $rs['apellidos'] ;
            $this->Correo = $rs['correo'] ;
            $this->Contrasena = base64_decode($rs['pass']);
            $this->Usuario = $rs['usuario'] ;
            $this->Perfil = $rs['IdPerfil'] ;
            $this->Estado = $rs['estado'] ;            
            return true;
    	}
    	return false;
    }
    public function DeleteUsuario(){
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
    function setNombre($Nombre){
        $this->Nombre= $Nombre;
    }
    function setApellido($Apellido){
        $this->Apellido= $Apellido;
    }
    function setCorreo($Correo){
        $this->Correo= $Correo;
    }
    function setContrasena($Contrasena){
        $this->Contrasena= $Contrasena;
    }
    function setUsuario($Usuario){
        $this->Usuario= $Usuario;
    }
    function setPerfil($Perfil){
        $this->Perfil= $Perfil;
    }
    function setEstado($Estado){
        $this->Estado= $Estado;
    }
    function setIdUsuario($IdUsuario){
        $this->IdUsuario= $IdUsuario;
    }
    function getIdUsuario(){
        return $this->IdUsuario;
    }
    function getEstado(){
        return $this->Estado;
    }
    function getPerfil(){
        return $this->Perfil;
    }
    function getUsuario(){
        return $this->Usuario;
    }
    function getContrasena(){
        return $this->Contrasena;
    }
    function getCorreo(){
        return $this->Correo;
    }
    function getApellido(){
        return $this->Apellido;
    }
    function getNombre(){
        return $this->Nombre;
    }
}
?>