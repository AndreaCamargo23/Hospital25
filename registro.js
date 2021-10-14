$("#formregistro").submit(function(e) {
    e.preventDefault();
    var opcion, id_usuario;
    id_usuario = "";
    text = "";
    var user = $.trim($("#u41_input").val());
    var rol = $.trim($("#rol").val());
    var email = $.trim($("#u45_input").val());
    var password = $.trim($("#u42_input").val());
    var codigo = document.getElementById('codigo').innerText;
    var estado = "1";

    if (user == "" || rol == "Seleccione una opción" || email == "" || password == "" || codigo == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Por favor llene cada uno de los espacios del Registro',
        });
        return false;
    } else {
        $.ajax({
            url: './baseDatos/registro_i.php',
            type: 'POST',
            dataType: 'json',
            data: { id_usuario: id_usuario, email: email, password: password, rol: rol, estado: estado, user: user, codigo: codigo },
            success: function(data) {
                if (data == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario o el Email ya se encuentra Registrado',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario Creado',
                        confirmButtonColor: '#',
                        confirmButtonText: 'Volver a Iniciar Sesión',
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = './login.php';
                        }
                    });
                }
            }
        });
    }
});