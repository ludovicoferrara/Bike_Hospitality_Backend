<!--#inc.regioni-->
<?php
$_postfix = "Regioni";

var_dump($urlbase);

// Fetch regions with pagination
$sql = "SELECT id_regione, nome_regione, abilitata FROM regioni ORDER BY id_regione" ;
$rows = $dbDati->DoSelect($sql);

// Salva le modifiche al campo "abilitata" tramite POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_regione'])) {
    $id_regione = intval($_POST['id_regione']); // Sanitizza il valore

    // Inverti il valore del campo "abilitata"
    $sql = "UPDATE regioni SET abilitata = NOT abilitata WHERE id_regione = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $id_regione);
    $stmt->execute();

    if ($stmt->error) {
        error_log("Errore SQL: " . $stmt->error); // Logga eventuali errori
    }

    echo json_encode(['success' => true]); // Risposta JSON
    exit;
}

?>
<script>
async function toggleAbilitata(id_regione, checkbox) {
            try {
                const response = await fetch("", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({
                        id_regione: id_regione,
                    }),
                });

                const result = await response.json();
                if (!result.success) {
                    alert("Errore durante l'aggiornamento.");
                    checkbox.checked = !checkbox.checked; // Ripristina lo stato della checkbox in caso di errore
                }
            } catch (error) {
                console.error("Errore durante la richiesta:", error);
                alert("Errore durante l'aggiornamento.");
                checkbox.checked = !checkbox.checked; // Ripristina lo stato della checkbox in caso di errore
            }
        }

function setTab(t)
{
    document.frmins.tab.value = t;
    document.frmins.sezione.value='cms,0';
    document.frmins.submit();
}

function editItm(id){
	
    document.frmmenu.sezione.value='cms,2';
    document.frmmenu.id.value=id;
    document.frmmenu.submit();
}

function back(){
	
	document.frmmenu.sezione.value='cms,0';
        document.frmmenu.id.value=0;
	document.frmmenu.submit();
}

function refresh()
{
    waitpage();
    document.frmins.submit();
}
function esporta()
{
    document.frmins.esporta.checked=true;
    refresh();
}

function setOrd(strord){
    
        var ord = '<?=$ord?>';
        
        if(strord=='nome')
        {
            if(ord=='0') ord = 1;
            else ord = '0';
        }
        if(strord=='data_ins')
        {
            if(ord=='2') ord = 3;
            else ord = '2';
        }
        
    
	waitpage();
    	document.frmins.ord.value=ord;
    	document.frmins.submit();
    }
</script>
<div class="box_cnt">

<form method="post" name="frmins">
<input type="hidden" name="session_token" value="<?= session_id() ?>">
<table class="tablegrid3 tableresp" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Regione</th>
                    <th>Nome Regione</th>
                    <th>Abilitata</th>
                </tr>
            </thead>
            
            <tbody>
            <?php if (!empty($rows)) : ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_regione']) ?></td>
                    <td><?= htmlspecialchars($row['nome_regione']) ?></td>
                    <td>
                        <input type="checkbox" 
                               onchange="toggleAbilitata(<?= htmlspecialchars($row['id_regione']) ?>, this)"
                               <?= $row['abilitata'] ? 'checked' : '' ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3">No regions found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
        </table>
</form>
