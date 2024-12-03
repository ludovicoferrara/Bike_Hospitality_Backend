<table class="menu01" ><tr>
<?
$idmenu = 1;

$nlink = 0;

#if (is_array($a_lnkmenu[$idmenu])) {
if (array_key_exists($idmenu, $a_lnkmenu)) {
    $nlink = count($a_lnkmenu[$idmenu]);
}

for ($i=0;$i<$nlink;$i++){
		
     $class0 = "menuitem01";
	 
	
	  
	  $href0 = $urlbase;
	  
	  //$href  = $href0."index.php?sz=".$a_sezmenu[$idmenu][$i]."&amp;language=".$language;
	  $href  = $href0.$language."/".$a_sezmenu[$idmenu][$i]."/";
	  if($logged==1){
	  	$href  = $href0."index.php?sz=".$a_sezmenu[$idmenu][$i]."&amp;language=".$language;
	  	$href.= "&MSID=$MSID";
	  }
	  $class2 = "";
	  $class="menuoff";#if($isezione==$a_sezmenu[$idmenu][$i]){ $class = "menuon"; }
	  if($isezione==$a_isezmenu[$idmenu][$i]){ 
	  	$class = "menuon"; 
	    #$class2 = "menuitem01on";
	    $treebase = trim($a_lnkmenu[$idmenu][$i]);
	    
	    foreach ($_vlanguage as $k => $l){
	    	
	    	$a_flags[$k] = $l."/".$a_sezmenu[$idmenu][$i]."/";
	    	
	    }
	    
	  }
	  


	?><td>
<a href="<?=$href?>" class="" style="<?=$xstyle?>"><div class="<?=$class?> <?=$class0?>" ><p>	
<? echo trim($a_lnkmenu[$idmenu][$i]);?></p>
</div></a></td>
<? 

 }
 if($logged=='1' && false){ ?>
 <li>&nbsp;|&nbsp;<a href="<?=$urlbase?>?sz=iltuoaccount&MSID=<?=$MSID?>" class="menuoff">
IL TUO ACCOUNT</a></li>
 <li>&nbsp;|&nbsp;<a href="javascript:logout()" class="menuoff">
LOGOUT</a></li>
<?
 } 
?>

</tr></table>