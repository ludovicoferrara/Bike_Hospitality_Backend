
<div id="main_overlay" style="display:none">
    <div id="loading" style="display:none"><img src="main/contents/immagini/loading2_1.gif" style="max-width:64px" /></div>
    <div id="overlay" onclick="close_()" ></div>
    <div id="cnt_overlay" style="display:none">
            <div><h4 id="titleframe"></h4></div>
            <div id="closeframe"><a href="javascript:close_()" class="ev"><?= $lang['chiudi'] ?></a></div>
        <iframe frameborder="0" src="blank.html" style="background-color:white;" name="overlayframe" id="overlayframe"></iframe>
    </div>
</div>

    <div id="main_woverlay" style="display:none">

        <div id="woverlay" onclick="wclose_()" ></div>

        <div id="cnt_woverlay" onclick="wclose_()"  style="display:none" >
            <div id="alertbox" style="display:none" class="titolo"></div>
        </div>
    </div>




    <form name="frmmenu" id="frmmenu"  action="<? echo $action; ?>" method="post">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="sezione" value="<? echo $sz; ?>">
        <input type="hidden" name="language" value="<? echo $language; ?>">
        <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
        <input type="hidden" name="params" value="">
        <input type="hidden" name="frame" value="<? echo $frame; ?>">
        <input type="hidden" name="tab" value="<? echo $tab; ?>">
        <input type="hidden" name="tab2" value="<? echo $tab2; ?>">
        <input type="hidden" name="azione" value="">
        <input type="hidden" name="toreload" value="">
    </form>




    <script>

       // window.onload = checkCookiesOk();

<? if ($_logout) { ?>
            logout();
<? } ?>

    </script>

