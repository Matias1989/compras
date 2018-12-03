function validar(){
    var email, direccion, expresion, cuit, persona;
    cuit = document.getElementById("cuit").value;
    email = document.getElementById("email").value;
    direccion = document.getElementById("direccion").value;
    persona = document.querySelector('input[id="radio"]:checked').value;
    expresion = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;

    if (cuit) {
        var vec = new Array(10);
        var tipos = "";
        tipos = cuit.charAt(0) + cuit.charAt(1);
        var esCuit = false;
        if (tipos == 20 || tipos == 23 || tipos == 24 || tipos == 27 || tipos == 30 || tipos == 33 || tipos == 34) {
            var x = 0;
            var i = 0;
            var r1 = 0;
            var rt = 0;
            //dv Corresponde al digito de verificación ingresado (ultimo dígito) en el formulario.
            var dv = cuit.charAt(10);
            // Multiplico los dígitos.
            vec[0] = cuit.charAt(0) * 5;
            vec[1] = cuit.charAt(1) * 4;
            vec[2] = cuit.charAt(2) * 3;
            vec[3] = cuit.charAt(3) * 2;
            vec[4] = cuit.charAt(4) * 7;
            vec[5] = cuit.charAt(5) * 6;
            vec[6] = cuit.charAt(6) * 5;
            vec[7] = cuit.charAt(7) * 4;
            vec[8] = cuit.charAt(8) * 3;
            vec[9] = cuit.charAt(9) * 2;
                        
            // Suma cada uno de los resultado.
            for(i = 0; i<=9; i++) {
                x += vec[i];
            }
            
            r1 = x / 11;
            
            rt = x - (r1 * 11);
            
            if (rt == 0) {
                dv = 0;
            }else if(rt == 1){
                if(persona == "femenino"){
                    dv = 9;
                    cuit.charAt(0) = 2;
                    cuit.charAt(1) = 3;
                }
                
            }

            if (rt == cuit.charAt(10)){
                esCuit = true;
            }else if (!esCuit){
                alert("CUIT Invalido, digito verificador incorrecto. "+tipos+ " " + rt +" " +cuit);
                return false;
            }

        }else{
            alert("CUIT Invalido, tipo incorrecto "+tipos);
            return false;
        }
    }