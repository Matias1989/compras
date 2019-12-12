$(buscar_datos());

function buscar_datos(consulta){
    $.ajax({
        url:'buscar_proveedor.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta:consulta}, 
    })
    .done(function(respuesta) {
        $('#datos_proveedor').html(respuesta);

    })
    .fail(function() {
        console.log("error");
    })
}

$(document).on('keyup', '#busqueda_proveedor', function(){
    var valor = $(this).val();
    buscar_datos(valor);
    
});
