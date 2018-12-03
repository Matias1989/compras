function confirmar(borrarid, tipo){
	if(confirm("¿Desea realmente eliminar el registro?")){
        if(tipo == 'producto'){
            window.location.href='borra_producto.php?borrar_id='
            +borrarid+ '';
            return true;
        }else if(tipo == 'proveedor'){
            window.location.href='borra_proveedor.php?borrar_id='
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
            alert("CUIT Invalido, tipo incorrecto."+tipos);
            esCuit = false;
            return false;
        }
    }
    if(!expresion.test(email)){
        alert("El email no es valido.");
        return false;
    }
}

function confirmarEstado(estado){
    if(confirm("¿Desea cambiar estado del proveedor?")){
        window.location.href='cambiar_estado.php?estado='
        +estado+ '';
        return true;
    }
}