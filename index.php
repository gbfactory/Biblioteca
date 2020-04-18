<?php    
    require_once("resources/config.php");

    require_once(COMPONENTS_PATH . "/header.php");
    require_once(COMPONENTS_PATH . "/navbar.php");
?>

<div class="jumbotron container mt-5 mb-5">
    <h3>Benvenuto nella Biblioteca</h3>
    <p class="lead">Cosa vuoi fare?</p>
    <hr>
    <a class="btn btn-success" href="add.php" role="button">Aggiungi Libro</a>
    <a class="btn btn-warning" href="search.php" role="button">Catalogo Libri</a>
    <a class="btn btn-info" href="check.php" role="button">Controlla Libro</a>
</div>

<div class="jumbotron container">

    <div class="card mb-3 bg-secondary mb-3">
        <div class="row no-gutters">
            <div class="col-md-2">
                <img src="https://images.isbndb.com/covers/40/03/9780062074003.jpg" class="card-img" alt="Libro">
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <a href="book.php?isbn=12343"><h5 class="card-title">Titolo del libro</h5></a>
                    <p class="card-text">
                        Autore: Nome Cognome <br>
                        ISBN: 12343523 <br>
                        Casa Editrice: Ciao come stia <br>
                        Data: 1392
                    </p>
                </div>
            </div>
        </div>
    </div>
            
</div>

<?php
    require_once(COMPONENTS_PATH . "/footer.php");
?>
