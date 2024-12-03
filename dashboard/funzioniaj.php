<?php
extract($_GET);
extract($_POST);

 if(!isset($_incpath)) $_incpath = "";
 
 $_main_dir = "./_main/";
 
include_once $_main_dir."_inc/config.php";//FILE DI CONFIGURAZIONE GENERALE

include_once $_main_dir."_inc/dbmanager.php";   //istanze database, include db.class.php - definizione delle classi

require_once($extincpath_hdd."_inc/common.php");

switch($azione){

	case 'cm'://v
	{
		$dbDati->RefreshConnect();
		
		$sql="SELECT codice_comune, nome_comune FROM comuni  WHERE codice_provincia='$pv'";
		
		$dbDati->Set_Sql($sql);
		$rs = $dbDati->DoSelect();
		$Js='';
		if($dbDati->NrRecord>0){
			foreach ($rs as $k => $res){
				if($Js!='')$Js.=",";
				$Js.=$res['codice_comune']."-".utf8_encode($res['nome_comune']);
			}
		}
		
		echo $Js;	
	} break;
	
	case 'pv'://v
	{
		$dbDati->RefreshConnect();
		
		$sql="SELECT codice_provincia, nome_provincia FROM province  WHERE id_regione='$rg'";

		$dbDati->Set_Sql($sql);
		$rs = $dbDati->DoSelect();
		$Js='';
		if($dbDati->NrRecord>0){
			foreach ($rs as $k => $res){
				if($Js!='')$Js.=",";
				$Js.=$res['codice_provincia']."-".utf8_encode($res['nome_provincia']);
			}
		}
		
		echo $Js;	
	} break;
	
	
	default:
		break;
	

}
/*
 $fname = "_log/funzionilog.txt";
 $f=fopen($fname,"w");
 fputs($f,Date("H:i")." ".$azione." $sql\r\n$Js\r\n");
 fclose($f);
*/
?>