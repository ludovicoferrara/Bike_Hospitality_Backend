<?

function inviaEmailRecuperoPsw($email){
	
	global $mydb, $lang, $language,  $urlbase, $mydbG, $tbl_utenti;
	
	extract($mydb->vtables);
	
	 $sql = "SELECT * FROM $tbl_utenti WHERE email = '$email'";
		$mydb->DoSelect($sql);
		$r = $mydb->GetRow();
                
          $res = 0;
          
          if(!isset($r['email']) || $r['email']!=$email)
          {
              $res = -9;
              
          } else {


                     $Subject = $lang['soggetto_email_recupero_passw'];
              
                     $urlbase = trim($urlbase,"\/");
        
			  
			  $a_emailto = array();
			  $a_emailtoBCC = array();
			  
			  array_push($a_emailto, $r['email']);
			  
			  $key = md5($email.time());
			  
			  $Body =  Get_TXTArea('email_recuperopassword',$language);
                          
			  $Body = str_replace("|link_recupero_password|","<a href=\"$urlbase/$language/recuperopassword/?key=$key\">imposta nuova password</a>", $Body);

			  
			 # echo $Body;
		 	 include ("./mail/mailmanager.php");
		 	 
		 	 if($result) $res = 1; else $res = -1;
		 	 
		 	  $sql = "UPDATE $tbl_utenti SET data_ukey = NOW(), ukey='$key' WHERE email = '$email'";
		 	 $mydb->ExecSql($sql);
          }
}

	//generazione password casuale
	function generate_password($password_length = 10)
	{
            $mypass = "";
		// Creo un ciclo for che si ripete per il valore di $password_length
		for ($x=1; $x <= $password_length; $x++)
		{
			if ($x % 2) //Se $x ? multiplo di 2...
			{
				// Aggiungo una lettera casuale usando chr() in combinazione
				// con rand() che genera un valore numerico compreso tra 97
				// e 122, numeri che corrispondono alle lettere dell'alfabeto
				// nella tabella dei caratteri ASCII
				$mypass .= chr(rand(97,122));

			
			}
			else //Se $x non ? multiplo di 2...
			{
				// Aggiungo alla password un numero compreso tra 0 e 9
				$mypass .= rand(0,9);
			}
		}

		return $mypass;
	}
	function inviaPassword($idu){
	
		global $mydb, $lang, $language,  $urlbase, $mydbG, $tbl_utenti, $_emailwm;
		
		extract($mydb->vtables);
		
		    $sql = "SELECT * FROM $tbl_utenti WHERE id_utenti = '$idu'";
			$mydb->DoSelect($sql);
			$r = $mydb->GetRow();
					
			  $res = 0;
			  
			  $email = $r['email'];
			  $password = $r['password'];
			  $user = $r['username'];
			  
			  if(!isset($r['email']) || $r['email']!=$email)
			  {
				  $res = -9;
				  
			  } else {
	
	
						 $Subject = $lang['soggetto_email_password'];
				  
						 $urlbase = trim($urlbase,"\/");
			
				  
				  $a_emailto = array();
				  $a_emailtoBCC = array();
				  
				  array_push($a_emailto, $r['email']);
				  
				  $key = md5($email);
				  
				  $Body =  Get_TXTArea('email_inviopassword',$language);
							  
				  $Body = str_replace("|email|",$email, $Body);
							  $Body = str_replace("|password|",$password, $Body);
							  $Body = str_replace("|username|",$user, $Body);
	
				  
				 # echo $Body;
				  include ("./mail/mailmanager.php");
				  
				  if($result) $res = 1; else $res = -1;
				  
				 
			  }
			  
			  return $res;
	}


