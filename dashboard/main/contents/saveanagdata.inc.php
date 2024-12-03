<?php

   $ida=$id;
   
     $a_usrfparams = find_post("usrf_");
     $usrfparams = serialize($a_usrfparams); 
     
    foreach ($a_usrfparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	$a_usrfparams[$k] = myencodeTxt($v);
    	
    	
    }
    extract($a_usrfparams);
    
    if(!isset($usrf_nome)) $usrf_nome = "";
    if(!isset($usrf_cognome) && isset($usrf_rs)) $usrf_cognome = $usrf_rs;
    /*
    $sql = "SELECT COUNT(*) as n FROM $tbl_aziende WHERE codice='$usrf_codice' AND $key_aziende != $ida";
    $mydb->DoSelect($sql);
    $rtmp=$mydb->GetRow();
    if($rtmp['n']>0)
    {
        $errmsg = "ATTENZIONE: il codice inserito &egrave; gi&agrave; in uso.";
        $usrf_codice = $usrf_oldcodice;
    }
    */
    $sql = "UPDATE $tbl_aziende SET nome='$usrf_nome', cognome='$usrf_cognome', codice = '$usrf_codice', note='$usrf_note', email='$usrf_email'  WHERE id_anag=$ida";
    $mydbG->ExecSql($sql);
    /*
    $sql = "UPDATE $tbl_aziende_anag SET cognome='$usrf_cognome',nome='$usrf_nome',  resi_comune_txt='$usrf_citta', resi_via='$usrf_indirizzo', resi_cap='$usrf_cap', ";
    $sql .= "resi_provincia_txt='$usrf_prov', tel='$usrf_telefono'  WHERE id_utenti_anag = $ida";
    $mydbG->ExecSql($sql);
    */

    $sql = "UPDATE $tbl_aziende_anag SET cognome='$usrf_rs', nomebreve='$usrf_insegna', piva='$usrf_piva', resi_comune='$usrf_comune', resi_provincia='$usrf_provincia', resi_via='$usrf_indirizzo', resi_cap='$usrf_cap', ";
    $sql .= " resi_civico='$usrf_civico', resi_telefono='$usrf_telefono', pec='$usrf_pec', cod_sdi='$usrf_cdest' WHERE id_anag = $ida";
    #resi_provincia_txt='$usrf_prov',
    $mydbG->ExecSql($sql);
    /**/
    
    if(isset($usrf_insegna))
    {
        $sql = "UPDATE $tbl_aziende_anag SET nomebreve='$usrf_insegna'  WHERE id_anag = $ida";
        $mydbG->ExecSql($sql);
        
    }
    
    if($_wsnetwork && isset($usrf_insegna))
    {
        $sql = "UPDATE $tbl_websites SET titolo = '$usrf_insegna' WHERE id_anag=$ida";
        $mydbNW->ExecSql($sql);
        
        $sql = "SELECT id FROM $tbl_websites WHERE  id_anag=$ida";
        $mydbNW->DoSelect($sql);
        $rws=$mydbNW->GetRow();
        $idws = $rws['id'];
        
        $sql = "UPDATE $tbl_websites_testi SET titolo = '$usrf_insegna' WHERE id_rel=$idws";
        $mydbNW->ExecSql($sql);
        
    }
        
    

