<?php
if(!isset($tab) || $tab=="") $tab=0;

if(!isset($isubsezione) || $isubsezione=="") $isubsezione=0;
if(empty($nxpage)) $nxpage=50;
if(empty($npage)) $npage=0;

#echo ">>".$azione;

if($azione=="delUser")
{
    $sql = "DELETE FROM t_utenti WHERE id_utenti=$id";
    $mydb->ExecSql($sql);
}

?>
<!-- @impostazioni -->
<script>

function setTab(t)
{
    document.frmins.tab.value = t;
    document.frmins.sezione.value = 'impostazioni,0';
    document.frmins.submit();
}

function delUser(id){
	
	//document.frmins.sezione.value='impostazioni,2';
        document.frmins.azione.value='delUser';
        document.frmins.id.value=id;
        waitpage();
	document.frmins.submit();
	
}

function editUser(id){
	
	document.frmmenu.sezione.value='impostazioni,2';
        document.frmmenu.id.value=id;
	document.frmmenu.submit();
	
}

function back(){
	
	document.frmmenu.sezione.value='impostazioni,0';
        document.frmmenu.id.value=0;
	document.frmmenu.submit();
	
}

</script>
<div class="box_cnt">
    
  
    <div class="tabmenu tabmenuadmin">
         <div class="tabitem <? if($tab==0) echo "tabitemon"?>" onclick="setTab(0)"><div class="itmTab">Gestione Operatori</div></div>
         <!--div class="tabitem <? if($tab==2) echo "tabitemon"?>" onclick="setTab(2)"><div class="itmTab">Gestione Categorie</div></div>
         <div class="tabitem <? if($tab==3) echo "tabitemon"?>" onclick="setTab(3)"><div class="itmTab">Messaggi e Risposta Automatica</div></div-->
         
    </div>
    <div style="background:white;clear:both">
    <div class="box_cnt"> 
<?
 if($tab==0) { ?>
<?
if($isubsezione==0)
{
if(empty($nxpage)) $nxpage=50;

$cond = "";
if(isset($search_str) && $search_str!="")
{
$cond = " AND (nome LIKE '%$search_str%' OR cognome LIKE '%$search_str%' OR email LIKE '%$search_str%') ";
}

$sql = "SELECT COUNT(*) FROM t_utenti WHERE level>='$OPERLEVEL' AND level<=$ADMINLEVEL $cond";
$mydb->DoSelect($sql);
$rcount = $mydb->GetRow();

$ntot = $rcount[0];
$ntotpage = floor($ntot/$nxpage);
if($ntotpage != $ntot/$nxpage) $ntotpage++;
	
$nn = $npage*$nxpage;


$sql = "SELECT * FROM t_utenti WHERE level>='$OPERLEVEL' AND level<=$ADMINLEVEL $cond ORDER BY cognome ASC ";# LIMIT $nn, $nxpage";
$a_utenti = $mydb->DoSelect($sql);
 
?>
        <form name="frmins" method="post" action="<? echo $action ?>" >
            
            <div>
            <a href="?MSID=<?=$MSID?>&tab=0&sz=impostazioni,1"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi Operatore</a>
        </div>
            
              <div class="spessore" style="height:20px"></div>
            
        <table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th></th><th>Cognome</th><th>Nome</th><th>Username</th><th>Email</th><th>Profilo</th>
                    <!--<th>Stato account</th>-->
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                
            
        <?
        $i=0;
        foreach($a_utenti as $k => $r)
        {
            $i++;
            $nome    = mydecodeTxt($r['nome']);
            $cognome = mydecodeTxt($r['cognome']);
            $email = mydecodeTxt($r['email']);
            $username = $r['username'];
            $data_reg = Date_fromdbX($r['data_ins']);
            $idu = $r['id_utenti'];
            
            $stato=$r['stato'];
            $icostato = "verified.png";
            $altstato = "Attivo";
            if($stato=='0') {
                $icostato = "notaccept.png";
                $altstato = "Non attivo";
            }
            $profilo=$A_USERSDES[$r['level']];
            
        ?>
        <tr>
            <td data-label="" style="min-height:32px">
                <div class="fleft"><?=$i+$nn?></div>
                <div class="tdToolbar1 fright">
                    <a href="javascript:editUser(<?=$idu?>)"><img src="main/contents/icone/edit-icon.png" class="ico20 fleft" /></a>
                    <a href="javascript:delUser(<?=$idu?>)"><img src="main/contents/icone/cancel.png" class="ico20 fleft" /></a>
                </div>
            </td>
            <td data-label="Cognome"><?=$cognome?></td>
            <td data-label="Nome"><?=$nome?></td>
            <td data-label="Username"><?=$username?></td>
            <td data-label="Email"><?=$email?></td>
            
            <td data-label="Profilo"><?=$profilo?></td>
            <!--<td><a href="#" title="<?=$altstato?>"><img src="main/contents/icone/<?=$icostato?>" class="ico24" /></a></td>-->
            
            <td class="tdToolbar" style="min-width:260px">
                <a href="javascript:editUser(<?=$idu?>)"><img src="main/contents/icone/edit-icon.png" class="ico20 fleft imgcliccabile" /></a>
                <a href="javascript:delUser(<?=$idu?>)"><img src="main/contents/icone/cancel.png" class="ico20 fright imgcliccabile" /></a>
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
        </form>
        
        
<? } elseif($isubsezione==1){
    
    include "nuovooperatore.php";
    
} elseif($isubsezione==2){
    
    include "operatore.php";
}
 } else { ?>
    
    <? include "impostazionicustom.inc.php"; ?>
    
<? } ?>       
    </div>
    </div>
        



</div>

