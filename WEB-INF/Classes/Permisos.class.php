<?php 
  include_once("catalogos.class.php");
class Permisos{
    private $IdPE;
    private $IdPerfil;
    private $Idsubmenu;
    private $Alta;
    private $Baja;
    private $Consulta;
    private $Modificacion;
    private $IdMenu;
    private $Descripcion;
    public function CorroborarPermiso($id_perfil, $id_submenu){
        $catalogos = new catalogos();
        $consulta = "SELECT IdCatPerfil, IdSubMenu FROM detperfil WHERE IdCatPerfil='$id_perfil' and IdSubMenu='$id_submenu' LIMIT 1";
        $query = $catalogos->obtenerLista($consulta);
        if(mysqli_num_rows($query)==0){
            return true;
        }else{
            return false;
        }
    }
    public function get_permisos_submenu($id_user, $pagina) {
        $consulta = "SELECT
        dp.Alta,
        dp.Baja,
        dp.Consulta,
        dp.Modificacion,
        sm.RefSubmenu,
        sm.IdMenu,
        sm.IdSubmenu 
    FROM
        usuario u
        INNER JOIN detperfil dp ON u.IdPerfil = dp.IdCatPerfil
        INNER JOIN submenu sm ON sm.IdSubmenu = dp.IdSubMenu 
    WHERE
        u.id_usuario = $id_user 
        AND sm.RefSubmenu = '$pagina'";
        $catalogos = new catalogos();
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            $this->Alta = ($rs['Alta'] == "1") ? true : false;
            $this->Baja = ($rs['Baja'] == "1") ? true : false;
            $this->Consulta = ($rs['Consulta'] == "1") ? true : false;
            $this->Modificacion = ($rs['Modificacion'] == "1") ? true : false;
            $this->Idsubmenu = $rs['IdSubmenu'];
            return true;
        }
        $this->Alta = false;
        $this->Baja = false;
        $this->Consulta = false;
        $this->Modificacion = false;
        return false;
    }
    public function newPermiso(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO detperfil(IdCatPerfil, IdSubMenu, Alta, Baja, Consulta , Modificacion)
                    VALUES ('$this->IdPerfil', '$this->Idsubmenu', '$this->Alta', '$this->Baja','$this->Consulta' , '$this->Modificacion');";
        $query = $catalogos->obtenerLista($insert);
        if ($query == 1) {
            return true;
        }
    }
    
    public function EditPermiso() {
        $consulta = "UPDATE detperfil SET IdCatPerfil= '$this->IdPerfil', IdSubMenu = '$this->Idsubmenu', Alta = '$this->Alta',
                     Baja = '$this->Baja', Consulta = '$this->Consulta', Modificacion = '$this->Modificacion' 
                     WHERE IdCatPerfil= '$this->IdPerfil' and IdSubMenu = '$this->Idsubmenu'";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, "detperfil", "WHERE IdCatPerfil= '$this->IdPerfil' and IdSubMenu = '$this->Idsubmenu'");
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function DeletePermiso(){
        $where = "IdCatPerfil= '$this->IdPerfil' and IdSubMenu = '$this->Idsubmenu'";
        $tabla = "detperfil";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function getId(){
        $catalogos = new catalogos();
        $consulta = "SELECT
        p.NombrePerfil, m.Nombre as nm, sm.Nombre as nsm, sm.Descripcion, dp.IdCatPerfil,
        dp.IdSubMenu, m.IdMenu, dp.Alta,
        dp.Baja,
        dp.Consulta,
        dp.Modificacion
        FROM
        perfil AS p
        INNER JOIN detperfil AS dp ON dp.IdCatPerfil = p.IdPerfil
        INNER JOIN submenu as sm ON dp.IdSubMenu = sm.IdSubmenu
        INNER JOIN menu as m on m.IdMenu = sm.IdMenu WHERE p.IdPerfil= '$this->IdPerfil' and dp.IdSubMenu='$this->Idsubmenu'";
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            $this->Alta = $rs['Alta'] ;
            $this->Baja = $rs['Baja'] ;
            $this->Consulta = $rs['Consulta'] ;
            $this->Modificacion = $rs['Modificacion'];
            $this->IdPerfil =   $rs['IdCatPerfil'] ;
            $this->Idsubmenu =   $rs['IdSubMenu'] ;
            $this->IdMenu =   $rs['IdMenu'] ;
            $this->Descripcion =   $rs['Descripcion'] ;
            return true;
    	}
    	return false;
    }
    public function newPermisoEspecial(){
        $catalogos = new catalogos();
        $insert = "INSERT INTO DetPermisosEspeciales(IdPerfil, IdPermisoEspecial)
                    VALUES ('$this->IdPerfil', '$this->IdPermisoEspecial');";
        $query = $catalogos->obtenerLista($insert);
        if ($query == 1) {
            return true;
        }
    }
    public function DeletePermisoEspecial(){
        $where = "IdPerfil= '$this->IdPerfil'";
        $tabla = "DetPermisosEspeciales";
        $consulta = "DELETE FROM $tabla WHERE $where";
        $catalogos = new catalogos();
        $query = $catalogos->ejecutaConsultaActualizacion($consulta, $tabla, $where);
        if ($query == 1) {
            return true;
        }
        return false;
    }
    public function getIdEspeciales(){
        $catalogos = new catalogos();
        $this->IdPE= array();
        $consulta = "SELECT * from DetPermisosEspeciales
         WHERE IdPerfil= '$this->IdPerfil'";
        $query = $catalogos->obtenerLista($consulta);
        if(mysqli_num_rows($query)>0){
            while ($rs = mysqli_fetch_array($query)) {
                array_push($this->IdPE,$rs['IdPermisoEspecial']);
            }
            return true;
        }
    	return false;
    }
    public function tienePermisoE($id_perfil, $idpermisoespecial){
        $catalogos = new catalogos();
        $consulta = "SELECT * FROM
        DetPermisosEspeciales  WHERE IdPerfil= '$id_perfil' and IdPermisoEspecial='$idpermisoespecial'";
        $query = $catalogos->obtenerLista($consulta);
        while ($rs = mysqli_fetch_array($query)) {
            return true;
    	}
    	return false;
    }
    function setIdPerfil($IdPerfil){
        $this->IdPerfil= $IdPerfil;
    }
    function setIdsubmenu($Idsubmenu){
        $this->Idsubmenu= $Idsubmenu;
    }
    function setAlta($Alta){
        $this->Alta= $Alta;
    }
    function setBaja($Baja){
        $this->Baja= $Baja;
    }
    function setConsulta($Consulta){
        $this->Consulta= $Consulta;
    }
    function setModificacion($Modificacion){
        $this->Modificacion= $Modificacion;
    }
    function setIdPermisos($IdPermisos){
        $this->IdPermisos= $IdPermisos;
    }
    function setNombrePerfil($NombrePerfil){
        $this->NombrePerfil= $NombrePerfil;
    }
    function setnm($nm){
        $this->nm= $nm;
    }
    function setnsm($nsm){
        $this->nsm= $nsm;
    }
    function setIdMenu($DescrIdMenuipcion){
        $this->IdMenu= $IdMenu;
    }
    function setDescripcion($Descripcion){
        $this->Descripcion= $Descripcion;
    }
    function setIdPermisoEspecial($IdPermisoEspecial){
        $this->IdPermisoEspecial= $IdPermisoEspecial;
    }
    function getIdPermisoEspecial(){
        return $this->IdPermisoEspecial;
    }
    function getDescripcion(){
        return $this->Descripcion;
    }
    function getIdMenu(){
        return $this->IdMenu;
    }
    function getnsm(){
        return $this->nsm;
    }
    function getnm(){
        return $this->nm;
    }
    function getNombrePerfil(){
        return $this->NombrePerfil;
    }
    function getIdPermisos(){
        return $this->IdPermisos;
    }
    function getModificacion(){
        return $this->Modificacion;
    }
    function getConsulta(){
        return $this->Consulta;
    }
    function getBaja(){
        return $this->Baja;
    }
    function getAlta(){
        return $this->Alta;
    }
    function getIdsubmenu(){
        return $this->Idsubmenu;
    }
    function getIdPerfil(){
        return $this->IdPerfil;
    }
    function getIdPE(){
        return $this->IdPE;
    }
}
?>