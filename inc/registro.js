//-- FUNCS --\\


function MostrarError(objId, tipo) {
    l_generico('errMsg', tipo, objId);
}

function ValidarMinMax(objId, min, max) {
    var minValido = false;
    var maxValido = false;

    var txt = $(objId).val();

    var filtros = [/(<([^>]+)>)/ig, / |&nbsp;/ig, /\r\n|\r|\n/g];
    for(var i in filtros) {
        txt = txt.replace(filtros[i], "");
    }



    if (txt.length > min && txt.lenght < max) {
        valido = true;
    } else {
        msg = 'Debe escribir al menos 2 caracteres';
    }

    if (minValido && maxValido) return true;
    return false;
}

function ValidarMail(objId) {
    var valido = false;

    return valido;
}

function ValidarTel(objId) {
    var valido = false;

    return valido;
}


//-- INICIO --\\

$(function () {


    JsCargado($('#cargandoJs_registro'), 'registro.js');

});