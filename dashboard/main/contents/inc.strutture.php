<!--#inc.strutture-->
<?php
if(!isset($tab) || $tab=="" ) $tab=2;
if(!isset($ord)) $ord = my_statevar_read("ordAnag");
if(!isset($searchstr)) $searchstr = my_statevar_read("searchstrAnag");
if(!isset($searchRegione)) $searchRegione = my_statevar_read("searchRegione");
if(!isset($searchProv)) $searchProv = my_statevar_read("searchProv");
if(empty($nxpage)) $nxpage = my_statevar_read("nxpageAnag");
if(!isset($isubsezione) || $isubsezione=="") $isubsezione=0;
if(empty($nxpage)) $nxpage=50;

$sql = "SELECT * FROM regioni";
$a_regioni = $dbDati->DoSelect($sql);
/*
if($azione=="delUAnag")
{
    $sql = "SELECT id_utente_portale FROM contatti WHERE id_utentihs = $id";
    $mydbG->DoSelect($sql);
    $rtmp=$mydbG->GetRow();
    
    $idu = $rtmp['id_utente_portale'];
    
    $sql = "DELETE FROM t_utenti WHERE idutente=$idu";
    $mydb->ExecSql($sql);
    
    $sql = "DELETE FROM contatti_anag WHERE id_utenti_anag=$id";
    $mydbG->ExecSql($sql);
    
    $sql = "DELETE FROM anagrafiche_contatti WHERE id_utente_ext=$id";
    $mydbG->ExecSql($sql);
    
    $sql = "DELETE FROM contatti WHERE id_utentihs=$id";
    $mydbG->ExecSql($sql);
}
 * 
 */
if($azione=="delAnag")
{

    
    $sql = "DELETE FROM anagrafiche_contatti WHERE id_azienda=$id";
    $mydbG->ExecSql($sql);
    
    $sql = "DELETE FROM anagrafiche_gruppi WHERE id_utente=$id";
    $mydbG->ExecSql($sql);
    
    $sql = "DELETE FROM $tbl_aziende WHERE id_anag=$id";
    $mydbG->ExecSql($sql);
    
    $sql = "DELETE FROM $tbl_aziende_anag WHERE id_anag=$id";
    $mydbG->ExecSql($sql);
    
    $sql = "DELETE FROM $tbl_websites WHERE id_anag=$id";
    $mydbNW->ExecSql($sql);
}

if($azione=="addGruppo" && isset($newGroup) && $newGroup!="")
{
     $sql = "INSERT INTO gruppi_anagrafiche (nome, tab) VALUES ('".myencodeTxt($newGroup)."', '2')";
    $mydbG->ExecSql($sql);
}

if($azione=="delGruppo")
{
    $sql = "DELETE FROM gruppi_anagrafiche WHERE id_gruppo=$idGruppo";
    $mydbG->ExecSql($sql);
}
/*
if($azione=="addGruppoUt" && isset($newGroupUt) && $newGroupUt!="")
{
     $sql = "INSERT INTO gruppi (nome, tab) VALUES ('".myencodeTxt($newGroupUt)."', '0')";
    $mydbG->ExecSql($sql);
}
if($azione=="delUtGruppo")
{
    $sql = "DELETE FROM gruppi WHERE id_gruppo=$idGruppo";
    $mydbG->ExecSql($sql);
}
 * 
 */
?>
<script>

function setTab(t)
{
    document.frmins.tab.value = t;
    document.frmins.sezione.value='cms,0';
    document.frmins.submit();
}


function reportAnag(id){
	
    //document.frmmenu.sezione.value='anagrafiche,6';
    //document.frmmenu.id.value=id;
    //document.frmmenu.submit();

}

function editAnag(id){
	
        document.frmmenu.sezione.value='cms,2';
        document.frmmenu.id.value=id;
	document.frmmenu.submit();
	
}



function delAnag(id){
	
        if(confirm('ATTENZIONE: confermi la cancellazione dell\'anagrafica?'))
        {
	document.frmmenu.azione.value='delAnag';
        document.frmmenu.id.value=id;
	document.frmmenu.submit();
        }
}

function addGruppo()
{
        document.frmins.azione.value='addGruppo';
        waitpage();
	document.frmins.submit();
}


function back(){
	
	document.frmmenu.sezione.value='cms,0';
        document.frmmenu.id.value=0;
	document.frmmenu.submit();
	
}
function editGruppo(id){
	
	document.frmmenu.sezione.value='anagrafiche,7';
        document.frmmenu.params.value='idGruppo='+id;
	document.frmmenu.submit();
	
}
function delGruppo(id){
	
        if(confirm('Confermi la cancellazione del gruppo?'))
        {
	document.frmmenu.azione.value='delGruppo';
        document.frmmenu.params.value='idGruppo='+id;
	document.frmmenu.submit();
        }
	
}


function refresh()
{
    waitpage();
    document.frmins.submit();
}
function esporta()
{
    document.frmins.esporta.checked=true;
    refresh();
}

function setOrd(strord){
    
        var ord = '<?=$ord?>';
        
        if(strord=='nome')
        {
            if(ord=='0') ord = 1;
            else ord = '0';
        }
        if(strord=='categoria')
        {
            if(ord=='2') ord = 3;
            else ord = '2';
        }
        if(strord=='data_reg')
        {
            if(ord=='4') ord = 5;
            else ord = '4';
        }
        if(strord=='codice')
        {
            if(ord=='6') ord = 7;
            else ord = '6';
        }
        if(strord=='localita')
        {
            if(ord=='8') ord = 9;
            else ord = '8';
        }
    
    
	waitpage();
    	document.frmins.ord.value=ord;
    	document.frmins.submit();
    }
</script>
<div class="box_cnt">

<?
if($isubsezione==0 )
{
?>
<?php


if(!isset($npage)) $npage = 0;

switch ($ord){
	case 0: {
		
		$orderby = "tu.cognome ASC";
		
	} break;
	
	case 1: {
		
		$orderby = "tu.cognome DESC";
		
	} break;
    	case 2: {
		
		$orderby = "tu.categoria ASC";
		
	} break;
    	case 3: {
		
		$orderby = "tu.categoria DESC";
		
	} break;
        case 4: {
		
		$orderby = "tu.data_reg ASC";
		
	} break;
    	case 5: {
		
		$orderby = "tu.data_reg DESC";
		
	} break;
    
       case 6: {
		
		$orderby = "tu.codice ASC";
		
	} break;
    	case 7: {
		
		$orderby = "tu.codice DESC";
		
	} break;
        case 8: {
		
		$orderby = "ta.resi_provincia ASC";
		
	} break;
    	case 9: {
		
		$orderby = "ta.resi_provincia DESC";
		
	} break;
    

	default: 
        {
            $ord = 0;
            $orderby = "tu.categoria ASC, tu.cognome ASC";
        }
}

##$id_tipoClienti = getIdTipologia('Struttura Ricettiva', $mydbG);

$cond = "";
$from = "";
if(isset($searchstr) && $searchstr!="")
{
$cond .= " AND (ta.nome LIKE '%$searchstr%' OR ta.cognome LIKE '%$searchstr%' ) ";
}
if(isset($searchRegione) && $searchRegione!="")
{
    $cond .= " AND ( 0 ";
    $sql = "SELECT * FROM province WHERE id_regione=$searchRegione";
    $aProv = $dbDati->DoSelect($sql);
    foreach($aProv as $k => $rp)
    {
        $p = $rp['codice_provincia'];
        $cond .= " OR ta.resi_provincia = '$p' ";
        
    }
    $cond .= " ) ";
}
if(isset($searchProv) && $searchProv!="" && $searchRegione!="")
{
    $cond .= " AND ta.resi_provincia = '$searchProv' ";
}
if(isset($searchCategoria) && $searchCategoria!="")
{
    $cond .= " AND tu.categoria='$searchCategoria' ";
}
#$sql = "SELECT COUNT(*) FROM $tbl_aziende as ta, anagrafiche_gruppi as tg WHERE ta.$key_aziende=tg.id_utente AND tg.id_gruppo=$id_gruppoClienti  $cond";#level<='$MAXUSERSLEVEL'
$sql = "SELECT COUNT(*) FROM $tbl_aziende as tu, $tbl_aziende_anag as ta WHERE  tu.id_anag=ta.id_anag AND  tu.tipo=$_tipoanagAff AND tu.id_circuito=$id_location $cond";#level<='$MAXUSERSLEVEL'
$mydbG->DoSelect($sql);
$ntot = 0;
if( ($rcount = $mydbG->GetRow()) )
{
$ntot = $rcount[0];
}
$ntotpage = floor($ntot/$nxpage);
if($ntotpage != $ntot/$nxpage) $ntotpage++;
	
$nn = $npage*$nxpage;


$sql = "SELECT tu.codice, tu.categoria, tu.data_reg, ta.* FROM $tbl_aziende as tu, $tbl_aziende_anag as ta  WHERE tu.id_anag=ta.id_anag AND  tu.tipo=$_tipoanagAff AND tu.id_circuito=$id_location  $cond ORDER BY $orderby LIMIT $nn, $nxpage";# ";tu.level<='$MAXUSERSLEVEL'
#, tu.subcategoria

$a_utenti = $mydbG->DoSelect($sql);

$sql = "SELECT * FROM gruppi_anagrafiche WHERE tab='2'";#
$a_gruppi = $mydbG->DoSelect($sql);

$sql = "SELECT * FROM utenti_categorie WHERE tipo='1' AND main_tipo='2' AND id_parent=0";
$a_cat = $mydbG->DoSelect($sql);

 ?>


    <div style='text-align: left'>
            <a href="?MSID=<?= $MSID ?>&tab=<?=$tab?>&sz=cms,4"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi Struttura</a>
    </div>



    <form name="frmins" method="post" action="<? echo $action ?>" >
            
        <div class="spessore" style="height:20px"></div>
        
        <div class="testo2" align="left">
            Filtra per nome: <input type="text" name="searchstr" value="<?=$searchstr?>" />
            <img src="main/contents/icone/magnifier.png" class="ico24 imgcliccabile" onclick="refresh()" align="absmiddle" />
            <? if($searchstr!=""){?>
            <img src="main/contents/icone/magnifier-r.png" class="ico24 imgcliccabile" onclick="document.frmins.searchstr.value='';refresh()" align="absmiddle" />
            <? } ?>
            <div class="spessore"></div>
            Filtra per categoria: <select name="searchCategoria" onchange="refresh()">
            <option value="">-tutte-</option>
            <? 
               foreach($a_cat as $k => $rc)
               {
                   $s = "";
                   if($rc['id_cat']==$searchCategoria) $s = "selected";
                   ?>
                <option value="<?=$rc['id_cat']?>" <?=$s?> ><?=$rc['nome']?></option>
            <?
               }
            ?>
        </select>
            <div class="spessore"></div>
            Filtra per regione: <select name="searchRegione" onchange="refresh()">
            <option value="">-tutte-</option>
            <? 
               foreach($a_regioni as $k => $rg)
               {
                   $s = "";
                   if($rg['id_regione']==$searchRegione) $s = "selected";
                   ?>
                <option value="<?=$rg['id_regione']?>" <?=$s?> ><?=$rg['nome_regione']?></option>
            <?
               }
            ?>
        </select>
<?
    if($searchRegione!="")
    {

        ?>
    <div class="spessore"></div>
            Filtra per provincia: <select name="searchProv" onchange="refresh()">
            <option value="">-tutte-</option>
            <? 
               foreach($aProv as $k => $rp)
               {
                   $s = "";
                   if($rp['codice_provincia']==$searchProv) $s = "selected";
                   ?>
                <option value="<?=$rp['codice_provincia']?>" <?=$s?> ><?=$rp['nome_provincia']?></option>
            <?
               }
            ?>
        </select>        
            <?
    }
?>
        
        <div class="spessore" style="height:20px"></div>
       
<div style="text-align: left">
Visualizza <input type="text" name="nxpage" value="<?=$nxpage?>" class="lite mini" /> righe per pagina <img src="main/contents/icone/right-arrow-1.png" class="ico24 cliccabile rounded" align="absmiddle" onclick="document.frmins.submit()" /> 
</div>    
<div class="spessore" style="height:10px" align="left"></div> 
<? /*
<div style="text-align: left" class="testo_evi">
<? if($esporta=='1')
{
    #$sqlfull = "SELECT * FROM t_utenti WHERE level<='1'  $cond ORDER BY $orderby ";
    $sqlfull = "SELECT tu.* FROM t_utenti as tu, t_prodotti as tp WHERE tu.id_anag=tp.id AND tu.level<='1'  $cond ORDER BY $orderby ";# ";
    $a_full = $mydb->DoSelect($sqlfull);
    include "esporta.inc.php";
    
    ?>
<a href="download.php?path=csv&f=elenco.xls&t=<?=time()?>" target="_blank">scarica xls</a><br/>
<a href="download.php?path=csv&f=elenco.csv&t=<?=time()?>" target="_blank">scarica csv</a><br/>
<a href="download.php?path=csv&f=elenco.xlsx&t=<?=time()?>" target="_blank">scarica xlsx</a><br/>
<?
}*/

?>

 </div>   
   <div class="spessore" style="height:10px"></div>
   <div class="admtitolo" align="left">
   <? 
   $pagmode = '1';$frm = "document.frmins";
   $href0 = "?MSID=$MSID&sz=cms";
   
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:10px"></div>

   </div>       
           
        <table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th  onclick="setOrd('nome')"><span class="underlined cliccabile">Struttura</span></th>
                    
                    <th  onclick="setOrd('data_reg')"><span class="underlined cliccabile">Data registrazione</span></th>
                    <th   onclick="setOrd('categoria')"><span class="underlined cliccabile">Categoria</span></th>
                    <th   onclick="setOrd('localita')"><span class="underlined cliccabile">Localit&agrave;</span></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                
            
        <?
        $i=0;
        
        #while($r=$a_utenti[$i++])
        if(is_array($a_utenti)) foreach($a_utenti as $i => $r)
        {
            $nome    = mydecodeTxt($r['nome']);
            $cognome = mydecodeTxt($r['cognome'])." ".$nome;
            //$email = mydecodeTxt($r['email']);
            $data_reg = Date_fromdbX($r['data_reg']);
            $idu = $r['id_anag'];
            $codice = $r['codice'];
            
            $categoria = getCategoriaAnag($r['categoria'], $mydbG);
           /* if($r['subcategoria']>0)
            {
                $scategoria = getCategoriaAnag($r['subcategoria'], $mydbG);
                $categoria .= "/".$scategoria;
            }
            
            $stato=$r['stato'];
            $icostato = "verified.png";
            $altstato = "Attivo";
            if($stato=='0') {
                $icostato = "notaccept.png";
                $altstato = "Non attivo";
            }
             */
            $localita="";
            if($r['resi_comune']!="") $localita=getComune($r['resi_comune']);
            if($r['resi_provincia']!="") $localita .= " (".getProvincia($r['resi_provincia']).")";
            /*
            $cognome = addslashes(ucwords(strtolower($cognome)));
            
            $sql = "UPDATE $tbl_aziende SET cognome='$cognome' WHERE id_anag=$idu";
            $mydbG->ExecSql($sql);
            $sql = "UPDATE $tbl_aziende_anag SET cognome='$cognome', nomebreve='$cognome' WHERE id_anag=$idu";
            $mydbG->ExecSql($sql);
            $sql = "UPDATE $tbl_websites SET titolo='$cognome' WHERE id_anag=$idu";
            $mydbNW->ExecSql($sql);
        */
            
            
        ?>
        <tr>
            <td data-label="" style="min-height:32px">
                <div class="fleft"><?=$i+1?></div>
                <div class="tdToolbar1 fright">
                    <a href="javascript:editAnag(<?=$idu?>)" title="Apri scheda anagrafica"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                    <!--a href="javascript:usersAnag(<?=$idu?>)"  title="Elenco utenti"><img src="main/contents/icone/users.png" class="imgcliccabile ico20 fleft" /></a-->
                    <a href="javascript:reportAnag(<?=$idu?>)"  title="Report"><img src="main/contents/icone/book.png" class="imgcliccabile ico20 fleft " style="filter:invert(1);" /></a>
                    <a href="javascript:delAnag(<?=$idu?>)"  title="Elimina anagrafica"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                </div>
            </td>
            <td data-label="Cognome"><?=$cognome?></td>
            
            <td data-label="Data registrazione"><?=$data_reg?></td>
            <td><?=$categoria?></td>
            <td data-label="Località"><?=$localita?></td>
            
                        
            <td class="tdToolbar" style="min-width:260px">
                <a href="javascript:editAnag(<?=$idu?>)" title="Apri scheda anagrafica"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                <!--a href="javascript:usersAnag(<?=$idu?>)"  title="Elenco utenti aziendali"><img src="main/contents/icone/users.png" class="imgcliccabile ico20 fleft spaced" /></a-->
                <a href="javascript:reportAnag(<?=$idu?>)"  title="Report"><img src="main/contents/icone/book.png" class="imgcliccabile ico20 fleft spaced " style="filter:invert(1);" /></a>
                <a href="javascript:delAnag(<?=$idu?>)"  title="Elimina anagrafica"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
            </td>
        </tr>    
        <?
            
        }
        ?>
            </tbody>
        </table>
        
        <input type="hidden" name="MSID" value="<?=$MSID?>" />
        <input type="hidden" name="sezione" value="<?=$sezione?>" />
        <input type="hidden" name="azione" value="" />
        <input type="hidden" name="id" value="" />
        
        <input type="hidden" name="tab" value="<?=$tab?>" />
        <input type="hidden" name="tab2" value="<?=$tab2?>" />  
        
        <input type="hidden" name="ord" value="<?=$ord?>" />
        </form>
      
  <div class="admtitolo" align="left">
   <? 
   $pagmode = '1';$frm = "document.frmins";
   $href0 = "?MSID=$MSID&sz=cms";
   
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:60px"></div>
       </div>
     
<? 
my_statevar_create("ordAnag",$ord);
my_statevar_create("searchstrAnag",$searchstr);
my_statevar_create("searchRegione",$searchRegione);
my_statevar_create("searchProv",$searchProv);
my_statevar_create("nxpageAnag",$nxpage);

?>
<? } elseif($isubsezione==2){ ?>
    
    <?
    if(!isset($tab2) || $tab2=="" || $tab2>3 ) $tab2=0;
    ?>

        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div><div class="spessore"></div>
        
        <?
        $sql = "SELECT ta.*, tu.codice, tu.nome, tu.note, tu.logo, tu.email FROM $tbl_aziende as tu, $tbl_aziende_anag as ta WHERE tu.id_anag=$id AND tu.id_anag=ta.id_anag";
        $mydbG->DoSelect($sql);
        $ru2 = $mydbG->GetRow();

        $usrf_rs       = mydecodeTxt($ru2['cognome']);
        
        ?>
        <div class="titolo"><?=$usrf_rs?></div>
        <div class="spessore"></div>
        
            
        <div class="tabmenu">
            <div class="tabitem <? if($tab2==0) echo "tabitemon"?>" onclick="setTab2(0)"><div class="itmTab">Dati Generali</div></div>
            <div class="tabitem <? if($tab2==2) echo "tabitemon"?>" onclick="setTab2(2)"><div class="itmTab">Altri Dati</div></div>
            <div class="tabitem <? if($tab2==1) echo "tabitemon"?>" onclick="setTab2(1)"><div class="itmTab">Descrizione</div></div>
            <div class="tabitem <? if($tab2==3) echo "tabitemon"?>" onclick="setTab2(3)"><div class="itmTab">Statistiche</div></div>
            
         
    </div>
    <div class="box_cnt">
        

        <?
        
        
        if($tab2==0){
            include "anagrafica.php";
        }
        elseif($tab2==2){
            include "struttura_altro.inc.php";
        }
        elseif($tab2==1){
            include "struttura_testi.inc.php";
        }
        elseif($tab2==3){
            include "struttura_stats.inc.php";
        }
        ?>
      </div> 
        
<? } elseif($isubsezione==4){ ?>
        
        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div><div class="spessore"></div>
        
        <div class="box_cnt">
        
       <? include "anagrafica.php"; ?>
            
       </div> 
        
<? } ?>


</div>
    
   

