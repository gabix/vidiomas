//-- FUNCS --\\


function MostrarError(objId, tipo) {
    l_generico('errMsg', tipo, objId);
}

//function ValidarMinMax(objId, min, max) {
//    var minValido = false;
//    var maxValido = false;
//
//    var txt = $(objId).val();
//
//    var filtros = [/(<([^>]+)>)/ig, / |&nbsp;/ig, /\r\n|\r|\n/g];
//    for(var i in filtros) {
//        txt = txt.replace(filtros[i], "");
//    }
//
//
//
//    if (txt.length > min && txt.lenght < max) {
//        valido = true;
//    } else {
//        msg = 'Debe escribir al menos 2 caracteres';
//    }
//
//    if (minValido && maxValido) return true;
//    return false;
//}
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

function ValidarR_pass() {
    var lugarErr = $('#err_pass');
    lugarErr.html("");

    var pass = $('#inp_r_pass');
    var passR = $('#inp_r_passR');

    if (pass.val().lenght > 0) {
        
    }
}

function ValidarTodo() {
    var err = true;

    if (ValidarR_pass());

}

$('#btn_enviar').on('click', function(evt){
    evt.stopImmediatePropagation();
    evt.preventDefault();

    //validar
    Submit_f_registro();
});

function Submit_f_registro() {
    var form = $('#f_registro');
    var r_pass = $

    var pE = document.createElement("input");
    pE.name = "inp_passEnc";
    pE.type = "hidden";
    pE.value = hex_sha512($("#inp_pass").val());
    //borro el pass tipeado
    $("#inp_pass").val("");
    $('#form_login').append(pE);

    var serialized = $('#form_login').serialize();
    $.post('proc/p_login.php', serialized, function (errYmsg) {
        errYmsg = $.parseJSON(errYmsg);
        //console.log(errYmsg);

        if (errYmsg.err) {
            //en caso de error
            $("#inp_email").removeClass("backVerde");
            $("#inp_pass").removeClass("backVerde");
            $("#inp_email").addClass("backRojo");
            $("#inp_pass").addClass("backRojo");
            login_activa(0);
            l_generico('errMsg', errYmsg.msg, '#lbl_logErr');

        } else {
            //LOGEADO!
            //redirigir a control panel
            window.location = "cpanel.php";
        }
    });
    return true;

}

//-- INICIO --\\
$(function () {
    JsCargado($('#cargandoJs_registro'), 'registro.js');
});