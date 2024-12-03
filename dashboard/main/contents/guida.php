<?
$errmsg = "";

if($azione=="ins" || $azione=="save")
{
$nome = myencodeTxt($usrf_nome);
$cognome = myencodeTxt($usrf_cognome);
$localita = myencodeTxt($usrf_localita);
#$note = myencodeTxt($usrf_note);
$strsettore = "";
if(is_array($settore))
    $strsettore = join("|",$settore);

$strlingue = "";
if(is_array($lingue))
    $strlingue = join("|",$lingue);
}
if($azione=="save")
{

$sql = "UPDATE guide SET nome='$nome',cognome='$cognome', localita='$localita', comune='$usrf_comune',provincia='$usrf_provincia',";
$sql .= "telefono='$usrf_telefono', email='$usrf_email', settori='$strsettore', lingue='$strlingue'  WHERE id=$id ";
$mydb->ExecSql($sql);

 if(isset($_FILES["fileToUpload"]["name"]))
 {
 
 $target_dir = $path_userdata."guide/$id/";
 if(!is_dir($target_dir))
 {
     mkdir($target_dir);
     chmod($target_dir,0777);
 }
 #$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
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
    $sql = "UPDATE guide SET foto='$imgname' WHERE id=$id";
    $mydb->ExecSql($sql);
    #}

 }
 }
 
} 
if($azione=="ins")
{
$sql = "INSERT INTO guide (nome, cognome, localita, data_ins, id_circuito, comune, provincia, telefono, email, settori, lingue) VALUES ";
$sql .= "('$nome', '$cognome', '$localita', NOW(), $id_location, '$usrf_comune', '$usrf_provincia', '$usrf_telefono', '$usrf_email', '$strsettore', '$strlingue')";
$mydb->ExecSql($sql);

 $isubsezione = 2;
 $azto = "save";
 $id = $mydb->LastInsertedId;

} 


if($isubsezione==2)
{

$azto = "save";

$titlepag = "Scheda guida";

$sql = "SELECT tg.* FROM guide as tg WHERE tg.id=$id ";
$mydb->DoSelect($sql);
$ru2 = $mydb->GetRow();

$usrf_nome       = mydecodeTxt($ru2['nome']);
$usrf_cognome    = mydecodeTxt($ru2['cognome']);
$usrf_citta    = $ru2['comune'];
$usrf_telefono = $ru2['telefono'];
$usrf_localita     = mydecodeTxt($ru2['localita']);
#$usrf_note     = mydecodeTxt($ru2['note']);
$usrf_email    = $ru2['email'];
$usrf_prov     = $ru2['provincia'];
#$usrf_prov = getProvFromComune($usrf_citta);
$a_lingue  = [];
if($ru2['lingue']!="") $a_lingue  = explode("|",$ru2['lingue']);
$a_settori = [];
if($ru2['settori']!="") $a_settori = explode("|",$ru2['settori']);
$img = $ru2['foto'];

} elseif($isubsezione==4) {

$id = 0;

$azto = "ins";
    
$usrf_nome     = "";
$usrf_cognome  = "";
$usrf_citta    = "";
$usrf_localita = "";
if(empty($usrf_prov)) $usrf_prov     = "";
$usrf_telefono = "";
$usrf_note     = "";
$usrf_email    = "";

$a_lingue  = [];
$a_settori = [];

$img = "";
    
$titlepag = "Nuova guida";
}

$httppath = $http_userdata."guide/$id/";


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
                                        <td class="testob">Cognome :</td><td><input type="text" name="usrf_cognome" value="<?=$usrf_cognome?>"   /></td>
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
                                            <select name="usrf_provincia"  id="usrf_provincia"  onchange="loadComuni(this.value,'usrf_' )" >
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
                                    <td class="testob">Telefono:</td><td><input type="text" name="usrf_telefono" value="<?=$usrf_telefono?>"  /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="testob">
                                            Email:<br>
                                            
                                        </td>
                                        <td><input type="text" name="usrf_email" value="<?=$usrf_email?>" /></td>
                                    </tr>
                                    <tr>
                                        <td class="testob">
                                            Settori:<br>
                                            
                                        </td>
                                        <td>
                                            <ul class="elenco" >
                                                <li >
                                                    <input type="checkbox" name="settore[]" value="Cicloturismo" <? if(in_array("Cicloturismo", $a_settori)) echo "checked" ?> /> Cicloturismo
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="settore[]" value="MTB" <? if(in_array("MTB", $a_settori)) echo "checked" ?> /> MTB
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="settore[]" value="Bici da strada" <? if(in_array("Bici da strada", $a_settori)) echo "checked" ?> /> Bici da strada
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="settore[]" value="Gravel" <? if(in_array("Gravel", $a_settori)) echo "checked" ?> /> Gravel
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="settore[]" value="E-Bike" <? if(in_array("E-Bike", $a_settori)) echo "checked" ?> /> E-Bike
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                                                        <tr>
                                        <td class="testob">
                                            Lingue:<br>
                                            
                                        </td>
                                        <td>
                                            <ul class="elenco" >
                                                <li >
                                                    <input type="checkbox" name="lingue[]" value="it" <? if(in_array("it", $a_lingue)) echo "checked" ?> /> Italiano
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="lingue[]" value="en" <? if(in_array("en", $a_lingue)) echo "checked" ?> /> Inglese
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="lingue[]" value="es" <? if(in_array("es", $a_lingue)) echo "checked" ?> /> Spagnolo
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="lingue[]" value="fr" <? if(in_array("fr", $a_lingue)) echo "checked" ?> /> Francese
                                                </li>
                                                <li >
                                                    <input type="checkbox" name="lingue[]" value="de" <? if(in_array("de", $a_lingue)) echo "checked" ?> /> Tedesco
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!--
                                    <tr>
                                    <td class="testob">Note:</td>
                                    <td><textarea name="usrf_note"><?=$usrf_note?></textarea></td>
                                    </tr> 
                                    -->
                                    <tr>
                                    <td class="testob">
                                        Foto:
                                    <? 
                                    if($img!="")
                                    {
                                        $url = $img;
                                        
                                        if(!stristr($img,"http://") && !stristr($img,"https://"))
                                        {
                                          $url = $http_userdata."guide/$id/$img"; 
                                        }  
                                        ?>
                                       <br/><img src="<?=$url?>" style="max-width: 160px;max-height: 60px" />     
                                    <?}?>
                                    </td>
                                    <td><input type="file" name="fileToUpload"  /></td>
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