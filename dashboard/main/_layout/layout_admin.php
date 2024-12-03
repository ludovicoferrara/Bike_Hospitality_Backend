<?
$_USR_RIGHT = $thisuser->Get_Permessi($sz);
$_title = Get_TXTArea('_title', 'it');
?><html>
<head>  
<title><? echo $_title; ?> -- RESERVED AREA --</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script language="javascript" type="text/javascript" src="<?=$extincpath_http?>contents/common.js.php?t=<?=time()?>"></script>
<script language="javascript" type="text/javascript" src="<?=$extincpath_http?>contents/commonj.js.php?t=<?=time()?>"></script>
<script language="javascript" type="text/javascript" src="<?=$extincpath_http?>contents/tt.js"></script>

<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	
<? #<link href="main/contents/style.css" rel="stylesheet" type="text/css" />
if(is_file("main/admin/admstyle.css"))
{
	?>
<link href="main/admin/admstyle.css" rel="stylesheet" type="text/css" />		
	<?
} else {
?>
<link href="<?=$extincpath_http?>admin/admstyle.css" rel="stylesheet" type="text/css" />
<? } ?>

<link rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
<script type="text/javascript">

var languageCode = 'it';

</script>
<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

</head>

<body>


<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>

<div id="adm_top"> 
	    <div id="adm_msg_top" class="admtitolo_ev" align="right"></div>
		
		<div id="adm_menu_top">
		    <div align="right" class="admtitolo" >Sei autenticato come <?echo $A_USERSDES[$thisuser->Get_level()] ?></div>
		</div>
		
		
	   <div id="adm_toolbar_in"><? 
$ssz = $isubsezione;  

include $extincpath_hdd."admin/adm_menu.php";

?></div>
	   
			
</div>

<div id="adm_container" align="center">


	
     
	
   <div id="adm_contents" align="center"> 
	
	   <? 
        if(!isset($content)) $content = $extincpath_hdd."contents/sezione.php";
        include $content; 
       ?>
     
   <div id="admcuscino" align="center"></div><!-- -->
	 
		
	<div id="xfooter" style="height:100%"><span class="admtesto_ev"><? 
/**/
if($thisuser->Get_username()=="sadmin" || $thisuser->Get_username()=="emanu_test"){
echo $content;
echo "<br>sz=$sz<br>";
echo "<br>isub=$isubsezione<br>";
echo "<br>azione=$azione";
echo "<br>prefix=$prefix";
echo "<br>$mysessionid<br>&nbsp;";
print_r($_USR_RIGHT);
}

?></span>

	</div>
 </div><!-- qui finisce contents --	
	 <!--	-->
</div>

<div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100;width:400px;height:200px">
<?
if($sz==187 || $sz==177 || $sz==904) include $extincpath_hdd."admin/uploadfile.php";
?>
</div>

<div id="main_overlay" style="display:none">
<div id="loading" style="display:none"><img src="main/contents/immagini/loading.gif" /></div>
<div id="overlay" onclick="close_()" >
</div>
<div id="cnt_overlay" style="display:none">
<p id="titleframe" class="subtitolo"></p>
<p id="closeframe"><a href="javascript:close_()" class="ev">CHIUDI</a></p>
<p style="clear:both"></p>
<iframe frameborder="0" width="1200" height="620" src="blank.html" style="background-color:white;" name="overlayframe" id="overlayframe"></iframe>

</div>
</div>

<div id="main_woverlay" style="display:none">
<div id="woverlay" onclick="wclose_()" ></div>
<div id="cnt_woverlay">
<div id="alertbox" style="display:none"></div>

<div id="cnt_woverlay_title" class="admtitolobig" ></div>
<div id="cnt_woverlay_text" class="admtitolo" ></div>
</div>
</div>

<form name="frmmenu" action="<? echo $action; ?>" method="post">
    <input type="hidden" name="id" value="<? echo $id; ?>">
    <input type="hidden" name="sezione" value="<? echo $sz; ?>">
    <input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
    <input type="hidden" name="strparam" value="">
    <input type="hidden" name="npage"     value="">
    <input type="hidden" name="toreload"     value="">
    <input type="hidden" name="tab"     value="<?=$tab?>">
    <input type="hidden" name="tab2"     value="<?=$tab2?>">
	 
		<?
        /* Trasformare in variabili di stato */
        ?>
		<input type="hidden" name="sezto" value="">
        <input type="hidden" name="azione" value="">

        <?
        /* Variabili di appoggio non critiche */
        ?> 
</form>
<form name="frmmenu2" id="frmmenu2"  action="<? echo $action; ?>" method="post" target="overlayframe">

    <input type="hidden" name="id" value="">
    <input type="hidden" name="sezione" value="<? echo $sz; ?>">
	<input type="hidden" name="MSID"  value="<? echo $mysessionid ?>">
	<input type="hidden" name="strparam" value="<? echo $strparam; ?>">
	<input type="hidden" name="tmp" value="">
	<input type="hidden" name="frame" value="1">
	<input type="hidden" name="azione" value="">
</form>

</body>
</html>