<?

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="it" dir="ltr"  xmlns="http://www.w3.org/1999/xhtml">

<head>
<?
include "layout_header.inc.php";
?>

<style type="text/css" >@import "<?=$urlbase?>main/contents/style.css?t=1";</style>
<style type="text/css" >@import "<?=$urlbase?>main/contents/styletxt.css";</style>

</head>
<?



include "./main/contents/menu0.php";

 

?>
<body>

<div id="container" align="center">

   
    
    <div id="top">

		<div class="content"> 
	
	     	<div id="logo" ><a href="<?=$urlbase?>" title="<?=$_title?>" ><? WriteMedia("logo",$language)?></a></div>
			    
	       <div id="toolbar">
	  
		     
		     	
		   </div>
		     
	
		</div>
  	</div>
	
	 
	   
	 <? 
	if($sz==100){
	?>
		 <div id="contents" style="top:0px">
	<?
	} else {
		?>
		 <div id="contents">
	<?
		
	}
	
	 # <div id="contents1" >
	#<!--    <div id="contents2" align="center">  -->
	 
        if(!isset($content)) $content = $incpath."contents/404.php";
        include $content; 
      
     #	
  #</div>  
  # <!--/div>-->
    ?>
		<div class="spessore" ></div>
	   </div><!-- qui finisce contents -->	



</div><!-- qui finisce container-->	


<?	
include "layout_common.inc.php"; 
?>

</body>
</html>