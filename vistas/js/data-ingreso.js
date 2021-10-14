
$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 4;
    tablaIngreso = $('#tablaIngreso').DataTable({
        "ajax": {
            "url": "../baseDatos/crudIngreso.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_ingreso" },
            { "data": "fecha_ingreso" },
            { "data": "fecha_salida" },
            { "data": "descripcion" },
            { "data": "nombre" },
            { "data": "apellido" },
			{ "data": "id_habi" },
            { "data": "id_cama" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-outline-success btn-sm btnAgregarS' title='Agregar Servicio'><i class='fas fa-plus-circle'></i></button><button class='btn btn-outline-info btn-sm btnAgregarE' title='Agregar Empleado'><i class='fas fa-user-plus'></i></button></div></div><div class='text-center'><div class='btn-group'><button class='btn btn-outline-warning btn-sm btnConsultar' title='Ver servicios y empleados'><i class='fas fa-search-location'></i></button><button class='btn btn-outline-secondary btn-sm btnFactura' title='Generar factura, descargar historia clinica'><i class='fas fa-sign-out-alt'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formIngreso').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable
        fecha_ingreso = $.trim($("#starDate").val());
		fecha_salida = $.trim($("#endDate").val());
        descripcion = $.trim($("#descripcion").val());
        id_paciente = $.trim($("#paciente").val());
        cama = $.trim($("#cama").val());
		id_empleado = $.trim($("#empleado").val());
		id_servicio = $.trim($("#servicio").val());
        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudIngreso.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                fecha_ingreso: fecha_ingreso,
				fecha_salida: fecha_salida,
                descripcion: descripcion,
                id_paciente: id_paciente,
				id_servicio: id_servicio,
				id_empleado: id_empleado,
                cama: cama,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Registrar',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambios Guardados',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    tablaIngreso.ajax.reload(null, false);
                }
            }
        });
        $('#modalIngreso').modal('hide');
    });
    $("#btnAgregar").click(function() {
        opcion = 1; //Insertar o registrar el alumno 
        //Referenciar el formulario
        $('#formIngreso').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("REGISTRAR INGRESO");
        $("#btnGuardar").text("Crear");
        $("#modalIngreso").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnAgregarS", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;//Agregar servicio
		document.getElementById("servicioDiv").style.display = "block";//Ocultar el div 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Agregar Servicio");
		document.getElementById("empleadoDiv").style.display = "none";//Ocultar el div 
        $("#modalAgregar").modal('show');
        $("#botonAgregar").text("Agregar");
    });
	$(document).on('click', ".btnAgregarE", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 2;//Agregar servicio
        //Referenciar el modal y agregar el titulo en el modal
		document.getElementById("empleadoDiv").style.display = "block";
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Agregar Empleado");
		document.getElementById("servicioDiv").style.display = "none";//Ocultar el div 
        $("#modalAgregar").modal('show');
        $("#botonAgregar").text("Agregar");
    });
	
	$('#formAgregar').submit(function(e) {
        //evitar la acción del submit, para recargar la página
       e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable
        
		id_empleado = $.trim($("#empleado2").val());
		id_servicio = $.trim($("#servicio2").val());
        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudIngreso.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
				id_servicio: id_servicio,
				id_empleado: id_empleado,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Registrar',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambios Guardados',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    tablaIngreso.ajax.reload(null, false);
                }
            }
        });
        $('#modalAgregar').modal('hide');
    });	
	
	
    $(document).on("click", ".btnConsultar", function() {
        Swal.fire({
            icon: 'info',
            title: 'Revision de empleados y servicios',
            confirmButtonText: 'OK',
        });
		
        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
		opcion = 7;		
		$(document).ready(function() {
			tabla1 = $('#tabla1').DataTable({
				"ajax": {
					"url": "../baseDatos/crudIngreso.php",
					"method": 'POST',
					"data": { id:id,opcion: opcion },
					"dataSrc": ""
				},
				"columns": [
					{ "data": "id_empleado" },
					{ "data": "nombre" },
					{ "data": "apellido" }					
				]
			});
			opcion = 6;	
			tabla2 = $('#tabla2').DataTable({
				"ajax": {
					"url": "../baseDatos/crudIngreso.php",
					"method": 'POST',
					"data": { id:id,opcion: opcion },
					"dataSrc": ""
				},
				"columns": [
					{ "data": "id_servicio" },
					{ "data": "nombre" },
					{ "data": "valor_s" }					
				]
			});
			$("#ademas").modal('show');	
		});
		
    });
	$(document).on("click", ".btnFactura", function() {    
		
        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
		opcion = 8;	var email ="";
		$.ajax({
                url: "../baseDatos/crudIngreso.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function(data) {
                    if(data==null){                        
						generarPDF(id);
                    }else{
                        Swal.fire({
                            icon: 'info',
                            title: 'Factura generada correctamente, el paciente esta en estado fallecido',
                        });
						generarPDF(id);
                        //tablaIngreso.ajax.reload(null, false);
                    }
                }
            });
		
    });
});

function generarPDF(ingreso){
	var ancho = 1000; 
	var alto=800; 
	var x = parseInt((window.screen.width/2)-(ancho/2));
	var y = parseInt((window.screen.height/2)-(alto/2));
	$url ='../librerias/ingreso/factura.php?ci='+ingreso+'&f='+3;
	window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}