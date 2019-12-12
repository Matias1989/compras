$(buscar_datos());
$( document ).ready(function() {
    if($('#_id_categoria').val() != ''){
        buscar_datos($('#_id_categoria').val(), '');
        $('#_categoria').val($('#_id_categoria').val())
        $('#busqueda_producto').val('');
    }
});


function buscar_datos(categoria, consulta){
    $.ajax({
        url:'buscar_producto.php',
        type: 'POST',
        dataType: 'html',
        data: {categoria:categoria, consulta:consulta}, 
    })
    .done(function(respuesta) {
        $('#datos_producto').html(respuesta);

    })
    .fail(function() {
        console.log("error");
    })
}

$(document).on('change', '#_categoria', function(){
    var id_categoria = $(this).val();
    buscar_datos(id_categoria, '');
});

$(document).on('keyup', '#busqueda_producto', function(){
    var valor = $(this).val();
    var id_categoria = $('#_categoria').val();
    console.log($(this).val());
    
    buscar_datos(id_categoria, valor);
    // if(valor != ''){
    // }else{
    //     buscar_datos(id_categoria, '');
    // }  
});

