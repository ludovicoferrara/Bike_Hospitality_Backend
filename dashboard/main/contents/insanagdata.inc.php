<?php

$a_usrfparams = find_post("usrf_");

foreach ($a_usrfparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	$a_usrfparams[$k] = myencodeTxt($v);
    	/*
    	if($v=="" && $ob[$k]=="1") {
    		$err++;
    		$prosegui = false;
    		
    		$errmsg = "Compilare tutti i campi obbligatori";
    	}
    	*/
    }
    extract($a_usrfparams);
    
$tipo = $_tipoanagAff;
if(!isset($autocodice)) $autocodice = 0;

                         if($usrf_rs!="")
                         {
    		         #$usrf_rs = strtoupper($usrf_rs);
                         ##$tipo=2;
                         $usr_nome = "";
                         $usr_cognome = $usrf_rs;
                         }
    		         
    		     
    		         $stato="AT";
				 
				 	$sql = "INSERT INTO $tbl_aziende ( id_circuito, nome, cognome,  data_reg, tipo, categoria, stato, email) VALUES ( $_id_circuito, " ;
					$sql .= "'$usr_nome', '$usr_cognome',   NOW(), '$tipo', 0,   '$stato', '$usrf_email') ";
					
					$mydbG->ExecSql($sql);
					
					$id_utentihs = $mydbG->LastInsertedId;
					
					if($id_utentihs>0){
                                            
                                            if($usrf_codice=="" && $autocodice=='1') 
                                            {
                                                $codice = str_pad($id_utentihs, 5, "0", 0);
                                                
                                                $sql = "UPDATE $tbl_aziende SET codice='$codice' WHERE id_anag=$id_utentihs ";
                                                $mydbG->ExecSql($sql);
                                            }
                                            
                                         /*   $id_gruppoClienti = getIdGruppoAnag('customers', $mydbG);
                                            
                                            $sql = "INSERT INTO anagrafiche_gruppi (id_utente, id_gruppo) VALUES ($id_utentihs, $id_gruppoClienti)";
                                            $mydbG->ExecSql($sql);
						
						$citta_nas_est = ""; $flagnaz = "I";
						if($usr_codice_paese_nas!=114){
							
							$citta_nas_est = $usr_luogo_nas; 
							$flagnaz = "E";
						}
						
					$usr_nato_il = "$usr_data_nascita_a-$usr_data_nascita_m-$usr_data_nascita_d";
						
					$sql = "INSERT INTO $tbl_anag ( id_utenti_anag, cognome, nome, cfiscale,  piva, sesso, nas_localita, nas_data, nas_comune, nas_provincia, nas_flagnaz, nas_est_localita, nas_est_nazione, ";
				        $sql .= "docu_tipo, docu_numero, docu_ufficio, docu_luogo, docu_rilascio, docu_scadenza, resi_via, resi_comune, resi_provincia, resi_cap, resi_est_localita, resi_est_nazione, ";
				        $sql .= "domi_via, domi_comune, domi_provincia, domi_cap, domi_est_localita, domi_est_nazione, tel, cell, nomebreve, resi_localita, domi_localita) VALUES ( ";
				        $sql = $sql."$id_utentihs, '$usr_cognome', '$usr_nome', '$usr_cf', '$usrf_piva', '$usr_sesso', '$usr_luogo_nas', ";
				        $sql = $sql."'$usr_nato_il', '', '', '$flagnaz', '$citta_nas_est', ";
				        $sql = $sql."'$usr_codice_paese_nas', '', '', '', '', ";
				        $sql = $sql."'', '', ";
				
				        $sql = $sql."'$usr_indirizzo', '$usr_comune', '$usr_provincia', ";
				        $sql = $sql."'$usr_cap', '$usr_citta', '$usr_codice_paese', ";
				
				        $sql = $sql."'$usr_domi_indirizzo', '$usr_domi_comune', '$usr_domi_provincia', ";
				        $sql = $sql."'$usr_domi_cap', '$usr_domi_est_localita', '$usr_domi_codice_paese', ";
				
				        $sql = $sql."'$usr_telefono', '$usr_cellulare', '', '$usr_localita', '$usr_domi_localita' )";
				        */
                                        $sql = "INSERT INTO $tbl_aziende_anag ( id_anag, cognome, nome, cfiscale,  piva,  ";
				        $sql .= "resi_via, resi_comune, resi_provincia, resi_cap,  ";
				        $sql .= "resi_telefono, pec, cod_sdi) VALUES ( ";
				        $sql = $sql."$id_utentihs, '$usr_cognome', '$usr_nome', '', '',  ";
				        
				        $sql = $sql."'$usrf_indirizzo', '$usrf_comune', '$usrf_provincia', ";
				        $sql = $sql."'$usrf_cap', ";
				
				       				
				         $sql = $sql."'$usrf_telefono', '$usrf_pec', '$usrf_cdest')";
                                        
				        $mydbG->ExecSql($sql);
                                        
                                        if($_wsnetwork)
                                        {
                                            $sql = "INSERT INTO $tbl_websites (titolo, data_ins, id_anag) VALUES ('$usr_cognome', NOW(), $id_utentihs)";
                                            $mydbNW->ExecSql($sql);
                                            $idext = $mydbNW->LastInsertedId;
                                            
                                            $sql = "UPDATE $tbl_aziende SET id_ws=$idext WHERE id_anag=$id_utentihs";
                                            $mydbG->ExecSql($sql);
                                            
                                                foreach($_vlanguage as $k => $v){
                                                                $sql = "INSERT INTO $tbl_websites_testi (id_rel, lang) VALUES ($idext, '$v')";
                                                                $mydbNW->ExecSql($sql);

                                                }
                                        }
                                        
                                        
                                        }

