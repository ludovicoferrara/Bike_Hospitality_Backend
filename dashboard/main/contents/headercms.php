<?
if(count($__a_locations)==1)
{
    $idLocationSelected =  $id_location = $__a_locations[0]['id'];
} else {

?>
<script>

function setLocation(idLocation)
{
	addparam('idLocationSelected', idLocation, 'params');
	waitpage();
	document.frmmenu.submit();
}

function selectLocations()
{
	showlayer('sceltalocations');
	el=document.getElementById('sceltalocations');
	el.style.height='66px';
}

function opencloseC(div, maxh){
		
		el = document.getElementById(div);
		
		var h = el.offsetHeight;
		
		
		if(h==0) {
			el.style.maxHeight = maxh+'px';
			//el.style.Height = maxh+'px';
			el.style.border='solid 2px silver';
		}
		else {
			el.style.maxHeight = "0px";
			el.style.border='none';
	             }
		
	}
function openC(div, maxh){
		
		el = document.getElementById(div);
		
			el.style.maxHeight = maxh+'px';
			//el.style.Height = maxh+'px';
			el.style.border='solid 2px silver';
	}
function closeC(div){
		
		el = document.getElementById(div);
		
			el.style.maxHeight = "0px";
			el.style.border='none';
	             
	}
        
var searchlock=0;
        
function searchLoc(str)
{
    
    if(str.length >= 3)
    {
        for(i=0;i<a_locations.length;i++) a_locations[i]=null;
        searchlock=1;
        ajaxSrv('HS.searchLocations', 'searchstring='+str+'&cond=id_profilo!:1 AND id_profilo!:5&order=codice', 'searchLocDone(res)', ''); 
    }
    
}
function searchLocDone(res)
{
        
    if(res!='')
    {
    
    var a1 = res.split('|');
    
    for(i1=0;i1<a1.length;i1++)
    {
        a2 = a1[i1].split(';');
        
        a_locations[i1] = new Array();
        a_locations[i1]['id'] = a2[0];
        a_locations[i1]['codice'] = a2[1];
        a_locations[i1]['denominazione'] = a2[2];
    }
    writeLocations(0);
    }
    
    
    searchlock=0;
}
</script>

<?
$id_location=0;
parse_str($fparams, $a);extract($a);

if(!isset($idLocationSelected) || $idLocationSelected=="") {
    $idLocationSelected = my_statevar_read("idLocationSelected","sid");
}
if(is_numeric($idLocationSelected) && $idLocationSelected>0)  $id_location = $idLocationSelected;


    if($_level<$GESTLEVEL){

        $sql = "SELECT id_esportato FROM t_utenti WHERE idutente= $_idutente";
        $mydb->DoSelect($sql);
        $ru = $mydb->GetRow();
        $id_location = $ru['id_esportato'];
        $styleboxlocations ="display:none;height:0px";

    }  else {

	///$id_location = 0;
	$a_locations=$__a_locations;//vedi config.php >> gestire da db
	$styleboxlocations ="";
    }

$location = "";
$aLocationsNames=array();
$i=0;
foreach($a_locations as $i => $r){
    $aLocationsNames[$r['id']] = $r['denominazione'];
}
		    
if($id_location>0) {
    $location = $aLocationsNames[$id_location];
    my_statevar_create("idLocationSelected",$id_location);
}
		
if($_level>=$GESTLEVEL)
	{
			
	?>
	<script >
		var a_locations = new Array();
		
		<? 
		$i=0;

                 foreach($a_locations as $i => $r)
		    {
		    	
		    	$idl=$r['id'];
		    	?>
		    	a_locations[<?=$i?>] = new Array();
		    	a_locations[<?=$i?>]['id'] = '<?=$r['id']?>';
		    	a_locations[<?=$i?>]['codice'] = '<?=$r['codice']?>';
		    	a_locations[<?=$i?>]['denominazione'] = '<?=addslashes($r['denominazione'])?>';
		    	
		    	<?
		    	
		    	$i++;
		    }
		?>
		
		var offset = 0;
		
		function writeLocations(n=0)
		{
			var out = '<div align="center" style="width:100%" ><img src="main/contents/immagini/up.png" class="cliccabile" onclick="writeLocations(-5)" style="width:48px;margin:6px;"  /></div>\n';
			
			out += '<ul class="selectmenu">\n';
			var count=0;
			var j=0;
                        if(isNaN(n)) n=0;
			
			offset = offset + n;
			
			for(i=0;i<24;i++)
			{
				j = i+offset;
				if(j<a_locations.length && a_locations[j]!=null)
				{
                                    out += '<a href="javascript:setLocation('+a_locations[j]['id'] +')" class="nodec">\n';
		    	            out += '<li>'+a_locations[j]['codice']+' '+a_locations[j]['denominazione']+'</li></a>\n';
				}
			}
			
			out += '</ul>\n';
			out += '<div align="center" style="width:100%" ><img src="main/contents/immagini/down.png" class="cliccabile" onclick="writeLocations(5)" style="width:48px;margin:6px;"  /></div>\n';
			
			setTextinDiv('elencoLocations',out);
		}
		
		addEvent(window, 'load', writeLocations);
		 
	</script>
        <? } ?>
        <div id="dashboardtop" >
        
	<div class="titolo_evi fleft" style="padding-top:10px;margin-left:10px;"><?=$location?></div>
        
    
<? # onclick="closeC('elencoLocations')"
if($_level>=$GESTLEVEL)
{ 	 ?>
        <div class="fright" style="padding-top:0px;margin-right:40px;" >
	<div class="button5 cliccabile" id="btnsearchlocations" onclick="opencloseC('elencoLocations',1024)" style="">
            <input type="text" id="searchLocation" value="" placeholder="SCEGLI IL SITO WEB" class="invisibile" style="text-align:center;margin-top:4px;" onchange="searchLoc(this.value)" />
	</div>
	<div id="test"></div>
	<div id="elencoLocations" class="accordion elencotopdown" style="background:white;width:330px">

	</div>
	</div>

        </div>
	<input  type="hidden" name="idLocationSelected" value="<?=$id_location?>" />
<? } ?>

<? } ?>