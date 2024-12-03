<?
$errmsg = "";

if($azione=="save")
{
     $a_usrparams = find_post("usr_");
     $usrparams = serialize($a_usrparams); 
     
         
    foreach ($a_usrparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	$a_usrparams[$k] = myencodeTxt($v);
    	
    }
    extract($a_usrparams);
    
     $a_usrfparams = find_post("usrf_");
     $usrfparams = serialize($a_usrfparams); 
     
      
    foreach ($a_usrfparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	$a_usrfparams[$k] = myencodeTxt($v);
    	
    
    }
    extract($a_usrfparams);

    $sql = "SELECT COUNT(*) FROM $tbl_utenti WHERE username='$usr_username' AND cancellato='0'";
    $mydb->DoSelect($sql);
    $rtmp=$mydb->GetRow();
    if($rtmp[0]>0)
    {
        $errmsg = "Lo username scelto &egrave; gi&agrave; utilizzato";

    } else {
    
        $sql = "INSERT INTO $tbl_utenti (nome, cognome, username, password, email, level, data_ins, tipo, tipo_reg, stato ) VALUES (";
        $sql .= "'$usr_nome', '$usr_cognome', '$usr_username', '$usr_password', '$usr_email', '$usr_level', NOW(), '1', '0', '1') ";
                
        $mydb->ExecSql($sql);
        //echo $sql;
        $idu = $mydb->LastInsertedId;
        
    if($idu>1 ){
                
            
                                            $errmsg = "L'Utente &egrave; stato inserito!";
            }				
    }
 
}


if($errmsg!=""){
?>
<div class="bordered" style="margin-top:20px;max-width:<?=$maxw?>;padding:6px">
    <span class="testo_err"><?=$errmsg?></span>
</div>
<? } ?>
    <form id="frmins" name="frmins" action="<? echo $action; ?>" method="post">
        
       
            

        <div class="box bordered" style="text-align:left">

<?
#echo "Dati personali \n";
?>

                                <table cellspacing="0" cellpadding="4" border="0" class="tablerespnob">
                                    <tr>
                                        <td class="testob tdlabel">Username*:</td><td><input type="text" name="usr_username" value="" title="Username"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob tdlabel">Email*:</td><td><input type="text" name="usr_email" value="" title="Email"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob tdlabel">Password*:</td><td><input type="password" name="usr_password" value="" title="Password" /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob tdlabel">Ripeti Password*:</td><td><input type="password" name="usr_password2" value=""  /></td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="testob tdlabel">Nome*:</td><td><input type="text" name="usr_nome" value="" title="Nome" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob tdlabel">Cognome*:</td><td><input type="text" name="usr_cognome" value="" title="Cognome" /></td>
                                    </tr>

 <? /*                                   
                                    <tr>
                                        <td class="testob">Citt&agrave;:</td><td><input type="text" name="usr_citta" value=""  /></td>
                                    </tr>                                    
                                       <tr>
                                        <td class="testob">Cap:</td><td><input type="text" name="usr_cap" value="" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Provincia:</td><td><input type="text" name="usr_prov" value=""  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Indirizzo:</td><td><input type="text" name="usr_indirizzo" value=""  /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">Telefono:</td><td><input type="text" name="usr_telefono" value=""  /></td>
                                    </tr>  
                                   
*/ ?>
                                                                        
                                    <tr>
                                        <td class="testob">Profilo*:</td>
                                        <td>
                                            <select name="usr_level">
                                                <? foreach($A_USERSDES as $k => $v)
                                                {
                                                    if($k<=$MAXOPERLEVEL){
                                                    ?>
                                                <option value="<?=$k?>"  ><?=$v?></option>
                                                <?
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                </table>
                                        

    </div>

<? /*       
        <div class="box bordered" style="text-align:left">

        Dati di fatturazione
        
                   
                             <table cellspacing="0" cellpadding="4" border="0" class="tblForm">
                                    <tr>
                                        <td class="testob">Ragione Sociale Azienda:</td><td><input type="text" name="usrf_rs" value=""   /></td>
                                    </tr>
                                            
                                    <tr>
                                        <td class="testob">Citt&agrave; Azienda:</td><td><input type="text" name="usrf_citta" value="" /></td>
                                    </tr>
                                       <tr>
                                        <td class="testob">Cap Azienda:</td><td><input type="text" name="usrf_cap" value="" /></td>

                                    <tr>
                                        <td class="testob">Indirizzo Azienda:</td><td><input type="text" name="usrf_indirizzo" value="" /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">Telefono Azienda:</td><td><input type="text" name="usrf_telefono" value=""  /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">PARTITA IVA:</td><td><input type="text" name="usrf_piva" value=""  /></td>
                                    </tr>  
                                    
                                    <tr>
                                        <td class="testob">Codice Destinatario<br/><span class="testosm">(Fatturazione Elettronica)</span>:</td>
                                    <td><input type="text" name="usrf_cdest" value=""  /></td>
                                    </tr>  
                                    
                                    <tr>
                                    <td class="testob">PEC Azienda:</td>
                                    <td><input type="text" name="usrf_pec" value=""  /></td>
                                    </tr> 
                                    
                                    

                                </table>
                                            

            

    </div>
        
 */ ?>       
    <div class="clearboth"></div>
        
    <div class="box bordered">
          
        <table cellspacing="0" cellpadding="4" border="0">
          

           <tr>
            <td colspan="2" align="center">
                    <div id="login_entra" class="button1" onclick="checkdata()"><div>Salva</div></div>
            </td>
      
           </tr>  
        </table>
    </div>  
        
            <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="">
           <input type="hidden" name="sezione"  value="impostazioni,1">
            <input type="hidden" name="tab"  value="0">
            <input type="hidden" name="azione"  value="">
            
        </form>

<script type="text/javascript" charset="utf-8">

function checkdata(){
	
	res = convalidaForm3(document.frmins,'<?=$language?>','evi');
        
        if(document.frmins.usr_password.value!=document.frmins.usr_password2.value)
        {
            myAlert('Attenzione: le password inserite non coincidono.');
            res = 0;
        }

	if(res)
        {

        document.frmins.azione.value='save';

        document.frmins.submit();
	
	}
}

</script>