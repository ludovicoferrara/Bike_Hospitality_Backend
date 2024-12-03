<?php
$ititolo=0;
if($row!=null){
parse_str($row['params'], $res);extract($res);
$testo  = "";
if(isset($row['testo'])) $testo  = mydecodeTxt(trim($row['testo']));

$int_ = "";
$foo_ = "";
if($rowarea['int_']!="") $int_   = trim($rowarea['int_']);
if($rowarea['foo_']!="") $foo_   = trim($rowarea['foo_']);

$testo = str_replace("MSID", "MSID=".$MSID, $testo);

if(isset($b_nl2br))
    if($b_nl2br=='1') $testo = nl2br($testo);

$_titolo = "";
if(isset($row['titolo'])) $_titolo = mydecodeTxt(trim($row['titolo']));
if($_titolo=="//@HIDDEN@//") $_titolo="";

#$testo = Replace_view($int_.$testo.$foo_ );
$testo = $int_.$testo.$foo_ ;

$_cmsmode = "replace_view";
include $extincpath_hdd."_inc/_cms.php";

if(strstr($testo,"|||")) {
	$testo = Replace_vars($testo);
}

if(strstr($testo,"|A|")){
	
	$testo = Replace_area($testo);
	
}
if(isset($link))
{
                $link = str_replace("MSID", "MSID=".$MSID, $link);
		$link = str_replace("_LANG_", $language, $link);
		$link = str_replace("_SZ_", $sz0, $link);
                
} else $link = "";
	#$xstyle = $style0;

	if($area=="box9"){
		
		?>
		
	<div class="box9 testosmscuro"  >
	<div class="box9top"></div>
	<div class="box9in">
	<? echo $testo; ?>
	</div>
	<div class="box9down"></div>
    </div>
		
		<?
		
		
		
	} 


	elseif ($area=="box1" || $area=="box2" || $area=="box6" ){   #
	
?> 
	<div class="<?=$area?> testo <?=$cls?>" style="<?=$css?>"  >
	
            <? echo $testo; ?>

        </div>
<? 


} elseif($area=="box7" || $area=="box5t" || $area=="box6t" ){
	
	if($area_tpl=="xcenter") echo "<div class=\"content\" >"; 
	
?> 
    
	   <div class="<?=$area?>" >
	  
	  <div class="boxtitolo">
	  
	     <div class="titolo_big" ><?=$_titolo?></div>

	  </div>
	 <p>&nbsp;</p>
	
      <span class="testo"><? echo $testo; ?></span>
    
      
      </div>
<? 
if($area_tpl=="xcenter") echo "</div>";
$ititolo++;

}  elseif ($area=="box3" ){
    
    #if($area_tpl!="xcenter") echo "\t\t<div class=\"content1\">"; 
?>	
<div class="<?=$area?>"  style="<?=$css?>" >
 
     <? echo $testo; ?>

</div>
<? 
#if($area_tpl!="xcenter") echo "\t\t</div>"; 

} elseif ($area=="box4" ){
?>	
<div class="<?=$area?>"  style="<?=$css?>" >

      <span class="testo"><? echo $testo; ?></span>
   
      </div>
<? 
$ititolo++;

} 


elseif ( $area=="img" && $area_tpl == "top"){
	Draw_VImgArea($rowarea['nome'],$language);
}elseif ( $area=="txt" ){
	echo $testo; 
}elseif ( $area=="custom"){
?>	
<? echo $testo; ?>
<?
}

}

?>