<?
$sql = "SELECT nome FROM $tbl_aree WHERE id_area = $id_area";$mydb->DoSelect($sql);$r = $mydb->GetRow();
echo $msg = Get_TXTArea($r['nome'],$language, '0');	?>