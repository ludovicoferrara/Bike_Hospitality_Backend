<!DOCTYPE>
<html>
<head>

<title><? echo $_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="<?=$extincpath_http?>contents/common.js.php?t=2&frame=1"  charset="utf-8"></script>
<script type="text/javascript" src="<?=$extincpath_http?>contents/commonj.js.php?t=1"  charset="utf-8"></script>
<script type="text/javascript" src="index.php?_F2I=jscode&language=<?=$language?>&MSID=<?=$MSID?>&frame=<?=$frame?>"></script>



<script type="text/javascript" src="<?=$extincpath_http?>contents/jquery-3.2.1.min.js"  charset="utf-8"></script>


<style type="text/css" >@import "<?=$extincpath_http?>contents/bootstrap.min.css";</style>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/-->
<script src="<?=$extincpath_http?>contents/bootstrap.min.js" ></script>



<style type="text/css" media="screen">@import "main/contents/style.css";</style>
<style type="text/css" media="screen">@import "main/contents/styletxt.css";</style>
<style type="text/css" media="screen">@import "main/contents/stylec.css?t=<?=time()?>";</style>

<style type="text/css" media="screen">
#container_f
	{
	width: 100%;
	height: 100%;
	
	position: relative;
	top: 0px;
	font-size:14px;
        margin-top: 0px;
	margin: 0px auto;   /*centra negli altri browsers*/
        text-align: left;   /*ripristina l' allineamento*/
	z-index: 2;
	padding: 0px;
	}
body{
background-image:none;	
background-color: white;
}
<? 
/*
if($sz==200){ ?>
 #scrollbar_container{
   position: absolute;
	width: 1036px;
	left: 8px;
	top: 10px;
	height: 610px;
 }
 
 #scrollbar_content {
	width: 1028px;
	height: 610px;
  
 	position: absolute;
	left: 0px;
	top: 0px; 
	overflow: hidden;
}
 #scrollbar_track, #scrollbar_track2 {  
      position:absolute;  
      top:0px;  
     
      height:100%;  
      width:10px;  
      background-color:transparent;  
      cursor:move;  
		right: 12px;
		z-index: 10;
  } 
   #scrollbar_track2 {  
	right: 0px;
	}
   
  #scrollbar_handle {  
      width:10px;  
      background-color:  #676666;  
      cursor:move;  
      -moz-border-radius: 5px;  
     -webkit-border-radius: 5px;  
      opacity:0.3;  
      -moz-opacity:0.3;  
		
		filter:alpha(opacity=30);
   opacity: 0.3;
	
	border: solid;
	border-color: #BABABA;
	border-width: 1px;
  } 
  <? }
 *  
 */?>
  .box3 {
  
  margin: 0px
  }
  
  .button1 p {
  padding-top:12px
  }
</style>


</head>
<body>

<div id="container_f" >
<? 
$containers = "center";

if($sz=="100") include "main/contents/form.php";
    
     /*
      * 
    elseif($sz=="110") include "main/contents/ricercafull.php";
    elseif($sz=="120") include "main/contents/news.php";
    elseif ($sz=="1000") include "main/contents/schedaws.php";
    elseif ($sz=="1900") include "main/contents/account.php";
    
	#include $content; 
     * 
     */
    if($sz=="90") include "main/admin/preview.php";


	
?>
<iframe frameborder="0" width="100" height="0" src="blank.html"  name="service"></iframe>

<form name="frmmenu" action="<? echo $action; ?>" method="post">
  
<input type="hidden" name="id" value="">
<input type="hidden" name="sezione" value="<? echo $sz; ?>">
<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
<input type="hidden" name="strparam" value="<? echo $strparam; ?>">
<input type="hidden" name="sezto"     value="<? echo $sz ?>">
<input type="hidden" name="azione" value="">
<input type="hidden" name="frame" value="<? echo $frame; ?>">

</form>



<div id="main_overlay" style="display:none">
    <div id="loading" style="display:none"><img src="main/contents/immagini/loading.gif" /></div>
    <div id="overlay" onclick="close_()" ></div>
    <div id="cnt_overlay" style="display:none">
        <p id="titleframe" class="subtitolo"></p>
        <p id="closeframe"><a href="javascript:close_()" class="ev"><?=$lang['chiudi']?></a></p>
        <p style="clear:both"></p>
        <iframe frameborder="0" width="900" height="540" src="blank.php" style="background-color:white;" name="overlayframe" id="overlayframe"></iframe>
    </div>
</div>

<form name="frmmenu2" id="frmmenu2"  action="<? echo $action; ?>" method="post" target="overlayframe">
  
    <input type="hidden" name="id" value="">
    <input type="hidden" name="sezione" value="<? echo $sz; ?>">
	<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
	<input type="hidden" name="strparam" value="<? echo $strparam; ?>">
	<input type="hidden" name="tmp" value="">
	<input type="hidden" name="frame" value="1">
	
</form>

</div>
</body>
</html>