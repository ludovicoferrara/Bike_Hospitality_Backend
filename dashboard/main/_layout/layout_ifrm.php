<!DOCTYPE>
<html>
<head>

<title><? echo $_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="<?=$extincpath_http?>contents/common.js.php?t=2&frame=1"  charset="utf-8"></script>
<script type="text/javascript" src="<?=$extincpath_http?>contents/commonj.js.php?t=1"  charset="utf-8"></script>
<script type="text/javascript" src="index.php?_F2I=jscode&language=<?=$language?>&MSID=<?=$MSID?>&frame=<?=$frame?>"></script>

<script type="text/javascript" src="<?=$extincpath_http?>contents/jquery-3.2.1.min.js"  charset="utf-8"></script>
<script type="text/javascript" src="<?=$extincpath_http?>contents/jquery-ui.js"  charset="utf-8"></script>
<link rel="stylesheet" href="<?= $extincpath_http ?>contents/jquery-ui.css">


<style type="text/css" >@import "<?=$extincpath_http?>bs431/css/bootstrap.min.css";</style>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/-->
<script src="<?=$extincpath_http?>bs431/js/bootstrap.min.js" ></script>



<style type="text/css" >@import "<?=$urlbase?>main/contents/style.css?t=<?=time()?>";</style>
<style type="text/css" >@import "<?=$urlbase?>main/_themes/style.<?=$_tema?>.css?t=<?=time()?>";</style>
<style type="text/css" >@import "<?=$urlbase?>main/contents/stylecustom.css?t=<?=time()?>";</style>

<style type="text/css" media="screen">
#container_f
{
    width: 100%;
    /*height: 100%;*/
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
#loading
{
    margin-top:200px;
}

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
if($sz=="90") include "main/admin/preview.php";

    


	
?>
<iframe frameborder="0" width="100" height="0" src="blank.html"  name="ifrservice"></iframe>

<form name="frmmenu" action="<? echo $action; ?>" method="post">
  
<input type="hidden" name="id" value="">
<input type="hidden" name="sezione" value="<? echo $sz; ?>">
<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
<input type="hidden" name="params" value="">
<input type="hidden" name="sezto"     value="<? echo $sz ?>">
<input type="hidden" name="azione" value="">
<input type="hidden" name="frame" value="<? echo $frame; ?>">
<input type="hidden" name="toreload" value="">

</form>



<div id="main_overlay" style="display:none">
    <div id="loading" style="display:none"><img src="main/contents/immagini/loading.gif" /></div>
    <div id="overlay" onclick="close_()" ></div>
    <div id="cnt_overlay" style="display:none">
        <p id="titleframe" class="titolo"></p>
        <p id="closeframe"><a href="javascript:close_()" class="ev"><?=$lang['chiudi']?></a></p>
        <p style="clear:both"></p>
        <iframe frameborder="0" width="900" height="540" src="blank.php" style="background-color:white;" name="overlayframe" id="overlayframe"></iframe>
    </div>
</div>

<form name="frmmenu2" id="frmmenu2"  action="<? echo $action; ?>" method="post" target="overlayframe">
  
    <input type="hidden" name="id" value="">
    <input type="hidden" name="sezione" value="<? echo $sz; ?>">
	<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
	<input type="hidden" name="params" value="">
	<input type="hidden" name="tmp" value="">
	<input type="hidden" name="frame" value="1">
	
</form>

</div>
</body>
</html>