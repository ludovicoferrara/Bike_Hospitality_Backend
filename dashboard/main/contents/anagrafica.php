<?
$errmsg = "";

if($azione=="save")
{
 include "saveanagdata.inc.php";

 if(isset($_FILES["fileToUpload"]["name"]))
 {
 
 $target_dir = "main/contents/media/";
 $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
 $imgname = "logo_".$ida.".".$imageFileType;#,$_FILES["fileToUpload"]["name"];
 $target_file = $target_dir .  $imgname;#basename($_FILES["fileToUpload"]["name"]);
 $uploadOk = 1;
 //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 // Check if image file is a actual image or fake image
 if(1) {
   $check = true;//getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   if($check !== false) {
     //echo "File is an image - " . $check["mime"] . ".";
     $uploadOk = 1;
     move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
   } else {
     echo "File is not an image.";
     $uploadOk = 0;
   }
 }
 
 if( ($uploadOk == 1) && is_file($target_file) )
 {
    #if($_usecrm)//non serve...
    #{
    $sql = "UPDATE $tbl_aziende SET logo='$imgname' WHERE id_anag=$ida";
    $mydbG->ExecSql($sql);
    #}

 }
 }
 
} 
if($azione=="ins")
{
 include "insanagdata.inc.php";

 $isubsezione = 2;
 $azto = "save";
 $id = $id_utentihs;

 if(isset($_FILES["fileToUpload"]["name"]))
 {
 
    $target_dir = "main/contents/media/";
    $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
    $imgname = "logo_".$id.".".$imageFileType;#,$_FILES["fileToUpload"]["name"];
    $target_file = $target_dir .  $imgname;#basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(1) {
      $check = true;//getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    if( ($uploadOk == 1) && is_file($target_file) )
    {
       $sql = "UPDATE $tbl_aziende SET logo='$imgname' WHERE id_utentihs=$id";
       $mydbG->ExecSql($sql);

    }
 }
 
} 

if($azione=="addGruppo")
{
    $sql = "INSERT INTO anagrafiche_gruppi (id_utente, id_gruppo, tab) VALUES ($id, $gruppo2add, '2')";
    $mydbG->ExecSql($sql);
}

if($azione=="delFromGr")
{
    $sql = "DELETE FROM anagrafiche_gruppi WHERE id_utente = $id AND id_gruppo= $idg";
    $mydbG->ExecSql($sql);
}

if($isubsezione==2)
{

$azto = "save";

$titlepag = "Scheda cliente";

$sql = "SELECT ta.*, tu.codice, tu.nome, tu.note, tu.logo, tu.email FROM $tbl_aziende as tu, $tbl_aziende_anag as ta WHERE tu.id_anag=$id AND tu.id_anag=ta.id_anag";
$mydbG->DoSelect($sql);
$ru2 = $mydbG->GetRow();

$usrf_piva     = $ru2['piva'];
$usrf_rs       = mydecodeTxt($ru2['cognome']);
$usrf_cfiscale = $ru2['cfiscale'];
$usrf_comune   = $ru2['resi_comune'];
$usrf_indirizzo= mydecodeTxt($ru2['resi_via']);
$usrf_cap      = $ru2['resi_cap'];
$usrf_prov     = $ru2['resi_provincia'];
$usrf_telefono = $ru2['resi_telefono'];
$usrf_pec      = $ru2['pec'];
$usrf_cdest    = $ru2['cod_sdi'];
$usrf_nome     = mydecodeTxt($ru2['nome']);
$usrf_codice   = $ru2['codice'];
$usrf_note     = mydecodeTxt($ru2['note']);
$usrf_email    = $ru2['email'];
$usrf_civico   = $ru2['resi_civico'];
$usrf_insegna  = mydecodeTxt($ru2['nomebreve']);

//PATCH
if($_wsnetwork && $usrf_insegna=="")
{
    $sql = "SELECT titolo FROM $tbl_websites WHERE id_anag=$id";
    $mydbNW->DoSelect($sql);
    if( ($rws=$mydbNW->GetRow()) )
    {
        $usrf_insegna = mydecodeTxt($rws['titolo']);
    }
}

$img = $ru2['logo'];

} elseif($isubsezione==4) {

$id = 0;

$azto = "ins";

if($azione!="preins")
{
$usrf_piva     = "";
$usrf_rs       = "";
$usrf_cfiscale = "";
$usrf_comune   = "";
$usrf_indirizzo= "";
$usrf_cap      = "";
$usrf_prov     = "";
$usrf_telefono = "";
$usrf_pec      = "";
$usrf_cdest    = "";
$usrf_nome     = "";
$usrf_codice   = "";
$usrf_note     = "";
$usrf_email    = "";
$reportConfig  = '0';
$usrf_civico   = "";
$usrf_insegna  = "";


}
$img = "";
$titlepag = "Nuovo cliente";
}

$sql = "SELECT * FROM gruppi_anagrafiche WHERE tab='2'";
$a_gruppi = $mydbG->DoSelect($sql);

if($errmsg!=""){
?>
<div class="bordered" style="margin-top:20px;max-width:<?=$maxw?>;padding:6px">
    <span class="testo_err"><?=$errmsg?></span>
</div>
<? } ?>
    <form id="frmins" name="frmins" action="<? echo $action; ?>" method="post" enctype="multipart/form-data">
        
        <div class="spessore"></div>
            
        
        <div class="titolo" style="text-align:left">
            <?=$titlepag?>
        </div>

     
        <div class="box bordered" style="text-align:left">

        
                   
                             <table cellspacing="0" cellpadding="4" border="0" class="tblForm">
                                    <tr>
                                        <td class="testob">Ragione Sociale :</td><td><input type="text" name="usrf_rs" value="<?=$usrf_rs?>" title="Ragione Sociale"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Insegna :</td><td><input type="text" name="usrf_insegna" value="<?=$usrf_insegna?>"   /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Codice:</td><td>
                                            <input type="text" name="usrf_codice" value="<?=$usrf_codice?>"   />
                                            <? if($isubsezione==4) {?><input type="checkbox" name="autocodice" value="1" checked /> automatico<? } ?>
                                            <input type="hidden" name="usrf_oldcodice" value="<?=$usrf_codice?>"   />
                                        </td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td class="testob">
                                            Logo:
                                        <? if($img!=""){?>
                                       <br/><img src="main/contents/media/<?=$img?>" style="max-width: 160px;max-height: 60px" />     
                                        <?}?>
                                        </td>
                                        
                                        <td>
                                            <input type="file" name="fileToUpload"  /> </td>
                                    </tr>
                                     -->
                                    <tr>
                                        <td class="testob">
                                            Email:<br>
                                            <!--<span class="testosm">Email per l'invio delle notifiche</span>-->
                                        </td>
                                        <td><input type="text" name="usrf_email" value="<?=$usrf_email?>" /></td>
                                    </tr>
                                    <? /*
                                    <tr>
                                        <td class="testob">Invio report:</td>
                                        <td>
                                            <select name="reportConfig" >
                                                <option value="0" <? if($reportConfig=='0') echo "selected"; ?> >Manuale</option>
                                                <option value="1" <? if($reportConfig=='1') echo "selected"; ?> >Automatico mensile</option>
                                                <option value="2" <? if($reportConfig=='2') echo "selected"; ?> >Automatico trimestrale</option>
                                                <option value="3" <? if($reportConfig=='3') echo "selected"; ?> >Automatico semestrale</option>
                                            </select>
                                        </td>
                                    </tr>
                                          
                                    <tr>
                                        <td class="testob">Citt&agrave; Azienda:</td><td><input type="text" name="usrf_citta" value="<?=stripslashes($usrf_citta)?>" /></td>
                                    </tr>
                                    */ ?>  
                                    <tr>
                                        <td class="testob">Provincia:</td>
                                        <td>
                                            <select name="usrf_provincia" id="usrf_provincia" onchange="loadComuni(this.value,'usrf_' )">
                                                <option value="" >-selezionare la provincia-</option>
                                                <?
                                                $sql = "SELECT * FROM province WHERE 1 ORDER BY nome_provincia";
	                                        $a_prov = $dbDati->DoSelect($sql);
                                                foreach($a_prov as $k => $rp)
                                                {
                                                    $s = "";
                                                    if($rp['codice_provincia']==$usrf_prov) $s = "selected";
                                                    ?>
                                                <option value="<?=$rp['codice_provincia']?>" <?=$s?> ><?= utf8_encode($rp['nome_provincia'])?></option>
                                                <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Citt&agrave;:</td>
                                        <td>
                                            <select name="usrf_comune" id="usrf_comune">
                                                <? if($usrf_prov==""){?>
                                                <option value=""  >-selezionare la provincia-</option>
                                                <? }elseif($usrf_comune==""){?>
                                                <option value="" >-selezionare il comune-</option>
                                                <? } ?>
                                                <?
                                                if($usrf_prov!=""){
                                                $sql = "SELECT * FROM comuni WHERE codice_provincia='$usrf_prov'";
	                                        $a_prov = $dbDati->DoSelect($sql);
                                                foreach($a_prov as $k => $rp)
                                                {
                                                    $s = "";
                                                    if($rp['codice_comune']==$usrf_comune) $s = "selected";
                                                    ?>
                                                <option value="<?=$rp['codice_comune']?>" <?=$s?> ><?=utf8_encode($rp['nome_comune'])?></option>
                                                <?
                                                }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                       <tr>
                                        <td class="testob">Cap:</td><td><input type="text" name="usrf_cap" value="<?=$usrf_cap?>" /></td>

                                    <tr>
                                        <td class="testob">Indirizzo:</td><td><input type="text" name="usrf_indirizzo" value="<?= mydecodeTxt($usrf_indirizzo)?>" /></td>
                                    </tr>  
                                     <tr>
                                        <td class="testob">N. Civico:</td><td><input type="text" name="usrf_civico" value="<?=mydecodeTxt($usrf_civico)?>" /></td>
                                    </tr>  
                                    <? /* non li metto per semplicità
                                    <tr>
                                    <td class="testob">Telefono:</td><td><input type="text" name="usrf_telefono" value="<?=$usrf_telefono?>"  /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">Codice Fiscale:</td><td><input type="text" name="usrf_cfiscale" value="<?=$usrf_cfiscale?>"  /></td>
                                    </tr>  
                                    <tr>
                                    <td class="testob">PARTITA IVA:</td><td><input type="text" name="usrf_piva" value="<?=$usrf_piva?>"  /></td>
                                    </tr>  
                                    
                                    <tr>
                                        <td class="testob">Codice Destinatario<br/><span class="testosm">(Fatturazione Elettronica)</span>:</td>
                                    <td><input type="text" name="usrf_cdest" value="<?=$usrf_cdest?>"  /></td>
                                    </tr>  
                                    
                                    <tr>
                                    <td class="testob">PEC:</td>
                                    <td><input type="text" name="usrf_pec" value="<?=$usrf_pec?>"  /></td>
                                    </tr> 
                                    */ ?>
                                    <tr>
                                    <td class="testob">Note:</td>
                                    <td><textarea name="usrf_note"><?=$usrf_note?></textarea></td>
                                    </tr> 
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="usrf_telefono" value="<?=$usrf_telefono?>" />
                                            <input type="hidden" name="usrf_cfiscale" value="<?=$usrf_cfiscale?>"  />
                                            <input type="hidden" name="usrf_piva" value="<?=$usrf_piva?>" />
                                            <input type="hidden" name="usrf_cdest" value="<?=$usrf_cdest?>"  /> 
                                            <input type="hidden" name="usrf_pec" value="<?=$usrf_pec?>"  />
                                        </td>
                                    
                                    </tr> 
                                    
                                    

                                </table>
                                            

            

    </div>
        
        
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
    
    <div class="clearboth"></div>

    <? if($isubsezione==2)
    {
 ?>   
    <div class="titolo" style="text-align:left">Gruppi di appartenenza</div>
    
    <div class="spessore"></div>
    
    <table cellspacing="0" cellpadding="6" border="0" class="tablegrid">
        
        <tr>
            <th>Gruppo</th><th></th>
        </tr>
        <?
        $sql = "SELECT tg.* FROM gruppi_anagrafiche as tg, anagrafiche_gruppi as tag WHERE tag.id_gruppo = tg.id_gruppo AND tag.id_utente=$id AND tag.tab='2'";
        $a = $mydbG->DoSelect($sql);
        if(is_array($a))
            foreach($a as $k => $r)
        {
            ?>
        <tr>
            <td><?=$r['nome']?></td>
            <td><a href="javascript:delFromGr(<?=$r['id_gruppo']?>)" title="Rimuovi dal gruppo"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a></td>
        </tr>
        <?    } ?>
        
    </table>
    
    
        
    <div class="box bordered" style="text-align:left">
          
        Aggiungi al gruppo: <select name="gruppo2add" onchange="addGruppo()">
            <option value="">-scegli il gruppo-</option>
            <? if(is_array($a_gruppi)){
               foreach($a_gruppi as $k => $rg)
               {
                   ?>
                <option value="<?=$rg['id_gruppo']?>"><?=$rg['nome']?></option>
            <?
               }
            }?>
        </select>

    </div>  

    <? } ?>
        
            <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="<? echo $id ?>">
            <input type="hidden" name="tab"  value="<? echo $tab ?>">
            <input type="hidden" name="tab2"  value="<? echo $tab2 ?>">
           <input type="hidden" name="sezione"  value="cms,<?=$isubsezione?>">
            <input type="hidden" name="azione"  value="preins">
            <input type="hidden" name="idg"  value="">
            
        </form>

<script type="text/javascript" charset="utf-8">

function checkdata(){
	
	res = convalidaForm3(document.frmins,'<?=$language?>','evi');

	if(res)
        {

        document.frmins.azione.value='<?=$azto?>';
        waitpage();
        document.frmins.submit();
	
	}
}

function addGruppo()
{
    document.frmins.azione.value='addGruppo';
     waitpage();
    document.frmins.submit();
}
function delFromGr(idg)
{
    document.frmins.azione.value='delFromGr';
    document.frmins.idg.value=idg;
    waitpage();
    document.frmins.submit();
}
</script>