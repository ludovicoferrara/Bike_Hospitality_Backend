<!DOCTYPE html>
<html>

<head>
<?
include "layout_header.inc.php";
?>
</head>

<body >

    <div id="menuleft" class="menuleft_<?=$_tema?>">

        <? include "./main/contents/menuleft.php"; ?>
        
    </div>
     
<?

if(!isset($content)) $content = $incpath."contents/404.php";
include $content; 

?>
  <script type="text/javascript"> 
    
    function initScreen()
    {

    var elleft  = document.getElementById('menuleft');
    var elright = document.getElementById('right2');
    var body    = document.getElementsByTagName('body');
        
    //var abswidth = window.innerWidth;
    var abswidth = body[0].offsetWidth;
    var mwidth   = elleft.offsetWidth;

    elright.style.width = (abswidth - mwidth)+'px';//-20
       
    hl = elleft.offsetHeight;//
    hr = elright.offsetHeight;
        
    elright.style.minHeight = hl+"px";

    }
    
    addEvent(window, 'load', initScreen);
    addEvent(window, 'resize', initScreen);
    
    // initScreen();
 </script>	
<? 
include "layout_common.inc.php"; 
?>

</body>
</html>