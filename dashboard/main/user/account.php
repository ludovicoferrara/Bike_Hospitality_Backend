<?
if(!isset($errmsg)) $errmsg = "";

$id = $_idutente;

if($azione=="saveaccount")
{
 include $incpath."user/saveusrdata.inc.php";
 
} 


$sql = "SELECT * FROM t_utenti WHERE idutente=$_idutente";
$mydb->DoSelect($sql);
$ru = $mydb->GetRow();

$usr_email    = $ru['email'];
$usr_username = $ru['username'];
$usr_nome     = $ru['nome'];
$usr_cognome  = $ru['cognome'];

$usr_telefono = $ru['tel1'];
$usr_level    = $ru['level'];

$stato = $ru['stato'];
if($stato=='1') $strstato = "<span class=\"green\" >Attivo</span>"; else $strstato = "<span class=\"orange\">Non Attivo</span>";

$sql = "SELECT ta.* FROM $tbl_aziende as tu, $tbl_aziende_anag as ta WHERE tu.id_utente_portale=$_idutente AND tu.id_utentihs=ta.id_utenti_anag";
$mydbG->DoSelect($sql);
$ru2 = $mydbG->GetRow();

$id_anag = $ru2['id_utenti_anag'];

$usr_citta    = $ru2['resi_comune_txt'];
$usr_indirizzo= $ru2['resi_via'];
$usr_cap      = $ru2['resi_cap'];
$usr_prov     = $ru2['resi_provincia_txt'];
//$usr_telefono = $ru2['resi_telefono'];

$ruf = array();

$sql = "SELECT * FROM $tbl_aziende_fatt WHERE id_anag=$id_anag";
$mydbG->DoSelect($sql);
if ( ($ruf = $mydbG->GetRow()) )
{

$usrf_piva     = $ruf['piva'];
$usrf_cfiscale = $ruf['cfiscale'];
$usrf_rs       = $ruf['cognome'];
$usrf_citta    = $ruf['domi_comune_txt'];
$usrf_indirizzo= $ruf['domi_via'];
$usrf_cap      = $ruf['domi_cap'];
$usrf_prov     = $ruf['domi_provincia_txt'];
$usrf_telefono = $ruf['domi_telefono'];
$usrf_pec      = $ruf['pec'];
$usrf_cdest    = $ruf['cod_sdi'];

}

if($errmsg!=""){
?>
<div class="bordered" style="margin-top:20px;max-width:<?=$maxw?>;padding:6px">
    <span class="testo_err"><?=$errmsg?></span>
</div>
<? } ?>
<!--div class="rbutton2" onclick="back()"><div>Indietro</div></div-->
 <div class="spessore"></div>
 
    <form id="frmins" name="frmins" action="<? echo $action; ?>" method="post">
        
        
        <div class="box_cnt boxaccount rounded">

                 <div class="titolo" style="width:100%;text-align:center">Dati generali</div>

                                <table cellspacing="0" cellpadding="4" border="0" class="tablerespnob">
                                    <tr>
                                        <td class=" tdlabel">Username*:</td>
                                        <td class="tdField"><?=$usr_username?>
                                            <input type="hidden" name="usr_username" value="<?=$usr_username?>"   />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" tdlabel">Email*:</td>
                                        <td class="tdField"><?=$usr_email?>
                                            <input type="hidden" name="usr_email" value="<?=$usr_email?>" />
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <td class=" tdlabel">Nome*:</td><td><input type="text" name="usr_nome" value="<?=stripslashes($usr_nome)?>" title="Nome" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class=" tdlabel">Cognome*:</td><td><input type="text" name="usr_cognome" value="<?=stripslashes($usr_cognome)?>" title="Cognome" /></td>
                                    </tr>
                                  <? if($usr_level==1 && 0){?>
                                    <tr>
                                        <td class="">Citt&agrave;:</td><td><input type="text" name="usr_citta" value="<?=stripslashes($usr_citta)?>"  /></td>
                                    </tr>                                    
                                       <tr>
                                        <td class="">Cap:</td><td><input type="text" name="usr_cap" value="<?=$usr_cap?>" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="">Provincia:</td><td><input type="text" name="usr_prov" value="<?=stripslashes($usr_prov)?>" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="">Indirizzo:</td><td><input type="text" name="usr_indirizzo" value="<?=stripslashes($usr_indirizzo)?>"  /></td>
                                    </tr> 
                                  
                                    <tr>
                                    <td class="">Telefono:</td><td><input type="text" name="usr_telefono" value="<?=$usr_telefono?>"  /></td>
                                    </tr>  
                                   <? } ?> 
                                  <? /*
                                    <tr>
                                        <td class=" tdlabel">Profilo*:</td>
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
                                  */ ?>
                                </table>
                                        
                 <input type="hidden" name="usr_level" value="<?=$usr_level?>"  />

    </div>

    <? if($usr_level==1 && 0){ ?>
        <div class="box_cnt boxaccount rounded">

            <div class="titolo" style="width:100%;text-align:center">Dati di fatturazione</div>
        
                   
                             <table cellspacing="0" cellpadding="4" border="0" class="tblForm">
                                    <tr>
                                        <td class="">Nominativo / Ragione Sociale:</td><td><input type="text" name="usrf_rs" value="<?=stripslashes($usrf_rs)?>"   /></td>
                                    </tr>
                                     <tr>
                                    <td class="">Codice Fiscale:</td><td><input type="text" name="usrf_cfiscale" value="<?= stripslashes($usrf_cfiscale) ?>"  /></td>
                                    </tr>
                    
                                            
                                    <tr>
                                        <td class="">Citt&agrave;:</td><td><input type="text" name="usrf_citta" value="<?=stripslashes($usrf_citta)?>" /></td>
                                    </tr>
                                       <tr>
                                        <td class="">Cap:</td><td><input type="text" name="usrf_cap" value="<?=$usrf_cap?>" /></td>

                                    <tr>
                                        <td class="">Indirizzo:</td><td><input type="text" name="usrf_indirizzo" value="<?=stripslashes($usrf_indirizzo)?>" /></td>
                                    </tr>  
                                     <tr>
                                        <td class="">Provincia:</td><td><input type="text" name="usrf_prov" value="<?=stripslashes($usrf_prov)?>" /></td>
                                    </tr>
                                    <tr>
                                    <td class="">Telefono:</td><td><input type="text" name="usrf_telefono" value="<?=$usrf_telefono?>"  /></td>
                                    </tr>  
                                    <tr>
                                    <td class="">PARTITA IVA:</td><td><input type="text" name="usrf_piva" value="<?=$usrf_piva?>"  /></td>
                                    </tr>  
                                    
                                    <tr>
                                        <td class="">Codice Destinatario<br/><span class="testosm">(Fatturazione Elettronica)</span>:</td>
                                    <td><input type="text" name="usrf_cdest" value="<?=$usrf_cdest?>"  /></td>
                                    </tr>  
                                    
                                    <tr>
                                    <td class="">PEC:</td>
                                    <td><input type="text" name="usrf_pec" value="<?=$usrf_pec?>"  /></td>
                                    </tr> 
                                    
                                    

                                </table>
                                            

            

    </div>
     
    <? } ?>
        
    <div class="clearboth"></div>
    <div class="spessore"></div>
        
    <div class="box_cnt boxaccount rounded">
          
        <div class="button1" onclick="checkdata()" style="display:inline-table"><div>Salva</div></div>
            
    </div>  
        
            <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="<? echo $id ?>">
            <input type="hidden" name="sezione"  value="<?=$sezione?>,2">
            <input type="hidden" name="azione"  value="">
            <input type="hidden" name="tab"  value="<?=$tab?>">
            
        </form>

<script type="text/javascript" charset="utf-8">

function checkdata(){
	
	res = convalidaForm3(document.frmins,'evi');

	if(res)
        {

        document.frmins.azione.value='saveaccount';

        document.frmins.submit();
	
	}
}


</script>