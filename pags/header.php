<div id="d_header">
    <div id="header_logo">
        <img src="img/noimg.png" alt="Vidiomas" id="img_logo" />
        <span id="logo_t">ONLINE LANGUAGE SCHOOL</span>
    </div>
    <form id="header_banderas" method="post">
        <a href="es" class="a_banderas"><img class="img_banderas" src="img/banderas/flags-spain.png" alt="<?= $l->grales("espanol") ?>" /></a>
        <a href="en" class="a_banderas"><img class="img_banderas" src="img/banderas/flags-united_kingdom.png" alt="<?= $l->grales("ingles") ?>" /></a>
        <a href="nl" class="a_banderas"><img class="img_banderas" src="img/banderas/flags-netherlands.png" alt="<?= $l->grales("holandes") ?>" /></a>
        <a href="de" class="a_banderas"><img class="img_banderas" src="img/banderas/flags-germany.png" alt="<?= $l->grales("aleman") ?>" /></a>
        <a href="sv" class="a_banderas"><img class="img_banderas" src="img/banderas/flags-sweden.png" alt="<?= $l->grales("sueco") ?>" /></a>
        <a href="no" class="a_banderas"><img class="img_banderas" src="img/banderas/flags-norway.png" alt="<?= $l->grales("noruego") ?>" /></a>
        <input type="hidden" id="inp_lang" name="inp_lang" value="<?= $l->lang ?>" />
    </form>
    <p class="cl"></p>
    <div id="header_login" mos="<?php if ($lo) echo "logueado"; ?>">
        <a href="log+in" id="but_login" class="but_logins dispInline">Log in</a>
        <form id="form_login" class="dispNone" method="post">
            <label id="lbl_logErr"></label>
            <input type="text" id="inp_email" name="inp_email" placeholder="Email" size="15" title="<?= $l->grales("mailAqui") ?>" />
            <input type="password" id="inp_pass" name="inp_pass" placeholder="Password" size="15" title="<?= $l->grales("passAqui") ?>" />
            <input type="checkbox" name="chk_recordame" checked="checked" />
            <label><?= $l->grales('recordarme') ?></label>
            <input type="submit" id="but_enter" name="but_enter" value=">" />
        </form>
        <div id="usu_login" class="dispNone">
            <label><?= $l->grales("holaUsu") ?></label>
            <a href="cpanel.php" class="but_logins" id="but_usu"><?php if ($lo)
                echo $usu->get_apodo(); ?></a>
        </div>
        <span>&nbsp;|&nbsp;</span>
        <a href="registro.php" class="but_logins dispInline" id="but_register"><?= $l->grales("registrate") ?></a>
        <a href="proc/p_logout.php" class="but_logins dispNone" id="but_logout"><?= $l->grales("logOut") ?></a>
        <p class="cl"></p>
    </div>

</div>