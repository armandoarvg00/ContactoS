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
  $same_pag="Catalogos/lista_perfil.php";
  $Permisos->get_permisos_submenu($_SESSION['idusuario'], $same_pag);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    
   <script src="resources/js/Catalogos/perfil.js"></script>


    <style>
        *{
            padding: 0px;
            margin:0px;
        }
    </style>
</head>
<body>

<div class="modal fade" id="ModalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="ModalPerfil">Nuevo Puesto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formperfil" class="formperfil" name="formperfil"  method="post" action="/" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="mb-3">
              <label for="Nombre" class="col-form-label"><span></span></label>
              <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" value="">
            </div>
            <div class="mb-3">
              <label for="Descripcion" class="col-form-label"><span></span></label>
              <input type="text" class="form-control" name="Descripcion" id="Descripcion" placeholder="Descripción" value="">
            </div>
            <div class="mb-3">
              <label for="Estado" class="col-form-label"><span></span></label>
              <select name="Estado" id="Estado" class="form-control">
              <option value="">Selecciona una opción</option>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
              </select>
            </div>
            <div class="mb-3">
              <select id='pre-selected-options' multiple='multiple' placeholder="Selecciona Algun Permiso" name="PermisosEspeciales[]" >
                <?php 
                    $consulta_cl ="SELECT IdPermisosE, CONCAT(NombrePermiso, ' (', Descripcion,')') as Nombre from CatPermisosEspeciales;" ;
                    $ccl= $catalogos->obtenerLista($consulta_cl);
                    while ($rowcl = mysqli_fetch_array($ccl)) {
                    $IdPermisosE=$rowcl['IdPermisosE'];
                    $Nombre=$rowcl['Nombre'];
                    echo ' <option value="'.$IdPermisosE.'">'.$Nombre.'</option>';
                    }
                ?>
              </select>
            </div>
        </div>
        <div class="modal-footer">
        <input type="hidden" id="accion" name="accion" >

        <input type="hidden" name="IdPerfil" id="IdPerfil" value="">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id ="GuardarP" >Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
  <div class="cuadro">
    <div>
    <?php if ($Permisos->getAlta()) {?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalPerfil" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevoP');">Agregar +</button>
    <?php }?>
    </div>
    <table id="Tperfil" class="table table-striped" style="width:100%">
      <thead>
        <tr class='cabecera'>
          <th>Id</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Estado</th>  
          <?php if ($Permisos->getModificacion()) {?>  <th></th> <?php }?>
          <?php if ($Permisos->getBaja()) {?><th></th> <?php }?> 
        </tr>
      </thead>
      <tbody>
        <?php 
          $consulta ="SELECT * from perfil ";
          $query = $catalogos->obtenerLista($consulta);
          while ($rs = mysqli_fetch_array($query)) {  
        ?> 
        <tr>
          <td><?php echo $rs['IdPerfil']?></td>
          <td><?php echo $rs['NombrePerfil']?></td>
          <td><?php echo $rs['Descripcion']?></td>
          <td><?php                            
                if( $rs['Estado']==1)
                { echo "Activo";}else{ echo "Inactivo";}
              ?>
          </td>
          <?php if ($Permisos->getModificacion()) {?>  
            <td>
            <i class="bi bi-pencil-square" onclick="DatosEditar('<?php echo $rs['IdPerfil'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#ModalPerfil" data-bs-whatever="@mdo"></i>
            </td>
          <?php }?>
          <?php if ($Permisos->getBaja()) {?>
          <td>
            <i class="bi bi-trash-fill" onclick="eliminar('<?php echo $rs['IdPerfil'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" ></i>
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
          <?php if ($Permisos->getModificacion()) {?>  <th></th> <?php }?>
          <?php if ($Permisos->getBaja()) {?><th></th> <?php }?>
        </tr>
      </tfoot>
    </table>
  </div>

<input type="hidden" name="id_menu" id="id_menu">
<input type="hidden" name="id_submenu" id="id_submenu">
</body>
</html>