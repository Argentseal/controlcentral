<?php include("../db.php"); ?>
<?php 

///// Datos de usuarios//////////////

if(!$_SESSION['nombre']){
session_destroy();
header("location: ../index.php");
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$tipo = $_SESSION['tipo_us'];

}



///// Datos de usuarios//////////////

?>

<?php $mes = "20" .date ('y-m', strtotime('-0 month'));?>
 <?php 
  $query = "SELECT COUNT(ot) as 'bajasin' FROM bajas  WHERE tkl = '' and calendario like '%$mes%' ORDER BY calendario desc";
  $result_tasks = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $bajasin= $row['bajasin'];} ?>
<?php
  $query1 = "SELECT COUNT(ot) as 'reclamosin' FROM reclamos WHERE solucion='Ninguna aun'";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $reclamosin = $row['reclamosin']; }
?>
<?php $notitotal = $bajasin + $reclamosin; ?>
<!----VEHICULO--->
<?php
  $query = "SELECT * FROM vehiculos ORDER BY patente desc";
  $result_tasks = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result_tasks)) 
    { 
      $fecha_ultima = "20" .date ('y-m-d', strtotime('-0 days'));
      $fecha_media = "20" .date ('y-m-d', strtotime('+15 days'));
      /////VTV/////////
      $fecha_ven_vtv = $row['vtv'];                      

        if ($fecha_ven_vtv <= $fecha_media)
          {
            if($fecha_ven_vtv > $fecha_ultima)
            {                            
              $id = $row['id'];
              $query = "SELECT * FROM vehiculos WHERE id=$id";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) == 1)
              {
                $row = mysqli_fetch_array($result);                              
              }  
              $query = "UPDATE vehiculos set vigente = 'PROXIMO' WHERE id=$id";
              mysqli_query($conn, $query);         
            }
            else
            {

              $id = $row['id'];
              $query = "SELECT * FROM vehiculos WHERE id=$id";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) == 1)
              {
                $row = mysqli_fetch_array($result);                              
              }  
              $query = "UPDATE vehiculos set vigente = 'NO' WHERE id=$id";
              mysqli_query($conn, $query);
            }
          }

          /////SEGURO/////////
      $fecha_ven_seg = $row['seguro'];                      

        if ($fecha_ven_seg <= $fecha_media)
          {
            if($fecha_ven_seg > $fecha_ultima)
            {                            
              $id = $row['id'];
              $query = "SELECT * FROM vehiculos WHERE id=$id";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) == 1)
              {
                $row = mysqli_fetch_array($result);                              
              }  
              $query = "UPDATE vehiculos set vigenteseg = 'PROXIMO' WHERE id=$id";
              mysqli_query($conn, $query);         
            }
            else
            {
              $id = $row['id'];
              $query = "SELECT * FROM vehiculos WHERE id=$id";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) == 1)
              {
                $row = mysqli_fetch_array($result);                              
              }  
              $query = "UPDATE vehiculos set vigenteseg = 'NO' WHERE id=$id";
              mysqli_query($conn, $query);
            }
          }
        }        
?>
<?php
  $query1 = "SELECT COUNT(vigente) as 'novigente' FROM vehiculos WHERE vigente='NO'";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $novigente = $row['novigente']; }
?>
<?php
  $query1 = "SELECT COUNT(vigente) as 'proximovigente' FROM vehiculos WHERE vigente='PROXIMO'";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $proximovigente = $row['proximovigente']; }
?>

<!------------------------->
<?php
  $query1 = "SELECT COUNT(vigenteseg) as 'novigenteseg' FROM vehiculos WHERE vigenteseg='NO'";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $novigenteseg = $row['novigenteseg']; }
?>
<?php
  $query1 = "SELECT COUNT(vigenteseg) as 'proximovigenteseg' FROM vehiculos WHERE vigenteseg='PROXIMO'";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $proximovigenteseg = $row['proximovigenteseg']; }
?>
<?php $notivehiculototal = $novigente + $proximovigente + $novigenteseg + $proximovigenteseg; ?>
<!----VEHICULO--->
<!DOCTYPE html>
<html lang="es_ES">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Argentseal</title><!--titulo de pestaña-->

  <link rel="stylesheet" type="text/css" href="../jquery-ui-1.12.1.custom/jquery-ui.css">
  <link rel="stylesheet" href="jquery-ui-1.12.1.custom/style.css">
  <script src="../jquery-3.3.1.min.js"></script>
  <script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
  <!--Bootstrap 4-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!----Timepicker---->
  <link rel="stylesheet" type="text/css" href="../clockpicker.css">
  <!--- Font Awesome 5----->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
  integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
  crossorigin="anonymous">  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
  <!--    Datatables  -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
  
  
  <title>Argentseal</title>                    <!--titulo de pestaña-->
  <link rel="shortcut icon" type="image/png" href=”../Image/argent.ico” >
</head>
<body>
  <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
    <img src="/Image/argent.png" width="30" height="37" class="d-inline-block align-top" alt="" loading="lazy">
    <a class="navbar-brand pl-3" href="../inicio.php">Argentseal</a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        
        <?php if ($tipo == 'Visor'){ echo "";} else { ?>

        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Deposito
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <!-----VISTA ADMINISTRADOR---->
            <?php if ($tipo == 'Administrador'){ echo '
            <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
            <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>            
            <a class="dropdown-item" href="../Basico/descarga.php">Asignacion</a>
            <a class="dropdown-item" href="../Basico/asignacion.php">Devolucion</a>  ';} else { echo "";} ?>
            <!-----VISTA ADMINISTRADOR---->  

            <!-----VISTA DESPACHO---->
            <?php if ($tipo == 'Despacho'){ echo '
            <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
            <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>            
            <a class="dropdown-item" href="../Basico/descarga.php">Asignacion</a>
            <a class="dropdown-item" href="../Basico/asignacion.php">Devolucion</a>  ';} else { echo "";} ?>
            <!-----VISTA DESPACHO---->

            <!-----VISTA SUPERVISOR---->
            <?php if ($tipo == 'Supervisor'){ echo '
            <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
            <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>            
            <a class="dropdown-item" href="../Basico/descarga.php">Asignacion</a>
            <a class="dropdown-item" href="../Basico/asignacion.php">Devolucion</a>  ';} else { echo "";} ?>
            <!-----VISTA SUPERVISOR---->

            <!-----VISTA DEPOSITO---->
            <?php if ($tipo == 'Deposito'){ echo '
            <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
            <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>            
            <a class="dropdown-item" href="../Basico/descarga.php">Asignacion</a>
            <a class="dropdown-item" href="../Basico/asignacion.php">Devolucion</a>  ';} else { echo "";} ?>
            <!-----VISTA DEPOSITO----> 

                
          </div>
        </li>
        <?php } ?>

        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Control
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <!-----VISTA ADMINISTRADOR---->
            <?php if ($tipo == 'Administrador'){ echo '
            <a class="dropdown-item" href="../Basico/auditorias.php">Auditorias</a>
            <a class="dropdown-item" href="../Basico/altas.php">Altas</a>
            <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
            <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
            <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a>
            <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
            <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
            <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a> ';} else { echo "";} ?>
            <!-----VISTA ADMINISTRADOR---->

            <!-----VISTA DESPACHO---->
            <?php if ($tipo == 'Despacho'){ echo '
            <a class="dropdown-item" href="../Basico/auditorias.php">Auditorias</a>
            <a class="dropdown-item" href="../Basico/altas.php">Altas</a>
            <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
            <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
            <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a>
            <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
            <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
            <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a> ';} else { echo "";} ?>
            <!-----VISTA DESPACHO---->

            <!-----VISTA SUPERVISOR---->
            <?php if ($tipo == 'Supervisor'){ echo '
            <a class="dropdown-item" href="../Basico/auditorias.php">Auditorias</a>
            <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
            <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
            <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a> ';} else { echo "";} ?>
            <!-----VISTA SUPERVISOR---->

            <!-----VISTA DEPOSITO---->
            <?php if ($tipo == 'Deposito'){ echo '
            
            <a class="dropdown-item" href="../Basico/altas.php">Altas</a>
            <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
            <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
            <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a> 
            <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a> ';} else { echo "";} ?>
            <!-----VISTA DEPOSITO---->

            <!-----VISTA VISOR---->
            <?php if ($tipo == 'Visor'){ echo '
            <a class="dropdown-item" href="../Basico/garantiasanalisis.php">Garantias</a>
            <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a> ';} else { echo "";} ?>
            <!-----VISTA VISOR---->
          </div>
        </li>
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tecnicos
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <!-----VISTA ADMINISTRADOR---->
            <?php if ($tipo == 'Administrador'){ echo '
            <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
            <a class="dropdown-item" href="../Basico/ayudantes.php">Ayudantes</a>
            <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
            <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
            <a class="dropdown-item" href="../Basico/produccion.php">Produccion</a>
            <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
            <a class="dropdown-item" href="../Basico/liquidacion.php">Liquidacion</a> ';} else { echo "";} ?>
            <!-----VISTA ADMINISTRADOR---->

            <!-----VISTA DESPACHO---->
            <?php if ($tipo == 'Despacho'){ echo '
            <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
            <a class="dropdown-item" href="../Basico/ayudantes.php">Ayudantes</a>
            <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
            <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
            <a class="dropdown-item" href="../Basico/produccion.php">Produccion</a>
            <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
            <a class="dropdown-item" href="../Basico/liquidacion.php">Liquidacion</a> ';} else { echo "";} ?>
            <!-----VISTA DESPACHO---->

            <!-----VISTA SUPERVISOR---->
            <?php if ($tipo == 'Supervisor'){ echo '
            <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
            <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
            <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>            
            <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a> ';} else { echo "";} ?>
            <!-----VISTA SUPERVISOR---->

            <!-----VISTA DEPOSITO---->
            <?php if ($tipo == 'Deposito'){ echo '
            <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
            <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
            <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a> ';} else { echo "";} ?>
            <!-----VISTA DEPOSITO---->

            <!-----VISTA VISOR---->
            <?php if ($tipo == 'Visor'){ echo '
            <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a> ';} else { echo "";} ?>
            <!-----VISTA VISOR---->
          </div>
        </li>


        <!--------->
        <?php if ($tipo == 'Administrador'){ echo '
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            General
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../Basico/asistenciatotal.php">Asistencia total</a>
            <a class="dropdown-item" href="../Basico/usuarios.php">Usuarios</a>
            <a class="dropdown-item" href="../Basico/herramientas.php">Herramientas</a>
            <a class="dropdown-item" href="../Basico/precios.php">Precios</a>
          </div>
        </li>
        ';} else { echo "";} ?>
        <!--------->

        <!--------->
        <?php if ($tipo == 'Despacho'){ echo '
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            General
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../Basico/asistenciatotal.php">Asistencia total</a>            
            <a class="dropdown-item" href="../Basico/precios.php">Precios</a>                                   
          </div>
        </li>
        ';} else { echo "";} ?>
        <!--------->


          <!------BAJAS Y RECLAMOS------->
        <li class="nav-item  <?php if ($notitotal>=1){echo "dropdown";}else{echo "";} ?> active ">
          <a class="nav-link  <?php if ($notitotal>=1){echo "dropdown-toggle";}else{echo "";} ?>  justify-content-between" href="#" id="noti" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <?php if ($notitotal>=1)
            { ?>
              <span class="badge badge-danger"><?php echo $notitotal; ?></span> <?php
            }
            else
            { echo ""; ?>
            <?php } ?>
          </a>
        <div class="dropdown-menu" aria-labelledby="noti">            
            <?php if ($bajasin == 0)
            { echo "";}
            else
            {?>        
            <a class="dropdown-item" <?php if ($tipo == 'Visor'){ echo "";} else { echo ' href="../Basico/bajas.php" ';} ?> >Bajas  
              <?php if ($bajasin == 0)
              { echo "";}
              else
              {?>
              <span class="badge badge-danger"><?php echo $bajasin; ?></span>
              <?php ;}?></a>            
            <?php ;}?> 
             <!----------->
            <?php if ($reclamosin == 0)
            { echo "";}
            else
            {?>        
            <a class="dropdown-item" <?php if ($tipo == 'Visor'){ echo "";} else { echo ' href="../Basico/reclamos.php" ';} ?> >Reclamos 
              <?php if ($reclamosin == 0)
              { echo "";}
              else
              {?>
              <span class="badge badge-danger"><?php echo $reclamosin; ?></span>
              <?php ;}?></a>             
            <?php ;}?>          
        </div>
      </li>
      <!------BAJAS Y RECLAMOS------->
      <!------VEHICULOS------->
      <li class="nav-item <?php if ($notivehiculototal>=1){echo "dropdown";}else{echo "";} ?> active">
          <a class="nav-link   <?php if ($notivehiculototal>=1){echo "dropdown-toggle";}else{echo "";} ?>  justify-content-between" href="#" id="notivehiculo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-car"></i>
            <?php if ($notivehiculototal>=1)
            { ?>
              <span class="badge badge-danger"><?php echo $notivehiculototal; ?></span> <?php
            }
            else
            { echo ""; ?>
            <?php } ?>
          </a>
        <div class="dropdown-menu" aria-labelledby="notivehiculo">            
            <?php if ($novigente == 0 && $proximovigente == 0)
            { echo "";}
            else
            {?>        
            <a class="dropdown-item" <?php if ($tipo == 'Visor'){ echo "";} else { echo ' href="../Basico/vehiculos.php" ';} ?> >VTV 
              <?php if ($proximovigente == 0)
              { echo "";}
              else
              {?>
              <span class="badge badge-warning"><?php echo $proximovigente; ?></span>
              <?php ;}?>             
               
              <?php if ($novigente == 0)
              { echo "";}
              else
              {?>
              <span class="badge badge-danger"><?php echo $novigente; ?></span>
              <?php ;}?></a>
            <?php ;}?>
            <!----------->
            <?php if ($novigenteseg == 0 && $proximovigenteseg == 0)
            { echo "";}
            else
            {?>        
            <a class="dropdown-item" <?php if ($tipo == 'Visor'){ echo "";} else { echo ' href="../Basico/vehiculos.php" ';} ?> >Seguro 
              <?php if ($proximovigenteseg == 0)
              { echo "";}
              else
              {?>
              <span class="badge badge-warning"><?php echo $proximovigenteseg; ?></span>
              <?php ;}?>             
               
              <?php if ($novigenteseg == 0)
              { echo "";}
              else
              {?>
              <span class="badge badge-danger"><?php echo $novigenteseg; ?></span>
              <?php ;}?></a>
            <?php ;}?>
        </div>
      </li>
      <!------VEHICULOS------->
    </ul>



    <span class="btn-group text-white">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle d-md-none d-lg-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
      </a>
      <div class="dropdown-menu dropdown-menu-left">
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo; ?></small></a>
          <div class="form-row justify-content-center">
          <a class="text-center h2">
            <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
          </a></div>

           <?php
          $query = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo' ";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>

          <a class="dropdown-item text-center" href="../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div> 
          <?php if ($tipo == 'Administrador'){ echo '<div class="form-row justify-content-center">
          <a href="../ATC/indexatc.php"  class="h1 text-info"><i class="fas fa-sync-alt"></i></a>
         </div>' ;} ?>
         <?php if ($tipo == 'Despacho'){ echo '<div class="form-row justify-content-center">
          <a href="../ATC/indexatc.php"  class="h1 text-info"><i class="fas fa-sync-alt"></i></a>
         </div>' ;} ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="../includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>
        </div>
      </div>
    </span>



  </div>



  <span class=" d-sm-none d-none d-md-block d-lg-block float-right">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
         <?php if ($tipo == 'Supervisor'){ echo '<i class="fas fa-user-tie"></i>';} ?>
         <?php if ($tipo == 'Deposito'){ echo '<i class="fas fa-user"></i>';} ?>
         <?php if ($tipo == 'Visor'){ echo '<i class="far fa-eye"></i>';} ?>
    </a>
      <div class="dropdown-menu dropdown-menu-right">          
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo; ?></small></a>
          <div class="form-row justify-content-center">
          <a class="text-center h2">
            <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
          </a></div>

           <?php
          $query = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo' ";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>

          <a class="dropdown-item text-center" href="../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div> 
          <?php if ($tipo == 'Administrador'){ echo '
          <div class="form-row justify-content-center">
          <a href="../../corpo/indexcorpo.php" class="h1 text-success"><i class="fas fa-user-tie"></i></a>
          </div>
          <div class="form-row justify-content-center">
          <a href="../../ATC/indexatc.php" class="h1 text-info"><i class="fas fa-street-view"></i></a>
          </div>' ;} ?>
         <?php if ($tipo == 'Despacho'){ echo '
          <div class="form-row justify-content-center">
          <a href="../../corpo/indexcorpo.php" class="h1 text-success"><i class="fas fa-user-tie"></i></a>
          </div>
          <div class="form-row justify-content-center">
          <a href="../../ATC/indexatc.php" class="h1 text-info"><i class="fas fa-street-view"></i></a>
          </div>' ;} ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="../includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>

        </div>
      </div>
    </span>
    

    
</nav>




