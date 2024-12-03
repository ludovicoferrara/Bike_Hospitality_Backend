<!--#inc.comuni-->
<?php
$_postfix = "Comuni";


if(!isset($ord)) $ord = my_statevar_read("ord$_postfix");
if(!isset($searchstr)) $searchstr = my_statevar_read("searchstr$_postfix");
if(!isset($nxpage)) $nxpage = my_statevar_read("nxpage$_postfix");
if(!isset($searchRegione)) $searchRegione = my_statevar_read("searchRegione");
if(!isset($searchProv)) $searchProv = my_statevar_read("searchProv");

if(!isset($isubsezione) || $isubsezione=="") $isubsezione=0;
if(empty($nxpage)) $nxpage=50;

$sql = "SELECT * FROM regioni";
$a_regioni = $dbDati->DoSelect($sql);

if($azione=="delItm")
{
    $sql = "DELETE FROM comuni WHERE id=$id";
    $mydbNW->ExecSql($sql);
    
    $sql = "DELETE FROM comuni_testi WHERE id_rel=$id";
    $mydbNW->ExecSql($sql);
    
    //CANCELLARE IMMAGINI
    $sql = "DELETE FROM comuni_immagini WHERE id_rel=$id";
    $mydbNW->ExecSql($sql);
}
?>
<script>

function setTab(t)
{
    document.frmins.tab.value = t;
    document.frmins.sezione.value='cms,0';
    document.frmins.submit();
}



function editItm(id){
	
    document.frmmenu.sezione.value='cms,2';
    document.frmmenu.id.value=id;
	document.frmmenu.submit();
	
}
	
	

function delItm(id){
	
        if(confirm('ATTENZIONE: confermi la cancellazione del comune?'))
        {
	        document.frmmenu.azione.value='delItm';
            document.frmmenu.id.value=id;
	        document.frmmenu.submit();
        }
}


function back(){
	
	document.frmmenu.sezione.value='cms,0';
    document.frmmenu.id.value=0;
	document.frmmenu.submit();
	
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
        if(strord=='data_ins')
        {
            if(ord=='2') ord = 3;
            else ord = '2';
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
		
		$orderby = "tc.nome_comune ASC, tc.sigla_provincia ASC ";
		
	} break;
	
	case 1: {
		
		$orderby = "tc.nome_comune DESC, tc.sigla_provincia ASC ";
		
	} break;
    case 2: {
		
		$orderby = "ti.data_ins ASC ";
		
	} break;
	
	case 3: {
		
		$orderby = "ti.data_ins DESC ";
		
	} break;
    	
    

	default: 
        {
            $ord = 0;
            $orderby = "tc.nome_comune ASC";
        }
}

$cond = "";
$from = "";
if(isset($searchstr) && $searchstr!="")
{
$cond .= " AND (nome LIKE '%$searchstr%') ";
}

$sql = "SELECT COUNT(*) FROM comuni as ti $from WHERE 1 $cond";
$mydb->DoSelect($sql);
$ntot = 0;
if( ($rcount = $mydb->GetRow()) )
{
$ntot = $rcount[0];
}
$ntotpage = floor($ntot/$nxpage);
if($ntotpage != $ntot/$nxpage) $ntotpage++;
	
$nn = $npage*$nxpage;


$sql = "SELECT ti.*, tc.nome_comune FROM www_bikeh.comuni as ti, generale.comuni as tc   WHERE ti.comune=tc.codice_comune AND ti.id_circuito=$id_location  $cond ORDER BY $orderby LIMIT $nn, $nxpage";
$a_ = $mydb->DoSelect($sql);


 ?>


    <div style='text-align: left'>
            <a href="?MSID=<?= $MSID ?>&tab=<?=$tab?>&sz=cms,4"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi comune</a>
    </div>



    <form name="frmins" method="post" action="<? echo $action ?>" >
            
        <div class="spessore" style="height:20px"></div>
        
        <div class="testo2" align="left">
            Filtra per nome: <input type="text" name="searchstr" value="<?=$searchstr?>" />
            <img src="main/contents/icone/magnifier.png" class="ico24 imgcliccabile" onclick="refresh()" align="absmiddle" />
            <? if($searchstr!=""){?>
            <img src="main/contents/icone/magnifier-r.png" class="ico24 imgcliccabile" onclick="document.frmins.searchstr.value='';refresh()" align="absmiddle" />
            <? } ?>
                    
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
                    <th  onclick="setOrd('nome')"><span class="underlined cliccabile">Comune</span></th>
                    <th >Provincia</th>
                    <th  onclick="setOrd('data_ins')"><span class="underlined cliccabile">Data registrazione</span></th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                
            
        <?
        $i=0;
        
        #while($r=$a_utenti[$i++])
        if(is_array($a_)) foreach($a_ as $i => $r)
        {
            $nome    = mydecodeTxt($r['nome_comune']);

            $idu = $r['id'];

            $localita=getProvincia($r['provincia']);
            $data_reg = Date_fromdb($r['data_ins']);
            
        ?>
        <tr>
            <td data-label="" style="min-height:32px">
                <div class="fleft"><?=$i+1?></div>
                <div class="tdToolbar1 fright">
                    <a href="javascript:editItm(<?=$idu?>)" title="Apri scheda"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                    <a href="javascript:reportItm(<?=$idu?>)"  title="Report"><img src="main/contents/icone/book.png" class="imgcliccabile ico20 fleft " style="filter:invert(1);" /></a>
                    <a href="javascript:delItm(<?=$idu?>)"  title="Elimina"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                </div>
            </td>
            <td data-label="Cognome"><?=$nome?></td>
            
            
            <td data-label="Provincia"><?=$localita?></td>
            <td data-label="Data inserimento"><?=$data_reg?></td>
                        
            <td class="tdToolbar" style="min-width:260px">
                <a href="javascript:editItm(<?=$idu?>)" title="Apri scheda"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                <a href="javascript:reportItm(<?=$idu?>)"  title="Report"><img src="main/contents/icone/book.png" class="imgcliccabile ico20 fleft " style="filter:invert(1);" /></a>
                <a href="javascript:delItm(<?=$idu?>)"  title="Elimina"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
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
   $href0 = "?MSID=$MSID&sz=cms&tab=2";
   
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:60px"></div>
    </div>
     
<? 
my_statevar_create("ord$_postfix",$ord);
my_statevar_create("searchstr$_postfix",$searchstr);
my_statevar_create("nxpage$_postfix",$nxpage);

my_statevar_create("searchRegione",$searchRegione);
my_statevar_create("searchProv",$searchProv);

?>
<? } elseif($isubsezione==2){ ?>
    
    <?
    if(!isset($tab2) || $tab2=="" || $tab2>1 ) $tab2=0;
    ?>

        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div><div class="spessore"></div>
        
        <?
        $sql = "SELECT ti.* FROM comuni as ti WHERE ti.id=$id ";
        $mydb->DoSelect($sql);
        $ru2 = $mydb->GetRow();

        $titolo       = getComune($ru2['comune']);
        
        ?>
        <div class="titolo"><?=$titolo?></div>
        <div class="spessore"></div>
        
            
        <div class="tabmenu">
            <div class="tabitem <? if($tab2==0) echo "tabitemon"?>" onclick="setTab2(0)"><div class="itmTab">Dati Generali</div></div>
            <?/*<div class="tabitem <? if($tab2==2) echo "tabitemon"?>" onclick="setTab2(2)"><div class="itmTab">Altri Dati</div></div>*/?>
            <div class="tabitem <? if($tab2==1) echo "tabitemon"?>" onclick="setTab2(1)"><div class="itmTab">Descrizione</div></div>
            
         
    </div>
    <div class="box_cnt">
        

        <?
        if($tab2==2) $tab2=0;
        
        if($tab2==0){
            include "comune.php";
        }
        elseif($tab2==2){
           // include "comune_altro.inc.php";
        }
        elseif($tab2==1){
            include "comune_testi.inc.php";
        }
        ?>
      </div> 
        
<? } elseif($isubsezione==4){ ?>
        
        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div><div class="spessore"></div>
        
        <div class="box_cnt">
        
       <? include "comune.php"; ?>
            
       </div> 
        
<? } ?>


</div>
    
   

