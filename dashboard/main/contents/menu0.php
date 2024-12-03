<?
$a_lnkmenu  = array();
$a_sezmenu  = array();
$a_isezmenu  = array();
$a_sezmenu2 = array();
$a_paramsmenu = array();
$a_tree = array();
$nomesezione="";

$_menutop  = 0;
$_menufoo  = 0;
$_menumain = 0;

$sql = "SELECT * FROM t_menu WHERE level = '0' AND visibile='1' ORDER BY id_menu";
$a_menu = $mydb->DoSelect($sql);
$imenu = 0;

if(is_array($a_menu))
{
foreach($a_menu as $imenu => $rmenu){
	

$idmenu = $rmenu['id_menu'];
$menu = strtolower($rmenu['nome']);

if($menu == "top") $_menutop = 1;
elseif($menu == "main") $_menumain = 1;
elseif($menu == "footer") $_menufoo = 1;

$sql = "SELECT tb1.sz,tb1.visibility,tb1.id_sezione,tb1.subsezioni,tb1.subsezioniconfig,tb1.alias,tb2.mode, tb1.params FROM $tbl_sezioni AS tb1, $tbl_sezioni_menu AS tb2 WHERE tb1.id_sezione = tb2.id_sezione AND tb2.id_menu='$idmenu'  AND tb1.visibility='public'";

if($logged=='1'){
	$sql .= " AND (tb2.mode='0' OR tb2.mode='1')";
} else {
	$sql .= " AND (tb2.mode='0' OR tb2.mode='2')";
}
$sql .=" ORDER BY tb2.ordine";
$arrs=$mydb->DoSelect($sql);


$i=0;
if(is_array($arrs))
{
foreach($arrs as $i => $rs)
{
		$sql ="SELECT * FROM $tbl_labels WHERE id_sezione = ".$rs['id_sezione'];
		$mydb->DoSelect($sql);$r=$mydb->GetRow();
		$a_lnkmenu[$idmenu][$i] = $lang[$r['nome']];#$r['label_menu'];
		
        if($isezione==$rs['sz']) $nomesezione = $lang[$r['nome']];
		$sz_ = $rs['sz'];
		$alias = $rs['alias'];
		$a_sezmenu[$idmenu][$i]  = $alias;#$sz_;
		$a_isezmenu[$idmenu][$i]  = $sz_;
		##$a_tree[$idmenu] = $lang[$r['nome']];

		if($rs['subsezioni']=='1' && $rs['subsezioniconfig']!='01')//se la sez ha subsezioni devo puntare alla prima subsezione
		{
			$sql = "SELECT tb1.sz, tb1.alias, tb2.nome FROM $tbl_sezioni AS tb1, $tbl_labels AS tb2 WHERE tb1.id_sezione = tb2.id_sezione ";
			$sql .= "AND tb1.id_parent = ".$rs['id_sezione']." AND tb1.visibility='public' ORDER by tb1.ordine_menu ASC LIMIT 0,1";
			$mydb->DoSelect($sql);
			if($r2=$mydb->GetRow()) {
				 $sz_ = $r2['sz'];
				 ##$a_tree[$idmenu]  .= " -> ".$lang[$r2['nome']];
				
				$a_sezmenu[$idmenu][$i]  = $r2['alias'];;
		        #$a_isezmenu[$idmenu][$i]  = $sz_;
			}
			
			
					
		}
		
		if($rs['subsezioni']=='1' && $sz!=$isezione){
					
		$sql = "SELECT tb1.sz,tb2.nome FROM $tbl_sezioni AS tb1, $tbl_labels AS tb2 WHERE tb1.id_sezione = tb2.id_sezione ";
			$sql .= "AND tb1.sz = ".$sz." ";
			$mydb->DoSelect($sql);
			if($r2=$mydb->GetRow()) {
				##$a_tree[$idmenu]  .= " -> ".$lang[$r2['nome']];
			}
		}
			
		$a_sezmenu2[$idmenu][$i] = $rs['params'];//$sz_;
		
		$a_paramsmenu[$idmenu][$i] = "";
		
        ##if($isezione==$a_isezmenu[$idmenu][$i]) $tree = $a_tree[$idmenu];
	  	
		$i++;
} 


}
}
}
/*
echo "1:";print_r($a_lnkmenu[1]);echo "<br>";
echo "2:";print_r($a_lnkmenu[2]);echo "<br>";
echo "3:";print_r($a_lnkmenu[3]);echo "<br>";
*/
?>