<?php

   $_idutente=$id;

    $a_usrparams = find_post("usr_");
    $usrparams = serialize($a_usrparams);     
    
    foreach ($a_usrparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	$a_usrparams[$k] = myencodeTxt($v);
        	
    	
    }
    extract($a_usrparams);
        
    $sql = "UPDATE t_utenti SET nome='$usr_nome', cognome='$usr_cognome', level='$usr_level', email='$usr_email' WHERE id_utenti=$_idutente";
    $mydb->ExecSql($sql);
    #, citta='$usr_citta', indirizzo='$usr_indirizzo', cap='$usr_cap', prov='$usr_prov', tel1='$usr_telefono' 
    /*
     $a_usrfparams = find_post("usrf_");
     $usrfparams = serialize($a_usrfparams); 
     
    foreach ($a_usrfparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	$a_usrfparams[$k] = myencodeTxt($v);
    	
    	
    }
    extract($a_usrfparams);
    
    $sql = "UPDATE aziende SET cognome = '$usrf_rs' WHERE id_utente_portale = $_idutente ";
    $mydbG->ExecSql($sql);
    
    $sql = "SELECT id_utentihs FROM aziende WHERE  id_utente_portale = $_idutente ";
    $mydbG->DoSelect($sql);
    $ra = $mydbG->GetRow();
    $ida = $ra['id_utentihs'];
    
    $sql = "UPDATE aziende_anag SET cognome='$usrf_rs', piva='$usrf_piva', resi_comune_txt='$usrf_citta', resi_via='$usrf_indirizzo', resi_cap='$usrf_cap', ";
    $sql .= "resi_provincia_txt='$usrf_prov', tel='$usrf_telefono', pec='$usrf_pec', codice_dest='$usrf_cdest' WHERE id_utenti_anag = $ida";
    $mydbG->ExecSql($sql);
*/

