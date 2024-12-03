<!DOCTYPE html>
<html lang="it" dir="ltr"  xmlns="http://www.w3.org/1999/xhtml">

<head>
<?
include "layout_header.inc.php";
?>
</head>

<body >

<div id="container">
<?
 
if(!isset($content)) $content = $incpath."contents/404.php";
       include $content; 
/*
?>
<div class="spessore"></div>
<div class="" id="foocuscino" style="height:120px" ></div>

<div id="footer" style="height:60px;background-color:transparent">

  <div class="content" id="foocreditscnt">
    <div id="foocredits">

        <div id="fooinfo" class="testofoo" style="height:60px"><div style="padding:8px"><? echo Get_TXTArea('_footer',$language); ?></div></div>

    </div>
  </div>
    
</div>
*/?>
</div>
<?

include "layout_common.inc.php"; 
?>
</body>
</html>