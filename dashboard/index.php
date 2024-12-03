<?
session_start();

ini_set('error_reporting', E_ALL & ~E_NOTICE);
ini_set('display_errors',1);

//

extract($_GET);
extract($_POST);

$_main_dir = "./_main/";
//FILE DI CONFIGURAZIONE GENERALE
include_once $_main_dir."_inc/config.php";//FILE DI CONFIGURAZIONE GENERALE
include_once $_main_dir."_inc/global.inc.php";	  //parametri generali del sito
include_once $_main_dir."_inc/parseInputVars.inc.php";

/*
$qs = "";
if( $_SERVER["HTTPS"]!="on" && !isset($_SRV) && !isset($autologin)) {
    foreach($_REQUEST as $k => $v) $qs .= $k."=".$v."&";
    echo header("location: $urlbase?$qs");
	#echo $urlbase;
}
*/


if(!isset($_SRV)) { $_SRV = ""; }
if(!isset($_F2I)) { $_F2I = ""; }

$_t = time();#Date("d");

//

if($_SRV=="" && $_F2I==""){

$request_uri = filter_input(INPUT_SERVER, "REQUEST_URI");
$request_uri = str_replace("/index.php","",$request_uri);
$request_uri = str_replace("//","/",$request_uri);

if(strstr($request_uri,"?")){
$aru = explode("?",$request_uri);
parse_str($aru[1], $res);extract($res);
$request_uri = $aru[0];
}

 if( ($request_uri=="/$_dir" || $request_uri=="/$_dir/") && !isset($sz) && !isset($sezione) ){

 	 $sz = "home";
}
if(isset($sz) && $sz=="") $sz = "home";

}

if (!isset($MSID) || $MSID==""){

	if(isset($_SESSION['myUsrsessionid'])) $MSID = $_SESSION['myUsrsessionid'];

}

//GESTIONE SESSIONI
if(isset($MSID) && $MSID!="" && $MSID!=null && $MSID!="test"  && $MSID!="-1"){
 $mysessionid = $MSID;
 }
else {

	$mysessionid =  time().filter_input(INPUT_SERVER, "USER_AGENT");
	$mysessionid = md5($mysessionid);

}

$MSID = $mysessionid;

if(!isset($sz)) $sz="";
if(isset($sezione) && $sezione!="") #!isset($sz)||($sz=="")
{
	$sz = $sezione;
} else { $sezione = $sz; }


$v = explode(".",$sz);
$sz0 = $v[0];

$a_sz = explode(",",$v[0]);//sz=$vv[0]

// parametri aggiuntivi
if(isset($params)) {
    parse_str($params, $res);extract($res);
}
$params = "";
// parametri aggiuntivi
if(isset($strparam)) {
    parse_str($strparam, $res);extract($res);
}
$strparam = "";

 //CLASSI , GESTORI DELLE CLASSI E FILE DI INCLUSIONE GENERALI
include_once $_main_dir."_inc/dbmanager.php";    //istanze database, include db.class.php - definizione delle classi
include_once $extincpath_hdd."_inc/usermanager.php"; //funzioni per la validazione degli accessi
include_once $extincpath_hdd."_inc/session.php";  //funzioni per la gestione delle sessioni
//////////////////////////////////////////////////////////////////////////////////////////////////////
include_once $extincpath_hdd."_class/login.class.php";
///////////////////////////////////////////////////////////////////////////////////////////////////////

#-------------------------
# Inclusioni File generali
#-------------------------
include $extincpath_hdd."_inc/common.php";		//file di funzioni di utilità comuni
include $extincpath_hdd."_inc/commonws.php";	//file di funzioni di utilità comuni
#-------------------------------
# Inclusioni File di configuraz.
#-------------------------------
include_once( "./".$prefix."/_inc/config.inc.php");
include_once( $prefix."/_inc/function.php");

##############################################################################################

include_once( $extincpath_hdd."_inc/login.php");

if( ($logged && $_level<=$MAXUSERSLEVEL) || !$logged) {

	$_SESSION['myUsrsessionid'] = $MSID;
}
else $_SESSION['myUsrsessionid'] = "";
/*
if ($logged == 1) {
        
        extract($_GET);
        extract($_POST);
}
*/
##############################################################################################
// <LINGUA> ---------------------------------------------------------------------------------------------------------------
 if(isset($language_) && $language_!=""){
 	 	$language=$language_;
 	 }

if(!isset($language) || $language=="" ) $language="it";//_________________________

include $extincpath_hdd."_inc/language.php";
if(file_exists($prefix."/_inc/language.php")) include_once( "./".$prefix."/_inc/language.php");

// </LINGUA> ---------------------------------------------------------------------------------------------------------------
##############################################################################################
#STATISTICHE
##if($logged==1) trace_activity(1);
##elseif ($loggedUser==1) trace_activity(0);
##############################################################################################

if(isset($_SRV) && $_SRV !="") {

	include "./init.php";
	include "./service.php";


} elseif(isset($_F2I) && $_F2I !="") {

	$f="";

	switch($_F2I){
		case "jscode":{
			$f = $baseDir."main/contents/jscode.js.php";
		} break;
	}

	include $f;

} else {


//Inclusione pagine del sito
if(!isset($sezione) || $sezione=="") $sezione = "0";
#if($sessiontimeout) $sezione = "sessiontimeout";

$a = Get_Contents($sezione);
$_ALL_PARAMS['layout'] = $layout  = $a[2];
$content = $a[0];
$_ALL_PARAMS['sz']     = $sz      = $a[3];
$xparams = $a[4];parse_str($xparams,$res);extract($res);
#$a_sezione = $a[5];
if($a[1]!="" && $azione=="") $azione = trim($a[1]);if(!isset($azione)) $azione = "";
$_ALL_PARAMS['azione']     = $azione;

include "./init.php";

if($prefix != "")
{

$conn=$mydb->RefreshConnect();

include "./".$prefix."/_layout/".$layout;
}
else
{
	echo "ERRORE GENERALE.<br>";
}

}

 ##############################################################################################

 // chiusura della connessione al database
 $conn=$mydb->Get_IdConnection();
if($conn)  $conn = $mydb->Disconnect();



?>