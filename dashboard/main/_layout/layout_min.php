<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script  type="text/javascript" src="<?=$extincpath_http?>contents/common.js.php?t=<?=time()?>"></script>
<? if($_virtual!='1'){ ?>
<style type="text/css" media="screen">@import "main/contents/style.css";</style>
<style type="text/css" media="screen">@import "main/contents/styletxt.css";</style>
<? } ?>
<style type="text/css" media="screen">
#container_f
	{
	width: 100%;
	height: 100%;
	
	position: relative;
	top: 0px;
	 
        margin-top: 0px;
	margin: 0px auto;   /*centra negli altri browsers*/
        text-align: left;   /*ripristina l' allineamento*/
	padding: 0px;
	}
body{
background-image:none;	
background-color: white;
}

 
</style>
</head>
<body>

<div id="container_f" >
<? 

if($content!="") include $content; 

?>
</div>
 

<form name="frmmenu" action="<? echo $action; ?>" method="post">
  
    <input type="hidden" name="id" value="">
    <input type="hidden" name="sezione" value="<? echo $sz; ?>">
	<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
	<input type="hidden" name="params" value="">
	
		<?
        /* Trasformare in variabili di stato */
        ?>
		<input type="hidden" name="sezto"     value="<? echo $sz ?>">
        <input type="hidden" name="azione" value="">

        <?
        /* Variabili di appoggio non critiche */
        ?>
		
	 
</form>


</body>
</html>