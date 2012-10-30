// -- Funcs -- \\

function activa(obj, display) {
    obj.removeClass("dispNone");
    obj.addClass("disp" + display);
}
function desactiva(obj, display) {
    obj.removeClass("disp" + display);
    obj.addClass("dispNone");
}

function login_activa(a) {
    if (a == 0) {
        activa($('#form_login'), "Inline");
        activa($('#but_register'), "Inline");
        desactiva($('#but_login'), "Inline");
        desactiva($('#but_logout'), "Inline");
        desactiva($('#usu_login'), "Inline");
    } else if (a == 1) {
        activa($('#but_login'), "Inline");
        activa($('#but_register'), "Inline");
        desactiva($('#form_login'), "Inline");
        desactiva($('#but_logout'), "Inline");
        desactiva($('#usu_login'), "Inline");
    } else {
        desactiva($('#but_login'), "Inline");
        desactiva($('#but_register'), "Inline");
        desactiva($('#form_login'), "Inline");
        activa($('#but_logout'), "Inline");
        activa($('#usu_login'), "Inline");
    }
}

function validaE() {
    $('#lbl_logErr').html("");
    $("#inp_email").removeClass("backRojo");
    $("#inp_email").removeClass("backVerde");
    $('#inp_email')[0]['title'] = 'Enter your email address here';

    var ret = false;
    var filtro = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var emailVal = $("#inp_email").val();

    if (emailVal == '') {
        //vacio
        $("#inp_email").addClass("backRojo");
        ret = true;
    } else if (!filtro.test(emailVal)) {
        //no es un email valido
        $("#inp_email").addClass("backRojo");
        ret = true;
    } else {
        $("#inp_email").addClass("backVerde");
    }
    return ret;
}

function validaP() {
    $('#lbl_logErr').html("");
    $("#inp_pass").removeClass("backRojo");
    $("#inp_pass").removeClass("backVerde");
    $('#inp_email')[0]['title'] = 'Enter your password here';

    var ret = false;
    var passVal = $("#inp_pass").val();

    if (passVal == '') {
        $("#inp_pass").addClass("backRojo");
        ret = true;
    } else {
        $("#inp_pass").addClass("backVerde");
    }
    return ret;
}

function HashPass() {
    var pE = document.createElement("input");
    pE.name = "inp_passEnc";
    //hago oculto el campo
    pE.type = "hidden";
    //encripto la pass tipeada y se la asigno a inp_passEnc
    pE.value = hex_sha512($("#inp_pass").val());
    //borro el pass tipeado
    $("#inp_pass").val("");
    $('#form_login').append(pE);
}

function Login() {
    if (validaE() || validaP()) {
        return false;
    } else {
        //logueo
        HashPass();

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
                l_generico('errMsg', errYmsg.msg, $('#lbl_logErr'));

            } else {
                //LOGEADO!
                //redirigir a control panel
                window.location = "cpanel.php";
            }
        });
        return true;
    }
}

function l_generico(arr, msg, obj) {
    var setedLang = $('meta[name=lang]').attr("content");
    var paForm = '<form>'
        + '<input type="text" name="lang" value="' + setedLang + '"/>'
        + '<input type="text" name="arr" value="' + arr + '"/>'
        + '<input type="text" name="msg" value="' + msg + '"/>'
        + '</form>';
    var serialized = $(paForm).serialize();

    $.get('proc/p_lang.php', serialized, function (rta) {
        rta = $.parseJSON(rta);

        if (rta.err == true) {
            return false;
        }
        if (!obj == "") {
            obj.html(rta.msg);
        } else {
            return rta.msg;

        }
    });
}

// -- Eventos -- \\
$('.a_banderas').on('click', function (evt) {
    evt.stopImmediatePropagation();
    evt.preventDefault();
    var setedLang = $('meta[name=lang]').attr("content");
    var val = $(this).attr('href');

    if (val != setedLang) {
        $('#inp_lang').val(val);
        $('#header_banderas').submit();
    }
});

$('#but_login').on('click', function (evt) {
    evt.stopImmediatePropagation();
    evt.preventDefault();
    login_activa(0);
});
$('#inp_email').keyup(function () {
    validaE()
});
$('#inp_pass').keyup(function () {
    validaP()
});
$('#but_enter').on('click', function (evt) {
    evt.stopImmediatePropagation();
    evt.preventDefault();

    Login();
});

function JsCargado(p_id, jsPag) {
    p_id.html(jsPag+" CARGADO");
    p_id.removeClass('colRojo');
    p_id.addClass('colVerde');
}

// -- Init -- \\
$(function () {
    if ($('#header_login').attr('mos') == 'logueado') {
        login_activa(2);
    }

    JsCargado($('#cargandoJs_generales'), 'generales.js');


//var lang = $('meta[name=lang]').attr("content");
//$('#pru').html(lang);

});