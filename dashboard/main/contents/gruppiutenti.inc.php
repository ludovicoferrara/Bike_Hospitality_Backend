<?php

if($azione=="addGruppo")
{
    $newgruppo = myencodeTxt($newGroup);
    $sql = "INSERT INTO gruppi (nome, tab) VALUES ('$newgruppo','0')";
    $mydb->ExecSql($sql);
}

if($azione=="delGruppo")
{
    $sql = "DELETE FROM gruppi WHERE id_gruppo=$id";
    $mydb->ExecSql($sql);
}

$sql = "SELECT * FROM gruppi WHERE tab='0'";#
$a_ = $mydbG->DoSelect($sql);

 ?>
<div class="spessore" style="height:20px"></div>

    <form name="frmins" method="post" action="<? echo $action ?>" >
 
    <div style='text-align: left'>
            <a href="javascript:showhidelayer('cntNewGroup')"><img src="main/contents/icone/add.png" class="ico24" align="absmiddle" /> Aggiungi Gruppo</a>
    </div>
<div class="spessore" ></div>
<div id='cntNewGroup' style='text-align: left;display:none'>
    <input type="text" name='newGroup' value=""/> <img src="main/contents/icone/right-arrow-1.png" class="ico24 cliccabile rounded" align="absmiddle" onclick="addGruppo()" />
</div>

   <div class="spessore" style="height:10px"></div>
    
           
        <table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th >Gruppo</th>
                    <th >Codice</th>
                    <th >Note</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                
            
        <?
        $i=0;
        if(is_array($a_))
        foreach($a_ as $i => $r)
        {
            $nome    = mydecodeTxt($r['nome']);
            $note    = mydecodeTxt($r['descrizione']);
            
            $id = $r['id_gruppo'];
        ?>
        <tr>
            <td data-label="" style="min-height:32px">
                <div class="fleft"><?=$i+1?></div>
                <div class="tdToolbar1 fright">
                    <a href="javascript:editGruppo(<?=$id?>)" title="Modifica gruppo"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                    <a href="javascript:delGruppo(<?=$id?>)" title="Elimina gruppo"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
                </div>
            </td>
            <td data-label="Cognome"><?=$nome?></td>
            <td><?=$r['codice']?></td>
            <td><?=$note?></td>
                        
            <td class="tdToolbar" style="min-width:260px">
                <a href="javascript:editGruppo(<?=$id?>)"  title="Modifica gruppo"><img src="main/contents/icone/edit-icon.png" class="imgcliccabile ico20 fleft" /></a>
                <a href="javascript:delGruppo(<?=$id?>)" title="Elimina gruppo"><img src="main/contents/icone/cancel.png" class="imgcliccabile ico20 fright" /></a>
            </td>
        </tr>    
        <?
            
        }
        ?>
            </tbody>
        </table>
        
        <input type="hidden" name="MSID" value="<?=$MSID?>" />
        <input type="hidden" name="sz" value="<?=$sezione?>" />
        <input type="hidden" name="azione" value="" />
        <input type="hidden" name="id" value="" />
        
        <input type="hidden" name="tab" value="<?=$tab?>" />
        <input type="hidden" name="tab2" value="<?=$tab2?>" />  

    </form>
      