<?

#include "home.php";

if(1){
    
$msg = "";
$errmsg = "";

$recpasswfailed = 0;
$height = 0;
#if($md=="recuperopassword") $height = 300;

if(isset($ricordapsw) && $ricordapsw=='1'){
    
    $recuperopassword = "1";
	
	          $sql = "SELECT COUNT(*) as n FROM t_utenti WHERE email = '$emailreg' ";#AND level <= $MAXUSERSLEVEL
	          $mydb->DoSelect($sql);
	          $r = $mydb->GetRow();
	          
	          $n = $r['n'];
	          
	          if($n==0){
	          
	          	$recpasswfailed = 1;
		 	 	
		 	$errmsg = $lang['errore_email_non_trovata'];//L'indirizzo email inserito non è presente nei nostri archivi.
	          	
	          	
	          } else {
                     
                      $res = inviaEmailRecuperoPsw($emailreg);
                      
                      /*
	          	
	          	      $newpassword = generate_password(8);
	          	      
	          	      $md5pas = md5($newpassword);
	          	      
	          	      $sql = "SELECT idutente FROM t_utenti WHERE email = '$emailreg' AND level <= $MAXUSERSLEVEL";
			          $mydb->DoSelect($sql);
			          $r = $mydb->GetRow();
			          
			          $id = $r['idutente'];
			          
			          $sql = "UPDATE t_utenti SET password = '$md5pas' WHERE idutente = $id";
			          $mydb->ExecSql($sql);
	          	      
	          	      
	
			          $Subject = $lang['soggetto_email_recupero_passw'];
					  
					  $a_emailto = array();
					  array_push($a_emailto, $emailreg);
					  
					  $Body = Get_TXTArea("email_recuperopassword",$language);
					  $Body = str_replace("|password|", $newpassword, $Body);
					   
					  
				 	 include ("./mail/mailmanager.php");
				 	 
				 	 add_log(Date("Y-m-d H:i")." Invio email recupero password a $emailreg [$mailresult]" );
				 	 
				 	 if($mailresult != 1){
				 	 	
				 	 	$recpasswfailed = 1;
				 	 	
				 	 	$msg = $lang['errore2'];//"Si &egrave; verificato un errore!";
				 	 	
				 	 } else {
				 	 	
				 	 	$msg = $lang['messaggioEmail']." ".$emailreg;//"Ti &egrave; stata inviata la nuova password all'indirizzo email ";
				 	 	
				 	 }
                       * 
                       */
	          }
	        
	 $msg = $lang['messaggioEmail'];# Get_TXTArea('messaggioEmail',$language); 
   
	
}


$class1 = "";if($loginfailed=='1') $class1 = "input_evi";

?>

<script type="text/javascript">

 function espandi_rp(){
 	
 	enablescroll_ricorda_passw = 1;
 	
 	hidelayer('lnkrecpassw');
 	
 	expand_div_v('ricorda_passw', 300, 3, 10);
 	
 }
 
 function sendReqPsw(){
 	
 	if(document.frmpassw.emailreg.value!='') document.frmpassw.submit();
 	
 }

</script>

<?

if($msg!=""){
?>
<p class="titolo"><?=$msg?></p>
<hr/>
<br/><br/>
<?  } ?>

<div style="width:100%" align="center">
<p>&nbsp;</p>

    <form id="frmlogin" name="frmlogin" action="<? echo $action; ?>" method="post">
        
            <span class="titolo_big"><?=$lang['area_riservata']?> </span>
	
		     		<div class="testo <?=$class1?>">Username</div>
		     		<input type="text" name="username" value="<?=$username?>" class="" /><br/>
		    		<div class="testo <?=$class1?>">Password</div>
		    		<input type="password" name="password" value=""  class="" /><br/><br/>
                                
                                <div id="login_entra" class="button1" onclick="Login()"><div><?=$lang['entra']?></div></div>
                                    
		      		<div id="msg2" class="testo_err"><? if($loginfailed=='1') echo "Username e/o Password <b>NON</b> esatti";?></div>
		     		<input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
		    		<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
	        		<input type="hidden" name="params" value="">
	        		<input type="hidden" name="login"  value="1">
	        		
    </form>
	 		
	 		<p>&nbsp;</p>

	 <a href="javascript:void(0);" onclick="espandi_rp()" id="lnkrecpassw"><?=$lang['psw_dimenticata']?></a>
	 
	 		<p>&nbsp;</p>
	 		<div id="ricorda_passw" style="height:<?=$height?>px;">
                            
	 		<form id="frmpassw" name="frmpassw" action="<? echo $action; ?>" method="post">
					
	 		        <p class="titolo"><?=$lang['messaggioRecPsw']?>:<a name="recuperopassw"></a></p>
	 		        <p class="testo"><?=$lang['messaggioLogin1']?></p>
                                
                                <input type="text" name="emailreg" value="" placeholder="email.." /><br/><br/>
                                <div class="lnk" onclick="sendReqPsw()"><?= ucfirst($lang['invia'])?></div>
		      		<p id="msg2" class="testo_err"><? if($recpasswfailed=='1') echo $errmsg;?></p>
		     		<input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
		    		<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
	        		<input type="hidden" name="ricordapsw"  value="1">
	        		<input type="hidden" name="sz"  value="login">
		      </form>
		      
		      <span class="testo"><?=$lang['messaggioLogin2']?></span> 
	 		</div>

	 		<p>&nbsp;</p>
	 		<p>&nbsp;</p>
	 		
<?
if(isset($recuperopassword)){
?>
  <script>
      espandi_rp();
  </script>
<? } ?>
</div>

<? } ?>