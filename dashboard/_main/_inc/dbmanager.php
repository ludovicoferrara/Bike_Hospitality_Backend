<?
   include_once $extincpath_hdd."_class/db.class.php";

   #---------  database generale  -------------
   $mydb = new DB_MysqlType;
   include_once $_main_dir."_inc/db.inc.php";
      extract($a_dbparam[$SITE]);
      extract($svtables);
   $mydb->Set_Param($dbaddress, $dbusername, $dbpassword, $dbname, $svtables); //Imposta i parametri per la connessione al database
 	//---------------------------------------------------------------------------

	$db_session = $mydb;

	$dbDati = new DB_MysqlType;
	$dbDati->Set_Param($a_dbparam_3['dbaddress'], $a_dbparam_3['dbusername'], $a_dbparam_3['dbpassword'], $a_dbparam_3['dbname'], null);
        
        // DB Gestionale
	$mydbG = new DB_MysqlType;
	$mydbG->Set_Param($a_dbparam_2['dbaddress'], $a_dbparam_2['dbusername'], $a_dbparam_2['dbpassword'], $a_dbparam_2['dbname'], null);
        
        //DB WS Network
        $mydbNW = $mydb;


?>