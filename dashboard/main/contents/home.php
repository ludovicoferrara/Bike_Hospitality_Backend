<?
if ($err > 0)
{
?>
    <div class="box bordered">
        <p class="titolo err">
            SI E' VERIFICATO UN ERRORE!
        </p>
    </div>
    <div class="spessore"></div>
    <?
}
?>

    
<div class="box" style="display:inline-table">

    <p class="titolo_big">ACCEDI AL SERVIZIO</p>

    <div class="spessore"></div>
    <div class="spessore"></div>

    <form id="frmlogin" name="frmlogin" action="<? echo $action; ?>" method="post">


        <table cellspacing="0" cellpadding="4" border="0" style="width:100%" >
            <tr>
                <td class="testob" style="text-align:right">Nome utente:</td><td><input type="text" name="username" value="<?= $username ?>"  /></td>
            </tr>

            <tr>
                <td class="testob" style="text-align:right">Password:</td><td><input type="password" name="password" value="" /></td>
            </tr>
            <tr><td colspan="2" align="left">
                    &nbsp;
                </td></tr>
            <tr><td colspan="2" align="center">
                    <div id="login_entra" class="button1" onclick="Login()"><div>ACCEDI</div></div>
                </td></tr>

        </table>
        <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
        <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
        <input type="hidden" name="login"  value="1">

    </form>
    <div class="spessore"></div>
    <div class="spessore"></div>
<!--
    <div class="testo">
        <i>Password dimenticata?</i> <a href="<?= $urlbase ?>/it/login/?recuperopassword">Clicca qui</a>
    </div>
-->
</div>
<? /*
<div class="spessore"></div>
<div class="spessore"></div>

<div class="box " style="display:inline-table">

    <p class="titolo_big"><?= $lang['crea_account'] ?></p>
    <p> </p>

    <? Get_TXTArea('messaggio_1', $language); ?>
    <p> </p>
    <p class="testob">
        <a class="lnk" href="<?= $language ?>/registrati/"><?= $lang['registrati'] ?></a>
    </p>
    <p> </p>
</div>

<div class="spessore"></div>
*/ ?>

