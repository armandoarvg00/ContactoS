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
  $same_pag="Catalogos/lista_usuarios.php";
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
   <script src="resources/js/Catalogos/usuarios.js"></script>
    <style>
        *{
            padding: 0px;
            margin:0px;
        }
    </style>
</head>
<body>
<div class="modal fade" id="Modalusuarios" tabindex="-1" aria-labelledby="Modalusuarios" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="Modalusuarios">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formusuarios" class="formusuarios" name="formusuarios"  method="post" action="/" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Nombre" class="col-form-label"><span>Nombre</span></label>
                            <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Apellido" class="col-form-label"><span>Apellido</span></label>
                            <input type="text" class="form-control" name="Apellido" id="Apellido" placeholder="Apellido" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Correo" class="col-form-label"><span>Correo</span></label>
                            <input type="text" class="form-control" name="Correo" id="Correo" placeholder="Correo" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Contrasena" class="col-form-label"><span>Contraseña</span></label>
                            <input type="text" class="form-control" name="Contrasena" id="Contrasena" placeholder="Contraseña" value="">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Username" class="col-form-label"><span>Usuario</span></label>
                            <input type="text" class="form-control" name="Username" id="Username" placeholder="Usuario" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Perfil" class="col-form-label"><span>Perfil</span></label>
                            <select name="Perfil" id="Perfil" class="form-control">
                                <option value="">Selecciona un Perfil</option>
                                <?php 
                                    $consulta_cl ="SELECT IdPerfil, NombrePerfil as Nombre from perfil;" ;
                                    $ccl= $catalogos->obtenerLista($consulta_cl);
                                    while ($rowcl = mysqli_fetch_array($ccl)) {
                                    $IdPerfil=$rowcl['IdPerfil'];
                                    $Nombre=$rowcl['Nombre'];
                                    echo ' <option value="'.$IdPerfil.'">'.$Nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <label for="Estado" class="col-form-label"><span>Estado</span></label>
                            <select name="Estado" id="Estado" class="form-control">
                                <option value="">Selecciona un Estado</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                            <!--<select id="choices-multiple-remove-button" class="Aseguradoras"  name="Aseguradoras[]" placeholder="Seleccionar Aseguradoras" multiple>
                                <?php 
                                    $consulta_cl ="SELECT IdAseguradoras, NombreA as Nombre from aseguradoras;" ;
                                    $ccl= $catalogos->obtenerLista($consulta_cl);
                                    while ($rowcl = mysqli_fetch_array($ccl)) {
                                    $IdAseguradoras=$rowcl['IdAseguradoras'];
                                    $NombreA=$rowcl['Nombre'];
                                    echo ' <option value="'.$IdAseguradoras.'">'.$NombreA.'</option>';
                                    }
                                ?>
                            </select>-->
                            <select id='pre-selected-options' multiple='multiple' placeholder="Seleccionar Aseguradoras" name="Aseguradoras[]" >
                                <?php 
                                    $consulta_cl ="SELECT IdAseguradoras, NombreA as Nombre from aseguradoras;" ;
                                    $ccl= $catalogos->obtenerLista($consulta_cl);
                                    while ($rowcl = mysqli_fetch_array($ccl)) {
                                    $IdAseguradoras=$rowcl['IdAseguradoras'];
                                    $NombreA=$rowcl['Nombre'];
                                    echo ' <option value="'.$IdAseguradoras.'">'.$NombreA.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                          
                    </div><br>
                    
                </div>
                <div class="modal-footer">
                <input type="hidden" id="accion" name="accion" >
                <input type="hidden" name="IdUsuario" id="IdUsuario" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id ="GuardarU" >Guardar</button>
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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modalusuarios" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevoU');">Agregar +</button>
    <?php }?>
    </div>
    <table id="Tusuarios" class="table table-striped" style="width:100%">
      <thead>
        <tr class='cabecera'>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th> 
            <th>Contraseña</th>
            <th>Usuario</th>  
            <th>Tipo</th> 
            <th>Estado</th> 
            <?php if ($Permisos->getModificacion()) {?>  <th></th> <?php }?>
          <?php if ($Permisos->getBaja()) {?><th></th> <?php }?> 
        </tr>
      </thead>
      <tbody>
        <?php 
          $consulta ="SELECT u.*, p.NombrePerfil from usuario as u 
          LEFT JOIN perfil as p on p.IdPerfil = u.IdPerfil $where order by estado $limit";
          $query = $catalogos->obtenerLista($consulta);
          while ($rs = mysqli_fetch_array($query)) {  
        ?> 
        <tr>
            <td><?php echo $rs['id_usuario'];?></td>
            <td><?php echo $rs['nombre'];?></td>
            <td><?php echo $rs['apellidos'];?></td>
            <td><?php echo $rs['correo'];?></td>
            <td><?php echo base64_decode($rs['pass']);?></td>
            <td><?php echo $rs['usuario'];?></td>
            <td><?php echo $rs['NombrePerfil'];?></td>
            <td><?php echo $rs['estado'];?></td>
            <?php if ($Permisos->getModificacion()) {?>  
            <td>
            <i class="bi bi-pencil-square" onclick="DatosEditar('<?php echo $rs['id_usuario'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#Modalusuarios" data-bs-whatever="@mdo"></i>
            </td>
          <?php }?>
          <?php if ($Permisos->getBaja()) {?>
          <td>
            <i class="bi bi-trash-fill" onclick="eliminar('<?php echo $rs['id_usuario'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" ></i>
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
            <th>Apellidos</th>
            <th>Correo</th> 
            <th>Contraseña</th>
            <th>Usuario</th>  
            <th>Tipo</th> 
            <th>Estado</th> 
            <?php if ($Permisos->getModificacion()) {?>  <th></th> <?php }?>
          <?php if ($Permisos->getBaja()) {?><th></th> <?php }?>
        </tr>
      </tfoot>
    </table>
  </div>
  </div>
<input type="hidden" name="id_menu" id="id_menu">
<input type="hidden" name="id_submenu" id="id_submenu">
</body>
</html>