<?
if($level>=$ADMINLEVEL){
	#***********************************************************************#
	$a_lnkmenu = array(
0 => 'Gestione Contenuti',
1 => 'Gallery',
2 => 'Banner',
3 => 'Commenti',
4 => 'News',
5 => 'Eventi',
6 => 'Codici',
9 => 'Operatori',
8 => 'Il tuo account',
7 => 'Utenti registrati',
10 => 'CMS',
11 => 'LOGOUT'

);

$a_sezmenu = array(
0 => '20',
1 => '185',
2 => '190',
3 => '230',
4 => '110,0',
5 => '110,1',
6 => '310,0',
9 => '160,1',
8 => '130',
7 => '160,2',
10 => '100',
11 => 'j'

);
$a_enmenu = array(
0 => '1',
1 => '1',
2 => '0',
3 => '0',
4 => '0',
5 => '1',
6 => '0',
7 => '0',
8 => '1',
9 => '1',
10 => '1',
11 => '1'
);
//--------------------
$a_jsmenu = array(
0 => 'admlogout()',
);

	
if(!in_array("V",$thisuser->Get_Permessi('160,1'))) $a_enmenu[9]=0; #operatori
if(!in_array("V",$thisuser->Get_Permessi('10')))    $a_enmenu[0]=0; #CMS Utente
if(!in_array("V",$thisuser->Get_Permessi('100')))   $a_enmenu[10]=0; #CMS


if($username=="swadmin"){
	
	$a_enmenu[0]=1;
	$a_enmenu[10]=0;
	$a_enmenu[9]=0;
	$a_enmenu[11]=0;
	$a_enmenu[8]=0;
	
}
#if($level>$ADMINLEVEL) $a_enmenu[3]=1;
} 
//------------------------------------------------------------------------------------------------
#} 


//--------------------
$nlink = count($a_lnkmenu);

$lnkclass = "lnkadmin";
?>