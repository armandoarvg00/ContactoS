<?php
  session_start();
  if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
      header("Location: index.php");
  }
 
  error_reporting(0);
  include_once("../WEB-INF/Classes/Permisos.class.php");
  include_once("../WEB-INF/Classes/catalogos.class.php");
  include_once("../WEB-INF/Classes/Usuario.class.php");
  include_once("../WEB-INF/Classes/Menu.class.php");
  $catalogos = new catalogos();
  $Permisos = new Permisos();
  $same_pag="Catalogos/lista_permisos.php";
  $Permisos->get_permisos_submenu($_SESSION['idusuario'], $same_pag);
  $where= "";
  $limit=" LIMIT 250";
  if(isset($_POST['datos']) and $_POST['datos']=="borrar"){
    unset($_SESSION['perfil']);
    $where='';
}
if(isset($_SESSION['perfil']) and $_SESSION['perfil']!=""){
    $where= " Where". $_SESSION['perfil'];
    $limit=" ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    
   <script src="resources/js/Catalogos/permisos.js"></script>

<!-- Tema opcional -->
    <style>
        *{
            padding: 0px;
            margin:0px;
        }
    </style>
</head>
<body>

<div class="modal fade" id="ModalPermisos" tabindex="-1" aria-labelledby="ModalPermisos" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="ModalPermisos">Nuevo Permiso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formpermisos" class="formpermisos" name="formpermisos"  method="post" action="/" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="form-group form-group-sm col-md-4 col-sm-4 col-xs-4">
                    <label for="Permiso" class="col-form-label"><span></span></label>
                    <select name="Permiso" id="Permiso" class="form-control">
                        <option value="">Selecciona un puesto</option>
                        <?php 
                        $consulta_cl ="SELECT IdPerfil, NombrePerfil as Nombre from perfil " ;
                        $ccl= $catalogos->obtenerLista($consulta_cl);
                        while ($rowcl = mysqli_fetch_array($ccl)) {
                        $autor=$rowcl['Nombre'];
                        $id=$rowcl['IdPerfil'];
                        echo ' <option value="'.$id.'">'.$autor.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group form-group-sm col-md-4 col-sm-4 col-xs-4">
                    <label for="Menu" class="col-form-label"><span></span></label>
                    <select name="Menu" id="Menu" class="form-control" onchange="cargarsub();">
                        <option value="">Selecciona un menú</option>
                        <?php 
                        $consulta_cl ="SELECT IdMenu, Nombre as Nombre from menu " ;
                        $ccl= $catalogos->obtenerLista($consulta_cl);
                        while ($rowcl = mysqli_fetch_array($ccl)) {
                        $autor=$rowcl['Nombre'];
                        $id=$rowcl['IdMenu'];
                        echo ' <option value="'.$id.'">'.$autor.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group form-group-sm col-md-4 col-sm-4 col-xs-4">
                    <label for="Submenu" class="col-form-label"><span></span></label>
                    <select name="Submenu" id="Submenu" class="form-control">
                    <option value="">Selecciona un submenú</option>
                    <?php 
                            $consulta_cl ="SELECT IdSubmenu, Nombre as Nombre from submenu " ;
                            $ccl= $catalogos->obtenerLista($consulta_cl);
                            while ($rowcl = mysqli_fetch_array($ccl)) {
                            $autor=$rowcl['Nombre'];
                            $id=$rowcl['IdSubmenu'];
                            echo ' <option value="'.$id.'">'.$autor.'</option>';
                            }
                            ?>
                    </select>
                </div>
            </div><br>
            <div class="row">
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <input class="form-check-input" type="checkbox" id="Alta" name="Alta">
                    <label class="form-check-label" for="Alta">
                        Alta
                    </label>
                </div>
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <input class="form-check-input" type="checkbox"id="Baja" name="Baja">
                    <label class="form-check-label" for="Baja">
                        Baja
                    </label>
                </div>
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <input class="form-check-input" type="checkbox" id="Consulta" name="Consulta">
                    <label class="form-check-label" for="Consulta">
                        Consulta
                    </label>
                </div>
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <input class="form-check-input" type="checkbox" id="Modificacion" name="Modificacion">
                    <label class="form-check-label" for="Modificacion">
                        Modificación
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="accion" name="accion" >
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id ="GuardarPermisos" >Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="filtros" class="filtros">
    <div class="ajustable">
        <div class="container">
            <div class="row">
                <div class="col-6 col-sm-8">
                    Selecciona un Perfil
                    <select class="form-control" placeholder="Selecciona un perfil" name="perfil" id="perfil" onchange='perfil(this.value);'>
                        <option value="">Selecciona una opción</option>
                        <?php 
                            $consulta_cl ="SELECT IdPerfil, NombrePerfil from perfil WHERE estado ='1' order by NombrePerfil;" ;
                            $ccl= $catalogos->obtenerLista($consulta_cl);
                            while ($rowcl = mysqli_fetch_array($ccl)) {
                            $id_usuario=$rowcl['IdPerfil'];
                            $NombreA=$rowcl['NombrePerfil'];
                            echo ' <option value="'.$id_usuario.'">'.$NombreA.'</option>';
                            }
                        ?>
                    </select>     
                </div>
            </div>
        </div>
    </div>
</div>
<div id="datostabla">
  <div class="cuadro">
    <div>
    <?php if ($Permisos->getAlta()) {?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalPermisos" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevoPermiso');">Agregar +</button>
    <?php }?>
    </div>
    <table id="Tpermisos" class="table table-striped" style="width:100%">
      <thead>
        <tr class='cabecera'>
          <th>Id</th>
          <th>Perfil</th>
          <th>Menú</th>
          <th>Submenú</th>   
          <th>Descripción</th>  
          <?php if ($Permisos->getModificacion()) {?>  <th></th> <?php }?>
          <?php if ($Permisos->getBaja()) {?><th></th> <?php }?>
        </tr>
      </thead>
      <tbody>
        <?php
        $contador=1; 
          $consulta ="SELECT
          p.NombrePerfil, m.Nombre as nm, sm.Nombre as nsm, sm.Descripcion, dp.IdCatPerfil, dp.IdSubMenu
            FROM
          perfil AS p
          INNER JOIN detperfil AS dp ON dp.IdCatPerfil = p.IdPerfil
          INNER JOIN submenu as sm ON dp.IdSubMenu = sm.IdSubmenu
          INNER JOIN menu as m on m.IdMenu = sm.IdMenu $where order by NombrePerfil $limit";
          $query = $catalogos->obtenerLista($consulta);
          while ($rs = mysqli_fetch_array($query)) {  
        ?> 
        <tr>
          <td><?php echo $contador; $contador++?></td>
          <td><?php echo $rs['NombrePerfil']?></td>
          <td><?php echo $rs['nm']?></td>
          <td><?php echo $rs['nsm']?></td>
          <td><?php echo $rs['Descripcion']?></td>
          <?php if ($Permisos->getModificacion()) {?>  
            <td>
            <i class="bi bi-pencil-square" onclick="DatosEditar('<?php echo $rs['IdCatPerfil'];?>', '<?php echo $rs['IdSubMenu'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#ModalPermisos" data-bs-whatever="@mdo"></i>
            </td>
          <?php }?>
          <?php if ($Permisos->getBaja()) {?>
          <td>
            <i class="bi bi-trash-fill" onclick="eliminar('<?php echo $rs['IdCatPerfil'];?>', '<?php echo $rs['IdSubMenu'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" ></i>
          </td>
          <?php }?>
        </tr>
        <?php 
          }
        ?>
      </tbody>
      <tfoot>
        <tr class='pie'>
          <th>Id</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Estado</th> 
          <?php if ($Permisos->getModificacion()) {?>  <th></th><?php }?>
          <?php if ($Permisos->getModificacion()) {?> <th></th> <?php }?>
        </tr>
      </tfoot>
    </table>
  </div>
  </div>
<input type="hidden" name="id_menu" id="id_menu">
<input type="hidden" name="id_submenu" id="id_submenu">
</body>
</html>