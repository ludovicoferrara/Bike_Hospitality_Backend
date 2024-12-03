<?
$errmsg = "";

if($azione=="save")
{
$nome = myencodeTxt($usrf_nome);
$localita = myencodeTxt($usrf_localita);
$note = myencodeTxt($usrf_note);

$sql = "UPDATE itinerari SET nome='$nome', localita='$localita', comune='$usrf_comune', provincia='$usrf_provincia', telefono='$usrf_telefono', email='$usrf_email', note='$note', info='$usrf_tipo' WHERE id=$id ";
$mydb->ExecSql($sql);
/*
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
    #$mydbG->ExecSql($sql);
    #}

 }
 }
 */
} 
if($azione=="ins")
{
$nome = myencodeTxt($usrf_nome);
$localita = myencodeTxt($usrf_localita);
$note = myencodeTxt($usrf_note);

$sql = "INSERT INTO itinerari (nome, localita, data_ins, id_circuito, comune, provincia, telefono, email, note, info) VALUES ";
$sql .= "('$nome', '$localita', NOW(), $id_location, '$usrf_comune', '$usrf_provincia',  '$usrf_telefono', '$usrf_email', '$note', '$usrf_tipo')";
$mydb->ExecSql($sql);

 $isubsezione = 2;
 $azto = "save";
 $id = $mydb->LastInsertedId;


 
} 


if($isubsezione==2)
{

$azto = "save";

$titlepag = "Scheda itinerario";

$sql = "SELECT ti.* FROM itinerari as ti WHERE ti.id=$id ";
$mydb->DoSelect($sql);
$ru2 = $mydb->GetRow();

$usrf_nome       = mydecodeTxt($ru2['nome']);
$usrf_citta    = $ru2['comune'];
$usrf_telefono = $ru2['telefono'];
$usrf_localita     = mydecodeTxt($ru2['localita']);
$usrf_note     = mydecodeTxt($ru2['note']);
$usrf_email    = $ru2['email'];
$usrf_prov     = $ru2['provincia'];
if($usrf_prov=="") $usrf_prov = getProvFromComune($usrf_citta);
$usrf_tipo     = $ru2['info'];

#$img = $ru2['logo'];

} elseif($isubsezione==4) {

$id = 0;

$azto = "ins";
    
$usrf_nome     = "";
$usrf_citta    = "";
$usrf_localita = "";
if(empty($usrf_prov)) $usrf_prov     = "";
$usrf_telefono = "";
$usrf_note     = "";
$usrf_email    = "";
$usrf_tipo     = "";

$img = "";
    
$titlepag = "Nuovo itinerario";
}


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
                                        <td class="testob">Nome :</td><td><input type="text" name="usrf_nome" value="<?=$usrf_nome?>"   /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Tipo :</td><td>
                                        <select name="usrf_tipo">
                                            <option value="Itinerario" <?if($usrf_tipo=="Itinerario") echo "selected"?> >Itinerario</option>
                                            <option value="Format"  <?if($usrf_tipo=="Format") echo "selected"?> >Format</option>
                                        </select>
                                        </td>
                                    </tr>
                                    
                                    
                                    <? /*
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
                                    */ ?>  
                                    <tr>
                                        <td class="testob">Provincia:</td>
                                        <td>
                                            <select  name="usrf_provincia"  id="usrf_provincia"   onchange="loadComuni(this.value,'usrf_' )" >
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
                                        <td class="testob">Località :</td><td><input type="text" name="usrf_localita" value="<?=$usrf_localita?>"   /></td>
                                    </tr>

                                    
                                    <tr>
                                    <td class="testob">Telefono organizzatore:</td><td><input type="text" name="usrf_telefono" value="<?=$usrf_telefono?>"  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">
                                            Email organizzatore:<br>
                                            
                                        </td>
                                        <td><input type="text" name="usrf_email" value="<?=$usrf_email?>" /></td>
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
    
    <? } ?>
        
            <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="<? echo $id ?>">
            <input type="hidden" name="tab"  value="<? echo $tab ?>">
            <input type="hidden" name="tab2"  value="<? echo $tab2 ?>">
           <input type="hidden" name="sezione"  value="cms,<?=$isubsezione?>">
            <input type="hidden" name="azione"  value="">
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