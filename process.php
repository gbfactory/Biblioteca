<?php

    require_once("resources/config.php");

    require_once(COMPONENTS_PATH . "/header.php");
    require_once(COMPONENTS_PATH . "/navbar.php");

    $conn = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['dbname']);

    // Check connection
    if($conn === false){
        die("Errore di connessione: " . $mysqli->connect_error);
    }

    $titolo = addslashes($_POST['titolo']);
    $sottotitolo = addslashes($_POST['sottotitolo']);
    $autori = addslashes($_POST['autori']);
    $descrizione = addslashes($_POST['desc']);
    $prezzo = addslashes($_POST['prezzo']);
    $copertina = addslashes($_POST['copertina']);
    $editore = addslashes($_POST['editore']);
    $collana = addslashes($_POST['collana']);
    $datapubb = addslashes($_POST['datapubb']);
    $ean = addslashes($_POST['ean']);
    $isbn = addslashes($_POST['isbn']);
    $pagine = addslashes($_POST['pagine']);
    $formato = addslashes($_POST['formato']);
    $traduttore = addslashes($_POST['traduttore']);
    $cura = addslashes($_POST['cura']);
    $edizione = addslashes($_POST['edizione']);
    $illustratore = addslashes($_POST['illustratore']);

    $sql = "INSERT INTO newbooks (titolo, sottotitolo, autori, descrizione, prezzo, copertina, editore, collana, datapubb, ean, isbn, pagine, formato, traduttore, cura, edizione, illustratore)
            VALUES ('$titolo', '$sottotitolo', '$autori', '$descrizione', '$prezzo', '$copertina', '$editore', '$collana', '$datapubb', '$ean', '$isbn', '$pagine', '$formato', '$traduttore', '$cura', '$edizione', '$illustratore')";

    if ($conn->query($sql) === true) { ?>

    <div class="jumbotron container mt-5">
        <h4>Libro aggiunto con successo!</h4>
        <h6>Riepilogo</h6>
<?php

    echo $titolo . '<br>';
    echo $sottotitolo . '<br>';
    echo $autori . '<br>';
    echo $descrizione . '<br>';
    echo $prezzo . '<br>';
    echo $copertina . '<br>';
    echo $editore . '<br>';
    echo $collana . '<br>';
    echo $datapubb . '<br>';
    echo $ean . '<br>';
    echo $isbn . '<br>';
    echo $pagine . '<br>';
    echo $formato . '<br>';
    echo $traduttore . '<br>';
    echo $cura . '<br>';
    echo $edizione . '<br>';
    echo $illustratore . '<br>';

?>

        <button class="btn btn-success"><a href="newadd.php">Aggiungi Libro</a></button>
    </div>

    <?php } else { ?>
    
    <div class="jumbotron container mt-5">
        <h4>Errore</h4>
        <p><b>SQL</b> <?= $sql ?></p>
        <p><b>ERR</b> <?= $conn->error ?></p>
        
        <button class="btn btn-success"><a href="newadd.php">Aggiungi Libro</a></button>
    </div>

    <?php }
                    
    $conn->close();

?>