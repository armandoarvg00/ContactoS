<?php
include_once "catalogos.class.php";
class Perfil
{
    private $IdUsuario;
    private $IdPerfil;
    private $NombrePerfil;
    private $Descripcion;
    private $Estado;
    private $UsuarioCreacion;
    private $Pantalla;
    public function getPerfil($Id)
    {
        $catalogos = new catalogos();
        $consulta  = "SELECT * from perfil WHERE IdPerfil = " . $Id;
        $query     = $catalogos->obtenerLista($consulta);
        return $query;
    }
    public function CorroborarPerfil($nombre)
    {
        $catalogos = new catalogos();
        $consulta  = "SELECT NombrePerfil FROM perfil WHERE NombrePerfil='$nombre' LIMIT 1";
        $query     = $catalogos->obtenerLista($consulta);
        if (mysqli_num_rows($query) == 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getId()
    {
        $catalogos = new catalogos();
        $consulta  = "SELECT IdPerfil, NombrePerfil, Descripcion, Estado FROM perfil WHERE IdPerfil='$this->IdPerfil'";
        $query     = $catalogos->obtenerLista($consulta);

        while ($rs = mysqli_fetch_array($query)) {
            $this->NombrePerfil = $rs['NombrePerfil'];
            $this->Descripcion  = $rs['Descripcion'];
            $this->Estado       = $rs['Estado'];
            return true;
        }
        return false;
    }
    public function newPerfil()
    {
        $catalogos = new catalogos();
        $insert    = "INSERT INTO perfil(NombrePerfil, Descripcion, Estado, UsuarioCreacion, FechaCreacion , UsuarioUltimaModificacion, FechaUltimaModificacion, Pantalla)
                    VALUES ('$this->NombrePerfil', '$this->Descripcion', '$this->Estado', '$this->UsuarioCreacion', 'NOW()' , '$this->UsuarioCreacion', 'NOW()', '$this->Pantalla' );";
        $this->IdPerfil = $catalogos->insertarRegistro($insert);
        if ($this->IdPerfil != null && $this->IdPerfil != 0) {
            return true;
        }
        return false;
    }
    public function EditPerfil()
    {
        $consulta = "UPDATE perfil SET NombrePerfil = '$this->NombrePerfil', Descripcion = '$this->Descripcion', Estado = '$this->Estado'
                     WHERE IdPerfil= '$this->IdPerfil' ";
        $catalogos = new catalogos();
        $query     = $catalogos->ejecutaConsultaActualizacion($consulta, "perfil", "WHERE IdPerfil= '$this->IdPerfil'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function DeletePerfil()
    {
        $where     = "IdPerfil= '$this->IdPerfil'";
        $tabla     = "perfil";
        $consulta  = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query     = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function setIdPerfil($IdPerfil)
    {
        $this->IdPerfil = $IdPerfil;
    }
    public function setNombrePerfil($NombrePerfil)
    {
        $this->NombrePerfil = $NombrePerfil;
    }
    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }
    public function setUsuarioCreacion($UsuarioCreacion)
    {
        $this->UsuarioCreacion = $UsuarioCreacion;
    }
    public function setPantalla($Pantalla)
    {
        $this->Pantalla = $Pantalla;
    }
    public function getPantalla()
    {
        return $this->Pantalla;
    }
    public function getUsuarioCreacion()
    {
        return $this->UsuarioCreacion;
    }
    public function getEstado()
    {
        return $this->Estado;
    }
    public function getDescripcion()
    {
        return $this->Descripcion;
    }
    public function getNombrePerfil()
    {
        return $this->NombrePerfil;
    }
    public function getIdPerfil()
    {
        return $this->IdPerfil;
    }
}
