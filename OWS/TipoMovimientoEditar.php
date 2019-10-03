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
	function Actualizar()
	{
		document.getElementById("divError").style.display = "none";
		document.getElementById("divResult").style.display = "none";
		
		if(!Validar())
			return;
		
		var descrip = document.getElementById("txtDescrip").value;
		var id = document.getElementById("hdnId").value;
		
		urltemp = 'classes/TipoMovimiento/actualizarTipoMovimiento.php?id='+id+'&d='+descrip;
		
		$.ajax({
			type: "GET",
			url: urltemp,
			success: function(data){
				
				if (data == 1)
				{
					document.getElementById("divMensaje").innerHTML = "<p>El tipo de movimiento "+descrip+" fue actualizado correctamente<p>";
					document.getElementById("divResult").style.display = "block";
				}
			}
		});
		
	}
	
	function Validar()
	{
		var mensaje = "";
		if(document.getElementById("txtDescrip").value == "")
		{
			mensaje = mensaje + "<p>Por favor ingrese la descripción del tipo de movimiento.<p>"
		}
		
		if(mensaje != "")
		{
			console.log(mensaje);
			document.getElementById("divError2").innerHTML = mensaje;
			document.getElementById("divError").style.display = "block";
			
			return false;
		}
		else
			return true;
	}
	
	function Cancelar()
	{
		window.history.back();
	}
	function Inicio()
	{
		var modo = '<?php echo $_GET["m"]; ?>';
		var id = <?php echo $_GET["id"]; ?>;
		document.getElementById("hdnId").value = id;
		
		$.ajax({
			type: "GET",
			url: 'classes/TipoMovimiento/getTipoMovimientoPorId.php?id='+id,
			success: function(data){
				console.log(data);
				var data1 = JSON.parse(data);
				data1.forEach(row => {
				
				document.getElementById("txtCodigo").value = row.Codigo;
				document.getElementById("txtDescrip").value = row.Descripcion;
				document.getElementById("selTipo").value = row.TipoImputacion;
				}
				);
			}			
			});
		
		document.getElementById("txtCodigo").disabled = true;
		document.getElementById("selTipo").disabled = true;
		if(modo == 'R')
			document.getElementById("txtDescrip").disabled = true;
		
		
	}
	
  </script>
		
</head>

<body id="page-top" onload="javascript:Inicio();">
<input type="hidden" id="hdnId" ></hidden>
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
			<h1 class="h3 mb-4 text-gray-800">Nuevo tipo de movimiento</h1>
			<div class="col-lg-12 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                
                <div class="card-body">
					<p>Ingrese los datos del nuevo tipo de movimiento</p>
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
                            <select class="form-control select2-hidden-accessible"  id="selTipo" name="selTipo"  tabindex="-1" aria-hidden="true">
								<option value="">Seleccionas</option>
								<option value="DEB">Débito</option>
								<option value="CRE">Crédito</option>
							</select>
                        </div>
					</div>
					<div class="mb-4">		
                        <div class="form-group pull-right">
							<?php 
							if($_GET["m"] == "E")
							{
							?>
							<input type="submit" value="Actualizar" class="btn-lg btn-primary"  onclick="javascript:Actualizar();">
							<input type="submit" value="Cancelar" class="btn-lg btn-danger" onclick="javascript:Cancelar();">
							<?php
							}
							else
							{
							?>
							<input type="submit" value="Volver" class="btn-lg btn-primary" onclick="javascript:Cancelar();">
							<?php		
							}
							?>
                            
					    </div>
                    </div>
					
					<div class="card-body border-left-success " style="display:none;" id="divResult">		
                        <div class="form-group pull-right" id="divMensaje">
                            
					    </div>
                    </div>
					<div class="card-body border-left-warning " style="display:none;" id="divError">		
                        <div class="form-group pull-right" id="divError2">
                            
					    </div>
                    </div>
					
					
					
                </div>
				
				
         </div>


            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
		include("footer.php");
	  ?>
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
  <?php include("modal.php"); ?>

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
