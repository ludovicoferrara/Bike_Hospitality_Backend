<?  
global $_id_smtppserver;

use PHPMailer\PHPMailer\PHPMailer;

include_once 'PHPMailer.php';
include_once 'SMTP.php';
include_once 'Exception.php';

if(isset($_id_smtppserver) && $_id_smtppserver>0 )
$sql = "SELECT * FROM account_smtp WHERE id_casella=$_id_smtppserver";
else $sql = "SELECT * FROM account_smtp WHERE _default='1'";

$mydbG->DoSelect($sql);
$rsmtp = $mydbG->GetRow();
    
$From        = $rsmtp['mittente'];
$FromName    = $rsmtp['nome'];
if(!isset($Replyto) || $Replyto=="") $Replyto     = $rsmtp['Replyto'];

$server = explode(":", $rsmtp['server']);
$tipo = explode(":", strtolower($rsmtp['tipo']));

$mail = new PHPMailer();

$mail->CharSet = "utf-8";

if($rsmtp['enable']=='1'){

$mail->IsSMTP();  //uso di stmp
$mail->Host = $server[0];#"//server smtp principale localhost
$mail->SMTPAuth = true;  //voglio  usare l'autenticazione
if($tipo[2]!="") $mail->SMTPSecure = $tipo[2];#"tls"; 
$mail->Port = $server[1];#587;

}

$mail->CharSet = "utf-8";

$mail->IsHTML(true);

 $mail->SMTPOptions = array (
        'ssl' => array(
        'verify_peer'  => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true));

// SMTP username and password
$mail->Username = $rsmtp['user'];
$mail->Password = $rsmtp['password'];

$mail->From = $From;  //mittente - uguale a quello di login
$mail->FromName = $FromName;  //nome mittente
$mail->AddReplyTo($Replyto);#, $From

foreach ($a_emailto as $k => $v){
$mail->AddAddress($v);  //destinatari della mail
}

if(isset($a_emailCC))
foreach ($a_emailCC as $k => $v){
$mail->AddCC($v);  //destinatari della mail
}

if(isset($a_emailCCn))
foreach ($a_emailCCn as $k => $v){
$mail->AddBCC($v);  //destinatari della mail
}

if(isset($a_attach))
foreach ($a_attach as $k => $v){
$mail->AddAttachment($v);
}

if(!isset($_firma)) {
	$_firma = Get_TXTArea('firma_email',$language);
	if(!stristr($_firma, "http")) $_firma = str_replace("src=\"","src=\"".$urlbase."/", $_firma);
}

if(isset($confermaLettura) && $confermaLettura=='1') $mail->ConfirmReadingTo = $Replyto;
if(isset($priority) && $priority!=3) $mail->Priority = $priority;

$mail->Subject = $Subject;
$mail->Body    = $Body.$_firma;

$mailerror = "";

$mailresult=$result = $mail->Send();   //invio della mail
$mailerror = $mail->ErrorInfo;

if($result) $res = '1'; else $res = '0';

//echo $mail->ErrorInfo; 

$mail->SmtpClose();
unset($mail);


?>