$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 4;
    tablaPaciente = $('#tablaPaciente').DataTable({
        "ajax": {
            "url": "../baseDatos/crudPaciente.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_paciente" },
            { "data": "concat(nombre, apellido)" },
            { "data": "direccion" },
            { "data": "fecha_nac" },
            { "data": "celular" },
            { "data": "email" },
            { "data": "genero" },
            { "data": "rh" },
            { "data": "estado" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnEditar' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-dark btn-sm btnBorrar' title='Fallecido'><i class='fas fa-times'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formPaciente').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        var memo = document.getElementsByName('genero');
        for (i = 0; i < memo.length; i++) {
            if (memo[i].checked) {
                //var memory=memo[i].checked;
                var genero = memo[i].value;
            }
        }
        id = $.trim($("#id").val());
        nom = $.trim($("#nom").val());
        ape = $.trim($("#ape").val());
        dire = $.trim($("#dire").val());
        fecha_nac = $.trim($("#fecha_nac").val());
        email = $.trim($("#email").val());
        celu = $.trim($("#celu").val());
        rh = $.trim($("#rh").val());
        estado = $.trim($("#estado").val());

        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudPaciente.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                nom: nom,
                ape: ape,
                dire: dire,
                fecha_nac: fecha_nac,
                email: email,
                celu: celu,
                genero: genero,
                rh: rh,
                estado: estado,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'El Paciente ya se encuentra Registrado',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambios Guardados',
                    });
                    tablaPaciente.ajax.reload(null, false);
                }
            }
        });
        $('#modalPaciente').modal('hide');
    });
    $("#btnNuevo").click(function() {
        opcion = 1; //Insertar o registrar el alumno 
        //Referenciar el formulario
        $('#formPaciente').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $('#estado').prop('disabled', false);
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("REGISTRAR PACIENTE");
        $("#btnGuardar").text("Crear");
        $("#modalPaciente").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnEditar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        datos = null;
        $.ajax({
            url: "../baseDatos/crudPaciente.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#id").val(email[0]["id_paciente"]);
                $('#nom').val(email[0]["nombre"]);
                $('#ape').val(email[0]["apellido"]);
                $('#dire').val(email[0]["direccion"]);
                $("#fecha_nac").val(email[0]["fecha_nac"]);
                $('#email').val(email[0]["email"]);
                $('#celu').val(email[0]["celular"]);
                $('#rh').val(email[0]["id_rh_fk"]);
                $('#genero').val(email[0]["id_genero_fk"]);
                $('#estado').val(email[0]["id_estado_fk"]);

                var memo = document.getElementsByName('genero');
                for (i = 0; i < memo.length; i++) {
                    if (memo[i].value == email[0]["id_genero_fk"]) {
                        //var memory=memo[i].checked;
                        memo[i].checked = true;
                        var genero = memo[i].value;
                    }
                }
                $('#estado').prop('disabled', true);
            }
        });

        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar Información");
        $("#modalPaciente").modal('show');
        $("#btnGuardar").text("Actualizar");
    });
    $(document).on("click", ".btnBorrar", function() { //Cuando se le de salida al paciente se efectuara la factura del paciente y quedara en estado de deuda hasta que la factura este pagada 
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0);
        opcion = 3;
        var confirmacion = confirm("¿Esta seguro que dese marcar como fallecido el paciente " + id + "?");

        if (confirmacion) {
            //enviar por medio de ajax la respuesta
            $.ajax({
                url: "../baseDatos/crudPaciente.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function(data) {
                    //buscar la fila que selecionamos y la borramos
                    if (data==null) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error, La factura ya se encuentra generada y el estado cambiado',
                        });
                    }else{
                        Swal.fire({
                            icon: 'info',
                            title: 'El Paciente se encuentra en estado fallecido, factura generada',
                        });	
						tablaPaciente.ajax.reload(null, false);
                    }
                }
            });

        }
    });
    $('#formIngreso').submit(function(e) {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        datos = null;
        $.ajax({
            url: "../baseDatos/crudPaciente.php",
            type: "POST",
            datatype: "json",
            data: {
                id: id,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#id").val(email[0]["id_paciente"]);
                $('#nom').val(email[0]["nombre"]);
                $('#ape').val(email[0]["apellido"]);
                $('#dire').val(email[0]["direccion"]);
                $("#fecha_nac").val(email[0]["fecha_nac"]);
                $('#email').val(email[0]["email"]);
                $('#celu').val(email[0]["celular"]);
                $('#rh').val(email[0]["id_rh_fk"]);
                $('#genero').val(email[0]["id_genero_fk"]);
                $('#estado').val(email[0]["id_estado_fk"]);

                var memo = document.getElementsByName('genero');
                for (i = 0; i < memo.length; i++) {
                    if (memo[i].value == email[0]["id_genero_fk"]) {
                        //var memory=memo[i].checked;
                        memo[i].checked = true;
                        var genero = memo[i].value;
                    }
                }
                $('#estado').prop('disabled', true);
            }
        });
        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar Información");
        $("#modalPaciente").modal('show');
        $("#btnGuardar").text("Actualizar");
    });
});
