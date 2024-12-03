<?
$_supervisione = false;//>> Togliere: usata solo in account.php

$_idutente = 0;
$err = 0;
$_logout = 0;//se 1 significa che la sessione è scaduta e viene fatto il logout automatico

my_session_destroy();//cancella le variabili di sessione temporanee, NON quelle legate alla sessione di login

if(isset($level)) $_level = $level;
else $_level = 0;

if($logged==1){
	
     $a_data_user = $thisuser->Get_user_data();
     $_nomeutente = $a_data_user['nome'];
     $_cognomeutente = $a_data_user['cognome'];
     $_idutente   = $a_data_user['id_utenti'];
     $_tipoutente = $a_data_user['tipo'];
     $_emailutente = $a_data_user['email'];

}

    if ($logged == 1 && $level >= $ADMINLEVEL) {
        
        if(!isset($id)) $id = "";
    }


if(is_file("init.custom.php")) include "init.custom.php";
?>
