<?

$idmenu = 3;

$nlink = count($a_lnkmenu[$idmenu]);

$msid="";if($logged=='1') $msid="MSID=".$mysessionid."&";
 
?>
<ul class="menu3">
 <?
	for ($i=0;$i<$nlink;$i++){
	  $left=3;if($i==0)$left=0;
	  $href0 = $urlbase;
	  
	  $href  = $href0."?sz=".$a_sezmenu[$idmenu][$i];
          $target = "";
          if(substr($a_sezmenu[$idmenu][$i],0,4)=="url:")
          {
              $href = substr($a_sezmenu[$idmenu][$i],4);
              $target = "_blank";
          }
	  #$href  = $href0.$language."/".$a_sezmenu[$idmenu][$i]."/";
	  if($logged==1) 	  $href.= "&MSID=$MSID";
	  #$href  = $href0.$a_sezmenu[$i];
	  $class="menu3off";
	  if($isezione==$a_isezmenu[$idmenu][$i]){ $class = "menu3on"; }
	?>
	<li ><a href="<?=$href?>" class="<?=$class?>" target="<?=$target?>" ><? echo trim($a_lnkmenu[$idmenu][$i]);?></a></li>
<? 
#if($i<$nlink-1) echo "<li>|</li>\n";#echo "&nbsp;|&nbsp;"; 
}
 /*
<li>| <a href="<?=$url_gestionale?>" target="_blank" title="Area riservata admin" ><img src="main/contents/icone/lock-gr-icon.png" class="ico16"  /></a></li>
  * 
  */
?>
</ul>