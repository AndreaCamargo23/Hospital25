$(document).ready(function() {
    var opcion, id_habi,id_habi2;
    id_habi = "";
	id_habi2 = "";
    opcion = 4;
	tablaHabitacion = $('#tablaHabitacion').DataTable({
        "ajax": {
            "url": "../baseDatos/crudHabitacion.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_habi" },
            { "data": "camas" },
            { "data": "estado" },
            { "data": "disponibles" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnEditar' title='Agregar cama'><i class='fas fa-plus-square'></i></button><button class='btn btn-warning btn-sm btnBorrar' title='Ver Pacientes'><i class='fas fa-search-location'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formHabitacion').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        id_habi = $.trim($("#id_habi").val());
        id_servicio = $.trim($("#id_servicio").val());

        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudHabitacion.php",
            type: "POST",
            datatype: "json",
            data: {
                id_habi: id_habi,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo agregar la habitacion '+id_servicio,
                        confirmButtonText: 'Ok',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Habitacion Guardado',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        window.location.href = './habitacion.php';
                    });
                    tablaHabitacion.ajax.reload(null, false);
                }
            }
        });
        $('#modalHabitacion').modal('hide');
    });
    $("#btnAgregar").click(function() {
        opcion = 1; //Insertar o registrar el alumno 
        //Referenciar el formulario
        $('#formHabitacion').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("REGISTRAR");
        $("#btnGuardar").text("Crear");
        $("#modalHabitacion").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnEditar", function() {//Agregar una cama
        fila = $(this).closest('tr'); 
        id_habi = parseInt(fila.find('td:eq(0)').text());
		$('#formCama').trigger("reset"); //Funcion para resetear o limpiar el formulario 
		Swal.fire({
            icon: 'info',
            title: 'Ingreso para registrar una cama',
            confirmButtonText: 'OK',
        });
		opcion = 2;
		$(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
		$(".modal-title").text("Agregar Cama");
        $("#Disponibles").modal('show');        
    });
	$('#formCama').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        valorCama = $.trim($("#valorCama").val());
		tipo = $.trim($("#tipo").val());
        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudHabitacion.php",
            type: "POST",
            datatype: "json",
            data: {
                id_habi: id_habi,
				valorCama: valorCama,
				tipo: tipo,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo agregar la cama a la habitacion'+id_habi,
                        confirmButtonText: 'Ok',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cama Guardado',
                        confirmButtonText: 'OK',
                    });
                    tablaHabitacion.ajax.reload(null, false);
                }
            }
        });
        $('#Disponibles').modal('hide');
		
    });
    $(document).on("click", ".btnBorrar", function() {//Mostrar los datos en el modal del paciente
		Swal.fire({
            icon: 'info',
            title: 'Revision de pacientes',
            confirmButtonText: 'OK',
        });
		
        fila = $(this); //manipular el contenido de la clase
        id_habi = parseInt($(this).closest('tr').find('td:eq(0)').text());
		opcion = 3;		
		$(document).ready(function() {
			tabla2 = $('#tabla2').DataTable({
				"ajax": {
					"url": "../baseDatos/crudHabitacion.php",
					"method": 'POST',
					"data": { id_habi:id_habi,opcion: opcion },
					"dataSrc": ""
				},
				"columns": [
					{ "data": "id_paciente" },
					{ "data": "nombre" },
					{ "data": "apellido" }					
				]
			});			
		});
		$("#pacientes").modal('show');		
    });
});