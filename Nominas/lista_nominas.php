<?php
    session_start();
    if ((!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")){ 
        header("Location: index.php");
    }
    $where="";
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
    $same_pag="Contactos/lista_cobranza.php";
    $Permisos->get_permisos_submenu($_SESSION['idusuario'], $same_pag);
    $comentarioG= $Permisos->tienePermisoE($Usuario->getPerfil(), 1);
    $Asignado= $Permisos->tienePermisoE($Usuario->getPerfil(), 2);
    $PEmitir = $Permisos->tienePermisoE($Usuario->getPerfil(), 3);
    $suarios_datos = array();
    $where= "";
    $whereE="";
    $limit=" LIMIT 10";
    $consulta_cl ="SELECT id_usuario, nombre, usuario from usuario /*WHERE Tipo= 'Venta Nueva'*/ order by Estado ;" ;
    $ccl= $catalogos->obtenerLista($consulta_cl);
    $metodoPago[''] = "Selecciona un Usuario";
    while ($rowcl = mysqli_fetch_array($ccl)) {
        $metodoPago[$rowcl['id_usuario']] = $rowcl['nombre']." (".$rowcl['usuario'].")";
    }
    if(isset($_POST['datos']) and $_POST['datos']=="borrar"){
        unset($_SESSION['perfil']);
        unset($_SESSION['Asesor']);
        unset($_SESSION['Fechas']);
        unset($_SESSION['FechaI']);
        $where='';
    }
    if(isset($_SESSION['perfil']) and $_SESSION['perfil']!=""){
        $where= " AND". $_SESSION['perfil'];
        $limit=" LIMIT 200";
        $whereE=$where;
        $whereF=$where;
    }
    if(isset($_SESSION['Asesor']) and $_SESSION['Asesor']!=""){
        $where.= " AND". $_SESSION['Asesor'];
        $limit=" ";
        $whereE=$where;
        $whereF=$where;
    }
    if(isset($_SESSION['FechaI']) and $_SESSION['FechaI']!="" ){
        $whereE=" AND".$_SESSION['FechaI'].$where;
        //$limit=" "; 
    }
    if(isset($_SESSION['FechaFf']) and $_SESSION['FechaFf']!="" ){
        $whereF=" AND".$_SESSION['FechaFf'].$where;
        //$limit=" "; 
    }
    if(isset($_SESSION['Fechas']) and $_SESSION['Fechas']!=""){
        $where.= " AND".$_SESSION['Fechas'];
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
    <script src="resources/js/Nominas/nominas.js"></script>
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
            <h5 class="modal-title" id="Modalcvn">Datos Cobranza</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formContactos" class="formcvn" name="formcvn"  method="post" action="/" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="NoPoliza" class="col-form-label"><span>Póliza</span></label>
                            <input type="text" class="form-control" name="NoPoliza" id="NoPoliza" placeholder="NoPoliza" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Serie" class="col-form-label"><span>Serie</span></label>
                            <input type="text" class="form-control" name="Serie" id="Serie" placeholder="Serie" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Nombre" class="col-form-label"><span>Nombre</span></label>
                            <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Correo" class="col-form-label"><span>Correo</span></label>
                            <input type="text" class="form-control" name="Correo" id="Correo" placeholder="Correo" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Telefono" class="col-form-label"><span>Télefono</span></label>
                            <input type="text" class="form-control" name="Telefono" id="Telefono" placeholder="Télefono" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Registro" class="col-form-label"><span>Registro</span></label>
                            <input type="date-time" class="form-control" name="Registro" id="Registro" placeholder="Registro" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Vigencia" class="col-form-label"><span>Vigencia</span></label>
                            <input type="date" class="form-control" name="Vigencia" id="Vigencia" placeholder="Vigencia" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Proximo" class="col-form-label"><span>Próximo pago</span></label>
                            <input type="date" class="form-control" name="Proximo" id="Proximo" placeholder="Proximo" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Fechapago" class="col-form-label"><span>Fecha de Pago</span></label>
                            <input type="date" class="form-control" name="Fechapago" id="Fechapago" placeholder="Fecha de pago" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Aseguradora" class="col-form-label"><span>Aseguradora</span></label>
                            <input type="text" class="form-control" name="Aseguradora" id="Aseguradora" placeholder="Aseguradora" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Fpago" class="col-form-label"><span>Forma de pago</span></label>
                            <input type="text" class="form-control" name="Fpago" id="Fpago" placeholder="Fpago" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Pneta" class="col-form-label"><span>Prima Neta</span></label>
                            <input type="text" class="form-control" name="Pneta" id="Pneta" placeholder="Pneta" value="">
                        </div>
                    </div>
         
                
                    <br>
                    
                </div>
                <div class="modal-footer">
                <input type="hidden" name="IdVentas" id="IdVentas" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
               <!-- <button type="button" class="btn btn-primary" id ="GuardarA" >Guardar</button>-->
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

<div class="modal fade" id="Modalrex" tabindex="-1" aria-labelledby="Modalrex" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="Modalrex">Reexpedición de Póliza </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formReexpedicion" class="formcvn" name="formReexpedicion"  method="post" action="/" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Persona" id="Fisica" value="Fisica">
                                <label class="form-check-label" for="Fisica">Fisica</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Persona" id="Moral" value="Moral">
                                <label class="form-check-label" for="Moral">Moral</label>
                            </div>
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Nopoliza" class="col-form-label"><span>Número de póliza</span></label>
                            <input type="text" class="form-control" name="Nopoliza" id="Nopoliza" placeholder="Número de póliza" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="NoSerie" class="col-form-label"><span>Número de serie</span></label>
                            <input type="text" class="form-control" name="NoSerie" id="NoSerie" placeholder="Número de serie" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="NombreR" class="col-form-label"><span>Nombre</span></label>
                            <input type="text" class="form-control" name="NombreR" id="NombreR" placeholder="Nombre" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Apaterno" class="col-form-label"><span>Apellido Paterno</span></label>
                            <input type="text" class="form-control" name="Apaterno" id="Apaterno" placeholder="Apellido Paterno" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Amaterno" class="col-form-label"><span>Apellido Materno</span></label>
                            <input type="text" class="form-control" name="Amaterno" id="Amaterno" placeholder="Apellido Materno" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Placas" class="col-form-label"><span>Placas</span></label>
                            <input type="text" class="form-control" name="Placas" id="Placas" placeholder="Placas" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="CorreoEE" class="col-form-label"><span>Correo Electrónico</span></label>
                            <input type="text" class="form-control" name="CorreoEE" id="CorreoEE" placeholder="Correo" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="CorreoEE" class="col-form-label"><span>Correo Electrónico (Opc)</span></label>
                            <input type="text" class="form-control" name="CorreoEEo" id="CorreoEEo" placeholder="orreo Electrónico (Opc)" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Aseguradora" class="col-form-label"><span>Teléfono</span></label>
                            <input type="text" class="form-control" name="Tel" id="Tel" placeholder="Teléfono" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Fpago" class="col-form-label"><span>Teléfono (Opc)</span></label>
                            <input type="text" class="form-control" name="Telo" id="Telo" placeholder="Teléfono (Opc)" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Aseguradora" class="col-form-label"><span>Aseguradora</span></label>
                            <select class="form-control" placeholder="Seleccionar Aseguradora" name="Aseguradoras" >
                                <option value="">Selecciona una opción</option>
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
                    </div>
                    <div class="row">
            
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Pneta" class="col-form-label"><span>Fecha de registro</span></label>
                            <input type="date-time" class="form-control" name="FechaRegistro" id="FechaRegistro" placeholder="Fecha de registro" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly>
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="VigenciaR" class="col-form-label"><span>Fecha de registro</span></label>
                            <input type="date" class="form-control" name="VigenciaR" id="VigenciaR" placeholder="Vigencia" value="" >
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Estatus" id="Estatus" value="Pendiente">
                                <label class="form-check-label" for="Estatus">Pendiente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Estatus" id="Pagado" value="Pagado">
                                <label class="form-check-label" for="Moral">Pagado</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Negocio" class="col-form-label"><span>Negocio</span></label>
                            <select name="negocio" id="lista1" class="form-control" onchange="TipoNegocio(this.value);">
                                <option value="0">Selecciona una opción</option>
                                <option value="Autos">Autos</option>
                                <option value="Motos">Motos</option>
                                <option value="Equipo Pesado">Equipo Pesado</option>
                                <option value="Pick Ups">Pick Ups</option>
                                <option value="5">Gastos Medicos</option>
                                <option value="6">Vida</option>
                            </select>                         
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="tiponegocio" class="col-form-label"><span>Tipo de negocio</span></label>
                            <select name="tiponegocio" id="tiponegocio" class="form-control">
                                <option value="0">Selecciona una opcion</option>
                            </select>  
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="FormaPago" class="col-form-label"><span>Forma de Pago</span></label>
                            <select name="forma_pago" placeholder="" class="form-control" id="forma_pago" onclick="forma_pago()" required>
                            <option value="">Selecciona una opción</option>
                            <option value="Mensual">Mensual</option>
                            <option value="Bimestral">Bimestral</option>
                            <option value="Trimestral">Trimestral</option>
                            <option value="Semestral">Semestral</option>
                            <option value="Contado">Contado</option>
                        </select>                        
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="PNT" class="col-form-label"><span>Prima Neta Total</span></label>
                            <input type="text" class="form-control" name="PNT" id="PNT" placeholder="Prima Neta Total" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="PN" class="col-form-label"><span>Prima Neta </span></label>
                            <input type="text" class="form-control" name="PN" id="PN" placeholder="Prima Neta" value="">
                        
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Descuento" class="col-form-label"><span>Descuento</span></label>
                            <input type="text" class="form-control" name="Descuento" id="Descuento" placeholder="Descuento" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Spoliza" class="col-form-label"><span>Subir Póliza</span></label>
                            <input type="file" class="form-control" name="Spoliza" id="Spoliza" placeholder="Subir Póliza" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Fotos" class="col-form-label"><span>Fotos</span></label>
                            <input type="file" class="form-control" name="Fotos" id="Fotos[]" multiple=""placeholder="Subir Póliza" value="">
                        </div>
                        <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="MP" class="col-form-label"><span>Método de Pago</span></label>
                                <select name="MP" id="MP" class="form-control" placeholder="Metodo de Pago">
                                <option value="">Selecciona una opción</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>                       
                        </div>
                        
                    </div>
                    <div class="row">
                    <div class="form-group form-group-sm col-md-4 col-sm-6 col-xs-4">
                            <label for="Comentarios" class="col-form-label"><span>Comentarios </span></label>
                            <input type="text" class="form-control" name="Comentarios" id="Comentarios" placeholder="Comentarios" value="">
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
<div id="filtros" class="filtros">
    <div class="ajustable100">
        <div class="container">
            <div class="row">
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <label for="perfil">Selecciona un perfil</label>
                    <?php if ($Permisos->getAlta()) {?>
                        <select class="form-control" placeholder="Seleccionar Perfil" name="perfil" onchange="Perfiles(this.value);">
                            <option value="">Selecciona una opción</option>
                            <?php 
                                $consulta_cl ="SELECT IdPerfil, NombrePerfil from perfil order by NombrePerfil;" ;
                                $ccl= $catalogos->obtenerLista($consulta_cl);
                                while ($rowcl = mysqli_fetch_array($ccl)) {
                                $IdPerfil=$rowcl['IdPerfil'];
                                $perfil=$rowcl['NombrePerfil'];
                                echo ' <option value="'.$IdPerfil.'">'.$perfil.'</option>';
                                }
                            ?>
                        </select>           
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modalcvn" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevo');">Agregar +</button>-->
                    <?php }?>
                </div>
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <?php if ($Permisos->getAlta()) {?>
                        <label for="asesores">Selecciona un Usuario</label>
                        <select class="form-control" placeholder="Seleccionar Asesor" name="asesores" id="asesores" onchange='asesores(this.value);'>
                            <option value="">Selecciona una opción</option>
                            <?php 
                                $consulta_cl ="SELECT id_usuario, CONCAT(nombre,' ', usuario) as usuarios from usuario order by nombre;" ;
                                $ccl= $catalogos->obtenerLista($consulta_cl);
                                while ($rowcl = mysqli_fetch_array($ccl)) {
                                $id_usuario=$rowcl['id_usuario'];
                                $NombreA=$rowcl['usuarios'];
                                echo ' <option value="'.$id_usuario.'">'.$NombreA.'</option>';
                                }
                            ?>
                        </select>           
                    <?php }?>
                </div>
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <?php if ($Permisos->getAlta()) {?>
                        <label for="FechaI">Rango inicial de fecha de pago</label>
                        <input type="date" name="FechaI" id="FechaI" class="form-control">
                    <?php }?>
                </div>
                <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
                    <?php if ($Permisos->getAlta()) {?>
                        <label for="FechaF">Rango final de fecha de pago</label>
                        <input type="date" name="FechaF" id="FechaF" class="form-control" onchange="FechaF(this.value)">
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="datostabla">
<div class="cuadro">
    <div class="row center">
        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
            <?php if ($Permisos->getAlta()) {?>
                Emitido    
                <?php 
                    $consulta ="SELECT SUM(prima_neta) as Emitido FROM ventas as ventas 
                    inner join usuario as usu on usu.id_usuario = ventas.id_usuario 
                    Where 1='1' $whereE";
                        $query = $catalogos->obtenerLista($consulta);
                        while ($rs = mysqli_fetch_array($query)) {
                            $emitido = $rs['Emitido'];
                            echo "<p>$".round($emitido,2)."</p>";
                        }
                ?>  
                

             <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modalcvn" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevo');">Agregar +</button>-->
            <?php }?>
        </div>
        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
            <?php if ($Permisos->getAlta()) {?>
               Pagado 
               <?php 
                     $consulta ="SELECT SUM(prima_neta) Emitido FROM ventas as ventas 
                     inner join usuario as usu on usu.id_usuario = ventas.id_usuario 
                     Where fecha_pago!='0001-01-01' and revisado ='1' $whereF;

                         ";
                        $query = $catalogos->obtenerLista($consulta);
                        while ($rs = mysqli_fetch_array($query)) {
                            $emitido = $rs['Emitido'];
                            echo "<p>$".round($emitido,2)."</p>";
                        }
                ?>         
             <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modalcvn" data-bs-whatever="@mdo" onclick="cambiaraccion('nuevo');">Agregar +</button>-->
            <?php }?>
        </div>
        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
          Aceptado
          <?php 
                     $consulta ="SELECT SUM(prima_neta) as Emitido FROM ventas as ventas 
                     inner join usuario as usu on usu.id_usuario = ventas.id_usuario 
                     Where fecha_pago!='0001-01-01' and usu.tipo='$tipo_usuario' and (revisado ='1') and 
                     $where Limit 10
                         ";
                        $query = $catalogos->obtenerLista($consulta);
                        while ($rs = mysqli_fetch_array($query)) {
                            $emitido = $rs['Emitido'];
                            echo "<p>$".round($emitido,2)."</p>";
                        }
                ?>  
        </div>
        <div class="form-group form-group-sm col-md-3 col-sm-3 col-xs-3">
            
        </div>
        <br>
    </div>
   
    <div id="datostabla">
    <table id="TVentas" class="table table-striped" style="width:100%">
        <thead>
            <tr class='cabecera'>
                        <th>Id C</th>
                        <th># Póliza</th>
                        <th>Nombre</th>
                        <th>Télefono</th>
                        <th>Registro</th>
                        <th>Vigencia</th>
                        <th>Prox. Pago</th>
                        <th>Póliza</th>
                        <th>Fotos</th>
                        <th>Fecha Pago</th>
                        <th>Aseguradora</th>
                       
                        <th>Forma Pago</th>
                        <th>Prima Neta</th><?php //Gerente ?>
                        <th>Asignado</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $consulta ="SELECT ventas.*, usu.nombre as nasesor,usu.tipo FROM ventas as ventas 
                         inner join usuario as usu on usu.id_usuario = ventas.id_usuario 
                         WHERE 
                         ventas.estado != 'cancelado' 
                         $where
                          order by fecha_pago $limit";
                        $query = $catalogos->obtenerLista($consulta);
                        if(mysqli_num_rows($query)>0){
                        while ($rs = mysqli_fetch_array($query)) {
                           ?> 
                           <tr>
                                <td>
                                    <?php echo $rs['id_contactos'];?>     
                                    <i class="bi bi-arrow-repeat" title="Reexpedición de póliza" onclick="GenerarP('<?php echo $rs['id_contactos'];?>', 'nuevo')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#Modalrex" data-bs-whatever="@mdo"></i>
       
                                    <?php if ($Permisos->getModificacion()) {?>  
                                      <i class="bi bi-pencil-square" title="Editar" onclick="DatosEditar('<?php echo $rs['id_ventas'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#Modalcvn" data-bs-whatever="@mdo"></i>
                                    <?php }?>
                                    <?php if ($Permisos->getBaja()) {?>
                                        <i class="bi bi-trash-fill" title="Eliminar" onclick="eliminar('<?php echo $rs['id_ventas'];?>')" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" ></i>
                                    <?php }?>
                                    <i class="bi bi-journal-album" title="Agendar" style="font-size: 1rem; color: cornflowerblue; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#Modalagendar" data-bs-whatever="@mdo" onclick="SetIdcontacto('<?php echo $rs['id_ventas'];?>');"></i>
                                    <?php if ($rs['comentario_de_gerente']!="") {?>
                                        <i class="bi bi-exclamation-triangle" title="Mensaje de gerente" onclick="myFunction(<?php echo $rs['id_ventas'];?>)" style="font-size: 1rem; color: red; cursor:pointer;" ></i>
                                    <?php }?>
                                    
                                    <div class="comentario_gerente" id="myDIV<?php echo $rs['id_ventas'];?>">
                                        <textarea readonly onclick="myFunctioncerrar(<?php echo $rs['id_ventas'];?>)"><?php echo $rs['comentario_de_gerente'];?></textarea>
                                    </div>
                                </td>
                                <td><?php echo $rs['no_poliza'];?></td>
                                <td><?php echo $rs['nombre'];?></td>
                                <td><?php echo $rs['telefono'];?></td>
                                <td><?php echo $rs['registrof'];?></td>
                                <td><?php echo $rs['vigencia'];?></td>
                                <td><?php echo $rs['vigencia2'];?></td>
                                <td>
                                    <a href="../Polizas/<?php echo $anioahora."/polizas/".$rs['no_poliza']."/".$rs['poliza'];?>" target="_blank">Ver</a></td>
                                </td>
                                <td><?php  if($rs['foto1']!=""){?>
                                    <a href="<?php echo "../Polizas/".$anioahora."/polizas/".$rs['no_poliza']."/".$rs['foto1'];?>" target="_blank" >1</a>
                                    <a href="<?php echo "../Polizas/".$anioahora."/polizas/".$rs['no_poliza']."/".$rs['foto2'];?>" target="_blank" >2</a>
                                    <a href="<?php echo "../Polizas/".$anioahora."/polizas/".$rs['no_poliza']."/".$rs['foto3'];?>" target="_blank" >3</a>
                                    <a href="<?php echo "../Polizas/".$anioahora."/polizas/".$rs['no_poliza']."/".$rs['foto4'];?>" target="_blank" >4</a>
                                    <a href="<?php echo "../Polizas/".$anioahora."/polizas/".$rs['no_poliza']."/".$rs['foto5'];?>" target="_blank" >5</a>
                                <?php 
                                    }?>
                                </td>
                                <td><input type="date" class="form-control datos" name="fecha" id="fecha" ondblclick="AsignarFeP('<?php echo $rs['id_ventas'];?>',this.value);"></td>
                                <td><?php echo $rs['compania']?>
                                </td>
                  
                                <td><?php echo $rs['forma_de_pago']?></td>
                                <td><?php echo number_format($rs['prima_neta'],2)?></td>
                                <td><?php echo $rs['nasesor']?></td>

                            </tr>
                           <?php 
                        } unset($_SESSION['Where']); 
                    }else{
                            unset($_SESSION['Where']); 
                        }
                    ?>
                    
                </tbody>
                <tfoot>
                    <tr class='pie'>
                        <th>Id C</th>
                        <th># Póliza</th>
                        <th>Nombre</th>
                        <th>Télefono</th>
                        <th>Registro</th>
                        <th>Vigencia</th>
                        <th>Prox. Pago</th>
                        <th>Póliza</th>
                        <th>Fotos</th>
                        <th>Fecha Pago</th>
                        <th>Aseguradora</th>
                        
                        <th>Forma Pago</th>
                        <th>Prima Neta</th><?php //Gerente ?>
                        <th>Asignado</th>

                    </tr>
                </tfoot>
            </table>
    </div>
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