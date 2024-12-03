<?php
if(!isset($tab)) $tab=0;

$path = "files";

if(!isset($isubsezione) || $isubsezione=="") $isubsezione=0;
if(empty($nxpage)) $nxpage=50;

if($azione=="delete")
{
    $sql = "DELETE FROM t_prodotti WHERE id=$id";
    $mydb->ExecSql($sql);
}
if($azione=="ins")
{
    $evento = addslashes($usr_title);
    $data = Date_fordb($usr_data);
    
    $sql = "INSERT INTO t_prodotti (titolo, id_cat, data_ins, data_rif ) VALUES (";
    $sql .= "'$evento', $usr_cat, NOW(), '$data') ";
    		
    $mydb->ExecSql($sql);
    //echo $sql;
    $idu = $mydb->LastInsertedId;
    
  if($idu>1 ){

                $errmsg = "Il record &egrave; stato inserito!";
        }
}

$cond = "1";
if($search_str!="")
{
$cond .= " AND (nome LIKE '%$search_str%' OR centro LIKE '%$search_str%' OR citta LIKE '%$search_str%') ";
}
if($search_cat!="")
{
    $cond .= " AND id_cat=$search_cat ";
}

$sql = "SELECT * FROM t_categorie ";
$a_cats = $mydb->DoSelect($sql);

$aCategorie=array();

foreach($a_cats as $k => $rc)
{
    $aCategorie[$rc['id']] = $rc['titolo'];
}

$sql = "SELECT COUNT(*) FROM t_prodotti WHERE  $cond ";
$mydb->DoSelect($sql);
$rcount = $mydb->GetRow();

$ntot = $rcount[0];
$ntotpage = floor($ntot/$nxpage);
if($ntotpage != $ntot/$nxpage) $ntotpage++;
	
$nn = $npage*$nxpage;

switch ($ord){
	case 0: {
		
		$orderby = "data_rif DESC";
		
	} break;
	
	case 1: {
		
		$orderby = "data_rif ASC";
		
	} break;
    	case 2: {
		
		$orderby = "titolo ASC";
		
	} break;
    	case 3: {
		
		$orderby = "titolo DESC";
		
	} break;
        case 4: {
		
		$orderby = "id_cat ASC, titolo ASC";
		
	} break;
    	case 5: {
		
		$orderby = "id_cat DESC, titolo DESC";
		
	} break;
    

	default: 
        {
            $ord = 0;
            $orderby = "data_rif DESC";
        }
}


$sql = "SELECT * FROM t_prodotti WHERE  $cond ORDER BY $orderby LIMIT $nn, $nxpage";
$a_eventi = $mydb->DoSelect($sql);


?>
<script>

function setTab(t)
{
    document.frmins.tab.value = t;
     document.frmins.submit();
}

function editItem(id){
	
	document.frmmenu.sezione.value='elenco,1';
        document.frmmenu.id.value=id;
	document.frmmenu.submit();
	
}

function delItem(id){
	if(confirm('Confermi la cancellazione dell\'evento?'))
        {
        waitpage();
	document.frmmenu.azione.value='delete';
        document.frmmenu.id.value=id;
	document.frmmenu.submit();
       }
}

function back(){
	
	document.frmmenu.sezione.value='elenco,0';
        document.frmmenu.id.value=0;
	document.frmmenu.submit();
	
}
</script>
<div class="box_cnt">

<?

if($isubsezione==0 )
{
?>
  
    <div class="tabmenu" >
         <div class="tabitem <? if($tab==0) echo "tabitemon"?>" onclick="setTab(0)"><div class="itmTab">Elenco Eventi</div></div>
         <!--
         <div class="tabitem <? if($tab==1) echo "tabitemon"?>" onclick="setTab(1)"><div class="itmTab">Nuovo Evento</div></div>
         -->
    </div>
    <div style="background:white;clear:both">
    <div class="box_cnt"> 
 <?
 if($tab==0)
{
 ?>
        <div >
            <a href="?MSID=<?=$MSID?>&sz=elenco,2"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi Evento</a>
        </div>
  
    <form name="frmins" method="post" action="<? echo $action ?>" >
            
        <div class="spessore" style="height:20px"></div>
           
<div style="text-align: left">
Visualizza <input type="text" name="nxpage" value="<?=$nxpage?>" class="lite mini" /> righe per pagina <img src="main/contents/icone/right-arrow-1.png" class="ico24 imgcliccabile rounded" align="absmiddle" onclick="document.frmins.submit()" /> 
</div> <div style="text-align: left;margin-top:4px">
<!-- Cerca per nominativo, codice o citt&agrave;: <input type="text"  value="<?=$search_str?>" name="search_str" />-->
Cerca per categoria: <select name="search_cat"  >
                                                <option value="">-tutte-</option>
                                                <? foreach($a_cats as $k => $rc)
                                                {
                                                    $idc = $rc['id'];
                                                    $cat = $rc['titolo'];
                                                    $str="";
                                                    if($search_cat==$idc) $str = "selected";
                                                    ?>
                                                <option value="<?=$idc?>" <?=$str?> ><?=$cat?></option>
                                                <? } ?>
                                            </select>
<img src="main/contents/icone/magnifier.png" class="ico24 imgcliccabile rounded" align="absmiddle" onclick="document.frmins.submit()" />

<? if($search_str!=""){ ?><img src="main/contents/icone/magnifier-r.png" class="ico24 imgcliccabile rounded" align="absmiddle" onclick="document.frmins.search_str.value='';document.frmins.submit()" /><? } ?>
<br/>

</div>      
           
   <div class="admtitolo" align="left">
   <? 
   $pagmode = '1';$frm = "document.frmins";
   $href0 = "?MSID=$MSID&sz=elenco,0&ord=$ord&nxpage=$nxpage";
   
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:20px"></div>
   </div>       
           
        <table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th  onclick="setOrd('titolo')"><span class="underlined cliccabile">Evento</span></th>
                    <th  onclick="setOrd('cat')"><span class="underlined cliccabile">Categoria</span></th>
                    <th  onclick="setOrd('data')"><span class="underlined cliccabile">Data evento</span></th>
                    <th></th>
                    
                </tr>
            </thead>
            
            <tbody>
        <?
        $i=0;
        
        while($r=$a_eventi[$i++])
        {
            $nome    = mydecodeTxt($r['titolo']);
            $data    = Date_fromdb($r['data_rif']);
            $idu = $r['id'];
                        
        ?>
        <tr>
            <td style="min-height:32px">
                <div class="fleft"><?=$i+$nn?></div>
                
                <div class="tdToolbar1 fright">
                    <a href="javascript:showForm(<?=$idu?>)"><img src="main/contents/icone/text-document-page.png" class="ico20 fleft imgcliccabile" /></a>
                    <a href="javascript:editItem(<?=$idu?>)"><img src="main/contents/icone/edit-icon.png" class="ico20 fleft imgcliccabile" /></a>
                    <a href="javascript:delItem(<?=$idu?>)"><img src="main/contents/icone/cancel.png" style="margin-left:12px" class="ico20 fleft imgcliccabile" /></a>
                </div>
                
            </td>
            <td data-label="ID"><?=$idu?></td>
            <td data-label="Evento"><?=$nome?></td>
            <td data-label="Categoria"><?=$aCategorie[$r['id_cat']]?></td>
            <td data-label="Data evento"><?=$data?></td>
            
            <td class="tdToolbar">
                <a href="javascript:showForm(<?=$idu?>)"><img src="main/contents/icone/text-document-page.png" class="ico20 fleft imgcliccabile" /></a>
                <a href="javascript:editItem(<?=$idu?>)"><img src="main/contents/icone/edit-icon.png" class="ico20 fleft imgcliccabile" /></a>
                
                <a href="javascript:delItem(<?=$idu?>)"><img src="main/contents/icone/cancel.png" class="ico20 fright imgcliccabile" /></a>
            </td>
            
        </tr>    
        <?
        }
        ?>
            </tbody>
        </table>
        
        <input type="hidden" name="MSID" value="<?=$MSID?>" />
        <input type="hidden" name="sz" value="<?=$sezione?>" />
        <input type="hidden" name="azione" value="" />
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="ord" value="<?=$ord?>" />
        
        <input type="hidden" name="tab" value="<?=$tab?>" />
        <input type="hidden" name="tab2" value="<?=$tab2?>" />   
        </form>
        
        <script> 
            
    function setOrd(strord){
    
        var ord = '<?=$ord?>';
        
        if(strord=='data')
        {
            if(ord=='0') ord = 1;
            else ord = '0';
        }
        if(strord=='titolo')
        {
            if(ord=='2') ord = 3;
            else ord = '2';
        }
        if(strord=='cat')
        {
            if(ord=='4') ord = 5;
            else ord = '4';
        }
    
    
	waitpage();
    	document.frmins.ord.value=ord;
    	document.frmins.submit();
    }
            
         </script>
<? /*        
  <div class="admtitolo" align="left">
   <? 
   $pagmode = '1';$frm = "document.frmins";
   $href0 = "?MSID=$MSID&sz=utenti&ord=$ord&";
   
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:60px"></div>
       </div>
*/?>        
<? } elseif($tab==1) { ?>

       <!--  <div class="rbutton2" onclick="back()"><div>Indietro</div></div>-->
        
        <div class="spessore"></div>
        
        <?
        include "nuovocdc.php";
        ?>

<? } ?>        
    </div>
    </div>
        
<? } elseif($isubsezione==1){ ?>
        
        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div>
        
        <?
        include "evento.php";
        ?>
        
<? } elseif($isubsezione==2){ ?>
        
       <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div>
        
        <?
        include "nuovo.php";
        ?>
        
        
<? } ?>

</div>

