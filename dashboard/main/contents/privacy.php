<?
global  $language;

$msgtxt = addslashes(Get_TXTArea('info_privacy',$language));

			$sql = "SELECT * FROM t_privacy";
			$mydb->DoSelect($sql);
			$rp = $mydb->GetRow();
			
			$RS = mydecodeTxt($rp['nome']);
			$INDIRIZZO = $rp['indirizzo'];
			$PIVA = $rp['piva'];
			$CITTA =  getComune($rp['citta']);
			$PROV  =  getProvincia($rp['prov']);
			$CAP   =  $rp['cap'];
			$RESPONSABILE = mydecodeTxt($Responsabile);
			
			eval("\$msg=\"$msgtxt\";");
			
			echo $msg = stripslashes($msg);
?>
