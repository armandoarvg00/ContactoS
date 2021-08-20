<?php 
    include_once("catalogos.class.php");
    class Session{
        private $Usuario;
        private $Password;
        public function login($user, $pass){
            $catalogos = new catalogos();
            $pass= base64_encode($pass);
            $consulta= "SELECT * FROM usuario where usuario= '$user' && pass='$pass'";
            $query = $catalogos->obtenerLista($consulta);
            while ($rs = mysqli_fetch_array($query)) {
                $this->IdUsuario = $rs['id_usuario'];
                $this->Usuario = $rs['usuario'];
                $this->Tipo = $rs['tipo'];
                return $this->IdUsuario;
            }
            return "";
        }
        function setTipo($Tipo){
            $this->Tipo;
        }
        function setIdUsuario($IdUsuario){
            $this->IdUsuario;
        }
        function setUsuario($Usuario){
            $this->Usuario;
        }
        function setPassword($Password){
            $this->Password;
        }
        function getTipo(){
            return $this->Tipo;
        }
        function getIdUsuario(){
            return $this->IdUsuario;
        }
        function getUsuario(){
            return $this->Usuario;
        }
        function getPassword(){
            return $this->Password;
        }
    }
?>