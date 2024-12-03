<?
$errmsg = "";

if($azione=="up")
{
    $sql = "UPDATE itinerari_immagini SET ordine = ordine-15 WHERE id=$idimg";
    $mydbNW->ExecSql($sql);
}
if($azione=="down")
{
    $sql = "UPDATE itinerari_immagini SET ordine = ordine+15 WHERE id=$idimg";
    $mydbNW->ExecSql($sql);
}

if($azione=="save2")
{
    
    $info = myencodeTxt($usrf_info);
    
    $sql = "UPDATE itinerari SET info='$info', gpx='$usrf_gpx', linkgpx='$usrf_gpxl', map='$usrf_map' WHERE  id=$idws";
    $mydbNW->ExecSql($sql);
    
    if(isset($_FILES["fileToUpload1"]["name"]))
    {

        $path = $path_userdata."itinerari/".$idws."/";
        if(!is_dir($path) )
        {
            mkdir($path,0777);
            chmod($path,0777);
        }

        $target_dir = $path;

        $imgname = $_FILES["fileToUpload1"]["name"];
        #$target_file = $target_dir .  $imgname;

        #move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file);
        $res = upload_img2($_FILES["fileToUpload1"]["tmp_name"],$_FILES["fileToUpload1"]["name"],$target_dir,"");
        $imgname = $res[0];
        $target_file = $target_dir .  $imgname;

        if(is_file($target_file) )
        {
            $lnk = $urlcrm."userdata/itinerari/$idws/".$imgname;
            $sql = "UPDATE itinerari SET gpx='$lnk' WHERE  id=$idws";
           $mydbNW->ExecSql($sql);

        }
    } 
    if(isset($_FILES["fileToUpload2"]["name"]))
    {

        $path = $path_userdata."itinerari/".$idws."/";
        if(!is_dir($path) )
        {
            mkdir($path,0777);
            chmod($path,0777);
        }

        $target_dir = $path;

        $imgname = $_FILES["fileToUpload2"]["name"];
        #$target_file = $target_dir .  $imgname;

        #move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file);
        $res = upload_img2($_FILES["fileToUpload2"]["tmp_name"],$_FILES["fileToUpload2"]["name"],$target_dir,"");
        $imgname = $res[0];
        $target_file = $target_dir .  $imgname;

        if(is_file($target_file) )
        {
            $lnk = $urlcrm."userdata/itinerari/$idws/".$imgname;
            $sql = "UPDATE itinerari SET linkgpx='$lnk' WHERE  id=$idws";
           $mydbNW->ExecSql($sql);

        }
    } 
    
    if(isset($_FILES["fileToUpload3"]["name"]))
    {

        $path = $path_userdata."itinerari/".$idws."/";
        if(!is_dir($path) )
        {
            mkdir($path,0777);
            chmod($path,0777);
        }

        $target_dir = $path;

        $imgname = $_FILES["fileToUpload3"]["name"];
        #$target_file = $target_dir .  $imgname;

        #move_uploaded_file($_FILES["fileToUpload3"]["tmp_name"], $target_file);
        $res = upload_img2($_FILES["fileToUpload3"]["tmp_name"],$_FILES["fileToUpload3"]["name"],$target_dir,"");
        $imgname = $res[0];
        $target_file = $target_dir .  $imgname;

        if(is_file($target_file) )
        {
            $lnk = $urlcrm."userdata/itinerari/$idws/".$imgname;
            $sql = "UPDATE itinerari SET map='$lnk' WHERE  id=$idws";
           $mydbNW->ExecSql($sql);

        }
    } 

 if(isset($_FILES["fileToUpload"]["name"]))
 {
     
     $path = $path_userdata."itinerari/".$idws."/";
     if(!is_dir($path) )
     {
         mkdir($path,0777);
         chmod($path,0777);
     }

 
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
     $url = $http_userdata."itinerari/".$idws."/".$imgname;
    $sql = "INSERT INTO itinerari_immagini (id_rel, immagine) VALUES ($idws, '$url')";
    $mydbNW->ExecSql($sql);

 }
 }
 
 if($url2add!="")
 {
         $sql = "INSERT INTO itinerari_immagini (id_rel, immagine) VALUES ($idws, '$url2add')";
         $mydbNW->ExecSql($sql);
 }
 
} 

if($azione=="delImg")
{
    $sql = "SELECT * FROM itinerari_immagini WHERE id=$idimg";
    $mydbNW->DoSelect($sql);
    $rtmp = $mydbNW->GetRow();
    $img = $rtmp['immagine'];
    if(strstr($img,$http_userdata))
    {
        $filename = str_replace($http_userdata, "", $img);
        $fullpath = $path_userdata.$filename;
        #echo "DELETE $fullpath";
        unlink($fullpath);
    } else {
        
    }
    $sql = "DELETE FROM itinerari_immagini WHERE id=$idimg";
    $mydbNW->ExecSql($sql);
}


$sql = "SELECT ti.* FROM itinerari as ti WHERE ti.id=$id";
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

        
                   
                             <table cellspacing="4" cellpadding="4" border="0" class="tblForm">
                                 
                                 
                                 
                                   <tr>
                                        <td class="testob">Tipologia :</td><td><input type="text" name="usrf_info" value="<?= $usrf_info?>" class="large"  /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Altimetria (link):</td>
                                        <td>
                                            <input type="text" name="usrf_gpx" value="<?= $usrf_gpx?>" class="large"  /> 
                                            Carica file: <input type="file" name="fileToUpload1"  /> 
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="testob">Gpx (link):</td>
                                        <td>
                                            <input type="text" name="usrf_gpxl" value="<?= $usrf_gpxl?>" class="large"  />
                                            Carica file: <input type="file" name="fileToUpload2"  /> 
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">Mappa:</td><td>
                                            <input type="text" name="usrf_map" value="<?=$usrf_map?>"  class="large"   />
                                            Carica file: <input type="file" name="fileToUpload3"  /> 
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
        $sql = "SELECT * FROM itinerari_immagini WHERE id_rel=$idws ORDER BY ordine, id";
        $a_imgs = $mydb->DoSelect($sql);
        ?>
        
                   
                             <table cellspacing="12" cellpadding="4" border="0" class="tblForm">
                                 <tr>
                                        <td class="testob">
                                          Aggiungi immagine
                                        </td>
                                        
                                        <td>
                                            Carica file: <input type="file" name="fileToUpload"  /> 
                                            <img src="main/contents/icone/right-arrow-1.png" class="ico24 imgcliccabile" onclick="checkdata()" align="absmiddle" />
                                            <br/><br/>
                                            Inserisci url:  <input type="text" name="url2add" value=""  />
                                            <img src="main/contents/icone/right-arrow-1.png" class="ico24 imgcliccabile" onclick="checkdata()" align="absmiddle" />
                                        
                                        </td>
                                    </tr>
                                 
                                 <? 
                                 $ord = 0;
                                 foreach($a_imgs as $k => $r)
                                 {
                                 $img = $r['immagine'];  
                                 $ord += 10;
                                 $sql = "UPDATE itinerari_immagini SET ordine=$ord WHERE id=".$r['id'];
                                 $mydb->ExecSql($sql);
                                 $st = "";
                                 if($k%2==0) $st = "background:#efefef";
                                 ?>
                                   <tr style="<?=$st?>">
                                        <td class="testob">
                                            <img style="max-width:220px;max-height: 220px" src="<?=$img?>" alt="" />
                                        </td>
                                        <td style="border-left:solid 1px silver" valign="top">
                                            <? if($k==0){?>
                                            <div class="fleft">Immagine principale</div>
                                            <div class="clearboth"></div>    
                                            <?}?>
                                            <? if($k>0){?>
                                            <img src="main/contents/icone/up-arrow.png" class="ico24 imgcliccabile fleft" onclick="up('<?=$r['id']?>')" />
                                            <div class="clearboth"></div>
                                            <?}?>
                                            <? if($k<count($a_imgs)-1){?>
                                            <img src="main/contents/icone/down-arrow.png" class="ico24 imgcliccabile fleft" onclick="down('<?=$r['id']?>')" />
                                            <?}?>
                                            <img src="main/contents/icone/cancel.png" class="ico24 imgcliccabile fright" onclick="delImg('<?=$r['id']?>')" align="absmiddle" />
                                            
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
            <input type="hidden" name="idimg"  value="">
            
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

function delImg(id)
{
    if(confirm('Confermi la rimozione dell\'immagine?'))
    {
    document.frmins.azione.value='delImg';
    document.frmins.idimg.value=id;
    waitpage();
    document.frmins.submit();
    }
}

function up(id)
{
    document.frmins.azione.value='up';
    document.frmins.idimg.value=id;
    waitpage();
    document.frmins.submit();
}
function down(id)
{
    document.frmins.azione.value='down';
    document.frmins.idimg.value=id;
    waitpage();
    document.frmins.submit();
}

</script>