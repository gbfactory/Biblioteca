<?php

require_once("resources/config.php");

require_once(COMPONENTS_PATH . "/header.php");
require_once(COMPONENTS_PATH . "/navbar.php");

    $conn = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['dbname']);

    // Check connection
    if($conn === false){
        die("Errore di connessione: " . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM newbooks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        ?>
        <div class="container">

            <div class="card mt-5">
                <div class="card-body">
                    Libri presenti: <?= $result->num_rows ?>
                </div>
            </div>

            <div class="jumbotron mt-5">
        <?php while($row = $result->fetch_assoc()) { ?>

            <div class="card sm-3 bg-secondary sm-3">
                <div class="row no-gutters">
                    <div class="col-">
                        <img src="<?= $row["copertina"] ?>" class="card-img" alt="Libro" style="max-height: 190px; width: auto;">
                    </div>
                    <div class="col-">
                        <div class="card-body">
                            <a href="book.php?isbn=<?= $row["ean"] ?>"><h5 class="card-title"><?= $row["titolo"]; ?> <?= $row["sottotitolo"]; ?> </h5></a>
                            <p class="card-text">
                                <?php if($row["formato"]) { echo '(' . $row["formato"] . ') <br>';} ?>
                                di <?= $row["autori"] ?> <br>
                                <?= $row["editore"] ?> <?= $row["collana"] ?> - <?= $row["datapubb"] ?> <br>
                                ISBN: <?= $row["ean"] ?> <br>
                                Prezzo: <?= $row["prezzo"] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
        echo('</div></div>');

    } else {
        echo "0 risultati";
    }
    $conn->close();

    

?>