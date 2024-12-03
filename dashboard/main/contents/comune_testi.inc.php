<?
$errmsg = "";

if($azione=="save3")
{
    foreach($usrf_descriz as $k => $descriz)
    {
        $l = $usrf_lang[$k];
        $testo = myencodeTxt($descriz);
        $sql = "UPDATE comuni_testi SET testo='$testo' WHERE  id_rel=$id AND lang='$l'";
        $mydbNW->ExecSql($sql);
    }

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
    $sql = "UPDATE $tbl_aziende SET logo='$imgname' WHERE id_utentihs=$ida";
    #$mydbG->ExecSql($sql);

 }
 }
 
} 

$sql = "SELECT tc.id as idc, tt.* FROM comuni as tc, comuni_testi as tt  WHERE tc.id=$id AND tc.id=tt.id_rel";
$a_des = $mydbNW->DoSelect($sql);

if(count($a_des)==0)
{
    foreach($_vlanguage as $k => $v){
		    	$sql = "INSERT INTO comuni_testi (id_rel, lang) VALUES ($id, '$v')";
                        $mydbNW->ExecSql($sql);
                        
    	}
        
    $sql = "SELECT tc.id as idc, tt.* FROM comuni as tc, comuni_testi as tt  WHERE tc.id=$id AND tc.id=tt.id_rel";
    $a_des = $mydbNW->DoSelect($sql);
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
            Descrizione
        </div>

     
        <div class="box bordered" style="text-align:left">

        
                   
                             <table cellspacing="0" cellpadding="4" border="0" class="tblForm">
                                 
                                 <?
                                 foreach($a_des as $k => $rd)
                                 {
                                     #$idws       = $rd['idws'];
                                     $usrf_descriz = mydecodeTxt($rd['testo']);
                                     $l = $rd['lang'];
                                
                                ?> 
                                   <tr>
                                    <td class="testob">Descrizione (<?=$l?>):</td>
                                    <td><textarea name="usrf_descriz[]" style="width:960px;height:480px;overflow-y:auto"><?=$usrf_descriz?></textarea>
                                    <input type="hidden" name="usrf_lang[]"  value="<? echo $l ?>">
                                    </td>
                                    </tr> 
                                   
                                    <? 
                                 }
                                    /*
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

                                    <tr>
                                        <td class="testob">
                                            Email:<br>
                                            <!--<span class="testosm">Email per l'invio delle notifiche</span>-->
                                        </td>
                                        <td><input type="text" name="usrf_email" value="<?=$usrf_email?>" /></td>
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
            <input type="hidden" name="idc"  value="<?=$idc?>">
            
        </form>

<script src="<?=$extincpath_http?>contents/tinymce662/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
     
     
tinyMCE.init({
    selector: "textarea",
    <?/*
    //theme: "modern",
    //plugins: [
    //    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
    //    "searchreplace wordcount visualblocks visualchars code fullscreen",
    //    "insertdatetime media nonbreaking save table contextmenu directionality",
    //    "emoticons template paste textcolor colorpicker textpattern"// imagetools
    //],
toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect fontsize",
     
     *      */
    ?>
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
  
     toolbar1: "fullscreen preview | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styles blocks fontfamily fontsize",
     toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor code |  forecolor backcolor",//image media insertdatetime preview |
     toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | ltr rtl | visualchars visualblocks nonbreaking  pagebreak restoredraft | print ",//template
    image_advtab: true,
     resize: "both",
    convert_urls: false,
    // menubar: false,
    toolbar_items_size: 'small',
  
  font_size_formats: '10px 11px 12px 14px 16px 18px 20px 24px 26px 36pt 46px',
  //font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',
  font_family_formats: 'EB Garamond=EB Garamond; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
  block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4',
  document_base_url: '<?=$urlbase?>',
   allow_unsafe_link_target: true,
   //extended_valid_elements: '*[*]',
   extended_valid_elements: 'input[class|name|value|style|onclick|type|size|id]',


 content_css: [
    //'https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,700;1,400&display=swap',
    //'https://www.tao-shan.com/style.css?t=<?=time()?>',
    //'https://www.tao-shan.com/styletxt.css?t=<?=time()?>'
    ],
  //  importcss_file_filter: '/styletxt.css',
        
    content_style: [ 
        "p { line-height:110%;margin:3px;}",
        ".titolo { font-weight: bold; font-size:24px; }"
     ],
     

    <?
    //echo $image_list;
    /* "body { line-height:110%;margin:3px;}",
  style_formats: [
    {title: 'testo', selector: 'td, span, p, div', classes: 'testo'},
    {title: 'titolo', selector: 'td, span, p, div', classes: 'titolo'},
    {title: 'titolo grande', selector: 'td, span, p, div', classes: 'titolo_big'}
    ],
    style_formats_merge: true,
		
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
     * */
    ?>
     
});
   

function checkdata(){
	
	res = convalidaForm3(document.frmins,'<?=$language?>','evi');

	if(res)
        {

        document.frmins.azione.value='save3';
        waitpage();
        document.frmins.submit();
	
	}
}

</script>