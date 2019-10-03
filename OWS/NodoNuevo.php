<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>OWS - Nodos</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/lista.scss" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  
  <script src="js/utilities.js"></script>
  <script src="vendor/jquery/jquery.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  
  <script>
	function Nuevo()
	{
		document.getElementById("divError").style.display = "none";
		document.getElementById("divResult").style.display = "none";
		
		if(!Validar())
			return;
		
		var codigo = document.getElementById("txtCodigo").value;
		var descrip = document.getElementById("txtDescrip").value;
		var tipo = document.getElementById("selTipo").value;
		
		urltemp = 'classes/TipoMovimiento/nuevoTipoMovimiento.php?c='+codigo+'&d='+descrip+'&t='+tipo;
		
		$.ajax({
			type: "GET",
			url: urltemp,
			success: function(data){
				
				console.log(data);
				if (data == 1)
				{
					document.getElementById("divMensaje").innerHTML = "<p>El tipo de movimiento "+descrip+" fue creado correctamente<p>";
					document.getElementById("divResult").style.display = "block";
					document.getElementById("txtCodigo").value = "";
					document.getElementById("txtDescrip").value ="";
					document.getElementById("selTipo").value = 0;
				}
			}
		});
		
	}
	
	function Validar()
	{
		var mensaje = "";
		if(document.getElementById("txtCodigo").value == "")
		{
			mensaje = mensaje + "<p>Por favor ingrese el codigo del tipo de movimiento.<p>"
		}
		else
		{
			$.ajax({
			type: "GET",
			url: 'classes/TipoMovimiento/getTipoMovimientoPorCodigo.php?c='+document.getElementById("txtCodigo").value,
			success: function(data){
				
				mensaje =  mensaje + "<p>El código ingresado ya existe para un tipo de movimiento.<p>"
			},
			async: false
			});
			
		}
		
		if(document.getElementById("txtDescrip").value == "")
		{
			mensaje = mensaje + "<p>Por favor ingrese la descripción del tipo de movimiento.<p>"
		}
		
		if(document.getElementById("selTipo").value == 0)
		{
			mensaje = mensaje + "<p>Por favor seleccione el tipo de imputación.<p>"
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
	$(document).ready(function() {
			CargarProvincias();
		//	CargarGrilla("","",0, 0);
		});
		
		function CargarProvincias()
		{
			$.ajax({
						type: "GET",
						url: "classes/Generales/getProvincias.php",
						async: true,
						success: function(data){
							
							var selProv = document.getElementById("selProvincia");

						
							
							var data1 = JSON.parse(data);
							data1.forEach(row => {
								var opt = document.createElement("option");
								opt.value= row.IdProvincia;
								opt.innerHTML = row.Descripcion; 

								selProv.appendChild(opt);
							});
						}
			});
		}
		function CargarCiudades()
		{
			var prov = document.getElementById("selProvincia").value;
			if(prov != 0)
			{
				$.ajax({
					type: "GET",
					url: "classes/Generales/getCiudades.php?p="+prov,
					async: true,
					success: function(data){
						
						var selCiu = document.getElementById("selCiudad");
						
						var opt = document.createElement("option");
						opt.value= 0;
						opt.innerHTML = "Seleccione"; 

						selCiu.appendChild(opt);
						var data1 = JSON.parse(data);
						data1.forEach(row => {
							opt = document.createElement("option");
							opt.value= row.IdCiudad;
							opt.innerHTML = row.Nombre; 

							selCiu.appendChild(opt);
						});
					}
				});
			}
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
			<h1 class="h3 mb-4 text-gray-800">Nuevo nodo</h1>
			<div class="col-lg-12 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                
                <div class="card-body">
					<p>Ingrese los datos del nuevo nodo</p>
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
							<label for="Currency">Link Maps</label>
                            <input class="form-control" id="txtLinkMaps" name="txtLinkMaps" value="">
                        </div>
					</div>
					<div class="row mb-4">
						
						<div class="col-4">
							<label for="Name">Provincia</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selProvincia" name="selProvincia" onchange="javascript:CargarCiudades();"  tabindex="-1" aria-hidden="true">
								<option value="0">Seleccione</option>
							</select>
						</div>
						<div class="col-4">
							<label for="Username">Ciudad</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selCiudad" name="selCiudad"  tabindex="-1" aria-hidden="true">
							</select>
						</div>
						<div class="col-4">
							<label for="Currency">Otros datos</label>
                            <input class="form-control" id="txtOtros" name="txtOtros" value="">
                        </div>
					</div>
					<div class="row mb-4">
						
						<div class="col-4">
							<label for="Name">UPS</label>
                            <input class="form-control" id="txtUPS" name="txtUPS" value="">
						</div>
						<div class="col-4">
							<label for="Username">Baterias</label>
                            <input class="form-control" id="txtBaterias" name="txtBaterias" value="">
						</div>
						<div class="col-4">
							<label for="Currency">Servidor</label>
                            <input class="form-control" id="txtServidor" name="txtServidor" value="">
                        </div>
					</div>
					<div class="row mb-4">
						
						<div class="col-4">
							<label for="Name">Panel Solar</label>
                            <input class="form-control" id="txtPanel" name="txtPanel" value="">
						</div>
						<div class="col-4">
							<label for="Username">Regulador</label>
                            <input class="form-control" id="txtRegulador" name="txtRegulador" value="">
						</div>
						<div class="col-4">
							<label for="Currency">Bocas electricas</label>
                            <input class="form-control" id="txtBocas" name="txtBocas" value="">
                        </div>
					</div>
				</div>
			</div>
			<div class="card shadow mb-4">
				<div class="card-body">
					<p>Seleccione el hardware asociado al nodo</p>
					<!-- Routers -->
					<div class="row mb-4" style="border: 1px solid; padding-bottom: 5px;">
						<div class="col-5">
							<label for="Currency">Routers Disponibles</label>
							<div class="subject-info-box-1">
							  <select multiple="multiple" id='lstBox1' class="form-control">
								<option value="ajax">Ajax</option>
								<option value="jquery">jQuery</option>
								<option value="javascript">JavaScript</option>
								<option value="mootool">MooTools</option>
								<option value="prototype">Prototype</option>
								<option value="dojo">Dojo</option>
							  </select>
							</div>
						</div>
						
						<div class="col-1 text-center">
							<label for="Currency"></label>
							<div class="subject-info-arrows text-center">
							  <input type="button" id="btnAllRight" value=">>" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnRight" value=">" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnLeft" value="<" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnAllLeft" value="<<" class="btn btn-primary btn-circle btn-sm" />
							</div>
						</div>
						<div class="col-5">
							<label for="Currency">Routers Asignados</label>
							<div class="subject-info-box-2">
							  <select multiple="multiple" id='lstBox2' class="form-control">
								<option value="asp">ASP.NET</option>
								<option value="c#">C#</option>
								<option value="vb">VB.NET</option>
								<option value="java">Java</option>
								<option value="php">PHP</option>
								<option value="python">Python</option>
							  </select>
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<!-- Switch -->
					<div class="row mb-4" style="border: 1px solid; padding-bottom: 5px;">
						<div class="col-5">
							<label for="Currency">Switchs Disponibles</label>
							<div class="subject-info-box-1">
							  <select multiple="multiple" id='lstBoxSWD' class="form-control">
								<option value="ajax">Ajax</option>
								<option value="jquery">jQuery</option>
								<option value="javascript">JavaScript</option>
								<option value="mootool">MooTools</option>
								<option value="prototype">Prototype</option>
								<option value="dojo">Dojo</option>
							  </select>
							</div>
						</div>
						
						<div class="col-1 text-center" >
							<label for="Currency"></label>
							<div class="subject-info-arrows text-center">
							  <input type="button" id="btnAllRightSW" value=">>" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnRightSW" value=">" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnLeftSW" value="<" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnAllLeftSW" value="<<" class="btn btn-primary btn-circle btn-sm" />
							</div>
						</div>
						<div class="col-5">
							<label for="Currency">Switchs Asignados</label>
							<div class="subject-info-box-2">
							  <select multiple="multiple" id='lstBoxSWA' class="form-control">
								<option value="asp">ASP.NET</option>
								<option value="c#">C#</option>
								<option value="vb">VB.NET</option>
								<option value="java">Java</option>
								<option value="php">PHP</option>
								<option value="python">Python</option>
							  </select>
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<!-- Antenas -->
					<div class="row mb-4" style="border: 1px solid; padding-bottom: 5px;">
						<div class="col-5">
							<label for="Currency">Antenas Disponibles</label>
							<div class="subject-info-box-1">
							  <select multiple="multiple" id='lstBoxAD' class="form-control">
								<option value="ajax">Ajax</option>
								<option value="jquery">jQuery</option>
								<option value="javascript">JavaScript</option>
								<option value="mootool">MooTools</option>
								<option value="prototype">Prototype</option>
								<option value="dojo">Dojo</option>
							  </select>
							</div>
						</div>
						
						<div class="col-1 text-center" >
							<label for="Currency"></label>
							<div class="subject-info-arrows text-center">
							  <input type="button" id="btnAllRightA" value=">>" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnRightA" value=">" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnLeftA" value="<" class="btn btn-primary btn-circle btn-sm" />
							  <input type="button" id="btnAllLeftA" value="<<" class="btn btn-primary btn-circle btn-sm" />
							</div>
						</div>
						<div class="col-5">
							<label for="Currency">Antenas Asignados</label>
							<div class="subject-info-box-2">
							  <select multiple="multiple" id='lstBoxAA' class="form-control">
								<option value="asp">ASP.NET</option>
								<option value="c#">C#</option>
								<option value="vb">VB.NET</option>
								<option value="java">Java</option>
								<option value="php">PHP</option>
								<option value="python">Python</option>
							  </select>
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<div class="mb-4">		
                        <div class="form-group pull-right">
                            <input type="submit" value="Crear" class="btn-lg btn-primary"  onclick="javascript:Nuevo();">
							<input type="submit" value="Cancelar" class="btn-lg btn-danger" onclick="javascript:Cancelar();">
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
  <script src="js/lista.js"></script>
  <script src="js/lista2.js"></script>
  <script src="js/lista3.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
