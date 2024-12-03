<?php
if (!isset($tab) || $tab == "")
    $tab = 0;
if (!isset($npage))
    $npage = 0;


if (!isset($ord))
    $ord = my_statevar_read("ordUtenti");
if (!isset($searchstr))
    $searchstr = my_statevar_read("searchstrUtenti");
if (!isset($nxpage))
    $nxpage = my_statevar_read("nxpageUtenti");
if (!isset($filtro1)){
    $filtro1 = getU_VAR("filtro1Utenti", $_idutente);
    #my_statevar_read("filtro1Utenti");
} else {
    setU_VAR("filtro1Utenti", $filtro1, $_idutente);
}
if (!isset($filtro2)){
    $filtro2 = getU_VAR("filtro2Utenti", $_idutente);
    #my_statevar_read("filtro1Utenti");
} else {
    setU_VAR("filtro2Utenti", $filtro2, $_idutente);
}

if (!isset($isubsezione) || $isubsezione == "")
    $isubsezione = 0;
if (empty($nxpage))
    $nxpage = 50;

if ($azione == "delUser") {
    $sql = "DELETE FROM t_utenti WHERE idutente=$id";
    $mydb->ExecSql($sql);

    $sql = "DELETE FROM t_utenti_note WHERE id_utente=$id";
    $mydb->ExecSql($sql);
}

if ($tab == 0 || $tab == 2) {

    switch ($ord) {
        case 0: {

                $orderby = "tu.cognome ASC";
            } break;

        case 1: {

                $orderby = "tu.cognome DESC";
            } break;
        case 2: {

                $orderby = "tu.email ASC";
            } break;
        case 3: {

                $orderby = "tu.email DESC";
            } break;
        case 4: {

                $orderby = "tu.data_ins ASC";
            } break;
        case 5: {

                $orderby = "tu.data_ins DESC";
            } break;

        case 6: {

                $orderby = "tp.titolo ASC";
            } break;
        case 7: {

                $orderby = "tp.titolo DESC";
            } break;
        case 8: {

            $orderby = "tp.data_rif ASC";
            } break;
        case 9: {

                $orderby = "tp.data_rif DESC";
            } break;


        default: {
            $ord = 0;
            $orderby = "tu.cognome ASC";
        }
}

    $cond = " ";
    $from = "";
    if ($searchstr != "") {
        $cond = " AND (tu.nome LIKE '%$searchstr%' OR tu.cognome LIKE '%$searchstr%' OR tu.email LIKE '%$searchstr%') ";
    }
    

    //if($filtro1 != "" && $filtro1>2) $filtro1="";
    //if($filtro2 != "" && $filtro2>2) $filtro2="";
    
    if($filtro1 != "" && $filtro1>0)
    {
        $from .= ", t_utenti_corsi as tuc ";
        $cond .= " AND tu.idutente = tuc.id_utente AND tuc.id_corso=$filtro1 AND tuc.importo>0 ";
    }
        if($filtro2 != "" && $filtro2>0)
    {
        $from .= ", t_utenti_corsi as tuc ";
        $cond .= " AND tu.idutente = tuc.id_utente AND tuc.id_corso=$filtro2 AND tuc.data_confermato IS NOT NULL ";
    }

    $ntot = 0;
    $a_utenti = array();

    if ($tab == 0)
        $sql = "SELECT COUNT(*) FROM t_utenti as tu $from WHERE tu.level<'$SUPLEVEL' $cond";
    elseif ($tab == 2)
        $sql = "SELECT COUNT(*) FROM t_utenti as tu $from WHERE  tu.level & '$SUPLEVEL' AND tu.level<$SADMINLEVEL $cond";
    $mydb->DoSelect($sql);
    if (($rcount = $mydb->GetRow())) {
        $ntot = $rcount[0];
        $ntotpage = floor($ntot / $nxpage);
        if ($ntotpage != $ntot / $nxpage)
            $ntotpage++;

        $nn = $npage * $nxpage;


        if ($tab == 0)
            $sql = "SELECT tu.* FROM t_utenti as tu $from WHERE  tu.data_confermato  IS NOT NULL AND tu.level<'$SUPLEVEL'  $cond ORDER BY $orderby LIMIT $nn, $nxpage";# ";
        elseif ($tab == 2)
            $sql = "SELECT tu.* FROM t_utenti as tu $from WHERE   tu.level & '$SUPLEVEL' AND tu.level<$SADMINLEVEL  $cond ORDER BY $orderby LIMIT $nn, $nxpage";# ";
//echo $sql;        
        $a_utenti = $mydb->DoSelect($sql);
    }
}
?>
<script>

    function setTab(t)
    {
        document.frmins.tab.value = t;
        document.frmins.submit();
    }

    function editUser(id) {

        document.frmmenu.sezione.value = 'utenti,1';
        document.frmmenu.id.value = id;
        document.frmmenu.submit();

    }


    function delUser(id) {

        if (confirm('ATTENZIONE: confermi la cancellazione dell\'utente?'))
        {
            document.frmmenu.azione.value = 'delUser';
            document.frmmenu.id.value = id;
            document.frmmenu.submit();
        }
    }

    function back() {

        document.frmmenu.sezione.value = 'utenti,0';
        document.frmmenu.params.value = 'tab=<?=$tab?>';
        document.frmmenu.id.value = 0;
        document.frmmenu.submit();

    }

    function refresh()
    {
        waitpage();
        document.frmins.submit();
    }
    function esporta()
    {
        document.frmins.esporta.checked = true;
        refresh();
    }

    function setOrd(strord) {

        var ord = '<?= $ord ?>';

        if (strord == 'nome')
        {
            if (ord == '0')
                ord = 1;
            else
                ord = '0';
        }
        if (strord == 'email')
        {
            if (ord == '2')
                ord = 3;
            else
                ord = '2';
        }
        if (strord == 'data_reg')
        {
            if (ord == '4')
                ord = 5;
            else
                ord = '4';
        }


        waitpage();
        document.frmins.ord.value = ord;
        document.frmins.submit();
    }
    
function addGruppo()
{
    document.frmins.azione.value='addGruppo';
     waitpage();
    document.frmins.submit();
}
function editGruppo(id)
{
   document.frmmenu.sezione.value = 'utenti,3';
   document.frmmenu.id.value = id;
   waitpage();
   document.frmmenu.submit();
}
function delGruppo(id)
{
   document.frmmenu.azione.value = 'delGruppo';
   document.frmmenu.id.value = id;
   waitpage();
   document.frmmenu.submit();
}
</script>
<div class="box_cnt">

<?
if ($isubsezione == 0) {
    ?>

        <div class="tabmenu tabmenuadmin" >

            <div class="tabitem <? if ($tab == 0) echo "tabitemon" ?>" onclick="setTab(0)"><div class="itmTab">Elenco utenti</div></div>
            <div class="tabitem <? if ($tab == 2) echo "tabitemon" ?>" onclick="setTab(2)"><div class="itmTab">Gruppi</div></div>
            <div class="tabitem <? if ($tab == 4) echo "tabitemon" ?>" onclick="setTab(4)"><div class="itmTab">Utenti da autorizzare</div></div>
        </div>
        <div style="background:white;clear:both">
            <div class="box_cnt">
    <?
    if ($tab == 0) {

        ?>

                    <form name="frmins" method="post" action="<? echo $action ?>" >

                        <div class="spessore" style="height:20px"></div>
        
                        <div style='text-align: left'>
                            <a href="?MSID=<?= $MSID ?>&tab=0&sz=utenti,2"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi Utente</a>
                        </div>

                        <div class="spessore" style="height:20px"></div>
                        <div class="testo" align="left">
                            Cerca per email o nominativo: <input type="text" name="searchstr" value="<?= $searchstr ?>" />
            <img src="main/contents/icone/magnifier.png" class="ico24 imgcliccabile" onclick="refresh()" align="absmiddle" />
        <? if ($searchstr != "") { ?>
                                <img src="main/contents/icone/magnifier-r.png" class="ico24 imgcliccabile" onclick="document.frmins.searchstr.value = '';refresh()" align="absmiddle" />
            <? } ?>
        <div class="spessore" style="height:20px"></div>
       
<div style="text-align: left">
                                Visualizza <input type="text" name="nxpage" value="<?= $nxpage ?>" class="lite mini" /> righe per pagina <img src="main/contents/icone/right-arrow-1.png" class="ico24 cliccabile rounded" align="absmiddle" onclick="document.frmins.submit()" />
</div>    
<div class="spessore" style="height:10px" align="left"></div> 
<? /*
<div style="text-align: left" class="testo_evi">
<? if($esporta=='1')
{
    #$sqlfull = "SELECT * FROM t_utenti WHERE level<='1'  $cond ORDER BY $orderby ";
                              $sqlfull = "SELECT tu.* FROM t_utenti as tu, t_prodotti as tp WHERE tu.id_rel=tp.id AND tu.level<='1'  $cond ORDER BY $orderby ";# ";
    $a_full = $mydb->DoSelect($sqlfull);
    include "esporta.inc.php";
    
    ?>
<a href="download.php?path=csv&f=elenco.xls&t=<?=time()?>" target="_blank">scarica xls</a><br/>
<a href="download.php?path=csv&f=elenco.csv&t=<?=time()?>" target="_blank">scarica csv</a><br/>
<a href="download.php?path=csv&f=elenco.xlsx&t=<?=time()?>" target="_blank">scarica xlsx</a><br/>
<?
                              } */
?>

 </div>   
   <div class="spessore" style="height:10px"></div>
   <div class="admtitolo" align="left">
   <? 
                            $pagmode = '1';
                            $frm = "document.frmins";
   $href0 = "?MSID=$MSID&sz=utenti";
   
                            if ($ntot > 0)
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:10px"></div>

   </div>       
           
                        <?
                        $html = '<table cellpadding="6" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nominativo</th>
                                    <th>Email</th>
                                    <th>Data registrazione</th>
                                    <th>Account</th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                            ';
                        $csv = "Nominativo;Email;Data registrazione;;\n";
                        ?>

        <table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th  onclick="setOrd('nome')"><span class="underlined cliccabile">Nominativo</span></th>
                    <th  onclick="setOrd('email')"><span class="underlined cliccabile">Email</span></th>
                    <!--                <th></th>-->
                    <th  onclick="setOrd('data_reg')"><span class="underlined cliccabile">Data registrazione</span></th>
                                    <th >Account</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                
            
        <?
                                $i = 0;
        
                                foreach ($a_utenti as $k => $r) {
                                    $i++;
                                    $nome = mydecodeTxt($r['nome']);
                                    $cognome = mydecodeTxt($r['cognome']) . " " . $nome;
                                    $email = mydecodeTxt($r['email']);
                                    $data_reg = Date_fromdbX($r['data_ins']);
                                    $idu = $r['idutente'];
                                    
                                      $stato=$r['stato'];
                                      $icostato = "verified.png";
                                      $altstato = "Attivo";
                                      if($stato=='0') {
                                      $icostato = "notaccept.png";
                                      $altstato = "Non attivo";
                                      }
                                     
                                    if($r['conferma_email']=="")  $icoemail = "notaccept.png";
                                    else $icoemail = "verified.png";
                                    $profilo = "";
                                    ?>
                                    <tr>
                                        <td data-label="" style="min-height:32px">
                                            <div class="fleft"><?= $i + $nn ?></div>
                                            <div class="tdToolbar1 fright">
                                                <a href="javascript:editUser(<?= $idu ?>)"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                                                <a href="javascript:delUser(<?= $idu ?>)"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                                            </div>
                                        </td>
                                        <td data-label="Cognome"><?= $cognome ?></td>
                                        <td data-label="Email"><?= $email ?></td>
                                        <!--<td><img src="main/contents/icone/<?=$icoemail?>" class="ico18" /></td>-->
                                        <td data-label="Data registrazione"><?= $data_reg ?></td>
                                        <td><img src="main/contents/icone/<?=$icostato?>" class="ico18" /></td>
                                        <td class="tdToolbar" style="min-width:260px">
                                            <a href="javascript:editUser(<?= $idu ?>)"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                                            <a href="javascript:delUser(<?= $idu ?>)"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                                        </td>
                                    </tr>
                                    <?
                                    $html .= '<tr>'
                                            . '<td>'.$cognome.'</td>'
                                            . '<td>'.$email.'</td>'
                                            . '<td>'.$data_reg.'</td>'
                                            . '<td></td>'
                                            . '</tr>
                                            ';
                                    $csv .= "$cognome;$email;$data_reg;;\n";        
                                           
                                }
                                ?>
                            </tbody>
                        </table>

                        <?
                        $html .= '</tbody>
                        </table>
                        ';
                        ?>

                        <input type="hidden" name="MSID" value="<?= $MSID ?>" />
                        <input type="hidden" name="sz" value="<?= $sezione ?>" />
                        <input type="hidden" name="azione" value="" />
                        <input type="hidden" name="id" value="" />

                        <input type="hidden" name="tab" value="<?= $tab ?>" />
                        <input type="hidden" name="tab2" value="<?= $tab2 ?>" />

                        <input type="hidden" name="ord" value="<?= $ord ?>" />
                    </form>

                    <div class="admtitolo" align="left">
                        <?
                        $pagmode = '1';
                        $frm = "document.frmins";
                        $href0 = "?MSID=$MSID&sz=utenti";

                        if ($ntot > 0)
                            include "paginazione.php";
                        ?>
                        <div class="spessore" style="height:60px"></div>
                    </div>

                    <?
                    /*
                    $xls = new HtmlExcel();
                    #$xls->setCss($css);
                    $xls->addSheet("Utenti", $html);
                    #$xls->addSheet("Names", $names);
                    #$xls->headers();
                    $out = $xls->buildFile();
                    
                   # $fout = fopen("_csv/Utenti_".Date("Ymd").$_idutente.".xls","w");
                   # fputs($fout,$out);
                   # fclose($fout);
                    */
                    $fcsv = fopen("_csv/Utenti_".Date("Ymd").$_idutente.".csv","w");
                    fputs($fcsv,$csv);
                    fclose($fcsv);
                     /*
                    $fnamecsv = "Utenti_".Date("Ymd").$_idutente.".csv";
                    $fnamexls = "Utenti_".Date("Ymd").$_idutente.".xlsx";
                    
                    include "PhpSpreadsheet/xlsx.inc.php";
                    
                    ?>
                <div class="admtitolo" align="left">
                    <a href="<?=$urlbase?>_csv/<?=$fnamexls?>" target="_blank"><img src="main/contents/icone/xlsx-file.png" class="ico24" /> Scarica elenco</a>
                    </div>
                */
                    ?>
                <script>
                   <?
                   if(isset($filtro1) && $filtro1!="")
        {
                       echo "document.frmins.filtro1.value='$filtro1';\n";
                   }
                   if(isset($filtro2) && $filtro2!="")
                   {
                       echo "document.frmins.filtro2.value='$filtro2';\n";
                   }
                   ?>
                       function setFiltro1()
                       {
                           document.frmins.filtro2.value='';
                           waitpage();
                           document.frmins.submit();
                       }
                       function setFiltro2()
                       {
                           document.frmins.filtro1.value='';
                           waitpage();
                           document.frmins.submit();
                       }
                </script>
                    <?
                    
                    my_statevar_create("ordUtenti", $ord);
                    my_statevar_create("searchstrUtenti", $searchstr);
                    my_statevar_create("nxpageUtenti", $nxpage);
                    my_statevar_create("filtro1Utenti", $filtro1);
                    my_statevar_create("filtro2Utenti", $filtro2);
                    
                } elseif ($tab == 4) {
                    ?>

                    <?
                    $sql = "SELECT tu.* FROM t_utenti as tu WHERE tu.level<='$MAXUSERSLEVEL' AND data_confermato IS NULL ORDER BY data_ins DESC"; # ";
                    $a_utenti = $mydb->DoSelect($sql);
                    ?>
                    

                    <form name="frmins" method="post" action="<? echo $action ?>" >

                        <div class="spessore"></div>

                        <table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th  onclick="setOrd('nome')"><span class="underlined cliccabile">Nominativo</span></th>
                                    <th  onclick="setOrd('email')"><span class="underlined cliccabile">Email</span></th>
                                    <th></th>
                                    <th  onclick="setOrd('data_reg')"><span class="underlined cliccabile">Data registrazione</span></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>


                                <?
                                $i = 0;
                                if (is_array($a_utenti))
                                    foreach ($a_utenti as $k => $r) {
                                        $i++;
                                        $nome = mydecodeTxt($r['nome']);
                                        $cognome = mydecodeTxt($r['cognome']) . " " . $nome;
            $email = mydecodeTxt($r['email']);
            $data_reg = Date_fromdbX($r['data_ins']);
            $idu = $r['idutente'];
            /*
            $stato=$r['stato'];
            $icostato = "verified.png";
            $altstato = "Attivo";
            if($stato=='0') {
                $icostato = "notaccept.png";
                $altstato = "Non attivo";
            }
             */
                                        $profilo = "";
                                        if($r['conferma_email']=="")  $icostato = "notaccept.png";
                                        else $icostato = "verified.png";
                                        ?>
                                        <tr>
                                            <td data-label="" style="min-height:32px">
                                                <div class="fleft"><?= $i ?></div>
                                                <div class="tdToolbar1 fright">
                                                    <a href="javascript:editUser(<?= $idu ?>)"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                                                    <a href="javascript:delUser(<?= $idu ?>)"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                                                </div>
                                            </td>
                                            <td data-label="Cognome"><?= $cognome ?></td>
                                            <td data-label="Email"><?= $email ?></td>
                                            <td><img src="main/contents/icone/<?=$icostato?>" class="ico18"/></td>
                                            <td data-label="Data registrazione"><?= $data_reg ?></td>
            
                                            <td class="tdToolbar" style="min-width:260px">
                                                <a href="javascript:editUser(<?= $idu ?>)"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                                                <a href="javascript:delUser(<?= $idu ?>)"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                                            </td>
                                        </tr>
                                        <?
                                    }
        ?>
                            </tbody>
                        </table>


                        <input type="hidden" name="MSID" value="<?= $MSID ?>" />
                        <input type="hidden" name="sz" value="utenti" />
                        <input type="hidden" name="azione" value="" />
                        <input type="hidden" name="id" value="" />

                        <input type="hidden" name="tab" value="<?= $tab ?>" />
                        <input type="hidden" name="tab2" value="<?= $tab2 ?>" />

                        <input type="hidden" name="ord" value="<?= $ord ?>" />
                    </form>

                <? } elseif ($tab == 2) { 
                    
                    include "gruppiutenti.inc.php";

                }
?>
    </div>
    </div>
        
    <? } elseif ($isubsezione == 1) { ?>

        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>

        <div class="spessore"></div>

        <?
        include "utente.php";
        ?>


    <? } elseif ($isubsezione == 2) { ?>

        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>

        <div class="spessore"></div>

        <?
        include "nuovoutente.php";
        ?>
    <? } elseif ($isubsezione == 3) { ?>

        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>

        <div class="spessore"></div>

        <?
        include "edit_gruppo.php";
        ?>


    <? } ?>

</div>

