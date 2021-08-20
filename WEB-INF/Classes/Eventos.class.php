<?php
class Eventos{
    private $IdContacto;
    private $Titulo;
    private $Color;
    private $Fecha;
    private $IdUsuario;
    public function newEventos(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO eventos( title, color, start, end, id_usuario, id_contacto)
                   VALUES ( '$this->Titulo', '$this->Color','$this->Fecha', '$this->Fecha', '$this->IdUsuario','$this->IdContacto');";
        $this->IdAseguradoraRel = $catalogos->insertarRegistro($insert);
        if ($this->IdAseguradoraRel != null && $this->IdAseguradoraRel != 0) {
            return true;
        }
        return false;
    }

    function setIdContactos($IdContactos){
        $this->IdContactos= $IdContactos;
    }
    function setTitulo($Titulo){
        $this->Titulo= $Titulo;
    }
    function setColor($Color){
        $this->Color= $Color;
    }
    function setFecha($Fecha){
        $this->Fecha= $Fecha;
    }
    function setIdUsuario($IdUsuario){
        $this->IdUsuario= $IdUsuario;
    }
    function getIdUsuario(){
        return $this->IdUsuario;
    }
    function getFecha(){
        return $this->Fecha;
    }
    function getColor(){
        return $this->Color;
    }
    function getTitulo(){
        return $this->Titulo;
    }
    function getIdContactos(){
        return $this->IdContactos;
    }
}
?>