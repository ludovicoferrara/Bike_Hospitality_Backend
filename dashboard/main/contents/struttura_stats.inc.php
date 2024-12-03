<?php
if(!isset($ymesea))  $ymesea = "";
if(!isset($ymeseda)) $ymeseda = "";
#if(!isset($idreporttmp)) $idreporttmp = "";

if(isset($ymese) && $ymese!="")
{
    $a = explode("_",$ymese);
    $year = $a[0];
    $mese = $a[1];
    $periodo = "mese";

} elseif($ymesea!="" ||  $ymeseda!="")
{
    if(!isset($ymesea) || !isset($ymeseda))
    {
        if(!isset($ymesea)) $ymesea = $ymeseda; else $ymeseda = $ymesea;
        $periodo = "mese";
    }
    if($ymesea == $ymeseda) $periodo = "mese";
    else {
        $periodo = "multimese";
        $year = "";
        $mese = $ymeseda."|".$ymesea;
    }
    
    if($periodo == "mese")
    {
    $a = explode("_",$ymeseda);
    $year = $a[0];
    $mese = $a[1];
    }
    
} else {

    $year = Date("Y");
    $mese = Date("m")*1-1;
    $mese = str_pad($mese,2,"0",0);
    if(Date("m")=="01"){
        $mese = 12;
        $year = $year-1;
    }
    $periodo = "mese";

}

include "statistiche.inc.php";


$mstart = "01";
$ystart = 2024;
$cond = "";
    
$imstart = $mstart*1;

$minyear  = Date("Y",time()-365*86400);
$minmonth = Date("m",time()-365*86400);

?>
<script src="main/contents/js/Chart.bundle.js"></script>
<script src="main/contents/js/utils.js"></script>

        <div class="box bordered" style="text-align:left">
            
            <div id="uttotalitop">
            <div class="uttotalitop-title"><div>Visite totali:</div></div>
            <div id="uttotalitop-num"><?=$visiteTot?></div>
            </div>
            
            <div class="clearbox"></div>
            
            
            
        </div>

<div id="toolbox2">

<div style="padding-left:10px">
<div class="titolo_big fleft" id="umese_title" style="padding-top:8px"><?=$title?></div>

<form id="frmins" name="frmins" action="<? echo $action; ?>" method="post" >
    
    <div class="spessore"></div>
    
        
            <div id="sceltaperiodo" class="testo_evi">
        
        Scegli il mese:  <select name="ymese" style="width:130px"  onchange="setMese()" >
            <option value="">-scegli il mese-</option>
            <?
    for($y=$ystart;$y<=Date("Y");$y++){
    for($i=1;$i<=12;$i++)
    {

        if($y<Date("Y") || $i<=(Date("m")))//-1
        if( ($y>$ystart || $i>=$imstart) && $y>=$minyear)
        {
            $skip=false;
            if($y==$minyear && $i<$minmonth) $skip=true;
            $str = "";
            if($ymese==$y."_".$i) $str="selected";
            if(!$skip) echo "<option value=\"".$y."_$i\" $str >".strtoupper(getNomeMese($i))." $y </option>\n";
        }
    }}
    ?>
        </select>   
    oppure scegli il periodo: da <select name="ymeseda" style="width:130px">
    <option value="">-scegli il mese-</option>
    <?
    for($y=$ystart;$y<=Date("Y");$y++){
    for($i=1;$i<=12;$i++)
    {

        if($y<Date("Y") || $i<=(Date("m")))//-1
        if( ($y>$ystart || $i>=$imstart) && $y>=$minyear)
        {
            $skip=false;
            if($y==$minyear && $i<$minmonth) $skip=true;
            $str = "";
            if($ymeseda==$y."_".$i) $str="selected";
            if(!$skip) echo "<option value=\"".$y."_$i\" $str >".strtoupper(getNomeMese($i))." $y </option>\n";
        }
    }}
    ?>

    </select> a 
    <select name="ymesea" style="width:130px">
    <option value="">-scegli il mese-</option>
    <?
    for($y=$ystart;$y<=Date("Y");$y++)
    for($i=1;$i<=12;$i++)
    {

        if($y<Date("Y") || $i<=(Date("m")))//-1
        if( ($y>$ystart || $i>=$mstart) && $y>=$minyear)
        {
            $skip=false;
            if($y==$minyear && $i<$minmonth) $skip=true;
            $str = "";
            if($ymesea==$y."_".$i) $str="selected";
            if(!$skip) echo "<option value=\"".$y."_$i\" $str >".strtoupper(getNomeMese($i))." $y </option>\n";
        }
    }
    ?>

    </select>
    <img src="main/contents/immagini/button1.png" class="ico24 ico rounded imgcliccabile" onclick="setMesi()" align="absmiddle" /> 
    </div>


     



            <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="<? echo $id ?>">
            <input type="hidden" name="tab"  value="<? echo $tab ?>">
            <input type="hidden" name="tab2"  value="<? echo $tab2 ?>">
            <input type="hidden" name="sezione"  value="cms,<?=$isubsezione?>">
            <input type="hidden" name="azione"  value="">
            
</form>

</div>
    
    <div class="spessore" style="height:40px;"></div>

    <div id="UsersCnt" class="grid-container">
        
        <!-- Utenti -->
        <div id="utChartCnt">
            <div class="titolo_big">Visite giornaliere</div>
            <canvas id="utChart"></canvas>
        </div>
        
        <div class="clearbox"></div>

    </div>
    
    <div class="item2 item2_blu">
        <div class="item2_title"  id="nuoviutentiumeset"><div style="float:left;padding:5px">visite</div>
        </div>
    
    <!--div class="item2_stats" id="nuoviutentiumeses"></div-->
     <div class="item2_ico vetro" style="background-image:url(main/contents/icone/multiple-users-g.png);"></div>
    <div class="item2_number"  id="nuoviutentiumesen"><?=$visitefull?></div>
    
    </div>
    
 
<script>
    //Visite
var ctx5 = document.getElementById("utChart");

var _datasetut   = [<?=$strDataFull?>];

var data = {
	labels: [<?=$labels?>],
	datasets: [
    	{
	    label: 'Visite',
	    data: _datasetut,
	    backgroundColor: 'rgba(255, 206, 145, 0.6)',

            borderColor: 'rgba(230, 127, 0, 0.6)',

            borderWidth: 1
	}
	]
}; 

var myBarChart5 = new Chart(ctx5, {
    type: 'line',
    data: data,
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
    // ////////////////////////////////////////


function setMese()
{
    document.frmins.target = "_self";
    document.frmins.ymeseda.value='';
    document.frmins.ymesea.value='';
    waitpage();
    document.frmins.submit();
}
function setMesi()
{
    document.frmins.target = "_self";
    document.frmins.ymese.value='';
    waitpage();
    document.frmins.submit();
}
    
</script>

