<!DOCTYPE html>
<html>

<head>
<?
include "layout_header.inc.php";
?>
</head>

<body>

<div id="cookiesbanner" style="<?=$stylecb?>">
    <img src="main/contents/immagini/closebc.png" class="fright cliccabile" onclick="hidelayer('cookiesbanner');" hspace="3" />
    <?=$_cookiesbanner?>
</div>

<div id="wrapper" style="display:flex;flex-direction: column;min-height:100%">
<div id="container" style="flex:1 0 auto">

<? /*
    <div id="supertop" class="<?=$supertopclass?>">

        <div class="content">
<? if($_menutop==1){ ?>
            <div id="menutop">
                        <? 
		     	include $incpath.'contents/menutop.php';
		     	?>
            </div>
<? } ?>
        </div>
    
    </div>

*/ ?>
    <div id="top">

	<div class="content"> 
	     <div id="logo" ><a href="<?=$urlbase?>" title="<?=$_title?>" ><? WriteMedia("logo",$language)?></a></div>
	      <?
          if(!$logged && $_menumain==1){
          ?>
                <div id="toolbar">
	  
                        <div class="fright">
		     	<? 
		     	$mode = "top";
		     	include $incpath.'contents/menu.php';
		    
		     	?>
                        </div>
                </div>
		<? } ?>     
	</div>
    </div>


<div id="contents">
<?

       if(!isset($content)) $content = $incpath."contents/404.php";
       include $content;

?>
</div><!-- qui finisce contents -->	

<div class="" id="foocuscino" ></div>

</div><!-- qui finisce container-->

<div id="footer" >

  <div class="content" id="foocreditscnt">
    <div id="foocredits">

        <div id="fooinfo" class="testofoo"><div style="padding:8px"><? echo Get_TXTArea('_footer',$language); ?></div></div>
                <? if($_menufoo==1 ){ ?>
		<div id="menu3">
		<? 
				     	include $incpath.'contents/menufooter.php';
		?>
		</div>
            <? } ?>
    </div>
  </div>
    
</div>

</div>

<?
include "layout_common.inc.php";
?>

</body>
</html>