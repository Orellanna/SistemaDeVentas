<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarTraspasos();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarTraspasos();
exit;
}  
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregar") 
{
$reg = $tra->AgregarDetallesTraspasos();
exit;
}      
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Ruben Chirinos">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>
    <!-- This Page CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <!--Bootstrap Horizontal CSS -->
    <link href="assets/css/bootstrap-horizon.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


</head>

<body onLoad="muestraReloj(); getTime();" class="fix-header">
    
   <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 
      
    <!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Búsqueda de Productos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                    </div>
                    <div class="modal-body">

                    <!-- .div load -->
                    <div id="loadproductos"></div>
                    <!-- /.div load -->

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->


        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->
   

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Traspasos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Traspasos</li>
                                <li class="breadcrumb-item active" aria-current="page">Traspasos</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="page-content container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
               
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Traspasos</h4>
            </div>

<?php if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
      
$reg = $tra->TraspasosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatetraspasos" id="updatetraspasos" data-id="<?php echo $reg[0]["codtraspaso"] ?>">

<?php } else if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") {
      
$reg = $tra->TraspasosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="agregatraspasos" id="agregatraspasos" data-id="<?php echo $reg[0]["codtraspaso"] ?>">
        
<?php } else { ?>
        
 <form class="form form-material" method="post" action="#" name="savetraspasos" id="savetraspasos">

<?php } ?>
           
               <div class="form-body">

                <div id="save">
                   <!-- error will be shown here ! -->
                </div>

            <div class="card-body">

<input type="hidden" name="proceso" id="proceso" <?php if (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="U") { ?> value="update" <?php } elseif (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="A") { ?> value="agregar" <?php } else { ?> value="save" <?php } ?>>

<input type="hidden" name="idtraspaso" id="idtraspaso" <?php if (isset($reg[0]['idtraspaso'])) { ?> value="<?php echo $reg[0]['idtraspaso']; ?>"<?php } ?>>
<input type="hidden" name="codtraspaso" id="codtraspaso" <?php if (isset($reg[0]['codtraspaso'])) { ?> value="<?php echo encrypt($reg[0]['codtraspaso']); ?>"<?php } ?>>
<input type="hidden" name="traspaso" id="traspaso" <?php if (isset($reg[0]['codtraspaso'])) { ?> value="<?php echo encrypt($reg[0]['codtraspaso']); ?>"<?php } ?>>

<input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>" <?php } ?>>
<input type="hidden" name="sucursal" id="sucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } ?>>
     
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <div class="row">
        <?php if (isset($reg[0]['recibe'])) { ?>
         <div class="col-md-4"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Sucursal que Recibe: <span class="symbol required"></span></label> 
                <input type="hidden" name="recibe" id="recibe" value="<?php echo encrypt($reg[0]['recibe']); ?>">
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="nomsucursal" id="nomsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Sucursal que Recibe" value="<?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'] ?>" disabled="" required="" aria-required="true">
                <i class="fa fa-bank form-control-feedback"></i>  
            </div>
        </div>   

        <?php } else { ?>

        <div class="col-md-4"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Seleccione Sucursal que Recibe: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="recibe" id="recibe" class="form-control" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $sucursal = new Login();
                $sucursal = $sucursal->ListarSucursalesDiferentes();
                if($sucursal==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($sucursal);$i++){
                ?>
                <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>       
                <?php } } ?>
                </select> 
            </div> 
        </div>

        <?php } ?>

        <div class="col-md-4"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Fecha Traspaso: <span class="symbol required"></span></label> 
                <input type="text" class="form-control calendario" name="fechatraspaso" id="fechatraspaso" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Traspaso" <?php if (isset($reg[0]['fechatraspaso'])) { ?> value="<?php echo date("d-m-Y",strtotime($reg[0]['fechatraspaso'])); ?>" <?php } else { ?> value="<?php echo date("d-m-Y"); ?>" <?php } ?> required="" aria-required="true">
                <i class="fa fa-calendar form-control-feedback"></i>  
            </div> 
        </div>

        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label">Observaciones: </label>
                <input type="text" class="form-control" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observaciones en Traspaso" autocomplete="off" required="" aria-required="true"/> 
                <i class="fa fa-comments form-control-feedback"></i>
            </div>
        </div>
    </div> 


<?php if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

<div id="detallestraspasoupdate">

        <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;   
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoTraspaso(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantidad"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadbd[]" id="cantidadbd" value="<?php echo $detalle[$i]["cantidad"]; ?>">
      <input type="hidden" name="coddetalletraspaso[]" id="coddetalletraspaso" value="<?php echo $detalle[$i]["coddetalletraspaso"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"></td>
      
      <td><strong><?php echo $detalle[$i]['codproducto']; ?></strong></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
       <td><strong><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></strong></td>

       <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></strong></td>

       <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></strong></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <strong><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoUpdate('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
</div>


<?php } else if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

<div id="detallestraspasosagregar">

        <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><strong><?php echo $a++; ?></td>
      
      <td><strong><?php echo $detalle[$i]['codproducto']; ?></strong></td>

    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

      <td><strong><?php echo $detalle[$i]['cantidad']; ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></strong></td>

       <td><strong><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></strong></td>

      <td><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></strong></td>

      <td><strong><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoAgregar('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>
            </div>
      </div>

            <hr>

        <input type="hidden" name="idproducto" id="idproducto">
        <input type="hidden" name="codproducto" id="codproducto">
        <input type="hidden" name="producto" id="producto">
        <input type="hidden" name="codmarca" id="codmarca">
        <input type="hidden" name="marcas" id="marcas">
        <input type="hidden" name="codmodelo" id="codmodelo">
        <input type="hidden" name="modelos" id="modelos">
        <input type="hidden" name="codpresentacion" id="codpresentacion">
        <input type="hidden" name="presentacion" id="presentacion">
        <input type="hidden" name="preciocompra" id="preciocompra"> 
        <input type="hidden" name="precioconiva" id="precioconiva">
        <input type="hidden" name="ivaproducto" id="ivaproducto">
        <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">

        <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                  <label class="control-label">Realice la Búsqueda de Producto: <span class="symbol required"></span></label>
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_traspaso" id="search_traspaso" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda por Código, Descripción o Nº de Barra">
                  <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
               </div> 
            </div> 

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
                 <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" readonly="readonly">
                 <i class="fa fa-bolt form-control-feedback"></i> 
              </div> 
            </div>  

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Descuento: <span class="symbol required"></span></label>
                    <input class="form-control agregaproducto" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                 <input type="text" class="form-control agregaproducto" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad">
                 <i class="fa fa-bolt form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="pull-right">
     <div class="pull-right">
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="CargaProductos()"><i class="fa fa-search"></i> Productos</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar</button>
        </div>
        </div></br>

        <div class="table-responsive m-t-40">
            <table id="carrito" class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
              </table><hr>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($valor, 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($valor, 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($valor, 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($_SESSION['descsucursal'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>    </td>
                    </tr>
                  </table>
        </div>


<?php } else { ?>

    <div id="loadcampos">

        <input type="hidden" name="idproducto" id="idproducto">
        <input type="hidden" name="codproducto" id="codproducto">
        <input type="hidden" name="producto" id="producto">
        <input type="hidden" name="codmarca" id="codmarca">
        <input type="hidden" name="marcas" id="marcas">
        <input type="hidden" name="codmodelo" id="codmodelo">
        <input type="hidden" name="modelos" id="modelos">
        <input type="hidden" name="codpresentacion" id="codpresentacion">
        <input type="hidden" name="presentacion" id="presentacion">
        <input type="hidden" name="preciocompra" id="preciocompra"> 
        <input type="hidden" name="precioconiva" id="precioconiva">
        <input type="hidden" name="ivaproducto" id="ivaproducto">
        <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">

        <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                <label class="control-label">Realice la Búsqueda de Producto: <span class="symbol required"></span></label>
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_traspaso" id="search_traspaso" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda por Código, Descripción o Nº de Barra">
                  <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
               </div> 
            </div> 

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
                 <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" readonly="readonly">
                 <i class="fa fa-bolt form-control-feedback"></i> 
              </div> 
            </div>  

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Descuento: <span class="symbol required"></span></label>
                    <input class="form-control agregaproducto" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                 <input type="text" class="form-control agregaproducto" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad">
                 <i class="fa fa-bolt form-control-feedback"></i> 
                </div> 
            </div>
        </div>

       <div class="pull-right">
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="CargaProductos()"><i class="fa fa-search"></i> Productos</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar</button>
        </div>


    </div></br>

        <div class="table-responsive m-t-40">
            <table id="carrito" class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
              </table><hr>
        
        <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($valor, 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($valor, 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($valor, 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($_SESSION['descsucursal'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>    </td>
                    </tr>
                  </table>
        </div>


<?php } ?> 


<div class="clearfix"></div>
<hr>
              <div class="text-right">
<?php  if (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="U") { ?>
<span id="submit_update"><button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button></span>
<a href="traspasos"><button class="btn btn-dark" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button></a> 
<?php } else if (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="A") { ?>  
<span id="submit_agregar"><button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button></span>
<button class="btn btn-dark" type="button" id="vaciar2"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button></span>
<button class="btn btn-dark" type="button" id="vaciar"><i class="fa fa-trash-o"></i> Limpiar</button>
<?php } ?>
</div>
          </div>
       </div>
     </form>
   </div>
  </div>
</div>

<!-- End Row -->


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/script/jquery.min.js"></script> 
    <script src="assets/js/bootstrap.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!-- Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jstraspasos.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <!-- jQuery -->

</body>
</html>

<?php } else { ?>   
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
        document.location.href='panel'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>