<?php
session_start();
if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
    header("Location: index.php");
}

error_reporting(0);
include_once "../WEB-INF/Classes/Permisos.class.php";
include_once "../WEB-INF/Classes/catalogos.class.php";
include_once "../WEB-INF/Classes/Usuario.class.php";
include_once "../WEB-INF/Classes/Menu.class.php";
$catalogos = new catalogos();
$Permisos  = new Permisos();
$same_pag  = "Catalogos/lista_aseguradoras.php";
$Permisos->get_permisos_submenu($_SESSION['idusuario'], $same_pag);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
   <script src="resources/js/Catalogos/Aseguradoras.js"></script>

    <style>
        *{
            padding: 0px;
            margin:0px;
        }


    </style>
</head>
<body>

<div class="modal fade" id="ModalAseguradoras" tabindex="-1" aria-labelledby="ModalAseguradoras" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalAseguradoras">Nueva Aseguradora</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAseguradoras" class="formAseguradoras" name="formAseguradoras"  method="post" action="/" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Nombre" class="col-form-label"><span></span></label>
                            <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Estado" class="col-form-label"><span></span></label>
                            <select name="Estado" id="Estado" class="form-control">
                                <option value="">Selecciona un Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                    </div><br>

                </div>
                <div class="modal-footer">
                <input type="hidden" id="accion" name="accion" >
                <input type="hidden" name="IdAseguradora" id="IdAseguradora" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id ="GuardarA" >Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
  <div class="cuadro">
    <div>
    <?php if ($Permisos->getAlta()) {?>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAseguradoras" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevoA');">Agregar +</button>
    <?php }?>
    </div>
    <table id="TAseguradoras" class="table table-striped" style="width:100%">
      <thead>
        <tr class='cabecera'>
            <th>Id</th>
            <th>Nombre</th>
            <th>Estado</th>
            <?php if ($Permisos->getModificacion()) {?>  <th></th> <?php }?>
          <?php if ($Permisos->getBaja()) {?><th></th> <?php }?>
        </tr>
      </thead>
      <tbody>
        <?php
$consulta = "SELECT * from aseguradoras order by NombreA";
$query    = $catalogos->obtenerLista($consulta);
while ($rs = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?php echo $rs['IdAseguradoras']; ?></td>
            <td><?php echo $rs['NombreA']; ?></td>
            <td><?php
if ($rs['Estado'] == 1) {echo "Activo";} else {echo "Inactivo";}
    ?>
          </td>
          <?php if ($Permisos->getModificacion()) {?>
            <td>
            <i class="bi bi-pencil-square" onclick="DatosEditar('<?php echo $rs['IdAseguradoras']; ?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#ModalAseguradoras" data-bs-whatever="@mdo"></i>
            </td>
          <?php }?>
          <?php if ($Permisos->getBaja()) {?>
          <td>
            <i class="bi bi-trash-fill" onclick="eliminar('<?php echo $rs['IdAseguradoras']; ?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" ></i>
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