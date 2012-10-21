<!--suppress HtmlUnknownTarget -->
<div id="d_bar_supBoto">
    <div id="d_bar_boto1">
        <a class="but_boto_sup<?php if ($selPag == "home") echo " boto_sup_select_of" ?>"
           href="home.php"><?=$l->grales('home')?></a>
        <span class="boto_span">|</span>
        <a class="but_boto_sup<?php if ($selPag == "nosotros") echo " boto_sup_select" ?>"
           href="nosotros.php"><?=$l->grales('nosotros')?></a>
        <span class="boto_span">|</span>
        <a class="but_boto_sup<?php if ($selPag == "aula") echo " boto_sup_select" ?>"
           href="aula.php"><?=$l->grales('aula')?></a>
        <span class="boto_span">|</span>
        <a class="but_boto_sup<?php if ($selPag == "niveles") echo " boto_sup_select_of" ?>"
           href="niveles.php"><?=$l->grales('niveles')?></a>
        <span class="boto_span">|</span>
        <a class="but_boto_sup<?php if ($selPag == "viajar") echo " boto_sup_select_of" ?>"
           href="viajar.php"><?=$l->grales('viajar')?></a>
    </div>

    <div id="d_bar_boto2">
        <a class="but_boto_sup<?php if ($selPag == "foro") echo " boto_sup_select_of" ?>"
           href="foro.php"><?=$l->grales('foro')?></a>
        <span class="boto_span">|</span>
        <a class="but_boto_sup<?php if ($selPag == "blog") echo " boto_sup_select_of" ?>"
           href="blog.php"><?=$l->grales('blog')?></a>
    </div>

    <div id="d_bar_boto3">
        <a href="#" class="but_img"><img class="img_fbtw" alt="fb" src="img/facebook.png"/></a>
        <a href="#" class="but_img"><img class="img_fbtw" alt="twt" src="img/twitter.png"/></a>
    </div>
</div>
<div id="d_bar_encima"></div>
<div id="d_bar_subBoto_nos" class="dispNone backVerde">
    <?php
    $selBut = "";
    if (isset ($_GET['nos'])) $selBut = htmlentities($_GET['nos']);
    ?>
    <a class="but_boto_sub <?php if ($selBut == "que") echo "but_boto_sub_select";?>"
       href="nosotros.php?nos=que"><?=$l->grales('que')?><br/>
        <span class="but_boto_sub_txt"><?=$l->grales('queEsVidiomas')?></span></a>
    <a class="but_boto_sub <?php if ($selBut == "quienes") echo "but_boto_sub_select";?>"
       href="nosotros.php?nos=quienes"><?=$l->grales('quienes')?><br/>
        <span class="but_boto_sub_txt"><?=$l->grales('quienesSomos')?></span></a>
    <a class="but_boto_sub <?php if ($selBut == "donde") echo "but_boto_sub_select";?>"
       href="nosotros.php?nos=donde"><?=$l->grales('donde')?><br/>
        <span class="but_boto_sub_txt"><?=$l->grales('dondeContactarnos')?></span></a>
</div>
<div id="d_bar_subBoto_aula" class="dispNone backVerde">
    <a class="but_boto_sub but_boto_sub_select" href="clases.php"><?=$l->grales('misClases')?></a>
    <a class="but_boto_sub" href="aula.php"><?=$l->grales('miAula')?></a>
    <a class="but_boto_sub" href="tests.php"><?=$l->grales('misTests')?></a>
</div>
<div id="d_bar_sub_vacia" class="dispBlock backGris"></div>
