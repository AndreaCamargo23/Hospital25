$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 1;
    tablaServicios = $('#tablaServicios').DataTable({
        "ajax": {
            "url": "../baseDatos/crudinfoSer.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_servicio" },
            { "data": "nombre" },
            { "data": "COUNT(*)" }
        ]
    });

    var fila;

    $('#formServicio').submit(function(e) {
        e.preventDefault();
        texto = "";
        fecha_entrada = $.trim($("#fecha_entrada").val());
        fecha_salida = $.trim($("#fecha_salida").val());
        $("#fecha_e").val(fecha_entrada);
        $("#fecha_s").val(fecha_salida);
        opcion = 2;
        tabla2 = $('#tabla2').DataTable({
            "ajax": {
                "url": "../baseDatos/crudinfoSer.php",
                "method": 'POST',
                "data": { fecha_entrada: fecha_entrada, fecha_salida: fecha_salida, opcion: opcion },
                "dataSrc": ""
            },
            "columns": [
                { "data": "nombre" },
                { "data": "COUNT(*)" }
            ]
        });
        $(".modal-header").css("background-color", "");
        $(".modal-header").css("color", "black");
        $(".modal-title").text("Servicios Adquiridos");
        $("#modalInforme").modal('show');

    });
});