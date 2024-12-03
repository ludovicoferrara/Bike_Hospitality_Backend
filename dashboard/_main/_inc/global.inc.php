<?	  
//-------------- GLOBAL.INC.PHP ------------------
// 
//--------------------------------------------

	  
 //------------ Permessi -------------------------------------------------------------
	 //___________________________TOGLIERE : OGNI SITO HA I SUOI --->> PASSARE SU DB
	  $A_USERSLEVEL= array(
	  0     => '127',
	  1     => '64',
	  2     => '32',
	  3     => '16',
	  4     => '8',
	  5     => '4',
	  6     => '2',
	  7     => '1'
	  );

$SADMINLEVEL = 127;	  
$ADMINLEVEL  = 64;
$OPERLEVEL   = 8;
$MAXOPERLEVEL   = 32;

$MAXUSERSLEVEL = 4;
$GESTLEVEL = 4;
$SUPLEVEL  = 2;


       $A_USERSDES = array(
	  '127' => 'S.Amministratore',
	  '64'  => 'Amministratore',//CMS
	  '32'  => 'Amministratore',
	  '16'  => 'Operatore (1)',
	  '8'   => 'Operatore',
	  '4'   => 'Gestore',//Gestore Dashboard
	  '2'   => 'Utente',
	  '1'   => 'Utente'
	  );
	  
	  $A_USERSSTARTPAGE = array(
	  '127' => 0,
	  '64'  => 'dashboard',
	  '32'  => 'dashboard',
	  '16'  => 'dashboard',
	  '8'   => 'dashboard',
	  '4'   => 'dashboard',
	  '2'   => 'dashboard',
	  '1'   => 'dashboard'
	  );
$i=0;
$A_INPUTVARS = array();
$A_INPUTVARS[$i++] = "MSID";
$A_INPUTVARS[$i++] = "_F2I";
$A_INPUTVARS[$i++] = "_SRV";
$A_INPUTVARS[$i++] = "sz";
$A_INPUTVARS[$i++] = "sezione";
$A_INPUTVARS[$i++] = "azione";
$A_INPUTVARS[$i++] = "params";
$A_INPUTVARS[$i++] = "login";
$A_INPUTVARS[$i++] = "logout";
$A_INPUTVARS[$i++] = "username";
$A_INPUTVARS[$i++] = "password";
$A_INPUTVARS[$i++] = "tab";
$A_INPUTVARS[$i++] = "tab2";
$A_INPUTVARS[$i++] = "strparam";

if(1)#$sz == "registrati"
{
$A_INPUTVARS[$i++] = "usr_nome";
$A_INPUTVARS[$i++] = "usr_cognome";
$A_INPUTVARS[$i++] = "usr_email";
$A_INPUTVARS[$i++] = "password2";
$A_INPUTVARS[$i++] = "usr_cfiscale";
$A_INPUTVARS[$i++] = "usrf_cfiscale";
$A_INPUTVARS[$i++] = "usr_cf";
$A_INPUTVARS[$i++] = "usr_citta";
$A_INPUTVARS[$i++] = "usr_cap";
$A_INPUTVARS[$i++] = "usr_prov";
$A_INPUTVARS[$i++] = "usr_indirizzo";
$A_INPUTVARS[$i++] = "usr_telefono";
$A_INPUTVARS[$i++] = "usr_note";
$A_INPUTVARS[$i++] = "usr_note1";
$A_INPUTVARS[$i++] = "usr_note2";
$A_INPUTVARS[$i++] = "usr_note3";
$A_INPUTVARS[$i++] = "usr_localita";
$A_INPUTVARS[$i++] = "usr_msg1";
$A_INPUTVARS[$i++] = "usr_msg2";
$A_INPUTVARS[$i++] = "usr_msg3";
$A_INPUTVARS[$i++] = "usrf_rs";
$A_INPUTVARS[$i++] = "usrf_cap"; 
$A_INPUTVARS[$i++] = "usrf_indirizzo"; 
$A_INPUTVARS[$i++] = "usrf_provincia"; 
$A_INPUTVARS[$i++] = "usrf_telefono"; 
$A_INPUTVARS[$i++] = "usrf_piva"; 
$A_INPUTVARS[$i++] = "usrf_cdest"; 
$A_INPUTVARS[$i++] = "usrf_pec"; 
$A_INPUTVARS[$i++] = "usrf_citta";
$A_INPUTVARS[$i++] = "chk_condizioni";
$A_INPUTVARS[$i++] = "chk_condizioni2";
$A_INPUTVARS[$i++] = "ricordapsw";
$A_INPUTVARS[$i++] = "emailreg";
}
?>