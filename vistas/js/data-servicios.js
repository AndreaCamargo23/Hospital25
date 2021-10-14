$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 4;
	tablaServicio = $('#tablaServicio').DataTable({
        "ajax": {
            "url": "../baseDatos/crudServicios.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_servicio" },
            { "data": "nombre" },
            { "data": "valor_s" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnEditar' title='Editar'><i class='fas fa-user-edit'></i></button><button class='btn btn-warning btn-sm btnBorrar' data-toggle='Disponible' title='Ver habitaciones disponibles que aun tienen camas disponibles'><i class='fas fa-search-location'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formServicio').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        name = $.trim($("#name").val());
        valor = $.trim($("#valor").val());

        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudServicios.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                name: name,
                valor: valor,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo agregar los servicios',
                        confirmButtonText: 'Cambiar',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Servicio Guardado',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        window.location.href = './servicios.php';
                    });
                    tablaServicio.ajax.reload(null, false);
                }
            }
        });
        $('#modalServicio').modal('hide');
    });
    $("#btnAgregar").click(function() {
        opcion = 1; //Insertar o registrar el alumno 
        //Referenciar el formulario
        $('#formServicio').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("REGISTRAR");
        $("#btnGuardar").text("Crear");
        $("#modalServicio").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnEditar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        datos = null;
        $.ajax({
            url: "../baseDatos/crudServicios.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                opcion: opcion
            },
            success: function(data) {				
                email = JSON.parse(data);
                $("#name").val(email[0]["nombre"]);
                $('#valor').val(email[0]["valor_s"]);
            }
        });

        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar");
        $("#modalServicio").modal('show');
        $("#btnGuardar").text("Actualizar");
        Swal.fire({
            icon: 'info',
            title: 'Ingreso a Editar',
            confirmButtonText: 'OK',
        });
    });
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
		opcion = 3;
		$(document).ready(function() {
			tabla2 = $('#tabla2').DataTable({
				"ajax": {
					"url": "../baseDatos/crudServicios.php",
					"method": 'POST',
					"data": { id:id,opcion: opcion },
					"dataSrc": ""
				},
				"columns": [
					{ "data": "id_habi" },
					{ "data": "camas" }					
				]
			});
			
		});
        $("#Disponibles").modal('show');
    });
});