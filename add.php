<?php
require_once("resources/config.php");

require_once(COMPONENTS_PATH . "/header.php");
require_once(COMPONENTS_PATH . "/navbar.php");

?>

<div class="jumbotron container mt-5" id="jumboIsbn">
    <form action="" method="POST">
        <div class="form-group">
            <label for="inputisbn">Codice ISBN</label>
            <input name="isbn" type="text" class="form-control" id="inputisbn" aria-describedby="isbnInput">
            <small id="isbnInput" class="form-text text-muted">ISBN 10 o ISBN 13</small>
        </div>

        <button type="submit" name="addBook" class="btn btn-success">Aggiungi Libro</button>
    </form>
</div>

<?php

if (isset($_POST["addBook"])) {

    $isbn = $_POST['isbn'];

    require_once(COMPONENTS_PATH . "/simple_html_dom.php");

    $bookUrl = $config['url']['api'] . $isbn;

    $html = file_get_html($bookUrl) or die;
    
    if ($html) {
        // Titolo
if ($html->find('.product_heading_title', 0)) {
    $titolo = $html->find('.product_heading_title', 0)->plaintext;
} else {
    $titolo = "";
}

// Sottotitolo
if ($html->find('.scheda-subtitle', 0)) {
    $sottotitolo = $html->find('.scheda-subtitle', 0)->plaintext;
} else {
    $sottotitolo = "";
}

// Autori
if ($html->find('.product_text', 0)) {
    $autori = substr($html->find('.product_text', 0)->plaintext, 3);
} else {
    $autori = "";
}

// Descrizione
if ($html->find('.more-block', 0)) {
    $desc = substr($html->find('.more-block', 0)->plaintext, 21);
} else {
    $desc = "";
}

// Prezzo pubblico
if ($html->find('.product-public-price', 0)) {
    $prezzo = $html->find('.product-public-price', 0)->plaintext;
} else if ($html->find('.product-our-price', 0)) {
    $prezzo = $html->find('.product-our-price', 0)->plaintext;
} else {
    $prezzo = "";
}

// Copertina
if ($html->find('#photoprod', 0)) {
    $copertina = $html->find('#photoprod', 0)->src;
} else {
    $copertina = "https://i.imgur.com/WuI1P4e.png";
}

// Dettagli libri

$editore = "";
$collana = "";
$datapubb = "";
$ean = "";
$isbn = "";
$pagine = 0;
$formato = "";
$age = "";
$traduttore = "";
$cura = "";
$edizione = 0;
$illustratore = "";

$dettagli = $html->find('.dettagli-prodotto', 0)->children();

foreach ($dettagli as $item) {
    $elem = explode(': ', $item->plaintext);

    $tipo = $elem[0];
    $val = $elem[1];

    switch ($tipo) {

            // Editore
        case 'Editore':
            $editore = trim($val);
            break;

            // Collana
        case 'Collana':
            $collana = trim($val);
            break;

            // Data di Pubblicazione
        case 'Data di Pubblicazione':
            $datapubb = trim($val);
            break;

            // EAN (isbn13)
        case 'EAN':
            $ean = trim($val);
            break;

            // ISBN (isbn10)
        case 'ISBN':
            $isbn = trim($val);
            break;

            // Pagine
        case 'Pagine':
            $pagine = trim($val);
            break;

            // Formato
        case 'Formato':
            $formato = trim($val);
            break;

            // Age
        case 'Età consigliata':
            $age = trim($val);
            break;

            // Traduttore
        case 'Traduttore':
            $traduttore = trim($val);
            break;

            // A cura di
        case 'A cura di':
            $cura = trim($val);
            break;

            // Edizione
        case 'Edizione':
            $edizione = trim($val);
            break;

            // Illustratore
        case 'Illustratore':
            $illustratore = trim($val);
            break;
    }
}
} else {
    echo 'Libro non trovato. Inseriscilo manualmente';
    $titolo = "";
    $sottotitolo = "";
    $autori = "";
    $desc = "";
    $prezzo = "";
    $copertina = "";
    $editore = "";
    $collana = "";  
    $datapubb = "";
    // $ean = "";
    // $isbn = "";
    $pagine = "";
    $formato = "";
    $age = "";
    $traduttore = "";
    $cura = "";
    $edizione = "";
    $illustratore = "";

    if (strlen($postisbn) == 10) {
        $isbn = $postisbn;
    } else if (strlen($postisbn) == 13) {
        $ean = $postisbn;
    } else {
        $isbn = "";
        $ean = "";
    }
}




?>

<script>
    $('#jumboIsbn').hide();
</script>

<div class="jumbotron container mt-5">

    <form action="process.php" method="POST">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="copertina">Copertina</label>
                    <input id="coverinput" type="text" class="form-control" name="copertina" value="<?= $copertina ?>">
                </div>

                <img class="img-fluid" id="coverimage" src="<?= $copertina ?>" alt="">

                <script>
                    $('#coverinput').change(function() {
                        $('#coverimage').attr('src', $('#coverinput').val());
                    })
                </script>


            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="titolo">Titolo</label>
                    <input type="text" class="form-control" name="titolo" value="<?= $titolo ?>">
                </div>
                <div class="form-group">
                    <label for="sottotitolo">Sottotitolo</label>
                    <input type="text" class="form-control" name="sottotitolo" value="<?= $sottotitolo ?>">
                </div>
                <div class="form-group">
                    <label for="autori">Autori</label>
                    <input type="text" class="form-control" name="autori" value="<?= $autori ?>">
                </div>
                <div class="form-group">
                    <label for="prezzo">Prezzo</label>
                    <input type="text" class="form-control" name="prezzo" value="<?= $prezzo ?>">
                </div>
                <div class="form-group">
                    <label for="editore">Editore</label>
                    <input type="text" class="form-control" name="editore" value="<?= $editore ?>">
                </div>
                <div class="form-group">
                    <label for="collana">Collana</label>
                    <input type="text" class="form-control" name="collana" value="<?= $collana ?>">
                </div>
                <div class="form-group">
                    <label for="edizione">Edizione</label>
                    <input type="text" class="form-control" name="edizione" value="<?= $edizione ?>">
                </div>
                <div class="form-group">
                    <label for="cura">Curatrice</label>
                    <input type="text" class="form-control" name="cura" value="<?= $cura ?>">
                </div>
                <div class="form-group">
                    <label for="traduttore">Traduttore</label>
                    <input type="text" class="form-control" name="traduttore" value="<?= $traduttore ?>">
                </div>
                <div class="form-group">
                    <label for="illustratore">Illustratore</label>
                    <input type="text" class="form-control" name="illustratore" value="<?= $illustratore ?>">
                </div>
                <div class="form-group">
                    <label for="datapubb">Data di Pubblicazione</label>
                    <input type="text" class="form-control" name="datapubb" value="<?= $datapubb ?>">
                </div>
                <div class="form-group">
                    <label for="ean">EAN (ISBN 13)</label>
                    <input type="text" class="form-control" name="ean" value="<?= $ean ?>">
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN (ISBN 10)</label>
                    <input type="text" class="form-control" name="isbn" value="<?= $isbn ?>">
                </div>
                <div class="form-group">
                    <label for="pagine">Pagine</label>
                    <input type="text" class="form-control" name="pagine" value="<?= $pagine ?>">
                </div>
                <div class="form-group">
                    <label for="formato">Formato</label>
                    <input type="text" class="form-control" name="formato" value="<?= $formato ?>">
                </div>
                <div class="form-group">
                    <label for="desc">Descrizione</label>
                    <input type="text" class="form-control" name="desc" value="<?= $desc ?>">
                </div>

                <button type="submit" name="submitBook" class="btn btn-success">Aggiungi Libro</button>

            </div>
        </div>

    </form>

</div>

<?php
}

require_once(COMPONENTS_PATH . "/footer.php");
?>