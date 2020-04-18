<?php
require_once("resources/config.php");

require_once(COMPONENTS_PATH . "/header.php");
require_once(COMPONENTS_PATH . "/navbar.php");

?>

<div class="jumbotron container mt-5">
    <form action="" method="POST">
        <div class="form-group">
            <label for="inputisbn">Codice ISBN</label>
            <input name="isbn" type="text" class="form-control" id="inputisbn" aria-describedby="isbnInput">
            <small id="isbnInput" class="form-text text-muted">ISBN 10 o ISBN 13</small>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Controlla Libro</button>
    </form>
</div>

<?php

if (isset($_POST['submit'])) {


    $isbn = $_POST['isbn'];

    $jsonurl = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $isbn;
    $jsoncontent = file_get_contents($jsonurl);
    $json = json_decode($jsoncontent);


    if ($json->totalItems == 0) { ?>
        <div class="jumbotron container mt-5">
            <h3>Libro non trovato</h3>
        </div>
    <?php } else {

        // Book item main api
        $bookItem = $json->items[0];

        // Self link per piu info sul libro
        $selfLink = $bookItem->selfLink;
        $selfLinkJsonContent = file_get_contents($selfLink);
        $selfLinkJson = json_decode($selfLinkJsonContent);

        // Price
        $priceapi = "https://booksrun.com/api/price/sell/" . $isbn . "?key=fqfb16h7x2sss8k52ily";
        $priceJsonContent = file_get_contents($priceapi);
        $priceJson = json_decode($priceJsonContent);

    ?>

        <div class="jumbotron container mt-5">

            <div class="row">
                <div class="col-md-3">
                    <?php
                    if (isset($bookItem->volumeInfo->imageLinks->smallThumbnail)) {
                        $thumbnailUrl = $bookItem->volumeInfo->imageLinks->smallThumbnail; ?>
                        <img src="<?php echo $thumbnailUrl ?>" class="card-img" alt="Book Cover">
                    <?php } else { ?>
                        <img src="https://isbndb.com/modules/isbndb/img/default-book-cover.jpg" alt="Cover non disponibiler">
                    <?php } ?>
                </div>
                <div class="col-md-9">
                    <div class="card-body">

                        <h3 class="card-title"><?php echo $bookItem->volumeInfo->title; ?></h3>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#info">Informazioni</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#desc">Descrizione</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#biblio">Biblioteca</a>
                            </li>
                        </ul>

                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active show" id="info">

                                <table class="table table-hover">
                                    <tbody>

                                        <?php
                                        if (isset($bookItem->volumeInfo->authors)) {
                                            $authors = $bookItem->volumeInfo->authors; ?>
                                            <tr class="table-action">
                                                <td>Autori</td>
                                                <td>
                                                    <?php foreach ($authors as $author) {
                                                        echo $author;
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        if (isset($selfLinkJson->volumeInfo->publisher)) {
                                            $publisher = $selfLinkJson->volumeInfo->publisher; ?>
                                            <tr>
                                                <td>Casa Editrice</td>
                                                <td><?php echo $publisher ?></td>
                                            </tr>
                                        <?php }
                                        ?>

                                        <?php
                                        if (isset($bookItem->volumeInfo->publishedDate)) {
                                            $publishDate = $bookItem->volumeInfo->publishedDate; ?>
                                            <tr class="table-action">
                                                <td>Anno</td>
                                                <td>
                                                    <?php echo $publishDate; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        if (isset($bookItem->volumeInfo->industryIdentifiers)) {
                                            $identifiers = $bookItem->volumeInfo->industryIdentifiers;
                                            foreach ($identifiers as $id) { ?>

                                                <tr class="table-action">
                                                    <td><?php echo $id->type ?></td>
                                                    <td><?php echo $id->identifier ?></td>
                                                </tr>

                                        <?php }
                                        }
                                        ?>

                                        <?php
                                        if (isset($bookItem->volumeInfo->pageCount)) {
                                            $pages = $bookItem->volumeInfo->pageCount; ?>
                                            <tr>
                                                <td>Numero di pagine</td>
                                                <td><?php echo $pages ?></td>
                                            </tr>
                                        <?php }
                                        ?>

                                        <?php
                                        if (isset($bookItem->volumeInfo->language)) {
                                            $lang = $bookItem->volumeInfo->language; ?>
                                            <tr>
                                                <td>Lingua</td>
                                                <td><?php echo $lang ?></td>
                                            </tr>
                                        <?php }
                                        ?>

                                        <?php
                                        if (isset($selfLinkJson->volumeInfo->dimensions)) {
                                            $dimensions = $selfLinkJson->volumeInfo->dimensions; ?>
                                            <tr>
                                                <td>Dimensioni</td>
                                                <td><?php echo $dimensions->height ?></td>
                                            </tr>
                                        <?php }
                                        ?>

                                        <?php
                                        if ($priceJson->result->status == "success") {
                                            $prezzo = $priceJson->result->text->Average; ?>
                                            <tr>
                                                <td>Prezzo Medio</td>
                                                <td><?php echo $prezzo  ?> $</td>
                                            </tr>
                                        <?php }
                                        ?>

                                        <?php
                                        if (isset($selfLinkJson->volumeInfo->categories)) {
                                            $cats = $selfLinkJson->volumeInfo->categories; ?>
                                            <tr class="table-action">
                                                <td>Categorie</td>
                                                <td>
                                                    <?php
                                                    foreach ($cats as $cat) { ?>
                                                        <?php echo $cat . ', ' ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>

                            </div>

                            <div class="tab-pane fade" id="desc">
                                <?php
                                $desc = $selfLinkJson->volumeInfo->description;
                                if ($desc) { ?>
                                    <p><?php echo $desc; ?></p>
                                <?php }
                                ?>
                            </div>

                            <div class="tab-pane fade" id="biblio">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>Posizione</td>
                                            <td>Scaffale 1</td>
                                        </tr>
                                        <tr>
                                            <td>Data</td>
                                            <td>2013</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



        </div>

<?php
    }
}
require_once(COMPONENTS_PATH . "/footer.php");
?>