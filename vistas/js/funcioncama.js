$(document).ready(function() {
    var opcion, id_cama;
    id_cama = "";
    opcion = 4;
    tablaCama = $('#tablaCama').DataTable({
        "ajax": {
            "url": "../baseDatos/crudCamas.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_cama" },
            { "data": "valor_c" },
            { "data": "tipo" },
            { "data": "id_habitacion_fk" },
            { "data": "estado" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnEditar' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-warning btn-sm btnBorrar' title='Desactivar'><i class='fas fa-ban'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formCama').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        valor_c = $.trim($("#valor_c").val());
        tipo = $.trim($("#tipo").val());
        id_habitacion_fk= $.trim($("#habitacion").val());
        estado = $.trim($("#estado").val());
        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudCamas.php",
            type: "POST",
            datatype: "json",
            data: {
                id_cama: id_cama,
                valor_c: valor_c,
                tipo: tipo,
                id_habitacion_fk: id_habitacion_fk,
                estado: estado,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al registrar la cama',
                        confirmButtonText: 'Cambiar',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cama Guardada'+ id_habitacion_fk,
                        confirmButtonText: 'OK',
                    });
                    tablaCama.ajax.reload(null, false);
                }
            }
        });
        $('#modalCama').modal('hide');
    });
    $("#btnAgregar").click(function() {
        opcion = 1; //Insertar o registrar el alumno
        //Referenciar el formulario
        $('#formCama').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Registrar Cama");
        $("#btnGuardar").text("Crear Cama");
        $("#modalCama").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnEditar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id_cama = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        $.ajax({
            url: "../baseDatos/crudCamas.php",
            type: "POST",
            datatype: "json",
            data: {
                id_cama: id_cama,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#valor_c").val(email[0]["valor_c"]);
                $('#tipo').val(email[0]["id_tipo_fk"]);
                $('#habitacion').val(email[0]["id_habitacion_fk"]);
                $('#estado').val(email[0]["id_estado_fk"]);
            }
        });

        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar Información");
        $("#modalCama").modal('show');
        $("#btnGuardar").text("Actualizar");
        Swal.fire({
            icon: 'info',
            title: 'Ingreso a Editar',
            confirmButtonText: 'OK',
        });
    });
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this); //manipular el contenido de la clase
        id_cama = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 3;
        var confirmacion = confirm("¿Esta seguro de desactivar la cama " + id_cama + " ?");
        if (confirmacion) {
            //enviar por medio de ajax la respuesta
            $.ajax({
                url: "../baseDatos/crudCamas.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id_cama: id_cama },
                success: function(data) {
                    //buscar la fila que selecionamos y la borramos
                    if (data == "null") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrio un error al desactivar la cama',
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'La cama ha sido bloqueada',
                            confirmButtonText: 'OK',
                        });
                    }

                }
            });
            tablaCama.ajax.reload(null, false);
        }
    });
});