<?
$errmsg = "";

if($azione=="save")
{
$nome = myencodeTxt($usrf_nome);
$note = myencodeTxt($usrf_note);

$sql = "UPDATE sponsor SET nome='$nome', web='$usrf_web', note='$note' WHERE id=$id ";
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
   } else {
     echo "File is not an image.";
     $uploadOk = 0;
   }
 }
 
 if( ($uploadOk == 1) && is_file($target_file) )
 {
    #if($_usecrm)//non serve...
    #{
    $sql = "UPDATE sponsor SET immagine='$imgname' WHERE id=$id";
    $mydb->ExecSql($sql);
    #}

 }
 }
 
}
if($azione=="ins")
{
$nome = myencodeTxt($usrf_nome);
$note = myencodeTxt($usrf_note);

$sql = "INSERT INTO sponsor (nome, data_ins, id_circuito, web, note) VALUES ";
$sql .= "('$nome', NOW(), $id_location, '$usrf_web', '$note')";
$mydb->ExecSql($sql);

 $isubsezione = 2;
 $azto = "save";
 $id = $mydb->LastInsertedId;


 
}


if($isubsezione==2)
{

$azto = "save";

$titlepag = "Scheda Sponsor/Collegamento";

$sql = "SELECT ti.* FROM sponsor as ti WHERE ti.id=$id ";
$mydb->DoSelect($sql);
$ru2 = $mydb->GetRow();

$usrf_nome       = mydecodeTxt($ru2['nome']);
$usrf_web = $ru2['web'];
$usrf_note     = mydecodeTxt($ru2['note']);
$img    = $ru2['immagine'];

} elseif($isubsezione==4) {

$id = 0;

$azto = "ins";
    
$usrf_nome     = "";
$usrf_web = "";
$usrf_note     = "";
$img = "";
    
$titlepag = "Nuovo Sponsor/Collegamento";
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
                                        <td class="testob">Web :</td><td><input type="text" name="usrf_web" value="<?=$usrf_web?>"   /></td>
                                    </tr>

                                    
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