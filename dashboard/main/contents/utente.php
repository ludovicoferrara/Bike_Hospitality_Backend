<?
if($azione=="save")
{
 include "saveusrdata.inc.php";
 
} elseif($azione=="susp") {
    
    $sql = "UPDATE t_utenti SET stato='0' WHERE idutente=$id";
    $mydb->ExecSql($sql);
    
} elseif($azione=="attiva") {
    
    $sql = "UPDATE t_utenti SET stato='1' WHERE idutente=$id";
    $mydb->ExecSql($sql);
    
}

$_idutente = $id;

$sql = "SELECT * FROM t_utenti WHERE idutente=$_idutente";
$mydb->DoSelect($sql);
$ru = $mydb->GetRow();

$usr_email    = $ru['email'];
$usr_username = $ru['username'];
$usr_nome     = $ru['nome'];
$usr_cognome  = $ru['cognome'];
$usr_citta    = $ru['citta'];
$usr_indirizzo= $ru['indirizzo'];
$usr_cap      = $ru['cap'];
$usr_prov     = $ru['prov'];
$usr_telefono = $ru['tel1'];
$usr_level    = $ru['level'];

$stato = $ru['stato'];
if($stato=='1') $strstato = "<span class=\"green\" >Attivo</span>"; else $strstato = "<span class=\"orange\">Non Attivo</span>";
/*
$sql = "SELECT ta.* FROM aziende as tu, aziende_anag as ta WHERE tu.id_utente_portale=$_idutente AND tu.id_utentihs=ta.id_utenti_anag";
$mydbG->DoSelect($sql);
$ru2 = $mydbG->GetRow();

$usrf_piva     = $ru2['piva'];
$usrf_rs       = $ru2['cognome'];
$usrf_citta    = $ru2['resi_comune_txt'];
$usrf_indirizzo= $ru2['resi_via'];
$usrf_cap      = $ru2['resi_cap'];
$usrf_prov     = $ru2['resi_provincia_txt'];
$usrf_telefono = $ru2['tel'];
$usrf_pec      = $ru2['pec'];
$usrf_cdest    = $ru2['codice_dest'];
*/


if($errmsg!=""){
?>
<div class="bordered" style="margin-top:20px;max-width:<?=$maxw?>;padding:6px">
    <span class="testo_err"><?=$errmsg?></span>
</div>
<? } ?>
<div class="rbutton2" onclick="back()"><div>Indietro</div></div>
 <div class="spessore"></div>
 
    <form id="frmins" name="frmins" action="<? echo $action; ?>" method="post">
        
         <div class="box boxw bordered" style="text-align:left">
             Stato Account: <?=$strstato?>
             
             <? if($stato=='1'){ ?>
             <div class="button2" onclick="sospendi()"><div>Sospendi</div></div>
             <? }elseif($stato!='1'){ ?>
              <div class="button2" onclick="attiva()"><div>Attiva</div></div>
             <? } ?>
         </div>
        
        <div class="spessore"></div>
        
        <div class="box boxw bordered" style="text-align:left">

<?
echo "Dati utente \n";
?>

                                <table cellspacing="0" cellpadding="4" border="0" class="tablerespnob">
                                    <tr>
                                        <td class="testob tdlabel">Username*:</td><td><input type="text" name="usr_username" value="<?=$usr_username?>" title="Username" <? echo "disabled" ?>  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob tdlabel">Email:</td><td><input type="text" name="usr_email" value="<?=$usr_email?>" title="Email" /></td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="testob tdlabel">Nome*:</td><td><input type="text" name="usr_nome" value="<?=stripslashes($usr_nome)?>" title="Nome" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob tdlabel">Cognome*:</td><td><input type="text" name="usr_cognome" value="<?=stripslashes($usr_cognome)?>" title="Cognome" /></td>
                                    </tr>
<? /*                                   
                                    <tr>
                                        <td class="testob">Citt&agrave;*:</td><td><input type="text" name="usr_citta" value="<?=stripslashes($usr_citta)?>" title="Citta" /></td>
                                    </tr>                                    
                                       <tr>
                                        <td class="testob">Cap*:</td><td><input type="text" name="usr_cap" value="<?=$usr_cap?>" title="Cap" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Provincia*:</td><td><input type="text" name="usr_prov" value="<?=stripslashes($usr_prov)?>" title="Provincia" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Indirizzo*:</td><td><input type="text" name="usr_indirizzo" value="<?=stripslashes($usr_indirizzo)?>" title="Indirizzo" /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">Telefono:</td><td><input type="text" name="usr_telefono" value="<?=$usr_telefono?>"  /></td>
                                    </tr>  
*/ ?>                                   
                                    <tr>
                                        <td class="testob tdlabel">Profilo*:</td>
                                        <td>
                                            <select name="usr_level">
                                                <? foreach($A_USERSDES as $k => $v)
                                                {
                                                    if($k<=$MAXOPERLEVEL){
                                                    ?>
                                                <option value="<?=$k?>" <? if($usr_level==$k) echo "selected" ?> ><?=$v?></option>
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
        <div class="box boxw bordered" style="text-align:left">

        Dati di fatturazione
        
                   
                             <table cellspacing="0" cellpadding="4" border="0" class="tblForm">
                                    <tr>
                                        <td class="testob">Ragione Sociale Azienda:</td><td><input type="text" name="usrf_rs" value="<?=stripslashes($usrf_rs)?>"   /></td>
                                    </tr>
                                            
                                    <tr>
                                        <td class="testob">Citt&agrave; Azienda:</td><td><input type="text" name="usrf_citta" value="<?=stripslashes($usrf_citta)?>" /></td>
                                    </tr>
                                       <tr>
                                        <td class="testob">Cap Azienda:</td><td><input type="text" name="usrf_cap" value="<?=$usrf_cap?>" /></td>

                                    <tr>
                                        <td class="testob">Indirizzo Azienda:</td><td><input type="text" name="usrf_indirizzo" value="<?=stripslashes($usrf_indirizzo)?>" /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">Telefono Azienda:</td><td><input type="text" name="usrf_telefono" value="<?=$usrf_telefono?>"  /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">PARTITA IVA:</td><td><input type="text" name="usrf_piva" value="<?=$usrf_piva?>"  /></td>
                                    </tr>  
                                    
                                    <tr>
                                        <td class="testob">Codice Destinatario<br/><span class="testosm">(Fatturazione Elettronica)</span>:</td>
                                    <td><input type="text" name="usrf_cdest" value="<?=$usrf_cdest?>"  /></td>
                                    </tr>  
                                    
                                    <tr>
                                    <td class="testob">PEC Azienda:</td>
                                    <td><input type="text" name="usrf_pec" value="<?=$usrf_pec?>"  /></td>
                                    </tr> 
                                    
                                    

                                </table>
                                            

            

    </div>
*/ ?>        
        
    <div class="clearboth"></div>
        
    <div class="box boxw bordered">
          
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
            <input type="hidden" name="id"  value="<? echo $id ?>">
            <input type="hidden" name="sezione"  value="<?=$sezione?>,2">
            <input type="hidden" name="azione"  value="">
            
        </form>

<script type="text/javascript" charset="utf-8">

function checkdata(){
	
	res = convalidaForm3(document.frmins,'<?=$language?>','evi');

	if(res)
        {

        document.frmins.azione.value='save';

        document.frmins.submit();
	
	}
}
    
function sospendi()
{
        document.frmins.azione.value='susp';

        document.frmins.submit();
}

function attiva()
{
        document.frmins.azione.value='attiva';

        document.frmins.submit();
}


</script>