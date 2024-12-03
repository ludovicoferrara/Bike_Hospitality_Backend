<?
$msg = "";
$errmsg = "";

if ($logged != 1) {
    echo "Sessione scaduta!<br/>";
} else {

    $sql = "SELECT * FROM province ORDER BY nome_provincia; ";
    $dbDati->Set_Sql($sql);
    $province = $dbDati->DoSelect();

    if ($azione == "savep") {

        $pass = md5($password);

        $sql = "UPDATE t_utenti SET password = '$pass', last_changed_password = NOW() WHERE id_utenti = $_idutente";
        $mydb->ExecSql($sql);

        $msg = "La password &egrave; stata modificata.";
    }

      if($azione=="save"){


      $nome = myencodeTxt($nome);
      $cognome = myencodeTxt($cognome);
      #nome = '$nome', cognome='$cognome',

      $sql = "UPDATE t_utenti SET  nome='$nome', cognome='$cognome'  WHERE id_utenti = $_idutente";
      $mydb->ExecSql($sql);

      if($email!=$emailold)
      {
        $sql = "UPDATE t_utenti SET  email='$email'  WHERE id_utenti = $_idutente";
        $mydb->ExecSql($sql);
      }
      if($username!=$usernameold)
      {
        $sql = "SELECT COUNT(*) as n FROM t_utenti WHERE username='$username' AND cancellato='0' ";
        $mydb->DoSelect($sql);
        $rtmp = $mydb->GetRow();

        if($rtmp['n']==0)
        {
        $sql = "UPDATE t_utenti SET  username='$username'  WHERE id_utenti = $_idutente";
        $mydb->ExecSql($sql);
        } else {
            $errmsg = "Lo username scelto non &egrave; disponibile.";
        }
      }




      }

   
    $sql = "SELECT * FROM t_utenti WHERE id_utenti = $_idutente";
    $mydb->DoSelect($sql);
    $ru = $mydb->GetRow();

    $tipoutente = $ru['tipo'];
    
    $usr_level = $ru['level'];

    #$paesi = getNazioni();

    if ($onlywarning > 0)
        $msg = "ATTENZIONE: E' necessario modificare la propria password!";
    ?>
<!--@account-->

    <script>

        function checkdata() {

            res = convalidaForm3(document.frmins, '<?= $language ?>', 'input_evi');

            if (!res)
                return false;

            else {
                waitpage();

                document.frmins.submit();

            }

        }

        function changeProfilo(p) {

            document.frmins.azione.value = 'changeprofilo';
            document.frmins.profilo.value = p;

            waitpage();

            document.frmins.submit();

        }


        function checkdata2() {



            res = false;

            if (document.frmins.password.value != '' && document.frmins.password.value != document.frmins.password2.value)
                alert('Le password inserite non coincidono');

            if (document.frmins.password.value != '' && document.frmins.password.value == document.frmins.password2.value)
                res = true;


            if (!res)
                return false;

            else {

                document.frmins.azione.value = 'savep';

                waitpage();

                document.frmins.submit();

            }

        }


    </script>
    

    <div class="box_in">

    <div class="titolo_evi"><?= $msg ?></div>
    <div class="titolo err"><?= $errmsg ?></div>
    
    <? if ($usr_level>$MAXUSERSLEVEL) { ?>

    <form name="frmins" id="frmins" method="post" action="<? echo $urlbase ?>index.php" enctype="multipart/form-data">
        <p>&nbsp;</p>

    <? if (1) { ?>

            <div class="box_cnt boxaccount rounded">
                <p class="testosm">I dati contrassegnati con * sono obbligatori</p>


                <p>&nbsp;</p>
                <div class="titolo">Dati generali</div>
               <div class="spessore"></div>

                <table cellspacing="0" cellpadding="6" border="0" align="center"  class="tableresp2">

        <? if (!$_supervisione) { ?>
                        
                        <tr>
                            <td class="testo_evi tdlabel" ><span class="required">*</span>Cognome</td>
                            <td class="tdField" data-label="Cognome">
                                <input type="text" value="<?= mydecodeTxt($ru['cognome']) ?>" name="cognome" title="Cognome" >
                            </td>
        
                            <td class="testo_evi tdlabel" ><span class="required">*</span>Nome</td>
                            <td class="tdField" data-label="Nome">
                                <input type="text" value="<?= $ru['nome'] ?>" name="nome" title="Nome" >
                            </td>
                        </tr>
                        <? /*
                        <tr>

                        <tr>
                            <td class="testo_evi" ><span class="required">*</span>Sesso</td>
                            <td class=""><?= mydecodeTxt($ru['sesso']) ?>
                                <input type="hidden" value="<?= mydecodeTxt($ru['sesso']) ?>" name="sesso" title="Sess" ></td>

            <? if ($tipoutente > 0) { ?>

                                <td class="testo_evi" ><span class="required">*</span>Data di nascita</td>
                                <td class="">
                                    <?
                                    echo Date_fromdb($ru['nato_il']);
                                    ?>
                                    <input type="hidden" value="<?= $ru['nato_il'] ?>" name="nato_il" title="Data di nascita" ></td>

            <? } else { ?>

                                <td class="testo" >Data di nascita</td>
                                <td class="testo">
                                    <?
                                    $adata = explode("-", $ru['nato_il']);
                                    if ($adata[0] == "0000")
                                        $adata[0] = '';
                                    if ($adata[1] == "00")
                                        $adata[1] = '';
                                    if ($adata[2] == "00")
                                        $adata[2] = '';
                                    ?>

                                    <input type="text" name="datan_dd" value="<?= $adata[2] ?>" maxlength="2" class="mini" /> / <input type="text" name="datan_mm" value="<?= $adata[1] ?>" maxlength="2" class="mini" /> / <input type="text" name="datan_aaaa" value="<?= $adata[0] ?>" maxlength="4" class="medium" /> (gg/mm/aaaaa)
                                </td>
                        <? } ?>
                        </tr>
                        <tr>

                        </tr>
            <? if ($tipoutente > 0) { ?>
                            <tr>

                                <td class="testo" >Codice Fiscale</td>
                                <td class=""><input type="text" value="<?= $ru['cf'] ?>" name="cf"  ></td>


                                <td class="testo_evi">*Nazione di nascita</td>
                                <td class="">  <select name="nazione_nas_sigla" title="Nazione">
                                        <option value=""></option>
                                        <?
                                        $i = 0;
                                        while ($r = $paesi[$i++]) {
                                            $s = "";
                                            $k = $r['id_nazione'];
                                            $v = $r['descrizione'];
                                            if ($k == $ru['nazione_nas_sigla'])
                                                $s = "selected";
                                            echo "<option value=\"$k\" $s />$v</option>";
                                        }
                                        ?>
                                    </select></td>

                            </tr>

                            <tr>


                                <td class="testo_evi">*Luogo di nascita</td>
                                <td class=""><input type="text" value="<?= mydecodeTxt($ru['nato_a']) ?>" name="nato_a" ></td>
                                <td class="testo" ></td>
                                <td class=""></td>


                            </tr>


                            <tr><td colspan="4" class="titolo">&nbsp;</td> </tr>
                            <tr><td colspan="4" class="titolo">Residenza</td> </tr>

                            <tr>
                                <td class="testo">Nazione</td>
                                <td class="">
                                    <select name="nazione_sigla" title="Nazione" onchange="checkdata()">
                                        <option value=""></option>
                                        <?
                                        $i = 0;
                                        while ($r = $paesi[$i++]) {
                                            $s = "";
                                            $k = $r['id_nazione'];
                                            $v = $r['descrizione'];
                                            if ($k == $ru['nazione_sigla'])
                                                $s = "selected";
                                            echo "<option value=\"$k\" $s />$v</option>";
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </td>

                <?
                if ($ru['nazione_sigla'] == "114") {
                    ?>

                                    <td class="" >Provincia</td>
                                    <td class="">
                                        <select  name="prov" id="usr_provincia"  onchange="javascript:loadComuni(this.value, 'usr_');" >
                                            <? # checkdata2();-seleziona la regione-?>
                                            <option value="">Seleziona...</option>
                                            <?
                                            $i = 0;
                                            while ($r = $province[$i++]) {
                                                $s = "";
                                                $k = $r['codice_provincia'];
                                                $v = utf8_encode($r['nome_provincia']);
                                                if ($k == $ru['prov'])
                                                    $s = "selected";
                                                echo "<option value=\"$k\" $s />$v</option>";
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" value="<?= mydecodeTxt($ru['citta_est']) ?>" name="citta_est" >
                                    </td>
                <? } else { ?>
                                    <td class="" >Citt&agrave;</td>
                                    <td class="">
                                        <input type="text" value="<?= mydecodeTxt($ru['citta_est']) ?>" name="citta_est" >
                                        <input type="hidden" value="<?= $ru['prov'] ?>" name="prov" >
                                        <input type="hidden" value="<?= $ru['citta'] ?>" name="comune" >
                                        <input type="hidden" value="<?= $ru['cap'] ?>" name="cap" >
                                        <input type="hidden" value="<?= $ru['localita'] ?>" name="localita" >
                                    </td>

                            <? } ?>
                            </tr>

                <?
                if ($ru['nazione_sigla'] == "114") {
                    ?>

                                <tr>
                                    <td class="testo" >Comune</td>
                                    <td class="">
                                        <select name="comune" id="usr_comune" >

                                            <? if ($ru['prov'] == "" || is_null($ru['prov'])) { ?>

                                                <option value=""><?= $lang['seleziona_provincia'] ?></option>

                                            <?
                                            } else {



                                                $sql = "SELECT * FROM comuni WHERE codice_provincia = '" . $ru['prov'] . "'";
                                                $dbDati->Set_Sql($sql);
                                                $dbDati->DoSelect();
                                                while ($row = $dbDati->GetRow()) {
                                                    $str = "";
                                                    if ($ru['citta'] == $row['codice_comune'])
                                                        $str = "selected='selected'";
                                                    echo "<option value=\"" . $row['codice_comune'] . "\" id=\"" . $row['codice_comune'] . "\" $str >" . htmlentities($row['nome_comune']) . "</option>\n";
                                                }
                                                ?>

                                <? } ?>
                                        </select>

                                    </td>
                                    <td class="testo" >CAP</td>
                                    <td class=""><input type="text" value="<?= $ru['cap'] ?>" name="cap"  ></td>
                                </tr>
                                <? } ?>
                            <tr>


                                <td class="testo" >Indirizzo</td>
                                <td class=""><input type="text" value="<?= mydecodeTxt($ru['indirizzo']) ?>" name="indirizzo" ></td>
                                <?
                                if ($ru['nazione_sigla'] == "114") {
                                    ?>
                                    <td class="testo" >Localit&agrave;</td>
                                    <td class=""><input type="text" value="<?= mydecodeTxt($ru['localita']) ?>" name="localita" ></td>
                            <? } else { ?>
                                    <td></td><td></td>
                            <? } ?>
                            </tr>

                            <?
                        }
                        /*
                          if($usrsch_chk_maschile_1=='1' || $usrsch_chk_femminile_1=='1'){

                          ?>
                          <tr>
                          <td class="testo freccia" >Altezza</td>
                          <td class="testo" colspan="3" ><input type="text" value="<?=$altezza?>" name="altezza" class="mini" > Inserisci la tua altezza: questa informazione verr&agrave; mostrata nella tua scheda giocatore</td>
                          </tr>

                          <? }
                         */
                        ?>

                        <tr><td colspan="4" class="titolo">&nbsp;</td> </tr>

                        <tr>
                            <td class="tdlabel">Username</td>
                            <td class="tdField"  data-label="Username&nbsp;"><?= $ru['username'] ?>
                                <input type="hidden" value="<?= $ru['username'] ?>" name="usernameold"  >
                            </td>
                            <td class="testo_evi tdlabel"  ><span class="required" >*</span>Email</td>
                            <td class="tdField"  data-label="Email">
                                <input type="text" value="<?= $ru['email'] ?>" name="email"  >
                                <input type="hidden" value="<?= $ru['email'] ?>" name="emailold"  >
                            </td>
                           
                           
                        </tr>

                        <tr><td colspan="4" class="titolo">&nbsp;</td> </tr>

                    </table>
                    <div align="center"><div class="button1" onclick="checkdata()"><p>SALVA</p></div></div>
                    <p>&nbsp;</p>
                </div>
                <p>&nbsp;</p>
        <? } ?>
    <? } ?>
    <? } else {
        
        include $incpath.'user/account.php';
        
        ?>
    <? } ?>

        <div class="box_cnt boxaccount rounded">

            <div class="titolo">Modifica la tua password:</div>
            <div class="spessore"></div>

            <table cellspacing="0" cellpadding="6" border="0" align="center"  class="tableresp2">

                <tr>
                    <td class="testo tdlabel" >Nuova password</td>
                    <td class="tdField" data-label="Nuova password&nbsp;"><input type="password" value="" name="password" form="frmins"  ></td>

                    <td class="testo tdlabel" >Ripeti password</td>
                    <td class="tdField" data-label="Ripeti password&nbsp;"><input type="password" value="" name="password2"  form="frmins"  ></td>
                </tr>

                <tr><td colspan="4" class="titolo">&nbsp;</td> </tr>

            </table>
            <div align="center"><div class="button1" onclick="checkdata2()"><div>SALVA</div></div></div>

        </div>



        <p>&nbsp;</p>

        <input type="hidden" name="sz" value="<?= $sz ?>">
        <input type="hidden" name="MSID" value="<? echo $MSID ?>">
        <input type="hidden" name="language" value="<? echo $language; ?>">
        <input type="hidden" name="azione" value="save">
        <input type="hidden" name="frame" value="<? echo $frame ?>">
        <input type="hidden" name="_idutente" value="<? echo $_idutente ?>">


    </form>

<? } ?>

</div>