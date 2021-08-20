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
    $Usuario = new Usuario();
    $Usuario->setIdUsuario($_SESSION['idusuario']);
    $Usuario->getId();
    $same_pag="Contactos/lista_renovaciones.php";
    $Permisos->get_permisos_submenu($_SESSION['idusuario'], $same_pag);
    $comentarioG= $Permisos->tienePermisoE($Usuario->getPerfil(), 1);
    $Asignado= $Permisos->tienePermisoE($Usuario->getPerfil(), 2);
    $PEmitir = $Permisos->tienePermisoE($Usuario->getPerfil(), 3);
    $suarios_datos = array();
    $where= "";
    $limit=" LIMIT 250";
    $consulta_cl ="SELECT id_usuario, nombre, usuario from usuario WHERE IdPerfil= '35' and  estado ='Activo' order by Estado ;" ;
    $ccl= $catalogos->obtenerLista($consulta_cl);
    $metodoPago[''] = "Selecciona un Usuario";
    while ($rowcl = mysqli_fetch_array($ccl)) {
        $metodoPago[$rowcl['id_usuario']] = $rowcl['nombre']." (".$rowcl['usuario'].")";
    }
    if(isset($_POST['datos']) and $_POST['datos']=="borrar"){
        unset($_SESSION['Asesor']);
        unset($_SESSION['Fechas']);
        $where='';
    }
    if(isset($_SESSION['Asesor']) and $_SESSION['Asesor']!=""){
        $where= " Where". $_SESSION['Asesor'];
        $limit=" ";
    }
    if(isset($_SESSION['Fechas']) and $_SESSION['Fechas']!=""){
        if($where==""){
            $where= " Where";
        }else{
            $where.= " AND";
        }
        $where.= $_SESSION['Fechas'];
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
    <script src="resources/js/Contactos/Renovacion.js"></script>
    <style>
        *{
            padding: 0px;
            margin:0px;
        }
.comentario_gerente{
    float:left;
    background-color: white;
    top: 15px;
    text-align: center;
    border-radius:0px!important;
    width: 150px;
    left:0px ;
    -webkit-box-shadow: 0px 0px 9px -2px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 9px -2px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 9px -2px rgba(0,0,0,0.75);
    display: none;
    cursor: pointer;
}
.coment{
    resize: none;
    margin-top: 5px;
    position: all;
    width: 130px!important;
    height: auto;
    min-width: 93px;
    min-height: 60px;  
}
.datos{
    width: 100px;
    font-size: 10px;
}
.emitir{
    width: 130px;
    height: 30px;
    font-size: 11px;
}
    </style>
</head>
<body>
<div class="modal fade" id="Modalcvn" tabindex="-1" aria-labelledby="Modalcvn" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="Modalcvn">Nueva Renovación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formContactos" class="formcvn" name="formcvn"  method="post" action="/" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Nombre" class="col-form-label"><span>Nombre</span></label>
                            <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Correo" class="col-form-label"><span>Correo</span></label>
                            <input type="text" class="form-control" name="Correo" id="Correo" placeholder="Correo" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Telefono" class="col-form-label"><span>Teléfono</span></label>
                            <input type="text" class="form-control" name="Telefono" id="Telefono" placeholder="Teléfono" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="CP" class="col-form-label"><span>Código Postal</span></label>
                            <input type="text" class="form-control" name="CP" id="CP" placeholder="Código Postal" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Marca" class="col-form-label"><span>Marca</span></label>
                            <input type="text" class="form-control" name="Marca" id="Marca" placeholder="Marca" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Anio" class="col-form-label"><span>Año</span></label>
                            <input type="text" class="form-control" name="Anio" id="Anio" placeholder="Año" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Version" class="col-form-label"><span>Versión</span></label>
                            <input type="text" class="form-control" name="Version" id="Version" placeholder="Versión" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-6 col-sm-6 col-xs-6">
                            <label for="Edad" class="col-form-label"><span>Edad de Conductor</span></label>
                            <input type="text" class="form-control" name="Edad" id="Edad" placeholder="Edad" value="">
                        </div>
                    </div> <br>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-2 col-sm-2 col-xs-2">
                            <label class="form-check-label" for="Chat">
                            <i class="bi bi-chat-dots-fill" title="Chat" style="font-size: 2rem; color: #0d6efd; cursor:pointer;"></i>
                            </label>
                            <input class="form-check-input" value="Chat" type="radio" id="Chat" name="Medio">
                        </div>
                        <div class="form-group form-group-sm col-md-2 col-sm-2 col-xs-2">
                            <label class="form-check-label" for="CCorreo">
                            <i class="bi bi-envelope" title="Correo" style="font-size: 2rem; color: #0d6efd; cursor:pointer;" ></i>
                            </label>
                            <input class="form-check-input" value="Correo"  type="radio" id="CCorreo" name="Medio">

                        </div>
                        <div class="form-group form-group-sm col-md-2 col-sm-2 col-xs-2">
                            <label class="form-check-label" for="Impreso">
                            <i class="bi bi-printer"  title="Impreso" style="font-size: 2rem; color: #0d6efd; cursor:pointer;"></i>
                            </label>
                            <input class="form-check-input" type="radio" value="Impreso"  id="Impreso" name="Medio">

                        </div>
                        <div class="form-group form-group-sm col-md-2 col-sm-2 col-xs-2">
                            <label class="form-check-label" for="Messenger">
                            <i class="bi bi-messenger"   title="Messenger" style="font-size: 2rem; color: #0d6efd; cursor:pointer;" ></i>
                            </label>
                            <input class="form-check-input" type="radio" value="Messenger" id="Messenger" name="Medio">
                        </div>
                        <div class="form-group form-group-sm col-md-2 col-sm-2 col-xs-2">
                            <label class="form-check-label" for="Llamada">
                            <i class="bi bi-telephone-outbound"   title="Llamada" style="font-size: 2rem; color: #0d6efd; cursor:pointer;" ></i>
                            </label>
                            <input class="form-check-input" type="radio" value="Llamada" id="Llamada" name="Medio">

                        </div>
                        <div class="form-group form-group-sm col-md-2 col-sm-2 col-xs-2">
                            <label class="form-check-label" for="Referido">
                            <i class="bi bi-people-fill"  title="Contacto Referido" style="font-size: 3rem; color: #0d6efd; cursor:pointer;" ></i>
                            </label>
                            <input class="form-check-input" type="radio" value="Referido"  id="Referido" name="Medio">

                        </div>
                    </div>
                    <br>
                    
                </div>
                <div class="modal-footer">
                <input type="hidden" id="accion" name="accion" >
                <input type="hidden" name="IdContacto" id="IdContacto" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id ="GuardarA" >Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="Modalagendar" tabindex="-1" aria-labelledby="Modalagendar" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="Modalagendar">Agendar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEvento" class="formcvn" name="formcvn" method="post" action="/" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-12 col-sm-12 col-xs-12">
                            <label for="Nombre" class="col-form-label"><span>Titulo</span></label>
                            <input type="text" class="form-control" name="Titulo" id="Titulo" placeholder="Titulo" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-12 col-sm-12 col-xs-12">
                            <label for="Color" class="col-form-label"><span>Color</span></label>
                            <select name="Color" class="form-control" id="Color">
                                <option value="">Seleccionar</option>
                                <option style="color:#0071c5;" value="#0071c5"> Azul oscuro</option>
                                <option style="color:#40E0D0;" value="#40E0D0"> Turquesa</option>
                                <option style="color:#008000;" value="#008000"> Verde</option>						  
                                <option style="color:#FFD700;" value="#FFD700">Amarillo</option>
                                <option style="color:#FF8C00;" value="#FF8C00"> Naranja</option>
                                <option style="color:#FF0000;" value="#FF0000"> Rojo</option>
                                <option style="color:#000;" value="#000"> Negro</option>
						    </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-12 col-sm-12 col-xs-12">
                        <label for="Fecha" class="col-form-label"><span>Fecha </span></label>
                            <input type="datetime-local" name="Fecha" class="form-control" id="Fecha" value ="">
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="IdContactoE" id="IdContactoE" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id ="GuardarE" onclick="AgregarEvento()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="filtros" class="filtros">
    <div class="ajustable">
        <div class="container">
            <div class="row">
                <div class="col-6 col-sm-4">
                    Selecciona un Usuario
                    <select class="form-control" placeholder="Seleccionar Asesor" name="asesores" id="asesores" onchange='asesores(this.value);'>
                        <option value="">Selecciona una opción</option>
                        <?php 
                            $consulta_cl ="SELECT id_usuario, CONCAT(nombre,' ', usuario) as usuarios from usuario WHERE IdPerfil= '35' and  estado ='Activo' order by nombre;" ;
                            $ccl= $catalogos->obtenerLista($consulta_cl);
                            while ($rowcl = mysqli_fetch_array($ccl)) {
                            $id_usuario=$rowcl['id_usuario'];
                            $NombreA=$rowcl['usuarios'];
                            echo ' <option value="'.$id_usuario.'">'.$NombreA.'</option>';
                            }
                        ?>
                    </select>     
                </div>
                <div class="col-6 col-sm-3">
                    Fecha Inicial<input type="date" name="FechaI" id="FechaI" class="form-control" ></div>
                <div class="col-6 col-sm-3">
                    Fecha Final<input type="date" name="FechaF" id="FechaF" class="form-control"  onchange="FechaF(this.value)">
                </div>
                <div class="col-6 col-sm-1">
                   <a href="Contactos/exportar_re.php"><i class="bi bi-file-earmark-text-fill" style="margin-left:0px; font-size: 2rem; color: white; cursor:pointer;" title="Descargar Excel"></a></i>
                </div>
                <div class="col-6 col-sm-1">
                    <a href="Contactos/exportar_pdfre.php" target="_blank"> <i class="bi bi-file-earmark-pdf-fill" style="margin-left:0px; font-size: 2rem; color: white; cursor:pointer;" title="Descargar PDF"></a></i>                
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cuadro">
<div id="datostabla">
    
    <div>
        <?php if ($Permisos->getAlta()) {?>
       <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modalcvn" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevo');">Agregar +</button>-->
    <?php }?>
    </div>
    <table id="TContactos" class="table table-striped" style="width:100%">
                <thead>
                    <tr class='cabecera'>
                        <th>Id</th>
                        <th>No.Poliza</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Télefono</th>
                        <th>Vigencia</th>
                        <th>Póliza</th>
                        <th>Prima neta</th>
                        <th>Forma pago</th>
                        <th>Emitir</th>
                        <?php if($comentarioG){?>
                        <th>Gerencia</th>
                        <?php }?>
                        <th>Compañia</th>
                        <th>Negocio</th><?php //Gerente ?>
                        <th>Asignado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $consulta ="SELECT renov.*, u.nombre as asesor FROM renovacion as renov 
                         inner join usuario as u on u.id_usuario= renov.id_usuario 
                         $where
                          order by vigencia desc $limit";
                        $query = $catalogos->obtenerLista($consulta);
                        while ($rs = mysqli_fetch_array($query)) {
                           ?> 
                           <tr>
                                <td>
                                    <?php echo $rs['id_renovacion'];?>            
                                    <?php if ($Permisos->getModificacion()) {?>  
                                       <!-- <i class="bi bi-pencil-square" title="Editar" onclick="DatosEditar('<?php echo $rs['id_renovacion'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#Modalcvn" data-bs-whatever="@mdo"></i>-->
                                    <?php }?>
                                    <?php if ($Permisos->getBaja()) {?>
                                        <i class="bi bi-trash-fill" title="Eliminar" onclick="eliminar('<?php echo $rs['id_renovacion'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" ></i>
                                    <?php }?>
                                    <i class="bi bi-journal-album" title="Agendar" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#Modalagendar" data-bs-whatever="@mdo" onclick="SetIdcontacto('<?php echo $rs['id_renovacion'];?>');"></i>
                                    <?php if ($rs['comentario_de_gerente']!="") {?>
                                        <i class="i bi-exclamation-triangle" title="Mensaje de gerente" onclick="myFunction(<?php echo $rs['id_renovacion'];?>)" style="font-size: 1rem; color: red; cursor:pointer;" ></i>
                                    <?php }?>
                                    <div class="comentario_gerente" id="myDIV<?php echo $rs['id_renovacion'];?>">
                                        <textarea readonly onclick="myFunctioncerrar(<?php echo $rs['id_renovacion'];?>)"><?php echo $rs['comentario_de_gerente'];?></textarea>
                                    </div>
                                </td>
                                <td><?php echo $rs['no_poliza'];?></td>
                                <td><?php echo $rs['nombre'];?></td>
                                <td><?php echo $rs['correo'];?></td>
                                <td><?php echo $rs['telefono'];?></td>
                                <td><?php echo $rs['vigencia'];?></td>
                                <td>
                                    <a href="../Polizas/<?php echo $anioahora."/polizas/".$rs['no_poliza']."/".$rs['poliza'];?>" target="_blank">Ver</a></td>
                                </td>
                                <td><?php echo $rs['prima_neta'];?></td>
                                <td><?php echo $rs['forma_de_pago'];?></td>
                                <td>
                                    <?php if ($Permisos->getConsulta()) {?>
                                        <select  name="Estatus" class="form-select emitir" onchange="CambiarEmitir('<?php echo $rs['id_renovacion'];?>',this.value);">
                                        <option value="">Selecciona una opcion</option>
                                        <?php 
                                        $emitir=0;
                                        $falso=0;
                                        $duplicado=0;
                                        $otro=0;
                                        $contactado=0;
                                        $nocontactado=0;
                                        if ($rs['contactado']==3){$emitir="selected";}
                                        if ($rs['contactado']==6){$falso="selected";}
                                        if ($rs['contactado']==4){$duplicado="selected";}
                                        if ($rs['contactado']==2){$otro="selected";}
                                        if ($rs['contactado']==5){$contactado="selected";}
                                        if ($rs['contactado']==1){$nocontactado="selected";}
                                        ?>
                                            <option value="3" <?php echo $emitir?>>Emitir</option>
                                        <optgroup label="No viable">
                                            <option value="6" <?php echo $falso?>>Falso</option>
                                            <option value="4" <?php echo $duplicado?>>Duplicado</option>
                                            <option value="2" <?php echo $otro?>>Otro</option>
                                        </optgroup>
                                        <optgroup label="Seguimiendo">
                                            <option value="5" <?php echo $contactado?>>Contactado</option>
                                            <option value="1" <?php echo $nocontactado?>>No Contactado</option>
                                        </optgroup>
                                        </select>
                                        <textarea name='msjasesor' class='coment' id='msjasesor' ondblclick="GMA('<?php echo $rs['id_renovacion'];?>',this.value);"><?php
                                            echo $rs['comentario_renovacion'];
                                            ;?>
                                            </textarea>
                                            
                                    <?php }else{echo "prueba";}?>
                                </td>
                                <?php if($comentarioG){?>
                                <td> 
                                    <textarea name='msgerencia' class='coment' id='msgerencia' ondblclick="GMG('<?php echo $rs['id_renovacion'];?>',this.value);">
                                        <?php echo $rs['comentario_de_gerente'];?>
                                    </textarea>
                                </td>  
                                                                <?php }?>

                                <td><?php echo $rs['compania']?></td>
                                <td><?php echo $rs['negocio']?></td>
                                <td>
                                    <select name="Usuario" class="form-select datos" aria-label="Default select example" id="Usuario" class="form-control" onchange="cambiarUser('<?php echo $rs['id_renovacion'];?>',this.value)">
                                        <?php 
                                        foreach ($metodoPago as $key => $value) {
                                            $s = "";
                                            if ($key == $rs['id_usuario']) {
                                                $s = "selected='selected'";
                                            }
                                            echo "<option value='$key' $s>$value</option>";
                                        }?>
                                    </select> 
                                </td>
                            </tr>
                           <?php 
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr class='pie'>
                        <th>Id</th>
                        <th>No.Poliza</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Télefono</th>
                        <th>Vigencia</th>
                        <th>Póliza</th>
                        <th>Prima neta</th>
                        <th>Forma pago</th>
                        <th>Emitir</th>
                        <?php if($comentarioG){?>
                        <th>Gerencia</th>
                        <?php }?>
                        <th>Compañia</th>                    
                        <th>Negocio</th><?php //Gerente ?>
                        <th>Asignado</th>
                    </tr>
                </tfoot>
            </table>
    </div>
    </div>
   <script>//Código de luis
    function myFunction(contador){
        let i= document.getElementById('myDIV'+contador);
        i.style.display = "block";
        }
        function myFunctioncerrar(contador){
            let i= document.getElementById('myDIV'+contador);
            i.style.display = "none";
        }// Fin Código de luis
   </script>
</body>
</html>