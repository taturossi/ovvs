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
		var maps = document.getElementById("txtLinkMaps").value;
		var prov = document.getElementById("selProvincia").value;
		var ciudad = document.getElementById("selCiudad").value;
		var otros = document.getElementById("txtOtros").value;
		var ups = document.getElementById("txtUPS").value;
		var bat = document.getElementById("txtBaterias").value;
		var server = document.getElementById("txtServidor").value;
		var panel = document.getElementById("txtPanel").value;
		var regulador = document.getElementById("txtRegulador").value;
		var bocas = document.getElementById("txtBocas").value;
		
		urltemp = 'classes/nodo/nuevoNodo.php?codigo='+codigo+'&descrip='+descrip+'&maps='+maps+'&ciudad='+ciudad+'&otros='+otros+'&ups='+ups+'&bat='+bat+'&server='+server+'&panel='+panel+'&regulador='+regulador+'&bocas='+bocas;
		
		var resultnodo = 0;	
		var resultrouter = 0;	
		var resultswitch = 0;	
		var resultsantena = 0;	
		var idpadre = 0;
		
		$.ajax({
			type: "GET",
			async: false,
			url: urltemp,
			success: function(data){
				
				if (data >0)
				{
					resultnodo = data;
				}
			}
		});

		//Proceso list box de Routers
		var result = [];
		var options =document.getElementById("lstBoxRA").options;
		var opt;
		for (var i=0, ilen=options.length;i<ilen; i++) {
		
			opt = options[i];

			$.ajax({
			type: "GET",
			async: false,
			url: 'classes/nodo/asociarequipo.php?idEq='+opt.value+'&idNodo='+resultnodo+'&idEqPadre=0',
			success: function(data){
					if (data >0)
					{
						resultrouter = data;
						idpadre = opt.value;
					}
				}
			});
			
		}
		
		//Proceso listbox de switch
		options =document.getElementById("lstBoxSWA").options;
		if(options.length > 0)
		{
			opt = options[0];

			$.ajax({
			type: "GET",
			async: false,
			url: 'classes/nodo/asociarequipo.php?idEq='+opt.value+'&idNodo='+resultnodo+'&idEqPadre='+idpadre,
			success: function(data){
					if (data >0)
					{
						resultswitch = data;
						idpadre = opt.value;
					}
				}
			});
			
		}
		else
			resultswitch = 1;

		//Proceso listbox de antenas
		options =document.getElementById("lstBoxAA").options;
		if(options.length > 0)
		{
			for (var i=0, ilen=options.length;i<ilen; i++) {
				opt = options[i];

				$.ajax({
				type: "GET",
				async: false,
				url: 'classes/nodo/asociarequipo.php?idEq='+opt.value+'&idNodo='+resultnodo+'&idEqPadre='+idpadre,
				success: function(data){
						if (data >0)
						{
							resultsantena = data;
						}
					}
				});
			}
		}

		//Validacion final
		if(resultnodo != 0 && resultrouter != 0 && resultswitch != 0 && resultsantena != 0)
		{
			document.getElementById("txtCodigo").value = "";
			document.getElementById("txtDescrip").value = "";
			document.getElementById("txtLinkMaps").value = "";
			document.getElementById("selProvincia").value = 0;
			document.getElementById("selCiudad").value = 0;
			document.getElementById("txtOtros").value = "";
			document.getElementById("txtUPS").value = "";
			document.getElementById("txtBaterias").value = "";
			document.getElementById("txtServidor").value = "";
			document.getElementById("txtPanel").value = "";
			document.getElementById("txtRegulador").value = "";
			document.getElementById("txtBocas").value = "";	
			LimpiarListas();
			CargarEquipos();
			document.getElementById("divMensaje").innerHTML = "<p>El nodo "+descrip+" fue creado correctamente<p>";
			document.getElementById("divResult").style.display = "block";
			
		}
		
	}
	
	function Validar()
	{

		var codigo = document.getElementById("txtCodigo").value;
		var descrip = document.getElementById("txtDescrip").value;
		var prov = document.getElementById("selProvincia").value;
		var ciudad = document.getElementById("selCiudad").value;
		var routers = document.getElementById("lstBoxRA").options.length;
		var sw = document.getElementById("lstBoxSWA").options.length;
		var antenas = document.getElementById("lstBoxAA").options.length;

		var mensaje = "";
		if(codigo == "")
		{
			mensaje = mensaje + "<p>Por favor ingrese el codigo del nodo.<p>"
		}
		else
		{
			$.ajax({
			type: "GET",
			url: 'classes/Nodo/getNodoPorCodigo.php?c='+codigo,
			success: function(data){
				if(data != "")
					mensaje =  mensaje + "<p>El código ingresado ya existe para un nodo existente.<p>"
			},
			async: false
			});
			
		}
		
		if(document.getElementById("txtDescrip").value == "")
		{
			mensaje = mensaje + "<p>Por favor ingrese la descripción del tipo de movimiento.<p>"
		}
		
		if(prov == 0)
		{
			mensaje = mensaje + "<p>Por favor seleccione la  provincia donde se encuentra el nodo.<p>"
		}
		if(ciudad == 0)
		{
			mensaje = mensaje + "<p>Por favor seleccione la  ciudad donde se encuentra el nodo.<p>"
		}

		if(sw > 0 || antenas > 0) 
		{
			if(routers == 0)
				mensaje = mensaje + "<p>Por favor debe asignar un router al nodo para la conexion de los demas equipos.<p>";
		}

		if(routers > 1)
		{
			mensaje = mensaje + "<p>Por favor debe asignar solo un router al nodo para la conexion de los demas equipos.<p>";
		}

		if(sw > 1)
			mensaje = mensaje + "<p>Por favor debe asignar solo un switch al nodo para la conexion de los demas equipos.<p>";


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
			CargarEquipos();
			CargarGrillaAntenas();
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
						opt.innerHTML = row.Descripcion; 

						selCiu.appendChild(opt);
					});
				}
			});
		}
	}
	function LimpiarListas()
	{
		var sel = document.getElementById("lstBoxRD");
		var i;
		for(i = sel.options.length - 1 ; i >= 0 ; i--)
			sel.remove(i);
			
		sel = document.getElementById("lstBoxRA");
		for(i = sel.options.length - 1 ; i >= 0 ; i--)
			sel.remove(i);
		
		sel = document.getElementById("lstBoxSWA");
		for(i = sel.options.length - 1 ; i >= 0 ; i--)
			sel.remove(i);
			
		sel = document.getElementById("lstBoxSWD");
		for(i = sel.options.length - 1 ; i >= 0 ; i--)
			sel.remove(i);
		
		sel = document.getElementById("lstBoxAA");
		for(i = sel.options.length - 1 ; i >= 0 ; i--)
			sel.remove(i);
		
		sel = document.getElementById("lstBoxAD");
		for(i = sel.options.length - 1 ; i >= 0 ; i--)
			sel.remove(i);
		
	}
	function CargarEquipos()
	{
		$.ajax({
					type: "GET",
					url: "classes/Equipo/getEquiposSinAsignar.php",
					async: true,
					success: function(data){
						
						var selRout = document.getElementById("lstBoxRD");
						var selSwitch = document.getElementById("lstBoxSWD");
						var selAntena = document.getElementById("lstBoxAD");
					
						//1-R, 2-S, 4-a
						var data1 = JSON.parse(data);
						data1.forEach(row => {
							var opt = document.createElement("option");
							opt.value= row.idEquipo;
							opt.innerHTML = row.codigo +"-"+ row.Descripcion; 
							if(row.idTipoEquipo == 1)
								selRout.appendChild(opt);
							else if(row.idTipoEquipo == 2)
								selSwitch.appendChild(opt);
							else if(row.idTipoEquipo == 4)
								selAntena.appendChild(opt); 
						});
					}
		});
	}
	function CargarGrillaAntenas()
	{
		tabContainer=document.getElementById("tableContainer");

		drawTable=document.createElement("table");
		drawTable.setAttribute('class', "table table-bordered dataTable");
		drawTable.setAttribute('id', "tblAntenas");
		drawTable.setAttribute('width', "100%");
		drawTable.setAttribute('cellspacing', "0");
		drawHead=document.createElement("thead");
		drawtr=document.createElement("tr");
		drawthCodigo=document.createElement("th");
		drawthMod=document.createElement("th");
		drawthFrecs=document.createElement("th");
		drawthAB=document.createElement("th");
		drawthFrec=document.createElement("th");
		drawthCodigo.appendChild(document.createTextNode('Cod-Desc'));
		drawthMod.appendChild(document.createTextNode('Modalidad'));
		drawthFrecs.appendChild(document.createTextNode('Frecuencias'));
		drawthAB.appendChild(document.createTextNode('AB'));
		drawthFrec.appendChild(document.createTextNode('Frecuencia'));
		
																													
		drawtr.appendChild(drawthCodigo);		
		drawtr.appendChild(drawthMod);	
		drawtr.appendChild(drawthFrecs);
		drawtr.appendChild(drawthAB);
		drawtr.appendChild(drawthFrec);						
		drawHead.appendChild(drawtr);																											
																													
		drawFoot=document.createElement("tfoot");
		drawtrFoot=document.createElement("tr");
		drawthCodigoFoot=document.createElement("th");
		drawthModFoot=document.createElement("th");
		drawthFrecsFoot=document.createElement("th");
		drawthABFoot=document.createElement("th");
		drawthFrecFoot=document.createElement("th");

		drawthCodigoFoot.appendChild(document.createTextNode('Cod-Desc'));
		drawthModFoot.appendChild(document.createTextNode('Modalidad'));
		drawthFrecsFoot.appendChild(document.createTextNode('Frecuencias'));
		drawthABFoot.appendChild(document.createTextNode('AB'));
		drawthFrecFoot.appendChild(document.createTextNode('Frecuencia'));
		
		drawtrFoot.appendChild(drawthCodigoFoot);		
		drawtrFoot.appendChild(drawthModFoot);	
		drawtrFoot.appendChild(drawthFrecsFoot);
		drawtrFoot.appendChild(drawthABFoot);		
		drawtrFoot.appendChild(drawthFrecFoot);	
		drawFoot.appendChild(drawtrFoot);
																													
		tabBody=document.createElement("tbody");	
			
		rowTable=document.createElement("tr");

		colCodigo = document.createElement("td");
		colMod = document.createElement("td");
		colFrecs = document.createElement("td");
		colAB = document.createElement("td");
		colFrec = document.createElement("td");
			
		
		colCodigo.appendChild(document.createTextNode("aa"));
		colMod.appendChild(document.createTextNode("aa"));
		colFrecs.appendChild(document.createTextNode("aa"));
		colAB.appendChild(document.createTextNode("aa"));
		colFrec.appendChild(document.createTextNode("aa"));
		/*
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
		*/
		rowTable.appendChild(colCodigo);
		rowTable.appendChild(colMod);
		rowTable.appendChild(colFrecs);
		rowTable.appendChild(colAB);
		rowTable.appendChild(colFrec);
		
		tabBody.appendChild(rowTable);
		
		drawTable.appendChild(drawHead);
		drawTable.appendChild(drawFoot);
		drawTable.appendChild(tabBody);
		tabContainer.appendChild(drawTable);
		$('#tblAntenas').DataTable();
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
							<label for="Name">Código *</label>
                            <input class="form-control" id="txtCodigo" name="txtCodigo" value="">
						</div>
						<div class="col-4">
							<label for="Username">Descripción *</label>
                            <input class="form-control" id="txtDescrip" name="txtDescrip" value="">
						</div>
						<div class="col-4">
							<label for="Currency">Link Maps</label>
                            <input class="form-control" id="txtLinkMaps" name="txtLinkMaps" value="">
                        </div>
					</div>
					<div class="row mb-4">
						
						<div class="col-4">
							<label for="Name">Provincia *</label>
                            <select class="form-control select2-hidden-accessible" data-val="true"  id="selProvincia" name="selProvincia" onchange="javascript:CargarCiudades();"  tabindex="-1" aria-hidden="true">
								<option value="0">Seleccione</option>
							</select>
						</div>
						<div class="col-4">
							<label for="Username">Ciudad *</label>
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
							  <select multiple="multiple" id='lstBoxRD' class="form-control">
								
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
							  <select multiple="multiple" id='lstBoxRA' class="form-control">
								
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
						<div class="col-6">
							<label for="Currency">Antenas Asignados</label>
							<div class="subject-info-box-2">
							  <select multiple="multiple" id='lstBoxAA' class="form-control">
								
							  </select>
							</div>
							<div class="table-responsive" id="tableContainer">
               
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
