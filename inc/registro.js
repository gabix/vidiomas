//-- FUNCS --\\


function MostrarError(objId, tipo) {
    l_generico('errMsg', tipo, objId);
}

function ValidarMinMax(obj, min, max, tagsYesps) {
    var txt = obj.val();

    if (tagsYesps) {
        var filtros = [/(<([^>]+)>)/ig, / |&nbsp;/ig, /\r\n|\r|\n/g];
        for(var i in filtros) {
            txt = txt.replace(filtros[i], "");
        }
    }

    return (txt.length >= min && txt.length <= max);
}
//
//function ValidarMail(objId) {
//    var valido = false;
//
//    return valido;
//}
//
//function ValidarTel(objId) {
//    var valido = false;
//
//    return valido;
//}
//
//function ValidarApodoNoUsado() {
//
//}

/**
 * @return {boolean}
 */
function ValidarR_pass() {
    var lugarErr = '#err_pass';
    var pass = $('#inp_r_pass');
    var passR = $('#inp_r_passR');

    var valP = ValidarMinMax(pass, 5, 50, false);
    var valPr = ValidarMinMax(passR, 5, 50, false);
    if (valP && valPr) {
        if (pass.val() == passR.val()) {
            $(lugarErr).html("");
            return true;
        } else {
            MostrarError(lugarErr, "passDesigual");
        }

    } else {
        MostrarError(lugarErr, "passMinMax");
    }
    return false;
}

function ValidarTodo() {
    console.log("ValidarTodo!");
    var err = true;

    var valRpass = ValidarR_pass();

    return (valRpass && true && true);
}

function Submit_f_registro() {
    console.log("Submit_f_registro!");

    var form = $('#f_registro');
    var pass = $('#inp_r_pass');
    var passR = $('#inp_r_passR');

    var pE = document.createElement("input");
    pE.name = "inp_passEnc";
    pE.type = "hidden";
    pE.value = hex_sha512(pass.val());

    pass.val("");
    passR.val("");
    form.append(pE);

    var serialized = form.serialize();
    $.post('proc/p_registro.php', serialized, function (rta) {
        rta = $.parseJSON(rta);
        console.log(rta);

//        if (errYmsg.err) {
//            //en caso de error
//            $("#inp_email").removeClass("backVerde");
//            $("#inp_pass").removeClass("backVerde");
//            $("#inp_email").addClass("backRojo");
//            $("#inp_pass").addClass("backRojo");
//            login_activa(0);
//            l_generico('errMsg', errYmsg.msg, '#lbl_logErr');
//
//        } else {
//            //LOGEADO!
//            //redirigir a control panel
//            window.location = "cpanel.php";
//        }
    });
}

//-- Eventos --\\
$('#btn_submit').on('click', function(evt){
    evt.stopImmediatePropagation();
    evt.preventDefault();

    console.log("enviar!");

    if (ValidarTodo()) {
        Submit_f_registro();
    }
});

//-- INICIO --\\
$(function () {
    JsCargado($('#cargandoJs_registro'), 'registro.js');
});