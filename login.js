$("#formlogin").submit(function(e) {
    e.preventDefault();
    var user = $.trim($("#u22_input").val());
    var password = $.trim($("#u23_input").val());
    if (user.length == "" || password.length == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Por favor digite el Usuario y la Contraseña',
        });
        return false;
    } else {
        $.ajax({
            url: './baseDatos/login_i.php',
            type: 'POST',
            dataType: 'json',
            data: { user: user, password: password },
            success: function(data) {
                if (data == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario y Contraseña Incorrectos',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sesión Iniciada',
                        confirmButtonColor: '#',
                        confirmButtonText: 'Ingresar',
                    }).then((result) => {
                        rol = data[0]["id_rol_fk"];
                        if (rol == 1) {
                            window.location.href = './vistas/indexAdmi.php';
                        }
                        if (rol == 2) {
                            window.location.href = './vistas/indexEmple.php';
                        }
                        if (rol == 3) {
                            window.location.href = './vistas/indexPacie.php';
                        }
                    });
                }
            }
        });
    }
});