<?php

if($azione=="delete")
{
    $sql = "DELETE FROM t_categorie WHERE id=$id";
    $mydb->ExecSql($sql);
}

if($azione=="inscat")
{
     $a_usrparams = find_post("usr_");
     $usrparams = serialize($a_usrparams); 
    
         
    foreach ($a_usrparams as $k => $v){
    	
    	#echo $k. " => ". $v."<br/>";
    	if($k!="usr_file") $a_usrparams[$k] = myencodeTxt($v);
    	
    }
    extract($a_usrparams);
    /*
    $newfile = "";
    
    if(isset($_FILES["usr_file"])){
				   $userfilenew_name    = $_FILES["usr_file"]["name"];
				   $userfilenew_tmpname = $_FILES["usr_file"]["tmp_name"];
                                   
                                   $a = upload_img2($userfilenew_tmpname,$userfilenew_name,$path."/","");
				   $newfile=$a[0];
				}
	*/	
    
    
    $sql = "INSERT INTO t_categorie (titolo, data_ins ) VALUES (";
    $sql .= "'$usr_cat',  NOW()) ";
    		
    $mydb->ExecSql($sql);
    //echo $sql;
    $idu = $mydb->LastInsertedId;
    
  if($idu>1 ){

                                        $errmsg = "Il record &egrave; stato inserito!";
        }				
    
 
}

if($azione=="save3")
{
    $txt  = addslashes($testoEmail);
    $subj = addslashes($soggettoEmail);
    
    $esitoOk = addslashes($esitoOk);
    $esitoKo = addslashes($esitoKo);
    
    setT_VAR("testoEmail", $txt);
    setT_VAR("soggettoEmail", $subj);
    
    setT_VAR("esitoOk", $esitoOk);
    setT_VAR("esitoKo", $esitoKo);
   
}

?>
<script>

function editCat(id){
	
	document.frmmenu.sezione.value='impostazioni,3';
        document.frmmenu.id.value=id;
	document.frmmenu.submit();
	
}

function delCat(id){
	
	//document.frmins.sezione.value='impostazioni,2';
        document.frmins.azione.value='delete';
        document.frmins.id.value=id;
        waitpage();
	document.frmins.submit();
	
}


function save3()
{
        document.frmins.azione.value='save3';
        waitpage();
	document.frmins.submit();
    
}    
    
</script>
<?
if($tab==2)
{
     if($isubsezione==0 )
    {
         $cond = "1";
/*
if($search_str!="")
{
$cond = " AND (nome LIKE '%$search_str%' OR cognome LIKE '%$search_str%' OR email LIKE '%$search_str%') ";
}
*/
$sql = "SELECT COUNT(*) FROM t_categorie WHERE  $cond";
$mydb->DoSelect($sql);
$rcount = $mydb->GetRow();

$ntot = $rcount[0];
$ntotpage = floor($ntot/$nxpage);
if($ntotpage != $ntot/$nxpage) $ntotpage++;
	
$nn = $npage*$nxpage;


$sql = "SELECT * FROM t_categorie WHERE  $cond ORDER BY titolo ASC ";# LIMIT $nn, $nxpage";
$a_cdc = $mydb->DoSelect($sql);
 ?>
        <form name="frmins" method="post" action="<? echo $action ?>" >
        
        <div>
            <a href="?MSID=<?=$MSID?>&tab=2&sz=impostazioni,4"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi Categoria</a>
        </div>


            
        <div class="spessore" style="height:20px"></div>
     <? /*        
<div style="text-align: left">
Visualizza <input type="text" name="nxpage" value="<?=$nxpage?>" class="lite mini" /> righe per pagina <img src="main/contents/immagini/button1.jpg" class="ico24 cliccabile rounded" align="absmiddle" onclick="document.frmins.submit()" /> 
</div> <div style="text-align: left;margin-top:4px">
Cerca per nome, cognome o email: <input type="text"  value="<?=$search_str?>" name="search_str" />
<img src="main/contents/immagini/button1.jpg" class="ico24 cliccabile rounded" align="absmiddle" onclick="document.frmins.submit()" /><br/>

</div>      
           
   <div class="admtitolo" align="left">
   <? 
   $pagmode = '1';$frm = "document.frmins";
   $href0 = "?MSID=$MSID&sz=utenti&ord=$ord&";
   
    include "paginazione.php"; 
   ?>	
   <div class="spessore" style="height:20px"></div>
   </div>       
*/ ?>            
        <table class="tablegrid3" cellpadding="6" cellspacing="0">
        <tr>
            <th></th><th>Categoria</th><th></th>
        </tr>
        <?
        $i=0;
        
        while($r=$a_cdc[$i++])
        {
            $nome    = mydecodeTxt($r['titolo']);
            $data_reg = Date_fromdbX($r['data_ins']);
            $idc = $r['id'];
            
            $cancellabile = true;

            $sql = "SELECT COUNT(*) FROM t_prodotti WHERE id_cat=$idc";
            $mydb->DoSelect($sql);
            $rtmp=$mydb->GetRow();
            
            if($rtmp[0]>0) $cancellabile=false;

        ?>
        <tr>
            <td><?=$i+$nn?></td>
            <td><?=$nome?></td>
                        
            <td style="min-width:260px">
                <a href="javascript:editCat(<?=$idc?>)"><img src="main/contents/icone/edit-icon.png" class="ico20 fleft imgcliccabile" /></a>
            <? if($cancellabile){ ?>
                <a href="javascript:delCat(<?=$idc?>)"><img src="main/contents/icone/cancel.png" class="ico20 fleft imgcliccabile fright" /></a>
            <? } ?>
            </td>
        </tr>    
        <?
            
        }
        ?>
        </table>
        
                
        <input type="hidden" name="MSID" value="<?=$MSID?>" />
        <input type="hidden" name="sz" value="<?=$sezione?>" />
        <input type="hidden" name="azione" value="" />
        <input type="hidden" name="id" value="" />
        
        <input type="hidden" name="tab" value="<?=$tab?>" />
        <input type="hidden" name="tab2" value="<?=$tab2?>" />   
        </form>
        
        <? } elseif($isubsezione==3){ ?>
        
        <div class="rbutton2" onclick="back()"><div>Indietro</div></div>
        
        <div class="spessore"></div>
        
        <?
        include "categoria.php";
        ?>
        
        <? } elseif($isubsezione==4){ ?>

                <div class="rbutton2" onclick="back()"><div>Indietro</div></div>

                <div class="spessore"></div>

                <?
                include "nuovacat.php";
                ?>


        <? } ?>
        
        
<? } elseif($tab==1) { ?>
<?
 
?>
<?  } elseif($tab==3) { ?>
<?
 $testoEmail = getT_VAR("testoEmail");
 $soggettoEmail = getT_VAR("soggettoEmail");
 $esitoOk = getT_VAR("esitoOk");
 $esitoKo = getT_VAR("esitoKo");
?>
<script src="https://www..org/admin/tinymce571/js/tinymce/tinymce.min.js" ></script>
 <!--script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
    <script> 
        tinymce.init({
            selector:'textarea',

   plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | image code | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat  | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',

            /* without images_upload_url set, Upload tab won't show up*/
            images_upload_url: 'tinymceupload.php',
 <?     /*        images_upload_handler: function (blobInfo, success, failure) {
         setTimeout(function () {
              /* no matter what you upload, we will turn it into TinyMCE logo :)* /
              //success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
            }, 2000);
  }*/
 if(is_file($baseDir."main/tinymce/imglist.js"))
 {
     echo get_include_contents($baseDir."main/tinymce/imglist.js");
 }
            ?>
        });
    </script>
    <form id="frmins" name="frmins" action="<? echo $action; ?>" method="post" >


        <div class="box boxw bordered" style="text-align:left">
            
            <div class="titolo">
                Configurazione risposta automatica: <span class="testo">(valori predefiniti)</span>
            </div>
            
            <div class="spessore"></div>
            <div class="spessore"></div>
            

                <table class="tablegrid3" cellpadding="6" cellspacing="0">
                                        <tr>
                                            <th colspan="5">Soggetto email risposta automatica</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><input type="text" name="soggettoEmail" value="<?=$soggettoEmail?>" style="width:560px"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Testo email risposta automatica</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><textarea name="testoEmail" style="width:640px;height:480px"><?=$testoEmail?></textarea></td>
                                        </tr>
                </table>
            
            
            <div class="spessore"></div>
            <div class="spessore"></div>
            
           <div class="titolo">
                Messaggi (esito registrazione): 
            </div>
            
            <div class="spessore"></div>
            <div class="spessore"></div>
            

                <table class="tablegrid3" cellpadding="6" cellspacing="0">
                                        <tr>
                                            <th colspan="5">Esito positivo</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><input type="text" name="esitoOk" value="<?=$esitoOk?>" style="width:560px"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Esito negativo</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><input type="text" name="esitoKo" value="<?=$esitoKo?>" style="width:560px"></td>
                                        </tr>
                </table>
            
             <input type="image" name="submit" src="./main/contents/immagini/trans.gif" style="width:0px;height:0px;border: 0px none;padding:0px;" />
            <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
            <input type="hidden" name="id"  value="<? echo $id ?>">
           <input type="hidden" name="sz"  value="impostazioni">
            <input type="hidden" name="tab"  value="3">
            <input type="hidden" name="azione"  value="">
            
                <div class="box boxw bordered">
          
        <table cellspacing="0" cellpadding="4" border="0">

           <tr>
            <td colspan="2" align="center">
                    <div id="login_entra" class="button1" onclick="save3()"><div>Salva</div></div>
            </td>

           </tr>  
        </table>
    </div> 
                      
        </div>
            
        </form>
<? } ?>       
