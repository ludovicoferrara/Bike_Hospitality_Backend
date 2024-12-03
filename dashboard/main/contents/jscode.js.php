//<script>
<?
/*
//Inizializzo l'oggetto da Spostare
      var oggettoMoving = null;
      
      var dragged = '';
 
      //Le due variabili che archiviano la posizione cursore mouse
      mouse_x = 0;
      mouse_y = 0;
 
      //Le due variabili che archiviano la posizione dell'elemento
      ele_x = 0;
      ele_y = 0;
      

     //Collega le due funzioni muovi e ferma
      function inizializzaMov(){
      	
       document.onmousemove = muovi;
       document.onmouseup = ferma;
      
      }
 
      //Distrugge l'oggetto quando siamo fermi
      function ferma(){
      	
      	var fullid;
      	var elX;
      	var elY;
      	
      	
      	if(oggettoMoving) {
      		fullid = oggettoMoving.id;
      		elX = oggettoMoving.offsetLeft;
      		elY = oggettoMoving.offsetTop;
      		
      	}
      	
        oggettoMoving = null;
        
        //if(dragged=='cnt_woverlay') showlayer('cnt_woverlay_text');
        

      }
 
      //Funzione principale, che � responsabile dello spostamento dell'elemento
      function muovi(e){
        mouse_x = document.all ? window.event.clientX : e.pageX;
        mouse_y = document.all ? window.event.clientY : e.pageY;
        var dx = mouse_x-ele_x;
        
        if(oggettoMoving != null)
        { 
          oggettoMoving.style.left = (mouse_x - ele_x) + "px";
          oggettoMoving.style.top = (mouse_y - ele_y) + "px";
        }
      }
 
      //Viene richiamata quando comincio a spostare l'oggetto
      function muoviOggetto(ele){
 
      		dragged = ele;
                
	        //memorizzo i valori dell'elemento che deve essere spostato
	        oggettoMoving = document.getElementById(ele);
	        ele_x = mouse_x - oggettoMoving.offsetLeft;
	        ele_y = mouse_y - oggettoMoving.offsetTop;
      	
 
      }
      
*/      
?>
    //////////////////////////////////////////////////////

var fieldComuni;

var valueComuni;


function loadComuni(item1, _field){
	
    fieldComuni = _field;
    valueComuni = '';
	http1.onreadystatechange = getComuni;
	http1.open('GET','<?=$urlbase?>funzioniaj.php?azione=cm&pv='+item1, true);
	http1.onreadystatechange = getComuni;//lasciare per compatibilit� con ie
	http1.send(null);
	
}

function getComuni(){

   // var field = 'usr_';
    field = fieldComuni;
    
    var newOption;
	var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;
	var City = document.getElementById(field + 'comune');

	while (City.options.length) {
		City.remove(0);
	}

	el = document.getElementById(field + 'provincia');
	id = el.value;


	if(id == ''){
		document.getElementById(fieldComuni+'comune').disabled = true;
		newOption = document.createElement("option");
		newOption.value = '';
		newOption.text = 'Seleziona una Provincia';
		City.add(newOption, where);
	} else {
		if(http1.readyState == 4){
			if (http1.status == 200) {
				var response = http1.responseText;
				if(response == ''){
					document.getElementById(field+'comune').disabled = true;
					newOption = document.createElement("option");
					newOption.value = '';
					newOption.text = 'Nessuna voce';
					City.add(newOption, where);
				}else{
                                    
					var coppia = response.split(',');
					var max = coppia.length;
					var val='';
					newOption = document.createElement("option");
					newOption.value = '';
					newOption.text = 'Seleziona un Comune';
					City.add(newOption, where);
					for(var x=0;x<max;x++){
						val = coppia[x].split('-');
						newOption = document.createElement("option");
						newOption.value = val[0];
						newOption.text = val[1];

						City.add(newOption, where);
					}
					document.getElementById(field+'comune').disabled = false;
					//if(flag){
					//	flag=false;
						//SettaComune('nas');
					//}
					document.getElementById(field+'comune').focus();
					
					if(valueComuni!='') document.getElementById(field+'comune').value = valueComuni;
				}
			}
		}
	}
	City=null;
	newOption=null;
}
//</script>