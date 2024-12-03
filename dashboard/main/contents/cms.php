<?

include "headercms.php";

if(!isset($tab) || $tab=="") $tab=1;
if(!isset($tab2) || $tab2=="") $tab2=0;

if(!isset($isubsezione) || $isubsezione=="") $isubsezione=0;
if(empty($nxpage)) $nxpage=50;
if(empty($npage)) $npage=0;

?>
<script>

function setTab(t)
{
    document.frmins.tab.value = t;
    document.frmins.sezione.value = 'cms,0';
    document.frmins.submit();
}

function setTab2(t)
{
    document.frmins.tab2.value = t;
    //document.frmins.sezione.value = 'cms,0';
    document.frmins.submit();
}

function back(){
	
	document.frmmenu.sezione.value='cms,0';
        document.frmmenu.id.value=0;
	document.frmmenu.submit();
	
}

</script>
<div class="box_cnt">
    
  
    <div class="tabmenu tabmenuadmin">
         <!--div class="tabitem <? if($tab==0) echo "tabitemon"?>" onclick="setTab(0)"><div class="itmTab">Sito Web</div></div-->
         
         <div class="tabitem <? if($tab==1) echo "tabitemon"?>" onclick="setTab(1)"><div class="itmTab">Strutture/Partner</div></div>
         <div class="tabitem <? if($tab==2) echo "tabitemon"?>" onclick="setTab(2)"><div class="itmTab">Itinerari</div></div>
         <div class="tabitem <? if($tab==3) echo "tabitemon"?>" onclick="setTab(3)"><div class="itmTab">Guide ciclo-turistiche</div></div>
         <div class="tabitem <? if($tab==4) echo "tabitemon"?>" onclick="setTab(4)"><div class="itmTab">Comuni</div></div>
         <div class="tabitem <? if($tab==5) echo "tabitemon"?>" onclick="setTab(5)"><div class="itmTab">Stazioni di ricarica</div></div>
         <div class="tabitem <? if($tab==6) echo "tabitemon"?>" onclick="setTab(6)"><div class="itmTab">Eventi</div></div>
         <!--<div class="tabitem <? if($tab==7) echo "tabitemon"?>" onclick="setTab(7)"><div class="itmTab">Promozioni</div></div>-->
         <div class="tabitem <? if($tab==8) echo "tabitemon"?>" onclick="setTab(8)"><div class="itmTab">Sponsor/Collegamenti</div></div>
         <!--<div class="tabitem <? if($tab==9) echo "tabitemon"?>" onclick="setTab(9)"><div class="itmTab">Altro</div></div>-->
         <div class="tabitem <? if($tab==10) echo "tabitemon"?>" onclick="setTab(10)"><div class="itmTab">Regioni</div></div>

         
    </div>
    <div style="background:white;clear:both">
    <div class="box_cnt">
        
        <? if($tab==0){ ?>
        
        <? } elseif($tab==1){ ?>
        
        <? include "inc.strutture.php" ?>
        
        <? } elseif($tab==2){ ?>
        
        <? include "inc.itinerari.php" ?>
        
        <? } elseif($tab==3){ ?>
        
        <? include "inc.guide.php" ?>
        
        <? } elseif($tab==4){ ?>
        
        <? include "inc.comuni.php" ?>
        
        <? } elseif($tab==5){ ?>
        
        <? include "inc.stazioni.php" ?>
        
        <? } elseif($tab==6){ ?>
        
        <? include "inc.eventi.php" ?>
        
        <? } elseif($tab==8){ ?>
        
        <? include "inc.sponsor.php" ?>
        
        <? } elseif($tab==9){ ?>
        
        <? include "inc.altro.php" ?>

        <? } elseif($tab==10){ ?>
        
        <? include "inc.regioni.php" ?>
        
        <? } ?>

        
        
    </div>
        
        
    </div>
    
</div>