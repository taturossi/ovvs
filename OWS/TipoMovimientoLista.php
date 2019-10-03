<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>OWS - Tipo Movimiento</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  
  <script src="js/utilities.js"></script>
<script src="vendor/jquery/jquery.js"></script>
 <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  
  <script>
	function Filtrar()
	{
		var codigo = document.getElementById("txtCodigo").value;
		var descrip = document.getElementById("txtDescrip").value;
		var Tipo = document.getElementById("selTipo").value;
		var chk = document.getElementById("chkHabilitado").checked;
		
		
		document.getElementById("tableContainer").innerHTML = "";
		CargarGrilla(codigo,descrip,Tipo, chk);
	}
	function Desactivar (id, codigo)
	{
		if (confirm("¿Esta seguro que desea desactivar el tipo de movimiento "+ codigo +" ?")) {
			
			console.log("entre: "+id);
			urltemp = 'classes/TipoMovimiento/actualizarTipoMovimiento.php?id='+id+'&fb=1';
			
			$.ajax({
				type: "GET",
				url: urltemp,
				success: function(data){
					if (data == 1)
					{
						
						document.getElementById("tableContainer").innerHTML = "";
						CargarGrilla("","","", false);
						document.getElementById("divMensaje").innerHTML = "<p>El tipo de movimiento "+codigo+" fue desactivado correctamente<p>";
						document.getElementById("divResult").style.display = "block";
					}
				}
			});
		}
	}
  </script>
	<script>  
		$(document).ready(function() {
			CargarGrilla("","","", false);
		});
		
		function CargarGrilla(c,d,t,ch)
		{
			document.getElementById("divResult").style.display = "none";
			var urltemp = 'classes/TipoMovimiento/getTiposMovimiento.php';
			if(c != "" || d != "" || t !="" || ch == true)
				urltemp = urltemp + "?"
			
			if(c != "")
				urltemp = urltemp + "c="+c+"&";
			if(d != "")
				urltemp = urltemp + "d="+d+"&";
			if(t != "")
				urltemp = urltemp + "t="+t+"&";
			if(ch == true)
				urltemp = urltemp + "ch=1";
			
			$.ajax({
						type: "GET",
						url: urltemp,//'classes/TipoMovimiento/getTiposMovimiento.php',
						success: function(data){
							console.log(data);
						 
						tabContainer=document.getElementById("tableContainer");

						drawTable=document.createElement("table");
						drawTable.setAttribute('class', "table table-bordered dataTable");
						drawTable.setAttribute('id', "dataTable");
						drawTable.setAttribute('width', "100%");
						drawTable.setAttribute('cellspacing', "0");
						drawHead=document.createElement("thead");
						drawtr=document.createElement("tr");
						drawthCodigo=document.createElement("th");
						drawthDescrip=document.createElement("th");
						drawthTipo=document.createElement("th");
						drawthFechaAlta=document.createElement("th");
						drawthFechaBaja=document.createElement("th");
						drawthActions=document.createElement("th"); 
						drawthCodigo.appendChild(document.createTextNode('Codigo'));
						drawthDescrip.appendChild(document.createTextNode('Descripción'));
						drawthTipo.appendChild(document.createTextNode('Imputación'));
						drawthFechaAlta.appendChild(document.createTextNode('Fecha Alta'));
						drawthFechaBaja.appendChild(document.createTextNode('Fecha Baja'));
						drawthActions.appendChild(document.createTextNode('Acciones'));
						
																																  
						drawtr.appendChild(drawthCodigo);		
						drawtr.appendChild(drawthDescrip);	
						drawtr.appendChild(drawthTipo);
						drawtr.appendChild(drawthFechaAlta);		
						drawtr.appendChild(drawthFechaBaja);
						drawtr.appendChild(drawthActions);						
						drawHead.appendChild(drawtr);
																																  
																																  
						drawFoot=document.createElement("tfoot");
						drawtrFoot=document.createElement("tr");
						drawthCodigoFoot=document.createElement("th");
						drawthDescripFoot=document.createElement("th");
						drawthTipoFoot=document.createElement("th");
						drawthFechaAltaFoot=document.createElement("th");
						drawthFechaBajaFoot=document.createElement("th");
						drawthActionsFoot=document.createElement("th");
						drawthCodigoFoot.appendChild(document.createTextNode('Codigo'));
						drawthDescripFoot.appendChild(document.createTextNode('Descripción'));
						drawthTipoFoot.appendChild(document.createTextNode('Imputación'));
						drawthFechaAltaFoot.appendChild(document.createTextNode('Fecha Alta'));
						drawthFechaBajaFoot.appendChild(document.createTextNode('Fecha Baja'));
						drawthActionsFoot.appendChild(document.createTextNode('Actions'));		
						
						drawtrFoot.appendChild(drawthCodigoFoot);		
						drawtrFoot.appendChild(drawthDescripFoot);	
						drawtrFoot.appendChild(drawthTipoFoot);
						drawtrFoot.appendChild(drawthFechaAltaFoot);		
						drawtrFoot.appendChild(drawthFechaBajaFoot);	
						drawFoot.appendChild(drawtrFoot);
						drawtrFoot.appendChild(drawthActionsFoot);
																																  
						tabBody=document.createElement("tbody");	
							
							console.log(data);
							var data1 = JSON.parse(data);
							data1.forEach(row => {
							//$('#tbody').append('<tr><td>' + row.name + '</td><td>' + row.campaignId + '</td></tr>');
							rowTable=document.createElement("tr");

							colCodigo = document.createElement("td");
							colDescrip = document.createElement("td");
							colTipo = document.createElement("td");
							colFechaAlta = document.createElement("td");
							colFechaBaja = document.createElement("td");
							colActions = document.createElement("td");
							  
							
							colCodigo.appendChild(document.createTextNode(row.Codigo));
							colDescrip.appendChild(document.createTextNode(row.Descripcion));
							colTipo.appendChild(document.createTextNode(row.TipoImputacion));
							colFechaAlta.appendChild(document.createTextNode(row.FechaAlta));
							colFechaBaja.appendChild(document.createTextNode(row.FechaBaja));
							
							var link = document.createElement("a");
							link.setAttribute('href', "TipoMovimientoEditar.php?m=R&id=" + row.IdTipoMovimiento );
							link.setAttribute('class', "btn-sm btn-secondary mr-1");
							var btnsettings = document.createElement("i");
							btnsettings.setAttribute('class', "fas fa-cog text-white-50");
							link.appendChild(btnsettings);
							  
							var editlink = document.createElement("a");
							editlink.setAttribute('href', "TipoMovimientoEditar.php?m=E&id=" + row.IdTipoMovimiento );
							editlink.setAttribute('class', "btn-sm btn-primary mr-1");
							var btnedit = document.createElement("i");
							btnedit.setAttribute('class', "fa fa-magic text-white-50");
							editlink.appendChild(btnedit);
							
							var remove = document.createElement("a");
							remove.setAttribute('href', "#");
							remove.setAttribute('class', "btn-sm btn-danger ");
							remove.setAttribute('onclick', "javascript:Desactivar("+ row.IdTipoMovimiento+",'"+ row.Codigo +"');");
							var btnremove = document.createElement("i");
							btnremove.setAttribute('class', "fas fa-trash text-white-50");
							remove.appendChild(btnremove);
							
							colActions.appendChild(link);
							colActions.appendChild(editlink);
							colActions.appendChild(remove);

							rowTable.appendChild(colCodigo);
							rowTable.appendChild(colDescrip);
							rowTable.appendChild(colTipo);
							rowTable.appendChild(colFechaAlta);
							rowTable.appendChild(colFechaBaja);
							rowTable.appendChild(colActions);	
							
							tabBody.appendChild(rowTable);
						  });
						drawTable.appendChild(drawHead);
						drawTable.appendChild(drawFoot);
						drawTable.appendChild(tabBody);
						tabContainer.appendChild(drawTable);
						$('#dataTable').DataTable();
						}
					});
		}
	</script>
</head>

<body id="page-top" >

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
	<?php 
		include "sidebar.php";
	?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php 
			include "top.php";
		?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

			<!-- Page Heading -->
			<h1 class="h3 mb-4 text-gray-800">Lista de tipos de movimientos</h1>
			<div class="col-lg-12 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-body">
					<p>Seleccione los filtros deseados.</p>
					<div class="row mb-4">
						
						<div class="col-4">
							<label for="Name">Código</label>
                            <input class="form-control" id="txtCodigo" name="txtCodigo" value="">
						</div>
						<div class="col-4">
							<label for="Username">Descripción</label>
                            <input class="form-control" id="txtDescrip" name="txtDescrip" value="">
						</div>
						<div class="col-4">
							<label for="Currency">Tipo Imputación</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selTipo" name="selTipo"  tabindex="-1" aria-hidden="true">
								<option value="">Seleccionas</option>
								<option value="DEB">Débito</option>
								<option value="CRE">Crédito</option>
							</select>
                        </div>
					</div>
					<div class="row mb-4">
						
						<div class="col-4">
							<input type="checkbox" id="chkHabilitado">
							<label for="Name">Habilitado</label>
						</div>
						
					</div>
					<div class="mb-4">		
                        <div class="form-group pull-right">
                            <input type="submit" value="Filtrar" class="btn-lg btn-primary" onclick="javascript:Filtrar();">
					    </div>
                    </div>
			    </div>
				
         </div>
		 <div class="card shadow mb-4">
             <div class="card-body" >
				<div class="my-2"><a href="tipomovimientonuevo.php" class="btn-lg btn-primary">Crear Nuevo</a></div>
				</br>
				<div class="card-body border-left-success " style="display:none;" id="divResult">		
					<div class="form-group pull-right" id="divMensaje">
					</div>
				</div>
				</br>
				<div class="table-responsive" id="tableContainer">
               
				</div>
            </div>
         </div>


            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
       <?php include "footer.php"; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php include "modal.php"; ?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
