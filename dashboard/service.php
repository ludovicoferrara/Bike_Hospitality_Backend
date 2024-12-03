<?
extract($_REQUEST);
$log = "";
$skiplog = false;

 switch($_SRV){
 	
 case "getArea": {
 	
 	echo Get_TXTArea($area,$language);
	
} break;

  
  case "uploadimg":  {
  	
  	include $_main_dir."sql_medianodb.php";
  	
  	?>
  	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" dir="ltr">
<head></head>
<body onload="Continua('<?=$esito?>')">
<script type="text/javascript">

function Continua(esito){
	
	parent.document.frmins.tmp.value=esito;
	parent.document.frmins.submit();
	
}

</script>

</body>
 </html> 	
  	<?
  	
  	
  }break;
  
  case "sendemail":  {
  	
  	include $_main_dir."sendemail.php";
  	
  	?>
  	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" dir="ltr">
<head></head>
<body onload="Continua('<?=$esito?>')">
<script type="text/javascript">

function Continua(esito){
	
	parent.document.frmins.tmp.value=esito;
	parent.document.frmins.submit();
	
}

</script>

</body>
 </html> 	
  	<?
  	
  	
  }break;
  
  case "hello": {
  	echo "ciao";
  } break;
  
  case "getTipiAree": {
  	
  	if($container!="float") $sql  = "SELECT id_tipoaree, des, sigla FROM $tbl_tipoaree WHERE container = '*' OR container LIKE '%$container%'";
  	else $sql  = "SELECT id_tipoaree, des, sigla FROM t_tipoaree WHERE container = 'float' ORDER BY ordine";
  	$a = $mydb->DoSelect($sql);
  	$i=0;
  	$res="";
  	
  	while($r=$a[$i++]){
  		
  		$res .= $r['sigla'].",".$r['des']."|";
  		
  	}
  	
  	echo $res;
  	
  } break;
   
 
  
  case "ajaxuserupload": case "ajaxUserFileUpload": {
  	
  	include "doajaxuserfileupload.php";
  	
  } break;
  
   case "ajaxFileupload": {
  	//carica un files in /files
  	include "doajaxfileupload.php";
  	
  } break;
  
   case "ajUserFileUpload": {
   	
   	$fileToUpload = 'fileToUpload';
   	
   	if(!is_dir($path_network_hdd.$id_utente."/")){
   		
   		mkdir($path_network_hdd.$id_utente."/");
   		chmod($path_network_hdd.$id_utente."/", 0777);
   		
   	}
   	
   	move_uploaded_file($_FILES[$fileToUpload]['tmp_name'],$path_network_hdd.$id_utente."/".$_FILES[$fileToUpload]['name']);
   	
   	if($_addslashes==1) $command = addslashes($command);
   	
   	 	?>
  	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" dir="ltr">
<head></head>
<body onload="eval('<?=$command?>')">


</body>
 </html> 	
  	<?
   	
   } break;
   
   case "ajFrFileUpload": {
   	
   	$fileToUpload = 'fileToUpload';
        
        if(!isset($path) || $path="") $path = "tmp";
        $path = rtrim($path, "/")."/";
        
        $prefix="";
        if($session_id!="") $prefix = $session_id."__";

   	move_uploaded_file($_FILES[$fileToUpload]['tmp_name'],$path.$prefix.$_FILES[$fileToUpload]['name']);
   	
   ?><!DOCTYPE html">
<html>
<head></head>
<body onload="eval('<?=addslashes($command)?>')">

</body>
</html> 	
  	<?
   	
   } break;
   
 case "loadTmpUserFiles": {
     
    // if(!isset($tmpPath) || $tmpPath="") 
             $tmpPath = "tmp";
     $path = trim($tmpPath, "/")."/";
     
     $files = "";
     $prefix="";
     if($session_id!="") $prefix = $session_id."__";
        
     $dir_handle = opendir($path);
     
     			while ($file = readdir($dir_handle)) {
			
			    if($file!="." && $file!=".." && strstr($file,$prefix) ) {# && $file != "local.php" && !strstr($file, ".zip")
			    	
			    	$a = explode(".",$file);
			    	$af = explode("_",$a[0]);

			    		$files .= str_replace($prefix,"",$file).";";

			    }
			    
			}
			
			closedir($dir_handle);
     
     $files=rtrim($files,";");
        
?><!DOCTYPE html">
<html>
<head></head>
<body onload="top.loadTmpUserFilesDone('<?=$files?>')">

</body>
 </html> 	
  	<?   
     }
     
 case "delTmpUserFile": {
     
    // if(!isset($tmpPath) || $tmpPath="") 
             $tmpPath = "tmp";
     $path = trim($tmpPath, "/")."/";
     
     if($session_id!="") $f2del = $session_id."__".$f2del;
        
     unlink($path.$f2del);
       
?><!DOCTYPE html">
<html>
<head></head>
<body onload="eval('<?=addslashes($command)?>')">

</body>
 </html> 	
  	<?   
     }

 
 case "ajFileUpload":
 {
     $output_dir = $path_tmp;

     if(isset($_dest) && $_dest!="")
     {
         switch($_dest)
         {
             case "nwShare":
             {
                 $output_dir = $path_hdd_library;
                 if($dir!="") {
                     if(substr($output_dir,strlen($output_dir), 1)!="/") $output_dir .= "/";
                     $output_dir .= $dir."/";
                 }
                                  
             } break;
             
             case "userTmp":
             {
                 $output_dir = $path_tmp."/".$_idutente."/";
                 if(!is_dir($output_dir))
                 {
                     mkdir($output_dir,0777);
                     chmod($output_dir,0777);
                 }
                                                   
             } break;
         }
     }
              
        if(isset($_FILES[$fileFieldsName]))
        {
                $ret = array();

        //	This is for custom errors;	
        /*	$custom_error= array();
                $custom_error['jquery-upload-file-error']="File already exists";
                echo json_encode($custom_error);
                die();
        */
                $error =$_FILES[$fileFieldsName]["error"];
                //You need to handle  both cases
                //If Any browser does not support serializing of multiple files using FormData() 
                if(!is_array($_FILES[$fileFieldsName]["name"])) //single file
                {
                        $fileName = $_FILES[$fileFieldsName]["name"];
                        move_uploaded_file($_FILES[$fileFieldsName]["tmp_name"],$output_dir.$fileName);
                $ret[]= $fileName;
                }
                else  //Multiple files, file[]
                {
                  $fileCount = count($_FILES[$fileFieldsName]["name"]);
                  for($i=0; $i < $fileCount; $i++)
                  {
                        $fileName = $_FILES[$fileFieldsName]["name"][$i];
                        move_uploaded_file($_FILES[$fileFieldsName]["tmp_name"][$i],$output_dir.$fileName);
                        $ret[]= $fileName;
                  }

                }
            echo json_encode($ret);
    //        $log .= ob_get_contents();
   //ob_end_clean();
            $log .= serialize($ret);
         }
 } break;
 

case "getListFilesTemp": {
	
	$path = "$path_tmp/$MSID/";
	
	$a = myScandir($path);
	
	echo $res = join("|",$a);

} break;

case "getListFiles": {
	
	 
	
	$a = myScandir($path);
	
	echo $res = join("|",$a);
	
	
	
	
} break;

case "removeFilesTemp": {
	
	$path = "$path_tmp/$MSID/";
	
	if(is_file($path.$file)) unlink($path.$file);
	
	$a = myScandir($path);
	
	echo $res = join("|",$a);
	
} break;


case "removeFile": {
	
	
	
	if(is_file($path.$file)) unlink($path.$file);
	
	$a = myScandir($path);
	
	echo $res = join("|",$a);
	
	
	
	
} break;

case "browselib": {
	
	 ob_start();
     
	
	include $extincpath_hdd."admin/browselib.php";
	
	 $contents = ob_get_contents();
        ob_end_clean();
        
     echo $contents;
	
	
} break;

             case "generaPassword": {
                 
                 $p = generaPSW(8,12);
                 
                 echo $p;
                 
             } break;



 }

  if(is_file("service_custom.php")) include "service_custom.php";
 
 /**/
  if(!$skiplog)
  {
 $fname = "_log/srvslog.txt";
 $f=fopen($fname,"a");
 fputs($f,$_SRV." \n$log\n\r\n");
 fclose($f);
  }
?>