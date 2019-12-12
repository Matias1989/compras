function confirmar(borrarid, tipo){
	if(confirm("¿Desea realmente eliminar el registro?")){
        if(tipo == 'producto'){
            window.location.href='borra_producto.php?borrar_id='
            +borrarid+ '';
            return true;
        }else if(tipo == 'item'){
            window.location.href='altaitem2.php?borrar_id='
            +borrarid+ '';
            return true;
        }
	}
}

function validar(){
    var email, expresion, cuit;
    cuit = document.getElementById("cuit").value;
    email = document.getElementById("email").value;
    expresion =  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (cuit) {
        var tipos = "";
        tipos = cuit.charAt(0) + cuit.charAt(1);
        var esCuit = false;
        if (tipos == 20 || tipos == 23 || tipos == 24 || tipos == 27 || tipos == 30 || tipos == 33 || tipos == 34) {
            esCuit = true;
        }else{
            esCuit = false;
        }

        if(!esCuit){
            alert("CUIT Invalido, tipo incorrecto.");
            return false;
        }
    }

    if(!expresion.test(email)){
        alert("El email no es valido.");
        return false;
    }
}

function  validarItems() {
    var producto, precio_unitario, cantidad;
    precio_unitario = document.getElementById("precio_unitario").value;
    cantidad = document.getElementById("cantidad").value;
    producto = document.getElementById("producto").value;

    if ((cantidad && precio_unitario && producto) != "") {
        document.getElementById("form-datos").submit();
        return true;
    }else{
        alert("Datos incompletos.");
        return false;
    }
}

function confirmarActividad(id_proveedor){
    if(confirm("¿Desea cambiar actividad del proveedor?")){
        window.location.href='cambiar_actividad.php?id_proveedor='
        +id_proveedor+ '';
        return true;
    }
}