$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 4;
    tablaEmpleados = $('#tablaEmpleados').DataTable({
        "ajax": {
            "url": "../baseDatos/crudEmpleado.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_empleado" },
            { "data": "concat(nombre,apellido)" },
            { "data": "direccion" },
            { "data": "fecha_nac" },
            { "data": "email" },
            { "data": "cargo" },
            { "data": "estado" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnEditar' title='Editar'><i class='fas fa-user-edit'></i></button><button class='btn btn-dark btn-sm btnBorrar' title='Inactivar'><i class='fas fa-user-slash'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formEmpleado').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        id = $.trim($("#id").val());
        nom = $.trim($("#nom").val());
        ape = $.trim($("#ape").val());
        dire = $.trim($("#dire").val());
        fecha_nac = $.trim($("#fecha_nac").val());
        email = $.trim($("#email").val());
        cargo = $.trim($("#cargo").val());
        estado = $.trim($("#estado").val());

        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudEmpleado.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                nom: nom,
                ape: ape,
                dire: dire,
                fecha_nac: fecha_nac,
                email: email,
                cargo: cargo,
                estado: estado,
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
                    tablaEmpleados.ajax.reload(null, false);
                }
            }
        });
        $('#modalEmpleado').modal('hide');
    });
    $("#btnAddEmpleado").click(function() {
        opcion = 1; //Insertar o registrar el alumno 
        //Referenciar el formulario
        $('#formEmpleado').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("REGISTRAR EMPLEADO");
        $("#btnGuardar").text("Crear");
        $("#modalEmpleado").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnEditar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        datos = null;
        $.ajax({
            url: "../baseDatos/crudEmpleado.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#id").val(email[0]["id_empleado"]);
                $('#nom').val(email[0]["nombre"]);
                $('#ape').val(email[0]["apellido"]);
                $('#dire').val(email[0]["direccion"]);
                $("#fecha_nac").val(email[0]["fecha_nac"]);
                $('#email').val(email[0]["email"]);
                $('#cargo').val(email[0]["id_cargo_fk"]);
                $('#estado').val(email[0]["id_estado_fk"]);
            }
        });

        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar Información");
        $("#modalEmpleado").modal('show');
        $("#btnGuardar").text("Actualizar");
    });
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0);
        opcion = 3;
        var confirmacion = confirm("¿Esta seguro de marcar como inactivo el empleado con Identificación " + id + "?");
        if (confirmacion) {
            //enviar por medio de ajax la respuesta
            $.ajax({
                url: "../baseDatos/crudEmpleado.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function(data) {
                    //buscar la fila que selecionamos y la borramos
                    if (data == "null") {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo Inhabilitar el Empleado',
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Empleado quedo Inactivo',
                        });
                        tablaEmpleados.ajax.reload(null, false);
                    }
                }
            });

        }
    });
});