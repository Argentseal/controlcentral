
<?php include("db.php"); ?>
<?php include('includes/header.php'); ?>
<?php 
$mes = date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
	$mes1 = $_POST['mes'];
	$mes = "20" .date ('y-m', strtotime($mes1));
}

?>


<!-- MESSAGES -->
      <?php session_start();      
       if ($_SESSION['card'] == 1) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->



<!-- TOTAL ALTAS-->
<?php $query= "SELECT SUM(tcumplida) as 'todocum' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todocum= $row['todocum'];}?>
<!-- TOTAL ALTAS-->

<!-- DOS Y TRES PLAY-->
<?php $query= "SELECT SUM(dosplay + tresplay) as 'dosytres' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$dosytres= $row['dosytres'];}?>
<!-- DOS Y TRES PLAY-->

<!-- SET TO BOX-->
<?php $query= "SELECT SUM(tcumplida) as 'cumplitec', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cumplitec asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$teccum= $row['tecnico'];
$cumplitec= $row['cumplitec'];}?>
<!-- SET TO BOX-->

<!-- TOTAL BAJAS-->
<?php $query= "SELECT SUM(bajas) as 'todobaja' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobaja= $row['todobaja'];}?>
<!-- TOTAL BAJAS-->

<!-- TOP BAJAS Y CANTIDAD -->
<?php $query= "SELECT count(ot) as 'cantidad', motivo FROM bajas  WHERE calendario like '%$mes%' GROUP BY motivo ORDER BY cantidad asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$topmotivo= $row['motivo'];
$cantidad= $row['cantidad'];}?>
<!-- TOP BAJAS Y CANTIDAD -->

<!-- TOP BAJAS POR TECNICO-->
<?php $query= "SELECT SUM(bajas) as 'cantidadtec', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadtec asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$bajatecnico= $row['tecnico'];
$cantidadtec= $row['cantidadtec'];}?>
<!-- TOP BAJAS POR TECNICO-->

<!-- TOTAL GARANTIAS-->
<?php $query= "SELECT SUM(garantec) as 'todogar' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgar=$row['todogar'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- TOP GARANTIAS JUSTIFICADAS -->
<?php $query= "SELECT count(fecha) as 'fechfech' FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$fechfech= $row['fechfech'];}	?>

<?php $query= "SELECT count(*) as 'justifi' FROM garantias  WHERE fecharep like '%$mes%' and justificado = 'SI' ORDER BY fecharep asc LIMIT $fechfech";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$justi= $row['justifi'];}?>

<?php $query= "SELECT * FROM garantias  WHERE fecharep like '%$mes%' and justificado = 'SI' GROUP BY fecharep ORDER BY fecharep asc LIMIT $fechfech";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result_tasks)) { 
}?>
<!-- TOP GARANTIAS JUSTIFICADAS -->

<!-- TOP GARANTIAS POR TECNICO-->
<?php $query= "SELECT SUM(garantec) as 'cantidadgar', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadgar asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$gartecnico= $row['tecnico'];
$cantidadgar= $row['cantidadgar'];}?>
<!-- TOP GARANTIAS POR TECNICO-->

<!-- TOTAL-->
<?php $query= "SELECT SUM(tcumplida + bajas) as 'todototal' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todototal=$row['todototal'];} ?>
<!-- TOTAL-->

<!-- TOP BAJAS POR TECNICO-->
<?php $query= "SELECT count(tecnico) as 'canttec', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY fecha"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) {
$canttec= $row['canttec'];}?>
<!-- TOP BAJAS POR TECNICO-->

<!-- CANTIDAD DE DIAS-->
<?php
$query= "SELECT COUNT(distinct fecha) as 'cantfech' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$cantfech= $row['cantfech'];}?>
<!-- CANTIDAD DE DIAS-->

<!---Scoring--->
<?php
$scoring1 = $totalgar*100/$dosytres;
$scoring = bcdiv($scoring1, '1', '2');
?>
<!---Scoring--->



<div class="container-fluid p-4">  <!---- RESUMEN--->
	<div class="row p-2 border border">		
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---ALTAS--->
			<div class="card bg-info">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todocum ?></p>				
						<p class="h4 text-light text-left ml-4">Altas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-up"></i></i></p>	
					</div>											
				</div>				
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-info text-light">2play y 3play <span class="badge badge-light"><?php echo $dosytres ?></span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-info text-light"><?php echo $teccum ." "; ?><span class="badge badge-light"><?php echo $cumplitec ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---BAJAS--->
			<div class="card bg-danger">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todobaja ?></p>
						<p class="h4 text-light text-left ml-4">Bajas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-down"></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-danger text-light"><?php echo $topmotivo ." "; ?><span class="badge badge-light"><?php echo $cantidad ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-danger text-light"><?php echo $bajatecnico ." "; ?><span class="badge badge-light"><?php echo $cantidadtec ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---GARANTIAS--->
			<div class="card bg-warning">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $totalgar ?></p>					
						<p class="h4 text-light text-left ml-4">Garantias</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-warning text-light">Visitas justificadas <span class="badge badge-light"><?php echo $justi ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-warning text-light"><?php echo $gartecnico ." "; ?><span class="badge badge-light"><?php echo $cantidadgar ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->
			<div class="card bg-dark">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototal ?></p>
						<p class="h4 text-light text-left ml-4">Visitas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-dark text-light">Scoring <span class="badge badge-light"><?php echo $scoring ?>%</span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-dark text-light">Dias trabajados <span class="badge badge-light"><?php echo $cantfech ?></span></a>
					</p>
				</div> 
			</div>
		</div>
	</div>
</div>

 <!-- BOTON DESPLEGABLE-->

<div class="container-fluid p-4 border">
	<div class="row align-items-start justify-content-center p-2">		
		<p><a class="btn btn-primary mt-4" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Ver tablas</a></p>		
	</div>
	<div class="row align-items-start justify-content-center p-1">
		<div class="col">			
			<div class="collapse multi-collapse" id="multiCollapseExample1">
				<div class="row P-1">
					<div class="col-12 col-md-3 col-sm-6 order-1 order-md-1 order-sm-1">
						<div class="container p-1">
							<div class="card card-body border-info">
								<p class="h4 mb-6 text-center">Altas por tecnico</p>
								<table class="table table-bordered table-responsive table-striped table-sm">
									<thead class="thead-dark text-center">
										<tr>          
										<th>Tecnico</th>
										<th>Cant</th>         
										</tr>
									</thead>
									<tbody>
										<?php
										$query = "SELECT SUM(tcumplida) as 'cumplitec', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cumplitec desc";
										$result_tasks = mysqli_query($conn, $query);  
										while($row = mysqli_fetch_assoc($result_tasks)) { ?>
										<tr>                       
										<td><?php echo $row['tecnico']; ?></td>
										<td align="center"><?php echo $row['cumplitec']; ?></td>
										</tr>        
									<?php } ?>
									</tbody>
								</table>    
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-sm-12 order-md-2 order-sm-3 order-2">
						<div class="card border border-danger">
							<div class="row">
								<div class="col-sm-6 col-md-6 d-none d-sm-block d-md-block d-lg-block">
									<div class="container p-1">
										<div class="card card-body  border-0">
											<p class="h4 mb-6 text-center">Bajas por motivo</p>
											<table class="table table-bordered table-responsive table-striped table-sm table-6">
												<thead class="thead-dark text-center">
													<tr>          
													<th>Motivo</th>
													<th>Cant</th>         
													</tr>
												</thead>
												<tbody>
													<?php
													$query = "SELECT count(ot) as 'cantidad', motivo FROM bajas  WHERE calendario like '%$mes%' GROUP BY motivo ORDER BY cantidad desc";
													$result_tasks = mysqli_query($conn, $query);  
													while($row = mysqli_fetch_assoc($result_tasks)) { ?>
													<tr>                       
													<td><?php echo $row['motivo']; ?></td>
													<td align="center"><?php echo $row['cantidad']; ?></td>
													</tr>        
												<?php } ?>
												</tbody>
											</table>    
										</div>	
									</div>
								</div>							
								<div class="col-12 col-sm-6 col-md-6 d-block d-sm-block d-md-block d-lg-block">
									<div class="container p-1">
										<div class="card card-body border-0">
											<p class="h4 mb-6 text-center">Bajas por tecnico</p>
											<table class="table table-bordered table-responsive table-striped table-sm table-6">
												<thead class="thead-dark text-center">
													<tr>          
													<th>Tecnico</th>
													<th>Cant</th>         
													</tr>
												</thead>
												<tbody>
													<?php
													$query = "SELECT SUM(bajas) as 'cantidadtec', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadtec desc";
													$result_tasks = mysqli_query($conn, $query);  
													while($row = mysqli_fetch_assoc($result_tasks)) { ?>
													<tr>                       
													<td><?php echo $row['tecnico']; ?></td>
													<td align="center"><?php echo $row['cantidadtec']; ?></td>
													</tr>        
												<?php } ?>
												</tbody>
											</table>    
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-3 order-md-3 order-sm-2 order-3">
						<div class="container p-1">
							<div class="card card-body  border-warning">
								<p class="h4 mb-6 text-center">Garantias por tecnico</p>
								<table class="table table-bordered table-responsive table-striped table-sm">
									<thead class="thead-dark text-center">
										<tr>          
										<th>Tecnico</th>
										<th>Cant</th>         
										</tr>
									</thead>
									<tbody>
										<?php
										$query = "SELECT SUM(garantec) as 'cantidadgar', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadgar desc";
										$result_tasks = mysqli_query($conn, $query);  
										while($row = mysqli_fetch_assoc($result_tasks)) { ?>
										<tr>                       
										<td><?php echo $row['tecnico']; ?></td>
										<td align="center"><?php echo $row['cantidadgar']; ?></td>
										</tr>        
									<?php } ?>
									</tbody>
								</table>    
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 <!-- BOTON DESPLEGABLE-->





<!-----
	<form method="POST">		
		<div class="row">
			<div class="form-group col">
				<label for="exampleFormControlSelect1">Fecha de la instalacion</label >
				<input type="text" id="fechaint" name="fechaint" readonly="" class="form-control" required>
			</div>        
			<div class="form-group col">
				<label for="exampleFormControlSelect1">Fecha de la reparacion</label >
				<input type="text" id="fecharep" name="fecharep" readonly="" class="form-control" required>
			</div>
		</div>
		<input type="submit" name="depo" id="depo" class="btn btn-success btn-block" value="Cargar">
	</form>

	conexion php mysql 
	<?php if(isset($_POST["depo"])) {
		$fechaint = $_POST['fechaint'];
		$fecharep = $_POST['fecharep'];
		$query= "SELECT count(*) as 'material1' FROM garantias WHERE fecharep BETWEEN '$fechaint' AND '$fecharep'"; 
		$result_tasks = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result_tasks)) { ?>


			<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
				<div class="card-header">Altas</div>
				<div class="card-body">
					<h5 class="card-title">Cantidad de altas</h5>
					<p class="card-text"><?php echo $row['material1']; ?></p><?php } }?>
				</div>
			</div>

			----->

<!--- GRAFICO TODOS LOS TECNICOS---->

<div class="container-fluid p-4 d-md-block d-lg-block">
	<div class="row p-2">
		<div class="col-12 border p-2">			
			<figure class="highcharts-figure">
			    <div id="container">    	
			    </div>
			    <p class="highcharts-description">			       
			    </p>
			</figure>			
		</div>		
	</div>
</div>


<!--- GRAFICO TODOS LOS TECNICOS---->

<div class="container">
	<div class="row">
		<div class="col">
			<div class="card card-body">
				<form action="../inicio.php" method="POST">
					<p class="h4 mb-4 text-center">Mes</p>
					<div class="form-row align-items-end">						
						<div class="col">							
							<select type="text" name="mes" class="form-control">
								<option selected>Mes...</option>
								<option value="-0 month">Mes actual</option>
								<option value="-1 month">Hace un mes</option>
								<option value="-2 month">Hace dos meses</option>
								<option value="-3 month">Hace tres meses</option>
							</select>
						</div>						
						<div class="col">
							<input type="submit" name="meses" class="btn btn-success btn-block" value="Cargar mes">
						</div>						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>






<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<!-- Calendario 1-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$("#fechaint").datepicker({ dateFormat: "yy-mm-dd"});
		$( "#anim" ).on( "change", function() {
			$( "#fechaint" ).datepicker( "option", "showAnim", $( this ).val() );
		});
	} );
</script>
<!-- Calendario 2-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$("#fecharep").datepicker({ dateFormat: "yy-mm-dd"});
		$( "#anim" ).on( "change", function() {
			$( "#fecharep" ).datepicker( "option", "showAnim", $( this ).val() );
		});
	} );
</script>



<!-- Grafico 1-->
<script src="HC/code/highcharts.js"></script>
<script src="HC/code/modules/heatmap.js"></script>
<script src="HC/code/modules/series-label.js"></script>
<script src="HC/code/modules/exporting.js"></script>
<script src="HC/code/modules/export-data.js"></script>
<script src="HC/code/modules/accessibility.js"></script>
<script type="text/javascript">
Highcharts.chart('container', {

    title: {
        text: 'Tareas'
    },

    subtitle: {
        text: 'Tipos de tareas dividido por dia'
    },

    yAxis: {
        title: {
            text: 'Total de tareas'
        }
    },

    xAxis: {
        categories:
        [
	        <?php
			$query= "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha"; 
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecha'];
            $tomorrow = date('d-m', strtotime("$bb"));
			
			?>
			 '<?php echo $tomorrow; ?>',
			<?php
			}
			?>
        ]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            
        }
    },

    series: [
    {
        name: 'Tareas cumplidas',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(tcumplida) as totcum FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totcum']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Bajas',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(bajas) as totbajas FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totbajas']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Garantias',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(garantec) as totgarantias FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totgarantias']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Doble play',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(dosplay) as dosdos FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['dosdos']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Triple play',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(tresplay) as trestres FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['trestres']; ?>,
			<?php
			}
			?>
        ]
    }
        ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>
<!-- Grafico 1-->



</body>
</html>

