<?
$_title0 = Get_TXTArea('_title', $language);
$_description0 = Get_TXTArea('_description', $language);
$_keywords0 = Get_TXTArea('_keywords', $language);
$_keyphrase = Get_TXTArea('_keyphrase', $language);
$_author = Get_TXTArea('_author', $language);
$_footer = Get_TXTArea('_footer', $language);

if(!isset($_tema)) $_tema   = "standard";
if(!isset($_gui))  $_gui = "standard";

$_szp=$sz;

$sql = "SELECT level, id_parent FROM $tbl_sezioni WHERE sz = $sz";
$mydb->DoSelect($sql);
if (!$r = $mydb->GetRow()) {
    $_levelsez = 0;
} else {
    $_levelsez = $r['level'];

    if ($_levelsez > 0) {
        $sql = "SELECT sz  FROM $tbl_sezioni WHERE id_sezione=" . $r['id_parent'];
        $mydb->DoSelect($sql);
        $rtmp = $mydb->GetRow();
        $_szp = $rtmp['sz'];
    }
}
$_bootstrap = false;

$id_sezione_ = $id_sezione;
if(isset($id_subsezione) && $id_subsezione!="") $id_sezione_ = $id_subsezione;

$sql = "SELECT containers, params FROM $tbl_sezioni WHERE id_sezione = $id_sezione_";
$mydb->DoSelect($sql);
if(!$r=$mydb->GetRow()) {
    $containers = "";
} else {
    $containers = $r['containers'];
    if(strstr($r['params'],"|bootstrap|")) $_bootstrap = true;
}

$sql = "SELECT tb1.id_area, tb1.nome FROM $tbl_aree AS tb1, $tbl_sez_aree AS tb2 WHERE tb1.id_area=tb2.id_area AND tb2.id_sezione = $id_sezione AND tb1.extra = 'metatag'";
$a_meta_aree = $mydb->DoSelect($sql);

$i = 0;
if(is_array($a_meta_aree)){
foreach ($a_meta_aree as $i => $r) {

    if (substr($r['nome'], 0, 6) == "_title") {

        $_titlews = Get_TXTArea($r['nome'], $language);
    }
    if (substr($r['nome'], 0, 12) == "_description"){
        $_description = Get_TXTArea($r['nome'], $language);
    }
    if (substr($r['nome'], 0, 9) == "_keywords"){
        $_keywords = Get_TXTArea($r['nome'], $language);
    }
}
}
if (empty($_titlews))
    $_titlews = $_title0;
if (empty($_description))
    $_description = $_description0;
if (empty($_keywords))
    $_keywords = $_keywords0;

#if (isset($xtitlepage) && $xtitlepage != "")
#   $_titlews = $lang['_PREFIX_TITLE'] . " " . $xtitlepage;

$_title = "";

if ($logged == '1')
    $supertopclass = "supertoplogged";
else
    $supertopclass = "supertopnologged";

include "./main/contents/menu0.php";


$stylecb = "display:none";
if ($logged != '1') {

    $_cookiesbanner = Get_TXTArea('_cookiesbanner', $language);

    if ($request_uri == "" || $request_uri == "/" || $request_uri == "\\")
        $stylecb = "";
    else
        $stylecb = "display:none";

    if (($sz > 0 && $sz != 100) || $logged == 1)
        $stylecb = "display:none";
}
?>
<title><? echo $_titlews; ?></title>

<base href="<?= $urlbase ?>" target="_self"  />

<meta name="description" content="<? echo $_description ?>" />
<meta name="keywords" content="<? echo $_keywords ?>" />
<meta http-equiv="content-language" content="it">

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Favicons -- >
<link rel="shortcut icon" href="images/favicon.ico"-->

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta charset="utf-8">

<script type="text/javascript" src="<?= $extincpath_http ?>contents/common.js.php?t=<?=$_t?>"   charset="utf-8"></script>
<script type="text/javascript" src="<?= $extincpath_http ?>contents/commonj.js.php?t=<?=$_t?>"  charset="utf-8"></script>

<script type="text/javascript" src="<?= $extincpath_http ?>contents/jquery-3.2.1.min.js"  charset="utf-8"></script>
<script type="text/javascript" src="<?= $extincpath_http ?>contents/jquery-ui.js"  charset="utf-8"></script>
<link rel="stylesheet" href="<?= $extincpath_http ?>contents/jquery-ui.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed|Lato" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">

<script type="text/javascript" src="index.php?_F2I=jscode&language=<?= $language ?>&MSID=<?= $MSID ?>&_szalias=<?= $_szalias ?>&frame=<?= $frame ?>&t=<?=$_t?>"></script>

<? if($_bootstrap){ ?>
<style type="text/css" >@import "<?=$extincpath_http?>bs431/css/bootstrap.min.css";</style>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/-->
<script src="<?=$extincpath_http?>bs431/js/bootstrap.min.js" ></script>

<style type="text/css" >@import "<?=$extincpath_http?>bs/css/bootstrap-datepicker3.css";</style>
<script src="<?=$extincpath_http?>bs/js/bootstrap-datepicker.js" ></script>
<? } ?>

<style type="text/css" >@import "<?= $extincpath_http ?>/_gui/lt.<?= $_tema ?>.css?t=<?=$_t?>";</style>
<style type="text/css" >@import "<?= $extincpath_http ?>/_gui/th.<?= $_gui ?>.css?t=<?=$_t?>";</style>
<style type="text/css" >@import "<?= $urlbase ?>main/contents/style.css?t=<?=$_t?>";</style>

<?
if($logged)
{
    if(is_file("main/contents/stylecustomAdm.css") && $_level > $GESTLEVEL)
    {
        ?>
<style type="text/css" >@import "<?= $urlbase ?>main/contents/stylecustomAdm.css?t=<?=$_t?>";</style>
<?
    }
}
?>
