<?
$errmsg = "";



if($azione=="save2")
{
    $path = $path_userdata.$id."/";
    
    if(!is_dir($path))
    {
        mkdir($path,0777);
    }
    
    $subcategoria = 0;
    
    $sql = "SELECT * FROM utenti_categorie WHERE id_cat=$usrf_cat";
    $mydbG->DoSelect($sql);
    $rtmp=$mydbG->GetRow();
    if($rtmp['id_parent']>0)
    {
        $subcategoria = $usrf_cat;
        $usrf_cat = $rtmp['id_parent'];
    }
    
    $sql = "UPDATE $tbl_websites SET url='$usrf_url', wiki='$usrf_wiki', telefono='$usrf_tel', email='$usrf_email', id_cat=$usrf_cat, coords='$usrf_coords' WHERE  id=$idws";
    $mydbNW->ExecSql($sql);
    
    $sql = "UPDATE $tbl_aziende SET categoria=$usrf_cat, subcategoria=$subcategoria WHERE id_anag=$id";
    $mydbG->ExecSql($sql);
 

 if(isset($_FILES["fileToUpload"]["name"]))
 {
 
 $target_dir = $path;
 $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
 $imgname = $_FILES["fileToUpload"]["name"];#"logo_".$ida.".".$imageFileType;#
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
    $sql = "UPDATE $tbl_websites SET img='$imgname' WHERE id=$idws";
    $mydbNW->ExecSql($sql);

 }
 }
 
} 


$sql = "SELECT ta.* FROM $tbl_websites as ta WHERE ta.id_anag=$id";
$mydbNW->DoSelect($sql);
$rws = $mydbNW->GetRow();

$idws       = $rws['id'];

$usrf_url   = $rws['url'];
#$usrf_rs       = mydecodeTxt($ru2['cognome']);
$usrf_wiki  = $rws['wiki'];
$usrf_tel   = $rws['telefono']; 
$usrf_email = $rws['email']; 
$usrf_cat   = $rws['id_cat'];
$usrf_coords= $rws['coords'];
$usrf_img   = $rws['img'];

/*
$usrf_citta    = $ru2['resi_comune'];
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

$img = $ru2['logo'];
*/


if($errmsg!=""){
?>
<div class="bordered" style="margin-top:20px;max-width:<?=$maxw?>;padding:6px">
    <span class="testo_err"><?=$errmsg?></span>
</div>
<? } ?>
    <form id="frmins" name="frmins" action="<? echo $action; ?>" method="post" enctype="multipart/form-data">
        
        <div class="spessore"></div>
            
        
        <div class="titolo" style="text-align:left">
            Scheda Web
        </div>

     
        <div class="box bordered" style="text-align:left">

        
                   
                             <table cellspacing="0" cellpadding="4" border="0" class="tblForm">
                                 
                                 <tr>
                                        <td class="testob">Categoria:</td>
                                        <td>
                                            <select name="usrf_cat">
                                                <option value="0" >-selezionare la categoria-</option>
                                                <?
                                                $sql = "SELECT * FROM utenti_categorie WHERE main_tipo=$_maintipoanag AND tipo='1'";
	                                        $a_cat = $mydbG->DoSelect($sql);
                                                foreach($a_cat as $k => $rp)
                                                {
                                                    $s = "";
                                                    if($rp['id_cat']==$usrf_cat) $s = "selected";
                                                    $cat = getCategoriaAnag($rp['id_cat'], $mydbG);
                                                    if($rp['id_parent']>0)
                                                    {
                                                        $cat = getCategoriaAnag($rp['id_parent'], $mydbG)."/".$cat;
                                                    }
                                                    ?>
                                                <option value="<?=$rp['id_cat']?>" <?=$s?> ><?= $cat;?></option>
                                                <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                 
                                   <tr>
                                        <td class="testob">Telefono :</td><td><input type="text" name="usrf_tel" value="<?= $usrf_tel?>" class="large"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Email :</td><td><input type="text" name="usrf_email" value="<?= $usrf_email?>" class="large"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Wiki :</td><td><input type="text" name="usrf_wiki" value="<?= $usrf_wiki?>" class="large"  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Sito web:</td><td>
                                            <input type="text" name="usrf_url" value="<?=$usrf_url?>"  class="large"   />
                                         </td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Coordinate:</td><td>
                                            <input type="text" name="usrf_coords" value="<?=$usrf_coords?>"  class="large"   />
                                         </td>
                                    </tr>
                                    <tr>
                                        <td class="testob">
                                            Immagine:
                                        <? if($usrf_img!=""){?>
                                       <br/><img src="<?=$http_userdata.$id."/".$usrf_img?>" style="max-width: 160px;max-height: 60px" />     
                                        <?}?>
                                        </td>
                                        
                                        <td>
                                            <input type="file" name="fileToUpload"  /> </td>
                                    </tr>
                                    <? /*
                                    

                                    <tr>
                                        <td class="testob">
                                            Email:<br>
                                            <!--<span class="testosm">Email per l'invio delle notifiche</span>-->
                                        </td>
                                        <td><input type="text" name="usrf_email" value="<?=$usrf_email?>" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Provincia:</td>
                                        <td>
                                            <select name="usrf_prov">
                                                <option value="" >-selezionare la provincia-</option>
                                                <?
                                                $sql = "SELECT * FROM province WHERE 1";
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
                                            <select name="usrf_citta">
                                                <? if($usrf_prov==""){?>
                                                <option value="" >-selezionare la provincia-</option>
                                                <? }elseif($usrf_citta==""){?>
                                                <option value="" >-selezionare il comune-</option>
                                                <? } ?>
                                                <?
                                                if($usrf_prov!=""){
                                                $sql = "SELECT * FROM comuni WHERE codice_provincia='$usrf_prov'";
	                                        $a_prov = $dbDati->DoSelect($sql);
                                                foreach($a_prov as $k => $rp)
                                                {
                                                    $s = "";
                                                    if($rp['codice_comune']==$usrf_citta) $s = "selected";
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
                                    
                                    <tr>
                                    <td class="testob">Note:</td>
                                    <td><textarea name="usrf_note"><?=$usrf_note?></textarea></td>
                                    </tr> 
                                    <!--
                                    <tr>
                                    <td class="testob">Logo:</td>
                                    <td><input type="file" name="usrf_logo"  /></td>
                                    </tr> 
                                    -->
                                    */?>

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

       
            <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="<? echo $id ?>">
            <input type="hidden" name="tab"  value="<? echo $tab ?>">
            <input type="hidden" name="tab2"  value="<? echo $tab2 ?>">
            <input type="hidden" name="sezione"  value="cms,<?=$isubsezione?>">
            <input type="hidden" name="azione"  value="">
            <input type="hidden" name="idws"  value="<?=$idws?>">
            
        </form>

<script>

function checkdata(){
	
	res = convalidaForm3(document.frmins,'<?=$language?>','evi');

	if(res)
        {

        document.frmins.azione.value='save2';
        waitpage();
        document.frmins.submit();
	
	}
}

</script>