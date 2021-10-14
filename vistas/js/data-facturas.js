$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 4;
    tablaFacturas = $('#tablaFacturas').DataTable({
        "ajax": {
            "url": "../baseDatos/crudFacturas.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_fact" },
            { "data": "fecha_factura" },
            { "data": "fecha_pago" },
            { "data": "valor_total" },
            { "data": "estado" },
            { "data": "id_ingreso_fk" },
            { "data": "fecha_vencimiento" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-outline-success btn-sm btnEditar' title='Editar'><i class='fas fa-user-edit'></i></button><button class='btn btn-outline-warning btn-sm btnBorrar' data-toggle='Disponible' title='Servicios del ingreso'><i class='fas fa-search-location'></i></button><button class='btn btn-outline-primary btn-sm btnDescargar' data-toggle='Disponible' title='Descargar Factura'><i class='fas fa-download'></i></button></div></div>" }
        ]
    });

    var fila;

    $('#formVencimiento').submit(function(e) {
        e.preventDefault();
        texto = "";
        fecha_vencimiento = $.trim($("#fecha_vencimiento").val());

        $.ajax({
            url: "../baseDatos/crudFacturas.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                fecha_vencimiento: fecha_vencimiento,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo agregar la Factura',
                        confirmButtonText: 'Cambiar',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Factura Guardada',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        tablaFacturas.ajax.reload(null, false);
                    });

                }
            }
        });
        $('#modalModificar').modal('hide');
    });

    //editar registros
    $(document).on('click', ".btnEditar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        datos = null;
        $.ajax({
            url: "../baseDatos/crudFacturas.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#fecha_vencimiento").val(email[0]["fecha_vencimiento"]);
            }
        });

        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar Fecha de Vencimiento");
        $("#modalModificar").modal('show');
        $("#btnGuardar").text("Actualizar");
        Swal.fire({
            icon: 'info',
            title: 'Ingreso a Editar',
            confirmButtonText: 'OK',
        });
    });
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);
        id = parseInt($(this).closest('tr').find('td:eq(5)').text());
        opcion = 3;
        $.ajax({
            url: "../baseDatos/crudFacturas.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#nom_paciente").val(email[0]["nombre"] + " " + email[0]["apellido"]);
                $("#valor_cama").val(email[0]["valor_c"]);
                $("#valor_total").val(email[0]["valor_total"]);
            }
        });

        opcion = 1;
        $(document).ready(function() {
            tabla2 = $('#tabla2').DataTable({
                "ajax": {
                    "url": "../baseDatos/crudFacturas.php",
                    "method": 'POST',
                    "data": { id: id, opcion: opcion },
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "nombre" },
                    { "data": "valor_s" }
                ]
            });

        });

        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Servicios Prestados");
        $("#modalServicio").modal('show');
    });
	$(document).on("click", ".btnDescargar", function() {
		fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(5)').text());
		Swal.fire({
            icon: 'success',
            title: 'Factura Guardada',
            confirmButtonText: 'OK',
        });		
		generarPDF(id);
	});
});
function generarPDF(ingreso){
	var ancho = 1000; 
	var alto=800; 
	var x = parseInt((window.screen.width/2)-(ancho/2));
	var y = parseInt((window.screen.height/2)-(alto/2));
	$url ='../librerias/ingreso/factura.php?ci='+ingreso;
	window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}