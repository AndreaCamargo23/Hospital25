$(document).ready(function() {
    var opcion, id_usuario;
    id_usuario = "";
    opcion = 4;
    tablaUsuarios = $('#tablaUsuarios').DataTable({
        "ajax": {
            "url": "../baseDatos/crudUsuarios.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_usuario" },
            { "data": "nombre_usua" },
            { "data": "email" },
            { "data": "nombre_rol" },
            { "data": "estado" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnEditar' title='Editar'><i class='fas fa-user-edit'></i></button><button class='btn btn-dark btn-sm btnBorrar' title='Bloquear'><i class='fas fa-user-slash'></i></button></div></div>" }
        ]
    });

    var fila;
    $('#formUsuario').submit(function(e) {
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        texto = "";
        //permite que no salgan datos raros en el valor de la variable 
        email = $.trim($("#email").val());
        passwd = $.trim($("#passwd").val());
        nomUsua = $.trim($("#nomUsua").val());
        rol = $.trim($("#rol").val());
        estado = $.trim($("#estado").val());
        codigo = $.trim($("#codigo").val());

        //usar el formato de AJAX para el tratamiento de los datos 
        $.ajax({
            url: "../baseDatos/crudUsuarios.php",
            type: "POST",
            datatype: "json",
            data: {
                id_usuario: id_usuario,
                email: email,
                passwd: passwd,
                nomUsua: nomUsua,
                rol: rol,
                estado: estado,
                codigo: codigo,
                opcion: opcion
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario o Email Incorrectos',
                        confirmButtonText: 'Cambiar',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambios Guardados',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        window.location.href = './usuarios.php';
                    });
                    tablaUsuarios.ajax.reload(null, false);
                }
            }
        });
        $('#modalUsuario').modal('hide');
    });
    $("#btnAgregar").click(function() {
        opcion = 1; //Insertar o registrar el alumno 
        document.getElementById("passwd").disabled = false;
        //Referenciar el formulario
        $('#formUsuario').trigger("reset"); //Funcion para resetear o limpiar el formulario 
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("REGISTRAR USUARIO");
        $("#btnGuardar").text("Crear Usuario");
        $("#modalUsuario").modal('show');
    });
    //editar registros
    $(document).on('click', ".btnEditar", function() {
        fila = $(this).closest('tr'); //manipular el contenido de la clase
        id_usuario = parseInt(fila.find('td:eq(0)').text()); //trae el codigo en la posicion 0
        opcion = 5;
        email = "";
        datos = null;
        $.ajax({
            url: "../baseDatos/crudUsuarios.php",
            type: "POST",
            datatype: "json",
            data: {
                id_usuario: id_usuario,
                opcion: opcion
            },
            success: function(data) {
                email = JSON.parse(data);
                $("#email").val(email[0]["email"]);
                $('#passwd').val(email[0]["passwd"]);
                document.getElementById("passwd").disabled = true;
                $('#nomUsua').val(email[0]["nombre_usua"]);
                $('#rol').val(email[0]["id_rol_fk"]);
                $('#estado').val(email[0]["id_estado_fk"]);
                $('#codigo').val(email[0]["codigo"]);
            }
        });

        opcion = 2;
        //Referenciar el modal y agregar el titulo en el modal
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Modificar Información");
        $("#modalUsuario").modal('show');
        $("#btnGuardar").text("Actualizar");
        Swal.fire({
            icon: 'info',
            title: 'Ingreso a Editar',
            confirmButtonText: 'OK',
        });
    });
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this); //manipular el contenido de la clase
        id_usuario = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 3;
        var confirmacion = confirm("¿Esta seguro de bloquear el usuario No " + id_usuario + " ?");
        if (confirmacion) {
            //enviar por medio de ajax la respuesta
            $.ajax({
                url: "../baseDatos/crudUsuarios.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id_usuario: id_usuario },
                success: function(data) {
                    //buscar la fila que selecionamos y la borramos
                    if (data == "null") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrio un error al bloquear el usuario',
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'El usuario ha sido bloqueado',
                            confirmButtonText: 'OK',
                        });
                    }

                }
            });
            tablaUsuarios.ajax.reload(null, false);
        }
    });
});