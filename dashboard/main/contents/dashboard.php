<?php



$sql1 = "SELECT * FROM t_utenti WHERE id_utenti = $_idutente";
$mydb->DoSelect($sql1);
$ru = $mydb->GetRow();

$nominativo = mydecodeTxt($ru['nome'])." ".mydecodeTxt($ru['cognome']);

$oggi = Date("Y-m-d");

if($login=='1')
{

$dt1access = "n.d.";
$sql2 = "SELECT * FROM t_accessi WHERE id_utente=$_idutente AND data_login < '$oggi' ORDER BY id DESC lIMIT 0,1";
$mydb->DoSelect($sql2);
if(($ra = $mydb->GetRow())){
    $dt1access = Date_fromdbX($ra['data_login']);
}

}

$msg = "";

?>
<div class="box_in">
    <div class="box_cnt boxaccount rounded">
    
    <div class="titolo">Benvenuto <?=$nominativo?>!</div>
    
    <div class="cuscino"></div>
    
    <?
    if($login=='1')
   {
        ?>
    
    <div class="testo">Il tuo ultimo accesso risale al giorno <?=$dt1access?></div>
    
    <div class="cuscino"></div>
        
    <div class="testo_evi"><?=$msg?></div>   
    
    <div class="cuscino"></div>

<? 
}
?>    
    </div>  
</div>