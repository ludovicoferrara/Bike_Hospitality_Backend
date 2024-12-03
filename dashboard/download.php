<?$f = "";
$keyd="";
$keyf="";
$ukey="";

if(isset($_GET['f']))    $f   = $_GET['f'];
if(isset($_GET['keyd'])) $keyd = $_GET['keyd'];
if(isset($_GET['fkey'])) $keyf = $_GET['fkey'];
if(isset($_GET['ukey'])) $ukey = $_GET['ukey'];

$language = "it";
 if(!isset($_incpath)) $_incpath = "./";
 $_main_dir = "./_main/";  include_once $_main_dir."_inc/config.php";//FILE DI CONFIGURAZIONE GENERALE
 //CLASSI , GESTORI DELLE CLASSI E FILE DI INCLUSIONE GENERALI
include_once $_main_dir."_inc/dbmanager.php";   //istanze database, include db.class.php - definizione delle classi
#-------------------------# Inclusioni File generali#-------------------------include_once $_incpath."main/_inc/config.inc.php";	    //parametri generali del sito  include_once $_incpath."main/_inc/function.php";include_once $extincpath_hdd."_inc/common.php";		//file di funzioni di utilit? comuni
require_once($extincpath_hdd."_class/class.chip_download.php");

$scarica = false;
if($keyd!="")
{$sql = "SELECT * FROM documenti WHERE MD5(id) = '$keyd'";
$mydb->DoSelect($sql);if($rf=$mydb->GetRow()){    $nome_file = $rf['file'];    $path = $rf['path'];    $scarica = true;        $id = $rf['id'];        $sql = "UPDATE documenti SET data_last_download=NOW(), numero_download = numero_download + 1 WHERE id=$id";    $mydb->ExecSql($sql);        $path = $baseDir.$path;    $path = rtrim($path,"/")."/";
$args = array(		'download_path'		=>	$path,		'file'			=>	$nome_file,				'extension_check'	=>	TRUE,		'referrer_check'	=>	FALSE,		'referrer'		=>	NULL,		);
}} elseif($f!=""){        $nome_file=$f;        $path = "download";
        if(isset($_GET['path']))
    {
        $path = rtrim($_GET['path'],"/");
        $path = $baseDir.$path."/";
    }
    if(isset($ukey))
    {
        $sql = "SELECT idutente FROM t_utenti WHERE MD5(idutente) = '$ukey'";
        $mydb->DoSelect($sql);
        if(($ru=$mydb->GetRow()))
        {
            $idu = $ru['idutente'];
            $path = $baseDir."userdata/$idu/";
            
        } else die;
    }

    $args = array(                    'download_path'		=>	$path,                    'file'			=>	$nome_file,		                    'extension_check'	=>	TRUE,                    'referrer_check'	=>	FALSE,                    'referrer'		=>	NULL,                    );    $scarica=true;
    
} elseif($keyf!="")
{
$sql = "SELECT * FROM t_files WHERE MD5(id_files) = '$keyf'";
$mydb->DoSelect($sql);
if($rf=$mydb->GetRow())
{
    $nome_file = $rf['nome'];
    $fullpath = $rf['path'];
    $scarica = true;
    
    $id = $rf['id_files'];
    
    
   # $sql = "UPDATE t_files SET last_download=NOW() WHERE id_files=$id";
   # $mydb->ExecSql($sql);
    
    if($ukey!="" && $rf['id_utente']==0)
    {
        $sql = "SELECT idutente FROM t_utenti WHERE MD5(idutente)='$ukey'";
        $mydb->DoSelect($sql);
       if( ($ru=$mydb->GetRow()) )
       {
           $idu = $ru['idutente'];
           $sql = "INSERT IGNORE INTO t_files (nome, path, id_utente, id_frel) VALUES ('$nome_file', '$fullpath', $idu, $id) ";
           $mydb->ExecSql($sql);
           $id = $mydb->LastInsertedId;
       }
    }
    
    if(isset($idu) && $idu>0)
    {
        $sql = "UPDATE t_files SET last_download=NOW() WHERE id_utente=$idu AND path='$fullpath' AND nome='$nome_file' ";
        $mydb->ExecSql($sql);
    }
    
    $path = str_replace($nome_file, "", $fullpath);
    $path = rtrim($path,"/")."/";


$args = array(
		'download_path'		=>	$path,
		'file'			=>	$nome_file,		
		'extension_check'	=>	TRUE,
		'referrer_check'	=>	FALSE,
		'referrer'		=>	NULL,
		);

}}
//var_dump($args);if(is_file($path.$nome_file) && $scarica){     $download = new chip_download( $args );      $download_hook = $download->get_download_hook();        if( $download_hook['download'] == TRUE ) { 	/* You can write your logic before proceeding to download */		/* Let's download file */	$download->get_download();
} /*   $dimensione_file = filesize($path.$nome_file);    	$log = Date("Y-m-d H:i")." ".$path.$nome_file." ($dimensione_file) ".$_SERVER['REMOTE_ADDR']." \r\n";	$flog = fopen($baseDir."_log/download.log", "a");fputs($flog, $log);fclose($flog);
header("Content-Type: application/pdf; name=".$nome_file);header("Content-Transfer-Encoding: binary");header("Content-Length: ".$dimensione_file);header("Content-Disposition: inline; filename=".$nome_file);header("Expires: 0");header("Cache-Control: no-cache, must-revalidate");header("Cache-Control: private");header("Pragma: public");
readfile($path.$nome_file);  * */} else {	echo "ERROR";	die;}
?>