$(document).ready(function() {
    var opcion, id;
    id = "";

    var fila;

    $('#consulta').click(function(e) {
        opcion = 1;
        //evitar la acción del submit, para recargar la página
        e.preventDefault();
        tabla1 = $('#tabla1').DataTable({
            "ajax": {
                "url": "../baseDatos/crudInfoCam.php",
                "method": 'POST',
                "data": { opcion: opcion },
                "dataSrc": ""
            },
            "columns": [
                { "data": "id_cama" },
                { "data": "id_habi" },
                { "data": "nom" },
                { "data": "descripcion" },
                { "data": "nombre" }
            ]
        });
        $('#ademas').modal('show');
    });


    $(document).on("click", ".btnConsultar", function() {
        Swal.fire({
            icon: 'info',
            title: 'Revision de empleados y servicios',
            confirmButtonText: 'OK',
        });

        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 7;
        $(document).ready(function() {

            opcion = 6;
            tabla2 = $('#tabla2').DataTable({
                "ajax": {
                    "url": "../baseDatos/crudinfoCam.php",
                    "method": 'POST',
                    "data": { id: id, opcion: opcion },
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "id_servicio" },
                    { "data": "nombre" },
                    { "data": "valor_s" }
                ]
            });
            $("#ademas").modal('show');
        });

    });
    $(document).on("click", ".btnFactura", function() {
        Swal.fire({
            icon: 'info',
            title: 'Se acaba de generar su factura',
            confirmButtonText: 'OK',
        });

        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 7;

    });
});