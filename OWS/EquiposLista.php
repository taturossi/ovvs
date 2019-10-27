<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>OWS - Equipos</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/ows.css" rel="stylesheet">
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
		var Tipo = document.getElementById("selTipoEquipo").value;
		var Marca = document.getElementById("selMarca").value;
		var Modelo = document.getElementById("selModelo").value;
		var Torre = document.getElementById("selTorre").value;
		
		
		document.getElementById("tableContainer").innerHTML = "";
		CargarGrilla(codigo,descrip,Tipo, Marca, Modelo, Torre);
	}
	
  </script>
	<script>  
		$(document).ready(function() {
			CargarTipoEquipo();
			CargarMarcas();
			CargarTorre();
			CargarGrilla("","",0,0,0,0);
		});
		
		function CargarTipoEquipo()
		{
			$.ajax({
						type: "GET",
						url: "classes/Generales/getTipoEquipo.php",
						async: true,
						success: function(data){
							
							var selTipo = document.getElementById("selTipoEquipo");

						
							
							var data1 = JSON.parse(data);
							data1.forEach(row => {
								var opt = document.createElement("option");
								opt.value= row.IdTipoEquipo;
								opt.innerHTML = row.Descripcion; 

								selTipo.appendChild(opt);
							});
						}
			});
		}
		function CargarTorre()
		{
			$.ajax({
				type: "GET",
				url: "classes/Nodo/getNodos.php",
				async: true,
				success: function(data){
					
					var selTorre = document.getElementById("selTorre");
					var data1 = JSON.parse(data);
					data1.forEach(row => {
						var opt = document.createElement("option");
						opt.value= row.idNodo;
						opt.innerHTML = row.Nodo; 

						selTorre.appendChild(opt);
					});
				}
			});
		}
		function CargarMarcas()
		{
			$.ajax({
				type: "GET",
				url: "classes/Generales/getMarcas.php",
				async: true,
				success: function(data){
					
					var selMar = document.getElementById("selMarca");
					
					var opt; 
					var data1 = JSON.parse(data);
					data1.forEach(row => {
						opt = document.createElement("option");
						opt.value= row.idMarcaEquipo;
						opt.innerHTML = row.Descripcion; 

						selMar.appendChild(opt);
					});
				}
			});
			
		}
		function CargarModelos()
		{
			var marca = document.getElementById("selMarca").value;
			if(marca != 0)
			{
				$.ajax({
					type: "GET",
					url: "classes/Generales/getModelos.php?m="+marca,
					async: true,
					success: function(data){
						
						var sel = document.getElementById("selModelo");
						
						var opt = document.createElement("option");
						opt.value= 0;
						opt.innerHTML = "Seleccione"; 
						sel.appendChild(opt);
						
						var data1 = JSON.parse(data);
						data1.forEach(row => {
							opt = document.createElement("option");
							opt.value= row.idmodeloequipo;
							opt.innerHTML = row.descripcion; 

							sel.appendChild(opt);
						});
					}
				});
			}
		}
		
		function CargarGrilla(c,d,t, M, Mo, to)
		{
			document.getElementById("divResult").style.display = "none";
			var urltemp = 'classes/Equipo/getEquipos.php';
			if(c != "" || d != "" || t !=0 || M != 0 || Mo != 0 || to != 0)
				urltemp = urltemp + "?"
			
			if(c != "")
				urltemp = urltemp + "c="+c+"&";
			if(d != "")
				urltemp = urltemp + "d="+d+"&";
			if(t != 0)
				urltemp = urltemp + "t="+t+"&";
			if(M != 0)
				urltemp = urltemp + "m="+M+"&";
			if(Mo != 0)
				urltemp = urltemp + "mo="+Mo+"&";
			if(to != 0)
				urltemp = urltemp + "to="+to+"&";
			
			if(c != "" || d != "" || t !=0 || M != 0 || Mo != 0 || to != 0)
				urltemp = urltemp + "a=1";

			console.log(urltemp);
			$.ajax({
						type: "GET",
						url: urltemp,
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
						drawthTipoEquipo=document.createElement("th");
						drawthMarca=document.createElement("th");
						drawthModelo=document.createElement("th");
						drawthTorre=document.createElement("th");
						drawthFechaAlta=document.createElement("th");
						drawthActions=document.createElement("th"); 
						
						drawthCodigo.appendChild(document.createTextNode('Codigo'));
						drawthDescrip.appendChild(document.createTextNode('Descripción'));
						drawthTipoEquipo.appendChild(document.createTextNode('Tipo Equipo'));
						drawthMarca.appendChild(document.createTextNode('Marca'));
						drawthModelo.appendChild(document.createTextNode('Modelo'));
						drawthTorre.appendChild(document.createTextNode('Torre'));
						drawthFechaAlta.appendChild(document.createTextNode('Fecha Alta'));
						drawthActions.appendChild(document.createTextNode('Acciones'));
						
																
						drawtr.appendChild(drawthCodigo);		
						drawtr.appendChild(drawthDescrip);	
						drawtr.appendChild(drawthTipoEquipo);
						drawtr.appendChild(drawthMarca);
						drawtr.appendChild(drawthModelo);
						drawtr.appendChild(drawthTorre);
						drawtr.appendChild(drawthFechaAlta);		
						drawtr.appendChild(drawthActions);						
						drawHead.appendChild(drawtr);
																																  
																																  
						drawFoot=document.createElement("tfoot");
						drawtrFoot=document.createElement("tr");
						drawthCodigoFoot=document.createElement("th");
						drawthDescripFoot=document.createElement("th");
						drawthTipoEquipoFoot=document.createElement("th");
						drawthMarcaFoot=document.createElement("th");
						drawthModeloFoot=document.createElement("th");
						drawthTorreFoot=document.createElement("th");
						drawthFechaAltaFoot=document.createElement("th");
						drawthActionsFoot=document.createElement("th");
						
						drawthCodigoFoot.appendChild(document.createTextNode('Codigo'));
						drawthDescripFoot.appendChild(document.createTextNode('Descripción'));
						drawthTipoEquipoFoot.appendChild(document.createTextNode('Tipo Equipo'));
						drawthMarcaFoot.appendChild(document.createTextNode('Marca'));
						drawthModeloFoot.appendChild(document.createTextNode('Modelo'));
						drawthTorreFoot.appendChild(document.createTextNode('Torre'));
						drawthFechaAltaFoot.appendChild(document.createTextNode('Fecha Alta'));
						drawthActionsFoot.appendChild(document.createTextNode('Acciones'));		
						
						drawtrFoot.appendChild(drawthCodigoFoot);		
						drawtrFoot.appendChild(drawthDescripFoot);	
						drawtrFoot.appendChild(drawthTipoEquipoFoot);
						drawtrFoot.appendChild(drawthMarcaFoot);
						drawtrFoot.appendChild(drawthModeloFoot);
						drawtrFoot.appendChild(drawthTorreFoot);
						drawtrFoot.appendChild(drawthFechaAltaFoot);		
						drawtrFoot.appendChild(drawthActionsFoot);
						drawFoot.appendChild(drawtrFoot);
																																  
						tabBody=document.createElement("tbody");	
							
							
							var data1 = JSON.parse(data);
							data1.forEach(row => {
							rowTable=document.createElement("tr");

							colCodigo = document.createElement("td");
							colDescrip = document.createElement("td");
							colTipoEquipo = document.createElement("td");
							colMarca = document.createElement("td");
							colModelo = document.createElement("td");
							colTorre = document.createElement("td");
							colFechaAlta = document.createElement("td");
							colActions = document.createElement("td");
							
							colCodigo.appendChild(document.createTextNode(row.codigo));
							colDescrip.appendChild(document.createTextNode(row.Descripcion));
							colTipoEquipo.appendChild(document.createTextNode(row.TipoEquipo));
							colMarca.appendChild(document.createTextNode(row.marca));
							colModelo.appendChild(document.createTextNode(row.Modelo));
							colTorre.appendChild(document.createTextNode(row.Torre));
							
							colFechaAlta.appendChild(document.createTextNode(row.FechaAlta));
							
							var link = document.createElement("a");
							link.setAttribute('href', "EquipoEditar.php?m=R&id=" + row.idEquipo );
							link.setAttribute('class', "btn-sm btn-secondary mr-1");
							var btnsettings = document.createElement("i");
							btnsettings.setAttribute('class', "fas fa-cog text-white-50");
							link.appendChild(btnsettings);
							  
							var editlink = document.createElement("a");
							editlink.setAttribute('href', "EquipoEditar.php?m=E&id=" + row.idEquipo );
							editlink.setAttribute('class', "btn-sm btn-primary mr-1");
							var btnedit = document.createElement("i");
							btnedit.setAttribute('class', "fa fa-magic text-white-50");
							editlink.appendChild(btnedit);
							
							var remove = document.createElement("a");
							remove.setAttribute('href', "#");
							remove.setAttribute('class', "btn-sm btn-danger ");
							remove.setAttribute('onclick', "javascript:Desactivar("+ row.idEquipo+",'"+ row.codigo +"');");
							var btnremove = document.createElement("i");
							btnremove.setAttribute('class', "fas fa-trash text-white-50");
							remove.appendChild(btnremove);
							
							colActions.appendChild(link);
							colActions.appendChild(editlink);
							colActions.appendChild(remove);

							rowTable.appendChild(colCodigo);
							rowTable.appendChild(colDescrip);
							rowTable.appendChild(colTipoEquipo);
							rowTable.appendChild(colMarca);
							rowTable.appendChild(colModelo);
							rowTable.appendChild(colTorre);
							rowTable.appendChild(colFechaAlta);
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
		
		function ValidarComm()
		{
			var x = document.getElementsByName("chkSel");
			var i;
			for (i = 0; i < x.length; i++) {
				if (x[i].type == "checkbox") {
					if(x[i].checked == true)
					{
						alert(x[i].value);
					}
				}
			}
			
		}
		function Desactivar (id, codigo)
		{
			if (confirm("¿Esta seguro que desea desactivar el equipo "+ codigo +" ?")) {
				
				console.log("entre: "+id);
				urltemp = 'classes/Equipo/editarequipo.php?id='+id+'&fb=1';
				
				$.ajax({
					type: "GET",
					url: urltemp,
					success: function(data){
						console.log(data);
						if (data == 1)
						{
							document.getElementById("tableContainer").innerHTML = "";
							CargarGrilla("","",0,0,0,0);
							document.getElementById("divMensaje").innerHTML = "<p>El equipo "+codigo+" fue desactivado correctamente<p>";
							document.getElementById("divResult").style.display = "block";
						}
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
			<h1 class="h3 mb-4 text-gray-800">Gestión de Equipos</h1>
			<div class="col-lg-12 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-body">
					<p>Seleccione los filtros deseados.</p>
					<div class="row mb-4">
						
						<div class="col-2">
							<label for="Name">Código</label>
                            <input class="form-control" id="txtCodigo" name="txtCodigo" value="">
						</div>
						<div class="col-4">
							<label for="Username">Descripción</label>
                            <input class="form-control" id="txtDescrip" name="txtDescrip" value="">
						</div>
						<div class="col-3">
							<label for="Name">Tipo Equipo</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selTipoEquipo" name="selTipoEquipo"  tabindex="-1" aria-hidden="true">
								<option value="0"></option>
							</select>
						</div>
						
					</div>
					<div class="row mb-4">
						<div class="col-3">
							<label for="Username">Marca</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selMarca" name="selMarca"  onchange="javascript:CargarModelos();"  tabindex="-1" aria-hidden="true" >
								<option value="0"></option>
							</select>
						</div>
						<div class="col-3">
							<label for="Username">Modelo</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selModelo" name="selModelo"  tabindex="-1" aria-hidden="true">
								<option value="0"></option>
							</select>
						</div>
						<div class="col-3">
							<label for="Username">Torre</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selTorre" name="selTorre"  tabindex="-1" aria-hidden="true">
								<option value="0"></option>
							</select>
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
				<div class="my-2">
					<a href="EquipoNuevo.php" class="btn-lg btn-primary">Crear Nuevo</a>
				</div>
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
