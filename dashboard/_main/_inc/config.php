<?
$SITE = "0";
/*
$a_dbparam_0 = array(
    'dbaddress'  => "localhost",
    'dbusername' => "bikeh",
    'dbpassword' => "BikeH166##",
    'dbname'     => "www_bikeh",
);
$a_dbparam_3 = array(
    'dbaddress'  => "localhost",
    'dbusername' => "bikeh",
    'dbpassword' => "BikeH166##",
    'dbname'     => "generale",
    );

//gestionale
$a_dbparam_2 = array(
    'dbaddress'  => "localhost",
    'dbusername' => "bikeh",
    'dbpassword' => "BikeH166##",
    'dbname'     => "bikeh_main",
	);
*/
$a_dbparam_0 = array(
    'dbaddress'  => "127.0.0.1",
    'dbusername' => "root",
    'dbpassword' => "cinghiale02",
    'dbname'     => "www_bikeh",
);
$a_dbparam_3 = array(
    'dbaddress'  => "127.0.0.1",
    'dbusername' => "root",
    'dbpassword' => "cinghiale02",
    'dbname'     => "generale",
    );

//gestionale
$a_dbparam_2 = array(
    'dbaddress'  => "127.0.0.1",
    'dbusername' => "root",
    'dbpassword' => "cinghiale02",
    'dbname'     => "bikeh_main",
	);
	


$a_dbparam = array(
    '0'      => $a_dbparam_0
);

//<SITI>
$a_sites = array(
      0 => "0"
	  );

//</SITI>
//<PATH>
$a_pathsites = array(
    '0'=> "main",
     
	);
	
$SITE = strtolower($SITE);
#if(!in_array($SITE,$a_sites))  $SITE = $_DEFAULTSITE;
$prefix = $a_pathsites[$SITE];$prefix = strtolower($prefix);
if(empty($prefix)) die;


global $baseUrl;


// automatically define the base url
$baseUrl = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
$baseUrl .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
$pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : getenv('PATH_INFO');
if (@$pathInfo) {
  $pathHdd = str_replace('\\','/',dirname($pathInfo));
} else {
  $pathHdd = str_replace('\\','/', dirname( isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : getenv('SCRIPT_NAME')));
}
$baseUrl .= $pathHdd;
$urlbase = str_replace("http://","https://",$baseUrl."/");
$_dir = "bikehospitality/dashboard";

global $baseDir;
$baseDir = $_SERVER["DOCUMENT_ROOT"]."/$_dir/";

$_include_path = ".;".$baseDir;
ini_set('include_path',$_include_path);

$_addslashes     = "1";
 
$url_gestionale = "";

$nome_circuito = "";
$_id_circuito = 7;

$_duratamaxSessions = 24*30;//durata massima in ore delle variabili di sessione, default = 24

$extincpath_hdd  = $_SERVER["DOCUMENT_ROOT"]."/_wsmain.1.9/";
//$extincpath_http = "https://www2.wifi-project.cloud/_wsmain.1.9/";
//$urlcrm          = "https://www2.wifi-project.cloud/bikehospitality/";
$extincpath_http = "https://localhost:8000/_wsmain.1.9/";
$urlcrm          = "http://localhost:8000";

$_statorichiesto = 1;//stato richiesto all'utente per fare il login
$seztoFailed = "home";

include "wsconfig.inc.php";
?>