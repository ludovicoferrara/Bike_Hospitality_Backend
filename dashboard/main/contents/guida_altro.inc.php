<?
$errmsg = "";



if($azione=="save2")
{
    #$path = $path_userdata.$idws."/";
    
    $info = myencodeTxt($usrf_info);
    
    $sql = "UPDATE guide SET info='$info', gpx='$usrf_gpx', linkgpx='$usrf_gpxl', map='$usrf_map' WHERE  id=$idws";
    $mydbNW->ExecSql($sql);
    

/*
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
 */
} 


$sql = "SELECT ti.* FROM guide as ti WHERE ti.id=$id";
$mydbNW->DoSelect($sql);
$rws = $mydbNW->GetRow();

$idws       = $rws['id'];

#$usrf_url   = $rws['url'];
$usrf_info  = mydecodeTxt($ru2['info']);
$usrf_gpx   = $rws['gpx'];
$usrf_gpxl  = $rws['linkgpx']; 
$usrf_map   = $rws['map']; 
/*$usrf_cat   = $rws['id_cat'];
$usrf_coords= $rws['coords'];
$usrf_img   = $rws['img'];



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
                                        <td class="testob">Tipologia :</td><td><input type="text" name="usrf_info" value="<?= $usrf_info?>" class="large"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Gpx :</td><td><input type="text" name="usrf_gpx" value="<?= $usrf_gpx?>" class="large"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Link Gpx :</td><td><input type="text" name="usrf_gpxl" value="<?= $usrf_gpxl?>" class="large"  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Mappa:</td><td>
                                            <input type="text" name="usrf_map" value="<?=$usrf_map?>"  class="large"   />
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
    
    <div class="spessore"></div>
            
        
        <div class="titolo" style="text-align:left">
            Immagini
        </div>
    
    <div class="box bordered" style="text-align:left">

        <?
        $sql = "SELECT * FROM guide_immagini WHERE id_rel=$idws ORDER BY ordine, id";
        $a_imgs = $mydb->DoSelect($sql);
        ?>
        
                   
                             <table cellspacing="12" cellpadding="4" border="0" class="tblForm">
                                 
                                 
                                 <? 
                                 $ord = 0;
                                 foreach($a_imgs as $k => $r)
                                 {
                                 $img = $r['immagine'];  
                                 $ord += 10;
                                 $sql = "UPDATE itinerari_immagini SET ordine=$ord WHERE id=".$r['id'];
                                 $mydb->ExecSql($sql);
                                 ?>
                                   <tr>
                                        <td class="testob">
                                            <img style="max-width:220px;max-height: 220px" src="<?=$img?>" alt="" />
                                        </td>
                                        <td style="border-left:solid 1px silver" valign="top">
                                            <? if($k==0){?>Immagine principale<?}?>
                                        </td>
                                    </tr>
                                <? } ?>    
                                   
                                </table>
                                            

            

    </div>

       
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