$("#formrecuperar").submit(function(e) {
    e.preventDefault();

    var user = $.trim($("#u63_input").val());
    var password = $.trim($("#u64_input").val());
    var codigo = $.trim($("#u65_input").val());

    if (user == "" || password == "" || codigo == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Por favor llene cada uno de los Espacios',
        });
        return false;
    } else {
        $.ajax({
            url: './baseDatos/recuperar_i.php',
            type: 'POST',
            dataType: 'json',
            data: { user: user, password: password, codigo: codigo },
            success: function(data) {
                if (data == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'el Usuario o el Código son incorrectos',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Contraseña Cambiada',
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