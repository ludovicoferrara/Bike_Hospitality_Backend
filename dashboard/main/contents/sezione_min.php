<?
$sql = "SELECT nome FROM $tbl_aree WHERE id_area = $id_area";
echo $msg = Get_TXTArea($r['nome'],$language, '0');