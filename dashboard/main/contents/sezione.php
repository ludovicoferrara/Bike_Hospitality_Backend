<?
/*
switch($isezione){

	default: $xbordercolor0="#AC3000";	
}
*/

if($containers=="left|right"){#
?>
<div class="content">
<div id="left">
<?
$area_tpl = "left";$_cmsmode = 0;
include $extincpath_hdd."_inc/_cms.php";
?>
</div>

<div id="right">

<?
$area_tpl = "right";$_cmsmode = 0;
include $extincpath_hdd."_inc/_cms.php";
?>
</div>
</div>
<? } elseif($containers=="center" ){ ?>
<div class="content"  >
<?
	 #
	  $area_tpl = "center";$_cmsmode = 0;
	  include $extincpath_hdd."_inc/_cms.php";
	  #
	  
?>
</div>
<?
 }  elseif($containers=="xcenter"){ ?>

<?
	  
	  $area_tpl = "xcenter";$_cmsmode = 0;
	  include $extincpath_hdd."_inc/_cms.php";
?>

<?
 } 
?>