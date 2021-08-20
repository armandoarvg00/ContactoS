<?php 
include_once("catalogos.class.php");
class Menu{
    private $IdUsuario;
    public function getPermisos($IdUsuario){
        $catalogos = new catalogos();
        $consulta ="SELECT
                    usu.nombre,
                    usu.apellidos,
                    usu.usuario,
                    p.NombrePerfil,
                    p.Descripcion,
                    sm.Nombre AS nsm,
                    sm.RefSubmenu,
                    sm.NombreManual,
                    sm.Descripcion AS dsm,
                    sm.Posicion,
                    m.Nombre AS mn,
                    m.Descripcion AS md,
                    m.Posicion,
                    m.IdMenu,
                    sm.IdSubmenu from usuario as usu 
                    Inner JOIN perfil as p on usu.IdPerfil = p.IdPerfil
                    INNER JOIN detperfil as dp on p.IdPerfil = dp.IdCatPerfil 
                    INNER JOIN submenu as sm on dp.IdSubMenu = sm.IdSubmenu
                    INNER JOIN menu as m on sm.IdMenu = m.IdMenu 
                    where usu.id_usuario = $IdUsuario
                    ORDER BY m.Posicion, sm.Posicion
                    ";
        $query = $catalogos->obtenerLista($consulta);
        return $query;
    }
}
?>