$(document).ready(function() {
    var opcion, id;
    id = "";
    opcion = 2;
    tablaInformes = $('#tablaInformes').DataTable({
        "ajax": {
            "url": "../baseDatos/crud_infoFact.php",
            "method": 'POST',
            "data": { opcion: opcion },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_info" },
            { "data": "tipo" },
            { "data": "starDate" },
            { "data": "endDate" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-outline-info btn-sm btnDescargar' title='Desccargar'><i class='fas fa-download'></i></button><button class='btn btn-outline-danger btn-sm btnBorrar' title='Borrar'><i class='fas fa-trash-alt'></i></button></div></div>" }
        ]
    });
	$('#info_facturas').submit(function(e) {
		alert('entro');	
		startDate = $.trim($("#start").val());
		endDate = $.trim($("#end").val());
		tipo = $.trim($("#tipo").val());
		if(tipo=="3"){
			e.preventDefault();
			document.getElementById("tipo").focus();
			Swal.fire({
				icon: 'warning',
				title: 'Por favor llene cada uno de los espacios',
			});				
		}else{
			startDate = $.trim($("#start").val());
		endDate = $.trim($("#end").val());
		tipo = $.trim($("#tipo").val());
			opcion =1;
			$.ajax({
				url: "../baseDatos/crud_infoFact.php",
				type: "POST",
				datatype: "json",
				data: {
					startDate: startDate,
					endDate: endDate,
					tipo: tipo,
					opcion: opcion
				},
				success: function(data) {
					if (data == "null") {
						Swal.fire({
							icon: 'error',
							title: 'No fue encontrada la informacion',
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Informe Generado',
						});
						tablaInformes.ajax.reload(null, false);
					}
				}
			});
		}
	});
	
	$(document).on("click", ".btnBorrar", function() {    
		
        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
		opcion = 3;	
		Swal.fire({
		  title: 'Seguro que desea eliminar el informe?',
		  showDenyButton: true,
		  showCancelButton: true,
		  confirmButtonText: 'Save',
		  denyButtonText: `Don't save`,
		}).then((result) => {
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
			$.ajax({
                url: "../baseDatos/crud_infoFact.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function(data) {
                    if(data=="null"){                        
						Swal.fire({
                            icon: 'error',
                            title: 'Error al eliminar el informe',
                        });
                    }else{
                        Swal.fire({
                            icon: 'info',
                            title: 'Informe eliminado',
                        });
                        tablaInformes.ajax.reload(null, false);
                    }
                }
            });
		  } else if (result.isDenied) {
			Swal.fire('Changes are not saved', '', 'info')
		  }
		});	
		
    });
	
	$(document).on("click", ".btnDescargar", function() {    
		
        fila = $(this); //manipular el contenido de la clase
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
		opcion = 8;	var email ="";
		generarPDF(id);
    });
});

function generarPDF(informe){
	var ancho = 1000; 
	var alto=800; 
	var x = parseInt((window.screen.width/2)-(ancho/2));
	var y = parseInt((window.screen.height/2)-(alto/2));
	$url ='../librerias/ingreso/info_factura.php?ci='+informe+'&f='+3;
	window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}