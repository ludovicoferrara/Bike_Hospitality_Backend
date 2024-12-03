<?php

if(!isset($page)) $page = "";

foreach($_REQUEST as $k => $v) 
{
    $log .= "$k = $v \n";
}

switch($_SRV){
    
case "getDataApp":
{
    $jsout = "";
    
    $aOut = [];
    
    switch($page)
    {
        case "strutture": case "tecnici":  case "enogastronomici": case "noleggi": case "partner": case "promozioni":
        {
            if(!isset($orderby)) $orderby = "ta.cognome ASC";
            $cond = "";
            if($page=="strutture") $cond = " AND (tu.categoria=11 OR tu.categoria=12 OR tu.categoria=13 OR tu.categoria=14 OR tu.categoria=15 OR tu.categoria=19)";
            elseif($page=="tecnici") $cond = " AND (tu.categoria=18)";
            elseif($page=="enogastronomici") $cond = " AND (tu.categoria=16)";
            elseif($page=="noleggi") $cond = " AND (tu.categoria=17)";
            elseif($page=="partner") $cond = " AND (tu.categoria=18 OR tu.categoria=16)";# OR tu.categoria=16
            elseif($page=="promozioni") $cond = " AND (tu.categoria=21)";
            
            if(isset($regione) && $regione !="")
            {

                    $cond .= " AND ( 0 ";
                    $sql = "SELECT * FROM province WHERE id_regione=$regione";
                    $aProv = $dbDati->DoSelect($sql);
                    foreach($aProv as $k => $rp)
                    {
                        $p = $rp['codice_provincia'];
                        $cond .= " OR ta.resi_provincia = '$p' ";

                    }
                    $cond .= " ) ";
                
            }
            if(isset($provincia) && $provincia!="")
            {
                $cond .= " AND ta.resi_provincia = '$provincia' ";
            }
                
            $sql = "SELECT tu.codice, tu.categoria, tu.id_ws, ta.* FROM $tbl_aziende as tu, $tbl_aziende_anag as ta  WHERE tu.id_anag=ta.id_anag AND  tu.tipo=$_tipoanagAff AND tu.id_circuito=$id_location  $cond ORDER BY $orderby ";#LIMIT $nn, $nxpage
            $aRs = $mydbG->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $idws = $r['id_ws'];
                $aOut[$k]['nome']      = $r['nomebreve'];
                $aOut[$k]['categoria'] = getCategoriaAnag($r['categoria'], $mydbG);
                $ida = $r['id_anag'];
                $aOut[$k]['email']      = $r['resi_email'];
                $aOut[$k]['telefono']   = $r['resi_telefono'];
                
                $localita="";
                if($r['resi_comune']!="") $localita=getComune($r['resi_comune']);
                if($r['resi_provincia']!="") $localita .= " (".getProvincia($r['resi_provincia']).")";
                $aOut[$k]['localita'] = mydecodeTxt($localita);
                
                $indirizzo="";
                if($r['resi_via']!="")    $indirizzo .= $r['resi_via']." ";
                if($r['resi_civico']!="") $indirizzo .= $r['resi_civico']." ";
                if($r['resi_cap']!="")    $indirizzo .= $r['resi_cap']." ";
                $aOut[$k]['indirizzo'] = mydecodeTxt($indirizzo);
                
                $aOut[$k]['codice_provincia'] = $r['resi_provincia'];
                $aOut[$k]['provincia'] = getProvinciaX($r['resi_provincia']);
                
                $aOut[$k]['id_regione'] = 0;
                if(isset($r['resi_provincia']) && $r['resi_provincia']!="")
                {
                $a = getRegioneFromProv($r['resi_provincia']);
                $aOut[$k]['id_regione'] = $a[0];
                }
                
                $sql = "SELECT * FROM affiliati WHERE id_anag = ".$r['id_anag'];$log .= $sql;
                $mydbNW->DoSelect($sql);
                $ra = $mydbNW->GetRow();
                
                $immagine = $http_userdata.$r['id_anag']."/".$ra['img'];
                $aOut[$k]['immagine'] = $immagine;
                if($ra['telefono']!="") $aOut[$k]['telefono'] = $ra['telefono'];
                $aOut[$k]['url'] = $ra['url'];
                $aOut[$k]['wiki'] = $ra['wiki'];
                $aOut[$k]['coords'] = $ra['coords'];
                if($ra['email']!="") $aOut[$k]['email'] = $ra['email'];
                
                if(!isset($language) || $language=="") $language = "it";
                
                $aOut[$k]['descrizione'] = "";
                $sql = "SELECT * FROM affiliati_testi WHERE id_rel='$idws' AND lang='$language'";$log .= $sql;
                $mydbNW->DoSelect($sql);
                if( ($rt = $mydbNW->GetRow()) )
                {
                $aOut[$k]['descrizione'] = $rt['testo'];
                }
                }
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "struttura":
        {
            if(!isset($id) || $id == "") $jsout = "";
            else {
            
                        
            $sql = "SELECT tu.codice, tu.categoria, ta.* FROM $tbl_aziende as tu, $tbl_aziende_anag as ta  WHERE tu.id_anag=ta.id_anag AND  tu.id_anag=$id AND tu.id_circuito=$id_location  ";
            $aRs = $mydbG->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut['id']        = $r['id_anag'];
                $aOut['nome']      = $r['nomebreve'];
                $aOut['categoria'] = getCategoriaAnag($r['categoria'], $mydbG);
                
                $localita="";
                if($r['resi_comune']!="") $localita=getComune($r['resi_comune']);
                if($r['resi_provincia']!="") $localita .= " (".getProvincia($r['resi_provincia']).")";
                $aOut['localita'] = $localita;
                
                $indirizzo="";
                if($r['resi_via']!="")    $indirizzo .= $r['resi_via']." ";
                if($r['resi_civico']!="") $indirizzo .= $r['resi_civico']." ";
                if($r['resi_cap']!="")    $indirizzo .= $r['resi_cap']." ";
                $aOut['indirizzo'] = $indirizzo;
                
                $sql = "SELECT * FROM affiliati WHERE id_anag = ".$r['id_anag'];
                $mydbNW->DoSelect($sql);
                $ra = $mydbNW->GetRow();
                
                $immagine = $http_userdata.$r['id_anag']."/".$ra['img'];
                $aOut['immagine'] = $immagine;
                $aOut['telefono'] = $ra['telefono'];
                $aOut['url'] = $ra['url'];
                $aOut['wiki'] = $ra['wiki'];
                $aOut['coords'] = $ra['coords'];
                
                if(!isset($language) || $language=="") $language = "it";
                
                $sql = "SELECT * FROM affiliati_testi WHERE id_rel='$id' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                $rt = $mydbNW->GetRow();
                
                $aOut['descrizione'] = $rt['testo'];

                }
                
                $jsout = json_encode($aOut);
            }
        
            
        } break;
        
        case "comuni":
        {
            if(!isset($orderby)) $orderby = "tc.nome_comune ASC";
            $cond = "";
            
                 if(isset($regione) && $regione !="")
                {

                        $cond .= " AND ( 0 ";
                        $sql = "SELECT * FROM province WHERE id_regione=$regione";
                        $aProv = $dbDati->DoSelect($sql);
                        foreach($aProv as $k => $rp)
                        {
                            $p = $rp['codice_provincia'];
                            $cond .= " OR ti.provincia = '$p' ";

                        }
                        $cond .= " ) ";

                }
                if(isset($provincia) && $provincia!="")
                {
                    $cond .= " AND ti.provincia = '$provincia' ";
                }
                            
            $sql = "SELECT ti.*, tc.nome_comune FROM www_bikeh.comuni as ti, generale.comuni as tc   WHERE ti.comune=tc.codice_comune AND ti.id_circuito=$id_location  $cond ORDER BY $orderby ";

            $aRs = $mydbG->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $idc = $r['id'];
                $aOut[$k]['nome']      = $r['nome_comune'];

                $localita = getProvinciaX($r['provincia']);
                $aOut[$k]['provincia'] = $localita;
                $aOut[$k]['codice_provincia'] = $r['provincia'];


                
                $immagine = $urlbase."/main/contents/media/".stripslashes($r['img']);
                $aOut[$k]['immagine'] = $immagine;
                
                $aOut[$k]['url']  = $r['web'];
                $aOut[$k]['wiki'] = $r['wiki'];
                
                if(!isset($language) || $language=="") $language = "it";
                
                $sql = "SELECT * FROM comuni_testi WHERE id_rel='$idc' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                $rt = $mydbNW->GetRow();
                
                $aOut[$k]['descrizione'] = $rt['testo'];

                }
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "itinerari": case "format":
        {
            if(!isset($orderby)) $orderby = "ti.nome ASC";
            $cond = "";
            #if($page=="itinerari") $cond = " AND info='Itinerario' ";
            #elseif($page=="format") $cond = " AND info='Format' ";
            
                        
                if(isset($regione) && $regione !="")
                {

                        $cond .= " AND ( 0 ";
                        $sql = "SELECT * FROM province WHERE id_regione=$regione";
                        $aProv = $dbDati->DoSelect($sql);
                        foreach($aProv as $k => $rp)
                        {
                            $p = $rp['codice_provincia'];
                            $cond .= " OR ti.provincia = '$p' ";

                        }
                        $cond .= " ) ";

                }
                if(isset($provincia) && $provincia!="")
                {
                    $cond .= " AND ti.provincia = '$provincia' ";
                }
                            
            $sql = "SELECT ti.* FROM itinerari as ti  WHERE ti.id_circuito=$id_location  $cond ORDER BY $orderby ";

            $aRs = $mydbNW->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $id = $r['id'];
                $aOut[$k]['nome']      = $r['nome'];
                $aOut[$k]['categoria'] = $r['info'];

                $provincia = getProvincia($r['provincia']);
                $aOut[$k]['provincia'] = $provincia;
                $aOut[$k]['codice_provincia'] = $r['provincia'];
                $aOut[$k]['nome_provincia'] = getProvinciaX($r['provincia']);
                
                $comune = getComune($r['comune']);
                $aOut[$k]['comune'] = $comune;
                
                $aOut[$k]['localita'] = $r['localita'];
                
                
                #$immagine = $urlbase."/main/contents/media/".stripslashes($r['img']);
                #$aOut[$k]['immagine'] = $immagine;
                
                $aOut[$k]['gpx']  = $r['gpx'];
                $aOut[$k]['map']  = $r['map'];
                $aOut[$k]['linkgpx']  = $r['linkgpx'];
                
                $aOut[$k]['telefono']  = $r['telefono'];
                $aOut[$k]['email']  = $r['email'];
                
                if(!isset($language) || $language=="") $language = "it";
                
                $sql = "SELECT * FROM itinerari_testi WHERE id_rel='$id' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                $rt = $mydbNW->GetRow();
                
                $aOut[$k]['descrizione'] = $rt['testo'];
                
                $aImg = [];
                
                $sql = "SELECT * FROM itinerari_immagini WHERE id_rel='$id' ";#AND lang='$language'
                $a_img = $mydbNW->DoSelect($sql);
                foreach($a_img as $ki => $ri)
                {
                    $aImg[$ki] = $ri['immagine'];
                }
                $aOut[$k]['immagini'] = $aImg;
                
                }
        
                
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "guide":
        {
            if(!isset($orderby)) $orderby = "ti.nome ASC";
            $cond = "";
            if($page=="guide") $cond = "";
            
                if(isset($regione) && $regione !="")
                {

                        $cond .= " AND ( 0 ";
                        $sql = "SELECT * FROM province WHERE id_regione=$regione";
                        $aProv = $dbDati->DoSelect($sql);
                        foreach($aProv as $k => $rp)
                        {
                            $p = $rp['codice_provincia'];
                            $cond .= " OR ti.provincia = '$p' ";

                        }
                        $cond .= " ) ";

                }
                if(isset($provincia) && $provincia!="")
                {
                    $cond .= " AND ti.provincia = '$provincia' ";
                }
                                        
            $sql = "SELECT ti.* FROM guide as ti  WHERE ti.id_circuito=$id_location  $cond ORDER BY $orderby ";

            $aRs = $mydbNW->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $id = $r['id'];
                $aOut[$k]['nome']      = $r['nome'];
                $aOut[$k]['cognome']   = $r['cognome'];

                $provincia = getProvincia($r['provincia']);
                $aOut[$k]['provincia'] = $provincia;
                $aOut[$k]['codice_provincia'] = $r['provincia'];
                
                $a = getRegioneFromProv($r['provincia']);
                $aOut[$k]['id_regione'] = $a[0];
                
                $comune = getComune($r['comune']);
                $aOut[$k]['comune'] = $comune;
                
                $aOut[$k]['localita'] = $r['localita'];
                
                
                #$immagine = $urlbase."/main/contents/media/".stripslashes($r['img']);
                $aOut[$k]['foto'] = $r['foto'];
                if(!stristr($r['foto'],"http://") && !stristr($r['foto'],"https://"))
                {
                    $aOut[$k]['foto'] = "https://www2.wifi-project.cloud/bikehospitality/userdata/guide/".$id."/".$r['foto'];
                }
                
                $aOut[$k]['lingue']  = $r['lingue'];
                $aOut[$k]['settori']  = $r['settori'];
                
                $aOut[$k]['telefono']  = $r['telefono'];
                $aOut[$k]['email']  = $r['email'];
                
                if(!isset($language) || $language=="") $language = "it";
                
                $sql = "SELECT * FROM guide_testi WHERE id_rel='$id' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                $rt = $mydbNW->GetRow();
                
                $aOut[$k]['descrizione'] = $rt['testo'];
                /*
                $aImg = [];
                
                $sql = "SELECT * FROM itinerari_immagini WHERE id_rel='$id' ";#AND lang='$language'
                $a_img = $mydbNW->DoSelect($sql);
                foreach($a_img as $ki => $ri)
                {
                    $aImg[$ki] = $ri['immagine'];
                }
                $aOut[$k]['immagini'] = $aImg;
                */
                
                }
                
                
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "regioni":
        {
            $sql = "SELECT * FROM regioni";
            $aRs = $dbDati->DoSelect($sql);
            
             if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id_regione']        = $r['id_regione'];
                $aOut[$k]['nome_regione']      = $r['nome_regione'];
                $aOut[$k]['']      = $r[''];
                }
                
            $jsout = json_encode($aOut);
            
        } break;
        
        case "province":
        {
            $cond = "1";
            if(isset($regione) && $regione != "")
            {
                $cond = " id_regione = $regione";
            }
            $sql = "SELECT * FROM province WHERE $cond";
            $aRs = $dbDati->DoSelect($sql);
            
             if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id_regione']          = $r['id_regione'];
                $aOut[$k]['nome_provincia']      = $r['nome_provincia'];
                $aOut[$k]['codice_provincia']    = $r['codice_provincia'];
                $aOut[$k]['sigla_provincia']     = $r['sigla_provincia'];
                
                }
                
            $jsout = json_encode($aOut);
            
        } break;
        
        case "stazioni":
        {
            if(!isset($orderby)) $orderby = "ti.id ASC";
            $cond = "";
                        
            if(isset($regione) && $regione !="")
            {

                    $cond .= " AND ( 0 ";
                    $sql = "SELECT * FROM province WHERE id_regione=$regione";
                    $aProv = $dbDati->DoSelect($sql);
                    foreach($aProv as $k => $rp)
                    {
                        $p = $rp['codice_provincia'];
                        $cond .= " OR ti.provincia = '$p' ";

                    }
                    $cond .= " ) ";
                
            }
            if(isset($provincia) && $provincia!="")
            {
                $cond .= " AND ti.provincia = '$provincia' ";
            }
                
            $sql = "SELECT ti.* FROM stazioni as ti  WHERE ti.id_circuito=$id_location  $cond ORDER BY $orderby ";#LIMIT $nn, $nxpage
            $aRs = $mydbNW->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $r['id'];
                                
                $localita="";
                if($r['comune']!="") $localita=getComune($r['comune']);
                if($r['provincia']!="") $localita .= " (".getProvincia($r['provincia']).")";
                $aOut[$k]['localita'] = $localita;
                
                $indirizzo="";
                if($r['indirizzo']!="")    $indirizzo .= $r['indirizzo']." ";
                #if($r['resi_civico']!="") $indirizzo .= $r['resi_civico']." ";
                #if($r['resi_cap']!="")    $indirizzo .= $r['resi_cap']." ";
                $aOut[$k]['indirizzo'] = $indirizzo;
                
                $aOut[$k]['codice_provincia'] = $r['provincia'];
                
                $a = getRegioneFromProv($r['provincia']);
                $aOut[$k]['id_regione'] = $a[0];
                
                              
                #$immagine = $http_userdata.$r['id_anag']."/".$ra['img'];
                #$aOut[$k]['immagine'] = $immagine;
                
                $aOut[$k]['latitude'] = $r['latitude'];
                $aOut[$k]['longitude'] = $r['longitude'];

                /*
                if(!isset($language) || $language=="") $language = "it";
                
                $sql = "SELECT * FROM affiliati_testi WHERE id_rel='$ida' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                $rt = $mydbNW->GetRow();
                
                $aOut[$k]['descrizione'] = $rt['testo'];
                 */
                }
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "sponsor":
        {
            if(!isset($orderby)) $orderby = "ti.id ASC";
            $cond = "";
            /*            
            if(isset($regione) && $regione !="")
            {

                    $cond .= " AND ( 0 ";
                    $sql = "SELECT * FROM province WHERE id_regione=$regione";
                    $aProv = $dbDati->DoSelect($sql);
                    foreach($aProv as $k => $rp)
                    {
                        $p = $rp['codice_provincia'];
                        $cond .= " OR ti.provincia = '$p' ";

                    }
                    $cond .= " ) ";
                
            }
            if(isset($provincia) && $provincia!="")
            {
                $cond .= " AND ti.provincia = '$provincia' ";
            }
            */ 
            $sql = "SELECT ti.* FROM sponsor as ti  WHERE ti.id_circuito=$id_location  $cond ORDER BY $orderby ";#LIMIT $nn, $nxpage
            $aRs = $mydbNW->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $r['id'];
                                
                $aOut[$k]['nome'] = $r['nome'];
                $aOut[$k]['web']  = $r['web'];
                              
                $immagine = $urlbase."main/contents/media/".$r['immagine'];
                $aOut[$k]['immagine'] = $immagine;

                /*
                if(!isset($language) || $language=="") $language = "it";
                
                $sql = "SELECT * FROM affiliati_testi WHERE id_rel='$ida' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                $rt = $mydbNW->GetRow();
                
                $aOut[$k]['descrizione'] = $rt['testo'];
                 */
                }
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "home":
        {
            $aOut['testo'] = "";
            $aOut['upd'] = "0";
            
            $jsout = json_encode($aOut);
            
            #$sql = "INSERT INTO stats (page, lang, version) VALUES ('home','$language','$appVersion')";
            #$mydbNW->ExecSql($sql);
            
        } break;
        
        case "disciplinare":
        {
            if(!isset($language) || $language=="") $language="it";
            $sql = "SELECT * FROM altro_testi WHERE id_rel = 1 AND lang='$language'";#
            $aRes = $mydbNW->DoSelect($sql);
            
            foreach($aRes as $k => $r)
            {
                $aOut[$k]['titolo'] = $r['titolo'];#mydecodeTxt($r['titolo']);
                $aOut[$k]['testo']  = nl2br($r['testo']);#mydecodeTxt($r['testo']);
            }
            
            $jsout = json_encode($aOut);
            
        } break;
        
        case "eventi":
        {
            if(!isset($orderby)) $orderby = "ti.data_rif DESC";
            $cond = "";
                        
                if(isset($regione) && $regione !="")
                {

                        $cond .= " AND ( 0 ";
                        $sql = "SELECT * FROM province WHERE id_regione=$regione";
                        $aProv = $dbDati->DoSelect($sql);
                        foreach($aProv as $k => $rp)
                        {
                            $p = $rp['codice_provincia'];
                            $cond .= " OR ti.provincia = '$p' ";

                        }
                        $cond .= " ) ";

                }
                if(isset($provincia) && $provincia!="")
                {
                    $cond .= " AND ti.provincia = '$provincia' ";
                }
                                        
            $sql = "SELECT ti.* FROM eventi as ti  WHERE ti.id_circuito=$id_location  $cond ORDER BY $orderby ";

            $aRs = $mydbNW->DoSelect($sql);
            
            if(is_array($aRs))
                foreach($aRs as $k => $r)
                {
                $aOut[$k]['id']        = $id = $r['id'];
                $aOut[$k]['nome']      = $r['nome'];
                
                $provincia = getProvincia($r['provincia']);
                $aOut[$k]['provincia'] = $provincia;
                $aOut[$k]['codice_provincia'] = $r['provincia'];
                
                $a = getRegioneFromProv($r['provincia']);
                $aOut[$k]['id_regione'] = $a[0];
                
                $aOut[$k]['localita'] = $r['localita'];
                
                
                $immagine = $urlbase."/main/contents/media/".stripslashes($r['immagine']);
                $aOut[$k]['immagine'] = $immagine;
                
                $aOut[$k]['categoria']  = $r['tipologia'];
                                
                if(!isset($language) || $language=="") $language = "it";
                
                $aOut[$k]['descrizione']= "";
                
                $sql = "SELECT * FROM eventi_testi WHERE id_rel='$id' AND lang='$language'";
                $mydbNW->DoSelect($sql);
                if( ($rt = $mydbNW->GetRow()))
                {
                $aOut[$k]['descrizione'] = $rt['testo'];
                }
                /*
                $aImg = [];
                
                $sql = "SELECT * FROM itinerari_immagini WHERE id_rel='$id' ";#AND lang='$language'
                $a_img = $mydbNW->DoSelect($sql);
                foreach($a_img as $ki => $ri)
                {
                    $aImg[$ki] = $ri['immagine'];
                }
                $aOut[$k]['immagini'] = $aImg;
                */
                
                }
                
                
                
                $jsout = json_encode($aOut);
        
            
        } break;
        
        case "promozioni___":
        {
            
           
            $jsout = json_encode($aOut);
            
        } break;
    }
    
    echo $jsout;
    
} break;

case "getStatsApp":
{
    $fstats = fopen("_log/stats.log","a");
    
    fputs($fstats,Date("Y-m-d H:i:s")."\n".$json."\n");
    
    fclose($fstats);
    
    $obj = json_decode($json);
   
    $view = $obj->view;
    $page = $view->page;
    $id   = $view->id;
    $lang = $view->lang;
    $uid  = $view->UniqueID;
    $deviceInfo = json_encode($obj->deviceInfo);
    
    $sql = "INSERT INTO stats (uid, page, idPage, lang, info, data_ins) VALUES ('$uid', '$page', '$id', '$lang', '$deviceInfo', NOW() )";
    $mydb->ExecSql($sql);
    
    $aAout = [];
    $aAout['res'] = '1';
    
    $jsout = json_encode($aAout);
    
    echo $jsout;
    
} break;

case "getStatsAppTest":
{
    $fstats = fopen("_log/statsTest.log","a");
    ob_start();
    fputs($fstats,Date("Y-m-d H:i:s")."\n".$json."\n");
    
    $obj = json_decode($json);
   
    $view = $obj->view;
    $page = $view->page;
    $id   = $view->id;
    $lang = $view->lang;
    $uid  = $view->UniqueID;
    $deviceInfo = json_encode($obj->deviceInfo);
    
    $sql = "INSERT INTO stats (uid, page, idPage, lang, info, data_ins) VALUES ('$uid', '$page', '$id', '$lang', '$deviceInfo', NOW() )";
    $mydb->ExecSql($sql);

    $out = ob_get_clean();
    fputs($fstats,":".$out."\n");
    fclose($fstats);
    $aAout = [];
    $aAout['res'] = '1';
    
    $jsout = json_encode($aAout);
    
    echo $jsout;
    
} break;


}
