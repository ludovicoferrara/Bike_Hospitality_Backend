<?
      $_ALL_PARAMS['urlbase']  = $urlbase;
      $_ALL_PARAMS['homepage'] = $urlbase."index.php?sz=0"; 
      $_ALL_PARAMS['_url']  = str_replace("http://","",$urlbase);#"";
      $_ALL_PARAMS['_url']  = str_replace("https://","",$_ALL_PARAMS['_url']);#"";
      $_ALL_PARAMS['_urlname']  = "";
      $_ALL_PARAMS['action']   = $urlbase."index.php";
      $_ALL_PARAMS['_emailwm']  = "info@bitwall.it";
      $_ALL_PARAMS['_urlname']  = "Wifi-project.cloud";
      
      $href0 = $urlbase."index.php?";
      
      #----------------------------
    /* MENU: */
    $_ALL_PARAMS['_ndigitsmenu']  = 2;
	$_ALL_PARAMS['_basemenu']     = 100;
	$_ALL_PARAMS['_submenu']      = 1;//0|1 esistenza submenu

	$_ALL_PARAMS['_field_username']  = "email"; 
	
	$_ALL_PARAMS['FileAjax'] = 'ajax.php';
    
      /*----------GESTIONE LINGUA-------------*/  
    $_vlanguage = Array (
    0 => "it",
    1 => "en",
    #2 => "fr",
    #3 => "es"
   
    );
    
    $_vlanguage_enabled = Array (
    0 => "1",
    1 => "0",
    2 => "0",
    3 => "0"
   
    );
    
    $_vdeslanguage = Array (
    0 => "italiano",
    1 => "inglese",
    2 => "francese",
    3 => "spagnolo"
   
    );
    $_langdefault = "it";
    $_useurlwlang = 0; #0|1 se = 1 gli url sono del tipo /lang/....
    
    $_ALL_PARAMS['_nlanguage']  = count($_vlanguage);
    
    function get_ilanguage($language){
        global $_vlanguage;
        $ilanguage = 0;
	    	foreach($_vlanguage as $k => $v){
		    	if($v==$language) $ilanguage==$k;
    	}
    	return $ilanguage;
    }
    
    /*---------------------------------------*/
    
	$_ALL_PARAMS['incpath'] =  $incpath     = "./$prefix/";
	$_ALL_PARAMS['incpathfull'] =  $incpathfull = "./$prefix/contents/";
	$_ALL_PARAMS['incpathloc']  =  $incpathloc = $baseDir."/$prefix/contents/";
	/*
	$_ALL_PARAMS['path_network_http']            = $urlbase."network/mws/";
	$_ALL_PARAMS['path_network_hdd']             = $baseDir."/network/mws/";
	$_ALL_PARAMS['path_network_rel']             = "network/mws/";
	
	#$_ALL_PARAMS['urlsite']    = $urlbase.$prefix."/contents/";
	#$basemotore  = $urlbase;
	#$basesite    = $_ALL_PARAMS['urlsite']; #_________________LASCIARE PER COMPATIBILITA'
	*/
	if(!(isset($_ALL_PARAMS['action']))) $_ALL_PARAMS['action'] = $urlbase."index.php";

	 //------------- Percorsi per recuperare le immagini ----------------------------------

	  $_ALL_PARAMS['path_icone'] 	      = "icone/";				//percorso delle icone: edita/elimina/mostra.... 
	  $_ALL_PARAMS['path_img']            = "immagini/";   		 // immagini 
	  $_ALL_PARAMS['path_catalogo']	      = $_ALL_PARAMS['path_media']    = "media/";		 // immagini relative al catalogo e cms
	  $_ALL_PARAMS['path_userdata']       = $_SERVER["DOCUMENT_ROOT"]."/bikehospitality/userdata/";            //
          $_ALL_PARAMS['http_userdata']   = $urlcrm."userdata/";            //
	  $_ALL_PARAMS['path_tmp']            = "tmp/"; 
	  $_ALL_PARAMS['path_gallery']        = "gallery/";

          $_ALL_PARAMS['_nrowsxpage']       = 50; 

          $_createhtaccess = true;
          $_id_smtppserver = 1;
	  

	 //-----------------------------------------------------------------------------------------
	 extract($_ALL_PARAMS);
	 
	 $_usecrm = 1;//vedi monterey... determina se � collegato al db/crm
         $_maintipoanag = 2;
         $_wsnetwork = true;//ex network minisiti, se true => esiste la tabella da sincronizzare
         $_tipoanagAff = 3;
         
         $_tipousersGuide = 2;
	 /*$_areariservata = 0;
	 $_areagestionale = 1;*/
	 
     $_forzamodificapassword = true;
     $_scadenzapassword = 30;//giorni
       
       $_sztosessiontimeout = "home";
       /*
       $_usetermini  = 0;
       $_regpassword = 1;
       $_useraccount = 0;//l'utente può accedere all'area riservatas
       
       
       $_urlprivacy = "";
       
       $_contattouser = true; //il contatto deve essere associato ad un utente
       $_anaguser = true; //l'azienda deve essere associata ad un utente, situazione tipica se l'utente ha dati anagrafici/di fatturazione
       //(in questo caso l'utente dovrebbe essere inserito come contatto associato all'azienda)
       $_userdatifatt = false;//solo per l'utente
	   */
#$_cntareasubmenu = "right";#serve se si abilita la generazione automatica dei sub menu
 
$_tipoareasubmenu = "smenu";

$_testodefaultsubmenu = "//@__includest:submenu@//";

$_tema = "standard";
$_logow = true;//logo nell'area riservata
$_foomini = false;//footer nell'area riservata

$_menu_def = "1";

$_def_creasubmenu = "NO";


?>