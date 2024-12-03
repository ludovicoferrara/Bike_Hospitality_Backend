<?
global $searchstr;

$cerca = trim($searchstr);

#echo "cerco $cerca <br/><br/>";



  $sql = "SELECT tt.id_area, tt.testo FROM $tbl_testi as tt, t_sez_aree as tsa WHERE tt.id_area = tsa.id_area AND (tt.testo LIKE '%$cerca%' OR tt.titolo LIKE '%$cerca%' ) LIMIT 0,20";# 
$a1=$mydb->DoSelect($sql);

 $sql = "SELECT tu.* FROM minisiti as tu WHERE tu.pubblicato='1'  AND (tu.nome LIKE '%$cerca%' OR tu.cognomers LIKE '%$cerca%' OR tu.indirizzo LIKE '%$cerca%') ";# 
$a2=$mydbNW->DoSelect($sql);
/*
$sql = "SELECT * FROM staff WHERE visibile='1' AND (nome LIKE '%$cerca%' OR titolo LIKE '$cerca' OR email LIKE '$cerca')";# 
$a3=$mydb->DoSelect($sql);

$sql = "SELECT t2.* FROM t_prodotti as t1, t_testi_prodotti as t2 WHERE t1.visibile='1' AND t1.id=t2.id_prod AND ";
$sql .= "(t2.titolo LIKE '%$cerca%'  OR t2.testo0 LIKE '%$cerca%'  OR t2.note LIKE '%$cerca%'  OR t2.note1 LIKE '%$cerca%' )";# OR t2.testo3 LIKE '%$cerca%'OR t2.testo6 LIKE '%$cerca%'
$a4=$mydb->DoSelect($sql);
/*
*/


$i=0;

$found=0;

?>

<ul class="" style="margin-left:5px">
<?
$count = 0;
while($r=$a1[$i++]){
	
	
	
	 $sql = "SELECT id_sezione,navigazione FROM $tbl_sez_aree WHERE id_area = ".$r['id_area'];
	$mydb->DoSelect($sql);
	$rsez = $mydb->GetRow();
	
	$nav = $rsez['navigazione'];
	
	if($nav==""){
	 
    $sql = "SELECT sz, alias FROM $tbl_sezioni WHERE id_sezione = ".$rsez['id_sezione'];
	$mydb->DoSelect($sql);
	$rsez2 = $mydb->GetRow();
	
	$lnk = $rsez2['sz'];
	 $aliassez = $rsez2['alias'];
	} else {
		
		$anav = explode(";",$nav);
		$lnk = $anav[0];
	}
	/* (strstr($r['testo'],$cerca) || 1) && */
	if( $aliassez!="generale"  && $aliassez!="emailautomatiche"   && $aliassez!="sott_newsletter"  && $aliassez!="login"  && $aliassez!="account"){
		
		$count++;
		 $found++;
		
		
		$des = html_entity_decode($r['testo']);
		
		$des = strip_tags($des);

        $des = substr($des,0,200);
        
        $des = str_ireplace($cerca,"<span class=\"textevi\">".$cerca."</span>",$des);
		/**/
		
		echo "<li><span class=\"titolo\">$count) <a href=\"".$urlbase."index.php?sz=".$lnk."\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo $des;
        echo "...<br/><hr><br/></li>";	
        
	}
	/*
	if(strstr($r['titolo'],$cerca)){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['titolo']);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"$urlbase?sz=".$lnk."\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($testo);
        echo "<br/><hr><br/></li>";	
        
	}
	*/
	

?>

<? } ?>
<?

$i=0;

while($r=$a2[$i++]){
	
	$found++;
	
 	$id_ut = $r['id_utente'];
 	
 	$nome = mydecodeTxt($r['nome'])." ".mydecodeTxt($r['cognomers']);
	
	if(true)#strstr($r['testo'],$cerca)
	{
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['testo']);
		$des = $nome;

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"".$urlbase."index.php?sz=1012,0&idms=".$id_ut."\" target=\"_blank\">vai alla pagina dell'associato</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "<br/><hr><br/></li>";	
        
	}
	
}



if(false){


?>

<?


$i=0;

while($r=$a3[$i++]){
	
	$found++;
	
 	$id_ = $r['id'];
 	
	
	if(strstr($r['nome'],$cerca)){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['testo']);
		
$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"".$urlbase."index.php?sz=staff\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "...<br/><hr><br/></li>";	
        
	}
	if(strstr($r['titolo'],$cerca)){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['titolo']);
		$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"".$urlbase."index.php?sz=staff\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "...<br/><hr><br/></li>";	
        
	}
	if(strstr($r['email'],$cerca)){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['categoria']);
		$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"".$urlbase."index.php?sz=staff\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "...<br/><hr><br/></li>";	
        
	}
	
}

?>
<?


$i=0;

while($r=$a4[$i++]){
	
	
	
	$found++;
	
 	$id_ = $r['id_prod'];
 	$titolo = strtolower($r['titolo']);
 	
 	echo "<!-- start a4 $i $found $id_ $titolo $cerca -->";
	/*
	if(strstr($r['testo'],$cerca)){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['testo']);
		
$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"$urlbase?sz=1023,$idneg\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($titolo);
        echo "...<br/><hr><br/></li>";	
        
	}*/
	if(strstr($titolo,strtolower($cerca))){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['titolo']);
		$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"".$urlbase."index.php?sz=schedalavoro&id=$id_\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "...<br/><hr><br/></li>";	
        
	}
if(strstr($r['testo0'],$cerca) || strstr(strtolower($r['note']),strtolower($cerca))   || strstr(strtolower($r['note1']),strtolower($cerca))){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['testo5']);
		$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"".$urlbase."index.php?sz=schedalavoro&$id_\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "...<br/><hr><br/></li>";	
        
	}
	/*
	if(strstr($r['note'],$cerca) || strstr(strtolower($r['note']),strtolower($cerca))){
		
		$testo = str_replace($cerca,"<span class=\"textevi\">".$cerca."</span>",$r['note']);
		$des = nobr($testo);

$des = substr($des,0,200);
		
		echo "<li><span class=\"titolo\">$i) <a href=\"$urlbase?sz=1023,$id_\" target=\"_blank\">vai alla pagina</a></span><br/><br/>";
  		echo html_entity_decode($des);
        echo "...<br/><hr><br/></li>";	
        
	}*/
	
}
}
?>

</ul>

<?

if($found>0){
?>
<div align="center"><?=$lang['esito_ricerca']?></div>
<?
} 

$flog = fopen("_log/cerca.log","a");
fputs($flog,Date("d/m/Y").": ".$cerca." \r\n");
fclose($flog);
?>