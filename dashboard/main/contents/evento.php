<?
$errmsg = "";

if($azione=="save")
{
$nome = myencodeTxt($usrf_nome);
$localita = myencodeTxt($usrf_localita);
$note = myencodeTxt($usrf_note);
$data = Date_fordb($usrf_datarif);

$sql = "UPDATE eventi SET nome='$nome', localita='$localita', web='$usrf_web', provincia='$usrf_provincia', data_rif='$data',  note='$note' WHERE id=$id ";
$mydb->ExecSql($sql);

 if(isset($_FILES["fileToUpload"]["name"]))
 {
 
 $target_dir = "main/contents/media/";
 $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
 $imgname = $_FILES["fileToUpload"]["name"];
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
     $res = upload_img2($_FILES["fileToUpload"]["tmp_name"],$_FILES["fileToUpload"]["name"],$target_dir,"");
        $imgname = $res[0];
        $target_file = $target_dir .  $imgname;
   } else {
     echo "File is not an image.";
     $uploadOk = 0;
   }
 }
 
 if( ($uploadOk == 1) && is_file($target_file) )
 {
    #if($_usecrm)//non serve...
    #{
    $sql = "UPDATE eventi SET immagine='$imgname' WHERE id=$id";
    $mydb->ExecSql($sql);
    #}

 }
 }
 
}
if($azione=="ins")
{
$nome = myencodeTxt($usrf_nome);
$localita = myencodeTxt($usrf_localita);
$note = myencodeTxt($usrf_note);

$data = Date_fordb($usrf_datarif);

$sql = "INSERT INTO eventi (nome, localita, data_ins, id_circuito, provincia, web, note, data_rif) VALUES ";
$sql .= "('$nome', '$localita', NOW(), $id_location, '$usrf_provincia', '$usrf_web', '$note', '$data')";
$mydb->ExecSql($sql);

 $isubsezione = 2;
 $azto = "save";
 $id = $mydb->LastInsertedId;


 
}


if($isubsezione==2)
{

$azto = "save";

$titlepag = "Scheda evento";

$sql = "SELECT ti.* FROM eventi as ti WHERE ti.id=$id ";
$mydb->DoSelect($sql);
$ru2 = $mydb->GetRow();

$usrf_nome       = mydecodeTxt($ru2['nome']);
#$usrf_citta    = $ru2['comune'];
$usrf_web = $ru2['web'];
$usrf_localita = mydecodeTxt($ru2['localita']);
$usrf_note     = mydecodeTxt($ru2['note']);
$img    = $ru2['immagine'];
$usrf_prov     = $ru2['provincia'];
#if($usrf_prov=="") $usrf_prov = getProvFromComune($usrf_citta);
$usrf_datarif = Date_fromdb($ru2['data_rif']);

#$img = $ru2['logo'];

} elseif($isubsezione==4) {

$id = 0;

$azto = "ins";
    
$usrf_nome     = "";
$usrf_citta    = "";
$usrf_localita = "";
if(empty($usrf_prov)) $usrf_prov     = "";
$usrf_web = "";
$usrf_note     = "";
$usrf_datarif  = "";

$img = "";
    
$titlepag = "Nuovo evento";
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
                                    
                                    
                                    <? /* */ ?>  
                                     <tr>
                                        <td class="testob">
                                            Immagine:
                                        <? if($img!=""){?>
                                       <br/><img src="main/contents/media/<?=$img?>" style="max-width: 160px;max-height: 60px" />     
                                        <?}?>
                                        </td>
                                        
                                        <td>
                                            <input type="file" name="fileToUpload"  /> </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Data evento :</td><td><input type="text" name="usrf_datarif" value="<?=$usrf_datarif?>"   /></td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="testob">Provincia:</td>
                                        <td>
                                            <select  name="usrf_provincia"  id="usrf_provincia"  >
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
                                    <? /*
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
                                    */ ?>
                                    <tr>
                                        <td class="testob">Località :</td><td><input type="text" name="usrf_localita" value="<?=$usrf_localita?>"   /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Web :</td><td><input type="text" name="usrf_web" value="<?=$usrf_web?>"   /></td>
                                    </tr>

                                    <? /*
                                    <tr>
                                    <td class="testob">Telefono organizzatore:</td><td><input type="text" name="usrf_telefono" value="<?=$usrf_telefono?>"  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">
                                            Email organizzatore:<br>
                                            
                                        </td>
                                        <td><input type="text" name="usrf_email" value="<?=$usrf_email?>" /></td>
                                    </tr>
                                   */ ?>
                                    <tr>
                                    <td class="testob">Note:</td>
                                    <td><textarea name="usrf_note"><?=$usrf_note?></textarea></td>
                                    </tr> 
                                    
                                   
                                  <!--  -->
                                    

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